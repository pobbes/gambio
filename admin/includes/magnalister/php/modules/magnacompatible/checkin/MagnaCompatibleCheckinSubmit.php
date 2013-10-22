<?php
/**
 * 888888ba                 dP  .88888.                    dP                
 * 88    `8b                88 d8'   `88                   88                
 * 88aaaa8P' .d8888b. .d888b88 88        .d8888b. .d8888b. 88  .dP  .d8888b. 
 * 88   `8b. 88ooood8 88'  `88 88   YP88 88ooood8 88'  `"" 88888"   88'  `88 
 * 88     88 88.  ... 88.  .88 Y8.   .88 88.  ... 88.  ... 88  `8b. 88.  .88 
 * dP     dP `88888P' `88888P8  `88888'  `88888P' `88888P' dP   `YP `88888P' 
 *
 *                          m a g n a l i s t e r
 *                                      boost your Online-Shop
 *
 * -----------------------------------------------------------------------------
 * $Id: MeinpaketCheckinSubmit.php 1260 2011-09-26 10:08:02Z derpapst $
 *
 * (c) 2011 RedGecko GmbH -- http://www.redgecko.de
 *     Released under the GNU General Public License v2 or later
 * -----------------------------------------------------------------------------
 */

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');
require_once(DIR_MAGNALISTER_INCLUDES.'lib/classes/CheckinSubmit.php');

class MagnaCompatibleCheckinSubmit extends CheckinSubmit {
	const GENERICRESOURCE = 'magnacompatible';

	private $specificResource = '';

	private $checkinDetails = array();
	private $checkinSettings = array();
	
	protected $quantitySub = false;
	protected $quantityLumb = false;

	public function __construct($settings = array()) {
		global $_MagnaSession;
		
		$this->specificResource = $settings['marketplace'];
		
		/* Setzen der Currency nicht noetig, da Preisberechnungen bereits in 
		   der SummaryView Klasse gemacht wurden.
		 */
		$settings = array_merge(array(
			'language' => getDBConfigValue($settings['marketplace'].'.lang', $_MagnaSession['mpID']),
			'itemsPerBatch' => 50
		), $settings);

		parent::__construct($settings);
		$this->checkinSettings = array (
			'Categories' => array (
				'Marketplace' => 'no', //[no | optional | required]
				'Shop' => 'no',
			),
			'Variations' => 'no' //[no | yes]
		);
		$c = $this->loadMPConfig();
		$this->checkinSettings = array_merge_recursive_simple($this->checkinSettings, $c);
		//echo print_m($this->checkinSettings);
		//echo print_m($this->settings, 'settings');

		$stockSetting = getDBConfigValue($this->marketplace.'.quantity.type', $this->mpID);
		if ($stockSetting == 'stocksub') {
			 $this->quantitySub = -getDBConfigValue(
				$this->marketplace.'.quantity.value',
				$this->mpID,
				0
			);
			$this->quantityLumb = false;
		} else if ($stockSetting == 'lump') {
			$this->quantitySub = false;
			$this->quantityLumb = getDBConfigValue(
				$this->marketplace.'.quantity.value',
				$this->mpID,
				0
			);
		}

	}

	private function loadMPConfig() {
		$resource = 'config';
		do {
			if (is_string($this->specificResource) && !empty($this->specificResource)) {
				$lpath = DIR_MAGNALISTER_MODULES.$this->specificResource.'/'.$resource.'.php';
				//echo $lpath.'<br>';
				if (file_exists($lpath)) {
					break;
				}
			}
			$lpath = DIR_MAGNALISTER_MODULES.self::GENERICRESOURCE.'/'.$resource.'.php';
			//echo $lpath.'<br>';
			if (file_exists($lpath)) {
				break;
			} else {
				$lpath = false;
			}
		} while(false);
		
		if ($lpath == false) {
			return array();
		}
		require($lpath);
		
		if (isset($mpconfig['checkin'])) {
			return $mpconfig['checkin'];
		}
		return array();
	}

