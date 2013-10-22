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

require_once(DIR_MAGNALISTER_MODULES.'magnacompatible/configure.php');

class TradoriaConfigure extends MagnaCompatibleConfigure {

	protected function getAuthValuesFromPost() {
		$nAPIKey = trim($_POST['conf'][$this->marketplace.'.apikey']);
		$nMPUser = trim($_POST['conf'][$this->marketplace.'.mpusername']);
		$nMPPass = trim($_POST['conf'][$this->marketplace.'.mppassword']);
		$nMPPass = $this->processPasswordFromPost('mppassword', $nMPPass);

		if (empty($nAPIKey)) {
			unset($_POST['conf'][$this->marketplace.'.apikey']);
		}
		if (empty($nMPUser)) {
			unset($_POST['conf'][$this->marketplace.'.mpusername']);
		}
		if ($nMPPass === false) {
			unset($_POST['conf'][$this->marketplace.'.mppassword']);
			return false;
		}
		return array (
			'KEY' => $nAPIKey,
			'MPUSERNAME' => $nMPUser,
			'MPPASSWORD' => $nMPPass,
		);
	}
	
	protected function getFormFiles() {
		$forms = parent::getFormFiles();
		$forms[] = 'checkinTaxMatching';
		$forms[] = 'prepare/useShopCatsAsOwn';
		return $forms;
	}
	
	protected function finalizeForm() {
		$this->form['checkin']['fields']['tax']['procFunc'] = array($this, 'confTaxMatching');
	}

	public function confTaxMatching($args, &$value = '') {
		global $_MagnaSession;
		$taxes = MagnaDB::gi()->fetchArray('
		    SELECT tc.tax_class_id AS id, MAX(tr.tax_rate) AS rate, tc.tax_class_title AS title
		      FROM '.TABLE_TAX_RATES.' tr, '.TABLE_TAX_CLASS.' tc
		     WHERE tr.tax_class_id=tc.tax_class_id
		  GROUP BY tc.tax_class_id
		');
		$taxMatch = getDBConfigValue($args['key'], $this->mpID, array());
		$opts = array (
			'1' => '19 %',
			'2' => '7 %',
			'3' => '0 %',
			'4' => '10,7 %',
			'10' => '10 %',
			'11' => '12 %',
			'12' => '20 %',
		);
		$html = '<table class="nostyle"><tbody>';
		foreach ($taxes as $tax) {
			$html .= '
				<tr>
					<td>'.$tax['title'].' ('.$tax['rate'].'%)</td>
					<td><select name="conf['.$args['key'].']['.$tax['id'].']">';
			foreach ($opts as $key => $val) {
				$html .= '<option value="'.$key.'" '.(
					(array_key_exists($tax['id'], $taxMatch) && ($taxMatch[$tax['id']] == $key))
						? 'selected="selected"'
						: ''
				).'>'.$val.'</option>';
			}
			$html .= '
					</select></td>
				</tr>';
		}
		$html .= '</tbody></table>';
	
	#	$html .= print_m($taxes, '$taxes');
	#	$html .= print_m(func_get_args(), 'func_get_args');
		return $html;
	}
	
}