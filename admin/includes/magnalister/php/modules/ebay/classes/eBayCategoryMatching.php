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
 * $Id: categorymatching.php 674 2011-01-08 03:21:50Z derpapst $
 *
 * (c) 2010 RedGecko GmbH -- http://www.redgecko.de
 *     Released under the GNU General Public License v2 or later
 * -----------------------------------------------------------------------------
 */

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

class eBayCategoryMatching {
	const EBAY_CAT_VALIDITY_PERIOD = 86400; # Nach welcher Zeit werden Kategorien ungueltig (Sekunden)
	const EBAY_STORE_CAT_VALIDITY_PERIOD = 600; # Nach welcher Zeit werden Store-Kategorien ungueltig (Sekunden)
	
	private $request = 'view';
	private $isStoreCategory = false;

	private $url;
    private $SiteID;

	public function __construct($request = 'view') {
		global $_url;
		
		$this->request = $request;
		$this->url = $_url;

        $this->SiteID = geteBaySiteID();
	}
	
	# Die Funktion wird verwendet beim Aufruf der Kategorie-Zuordnung, nicht vorher.
	# Beim Aufruf werden die Hauptkategorien gezogen,
	# und beim Anklicken der einzelnen Kategorie die Kind-Kategorien, falls noch nicht vorhanden.
	private static function importeBayCategories($ParentID = 0) {
		try {
			$categories = MagnaConnector::gi()->submitRequest(array(
				'ACTION' => 'GetChildCategories',
				'DATA' => array('ParentID' => $ParentID)
			));
		} catch (MagnaException $e) {
			$categories = array(
				'DATA' => false
			);
		}
		if (!is_array($categories['DATA']) || empty($categories['DATA'])) {
			return false;
		}
		$now = time();
		foreach($categories['DATA'] as &$curRow) {
			$curRow['InsertTimestamp'] = $now;
			$curRow['StoreCategory'] = '0';
		}
		$delete_query = 'DELETE FROM '.TABLE_MAGNA_EBAY_CATEGORIES
			.' WHERE StoreCategory=\'0\'
			AND SiteID = '.$categories['DATA'][0]['SiteID'].'
			AND ParentID = ';
		# ganz oben ist CategoryID == ParentID
		if (0 == $ParentID)	$delete_query .= 'CategoryID';
		else			$delete_query .= $ParentID.' AND ParentID <> CategoryID';
		MagnaDB::gi()->query($delete_query);
		MagnaDB::gi()->batchinsert(TABLE_MAGNA_EBAY_CATEGORIES, $categories['DATA'], true);
		return true;
	}
	
	# Das gleiche fuer Store-Categories.
	# Nur: Es wird immer der ganze Kategorie-Baum abgerufen (die Datenmenge ist uebersichtlich)
	private static function importeBayStoreCategories() {
		try {
			$categories = MagnaConnector::gi()->submitRequest(array(
				'ACTION' => 'GetStoreCategories',
			));
		} catch (MagnaException $e) {
			$categories = array(
				'DATA' => false
			);
		}
		if (!is_array($categories['DATA']) || empty($categories['DATA'])) {
			return false;
		}
		// echo print_m($categories);
		$now = time();
		foreach($categories['DATA'] as &$curRow) {
			$curRow['SiteID'] = $curRow['mpID'];
			unset($curRow['mpID']);
			$curRow['InsertTimestamp'] = $now;
			$curRow['StoreCategory'] = '1';
		}
		$categories = array_values($categories['DATA']);
		MagnaDB::gi()->query('DELETE FROM '.TABLE_MAGNA_EBAY_CATEGORIES.' WHERE StoreCategory=\'1\'');
		MagnaDB::gi()->batchinsert(TABLE_MAGNA_EBAY_CATEGORIES, $categories, true);
		return true;
	}
	
