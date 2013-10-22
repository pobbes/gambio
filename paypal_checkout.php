<?php
/* --------------------------------------------------------------
   paypal_checkout.php 2012-07-09 gm
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
 * xt:Commerce ist eine gesch?tzte Handelsmarke und wird vertreten durch die xt:Commerce GmbH (Austria)
 * xt:Commerce is a protected trademark and represented by the xt:Commerce GmbH (Austria)
 *
 * @copyright Copyright 2003-2007 xt:Commerce (Winger/Zanier), www.xt-commerce.com
 * @copyright based on Copyright 2000-2001 The Exchange Project  (earlier name of osCommerce)
 * @copyright based on Copyright 2002-2003 osCommerce; www.oscommerce.com
 * @copyright based on Copyright 2003 nextcommerce; www.nextcommerce.org
 * @license http://www.xt-commerce.com.com/license/2_0.txt GNU Public License V2.0
 *
 * For questions, help, comments, discussion, etc., please join the
 * xt:Commerce Support Forums at www.xt-commerce.com
 *
 */
// Allgemein START
//------------------------------------------------------------------------
include ('includes/application_top.php');

# janolaw BOF
require_once(DIR_FS_CATALOG.'gm/classes/GMJanolaw.php');
$coo_janolaw = new GMJanolaw();
# janolaw EOF

$breadcrumb->add(NAVBAR_TITLE_PAYPAL_CHECKOUT, xtc_href_link(FILENAME_PAYPAL_CHECKOUT, '', 'SSL'));

// create smarty elements
$smarty = new Smarty;
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');
// include needed functions
require_once (DIR_FS_INC.'xtc_address_label.inc.php');
require_once (DIR_FS_INC.'xtc_get_address_format_id.inc.php');
require_once (DIR_FS_INC.'xtc_count_shipping_modules.inc.php');
require_once (DIR_FS_INC . 'xtc_check_stock.inc.php');
require_once (DIR_FS_INC . 'xtc_calculate_tax.inc.php');
require_once (DIR_FS_INC . 'xtc_check_stock.inc.php');
require_once (DIR_FS_INC . 'xtc_display_tax_value.inc.php');
require_once(DIR_FS_INC . 'get_products_vpe_array.inc.php');

require (DIR_WS_CLASSES.'http_client.php');
unset ($_SESSION['tmp_oID']);

switch ($_GET['error_message']) {
	case "1":
		$message = str_replace('\n', '', ERROR_CONDITIONS_NOT_ACCEPTED);
		$messageStack->add('checkout_payment', $message);
		break;
}

// Get Customer Data and Check for existing Account.
$o_paypal->paypal_get_customer_data();


if (!isset ($_SESSION['customer_id'])) {
	if (ACCOUNT_OPTIONS == 'guest') {
		xtc_redirect(xtc_href_link(FILENAME_CREATE_GUEST_ACCOUNT, '', 'SSL'));
	} else {
		xtc_redirect(xtc_href_link(FILENAME_LOGIN, '', 'SSL'));
	}
}

//// zahlungsweise in session schreiben
$_SESSION['payment'] = 'paypalexpress';

if(isset($_POST['act_shipping'])){
$_SESSION['act_shipping'] = 'true';
}

if(isset($_POST['act_payment'])){
$_SESSION['act_payment'] = 'true';
}

if (isset ($_POST['payment']))
	$_SESSION['payment'] = xtc_db_prepare_input($_POST['payment']);

if ($_POST['comments_added'] != '')
	$_SESSION['comments'] = gm_prepare_string($_POST['comments'], true);

//-- TheMedia Begin check if display conditions on checkout page is true
if (isset ($_POST['cot_gv']))
	$_SESSION['cot_gv'] = true;

// if there is nothing in the customers cart, redirect them to the shopping cart page
if ($_SESSION['cart']->count_contents() < 1)
	xtc_redirect(xtc_href_link(FILENAME_SHOPPING_CART));

if (isset ($_SESSION['credit_covers']))
	unset ($_SESSION['credit_covers']); //ICW ADDED FOR CREDIT CLASS SYSTEM

