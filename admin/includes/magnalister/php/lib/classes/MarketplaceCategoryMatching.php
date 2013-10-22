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
 * (c) 2011 RedGecko GmbH -- http://www.redgecko.de
 *     Released under the GNU General Public License v2 or later
 * -----------------------------------------------------------------------------
 */

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

abstract class MarketplaceCategoryMatching {
	const CAT_VALIDITY_PERIOD = 86400; # Nach welcher Zeit werden Kategorien ungueltig (Sekunden)
	const STORE_CAT_VALIDITY_PERIOD = 600; # Nach welcher Zeit werden Store-Kategorien ungueltig (Sekunden)
	
	protected $request = 'view';
	protected $isStoreCategory = false;

	protected $mpID = 0;

	protected $url;
	
	protected $hasPlatformCol = true;

	public function __construct() {
		global $_url, $_MagnaSession;
		
		$this->url = $_url;

		$this->mpID = $_MagnaSession['mpID'];
		$this->marketplace = $_MagnaSession['currentPlatform'];
		
		$this->hasPlatformCol = MagnaDB::gi()->columnExistsInTable('platform', $this->getTableName());
	}
	
	protected abstract function getTableName();
	
	protected function getCategoryValidityPeriod() {
		return self::CAT_VALIDITY_PERIOD;
	}
	
	protected function getStoreCategoryValidityPeriod() {
		return self::STORE_CAT_VALIDITY_PERIOD;
	}
	
