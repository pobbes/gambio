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
 * $Id: amazonFunctions.php 1608 2012-04-11 10:02:23Z derpapst $
 *
 * (c) 2010 RedGecko GmbH -- http://www.redgecko.de
 *     Released under the GNU General Public License v2 or later
 * -----------------------------------------------------------------------------
 */

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

require_once(DIR_MAGNALISTER_MODULES.'generic/genericFunctions.php');

function magnaAmazonSKU2pID($sku, $asin = '') {
	$pID = magnaSKU2pID($sku);
	if (($pID <= 0) && !empty($asin)) {
		global $_MagnaSession;
		if (getDBConfigValue('general.keytype', '0') == 'artNr') {
			$query = '
				SELECT p.products_id 
				  FROM '.TABLE_PRODUCTS.' p, '.TABLE_MAGNA_AMAZON_PROPERTIES.' pa
				 WHERE p.products_model = pa.products_model
				       AND pa.asin=\''.$asin.'\' AND mpID=\''.$_MagnaSession['mpID'].'\'
				 LIMIT 1
			';
		} else {
			$query = '
				SELECT products_id 
				  FROM '.TABLE_MAGNA_AMAZON_PROPERTIES.' 
				 WHERE asin=\''.$asin.'\' AND mpID=\''.$_MagnaSession['mpID'].'\'
				 LIMIT 1';
		}
		$pID = (int)MagnaDB::gi()->fetchOne($query);
		unset($query);
	}
	return $pID;
}

function performItemSearch($asin, $ean, $productsName) {
	require_once (DIR_MAGNALISTER_INCLUDES.'lib/classes/SimplePrice.php');

	$searchResults = array();
	if (!empty($asin)) {
		try {
			$result = MagnaConnector::gi()->submitRequest(array(
				'ACTION' => 'ItemLookup',
				'ASIN' => $asin
			));
			if (!empty($result['DATA'])) {
				$searchResults = array_merge($searchResults, $result['DATA']);
			}
		} catch (MagnaException $e) {
			$e->setCriticalStatus(false);
		}
	}
	$ean = str_replace(array(' ', '-'), '', $ean);
	if (!empty($ean)) {
		try {
			$result = MagnaConnector::gi()->submitRequest(array(
				'ACTION' => 'ItemLookup',
				'ASIN' => $ean
			));
			if (!empty($result['DATA'])) {
				$searchResults = array_merge($searchResults, $result['DATA']);
			}
		} catch (MagnaException $e) {
			$e->setCriticalStatus(false);
		}
		try {
			$result = MagnaConnector::gi()->submitRequest(array(
				'ACTION' => 'ItemSearch',
				'NAME' => $ean
			));
			if (!empty($result['DATA'])) {
				$searchResults = array_merge($searchResults, $result['DATA']);
			}
		} catch (MagnaException $e) {
			$e->setCriticalStatus(false);
		}
	}

	if (!empty($productsName)) {
		try {	
			$result = MagnaConnector::gi()->submitRequest(array(
				'ACTION' => 'ItemSearch',
				'NAME' => $productsName
			));
			if (!empty($result['DATA'])) {
				$searchResults = array_merge($searchResults, $result['DATA']);
			}
		} catch (MagnaException $e) {
			$e->setCriticalStatus(false);
		}
	}
	if (!empty($searchResults)) {
		$searchResults = array_map('unserialize', array_unique(array_map('serialize', $searchResults)));
	    foreach ($searchResults as &$data) {
	    	if (!empty($data['Author'])) {
	    		$data['Title'] .= ' ('.$data['Author'].')';
	    	}
	    	$price = new SimplePrice($data['LowestPrice']['Price'], $data['LowestPrice']['CurrencyCode']);
	    	$data['LowestPrice'] = $data['LowestPrice']['Price'];
	    	$data['LowestPriceFormated'] = $price->format();
	    }
	}
	return $searchResults;
}

