<?php
/* --------------------------------------------------------------
 checkout_confirmation.php 2010-06-10 gm
 Gambio GmbH
 http://www.gambio.de
 Copyright (c) 2010 Gambio GmbH
 Released under the GNU General Public License
 --------------------------------------------------------------
 */
?><?php

/* -----------------------------------------------------------------------------------------
 $Id: checkout_confirmation.php 1277 2005-10-01 17:02:59Z mz $

 XT-Commerce - community made shopping
 http://www.xt-commerce.com

 Copyright (c) 2003 XT-Commerce
 -----------------------------------------------------------------------------------------
 based on:
 (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
 (c) 2002-2003 osCommerce(checkout_confirmation.php,v 1.137 2003/05/07); www.oscommerce.com
 (c) 2003	 nextcommerce (checkout_confirmation.php,v 1.21 2003/08/17); www.nextcommerce.org

 Released under the GNU General Public License
 -----------------------------------------------------------------------------------------
 Third Party contributions:
 agree_conditions_1.01        	Autor:	Thomas Ploenkers (webmaster@oscommerce.at)

 Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

 Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
 http://www.oscommerce.com/community/contributions,282
 Copyright (c) Strider | Strider@oscworks.com
 Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
 Copyright (c) Andre ambidex@gmx.net
 Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org

 Released under the GNU General Public License
 ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');

$breadcrumb->add(NAVBAR_TITLE_1_CHECKOUT_CONFIRMATION, xtc_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_2_CHECKOUT_CONFIRMATION);

// create smarty elements
$smarty = new Smarty;
// include boxes
require (DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/source/boxes.php');
// include needed functions
require_once (DIR_FS_INC . 'xtc_calculate_tax.inc.php');
require_once (DIR_FS_INC . 'xtc_check_stock.inc.php');
require_once (DIR_FS_INC . 'xtc_display_tax_value.inc.php');

// if the customer is not logged on, redirect them to the login page
if (!isset ($_SESSION['customer_id']))
xtc_redirect(xtc_href_link(FILENAME_LOGIN, '', 'SSL'));

if(isset($_GET['ic_cancel']) && (int) $_GET['ic_cancel'] == 1) {
	?>
<script type="text/javascript" language="javascript">
	<!--
		parent.location.href = '<?php print xtc_href_link(FILENAME_CHECKOUT_PAYMENT,  '', 'SSL'); ?>';
	//-->
	</script>
	<?php
	exit();
}

if((isset($_SESSION['ic_processed']) && $_SESSION['ic_processed'] == true) || $_GET['ic_processed'] == 1) {
	unset($_SESSION['ic_processed']);
	unset($_SESSION['icSessionID']);
	unset($_SESSION['icBasketID']);

	?>
<script type="text/javascript" language="javascript">
	<!--
		parent.location.href = '<?php print xtc_href_link(FILENAME_CHECKOUT_SUCCESS,  '', 'SSL'); ?>';
	//-->
	</script>
	<?php
	$_SESSION['cart']->reset(true);
	exit();
}

// if there is nothing in the customers cart, redirect them to the shopping cart page
if ($_SESSION['cart']->count_contents() <= 0)
xtc_redirect(xtc_href_link(FILENAME_SHOPPING_CART));

// avoid hack attempts during the checkout procedure by checking the internal cartID
if (isset ($_SESSION['cart']->cartID) && isset ($_SESSION['cartID'])) {
	if ($_SESSION['cart']->cartID != $_SESSION['cartID'])
	xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
}

// if no shipping method has been selected, redirect the customer to the shipping method selection page
if (!isset ($_SESSION['shipping']))
xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));

//GM_MOD moneybookers:
if (isset($_SESSION['tmp_oID'])) unset($_SESSION['tmp_oID']);

//check if display conditions on checkout page is true

if (isset ($_POST['payment']))
$_SESSION['payment'] = xtc_db_prepare_input($_POST['payment']);

if ($_POST['comments_added'] != '')
$_SESSION['comments'] = xtc_db_prepare_input($_POST['comments']);

//-- TheMedia Begin check if display conditions on checkout page is true
if (isset ($_POST['cot_gv']))
$_SESSION['cot_gv'] = true;
// if conditions are not accepted, redirect the customer to the payment method selection page

// BOF GM_MOD:
if (gm_get_conf('GM_CHECK_CONDITIONS') == 1) {
	if ($_REQUEST['conditions'] == false) $error .= str_replace('\n', '<br />', ERROR_CONDITIONS_NOT_ACCEPTED_AGB);
}
if (gm_get_conf('GM_CHECK_WITHDRAWAL') == 1) {
	if ($_POST['withdrawal'] == false) $error .= str_replace('\n', '<br />', ERROR_CONDITIONS_NOT_ACCEPTED_WITHDRAWAL);
}

/*if(!isset($_SESSION['conditions']) || !isset($_SESSION['withdrawal']))
{
	if((($_POST['conditions'] == false && gm_get_conf('GM_CHECK_CONDITIONS') == 1) || ($_POST['withdrawal'] == false && gm_get_conf('GM_CHECK_WITHDRAWAL') == 1)) && $_POST['iclearRedirect'] != 1 ){
		//xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message=' . urlencode($error), 'SSL', true, false));
		$_SESSION['gm_error_message'] = urlencode($error);
		xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL', true, false));
	}
	else
	{
		if($_POST['conditions'] == true) $_SESSION['conditions']='true';
		if($_POST['withdrawal'] == true) $_SESSION['withdrawal']='true';
	}
}*/

