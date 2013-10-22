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
 * $Id: apply.php 1131 2011-07-06 21:25:39Z derpapst $
 *
 * (c) 2010 RedGecko GmbH -- http://www.redgecko.de
 *     Released under the GNU General Public License v2 or later
 * -----------------------------------------------------------------------------
 */

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');
require_once(DIR_MAGNALISTER_MODULES.'amazon/amazonFunctions.php');

function amazonSanitizeDesc($str) {
	$str = str_replace(array('&nbsp;', html_entity_decode('&nbsp;')), ' ', $str);	
	$str = sanitizeProductDescription(
		$str, 
		'<ul><ol><li><u><b><i><p><big><small><h1><h2><h3><h4><h5><h6><span>'.
		'<hr><strike><s><br><strong><em><i>',
		'_keep_all_'
	);
	$str = str_replace(array('<br />', '<br/>'), '<br>', $str);
	$str = preg_replace('/(\s*<br[^>]*>\s*)*$/', '', $str);
	$str = preg_replace('/\s\s+/', ' ', $str);
	return substr($str, 0, 2000);
}

function populateGenericData($pID, $edit = false) {
	global $_MagnaSession;
	
	$genericDataStructure = array (
		'MainCategory' => '',
		'ProductType' => '',
		'BrowseNodes' => array (),
		'ItemTitle' => '',
		'Manufacturer' => '',
		'Brand' => '',
		'ManufacturerPartNumber' => '',
		'EAN' => '',
		'Images' => array (),
		'BulletPoints' => array ('', '', '', '', ''),
		'Description' => '',
		'Keywords' => array ('', '', '', '', ''),
		'Attributes' => array (
		),
	);
	$product = MagnaDB::gi()->getProductById(
		$pID, getDBConfigValue('amazon.lang', $_MagnaSession['mpID'], $_SESSION['languages_id'])
	);
	if ($product === false) {
		return $genericDataStructure;
	}
	if ($product['manufacturers_id'] > 0) {
		$genericDataStructure['Manufacturer'] = $genericDataStructure['Brand'] = MagnaDB::gi()->fetchOne('
			SELECT manufacturers_name 
			  FROM '.TABLE_MANUFACTURERS.' 
			 WHERE manufacturers_id=\''.$product['manufacturers_id'].'\'
		');
	}
	if (empty($genericDataStructure['Manufacturer'])) {
		$genericDataStructure['Manufacturer'] = $genericDataStructure['Brand'] = getDBConfigValue(
			'amazon.prepare.manufacturerfallback', $_MagnaSession['mpID'], ''
		);
	}
	$mfrmd = getDBConfigValue('amazon.prepare.manufacturerpartnumber.table', $_MagnaSession['mpID'], false);
	if (is_array($mfrmd) && !empty($mfrmd['column']) && !empty($mfrmd['table'])) {
		$pIDAlias = getDBConfigValue('amazon.prepare.manufacturerpartnumber.alias', $_MagnaSession['mpID']);
		if (empty($pIDAlias)) {
			$pIDAlias = 'products_id';
		}
		$genericDataStructure['ManufacturerPartNumber'] = MagnaDB::gi()->fetchOne('
			SELECT `'.$mfrmd['column'].'` 
			  FROM `'.$mfrmd['table'].'` 
			 WHERE `'.$pIDAlias.'`=\''.MagnaDB::gi()->escape($pID).'\'
			 LIMIT 1
		');
	}
	if (!empty($product['products_allimages'])) {
		foreach ($product['products_allimages'] as $img) {
			$genericDataStructure['Images'][$img] = 'true';
		}
	}
	$genericDataStructure['ItemTitle'] = $product['products_name'];
	$genericDataStructure['EAN'] = $product[MAGNA_FIELD_PRODUCTS_EAN];
	$genericDataStructure['Description'] = amazonSanitizeDesc($product['products_description']);
	
	$trimFunc = create_function('&$v, $k', '$v = trim($v);');

	$product['products_meta_description'] = explode(',', $product['products_meta_description']);
	array_walk($product['products_meta_description'], $trimFunc);
	$genericDataStructure['BulletPoints'] = array_slice($product['products_meta_description'], 0, 5);
	# Laenge auf 500 Zeichen beschraenken
	if (!empty($genericDataStructure['BulletPoints'])) {
		foreach ($genericDataStructure['BulletPoints'] as &$bullet) {
			$bullet = trim($bullet);
			if (empty($bullet)) continue;
			$bullet = substr($bullet, 0, strpos(wordwrap($bullet, 500, "\n", true)."\n", "\n"));
		}
	}
	$genericDataStructure['BulletPoints'] = array_pad($genericDataStructure['BulletPoints'], 5, '');

	$product['products_meta_keywords'] = explode(',', $product['products_meta_keywords']);
	array_walk($product['products_meta_keywords'], $trimFunc);
	$genericDataStructure['Keywords'] = array_slice($product['products_meta_keywords'], 0, 5);
	# Laenge auf 50 Zeichen beschraenken
	if (!empty($genericDataStructure['Keywords'])) {
		foreach ($genericDataStructure['Keywords'] as &$keyword) {
			$keyword = trim($keyword);
			if (empty($keyword)) continue;
			$keyword = substr($keyword, 0, strpos(wordwrap($keyword, 50, "\n", true)."\n", "\n"));
		}
	}
	$genericDataStructure['Keywords'] = array_pad($genericDataStructure['Keywords'], 5, '');

	$dbData = MagnaDB::gi()->fetchOne('
		SELECT data FROM '.TABLE_MAGNA_AMAZON_APPLY.'
		 WHERE mpID=\''.$_MagnaSession['mpID'].'\' AND
		       '.((getDBConfigValue('general.keytype', '0') == 'artNr')
					? 'products_model=\''.$product['products_model'].'\''
					: 'products_id = \''.$pID.'\''
				).'
		 LIMIT 1
	');

	# Folgende 3 Zeilen auskommentieren, falls die bereits gespeicherten Produktdaten zur Beantragung
	# nicht ueberschrieben werden sollen.
	if (!$edit) {
		$dbData = false;
	}

	if ($dbData !== false) {
		$dbData = base64_decode($dbData);
		$dbData = unserialize($dbData);
		if (is_array($dbData) && !empty($dbData)) {
			$existingImages = $genericDataStructure['Images'];
			$genericDataStructure = array_merge(
				$genericDataStructure,
				$dbData
			);
			$savedImages = $genericDataStructure['Images'];
			if (!empty($existingImages)) {
				foreach ($existingImages as $img => $checked) {
					$genericDataStructure['Images'][$img] = (
						(is_array($savedImages) && array_key_exists($img, $savedImages)) ? $savedImages[$img] : 'false'
					);
				}
			}
		}
	}
	
	//echo print_m($genericDataStructure);
	return $genericDataStructure;
}

$_url['view'] = 'apply';
$applySetting = array(
	'selectionName' => 'apply'
);

$applyAction = 'categoryview';

setDBConfigValue(
	array(
		$_MagnaSession['currentPlatform'].'.'.$applySetting['selectionName'].'.status', 'val'
	), 
	$_MagnaSession['mpID'],
	getDBConfigValue(array($_MagnaSession['currentPlatform'].'.matching.status', 'val'), $_MagnaSession['mpID'], false)
);

if (!empty($_POST) && (!isset($_GET['kind']) || ($_GET['kind'] != 'ajax'))) {
//	echo print_m($_POST);
//	echo var_export_pre($_POST, '$_POST');
}

if (!empty($_POST) && isset($_GET['kind']) && ($_GET['kind'] == 'ajax')) {
	if (isset($_GET['applyAction'])) {
		$applyAction = $_GET['applyAction'];
	}
}

/**
 * Daten speichern
 */
if (array_key_exists('saveApplyData', $_POST)) {
	$requiredData = array (
		'MainCategory' => ML_LABEL_MAINCATEGORY,
		#'ProductType' => ML_LABEL_SUBCATEGORY,
		'BrowseNodes' => ML_AMAZON_LABEL_APPLY_BROWSENODES,
		'ItemTitle' => ML_LABEL_PRODUCT_NAME,
		'Manufacturer' => ML_GENERIC_MANUFACTURER_NAME,
	);

	$itemDetails = $_POST;
	unset($itemDetails['saveApplyData']);

	$pIDs = MagnaDB::gi()->fetchArray('
		SELECT pID FROM '.TABLE_MAGNA_SELECTION.'
		 WHERE mpID=\''.$_MagnaSession['mpID'].'\' AND
		       selectionname=\''.$applySetting['selectionName'].'\' AND
		       session_id=\''.session_id().'\'
	', true);
	if (!empty($pIDs)) {
		$missingItems = array();

		foreach ($pIDs as $pID) {
			$data = array_merge(
				populateGenericData($pID),
				$itemDetails
			);
			arrayEntitiesToUTF8($data);

			foreach ($requiredData as $key => $title) {
				if (empty($data[$key]) || ($data[$key] == 'null')) {
					$missingItems[$pID][] = $title;
				}
			}

			$productModel = MagnaDB::gi()->fetchOne('
				SELECT products_model
				  FROM '.TABLE_PRODUCTS.'
				 WHERE products_id='.$pID
			);
			#echo print_m($missingItems);
			$data = array (
				'mpID' => $_MagnaSession['mpID'],
				'products_id' => $pID,
				'products_model' => $productModel,
				'data' => base64_encode(serialize($data)),
				'is_incomplete' => array_key_exists($pID, $missingItems) ? 'true' : 'false',
			);
			$where = (getDBConfigValue('general.keytype', '0') == 'artNr')
				? array ('products_model' => $data['products_model'])
				: array ('products_id'    => $data['products_id']);
			$where['mpID'] = $_MagnaSession['mpID'];

			$swhere = 'WHERE ';
			foreach ($where as $key => $value) {
				$swhere .= '`'.$key.'` = \''.$value.'\' AND ';
			}
			$swhere = rtrim($swhere, ' AND ');

			if (($count = (int)MagnaDB::gi()->fetchOne('SELECT count(*) FROM `'.TABLE_MAGNA_AMAZON_APPLY.'` '.$swhere)) > 0) {
				if ($count > 1) {
					MagnaDB::gi()->query('DELETE FROM `'.TABLE_MAGNA_AMAZON_APPLY.'` '.$swhere.' LIMIT '.($count - 1));
				}
				MagnaDB::gi()->update(TABLE_MAGNA_AMAZON_APPLY, $data, $where);
			} else {
				MagnaDB::gi()->insert(TABLE_MAGNA_AMAZON_APPLY, $data);
			}
			if (!array_key_exists($pID, $missingItems)) {
				MagnaDB::gi()->delete(TABLE_MAGNA_SELECTION, array(
					'pID' => $pID,
					'mpID' => $_MagnaSession['mpID'],
				    'selectionname' => $applySetting['selectionName'],
				    'session_id' => session_id()
				));
			}
		}
		if (!empty($missingItems)) {
			echo '
				<p class="noticeBox">'.ML_AMAZON_TEXT_APPLY_DATA_INCOMPLETE.'</p>
			    <table class="datagrid">
			    	<thead><tr>
			    		<th>'.ML_LABEL_PRODUCTS_ID.'</th>
			    		<th>'.ML_LABEL_ARTICLE_NUMBER.'</th>
			    		<th>'.ML_LABEL_PRODUCT_NAME.'</th>
			    		<th>'.ML_AMAZON_LABEL_MISSING_FIELDS.'</th>
			    		<th>&nbsp;</th>
			    	</tr></thead>
			    	<tbody>';
		    $oddEven = true;
		    $i = 0;
			foreach ($missingItems as $pID => $items) {
				if ($i > 20) {
					echo '
						<tr class="'.(($oddEven = !$oddEven) ? 'odd' : 'even').'">
							<td colspan="5" class="textcenter bold">&hellip;</td>
						</tr>';
					break;
				}
				$product = MagnaDB::gi()->getProductById($pID);
				echo '
						<tr class="'.(($oddEven = !$oddEven) ? 'odd' : 'even').'">
							<td>'.$pID.'</td>
							<td>'.$product['products_model'].'</td>
							<td>'.$product['products_name'].'</td>
							<td>'.implode(',', $items).'</td>
							<td><a class="gfxbutton edit" title="bearbeiten" target="_blank" href="'.toURL($_url, array('edit' => $pID)).'">&nbsp;</a></td>
						</tr>';
				++$i;
			}
			echo '
					</tbody>
				</table>';
		}
	}
}

/**
 * Daten loeschen
 */
if (array_key_exists('removeapply', $_POST)) {
 	$pIDs = MagnaDB::gi()->fetchArray('
		SELECT pID FROM '.TABLE_MAGNA_SELECTION.'
		 WHERE mpID=\''.$_MagnaSession['mpID'].'\' AND
		       selectionname=\''.$applySetting['selectionName'].'\' AND
		       session_id=\''.session_id().'\'
	', true);
	if (!empty($pIDs)) {
		foreach ($pIDs as $pID) {
			$where = (getDBConfigValue('general.keytype', '0') == 'artNr')
				? array ('products_model' => MagnaDB::gi()->fetchOne('
							SELECT products_model
							  FROM '.TABLE_PRODUCTS.'
							 WHERE products_id='.$pID
						))
				: array ('products_id'    => $pID);
			$where['mpID'] = $_MagnaSession['mpID'];

			MagnaDB::gi()->delete(TABLE_MAGNA_AMAZON_APPLY, $where);
			MagnaDB::gi()->delete(TABLE_MAGNA_SELECTION, array(
				'pID' => $pID,
				'mpID' => $_MagnaSession['mpID'],
			    'selectionname' => $applySetting['selectionName'],
			    'session_id' => session_id()
			));
		}
	}
}

if (isset($_GET['edit']) && MagnaDB::gi()->recordExists(TABLE_MAGNA_AMAZON_APPLY, array(
	'mpID' => $_MagnaSession['mpID'],
	'products_id' => (int)$_GET['edit']
))) {
	MagnaDB::gi()->delete(TABLE_MAGNA_SELECTION, array(
		'mpID' => $_MagnaSession['mpID'],
	    'selectionname' => $applySetting['selectionName'],
	    'session_id' => session_id()
	));
	MagnaDB::gi()->insert(TABLE_MAGNA_SELECTION, array(
		'pID' => (int)$_GET['edit'],
		'data' => serialize(array()),
		'mpID' => $_MagnaSession['mpID'],
		'selectionname' => $applySetting['selectionName'],
		'session_id' => session_id(),
		'expires' => gmdate('Y-m-d H:i:s')
	));
	$_POST['apply'] = 'EDITMODE';
}

/**
 * Beantragen Vorbereitung
 */
if (array_key_exists('apply', $_POST) && (!empty($_POST['apply']))) {
	$itemCount = (int)MagnaDB::gi()->fetchOne('
		SELECT count(*) FROM '.TABLE_MAGNA_SELECTION.'
		 WHERE mpID=\''.$_MagnaSession['mpID'].'\' AND
		       selectionname=\''.$applySetting['selectionName'].'\' AND
		       session_id=\''.session_id().'\'
	  GROUP BY selectionname
	');

	if ($itemCount == 1) {
		$applyAction = 'singleapplication';
	} else if ($itemCount > 1) {
		$applyAction = 'multiapplication';
	}
}

if (($applyAction == 'singleapplication') || ($applyAction == 'multiapplication')) {
	include_once(DIR_MAGNALISTER_MODULES.'amazon/application/applicationviews.php');

} else {
	require_once(DIR_MAGNALISTER_MODULES.'amazon/classes/ApplyCategoryView.php');

	$aCV = new ApplyCategoryView(
		$current_category_id, $applySetting,  /* $current_category_id is a global variable from xt:Commerce */
		(isset($_GET['sorting']) ? $_GET['sorting'] : ''),
		(isset($_POST['tfSearch']) ? $_POST['tfSearch'] : '')
	);
	if (isset($_GET['kind']) && ($_GET['kind'] == 'ajax')) {
		echo $aCV->renderAjaxReply();
	} else {
		echo $aCV->printForm();
	}
}
