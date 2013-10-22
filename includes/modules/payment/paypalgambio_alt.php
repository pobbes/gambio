<?php
/* --------------------------------------------------------------
   paypal_gambio.php 2009-07-02 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2009 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(paypal.php,v 1.39 2003/01/29); www.oscommerce.com
   (c) 2003	 nextcommerce (paypal.php,v 1.8 2003/08/24); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: paypal.php 998 2005-07-07 14:18:20Z mz $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class paypalgambio_alt_ORIGIN {
	var $code, $title, $description, $enabled;

	function paypalgambio_alt_ORIGIN() {
		global $order;

		$this->code = 'paypalgambio_alt';
		$this->title = MODULE_PAYMENT_PAYPALGAMBIO_ALT_TEXT_TITLE;
		$this->description = '<h2>PayPal (ALT)</h2>';
		$this->sort_order = MODULE_PAYMENT_PAYPALGAMBIO_ALT_SORT_ORDER;
		$this->enabled = ((MODULE_PAYMENT_PAYPALGAMBIO_ALT_STATUS == 'True') ? true : false);
		$this->info = MODULE_PAYMENT_PAYPALGAMBIO_ALT_TEXT_INFO;
		if ((int) MODULE_PAYMENT_PAYPALGAMBIO_ALT_ORDER_STATUS_ID > 0) {
			$this->order_status = MODULE_PAYMENT_PAYPALGAMBIO_ALT_ORDER_STATUS_ID;
		}

		if (is_object($order))
			$this->update_status();
	}

	function update_status() {
		global $order;

		if (($this->enabled == true) && ((int) MODULE_PAYMENT_PAYPALGAMBIO_ALT_ZONE > 0)) {
			$check_flag = false;
			$check_query = xtc_db_query("select zone_id from ".TABLE_ZONES_TO_GEO_ZONES." where geo_zone_id = '".MODULE_PAYMENT_PAYPALGAMBIO_ALT_ZONE."' and zone_country_id = '".$order->billing['country']['id']."' order by zone_id");
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
		global $order, $xtPrice;

		if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
			$_SESSION['nc_paypal_amount'] = $order->info['total'] + $order->info['tax'];
		} else {
			$_SESSION['nc_paypal_amount'] = $order->info['total'];
		}
		
		return false;
	}

	function before_process() {
		return false;
	}

	function after_process() {
		global $order, $xtPrice, $insert_id;

		if (MODULE_PAYMENT_PAYPALGAMBIO_ALT_CURRENCY == 'Selected Currency') {
			$my_currency = $_SESSION['currency'];
		} else {
			$my_currency = substr(MODULE_PAYMENT_PAYPALGAMBIO_ALT_CURRENCY, 5);
		}
		if (!in_array($my_currency, array ('CAD', 'EUR', 'GBP', 'JPY', 'USD', 'CHF'))) {
			$my_currency = 'EUR';
		}

		$total = $_SESSION['nc_paypal_amount'];

		if ($_SESSION['currency'] == $my_currency) {
			$amount = round($total, $xtPrice->get_decimal_places($my_currency));
			$shipping = round($order->info['shipping_cost'], $xtPrice->get_decimal_places($my_currency));
		} else {
			$amount = round($xtPrice->xtcCalculateCurrEx($total, $my_currency), $xtPrice->get_decimal_places($my_currency));
			$shipping = round($xtPrice->xtcCalculateCurrEx($order->info['shipping_cost'], $my_currency), $xtPrice->get_decimal_places($my_currency));
		}

		$shipping = "$shipping";

		$process_button_string  = 'Sie werden automatisch zu PayPal weitergeleitet. Bitte warten...';
		$process_button_string .= xtc_draw_form('paypal_form', 'https://www.paypal.com/cgi-bin/webscr', 'post');
		$process_button_string .= xtc_draw_hidden_field('cmd', '_xclick').
															xtc_draw_hidden_field('business', MODULE_PAYMENT_PAYPALGAMBIO_ALT_ID).
															xtc_draw_hidden_field('item_name', STORE_NAME . ' (' . $_SESSION['tmp_oID'] . ')').
															xtc_draw_hidden_field('amount', $amount - $shipping).
															xtc_draw_hidden_field('shipping', $shipping).
															xtc_draw_hidden_field('currency_code', $my_currency).
															xtc_draw_hidden_field('return', xtc_href_link(FILENAME_CHECKOUT_SUCCESS, '', 'SSL')).
															xtc_draw_hidden_field('cancel_return', xtc_href_link(FILENAME_CHECKOUT_SUCCESS, '', 'SSL')
														);
		$process_button_string .= '</form>';
		$process_button_string .= '<script language="JavaScript">document.getElementById("paypal_form").submit();</script>';


		if ($this->order_status)
			xtc_db_query("UPDATE ".TABLE_ORDERS." SET orders_status='".$this->order_status."' WHERE orders_id='".$insert_id."'");

		$_SESSION['nc_checkout_success_info'] = $process_button_string;
	}

	function output_error() {
		return false;
	}

	function check() {
		if (!isset ($this->_check)) {
			$check_query = xtc_db_query("select configuration_value from ".TABLE_CONFIGURATION." where configuration_key = 'MODULE_PAYMENT_PAYPALGAMBIO_ALT_STATUS'");
			$this->_check = xtc_db_num_rows($check_query);
		}
		return $this->_check;
	}

	function install() {
		xtc_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_PAYPALGAMBIO_ALT_STATUS', 'True', '6', '3', 'gm_cfg_select_option(array(\'True\', \'False\'), ', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_PAYPALGAMBIO_ALT_ALLOWED', '', '6', '0', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_PAYPALGAMBIO_ALT_ID', 'you@yourbusiness.com',  '6', '4', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_PAYPALGAMBIO_ALT_CURRENCY', 'Selected Currency',  '6', '6', 'xtc_cfg_select_option(array(\'Selected Currency\',\'Only USD\',\'Only CAD\',\'Only EUR\',\'Only GBP\',\'Only JPY\',\'Only CHF\'), ', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_PAYPALGAMBIO_ALT_SORT_ORDER', '0', '6', '0', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_PAYMENT_PAYPALGAMBIO_ALT_ZONE', '0', '6', '2', 'xtc_get_zone_class_title', 'xtc_cfg_pull_down_zone_classes(', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, use_function, date_added) values ('MODULE_PAYMENT_PAYPALGAMBIO_ALT_ORDER_STATUS_ID', '0',  '6', '0', 'xtc_cfg_pull_down_order_statuses(', 'xtc_get_order_status_name', now())");
	}

	function remove() {
		xtc_db_query("delete from ".TABLE_CONFIGURATION." where configuration_key in ('".implode("', '", $this->keys())."')");
	}

	function keys() {
		return array ('MODULE_PAYMENT_PAYPALGAMBIO_ALT_STATUS', 'MODULE_PAYMENT_PAYPALGAMBIO_ALT_ALLOWED', 'MODULE_PAYMENT_PAYPALGAMBIO_ALT_ID', 'MODULE_PAYMENT_PAYPALGAMBIO_ALT_CURRENCY', 'MODULE_PAYMENT_PAYPALGAMBIO_ALT_ZONE', 'MODULE_PAYMENT_PAYPALGAMBIO_ALT_ORDER_STATUS_ID', 'MODULE_PAYMENT_PAYPALGAMBIO_ALT_SORT_ORDER');
	}
}

MainFactory::load_origin_class('paypalgambio_alt');
?>