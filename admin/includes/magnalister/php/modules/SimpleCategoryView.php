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
 * $Id: SimpleCategoryView.php 445 2010-10-12 16:24:28Z derpapst $
 *
 * (c) 2010 RedGecko GmbH -- http://www.redgecko.de
 *     Released under the GNU General Public License v2 or later
 * -----------------------------------------------------------------------------
 */

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');
require_once (DIR_MAGNALISTER_INCLUDES.'lib/classes/SimplePrice.php');

define('ML_HIDE_STATUS_FALSE', false);

class SimpleCategoryView {
	private $cPath = 0;
	private $search = '';
	private $productsQuery = '';

	protected $sorting = false;
	protected $allowedProductIDs = array();

	protected $list = array('categories' => array(), 'products' => array());
	protected $settings;
	protected $_magnasession;
	protected $url = array();

	protected $action = array();

	protected $selection;
	protected $selection2;
	
	protected $ajaxReply = array();

	protected $simplePrice = null;

	/* caches */
	private $__cat2prodCache = array();
	private $__categoryCache = array();

	/**
	 * @param $cPath	Selected Category. 0 == top category
	 * @param $sorting	How should the list be sorted? false == default sorting
	 * @param $search   Searchstring for Product
	 * @param $allowedProductIDs	Limit Products to a list of specified IDs, if empty show all Products
	 */
	public function __construct($cPath = 0, $settings = array(), $sorting = false, $search = '', $allowedProductIDs = array()) {
		global $_MagnaSession, $_url;
		$this->_magnasession = &$_MagnaSession;

		$this->settings = array_merge(array(
			'showCheckboxes'  => true,
			'selectionName'   => 'general',
			'selectionValues' => array(),
		), $settings);

		initArrayIfNecessary($_MagnaSession, $_MagnaSession['currentPlatform'].'|selection|'.$this->settings['selectionName']);
		$this->selection = &$_MagnaSession[$_MagnaSession['currentPlatform']]['selection'][$this->settings['selectionName']];

		initArrayIfNecessary($_MagnaSession, $_MagnaSession['currentPlatform'].'|selection|'.$this->settings['selectionName'].'2');
		$this->selection2 = &$_MagnaSession[$_MagnaSession['currentPlatform']]['selection'][$this->settings['selectionName'].'2'];
		initArrayIfNecessary($this->selection2, 'c');
		initArrayIfNecessary($this->selection2, 'p');

		if (empty($allowedProductIDs)) {
			$this->allowedProductIDs = $this->getFilteredProductsByCategory($cPath);
		} else {
			$this->allowedProductIDs = $allowedProductIDs;
		}
		
		//echo print_m($this->allowedProductIDs);
		if (isset($_GET['kind']) && ($_GET['kind'] == 'ajax')) {
			if (preg_match('/^(.*)\[(.*)\]$/', $_POST['action'], $match)) {
				$_POST[$match[1]][$match[2]] = 0;
			} else if (($_POST['action'] == 'addall') || ($_POST['action'] == 'removeall')) {
				$_POST[$_POST['action']]['0'] = 0;
			}
			$_timer = microtime(true);
		}
		
		$this->selectionController2();
/*
		if (array_key_exists('pAdd', $_POST)) {
			$pID = array_keys($_POST['pAdd']);
			$this->selection[(string)$pID[0]] = $this->settings['selectionValues'];
			$this->ajaxReply = array (
				'type' => 'p',
				'checked' => true,
				'newname' => 'pRemove['.$pID[0].']'
			);
		}
		if (array_key_exists('pRemove', $_POST)) {
			$pID = array_keys($_POST['pRemove']);
			unset($this->selection[$pID[0]]);
			$this->ajaxReply = array (
				'type' => 'p',
				'checked' => false,
				'newname' => 'pAdd['.$pID[0].']'
			);
		}
		if (array_key_exists('cAdd', $_POST)) {
			$cID = array_keys($_POST['cAdd']);
			if ($cID[0] == '0') {
				foreach ($this->allowedProductIDs as $p) {
					if (!array_key_exists($p, $this->selection)) {
						$this->selection[(string)$p] = $this->settings['selectionValues'];
					}
				}
				$this->ajaxReply = array (
					'type' => 'a',
					'checked' => true,
					'newname' => 'cRemove[0]'
				);
			} else {
				$productsToAdd = $this->getFilteredProductsByCategory($cID[0]);
				foreach ($productsToAdd as $p) {
					if (!array_key_exists($p, $this->selection)) {
						$this->selection[(string)$p] = $this->settings['selectionValues'];
					}
				}
				$this->ajaxReply = array (
					'type' => 'c',
					'checked' => true,
					'newname' => 'cRemove['.$cID[0].']'
				);
			}
		}
		if (array_key_exists('cRemove', $_POST) || array_key_exists('removeall', $_POST)) {
			$cID = array_keys($_POST['cRemove']);
			if ($cID[0] == '0') {
				$this->selection = array();
				$this->ajaxReply = array (
					'type' => 'a',
					'checked' => false,
					'newname' => 'cAdd[0]'
				);

			} else {
				$productsToRemove = $this->getFilteredProductsByCategory($cID[0]);
				foreach ($productsToRemove as $p) {
					if (array_key_exists($p, $this->selection)) {
						unset($this->selection[(string)$p]);
					}
				}
				$this->ajaxReply = array (
					'type' => 'c',
					'checked' => false,
					'newname' => 'cAdd['.$cID[0].']'
				);
			}
		}

		if (!empty($this->ajaxReply)) {
			$this->ajaxReply['timer'] = microtime2human(microtime(true) -  $_timer);
		}
//*/
		if (!isset($_GET['kind']) || ($_GET['kind'] != 'ajax')) {
			if ($cPath == NULL) $cPath = '0';
			$this->cPath = $cPath;
			$this->sorting = $sorting;
			$this->search = $search;
			$this->simplePrice = new SimplePrice();
			$this->simplePrice->setCurrency(DEFAULT_CURRENCY);
			if (($this->search == '') && isset($_POST['tfSearch']) && !empty($_POST['tfSearch'])) {
				$this->search = $_POST['tfSearch'];
			}
			$this->url = $_url;
	
			if (empty($this->url['cPath'])) {
				unset($this->url['cPath']);
			}
		}
	}

