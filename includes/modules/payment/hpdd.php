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

class hpdd_ORIGIN {
	var $code, $title, $description, $enabled, $hp, $payCode, $tmpStatus;

	// class constructor
	function hpdd_ORIGIN() /*{{{*/
	{
		global $order, $language;

		$this->payCode = 'dd';
		$this->code = 'hp'.$this->payCode;
		$this->version = '1.0';
		$this->title = MODULE_PAYMENT_HPDD_TEXT_TITLE;
		$this->description = MODULE_PAYMENT_HPDD_TEXT_DESC;
		$this->sort_order = MODULE_PAYMENT_HPDD_SORT_ORDER;
		$this->enabled = ((MODULE_PAYMENT_HPDD_STATUS == 'True') ? true : false);
		$this->info = MODULE_PAYMENT_HPDD_TEXT_INFO;
		#$this->form_action_url = 'checkout_success.php';
		$this->tmpOrders = false;
		$this->tmpStatus = MODULE_PAYMENT_HPDD_NEWORDER_STATUS_ID;
		$this->order_status = MODULE_PAYMENT_HPDD_NEWORDER_STATUS_ID;
		$this->hp = new heidelpay();
		$this->hp->actualPaymethod = strtoupper($this->payCode);
		/*
		 $this->icons_available = xtc_image(DIR_WS_ICONS . 'cc_amex_small.jpg') . ' ' .
		 xtc_image(DIR_WS_ICONS . 'cc_mastercard_small.jpg') . ' ' .
		 xtc_image(DIR_WS_ICONS . 'cc_visa_small.jpg') . ' ' .
		 xtc_image(DIR_WS_ICONS . 'cc_diners_small.jpg');
		 */

		if (is_object($order)) $this->update_status();


	}/*}}}*/

