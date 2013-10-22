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
 * $Id: InventoryView.php 680 2011-01-11 13:54:55Z MaW $
 *
 * (c) 2010 RedGecko GmbH -- http://www.redgecko.de
 *     Released under the GNU General Public License v2 or later
 * -----------------------------------------------------------------------------
 */

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');
require_once (DIR_MAGNALISTER_INCLUDES.'lib/classes/SimplePrice.php');

class InventoryView {
	protected $marketplace;

	protected $settings = array();
	protected $sort = array();

	protected $numberofitems = 0;
	protected $offset = 0;
	
	protected $renderableData = array();
		
	protected $simplePrice = null;
	protected $url = array();
	protected $magnasession = array();
	protected $magnaShopSession = array();

	protected $search = '';

	public function __construct($marketplace, $settings = array()) {
		global $_MagnaShopSession, $_MagnaSession, $_url, $_modules;
		
		$this->marketplace = $marketplace;
		
		$this->settings = array_merge(array(
			'maxTitleChars'	=> 80,
			'itemLimit'		=> 50,
		), $settings);

		$this->simplePrice = new SimplePrice();
		$this->simplePrice->setCurrency(getCurrencyFromMarketplace($_MagnaSession['mpID']));
		$this->url = $_url;
		$this->url['view'] = 'inventory';
		$this->magnasession = &$_MagnaSession;
		$this->magnaShopSession = &$_MagnaShopSession;

		if (array_key_exists('tfSearch', $_POST) && !empty($_POST['tfSearch'])) {
			$this->search = $_POST['tfSearch'];
		} else if (array_key_exists('search', $_GET) && !empty($_GET['search'])) {
			$this->search = $_GET['search'];
		}
	}

	private function getInventory() {
		try {
			$request = array(
				'ACTION' => 'GetInventory',
				'LIMIT' => $this->settings['itemLimit'],
				'OFFSET' => $this->offset,
				'ORDERBY' => $this->sort['order'],
				'SORTORDER' => $this->sort['type']
			);
			if (!empty($this->search)) {
				#$request['SEARCH'] = (!isUTF8($this->search)) ? utf8_encode($this->search) : $this->search;
				$request['SEARCH'] = $this->search;
			}
			$result = MagnaConnector::gi()->submitRequest($request);
			$this->numberofitems = (int)$result['NUMBEROFLISTINGS'];
			return $result;

		} catch (MagnaException $e) {
			return false;
		}
	}

	protected function sortByType($type) {
		$tmpURL = $this->url;
		if (!empty($this->search)) {
			$tmpURL['search'] = urlencode($this->search);
		}
		return '
			<span class="nowrap">
				<a href="'.toURL($tmpURL, array('sorting' => $type.'')).'" title="'.ML_LABEL_SORT_ASCENDING.'" class="sorting">
					<img alt="'.ML_LABEL_SORT_ASCENDING.'" src="'.DIR_MAGNALISTER_IMAGES.'sort_up.png" />
				</a>
				<a href="'.toURL($tmpURL, array('sorting' => $type.'-desc')).'" title="'.ML_LABEL_SORT_DESCENDING.'" class="sorting">
					<img alt="'.ML_LABEL_SORT_DESCENDING.'" src="'.DIR_MAGNALISTER_IMAGES.'sort_down.png" />
				</a>
			</span>';
	}

	protected function getSortOpt() {
		if (isset($_GET['sorting'])) {
			$sorting = $_GET['sorting'];
		} else {
			$sorting = 'blabla'; // fallback for default
		}

		switch ($sorting) {
	        case 'sku':
	            $this->sort['order'] = 'SKU';
	            $this->sort['type']  = 'ASC';
	            break;
	        case 'sku-desc':
	            $this->sort['order'] = 'SKU';
	            $this->sort['type']  = 'DESC';
	            break;
	        case 'itemtitle':
	            $this->sort['order'] = 'ItemTitle';
	            $this->sort['type']  = 'ASC';
	            break;
	        case 'itemtitle-desc':
	            $this->sort['order'] = 'ItemTitle';
	            $this->sort['type']  = 'DESC';
	            break;
	        case 'price':
	            $this->sort['order'] = 'Price';
	            $this->sort['type']  = 'ASC';
	            break;
	        case 'price-desc':
	            $this->sort['order'] = 'Price';
	            $this->sort['type']  = 'DESC';
	            break;
	        case 'dateadded-desc':
	            $this->sort['order'] = 'DateAdded';
	            $this->sort['type']  = 'DESC';
	            break;
			case 'dateadded':
	        default:
	            $this->sort['order'] = 'DateAdded';
	            $this->sort['type']  = 'DESC';
	            break;
	    }
	}
	
