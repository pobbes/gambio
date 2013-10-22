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
 * $Id: ebayFunctions.php 645 2010-12-21 20:09:08Z MaW $
 *
 * (c) 2010 RedGecko GmbH -- http://www.redgecko.de
 *     Released under the GNU General Public License v2 or later
 * -----------------------------------------------------------------------------
 */

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

require_once(DIR_MAGNALISTER_INCLUDES.'lib/classes/SimplePrice.php');

# eBay gibt GMT-Zeit zurueck,
# Format wie '2011-01-07T22:07:23.174Z',
# mache universellen Unix Timestamp daraus
function eBayTimeToTs($eBayTime) {
	return gmmktime(
		substr($eBayTime, 11,2), substr($eBayTime, 14,2), substr($eBayTime, 17,2),
		substr($eBayTime, 5,2),  substr($eBayTime, 8,2),  substr($eBayTime, 0,4)
	);
}

function autoupdateEbayInventory($mpID, $offset = 0, $limit = 100) {
	global $_MagnaSession;
	$_MagnaSession['mpID'] = $mpID;
	$_MagnaSession['currentPlatform'] = 'ebay';
	$tomarketplace  = getDBConfigValue('ebay.stocksync.tomarketplace', $mpID, null) == 'auto';
	$tomarketplaceC = getDBConfigValue('ebay.chinese.stocksync.tomarketplace', $mpID, null) == 'auto';
	$syncPrice  = getDBConfigValue('ebay.inventorysync.price', $mpID, null) == 'auto';
	$syncPriceC = getDBConfigValue('ebay.chinese.inventorysync.price', $mpID, null) == 'auto';

	if (function_exists('ml_debug_out')) {
		ml_debug_out("\n".'tomarketplace: '.($tomarketplace ? 'true' : 'false')." \t");
		ml_debug_out('tomarketplaceC: '.($tomarketplaceC ? 'true' : 'false')." \t");
		ml_debug_out('!(tomarketplace || tomarketplaceC): '.(!($tomarketplace || $tomarketplaceC) ? 'true' : 'false')."\n");
	}
	if (!($tomarketplace || $tomarketplaceC || $syncPrice || $syncPriceC)) {
		//if (function_exists('ml_debug_out')) ml_debug_out($mpID.' (ebay): no autosync'."\n");
		return true;
	}
	// return;

	try {
		$result = MagnaConnector::gi()->submitRequest(array(
			'ACTION' => 'GetInventory',
			'SUBSYSTEM' => 'eBay',
			'MARKETPLACEID' => $mpID,
			'LIMIT' => $limit,
			'OFFSET' => $offset,
			'ORDERBY' => 'DateAdded',
			'SORTORDER' => 'DESC'
		));
	} catch (MagnaException $e) {
		if (function_exists('ml_debug_out')) echo print_m($e->getErrorArray(), '$error ['.$e->getMessage().']');
		return false;
	}


	if (!empty($result['DATA'])) {
		$quantityType = getDBConfigValue('ebay.fixed.quantity.type', $mpID, '');
		$sub = 0;
		if ($quantityType == 'stocksub') {
			$sub = getDBConfigValue('ebay.fixed.quantity.value', $mpID, 0);
		}
		$chineseQuantityType = getDBConfigValue('ebay.chinese.quantity.type', $mpID, '');
		$chineseSub = 0;
		if ($chineseQuantityType == 'stocksub') {
			$chineseSub = getDBConfigValue('ebay.chinese.quantity.value', $mpID, 0);
		}

		# Bei Varianten kommt dieselbe ItemID mehrmals zurueck,
		# sollte aber nur einmal upgedatet werden
        $ItemsProcessed = array();
        $VariationsForItemCalculated = array();
        $totalQuantityForItemCalculated =array();

		foreach ($result['DATA'] as $item) {
            $currId = $item['ItemID'];
            if (in_array($currId, $ItemsProcessed)) continue;
			@set_time_limit(180);
			$pID = magnaSKU2pID($item['SKU']);
			if (0 == $pID) {
				if (function_exists('ml_debug_out')) ml_debug_out("\n".'SKU: '.$item['SKU'].' pID: '.$pID."\n");
            	continue; # nicht plattmachen wenn nicht gefunden
            }
            # Varianten neu berechnen bevor man Anzahl berechnet
	        if (MagnaDB::gi()->tableExists(TABLE_MAGNA_VARIATIONS)
                 && !in_array($currId, $VariationsForItemCalculated)) {
	            setProductVariations($pID, getDBConfigValue('ebay.lang', $_MagnaSession['mpID'], false));
                $VariationsForItemCalculated[] = $currId;
            }
			if (!isset($totalQuantityForItemCalculated[$currId])) {
                $currMainQty = makeQuantity($pID, $item['ListingType']);
                $totalQuantityForItemCalculated[$currId] = $currMainQty;
            } else {
			    $currMainQty = $totalQuantityForItemCalculated[$currId];
            }
            # ist es eine Variante?
            $currVarQty = makeVariationQuantity($pID, $item['SKU']);
            # Preis bestimmen (falls Preis-Synchro eingeschaltet)
            if ($syncPrice) {
                # schauen ob Preis eingefroren
                $priceFrozenQuery = '
                	SELECT Price FROM '.TABLE_MAGNA_EBAY_PROPERTIES.' 
                  		WHERE mpID = '.$mpID.' AND ';
                if ('artNr' == getDBConfigValue('general.keytype', '0')) {
                 	$priceFrozenQuery .= ' products_model = \''.magnaPID2SKU($pID, true).'\'';
                } else {
                   	$priceFrozenQuery .= ' products_id = '.$pID;
                }
                $priceFrozen = MagnaDB::gi()->fetchOne($priceFrozenQuery);
                if (0.0 == $priceFrozen) $priceFrozen = false;
                if (false === $currVarQty)
                    $currPrice = makePrice($pID, $item['ListingType'], $priceFrozen);
                else
                    $currPrice = makeVariationPrice($pID, $item['SKU']);
            }
			# Bei 'Chinese' moegliche Option: eBay-Bestand nur reduzieren
			# d.h. wenn gewachsen, nichts tun
			if (('Chinese' == $item['ListingType'])
			    && ($item['Quantity'] < $currMainQty)
			    && ('onlydecr' == getDBConfigValue('ebay.chinese.stocksync.tomarketplace', $mpID, ''))
			) {
				
				continue;
			}
            /*
            Hier Bedingungen: Variation quantity & -price sowie Stammart. qu & pri
            */
            if (  (($tomarketplace && ('Chinese' != $item['ListingType']))
                   && (   ((false !== $currVarQty) && ($item['Quantity'] != $currVarQty))
                       || ((false === $currVarQty) && ($item['Quantity'] != $currMainQty))))
                ||(($tomarketplaceC && ('Chinese' == $item['ListingType']))
                   && ($item['Quantity'] != $currMainQty))
                ||(($syncPrice && (!$priceFrozen) && ('Chinese' != $item['ListingType']))
                   && (($item['Price'] != $currPrice)))
                ||(($syncPriceC && (!$priceFrozen) && ('Chinese' == $item['ListingType']))
                   && (($item['Price'] != $currPrice)))
            ) {
                if ('Chinese' != $item['ListingType']) {
                    # getVariations mit set == false, schon neu gesetzt
                    $variationMatrix = getVariations($pID, null, false, $syncPrice && !$priceFrozen);
                }
                if (!isset($variationMatrix)) $variationMatrix = false;
                $request = array(
					'ACTION' => 'UpdateQuantity',
					'SUBSYSTEM' => 'eBay',
					'MARKETPLACEID' => $mpID,
					'DATA' => array (
						'ItemID' => $item['ItemID'],
						'NewQuantity' => (int)$currMainQty,
                        'Variations' => $variationMatrix,
						'fixed.stocksync' => getDBConfigValue('ebay.stocksync.tomarketplace', $mpID, ''),
						'chinese.stocksync' => getDBConfigValue('ebay.chinese.stocksync.tomarketplace', $mpID, ''),
					),
				);
                if (   (  ($syncPrice && 'Chinese'  != $item['ListingType'])
                        ||($syncPriceC && 'Chinese' == $item['ListingType']))
                    && !$priceFrozen)
                    $request['DATA']['Price'] = $currPrice;
				if (function_exists('ml_debug_out')) echo '$request: '.json_indent($request)."\n";
				try {
					$updateCall = MagnaConnector::gi()->submitRequest($request);
				} catch (MagnaException $e) {
					if (function_exists('ml_debug_out')) echo print_m($e->getErrorArray(), 'Exception');
				}
                $ItemsProcessed[] = $item['ItemID'];
			}
		}
		if (($offset + $limit) < $result['NUMBEROFLISTINGS']) {
			autoupdateEbayInventory($mpID, ($offset + $limit), $limit);
		}
	}
}

