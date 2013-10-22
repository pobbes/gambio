<?php
/*
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
*/

if (file_exists(DIR_WS_CLASSES.'class.heidelpay.php')){
	include_once(DIR_WS_CLASSES.'class.heidelpay.php');
} else {
	require_once(DIR_FS_CATALOG.DIR_WS_CLASSES.'class.heidelpay.php');
}

class hpidl_ORIGIN {
	var $code, $title, $description, $enabled, $hp, $payCode, $tmpStatus;

	// class constructor
	function hpidl_ORIGIN() /*{{{*/
	{
		global $order, $language;

		$this->payCode = 'idl';
		$this->code = 'hp'.$this->payCode;
		$this->version = '1.0';
		$this->title = MODULE_PAYMENT_HPIDL_TEXT_TITLE;
		$this->description = MODULE_PAYMENT_HPIDL_TEXT_DESC;
		$this->sort_order = MODULE_PAYMENT_HPIDL_SORT_ORDER;
		$this->enabled = ((MODULE_PAYMENT_HPIDL_STATUS == 'True') ? true : false);
		$this->info = MODULE_PAYMENT_HPIDL_TEXT_INFO;
		#$this->form_action_url = 'checkout_success.php';
		$this->tmpOrders = false;
		$this->tmpStatus = MODULE_PAYMENT_HPIDL_NEWORDER_STATUS_ID;
		$this->order_status = MODULE_PAYMENT_HPIDL_NEWORDER_STATUS_ID;
		$this->hp = new heidelpay();
		$this->hp->actualPaymethod = strtoupper($this->payCode);
		/*
		 $this->icons_available = xtc_image(DIR_WS_ICONS . 'cc_amex_small.jpg') . ' ' .
		 xtc_image(DIR_WS_ICONS . 'cc_mastercard_small.jpg') . ' ' .
		 xtc_image(DIR_WS_ICONS . 'cc_visa_small.jpg') . ' ' .
		 xtc_image(DIR_WS_ICONS . 'cc_diners_small.jpg');
		 */

		if (is_object($order)) $this->update_status();

		// OT FIX
		if ($_GET['payment_error'] == 'hpot'){
			GLOBAL $smarty;
			$error = $this->get_error();
			$smarty->assign('error', htmlspecialchars($error['error']));
		}

	}/*}}}*/

	function update_status() /*{{{*/
	{
		global $order;

		if (($this->enabled == true) && ((int) MODULE_PAYMENT_HPIDL_ZONE > 0)) {
			$check_flag = false;
			$check_query = xtc_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_HPIDL_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");
			while ($check = xtc_db_fetch_array($check_query)) {
				if ($check['zone_id'] < 1) {
					$check_flag = true;
					break;
				}
				elseif ($check['zone_id'] == $order->billing['zone_id']) {
					$check_flag = true;
					break;
				}
			}

			if ($check_flag == false) {
				$this->enabled = false;
			}
		}
	}/*}}}*/

	function javascript_validation() /*{{{*/
	{
		return false;
	}/*}}}*/

	function selection() /*{{{*/
	{
		GLOBAL $order;
		if (strpos($_SERVER['SCRIPT_FILENAME'], 'checkout_payment') !== false){
			unset($_SESSION['hpLastData']);
			unset($_SESSION['hpIdealData']);
		}
		#$_SESSION['hpModuleMode'] = 'AFTER';

		if (MODULE_PAYMENT_HPIDL_TRANSACTION_MODE == 'LIVE' || strpos(MODULE_PAYMENT_HPIDL_TEST_ACCOUNT, $order->customer['email_address']) !== false) {
			if (MODULE_PAYMENT_HPIDL_MODULE_MODE == 'NOWPF'){
				$content = array (
				array (
            'title' => 'Land',
            'field' => '<select name="hpidl[onlineTransferCountry]" style="width: 200px;"><option selected="true" value="NL">Niederlande</option></select>',
				),
				array (
            'title' => 'Bank',
            'field' => '<select style="width: 200px;" name="hpidl[onlineTransferInstitute]"><option value="ABN_AMRO">ABN AMRO</option><option value="ABN_AMRO_TEST">ABN AMRO Test</option><option value="FORTIS">Fortis</option><option value="FORTIS_TEST">Fortis Test</option><option value="FRIESLAND_BANK">Friesland Bank</option><option value="ING">ING</option><option value="ING_TEST">ING Test</option><option value="POSTBANK">Postbank</option><option value="RBS_TEST">RBS Test</option><option value="RABOBANK">Rabobank</option><option value="SNS_BANK">SNS Bank</option></select>',
				),
				array (
            'title' => 'Konto-Nr.',
            'field' => '<input autocomplete="off" value="" style="width: 200px;" maxlength="50" name="hpidl[otAccountNumber]" type="TEXT">',
				),
				array (
            'title' => 'Bankleitzahl',
            'field' => '<input value="" style="width: 200px;" maxlength="50" name="hpidl[otBankCode]" type="TEXT">',
				),
				array (
            'title' => 'Kontoinhaber',
            'field' => '<input value="" style="width: 200px;" maxlength="50" name="hpidl[onlineTransferHolder]" type="TEXT">',
				),
				);
			} else {
				$content = array (
				array (
            'title' => '',
            'field' => '',
				),
				);
			}
		} else {
			$content = array (
			array (
          'title' => '',
          'field' => MODULE_PAYMENT_HPIDL_DEBUGTEXT,
			),
			);
		}

		return array (
			'id'          => $this->code,
			'module'      => $this->title,
			'fields'      => $content,
			'description' => $this->info
		);
	}/*}}}*/