	protected function postDelete() { /* Nix :-) */ }
	
	private function initInventoryView() {
		//$_POST['timestamp'] = time();
		if (isset($_POST['ItemIDs']) && is_array($_POST['ItemIDs']) && isset($_POST['action']) && 
			($_SESSION['POST_TS'] != $_POST['timestamp']) // Re-Post Prevention
		) {
			$_SESSION['POST_TS'] = $_POST['timestamp'];
			switch ($_POST['action']) {
				case 'delete': {
					$itemIDs = $_POST['ItemIDs'];
					$request = array (
						'ACTION' => 'DeleteItems',
						'DATA' => array(),
					);
					$insertData = array();
					foreach ($itemIDs as $itemID) {
						$request['DATA'][] = array (
							'ItemID' => $itemID,
						);
						$pDetails = unserialize(str_replace('\\"', '"', $_POST['details'][$itemID]));
						$pID = magnaSKU2pID($sku);
						$model = '';
						if ($pID > 0) {
							$model = (string)MagnaDB::gi()->fetchOne('SELECT products_model FROM '.TABLE_PRODUCTS.' WHERE products_id=\''.$pID.'\'');
						}
						if (empty($model)) {
							$model = $sku;
						}
						$insertData[$itemID] = array (
							'products_id' => $pID,
							'products_model' => $model,
							'mpID' => $this->magnasession['mpID'],
							'ItemID' => $itemID,
							'price' => $pDetails['Price'],
							'timestamp' => date('Y-m-d H:i:s')
						);
					}
					/*
					echo print_m($insertData, '$insertData');
					echo print_m($request, '$request');
					*/
					try {
						$result = MagnaConnector::gi()->submitRequest($request);
					} catch (MagnaException $e) {
						$result = array (
							'STATUS' => 'ERROR'
						);
					}
					/*
					if ($result['STATUS'] == 'SUCCESS') {
						$result['DeletedItemIDs'] = array_keys($insertData);
					}
					echo print_m($result, '$result');
					*/
					if (($result['STATUS'] == 'SUCCESS') 
						&& array_key_exists('DeletedItemIDs', $result) 
						&& is_array($result['DeletedItemIDs'])
						&& !empty($result['DeletedItemIDs'])
					) {
						foreach ($result['DeletedItemIDs'] as $itemID) {
							if (!array_key_exists($itemID, $insertData)) continue;
							MagnaDB::gi()->insert(TABLE_MAGNA_EBAY_DELETEDLOG, $insertData[$itemID]);
						}
						$this->postDelete();
					}
					break;
				}
			}
		}

		$this->getSortOpt();

		if (isset($_GET['page']) && ctype_digit($_GET['page'])) {
			$this->offset = ($_GET['page'] - 1) * $this->settings['itemLimit'];
		} else {
			$this->offset = 0;
		}
	}
	
	public function prepareInventoryData() {
		global $magnaConfig;

		$result = $this->getInventory();
		if (($result !== false) && !empty($result['DATA'])) {
			$this->renderableData = $result['DATA'];
			foreach ($this->renderableData as &$item) {
				$item['ItemTitleShort'] = (strlen($item['ItemTitle']) > $this->settings['maxTitleChars'] + 2)
						? (fixHTMLUTF8Entities(substr($item['ItemTitle'], 0, $this->settings['maxTitleChars'])).'&hellip;')
						: fixHTMLUTF8Entities($item['ItemTitle']);
				$item['DateAdded'] = strtotime($item['DateAdded']);
				$item['DateEnd'] = ('GTC' != $item['ListingType'])? strtotime($item['End']):'-';
			}
			unset($result);
		}

	}
	
	private function emptyStr2mdash($str) {
		return (empty($str) || (is_numeric($str) && ($str == 0))) ? '&mdash;' : $str;
	}
	
	protected function additionalHeaders() { }

	protected function additionalValues($item) { }

