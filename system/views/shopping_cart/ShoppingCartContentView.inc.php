<?php
/* --------------------------------------------------------------
   ShoppingCartContentView.inc.php 2012-06-26 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(best_sellers.php,v 1.20 2003/02/10); www.oscommerce.com 
   (c) 2003	 nextcommerce (best_sellers.php,v 1.10 2003/08/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: best_sellers.php 1292 2005-10-07 16:10:55Z mz $)

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   Enable_Disable_Categories 1.3        	Autor: Mikel Williams | mikel@ladykatcostumes.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

// include needed functions
require_once (DIR_FS_INC.'xtc_array_to_string.inc.php');
require_once (DIR_FS_INC.'xtc_image_submit.inc.php');
require_once (DIR_FS_INC.'xtc_recalculate_price.inc.php');



class ShoppingCartContentView extends ContentView
{
	function ShoppingCartContentView()
	{
		$this->set_content_template('module/shopping_cart.html');
		$this->set_flat_assigns(true);
	}
	
	function get_html($p_coo_paypal_checkout)
	{
		$xtPrice = new xtcPrice($_SESSION['currency'], $_SESSION['customers_status']['customers_status_id']);

		if(gm_get_env_info('TEMPLATE_VERSION') < FIRST_GX2_TEMPLATE_VERSION || $_SESSION['cart']->count_contents() == 0)
		{
			$coo_gift_cart = MainFactory::create_object('GiftCartContentView');
			$t_view_html = $coo_gift_cart->get_html();
			$this->set_content_data('MODULE_gift_cart', $t_view_html);
		}

		if ($_SESSION['cart']->count_contents() > 0) {

			// BOF GM_MOD
			// Paypal Error Messages:
			if($_GET['gm_paypal_error'] == '2') {
				$p_errorcode = $_SESSION['reshash']['L_ERRORCODE0'];
				if(defined('GM_PAYPAL_ERROR_'.$p_errorcode)) {
					$t_paypal_error = constant('GM_PAYPAL_ERROR_'.$p_errorcode);
				} else {
					$t_paypal_error = GM_PAYPAL_ERROR;
				}
				$this->set_content_data('paypal_error', $t_paypal_error);
				require_once(DIR_WS_CLASSES.'paypal_checkout.php');
				if(!empty($_SESSION['tmp_oID']))
				{
					$o_paypal = new paypal_checkout();
					$o_paypal->logging_status($_SESSION['tmp_oID']);
				}
			} elseif($_GET['gm_paypal_error'] == '3') {
				$t_paypal_error = GM_PAYPAL_SESSION_ERROR;
				$this->set_content_data('paypal_error', $t_paypal_error);
			} elseif($_GET['gm_paypal_error'] == '4') {
				$t_paypal_error = GM_PAYPAL_UNALLOWED_COUNTRY_ERROR;
				$this->set_content_data('paypal_error', $t_paypal_error);
			}
			// EOF GM_MOD

			unset($_SESSION['paypal_express_checkout']);

			$this->set_content_data('FORM_ACTION', xtc_draw_form('cart_quantity', xtc_href_link(FILENAME_SHOPPING_CART, 'action=update_product', 'NONSSL', true, true, true)));
			$this->set_content_data('FORM_END', '</form>');
			$hidden_options = '';
			$_SESSION['any_out_of_stock'] = 0;

			$products = $_SESSION['cart']->get_products();

			for ($i = 0, $n = sizeof($products); $i < $n; $i ++) {
				/* bof gm weight*/
				$products[$i]['gm_weight'] = $products[$i]['weight'];
				/* eof gm weight */

				// Push all attributes information in an array
				if (isset ($products[$i]['attributes'])) {
					while (list ($option, $value) = each($products[$i]['attributes'])) {
						$hidden_options .= xtc_draw_hidden_field('id['.$products[$i]['id'].']['.$option.']', $value);
						$attributes = xtc_db_query("select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix,pa.attributes_stock,pa.products_attributes_id,pa.attributes_model,pa.weight_prefix,pa.options_values_weight
															  from ".TABLE_PRODUCTS_OPTIONS." popt, ".TABLE_PRODUCTS_OPTIONS_VALUES." poval, ".TABLE_PRODUCTS_ATTRIBUTES." pa
															  where pa.products_id = '".(int)$products[$i]['id']."'
															   and pa.options_id = '".(int)$option."'
															   and pa.options_id = popt.products_options_id
															   and pa.options_values_id = '".(int)$value."'
															   and pa.options_values_id = poval.products_options_values_id
															   and popt.language_id = '".(int) $_SESSION['languages_id']."'
															   and poval.language_id = '".(int) $_SESSION['languages_id']."'");
						$attributes_values = xtc_db_fetch_array($attributes);

						$products[$i][$option]['products_options_name'] = $attributes_values['products_options_name'];
						$products[$i][$option]['options_values_id'] = (int)$value;
						$products[$i][$option]['products_options_values_name'] = $attributes_values['products_options_values_name'];
						$products[$i][$option]['options_values_price'] = $attributes_values['options_values_price'];
						$products[$i][$option]['price_prefix'] = $attributes_values['price_prefix'];
						$products[$i][$option]['weight_prefix'] = $attributes_values['weight_prefix'];
						$products[$i][$option]['options_values_weight'] = $attributes_values['options_values_weight'];
						$products[$i][$option]['attributes_stock'] = $attributes_values['attributes_stock'];
						$products[$i][$option]['products_attributes_id'] = $attributes_values['products_attributes_id'];
						$products[$i][$option]['products_attributes_model'] = $attributes_values['products_attributes_model'];

						/* bof gm weight*/
						if($attributes_values['weight_prefix'] == '-') {
							$products[$i]['gm_weight'] -= $attributes_values['options_values_weight'];
						} else {
							$products[$i]['gm_weight'] += $products[$i][$option]['options_values_weight'];
						}
						/* eof gm weight*/
					}
				}
			}

			$this->set_content_data('HIDDEN_OPTIONS', $hidden_options);

			# order details
			$coo_order_details_cart = MainFactory::create_object('OrderDetailsCartContentView');
			$t_view_html = $coo_order_details_cart->get_html($products);
			$this->set_content_data('MODULE_order_details', $t_view_html);

			$_SESSION['allow_checkout'] = 'true';
			if (STOCK_CHECK == 'true') {
				if ($_SESSION['any_out_of_stock'] == 1) {
					if (STOCK_ALLOW_CHECKOUT == 'true') {
						// write permission in session
						$_SESSION['allow_checkout'] = 'true';
						$this->set_content_data('info_message', OUT_OF_STOCK_CAN_CHECKOUT);
					} else {
						$_SESSION['allow_checkout'] = 'false';
						$this->set_content_data('info_message', OUT_OF_STOCK_CANT_CHECKOUT);
					}
				} else {
					$_SESSION['allow_checkout'] = 'true';
				}
			}

			// Paypal Error Messages:

			if(isset($_SESSION['reshash']['FORMATED_ERRORS'])){
				$this->set_content_data('error', $_SESSION['reshash']['FORMATED_ERRORS']);
			}

			// minimum/maximum order value
			$checkout = true;
			if ($_SESSION['cart']->show_total() > 0 ) {
				if ($_SESSION['cart']->show_total() < $_SESSION['customers_status']['customers_status_min_order'] ) {
					$_SESSION['allow_checkout'] = 'false';
					$more_to_buy = $_SESSION['customers_status']['customers_status_min_order'] - $_SESSION['cart']->show_total();
					$order_amount=$xtPrice->xtcFormat($more_to_buy, true);
					$min_order=$xtPrice->xtcFormat($_SESSION['customers_status']['customers_status_min_order'], true);
					$this->set_content_data('info_message_1', MINIMUM_ORDER_VALUE_NOT_REACHED_1);
					$this->set_content_data('info_message_2', MINIMUM_ORDER_VALUE_NOT_REACHED_2);
					$this->set_content_data('order_amount', $order_amount);
					$this->set_content_data('min_order', $min_order);
				}
				if  ($_SESSION['customers_status']['customers_status_max_order'] != 0) {
					if ($_SESSION['cart']->show_total() > $_SESSION['customers_status']['customers_status_max_order'] ) {
					$_SESSION['allow_checkout'] = 'false';
					$less_to_buy = $_SESSION['cart']->show_total() - $_SESSION['customers_status']['customers_status_max_order'];
					$max_order=$xtPrice->xtcFormat($_SESSION['customers_status']['customers_status_max_order'], true);
					$order_amount=$xtPrice->xtcFormat($less_to_buy, true);
					$this->set_content_data('info_message_1', MAXIMUM_ORDER_VALUE_REACHED_1);
					$this->set_content_data('info_message_2', MAXIMUM_ORDER_VALUE_REACHED_2);
					$this->set_content_data('order_amount', $order_amount);
					$this->set_content_data('min_order', $max_order);
					}
				}
			}

			if(isset($_SESSION['info_message']))
			{
				$this->set_content_data('info_message', $_SESSION['info_message']);
				unset($_SESSION['info_message']);
			}

			// BOF GM_MOD
			if(strpos($_SESSION['customers_status']['customers_status_payment_unallowed'], 'paypalexpress') === false
					&& round($_SESSION['cart']->show_total(), 2) >= round($_SESSION['customers_status']['customers_status_min_order'], 2)
					&& ( round($_SESSION['cart']->show_total(), 2) <= round($_SESSION['customers_status']['customers_status_max_order'], 2)
						|| $_SESSION['customers_status']['customers_status_max_order'] == 0 ) )
			{
				if($_SESSION['cart']->get_content_type() === 'physical' || strpos(DOWNLOAD_UNALLOWED_PAYMENT, 'paypalexpress') === false)
				{
					$this->set_content_data('BUTTON_PAYPAL', $p_coo_paypal_checkout->build_express_checkout_button((int)$order_amount, $_SESSION['currency']));
				}
			}

			$t_button_back_url = xtc_href_link(FILENAME_DEFAULT);
			if(!empty($_SESSION['gm_history'][count($_SESSION['gm_history'])-1]['CLOSE']))
			{
				$t_button_back_url = HTTP_SERVER . $_SESSION['gm_history'][count($_SESSION['gm_history'])-1]['CLOSE'];
			}

			$this->set_content_data('BUTTON_RELOAD', xtc_image_submit('button_update_cart.gif', IMAGE_BUTTON_UPDATE_CART, 'onclick="var gm_quantity_checker = new GMOrderQuantityChecker(); return gm_quantity_checker.check_cart();"'));
			$this->set_content_data('BUTTON_BACK', '<a href="' . $t_button_back_url . '"><img src="templates/' . CURRENT_TEMPLATE . '/buttons/' . $_SESSION['language'] . '/button_back.gif" alt="' . IMAGE_BUTTON_BACK . '" title="' . IMAGE_BUTTON_BACK . '" border="0" /></a>');
			$this->set_content_data('BUTTON_BACK_URL', $t_button_back_url);
			$this->set_content_data('BUTTON_CHECKOUT', '<a id="gm_checkout" onclick="var gm_quantity_checker = new GMOrderQuantityChecker(); return gm_quantity_checker.check_cart();" href="'.xtc_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL').'">'.xtc_image_button('button_checkout.gif', IMAGE_BUTTON_CHECKOUT).'</a>');
			$this->set_content_data('LINK_CLOSE', $t_button_back_url);
			// EOF GM_MOD

		}
		else {

			// empty cart
			$cart_empty = true;
			
			if(isset($_SESSION['info_message']))
			{
				$this->set_content_data('info_message', $_SESSION['info_message']);
				unset($_SESSION['info_message']);
			}

			$t_button_back_url = xtc_href_link(FILENAME_DEFAULT);
			if(!empty($_SESSION['gm_history'][count($_SESSION['gm_history'])-1]['CLOSE']))
			{
				$t_button_back_url = HTTP_SERVER . $_SESSION['gm_history'][count($_SESSION['gm_history'])-1]['CLOSE'];
			}

			$this->set_content_data('cart_empty', $cart_empty);
						
			$this->set_content_data('FORM_ACTION', xtc_draw_form('cart_quantity', xtc_href_link(FILENAME_SHOPPING_CART, 'action=update_product', 'NONSSL', true, true, true)));
			$this->set_content_data('FORM_END', '</form>');
			
			// BOF GM_MOD:
			$this->set_content_data('BUTTON_BACK', '<a href="' . $t_button_back_url . '"><img src="templates/' . CURRENT_TEMPLATE . '/buttons/' . $_SESSION['language'] . '/button_back.gif" alt="' . IMAGE_BUTTON_BACK . '" title="' . IMAGE_BUTTON_BACK . '" border="0" /></a>');
			$this->set_content_data('BUTTON_BACK_URL', $t_button_back_url);
			$this->set_content_data('BUTTON_CONTINUE', '<a href="'.xtc_href_link(FILENAME_DEFAULT).'">'.xtc_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE).'</a>');
			$this->set_content_data('LINK_CLOSE', $t_button_back_url);
		}

		// BOF GM_MOD:
		$this->set_content_data('LIGHTBOX', gm_get_conf('GM_LIGHTBOX_CART'));
		$this->set_content_data('LIGHTBOX_CLOSE', xtc_href_link(FILENAME_DEFAULT, '', 'NONSSL'));

		$this->set_content_data('PRODUCTS_DATA', $t_products_array);
		
		$t_html_output = $this->build_html();
		return $t_html_output;
	}
	
}
?>