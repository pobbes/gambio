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
 * $Id: magnaFunctionLib.php 1614 2012-04-14 22:35:49Z derpapst $
 *
 * (c) 2010 RedGecko GmbH -- http://www.redgecko.de
 *     Released under the GNU General Public License v2 or later
 * -----------------------------------------------------------------------------
 */

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');


/******************************************************************************\
 *                        Magnalister Specific Functions                      *
\******************************************************************************/

function magnaContribVerify($hookname, $version) {
	$path = DIR_MAGNALISTER_CONTRIBS.$hookname.'_'.$version.'.php';
	if (($path[0] != '/') && !preg_match('/^[a-zA-Z]:\\\/', $path)) {
		if (defined('DIR_FS_ADMIN')) {
			$path = rtrim(DIR_FS_ADMIN, '/').'/'.$path;
		} else {
			return false;
		}
	}
	#echo var_dump_pre($path);
	return file_exists($path) ? $path : false;
}

function getCurrentModulePage() {
	global $_modules, $_MagnaSession;
	$modulePages = $_modules[$_MagnaSession['currentPlatform']]['pages'];

	if (isset($_modules[$_MagnaSession['currentPlatform']]['settings']['defaultpage'])) {
		$page = $_modules[$_MagnaSession['currentPlatform']]['settings']['defaultpage'];
	} else {
		$page = array_first(array_keys($modulePages));
	}
	if (array_key_exists('mode', $_GET) && array_key_exists($_GET['mode'], $modulePages)) {
		$page = $_GET['mode'];
	}
	return $page;
}

function requirementsMet($product, $requirements, &$failed) {
	if (!is_array($product) || empty($product) || !is_array($requirements) || empty($requirements)) {
		$failed = true;
		return false;
	}
	$failed = array();
	foreach ($requirements as $req => $needed) {
		if (!$needed) continue;
		if (!array_key_exists($req, $product) || (empty($product[$req]) && ($product[$req] !== '0'))) {
			$failed[] = $req;
		}
	}
	return empty($failed);
}

function generateProductCategoryThumb($fName, $w, $h, $noImageIcon = false) {
	$imagePath = '';

	if (!eempty(trim($fName)) && !$noImageIcon) {
		if (file_exists(SHOP_FS_PRODUCT_THUMBNAILS.$fName)) {
			$imagePath = SHOP_FS_PRODUCT_THUMBNAILS;
			$cachePath = DIR_MAGNALISTER_IMAGECACHE.'product_';
		} else if (file_exists(SHOP_FS_PRODUCT_IMAGES.$fName)) {
			$imagePath = SHOP_FS_PRODUCT_IMAGES;
			$cachePath = DIR_MAGNALISTER_IMAGECACHE.'product_';
		} else if (file_exists(SHOP_FS_CATEGORY_IMAGES.$fName)) {
			$imagePath = SHOP_FS_CATEGORY_IMAGES;
			$cachePath = DIR_MAGNALISTER_IMAGECACHE.'category_';
		}
	} else if ($noImageIcon) {
		$imagePath = DIR_MAGNALISTER_RESOURCE;
		$cachePath = DIR_MAGNALISTER_IMAGECACHE.'resource_';
	}
	if ($imagePath == '') {
		return generateProductCategoryThumb('noimage.png', $w, $h, true);
	}
	$newfName = basename($fName);
	if (($dotpos = strrpos($newfName, '.')) > 0) {
		$newfName = str_split($newfName, $dotpos);
		$newfName = $newfName[0];
	}
	$newfName .= '_'.$w.'x'.$h.'.jpg';
	if (!is_dir(dirname(DIR_FS_ADMIN.$cachePath))) {
		if (MAGNA_SAFE_MODE) return '&nbsp';
		mkdir(dirname(DIR_FS_ADMIN.$cachePath), 0775, true);
	}
	$destFile = DIR_FS_ADMIN.$cachePath.$newfName;
	if (file_exists($destFile)) {
		list($width, $height) = getimagesize($destFile);
		if (($w == $width) || ($h = $height)) {
			return '<img width="'.$width.'" height="'.$height.'" src="'.$cachePath.$newfName.'" alt="'.$fName.'"/>';
		}
	}

	$success = resizeImage($imagePath.$fName, $w, $h, $destFile);
	if (!$success && !$noImageIcon) {
		return generateProductCategoryThumb('noimage.png', $w, $h, true);
	} else if (!$success && $noImageIcon) {
		return 'X';
	}
	list($width, $height) = getimagesize($destFile);
	return '<img width="'.$width.'" height="'.$height.'" src="'.$cachePath.$newfName.'" alt="'.$fName.'"/>';
}

function html_image($image, $alt = "", $width = "", $height = "") {
	return '<img src="'.$image.'"'.(!empty($alt) ? (' alt="'.$alt.'" title="'.$alt.'"') : '').(!empty($width) ? (' width="'.$width.'"') : '').(!empty($height) ? (' height="'.$height.'"') : '').'>';
}

function parseShippingStatusName($status, $fallback) {
	/* Extract largest number */
	$largestNumber = 0;
	if (preg_match_all('/([0-9]+)/', $status, $matches)) {
		$numbers = $matches[0];
		foreach ($numbers as $number) {
			if ($number > $largestNumber) {
				$largestNumber = $number;
			}
		}
	}
	if (preg_match('/(Day|Days|Tag|Tage)/i', $status)) {
		return $largestNumber;
	}
	if (preg_match('/(Week|Weeks|Woche|Wochen)/i', $status)) {
		return $largestNumber * 7;
	}
	if (preg_match('/(Month|Months|Monat|Monate)/i', $status)) {
		return $largestNumber * 30;
	}
	
	return $fallback;
}

function shopAdminDiePage($content) {
	global $_MagnaSession;
	$_MagnaSession['currentPlatform'] = '';
	include_once(DIR_MAGNALISTER_INCLUDES.'admin_view_top.php');
	echo $content;
	include_once(DIR_MAGNALISTER_INCLUDES.'admin_view_bottom.php');
	include_once(DIR_WS_INCLUDES . 'application_bottom.php');
	exit();	
}