function updateEbayInventoryByEdit($mpID, $updateData) {
	$updateItem = genericInventoryUpdateByEdit($mpID, $updateData);	
	if (!is_array($updateItem)) {
		return false;
	}
    $pID = array_first(array_keys($updateData));
    #$updateData[$pID]['Variations'] = array('Variations' => getVariations($pID));

	$requestMode = ('SET' == $updateItem['NewQuantity']['Mode'])? 'NewQuantity':'AddQuantity';
	$QtyToSubmit = ('SUB' == $updateItem['NewQuantity']['Mode'])? -1 * $updateItem['NewQuantity']['Value']: $updateItem['NewQuantity']['Value'];
	$updateData = array(
		'SKU' => $updateItem['SKU'],
		"$requestMode" => (int)$QtyToSubmit,
		'fixed.stocksync' => getDBConfigValue('ebay.stocksync.tomarketplace', $mpID, ''),
		'chinese.stocksync' => getDBConfigValue('ebay.chinese.stocksync.tomarketplace', $mpID, ''),
	);
	$request = array(
		'ACTION' => 'UpdateQuantity',
		'SUBSYSTEM' => 'eBay',
		'MARKETPLACEID' => $mpID,
		'DATA' => $updateData
	);

	if (defined('MAGNA_ECHO_UPDATE') && MAGNA_ECHO_UPDATE) {
		echo print_m($request, __FUNCTION__);
		return true;
	}

	try {
		$result = MagnaConnector::gi()->submitRequest($request);
		#echo print_m($result, '$result');
	} catch (MagnaException $e) {
		if ($e->getCode() == MagnaException::TIMEOUT) {
			$e->saveRequest();
			$e->setCriticalStatus(false);
		}
		#echo print_m($e->getErrorArray(), '$error');
	}
}

function updateEbayInventoryByOrder($mpID, $boughtItems, $subRelQuant = true) {
	global $_MagnaSession;
    if (!isset($_MagnaSession) || !is_array($_MagnaSession)) {
        $_MagnaSession = array('mpID' => $mpID);
    } else if (!isset($_MagnaSession['mpID'])) {
        $_MagnaSession['mpID'] = $mpID;
    }
	$ess = getDBConfigValue('ebay.stocksync.tomarketplace', $mpID, 'no');
	$ecss = getDBConfigValue('ebay.chinese.stocksync.tomarketplace', $mpID, 'no');
	$syncPrice = getDBConfigValue('ebay.inventorysync.price', $mpID, null) == 'auto';
	$syncPriceC = getDBConfigValue('ebay.chinese.inventorysync.price', $mpID, null) == 'auto';

	if (($ess == 'no') && ($ecss == 'no')) {
		return;
	}
	$data = genericInventoryUpdateByOrder($mpID, $boughtItems, $subRelQuant);
	foreach($data as $i => $updateItem) {
		$requestMode = ('SET' == $updateItem['NewQuantity']['Mode'])? 'NewQuantity':'AddQuantity';
		$QtyToSubmit = ('SUB' == $updateItem['NewQuantity']['Mode'])? -1 * $updateItem['NewQuantity']['Value']: $updateItem['NewQuantity']['Value'];
		$updateData = array(
			'SKU' => $updateItem['SKU'],
			"$requestMode" => (int)$QtyToSubmit,
			'fixed.stocksync' => $ess,
			'chinese.stocksync' => $ecss,
		);
        $pID = magnaSKU2pID($updateItem['SKU'], true);
        # schauen ob Preis eingefroren
        $priceFrozenQuery = 'SELECT Price FROM '.TABLE_MAGNA_EBAY_PROPERTIES
                    .' WHERE mpID = '.$mpID.' AND ';
        if ('artNr' == getDBConfigValue('general.keytype', '0'))
                    $priceFrozenQuery .= ' products_model = \''.$updateItem['SKU'].'\'';
        else
                    $priceFrozenQuery .= ' products_id = '.$pID;
        $priceFrozen = MagnaDB::gi()->fetchOne($priceFrozenQuery);
        if(0.0 == $priceFrozen) $priceFrozen = false;
        $variationMatrix = getVariations($pID, null, true, $syncPrice && !$priceFrozen);
        $totalQuantity = makeQuantity($pID);
        if (false != $variationMatrix) {
            # mode ist immer SUB (kommt so aus magnaInventoryUpdateByOrder)
            setVariationQuantity($variationMatrix, $pID, $updateItem['Attributes'], $boughtItems[$i]['NewQuantity']['Value'], 'SUB');
            # wenn Variantions da, hat Anzahl keine Bedeutung, entscheidend ist die variationMatrix
            # es darf dann aber nicht sein dass 0 uebergeben wird, denn das wuerde EndItem ausloesen
            unset($updateData["$requestMode"]);
            $updateData['NewQuantity'] = (int)$totalQuantity;
        }
		$updateData['Variations'] = $variationMatrix;
		try {
			$request = array(
				'ACTION' => 'UpdateQuantity',
				'SUBSYSTEM' => 'eBay',
				'MARKETPLACEID' => $mpID,
				'DATA' => $updateData,
			);
			if (defined('MAGNA_ECHO_UPDATE') && MAGNA_ECHO_UPDATE) {
				echo print_m($request, __FUNCTION__);
			} else {
				$result = MagnaConnector::gi()->submitRequest($request);
				#echo print_m($result, '$result');
			}
		} catch (MagnaException $e) {
			/* don't show errors for now. should be saved in the errorlog instead. */
			$e->setCriticalStatus(false);
			/* Do NOT save the request incase of timeout. Since this is a synchronous
			 * call to ebay it may take up to 9 seconds before we receive a reply.
			 * The reply isn't important anyway (as it isn't processed anyway) so no need
			 * to repeat the request later on.
			 */
			/*
			if ($e->getCode() == MagnaException::TIMEOUT) {
				$e->saveRequest();
			}
			*/
			#echo print_m($e->getErrorArray(), '$error');
		}
	}
}

