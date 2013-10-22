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
 * $Id: PrepareCategoryView.php 699 2011-01-17 23:03:36Z derpapst $
 *
 * (c) 2010 RedGecko GmbH -- http://www.redgecko.de
 *     Released under the GNU General Public License v2 or later
 * -----------------------------------------------------------------------------
 */

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');
require_once(DIR_MAGNALISTER_INCLUDES.'lib/classes/SimpleCategoryView.php');

class PrepareCategoryView extends SimpleCategoryView {
	public function __construct($cPath = 0, $settings = array(), $sorting = false, $search = '', $productIDs = array()) {
		parent::__construct($cPath, $settings, $sorting, $search, $productIDs);
		//$this->action = array('action' => 'matching');

		if (!isset($_GET['kind']) || ($_GET['kind'] != 'ajax')) {
			$this->simplePrice->setCurrency(getCurrencyFromMarketplace($this->_magnasession['mpID']));
		}
	}

	public function getAdditionalHeadlines() {
		return '
			<td class="lowestprice">'.ML_EBAY_LABEL_EBAY_PRICE.'</td>
			<td class="matched">'.ML_EBAY_LABEL_PREPARED.'</td>';
	}

	public function getAdditionalCategoryInfo($cID, $data = false) {
		$html = '<td>&mdash;</td>';
			
		$pIDs = $this->list['categories'][$cID]['allproductsids'];
		if (!empty($pIDs)) {
			$totalItems = count($pIDs);
			$itemsFailed = 0;
			$itemsMatched = 0;
            $currStart = 0;
            $pIDsAtOnce = 256;
            $currPIDs = array_slice($pIDs, $currStart, $pIDsAtOnce);
            while (!empty($currPIDs)) {

			    if (getDBConfigValue('general.keytype', '0') == 'artNr') {
				    $query = '
					    SELECT count(p.products_id) prodCount, Verified
					    FROM '.TABLE_PRODUCTS.' p, '.TABLE_MAGNA_EBAY_PROPERTIES.' pa
					    WHERE p.products_id IN (\''.implode('\', \'', $pIDs).'\')
					        AND p.products_model=pa.products_model
					        AND p.products_model<>\'\'
					        AND mpID = '.$this->_magnasession['mpID'].'	
                        GROUP BY Verified
				    ';
			    } else {
				    $query = '
					    SELECT count(products_id) prodCount, Verified
					    FROM '.TABLE_MAGNA_EBAY_PROPERTIES.'
					    WHERE products_id IN (\''.implode('\', \'', $pIDs).'\')
					    AND mpID = '.$this->_magnasession['mpID'].'	
                        GROUP BY Verified
				    ';
			    }
			    	
			    $matched = MagnaDB::gi()->fetchArray($query);
    
			    foreach ($matched as $row) {
				    if ('OK' != $row['Verified']) {
					    $itemsFailed += $row['prodCount'];
				    } else {
					    $itemsMatched += $row['prodCount'];
				    }
			    }
                if (($itemsFailed > 0) && ($itemsMatched > 0)) break;
                $currStart += $pIDsAtOnce;
                $currPIDs = array_slice($pIDs, $currStart, $pIDsAtOnce);
			}
		} else {
			$totalItems = 0;
		}
		if (($itemsFailed == 0) && ($itemsMatched == 0)) { /* Nichts gematched und auch kein matching probiert */
			return $html.'
				<td title="'.ML_EBAY_CATEGORY_PREPARED_NONE.'">'.
					html_image(DIR_MAGNALISTER_IMAGES . 'status/grey_dot.png', ML_EBAY_CATEGORY_PREPARED_NONE, 12, 12).
				'</td>';
		}
		if ($itemsFailed == $totalItems) { /* Keine gematched */
			return $html.'
				<td title="'.ML_EBAY_CATEGORY_PREPARED_FAULTY.'">'.
					html_image(DIR_MAGNALISTER_IMAGES . 'status/red_dot.png', ML_EBAY_CATEGORY_PREPARED_FAULTY, 12, 12).
				'</td>';
		}
		if ($itemsMatched == $totalItems) {  /* Alle Items in Category gematched */
			return $html.'
				<td title="'.ML_EBAY_CATEGORY_PREPARED_ALL.'">'.
					html_image(DIR_MAGNALISTER_IMAGES . 'status/green_dot.png', ML_EBAY_CATEGORY_PREPARED_ALL, 12, 12).
				'</td>';
		}
		if (($itemsFailed > 0) || ($itemsMatched > 0)) { /* Einige nicht erfolgreich gematched */
			return $html.'
				<td title="'.ML_EBAY_CATEGORY_PREPARED_INCOMPLETE.'">'.
					html_image(DIR_MAGNALISTER_IMAGES . 'status/yellow_dot.png', ML_EBAY_CATEGORY_PREPARED_INCOMPLETE, 12, 12).
				'</td>';
		}

		return $html.'
			<td title="'.ML_ERROR_UNKNOWN.' $totalItems:'.$totalItems.' $itemsMatched:'.$itemsMatched.' $itemsFailed:'.$itemsFailed.'">'.
				html_image(DIR_MAGNALISTER_IMAGES . 'status/red_dot.png', ML_ERROR_UNKNOWN, 12, 12).
				html_image(DIR_MAGNALISTER_IMAGES . 'status/red_dot.png', ML_ERROR_UNKNOWN, 12, 12).
			'</td>';
	}

	public function getAdditionalProductInfo($pID, $data = false) {
		$priceFrozen = false;
		$a = MagnaDB::gi()->fetchRow('
			SELECT products_id, Price, BuyItNowPrice, Verified, ListingType
			  FROM '.TABLE_MAGNA_EBAY_PROPERTIES.'
			 WHERE '.((getDBConfigValue('general.keytype', '0') == 'artNr')
					? 'products_model=\''.MagnaDB::gi()->escape($data['products_model']).'\''
					: 'products_id=\''.$pID.'\''
				    ).'
					 AND mpID = '.$this->_magnasession['mpID']
		);
		if (empty($a)) {
			return '
				<td>&mdash;</td>
				<td>'.html_image(DIR_MAGNALISTER_IMAGES . 'status/grey_dot.png', ML_EBAY_PRODUCT_MATCHED_NO, 12, 12).'</td>';
		}
		if (0.0 == $a['Price']) { # Preis nicht eingefroren => berechnen
			$a['Price'] = makePrice($pID, $a['ListingType']);
		} else {
			$priceFrozen = true;
		}
		$textEBayPrice = $this->simplePrice->setPrice($a['Price'])->format();
		if (0 != $a['BuyItNowPrice'])
			$textEBayPrice .= '<br>'.ML_EBAY_BUYITNOW.': '.$this->simplePrice->setPrice($a['BuyItNowPrice'])->format();
		if ($priceFrozen) {
			$startPriceFormat='<b>'; $endPriceFormat='</b>';
			$priceTooltip = ' title="'.ML_EBAY_PRICE_FROZEN_TOOLTIP.'" ';
		} else {
			$startPriceFormat = $endPriceFormat = '';
			$priceTooltip = ' title="'.ML_EBAY_PRICE_CALCULATED_TOOLTIP.'" ';
		}
		if ('OK' != $a['Verified']) {
			return '
				<td '.$priceTooltip.'>'.$startPriceFormat.$textEBayPrice.$endPriceFormat.'</td>
				<td>'.html_image(DIR_MAGNALISTER_IMAGES . 'status/red_dot.png', ML_EBAY_PRODUCT_PREPARED_FAULTY, 12, 12).'</td>';
		}
		return '
			<td '.$priceTooltip.'>'.$startPriceFormat.$textEBayPrice.$endPriceFormat.'</td>
			<td>'.html_image(DIR_MAGNALISTER_IMAGES . 'status/green_dot.png', ML_EBAY_PRODUCT_PREPARED_OK, 12, 12).'</td>';
	}
	
	public function getFunctionButtons() {
		global $_url;

		$mmatch = true;

		return '
			<input type="hidden" value="'.$this->settings['selectionName'].'" name="selectionName"/>
			<input type="hidden" value="_" id="actionType"/>
			<table class="right"><tbody>
				<tr>
					<td id="match_settings" rowspan="2" class="textleft inputCell">
						<input id="match_all_rb" type="radio" name="match" value="all" '.($mmatch ? 'checked="checked"' : '').'/>
						<label for="match_all_rb">'.ML_LABEL_ALL.'</label><br />
						<input id="match_notmatched_rb" type="radio" name="match" value="notmatched" '.(!$mmatch ? 'checked="checked"' : '').'/>
						<label for="match_notmatched_rb">'.ML_EBAY_LABEL_ONLY_NOT_PREPARED.'</label>
					</td>
					<td class="texcenter inputCell">
						<table class="right"><tbody>
							<tr><td><input type="submit" class="fullWidth button smallmargin" value="'.ML_EBAY_BUTTON_PREPARE.'" id="prepare" name="prepare"/></td></tr>
						</tbody></table>
					</td>
					<td>
						<div class="desc" id="desc_man_match" title="'.ML_LABEL_INFOS.'"><span>'.ML_EBAY_LABEL_PREPARE.'</span></div>
					</td>
				</tr>
			</tbody></table>
		';

	}

	public function getLeftButtons() {
		return '
<input type="submit" class="button" value="'.ML_EBAY_BUTTON_UNPREPARE.'" id="unprepare" name="unprepare"/><br/>
<input type="submit" class="button" value="'.ML_EBAY_BUTTON_RESET_DESCRIPTION.'" id="reset_description" name="reset_description"/>';
	}
}
