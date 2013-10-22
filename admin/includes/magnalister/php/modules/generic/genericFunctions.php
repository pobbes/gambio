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

function magnaGetBaseRequest($mpID) {
	global $_modules;
	$marketplace = magnaGetMarketplaceByID($mpID);
	$subsystem = $_modules[$marketplace]['settings']['subsystem'];
	$request = array (
		'SUBSYSTEM' => $subsystem,
		'MARKETPLACEID' => $mpID,
	);
	if ($subsystem == 'ComparisonShopping') {
		$request['SEARCHENGINE'] = $marketplace;
	}
	return $request;
}

function magnaUpdateItems($mpID, $data, $upload = false, $responseCallback = '') {
	global $_modules;
	if (!is_array($data) || empty($data)) {
		return false;
	}
	$request = magnaGetBaseRequest($mpID);
	$request['ACTION'] = 'UpdateItems';
	$request['DATA'] = $data;
	if (defined('MAGNA_ECHO_UPDATE') && MAGNA_ECHO_UPDATE) {
		if (function_exists('ml_debug_out')) {
			ml_debug_out("\n".'$responseCallback: '.$responseCallback."\n");
			ml_debug_out(print_m($request));
		}
		return true;
	}
	try {
		$r = MagnaConnector::gi()->submitRequest($request);
		if (!empty($responseCallback) && function_exists($responseCallback)) {
			$responseCallback($r, $mpID);
		}
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

function magnaUploadItems($mpID) {
	$request = magnaGetBaseRequest($mpID);
	$request['ACTION'] = 'UploadItems';
	if (defined('MAGNA_ECHO_UPDATE') && MAGNA_ECHO_UPDATE) {
		if (function_exists('ml_debug_out')) ml_debug_out("\n".print_m($request));
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

function genericCalcNewQuantity($pID, $aID, $sub = 0) {
	$curQty = false;
	if ($aID !== false) {
		$curQty = MagnaDB::gi()->fetchOne('
			SELECT attributes_stock FROM '.TABLE_PRODUCTS_ATTRIBUTES.' 
			 WHERE products_attributes_id = \''.$aID.'\'
		');
	}
	if ($curQty === false) {
		$curQty = MagnaDB::gi()->fetchOne('
			SELECT products_quantity FROM '.TABLE_PRODUCTS.'
			 WHERE products_id = \''.$pID.'\'
		');
	}
	if ($curQty === false) {
		return false;
	}

	$curQty -= $sub;
	if ($curQty < 0) {
		$curQty = 0;
	}
	return $curQty;
}

function autoupdateGenericInventory($mpID, $offset = 0, $limit = 100, $updateFunction = '', $uploadFunction = '', $callStack = 0) {
	$marketplace = magnaGetMarketplaceByID($mpID);

	$syncStock = getDBConfigValue($marketplace.'.stocksync.tomarketplace', $mpID, null) == 'auto';
	$syncPrice = getDBConfigValue($marketplace.'.inventorysync.price', $mpID, null) == 'auto';
	//$syncStock = $syncPrice = true;
	if (function_exists('ml_debug_out')) {
		ml_debug_out("\n".'syncStock: '.($syncStock ? 'true' : 'false')." \t");
		ml_debug_out('syncPrice: '.($syncPrice ? 'true' : 'false')." \t");
		ml_debug_out('!(syncStock || syncPrice): '.(!($syncStock || $syncPrice) ? 'no sync' : 'sync')."\n");
	}
	//echo '<br>';
	if (!($syncStock || $syncPrice)) {
		if (function_exists('ml_debug_out')) ml_debug_out($mpID.' ('.$marketplace.'): no autosync'."\n");
		if (!defined('MAGNA_ECHO_UPDATE') || (MAGNA_ECHO_UPDATE !== true)) {
			return true;
		}
		if (function_exists('ml_debug_out')) ml_debug_out('   ## SIMULATE ##'."\n");
		$syncStock = 'auto';
		setDBConfigValue($marketplace.'.stocksync.tomarketplace', $mpID, $syncStock);
		$syncPrice = 'auto';
		setDBConfigValue($marketplace.'.inventorysync.price', $mpID, $syncPrice);
	}
	//return;
	$_debugLevel = isset($_GET['DEBUGLV']) ? $_GET['DEBUGLV'] : false;
	$_debugLevels = array('low', 'med', 'high');
	if (!in_array($_debugLevel, $_debugLevels)) {
		$_debugLevel = false;
	} else {
		if (function_exists('ml_debug_out')) ml_debug_out("\n".'$_debugLevel: '.$_debugLevel);
		$_debugLevels = array_flip($_debugLevels);
		$_debugLevel = $_debugLevels[$_debugLevel] + 1;
		if (function_exists('ml_debug_out')) ml_debug_out(' ('.$_debugLevel.")\n");
	}
	#return;

	if (empty($updateFunction) || !function_exists($updateFunction)) {
		$updateFunction = 'magnaUpdateItems';
	}

	$request = magnaGetBaseRequest($mpID);
	$request['ACTION'] = 'GetInventory';
	$request['LIMIT'] = $limit;
	$request['OFFSET'] = $offset;

	try {
		$result = MagnaConnector::gi()->submitRequest($request);
	} catch (MagnaException $e) {
		if (function_exists('ml_debug_out')) ml_debug_out("\n".print_m($e->getErrorArray(), $e->getMessage()));
		return false;
	}

	if (!empty($result['DATA'])) {
		$stockBatch = array();

		$sub = 0;
		if ($syncStock) {
			$quantityType = getDBConfigValue($marketplace.'.quantity.type', $mpID, '');
			if ($quantityType == 'stocksub') {
				$sub = getDBConfigValue($marketplace.'.quantity.value', $mpID, 0);
			}
		}
		if (function_exists('ml_debug_out')) ml_debug_out("\n".print_m(count($result['DATA']), 'inventory items')."\n");

		foreach ($result['DATA'] as $item) {
			@set_time_limit(180);
			$aID = magnaSKU2aID($item['SKU']);
			$pID = magnaSKU2pID($item['SKU']);
			//usleep(200000);

			if ((int)$pID <= 0) {
				if (function_exists('ml_debug_out')) ml_debug_out("\n".'Item not found :: SKU: '.$item['SKU'].' pID: '.$pID.' aID: '.$aID);
				continue;
			} else if (($_debugLevel >= 2) && function_exists('ml_debug_out')) {
				ml_debug_out("\n".'Item found :: SKU: '.$item['SKU'].' pID: '.$pID.' aID: '.$aID);
			}
			$data = array();
			if ($syncStock) {
				$curQty = genericCalcNewQuantity($pID, $aID, $sub);
				if (isset($item['Quantity']) && ($item['Quantity'] != $curQty)) {
					$data['NewQuantity'] = array (
						'Mode' => 'SET',
						'Value' => (int)$curQty
					);
					if (function_exists('ml_debug_out')) ml_debug_out("\n".'Quantity ['.$mpID.', '.$pID.', '.$aID.'] '.$item['Quantity'].' != '.$curQty);
				} else if (($_debugLevel >= 2) && function_exists('ml_debug_out')) {
					ml_debug_out("\n".'Quantity ['.$mpID.', '.$pID.', '.$aID.'] '.(isset($item['Quantity']) ? $item['Quantity'] : 'NULL').' == '.$curQty);
				}
			}
			if ($syncPrice) {
				$sp = new SimplePrice();
				$price = $sp->setPriceFromDB($pID, $mpID)
							->addAttributeSurcharge($aID)
							->finalizePrice($pID, $mpID)->getPrice();
				if (($price > 0) && ((float)$item['Price'] != $price)) {
					if (function_exists('ml_debug_out')) ml_debug_out("\n".'Price ['.$mpID.', '.$pID.', '.$aID.'] '.$item['Price'].' != '.$price);
					$data['Price'] = $price;
				} else if (($_debugLevel >= 2) && function_exists('ml_debug_out')) {
					ml_debug_out("\n".'Price ['.$mpID.', '.$pID.', '.$aID.'] '.$item['Price'].' == '.$price);
				}
			}
			if (!empty($data)) {
				$data['SKU'] = $item['SKU'];
				$stockBatch[] = $data;
			}
			if (function_exists('ml_debug_out')) {
				ml_debug_out(($_debugLevel >= 2) ? "\n" : '.');
			}
		}
		if (function_exists('ml_debug_out')) ml_debug_out("\n".print_m($stockBatch, '$stockBatch'));
		$updateFunction($mpID, $stockBatch);
	}
	if (($offset + $limit) < $result['NUMBEROFLISTINGS']) {
		autoupdateGenericInventory($mpID, ($offset + $limit), $limit, $updateFunction, $uploadFunction, $callStack + 1);
	} else if (($callStack == 0) && !empty($uploadFunction) && function_exists($uploadFunction)) {
		if (function_exists('ml_debug_out')) ml_debug_out('$updateFunction: '.$updateFunction.'; $uploadFunction: '.$uploadFunction."\n");
		$uploadFunction($mpID);
	}
	return true;
}
