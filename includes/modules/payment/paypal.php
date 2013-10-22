<?php
/* --------------------------------------------------------------
   paypal.php 2012-02-27 misc
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

*
 * Project:   	xt:Commerce - eCommerce Engine
 * @version $Id
 *
 * xt:Commerce - Shopsoftware
 * (c) 2003-2007 xt:Commerce (Winger/Zanier), http://www.xt-commerce.com
 *
 * xt:Commerce ist eine geschï¿½tzte Handelsmarke und wird vertreten durch die xt:Commerce GmbH (Austria)
 * xt:Commerce is a protected trademark and represented by the xt:Commerce GmbH (Austria)
 *
 * @copyright Copyright 2003-2007 xt:Commerce (Winger/Zanier), www.xt-commerce.com
 * @copyright based on Copyright 2002-2003 osCommerce; www.oscommerce.com
 * @copyright based on Copyright 2003 nextcommerce; www.nextcommerce.org
 * @license http://www.xt-commerce.com.com/license/2_0.txt GNU Public License V2.0
 *
 * For questions, help, comments, discussion, etc., please join the
 * xt:Commerce Support Forums at www.xt-commerce.com
 *
 */

class paypal_ORIGIN {
	var $code, $title, $description, $enabled;

	function paypal_ORIGIN() {
		global $order;
		
		$coo_paypal = new paypal_checkout();
		$version = $coo_paypal->get_version();
		$tool_link = $coo_paypal->get_api_link();
		unset($coo_paypal);
		$this->code = 'paypal';
		$this->title = '<img src="https://www.paypal-deutschland.de/external/logocenter-update/logo-paypal-100x27.gif" border="0" alt="PayPal-Standard-Logo">'. MODULE_PAYMENT_PAYPAL_TEXT_TITLE;
		$this->description = '
			<h2>PayPal Basis (empfohlen)</h2>
			<p>Version: '.$version.'</p>
			<p><a href="http://www.gambio.de/Unsere-Partner/PayPal.html" target="_blank"><img src="https://www.paypal-deutschland.de/external/logocenter-update/logo-paypal-150x41.gif" border=0 /></a></p>
			<p><a href="http://www.gambio.de/Unsere-Partner/PayPal.html" target="_blank"><u>Ausf&uuml;hrliche Informationen und Anmeldung</u></a></p>
			<p><a href="'.$tool_link.'" style="text-decoration:underline" target="_blank">'.BOX_API_TOOL.'</a></p>
			<p>			
				'.MODULE_PAYMENT_PAYPAL_TEXT_DESCRIPTION .'
				<a href="configuration.php?gID=25" style="text-decoration:underline">'.BOX_CONFIGURATION.'</a><br />
			<br />
			';
        if(MODULE_PAYMENT_PAYPAL_SORT_ORDER!=''){
		  $this->sort_order = MODULE_PAYMENT_PAYPAL_SORT_ORDER;
		}else{
		  $this->sort_order = 2;
		}
		$this->enabled = ((MODULE_PAYMENT_PAYPAL_STATUS == 'True') ? true : false);
		$this->info = MODULE_PAYMENT_PAYPAL_TEXT_INFO;
		$this->order_status_success = PAYPAL_ORDER_STATUS_SUCCESS_ID;
		$this->order_status_rejected = PAYPAL_ORDER_STATUS_REJECTED_ID;
		$this->order_status_pending = PAYPAL_ORDER_STATUS_PENDING_ID;
		$this->order_status_tmp = PAYPAL_ORDER_STATUS_TMP_ID;
		$this->tmpOrders = true;
		$this->debug = true;
		$this->tmpStatus = PAYPAL_ORDER_STATUS_TMP_ID;


		if (is_object($order))
			$this->update_status();

		//$this->form_action_url = 'https://www.paypal.com/cgi-bin/webscr';
	}