// Stock Check
if ((STOCK_CHECK == 'true') && (STOCK_ALLOW_CHECKOUT != 'true')) {
	$products = $_SESSION['cart']->get_products();
	$any_out_of_stock = 0;
	for ($i = 0, $n = sizeof($products); $i < $n; $i++) {
		if (xtc_check_stock($products[$i]['id'], $products[$i]['quantity']))
			$any_out_of_stock = 1;
	}
	if ($any_out_of_stock == 1)
		xtc_redirect(xtc_href_link(FILENAME_SHOPPING_CART));

	// BOF GM_MOD
	$gm_attributes_array = array_keys($_SESSION['cart']->contents);
	for($i = 0; $i < count($gm_attributes_array); $i++){
		if(strstr($gm_attributes_array[$i], '{') != false){
			if(ATTRIBUTE_STOCK_CHECK == 'true'){
				$gm_attribute_array = explode('{', str_replace('}', '{', $gm_attributes_array[$i]));
				$gm_attributes = $_SESSION['cart']->contents[$gm_attributes_array[$i]]['attributes'];
				for($j = 0; $j < count($gm_attributes); $j++){
					$gm_attribute_stock = xtc_db_query("SELECT products_attributes_id
																					FROM products_attributes
																					WHERE products_id = '" . $gm_attribute_array[0] . "'
																						AND options_id = '" . key($gm_attributes) . "'
																						AND options_values_id = '" . current($gm_attributes) . "'
																						AND (attributes_stock - " . $_SESSION['cart']->contents[$gm_attributes_array[$i]]['qty'] . ") < 0");
					if(mysql_num_rows($gm_attribute_stock) == 1) $gm_stock_error = true;
					next($gm_attributes);
				}
			}
		}
		elseif(xtc_get_products_stock($gm_attributes_array[$i]) - (double)$_SESSION['cart']->contents[$gm_attributes_array[$i]]['qty'] < 0)
		{
			$gm_stock_error = true;
		}
	}

	if ($gm_stock_error == true) xtc_redirect(xtc_href_link(FILENAME_SHOPPING_CART));
	// EOF GM_MOD
}

// if no shipping destination address was selected, use the customers own address as default
if (!isset ($_SESSION['sendto'])) {
	$_SESSION['sendto'] = $_SESSION['customer_default_address_id'];
} else {
	// verify the selected shipping address
	$check_address_query = xtc_db_query("select count(*) as total from ".TABLE_ADDRESS_BOOK." where customers_id = '".(int) $_SESSION['customer_id']."' and address_book_id = '".(int) $_SESSION['sendto']."'");
	$check_address = xtc_db_fetch_array($check_address_query);

	if ($check_address['total'] != '1') {
		$_SESSION['sendto'] = $_SESSION['customer_default_address_id'];
		if (isset ($_SESSION['shipping']))
			unset ($_SESSION['shipping']);
	}
}

// if no billing destination address was selected, use the customers own address as default
if (!isset ($_SESSION['billto'])) {
	$_SESSION['billto'] = $_SESSION['customer_default_address_id'];
} else {
	// verify the selected billing address
	$check_address_query = xtc_db_query("select count(*) as total from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int) $_SESSION['customer_id'] . "' and address_book_id = '" . (int) $_SESSION['billto'] . "'");
	$check_address = xtc_db_fetch_array($check_address_query);

	if ($check_address['total'] != '1') {
		$_SESSION['billto'] = $_SESSION['customer_default_address_id'];
		if (isset ($_SESSION['payment']))
			unset ($_SESSION['payment']);
	}
}

require (DIR_WS_CLASSES.'order.php');
$order = new order();

$t_country_error = '';

// check if country of selected shipping address is not allowed
if ($order->content_type != 'virtual' && ($order->content_type != 'virtual_weight') && ($_SESSION['cart']->count_contents_virtual() > 0)) {
	$t_country_check_sql = "SELECT a.address_book_id
							FROM
								" . TABLE_ADDRESS_BOOK . " a,
								" . TABLE_COUNTRIES . " c
							WHERE
								a.address_book_id = '" . (int)$_SESSION['sendto'] . "' AND
								a.entry_country_id = c.countries_id AND
								c.status = 1";
	$t_country_check_result = xtc_db_query($t_country_check_sql);
	if(xtc_db_num_rows($t_country_check_result) == 0)
	{
		$t_country_error .= ERROR_INVALID_SHIPPING_COUNTRY . ' ';
	}
}

// check if country of selected payment address is not allowed
$t_country_check_sql = "SELECT a.address_book_id
						FROM
							" . TABLE_ADDRESS_BOOK . " a,
							" . TABLE_COUNTRIES . " c
						WHERE
							a.address_book_id = '" . (int)$_SESSION['billto'] . "' AND
							a.entry_country_id = c.countries_id AND
							c.status = 1";
$t_country_check_result = xtc_db_query($t_country_check_sql);
if(xtc_db_num_rows($t_country_check_result) == 0)
{
	$t_country_error .= ERROR_INVALID_PAYMENT_COUNTRY;
}

if($t_country_error != '' && PAYPAL_EXPRESS_ADDRESS_CHANGE == 'true')
{
	$smarty->assign('error', $t_country_error);
}
elseif($t_country_error != '')
{
	xtc_redirect(xtc_href_link(FILENAME_SHOPPING_CART, 'gm_paypal_error=4'));
}

// BOF GM_MOD:
// register a random ID in the session to check throughout the checkout procedure
// against alterations in the shopping cart contents
$_SESSION['cartID'] = $_SESSION['cart']->cartID;

if ($order->delivery['country']['iso_code_2'] != '') {
	$_SESSION['delivery_zone'] = $order->delivery['country']['iso_code_2'];
}

$total_weight = $_SESSION['cart']->show_weight();
$total_count = $_SESSION['cart']->count_contents();

// load all enabled shipping modules
require (DIR_WS_CLASSES.'shipping.php');
$shipping_modules = new shipping;

// get all available shipping quotes
$quotes = $shipping_modules->quote();

if ($order->content_type == 'virtual' || ($order->content_type == 'virtual_weight') || ($_SESSION['cart']->count_contents_virtual() == 0)) { // GV Code added
	$_SESSION['shipping'] = false;
	$_SESSION['sendto'] = false;
}
elseif (!isset ($_SESSION['shipping']) || (isset ($_SESSION['shipping']) && ($_SESSION['shipping'] == false) && (xtc_count_shipping_modules() > 1))){

	$t_gm_error = true;

	for($i = 0; $i < count($quotes) && $t_gm_error == true; $i++)
	{
		if($quotes[$i]['id'] != false)
		{
			$_SESSION['shipping'] = $quotes[$i]['id'].'_'.$quotes[$i]['methods'][0]['id'];

			list($module, $method) = explode('_', $_SESSION['shipping']);

			if($_SESSION['shipping'] == 'free_free')
			{
				$quote[$i]['methods'][0]['title'] = FREE_SHIPPING_TITLE;
				$quote[$i]['methods'][0]['cost'] = '0';
			}
			else
			{
				$quote = $shipping_modules->quote($method, $module);
			}

			if(isset($quote[$i]['error']) || isset($quote['error']))
			{
				unset ($_SESSION['shipping']);
			}
			else
			{
				if((isset ($quote[0]['methods'][0]['title'])) && (isset ($quote[0]['methods'][0]['cost'])))
				{
					$_SESSION['shipping'] = array ('id' => $_SESSION['shipping'], 'title' => (($free_shipping == true) ? $quote[0]['methods'][0]['title'] : $quote[0]['module'].' ('.$quote[0]['methods'][0]['title'].')'), 'cost' => $quote[0]['methods'][0]['cost']);
					$t_gm_error = false;
					xtc_redirect(xtc_href_link(FILENAME_PAYPAL_CHECKOUT, '', 'SSL'));
				}
			}
		}
		else
		{
			$t_gm_error = false;
		}
	}
}

// load all enabled payment modules
require (DIR_WS_CLASSES . 'payment.php');

$payment_modules = new payment($_SESSION['payment']);
$payment_modules->update_status();

require (DIR_WS_CLASSES . 'order_total.php'); // GV Code ICW ADDED FOR CREDIT CLASS SYSTEM
$order_total_modules = new order_total();
$order_total_modules->process();


// GV Code Start
$order_total_modules->collect_posts();
$order_total_modules->pre_confirmation_check();
// GV Code End

if (is_array($payment_modules->modules))
	$payment_modules->pre_confirmation_check();

// Allgemein END
//------------------------------------------------------------------------


// SHIPPING START
//------------------------------------------------------------------------

if ($order->content_type != 'virtual' && ($order->content_type != 'virtual_weight') && ($_SESSION['cart']->count_contents_virtual() > 0)) {
	
	if (defined('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING') && (MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING == 'true')) {
		switch (MODULE_ORDER_TOTAL_SHIPPING_DESTINATION) {
			case 'national' :
				if ($order->delivery['country_id'] == STORE_COUNTRY)
					$pass = true;
				break;
			case 'international' :
				if ($order->delivery['country_id'] != STORE_COUNTRY)
					$pass = true;
				break;
			case 'both' :
				$pass = true;
				break;
			default :
				$pass = false;
				break;
		}

		$t_shipping_free_over = (double)MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER;
		if($_SESSION['customers_status']['customers_status_show_price_tax'] == 0
				&& $_SESSION['customers_status']['customers_status_add_tax_ot'] == 0 
				&& (int)MODULE_ORDER_TOTAL_SHIPPING_TAX_CLASS > 0)
		{
			$t_shipping_free_over = $t_shipping_free_over / (1 + $xtPrice->TAX[MODULE_ORDER_TOTAL_SHIPPING_TAX_CLASS] / 100);
		}
	
		$free_shipping = false;
		if (($pass == true) && ($order->info['total'] - $order->info['shipping_cost'] >= $xtPrice->xtcFormat($t_shipping_free_over, false, 0, true))) {
			$free_shipping = true;
	
			include (DIR_WS_LANGUAGES.$_SESSION['language'].'/modules/order_total/ot_shipping.php');
		}
	} else {
		$free_shipping = false;
	}
	
	// process the selected shipping method
	if (isset ($_POST['action']) && ($_POST['action'] == 'process')) {
		if ((xtc_count_shipping_modules() > 0) || ($free_shipping == true)) {
			if ((isset ($_POST['shipping'])) && (strpos($_POST['shipping'], '_'))) {
				$_SESSION['shipping'] = $_POST['shipping'];
	
				list ($module, $method) = explode('_', $_SESSION['shipping']);
				if (is_object($$module) || ($_SESSION['shipping'] == 'free_free')) {
					if ($_SESSION['shipping'] == 'free_free') {
						$quote[0]['methods'][0]['title'] = FREE_SHIPPING_TITLE;
						$quote[0]['methods'][0]['cost'] = '0';
					} else {
						$quote = $shipping_modules->quote($method, $module);
					}
					if (isset ($quote['error'])) {
						unset ($_SESSION['shipping']);
					} else {
						if ((isset ($quote[0]['methods'][0]['title'])) && (isset ($quote[0]['methods'][0]['cost']))) {
							$_SESSION['shipping'] = array ('id' => $_SESSION['shipping'], 'title' => (($free_shipping == true) ? $quote[0]['methods'][0]['title'] : $quote[0]['module'].' ('.$quote[0]['methods'][0]['title'].')'), 'cost' => $quote[0]['methods'][0]['cost']);
	
							xtc_redirect(xtc_href_link(FILENAME_PAYPAL_CHECKOUT, '', 'SSL'));
						}
					}
				} else {
					unset ($_SESSION['shipping']);
				}
			}
		} else {
			$_SESSION['shipping'] = false;
	
			xtc_redirect(xtc_href_link(FILENAME_PAYPAL_CHECKOUT, '', 'SSL'));
		}
	}
	
	
	// get all available shipping quotes
	$quotes = $shipping_modules->quote();
}
	
require (DIR_WS_INCLUDES.'header.php');

if (SHOW_IP_LOG == 'true') {
	$smarty->assign('IP_LOG', 'true');
	if ($_SERVER["HTTP_X_FORWARDED_FOR"]) {
		$customers_ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	} else {
		$customers_ip = $_SERVER["REMOTE_ADDR"];
	}
	$smarty->assign('CUSTOMERS_IP', $customers_ip);
}

if ($order->content_type != 'virtual' && ($order->content_type != 'virtual_weight') && ($_SESSION['cart']->count_contents_virtual() > 0)) {
	$smarty->assign('FORM_SHIPPING_ACTION', xtc_draw_form('checkout_shipping', xtc_href_link(FILENAME_PAYPAL_CHECKOUT, '', 'SSL'), 'post', 'name="paypal_shipping"').xtc_draw_hidden_field('action', 'process'));

	$t_shipping_form_array = array();
	$t_shipping_form_array = array('ID' => 'checkout_shipping',
									'ACTION' => xtc_href_link(FILENAME_PAYPAL_CHECKOUT, '', 'SSL'),
									'METHOD' => 'post');
	$smarty->assign('shipping_form_data', $t_shipping_form_array);
	$t_shipping_hidden_array = array('NAME' => 'action', 'VALUE' => 'process');
	$smarty->assign('shipping_hidden_data', $t_shipping_hidden_array);
	
	$smarty->assign('ADDRESS_SHIPPING_LABEL', xtc_address_label($_SESSION['customer_id'], $_SESSION['sendto'], true, ' ', '<br />'));
	$smarty->assign('BUTTON_CONTINUE', xtc_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE));
	$smarty->assign('FORM_END', '</form>');
}

$smarty->assign('ADDRESS_PAYMENT_LABEL', xtc_address_label($_SESSION['customer_id'], $_SESSION['billto'], true, ' ', '<br />'));
if (PAYPAL_EXPRESS_ADDRESS_CHANGE == 'true') {
	$smarty->assign('BUTTON_SHIPPING_ADDRESS', '<a href="'.xtc_href_link(FILENAME_CHECKOUT_SHIPPING_ADDRESS, '', 'SSL').'">'.xtc_image_button('button_change_address.gif', IMAGE_BUTTON_CHANGE_ADDRESS).'</a>');
	$smarty->assign('BUTTON_PAYMENT_ADDRESS', '<a href="' . xtc_href_link(FILENAME_CHECKOUT_PAYMENT_ADDRESS, '', 'SSL') . '">' . xtc_image_button('button_change_address.gif', IMAGE_BUTTON_CHANGE_ADDRESS) . '</a>');
	
	$smarty->assign('SHIPPING_ADDRESS_EDIT', xtc_href_link(FILENAME_CHECKOUT_SHIPPING_ADDRESS, '', 'SSL'));
	$smarty->assign('BILLING_ADDRESS_EDIT', xtc_href_link(FILENAME_CHECKOUT_PAYMENT_ADDRESS, '', 'SSL'));
}
	
$smarty->assign('PRODUCTS_EDIT', xtc_href_link(FILENAME_SHOPPING_CART, '', 'SSL'));
	
$module_smarty = new Smarty;

$module_smarty->assign('PAYPAL_EXPRESS', 1);

if ($order->content_type != 'virtual' && ($order->content_type != 'virtual_weight') && ($_SESSION['cart']->count_contents_virtual() > 0)) {
	if (xtc_count_shipping_modules() > 0) {
		$showtax = $_SESSION['customers_status']['customers_status_show_price_tax'];
		$module_smarty->assign('FREE_SHIPPING', $free_shipping);
	
		# free shipping or not...
		if ($free_shipping == true) {
			$module_smarty->assign('FREE_SHIPPING_TITLE', FREE_SHIPPING_TITLE);
			$module_smarty->assign('FREE_SHIPPING_DESCRIPTION', sprintf(FREE_SHIPPING_DESCRIPTION, $xtPrice->xtcFormat($t_shipping_free_over, true, 0, true)).xtc_draw_hidden_field('shipping', 'free_free'));
			$module_smarty->assign('FREE_SHIPPING_ICON', $quotes[$i]['icon']);
		} else {
			$radio_buttons = 0;
			#loop through installed shipping methods...
			for ($i = 0, $n = sizeof($quotes); $i < $n; $i ++) {
				if (!isset ($quotes[$i]['error'])) {
					for ($j = 0, $n2 = sizeof($quotes[$i]['methods']); $j < $n2; $j ++) {
						# set the radio button to be checked if it is the method chosen
						$quotes[$i]['methods'][$j]['radio_buttons'] = $radio_buttons;
						$checked = (($quotes[$i]['id'].'_'.$quotes[$i]['methods'][$j]['id'] == $_SESSION['shipping']['id']) ? true : false);
	
						if (($checked == true) || ($n == 1 && $n2 == 1)) {
							$quotes[$i]['methods'][$j]['checked'] = 1;
						}
	
						if (($n > 1) || ($n2 > 1)) {
							if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0)
								$quotes[$i]['tax'] = '';
							if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0)
								$quotes[$i]['tax'] = 0;
	
							$quotes[$i]['methods'][$j]['price'] = $xtPrice->xtcFormat(xtc_add_tax($quotes[$i]['methods'][$j]['cost'], $quotes[$i]['tax']), true, 0, true);
	
							$quotes[$i]['methods'][$j]['radio_field'] = xtc_draw_hidden_field('act_shipping', 'true').xtc_draw_radio_field('shipping', $quotes[$i]['id'].'_'.$quotes[$i]['methods'][$j]['id'], $checked, 'onclick="this.form.submit();"');
	
						} else {
							if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0)
								$quotes[$i]['tax'] = 0;
							$quotes[$i]['methods'][$j]['price'] = $xtPrice->xtcFormat(xtc_add_tax($quotes[$i]['methods'][$j]['cost'], $quotes[$i]['tax']), true, 0, true).xtc_draw_hidden_field('shipping', $quotes[$i]['id'].'_'.$quotes[$i]['methods'][$j]['id']);
						}
						$radio_buttons ++;
					}
				}
			}
	
			$module_smarty->assign('module_content', $quotes);
	
		}
		$module_smarty->caching = 0;
		$shipping_block = $module_smarty->fetch(CURRENT_TEMPLATE.'/module/checkout_shipping_block.html');
	}
}
// SHIPPING END
//------------------------------------------------------------------------