	private function renderDataGrid($id = '') {
		global $magnaConfig;

		$html = '
			<table'.(($id != '') ? ' id="'.$id.'"' : '').' class="datagrid">
				<thead class="small"><tr>
					<td class="nowrap" style="width: 5px;"><input type="checkbox" id="selectAll"/><label for="selectAll">'.ML_LABEL_CHOICE.'</label></td>
					<td>'.ML_LABEL_EBAY_ITEM_ID.'</td>
					<td>'.ML_LABEL_SKU.' '.$this->sortByType('sku').'</td>
					<td>'.ML_LABEL_SHOP_TITLE.' '.$this->sortByType('itemtitle').'</td>
					<td>'.ML_GENERIC_PRICE.' '.$this->sortByType('price').'</td>
					'.$this->additionalHeaders().'
					<td>'.ML_LABEL_EBAY_LISTINGTIME.' '.$this->sortByType('dateadded').'</td>
				</tr></thead>
				<tbody>
		';
		$oddEven = false;
		#echo print_m($this->renderableData, '$this->renderableData');
        $unknownSKUs = $this->findUnknownSKUs($this->renderableData);
		foreach ($this->renderableData as $item) {
			$details = htmlspecialchars(str_replace('"', '\\"', serialize(array(
			 	'SKU' => $item['SKU'],
			 	'Price' => $item['Price'],
			 	'Currency' => $item['Currency'],
			))));

            if (in_array($item['SKU'], $unknownSKUs)) {
                $skuStyleAds = 'title="'.ML_LABEL_SKU_NOT_IN_SHOP.'" style="color:#A00;"';
            } else {
                $skuStyleAds = '';
            }

			$html .= '
				<tr class="'.(($oddEven = !$oddEven) ? 'odd' : 'even').'">
					<td><input type="checkbox" name="ItemIDs[]" value="'.$item['ItemID'].'">
						<input type="hidden" name="details['.$item['ItemID'].']" value="'.$details.'"></td>
					<td><a href="'.$item['SiteUrl'].'?ViewItem&item='.$item['ItemID'].'" target="_blank">'.$item['ItemID'].'</a></td>
					<td '.$skuStyleAds.' >'.$item['SKU'].'</td>
					<td title="'.fixHTMLUTF8Entities($item['ItemTitle'], ENT_COMPAT).'">'.$item['ItemTitleShort'].'</td>
					<td>'.$this->simplePrice->setPriceAndCurrency($item['Price'], $item['Currency'])->format().'</td>
					'.($this->additionalValues($item)).'
					<td>'.date("d.m.Y", $item['DateAdded']).' &nbsp;&nbsp;<span class="small">'.date("H:i", $item['DateAdded']).'</span><br />'.date("d.m.Y", $item['DateEnd']).' &nbsp;&nbsp;<span class="small">'.date("H:i", $item['DateEnd']).'</span>'.'</td>';
			$html .= '	
				</tr>';
		}
		$html .= '
				</tbody>
			</table>';

		return $html;
	}