	function update_status() {
		global $order;

		if (($this->enabled == true) && ((int) MODULE_PAYMENT_PAYPAL_ZONE > 0)) {
			$check_flag = false;
			$check_query = xtc_db_query("select zone_id from ".TABLE_ZONES_TO_GEO_ZONES." where geo_zone_id = '".MODULE_PAYMENT_PAYPAL_ZONE."' and zone_country_id = '".$order->billing['country']['id']."' order by zone_id");
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
	}

	function javascript_validation() {
		return false;
	}

	function selection() {
		return array ('id' => $this->code, 'module' => $this->title, 'description' => $this->info);
	}

	function pre_confirmation_check() {
		return false;
	}

	function confirmation() {
		return false;
	}

	function process_button() {
		return false;
	}

	function before_process() {
		return false;
	}

	function payment_action() {
		global $order, $o_paypal, $tmp, $insert_id;

		$o_paypal->paypal_auth_call('checkout_process');

		$tmp = false;

		if (substr($o_paypal->payPalURL, 0, strlen(HTTP_SERVER)) == HTTP_SERVER || substr($o_paypal->payPalURL, 0, strlen(HTTPS_SERVER)) == HTTPS_SERVER){
			xtc_redirect($o_paypal->payPalURL);
		}else{
			xtc_redirect($o_paypal->payPalURL.'&useraction=commit');
		}

	}

	function after_process() {
		global $order, $insert_id, $o_paypal;

		$o_paypal->complete_express_ceckout($insert_id, $_GET, true);
		$o_paypal->write_status_history($insert_id);
		$o_paypal->logging_status($insert_id);
	}

	function output_error() {
		return false;
	}

	function check() {
		if (!isset ($this->_check)) {
			$check_query = xtc_db_query("select configuration_value from ".TABLE_CONFIGURATION." where configuration_key = 'MODULE_PAYMENT_PAYPAL_STATUS'");
			$this->_check = xtc_db_num_rows($check_query);
		}
		return $this->_check;
	}

	function admin_order($oID) {
		return false;
	}

	function install() {
		// BOF GM_MOD
		$stati_name['german']['PAYPAL_INST_ORDER_STATUS_TMP_NAME']		 = 'PayPal Abbruch';
		$stati_name['german']['PAYPAL_INST_ORDER_STATUS_REJECTED_NAME']	 = 'PayPal abgelehnt';
		$stati_name['english']['PAYPAL_INST_ORDER_STATUS_TMP_NAME']		 = 'PayPal canceled';
		$stati_name['english']['PAYPAL_INST_ORDER_STATUS_REJECTED_NAME'] = 'PayPal rejected';
		
		// Bestell Status prüfen oder erfassen
		$stati = array(
			'PAYPAL_INST_ORDER_STATUS_TMP_NAME'=>'PAYPAL_INST_ORDER_STATUS_TMP_ID',
			'PAYPAL_INST_ORDER_STATUS_SUCCESS_NAME'=>'PAYPAL_INST_ORDER_STATUS_SUCCESS_ID',
			'PAYPAL_INST_ORDER_STATUS_PENDING_NAME'=>'PAYPAL_INST_ORDER_STATUS_PENDING_ID',
			'PAYPAL_INST_ORDER_STATUS_REJECTED_NAME'=>'PAYPAL_INST_ORDER_STATUS_REJECTED_ID');
		foreach($stati as $statusname => $statusid) {
			$languages_query = xtc_db_query("select * from " . TABLE_LANGUAGES . " order by sort_order");
			while($languages = xtc_db_fetch_array($languages_query)) {
				if(isset($stati_name[$languages['directory']][$statusname])) {
					$new_statusname = $stati_name[$languages['directory']][$statusname];
					$check_query = xtc_db_query("select orders_status_id from " . TABLE_ORDERS_STATUS . " where orders_status_name = '" .$new_statusname. "' AND language_id='".$languages['languages_id']."' limit 1");
					$status = xtc_db_fetch_array($check_query);
					if(xtc_db_num_rows($check_query) < 1 OR ($$statusid AND $status['orders_status_id']!=$$statusid) ) {
						if(!$$statusid) {
							$status_query = xtc_db_query("select max(orders_status_id) as status_id from " . TABLE_ORDERS_STATUS);
							$status = xtc_db_fetch_array($status_query);
							$$statusid = $status['status_id']+1;
						}
						$check_query = xtc_db_query("select orders_status_id from " . TABLE_ORDERS_STATUS . " where orders_status_id = '".$$statusid ."' AND language_id='".$languages['languages_id']."'");
						if(xtc_db_num_rows($check_query)<1) {
							xtc_db_query("insert into " . TABLE_ORDERS_STATUS . " (orders_status_id, language_id, orders_status_name) values ('" . $$statusid . "', '" . $languages['languages_id'] . "', '" .$new_statusname. "')");
							if($statusid == 'PAYPAL_INST_ORDER_STATUS_TMP_ID') {
								xtc_db_query("UPDATE ".TABLE_CONFIGURATION." SET configuration_value = '".$$statusid."' WHERE configuration_key = 'PAYPAL_ORDER_STATUS_TMP_ID'");
							}
							if($statusid == 'PAYPAL_INST_ORDER_STATUS_REJECTED_ID') {
								xtc_db_query("UPDATE ".TABLE_CONFIGURATION." SET configuration_value = '".$$statusid."' WHERE configuration_key = 'PAYPAL_ORDER_STATUS_REJECTED_ID'");
							}
						}
					} else {
						$statusname = $status['orders_status_id'];
					}
				}
			}
		}
		// EOF GM_MOD

		xtc_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_PAYPAL_STATUS', 'True', '6', '3', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_PAYPAL_ALLOWED', '', '6', '0', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_PAYPAL_SORT_ORDER', '0', '6', '0', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_PAYMENT_PAYPAL_ZONE', '0', '6', '2', 'xtc_get_zone_class_title', 'xtc_cfg_pull_down_zone_classes(', now())");
	}