// PAYMENT START
//------------------------------------------------------------------------

if ($order->info['total'] > 0) {

	if (isset ($_GET['payment_error']) && is_object(${ $_GET['payment_error'] }) && ($error = ${$_GET['payment_error']}->get_error())) {

		$smarty->assign('error', htmlspecialchars_wrapper($error['error']));

	}

	$selection = $payment_modules->selection();

	$radio_buttons = 0;
	for ($i = 0, $n = sizeof($selection); $i < $n; $i++) {

		$selection[$i]['radio_buttons'] = $radio_buttons;
		if (($selection[$i]['id'] == $payment) || ($n == 1)) {
			$selection[$i]['checked'] = 1;
		}

		if (sizeof($selection) > 1) {
			$selection[$i]['selection'] = xtc_draw_radio_field('payment', $selection[$i]['id'], ($selection[$i]['id'] == $_SESSION['payment']), 'onclick="this.form.submit();"').xtc_draw_hidden_field('act_payment', 'true');
		} else {
			$selection[$i]['selection'] = xtc_draw_hidden_field('payment', $selection[$i]['id']).xtc_draw_hidden_field('act_payment', 'true');
		}

		if (isset ($selection[$i]['error'])) {

		} else {

			$radio_buttons++;
		}
	}

	$module_smarty->assign('module_content', $selection);

} else {
	$smarty->assign('GV_COVER', 'true');
}

