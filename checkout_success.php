<?php
/* --------------------------------------------------------------
   checkout_success.php 2009-12-21 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2009 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(checkout_success.php,v 1.48 2003/02/17); www.oscommerce.com 
   (c) 2003	 nextcommerce (checkout_success.php,v 1.14 2003/08/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: checkout_success.php 896 2005-04-27 19:22:59Z mz $)

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contribution:

   Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
   http://www.oscommerce.com/community/contributions,282
   Copyright (c) Strider | Strider@oscworks.com
   Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
   Copyright (c) Andre ambidex@gmx.net
   Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org


   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');

$breadcrumb->add(NAVBAR_TITLE_1_CHECKOUT_SUCCESS);
$breadcrumb->add(NAVBAR_TITLE_2_CHECKOUT_SUCCESS);

// create smarty elements
$smarty = new Smarty;
// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');

// if the customer is not logged on, redirect them to the shopping cart page
if (!isset ($_SESSION['customer_id'])) {
	xtc_redirect(xtc_href_link(FILENAME_SHOPPING_CART));
}

if (isset ($_GET['action']) && ($_GET['action'] == 'update')) {

	if ($_SESSION['account_type'] != 1) {
		xtc_redirect(xtc_href_link(FILENAME_DEFAULT));
	} else {
		xtc_redirect(xtc_href_link(FILENAME_LOGOFF));
	}
}

require (DIR_WS_INCLUDES.'header.php');

$orders_query = xtc_db_query("select orders_id, orders_status, payment_method from ".TABLE_ORDERS." where customers_id = '".$_SESSION['customer_id']."' order by orders_id desc limit 1");
$orders = xtc_db_fetch_array($orders_query);
$last_order = $orders['orders_id'];
$order_status = $orders['orders_status'];

$coo_checkout_success_extender_component = MainFactory::create_object('CheckoutSuccessExtenderComponent');
$coo_checkout_success_extender_component->set_data('orders_id', $last_order);
$coo_checkout_success_extender_component->proceed();
$t_dispatcher_result_array = $coo_checkout_success_extender_component->get_response();

if(is_array($t_dispatcher_result_array))
{
	foreach($t_dispatcher_result_array AS $t_key => $t_value)
	{
		$smarty->assign($t_key, $t_value);
	}
}

// BOF GM_MOD HEIDELPAY E-MAIL
if(strpos($orders['payment_method'], 'hp') !== false){
	require_once(DIR_WS_CLASSES.'order.php');
	$order = new order($last_order);
	$insert_id = $last_order;
	if(empty($_SESSION['checkout_no_order_mail']) == true) include('send_order.php');
}
// EOF GM_MOD HEIDELPAY E-MAIL

$smarty->assign('FORM_ACTION', xtc_draw_form('order', xtc_href_link(FILENAME_CHECKOUT_SUCCESS, 'action=update', 'SSL')));
// BOF GM_MOD:
$smarty->assign('BUTTON_CONTINUE', xtc_image_submit('contgr.gif', IMAGE_BUTTON_CONTINUE));
$smarty->assign('BUTTON_PRINT', '<img src="'.'templates/'.CURRENT_TEMPLATE.'/buttons/'.$_SESSION['language'].'/button_print.gif" style="cursor:hand" onclick="window.open(\''.xtc_href_link(FILENAME_PRINT_ORDER, 'oID='.$orders['orders_id']).'\', \'popup\', \'toolbar=0, width=640, height=600\')" />');
$smarty->assign('BUTTON_PRINT_URL', xtc_href_link(FILENAME_PRINT_ORDER, 'oID='.$orders['orders_id']));
$smarty->assign('FORM_END', '</form>');
// GV Code Start
$gv_query = xtc_db_query("select amount from ".TABLE_COUPON_GV_CUSTOMER." where customer_id='".$_SESSION['customer_id']."'");
if ($gv_result = xtc_db_fetch_array($gv_query)) {
	if ($gv_result['amount'] > 0) {
		$smarty->assign('GV_SEND_LINK', xtc_href_link(FILENAME_GV_SEND, '', 'SSL'));
	}
}
// GV Code End

// BOF GM_MOD:

// BOF GM_MOD
if($_SESSION['nc_checkout_success_info']) {
	$smarty->assign('NC_SUCCESS_INFO', $_SESSION['nc_checkout_success_info']);
	unset ($_SESSION['nc_paypal_amount']);
	unset ($_SESSION['nc_checkout_success_info']);
}

$smarty->assign('LIGHTBOX', gm_get_conf('GM_LIGHTBOX_CHECKOUT'));
$smarty->assign('LIGHTBOX_CLOSE', xtc_href_link(FILENAME_DEFAULT, '', 'NONSSL'));
// EOF GM_MOD

if (DOWNLOAD_ENABLED == 'true')
	include (DIR_WS_MODULES.'downloads.php');
$smarty->assign('language', $_SESSION['language']);
$smarty->assign('PAYMENT_BLOCK', $payment_block);
$smarty->caching = 0;

$main_content = $smarty->fetch(CURRENT_TEMPLATE.'/module/checkout_success.html');

$smarty->assign('language', $_SESSION['language']);
$smarty->assign('main_content', $main_content.(isset($_SESSION['xtb2'])?"<div style=\"text-align:center;padding:3px;margin-top:10px;font-weight:bold;\"><a style=\"text-decoration:underline;color:blue;\" href=\"./xtbcallback.php?reverse=true\">Zur&uuml;ck zur xt:booster Auktions&uuml;bersicht..</a></div>":""));

$smarty->caching = 0;
if (!defined(RM))
	$smarty->load_filter('output', 'note');
$smarty->display(CURRENT_TEMPLATE.'/index.html');
include ('includes/application_bottom.php');
?>