function sanitizeProductDescription($str, $allowable_tags = '', $allowable_attributes = '') {
	$str = !isUTF8($str) ? utf8_encode($str) : $str;
	
	$str = stripEvilBlockTags($str);

	/* Convert Gambio-Tabs to H1-Headlines */
	$str = preg_replace('/\[TAB:([^\]]*)\]/', '<h1>${1}</h1>', $str);

	if (stripos($allowable_tags, '<br') === false) {
		/* Convert (x)html breaks with or without atrributes to newlines. */
		$str = preg_replace('/\<br(\s*)?([[:alpha:]]*=".*")?(\s*)?\/?\>/i', "\n", $str);
	} else {
		$str = str_replace('<br/>', '<br />', $str);
	}
	$str = preg_replace("/<([^([:alpha:]|\/)])/", '&lt;\\1', $str); 
	$str = strip_tags_attributes($str, $allowable_tags, $allowable_attributes);
	
	if ($allowable_tags == '') {
		$str = str_replace(array("\n", "\t", "\v", "|"), " ", $str);
    	$str = str_replace(array("&quot;", "&qout;"), " \"", $str);

		$str = str_replace(array("&nbsp;"), " ", $str);

		/* Converts all html entities to "real" characters */
		$str = html_entity_decode($str);
		$str = str_replace(array(";", "'"), ", ", $str);
	}

	/* Strip excess whitespace */
	$str = preg_replace('/\s\s+/', ' ', trim($str));
	return $str;
}

function magnaGetAddressFormatID($country_id) {
	$ret = (int) MagnaDB::gi()->fetchOne(
		"SELECT address_format_id FROM " . TABLE_COUNTRIES . " WHERE countries_id = '" . $country_id . "'"
	);
	if ($ret < 1) {
		return '1';
	}
	return $ret;
}