if (ACTIVATE_GIFT_SYSTEM == 'true') {
	$smarty->assign('module_gift', $order_total_modules->credit_selection());
}

$module_smarty->caching = 0;
$payment_block = $module_smarty->fetch(CURRENT_TEMPLATE . '/module/checkout_payment_block.html');

// PAYMENT END
//------------------------------------------------------------------------

// CONFIRMATION START
//------------------------------------------------------------------------

if ($messageStack->size('checkout_payment') > 0) {
			$smarty->assign('error', $messageStack->output('checkout_payment'));
}



if ($order->info['payment_method'] != 'no_payment' && $order->info['payment_method'] != '') {
	include (DIR_WS_LANGUAGES . '/' . $_SESSION['language'] . '/modules/payment/' . $order->info['payment_method'] . '.php');
	$smarty->assign('PAYMENT_METHOD', constant(MODULE_PAYMENT_ . strtoupper($order->info['payment_method']) . _TEXT_TITLE));
}
$smarty->assign('PAYMENT_EDIT', xtc_href_link(FILENAME_PAYPAL_CHECKOUT_PAYMENT, '', 'SSL'));

// Products Attributes START
// ---------------------------------------------------------------------
$coo_properties_control = MainFactory::create_object('PropertiesControl');
$coo_properties_view = MainFactory::create_object('PropertiesView');