if(isset($_GET['payment_error'])) $smarty->assign('ERROR', htmlentities_wrapper($_GET['ret_errormsg']));

// load the selected payment module
require (DIR_WS_CLASSES . 'payment.php');
if (isset ($_SESSION['credit_covers']))
$_SESSION['payment'] = 'no_payment'; // GV Code Start/End ICW added for CREDIT CLASS
$payment_modules = new payment($_SESSION['payment']);

// GV Code ICW ADDED FOR CREDIT CLASS SYSTEM
require (DIR_WS_CLASSES . 'order_total.php');
require (DIR_WS_CLASSES . 'order.php');
$order = new order();

$payment_modules->update_status();

// GV Code Start
$order_total_modules = new order_total();
$order_total_modules->collect_posts();
$order_total_modules->pre_confirmation_check();
// GV Code End

// GV Code line changed
// BOF GM_MOD:
if ((is_array($payment_modules->modules) && (sizeof($payment_modules->modules) > 1) && (!is_object($$_SESSION['payment'])) && (!isset ($_SESSION['credit_covers']))) || (is_object($$_SESSION['payment']) && ($$_SESSION['payment']->enabled == false))) {
	xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message=' . urlencode(ERROR_NO_PAYMENT_MODULE_SELECTED), 'SSL'));
	$_SESSION['gm_error_message'] = urlencode(ERROR_NO_PAYMENT_MODULE_SELECTED);
	xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
}

if (is_array($payment_modules->modules))
if(is_array($payment_modules->modules) && strpos($_SESSION['payment'], 'saferpaygw') === false)
{
	$payment_modules->pre_confirmation_check();
}
// EOF GM_MOD saferpay

// load the selected shipping module
require (DIR_WS_CLASSES . 'shipping.php');
$shipping_modules = new shipping($_SESSION['shipping']);

// Stock Check
$any_out_of_stock = false;
if (STOCK_CHECK == 'true') {
	for ($i = 0, $n = sizeof($order->products); $i < $n; $i++) {
		if (xtc_check_stock($order->products[$i]['id'], $order->products[$i]['qty']))
		$any_out_of_stock = true;
	}
	// Out of Stock
	if ((STOCK_ALLOW_CHECKOUT != 'true') && ($any_out_of_stock == true))
	xtc_redirect(xtc_href_link(FILENAME_SHOPPING_CART));
}

$breadcrumb->add(NAVBAR_TITLE_1_CHECKOUT_CONFIRMATION, xtc_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_2_CHECKOUT_CONFIRMATION);

require (DIR_WS_INCLUDES . 'header.php');

if (isset ($$_SESSION['payment']->form_action_url) && !$$_SESSION['payment']->tmpOrders) {

	$form_action_url = $$_SESSION['payment']->form_action_url;

} else {
	$form_action_url = xtc_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL');
}

$payment_modules->before_process();

$smarty->assign('IC_PAYMENT_URL', $icCore->getBasket()->iclearURL());

$smarty->assign('language', $_SESSION['language']);
$smarty->assign('PAYMENT_BLOCK', $payment_block);
$smarty->caching = 0;
$main_content = $smarty->fetch(CURRENT_TEMPLATE . '/module/checkout_iclear.html');

$smarty->assign('language', $_SESSION['language']);
$smarty->assign('main_content', $main_content);
$smarty->caching = 0;
if (!defined(RM))
$smarty->load_filter('output', 'note');
$smarty->display(CURRENT_TEMPLATE . '/index.html');
?>
<script type="text/javascript" language="javascript">
<!--
	var element = document.getElementById("pre_black_container");
	if(element != undefined){
		element.innerHTML = '';
	
		window.setTimeout('$.dimScreenStop()',100);
	}
//-->
</script>
<?php
include ('includes/application_bottom.php');
?>