function geteBayShippingDetails() {
	global $_MagnaSession;

	$mpID = $_MagnaSession['mpID'];
	$site = getDBConfigValue('ebay.site', $mpID);
	
	initArrayIfNecessary($_MagnaSession, array($mpID, $site, 'eBayShippingDetails'));
	
	if (!empty($_MagnaSession[$mpID][$site]['eBayShippingDetails'])) {
		return $_MagnaSession[$mpID][$site]['eBayShippingDetails'];
	}
	try {
		$shippingDetails = MagnaConnector::gi()->submitRequest(array(
			'ACTION' => 'GetShippingServiceDetails'
		));
		$shippingDetails = $shippingDetails['DATA'];
	} catch (MagnaException $e) {
		return false;
	}
	unset($shippingDetails['Version']);
	unset($shippingDetails['Timestamp']);
	unset($shippingDetails['Site']);
	foreach ($shippingDetails['ShippingServices'] as &$service) {
		$service['Description'] = fixHTMLUTF8Entities($service['Description']);
	}
	foreach ($shippingDetails['ShippingLocations'] as &$location) {
		$location = fixHTMLUTF8Entities($location);
	}
	$_MagnaSession[$mpID][$site]['eBayShippingDetails'] = $shippingDetails;
	return $_MagnaSession[$mpID][$site]['eBayShippingDetails'];
}

function geteBayShippingServicesList() {
	$shippingDetails = geteBayShippingDetails();
	$servicesList = array();
	return $servicesList;
}

function geteBayLocalShippingServicesList() {
	$shippingDetails = geteBayShippingDetails();
	$servicesList = array();
	foreach($shippingDetails['ShippingServices'] as $service=>$serviceData) {
		if ('1' == $serviceData['InternationalService']) continue;
	#	$servicesList["$service"] = utf8_decode($serviceData['Description']);
		$servicesList["$service"] = $serviceData['Description'];
	}
	return $servicesList;
}

function geteBayInternationalShippingServicesList() {
	$shippingDetails = geteBayShippingDetails();
	$servicesList = array('' => ML_EBAY_LABEL_NO_INTL_SHIPPING);
	foreach($shippingDetails['ShippingServices'] as $service=>$serviceData) {
		if ('0' == $serviceData['InternationalService']) continue;
	#	$servicesList["$service"] = utf8_decode($serviceData['Description']);
		$servicesList["$service"] = $serviceData['Description'];
	}
	return $servicesList;
}

function geteBayShippingLocationsList() {
	$shippingDetails = geteBayShippingDetails();
	return $shippingDetails['ShippingLocations'];
}

function geteBaySiteID() {
    global $_MagnaSession;
	$mpID = $_MagnaSession['mpID'];
    if (isset($_MagnaSession[$mpID]['SiteID']))
        return $_MagnaSession[$mpID]['SiteID'];
    try {
        $baseCall = MagnaConnector::gi()->submitRequest(array(
            'ACTION' => 'GeteBayOfficialTime'
        ));
    } catch (MagnaException $e) {
        return 77;
    }
    $_MagnaSession[$mpID]['SiteID'] = $baseCall['DATA']['SiteID'];
    return $_MagnaSession[$mpID]['SiteID'];
}

function geteBayPaymentOptions() {
	global $_MagnaSession;

	#echo print_m($_MagnaSession,'$_MagnaSession');

	$mpID = $_MagnaSession['mpID'];
	$site = getDBConfigValue('ebay.site', $mpID);

	#echo print_m($site,'$site');
	
	if(@isset($_MagnaSession[$mpID]['eBayPaymentOptions']['Site']) && 
		($_MagnaSession[$mpID]['eBayPaymentOptions']['Site'] == getDBConfigValue('ebay.site', $mpID, '999'))
	) { # 999 um keine falsche Gleichheit bei nicht gesetzten Werten zu bekommen
		return $_MagnaSession[$mpID][$site]['eBayPaymentOptions'];
	} else {
		try { $paymentOptions = MagnaConnector::gi()->submitRequest(array(
				'ACTION' => 'GetPaymentOptions'));
		} catch (MagnaException $e) {
			$paymentOptions = array(
				'DATA' => false
			);
		}
		if (!is_array($paymentOptions) || @empty($paymentOptions['DATA'])) {
			return false;
		}
		foreach ($paymentOptions['DATA']['PaymentOptions'] as &$option) {
			$option = fixHTMLUTF8Entities($option);
		}
	}
	$_MagnaSession[$mpID]['eBayPaymentOptions'] = $paymentOptions['DATA']['PaymentOptions'];
	return $paymentOptions['DATA']['PaymentOptions'];
}

