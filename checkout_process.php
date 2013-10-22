<?php
/* --------------------------------------------------------------
   checkout_process.php 2012-09-21 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(checkout_process.php,v 1.128 2003/05/28); www.oscommerce.com
   (c) 2003	 nextcommerce (checkout_process.php,v 1.30 2003/08/24); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: checkout_process.php 1277 2005-10-01 17:02:59Z mz $)

   Released under the GNU General Public License
    ----------------------------------------------------------------------------------------
   Third Party contribution:

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

// include needed functions
require_once (DIR_FS_INC.'xtc_calculate_tax.inc.php');
require_once (DIR_FS_INC.'xtc_address_label.inc.php');
require_once (DIR_FS_INC.'changedatain.inc.php');
require_once (DIR_FS_INC . 'xtc_check_stock.inc.php');

// initialize smarty
$smarty = new Smarty;

if (DISPLAY_CONDITIONS_ON_CHECKOUT == 'true') {
	if (is_array($_SESSION['nvpReqArray']) && $_POST['conditions'] != 'conditions' && $_SESSION['payment'] == 'paypalexpress') {

		xtc_redirect(xtc_href_link(FILENAME_PAYPAL_CHECKOUT, 'error_message=1', 'SSL', true, false));

	}
}

if(STOCK_ALLOW_CHECKOUT == 'false' 
	&& $_SESSION['payment'] != 'paypal' 
	&& $_SESSION['payment'] != 'paypal_gambio' 
	&& $_SESSION['payment'] != 'paypalgambio_alt' 
	&& $_SESSION['payment'] != 'sofortueberweisung_direct' 
	&& $_SESSION['payment'] != 'pn_sofortueberweisung' 
	&& $_SESSION['payment'] != 'clickandbuy_v2' 
	&& $_SESSION['payment'] != 'postfinance_epayment' 
	&& strpos($_SESSION['payment'], 'sofort_') === false
	&& strpos($_SESSION['payment'], 'moneybookers') === false
	&& strpos($_SESSION['payment'], 'vrepay') === false)
{
    $gm_attributes_array = array_keys($_SESSION['cart']->contents);
    $any_out_of_stock = 0;
    
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
					if(mysql_num_rows($gm_attribute_stock) == 1) $any_out_of_stock = true;
					next($gm_attributes);
				}
			}
		}else{
            $coo_properties = MainFactory::create_object('PropertiesControl');
            $t_combis_id = $coo_properties->extract_combis_id($gm_attributes_array[$i]);

            if($t_combis_id == ''){
                // product without properties
                if(STOCK_CHECK == 'true')
                {
                    if (xtc_check_stock($gm_attributes_array[$i], (double)$_SESSION['cart']->contents[$gm_attributes_array[$i]]['qty'])){
                        $any_out_of_stock = true;
                    }
                }
            }else{
                // product with properties            
                $t_use_combis_quantity = $coo_properties->get_use_properties_combis_quantity($gm_attributes_array[$i]);

                if($t_use_combis_quantity != 3){
                    if(($t_use_combis_quantity == 0 && STOCK_CHECK == 'true' && ATTRIBUTE_STOCK_CHECK == 'true') || $t_use_combis_quantity == 2){
                        // check combi quantity
                        $t_combis_quantity = $coo_properties->get_properties_combis_quantity($t_combis_id);

                        if($t_combis_quantity < (double)$_SESSION['cart']->contents[$gm_attributes_array[$i]]['qty']){
                            $any_out_of_stock = true;
                        }
                    }else if($t_use_combis_quantity == 1){
                        // check article quantity
                        if (xtc_check_stock($gm_attributes_array[$i], (double)$_SESSION['cart']->contents[$gm_attributes_array[$i]]['qty'])){
                            $any_out_of_stock = true;
                        }
                    }
                }
            } 
        }
	}

	// wenn während des Bestellvorgangs Attribut- oder Artikellagerbestand unter Warenkorbbestand gesunken ist
	if ($any_out_of_stock == true) xtc_redirect(xtc_href_link(FILENAME_SHOPPING_CART));
}

// EOF GM_MOD

// if the customer is not logged on, redirect them to the login page
if (!isset ($_SESSION['customer_id'])) {
	xtc_redirect(xtc_href_link(FILENAME_LOGIN, '', 'SSL'));
}

if ($_SESSION['customers_status']['customers_status_show_price'] != '1') {
	// BOF GM_MOD:
	xtc_redirect(xtc_href_link(FILENAME_DEFAULT, '', 'NONSSL'));
}

if (!isset ($_SESSION['sendto'])) {
	if($_SESSION['payment']=='paypalexpress'){
		xtc_redirect(xtc_href_link(FILENAME_PAYPAL_CHECKOUT, '', 'SSL'));
	}else{
		xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
	}
}
// BOF GM_MOD:
if ((xtc_not_null(MODULE_PAYMENT_INSTALLED)) && (!isset ($_SESSION['payment'])) && (!isset ($_SESSION['credit_covers']))) {
	if($_SESSION['payment']=='paypalexpress'){
	xtc_redirect(xtc_href_link(FILENAME_PAYPAL_CHECKOUT, '', 'SSL'));
	}else{
	xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
	}
}

// avoid hack attempts during the checkout procedure by checking the internal cartID
if (isset ($_SESSION['cart']->cartID) && isset ($_SESSION['cartID'])) {
	if ($_SESSION['cart']->cartID != $_SESSION['cartID']) {
		if($_SESSION['payment']=='paypalexpress'){
		xtc_redirect(xtc_href_link(FILENAME_PAYPAL_CHECKOUT, '', 'SSL'));
		}else{
		xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
		}
	}
}

// load selected payment module
require (DIR_WS_CLASSES.'payment.php');
if (isset ($_SESSION['credit_covers']))
	$_SESSION['payment'] = ''; //ICW added for CREDIT CLASS
$payment_modules = new payment($_SESSION['payment']);

// load the selected shipping module
require (DIR_WS_CLASSES.'shipping.php');
$shipping_modules = new shipping($_SESSION['shipping']);

require (DIR_WS_CLASSES.'order.php');
$order = new order();

// load the before_process function from the payment modules
$payment_modules->before_process();

require (DIR_WS_CLASSES.'order_total.php');
$order_total_modules = new order_total();

$order_totals = $order_total_modules->process();


# PropertiesControl Object
$coo_properties = MainFactory::create_object('PropertiesControl');


// check if tmp order id exists
if (isset ($_SESSION['tmp_oID']) && is_int($_SESSION['tmp_oID'])) {
	$tmp = false;
	$insert_id = $_SESSION['tmp_oID'];
}
else {
	// check if tmp order need to be created
	//if (isset ($$_SESSION['payment']->form_action_url) && $$_SESSION['payment']->tmpOrders) {
	if ($$_SESSION['payment']->tmpOrders == true) {
		$tmp = true;
		$tmp_status = $$_SESSION['payment']->tmpStatus;
	}
	else {
		$tmp = false;
		$tmp_status = $order->info['order_status'];
	}

// BMC CC Mod Start
if (strtolower(CC_ENC) == 'true') {
	$plain_data = $order->info['cc_number'];
	$order->info['cc_number'] = changedatain($plain_data, CC_KEYCHAIN);
}
// BMC CC Mod End

if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == 1) {
	$discount = $_SESSION['customers_status']['customers_status_ot_discount'];
} else {
	$discount = '0.00';
}


/* bof gm */
if(($_POST['gm_log_ip'] == 'save' && gm_get_conf("GM_LOG_IP") == '1') || (gm_get_conf("GM_SHOW_IP") == '1' && gm_get_conf("GM_LOG_IP") == '1')) {
	if ($_SERVER["HTTP_X_FORWARDED_FOR"]) {
		$customers_ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	} else {
		$customers_ip = $_SERVER["REMOTE_ADDR"];
	}
}
/* eof gm */

