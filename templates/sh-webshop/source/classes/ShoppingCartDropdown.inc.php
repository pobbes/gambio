<?php
/* --------------------------------------------------------------
   ShoppingCartDropdown.inc.php 2010-12-20 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
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


class ShoppingCartDropdown extends ContentView
{
	function ShoppingCartDropdown()
	{
		$this->set_content_template('boxes/box_cart_dropdown.html');
		$this->set_caching_enabled(false);
		$this->set_flat_assigns(true);
	}
	
	function get_html()
	{
		global $PHP_SELF;
		global $xtPrice;
		global $main;

		// BOF GM_MOD
		$this->set_content_data('GM_CART_ON_TOP', gm_get_conf('GM_CART_ON_TOP'));
		// EOF GM_MOD

		if (strstr($PHP_SELF, FILENAME_CHECKOUT_PAYMENT) or strstr($PHP_SELF, FILENAME_CHECKOUT_CONFIRMATION) or strstr($PHP_SELF, FILENAME_CHECKOUT_SHIPPING))
			$this->set_content_data('deny_cart', 'true');

		if ($_SESSION['cart']->count_contents() > 0) {
			$products = $_SESSION['cart']->get_products();
			$products_in_cart = array ();
			$qty = 0;
			for ($i = 0, $n = sizeof($products); $i < $n; $i ++)
			{
				$qty += $products[$i]['quantity'];

				$t_image = '';
				if ($products[$i]['image'] != '') {
					$t_image = DIR_WS_THUMBNAIL_IMAGES.$products[$i]['image'];
				}
				$products_in_cart[] = array (
										'QTY' => gm_convert_qty($products[$i]['quantity'], false),
										'LINK' => xtc_href_link(FILENAME_PRODUCT_INFO, xtc_product_link($products[$i]['id'],$products[$i]['name'])),
										'NAME' => $products[$i]['name'],
										'IMAGE' => $t_image,
										'PRICE' => $xtPrice->xtcFormat($products[$i]['price'], true),
										'UNIT' => $products[$i]['unit_name']
									);

			}
			$this->set_content_data('PRODUCTS', $qty);
			$this->set_content_data('empty', 'false');
		} else {
			// cart empty
			$this->set_content_data('empty', 'true');
		}

		if ($_SESSION['cart']->count_contents() > 0) {

			$total =$_SESSION['cart']->show_total();
		if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == '1' && $_SESSION['customers_status']['customers_status_ot_discount'] != '0.00') {
			if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
				$price = $total-$_SESSION['cart']->show_tax(false);
			} else {
				$price = $total;
			}
			$discount = $xtPrice->xtcGetDC($price, $_SESSION['customers_status']['customers_status_ot_discount']);
			$this->set_content_data('DISCOUNT', $xtPrice->xtcFormat(($discount * (-1)), $price_special = 1, $calculate_currencies = false));

		}


		if ($_SESSION['customers_status']['customers_status_show_price'] == '1') {
			if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 0) $total-=$discount;
			if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) $total = $total - $_SESSION['cart']->show_tax(false) - $discount;
			if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 1) $total-=$discount;
			$this->set_content_data('TOTAL', $xtPrice->xtcFormat($total, true));
		}

			//GM_MOD:
			if(gm_get_conf('TAX_INFO_TAX_FREE') == 'true') {
				$gm_cart_tax_info = GM_TAX_FREE .'<br />';
			} else {
				$gm_cart_tax_info = $_SESSION['cart']->show_tax();
			}
			//GM_MOD:
			$this->set_content_data('UST', $gm_cart_tax_info);

			if (SHOW_SHIPPING=='true') {
				// BOF GM_MOD:
				$this->set_content_data('SHIPPING_INFO', $main->getShippingLink(true));
			}
		}
		if (ACTIVATE_GIFT_SYSTEM == 'true') {
			$this->set_content_data('ACTIVATE_GIFT', 'true');
		}

		// GV Code Start
		if (isset ($_SESSION['customer_id'])) {
			$gv_query = xtc_db_query("select amount from ".TABLE_COUPON_GV_CUSTOMER." where customer_id = '".$_SESSION['customer_id']."'");
			$gv_result = xtc_db_fetch_array($gv_query);
			if ($gv_result['amount'] > 0) {
				$this->set_content_data('GV_AMOUNT', $xtPrice->xtcFormat($gv_result['amount'], true, 0, true));
				$this->set_content_data('GV_SEND_TO_FRIEND_LINK', '<a href="'.xtc_href_link(FILENAME_GV_SEND).'">');
			}
		}
		if (isset ($_SESSION['gv_id'])) {
			$gv_query = xtc_db_query("select coupon_amount from ".TABLE_COUPONS." where coupon_id = '".$_SESSION['gv_id']."'");
			$coupon = xtc_db_fetch_array($gv_query);
			$this->set_content_data('COUPON_AMOUNT2', $xtPrice->xtcFormat($coupon['coupon_amount'], true, 0, true));
		}
		if (isset ($_SESSION['cc_id'])) {
			$this->set_content_data('COUPON_HELP_LINK', '<a href="javascript:popupWindow(\''.xtc_href_link(FILENAME_POPUP_COUPON_HELP, 'cID='.$_SESSION['cc_id']).'\')">');
		}
		// GV Code End
		$this->set_content_data('LINK_CART', xtc_href_link(FILENAME_SHOPPING_CART, '', 'SSL'));
		$this->set_content_data('products', $products_in_cart);

		$this->set_content_data('language', $_SESSION['language']);



		//$this->set_content_data('current_category_id', $c_current_category_id);
		//$this->set_content_data('CATEGORIES_DATA', $t_categories_info_array);
		
		$t_html_output = $this->build_html();
		return $t_html_output;
	}

	function set_tree_depth($p_depth)
	{
		$this->v_tree_depth = (int)$p_depth;
	}

	function get_tree_depth()
	{
		return $this->v_tree_depth;
	}

}
?>