$t_products_array = array();

for ($i = 0, $n = sizeof($order->products); $i < $n; $i++)
{
	$t_products_item		= array();
	$t_products_attributes	= array();

	$coo_product_item = new product(xtc_get_prid($order->products[$i]['id']));

	$t_options_values_array = array();
	$t_attr_weight = 0;
	$t_attr_model_array = array();
	if(isset($order->products[$i]['attributes']) && is_array($order->products[$i]['attributes']))
	{
		foreach($order->products[$i]['attributes'] AS $t_attributes_data_array)
		{
			$t_options_values_array[$t_attributes_data_array['option_id']] = $t_attributes_data_array['value_id'];
		}
		
		// calculate attributes weight and get attributes model
		foreach($t_options_values_array AS $t_option_id => $t_value_id)
		{
			$t_attr_sql = "SELECT
								options_values_weight AS weight,
								weight_prefix AS prefix,
								attributes_model
							FROM
								products_attributes
							WHERE
								products_id				= '" . (int)xtc_get_prid($order->products[$i]['id']) . "' AND
								options_id				= '" . (int)$t_option_id . "' AND
								options_values_id		= '" . (int)$t_value_id	 . "'
							LIMIT 1";
			$t_attr_result = xtc_db_query($t_attr_sql);
			if(xtc_db_num_rows($t_attr_result) == 1)
			{
				$t_attr_result_array = xtc_db_fetch_array($t_attr_result);

				if(trim($t_attr_result_array['attributes_model']) != '')
				{
					$t_attr_model_array[] = $t_attr_result_array['attributes_model'];
				}

				if($t_attr_result_array['prefix'] == '-')
				{
					$t_attr_weight -= (double)$t_attr_result_array['weight'];
				} 
				else
				{
					$t_attr_weight += (double)$t_attr_result_array['weight'];
				}
			}			
		}
	}

	$t_shipping_time = '';
	if(ACTIVATE_SHIPPING_STATUS == 'true')
	{
		$t_shipping_time = $order->products[$i]['shipping_time'];
	}


	$t_products_weight = '';	
	if(!empty($coo_product_item->data['gm_show_weight']))
	{
		// already contains products properties weight
		$t_products_weight = gm_prepare_number($order->products[$i]['weight'] + $t_attr_weight, $xtPrice->currencies[$xtPrice->actualCurr]['decimal_point']);
	}

	$t_products_model = $order->products[$i]['model'];
	if($t_products_model != '' && isset($t_attr_model_array[0]))
	{
		$t_products_model .= '-' . implode('-', $t_attr_model_array);
	}
	else
	{
		$t_products_model .= implode('-', $t_attr_model_array);
	}

	#properties
	$t_properties = '';
	$t_combis_id = '';
	$t_properties_array = array();
	if(strpos($order->products[$i]['id'], 'x') !== false)
	{
		$t_combis_id = (int)substr($order->products[$i]['id'], strpos($order->products[$i]['id'], 'x')+1);		
	}	
	if($t_combis_id != '')
	{
		$t_properties = $coo_properties_view->get_order_details_by_combis_id($t_combis_id, 'cart');
		$t_properties_array = $coo_properties_view->v_coo_properties_control->get_properties_combis_details($t_combis_id, $_SESSION['languages_id']);
		
		if(method_exists($coo_properties_control, 'get_properties_combis_model'))
		{
			$t_combi_model = $coo_properties_control->get_properties_combis_model($t_combis_id);

			if(APPEND_PROPERTIES_MODEL == "true") {
				// Artikelnummer (Kombi) an Artikelnummer (Artikel) anhängen
				if($t_products_model != '' && $t_combi_model != ''){
					$t_products_model = $t_products_model .'-'. $t_combi_model;
				}else if($t_combi_model != ''){
					$t_products_model = $t_combi_model;
				}
			}else{
				// Artikelnummer (Artikel) durch Artikelnummer (Kombi) ersetzen
				if($t_combi_model != ''){
					$t_products_model = $t_combi_model;
				}
			}

			if($coo_product_item->data['use_properties_combis_shipping_time'] == 1 && ACTIVATE_SHIPPING_STATUS == 'true'){
				$t_shipping_time = $coo_properties_control->get_properties_combis_shipping_time($t_combis_id);
			}
		}
	}

	$t_products_item['products_name'] = $order->products[$i]['name'];
	$t_products_item['quantity'] = gm_convert_qty($order->products[$i]['qty'], false);
	$t_products_item['final_price'] = $xtPrice->xtcFormat($order->products[$i]['final_price'], true);
	$t_products_item['price_formated'] = $order->products[$i]['price_formated'];
	$t_products_item['unit'] = $order->products[$i]['unit_name'];
	$t_products_item['model'] = $order->products[$i]['model'];
	$t_products_item['PROPERTIES'] = $t_properties;
	$t_products_item['products_image'] = (!empty($coo_product_item->data['gm_show_image']) && !empty($coo_product_item->data['products_image'])) ? DIR_WS_THUMBNAIL_IMAGES . $coo_product_item->data['products_image'] : '';
	$t_products_item['products_vpe_array'] = get_products_vpe_array($order->products[$i]['id'], $order->products[$i]['price'], $t_options_values_array);
	$t_products_item['products_alt'] = (!empty($coo_product_item->data['gm_alt_text'])) ? $coo_product_item->data['gm_alt_text'] : $order->products[$i]['name'];
	$t_products_item['checkout_information'] = $coo_product_item->data['checkout_information'];
	$t_products_item['products_url'] = xtc_href_link('request_port.php', 'module=ProductDetails&id=' . $order->products[$i]['id'], 'SSL');
	$t_products_item['products_model'] = $t_products_model;
	$t_products_item['products_weight'] = $t_products_weight;
	$t_products_item['shipping_time'] = $t_shipping_time;
	$t_products_item['DATA_ARRAY'] = $coo_product_item->data;

	if ((isset ($order->products[$i]['attributes'])) && (sizeof($order->products[$i]['attributes']) > 0)) {
		for ($j = 0, $n2 = sizeof($order->products[$i]['attributes']); $j < $n2; $j++) 
		{
			$t_products_attributes[] = array(
												'option' => $order->products[$i]['attributes'][$j]['option'],
												'value'  => $order->products[$i]['attributes'][$j]['value']
											);
		}
		// GX-Customizer:
		include(DIR_FS_CATALOG . 'gm/modules/gm_gprint_checkout_confirmation.php');
		$t_products_item['attributes'] = $t_products_attributes;
	}
	$t_products_array[] = $t_products_item;
}
// Products Attributes ENDE
// ---------------------------------------------------------------------