	# Die Funktion wird verwendet beim Aufruf der Kategorie-Zuordnung, nicht vorher.
	# Beim Aufruf werden die Hauptkategorien gezogen,
	# und beim Anklicken der einzelnen Kategorie die Kind-Kategorien, falls noch nicht vorhanden.
	private function importMPCategories($parentID = 0) {
		try {
			$categories = MagnaConnector::gi()->submitRequest(array(
				'ACTION' => 'GetChildCategories',
				'DATA' => array('ParentID' => $parentID)
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
		# Cast both to string because PHP thinks 'X' == 0 is true.
		if ($parentID.'' == (0).'') {
			# Tabelle leeren, wenn oberste Ebene abgefragt
			$w = array (
				'mpID' => '0',
			);
			if ($this->hasPlatformCol) {
				$w['platform'] = $this->marketplace;
			}
			MagnaDB::gi()->delete($this->getTableName(), $w);
		}
		$now = gmdate('Y-m-d H:i:s');
		foreach($categories['DATA'] as &$curRow) {
			$curRow['mpID'] = '0';
			if ($this->hasPlatformCol) $curRow['platform'] = $this->marketplace;
			$curRow['InsertTimestamp'] = $now;
		}
		MagnaDB::gi()->batchinsert($this->getTableName(), $categories['DATA'], true);
		return true;
	}
	
	# Das gleiche fuer Store-Categories.
	# Nur: Es wird immer der ganze Kategorie-Baum abgerufen (die Datenmenge ist uebersichtlich)
	private function importMPStoreCategories() {
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
		$now = gmdate('Y-m-d H:i:s');
		foreach($categories['DATA'] as &$curRow) {
			$curRow['mpID'] = $this->mpID;
			if ($this->hasPlatformCol) $curRow['platform'] = $this->marketplace;
			$curRow['InsertTimestamp'] = $now;
		}
		$categories = array_values($categories['DATA']);
		MagnaDB::gi()->batchinsert($this->getTableName(), $categories, true);
		return true;
	}

	private function getMPCategories($parentID = 0, $purge = false) {
		if ($purge) {
			$where = array (
				'ParentID' => $parentID,
				'mpID' => '0'
			);
			if ($this->hasPlatformCol) {
				$where['platform'] = $this->marketplace;
			}
			MagnaDB::gi()->delete($this->getTableName(), $where);
		}
		$validTo = gmdate('Y-m-d H:i:s', time() - $this->getCategoryValidityPeriod());

		$mpCategories = MagnaDB::gi()->fetchArray('
		    SELECT DISTINCT CategoryID, CategoryName,
		    	   ParentID, LeafCategory
		      FROM '.$this->getTableName().'
		     WHERE ParentID=\''.$parentID.'\'
		           AND mpID=\'0\'
		           '.($this->hasPlatformCol ? 'AND platform=\''.$this->marketplace.'\'' : '').'
		           AND InsertTimestamp > \''.$validTo.'\'
		  ORDER BY CategoryName ASC
		');
		# nichts gefunden? vom Server abrufen
		if (empty($mpCategories) && $this->importMPCategories($parentID)) {
			# Wenn Daten bekommen, noch mal select
			$mpCategories = MagnaDB::gi()->fetchArray('
			    SELECT DISTINCT CategoryID, CategoryName,
			    	   ParentID, LeafCategory
			      FROM '.$this->getTableName().'
			     WHERE ParentID=\''.$parentID.'\'
			           AND mpID=\'0\'
			           '.($this->hasPlatformCol ? 'AND platform=\''.$this->marketplace.'\'' : '').'
			  ORDER BY CategoryName ASC
			');
		}

		if (empty($mpCategories)) {
			return false;
		}
		return $mpCategories;
	}

	private function getMPStoreCategories($parentID = 0) {
		$validTo = gmdate('Y-m-d H:i:s', time() - $this->getStoreCategoryValidityPeriod());
		$mpCategories = MagnaDB::gi()->fetchArray('
		    SELECT DISTINCT CategoryID, CategoryName,
		    	   ParentID, LeafCategory
		      FROM '.$this->getTableName().'
		     WHERE ParentID=\''.$parentID.'\'
		           AND mpID=\''.$this->mpID.'\'
		           '.($this->hasPlatformCol ? 'AND platform=\''.$this->marketplace.'\'' : '').'
		           AND InsertTimestamp > \''.$validTo.'\'
		  ORDER BY CategoryName ASC
		');
		
		# nichts gefunden? vom Server abrufen
		if (empty($mpCategories) && $this->importMPStoreCategories($parentID)) {
			# Wenn Daten bekommen, noch mal select
			$mpCategories = MagnaDB::gi()->fetchArray('
			    SELECT DISTINCT CategoryID, CategoryName,
			    	   ParentID, LeafCategory
			      FROM '.$this->getTableName().'
			     WHERE ParentID=\''.$parentID.'\'
			           AND mpID=\''.$this->mpID.'\'
			           '.($this->hasPlatformCol ? 'AND platform=\''.$this->marketplace.'\'' : '').'
			  ORDER BY CategoryName ASC
			');
		}
		if (empty($mpCategories)) {
			return false;
		}
		return $mpCategories;
	}

	private function renderCategories($parentID = 0, $purge = false) {
		if ($this->isStoreCategory) {
			$subCats = $this->getMPStoreCategories($parentID, $purge);
		} else {
			$subCats = $this->getMPCategories($parentID, $purge);
		}
		if ($subCats === false) {
			return ML_ERROR_NO_CATEGORIES_FOUND;
		}
		$topLevelList = '';
		foreach ($subCats as $item) {
			if ($item['LeafCategory'] == 1) {
				$class = 'leaf';
			} else {
				$class = 'plus';
			}
			$topLevelList .= '
				<div class="catelem" id="y_'.$item['CategoryID'].'">
					<span class="toggle '.$class.'" id="y_toggle_'.$item['CategoryID'].'">&nbsp;</span>
					<div class="catname" id="y_select_'.$item['CategoryID'].'">
						<span class="catname">'.fixHTMLUTF8Entities($item['CategoryName']).'</span>
					</div>
				</div>';
		}
		return $topLevelList;
	}
	
	private function getMPCategoryPath($categoryID) {
		$appendedText = '&nbsp;<span class="cp_next">&gt;</span>&nbsp;';
		$mpID = ($this->isStoreCategory) ? $this->mpID: '0';
		$catPath = '';
		do {
			# Ermittle Namen, CategoryID und ParentID,
			# dann das gleiche fuer die ParentCategory usw.
			# bis bei Top angelangt (CategoryID = ParentID)
			$yCP = MagnaDB::gi()->fetchRow('
				SELECT CategoryID, CategoryName, ParentID
				  FROM '.$this->getTableName().'
				 WHERE CategoryID=\''.$categoryID.'\'
				       AND mpID=\''.$mpID.'\'
				       '.($this->hasPlatformCol ? 'AND platform=\''.$this->marketplace.'\'' : '').'
				 LIMIT 1
			');
			if ($yCP === false) {
				if ($this->isStoreCategory) {
					$this->importMPStoreCategories();
				} else {
					$this->importMPCategories($categoryID);
				}
				continue;
			}
			if (empty($catPath)) {
				$catPath = fixHTMLUTF8Entities($yCP['CategoryName']);
			} else {
				$catPath = fixHTMLUTF8Entities($yCP['CategoryName']) . $appendedText . $catPath;
			}
			$categoryID = $yCP['ParentID'];
		} while ($yCP['ParentID'] != '0');

		if ($yCP === false) {
			return '<span class="invalid">'.ML_LABEL_INVALID.'</span>';
		}
		return $catPath;
	}

	private function renderMPCategoryItem($id) {
		return '
			<div id="yc_'.$id.'" class="mpCategory">
				<div id="y_remove_'.$id.'" class="y_rm_handle">&nbsp;</div><div class="ycpath">'.$this->getMPCategoryPath($id).'</div>
			</div>';
	}
	
	protected function getActionBoxHTML() {
		return '';
	}
	
	protected function getMatchingBoxHTML() {
		return '';
	}

	public function renderView() {
		$html = '
			<form method="post" action="'.toURL($this->url).'">
				<table class="actions">
					<thead><tr><th>'.ML_LABEL_MATCH_CATEGORIES.'</th></tr></thead>
					<tbody>
						<tr><td>'.$this->getMatchingBoxHTML().'</td></tr>
					</tbody>
				</table>		
				<table class="actions">
					<thead><tr><th>'.ML_LABEL_ACTIONS.'</th></tr></thead>
					<tbody>
						<tr><td>'.$this->getActionBoxHTML().'</td></tr>
					</tbody>
				</table>
			</form>
			<div id="mpCategorySelector" class="dialog2" title="'.ML_LABEL_MATCH_CATEGORIES.'">
				<table id="catMatch"><tbody>
					<tr><td id="mpCats" class="catView"><div class="catView">'.$this->renderCategories(0).'</div></td></tr>
					<tr><td style="height: 0.5em"></td></tr>
					<tr><td class="catVisual" id="tmpSelectedCat"></td></tr>
				</tbody></table>
				<div id="messageDialog" class="dialog2"></div>
			</div>
		';
		ob_start();
?>
<script type="text/javascript">/*<![CDATA[*/
var mpCategorySelector = (function() {
	var selectedCategory = '';
	var isStoreCategory = false;
	
	var tmpSelectedCat = $('#tmpSelectedCat');
	var mpCats = $('#mpCats');
	
	var finalCategoryPath = '';
	
	function collapseAllNodes() {
		$('div.catelem span.toggle:not(.leaf)', mpCats).each(function() {
			$(this).removeClass('minus').addClass('plus');
			$(this).parent().children('div.catname').children('div.catelem').css({display: 'none'});
		});
		$('div.catname span.catname.selected', mpCats).removeClass('selected').css({'font-weight':'normal'});
	}

	function resetEverything() {
		collapseAllNodes();
		/* Expand Top-Node */
		$('#s_toggle_0').removeClass('plus').addClass('minus').parent().children('div.catname').children('div.catelem').css({display: 'block'});
		selectedCategory = '';
	}
	
	function selectCategory (elem) {
		elem = $(elem).parent();
		var tmpNewID = $(elem).attr('id');
		selectedCategory = tmpNewID;
		myConsole.log('selectedCategory', selectedCategory);
	
		$('div.catname span.catname.selected', mpCats).removeClass('selected').css({'font-weight':'normal'});
		$('span.catname', elem).addClass('selected').css({'font-weight':'bold'});
		generateCategoryPath(tmpSelectedCat);
	}
	
	function addCategoriesEventListener (elem) {
		$('div.catelem span.toggle:not(.leaf)', $(elem)).each(function() {
			$(this).click(function () {
				myConsole.log($(this).attr('id'));
				if ($(this).hasClass('plus')) {
					var tmpElem = $(this);
					tmpElem.removeClass('plus').addClass('minus');
					
					if (tmpElem.parent().children('div.catname').children('div.catelem').length == 0) {
						jQuery.blockUI(blockUILoading);
						jQuery.ajax({
							type: 'POST',
							url: '<?php echo toURL($this->url, array('where' => 'catMatchView', 'kind' => 'ajax'), true);?>',
							data: {
								'action': 'getMPCategories',
								'objID': tmpElem.attr('id'),
								'isStoreCategory': isStoreCategory
							},
							success: function(data) {
								var appendTo = tmpElem.parent().children('div.catname');
								appendTo.append(data);
								addCategoriesEventListener(appendTo);
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
			$(this).parent().children('div.catname').children('span.catname').each(function() {
				$(this).click(function () {
					selectCategory($(this));
				});
			});
		});
	}

	function returnCategoryID () {
		if (selectedCategory == '') {
			$('#messageDialog').html(
				'Bitte w&auml;hlen Sie eine Kategorie aus.'
			).jDialog({
				title: '<?php echo ML_LABEL_NOTE; ?>'
			});
			return false;
		}
		var cID = selectedCategory;
		cID = str_replace('y_select_', '', cID);
		//resetEverything();
		return cID;
	}

	function generateCategoryPath (viewElem) {
		jQuery.blockUI(blockUILoading);
		jQuery.ajax({
			type: 'POST',
			url: '<?php echo toURL($this->url, array('where' => 'catMatchView', 'kind' => 'ajax'), true);?>',
			data: {
				'action': 'getMPCategoryPath',
				'id': selectedCategory,
				'isStoreCategory': isStoreCategory
			},
			success: function(data) {
				finalCategoryPath = data;
				viewElem.html(finalCategoryPath);
				jQuery.unblockUI();
			},
			error: function() {
				jQuery.unblockUI();
			},
			dataType: 'html'
		});
	}
	
	function initMPCategories (purge) {
		purge = purge || false;
		myConsole.log('isStoreCategory', isStoreCategory);
		jQuery.blockUI(blockUILoading);
		jQuery.ajax({
			type: 'POST',
			url: '<?php echo toURL($this->url, array('where' => 'catMatchView', 'kind' => 'ajax'), true);?>',
			data: {
				'action': 'getMPCategories',
				'objID': '',
				'isStoreCategory': isStoreCategory,
				'purge': purge ? 'true' : 'false'
			},
			success: function(data) {
				$('#mpCats > div.catView').html(data);
				addCategoriesEventListener(mpCats);
				jQuery.unblockUI();
			},
			error: function() {
				jQuery.unblockUI();
			},
			dataType: 'html'
		});
	}
	
	function startCategorySelector (callback, kind) {
		var newStoreState = (kind == 'store');
		if (newStoreState != isStoreCategory) {
			isStoreCategory = newStoreState;
			$('#mpCats > div.catView').html('');
			initMPCategories();
		}
	
		$('#mpCategorySelector').jDialog({
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
			},
			open: function(event, ui) {
				if (isStoreCategory) return;
				var tbar = $('#mpCategorySelector').parent().find('.ui-dialog-titlebar');
				if (tbar.find('.ui-icon-arrowrefresh-1-n').length == 0) {
					var rlBtn = $('<a class="ui-dialog-titlebar-close ui-corner-all ui-state-focus" '+
						'role="button" href="#" style="right: 2em; padding: 0px;">'+
				    		'<span class="ui-icon ui-icon-arrowrefresh-1-n">reload</span>'+
				    	'</a>')
				    tbar.append(rlBtn);
				    rlBtn.click(function (event) {
				    	event.preventDefault();
				    	initMPCategories(true);
				    });
				}
			}
		});
	}
	
	return {
		addCategoriesEventListener: addCategoriesEventListener,
		getCategoryPath: function(e) {
			e.html(finalCategoryPath);
		},
		startCategorySelector: startCategorySelector
	}
})();
$(document).ready(function() {
	mpCategorySelector.addCategoriesEventListener($('#mpCats'));
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
			case 'getMPCategories': {
				return $this->renderCategories(
					empty($_POST['objID'])
						? 0
						: str_replace('y_toggle_', '', $_POST['objID']),
					isset($_POST['purge']) ? $_POST['purge'] : false
				);
				break;
			}

			case 'renderMPCategoryItem': {
				return $this->renderMPCategoryItem($id);
			}
			case 'getMPCategoryPath': {
				return $this->getMPCategoryPath($id);
			}
			default: {
				return json_encode(array(
					'error' => ML_ERROR_REQUEST_INVALID
				));
			}
		}
	}
	
}
