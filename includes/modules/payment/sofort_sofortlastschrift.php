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
 * $Id: sofort_sofortlastschrift.php 5725 2012-11-21 11:09:39Z rotsch $
 */

require_once(DIR_FS_CATALOG.'callback/sofort/sofort.php');
require_once(DIR_FS_CATALOG.'callback/sofort/library/sofortLib.php');

class sofort_sofortlastschrift extends sofort{
	
	function sofort_sofortlastschrift() {
		global $order;
		
		parent::sofort();
		
		$this->_checkExistingSofortConstants('sl');
		
		$this->code = 'sofort_sofortlastschrift';
		$this->title = MODULE_PAYMENT_SOFORT_SOFORTLASTSCHRIFT_TEXT_TITLE;
		$this->title_extern = MODULE_PAYMENT_SOFORT_SL_TEXT_TITLE;
		$this->paymentMethod = 'SL';
		
		if (defined('MODULE_PAYMENT_SOFORT_SL_RECOMMENDED_PAYMENT') && MODULE_PAYMENT_SOFORT_SL_RECOMMENDED_PAYMENT == 'True') {
			$this->title_extern .= ' ' . MODULE_PAYMENT_SOFORT_SL_RECOMMENDED_PAYMENT_TEXT;
		}
		
		$this->enabled = ((defined('MODULE_PAYMENT_SOFORT_SL_STATUS') && MODULE_PAYMENT_SOFORT_SL_STATUS == 'True') ? true : false);
		
		$this->description = MODULE_PAYMENT_SOFORT_SL_TEXT_DESCRIPTION.'<br />'.MODULE_PAYMENT_SOFORT_MULTIPAY_VERSIONNUMBER.': '.HelperFunctions::getSofortmodulVersion();
		if ($this->_isInstalled() && (!defined('MODULE_PAYMENT_SOFORT_MULTIPAY_MODULE_VERSION') || 
				strcasecmp(trim(MODULE_PAYMENT_SOFORT_MULTIPAY_MODULE_VERSION), trim(HelperFunctions::getSofortmodulVersion())) != 0)) {
			$this->description = '<span style ="color:red; font-weight: bold; font-size: 1.2em">'.MODULE_PAYMENT_SOFORT_MULTIPAY_UPDATE_NOTICE.'</span><br /><br />'.$this->description;
		}
		$this->description .= MODULE_PAYMENT_SOFORT_SL_TEXT_DESCRIPTION_EXTRA;
		$this->sort_order = (defined('MODULE_PAYMENT_SOFORT_SL_SORT_ORDER') ? MODULE_PAYMENT_SOFORT_SL_SORT_ORDER : false);
		
		if (is_object($order)) {
			$this->update_status();
		}
		
		if (defined('MODULE_PAYMENT_SOFORT_SL_STATUS')) {
			$this->sofort = new SofortLib_Multipay(MODULE_PAYMENT_SOFORT_MULTIPAY_APIKEY);
			$this->sofort->setVersion(HelperFunctions::getSofortmodulVersion());
			if (defined('MODULE_PAYMENT_SOFORT_MULTIPAY_LOG_ENABLED') && MODULE_PAYMENT_SOFORT_MULTIPAY_LOG_ENABLED == "True") {
				$this->sofort->setLogEnabled();
			}
		}
	}
	
	
	function selection() {
		
		if (!parent::selection()) {
			$this->sofort->log("Notice: Paymentmethod ".$this->code." will be deactivated for selection.");
			$this->enabled = false;
			return false;
		}
		
		$title = '';
		
		switch (MODULE_PAYMENT_SOFORT_MULTIPAY_IMAGE) {
			case 'Logo & Text':
				$title = $this->_setImageText('logo_155x50.png', MODULE_PAYMENT_SOFORT_SL_CHECKOUT_TEXT);
				break;
			case 'Infographic':
				$title = $this->_setImageText('banner_300x100.png', '');
				break;
		}
		
		$cost = '';
		
		if(array_key_exists('ot_sofort',  $GLOBALS)) {
			$cost = $GLOBALS['ot_sofort']->get_percent($this->code, 'price');
		}
		
		//commerce:SEO - Bugfix
		if (isset($_REQUEST['xajax']) && !empty($_REQUEST['xajax'])) {
			return array('id' => $this->code , 'module' => utf8_decode($this->title_extern), 'description' => utf8_decode($title), 'module_cost' => utf8_decode($cost));
		}else{
			return array('id' => $this->code , 'module' => $this->title_extern , 'description' => $title, 'module_cost' => $cost);
		}
	}
	
	
	function _setImageText($image, $text) {
		$lng = HelperFunctions::getShortCode($_SESSION['language']);
		$image = 'https://images.sofort.com/'.$lng.'/sl/'.$image;
		
		$image = xtc_image($image, MODULE_PAYMENT_SOFORT_SL_TEXT_DESCRIPTION_CHECKOUT_PAYMENT_IMAGEALT);
		$title = MODULE_PAYMENT_SOFORT_SL_TEXT_DESCRIPTION_CHECKOUT_PAYMENT_IMAGE;
		$title = str_replace('{{image}}', $image, $title);
		$title = str_replace('{{text}}', $text, $title);
		return $title;
	}
	
	
	function install() {
		$sofortStatuses = $this->_insertAndReturnSofortStatus();
		$refundedStatus = 		(isset($sofortStatuses['refunded'])			&& !empty($sofortStatuses['refunded']))			? $sofortStatuses['refunded'] : '';
		$directDebitStatus = 	(isset($sofortStatuses['direct_debit'])		&& !empty($sofortStatuses['direct_debit']))		? $sofortStatuses['direct_debit'] : '';
		$returnedDebitStatus = 	(isset($sofortStatuses['returned_debit'])	&& !empty($sofortStatuses['returned_debit']))	? $sofortStatuses['returned_debit'] : '';
		$unchangedStatus = 		(isset($sofortStatuses['unchanged'])		&& !empty($sofortStatuses['unchanged']))		? $sofortStatuses['unchanged'] : '';
		
		xtc_db_query("INSERT INTO ".HelperFunctions::escapeSql(TABLE_CONFIGURATION)." ( configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_PAYMENT_SOFORT_SL_STATUS', 'False', '6', '1', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");
		xtc_db_query("INSERT INTO ".HelperFunctions::escapeSql(TABLE_CONFIGURATION)." ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) VALUES ('MODULE_PAYMENT_SOFORT_SL_SORT_ORDER', '0', '6', '16', now())");
		xtc_db_query("INSERT INTO ".HelperFunctions::escapeSql(TABLE_CONFIGURATION)." ( configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_PAYMENT_SOFORT_SL_RECOMMENDED_PAYMENT', 'False', '6', '5', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");
		xtc_db_query("INSERT INTO ".HelperFunctions::escapeSql(TABLE_CONFIGURATION)." ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) VALUES ('MODULE_PAYMENT_SOFORT_SOFORTLASTSCHRIFT_ALLOWED', '', '6', '12', now())");
		xtc_db_query("INSERT INTO ".HelperFunctions::escapeSql(TABLE_CONFIGURATION)." ( configuration_key, configuration_value,  configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('MODULE_PAYMENT_SOFORT_SL_ZONE', '0', '6', '13', 'xtc_get_zone_class_title', 'xtc_cfg_pull_down_zone_classes(', now())");
		
		//"Best�tigt - Bisher kein Geldeingang" - pending-not_credited_yet
		xtc_db_query("INSERT INTO ".HelperFunctions::escapeSql(TABLE_CONFIGURATION)." ( configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, use_function, date_added) VALUES ('MODULE_PAYMENT_SOFORT_SL_PEN_NOT_CRE_YET_STATUS_ID', '".HelperFunctions::escapeSql($directDebitStatus)."',  '6', '35', 'xtc_cfg_pull_down_order_statuses(', 'xtc_get_order_status_name', now())");
		
		//"R�cklastschrift" - loss-rejected
		xtc_db_query("INSERT INTO ".HelperFunctions::escapeSql(TABLE_CONFIGURATION)." ( configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, use_function, date_added) VALUES ('MODULE_PAYMENT_SOFORT_SL_LOS_REJ_STATUS_ID', '".HelperFunctions::escapeSql($returnedDebitStatus)."',  '6', '35', 'xtc_cfg_pull_down_order_statuses(', 'xtc_get_order_status_name', now())");
		
		//"Geldeingang" - received-credited
		xtc_db_query("INSERT INTO ".HelperFunctions::escapeSql(TABLE_CONFIGURATION)." ( configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, use_function, date_added) VALUES ('MODULE_PAYMENT_SOFORT_SL_REC_CRE_STATUS_ID', '".HelperFunctions::escapeSql($unchangedStatus)."',  '6', '35', 'xtc_cfg_pull_down_order_statuses(', 'xtc_get_order_status_name', now())");
		
		//"Teilr�ckbuchung" - refunded-compensation
		xtc_db_query("INSERT INTO ".HelperFunctions::escapeSql(TABLE_CONFIGURATION)." ( configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, use_function, date_added) VALUES ('MODULE_PAYMENT_SOFORT_SL_REF_COM_STATUS_ID', '".HelperFunctions::escapeSql($unchangedStatus)."',  '6', '35', 'xtc_cfg_pull_down_order_statuses(', 'xtc_get_order_status_name', now())");
		
		//"Vollst�ndige R�ckbuchung" - refunded-refunded
		xtc_db_query("INSERT INTO ".HelperFunctions::escapeSql(TABLE_CONFIGURATION)." ( configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, use_function, date_added) VALUES ('MODULE_PAYMENT_SOFORT_SL_REF_REF_STATUS_ID', '".HelperFunctions::escapeSql($refundedStatus)."',  '6', '35', 'xtc_cfg_pull_down_order_statuses(', 'xtc_get_order_status_name', now())");
		
		//install shared keys, that are used by all/most multipay-modules
		parent::install();
	}
	
	
	function remove() {
		xtc_db_query("DELETE FROM " . HelperFunctions::escapeSql(TABLE_CONFIGURATION) . " WHERE configuration_key LIKE 'MODULE_PAYMENT_SOFORT_SL%'");
		xtc_db_query("DELETE FROM " . HelperFunctions::escapeSql(TABLE_CONFIGURATION) . " WHERE configuration_key LIKE 'MODULE_PAYMENT_SOFORT_SOFORTLASTSCHRIFT%'");
		
		//if this is the last removing of a multipay-paymentmethod --> we also remove all shared keys, that are used by all/most multipay-modules
		parent::remove();
	}
	
	
	function keys() {
		
		parent::keys();
		
		return array(
			'MODULE_PAYMENT_SOFORT_SL_STATUS',
			'MODULE_PAYMENT_SOFORT_MULTIPAY_APIKEY',
			'MODULE_PAYMENT_SOFORT_MULTIPAY_AUTH',
			'MODULE_PAYMENT_SOFORT_SL_RECOMMENDED_PAYMENT',
			'MODULE_PAYMENT_SOFORT_MULTIPAY_IMAGE',
			'MODULE_PAYMENT_SOFORT_MULTIPAY_REASON_1',
			'MODULE_PAYMENT_SOFORT_MULTIPAY_TEXT_REASON_2',
			'MODULE_PAYMENT_SOFORT_SOFORTLASTSCHRIFT_ALLOWED' ,
			'MODULE_PAYMENT_SOFORT_SL_ZONE' ,
			'MODULE_PAYMENT_SOFORT_SL_SORT_ORDER',
			'MODULE_PAYMENT_SOFORT_MULTIPAY_PROF_SETTINGS',
			'MODULE_PAYMENT_SOFORT_MULTIPAY_TEMP_STATUS_ID',
			'MODULE_PAYMENT_SOFORT_MULTIPAY_ABORTED_STATUS_ID',
			'MODULE_PAYMENT_SOFORT_SL_PEN_NOT_CRE_YET_STATUS_ID',
			'MODULE_PAYMENT_SOFORT_SL_LOS_REJ_STATUS_ID',
			'MODULE_PAYMENT_SOFORT_SL_REC_CRE_STATUS_ID',
			'MODULE_PAYMENT_SOFORT_SL_REF_COM_STATUS_ID',
			'MODULE_PAYMENT_SOFORT_SL_REF_REF_STATUS_ID',
			//'MODULE_PAYMENT_SOFORT_MULTIPAY_LOG_ENABLED',
		);
	}
}
?>