	function remove() {
		// BOF GM_MOD
		$coo_module_manager = new GMModuleManager('payment');
		$response = $coo_module_manager->get_modules_installed();
		// remove orderstatus if no paypal installed
		if(count($response) <= 1) {
			$stati_name['german']['PAYPAL_INST_ORDER_STATUS_TMP_NAME']		 = 'PayPal Abbruch';
			$stati_name['german']['PAYPAL_INST_ORDER_STATUS_REJECTED_NAME']	 = 'PayPal abgelehnt';
			$stati_name['english']['PAYPAL_INST_ORDER_STATUS_TMP_NAME']		 = 'PayPal canceled';
			$stati_name['english']['PAYPAL_INST_ORDER_STATUS_REJECTED_NAME'] = 'PayPal rejected';

			$stati = array(
				'PAYPAL_INST_ORDER_STATUS_TMP_NAME'=>'PAYPAL_INST_ORDER_STATUS_TMP_ID',
				'PAYPAL_INST_ORDER_STATUS_SUCCESS_NAME'=>'PAYPAL_INST_ORDER_STATUS_SUCCESS_ID',
				'PAYPAL_INST_ORDER_STATUS_PENDING_NAME'=>'PAYPAL_INST_ORDER_STATUS_PENDING_ID',
				'PAYPAL_INST_ORDER_STATUS_REJECTED_NAME'=>'PAYPAL_INST_ORDER_STATUS_REJECTED_ID');
			foreach($stati as $statusname => $statusid) {
				$languages_query = xtc_db_query("select * from " . TABLE_LANGUAGES . " order by sort_order");
				while($languages = xtc_db_fetch_array($languages_query)) {
					if(isset($stati_name[$languages['directory']][$statusname])) {
						$new_statusname = $stati_name[$languages['directory']][$statusname];
						//$sql = "DELETE FROM " . TABLE_ORDERS_STATUS . " WHERE orders_status_name = '" .$new_statusname. "'";
						//xtc_db_query($sql);
					}
				}
			}
		}

		xtc_db_query("delete from ".TABLE_CONFIGURATION." where configuration_key in ('".implode("', '", $this->keys())."')");
		// EOF GM_MOD
	}

	function keys() {
		return array ('MODULE_PAYMENT_PAYPAL_STATUS', 'MODULE_PAYMENT_PAYPAL_ALLOWED', 'MODULE_PAYMENT_PAYPAL_ZONE','MODULE_PAYMENT_PAYPAL_SORT_ORDER');
	}

  function check_paypal_api()
  {
      if (isset($_GET['module']) && substr($_GET['module'],0,6) == 'paypal') {
      require_once(DIR_FS_CATALOG.DIR_WS_CLASSES.'paypal_checkout.php');
      $paypal = new paypal_checkout();
      return $paypal->check_api();
    }
		return '';
  }
}

MainFactory::load_origin_class('paypal');
?>