if(isset($_POST['comments']) && empty($order->info['comments']))
{
	$order->info['comments'] = gm_prepare_string($_POST['comments'], true);
}
elseif(isset($_SESSION['comments']) && empty($order->info['comments']))
{
	$order->info['comments'] = $_SESSION['comments'];
}

if ($_SESSION['credit_covers'] != '1') {
	$sql_data_array = array ('customers_id' => $_SESSION['customer_id'], 'customers_name' => $order->customer['firstname'].' '.$order->customer['lastname'], 'customers_firstname' => $order->customer['firstname'], 'customers_lastname' => $order->customer['lastname'], 'customers_cid' => $order->customer['csID'], 'customers_vat_id' => $_SESSION['customer_vat_id'], 'customers_company' => $order->customer['company'], 'customers_status' => $_SESSION['customers_status']['customers_status_id'], 'customers_status_name' => $_SESSION['customers_status']['customers_status_name'], 'customers_status_image' => $_SESSION['customers_status']['customers_status_image'], 'customers_status_discount' => $discount, 'customers_street_address' => $order->customer['street_address'], 'customers_suburb' => $order->customer['suburb'], 'customers_city' => $order->customer['city'], 'customers_postcode' => $order->customer['postcode'], 'customers_state' => $order->customer['state'], 'customers_country' => $order->customer['country']['title'], 'customers_telephone' => $order->customer['telephone'], 'customers_email_address' => $order->customer['email_address'], 'customers_address_format_id' => $order->customer['format_id'], 'delivery_name' => $order->delivery['firstname'].' '.$order->delivery['lastname'], 'delivery_firstname' => $order->delivery['firstname'], 'delivery_lastname' => $order->delivery['lastname'], 'delivery_company' => $order->delivery['company'], 'delivery_street_address' => $order->delivery['street_address'], 'delivery_suburb' => $order->delivery['suburb'], 'delivery_city' => $order->delivery['city'], 'delivery_postcode' => $order->delivery['postcode'], 'delivery_state' => $order->delivery['state'], 'delivery_country' => $order->delivery['country']['title'], 'delivery_country_iso_code_2' => $order->delivery['country']['iso_code_2'], 'delivery_address_format_id' => $order->delivery['format_id'], 'billing_name' => $order->billing['firstname'].' '.$order->billing['lastname'], 'billing_firstname' => $order->billing['firstname'], 'billing_lastname' => $order->billing['lastname'], 'billing_company' => $order->billing['company'], 'billing_street_address' => $order->billing['street_address'], 'billing_suburb' => $order->billing['suburb'], 'billing_city' => $order->billing['city'], 'billing_postcode' => $order->billing['postcode'], 'billing_state' => $order->billing['state'], 'billing_country' => $order->billing['country']['title'], 'billing_country_iso_code_2' => $order->billing['country']['iso_code_2'], 'billing_address_format_id' => $order->billing['format_id'], 'payment_method' => $order->info['payment_method'], 'payment_class' => $order->info['payment_class'], 'shipping_method' => $order->info['shipping_method'], 'shipping_class' => $order->info['shipping_class'], 'cc_type' => $order->info['cc_type'], 'cc_owner' => $order->info['cc_owner'], 'cc_number' => $order->info['cc_number'], 'cc_expires' => $order->info['cc_expires'], 'cc_start' => $order->info['cc_start'], 'cc_cvv' => $order->info['cc_cvv'], 'cc_issue' => $order->info['cc_issue'], 'date_purchased' => 'now()', 'orders_status' => $tmp_status, 'currency' => $order->info['currency'], 'currency_value' => $order->info['currency_value'], 'customers_ip' => $customers_ip, 'language' => $_SESSION['language'], 'comments' => $order->info['comments']);
} else {
	// free gift , no paymentaddress
	$sql_data_array = array ('customers_id' => $_SESSION['customer_id'], 'customers_name' => $order->customer['firstname'].' '.$order->customer['lastname'], 'customers_firstname' => $order->customer['firstname'], 'customers_lastname' => $order->customer['lastname'], 'customers_cid' => $order->customer['csID'], 'customers_vat_id' => $_SESSION['customer_vat_id'], 'customers_company' => $order->customer['company'], 'customers_status' => $_SESSION['customers_status']['customers_status_id'], 'customers_status_name' => $_SESSION['customers_status']['customers_status_name'], 'customers_status_image' => $_SESSION['customers_status']['customers_status_image'], 'customers_status_discount' => $discount, 'customers_street_address' => $order->customer['street_address'], 'customers_suburb' => $order->customer['suburb'], 'customers_city' => $order->customer['city'], 'customers_postcode' => $order->customer['postcode'], 'customers_state' => $order->customer['state'], 'customers_country' => $order->customer['country']['title'], 'customers_telephone' => $order->customer['telephone'], 'customers_email_address' => $order->customer['email_address'], 'customers_address_format_id' => $order->customer['format_id'], 'delivery_name' => $order->delivery['firstname'].' '.$order->delivery['lastname'], 'delivery_firstname' => $order->delivery['firstname'], 'delivery_lastname' => $order->delivery['lastname'], 'delivery_company' => $order->delivery['company'], 'delivery_street_address' => $order->delivery['street_address'], 'delivery_suburb' => $order->delivery['suburb'], 'delivery_city' => $order->delivery['city'], 'delivery_postcode' => $order->delivery['postcode'], 'delivery_state' => $order->delivery['state'], 'delivery_country' => $order->delivery['country']['title'], 'delivery_country_iso_code_2' => $order->delivery['country']['iso_code_2'], 'delivery_address_format_id' => $order->delivery['format_id'], 'payment_method' => $order->info['payment_method'], 'payment_class' => $order->info['payment_class'], 'shipping_method' => $order->info['shipping_method'], 'shipping_class' => $order->info['shipping_class'], 'cc_type' => $order->info['cc_type'], 'cc_owner' => $order->info['cc_owner'], 'cc_number' => $order->info['cc_number'], 'cc_expires' => $order->info['cc_expires'], 'date_purchased' => 'now()', 'orders_status' => $tmp_status, 'currency' => $order->info['currency'], 'currency_value' => $order->info['currency_value'], 'customers_ip' => $customers_ip, 'comments' => $order->info['comments'], 'language' => $_SESSION['language']);
}