	private function geteBayCategories($ParentID = 0) {
		if (0 == $ParentID) {
			$whereCondition = 'CategoryID = ParentID';
		} else {
			$whereCondition = "CategoryID != ParentID AND ParentID = $ParentID";
		}
		
		$ebayCategories = MagnaDB::gi()->fetchArray('
			SELECT DISTINCT CategoryID, SiteID, CategoryName,
				CategoryLevel, ParentID, LeafCategory
			  FROM '.TABLE_MAGNA_EBAY_CATEGORIES.'
			 WHERE '.$whereCondition.'
			 AND StoreCategory = \'0\'
             AND SiteID = '.$this->SiteID.'
			 AND InsertTimestamp > UNIX_TIMESTAMP() - '.self::EBAY_CAT_VALIDITY_PERIOD.'
			 ORDER BY CategoryName ASC
		');
		
		# nichts gefunden? vom Server abrufen
		if (empty($ebayCategories)) {
			if (self::importeBayCategories($ParentID)) {
				# Wenn Daten bekommen, noch mal select
				$ebayCategories = MagnaDB::gi()->fetchArray('
					SELECT DISTINCT CategoryID, SiteID, CategoryName,
						CategoryLevel, ParentID, LeafCategory
			  		FROM '.TABLE_MAGNA_EBAY_CATEGORIES.'
			 		WHERE '.$whereCondition.'
					AND StoreCategory = \'0\'
                    AND SiteID = '.$this->SiteID.'
			 		ORDER BY CategoryName ASC
				');
			}
		}

		if (empty($ebayCategories)) {
			return false;
		}
		return $ebayCategories;
	}

	private function geteBayStoreCategories($ParentID = 0) {
		if (0 == $ParentID) {
			$whereCondition = 'CategoryID = ParentID';
		} else {
			$whereCondition = 'CategoryID != ParentID AND ParentID = '.$ParentID;
		}
		
		$ebayCategories = MagnaDB::gi()->fetchArray('
			SELECT DISTINCT CategoryID, SiteID, CategoryName,
				CategoryLevel, ParentID, LeafCategory
			  FROM '.TABLE_MAGNA_EBAY_CATEGORIES.'
			 WHERE '.$whereCondition.'
			 AND StoreCategory = \'1\'
			 AND InsertTimestamp > UNIX_TIMESTAMP() - '.self::EBAY_STORE_CAT_VALIDITY_PERIOD.'
			 ORDER BY CategoryName ASC
		');
		
		# nichts gefunden? vom Server abrufen
		if (empty($ebayCategories)) {
			if (self::importeBayStoreCategories($ParentID)) {
				# Wenn Daten bekommen, noch mal select
				$ebayCategories = MagnaDB::gi()->fetchArray('
					SELECT DISTINCT CategoryID, SiteID, CategoryName,
						CategoryLevel, ParentID, LeafCategory
			  		FROM '.TABLE_MAGNA_EBAY_CATEGORIES.'
			 		WHERE '.$whereCondition.'
					AND StoreCategory = \'1\'
			 		ORDER BY CategoryName ASC
				');
			}
		}
		if (empty($ebayCategories)) {
			return false;
		}
		return $ebayCategories;
	}

	private function rendereBayCategories($ParentID = 0) {
		if ($this->isStoreCategory) {
			$ebaySubCats = $this->geteBayStoreCategories($ParentID);
		} else {
			$ebaySubCats = $this->geteBayCategories($ParentID);
		}
		if ($ebaySubCats === false) {
			return '';
		}
		$ebayTopLevelList = '';
		foreach ($ebaySubCats as $item) {
			if (1 == $item['LeafCategory']) {
				$class = 'leaf';
			} else {
				$class = 'plus';
			}
			$ebayTopLevelList .= '
				<div class="catelem" id="y_'.$item['CategoryID'].'">
					<span class="toggle '.$class.'" id="y_toggle_'.$item['CategoryID'].'">&nbsp;</span>
					<div class="catname" id="y_select_'.$item['CategoryID'].'">
						<span class="catname">'.fixHTMLUTF8Entities($item['CategoryName']).'</span>
					</div>
				</div>';
		}
		return $ebayTopLevelList;
	}
	
	# dummy
	private function renderShopCategories() {
		return '';
	}
	# Artikel-Auswahl anzeigen. Spaeter schauen ob wir das auch strukturiert mit Kategorien machen,
	# aber erschtmal flat.
	private function renderSelection() {
		$selection = $this->getSelection();
		if ($selection === false) {
			return '';
		}
		$itemList = '';
		foreach ($selection as $item) {
			$itemList .= '
				<div class="catelem" id="y_'.$item['SKU'].'">
					<span class="toggle leaf" id="y_toggle_'.$item['SKU'].'">&nbsp;</span>
					<div class="catname" id="y_select_'.$item['SKU'].'">
						<span class="catname">'.fixHTMLUTF8Entities($item['products_name'].' ('.$item['SKU'].')').'</span>
					</div>
				</div>';
		}
		return $itemList;
	
	}

	private function rendereBayCategoryItem($id) {
		return '
			<div id="yc_'.$id.'" class="ebayCategory">
				<div id="y_remove_'.$id.'" class="y_rm_handle">&nbsp;</div><div class="ycpath">'.geteBayCategoryPath($id, $this->isStoreCategory).'</div>
			</div>';
	}

	public function renderView() {
		$html = '
			<div id="ebayCategorySelector" class="dialog2" title="'.ML_EBAY_LABEL_SELECT_CATEGORY.'">
				<table id="catMatch"><tbody>
					<tr>
						<td id="ebayCats" class="catView"><div class="catView">'.$this->rendereBayCategories('').'</div></td>
					</tr>
					<!--<tr>
						<td id="selectedeBayCategory" class="catView"><div class="catView"></div></td>
					</tr>-->
				</tbody></table>
				<div id="messageDialog" class="dialog2"></div>
			</div>
		';
		ob_start();
?>
<script type="text/javascript">/*<![CDATA[*/
var selectedEBayCategory = '';
var madeChanges = false;
var isStoreCategory = false;

function collapseAllNodes(elem) {
	$('div.catelem span.toggle:not(.leaf)', $(elem)).each(function() {
		$(this).removeClass('minus').addClass('plus');
		$(this).parent().children('div.catname').children('div.catelem').css({display: 'none'});
	});
	$('div.catname span.catname.selected', $(elem)).removeClass('selected').css({'font-weight':'normal'});
}

function resetEverything() {
	madeChanges = false;
	collapseAllNodes($('#ebayCats'));
	/* Expand Top-Node */
	$('#s_toggle_0').removeClass('plus').addClass('minus').parent().children('div.catname').children('div.catelem').css({display: 'block'});
	$('#selectedeBayCategory div.catView').empty();
	selectedEBayCategory = '';
}

function selectEBayCategory(yID, html) {
	madeChanges = true;
	$('#selectedeBayCategory div.catView').html(html);

	selectedEBayCategory = yID;
	myConsole.log('selectedeBayCategory', selectedEBayCategory);

	$('#ebayCats div.catname span.catname.selected').removeClass('selected').css({'font-weight':'normal'});
	$('#'+yID+' span.catname').addClass('selected').css({'font-weight':'bold'});
}

function clickEBayCategory(elem) {
    // hier Kategorien zuordnen, zu allen ausgewaehlten Items
	tmpNewID = $(elem).parent().attr('id');

	jQuery.blockUI(blockUILoading);
	jQuery.ajax({
		type: 'POST',
		url: '<?php echo toURL($this->url, array('where' => 'prepareView', 'kind' => 'ajax'), true);?>',
		data: {
			'action': 'rendereBayCategoryItem',
			'id': tmpNewID,
			'isStoreCategory': isStoreCategory
		},
		success: function(data) {
			selectEBayCategory(tmpNewID, data);
			jQuery.unblockUI();
		},
		error: function() {
			jQuery.unblockUI();
		},
		dataType: 'html'
	});
}

function addeBayCategoriesEventListener(elem) {
	$('div.catelem span.toggle:not(.leaf)', $(elem)).each(function() {
		$(this).click(function () {
			myConsole.log($(this).attr('id'));
			if ($(this).hasClass('plus')) {
				tmpElem = $(this);
				tmpElem.removeClass('plus').addClass('minus');
				
				if (tmpElem.parent().children('div.catname').children('div.catelem').length == 0) {
					jQuery.blockUI(blockUILoading);
					jQuery.ajax({
						type: 'POST',
						url: '<?php echo toURL($this->url, array('where' => 'prepareView', 'kind' => 'ajax'), true);?>',
						data: {
							'action': 'geteBayCategories',
							'objID': tmpElem.attr('id'),
							'isStoreCategory': isStoreCategory
						},
						success: function(data) {
							appendTo = tmpElem.parent().children('div.catname');
							appendTo.append(data);
							addeBayCategoriesEventListener(appendTo);
							appendTo.children('div.catelem').css({display: 'block'});
							jQuery.unblockUI();
						},
						error: function() {
							jQuery.unblockUI();
						},
						dataType: 'html'
					});
				} else {
					tmpElem.parent().children('div.catname').children('div.catelem').css({display: 'block'});
				}
			} else {
				$(this).removeClass('minus').addClass('plus');
				$(this).parent().children('div.catname').children('div.catelem').css({display: 'none'});
			}
		});
	});	
	$('div.catelem span.toggle.leaf', $(elem)).each(function() {
		$(this).click(function () {
			clickEBayCategory($(this).parent().children('div.catname').children('span.catname'));
		});
		$(this).parent().children('div.catname').children('span.catname').each(function() {
			$(this).click(function () {
				clickEBayCategory($(this));
			});
			if ($(this).parent().attr('id') == selectedEBayCategory) {
				$(this).addClass('selected').css({'font-weight':'bold'});	
			}
		});
	});
}

function returnCategoryID() {
	if (selectedEBayCategory == '') {
		$('#messageDialog').html(
			'Bitte w&auml;hlen Sie eine eBay-Kategorie aus.'
		).jDialog({
			title: '<?php echo ML_LABEL_NOTE; ?>'
		});
		return false;
	}
	cID = selectedEBayCategory;
	cID = str_replace('y_select_', '', cID);
	resetEverything();
	return cID;
}

function generateEbayCategoryPath(cID, viewElem) {
	jQuery.blockUI(blockUILoading);
	jQuery.ajax({
		type: 'POST',
		url: '<?php echo toURL($this->url, array('where' => 'prepareView', 'kind' => 'ajax'), true);?>',
		data: {
			'action': 'geteBayCategoryPath',
			'id': cID,
			'isStoreCategory': isStoreCategory
		},
		success: function(data) {
			jQuery.unblockUI();
			viewElem.html(data);
		},
		error: function() {
			jQuery.unblockUI();
		},
		dataType: 'html'
	});
}

function VariationsEnabled(cID, viewElem) {
	jQuery.blockUI(blockUILoading);
	jQuery.ajax({
		type: 'POST',
		url: '<?php echo toURL($this->url, array('where' => 'prepareView', 'kind' => 'ajax'), true);?>',
		data: {
			'action': 'VariationsEnabled',
			'id': cID
		},
		success: function(data) {
			jQuery.unblockUI();
			var msg;
			if(data == 'true') msg='<?php echo ML_EBAY_NOTE_VARIATIONS_ENABLED ?>';
			else msg='<?php echo ML_EBAY_NOTE_VARIATIONS_DISABLED ?>';
			viewElem.html(msg);
		},
		error: function() {
			jQuery.unblockUI();
		},
		dataType: 'html'
	});
}

function initEBayCategories() {
	myConsole.log('isStoreCategory', isStoreCategory);
	jQuery.blockUI(blockUILoading);
	jQuery.ajax({
		type: 'POST',
		url: '<?php echo toURL($this->url, array('where' => 'prepareView', 'kind' => 'ajax'), true);?>',
		data: {
			'action': 'geteBayCategories',
			'objID': '',
			'isStoreCategory': isStoreCategory
		},
		success: function(data) {
			$('#ebayCats > div.catView').html(data);
			addeBayCategoriesEventListener($('#ebayCats'));
			jQuery.unblockUI();
		},
		error: function() {
			jQuery.unblockUI();
		},
		dataType: 'html'
	});
}

function startCategorySelector(callback, kind) {
	newStoreState = (kind == 'store');
	if (newStoreState != isStoreCategory) {
		isStoreCategory = newStoreState;
		$('#ebayCats > div.catView').html('');
		initEBayCategories();
	}

	$('#ebayCategorySelector').jDialog({
		width: '75%',
		minWidth: '300px',
		buttons: {
			'<?php echo ML_BUTTON_LABEL_ABORT; ?>': function() {
				$(this).dialog('close');
			},
			'<?php echo ML_BUTTON_LABEL_OK; ?>': function() {
				cID = returnCategoryID();
				if (cID != false) {
					callback(cID);
					$(this).dialog('close');
				}
			}
		}
	});
}

$(document).ready(function() {
	addeBayCategoriesEventListener($('#ebayCats'));
});
/*]]>*/</script>
<?php
		$html .= ob_get_contents();	
		ob_end_clean();

		return $html;
	}
	
	public function renderAjax() {
		$id = '';
		if (isset($_POST['id'])) {
			if (($pos = strrpos($_POST['id'], '_')) !== false) {
				$id = substr($_POST['id'], $pos+1);
			} else {
				$id = $_POST['id'];
			}
		}
		$this->isStoreCategory = (array_key_exists('isStoreCategory', $_POST))
			? (($_POST['isStoreCategory'] == 'false')
				? false
				: true
			) : false;

		switch($_POST['action']) {
			/*case 'getCategoryPath': {
				$_timer = microtime(true);
				$cID = (int)$id;
				$yIDs = MagnaDB::gi()->fetchArray('
					SELECT ebay_category_id 
					  FROM '.TABLE_MAGNA_EBAY_CATEGORYMATCHING.'
					 WHERE category_id=\''.$cID.'\'', true
				);
				$ebayCategories = array();
				if (!empty($yIDs)) {
					foreach ($yIDs as $yID) {
						$ebayCategories[] = array(
							'origID' => 'y_select_'.$yID,
							'html' => $this->rendereBayCategoryItem($yID)
						);
					}
				}
				$shopCatHtml = renderCategoryPath($cID);
				return json_encode(array(
					'shopCatHtml' => $shopCatHtml,
					'yCategories' => $ebayCategories,
					'timer' => microtime2human(microtime(true) -  $_timer)
				));
				break;
			}*/
			case 'geteBayCategories': {
				return $this->rendereBayCategories(
					empty($_POST['objID'])
						? 0
						: str_replace('y_toggle_', '', $_POST['objID'])
				);
				break;
			}
			#case 'getShopCategories': {
			#	return $this->renderShopCategories(str_replace('s_toggle_', '', $_POST['cID']));
			#	break;
			#}
			# dummy
			case 'rendereBayCategoryItem': {
				return $this->rendereBayCategoryItem($id);
			}
			case 'geteBayCategoryPath': {
				return geteBayCategoryPath($id, $this->isStoreCategory);
			}
			case 'VariationsEnabled': {
				return VariationsEnabled($id)?'true':'false';
			}
			case 'saveCategoryMatching': {
				if (!isset($_POST['selectedShopCategory']) || empty($_POST['selectedShopCategory']) || 
					(isset($_POST['selectedeBayCategories']) && !is_array($_POST['selectedeBayCategories']))
				) {
					return json_encode(array(
						'debug' => var_dump_pre($_POST['selectedeBayCategories'], true),
						'error' => preg_replace('/\s\s+/', ' ', ML_EBAY_ERROR_SAVING_INVALID_EBAY_CATS)
					));
				}
 
				$cID = str_replace('s_select_', '', $_POST['selectedShopCategory']);
				if (!ctype_digit($cID)) {
					return json_encode(array(
						'debug' => var_dump_pre($cID, true),
						'error' => preg_replace('/\s\s+/', ' ', ML_EBAY_ERROR_SAVING_INVALID_SHOP_CAT)
					));
				}
				$cID = (int)$cID;
				
				if (isset($_POST['selectedeBayCategories']) && !empty($_POST['selectedeBayCategories'])) {
					$ebayIDs = array();
					foreach ($_POST['selectedeBayCategories'] as $tmpYID) {
						$tmpYID = str_replace('y_select_', '', $tmpYID);
						if (preg_match('/^[0-9]{2}-[0-9]{2}-[0-9]{2}$/', $tmpYID)) {
							$ebayIDs[] = $tmpYID;
						}
					}
					if (empty($ebayIDs)) {
						return json_encode(array(
							'error' => preg_replace('/\s\s+/', ' ', ML_EBAY_ERROR_SAVING_INVALID_EBAY_CATS_ALL)
						));
					}
					#MagnaDB::gi()->delete(TABLE_MAGNA_EBAY_CATEGORYMATCHING, array (
					#	'category_id' => $cID
					#));
					#foreach ($ebayIDs as $yID) {
/*
	Hier muss stehen:
	fuer alle ausgewaehlten produkte:
	insert(TABLE_MAGNA_EBAY_PROPERTIES, ...)
	Wobei: Kategorie-Auswahl haben wir, ABER wir brauchen noch die Auswahl von dem ganzen anderen Zeug.
*/
					#	MagnaDB::gi()->insert(TABLE_MAGNA_EBAY_CATEGORYMATCHING, array (
					#		'category_id' => $cID,
					#		'ebay_category_id' => $yID
					#	));
					#}
				} else {
					#MagnaDB::gi()->delete(TABLE_MAGNA_EBAY_CATEGORYMATCHING, array (
					#	'category_id' => $cID
					#));
				}

				return json_encode(array(
					'error' => ''
				));

				break;
			}
			default: {
				return json_encode(array(
					'error' => ML_EBAY_ERROR_REQUEST_INVALID
				));
			}
		}
	}
	
	public function render() {
		if ($this->request == 'ajax') {
			return $this->renderAjax();
		} else {
			return $this->renderView();
		}
		
	}
}
