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
 * $Id$
 *
 * (c) 2010 - 2011 RedGecko GmbH -- http://www.redgecko.de
 *     Released under the GNU General Public License v2 or later
 * -----------------------------------------------------------------------------
 */

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

require_once(DIR_MAGNALISTER_MODULES.'magnacompatible/crons/MagnaCompatibleCronBase.php');

abstract class MagnaCompatibleSyncInventory extends MagnaCompatibleCronBase {
	protected $offset = 0;
	protected $limit = 100;
	
	protected $simplePrice = null;
	
	protected $syncStock = false;
	protected $syncPrice = false;
	
	protected $_debugLevel = 0;
	
	protected $cItem = array();
	
	protected $stockBatch = array();
	
	protected $helperClass = '';

	public function __construct($mpID, $marketplace, $limit = 100) {
		parent::__construct($mpID, $marketplace);
		$this->limit = $limit;

		$this->initSync();
		
		$this->_debugLevel = isset($_GET['DEBUGLV']) ? $_GET['DEBUGLV'] : false;
		$_debugLevels = array('low', 'med', 'high');
		if (!in_array($this->_debugLevel, $_debugLevels)) {
			$this->_debugLevel = false;
		} else {
			if (function_exists('ml_debug_out')) ml_debug_out("\n".'$_debugLevel: '.$this->_debugLevel);
			$_debugLevels = array_flip($_debugLevels);
			$this->_debugLevel = $_debugLevels[$this->_debugLevel] + 1;
			if (function_exists('ml_debug_out')) ml_debug_out(' ('.$this->_debugLevel.")\n");
		}
		$this->helperClass = ucfirst($this->marketplace).'Helper';
		$helperPath = DIR_MAGNALISTER_MODULES.strtolower($this->marketplace).'/'.$this->helperClass.'.php';
		if (file_exists($helperPath)) {
			include_once($helperPath);
		}
	}
	
	protected function initSync() {
		require_once(DIR_MAGNALISTER_INCLUDES.'lib/classes/SimplePrice.php');
		$this->simplePrice = new SimplePrice();
	}
	
	protected function getConfigKeys() {
		return array (
			'StockSync' => array (
				'key' => 'stocksync.tomarketplace',
			),
			'PriceSync' => array (
				'key' => 'stocksync.tomarketplace',
			),
			'QuantityType' => array (
				'key' => 'quantity.type',
				'default' => '',
			),
			'QuantityValue' => array (
				'key' => 'quantity.value',
				'default' => 0,
			),
		);
	}

	protected function processUpdateItemsErrors($result) {
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
		$callback = $this->helperClass.'::processCheckinErrors';
		if (is_callable($callback)) {
			call_user_func($callback, $result, $this->mpID);
		}
	}

	protected function getBaseRequest() {
		return array (
			'SUBSYSTEM' => $this->marketplace,
			'MARKETPLACEID' => $this->mpID,
		);
	}

	protected function postProcessRequest($data) {
		return $data;
	}

