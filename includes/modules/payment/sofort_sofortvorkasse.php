<?php
/**
 * @version SOFORT Gateway 5.2.0 - $Date: 2012-11-21 12:09:39 +0100 (Wed, 21 Nov 2012) $
 * @author SOFORT AG (integration@sofort.com)
 * @link http://www.sofort.com/
 *
 * Copyright (c) 2012 SOFORT AG
 * 
 * Released under the GNU General Public License (Version 2)
 * [http://www.gnu.org/licenses/gpl-2.0.html]
 *
 * $Id: sofort_sofortvorkasse.php 5725 2012-11-21 11:09:39Z rotsch $
 */

require_once(DIR_FS_CATALOG.'callback/sofort/sofort.php');
require_once(DIR_FS_CATALOG.'callback/sofort/library/sofortLib.php');

class sofort_sofortvorkasse extends sofort {
	
	function sofort_sofortvorkasse() {
		global $order;
		
		parent::sofort();
		
		$this->_checkExistingSofortConstants('sv');
		
		//if(isset($_SESSION['sofort']['sofort_conditions_sv'])) unset($_SESSION['sofort']['sofort_conditions_sv']);
		
		$this->code = 'sofort_sofortvorkasse';
		$this->title = MODULE_PAYMENT_SOFORT_SOFORTVORKASSE_TEXT_TITLE;
		$this->title_extern = MODULE_PAYMENT_SOFORT_SV_TEXT_TITLE;
		$this->paymentMethod = 'SV';
		
		if(defined('MODULE_PAYMENT_SOFORT_SV_KS_STATUS') && MODULE_PAYMENT_SOFORT_SV_KS_STATUS == 'True'){
			$this->title_extern = MODULE_PAYMENT_SOFORT_SV_KS_TEXT_TITLE;
		}
		
		if (defined('MODULE_PAYMENT_SOFORT_SV_RECOMMENDED_PAYMENT') && MODULE_PAYMENT_SOFORT_SV_RECOMMENDED_PAYMENT == 'True') {
			$this->title_extern .= ' ' . MODULE_PAYMENT_SOFORT_SV_RECOMMENDED_PAYMENT_TEXT;
		}
		
		$this->enabled = (defined('MODULE_PAYMENT_SOFORT_SV_STATUS') && MODULE_PAYMENT_SOFORT_SV_STATUS == 'True') ? true : false;
		
		$this->description = MODULE_PAYMENT_SOFORT_SV_TEXT_DESCRIPTION.'<br />'.MODULE_PAYMENT_SOFORT_MULTIPAY_VERSIONNUMBER.': '.HelperFunctions::getSofortmodulVersion();
		if ($this->_isInstalled() && (!defined('MODULE_PAYMENT_SOFORT_MULTIPAY_MODULE_VERSION') || 
				strcasecmp(trim(MODULE_PAYMENT_SOFORT_MULTIPAY_MODULE_VERSION), trim(HelperFunctions::getSofortmodulVersion())) != 0)) {
			$this->description = '<span style ="color:red; font-weight: bold; font-size: 1.2em">'.MODULE_PAYMENT_SOFORT_MULTIPAY_UPDATE_NOTICE.'</span><br /><br />'.$this->description;
		}
		$this->description .= MODULE_PAYMENT_SOFORT_SV_TEXT_DESCRIPTION_EXTRA;
		$this->sort_order = (defined('MODULE_PAYMENT_SOFORT_SV_SORT_ORDER') ? MODULE_PAYMENT_SOFORT_SV_SORT_ORDER : false);
		
		if (is_object($order)) {
			$this->update_status();
		}
		
		if (defined('MODULE_PAYMENT_SOFORT_SV_STATUS')) {
			$this->sofort = new SofortLib_Multipay(MODULE_PAYMENT_SOFORT_MULTIPAY_APIKEY);
			$this->sofort->setVersion(HelperFunctions::getSofortmodulVersion());
			if (defined('MODULE_PAYMENT_SOFORT_MULTIPAY_LOG_ENABLED') && MODULE_PAYMENT_SOFORT_MULTIPAY_LOG_ENABLED == "True") {
				$this->sofort->setLogEnabled();
			}
		}
	}
	
	
	/**
	 * Show this payment-method (Vorkasse) at payment-page
	 */
	function selection() {
		
		if (!parent::selection()) {
			$this->sofort->log("Notice: Paymentmethod ".$this->code." will be deactivated for selection.");
			$this->enabled = false;
			return false;
		}
		
		if(!$this->sofort_js){
			$title = MODULE_PAYMENT_SOFORT_MULTIPAY_JS_LIBS;
			$this->sofort_js = true;
		} else {
			$title = '';
		}
		
		$cost = '';
		if(array_key_exists('ot_sofort',  $GLOBALS)) {
			$cost = $GLOBALS['ot_sofort']->get_percent($this->code, 'price');
		}
		
		//if Gambio-Lightbox then show normal conditions-link
		if (defined('GM_LIGHTBOX_CHECKOUT') && function_exists('gm_get_conf') && gm_get_conf('GM_LIGHTBOX_CHECKOUT') == 'true') {
			$conditionsText = MODULE_PAYMENT_SOFORT_SV_CHECKOUT_CONDITIONS_WITH_LIGHTBOX;
		} else {
			$conditionsText = MODULE_PAYMENT_SOFORT_SV_CHECKOUT_CONDITIONS;
		}
		
		$fields = array(
				array('title' => $conditionsText,
						'field' => xtc_draw_checkbox_field('sofort_conditions_sv', 'sofort_conditions_sv', false))
		);
		
		//commerce:SEO - Bugfix
		if (isset($_REQUEST['xajax']) && !empty($_REQUEST['xajax'])) {
			$fields[0]['title'] = utf8_decode($fields[0]['title']);
			return array('id' => $this->code , 'module' => utf8_decode($this->title_extern), 'fields' => $fields, 'description' => utf8_decode($title), 'module_cost' => utf8_decode($cost));
		}else{
			return array('id' => $this->code , 'module' => $this->title_extern , 'fields' => $fields, 'description' => $title, 'module_cost' => $cost);
		}
	}
	
	
	function pre_confirmation_check ($vars = '') {
		
		parent::pre_confirmation_check ($vars);
		
		//in CommerceSEO check is done with Ajax
		if (isset ($_POST['xajax']) && $_POST['xajax'] == 'updatePaymentModule' ) {
			$requestData = $vars;
			$is_ajax = true;
		} else {
			$is_ajax = false;
			$requestData = $_POST;
		}
		
		$requestData['sofort_conditions_sv']        = trim($requestData['sofort_conditions_sv']);
		$_SESSION['sofort']['sofort_conditions_sv'] = isset($requestData['sofort_conditions_sv']) ? $requestData['sofort_conditions_sv'] : '';
		
		if ($_SESSION['sofort']['sofort_conditions_sv'] != 'sofort_conditions_sv') {
			if ($is_ajax) {
				$payment_error_return = 'payment_error='.$this->code.'&error='.urlencode(MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_10002);
				$_SESSION['checkout_payment_error'] = $payment_error_return;
			} else {
				$payment_error_return = 'payment_error='.$this->code.'&error_codes=10002';
				$redirectUrl = xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false);
				xtc_redirect(HelperFunctions::cleanUrlParameter($redirectUrl));
			}
		}
		