	private function processShopCategoryLevel($cID, $descCol, $langID) {
		$trim = " \n\r\0\x0B\xa0\xc2"; # last 2 ones are utf8 &nbsp;
		$category = MagnaDB::gi()->fetchRow('
			SELECT cd.categories_name AS `name`, cd.'.$descCol.' AS `desc`, c.parent_id AS `parent`
			  FROM '.TABLE_CATEGORIES.' c, '.TABLE_CATEGORIES_DESCRIPTION.' cd 
			 WHERE c.categories_id = \''.$cID.'\' 
			       AND c.categories_id = cd.categories_id 
			       AND cd.language_id = \''.$langID.'\'
		');
		$c = array (
			'ID' => $cID,
			'Name' => trim(html_entity_decode(strip_tags($category['name']), ENT_QUOTES, 'UTF-8'), $trim),
			'Description' => trim(html_entity_decode(strip_tags($category['desc']), ENT_QUOTES, 'UTF-8'), $trim),
			'ParentID' => $category['parent'],
		);
		if ($c['ParentID'] == '0') {
			unset($c['ParentID']);
		}
		if ($c['Description'] == '') {
			$c['Description'] = $c['Name'];
		}
		return $c;
	}

	protected function generateShopCategoryPath($id, $from = 'category', $langID, $categoriesArray = array(), $index = 0, $callCount = 0) {
		$descCol = '';
		if (MagnaDB::gi()->columnExistsInTable('categories_description', TABLE_CATEGORIES_DESCRIPTION)) {
			$descCol = 'categories_description';
		} else {
			$descCol = 'categories_name';
		}
		if ($from == 'product') {
			$categoriesQuery = MagnaDB::gi()->query('
				SELECT categories_id AS code
				  FROM '.TABLE_PRODUCTS_TO_CATEGORIES.'
				 WHERE products_id = \''.$id.'\'
			');
			while ($categories = MagnaDB::gi()->fetchNext($categoriesQuery)) {
				if ($categories['code'] != '0') {
					$categoriesArray[$index][] = $category = $this->processShopCategoryLevel($categories['code'], $descCol, $langID);
					if (isset($category['ParentID'])) {
						$categoriesArray = $this->generateShopCategoryPath($category['ParentID'], 'category', $langID, $categoriesArray, $index);
					}
				}
				++$index;
			}
		} else if ($from == 'category') {
			$categoriesArray[$index][] = $category = $this->processShopCategoryLevel($id, $descCol, $langID);
			if (isset($category['ParentID'])) {
				$categoriesArray = $this->generateShopCategoryPath($category['ParentID'], 'category', $langID, $categoriesArray, $index);
			}
			if ($callCount == 0) {
				$categoriesArray[$index] = array_reverse($categoriesArray[$index]);
			}
		}
		return $categoriesArray;
	}
	
	public function makeSelectionFromErrorLog() {}
	
	protected function generateRequestHeader() {
		return array(
			'ACTION' => 'AddItems',
			'MODE' => $this->submitSession['mode']
		);
	}
	
	protected function markAsFailed($sku) {
		MagnaDB::gi()->insert(
			TABLE_MAGNA_COMPAT_ERRORLOG,
			array (
				'mpID' => $this->mpID,
				'batchid' => '-',
				'errormessage' => ML_GENERIC_ERROR_UNABLE_TO_LOAD_PREPARE_DATA,
				'dateadded' => gmdate('Y-m-d H:i:s'),
				'additionaldata' => serialize(array(
					'SKU' => $sku
				))
			)
		);
		$this->badItems[] = $pID;
		unset($this->selection[$pID]);
	}
	
	protected function prepareOwnShopCategories($pID, $product, &$data) {
		$cPath = $this->generateShopCategoryPath($pID, 'product', $this->settings['language']);
		if (!empty($cPath)) {
			$cPath = array_shift($cPath);
			$data['submit']['ShopCategory'] = $cPath[0]['ID'];
			$data['submit']['ShopCategoryStructure'] = $cPath;
		}
	}
	
	protected function getCategoryMatching($pID, $product, &$data) {
		$catMatching = MagnaDB::gi()->fetchRow('
			SELECT mp_category_id, store_category_id 
			  FROM `'.TABLE_MAGNA_COMPAT_CATEGORYMATCHING.'`
			 WHERE '.((getDBConfigValue('general.keytype', '0') == 'artNr')
			            ? 'products_model=\''.$product['products_model'].'\''
			            : 'products_id=\''.$pID.'\''
			        ).' AND
			       mpID=\''.$this->mpID.'\'
			 LIMIT 1
		');
		
		if ($this->checkinSettings['Categories']['Marketplace'] != 'no') {
			if ($catMatching !== false) {
				$data['submit']['MarketplaceCategory'] = $catMatching['mp_category_id'];
			} else if ($this->checkinSettings['Categories']['Marketplace'] == 'required') {
				$this->markAsFailed(magnaPID2SKU($pID));
				return false;
			}
		}
		
		if ($this->checkinSettings['Categories']['Shop'] != 'no') {
			if (getDBConfigValue(array($this->marketplace.'.catmatch.ownshopcats', 'val'), $this->mpID, false)) {
				$this->prepareOwnShopCategories($pID, $product, $data);
			} else if (is_array($catMatching) && !empty($catMatching['store_category_id'])) {
				$data['submit']['ShopCategory'] = $catMatching['store_category_id'];
			}
			if (($this->checkinSettings['Categories']['Shop'] == 'required') && !isset($data['submit']['ShopCategory'])) {
				$this->markAsFailed(magnaPID2SKU($pID));
				return false;
			}
		}
		return true;
	}
	
	protected function calcVariationPrice($price, $offset, $tax) {
		if ($offset == 0) {
			return $price;
		}

		$this->simpleprice->setPrice($price);

		$offset = $offset + $offset / 100 * $tax;
		if ($offset > 0) {
			$this->simpleprice->addLump($offset);
		} else {
			$this->simpleprice->subLump($offset * -1);
		}
		/*
		if (getDBConfigValue($this->marketplace.'.price.addkind', $this->mpID) == 'percent') {
			$this->simpleprice->addTax((float)getDBConfigValue(
				$this->marketplace.'.price.factor', $this->mpID
			));
		} else if (getDBConfigValue($this->marketplace.'.price.addkind', $this->mpID) == 'addition') {
			$this->simpleprice->addLump((float)getDBConfigValue(
				$this->marketplace.'.price.factor', $this->mpID
			));
		}
		*/
		return $this->simpleprice->roundPrice()->makeSignalPrice(
					getDBConfigValue($this->marketplace.'.price.signal', $this->mpID, '')
		    	)->getPrice();	
	}

	protected function getVariations($pID, $product, &$data) {
		if ($this->checkinSettings['Variations'] != 'yes') {
			return true;
		}
		require_once(DIR_MAGNALISTER_INCLUDES.'lib/classes/VariationsCalculator.php');
		$skutype = (getDBConfigValue('general.keytype', '0') == 'artNr') ? 'model' : 'id';
		$vc = new VariationsCalculator(array(
			'skubasetype' => $skutype,
			'skuvartype'  => $skutype,
		));
		$d = $vc->getVariationsByPIDFromDB($pID, true);
		if (empty($d)) {
			return true;
		}
		arrayEntitiesToUTF8($d);

		$variations = array();
		foreach ($d as $v) {
			$vi = array (
				'SKU' => $v['variation_products_model'],
				'Price' => $this->calcVariationPrice($data['price'], $v['variation_price'], $data['submit']['ItemTax']),
				'Currency' => $this->settings['currency'],
				'ItemTax' => $data['submit']['ItemTax'],
				'Quantity' => ($this->quantityLumb === false)
					? max(0, $v['variation_quantity'] - (int)$this->quantitySub)
					: $this->quantityLumb,
				'EAN' => $v['variation_ean'],
				'Variation' => $v['variation_attributes_text'],
			);
			if (!empty($v['variation_unit_of_measure']) && !empty($v['variation_volume'])
				&& (!isset($product['products_vpe_status']) || ($product['products_vpe_status'] == '1'))
			) {
				$vi['VPE'] = array (
					'Unit' => $v['variation_unit_of_measure'],
					'Value' => $v['variation_volume'],
				);
			}
			$variations[] = $vi;
		}
		$data['submit']['Variations'] = $variations;
		return true;
	}

	protected function getItemTax($pID, $product, &$data) {
		return $this->simpleprice->getTaxByClassID($product['products_tax_class_id']);
	}

	protected function appendAdditionalData($pID, $product, &$data) {
		if ($data['quantity'] < 0) {
			$data['quantity'] = 0;
		}

		$data['submit']['SKU'] = magnaPID2SKU($pID);
		$data['submit']['ItemTitle'] = $product['products_name'];
		$data['submit']['Price'] = $data['price'];
		$data['submit']['Currency'] = $this->settings['currency'];
		$data['submit']['Quantity'] = $data['quantity'];

		if (defined('MAGNA_FIELD_PRODUCTS_EAN')
			&& !empty($product[MAGNA_FIELD_PRODUCTS_EAN])
			&& getDBConfigValue(array($this->marketplace.'.checkin.ean', 'submit'), $this->mpID, true)
		) {
			$data['submit']['EAN'] = $product[MAGNA_FIELD_PRODUCTS_EAN];
		}
		$data['submit']['Description'] = $product['products_description'];

		$manufacturerName = '';
		if ($product['manufacturers_id'] > 0) {
			$manufacturerName = (string)MagnaDB::gi()->fetchOne(
				'SELECT manufacturers_name FROM '.TABLE_MANUFACTURERS.' WHERE manufacturers_id=\''.$product['manufacturers_id'].'\''
			);
		}
		if (empty($manufacturerName)) {
			$manufacturerName = getDBConfigValue(
				$this->marketplace.'.checkin.manufacturerfallback',
				$this->mpID,
				''
			);
		}
		if (!empty($manufacturerName)) {
			$data['submit']['Manufacturer'] = $manufacturerName;
		}
		$mfrmd = getDBConfigValue($this->marketplace.'.checkin.manufacturerpartnumber.table', $this->mpID, false);
		if (is_array($mfrmd) && !empty($mfrmd['column']) && !empty($mfrmd['table'])) {
			$pIDAlias = getDBConfigValue($this->marketplace.'.checkin.manufacturerpartnumber.alias', $this->mpID);
			if (empty($pIDAlias)) {
				$pIDAlias = 'products_id';
			}
			$data['submit']['ManufacturerPartNumber'] = MagnaDB::gi()->fetchOne('
				SELECT `'.$mfrmd['column'].'` 
				  FROM `'.$mfrmd['table'].'` 
				 WHERE `'.$pIDAlias.'`=\''.MagnaDB::gi()->escape($pID).'\'
				 LIMIT 1
			');
		}
		$data['submit']['ItemTax'] = $this->getItemTax($pID, $product, $data);

		$data['submit']['ShippingTime'] = getDBConfigValue($this->marketplace.'.checkin.leadtimetoship', $this->mpID, 3);

		$imagePath = getDBConfigValue($this->marketplace.'.imagepath', $this->mpID, SHOP_URL_POPUP_IMAGES);
		$images = array();
		if (!empty($product['products_allimages'])) {
			foreach($product['products_allimages'] as $img) {
				$images[] = $imagePath.$img;
			}
		}
		$data['submit']['Images'] = $images;
		if (!empty($product['products_vpe_name']) && !empty($product['products_vpe_value'])
			&& (!isset($product['products_vpe_status']) || ($product['products_vpe_status'] == '1'))
		) {
			$data['submit']['VPE'] = array (
				'Unit' => $product['products_vpe_name'],
				'Value' => $product['products_vpe_value'],
			);
		}
		if (!empty($product['products_weight'])) {
			$data['submit']['Weight'] = array (
				'Unit' => 'kg',
				'Value' => $product['products_weight'],
			);
		}
		
		if (!$this->getCategoryMatching($pID, $product, $data)) {
			return;
		}
		
		if (!$this->getVariations($pID, $product, $data)) {
			return;
		}
	}

	protected function processSubmitResult($result) {
		if (array_key_exists('ERRORS', $result)
			&& is_array($result['ERRORS'])
			&& !empty($result['ERRORS'])
		) {
			foreach ($result['ERRORS'] as $err) {
				$ad = array ();
				if (isset($err['DETAILS']['SKU'])) {
					$ad['SKU'] = $err['DETAILS']['SKU'];
				}
				$err = array (
					'mpID' => $this->mpID,
					'errormessage' => $err['ERRORMESSAGE'],
					'dateadded' => gmdate('Y-m-d H:i:s'),
					'additionaldata' => serialize($ad),
				);
				MagnaDB::gi()->insert(TABLE_MAGNA_COMPAT_ERRORLOG, $err);
			}
		}
		call_user_func(ucfirst($this->marketplace).'Helper::processCheckinErrors', $result, $this->mpID);
	}

	protected function filterSelection() {
		/* false is good! It indicates nothing bad happend. */
		return false;
	}

	protected function preSubmit(&$request) {
		MagnaConnector::gi()->setTimeOutInSeconds(600);
	}

	protected function postSubmit() {
		MagnaConnector::gi()->resetTimeOut();
	}

	protected function generateRedirectURL($state) {
		return toURL(array(
			'mp' => $this->realUrl['mp'],
			'mode'   => ($state == 'fail') ? 'errorlog' : 'inventory'
		), true);
	}
}