function magnaGetCountryFromISOCode($code) {
	$countryRes = MagnaDB::gi()->fetchRow('
		SELECT countries_id, countries_name, countries_iso_code_2
		  FROM '.TABLE_COUNTRIES.'
		 WHERE countries_iso_code_2=\''.$code.'\' 
		 LIMIT 1
	');
	if ($countryRes === false) {
		$countryRes = array (
			'countries_id' => 0,
			'countries_name' => $code,
		);
	}
	return $countryRes;
}

function substituteTemplate($tmplStr, $substitution) {
	$find = array();
	$replace = array();
	# Sonderfall: PICTURE1, ersetze durch URL wenn img oder a href Tag angegeben, sonst durch vollst. img Tag.
	if (isset($substitution['#PICTURE1#'])) {
		$tmplStr = str_replace('#PICTURE1#', "<img src=\"".$substitution['#PICTURE1#']."\" style=\"border:0;\" alt=\"\" title=\"\" />",
                                 preg_replace( '/(src|SRC|href|HREF)(\s*=\s*)(\'|")(#PICTURE1#)/', '\1\2\3'.$substitution['#PICTURE1#'], $tmplStr));
	}
	foreach ($substitution as $f => $r) {
		$find[] = $f;
		$replace[] = $r;
	}
	$str = str_replace($find, $replace, $tmplStr);
	# relative Pfade bei (nicht von uns eingesetzten) Bildern und Links ersetzen
	if (  ('none_none' != getDBConfigValue('general.editor',0,'tinyMCE')) 
	    &&(preg_match('/(src|SRC|href|HREF)(\s*=\s*)(\'|")(?!http|HTTP|mailto|javascript|#)/', $str))) {
		$str = preg_replace('/(src|SRC|href|HREF)(\s*=\s*)(\'|")(?!http|HTTP|mailto|javascript|#)/','\1\2\3'.HTTP_CATALOG_SERVER.DIR_WS_CATALOG.'\4', preg_replace('/(src|SRC|href|HREF)(\s*=\s*)(\'|")(\/)/','\1\2\3'.HTTP_CATALOG_SERVER.'\4', $str));
	}
	return $str;
}

function magnaGetMarketplaceByID($mpID) {
	global $magnaConfig;
	$mpID = (string)$mpID;
	if (!ctype_digit((string)$mpID)) {
		if (MAGNA_DEBUG) {
			echo print_m(prepareErrorBacktrace(2));
		}
		trigger_error(__FUNCTION__.': Parameter $mpID ('.trim(var_dump_pre($mpID)).') must be numeric.');
	}
	if (!array_key_exists($mpID, $magnaConfig['maranon']['Marketplaces'])) {
		return false;
	}
	return $magnaConfig['maranon']['Marketplaces'][$mpID];
}

function magnaGetIDsByMarketplace($mp) {
	global $magnaConfig;
	
	if (!array_key_exists('maranon', $magnaConfig) || 
	    !array_key_exists('Marketplaces', $magnaConfig['maranon']) || 
	    empty($magnaConfig['maranon']['Marketplaces'])
	) {
		return false;
	}
	$ids = array();
	foreach ($magnaConfig['maranon']['Marketplaces'] as $mpID => $marketplace) {
		if ($marketplace == $mp) {
			$ids[] = $mpID;
		}
	}
	return $ids;
}

function sendSaleConfirmationMail($mpID, $recipientAdress, $substitution) {
	global $magnaConfig;
	$marketplace = magnaGetMarketplaceByID($mpID);
	if ($marketplace === false) {
		return false;
	}

	if (is_array($substitution['#ORDERSUMMARY#']) && !empty($substitution['#ORDERSUMMARY#'])) {
		$mailOrderSummary = '
			<table class="ordersummary">
				<thead>
					<tr>
						<td class="qty">St&uuml;ck</td>
						<td class="name">Artikel</td>
						<td class="price">Einzelpreis</td>
						<td class="fprice">Gesamtpreis</td>
					</tr>
				</thead>
				<tbody>';
		$isOdd = false;
		foreach ($substitution['#ORDERSUMMARY#'] as $item) {
			$item['price'] = str_replace('&curren;', '&euro;', fixHTMLUTF8Entities($item['price']));
			$item['finalprice'] = str_replace('&curren;', '&euro;', fixHTMLUTF8Entities($item['finalprice']));
			$mailOrderSummary .= '
					<tr class="'.(($isOdd = !$isOdd) ? 'odd' : 'even').'">
						<td class="qty">'.$item['quantity'].'</td>
						<td class="name">'.fixHTMLUTF8Entities($item['name']).'</td>
						<td class="price">'.$item['price'].'</td>
						<td class="fprice">'.$item['finalprice'].'</td>
					</tr>';
		}
		$mailOrderSummary .= '
				</tbody>
			</table>';
		$substitution['#ORDERSUMMARY#'] = $mailOrderSummary;
	}
	
	$content = stringToUTF8(substituteTemplate(getDBConfigValue($marketplace.'.mail.content', $mpID), $substitution));
	unset($substitution['#ORDERSUMMARY#']);
	$subject = stringToUTF8(substituteTemplate(getDBConfigValue($marketplace.'.mail.subject', $mpID), $substitution));
/*
	echo print_m(array(
		'SUBJECT' => $subject,
		'CONTENT' => $content,
	), 'mail');
	return true;
//*/
	$orignator = getDBConfigValue($marketplace.'.mail.originator.adress', $mpID);
	try {
		$result = MagnaConnector::gi()->submitRequest(array(
			'ACTION' => 'SendSaleConfirmationMail',
			'SUBSYSTEM' => 'Core',
			'RECIPIENTADRESS' => $recipientAdress,
			'ORIGINATORNAME' => fixHTMLUTF8Entities(
				getDBConfigValue($marketplace.'.mail.originator.name', $mpID)
			),
			'ORIGINATORADRESS' => $orignator,
			'SUBJECT' => fixHTMLUTF8Entities($subject),
			'CONTENT' => $content,
			'BCC' => (
				($recipientAdress == $orignator) ? 
					false :	((getDBConfigValue($marketplace.'.mail.copy', $mpID) == 'true') ? 
						true : false
					)
			)
		));
		if (MAGNA_DEBUG && array_key_exists('DEBUG', $result)) {
			echo print_m($result['DEBUG'], 'Debug');
		}
		return true;
	} catch (MagnaException $e) {
		return false;
	}	
}

function sendTestMail($mpID) {
	require_once (DIR_MAGNALISTER_INCLUDES.'lib/classes/SimplePrice.php');
	$simplePrice = new SimplePrice();
	$simplePrice->setCurrency(DEFAULT_CURRENCY);
	
	$marketplace = magnaGetMarketplaceByID($mpID);
	
	return sendSaleConfirmationMail(
		$mpID,
		getDBConfigValue($marketplace.'.mail.originator.adress', $mpID),
		array(
			'#FIRSTNAME#' => 'Max',
			'#LASTNAME#' => 'Mustermann',
			'#ORDERSUMMARY#' => array(
 				array(
					'quantity' => 2,
					'name' => 'Lorem Ipsum - Das Buch',
					'price' => $simplePrice->setPrice(12.99)->format(),
					'finalprice' => $simplePrice->setPrice(12.99 * 2)->format(),
				),
 				array(
					'quantity' => 1,
					'name' => 'Dolor Sit Amet - Das Nachschlagewerk',
					'price' => $simplePrice->setPrice(22.59)->format(),
					'finalprice' => $simplePrice->setPrice(22.59)->format(),
				)
			),
			'#MARKETPLACE#' => 'marketplace.com',
			'#SHOPURL#' => HTTP_SERVER,
		)
	);
}

function delete_double_orders() {
	$orders_id_array = MagnaDB::gi()->fetchArray('SELECT DISTINCT mo2.orders_id orders_id
				FROM '.TABLE_MAGNA_ORDERS.' mo1, '.TABLE_MAGNA_ORDERS.' mo2
				 WHERE mo1.orders_id < mo2.orders_id AND mo1.special=mo2.special
				 AND mo1.data = mo2.data AND mo1.mpID=mo2.mpID
				ORDER BY mo2.orders_id');
	$orders_id_list = '';
	foreach($orders_id_array as $current_order)
		$orders_id_list .= ', '.$current_order['orders_id'];
	$orders_id_list = trim($orders_id_list, ', ');
	if(empty($orders_id_list)) return true;
	$orders_tables = array( TABLE_ORDERS,
				TABLE_ORDERS_STATUS_HISTORY,
				TABLE_ORDERS_TOTAL,
				TABLE_ORDERS_PRODUCTS,
				TABLE_ORDERS_PRODUCTS_ATTRIBUTES);
	foreach($orders_tables as $current_table) {
		MagnaDB::gi()->query('DELETE FROM '.$current_table.'
					WHERE orders_id IN ('.$orders_id_list.')
				');
	}
	return true;
}

function delete_double_customers() {
	return true;
	$customers_id_array = MagnaDB::gi()->fetchArray('SELECT DISTINCT
				c2.customers_id customers_id, c2.customers_default_address_id address_book_id
				FROM '.TABLE_CUSTOMERS.' c1, '.TABLE_CUSTOMERS.' c2
				WHERE c1.customers_firstname = c2.customers_firstname
				AND c1.customers_lastname=c2.customers_lastname
				AND c1.customers_email_address = c2.customers_email_address
				AND c2.customers_id > c1.customers_id
				ORDER BY c2.customers_id');
	$customers_id_list = '';
	$address_book_id_list = '';
	$customers_info_id_list = '';
	foreach($customers_id_array as $current_customer) {
		$customers_id_list .= ', '.$current_customer['customers_id'];
		$address_book_id_list .= ', '.$current_customer['address_book_id'];
	}
	$customers_id_list = trim($customers_id_list, ', ');
	if(empty($customers_id_list)) return true;
	$address_book_id_list = trim($address_book_id_list, ', ');
	MagnaDB::gi()->query('DELETE FROM '.TABLE_CUSTOMERS.' WHERE customers_id in ('.$customers_id_list.')');
	MagnaDB::gi()->query('DELETE FROM '.TABLE_CUSTOMERS_INFO.' WHERE customers_info_id in ('.$customers_id_list.')');
	MagnaDB::gi()->query('DELETE FROM '.TABLE_ADDRESS_BOOK.' WHERE address_book_id in ('.$address_book_id_list.')');
	return true;

}

function magnaFixOrders() {
	if (isset($_GET['forceDeleteDoubleOrders']) && ($_GET['forceDeleteDoubleOrders'] == 'true')) {
		setDBConfigValue('deletedoubleorders', 0, 'true', true);
	}
	if (getDBConfigValue('deletedoubleorders', '0', 'false') != 'true') {
		return;
	}
	delete_double_orders();
	delete_double_customers();
	setDBConfigValue('deletedoubleorders', 0, 'false', true);
}

function priceToFloat($price, $format) {
	$r = '/^[0-9'.escape_string_for_regex($format[2]).']*('.escape_string_for_regex($format[1]).'[0-9]{'.$format[0].'})?$/';
	if (!preg_match($r, $price)) {
		return -1;
	}
	$charAtDPPos = substr($price, -($format[0]+1), 1);
	if (ctype_digit($charAtDPPos)) {
		$charAtDPPos = '';
	}
	$regExpr = '/[^0-9'.escape_string_for_regex($charAtDPPos).']/';
	$price = preg_replace($regExpr, '', $price);
	if ($charAtDPPos != '') {
		$price = preg_replace('/'.escape_string_for_regex($charAtDPPos).'/', '.', $price);
	}
	$price = (float)$price;
	return $price;
}

function generateUniqueProductModels() {
	MagnaDB::gi()->query('
		UPDATE '.TABLE_PRODUCTS.' 
		   SET products_model=CONCAT(\'p\', products_id) 
		 WHERE products_model=\'\' OR products_model IS NULL
	');

	$q = MagnaDB::gi()->query('
		SELECT products_model, COUNT(products_model) as cnt
		  FROM '.TABLE_PRODUCTS.' 
		 WHERE products_model <> \'\'
      GROUP BY products_model
        HAVING cnt > 1'
	);
	$dblProdModel = array();
	while ($row = MagnaDB::gi()->fetchNext($q)) {
		$dblProdModel[] = $row['products_model'];
	}

	$q = MagnaDB::gi()->query('
		SELECT products_id, products_model
		  FROM '.TABLE_PRODUCTS.'
		 WHERE products_model IN (\''.implode('\', \'', $dblProdModel).'\')
	');
	$dblProdModel = array();
	while ($row = MagnaDB::gi()->fetchNext($q)) {
		$dblProdModel[$row['products_model']][] = $row['products_id'];
	}
	//echo print_m($dblProdModel);
	if (!empty($dblProdModel)) {
		foreach ($dblProdModel as $pMod => $pIDs) {
			$i = 1;
			foreach ($pIDs as $pID) {
				MagnaDB::gi()->update(TABLE_PRODUCTS, array(
					'products_model' => $pMod.'_'.($i++)
				), array(
					'products_id' => $pID
				));
			}
		}
	}
	# Varianten
	MagnaDB::gi()->query('
		UPDATE '.TABLE_PRODUCTS_ATTRIBUTES.' 
		   SET attributes_model=CONCAT(\'p\', products_id, \'_\', products_attributes_id) 
		 WHERE attributes_model=\'\' OR attributes_model IS NULL
	');
	$q = MagnaDB::gi()->query('
	    SELECT attributes_model, COUNT(attributes_model) as cnt
	      FROM '.TABLE_PRODUCTS_ATTRIBUTES.' 
	     WHERE attributes_model <> \'\'
	  GROUP BY attributes_model
	    HAVING cnt > 1
	');
	$dblAttrModel = array();
	while ($row = MagnaDB::gi()->fetchNext($q)) {
		$dblAttrModel[] = $row['attributes_model'];
	}

	$q = MagnaDB::gi()->query('
		SELECT products_attributes_id, attributes_model
		  FROM '.TABLE_PRODUCTS_ATTRIBUTES.'
		 WHERE attributes_model IN (\''.implode('\', \'', $dblAttrModel).'\')
	');
	$dblAttrModel = array();
	while ($row = MagnaDB::gi()->fetchNext($q)) {
		$dblAttrModel[$row['attributes_model']][] = $row['products_attributes_id'];
	}
	//echo print_m($dblProdModel);
	if (!empty($dblAttrModel)) {
		foreach ($dblAttrModel as $pMod => $pIDs) {
			$i = 1;
			foreach ($pIDs as $pID) {
				MagnaDB::gi()->update(TABLE_PRODUCTS_ATTRIBUTES, array(
					'attributes_model' => $pMod.'_'.($i++)
				), array(
					'products_attributes_id' => $pID
				));
			}
		}
	}
}

# update magnalister's variations table for a single product
# return true if variations available, otherwise false
function setProductVariations($pID, $language = false, $resetModelNames = false) {
	require_once(DIR_MAGNALISTER_INCLUDES.'lib/classes/VariationsCalculator.php');
	$skutype = ('artNr' == getDBConfigValue('general.keytype', '0'))?'model':'id';
	$vc = new VariationsCalculator(array(
		'skubasetype' => $skutype, //  [model | id]
		'skuvartype'  => $skutype, //  [model | id]
	),
    $language);
    if (!$resetModelNames) {
        $namesArr = MagnaDB::gi()->fetchArray('SELECT variation_attributes, variation_products_model
                        FROM '.TABLE_MAGNA_VARIATIONS.' WHERE products_id = '.$pID);
        if (is_array($namesArr)) {
            $namesByAttr = array();
            foreach ($namesArr as $namesRow) {
                $namesByAttr[$namesRow['variation_attributes']] = $namesRow['variation_products_model'];
            }
            if (empty($namesByAttr)) { unset($namesByAttr);  $namesByAttr = false; }
        } else {
            $namesByAttr = false;
        }
    }
	MagnaDB::gi()->query('DELETE FROM '.TABLE_MAGNA_VARIATIONS.' WHERE products_id = '.$pID);
	$permutations = $vc->getVariationsByPID($pID);
	if (!$permutations) return false;
    # preserve variation products model names
    if (!$resetModelNames && is_array($namesByAttr)) {
        foreach ($permutations as &$permutation) {
                if (isset ($namesByAttr[$permutation['variation_attributes']])) {
                    $permutation['variation_products_model'] = $namesByAttr[$permutation['variation_attributes']];
                }
        }
    }
	if (MagnaDB::gi()->batchinsert(TABLE_MAGNA_VARIATIONS, $permutations, true))
		return true;
}

# show the quantity of all variations of a product,
# without actually filling the variations table
# minus: subtract from each variation's stock, for the case this is set by config
function getProductVariationsQuantity($pID, $minus = 0) {
	$quantity = 0;
	require_once(DIR_MAGNALISTER_INCLUDES.'lib/classes/VariationsCalculator.php');
	$skutype = (getDBConfigValue('general.keytype', '0') == 'artNr') ? 'model' : 'id';
	$vc = new VariationsCalculator(array(
		'skubasetype' => $skutype,
		'skuvartype'  => $skutype,
	));
	return $vc->getProductVariationsTotalQuantity($pID, $minus);
}

# does the product have variations? no matter if there's stock > 0
function variationsExist($pID) {
    if (MagnaDB::gi()->fetchOne('SELECT COUNT(*) FROM '.TABLE_MAGNA_VARIATIONS.
        ' WHERE products_id = '.$pID) > 0)
        return true;
    else
        return false;
}

function getCurrencyFromMarketplace($mpID) {
	global $magnaConfig, $_modules;
	
	$mp = magnaGetMarketplaceByID($mpID);
	if ($mp === false) {
		return false;
	}
	if (!array_key_exists($mp, $_modules)) {
		return false;
	}
	$currency = $_modules[$mp]['settings']['currency'];
	if ($currency != '__depends__') {
		return $currency;
	}
	if ($mp == 'amazon') {
		$cur = getDBConfigValue('amazon.currency', $mpID, false);
		return empty($cur) ? false : $cur;
	}
	if ($mp == 'ebay') {
		$cur = getDBConfigValue('ebay.currency', $mpID, false);
		return empty($cur) ? false : $cur;
	}
	return false;
}

function magnaSKU2pID($sku, $mainOnly = false) {
	$sku = MagnaDB::gi()->escape($sku);

    $pID = 0;

    if (!$mainOnly) {
	    # Assume it's a Variation.
	    $pID = (int)MagnaDB::gi()->fetchOne('
		    SELECT products_id FROM '.TABLE_PRODUCTS_ATTRIBUTES.' 
		    WHERE products_attributes_id=\''.magnaSKU2aID($sku).'\' LIMIT 1
	    ');
	    if ($pID > 0) return $pID;
    
	    # Try a variation from the magnalister variations table
	    $pID = (int)MagnaDB::gi()->fetchOne('
		    SELECT products_id FROM '.TABLE_MAGNA_VARIATIONS.' 
		    WHERE variation_products_model=\''.$sku.'\' LIMIT 1
	    ');
	    if ($pID > 0) return $pID;
    }

	# It wasn't a variation. Try with products_id or products_model
	switch (getDBConfigValue('general.keytype', '0')) {
		case 'artNr': {
			$pID = (int)MagnaDB::gi()->fetchOne('
				SELECT products_id FROM '.TABLE_PRODUCTS.'
				 WHERE products_model=\''.$sku.'\' LIMIT 1
			');
			if ($pID > 0) break;
		}
		case 'pID': { 		 
			if (strpos($sku, 'ML') !== false) {
				// Check ob pID auch in DB existiert.
				$pID = (int)MagnaDB::gi()->fetchOne('
					SELECT products_id FROM '.TABLE_PRODUCTS.' 
					 WHERE products_id=\''.str_replace('ML', '', $sku).'\' LIMIT 1
				');
			}
			break;
		}
	}

	# ML v1.0.0, wird irgendwann bei neueren Versionen entfernt werden um Fehler zu vermeiden.
	/* Der Tag des Fehlers ist gekommen...
	if (($pID <= 0) && ctype_digit($sku)) {
		$pID = (int)MagnaDB::gi()->fetchOne('
			SELECT products_id FROM '.TABLE_PRODUCTS.' 
			 WHERE products_id=\''.((int)$sku).'\' LIMIT 1
		');
	}
	//*/

	return $pID;
}

function magnaSKU2aID($sku) {
	$aID = false;
	do {
		if ('artNr' != getDBConfigValue('general.keytype', '0')) {
			break;
		}
		if (preg_match('/(.*)_MLV([0-9]*)_([0-9]*)$/', $sku, $match)) {
			$pID = magnaSKU2pID($match[1]);
			return MagnaDB::gi()->fetchOne('
				SELECT products_attributes_id
				  FROM '.TABLE_PRODUCTS_ATTRIBUTES.' 
				 WHERE products_id=\''.$pID.'\'
				       AND options_id=\''.$match[2].'\'
				       AND options_values_id=\''.$match[3].'\'
				 LIMIT 1
			');
		} else if (MagnaDB::gi()->columnExistsInTable('attributes_model', TABLE_PRODUCTS_ATTRIBUTES)) {
			$aID = MagnaDB::gi()->fetchOne('
				SELECT products_attributes_id
				  FROM '.TABLE_PRODUCTS_ATTRIBUTES.' 
				 WHERE attributes_model = \''.$sku.'\'
			');
			if ($aID > 0) return $aID;
		}
	} while (false);

	if (strpos($sku, 'MLV') !== 0) {
		return false;
	}
	$skuTmp = str_replace('MLV', '', $sku);

	$opt = explode('_', $skuTmp);
	if (array_key_exists(2, $opt) 
		&& ctype_digit($opt[0]) && ctype_digit($opt[1]) && ctype_digit($opt[2])
	) {
		/* Neue Version */
		$aID = MagnaDB::gi()->fetchOne('
			SELECT products_attributes_id
			  FROM '.TABLE_PRODUCTS_ATTRIBUTES.' 
			 WHERE products_id=\''.$opt[0].'\'
			       AND options_id=\''.$opt[1].'\'
			       AND options_values_id=\''.$opt[2].'\'
			 LIMIT 1
		');
	}

	if ($aID === false) {
		/* Temporaerer Fallback fuer bereits bestehende Artikel, alte Version */
		$aID = MagnaDB::gi()->fetchOne('
			SELECT products_attributes_id
			  FROM '.TABLE_PRODUCTS_ATTRIBUTES.' 
			 WHERE products_attributes_id = \''.$skuTmp.'\'
		');
	}

	return $aID;
}

function magnaPID2SKU($pID) {
	$sku = '';
	switch (getDBConfigValue('general.keytype', '0')) {
		case 'artNr': {
			$sku = MagnaDB::gi()->fetchOne('
				SELECT products_model FROM '.TABLE_PRODUCTS.' 
				 WHERE products_id=\''.$pID.'\' LIMIT 1
			');
			break;
		}
	}
	
	if (empty($sku)) {
		$sku = 'ML'.$pID;
	}
	
	return trim($sku);
}

function magnaAID2SKU($aID) {
	if ('artNr' == getDBConfigValue('general.keytype', '0')) {
		$attrModel = '';
		if (MagnaDB::gi()->columnExistsInTable('attributes_model', TABLE_PRODUCTS_ATTRIBUTES)) {
			$attrModel = (string)MagnaDB::gi()->fetchOne('
				SELECT attributes_model
				  FROM '.TABLE_PRODUCTS_ATTRIBUTES.' 
				 WHERE products_attributes_id = \''.$aID.'\'
			');
		}
		if (!empty($attrModel)) {
			return $attrModel;
		}
		$attr = MagnaDB::gi()->fetchRow('
			SELECT p.products_id, p.products_model, options_id, options_values_id
			  FROM '.TABLE_PRODUCTS_ATTRIBUTES.' pa, '.TABLE_PRODUCTS.' p
			 WHERE products_attributes_id = \''.$aID.'\' 
			       AND pa.products_id=p.products_id
		');
		return (empty($attr['products_model']) 
			? 'MLV'.$attr['products_id'].'_'.$attr['options_id'].'_'.$attr['options_values_id']
			: $attr['products_model'].'_MLV'.$attr['options_id'].'_'.$attr['options_values_id']
		);
	} else {
		$attr = MagnaDB::gi()->fetchRow('
			SELECT products_id, options_id, options_values_id
			  FROM '.TABLE_PRODUCTS_ATTRIBUTES.' 
			 WHERE products_attributes_id = \''.$aID.'\'
		');
		return 'MLV'.$attr['products_id'].'_'.$attr['options_id'].'_'.$attr['options_values_id'];
	}
}

function magnaSKU2pOpt($sku, $language = 'en') {
	$ret = array(
		'options_id' => 0,
		'options_name' => '',
		'options_values_id' => 0,
		'options_values_name' => '',
		'options_values_price' => 0.00,
		'price_prefix' => ''
	);

	$aID = magnaSKU2aID($sku);
	if ($aID === false) {
		return $ret;
	}
	$option = MagnaDB::gi()->fetchRow(' 		 
		SELECT options_id, options_values_id, options_values_price, price_prefix 		 
		  FROM '.TABLE_PRODUCTS_ATTRIBUTES.'  		 
	     WHERE products_attributes_id = \''.$aID.'\'
	     LIMIT 1 		 
	');

	if (($option === false) || ($option['options_id'] <= 0) || ($option['options_values_id'] <= 0)) {
		return $ret;
	}

	/* Name der Option und des Wertes (z.B. 'Groesse' und 'M/L') */
	if (empty($language)) {
		$language = 'en';
	}
	$products_options_name = MagnaDB::gi()->fetchOne('
		SELECT products_options_name 
		  FROM '.TABLE_PRODUCTS_OPTIONS.' po, '.TABLE_LANGUAGES.' l
		 WHERE products_options_id = \''.$option['options_id'].'\' 
		       AND po.language_id = l.languages_id 
		       AND LOWER(code) = LOWER(\''.$language.'\') 
		 LIMIT 1
	');
	$products_options_values_name = MagnaDB::gi()->fetchOne('
		SELECT products_options_values_name 
		  FROM '.TABLE_PRODUCTS_OPTIONS_VALUES.' pov, '.TABLE_LANGUAGES.' l
		 WHERE products_options_values_id=\''.$option['options_values_id'].'\'
		       AND pov.language_id = l.languages_id 
		       AND LOWER(code) = LOWER(\''.$language.'\')
		 LIMIT 1
	');
	/* Fallback falls Datensaetze fuer gegebene Sprache nicht vorhanden */
	if (empty($products_options_name)) {
		$products_options_name = MagnaDB::gi()->fetchOne('
			SELECT products_options_name 
			  FROM '.TABLE_PRODUCTS_OPTIONS.' po
			 WHERE products_options_id = \''.$option['options_id'].'\' 
			 LIMIT 1
		');
	}
	if (empty($products_options_values_name)) {
		$products_options_values_name = MagnaDB::gi()->fetchOne('
			SELECT products_options_values_name 
			  FROM '.TABLE_PRODUCTS_OPTIONS_VALUES.' pov
			 WHERE products_options_values_id=\''.$option['options_values_id'].'\'
			 LIMIT 1
		');
	}
	return array(
		'options_id' => $option['options_id'],
		'options_name' => $products_options_name,
		'options_values_id' => $option['options_values_id'],
		'options_values_name' => $products_options_values_name,
		'options_values_price' => $option['options_values_price'],
		'price_prefix' => $option['price_prefix']
	);
}

function renderPagination ($currentPage, $pages, $baseURL, $type = 'link') {
	$html = '';
	if ($pages > 23) {
		for ($i = 1; $i <= 5; ++$i) {
			$class = ($currentPage == $i) ? 'class="bold"' : '';
			if ($type == 'submit') {
				$html .= ' <input type="submit" '.$class.' name="page" value="'.$i.'" title="'.ML_LABEL_PAGE.' '.$i.'"/>';
			} else {
				$html .= ' <a '.$class.' href="'.toUrl($baseURL, array('page' => $i)).'" title="'.ML_LABEL_PAGE.' '.$i.'">'.$i.'</a>';
			}
		}
		if (($currentPage - 5) < 7) {
			$start = 6;
			$end = 15;
		} else {
			$start = $currentPage - 4;
			$end = $currentPage + 4;
			$html .= ' &hellip; ';
		}
		if (($currentPage + 5) > ($pages - 7)) {
			$start = ($pages - 15);
			$end = $pages;
		}
		for ($i = $start; $i <= $end; ++$i) {
			$class = ($currentPage == $i) ? 'class="bold"' : '';
			if ($type == 'submit') {
				$html .= ' <input type="submit" '.$class.' name="page" value="'.$i.'" title="'.ML_LABEL_PAGE.' '.$i.'"/>';
			} else {
				$html .= ' <a '.$class.' href="'.toUrl($baseURL, array('page' => $i)).'" title="'.ML_LABEL_PAGE.' '.$i.'">'.$i.'</a>';
			}
		}
		if ($end != $pages) {
			$html .= ' &hellip; ';
			for ($i = $pages - 5; $i <= $pages; ++$i) {
				$class = ($currentPage == $i) ? 'class="bold"' : '';
				if ($type == 'submit') {
					$html .= ' <input type="submit" '.$class.' name="page" value="'.$i.'" title="'.ML_LABEL_PAGE.' '.$i.'"/>';
				} else {
					$html .= ' <a '.$class.' href="'.toUrl($baseURL, array('page' => $i)).'" title="'.ML_LABEL_PAGE.' '.$i.'">'.$i.'</a>';
				}
			}
		}
	} else {
		for ($i = 1; $i <= $pages; ++$i) {
			$class = ($currentPage == $i) ? 'class="bold"' : '';
			if ($type == 'submit') {
				$html .= ' <input type="submit" '.$class.' name="page" value="'.$i.'" title="'.ML_LABEL_PAGE.' '.$i.'"/>';
			} else {
				$html .= ' <a '.$class.' href="'.toUrl($baseURL, array('page' => $i)).'" title="'.ML_LABEL_PAGE.' '.$i.'">'.$i.'</a>';
			}
		}
	}
	return $html;
}

function renderCategoryPath($id, $from = 'category') {
	$calculated_category_path_string = '';
	$appendedText = '&nbsp;<span class="cp_next">&gt;</span>&nbsp;';
	$calculated_category_path = MagnaDB::gi()->generateCategoryPath($id, $from);
	for ($i = 0, $n = sizeof($calculated_category_path); $i < $n; $i ++) {
		for ($j = 0, $k = sizeof($calculated_category_path[$i]); $j < $k; $j ++) {
			$calculated_category_path_string .= fixHTMLUTF8Entities($calculated_category_path[$i][$j]['text']).$appendedText;
		}
		$calculated_category_path_string = substr($calculated_category_path_string, 0, -strlen($appendedText)).'<br>';
	}
	$calculated_category_path_string = substr($calculated_category_path_string, 0, -4);

	if (strlen($calculated_category_path_string) < 1)
		$calculated_category_path_string = ML_LABEL_CATEGORY_TOP;

	return $calculated_category_path_string;
}

function loadConfigForm($lang, $files, $replace = array()) {
	$form = array();
	foreach ($files as $file => $options) {
		$fC = file_get_contents(DIR_MAGNALISTER.'config/'.$lang.'/'.$file);
		if (!empty($replace)) {
			$fC = str_replace(array_keys($replace), array_values($replace), $fC);
		}
		$fC = json_decode($fC, true);
		if (array_key_exists('unset', $options)) {
			foreach ($options['unset'] as $key) {
				unset($fC[$key]);
			}
		}
		$form = array_merge($form, $fC);
	}
	return $form;
}

function getTinyMCEDefaultConfigObject() {
	$langCode = MagnaDB::gi()->fetchOne('
		SELECT code FROM '.TABLE_LANGUAGES.' WHERE languages_id=\''.$_SESSION['languages_id'].'\' LIMIT 1
	');
	if (!empty($langCode) && file_exists(DIR_MAGNALISTER.'js/tiny_mce/langs/'.$langCode.'.js')) {
		$langCode = 'language: "'.$langCode.'",';
	} else {
		$langCode = '';
	}

	return '
if (typeof tinyMCEMagnaDefaultConfig == "undefined") {
	var tinyMCEMagnaDefaultConfig = {
		// General options
		mode : "textareas",
		theme : "advanced",
		'.$langCode.'
		skin : "o2k7",
		skin_variant : "silver",
		editor_selector : "tinymce",
		plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
	
		// Theme options
		theme_advanced_buttons1 : "fullscreen,preview,code,|,undo,redo,|,bold,italic,underline,strikethrough,|,styleprops,|,forecolor,backcolor,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,link,unlink,anchor,image,cleanup,|,charmap,emotions,iespell,media,advhr,|,insertdate,inserttime",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,insertlayer,moveforward,movebackward,absolute,|,visualchars,nonbreaking",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		theme_advanced_resize_horizontal : false,
		// Example content CSS (should be your site CSS)
		//content_css : "style/style.css",
	
		width: "100%",
		valid_elements : "*[*]",
		invalid_elements : "",
		valid_children : "+body[style]",
		extended_valid_elements : "style[width], a[href|#]",
	
		// Drop lists for link/image/media/template dialogs
		//template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",
	
		relative_urls : false,
		document_base_url : "'.DIR_WS_CATALOG.'",
		remove_script_host : false,
		media_strict: false,
		
		gecko_spellcheck : true,
	
		autosave_ask_before_unload : true
	}
}';
}

function magna_wysiwyg($params, $value = '') {
	if (array_key_exists('class', $params)) {
		$params['class'] .= ' tinymce';
	} else {
		$params['class'] = 'tinymce';
	}
	$html = '<textarea';
	foreach ($params as $attr => $val) {
		$html .= ' '.$attr.'="'.$val.'"';
	}
	$html .= '>'.str_replace('<', '&lt;', (string)$value).'</textarea>';

    if ('tinyMCE' == getDBConfigValue('general.editor',0,'tinyMCE')) {

	    $html .= '<script type="text/javascript" src="includes/magnalister/js/tiny_mce/tiny_mce.js"></script>';

	    ob_start();?>
        <script type="text/javascript">/*<![CDATA[*/
    	    <?php echo getTinyMCEDefaultConfigObject(); ?>
		    $(document).ready(function() {
			    tinyMCE.init(tinyMCEMagnaDefaultConfig);
		    });
	    /*]]>*/</script><?php
	    $html .= ob_get_contents();
	    ob_end_clean();
    }
	return $html;
}

function magnaFixRamSize() {
	$nr = defined('ML_DEFAULT_RAM') ? ML_DEFAULT_RAM : '256M';
	$ramsize = @ini_get('memory_limit');
	if (!is_string($ramsize) || empty($ramsize)) {
		return @(bool)ini_set('memory_limit', $nr);
	}
	if (convert2Bytes($ramsize) < convert2Bytes($nr)) {
		return @(bool)ini_set('memory_limit', $nr);
	}
	return false;
}

function magnaFooterDebugTimers() {
	if (!defined('MAGNALISTER_PLUGIN') && file_exists(DIR_FS_DOCUMENT_ROOT.'magnaCallback.php')
		&& defined('MAGNA_DEBUG') && MAGNA_DEBUG
	) {
		global $_magnacallbacktimer, $_executionTime;

		echo '
		<style>
		textarea.apiRequestTime {
			border: 2px solid #ccc;
			background: #f8f8f8;
			color: #f8f8f8;
			border-radius: 5px;
			-moz-border-radius: 5px;
			-webkit-border-radius: 5px;
			width: 5px !important;
			height: 5px !important;
			padding: 0 !important;
			margin: 0 0 3px 0;
			overflow: hidden;
			font: 11px/1em monospace;
			display: block;
			-moz-box-sizing: content-box;
			-webkit-box-sizing: content-box;
			resize: none;
		}
		textarea.apiRequestTime:hover {
			color: #333;
			width: 100% !important;
			height: 300px !important;
			margin-top: -298px;
			position: relative;
			overflow: auto;
			padding: 3px 3px 0 3px !important;
			box-shadow: 0 0 15px rgba(0, 0, 0, 0.7), 0 0 2px 2px rgba(0, 0, 0, 0.3);
			-moz-box-shadow: 0 0 15px rgba(0, 0, 0, 0.7), 0 0 2px 2px rgba(0, 0, 0, 0.3);
			-webkit-box-shadow: 0 0 15px rgba(0, 0, 0, 0.7), 0 0 2px 2px rgba(0, 0, 0, 0.3);
		}
		div#magnaErrors {
			position: relative;
			width: 100%;
		}
		div#magnaErrors table {
			border-collapse: separate;
			border-spacing: 2px;
			width: 100%;
			position: relative;
			border: 2px solid #f00;
		}
		div#magnaErrors table th,
		div#magnaErrors table td {
			padding: 3px 5px;
			vertical-align: top;
		}
		div#magnaErrors table thead th {
			background: #444;
			color: #fff;
			font-weight: bold;
		}
		div#magnaErrors table tbody.odd td {
			background: #aaa;
			color: #000;
		}
		div#magnaErrors table tbody.even td {
			background: #ccc;
			color: #000;
		}
		div#magnaErrors table tbody td.level {	
			font-weight: bold;
		}
		div#magnaErrors table tbody td.level.notice {	
			background: #C9FF48;
			color: #000;
		}
		div#magnaErrors table tbody td.level.warning {	
			background: #FFB548;
			color: #000;
		}
		div#magnaErrors table tbody td.level.fatal {	
			background: #FF4848;
			color: #000;
		}
		div#magnaErrors table tbody td.message {
			position: relative;
		}
		div#magnaErrors table tbody td.action textarea,
		div#magnaErrors table tbody td.message pre {
			display: none;
			position: absolute;
			background: #fff;
			color: #000;
			border: 2px solid #999;
			z-index: 2;
			padding: 3px;
			margin-top: -2px;
			left: 0;
			width: 100%;
			overflow: auto;
		}
		div#magnaErrors table tbody td.message:hover pre {
			bottom: 1em;
			display: block;
			max-height: 450px;
		}
		div#magnaErrors table tbody td.action:hover textarea {
			display: block;
		    color: #333333;
		    height: 300px !important;
		    overflow: auto;
		    padding: 3px 3px 0 !important;
		    width: 100% !important;
		    font: 11px/1em monospace;
		    margin-top: -330px;
		}
		#magnaFootDebugger {
			text-align: left;
			background: #fff;
			border: 2px solid #999;
			font: 11px/1.2em sans-serif;
			padding: 5px;
		}
		#magnaFootDebugger hr {
			border-top: none;
			border-left: none;
			border-right: none;
			border-bottom: 1px solid #999;
		}
		</style>
		<div id="magnaFootDebugger">
			magnaCallback Time: <b>'.microtime2human($_magnacallbacktimer).'</b><br/><hr/>';
	
		if (class_exists('MagnaDB') && class_exists('MagnaConnector')) {
			$_executionTime = microtime(true) -  $_executionTime;
			$memory = memory_usage();
			echo '
				Entire page served in <b>'.microtime2human($_executionTime).'.</b><br/><hr/>
				API-Request Time: '.microtime2human(MagnaConnector::gi()->getRequestTime()).'. <br/>
				Processing Time: '.microtime2human($_executionTime - MagnaConnector::gi()->getRequestTime()).'. <br/><hr/>
				'.(($memory !== false) ? 'Max. Memory used: <b>'.$memory.'</b>. <br/><hr/>' : '').'
		     	DB-Stats (only MagnaDB Queries!): <br/>
		     	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Queries used: <b>'.MagnaDB::gi()->getQueryCount().'</b><br/>
		     	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Query time: '.microtime2human(MagnaDB::gi()->getRealQueryTime()).'<br/><hr/>
			';
		}
		if (class_exists('MagnaConnector')) {
			$tpR = MagnaConnector::gi()->getTimePerRequest();
			if (!empty($tpR)) {
				echo '<textarea class="apiRequestTime" readonly="readonly" spellcheck="false" wrap="off">';
				foreach ($tpR as $item) {
					echo print_m($item['request'], microtime2human($item['time']).' ['.$item['status'].']', true)."\n";
				}
				echo '</textarea>';
			}
		}
		if (class_exists('MagnaDB')) {
			$tpR = MagnaDB::gi()->getTimePerQuery();
			if (!empty($tpR)) {
				echo '<textarea class="apiRequestTime" readonly="readonly" spellcheck="false" wrap="off">';
				foreach ($tpR as $item) {
					echo print_m(ltrim(rtrim($item['query'], "\n"), "\n"), microtime2human($item['time']), true)."\n";
				}
				echo '</textarea>';
			}
		}
		$err = MagnaError::gi()->exceptionsToHTML(false);
		if (!empty($err)) {
			echo '<br/><hr/><div id="magnaErrors"><div>'.$err.'</div></div>';
		}
		
		echo '</div>';
	}
}

function magnaGenerateNavStructure() {
	global $magnaConfig, $_modules;
	
	$alwaysDisplayedModules = array();
	foreach ($_modules as $key => $item) {
		if ($item['displayAlways']) {
			$alwaysDisplayedModules[$key] = true;
		}
	}
	
	if (!isset($magnaConfig['maranon']['Marketplaces']) 
		|| !is_array($magnaConfig['maranon']['Marketplaces'])
	) {
		$magnaConfig['maranon']['Marketplaces'] = array();
	}
	$structure = array();
	
	$doinavtive = true;
	
	if (!empty($magnaConfig['maranon']['Marketplaces'])) {
		foreach ($magnaConfig['maranon']['Marketplaces'] as $mpID => $key) {
			$curItem = array ();
			
			$item = $_modules[$key];
	
			$classes = array();
			if (array_key_exists($key, $alwaysDisplayedModules)) {
				unset($alwaysDisplayedModules[$key]);
			}
			if (array_key_exists('mp', $_GET) && ($_GET['mp'] == $mpID)) {
				$classes[] = 'selected';
			}
			$curItem['title'] = isset($item['subtitle']) 
							? $item['subtitle'] 
							: $item['title'];
			$curItem['label'] = getDBConfigValue(array('general.tabident', $mpID), '0', '');
			$curItem['url']   = toURL(array('mp' => $mpID));
			$curItem['image'] = isset($item['logo'])
							? DIR_MAGNALISTER_IMAGES.'logos/'.$item['logo'].'.png'
							: '';
			$curItem['class'] = implode(' ', $classes);
			$curItem['key']   = $key.'_'.$mpID;
			
			$structure[] = $curItem;
		}
	} else {
		$doinavtive = false;
	}
	if (!empty($alwaysDisplayedModules)) {
		$curModule = isset($_GET['module']) ? $_GET['module'] : '';
		foreach ($alwaysDisplayedModules as $key => $null) {
			$item = $_modules[$key];
	
			$classes = array();
			if ($curModule == $key) {
				$classes[] = 'selected';
			}
			if ((!isset($item['type']) || ($item['type'] != 'system')) && $doinavtive) {
				$classes[] = 'inactive';
			}
			$curItem = array();
			
			$curItem['title'] = isset($item['subtitle']) 
							? $item['subtitle'] 
							: $item['title'];
			$curItem['label'] = '';
			$curItem['url']   = toURL(array('module' => $key));
			$curItem['image'] = isset($item['logo'])
							? DIR_MAGNALISTER_IMAGES.'logos/'.$item['logo'].'_inactive.png'
							: '';
			$curItem['class'] = implode(' ', $classes);
			$curItem['key']   = $key;
			
			$structure[] = $curItem;
		}
	}
	return $structure;
}

function magnaGenerateSideNav($args) {
	global $magnaConfig;
	
	$structure = magnaGenerateNavStructure();
	if (empty($structure)) {
		$structure = array (array (
			'class' => '',
			'key' => 'MAIN',
			'url' => toURL(),
			'title' => 'magnalister Admin',
		));
	}
	$html = '';

	switch (SHOPSYSTEM) {
		case 'gambio': {
			if (isset($args['out']) && ($args['out'] == 'xml')) {
				$base = toURL().'?';
				$sort = 0;
				foreach ($structure as $item) {
					$html .= '
						<menuitem link="FILENAME_MAGNALISTER" sort="'.(++$sort).'" '.
						         'link_param="'.str_replace($base, '', $item['url']).'" '.
						         'title="'.$item['title'].'"'.
						'></menuitem>';
				}
			} else {
				$html .= '
					<div class="leftmenu_head" '.
						'style="background-image:url('.DIR_MAGNALISTER_IMAGES.'magnalister_gambio_icon.png)">'.
						'<a id="FILENAME_MAGNALISTER_TOP" href="' . toURL() . '" class="fav_drag_item ui-draggable">'.
						'Marketing</a></div>
					<div class="leftmenu_collapse leftmenu_collapse_opened"> </div>
	       			<ul class="leftmenu_box" id="BOX_MAGNALISTER_LINK">';
       			foreach ($structure as $item) {
       				$item['title'] .= !empty($item['label']) 
       					? ' :: '.strip_tags(str_replace(
							array('&lt;', '&gt;', '&quot;'),
							array('<', '>', '"'),
							fixHTMLUTF8Entities($item['label'])
						)) 
       					: '';
       				$html .= '<li class="leftmenu_body_item '.$item['class'].'">'.
       					'<a id="BOX_MAGNA_'.strtoupper($item['key']).'" href="'.$item['url'].'" '.
       						'class="fav_drag_item ui-draggable" '.
       						'title="'.$item['title'].'">'.$item['title'].'</a></li>';
       			}
	       		$html .= '</ul>';
	       	}
		}
	}
	return $html;

}