	public function getCategoryCache() {
		if (empty($this->__categoryCacheTD)) {
			$where = ((SHOPSYSTEM != 'oscommerce') && ML_HIDE_STATUS_FALSE) ? 'WHERE categories_status<>0' : '';
			$catQuery = MagnaDB::gi()->query('
			    SELECT categories_id, parent_id 
			      FROM '.TABLE_CATEGORIES.' 
			     '.$where.'
			');
			$this->__categoryCacheTD = array();
			while ($tmp = MagnaDB::gi()->fetchNext($catQuery)) {
				$this->__categoryCacheTD[(int)$tmp['parent_id']][] = (int)$tmp['categories_id'];
				$this->__categoryCacheBU[(int)$tmp['categories_id']][] = (int)$tmp['parent_id'];
			}
			unset($catQuery);
			unset($tmp);
		}
	}

	public function getAllSubCategoriesOfCategory($cID = 0) {
		$this->getCategoryCache();

		$subCategories = isset($this->__categoryCacheTD[$cID]) ? $this->__categoryCacheTD[$cID] : array();
	
		if (!empty($subCategories)) {
			foreach ($subCategories as $c) {
				$this->mergeArrays($subCategories, $this->getAllSubCategoriesOfCategory($c));
			}
		}
	
		return $subCategories;
	}

	protected function setupCat2ProdCacheQuery($ex = array()) {
		$this->cat2ProdCacheQuery = '
		    SELECT p2c.products_id, p2c.categories_id 
		      FROM '.TABLE_PRODUCTS_TO_CATEGORIES.' p2c,
		           '.TABLE_PRODUCTS.' p';
		$where = '
		     WHERE p2c.products_id=p.products_id';
		
		if (!empty($ex)) {
			foreach ($ex as $item) {
				$this->cat2ProdCacheQuery .= (empty($item['table'])) ? '' : ',
		           '.$item['table'];
				$where .= (empty($item['where'])) ? '' : ' AND
		           '.$item['where'];
			}
		}
		$where .= (ML_HIDE_STATUS_FALSE) ? ' AND p.products_status<>0' : '';
		$this->cat2ProdCacheQuery .= $where;
		//echo print_m($this->cat2ProdCacheQuery);
		//die();
	}

	public function getCat2ProdCache() {
		if (empty($this->__cat2prodCache)) {
			if (empty($this->cat2ProdCacheQuery)) $this->setupCat2ProdCacheQuery();
			$prod2catQuery = MagnaDB::gi()->query($this->cat2ProdCacheQuery);
			$this->__cat2prodCache = array();
			while ($tmp = MagnaDB::gi()->fetchNext($prod2catQuery)) {
				if ($tmp['products_id'] == '0') continue;
				$this->__cat2prodCache[(int)$tmp['categories_id']][] = (int)$tmp['products_id'];
			}
			unset($prod2catQuery);
			unset($tmp);
		}
	}

	public function getProductIDsByCategoryID($cID) {
		$this->getCat2ProdCache();

		$subCategories = array($cID);
		$this->mergeArrays($subCategories, $this->getAllSubCategoriesOfCategory($cID));
			
		$productIDs = array();
		if (!empty($subCategories)) {
			foreach ($subCategories as $cC) {
				$copyArray = isset($this->__cat2prodCache[$cC]) ? $this->__cat2prodCache[$cC] : array();
				$this->mergeArrays(
					$productIDs,
					$copyArray
				);
			}
		}
		return array_unique($productIDs);
	}

	private function mergeArrays(&$sourceArray, &$copyArray){
		//merge copy array into source array
		$i = 0;
		while (isset($copyArray[$i])){
			$sourceArray[] = $copyArray[$i];
			unset($copyArray[$i]);
			++$i;
		}
	}

	private function getCategoryPath($cID, &$cPath = array()) {
		$meh = MagnaDB::gi()->fetchOne(
			'SELECT parent_id FROM '.TABLE_CATEGORIES.' WHERE categories_id=\''.$cID.'\''
		);
		$cPath[] = (int)$meh;
		if ($meh != '0') {
			$this->getCategoryPath($meh, $cPath);
		}
		return $cPath;
	}

	private function selectionController2() {
		if (array_key_exists('pAdd', $_POST)) {
			$pID = array_keys($_POST['pAdd']);
			$pID = (int)$pID[0];

		}
		if (array_key_exists('pRemove', $_POST)) {
			$pID = array_keys($_POST['pRemove']);
			$pID = (int)$pID[0];
			
		}
		if (array_key_exists('cAdd', $_POST)) {
			$cID = array_keys($_POST['cAdd']);
			$cID = (int)$cID[0];
			
			
			$this->selection2['c'][$cID] = 'c';
			$cPath = $this->getCategoryPath($cID);
			if (!empty($cPath)) {
				foreach ($cPath as $tCID) {
					if (array_key_exists($tCID, $this->selection2['c'])) {
						/* correct update! */
						$this->selection2['c'][$tCID] = 's';
					} else {
						$this->selection2['c'][$tCID] = 's';
					}
				}
			}

			echo print_m($cPath);
		}
		if (array_key_exists('cRemove', $_POST)) {
			$cID = array_keys($_POST['cRemove']);
			$cID = (int)$cID[0];

		}
	}

	protected function getFilteredProductsByCategory($cID) {
		return $this->getAllProductIDsByCategoryID($cID);
	}
	
	protected function getSorting() {
		if (!$this->sorting) {
			$this->sorting = 'name';
		}
	    switch ($this->sorting) {
	        case 'price'        :
	            $sort['cat']  = 'TRIM(cd.categories_name) ASC';
	            $sort['prod'] = 'p.products_price ASC';
	            break;
	        case 'price-desc'   :
	            $sort['cat']  = 'TRIM(cd.categories_name) ASC';
	            $sort['prod'] = 'p.products_price DESC';
	            break;
	        case 'name-desc'    :
	            $sort['cat']  = 'TRIM(cd.categories_name) DESC';
	            $sort['prod'] = 'TRIM(pd.products_name) DESC';
	            break;
	        case 'name'         :
	        default             :
	            $sort['cat']  = 'TRIM(cd.categories_name) ASC';
	            $sort['prod'] = 'TRIM(pd.products_name) ASC';
	            break;
	    }
		return $sort;
	}
	
	private function getAllParentCategories(&$categories) {
		$categories = array_flip($categories);
		
		$__categoryCache = array();
		$catQuery = MagnaDB::gi()->query('SELECT categories_id, parent_id FROM '.TABLE_CATEGORIES);
		while ($tmp = MagnaDB::gi()->fetchNext($catQuery)) {
			$__categoryCache[(int)$tmp['categories_id']][] = (int)$tmp['parent_id'];
		}
		unset($catQuery);
		unset($tmp);
	
		foreach ($categories as $cID => $null) {
			$categories[(int)$cID] = 0;
			$copyArray = isset($__categoryCache[(int)$cID]) ? $__categoryCache[(int)$cID] : array();
			if (!empty($copyArray)) {
				foreach($copyArray as $addCID) {
					$categories[$addCID] = 0;
				}
			}
		}
		unset($__categoryCache);
		return array_keys($categories);
	}
	
	private function retriveList() {
		$sort = $this->getSorting();

		// echo print_m($this->allowedProductIDs);
		if (!empty($this->allowedProductIDs)) {
			$allowedCategories = MagnaDB::gi()->fetchArray(
				'SELECT DISTINCT p2c.categories_id FROM '.TABLE_PRODUCTS_TO_CATEGORIES.' p2c '.
				'WHERE p2c.products_id IN ('.implode(', ', $this->allowedProductIDs).')',
				true
			);
			/* Get all involved parent categories */
			if (!empty($allowedCategories)) {
				$allowedCategories = $this->getAllParentCategories($allowedCategories);
			}
			// echo print_m($allowedCategories, '$allowedCategories');
			
			$allowedCategoriesWhere = 'c.categories_id IN ('.implode(', ', $allowedCategories).') AND ';
		} else {
			$allowedCategoriesWhere = '(0 = 1) AND '; // false... obviously
		}

		$queryStr = '  SELECT c.categories_id, cd.categories_name, c.categories_image, c.categories_status, c.parent_id
		      	         FROM '.TABLE_CATEGORIES.' c, '.TABLE_CATEGORIES_DESCRIPTION.' cd 
		      	        WHERE c.categories_id = cd.categories_id AND 
		      	              cd.language_id = \''.(int)$_SESSION['languages_id'].'\' AND 
		      	              '.(((SHOPSYSTEM != 'oscommerce') && ML_HIDE_STATUS_FALSE) ? 'categories_status<>0 AND' : '').'
		      	              '.$allowedCategoriesWhere;

		if ($this->search != '') {
		    $queryStr .= "cd.categories_name like '%" . $this->search . "%' ";
	    } else {
	    	$queryStr .= "c.parent_id = '" . $this->cPath . "' ";
	    }

	    $queryStr .= "ORDER BY " . $sort['cat'];

		$categories = MagnaDB::gi()->fetchArray($queryStr);
		$this->list['categories'] = array();

		if (!empty($categories)) {
			foreach ($categories as $category) {
				$category['allproductsids'] = $this->getFilteredProductsByCategory($category['categories_id']);
				$this->list['categories'][$category['categories_id']] = $category;
			}
		}
		unset($categories);

		if ($this->productsQuery == '') {
			$this->setupProductsQuery();
		}

		$products = MagnaDB::gi()->fetchArray($this->productsQuery);
		$this->list['products'] = array();
		if (!empty($products)) {
			foreach ($products as $product) {
				$this->list['products'][$product['products_id']] = $product;
			}
		}
		unset($products);

		//echo print_m($this->allowedProductIDs);
	}

	protected function setupProductsQuery($fields = '', $from = '', $where = '') {
		$sort = $this->getSorting();
		
		if (!empty($this->allowedProductIDs)) {
			$whereProducs = 'p.products_id IN ('.implode(', ', $this->allowedProductIDs).')';
		} else {
			$whereProducs = '(0 = 1)'; // false again... ZOMG
		}

		$this->productsQuery = '
			SELECT p.products_tax_class_id, p.products_id, pd.products_name,
			       p.products_quantity, p.products_image, p.products_price, 
			       p2c.categories_id'.(($fields != '') ? (', '.$fields) : '').'
			  FROM '.TABLE_PRODUCTS.' p, '.TABLE_PRODUCTS_DESCRIPTION.' pd, '.TABLE_PRODUCTS_TO_CATEGORIES.' p2c 
			       '.(($from != '') ? (', '.$from) : '').'
			 WHERE p.products_id = pd.products_id AND pd.language_id = \''.(int)$_SESSION['languages_id'].'\' AND
			       p.products_id = p2c.products_id AND
			       '.((ML_HIDE_STATUS_FALSE) ? 'p.products_status<>0 AND' : '').'
			       '.$whereProducs.' '.(($where != '') ? ('AND '.$where) : '').' ';
		
		if ($this->search != '') {
		    $this->productsQuery .= 'AND (pd.products_name like \'%'.$this->search.'%\' OR p.products_model = \''.$this->search.'\') 
		    	GROUP BY p.products_id ';
		    $this->productsQuery = str_replace('SELECT', 'SELECT DISTINCT', $this->productsQuery);
		    
		} else {
			$this->productsQuery .= 'AND p2c.categories_id = \''.$this->cPath.'\' ';
		}
		$this->productsQuery .= 'ORDER BY '.$sort['prod'];
		//echo print_m($this->productsQuery);
	}

	private function buildCPath($newCID) {
		global $cPath_array; /* xt:commerce */
		if ($this->cPath != 0) {
			return implode('_', array_merge($cPath_array, array($newCID)));
		}
		return $newCID;
	}

	private function categorySelector($cID, $top = false) {
		if (array_key_exists($cID, $this->selection2['c'])) {
			if ($this->selection2['c'][$cID] == 's') {
				$state = 'semichecked';
				$add = true;
			} else if ($this->selection2['c'][$cID] == 'c') {
				$state = 'checked';
				$add = false;
			}
		}
		
		if (!isset($state)) {
			$state = 'unchecked';
			$add = true;
		}
		if ($top) {
			$label = '<label for="selectAll">'.ML_LABEL_CHOICE.'</label>';
			$id = 'id="selectAll" ';
		} else {
			$label = $id = '';
		}
		return '<input '.$id.'type="submit" '.
		               'class="checkbox '.$state.'" value="" '.
		               'name="c'.($add ? 'Add' : 'Remove').'['.$cID.']" '.
		               'title="'.($add ? ML_LABEL_SELECT_ALL_PRODUCTS_OF_CATEGORY : ML_LABEL_DESELECT_ALL_PRODUCTS_OF_CATEGORY).'" />'.$label;
	}

	private function productSelector($pID) {
		if (array_key_exists($pID, $this->selection)) {
			return '<input type="submit" class="checkbox checked" value="" name="pRemove['.$pID.']" title="'.ML_LABEL_DESELECT_PRODUCT.'"/>';
		}
		return '<input type="submit" class="checkbox unchecked" value="" name="pAdd['.$pID.']" title="'.ML_LABEL_SELECT_PRODUCT.'"/>';
	}

	protected function sortByType($type) {
		return '
			<span class="nowrap">
				<a href="'.toURL($this->url, array('sorting' => $type.'')).'" title="'.ML_LABEL_SORT_ASCENDING.'" class="sorting">
					<img alt="'.ML_LABEL_SORT_ASCENDING.'" src="'.DIR_MAGNALISTER_IMAGES.'sort_up.png" />
				</a>
				<a href="'.toURL($this->url, array('sorting' => $type.'-desc')).'" title="'.ML_LABEL_SORT_DESCENDING.'" class="sorting">
					<img alt="'.ML_LABEL_SORT_DESCENDING.'" src="'.DIR_MAGNALISTER_IMAGES.'sort_down.png" />
				</a>
			</span>';
	}
	
	public function printForm() {
		global $cPath_array; /* xt:commerce */

		if (array_key_exists('cPath', $_GET) && ($_GET['cPath'] != '')) {
			$this->url['cPath'] = $_GET['cPath'];
		}
		if ($this->sorting) {
			$this->url['sorting'] = $this->sorting;
		}

		if (empty($this->list['categories']) && empty($this->list['products'])) {
			$this->retriveList();
		}
		// echo print_m($this->list, '$this->list');

		$html = '
		<form class="categoryView" action="'.toURL($this->url).'" method="post">
			<table class="list"><thead>
				<tr>
					<td class="nowrap edit"'.($this->settings['showCheckboxes'] ? ' colspan="2"' : '').'>
						'.($this->settings['showCheckboxes'] ? $this->categorySelector($this->cPath, true) : '').'
					</td>
					<td class="katProd">'.ML_LABEL_CATEGORIES_PRODUCTS.' '.$this->sortByType('name').'</td>
					<td class="price">'.ML_LABEL_SHOP_PRICE_NETTO.' '.$this->sortByType('price').'</td>
					<td class="price">'.ML_LABEL_SHOP_PRICE_BRUTTO.' '.$this->sortByType('price').'</td>
					'.$this->getAdditionalHeadlines().'
				</tr>
			</thead><tbody>
		';
		$odd = true;
		
		if (!empty($this->list['categories'])) {
			foreach ($this->list['categories'] as $category) {
				$html .= '
					<tr class="'.(($odd = !$odd) ? 'odd' : 'even').'">
						'.($this->settings['showCheckboxes'] ? '<td class="edit">'.$this->categorySelector($category['categories_id']).'</td>' : '').'
						<td class="image">'.generateProductCategoryThumb($category['categories_image'], 20, 20).'</td>
						<td><a href="'.toURL($this->url, array('cPath' => $this->buildCPath($category['categories_id']))).'">
							'.$this->imageHTML(DIR_MAGNALISTER_IMAGES.'folder.png', ML_LABEL_CATEGORY).' '.$category['categories_name'].'
						</a></td>
						<td>&mdash;</td>
						<td>&mdash;</td>
						'.$this->getAdditionalCategoryInfo($category['categories_id'], $product).'
					</tr>
				';
			}
		}
		if (!empty($this->list['products'])) {
			foreach ($this->list['products'] as $product) {
				$this->simplePrice->setPrice($product['products_price']);
				$html .= '
					<tr class="'.(($odd = !$odd) ? 'odd' : 'even').'">
						'.($this->settings['showCheckboxes'] ? '<td class="edit">'.$this->productSelector($product['products_id']).'</td>' : '').'
						<td class="image">'.generateProductCategoryThumb($product['products_image'], ML_THUMBS_MINI, ML_THUMBS_MINI).'</td>
						<td>'.$this->imageHTML(DIR_MAGNALISTER_IMAGES.'shape_square.png', ML_LABEL_PRODUCT).' '.$product['products_name'].'</td>
						<td>'.$this->simplePrice->format().'</td>
						<td>'.$this->simplePrice->addTaxByTaxID($product['products_tax_class_id'])->format().'</td>
						'.$this->getAdditionalProductInfo($product['products_id'], $product).'
					</tr>
				';
			}
		}
		if (empty($this->list['categories']) && empty($this->list['products'])) {
			$cols = substr_count($html, '</td>');
			$html .= '
				<tr class="even">
					<td class="center bold" colspan="'.($cols+1).'">'.ML_LABEL_EMPTY.'</td>
				</tr>
			';
		}

		$html .= '
			</tbody></table>
		</form>';

		ob_start();?>
		<script type="text/javascript">/*<![CDATA[*/
function toggleCheckboxClasses(elem, state) {
	if (state) {
		$(elem).addClass('checked').removeClass('semichecked').removeClass('unchecked');
	} else {
		$(elem).removeClass('checked').removeClass('semichecked').addClass('unchecked');
	}
}
function str_replace(search, replace, subject) {
    return subject.split(search).join(replace);
}

$(document).ready(function() {
	$('form.categoryView input[type="submit"]').each(function() {
		$(this).click(function () {
			elem = $(this);
			$.blockUI(blockUILoading);
			jQuery.ajax({
				type: 'POST',
				url: '<?php echo toURL($this->url, array('kind' => 'ajax'), true);?>',
				data: {
					'action': $(this).attr('name')
				},
				success: function(data) {
					toggleCheckboxClasses(elem, data.checked);
					$(elem).attr('name', data.newname);
					if ($(elem).attr('id') == 'selectAll') {
						$('form.categoryView input[type="submit"]:not(#selectAll)').each(function () {
							if (data.checked) {
								$(this).attr('name', str_replace('Add', 'Remove', $(this).attr('name')));
							} else {
								$(this).attr('name', str_replace('Remove', 'Add', $(this).attr('name')));
							}
							toggleCheckboxClasses(this, data.checked);
						});
					} else {
						checkedX = 0;
						itemCount = $('form.categoryView input[type="submit"]:not(#selectAll)').each(function () {
							if ($(this).hasClass('checked')) {
								++checkedX;
							}
						}).length;
						if (checkedX == 0) {
							toggleCheckboxClasses($('#selectAll').attr('name', str_replace('Remove', 'Add', $('#selectAll').attr('name'))), false);
						} else if (checkedX == itemCount) {
							toggleCheckboxClasses($('#selectAll').attr('name', str_replace('Add', 'Remove', $('#selectAll').attr('name'))), true);
						} else {
							$('#selectAll').attr(
								'name', 
								str_replace('Remove', 'Add', $('#selectAll').attr('name'))
							).removeClass('checked').removeClass('unchecked').addClass('semichecked');
						}
					}
					myConsole.log('It took '+data.timer+' to perform this action.');
					jQuery.unblockUI();
				},
				error: function() {
					jQuery.unblockUI();
				},
				dataType: 'json'
			});
		});
	});
	
	$('form.categoryView').submit(function() {
		$.blockUI(blockUILoading); 
	});
});
		/*]]>*/</script><?php
		$html .= ob_get_contents();	
		ob_end_clean();

		if (count($cPath_array) > 1) {
			$cPathBack = $cPath_array;
			array_pop($cPathBack);
			$cPathBack = '<a class="button" href="'.toURL($this->url, array('cPath' => implode('_', $cPathBack))).'">'.
				$this->imageHTML(DIR_MAGNALISTER_IMAGES.'folder_back.png', ML_BUTTON_LABEL_BACK).' '. ML_BUTTON_LABEL_BACK . 
			'</a>';
		} else if (((count($cPath_array) == 1) && ($cPath_array[0] != '0')) || !empty($this->search)) {
			unset($this->url['cPath']);
			$cPathBack = '<a class="button" href="'.toURL($this->url).'">'.
				$this->imageHTML(DIR_MAGNALISTER_IMAGES.'folder_back.png', ML_BUTTON_LABEL_BACK).' '. ML_BUTTON_LABEL_BACK . 
			'</a>';
		} else {
			$cPathBack = '&nbsp;';
		}
		
		$functionButtons = $this->getFunctionButtons();
		$infoText = $this->getInfoText();
		$html .= '
			<form name="action_form" action="'.toURL($this->url, $this->action).'" method="post" onsubmit="" id="action_form">
				<input type="hidden" name="timestamp" value="'.time().'"/>
				<table class="actions">
					<thead><tr><th>'.ML_LABEL_ACTIONS.'</th></tr></thead>
					<tbody>
						<tr class="first_child"><td>
							<table><tbody><tr>
								<td class="first_child">'.$cPathBack.'</td>
								<td><label for="tfSearch">Suche:</label>
									<input id="tfSearch" name="tfSearch" type="text" value="'.$_POST['tfSearch'].'"/>
									<input type="submit" class="button" value="'.ML_BUTTON_LABEL_GO.'" name="search_go" /></td>
								<td class="last_child">'.$functionButtons.'</td>
							</tr></tbody></table>
						</td></tr>
						'.(($infoText != '') ? ('<tr><td colspan="2"><div class="h4">'.ML_LABEL_INFO.'</div>'.$infoText.'</td></tr>') : '').'
					</tbody>
				</table>
			</form>
		';
		return $html;
	}
	
	public function renderAjaxReply() {
		return json_encode($this->ajaxReply);
	}

	private function imageHTML($fName, $alt = '') {
		$alt = ($alt != '') ? $alt : basename($fName);
		return '<img src="'.$fName.'" alt="'.$alt.'" />';
	}

	/* Wird von erbender Klasse ueberschrieben */
	public function getAdditionalHeadlines() { return ''; }

	/* Wird von erbender Klasse ueberschrieben */
	public function getAdditionalCategoryInfo($cID, $data = false) { return ''; }

	/* Wird von erbender Klasse ueberschrieben */
	public function getAdditionalProductInfo($pID, $data = false) { return ''; }

	/* Wird von erbender Klasse ueberschrieben */
	public function getFunctionButtons() { return ''; }
	
	/* Wird von erbender Klasse ueberschrieben */
	public function getInfoText() { return ''; }

}


$_MagnaSession['currentPlatform'] = 'test';
$_url['module'] = 'SimpleCategoryView';

if (!isset($_GET['kind']) || ($_GET['kind'] != 'ajax')) {
	include_once(DIR_MAGNALISTER_INCLUDES.'admin_view_top.php');
}

if (isset($_GET['cPath'])) {
	$cPath = explode('_', $_GET['cPath']);
	$cPath = array_pop($cPath);
} else {
	$cPath = 0;
}

$scV = new SimpleCategoryView($cPath);

if (!isset($_GET['kind']) || ($_GET['kind'] != 'ajax')) {
	echo $scV->printForm();

	if (!_browser('msie', '>= 6.0')) {
		echo '<textarea id="debugBox" wrap="off">';
		echo '$_MagnaSession['.$_MagnaSession['currentPlatform'].'][selection][general2] :: '.print_r($_MagnaSession[$_MagnaSession['currentPlatform']]['selection']['general2'], true)."\n";
		echo '$_POST :: '.print_r($_POST, true)."\n";
		echo '</textarea>';
	}

	include_once(DIR_MAGNALISTER_INCLUDES.'admin_view_bottom.php');
} else {
	echo $scV->renderAjaxReply();
}



require(DIR_WS_INCLUDES . 'application_bottom.php');
exit();