		return false;
	}
	
	
	/**
	 * @see sofort::before_process()
	 */
	function before_process() {
		$this->_setSvBankDataToEmail();
	}
	
	function after_process() {
		global $insert_id;
		
		parent::after_process();
		
		$redirectUrl = $this->_insertSvBankdataAndGetLinkToBankdataPage($insert_id);
		
		//we must delete the shop-sessiondata ourself because we redirect in the next line
		$this->_resetCartAndDeleteSessionData();
		
		xtc_redirect($redirectUrl);
	}
	
	
	function install() {
		$sofortStatuses = $this->_insertAndReturnSofortStatus();
		$svUnpaidStatus = 	(isset($sofortStatuses['sv_unpaid'])&& !empty($sofortStatuses['sv_unpaid']))? $sofortStatuses['sv_unpaid'] : '';
		$svPaidStatus = 	(isset($sofortStatuses['sv_paid'])&& !empty($sofortStatuses['sv_paid']))? $sofortStatuses['sv_paid'] : '';
		$refundedStatus = 	(isset($sofortStatuses['refunded'])&& !empty($sofortStatuses['refunded']))? $sofortStatuses['refunded'] : '';
		$checkStatus = 		(isset($sofortStatuses['check'])&& !empty($sofortStatuses['check']))? $sofortStatuses['check'] : '';
		$unchangedStatus = 	(isset($sofortStatuses['unchanged'])&& !empty($sofortStatuses['unchanged']))? $sofortStatuses['unchanged'] : '';

		xtc_db_query("INSERT INTO " . HelperFunctions::escapeSql(TABLE_CONFIGURATION) . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_PAYMENT_SOFORT_SV_STATUS', 'False', '6', '1', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");
		xtc_db_query("INSERT INTO " . HelperFunctions::escapeSql(TABLE_CONFIGURATION) . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_PAYMENT_SOFORT_SV_KS_STATUS', 'False', '6', '27', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");
		xtc_db_query("INSERT INTO " . HelperFunctions::escapeSql(TABLE_CONFIGURATION) . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) VALUES ('MODULE_PAYMENT_SOFORT_SV_SORT_ORDER', '0', '6', '16', now())");
		xtc_db_query("INSERT INTO " . HelperFunctions::escapeSql(TABLE_CONFIGURATION) . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_PAYMENT_SOFORT_SV_RECOMMENDED_PAYMENT', 'False', '6', '5', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");
		xtc_db_query("INSERT INTO " . HelperFunctions::escapeSql(TABLE_CONFIGURATION) . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) VALUES ('MODULE_PAYMENT_SOFORT_SOFORTVORKASSE_ALLOWED', '', '6', '12', now())");
		xtc_db_query("INSERT INTO " . HelperFunctions::escapeSql(TABLE_CONFIGURATION) . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('MODULE_PAYMENT_SOFORT_SV_ZONE', '0', '6', '13', 'xtc_get_zone_class_title', 'xtc_cfg_pull_down_zone_classes(', now())");
		xtc_db_query("INSERT INTO " . HelperFunctions::escapeSql(TABLE_CONFIGURATION) . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) VALUES ('MODULE_PAYMENT_SOFORT_SV_REASON_2', '{{transaction_id}}', '6', '8', now())");
		
		//"Bisher kein Geldeingang" - pending-wait_for_money
		xtc_db_query("INSERT INTO ".HelperFunctions::escapeSql(TABLE_CONFIGURATION)." ( configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, use_function, date_added) VALUES ('MODULE_PAYMENT_SOFORT_SV_PEN_WAI_FOR_MON_STATUS_ID', '".HelperFunctions::escapeSql($svUnpaidStatus)."',  '6', '35', 'xtc_cfg_pull_down_order_statuses(', 'xtc_get_order_status_name', now())");
		
		//"Geldeingang" - received-credited
		xtc_db_query("INSERT INTO ".HelperFunctions::escapeSql(TABLE_CONFIGURATION)." ( configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, use_function, date_added) VALUES ('MODULE_PAYMENT_SOFORT_SV_REC_CRE_STATUS_ID', '".HelperFunctions::escapeSql($svPaidStatus)."',  '6', '36', 'xtc_cfg_pull_down_order_statuses(', 'xtc_get_order_status_name', now())");
		
		//"Kein Geldeingang": loss-not_credited
		xtc_db_query("INSERT INTO ".HelperFunctions::escapeSql(TABLE_CONFIGURATION)." ( configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, use_function, date_added) VALUES ('MODULE_PAYMENT_SOFORT_SV_LOS_NOT_CRE_STATUS_ID', '".HelperFunctions::escapeSql($checkStatus)."',  '6', '30', 'xtc_cfg_pull_down_order_statuses(', 'xtc_get_order_status_name', now())");
		
		//"Zu wenig �berwiesen": received-partially_credited
		//"Zu viel �berwiesen": received-overpayment
		xtc_db_query("INSERT INTO ".HelperFunctions::escapeSql(TABLE_CONFIGURATION)." ( configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, use_function, date_added) VALUES ('MODULE_PAYMENT_SOFORT_SV_WRONG_AMOUNT_STATUS_ID', '".HelperFunctions::escapeSql($checkStatus)."',  '6', '30', 'xtc_cfg_pull_down_order_statuses(', 'xtc_get_order_status_name', now())");
		
		//"Teilr�ckbuchung": refunded-compensation
		xtc_db_query("INSERT INTO ".HelperFunctions::escapeSql(TABLE_CONFIGURATION)." ( configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, use_function, date_added) VALUES ('MODULE_PAYMENT_SOFORT_SV_REF_COM_STATUS_ID', '".HelperFunctions::escapeSql($unchangedStatus)."',  '6', '30', 'xtc_cfg_pull_down_order_statuses(', 'xtc_get_order_status_name', now())");
		
		//"Vollst�ndige R�ckbuchung": refunded-refunded
		xtc_db_query("INSERT INTO ".HelperFunctions::escapeSql(TABLE_CONFIGURATION)." ( configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, use_function, date_added) VALUES ('MODULE_PAYMENT_SOFORT_SV_REF_REF_STATUS_ID', '".HelperFunctions::escapeSql($refundedStatus)."',  '6', '30', 'xtc_cfg_pull_down_order_statuses(', 'xtc_get_order_status_name', now())");
		
		//install shared keys, that are used by all/most multipay-modules
		parent::install();
	}


	function remove() {
		xtc_db_query("DELETE FROM " . HelperFunctions::escapeSql(TABLE_CONFIGURATION) . " WHERE configuration_key LIKE 'MODULE_PAYMENT_SOFORT_SV%'");
		xtc_db_query("DELETE FROM " . HelperFunctions::escapeSql(TABLE_CONFIGURATION) . " WHERE configuration_key LIKE 'MODULE_PAYMENT_SOFORT_SOFORTVORKASSE%'");

		//if this is the last removing of a multipay-paymentmethod --> we also remove all shared keys, that are used by all/most multipay-modules
		parent::remove();
	}


	function keys() {
		
		parent::keys();
		
		return array(
			'MODULE_PAYMENT_SOFORT_SV_STATUS',
			'MODULE_PAYMENT_SOFORT_MULTIPAY_APIKEY',
			'MODULE_PAYMENT_SOFORT_MULTIPAY_AUTH',
			'MODULE_PAYMENT_SOFORT_SV_RECOMMENDED_PAYMENT',
			'MODULE_PAYMENT_SOFORT_SV_REASON_2',
			'MODULE_PAYMENT_SOFORT_SOFORTVORKASSE_ALLOWED',
			'MODULE_PAYMENT_SOFORT_SV_ZONE',
			'MODULE_PAYMENT_SOFORT_SV_SORT_ORDER',
			'MODULE_PAYMENT_SOFORT_MULTIPAY_PROF_SETTINGS',
			'MODULE_PAYMENT_SOFORT_MULTIPAY_TEMP_STATUS_ID',
			'MODULE_PAYMENT_SOFORT_MULTIPAY_ABORTED_STATUS_ID',
			'MODULE_PAYMENT_SOFORT_SV_PEN_WAI_FOR_MON_STATUS_ID',
			'MODULE_PAYMENT_SOFORT_SV_REC_CRE_STATUS_ID',
			'MODULE_PAYMENT_SOFORT_SV_LOS_NOT_CRE_STATUS_ID',
			'MODULE_PAYMENT_SOFORT_SV_WRONG_AMOUNT_STATUS_ID',
			'MODULE_PAYMENT_SOFORT_SV_REF_COM_STATUS_ID',
			'MODULE_PAYMENT_SOFORT_SV_REF_REF_STATUS_ID',
			//'MODULE_PAYMENT_SOFORT_MULTIPAY_LOG_ENABLED',
			//'MODULE_PAYMENT_SOFORT_SV_KS_STATUS',  //currently not available
		);
	}
	
	
	/**
	 * save bankdata in users history and return link to sv-bankdata-page
	 * @return string - link to sv-bankdata-page
	 */
	function _insertSvBankdataAndGetLinkToBankdataPage($orderId) {
		$time = date('d.m.Y, G:i:s');
		//save sofortvorkasse-bankdata in customer history and show bankdata-page
		$bankdata = 
			MODULE_PAYMENT_SOFORT_SV_CHECKOUT_HOLDER_TEXT.' '.HelperFunctions::htmlMask($_GET['holder']).' -- '.
			MODULE_PAYMENT_SOFORT_SV_CHECKOUT_ACCOUNT_NUMBER_TEXT.' '.HelperFunctions::htmlMask($_GET['account_number']).' -- '.
			MODULE_PAYMENT_SOFORT_SV_CHECKOUT_IBAN_TEXT.' '.HelperFunctions::htmlMask($_GET['iban']).' -- '.
			MODULE_PAYMENT_SOFORT_SV_CHECKOUT_BANK_CODE_TEXT.' '.HelperFunctions::htmlMask($_GET['bank_code']).' -- '.
			MODULE_PAYMENT_SOFORT_SV_CHECKOUT_BIC_TEXT.' '.HelperFunctions::htmlMask($_GET['bic']).' -- '.
			MODULE_PAYMENT_SOFORT_SV_CHECKOUT_AMOUNT_TEXT.' '.HelperFunctions::htmlMask($_GET['amount']).' Euro -- '.
			MODULE_PAYMENT_SOFORT_SV_CHECKOUT_REASON_1_TEXT.' '.HelperFunctions::htmlMask($_GET['reason_1']).' -- '.
			MODULE_PAYMENT_SOFORT_SV_CHECKOUT_REASON_2_TEXT.' '.HelperFunctions::htmlMask($_GET['reason_2']).' -- '.
			MODULE_PAYMENT_SOFORT_TRANSLATE_TIME.': '.$time;
		
		$lastOrderStatus = HelperFunctions::getLastOrderStatus($orderId);
		//only for security - should normally not happen
		if (!$lastOrderStatus) {
			$lastOrderStatus = DEFAULT_ORDERS_STATUS_ID; 
		}
		
		HelperFunctions::insertHistoryEntry($orderId, $lastOrderStatus, $bankdata);
		
		//create link to bankdata-page and return this link
		$get = 'holder='.HelperFunctions::htmlMask($_GET['holder']).'&account_number='.HelperFunctions::htmlMask($_GET['account_number']).
			'&iban='.HelperFunctions::htmlMask($_GET['iban']).'&bank_code='.HelperFunctions::htmlMask($_GET['bank_code']).
			'&bic='.HelperFunctions::htmlMask($_GET['bic']).'&amount='.HelperFunctions::htmlMask($_GET['amount']).
			'&reason_1='.HelperFunctions::htmlMask($_GET['reason_1']).'&reason_2='.HelperFunctions::htmlMask($_GET['reason_2']);
		
		return xtc_href_link('callback/sofort/ressources/scripts/confirmVorkasse.php', $get, 'SSL', true, false);
	}
	
	
	/**
	 * set SV-Bankdata to the customer- and sellermail (sending is done by core later)
	 */
	function _setSvBankDataToEmail() {
		global $smarty;
		
		if (isset($_GET['holder']) && $_GET['amount']) {
			$sofortVorkasseMailhtml  = "<br/><table style='margin-left:-3px;font-size:x-small;font-family:Verdana, Arial, Helvetica, sans-serif'>";
			$sofortVorkasseMailhtml .= "<tr><td colspan='2'><b>".MODULE_PAYMENT_SOFORT_SV_CHECKOUT_HEADING_TEXT."</b></td></tr>";
			$sofortVorkasseMailhtml .= "<tr><td colspan='2'><br/>".MODULE_PAYMENT_SOFORT_SV_CHECKOUT_TEXT."</td></tr>";
			$sofortVorkasseMailhtml .= "<tr><td>".MODULE_PAYMENT_SOFORT_SV_CHECKOUT_HOLDER_TEXT."</td><td><b>".HelperFunctions::htmlMask($_GET['holder'])."</b></td></tr>";
			$sofortVorkasseMailhtml .= "<tr><td>".MODULE_PAYMENT_SOFORT_SV_CHECKOUT_ACCOUNT_NUMBER_TEXT."</td><td><b>".HelperFunctions::htmlMask($_GET['account_number'])."</b></td></tr>";
			$sofortVorkasseMailhtml .= "<tr><td>".MODULE_PAYMENT_SOFORT_SV_CHECKOUT_IBAN_TEXT."</td><td><b>".HelperFunctions::htmlMask($_GET['iban'])."</b></td></tr>";
			$sofortVorkasseMailhtml .= "<tr><td>".MODULE_PAYMENT_SOFORT_SV_CHECKOUT_BANK_CODE_TEXT."</td><td><b>".HelperFunctions::htmlMask($_GET['bank_code'])."</b></td></tr>";
			$sofortVorkasseMailhtml .= "<tr><td>".MODULE_PAYMENT_SOFORT_SV_CHECKOUT_BIC_TEXT."</td><td><b>".HelperFunctions::htmlMask($_GET['bic'])."</b></td></tr>";
			$sofortVorkasseMailhtml .= "<tr><td>".MODULE_PAYMENT_SOFORT_SV_CHECKOUT_AMOUNT_TEXT."</td><td><b>".number_format(HelperFunctions::htmlMask($_GET['amount']),2,',','.'). ' &euro;'."</b></td></tr>";
			$sofortVorkasseMailhtml .= "<tr><td>".MODULE_PAYMENT_SOFORT_SV_CHECKOUT_REASON_1_TEXT."</td><td><b>".HelperFunctions::htmlMask($_GET['reason_1'])."</b></td></tr>";
			$sofortVorkasseMailhtml .= "<tr><td>".MODULE_PAYMENT_SOFORT_SV_CHECKOUT_REASON_2_TEXT."</td><td><b>".HelperFunctions::htmlMask($_GET['reason_2'])."</b></td></tr>";
			$sofortVorkasseMailhtml .= "<tr><td colspan='2'><span style='color:red;'><br/><b>".MODULE_PAYMENT_SOFORT_SV_CHECKOUT_REASON_HINT."</b></span></td></tr></table>";
			
			$sofortVorkasseMailtext  = "\n".MODULE_PAYMENT_SOFORT_SV_CHECKOUT_HEADING_TEXT."\n\n";
			$sofortVorkasseMailtext .= MODULE_PAYMENT_SOFORT_SV_CHECKOUT_TEXT."\n\n";
			$sofortVorkasseMailtext .= MODULE_PAYMENT_SOFORT_SV_CHECKOUT_HOLDER_TEXT."\n"		 .HelperFunctions::htmlMask($_GET['holder'])."\n\n";
			$sofortVorkasseMailtext .= MODULE_PAYMENT_SOFORT_SV_CHECKOUT_ACCOUNT_NUMBER_TEXT."\n".HelperFunctions::htmlMask($_GET['account_number'])."\n\n";
			$sofortVorkasseMailtext .= MODULE_PAYMENT_SOFORT_SV_CHECKOUT_IBAN_TEXT."\n"			 .HelperFunctions::htmlMask($_GET['iban'])."\n\n";
			$sofortVorkasseMailtext .= MODULE_PAYMENT_SOFORT_SV_CHECKOUT_BANK_CODE_TEXT."\n"	 .HelperFunctions::htmlMask($_GET['bank_code'])."\n\n";
			$sofortVorkasseMailtext .= MODULE_PAYMENT_SOFORT_SV_CHECKOUT_BIC_TEXT."\n"			 .HelperFunctions::htmlMask($_GET['bic'])."\n\n";
			$sofortVorkasseMailtext .= MODULE_PAYMENT_SOFORT_SV_CHECKOUT_AMOUNT_TEXT."\n"		 .HelperFunctions::htmlMask($_GET['amount']). ' EUR'."\n\n";
			$sofortVorkasseMailtext .= MODULE_PAYMENT_SOFORT_SV_CHECKOUT_REASON_1_TEXT."\n"		 .HelperFunctions::htmlMask($_GET['reason_1']);
			$sofortVorkasseMailtext .= MODULE_PAYMENT_SOFORT_SV_CHECKOUT_REASON_2_TEXT."\n"		 .HelperFunctions::htmlMask($_GET['reason_2'])."\n\n";
			$sofortVorkasseMailtext .= MODULE_PAYMENT_SOFORT_SV_CHECKOUT_REASON_HINT."\n";
			
			$smarty->assign('PAYMENT_INFO_HTML', $sofortVorkasseMailhtml);
			$smarty->assign('PAYMENT_INFO_TXT', $sofortVorkasseMailtext);
		}
		
		return true;
	}
}
?>