xtc_db_perform(TABLE_ORDERS, $sql_data_array);
$insert_id = xtc_db_insert_id();
$_SESSION['tmp_oID'] = $insert_id;
for ($i = 0, $n = sizeof($order_totals); $i < $n; $i ++) {
	$sql_data_array = array ('orders_id' => $insert_id, 'title' => $order_totals[$i]['title'], 'text' => $order_totals[$i]['text'], 'value' => $order_totals[$i]['value'], 'class' => $order_totals[$i]['code'], 'sort_order' => $order_totals[$i]['sort_order']);
	xtc_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);
}

/* magnalister v1.0.1 */
if (function_exists('magnaExecute')) magnaExecute('magnaInsertOrderDetails', array('oID' => $insert_id), array('order_details.php'));
if (function_exists('magnaExecute')) magnaExecute('magnaInventoryUpdate', array('action' => 'inventoryUpdateOrder'), array('inventoryUpdate.php'));
/* END magnalister */

$customer_notification = (SEND_EMAILS == 'true') ? '1' : '0';
$sql_data_array = array ('orders_id' => $insert_id, 'orders_status_id' => $order->info['order_status'], 'date_added' => 'now()', 'customer_notified' => $customer_notification, 'comments' => $order->info['comments']);
xtc_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);

// initialized for the email confirmation
$products_ordered = '';
$products_ordered_html = '';   
$subtotal = 0;
$total_tax = 0;