$smarty->assign('products_data', $t_products_array);

if (MODULE_ORDER_TOTAL_INSTALLED) {
	$smarty->assign('total_block', $order_total_modules->pp_output());
}

if (is_array($checkout_payment_modules->modules)) {
	if ($confirmation = $checkout_payment_modules->confirmation()) {
		for ($i = 0, $n = sizeof($confirmation['fields']); $i < $n; $i++) {
			$payment_info[] = array('TITLE'=>$confirmation['fields'][$i]['title'],
									'FIELD'=>stripslashes($confirmation['fields'][$i]['field'])
									);
		}
		$smarty->assign('PAYMENT_INFORMATION', $payment_info);

	}
}

if (xtc_not_null($order->info['comments'])) {
	$smarty->assign('ORDER_COMMENTS', nl2br(htmlspecialchars_wrapper($order->info['comments'])) . xtc_draw_hidden_field('comments', $order->info['comments']));

}

if (isset ($$_SESSION['payment']->form_action_url) && !$$_SESSION['payment']->tmpOrders) {

	$form_action_url = $$_SESSION['payment']->form_action_url;

} else {
	$form_action_url = xtc_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL');
}

$smarty->assign('CHECKOUT_FORM', xtc_draw_form('checkout_confirmation', $form_action_url, 'post', 'onsubmit="return check_paypal_form();"'));

$t_checkout_form_array = array();
$t_checkout_form_array = array('ID' => 'checkout_confirmation',
								'ACTION' => $form_action_url,
								'METHOD' => 'post');
$smarty->assign('checkout_form_data', $t_checkout_form_array);