	function pre_confirmation_check() /*{{{*/
	{
		GLOBAL $order;
		#echo 'HPIDL: '.__FUNCTION__; exit();
		if (MODULE_PAYMENT_HPIDL_TRANSACTION_MODE == 'LIVE' || strpos(MODULE_PAYMENT_HPIDL_TEST_ACCOUNT, $order->customer['email_address']) !== false) {
			if (defined('MODULE_PAYMENT_HPIDL_MODULE_MODE')) {
				$_SESSION['hpModuleMode'] = MODULE_PAYMENT_HPIDL_MODULE_MODE;
			} else {
				$_SESSION['hpModuleMode'] = 'AFTER' ;
			}
			$_SESSION['hpLastPost'] = $_POST;
			$_SESSION['hpIdealData'] = $_POST['hpidl'];
		} else {
			$payment_error_return = 'payment_error=hpidl&error='.urlencode(MODULE_PAYMENT_HPIDL_DEBUGTEXT);
			xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
		}
	}/*}}}*/

	function confirmation() /*{{{*/
	{
		return false;
	}/*}}}*/

	function process_button() /*{{{*/
	{
		global $order;
		$this->hp->rememberOrderData($order);
		return false;
	}/*}}}*/

	function payment_action() /*{{{*/
	{
		return true;
	}/*}}}*/

	function before_process() /*{{{*/
	{
		return false;
	}/*}}}*/

	function after_process() /*{{{*/
	{
		global $order, $xtPrice, $insert_id;
		$this->hp->setOrderStatus($insert_id, $this->order_status);
		$comment = ' ';
		$this->hp->addHistoryComment($insert_id, $comment, $this->order_status);
		$hpIframe = $this->hp->handleDebit($order, $this->payCode, $insert_id);
		return false;
	}/*}}}*/

	function admin_order($oID) /*{{{*/
	{
		return false;
	}/*}}}*/

	function get_error() /*{{{*/
	{
		global $_GET;

		$error = array (
			'title' => MODULE_PAYMENT_HPIDL_TEXT_ERROR,
			'error' => stripslashes(urldecode($_GET['error']
		)));

		return $error;
	}/*}}}*/

	function check() /*{{{*/
	{
		if (!isset ($this->_check)) {
			$check_query = xtc_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_HPIDL_STATUS'");
			$this->_check = xtc_db_num_rows($check_query);
		}
		return $this->_check;
	}/*}}}*/