    private function findUnknownSKUs($items) {
        $SKUarr = array();
        $SKUlist = '';
        foreach ($items as $item){
            $SKUarr[] = $item['SKU'];
            $SKUlist .= ", '".$item['SKU']."'";
        }
        $SKUarr = array_unique($SKUarr);
        $SKUlist = ltrim($SKUlist, ', ');
        # query for known SKUs
        if ('artNr' == getDBConfigValue('general.keytype', '0')) {
            $productSKUarr = MagnaDB::gi()->fetchArray('SELECT DISTINCT products_model AS SKU
                            FROM '.TABLE_PRODUCTS.' WHERE products_model IN ('.$SKUlist.')');
        } else {
            $productSKUarr = MagnaDB::gi()->fetchArray('SELECT DISTINCT CONCAT(\'ML\',products_id) AS SKU
                            FROM '.TABLE_PRODUCTS.' WHERE CONCAT(\'ML\',products_id) IN ('.$SKUlist.')');
        }
        $variationSKUarr = MagnaDB::gi()->fetchArray('SELECT DISTINCT variation_products_model AS SKU
                        FROM '.TABLE_MAGNA_VARIATIONS.' WHERE variation_products_model IN ('.$SKUlist.')');
        # drop the known SKUs from the list
        foreach ($productSKUarr as $productSKUrow) {
            if (false !== ($curKey = array_search($productSKUrow['SKU'], $SKUarr))) {
                unset($SKUarr[$curKey]);
            } 
        }
        foreach ($variationSKUarr as $variationSKUrow) {
            if (false !== ($curKey = array_search($variationSKUrow['SKU'], $SKUarr))) {
                unset($SKUarr[$curKey]);
            } 
        }
        $SKUarr = array_unique($SKUarr);
        return $SKUarr;
    }

	public function renderInventoryTable() {
		$html = '';
		if (empty($this->renderableData)) {
			$this->prepareInventoryData();
		}
		#echo print_m($this->renderableData, 'renderInventoryTable: $this->renderableData');


		$pages = ceil($this->numberofitems / $this->settings['itemLimit']);
		$bla = '';
		$tmpURL = $this->url;
		if (isset($_GET['sorting'])) {
			$tmpURL['sorting'] = $_GET['sorting'];
		}
		if (!empty($this->search)) {
			$tmpURL['search'] = urlencode($this->search);
		}
		$currentPage = 1;
		if (isset($_GET['page']) && ctype_digit($_GET['page']) && (1 <= (int)$_GET['page']) && ((int)$_GET['page'] <= $pages)) {
			$currentPage = (int)$_GET['page'];
		}

		for ($i = 1; $i <= $pages; ++$i) {
			$hi = ($currentPage == $i) ? '<b>'.$i.'</b>' : $i;
			$bla .= ' <a href="'.toUrl($tmpURL, array('page' => $i)).'" title="'.ML_LABEL_PAGE.' '.$i.'">'.$hi.'</a>';
		}
		$offset = $currentPage * $this->settings['itemLimit'] - $this->settings['itemLimit'] + 1;
		$limit = $offset + count($this->renderableData) - 1;
		$html .= '<table class="listingInfo"><tbody><tr>
					<td class="pagination">
						'.(($this->numberofitems > 0)
							?	('<span class="bold">'.ML_LABEL_PRODUCTS.':&nbsp; '.
								 $offset.' bis '.$limit.' von '.($this->numberofitems).'&nbsp;&nbsp;&nbsp;&nbsp;</span>'
								)
							:	''
						).'
						<span class="bold">'.ML_LABEL_CURRENT_PAGE.':&nbsp; '.$currentPage.'</span>
					</td>
					<td class="textright">
						'.$bla.'
					</td>
				</tr></tbody></table>';

		if (!empty($this->renderableData)) {
			$html .= $this->renderDataGrid('ebayinventory');
		} else {
			$html .= '<table class="magnaframe"><tbody><tr><td>'.
						(empty($this->search) ? ML_GENERIC_NO_INVENTORY : ML_LABEL_NO_SEARCH_RESULTS).
					 '</td></tr></tbody></table>';
		}

		ob_start();
?>
<script type="text/javascript">/*<![CDATA[*/
$(document).ready(function() {
	$('#selectAll').click(function() {
		state = $(this).attr('checked');
		$('#ebayinventory input[type="checkbox"]:not([disabled])').each(function() {
			$(this).attr('checked', state);
		});
	});
});
/*]]>*/</script>
<?php
		$html .= ob_get_contents();	
		ob_end_clean();
		
		return $html;
	}
	
	protected function getRightActionButton() { return ''; }
	
	public function renderActionBox() {
		global $_modules;
		$left = (!empty($this->renderableData) ? 
			'<input type="button" class="button" value="'.ML_BUTTON_LABEL_DELETE.'" id="listingDelete" name="listing[delete]"/>' : 
			''
		);
		
		$right = $this->getRightActionButton();

		ob_start();?>
<script type="text/javascript">/*<![CDATA[*/
$(document).ready(function() {
	$('#listingDelete').click(function() {
		if (($('#ebayinventory input[type="checkbox"]:checked').length > 0) &&
			confirm(unescape(<?php echo "'".html2url(sprintf(ML_GENERIC_DELETE_LISTINGS, $_modules[$this->magnasession['currentPlatform']]['title']))."'"; ?>))
		) {
			$('#action').val('delete');
			$(this).parents('form').submit();
		}
	});
});
/*]]>*/</script>
<?php // Durch aufrufen der Seite wird automatisch ein Aktualisierungsauftrag gestartet
		$js = ob_get_contents();	
		ob_end_clean();

		if (($left == '') && ($right == '')) {
			return '';
		}
		return '
			<input type="hidden" id="action" name="action" value="">
			<input type="hidden" name="timestamp" value="'.time().'">
			<table class="actions">
				<thead><tr><th>'.ML_LABEL_ACTIONS.'</th></tr></thead>
				<tbody><tr><td>
					<table><tbody><tr>
						<td class="firstChild">'.$left.'</td>
						<td><label for="tfSearch">'.ML_LABEL_SEARCH.':</label>
							<input id="tfSearch" name="tfSearch" type="text" value="'.fixHTMLUTF8Entities($this->search, ENT_COMPAT).'"/>
							<input type="submit" class="button" value="'.ML_BUTTON_LABEL_GO.'" name="search_go" /></td>
						<td class="lastChild">'.$right.'</td>
					</tr></tbody></table>
				</td></tr></tbody>
			</table>
			'.$js;
	}

	public function renderView() {
		$html = '<form action="'.toUrl($this->url).'" id="ebayInventoryView" method="post">';
		$this->initInventoryView();
		$html .= $this->renderInventoryTable();
		return $html.$this->renderActionBox().'
			</form>
			<script type="text/javascript">/*<![CDATA[*/
				$(document).ready(function() {
					$(\'#ebayInventoryView\').submit(function () {
						jQuery.blockUI(blockUILoading);
					});
				});
			/*]]>*/</script>';
	}
	
}
