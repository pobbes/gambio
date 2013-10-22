<?php
/* --------------------------------------------------------------
   send_order.php 2012-12-10 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2003	 nextcommerce (send_order.php,v 1.1 2003/08/24); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: send_order.php 1029 2005-07-14 19:08:49Z mz $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

#prevent direct execution
if(defined('DIR_FS_CATALOG') == false) die();

require_once (DIR_FS_INC.'xtc_get_order_data.inc.php');
require_once (DIR_FS_INC.'xtc_get_attributes_model.inc.php');

// bof gm
include(DIR_FS_CATALOG . 'gm/inc/gm_save_order.inc.php');
// eof gm

// check if customer is allowed to send this order!
$order_query_check = xtc_db_query("SELECT
  					customers_id
  					FROM ".TABLE_ORDERS."
  					WHERE orders_id='".$insert_id."'");

$order_check = xtc_db_fetch_array($order_query_check);
if ($_SESSION['customer_id'] == $order_check['customers_id']) {

	$order = new order($insert_id);

	if ($_SESSION['paypal_express_new_customer'] == 'true' && $_SESSION['ACCOUNT_PASSWORD']== 'true') {

		require_once (DIR_FS_INC.'xtc_create_password.inc.php');
		require_once (DIR_FS_INC.'xtc_encrypt_password.inc.php');

		$password_encrypted =  xtc_RandomString(10);
		$password = xtc_encrypt_password($password_encrypted);

		xtc_db_query("update " . TABLE_CUSTOMERS . " set customers_password = '" . $password . "' where customers_id = '" . (int) $_SESSION['customer_id'] . "'");

		$smarty->assign('NEW_PASSWORD', $password_encrypted);
	}

	$smarty->assign('address_label_customer', xtc_address_format($order->customer['format_id'], $order->customer, 1, '', '<br />'));
	$smarty->assign('address_label_shipping', xtc_address_format($order->delivery['format_id'], $order->delivery, 1, '', '<br />'));
	if ($_SESSION['credit_covers'] != '1') {
		$smarty->assign('address_label_payment', xtc_address_format($order->billing['format_id'], $order->billing, 1, '', '<br />'));
	}
	$smarty->assign('csID', $order->customer['csID']);
	// BOF GM_MOD:
	$smarty->assign('customer_vat', $order->customer['vat_id']);

	$order_total = $order->getTotalData($insert_id);
		$smarty->assign('order_data', $order->getOrderData($insert_id));
		$smarty->assign('order_total', $order_total['data']);

	// assign language to template for caching
	$smarty->assign('language', $_SESSION['language']);
	$smarty->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
	$smarty->assign('logo_path', HTTP_SERVER.DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');
	$smarty->assign('oID', $insert_id);
	if ($order->info['payment_method'] != '' && $order->info['payment_method'] != 'no_payment') {
		include (DIR_WS_LANGUAGES.$_SESSION['language'].'/modules/payment/'.$order->info['payment_method'].'.php');
		$payment_method = constant(strtoupper('MODULE_PAYMENT_'.$order->info['payment_method'].'_TEXT_TITLE'));
		$smarty->assign('PAYMENT_MODUL', $order->info['payment_method']);
	}
	$smarty->assign('PAYMENT_METHOD', $payment_method);
	$smarty->assign('DATE', xtc_date_long($order->info['date_purchased']));

	$smarty->assign('NAME', $order->customer['name']);
	$smarty->assign('COMMENTS', $order->info['comments']);
	$smarty->assign('EMAIL', $order->customer['email_address']);
	$smarty->assign('PHONE',$order->customer['telephone']);

	if(defined('EMAIL_SIGNATURE')) {
		$smarty->assign('EMAIL_SIGNATURE_HTML', nl2br(EMAIL_SIGNATURE));
		$smarty->assign('EMAIL_SIGNATURE_TEXT', EMAIL_SIGNATURE);
	}


	if (gm_get_conf('GM_SHOW_WITHDRAWAL') == 1) {
		if (GROUP_CHECK == 'true') {
			$group_check = "and group_ids LIKE '%c_" . $_SESSION['customers_status']['customers_status_id'] . "_group%'";
		}
		$shop_content_query = xtc_db_query("SELECT
														content_title,
														content_heading,
														content_text,
														content_file
														FROM " . TABLE_CONTENT_MANAGER . "
														WHERE content_group='" . (int)gm_get_conf('GM_WITHDRAWAL_CONTENT_ID') . "' " . $group_check . "
														AND languages_id='" . $_SESSION['languages_id'] . "'");
		$shop_content_data = xtc_db_fetch_array($shop_content_query);
		$t_withdrawal = trim(strip_tags($shop_content_data['content_text']));

		$smarty->assign('WITHDRAWAL_HTML', nl2br($t_withdrawal));
		$smarty->assign('WITHDRAWAL_TEXT', $t_withdrawal);
	}

	if (gm_get_conf('GM_SHOW_CONDITIONS') == 1) {
		if (GROUP_CHECK == 'true') {
			$group_check = "and group_ids LIKE '%c_" . $_SESSION['customers_status']['customers_status_id'] . "_group%'";
		}
		$shop_content_query = xtc_db_query("SELECT
														content_title,
														content_heading,
														content_text,
														content_file
														FROM " . TABLE_CONTENT_MANAGER . "
														WHERE content_group='3' " . $group_check . "
														AND languages_id='" . $_SESSION['languages_id'] . "'");
		$shop_content_data = xtc_db_fetch_array($shop_content_query);
		$t_agb = trim(strip_tags($shop_content_data['content_text']));

		$smarty->assign('AGB_HTML', nl2br($t_agb));
		$smarty->assign('AGB_TEXT', $t_agb);
	}





	/* BOF TRUSTED SHOPS RATING */
	$obj_widget = MainFactory::create_object('GMTSWidget', array($_SESSION['languages_id']));
	$smarty->assign('TS_RATING',  $obj_widget->get_rating_link($insert_id, 'GM_TRUSTED_SHOPS_WIDGET_SHOW_CONFIRMATION'));
	unset($obj_widget);
	/* EOF TRUSTED SHOPS RATING */

	// PAYMENT MODUL TEXTS
	// EU Bank Transfer
	if ($order->info['payment_method'] == 'eustandardtransfer') {
		$smarty->assign('PAYMENT_INFO_HTML', MODULE_PAYMENT_EUTRANSFER_TEXT_DESCRIPTION);
		$smarty->assign('PAYMENT_INFO_TXT', str_replace("<br />", "\n", MODULE_PAYMENT_EUTRANSFER_TEXT_DESCRIPTION));
	}

	// MONEYORDER
	if ($order->info['payment_method'] == 'moneyorder') {
		$smarty->assign('PAYMENT_INFO_HTML', MODULE_PAYMENT_MONEYORDER_TEXT_DESCRIPTION);
		$smarty->assign('PAYMENT_INFO_TXT', str_replace("<br />", "\n", MODULE_PAYMENT_MONEYORDER_TEXT_DESCRIPTION));
	}

        // HEIDELPAY: heidelpaypp (Vorkasse)
        if ($order->info['payment_method'] == 'heidelpaypp') {
            $smarty->assign('PAYMENT_INFO_HTML', $_SESSION['heidelpaypp_data']['emailfooter_html']);
            $smarty->assign('PAYMENT_INFO_TXT', $_SESSION['heidelpaypp_data']['emailfooter']);
        }
        
	// bof gm
	$gm_logo_mail = MainFactory::create_object('GMLogoManager', array("gm_logo_mail"));
	if($gm_logo_mail->logo_use == '1') {
		$smarty->assign('gm_logo_mail', $gm_logo_mail->get_logo());
	}
	// eof gm

	// dont allow cache
	$smarty->caching = false;
	
	# JANOLAW START
	require_once(DIR_FS_CATALOG.'gm/classes/GMJanolaw.php');
	$coo_janolaw = new GMJanolaw();
	if($coo_janolaw->get_status() == true)
	{
		$t_info_html  = $coo_janolaw->get_page_content('widerrufsbelehrung', true, true);
		$t_info_html .= '<br/><br/>AGB<br/><br/>';
		$t_info_html .= $coo_janolaw->get_page_content('agb', true, true);
		$smarty->assign('JANOLAW_INFO_HTML', $t_info_html);

		$t_info_text  = $coo_janolaw->get_page_content('widerrufsbelehrung', false, false);
		$t_info_text .= "\n\nAGB\n\n";
		$t_info_text .= $coo_janolaw->get_page_content('agb', false, false);
		$smarty->assign('JANOLAW_INFO_TEXT', $t_info_text);
	}
	# JANOLAW END
	
	$html_mail = $smarty->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/order_mail.html');
	$txt_mail = $smarty->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/order_mail.txt');

	// create subject
	$t_subject = gm_get_content('EMAIL_BILLING_SUBJECT_ORDER', $_SESSION['languages_id']);
	if(empty($t_subject)) $t_subject = EMAIL_BILLING_SUBJECT_ORDER;
	$order_subject = str_replace('{$nr}', $insert_id, $t_subject);
	$order_subject = str_replace('{$date}', strftime(DATE_FORMAT_LONG), $order_subject);
	$order_subject = str_replace('{$lastname}', $order->customer['lastname'], $order_subject);
	$order_subject = str_replace('{$firstname}', $order->customer['firstname'], $order_subject);

	// send mail to admin
	// BOF GM_MOD:
	if(SEND_EMAILS == 'true') {
		// get the sender mail adress. e.g. Host Europe has problems with the customer mail adress.
		$from_email_address = $order->customer['email_address'];
		if(SEND_EMAIL_BY_BILLING_ADRESS == 'SHOP_OWNER') {
			$from_email_address = EMAIL_BILLING_ADDRESS;
		}
		xtc_php_mail($from_email_address, $order->customer['firstname'].' '.$order->customer['lastname'], EMAIL_BILLING_ADDRESS, STORE_NAME, EMAIL_BILLING_FORWARDING_STRING, $order->customer['email_address'], $order->customer['firstname'].' '.$order->customer['lastname'], '', '', $order_subject, $html_mail, $txt_mail);
	}

	// send mail to customer
	// BOF GM_MOD:
	if(SEND_EMAILS == 'true') $gm_mail_status = xtc_php_mail(EMAIL_BILLING_ADDRESS, EMAIL_BILLING_NAME, $order->customer['email_address'], $order->customer['firstname'].' '.$order->customer['lastname'], '', EMAIL_BILLING_REPLY_ADDRESS, EMAIL_BILLING_REPLY_ADDRESS_NAME, '', '', $order_subject, $html_mail, $txt_mail);


	if($gm_mail_status == false) {
		$gm_send_order_status = 0;
	} else {
		$gm_send_order_status = 1;
	}

	gm_save_order($insert_id, $html_mail, $txt_mail, $gm_send_order_status);
	// eof gm

	if (AFTERBUY_ACTIVATED == 'true') {
		require_once (DIR_WS_CLASSES.'afterbuy.php');
		$aBUY = new xtc_afterbuy_functions($insert_id);
		if ($aBUY->order_send())
			$aBUY->process_order();
	}

} else {
	$smarty->assign('ERROR', 'You are not allowed to view this order!');
	$smarty->display(CURRENT_TEMPLATE.'/module/error_message.html');
}
?>