function amazonGetPossibleOptions($kind, $mpID = false) {
	if ($mpID === false) {
		global $_MagnaSession;
		$mpID = $_MagnaSession['mpID'];
	}
	
	initArrayIfNecessary($_MagnaSession, array($mpID, $kind));
	
	if (empty($_MagnaSession[$mpID][$kind])) {
		try {
			$result = MagnaConnector::gi()->submitRequest(array(
				'ACTION' => 'Get'.$kind,
				'SUBSYSTEM' => 'Amazon',
				'MARKETPLACEID' => $mpID,
			));
			$_MagnaSession[$mpID][$kind] = $result['DATA'];
		} catch (MagnaException $e) { }
	}
	return $_MagnaSession[$mpID][$kind];
}

function amazonGetMarketplaces() {
	global $_MagnaSession;
	
	initArrayIfNecessary($_MagnaSession, array($_MagnaSession['mpID'], 'Marketplaces', 'Sites'));
	initArrayIfNecessary($_MagnaSession, array($_MagnaSession['mpID'], 'Marketplaces', 'Currencies'));

	if (empty($_MagnaSession[$_MagnaSession['mpID']]['Marketplaces']['Sites']) || 
		empty($_MagnaSession[$_MagnaSession['mpID']]['Marketplaces']['Currencies'])
	) {
		try {
			$_MagnaSession[$_MagnaSession['mpID']]['Marketplaces'] = array();
			
			$result = MagnaConnector::gi()->submitRequest(array(
				'ACTION' => 'GetMarketplaces',
				'SUBSYSTEM' => 'Amazon',
			));
			foreach ($result['DATA'] as $item) {
				$_MagnaSession[$_MagnaSession['mpID']]['Marketplaces']['Sites'][$item['Key']] = fixHTMLUTF8Entities($item['Label']);
				$_MagnaSession[$_MagnaSession['mpID']]['Marketplaces']['Currencies'][$item['Key']] = $item['Currency'];
			}
		} catch (MagnaException $e) { }
	}

	return $_MagnaSession[$_MagnaSession['mpID']]['Marketplaces'];
}