// BOF GM_MOD products_shippingtime:
require_once(DIR_FS_CATALOG . 'gm/inc/set_shipping_status.php');


for ($i = 0, $n = sizeof($order->products); $i < $n; $i ++) {
    // check if combis exists
    $t_combis_id = $coo_properties->extract_combis_id($order->products[$i]['id']);
    
	// Stock Update - Joao Correia
	if (STOCK_LIMITED == 'true') {
		if (DOWNLOAD_ENABLED == 'true') {
			// BOF GM_MOD:
			$stock_query_raw = "SELECT p.products_quantity, pad.products_attributes_filename
						                            FROM ".TABLE_PRODUCTS." p
						                            LEFT JOIN ".TABLE_PRODUCTS_ATTRIBUTES." pa
						                             ON p.products_id=pa.products_id
						                            LEFT JOIN ".TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD." pad
						                             ON pa.products_attributes_id=pad.products_attributes_id
						                            WHERE p.products_id = '".xtc_get_prid($order->products[$i]['id'])."'";
			// Will work with only one option for downloadable products
			// otherwise, we have to build the query dynamically with a loop
			$products_attributes = $order->products[$i]['attributes'];
			if (is_array($products_attributes)) {
				$stock_query_raw = "SELECT p.products_quantity, pad.products_attributes_filename
						                            FROM ".TABLE_PRODUCTS." p
						                            LEFT JOIN ".TABLE_PRODUCTS_ATTRIBUTES." pa
						                             ON (p.products_id=pa.products_id AND pa.options_id = '".(int)$products_attributes[0]['option_id']."' AND pa.options_values_id = '".(int)$products_attributes[0]['value_id']."')
						                            LEFT JOIN ".TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD." pad
						                             ON pa.products_attributes_id=pad.products_attributes_id
						                            WHERE p.products_id = '".xtc_get_prid($order->products[$i]['id'])."'";
			}
			$stock_query = xtc_db_query($stock_query_raw, "db_link", false);
		} else {
			$stock_query = xtc_db_query("select products_quantity from ".TABLE_PRODUCTS." where products_id = '".xtc_get_prid($order->products[$i]['id'])."'", "db_link", false);
		}
		if (xtc_db_num_rows($stock_query) > 0) {
            if(empty($t_combis_id) == false){
                $coo_combis_admin_control = MainFactory::create_object("PropertiesCombisAdminControl");
                $t_use_combis_quantity = $coo_combis_admin_control->get_use_properties_combis_quantity(xtc_get_prid($order->products[$i]['id']));
            }else{
                $t_use_combis_quantity = 0;
            }
            
			$stock_values = xtc_db_fetch_array($stock_query);
			// do not decrement quantities if products_attributes_filename exists         
            if(!$stock_values['products_attributes_filename'] && ((empty($t_combis_id) && STOCK_CHECK == 'true') || (!empty($t_combis_id) && (($t_use_combis_quantity == 0 && STOCK_CHECK == 'true') || $t_use_combis_quantity == 1)))){
                $stock_left = $stock_values['products_quantity'] - $order->products[$i]['qty'];
            }else{
                $stock_left = $stock_values['products_quantity'];
            }
            
			xtc_db_query("update ".TABLE_PRODUCTS." set products_quantity = '".$stock_left."' where products_id = '".xtc_get_prid($order->products[$i]['id'])."'");
			// BOF GM_MOD:
			if (($stock_left < 1) && (STOCK_ALLOW_CHECKOUT == 'false') && GM_SET_OUT_OF_STOCK_PRODUCTS == 'true') {
				xtc_db_query("update ".TABLE_PRODUCTS." set products_status = '0' where products_id = '".xtc_get_prid($order->products[$i]['id'])."'");
			}

			// BOF GM_MOD products_shippingtime:
			set_shipping_status($order->products[$i]['id']);

			// BOF GM_MOD stock_notifier
			if($stock_left <= STOCK_REORDER_LEVEL) {
				$gm_get_products_name = xtc_db_query("SELECT products_name
																							FROM products_description
																							WHERE
																								products_id = '" . xtc_get_prid($order->products[$i]['id']) . "'
																								AND language_id = '" . $_SESSION['languages_id'] . "'");
				$gm_stock_data = mysql_fetch_array($gm_get_products_name);

				$gm_subject = GM_OUT_OF_STOCK_NOTIFY_TEXT .' '. $gm_stock_data['products_name'];
				$gm_body 		= GM_OUT_OF_STOCK_NOTIFY_TEXT .': ' . (double)$stock_left . "\n\n".
											HTTP_SERVER.DIR_WS_CATALOG . 'product_info.php?info=p' . xtc_get_prid($order->products[$i]['id']);

				// send mail
				xtc_php_mail(STORE_OWNER_EMAIL_ADDRESS, STORE_NAME, STORE_OWNER_EMAIL_ADDRESS, STORE_NAME, '', STORE_OWNER_EMAIL_ADDRESS, STORE_NAME, '', '', $gm_subject, nl2br(htmlentities_wrapper($gm_body)), $gm_body);
			}
			// EOF GM_MOD stock_notifier

		}
	}

	// Update products_ordered (for bestsellers list)
	// BOF GM_MOD:
	xtc_db_query("update ".TABLE_PRODUCTS." set products_ordered = products_ordered + ".(double)$order->products[$i]['qty']." where products_id = '".xtc_get_prid($order->products[$i]['id'])."'");

	$sql_data_array = array ('orders_id' => $insert_id, 'products_id' => xtc_get_prid($order->products[$i]['id']), 'products_model' => $order->products[$i]['model'], 'products_name' => $order->products[$i]['name'],'products_shipping_time'=>$order->products[$i]['shipping_time'], 'products_price' => $order->products[$i]['price'], 'final_price' => $order->products[$i]['final_price'], 'products_tax' => $order->products[$i]['tax'], 'products_discount_made' => $order->products[$i]['discount_allowed'], 'products_quantity' => $order->products[$i]['qty'], 'allow_tax' => $_SESSION['customers_status']['customers_status_show_price_tax']);

	xtc_db_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array);
	$order_products_id = xtc_db_insert_id();

	// BOF GM_MOD GX-Customizer:
	include(DIR_FS_CATALOG . 'gm/modules/gm_gprint_checkout.php');

	if(!empty($order->products[$i]['quantity_unit_id']))
	{
		xtc_db_query("INSERT INTO orders_products_quantity_units
						SET orders_products_id = '" . (int)$order_products_id . "',
							quantity_unit_id = '" . (int)$order->products[$i]['quantity_unit_id'] . "',
							unit_name = '" . xtc_db_input($order->products[$i]['unit_name']) . "'");
	}

	# save selected properties_combi in product

	if(is_object($GLOBALS['coo_debugger'])) $GLOBALS['coo_debugger']->log('checkout_process: $order->products[$i][id] '. $order->products[$i]['id'], 'Properties');
	if(is_object($GLOBALS['coo_debugger'])) $GLOBALS['coo_debugger']->log('checkout_process: extract_combis_id '. $t_combis_id, 'Properties');

    
    if(empty($t_combis_id) == false)
    {       
		$coo_properties->add_properties_combi_to_orders_product($t_combis_id, $order_products_id);
		# GM_MOD: ratscheu-fix
		# update properties_combi quantity
        if(($t_use_combis_quantity == 0 && STOCK_CHECK == 'true' && ATTRIBUTES_STOCK_CHECK == 'true') || $t_use_combis_quantity == 2){
            $t_quantity_change = $order->products[$i]['qty'] * -1;
            $val = $coo_properties->change_combis_quantity($t_combis_id, $t_quantity_change);
        }
		#echo 'c:'.$t_quantity_change.',v:'.$val;
	}






	// Aenderung Specials Quantity Anfang
	$specials_result = xtc_db_query("SELECT products_id, specials_quantity from ".TABLE_SPECIALS." WHERE products_id = '".xtc_get_prid($order->products[$i]['id'])."' ");
	if (xtc_db_num_rows($specials_result)) {
		$spq = xtc_db_fetch_array($specials_result);

		$new_sp_quantity = ($spq['specials_quantity'] - $order->products[$i]['qty']);

		if ($new_sp_quantity >= 1) {
			xtc_db_query("update ".TABLE_SPECIALS." set specials_quantity = '".$new_sp_quantity."' where products_id = '".xtc_get_prid($order->products[$i]['id'])."' ");
		} elseif(STOCK_CHECK == 'true') { // BOF GM_MOD:
			xtc_db_query("update ".TABLE_SPECIALS." set status = '0', specials_quantity = '".$new_sp_quantity."' where products_id = '".xtc_get_prid($order->products[$i]['id'])."' ");
		}
	}
	// Aenderung Ende

	$order_total_modules->update_credit_account($i); // GV Code ICW ADDED FOR CREDIT CLASS SYSTEM
	//------insert customer choosen option to order--------
	$attributes_exist = '0';
	$products_ordered_attributes = '';
	if (isset ($order->products[$i]['attributes'])) {
		$attributes_exist = '1';
		for ($j = 0, $n2 = sizeof($order->products[$i]['attributes']); $j < $n2; $j ++) {
			if (DOWNLOAD_ENABLED == 'true') {
				$attributes_query = "select popt.products_options_name,
								                               poval.products_options_values_name,
								                               pa.options_values_price,
								                               pa.price_prefix,
								                               pad.products_attributes_maxdays,
								                               pad.products_attributes_maxcount,
								                               pad.products_attributes_filename
								                               from ".TABLE_PRODUCTS_OPTIONS." popt, ".TABLE_PRODUCTS_OPTIONS_VALUES." poval, ".TABLE_PRODUCTS_ATTRIBUTES." pa
								                               left join ".TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD." pad
								                                on pa.products_attributes_id=pad.products_attributes_id
								                               where pa.products_id = '".$order->products[$i]['id']."'
								                                and pa.options_id = '".$order->products[$i]['attributes'][$j]['option_id']."'
								                                and pa.options_id = popt.products_options_id
								                                and pa.options_values_id = '".$order->products[$i]['attributes'][$j]['value_id']."'
								                                and pa.options_values_id = poval.products_options_values_id
								                                and popt.language_id = '".$_SESSION['languages_id']."'
								                                and poval.language_id = '".$_SESSION['languages_id']."'";
				$attributes = xtc_db_query($attributes_query);
			} else {
				$attributes = xtc_db_query("select popt.products_options_name,
								                                             poval.products_options_values_name,
								                                             pa.options_values_price,
								                                             pa.price_prefix
								                                             from ".TABLE_PRODUCTS_OPTIONS." popt, ".TABLE_PRODUCTS_OPTIONS_VALUES." poval, ".TABLE_PRODUCTS_ATTRIBUTES." pa
								                                             where pa.products_id = '".$order->products[$i]['id']."'
								                                             and pa.options_id = '".$order->products[$i]['attributes'][$j]['option_id']."'
								                                             and pa.options_id = popt.products_options_id
								                                             and pa.options_values_id = '".$order->products[$i]['attributes'][$j]['value_id']."'
								                                             and pa.options_values_id = poval.products_options_values_id
								                                             and popt.language_id = '".$_SESSION['languages_id']."'
								                                             and poval.language_id = '".$_SESSION['languages_id']."'");
			}
			// update attribute stock
			xtc_db_query("UPDATE ".TABLE_PRODUCTS_ATTRIBUTES." set
						                               attributes_stock=attributes_stock - '".$order->products[$i]['qty']."'
						                               where
						                               products_id='".$order->products[$i]['id']."'
						                               and options_values_id='".$order->products[$i]['attributes'][$j]['value_id']."'
						                               and options_id='".$order->products[$i]['attributes'][$j]['option_id']."'
						                               ");

			$attributes_values = xtc_db_fetch_array($attributes);

			$sql_data_array = array ('orders_id' => $insert_id, 'orders_products_id' => $order_products_id, 'products_options' => $attributes_values['products_options_name'], 'products_options_values' => $attributes_values['products_options_values_name'], 'options_values_price' => $attributes_values['options_values_price'], 'price_prefix' => $attributes_values['price_prefix']);
			xtc_db_perform(TABLE_ORDERS_PRODUCTS_ATTRIBUTES, $sql_data_array);

			if ((DOWNLOAD_ENABLED == 'true') && isset ($attributes_values['products_attributes_filename']) && xtc_not_null($attributes_values['products_attributes_filename'])) {
				$sql_data_array = array ('orders_id' => $insert_id, 'orders_products_id' => $order_products_id, 'orders_products_filename' => $attributes_values['products_attributes_filename'], 'download_maxdays' => $attributes_values['products_attributes_maxdays'], 'download_count' => $attributes_values['products_attributes_maxcount']);
				xtc_db_perform(TABLE_ORDERS_PRODUCTS_DOWNLOAD, $sql_data_array);
			}

			// BOF GM_MOD attributes stock_notifier
			// Avenger
			if (ATTRIBUTE_STOCK_CHECK == 'true')
			{
				$gm_get_attributes_stock = xtc_db_query("SELECT
																										pd.products_name,
																										pa.attributes_stock,
																										po.products_options_name,
																										pov.products_options_values_name
																									FROM
																										products_description pd,
																										products_attributes pa,
																										products_options po,
																										products_options_values pov
																									WHERE pa.products_id = '" . $order->products[$i]['id'] . "'
																	AND pa.options_values_id = '" . $order->products[$i]['attributes'][$j]['value_id'] . "'
																	AND pa.options_id = '" . $order->products[$i]['attributes'][$j]['option_id'] . "'
																									AND po.products_options_id = '" . $order->products[$i]['attributes'][$j]['option_id'] . "'
																									AND po.language_id = '" . $_SESSION['languages_id'] . "'
																									AND pov.products_options_values_id = '" . $order->products[$i]['attributes'][$j]['value_id'] . "'
																									AND pov.language_id = '" . $_SESSION['languages_id'] . "'
																									AND pd.products_id = '" . $order->products[$i]['id'] . "'
																									AND pd.language_id = '" . $_SESSION['languages_id'] . "'");
				if(xtc_db_num_rows($gm_get_attributes_stock) == 1){
					$gm_attributes_stock_data = xtc_db_fetch_array($gm_get_attributes_stock);

					if($gm_attributes_stock_data['attributes_stock'] <= STOCK_REORDER_LEVEL) {
						$gm_subject = GM_OUT_OF_STOCK_NOTIFY_TEXT .' '. $gm_attributes_stock_data['products_name'] . ' - ' . $gm_attributes_stock_data['products_options_name'] . ': ' . $gm_attributes_stock_data['products_options_values_name'];
						$gm_body 		= GM_OUT_OF_STOCK_NOTIFY_TEXT .': ' . (double)$gm_attributes_stock_data['attributes_stock'] .' ('. $gm_attributes_stock_data['products_name'] . ' - ' . $gm_attributes_stock_data['products_options_name'] . ': ' . $gm_attributes_stock_data['products_options_values_name'] . ")\n\n".
													HTTP_SERVER.DIR_WS_CATALOG . 'product_info.php?info=p' . xtc_get_prid($order->products[$i]['id']);

						xtc_php_mail(STORE_OWNER_EMAIL_ADDRESS, STORE_NAME, STORE_OWNER_EMAIL_ADDRESS, STORE_NAME, '', STORE_OWNER_EMAIL_ADDRESS, STORE_NAME, '', '', $gm_subject, nl2br(htmlentities_wrapper($gm_body)), $gm_body);
					}
				}
			}
			// Avenger
			// EOF GM_MOD attributes stock_notifier

		}
	}
	//------insert customer choosen option eof ----
	$total_weight += ($order->products[$i]['qty'] * $order->products[$i]['weight']);
	$total_tax += xtc_calculate_tax($total_products_price, $products_tax) * $order->products[$i]['qty'];
	$total_cost += $total_products_price;

}

if (isset ($_SESSION['tracking']['refID'])) {

	xtc_db_query("update ".TABLE_ORDERS." set
	                                 refferers_id = '".$_SESSION['tracking']['refID']."'
	                                 where orders_id = '".$insert_id."'");

	// check if late or direct sale
	$customers_logon_query = "SELECT customers_info_number_of_logons
				                            FROM ".TABLE_CUSTOMERS_INFO."
				                            WHERE customers_info_id  = '".$_SESSION['customer_id']."'";
	$customers_logon_query = xtc_db_query($customers_logon_query);
	$customers_logon = xtc_db_fetch_array($customers_logon_query);

	if ($customers_logon['customers_info_number_of_logons'] == 0) {
		// direct sale
		xtc_db_query("update ".TABLE_ORDERS." set
		                                 conversion_type = '1'
		                                 where orders_id = '".$insert_id."'");
	} else {
		// late sale

		xtc_db_query("update ".TABLE_ORDERS." set
		                                 conversion_type = '2'
		                                 where orders_id = '".$insert_id."'");
	}

} else {

	$customers_query = xtc_db_query("SELECT refferers_id as ref FROM ".TABLE_CUSTOMERS." WHERE customers_id='".$_SESSION['customer_id']."'");
	$customers_data = xtc_db_fetch_array($customers_query);
	if (xtc_db_num_rows($customers_query)) {

		xtc_db_query("update ".TABLE_ORDERS." set
		                                 refferers_id = '".$customers_data['ref']."'
		                                 where orders_id = '".$insert_id."'");
		// check if late or direct sale
		$customers_logon_query = "SELECT customers_info_number_of_logons
					                            FROM ".TABLE_CUSTOMERS_INFO."
					                            WHERE customers_info_id  = '".$_SESSION['customer_id']."'";
		$customers_logon_query = xtc_db_query($customers_logon_query);
		$customers_logon = xtc_db_fetch_array($customers_logon_query);

		if ($customers_logon['customers_info_number_of_logons'] == 0) {
			// direct sale
			xtc_db_query("update ".TABLE_ORDERS." set
			                                 conversion_type = '1'
			                                 where orders_id = '".$insert_id."'");
		} else {
			// late sale

			xtc_db_query("update ".TABLE_ORDERS." set
			                                 conversion_type = '2'
			                                 where orders_id = '".$insert_id."'");
		}
	}

}

	// redirect to payment service
	if ($tmp)
		$payment_modules->payment_action();
		// PayPal  EXPRESS ERROR Check
		if(isset($_SESSION['reshash']['ACK']) && $_SESSION['reshash']['ACK']!="Success"){
			xtc_redirect($o_paypal->EXPRESS_CANCEL_URL);
		}
}

if (!$tmp) {

	// NEW EMAIL configuration !
	$order_totals = $order_total_modules->apply_credit();
	// BOF GM_MOD HEIDELPAY E-MAIL
	if(strpos($payment_modules->selected_module, 'hp') === false){
	include ('send_order.php');
	}
	// EOF GM_MOD HEIDELPAY E-MAIL

	// load the after_process function from the payment modules
	$payment_modules->after_process();

		// PayPal  EXPRESS ERROR Check
		if(isset($_SESSION['reshash']['ACK']) && $_SESSION['reshash']['ACK']!="Success"){
			xtc_redirect($o_paypal->EXPRESS_CANCEL_URL);
		}
		//print_r($_SESSION['reshash']);
		//die();

		$pp_REDIRECTREQUIRED 	= $_SESSION['reshash']['REDIRECTREQUIRED'];
		$pp_TOKEN 						= $_SESSION['reshash']['TOKEN'];

	$_SESSION['cart']->reset(true);

	// unregister session variables used during checkout
	unset ($_SESSION['sendto']);
	unset ($_SESSION['billto']);
	unset ($_SESSION['shipping']);
	unset ($_SESSION['payment']);
	unset ($_SESSION['comments']);
	unset ($_SESSION['last_order']);
	unset ($_SESSION['tmp_oID']);
	unset ($_SESSION['cc']);
	unset($_SESSION['nvpReqArray']);
	unset($_SESSION['reshash']);
	$last_order = $insert_id;
	//GV Code Start
	if (isset ($_SESSION['credit_covers']))
		unset ($_SESSION['credit_covers']);
	$order_total_modules->clear_posts(); //ICW ADDED FOR CREDIT CLASS SYSTEM
	// GV Code End
	
	// BOF GM_MOD GX-Customizer:
	require(DIR_FS_CATALOG . 'gm/modules/gm_gprint_checkout_process.php');
	
	//GM_MOD:
  	if($pp_REDIRECTREQUIRED == 'true') {
 		xtc_redirect('https://www.paypal.com/webscr?cmd=_complete-express-checkout&token='.$pp_TOKEN);
 	}

	if(@isset($_SESSION['xtb0']))
	{
		define('XTB_CHECKOUT_PROCESS', __LINE__);
		require 'xtbcallback.php';
	}

	xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_SUCCESS, '', 'SSL'));

}
?>