	protected function updateItems($data) {
		global $_modules;
		if (!is_array($data) || empty($data)) {
			return false;
		}
		$request = $this->getBaseRequest();
		$request['ACTION'] = 'UpdateItems';
		$request['DATA'] = $this->postProcessRequest($data);
		if (defined('MAGNA_ECHO_UPDATE') && MAGNA_ECHO_UPDATE) {
			if (function_exists('ml_debug_out')) {
				ml_debug_out(print_m(json_indent(json_encode($request))));
			}
			return true;
		}
		try {
			$r = MagnaConnector::gi()->submitRequest($request);
			$this->processUpdateItemsErrors($r);
			if (defined('ML_SHOW_INVENTORY_CHANGE') && ML_SHOW_INVENTORY_CHANGE) {
				echo var_export_pre($r, '$r', true)."\n\n";
			}
			if (defined('ML_LOG_INVENTORY_CHANGE') && ML_LOG_INVENTORY_CHANGE) {
				file_put_contents(DIR_MAGNALISTER_CALLBACK.'inventoryUpdate.dat', '$r = '.var_export_pre($r, true)."\n", FILE_APPEND);
			}
		} catch (MagnaException $e) {
			if (defined('ML_LOG_INVENTORY_CHANGE') && ML_LOG_INVENTORY_CHANGE) {
				file_put_contents(
					DIR_MAGNALISTER_CALLBACK.'inventoryUpdate.dat', 
					'EXCEPTION :: '.$e->getMessage()."\n".'$error = '.var_export_pre($e->getErrorArray(), true).";\n",
					FILE_APPEND
				);
			}
			if ($e->getCode() == MagnaException::TIMEOUT) {
				$e->saveRequest();
				$e->setCriticalStatus(false);
			}
			return false;
		}
		return true;
	}
	
	
	protected function uploadItems() {
		$request = $this->getBaseRequest();
		$request['ACTION'] = 'UploadItems';
		if (defined('MAGNA_ECHO_UPDATE') && MAGNA_ECHO_UPDATE) {
			if (function_exists('ml_debug_out')) {
				ml_debug_out(print_m(json_indent(json_encode($request))));
			}
			return true;
		}
		try {
			//*
			$r = MagnaConnector::gi()->submitRequest($request);
			//*/
		} catch (MagnaException $e) {
			if (defined('ML_LOG_INVENTORY_CHANGE') && ML_LOG_INVENTORY_CHANGE) {
				file_put_contents(
					DIR_MAGNALISTER_CALLBACK.'inventoryUpdate.dat', 
					'EXCEPTION :: '.$e->getMessage()."\n".'$error = '.var_export_pre($e->getErrorArray(), true).";\n",
					FILE_APPEND
				);
			}
			if ($e->getCode() == MagnaException::TIMEOUT) {
				$e->saveRequest();
				$e->setCriticalStatus(false);
			}
			return false;
		}
		return true;
	}
	