$checkout_payment_button = '';
if (is_array($checkout_payment_modules->modules)) {
	$checkout_payment_button .= $checkout_payment_modules->process_button();
}
$smarty->assign('MODULE_BUTTONS', $checkout_payment_button);
// BOF GM_MOD:
$smarty->assign('CHECKOUT_BUTTON', xtc_image_submit('bestellung.gif', IMAGE_BUTTON_CONFIRM_ORDER) . "\n");

// CONFIRMATION END
//------------------------------------------------------------------------

// RIGHTS START
//------------------------------------------------------------------------

	if ($order->info['shipping_method']) {
		$smarty->assign('SHIPPING_METHOD', $order->info['shipping_method']);
		$smarty->assign('SHIPPING_EDIT', xtc_href_link(FILENAME_PAYPAL_CHECKOUT_SHIPPING, '', 'SSL'));

	}

// BOF GM_MOD:
$smarty->assign('COMMENTS', xtc_draw_textarea_field('comments', 'soft', '', '', $_SESSION['comments'], 'class="comments_textarea"') . xtc_draw_hidden_field('comments_added', 'YES'));

$smarty->assign('COMMENTS_NAME', 'comments');
$smarty->assign('COMMENTS_WRAP', 'soft');
$smarty->assign('COMMENTS_VALUE', $_SESSION['comments']);
$smarty->assign('COMMENTS_HIDDEN_NAME', 'comments_added');
$smarty->assign('COMMENTS_HIDDEN_VALUE', 'YES');

//check if display conditions on checkout page is true
// BOF GM_MOD:
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

	if ($shop_content_data['content_file'] != '') {

		$conditions = '<iframe SRC="' . GM_HTTP_SERVER . DIR_WS_CATALOG . 'media/content/' . $shop_content_data['content_file'] . '" width="100%" height="300">';
		$conditions .= '</iframe>';
		$smarty->assign('AGB_IFRAME', 1);
		$smarty->assign('AGB_IFRAME_URL', GM_HTTP_SERVER . DIR_WS_CATALOG . 'media/content/' . $shop_content_data['content_file']);
	} else {
		// BOF GM_MOD:
		$conditions = '<textarea class="agb_textarea" name="conditions_text" readonly="readonly">' . strip_tags($shop_content_data['content_text']) . '</textarea>';
		$t_conditions_array = array();
		$t_conditions_array = array('CLASS' => 'agb_textarea', 'NAME' => 'conditions_text', 'TEXT' => strip_tags($shop_content_data['content_text']));
		$smarty->assign('conditions_data', $t_conditions_array);
	}

	$smarty->assign('AGB', $conditions);
	$smarty->assign('AGB_LINK', $main->getContentLink(3, MORE_INFO));
}

// BOF GM_MOD
if(gm_get_conf('GM_CHECK_CONDITIONS') == 1){
	
	$t_conditions_checkbox_array = array();
	
	$smarty->assign('CHECKBOX_AGB', '<input type="checkbox" value="conditions" name="conditions" />');
	$t_conditions_checkbox_array = array('VALUE' => 'conditions', 'NAME' => 'conditions', 'CHECKED' => 0);
	
	$smarty->assign('conditions_checkbox_data', $t_conditions_checkbox_array);
}
// EOF GM_MOD


// BOF GM_MOD
//check if display withdrawal on checkout page is true
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

	if ($shop_content_data['content_file'] != '') {

		$withdrawal = '<iframe SRC="' . GM_HTTP_SERVER . DIR_WS_CATALOG . 'media/content/' . $shop_content_data['content_file'] . '" width="100%" height="300">';
		$withdrawal .= '</iframe>';
		$smarty->assign('WITHDRAWAL_IFRAME', 1);
		$smarty->assign('WITHDRAWAL_IFRAME_URL', GM_HTTP_SERVER . DIR_WS_CATALOG . 'media/content/' . $shop_content_data['content_file']);
	} else {
		// BOF GM_MOD:
		$withdrawal = '<textarea class="withdrawal_textarea" name="withdrawal_text" readonly="readonly">' . strip_tags($shop_content_data['content_text']) . '</textarea>';
		$t_withdrawal_array = array();
		$t_withdrawal_array = array('CLASS' => 'withdrawal_textarea', 'NAME' => 'withdrawal_text', 'TEXT' => strip_tags($shop_content_data['content_text']));
		$smarty->assign('withdrawal_data', $t_withdrawal_array);
	}

	$smarty->assign('WITHDRAWAL', $withdrawal);

}
// EOF GM_MOD

// BOF GM_MOD
if(gm_get_conf('GM_CHECK_WITHDRAWAL') == 1){
	$smarty->assign('CHECKBOX_WITHDRAWAL', '<input type="checkbox" value="withdrawal" name="withdrawal" />');
	$t_withdrawal_checkbox_array = array();
	$t_withdrawal_checkbox_array = array('VALUE' => 'withdrawal', 'NAME' => 'withdrawal', 'CHECKED' => 0);

	$smarty->assign('withdrawal_checkbox_data', $t_withdrawal_checkbox_array);
}
// EOF GM_MOD

$coo_content_master = MainFactory::create_object('ContentMaster');	
$t_confirmation_info_array = $coo_content_master->get_content(198);
$smarty->assign('CONFIRMATION_INFO', $t_confirmation_info_array['content_text']);