function amazonCalcNewQuantity($pID, $aID, $sub = 0) {
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

function autoupdateAmazonInventory($mpID, $offset = 0, $limit = 100) {
	$syncStock = getDBConfigValue('amazon.stocksync.tomarketplace', $mpID, null) == 'auto';
	$syncPrice = getDBConfigValue('amazon.inventorysync.price', $mpID, null) == 'auto';
	//$syncStock = $syncPrice = true;
	if (function_exists('ml_debug_out')) {
		ml_debug_out("\n".'syncStock: '.($syncStock ? 'true' : 'false')." \t");
		ml_debug_out('syncPrice: '.($syncPrice ? 'true' : 'false')." \t");
		ml_debug_out('!(syncStock || syncPrice): '.(!($syncStock || $syncPrice) ? 'true' : 'false')."\n");
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
	//return;
	require_once (DIR_MAGNALISTER_INCLUDES.'lib/classes/SimplePrice.php');

	$timeToShip = getDBConfigValue('amazon.leadtimetoship', $mpID, '');
	try {
		$result = MagnaConnector::gi()->submitRequest(array(
			'ACTION' => 'GetInventory',
			'SUBSYSTEM' => 'Amazon',
			'MARKETPLACEID' => $mpID,
			'LIMIT' => $limit,
			'OFFSET' => $offset,
			'ORDERBY' => 'SKU',
			'SORTORDER' => 'ASC'
		));
	} catch (MagnaException $e) {
		echo print_m($e->getErrorArray(), '$error');
		return false;
	}
	if (!empty($result['DATA'])) {
		$stockBatch = array();

		$sub = 0;
		if ($syncStock) {
			$quantityType = getDBConfigValue('amazon.quantity.type', $mpID, '');
			if ($quantityType == 'stocksub') {
				$sub = getDBConfigValue('amazon.quantity.value', $mpID, 0);
			}
		}
		if (function_exists('ml_debug_out')) ml_debug_out("\n".print_m(count($result['DATA']), 'inventory items')."\n");
		
		foreach ($result['DATA'] as $item) {
			@set_time_limit(180);
			$aID = magnaSKU2aID($item['SKU']);
			$pID = magnaSKU2pID($item['SKU']);
			//echo 'SKU: '.$item['SKU'].' pID: '.$pID.' aID: '.$aID."\n";

			if ((int)$pID <= 0) {
				if (function_exists('ml_debug_out')) ml_debug_out("\n".'Item not found :: SKU: '.$item['SKU'].' pID: '.$pID.' aID: '.$aID);
				continue;
			} else if (($_debugLevel >= 2) && function_exists('ml_debug_out')) {
				ml_debug_out("\n".'Item found :: SKU: '.$item['SKU'].' pID: '.$pID.' aID: '.$aID);
			}
			
			$data = array();
			if ($syncStock) {
				$curQty = amazonCalcNewQuantity($pID, $aID, $sub);
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
				if (!empty($timeToShip)) {
					$data['LeadtimeToShip'] = (int)$timeToShip;
				}
				$stockBatch[] = $data;
			}
			if (function_exists('ml_debug_out')) {
				ml_debug_out(($_debugLevel >= 2) ? "\n" : '.');
			}
		}
		if (function_exists('ml_debug_out')) ml_debug_out("\n".print_m($stockBatch, '$stockBatch'));
		magnaUpdateItems($mpID, $stockBatch);
	}
	if (($offset + $limit) < $result['NUMBEROFLISTINGS']) {
		autoupdateAmazonInventory($mpID, ($offset + $limit), $limit);
	} else {
		magnaUploadItems($mpID);
	}
	return true;
}

function updateAmazonInventoryByEdit($mpID, $updateData) {
	$updateItem = genericInventoryUpdateByEdit($mpID, $updateData);
	if (!is_array($updateItem)) {
		return;
	}
	$timeToShip = getDBConfigValue('amazon.leadtimetoship', $mpID, '');
	if (!empty($timeToShip)) {
		$updateItem['LeadtimeToShip'] = (int)$timeToShip;
	}
	#echo print_m($updateItem, '$updateItem');
	magnaUpdateItems($mpID, array($updateItem), true);
}

function updateAmazonInventoryByOrder($mpID, $boughtItems, $subRelQuant = true) {
	if (getDBConfigValue('amazon.stocksync.tomarketplace', $mpID, 'no') == 'no') {
		return;
	}
	$data = genericInventoryUpdateByOrder($mpID, $boughtItems, $subRelQuant);
	$timeToShip = getDBConfigValue('amazon.leadtimetoship', $mpID, '');
	if (!empty($timeToShip)) {
		foreach ($data as &$item) {
			$item['LeadtimeToShip'] = (int)$timeToShip;
		}
	}
	#echo print_m($data, '$data');
	magnaUpdateItems($mpID, $data, true);
}

function loadCarrierCodes($mpID = false) {
	if ($mpID === false) {
		global $_MagnaSession;
		$mpID = $_MagnaSession['mpID'];
	}
	$carrier = amazonGetPossibleOptions('CarrierCodes', $mpID);

	# Amazon Config Form
	if (array_key_exists('conf', $_POST) && array_key_exists('amazon.orderstatus.carrier.additional', $_POST['conf'])) {
		setDBConfigValue(
			'amazon.orderstatus.carrier.additional',
			$mpID,
			$_POST['conf']['amazon.orderstatus.carrier.additional']
		);
	}

	$addCarrier = explode(',', getDBConfigValue('amazon.orderstatus.carrier.additional', $mpID, ''));
	if (!empty($addCarrier)) {
		foreach ($addCarrier as $val) {
			$val = trim($val);
			if (empty($val)) continue;
			$carrier[$val] = $val;
		}
	}
	$carrierValues = array('null' => ML_LABEL_CARRIER_NONE);
	if (!empty($carrier)) {
		foreach ($carrier as $val) {
			if ($val == 'Other') continue;
			$carrierValues[$val] = $val;
		}
	}
	return $carrierValues;
}

function amazonDoOrderStatusSyncByTigger($mpID) {
	$mp = 'amazon';
	return getDBConfigValue($mp.'.orderstatus.sync', $mpID, 'no') != 'no';
}

function amazonRenderOrderStatusSync($args) {
	$html = '';
	$order = $args['order'];
	if (array_key_exists('ML_LABEL_SHIPPING_DATE', $order['data'])) {
		return '';
	}
	if (isset($order['internaldata']['Request'])) {
		return '';
	}
	$carrierCodes = loadCarrierCodes($order['mpID']);
	$defaultcarrier = getDBConfigValue(
		'amazon.orderstatus.carrier.default',
		$order['mpID']
	);

	$replace = array (
		'{#TRACKING_CODE#}' => magnaAmazonFetchTrackingCode3rdParty($order['orders_id'], $order['mpID']),
		'{#CARRIERS_OPTIONS#}' => '',
	);
	foreach ($carrierCodes as $key => $val) {
		$replace['{#CARRIERS_OPTIONS#}'] .= '
			<option '.(($key == $defaultcarrier) ? 'selected="selected"' : '').' value="'.$key.'">'.$val.'</option>';
	}
	
	$htmlTmpl = '
		<tr id="amazonSending"><td class="main" colspan="2" style="padding-left: 0;">
			<table><tbody>
				<tr><td class="main"><b>'.ML_LABEL_TRACKINGCODE.':</b></td>
					<td><input type="text" name="magna[trackingcode]" value="{#TRACKING_CODE#}"/></td></tr>
				<tr><td class="main"><b>'.ML_LABEL_CARRIER.':</b></td>
					<td><select name="magna[carriercode]">{#CARRIERS_OPTIONS#}</select></td></tr>
			</tbody></table>
		</td></tr>';

	if (SHOPSYSTEM == 'gambio') {
		if ($args['view'] == 'orderDetailMulti') {
			global $content_multi_order_status;
			$content_multi_order_status[] = array (
				'text' => ML_LABEL_TRACKINGCODE.': <input type="text" name="magna[trackingcode]" value="'.$replace['{#TRACKING_CODE#}'].'"/>',
			);
			$content_multi_order_status[] = array (
				'text' => ML_LABEL_CARRIER.': <select name="magna[carriercode]">'.$replace['{#CARRIERS_OPTIONS#}'].'</select>',
			);
			return;
		} else {
			$htmlTmpl = '
				<tr><td class="main">'.ML_LABEL_TRACKINGCODE.':</td>
					<td class="main"><input type="text" name="magna[trackingcode]" value="{#TRACKING_CODE#}"/></td></tr>
				<tr><td class="main">'.ML_LABEL_CARRIER.':</td>
					<td><select name="magna[carriercode]">{#CARRIERS_OPTIONS#}</select></td></tr>';
		}
	}

	$html = str_replace(array_keys($replace), array_values($replace), $htmlTmpl);
	return $html;
}

function amazonProcessSingleOrderStatus($args) {
	$order = $args['order'];
	$mp = $order['platform'];
	$mpID = $order['mpID'];
	
	$cancelledState = getDBConfigValue($mp.'.orderstatus.cancelled', $mpID, false);
	$shippedState = getDBConfigValue($mp.'.orderstatus.shipped', $mpID, false);

	$newState = $args['status'];
	if ($newState == 'cancel') {
		$newState = $cancelledState;
	} else if ($newState == 'order') {
		$newState = $shippedState;
		$_POST['magna']['trackingcode'] = magnaAmazonFetchTrackingCode3rdParty($order['orders_id'], $order['mpID']);
		$_POST['magna']['carriercode']  = getDBConfigValue('amazon.orderstatus.carrier.default', $order['mpID']);
	}
	
	$oStatAutoSync = getDBConfigValue($mp.'.orderstatus.sync', $mpID, 'auto') == 'auto';
	
	$request = false;
	if ($newState == $shippedState) {
		$trackercode = (
			array_key_exists('magna', $_POST) 
			&& array_key_exists('trackingcode', $_POST['magna']) 
			&& !eempty(trim($_POST['magna']['trackingcode']))
				? trim($_POST['magna']['trackingcode'])
				: ''
		);
		$carrier = (
			array_key_exists('magna', $_POST) 
			&& array_key_exists('carriercode', $_POST['magna']) 
			&& !eempty(trim($_POST['magna']['carriercode']))
			&& !($_POST['magna']['carriercode'] == 'null')
				? trim($_POST['magna']['carriercode'])
				: ''
		);
		$request = array (
			'ACTION' => 'ConfirmShipment',
			'SUBSYSTEM' => 'Amazon',
			'MARKETPLACEID' => $order['mpID'],
			'DATA' => array (
				array (
					'AmazonOrderID' => $order['data']['AmazonOrderID'],
					'ShippingDate' => gmdate('Y-m-d'),
					'Carrier' => $carrier,
					'TrackingCode' => $trackercode
				)
			)
		);
	} else if ($newState == $cancelledState) {
		$request = array (
			'ACTION' => 'CancelShipment',
			'SUBSYSTEM' => 'Amazon',
			'MARKETPLACEID' => $order['mpID'],
			'DATA' => array (
				array (
					'AmazonOrderID' => $order['data']['AmazonOrderID'],
				)
			)
		);
	}
	/*/
	else {
		echo 'Do nothing';
		echo var_dump_pre($cancelledState, '$cancelledState');
		echo var_dump_pre($shippedState, 'shippedState');
	}
	//*/

	if ($request === false) return '';
	#echo print_m($request);
	/*
	$result = array('BatchIDs' => array('1234768'));
	/*/
	if ($oStatAutoSync) {
		if ($newState == $shippedState) {
			unset($request['DATA'][0]['AmazonOrderID']);
			$order['internaldata']['Request'] = array (
				'Action' => $request['ACTION'],
				'Data' => $request['DATA'][0],
			);
		} else {
			$order['internaldata']['Request'] = array (
				'Action' => $request['ACTION']
			);
		}
		magnaAmazonSaveTrackingCode3rdParty($order['orders_id'], $trackercode, $mpID);
		magnaSaveOrder($order);
		return '';
	}

	try {
		$result = MagnaConnector::gi()->submitRequest($request);
		# $result['BatchIDs'] = array('1234768');
	} catch (MagnaException $e) {
		$result = array();
	}
	//*/

	if (!isset($result['DATA'][0])) {
		return '';
	}

	foreach ($result['DATA'] as $cData) {
		if ($order['data']['AmazonOrderID'] != $cData['AmazonOrderID']) continue;
		if ($newState == $shippedState) {
			$order['data']['ML_LABEL_SHIPPING_DATE'] = date('Y-m-d H:i:s');
			$order['data']['ML_LABEL_TRACKINGCODE'] = $trackercode;
			$order['data']['ML_LABEL_CARRIER'] = $carrier;
			magnaAmazonSaveTrackingCode3rdParty($order['orders_id'], $trackercode, $order['mpID']);
		} else if ($newState == $cancelledState) {
			$order['data']['ML_LABEL_ORDER_CANCELLED'] = date('Y-m-d H:i:s');
		}
		$order['data']['ML_AMAZON_LABEL_BATCHID'] = $cData['BatchID'];
		$order['orders_status'] = $newState;
		magnaSaveOrder($order);
	}
}

function amazonProcessMultiOrderStatus($args) {
/*
	echo var_export_pre($args, '$args');
	echo var_export_pre($_GET, '$_GET');
	echo var_export_pre($_POST, '$_POST');
*/
	$args['orders'] = array_values($args['orders']);
	$mpID = $args['orders'][0]['mpID'];
	$mp = $args['orders'][0]['platform'];

	$cancelledState = getDBConfigValue($mp.'.orderstatus.cancelled', $mpID, false);
	$shippedState = getDBConfigValue($mp.'.orderstatus.shipped', $mpID, false);
/*
	echo var_dump_pre($cancelledState, '$cancelledState');
	echo var_dump_pre($shippedState, '$shippedState');
	echo var_dump_pre($args['status'], '$args[status]');
*/
#	$args['status'] = '99';

	$oStatAutoSync = getDBConfigValue($mp.'.orderstatus.sync', $mpID, 'auto') == 'auto';

	$request = false;
	$preparedOrders = array();
	if ($args['status'] == $shippedState) {
		$trackercode = (
			array_key_exists('magna', $_POST) 
			&& array_key_exists('trackingcode', $_POST['magna']) 
			&& !eempty(trim($_POST['magna']['trackingcode']))
				? trim($_POST['magna']['trackingcode'])
				: ''
		);
		$carrier = (
			array_key_exists('magna', $_POST) 
			&& array_key_exists('carriercode', $_POST['magna']) 
			&& !eempty(trim($_POST['magna']['carriercode']))
			&& !($_POST['magna']['carriercode'] == 'null')
				? trim($_POST['magna']['carriercode'])
				: ''
		);
		$request = array (
			'ACTION' => 'ConfirmShipment',
			'SUBSYSTEM' => 'Amazon',
			'MARKETPLACEID' => $mpID,
			'DATA' => array (),
		);
		foreach ($args['orders'] as $o) {
			$r = array (
				'ShippingDate' => gmdate('Y-m-d'),
				'Carrier' => $carrier,
				'TrackingCode' => $trackercode
			);
			if ($oStatAutoSync) {
				$o['internaldata']['Request'] = array (
					'Action' => $request['ACTION'],
					'Data' => $r
				);
				magnaSaveOrder($o);
				magnaAmazonSaveTrackingCode3rdParty($o['orders_id'], $trackercode, $mpID);
			} else {
				$r['AmazonOrderID'] = $o['data']['AmazonOrderID'];
				$request['DATA'][] = $r;
				$preparedOrders[$o['data']['AmazonOrderID']] = &$o;
			}
		}

	} else if ($args['status'] == $cancelledState) {
		$request = array (
			'ACTION' => 'CancelShipment',
			'SUBSYSTEM' => 'Amazon',
			'MARKETPLACEID' => $mpID,
			'DATA' => array (),
		);
		foreach ($args['orders'] as $o) {
			if ($oStatAutoSync) {
				$o['internaldata']['Request'] = array (
					'Action' => $request['ACTION']
				);
				magnaSaveOrder($o);
			} else {
				$request['DATA'][] = array (
					'AmazonOrderID' => $o['data']['AmazonOrderID'],
				);
				$preparedOrders[$o['data']['AmazonOrderID']] = &$o;	
			}
		}
	}

	if ($request === false) return '';
	#echo print_m($request);

	if ($oStatAutoSync) {
		return '';
	}

	/*
	$result = array('BatchIDs' => '');
	/*/
	try {
		$result = MagnaConnector::gi()->submitRequest($request);
		# $result['BatchIDs'] = array('1234768');
	} catch (MagnaException $e) {
		$result = array();
	}
	//*/

	if (!isset($result['DATA'][0])) {
		return '';
	}

	foreach ($result['DATA'] as $cData) {
		if (!isset($preparedOrders[$cData['AmazonOrderID']])) continue;
		$o = &$preparedOrders[$cData['AmazonOrderID']];
		if ($args['status'] == $shippedState) {
			$o['data']['ML_LABEL_SHIPPING_DATE'] = date('Y-m-d H:i:s');
			$o['data']['ML_LABEL_TRACKINGCODE'] = $trackercode;
			$o['data']['ML_LABEL_CARRIER'] = $carrier;
			magnaAmazonSaveTrackingCode3rdParty($o['orders_id'], $trackercode, $o['mpID']);
		} else if ($args['status'] == $cancelledState) {
			$o['data']['ML_LABEL_ORDER_CANCELLED'] = date('Y-m-d H:i:s');
		}
		$o['data']['ML_AMAZON_LABEL_BATCHID'] = $cData['BatchID'];
		$o['orders_status'] = $args['status'];
		#echo print_m($o, '$o');
		magnaSaveOrder($o);
	}
	#die();
}

function magnaAmazonFetchTrackingCode3rdParty($oID, $mpID) {
	$table = getDBConfigValue('amazon.orderstatus.carrier.trackingcode.table', $mpID, false);
	if (($table === false) || empty($table['column']) || empty($table['table'])) return '';
	$cIDAlias = getDBConfigValue('amazon.orderstatus.carrier.trackingcode.alias', $mpID);
	if (empty($cIDAlias)) {
		$cIDAlias = 'orders_id';
	}
	return (string)MagnaDB::gi()->fetchOne('
		SELECT `'.$table['column'].'` 
		  FROM `'.$table['table'].'` 
		 WHERE `'.$cIDAlias.'`=\''.MagnaDB::gi()->escape($oID).'\'
	');
}

function magnaAmazonSaveTrackingCode3rdParty($oID, $tc, $mpID) {
	$table = getDBConfigValue('amazon.orderstatus.carrier.trackingcode.table', $mpID, false);
	if ($table === false || empty($table['column']) || empty($table['table'])) return;
	$cIDAlias = getDBConfigValue('amazon.orderstatus.carrier.trackingcode.alias', $mpID);
	if (empty($cIDAlias)) {
		$cIDAlias = 'orders_id';
	}
	MagnaDB::gi()->update($table['table'], array (
		$table['column'] => trim($tc),
	), array (
		$cIDAlias => $oID,
	));
}

function autoupdateAmazonOrdersStatus($mpID) {
	$mp = 'amazon';
	if (getDBConfigValue($mp.'.orderstatus.sync', $mpID, 'no') != 'auto') {
		return false;
	}
	$orders = MagnaDB::gi()->fetchArray(eecho('
	    SELECT mo.orders_id, mo.orders_status, mo.data, mo.internaldata, 
	           o.orders_status AS orders_status_shop
	      FROM `'.TABLE_MAGNA_ORDERS.'` mo, `'.TABLE_ORDERS.'` o
	     WHERE mo.orders_id=o.orders_id
	           AND mo.mpID=\''.$mpID.'\'
	           AND mo.orders_status<>o.orders_status
	', function_exists('ml_debug_out')));
	if (function_exists('ml_debug_out')) ml_debug_out(print_m($orders, '$orders'));
	if (empty($orders)) return true;

	$mp = 'amazon';
	$cancelledState = getDBConfigValue($mp.'.orderstatus.cancelled', $mpID, false);
	$shippedState = getDBConfigValue($mp.'.orderstatus.shipped', $mpID, false);
	
	$carrier = getDBConfigValue($mp.'.orderstatus.carrier.default', $mpID, '');

	$confirmations = array();
	$cancellations = array();
	$unprocessed = array();

	$preparedOrders = array();

	foreach ($orders as $key => &$order) {
		$order['data'] = @unserialize($order['data']);
		if (!is_array($order['data'])) {
			$order['data'] = array();
		}
		$order['internaldata'] = @unserialize($order['internaldata']);
		if (!is_array($order['internaldata'])) {
			$order['internaldata'] = array();
		}
		
		$status = $order['orders_status_shop'];
		unset($order['orders_status_shop']);

		if (($status != $shippedState) && ($status != $cancelledState)) {
			$unprocessed[] = $order['orders_id'];
			unset($orders[$key]);
			$order['orders_status'] = $status;
			continue;
		}

		$date = MagnaDB::gi()->fetchOne('
		    SELECT date_added FROM `'.TABLE_ORDERS_STATUS_HISTORY.'`
		     WHERE orders_id='.$order['orders_id'].'
		           AND orders_status_id='.$status.'
		  ORDER BY date_added DESC
		     LIMIT 1
		');

		if ($date === false) {
			$date = date('Y-m-d');
		} else {
			$date = date('Y-m-d', strtotime($date));
		}

		if ($status == $shippedState) {
			$trackercode = magnaAmazonFetchTrackingCode3rdParty($order['orders_id'], $mpID);
			if (isset($order['internaldata']['Request']['Data'])) {
				$cfirm = $order['internaldata']['Request']['Data'];
				$cfirm['AmazonOrderID'] = $order['data']['AmazonOrderID'];
				unset($order['internaldata']['Request']);
			} else {
				$cfirm = array (
					'AmazonOrderID' => $order['data']['AmazonOrderID'],
					'ShippingDate' => $date,
					'Carrier' => $carrier,
					'TrackingCode' => $trackercode
				);
			}
			$confirmations[] = $cfirm;
			$order['data']['ML_LABEL_SHIPPING_DATE'] = $cfirm['ShippingDate'];
			if (!empty($cfirm['TrackingCode'])) {
				$order['data']['ML_LABEL_TRACKINGCODE'] = $cfirm['TrackingCode'];
			}
			$order['data']['ML_LABEL_CARRIER'] = $carrier;
		} else if ($status == $cancelledState) {
			if (isset($order['internaldata']['Request'])) {
				unset($order['internaldata']['Request']);
			}
			$cancellations[] = array (
				'AmazonOrderID' => $order['data']['AmazonOrderID'],
			);
			$order['data']['ML_LABEL_ORDER_CANCELLED'] = $date;
		}
		$order['orders_tmp_status'] = $status;
		//$order['internaldata'] = serialize($order['internaldata']);
		$preparedOrders[$order['data']['AmazonOrderID']] = &$order;
	}
	$confirmedOrders = array();
	$cancelledOrders = array();
	
	$successfullySubmittedOrders = array();
	if (!empty($confirmations)) {
		$request = array (
			'ACTION' => 'ConfirmShipment',
			'SUBSYSTEM' => 'Amazon',
			'MARKETPLACEID' => $mpID,
			'DATA' => $confirmations,
		);
		if (defined('MAGNA_ECHO_UPDATE') && MAGNA_ECHO_UPDATE) {
			ml_debug_out(print_m($request, 'confirmations'));
		} else {
			try {
				$result = MagnaConnector::gi()->submitRequest($request);
			} catch (MagnaException $e) {
				$result = array();
			}
			#echo print_m($result, 'confirmations response');
			if (isset($result['DATA'][0])) {
				foreach ($result['DATA'] as $cData) {
					if (!isset($preparedOrders[$cData['AmazonOrderID']])) continue;
					$tO = &$preparedOrders[$cData['AmazonOrderID']];
					$tO['orders_status'] = $tO['orders_tmp_status'];
					unset($tO['orders_tmp_status']);
					$tO['data']['ML_AMAZON_LABEL_BATCHID'] = $cData['BatchID'];
					$successfullySubmittedOrders[$cData['AmazonOrderID']] = &$tO;
				}
			}
		}
	}

	if (!empty($cancellations)) {
		$request = array (
			'ACTION' => 'CancelShipment',
			'SUBSYSTEM' => 'Amazon',
			'MARKETPLACEID' => $mpID,
			'DATA' => $cancellations,
		);
		if (defined('MAGNA_ECHO_UPDATE') && MAGNA_ECHO_UPDATE) {
			ml_debug_out(print_m($request, 'cancellations'));
		} else {
			try {
				$result = MagnaConnector::gi()->submitRequest($request);
			} catch (MagnaException $e) {
				$result = array();
			}
			#echo print_m($result, 'cancellations response');
			if (isset($result['DATA'][0])) {
				foreach ($result['DATA'] as $cData) {
					if (!isset($preparedOrders[$cData['AmazonOrderID']])) continue;
					$tO = &$preparedOrders[$cData['AmazonOrderID']];
					$tO['orders_status'] = $tO['orders_tmp_status'];
					unset($tO['orders_tmp_status']);
					$tO['data']['ML_AMAZON_LABEL_BATCHID'] = $cData['BatchID'];
					$successfullySubmittedOrders[$cData['AmazonOrderID']] = &$tO;
				}
			}
		}
	}
	
	if (!empty($unprocessed)) {
		MagnaDB::gi()->query("
			UPDATE `".TABLE_MAGNA_ORDERS."` mo, `".TABLE_ORDERS."` o 
			   SET mo.orders_status=o.orders_status
		     WHERE mo.orders_id=o.orders_id
		           AND mo.orders_id IN ('".implode("', '", $unprocessed)."')
		");
		if (function_exists('ml_debug_out')) ml_debug_out(print_m($unprocessed, '$unprocessed'));
	}
	if (empty($successfullySubmittedOrders)) return true;
	foreach ($successfullySubmittedOrders as $o) {
		#echo print_m($o);
		$o['data'] = serialize($o['data']);
		$o['internaldata'] = serialize($o['internaldata']);
		//*
		MagnaDB::gi()->update(TABLE_MAGNA_ORDERS, $o, array(
			'orders_id' => $o['orders_id']
		));
		//*/
	}
	return true;
}