	function install() /*{{{*/
	{
		$this->remove(true);

		$groupId = 6;
		$sqlBase = 'INSERT INTO `'.TABLE_CONFIGURATION.'` SET ';
		$prefix = 'MODULE_PAYMENT_HPIDL_';
		$inst = array();
		$inst[] = array(
      'configuration_key'       => $prefix.'STATUS',
      'configuration_value'     => 'True',
      'set_function'            => 'xtc_cfg_select_option(array(\'True\', \'False\'), ',
		);
		$inst[] = array(
      'configuration_key'       => $prefix.'SECURITY_SENDER',
      'configuration_value'     => '31HA07BC8124AD82A9E96D9A35FAFD2A',
		);
		$inst[] = array(
      'configuration_key'       => $prefix.'USER_LOGIN',
      'configuration_value'     => '31ha07bc8124ad82a9e96d486d19edaa',
		);
		$inst[] = array(
      'configuration_key'       => $prefix.'USER_PWD',
      'configuration_value'     => 'password',
		);
		$inst[] = array(
      'configuration_key'       => $prefix.'TRANSACTION_CHANNEL',
      'configuration_value'     => '31HA07BC81A71E2A47DA804F6CABDC59',
		);
		$inst[] = array(
      'configuration_key'       => $prefix.'TRANSACTION_MODE',
      'configuration_value'     => 'CONNECTOR_TEST',
      'set_function'            => 'xtc_cfg_select_option(array(\'LIVE\', \'INTEGRATOR_TEST\', \'CONNECTOR_TEST\'), ',
		);
		$inst[] = array(
      'configuration_key'       => $prefix.'TEST_ACCOUNT',
      'configuration_value'     => '',
		);
		$inst[] = array(
      'configuration_key'       => $prefix.'SORT_ORDER',
      'configuration_value'     => '1',
		);
		$inst[] = array(
      'configuration_key'       => $prefix.'ZONE',
      'configuration_value'     => '',
      'set_function'            => 'xtc_cfg_pull_down_zone_classes(',
      'use_function'            => 'xtc_get_zone_class_title',
		);
		$inst[] = array(
      'configuration_key'       => $prefix.'ALLOWED',
      'configuration_value'     => '',
		);
		$inst[] = array(
      'configuration_key'       => $prefix.'PROCESSED_STATUS_ID',
      'configuration_value'     => '0',
      'set_function'            => 'xtc_cfg_pull_down_order_statuses(',
      'use_function'            => 'xtc_get_order_status_name',
		);
		$inst[] = array(
      'configuration_key'       => $prefix.'PENDING_STATUS_ID',
      'configuration_value'     => '0',
      'set_function'            => 'xtc_cfg_pull_down_order_statuses(',
      'use_function'            => 'xtc_get_order_status_name',
		);
		$inst[] = array(
      'configuration_key'       => $prefix.'CANCELED_STATUS_ID',
      'configuration_value'     => '0',
      'set_function'            => 'xtc_cfg_pull_down_order_statuses(',
      'use_function'            => 'xtc_get_order_status_name',
		);
		$inst[] = array(
      'configuration_key'       => $prefix.'NEWORDER_STATUS_ID',
      'configuration_value'     => '0',
      'set_function'            => 'xtc_cfg_pull_down_order_statuses(',
      'use_function'            => 'xtc_get_order_status_name',
		);
		/*
		 $inst[] = array(
		 'configuration_key'       => $prefix.'',
		 'configuration_value'     => '',
		 'set_function'            => '',
		 'use_function'            => '',
		 );
		 */
		foreach($inst AS $k => $v){
			$sql = $sqlBase.' ';
			foreach($v AS $key => $val){
				$sql.= '`'.addslashes($key).'` = "'.$val.'", ';
			}
			$sql.= '`sort_order` = "'.$k.'", ';
			$sql.= '`configuration_group_id` = "'.addslashes($groupId).'", ';
			$sql.= '`date_added` = NOW() ';
			#echo $sql.'<br>';
			xtc_db_query($sql);
		}

	}/*}}}*/

	function remove($install = false) /*{{{*/
	{
		if ($install) heidelpay::checkInstall($this->code);
		xtc_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
	}/*}}}*/

	function keys() /*{{{*/
	{
		return array (
			'MODULE_PAYMENT_HPIDL_STATUS',
      'MODULE_PAYMENT_HPIDL_SECURITY_SENDER',
      'MODULE_PAYMENT_HPIDL_USER_LOGIN',
      'MODULE_PAYMENT_HPIDL_USER_PWD',
      'MODULE_PAYMENT_HPIDL_TRANSACTION_CHANNEL',
      'MODULE_PAYMENT_HPIDL_TRANSACTION_MODE',
      'MODULE_PAYMENT_HPIDL_TEST_ACCOUNT',
			'MODULE_PAYMENT_HPIDL_PROCESSED_STATUS_ID',
			'MODULE_PAYMENT_HPIDL_PENDING_STATUS_ID',
			'MODULE_PAYMENT_HPIDL_CANCELED_STATUS_ID',
			'MODULE_PAYMENT_HPIDL_NEWORDER_STATUS_ID',
			'MODULE_PAYMENT_HPIDL_SORT_ORDER',
			'MODULE_PAYMENT_HPIDL_ALLOWED',
      'MODULE_PAYMENT_HPIDL_ZONE',
		#'MODULE_PAYMENT_HPIDL_',
		);
	}/*}}}*/

}

MainFactory::load_origin_class('hpidl');
?>