	function update_status() /*{{{*/
	{
		global $order;

		if (($this->enabled == true) && ((int) MODULE_PAYMENT_HPDD_ZONE > 0)) {
			$check_flag = false;
			$check_query = xtc_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_HPDD_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");
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
			unset($_SESSION['hpDDData']);
		}
		#$_SESSION['hpModuleMode'] = MODULE_PAYMENT_HPDD_MODULE_MODE;
		#echo '<pre>'.print_r($_SESSION, 1).'</pre>';
		$src = '';
		if (isset($_GET['hpddreg'])){
			$src = $this->hp->handleRegister($order, $this->payCode);
			#echo '<pre>'.print_r($src, 1).'</pre>'; exit();
		}
		$hpIframe = '';
		if (!empty($src)){
			if (gm_get_conf('GM_LIGHTBOX_CHECKOUT')){
				GLOBAL $smarty;
				$smarty->assign('LIGHTBOX', gm_get_conf('GM_LIGHTBOX_CHECKOUT'));
				if($_SESSION['style_edit_mode'] == 'edit') $smarty->assign('STYLE_EDIT', 1);
				else $smarty->assign('STYLE_EDIT', 0);
				$smarty->assign('language', $_SESSION['language']);
				$hpIframe = '<center><iframe src="'.$src.'" frameborder="0" width="700" height="250" style="border: 0px solid #ddd"></iframe></center><br>';
				$smarty->assign('content', $hpIframe);
				$smarty->assign('HPIFRAME', 'true');
				$content = $smarty->fetch(CURRENT_TEMPLATE . '/module/checkout_payment_hp.html');
				$hpIframe = $content;
				$_SESSION['HEIDELPAY_IFRAME'] = $hpIframe;
				header('Location: heidelpay_checkout_iframe.php?'.session_name().'='.session_id());
				exit();
			} else {
				$_SESSION['HEIDELPAY_IFRAME'] = $hpIframe;
				header('Location: heidelpay_iframe.php?'.session_name().'='.session_id());
				exit();
			}
		}

		if (MODULE_PAYMENT_HPDD_TRANSACTION_MODE == 'LIVE' || strpos(MODULE_PAYMENT_HPDD_TEST_ACCOUNT, $order->customer['email_address']) !== false) {
			if (MODULE_PAYMENT_HPDD_MODULE_MODE == 'NOWPF'){
				$content = array (
				array (
            'title' => 'Konto-Nr.',
            'field' => '<input autocomplete="off" value="" style="width: 200px;" maxlength="50" name="hpdd[AccountNumber]" type="TEXT">',
				),
				array (
            'title' => 'Bankleitzahl',
            'field' => '<input value="" style="width: 200px;" maxlength="50" name="hpdd[BankCode]" type="TEXT">',
				),
				array (
            'title' => 'Kontoinhaber',
            'field' => '<input value="" style="width: 200px;" maxlength="50" name="hpdd[Holder]" type="TEXT">',
				),
				);
			} else {
				$content = array (
				array (
            'title' => '',
            'field' => ''.$hpIframe.'<input type="hidden" name="hpddFirstStep" value="1">',
				),
				);
			}
		} else {
			$content = array (
			array (
          'title' => '',
          'field' => MODULE_PAYMENT_HPDD_DEBUGTEXT,
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
		#echo 'HPDD: '.__FUNCTION__; exit();
		if (MODULE_PAYMENT_HPDD_TRANSACTION_MODE == 'LIVE' || strpos(MODULE_PAYMENT_HPDD_TEST_ACCOUNT, $order->customer['email_address']) !== false) {
			if (defined('MODULE_PAYMENT_HPDD_MODULE_MODE')) {
				$_SESSION['hpModuleMode'] = MODULE_PAYMENT_HPDD_MODULE_MODE;
			} else {
				$_SESSION['hpModuleMode'] = 'AFTER' ;
			}
			if ($_POST['hpddFirstStep'] == 1 && MODULE_PAYMENT_HPDD_MODULE_MODE == 'DIRECT'){
				unset($_POST['hpddFirstStep']);
				$_SESSION['hpLastPost'] = $_POST;
				$payment_error_return = 'hpddreg=1';
				xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
			} else {
				$_SESSION['hpLastPost'] = $_POST;
				$_SESSION['hpDDData'] = $_POST['hpdd'];
			}
		} else {
			$payment_error_return = 'payment_error=hpdd&error='.urlencode(MODULE_PAYMENT_HPDD_DEBUGTEXT);
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
			'title' => MODULE_PAYMENT_HPDD_TEXT_ERROR,
			'error' => stripslashes(urldecode($_GET['error']
		)));

		return $error;
	}/*}}}*/

	function check() /*{{{*/
	{
		if (!isset ($this->_check)) {
			$check_query = xtc_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_HPDD_STATUS'");
			$this->_check = xtc_db_num_rows($check_query);
		}
		return $this->_check;
	}/*}}}*/

	function install() /*{{{*/
	{
		$this->remove(true);

		$groupId = 6;
		$sqlBase = 'INSERT INTO `'.TABLE_CONFIGURATION.'` SET ';
		$prefix = 'MODULE_PAYMENT_HPDD_';
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
      'configuration_value'     => '31HA07BC81A71E2A47DA94B6ADC524D8',
		);
		$inst[] = array(
      'configuration_key'       => $prefix.'TRANSACTION_MODE',
      'configuration_value'     => 'INTEGRATOR_TEST',
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
			'MODULE_PAYMENT_HPDD_STATUS',
      'MODULE_PAYMENT_HPDD_SECURITY_SENDER',
      'MODULE_PAYMENT_HPDD_USER_LOGIN',
      'MODULE_PAYMENT_HPDD_USER_PWD',
      'MODULE_PAYMENT_HPDD_TRANSACTION_CHANNEL',
      'MODULE_PAYMENT_HPDD_TRANSACTION_MODE',
      'MODULE_PAYMENT_HPDD_DIRECT_MODE',
      'MODULE_PAYMENT_HPDD_TEST_ACCOUNT',
			'MODULE_PAYMENT_HPDD_PROCESSED_STATUS_ID',
			'MODULE_PAYMENT_HPDD_PENDING_STATUS_ID',
			'MODULE_PAYMENT_HPDD_CANCELED_STATUS_ID',
			'MODULE_PAYMENT_HPDD_NEWORDER_STATUS_ID',
			'MODULE_PAYMENT_HPDD_SORT_ORDER',
			'MODULE_PAYMENT_HPDD_ALLOWED',
      'MODULE_PAYMENT_HPDD_ZONE',
		#'MODULE_PAYMENT_HPDD_',
		);
	}/*}}}*/

}

MainFactory::load_origin_class('hpdd');
?>