function getEBayAttributes($cID, $mode, $preselectedValues = array()) {
	# erst schauen obs ItemSpecifics gibt (sind neuer & das andere ist uU deprecated)
	$itemSpecs = getEBayItemSpecifics($cID, $mode, $preselectedValues);
	if (!empty($itemSpecs)) return $itemSpecs;
	try {
		$attrOptions = MagnaConnector::gi()->submitRequest(array(
			'ACTION' => 'GetAttributes',
			'DATA' => array (
				'CategoryID' => $cID,
				'FormStructure' => true,
			)
		));
	} catch (MagnaException $e) {
		return '';
	}
	if (!array_key_exists('attributes', $attrOptions['DATA'])
		|| empty($attrOptions['DATA']['attributes'])
	) {
		#return getEBayItemSpecifics($cID, $mode, $preselectedValues);
		return '';
	}
	$attrOptions = $attrOptions['DATA'];
	$attrOptions['attributes']['key'] = array('Attributes', $mode);
	$attrOptions['attributes']['head'] = ML_EBAY_LABEL_ATTRIBUTES_FOR.' '.(($mode == 1) 
		? ML_LABEL_EBAY_PRIMARY_CATEGORY
		: ML_LABEL_EBAY_SECONDARY_CATEGORY
	);
	if (!is_array($preselectedValues)) {
		$preselectedValues = json_decode($preselectedValues, true);
	}
	require_once(DIR_MAGNALISTER_INCLUDES.'lib/classes/GenerateProductsDetailInput.php');
	if (!empty($preselectedValues))
		$gPDI = new GenerateProductsDetailInput($attrOptions, $preselectedValues);
	else
		$gPDI = new GenerateProductsDetailInput($attrOptions);
	return $gPDI->render();
}

function getEBayItemSpecifics($cID, $mode, $preselectedValues='') {
	try {
		$specsOptions = MagnaConnector::gi()->submitRequest(array(
			'ACTION' => 'GetItemSpecifics',
			'DATA' => array (
				'CategoryID' => $cID,
				'FormStructure' => true,
			)
		));
	} catch (MagnaException $e) {
		return '';
	}
	if (!array_key_exists('specifics', $specsOptions['DATA'])
		|| empty($specsOptions['DATA']['specifics'])
	) {
		return '';
	}
	$specsOptions = $specsOptions['DATA'];
	$specsOptions['specifics']['key'] = array('ItemSpecifics', $mode);
	$specsOptions['specifics']['head'] = ML_EBAY_LABEL_ATTRIBUTES_FOR.' '.(($mode == 1) 
		? ML_LABEL_EBAY_PRIMARY_CATEGORY
		: ML_LABEL_EBAY_SECONDARY_CATEGORY
	);
	if (!is_array($preselectedValues)) {
		$preselectedValues = json_decode($preselectedValues, true);
	}
	require_once(DIR_MAGNALISTER_INCLUDES.'lib/classes/GenerateProductsDetailInput.php');
	if (!empty($preselectedValues))
		$gPDI = new GenerateProductsDetailInput($specsOptions, $preselectedValues);
	else
		$gPDI = new GenerateProductsDetailInput($specsOptions);
	return $gPDI->render();
}

function VariationsEnabled($cID) {
    if (empty($cID)) return false;
	try {
		$VariationsEnabledResult = MagnaConnector::gi()->submitRequest(array(
			'ACTION' => 'VariationsEnabled',
			'DATA' => array ('CategoryID' => $cID),
		));
	} catch (MagnaException $e) {
		return false;
	}
	if (isset($VariationsEnabledResult['DATA']['VariationsEnabled'])
		&& ('true' == (string)$VariationsEnabledResult['DATA']['VariationsEnabled'])
	) {
		return true;
	}
	return false;
}