if(gm_get_env_info('TEMPLATE_VERSION') < FIRST_GX2_TEMPLATE_VERSION)
{
	if(gm_get_conf('GM_SHOW_PRIVACY_CONFIRMATION') == 1){
		$smarty->assign('PRIVACY_CONFIRMATION', '<a href="' . xtc_href_link('shop_content.php', 'coID=2', 'SSL') . '" target="_blank" class="conditions_info_link">' . GM_CONFIRMATION_PRIVACY . '</a>');
		$smarty->assign('PRIVACY_CONFIRMATION_TEXT', GM_CONFIRMATION_PRIVACY);
		$smarty->assign('PRIVACY_CONFIRMATION_URL', xtc_href_link('shop_content.php', 'coID=2', 'SSL'));
	}

	if(gm_get_conf('GM_SHOW_CONDITIONS_CONFIRMATION') == 1){
		$smarty->assign('CONDITIONS_CONFIRMATION', '<a href="' . xtc_href_link('shop_content.php', 'coID=3', 'SSL') . '" target="_blank" class="conditions_info_link">' . GM_CONFIRMATION_CONDITIONS . '</a>');
		$smarty->assign('CONDITIONS_CONFIRMATION_TEXT', GM_CONFIRMATION_CONDITIONS);
		$smarty->assign('CONDITIONS_CONFIRMATION_URL', xtc_href_link('shop_content.php', 'coID=3', 'SSL') );
	}

	if(gm_get_conf('GM_SHOW_WITHDRAWAL_CONFIRMATION') == 1){
		$smarty->assign('WITHDRAWAL_CONFIRMATION', '<a href="' . xtc_href_link('shop_content.php', 'coID='.gm_get_conf('GM_WITHDRAWAL_CONTENT_ID'), 'SSL') . '" target="_blank" class="conditions_info_link">' . GM_CONFIRMATION_WITHDRAWAL . '</a>');
		$smarty->assign('WITHDRAWAL_CONFIRMATION_TEXT', GM_CONFIRMATION_WITHDRAWAL);
		$smarty->assign('WITHDRAWAL_CONFIRMATION_URL', xtc_href_link('shop_content.php', 'coID='.gm_get_conf('GM_WITHDRAWAL_CONTENT_ID'), 'SSL'));
	}
}
else
{
	if(gm_get_conf('GM_SHOW_PRIVACY_CONFIRMATION') == 1){
		$smarty->assign('PRIVACY_CONFIRMATION', '<a href="' . xtc_href_link('shop_content.php', 'coID=2&lightbox_mode=1', 'SSL') . '" target="_blank" class="conditions_info_link lightbox_iframe">' . GM_CONFIRMATION_PRIVACY . '</a>');
		$smarty->assign('PRIVACY_CONFIRMATION_TEXT', GM_CONFIRMATION_PRIVACY);
		$smarty->assign('PRIVACY_CONFIRMATION_URL', xtc_href_link('popup_content.php', 'coID=2&lightbox_mode=1', 'SSL'));
	}

	if(gm_get_conf('GM_SHOW_CONDITIONS_CONFIRMATION') == 1){
		$smarty->assign('CONDITIONS_CONFIRMATION', '<a href="' . xtc_href_link('shop_content.php', 'coID=3&lightbox_mode=1', 'SSL') . '" target="_blank" class="conditions_info_link lightbox_iframe">' . GM_CONFIRMATION_CONDITIONS . '</a>');
		$smarty->assign('CONDITIONS_CONFIRMATION_TEXT', GM_CONFIRMATION_CONDITIONS);
		$smarty->assign('CONDITIONS_CONFIRMATION_URL', xtc_href_link('popup_content.php', 'coID=3&lightbox_mode=1', 'SSL') );
	}

	if(gm_get_conf('GM_SHOW_WITHDRAWAL_CONFIRMATION') == 1){
		$smarty->assign('WITHDRAWAL_CONFIRMATION', '<a href="' . xtc_href_link('shop_content.php', 'coID='.gm_get_conf('GM_WITHDRAWAL_CONTENT_ID') . '&lightbox_mode=1', 'SSL') . '" target="_blank" class="conditions_info_link lightbox_iframe">' . GM_CONFIRMATION_WITHDRAWAL . '</a>');
		$smarty->assign('WITHDRAWAL_CONFIRMATION_TEXT', GM_CONFIRMATION_WITHDRAWAL);
		$smarty->assign('WITHDRAWAL_CONFIRMATION_URL', xtc_href_link('popup_content.php', 'coID='.gm_get_conf('GM_WITHDRAWAL_CONTENT_ID') . '&lightbox_mode=1', 'SSL'));
	}
}

// BOF GM_MOD:
$smarty->assign('LIGHTBOX', gm_get_conf('GM_LIGHTBOX_CHECKOUT'));
$smarty->assign('LIGHTBOX_CLOSE', xtc_href_link(FILENAME_DEFAULT, '', 'NONSSL'));


// RIGHTS END
//------------------------------------------------------------------------


//------------------------------------------
$smarty->assign('language', $_SESSION['language']);
$smarty->assign('SHIPPING_BLOCK', $shipping_block);


$payment_hidden = xtc_draw_hidden_field('payment','paypalexpress') . xtc_draw_hidden_field('act_payment','true');

$t_payment_hidden_fields_array = array();
$t_payment_hidden_fields_array[] = array('NAME' => 'payment', 'VALUE' => 'paypalexpress');
$t_payment_hidden_fields_array[] = array('NAME' => 'act_payment', 'VALUE' => 'true');
$smarty->assign('payment_hidden_fields_data', $t_payment_hidden_fields_array);

$smarty->assign('PAYMENT_HIDDEN', $payment_hidden);
$smarty->caching = 0;
$main_content = $smarty->fetch(CURRENT_TEMPLATE.'/module/checkout_paypal.html');

$smarty->assign('language', $_SESSION['language']);
$smarty->assign('main_content', $main_content);
$smarty->caching = 0;
if (!defined(RM))
	$smarty->load_filter('output', 'note');
$smarty->display(CURRENT_TEMPLATE.'/index.html');
include ('includes/application_bottom.php');
?>