	protected function calcNewQuantity() {
		$curQty = false;
		if ($this->cItem['aID'] > 0) {
			$curQty = MagnaDB::gi()->fetchOne('
				SELECT attributes_stock FROM '.TABLE_PRODUCTS_ATTRIBUTES.' 
				 WHERE products_attributes_id = \''.$this->cItem['aID'].'\'
			');
		}
		if ($curQty === false) {
			$curQty = MagnaDB::gi()->fetchOne('
				SELECT products_quantity FROM '.TABLE_PRODUCTS.'
				 WHERE products_id = \''.$this->cItem['pID'].'\'
			');
		}
		if ($curQty === false) {
			return false;
		}
	
		$curQty -= $this->config['QuantitySub'];
		if ($curQty < 0) {
			$curQty = 0;
		}
		return $curQty;
	}
	
	protected function isAutoSyncEnabled() {
		$this->syncStock = $this->config['StockSync'] == 'auto';
		$this->syncPrice = $this->config['PriceSync'] == 'auto';
		
		//$this->syncStock = $this->syncPrice = true;
		
		if (function_exists('ml_debug_out')) {
			ml_debug_out("\n".'syncStock: '.($this->syncStock ? 'true' : 'false')." \t");
			ml_debug_out('syncPrice: '.($this->syncPrice ? 'true' : 'false')." \t");
			ml_debug_out('!(syncStock || syncPrice): '.(!($this->syncStock || $this->syncPrice) ? 'no sync' : 'sync')."\n");
		}
		
		if (!($this->syncStock || $this->syncPrice)) {
			if (function_exists('ml_debug_out')) ml_debug_out($this->mpID.' ('.$this->marketplace.'): no autosync'."\n");
			return false;
		}
		return true;
	}

	protected function idendtifySKU() {
		$this->cItem['pID'] = (int)magnaSKU2pID($this->cItem['SKU']);
		$this->cItem['aID'] = (int)magnaSKU2aID($this->cItem['SKU']);
	}

	protected function updateQuantity() {
		if (!$this->syncStock) return false;
		
		$data = false;
		$curQty = $this->calcNewQuantity();

		if (isset($this->cItem['Quantity']) && ($this->cItem['Quantity'] != $curQty)) {
			$data = array (
				'Mode' => 'SET',
				'Value' => (int)$curQty
			);
			
			if (function_exists('ml_debug_out')) ml_debug_out("\n".
				'Quantity ['.$this->cItem['SKU'].', '.$this->cItem['ItemTitle'].', '.$this->cItem['pID'].', '.$this->cItem['aID'].'] '.
					$this->cItem['Quantity'].' != '.$curQty
			);

		} else if (($this->_debugLevel >= 2) && function_exists('ml_debug_out')) {
			ml_debug_out("\n".
				'Quantity ['.$this->cItem['SKU'].', '.$this->cItem['ItemTitle'].', '.$this->cItem['pID'].', '.$this->cItem['aID'].'] '.
					(isset($this->cItem['Quantity']) ? $this->cItem['Quantity'] : 'NULL').' == '.$curQty
			);
		}
		return $data;
	}

	protected function updatePrice() {
		if (!$this->syncPrice) return false;
		
		$data = false;
		
		$price = $this->simplePrice->setPriceFromDB($this->cItem['pID'], $this->mpID)
					->addAttributeSurcharge($this->cItem['aID'])
					->finalizePrice($this->cItem['pID'], $this->mpID)->getPrice();
				
		if (($price > 0) && ((float)$this->cItem['Price'] != $price)) {
			if (function_exists('ml_debug_out')) ml_debug_out("\n".
				'Price ['.$this->cItem['SKU'].', '.$this->cItem['ItemTitle'].', '.$this->cItem['pID'].', '.$this->cItem['aID'].'] '.$this->cItem['Price'].' != '.$price
			);
			$data = $price;
		} else if (($this->_debugLevel >= 2) && function_exists('ml_debug_out')) {
			ml_debug_out("\n".'Price ['.$this->cItem['SKU'].', '.$this->cItem['ItemTitle'].', '.$this->cItem['pID'].', '.$this->cItem['aID'].'] '.$this->cItem['Price'].' == '.$price);
		}
		return $data;		
	}

	protected function updateItem() {
		@set_time_limit(180);
		$this->idendtifySKU();
		
		if ((int)$this->cItem['pID'] <= 0) {
			if (function_exists('ml_debug_out')) ml_debug_out("\n".
				'Item not found :: SKU: '.$this->cItem['SKU'].', '.
				                  'ItemTitle: '.$this->cItem['ItemTitle'].', '.
				                  'pID: '.$this->cItem['pID'].', '.
				                  'aID: '.$this->cItem['aID']
			);
			return;
		} else if (($this->_debugLevel >= 2) && function_exists('ml_debug_out')) {
			ml_debug_out("\n".
				'Item found :: SKU: '.$this->cItem['SKU'].', '.
				              'ItemTitle: '.$this->cItem['ItemTitle'].', '.
				              'pID: '.$this->cItem['pID'].', '.
				              'aID: '.$this->cItem['aID']
			);
		}
		
		$data = array();
		
		$qU = $this->updateQuantity();
		if ($qU !== false) {
			$data['NewQuantity'] = $qU;
		}
		
		$pU = $this->updatePrice();
		if ($pU !== false) {
			$data['Price'] = $pU;
		}

		if (!empty($data)) {
			$data['SKU'] = $this->cItem['SKU'];
			$this->stockBatch[] = $data;
		}
		
	}

	protected function syncInventory() {
		do {
			$request = $this->getBaseRequest();
			$request['ACTION'] = 'GetInventory';
			$request['LIMIT'] = $this->limit;
			$request['OFFSET'] = $this->offset;
		
			try {
				$result = MagnaConnector::gi()->submitRequest($request);
			} catch (MagnaException $e) {
				if (function_exists('ml_debug_out')) ml_debug_out("\n".print_m($e->getErrorArray(), $e->getMessage()));
				return false;
			}
	
			if (!empty($result['DATA'])) {
				$this->stockBatch = array();
	
				if (function_exists('ml_debug_out')) ml_debug_out("\n".print_m(count($result['DATA']), 'inventory items')."\n");
		
				foreach ($result['DATA'] as $item) {
					$this->cItem = $item;
					@set_time_limit(180);
					$this->updateItem();
	
					if (function_exists('ml_debug_out')) {
						ml_debug_out(($this->_debugLevel >= 2) ? "\n" : '.');
					}
				}
				if (function_exists('ml_debug_out')) ml_debug_out("\n".print_m($this->stockBatch, '$stockBatch'));
				$this->updateItems($this->stockBatch);
			}
			$this->offset += $this->limit;
		} while ($this->offset < ($result['NUMBEROFLISTINGS'] + $this->limit));

		$this->uploadItems();
		return true;
	}

	public function process() {
		if (!$this->isAutoSyncEnabled()) {
			return;
		}
		$this->config['QuantitySub'] = 0;
		if ($this->syncStock) {
			if ($this->config['QuantityType'] == 'stocksub') {
				$this->config['QuantitySub'] = $this->config['QuantityValue'];
			}
		}
		$this->syncInventory();
	}
}