function substitutePictures($tmplStr, $pID, $imagePath) {
	# Tabelle nur bei xtCommerce- und Gambio- Shops vorhanden (nicht OsC)
	if (defined('TABLE_PRODUCTS_IMAGES') && MagnaDB::gi()->tableExists(TABLE_PRODUCTS_IMAGES) && 
		MagnaDB::gi()->columnExistsInTable('image_name', TABLE_PRODUCTS_IMAGES)
	) {
		$pics = MagnaDB::gi()->fetchArray('SELECT
			image_nr, image_name
			FROM '.TABLE_PRODUCTS_IMAGES.'
			WHERE products_id = '.$pID.'
            ORDER BY image_nr');
		$i = 2;
		# Ersetze #PICTURE2# usw. (#PICTURE1# ist das Hauptbild und wird vorher ersetzt)
		foreach($pics as $pic) {
			$tmplStr = str_replace('#PICTURE'.$i.'#', "<img src=\"".$imagePath.$pic['image_name']."\" style=\"border:0;\" alt=\"\" title=\"\" />",
				 preg_replace( '/(src|SRC|href|HREF)(\s*=\s*)(\'|")(#PICTURE'.$i.'#)/', '\1\2\3'.$imagePath.$pic['image_name'], $tmplStr));
			$i++;
		}
		# Uebriggebliebene #PICTUREx# loeschen
        $str = preg_replace('/#PICTURE\d+#/','',
            preg_replace('/<[^<]*(src|SRC|href|HREF)\s*=\s*(\'|")#PICTURE\d+#(\'|")[^>]*\/*>/','',$tmplStr));
	} else {
        $str = preg_replace('/#PICTURE\d+#/','',
            preg_replace('/<[^<]*(src|SRC|href|HREF)\s*=\s*(\'|")#PICTURE\d+#(\'|")[^>]*\/*>/','',$tmplStr));
	}
	return $str;
}

# Hilfsfunktion: Preis bestimmen
# priceType: == ListingType oder BuyItNowPrice
function makePrice($pID, $priceType, $takePrepared=false, $variationPrice = 0.0) {
	global $_MagnaSession;
	if ($takePrepared) {

		if ('artNr' == getDBConfigValue('general.keytype', '0')) {
			$preparedPriceQuery = 'SELECT '
			.('BuyItNowPrice' == $priceType? 'ep.BuyItNowPrice':'ep.Price').' AS Price '
			.' FROM '.TABLE_MAGNA_EBAY_PROPERTIES .' ep, '. TABLE_PRODUCTS .' p '
			.' WHERE ep.products_model = p.products_model AND p.products_id = '.$pID
			.' AND ep.mpID = '. $_MagnaSession['mpID']
			.' LIMIT 1';
		} else {
			$preparedPriceQuery = 'SELECT '
			.('BuyItNowPrice' == $priceType? 'BuyItNowPrice':'Price').' AS Price '
			.' FROM '.TABLE_MAGNA_EBAY_PROPERTIES
			.' WHERE products_id = '.$pID.' AND mpID = '. $_MagnaSession['mpID']
			.' LIMIT 1';
		}
		$preparedPriceRow = MagnaDB::gi()->fetchArray($preparedPriceQuery);
		if (1 == MagnaDB::gi()->numRows()) return($preparedPriceRow[0]['Price']);
	}
	require_once(DIR_MAGNALISTER_INCLUDES.'lib/classes/SimplePrice.php');
	switch ($priceType) {
		case 'Chinese': {
			$which = 'chinese';
			break;
		}
		case 'BuyItNowPrice': {
			$which = 'chinese.buyitnow';
			break;
		}
		default: { # 'FixedPriceItem' oder 'StoresFixedPrice'
			$which = 'fixed';
			break;
		}
	}
	$myPrice = new SimplePrice(null,getCurrencyFromMarketplace($_MagnaSession['mpID']));
	if ($variationPrice) 
		$myPrice->setPriceFromDB($pID, $_MagnaSession['mpID'], $which)->addLump($variationPrice)->finalizePrice($pID, $_MagnaSession['mpID'], $which);
	else
		$myPrice->setFinalPriceFromDB($pID, $_MagnaSession['mpID'], $which);
	return $myPrice->getPrice();
}

# Hilfsfunktion: Variation-Preis zu einem Grundpreis berechnen
# (benoetigt wenn Grundpreis per Hand geaendert)
# Grundpreis ist brutto, Varianten-Aufschlaege netto, daher kann man nicht einfach addieren
function addVarPriceToPrice($pID, $mainPrice, $varPrice) {
	global $_MagnaSession;
	$myPrice = new SimplePrice($mainPrice, getCurrencyFromMarketplace($_MagnaSession['mpID']));
	$myPrice->removeTaxByPID($pID)->addLump($varPrice)->addTaxByPID($pID);
	return $myPrice->getPrice();
}

function makeVariationPrice($pID,  $variation_products_model, $otherMainPrice = false) {
    global $_MagnaSession;
    $dbVarPrice = MagnaDB::gi()->fetchOne('SELECT variation_price FROM '.TABLE_MAGNA_VARIATIONS
                    .' WHERE products_id = '.$pID
                    .' AND variation_products_model = \''.$variation_products_model.'\'');
    if (false === $dbVarPrice) return false;
    if (!$otherMainPrice)
        return makePrice($pID, 'fixed', false, (float)$dbVarPrice);
    else
        return addVarPriceToPrice($pID, $otherMainPrice, (float)$dbVarPrice);
}

# Hilfsfunktion: Anzahl bestimmen
function makeQuantity($pID, $ListingType = 'StoresFixedPrice') {
	global $_MagnaSession;
	switch ($ListingType) {
		case 'Chinese': {
			$qType  = 'ebay.chinese.quantity.type';
			$qValue = 'ebay.chinese.quantity.value';
			break;
		}
		default: { # 'FixedPriceItem' oder 'StoresFixedPrice'
			$qType  = 'ebay.fixed.quantity.type';
			$qValue = 'ebay.fixed.quantity.value';
			break;
		}
	}
	$calc_method = getDBConfigValue($qType, $_MagnaSession['mpID']);
	if ('lump' == $calc_method) {
		return getDBConfigValue($qValue, $_MagnaSession['mpID']);
	}
	$shop_stock = 0;
	# Nehme Anzahl Varianten, soweit Varianten lt konfig aktiviert, und soweit solche existieren
	if (('Chinese' != $ListingType) && getDBConfigValue(array($_MagnaSession['currentPlatform'].'.usevariations', 'val'), $_MagnaSession['mpID'], true) && variationsExist($pID)) {
        if ('stock' == $calc_method)
		    $shop_stock = getProductVariationsQuantity($pID);
        else if ('stocksub' == $calc_method)
		    $shop_stock = getProductVariationsQuantity($pID, getDBConfigValue($qValue, $_MagnaSession['mpID']));
            return $shop_stock;
    }
    # Keine Varianten da, nehme Stammartikel
		$shop_stock = MagnaDB::gi()->fetchOne('SELECT products_quantity FROM '.TABLE_PRODUCTS.' WHERE products_id ='.$pID);
	if ('stock' == $calc_method) {
		return $shop_stock;
	} else if ('stocksub' == $calc_method) {
		return max(0, $shop_stock - getDBConfigValue($qValue, $_MagnaSession['mpID']));
	} else {
		return 0;
	}
}

# Hilfsfunktion: Anzahl einer einzelnen Variante
function makeVariationQuantity($pID, $variation_products_model) {
    global $_MagnaSession;
    $dbQuantity = MagnaDB::gi()->fetchOne('SELECT variation_quantity FROM '.TABLE_MAGNA_VARIATIONS
                    .' WHERE products_id = '.$pID
                    .' AND variation_products_model = \''.$variation_products_model.'\'');
    if (false     === $dbQuantity)  return false;
    $calc_method = getDBConfigValue('ebay.fixed.quantity.type', $_MagnaSession['mpID']);
    if ('stock'    == $calc_method) return (int)$dbQuantity;
    $calc_val = getDBConfigValue('ebay.fixed.quantity.value', $_MagnaSession['mpID']);
    if ('lump'     == $calc_method) return (int)$calc_val;
    if ('stocksub' == $calc_method) return (int)($dbQuantity - $calc_val);
}

# Hilfsfunktion: Varianten-Matrix fuer die Einstellung aufbauen
function getVariations($pID, $otherMainPrice = null, $set = true, $withPrices = true) {
	global $_MagnaSession;
    if (false == getDBConfigValue(array('ebay.usevariations', 'val'), $_MagnaSession['mpID'], true))
        return false;
	$variations = array();
	$namelist   = array();
	$valuelist   = array();
	if (!MagnaDB::gi()->tableExists(TABLE_MAGNA_VARIATIONS)) return false;
	if ($set) setProductVariations($pID, getDBConfigValue('ebay.lang', $_MagnaSession['mpID'], false));
	if (0 == MagnaDB::gi()->fetchOne('SELECT count(*) FROM '.TABLE_MAGNA_VARIATIONS.' WHERE products_id ='.$pID)) return false;
	# Anzahl-Settings
	$qType  = getDBConfigValue('ebay.fixed.quantity.type', $_MagnaSession['mpID']);
	$qValue = getDBConfigValue('ebay.fixed.quantity.value', $_MagnaSession['mpID']);
	$variations_data = MagnaDB::gi()->fetchArray('
		SELECT variation_products_model, variation_attributes, variation_quantity, variation_price 
		  FROM '.TABLE_MAGNA_VARIATIONS.'
		 WHERE products_id ='.$pID
	);
	# VariationsCalculator ermittelt bei der Initialisierung die Namen der Attribute und Werte
	require_once(DIR_MAGNALISTER_INCLUDES.'lib/classes/VariationsCalculator.php');
	$vc = new VariationsCalculator(array(), getDBConfigValue('ebay.lang', $_MagnaSession['mpID'], false));
	# Einzelne Varianten
	foreach ($variations_data as $k => $dataRow) {
		# Quantity
		if ('lump' == $qType) $variations['Variations'][$k]['Quantity'] = intval($qValue);
		else if ('stock' == $qType) $variations['Variations'][$k]['Quantity'] = intval($dataRow['variation_quantity']);
		else if ('stocksub' == $qType) $variations['Variations'][$k]['Quantity'] = intval($dataRow['variation_quantity'] - $qValue);
		if ($variations['Variations'][$k]['Quantity'] < 0) {
            $variations['Variations'][$k]['Quantity'] = 0;
			#unset($variations['Variations'][$k]);
			#continue;
		}
		# SKU
		$variations['Variations'][$k]['SKU'] = $dataRow['variation_products_model'];
        if ($withPrices) {
		    # Preis
		    if (! $otherMainPrice)
			    $variations['Variations'][$k]['StartPrice'] = makePrice($pID, 'fixed', false, (float)$dataRow['variation_price']);
		    else
			    $variations['Variations'][$k]['StartPrice'] = addVarPriceToPrice($pID, $otherMainPrice, $dataRow['variation_price']);
        }
		# Eigenschaften
		$attributes = explode('|', $dataRow['variation_attributes']);
		foreach ($attributes as $attr) {
			if (empty($attr)) continue;
			list($name, $value) = explode(',', $attr);
			if (!in_array($vc->optionNames[$name], $namelist)) {
				$namelist[] = $vc->optionNames[$name];
                # eBay akzeptiert nicht mehr als 50 Zeichen
				$valuelist[$vc->optionNames[$name]] = array(trim(substr($vc->optionValueNames[$value], 0, 50)));
			} else if (!in_array(trim(substr($vc->optionValueNames[$value], 0, 50)), $valuelist[$vc->optionNames[$name]])) {
				$valuelist[$vc->optionNames[$name]][] = trim(substr($vc->optionValueNames[$value], 0, 50));
			}
			$variations['Variations'][$k]['VariationSpecifics'][] = array(
				'Name' => trim(substr($vc->optionNames[$name], 0, 50)),
				'Value' => trim(substr($vc->optionValueNames[$value], 0, 50))
			);
		}
	}
	# Zusammenstellung der Namen und Werte
	foreach ($namelist as $name) {
		$variations['VariationSpecificsSet'][] = array(
			'Name' => trim(substr($name, 0, 50)),
			'Values' => $valuelist["$name"]
		);
	}
	return $variations;
}

# Hilfsfunktion: Varianten-Anzahl nach Kauf aendern (Matrix zum Upload zu eBay)
function setVariationQuantity(&$variationMatrix, $pID, $attributes, $value, $mode) {
    $variation_products_model = '';
    if (! is_array($attributes)) return false;
    if (! $pID) return false;
    ksort($attributes);

    $variationDbData = MagnaDB::gi()->fetchArray('SELECT variation_products_model, variation_attributes
                        FROM '.TABLE_MAGNA_VARIATIONS.' WHERE products_id = '.$pID);
    foreach ($variationDbData as $row) {
        $row_attributes = explode('|', $row['variation_attributes']);
        $found = true;
        if (count($row_attributes) < count($attributes)) {
            $found = false;
            continue;
        }
        foreach ($row_attributes as $attr) {
            list($akey, $aval) = $attr_arr = explode(',', $attr);
            if ($attributes[$akey] != $aval) $found = false;
        }
        if ($found) {
            $variation_products_model = $row['variation_products_model'];
            break;
        }
    }
    if ('' == $variation_products_model) return false;

    # Variation in der Matrix heruntersetzen
    foreach ($variationMatrix['Variations'] as $no => &$spec) {
        if ($spec['SKU'] == $variation_products_model) {
            if ('SUB' == $mode) $spec['Quantity'] -= $value;
            else $spec['Quantity'] = $value;
            # keine Anzahlen < 0 an eBay schicken
            if ($spec['Quantity'] < 0) $spec['Quantity'] = 0;
        }
    }

    # Kein Datenbank-Update, da u.U. mehrere mpIDs betroffen.
    # Die Tabelle wird eh vor jeder Verwendung aktualisiert.
    return true;
}

function geteBayCategoryPath($CategoryID, $StoreCategory = false) {
    global $_MagnaSession;
	$appendedText = '&nbsp;<span class="cp_next">&gt;</span>&nbsp;';
    if ($StoreCategory) $SiteID = $_MagnaSession['mpID'];
    else $SiteID = geteBaySiteID();
	$StoreCategory = $StoreCategory?'1':'0';
	$catPath = '';
	do {
		# Ermittle Namen, CategoryID und ParentID,
		# dann das gleiche fuer die ParentCategory usw.
		# bis bei Top angelangt (CategoryID = ParentID)
		$yCP = MagnaDB::gi()->fetchRow('
			SELECT CategoryID, CategoryName , ParentID
			  FROM '.TABLE_MAGNA_EBAY_CATEGORIES.'
			 WHERE CategoryID=\''.$CategoryID.'\'
			 AND StoreCategory=\''.$StoreCategory.'\'
             AND SiteID = \''.$SiteID.'\'
			 ORDER BY InsertTimestamp DESC LIMIT 1
		');
		if (empty($catPath)) {
			$catPath = fixHTMLUTF8Entities($yCP['CategoryName']);
		} else {
			$catPath = fixHTMLUTF8Entities($yCP['CategoryName']) . $appendedText . $catPath;
		}
		$CategoryID = $yCP['ParentID'];
	} while ($yCP['CategoryID'] != $yCP['ParentID']);
	if ($yCP === false) {
		return '<span class="invalid">'.ML_LABEL_INVALID.'</span>';
	}
	return $catPath;
}

# Hilfsfunktion fuer SaveEBaySingleProductProperties und SaveEBayMultipleProductProperties
# bereite die DB-Zeile vor mit allen Daten die sowohl fuer Single als auch Multiple inserts gelten
function prepareEBayPropertiesRow($pID, $itemDetails) {
	global $_MagnaSession;
    $myPrice = new SimplePrice(null, getCurrencyFromMarketplace($_MagnaSession['mpID']));
	$format = $myPrice->getFormatOptions();
	$row = array();
	$row['mpID'] = $_MagnaSession['mpID'];
	$row['products_id'] = $pID;
	$row['products_model'] = MagnaDB::gi()->fetchOne('SELECT products_model FROM '.TABLE_PRODUCTS.' WHERE products_id ='.$pID);
	$row['Site']            = $itemDetails['Site'];
	$row['PrimaryCategory'] = $itemDetails['PrimaryCategory'];
	if (!empty($itemDetails['PrimaryCategory'])) {
		$row['PrimaryCategoryName'] = MagnaDB::gi()->fetchOne('SELECT CategoryName FROM '.TABLE_MAGNA_EBAY_CATEGORIES.' WHERE CategoryID ='.$itemDetails['PrimaryCategory'].' LIMIT 1');
	}
	if (!empty($itemDetails['SecondaryCategory'])) {
		$row['SecondaryCategory'] = $itemDetails['SecondaryCategory'];
		$row['SecondaryCategoryName'] = MagnaDB::gi()->fetchOne('SELECT CategoryName FROM '.TABLE_MAGNA_EBAY_CATEGORIES.' WHERE CategoryID ='.$itemDetails['SecondaryCategory'].' LIMIT 1');
	}
	if (!empty($itemDetails['StoreCategory'])) {
		$row['StoreCategory'] = $itemDetails['StoreCategory'];
	}
	if (!empty($itemDetails['StoreCategory2'])) {
		$row['StoreCategory2'] = $itemDetails['StoreCategory2'];
	}
	$row['ListingType']     = $itemDetails['ListingType'];
	$row['ListingDuration'] = $itemDetails['ListingDuration'];
	$row['PaymentMethods']  = json_encode($itemDetails['PaymentMethods']);
	if (!empty($itemDetails['Attributes'])) {
		$row['Attributes'] = json_encode($itemDetails['Attributes']);
	} elseif ($oldAttributes = MagnaDB::gi()->fetchOne('SELECT Attributes FROM '.TABLE_MAGNA_EBAY_PROPERTIES.' WHERE products_id ='.$pID.' AND mpID = '.$_MagnaSession['mpID'])) {
		$row['Attributes'] = $oldAttributes;
	}
	if (!empty($itemDetails['ItemSpecifics'])) {
        arrayEntitiesFixHTMLUTF8($itemDetails['ItemSpecifics']);
		$row['ItemSpecifics'] = json_encode($itemDetails['ItemSpecifics']);
	} elseif ($oldItemSpecifics = MagnaDB::gi()->fetchOne('SELECT ItemSpecifics FROM '.TABLE_MAGNA_EBAY_PROPERTIES.' WHERE products_id ='.$pID.' AND mpID = '.$_MagnaSession['mpID'])) {
		$row['ItemSpecifics'] = $oldItemSpecifics;
	}

	$row['ConditionID'] = $itemDetails['ConditionID'];
	$ShippingDetails = array();
	$ShippingDetails['ShippingServiceOptions'] = array();
	foreach($itemDetails['ebay_default_shipping_local'] as $key => $localService) {
		$ShippingDetails['ShippingServiceOptions'][$key] = array(
			'ShippingService' => $localService['service'],
			'ShippingServiceCost' => priceToFloat($localService['cost'], $format),
			'ShippingServiceAdditionalCost' => priceToFloat($localService['addcost'], $format));
			if ('=GEWICHT' == strtoupper($localService['cost'])) {
				$ShippingDetails['ShippingServiceOptions'][$key]['ShippingServiceCost'] = '=GEWICHT';
				$ShippingDetails['ShippingServiceOptions'][$key]['ShippingServiceAdditionalCost'] = 0.0;
			}
		if (  !isset($next_service)
		    &&(is_numeric($ShippingDetails['ShippingServiceOptions'][$key]['ShippingServiceCost']))
		    &&(0.0 == $ShippingDetails['ShippingServiceOptions'][$key]['ShippingServiceCost'])
		    &&(0.0 == $ShippingDetails['ShippingServiceOptions'][$key]['ShippingServiceAdditionalCost'])) {
		$ShippingDetails['ShippingServiceOptions'][$key]['FreeShipping'] = 1;
		}
		$next_service = true; # FreeShipping darf nur beim 1ten Service gesetzt sein
	}
	$ShippingDetails['InternationalShippingServiceOption'] = array();
	if (is_array($itemDetails['ebay_default_shipping_international'])) {
		foreach($itemDetails['ebay_default_shipping_international'] as $key => $intlService) {
			if (empty($intlService['service'])) break;
			$ShippingDetails['InternationalShippingServiceOption'][$key] = array(
				'ShippingService' => $intlService['service'],
				'ShippingServiceCost' => priceToFloat($intlService['cost'], $format),
				'ShippingServiceAdditionalCost' => priceToFloat($intlService['addcost'], $format),
				'ShipToLocation' => $intlService['location']);
		}
	}
	if (0 == count($ShippingDetails['InternationalShippingServiceOption'])) {
	 	unset($ShippingDetails['InternationalShippingServiceOption']);
	}
	$row['ShippingDetails'] = json_encode($ShippingDetails);
	# Noch nicht verifiziert:
	$row['Verified'] = 'OPEN';
	return $row;
}

function SaveEBaySingleProductProperties($pID, $itemDetails) {
	global $_MagnaSession;
	$row = prepareEBayPropertiesRow($pID, $itemDetails);
	$row['Title']           = trim(strip_tags(html_entity_decode($itemDetails['Title'])));
	if(('on' == $itemDetails['enableSubtitle']) && !empty($itemDetails['Subtitle'])) {
		$row['Subtitle'] = trim(strip_tags($itemDetails['Subtitle']));
	}
	if(!empty($itemDetails['PictureURL'])) $row['PictureURL'] = trim($itemDetails['PictureURL']);
	if(!empty($itemDetails['GalleryURL']) && ('on' == $itemDetails['enableGallery'])) {
		$row['GalleryURL'] = trim($itemDetails['GalleryURL']);
	}
	require_once(DIR_MAGNALISTER_INCLUDES.'lib/classes/SimplePrice.php');
	$myPrice = new SimplePrice(null,getCurrencyFromMarketplace($_MagnaSession['mpID']));
	$format = $myPrice->getFormatOptions();
	#if (isset($itemDetails['freezePrice'])) 
	if ('true' == $itemDetails['isPriceFrozen']) {
		if ($itemDetails['frozenPrice'] == (string)(float) $itemDetails['frozenPrice'])
			$row['Price'] = $itemDetails['frozenPrice'];	
		else
			$row['Price'] = priceToFloat($itemDetails['frozenPrice'], $format);
        # Einfrieren, aber nicht ausgefuellt => berechneten Preis einfrieren
        if (0.00 == $row['Price']) $row['Price'] = priceToFloat($itemDetails['Price'], $format);
	} else {
		$row['Price'] = (float)0;
	}
	if(   isset($itemDetails['isPriceFrozen'])
	   && isset($itemDetails['enableBuyItNowPrice'])
	   && !empty($itemDetails['BuyItNowPrice'])
	   && ('Chinese' == $itemDetails['ListingType'])
	  ) {
		if ($itemDetails['BuyItNowPrice'] == (string)(float) $itemDetails['BuyItNowPrice'])
			$row['BuyItNowPrice'] = $itemDetails['BuyItNowPrice'];
		else
			$row['BuyItNowPrice'] = priceToFloat($itemDetails['BuyItNowPrice'], $format);
	}
	$row['Description']     = trim($itemDetails['Description']);
	#echo print_m($row, 'final');
	# doppelte Eintraege verhindern
	if ('artNr' == getDBConfigValue('general.keytype', '0'))
		MagnaDB::gi()->delete(TABLE_MAGNA_EBAY_PROPERTIES, array('mpID'=>$_MagnaSession['mpID'], 'products_model'=>$row['products_model']));
	else
		MagnaDB::gi()->delete(TABLE_MAGNA_EBAY_PROPERTIES, array('mpID'=>$_MagnaSession['mpID'], 'products_id'=>$pID));
	MagnaDB::gi()->insert(TABLE_MAGNA_EBAY_PROPERTIES, $row, true);
}

function SaveEBayMultipleProductProperties($pIDs, $itemDetails) {
	global $_MagnaSession;
	# Analog zu SaveEBaySingleProductProperties, aber
	# Title, (Subtitle), PictureURL aus der Datenbank
	# und Descriptions zusammenbauen
	if(!is_array($pIDs)) {
		if(!empty($pIDs)) $pIDs = array($pIDs);
		else return false;
	}
	$more_data_select = 'SELECT p.products_id products_id, p.products_model products_model, pd.products_name Title, ';
	if (MagnaDB::gi()->columnExistsInTable('products_short_description', TABLE_PRODUCTS_DESCRIPTION))
		$more_data_select .= ' pd.products_short_description Subtitle, ';
	else
		$more_data_select .= ' \'\' Subtitle, ';
	$more_data_select .=  ' pd.products_description description,
                p.products_price Price, p.products_image image 
				FROM '.TABLE_PRODUCTS.' p, '.TABLE_PRODUCTS_DESCRIPTION.' pd
				WHERE p.products_id = pd.products_id
				AND pd.language_id = \''.$_SESSION['languages_id'].'\'
				AND p.products_id IN ('.implode($pIDs, ', ').')';
	$more_data = MagnaDB::gi()->fetchArray($more_data_select);
	$imagePath = getDBConfigValue('ebay.imagepath',$_MagnaSession['mpID']);
	$eBayTemplate = getDBConfigValue('ebay.template.content',$_MagnaSession['mpID']);
	foreach ($more_data as $dataRow) {
		$row = prepareEBayPropertiesRow($dataRow['products_id'], $itemDetails);
		$row['Title'] = strip_tags($dataRow['Title']);
	    if('on' == $itemDetails['enableSubtitle'] && !empty($dataRow['Subtitle'])) {
		    $row['Subtitle'] = substr(trim(strip_tags($dataRow['Subtitle'])),0,55);
	    }
		# if (isset($itemDetails['subtitle_checked'])) $dataRow['Subtitle'] = strip_tags($dataRow['Subtitle']);
		#$row['Price'] = makePrice($dataRow['products_id'], $itemDetails['ListingType']);
		$row['Price'] = (float)0; # Preis nicht einfrieren
		if (('Chinese' == $itemDetails['ListingType']) && getDBConfigValue(array('ebay.chinese.buyitnow.price.active', 'val'), $_MagnaSession['mpID'])) {
			$row['BuyItNowPrice'] = makePrice($dataRow['products_id'], 'BuyItNowPrice');
		}
		$row['PictureURL'] = empty($dataRow['image'])? '': $imagePath . $dataRow['image'];
		if ('on' == $itemDetails['enableGallery']) {
			$galleryPath = getDBConfigValue('ebay.gallery.imagepath',$_MagnaSession['mpID']);
			$row['GalleryURL'] = empty($dataRow['image'])? '': $galleryPath . $dataRow['image'];
		}
		# Descriptions zusammenbauen
		$substitution = array(
			'#TITLE#' => fixHTMLUTF8Entities($dataRow['Title']),
			'#ARTNR#' => $dataRow['products_model'],
			'#PID#' => $dataRow['products_id'],
			'#SKU#' => magnaPID2SKU($dataRow['products_id']),
			'#SHORTDESCRIPTION#' => $dataRow['Subtitle'],
			'#DESCRIPTION#' => stripLocalWindowsLinks($dataRow['description']),
			'#PICTURE1#' => $row['PictureURL'],
			);
		$row['Description'] = substitutePictures(substituteTemplate($eBayTemplate, $substitution),$dataRow['products_id'],$imagePath);
		
        # ggf vorher eingefrorene Preise nicht plattmachen &
		# doppelte Eintraege verhindern
		if ('artNr' == getDBConfigValue('general.keytype', '0')) {
            $row['Price'] = (float)MagnaDB::gi()->fetchOne('SELECT Price FROM '.TABLE_MAGNA_EBAY_PROPERTIES.' WHERE mpID = '.$_MagnaSession['mpID'].' AND products_model = \''.$row['products_model'].'\'');
			MagnaDB::gi()->delete(TABLE_MAGNA_EBAY_PROPERTIES, array('mpID'=>$_MagnaSession['mpID'], 'products_model'=>$row['products_model']));
        } else {
            $row['Price'] = (float)MagnaDB::gi()->fetchOne('SELECT Price FROM '.TABLE_MAGNA_EBAY_PROPERTIES.' WHERE mpID = '.$_MagnaSession['mpID'].' AND products_id = '.$dataRow['products_id']);
			MagnaDB::gi()->delete(TABLE_MAGNA_EBAY_PROPERTIES, array('mpID'=>$_MagnaSession['mpID'], 'products_id'=>$dataRow['products_id']));
        }
		MagnaDB::gi()->insert(TABLE_MAGNA_EBAY_PROPERTIES, $row, true);
	}
}

