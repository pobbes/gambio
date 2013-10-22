<?php
/* --------------------------------------------------------------
   ot_coupon.php 2012-06-27 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(ot_coupon.php,v 1.1.2.37.3); www.oscommerce.com
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: ot_coupon.php 1322 2005-10-27 13:58:22Z mz $)

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contributions:

   Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
   http://www.oscommerce.com/community/contributions,282
   Copyright (c) Strider | Strider@oscworks.com
   Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
   Copyright (c) Andre ambidex@gmx.net
   Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

require_once(DIR_FS_INC . 'xtc_get_currencies_values.inc.php');

class ot_coupon_ORIGIN {
	var $title, $output;

	function ot_coupon_ORIGIN() {
		global $xtPrice;

		$this->code = 'ot_coupon';
		$this->header = MODULE_ORDER_TOTAL_COUPON_HEADER;
		$this->title = MODULE_ORDER_TOTAL_COUPON_TITLE;
		$this->description = MODULE_ORDER_TOTAL_COUPON_DESCRIPTION;
		$this->user_prompt = '';
		$this->enabled = MODULE_ORDER_TOTAL_COUPON_STATUS;
		$this->sort_order = MODULE_ORDER_TOTAL_COUPON_SORT_ORDER;
		$this->include_shipping = MODULE_ORDER_TOTAL_COUPON_INC_SHIPPING;
		$this->include_tax = MODULE_ORDER_TOTAL_COUPON_INC_TAX;
		$this->calculate_tax = MODULE_ORDER_TOTAL_COUPON_CALC_TAX;
		$this->tax_class = MODULE_ORDER_TOTAL_COUPON_TAX_CLASS;
		$this->credit_class = true;
		$this->output = array ();

	}

	function process() {
		global $order, $xtPrice;

		// BOF GM_MOD
		$t_gm_check_coupon = xtc_db_query("SELECT coupon_id 
											FROM " . TABLE_COUPONS . "
											WHERE 
												coupon_id = '" . (int)$_SESSION['cc_id'] . "'
												AND coupon_active = 'Y'");
		if(xtc_db_num_rows($t_gm_check_coupon) == 1)
		{
		// EOF GM_MOD
			$order_total = $this->get_order_total();
			$od_amount = $this->calculate_credit($order_total);
			$tod_amount = 0.0; //Fred
			$this->deduction = $od_amount;
		
			// BOF GM_MOD:
			if ($this->calculate_tax != 'None') { //Fred - changed from 'none' to 'None'!
				$tod_amount = $this->calculate_tax_deduction($order_total, $this->deduction, $this->calculate_tax);
			}
			
			if ($od_amount > 0) {
				// BOF GM_MOD
				if($_SESSION['customers_status']['customers_status_show_price_tax'] == 0)
				{
					if($_SESSION['gm_coupon_type'] != 'P')
					{
						$od_amount -= $tod_amount;
					}
				}
				unset($_SESSION['gm_coupon_type']);
				
				$order->info['subtotal'] = $order->info['subtotal'] - round($od_amount, 2);
				$order->info['total'] = $order->info['total'] - round($od_amount, 2);
				$order->info['deduction'] = $od_amount;
				$this->output[] = array ('title' => $this->title.': '.$this->coupon_code.':', 'text' => '-'.$xtPrice->xtcFormat($od_amount, true), 'value' => $od_amount); //Fred added hyphen
				// EOF GM_MOD
			}
		// BOF GM_MOD:
		}
	}

	function selection_test() {
		return false;
	}

	function pre_confirmation_check($order_total) {

		return $this->calculate_credit($order_total);
	}

	function use_credit_amount() {
		return $output_string;
	}

	function credit_selection() {
		/*
			$selection_string = '';
			$selection_string .= '<tr>' . "\n";
			$selection_string .= ' <td  width="10">' . xtc_draw_separator('pixel_trans.gif', '10', '1') .'</td>';
			$selection_string .= ' <td  nowrap class="main">' . "\n";
			$selection_string .=  TEXT_ENTER_COUPON_CODE . '</td>';
			$selection_string .= ' <td  align="right">'. xtc_draw_input_field('gv_redeem_code').'</td>';
			$selection_string .= ' <td  width="10">' . xtc_draw_separator('pixel_trans.gif', '10', '1') . '</td>';
			$selection_string .= '</tr>' . "\n";
		    */
		return false;
	}

	function collect_posts() {
		global $xtPrice;
		if ($_POST['gv_redeem_code']) {

			// get some info from the coupon table
			$coupon_query = xtc_db_query("select coupon_id, coupon_amount, coupon_type, coupon_minimum_order,uses_per_coupon, uses_per_user, restrict_to_products,restrict_to_categories from ".TABLE_COUPONS." where coupon_code='".xtc_db_input($_POST['gv_redeem_code'])."' and coupon_active='Y'");
			$coupon_result = xtc_db_fetch_array($coupon_query);

			// SS ?
			if ($coupon_result['coupon_type'] != 'G') {

				if (xtc_db_num_rows($coupon_query) == 0) {
					xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message='.urlencode(ERROR_NO_INVALID_REDEEM_COUPON), 'SSL'));
				}

				$date_query = xtc_db_query("select coupon_start_date from ".TABLE_COUPONS." where coupon_start_date <= now() and coupon_code='".xtc_db_input($_POST['gv_redeem_code'])."'");

				if (xtc_db_num_rows($date_query) == 0) {
					xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message='.urlencode(ERROR_INVALID_STARTDATE_COUPON), 'SSL'));
				}

				$date_query = xtc_db_query("select coupon_expire_date from ".TABLE_COUPONS." where coupon_expire_date >= now() and coupon_code='".xtc_db_input($_POST['gv_redeem_code'])."'");

				if (xtc_db_num_rows($date_query) == 0) {
					xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message='.urlencode(ERROR_INVALID_FINISDATE_COUPON), 'SSL'));
				}

				$coupon_count = xtc_db_query("select coupon_id from ".TABLE_COUPON_REDEEM_TRACK." where coupon_id = '".$coupon_result['coupon_id']."'");
				$coupon_count_customer = xtc_db_query("select coupon_id from ".TABLE_COUPON_REDEEM_TRACK." where coupon_id = '".$coupon_result['coupon_id']."' and customer_id = '".$_SESSION['customer_id']."'");

				if (xtc_db_num_rows($coupon_count) >= $coupon_result['uses_per_coupon'] && $coupon_result['uses_per_coupon'] > 0) {
					xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message='.urlencode(ERROR_INVALID_USES_COUPON.$coupon_result['uses_per_coupon'].TIMES), 'SSL'));
				}

				if (xtc_db_num_rows($coupon_count_customer) >= $coupon_result['uses_per_user'] && $coupon_result['uses_per_user'] > 0) {
					xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message='.urlencode(ERROR_INVALID_USES_USER_COUPON.$coupon_result['uses_per_user'].TIMES), 'SSL'));
				}
				if ($coupon_result['coupon_type'] == 'S') {
					$coupon_amount = $order->info['shipping_cost'];
				} else {
					$coupon_amount = $xtPrice->xtcFormat($coupon_result['coupon_amount'], true).' ';
				}
				if ($coupon_result['coupon_type'] == 'P')
					$coupon_amount = $coupon_result['coupon_amount'].'% ';
					
				if ($coupon_result['coupon_minimum_order'] > 0)
				{
					$t_gm_currency_array = array();
					$t_gm_currency_array = xtc_get_currencies_values($_SESSION['currency']);
					if(!empty($t_gm_currency_array['value']))
					{
						$coupon_result['coupon_minimum_order'] = (double)$coupon_result['coupon_minimum_order'] * (double)$t_gm_currency_array['value'];
						$coupon_result['coupon_minimum_order'] = round($coupon_result['coupon_minimum_order'], 2);
					}
					$coupon_amount .= 'on orders greater than '.$coupon_result['coupon_minimum_order'];
				}					

				$_SESSION['cc_id'] = $coupon_result['coupon_id']; //Fred ADDED, set the global and session variable

			}
			if ($_POST['submit_redeem_coupon_x'] && !$_POST['gv_redeem_code'])
				xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message='.urlencode(ERROR_NO_REDEEM_CODE), 'SSL'));
			}
	}

	function calculate_credit($amount) {
		global $order;

		$od_amount = 0;
		if (isset ($_SESSION['cc_id'])) {
			$coupon_query = xtc_db_query("select coupon_code from ".TABLE_COUPONS." where coupon_id = '".$_SESSION['cc_id']."'");
			$t_order_total = $this->get_order_total();
			if (xtc_db_num_rows($coupon_query) != 0) {
				$coupon_result = xtc_db_fetch_array($coupon_query);
				$this->coupon_code = $coupon_result['coupon_code'];
				$coupon_get = xtc_db_query("select coupon_amount, coupon_minimum_order, restrict_to_products, restrict_to_categories, coupon_type from ".TABLE_COUPONS." where coupon_code = '".$coupon_result['coupon_code']."'");
				$get_result = xtc_db_fetch_array($coupon_get);
				$c_deduct = $get_result['coupon_amount'];
				// BOF GM_MOD
				if($get_result['coupon_type'] != 'P')
				{
					$t_gm_currency_array = array();
					$t_gm_currency_array = xtc_get_currencies_values($_SESSION['currency']);
					if(!empty($t_gm_currency_array['value']))
					{
						$c_deduct *= (double)$t_gm_currency_array['value'];
						$c_deduct = round($c_deduct, 2);
					}
				}
				
				
				/*
				if ($get_result['coupon_type'] == 'S')
					$c_deduct = $order->info['shipping_cost'];
					
				if ($get_result['coupon_type']=='S' && $get_result['coupon_amount'] > 0 ) $c_deduct = $order->info['shipping_cost'] + $get_result['coupon_amount'];
				*/
				// EOF GM_MOD
				
				// BOF GM_MOD
				$t_gm_currency_array = array();
				$t_gm_currency_array = xtc_get_currencies_values($_SESSION['currency']);
				if(!empty($t_gm_currency_array['value']))
				{
					$get_result['coupon_minimum_order'] = (double)$get_result['coupon_minimum_order'] * (double)$t_gm_currency_array['value'];
					$get_result['coupon_minimum_order'] = round($get_result['coupon_minimum_order'], 2);
				}					
				// EOF GM_MOD
				
				if ($get_result['coupon_minimum_order'] <= $t_order_total) {

					if ($get_result['restrict_to_products'] || $get_result['restrict_to_categories']) {
						
						for ($i = 0; $i < sizeof($order->products); $i ++) {
							if ($get_result['restrict_to_products']) {
								$pr_ids = explode(',', $get_result['restrict_to_products']);
								// BOF GM_MOD:
								for ($ii = 0; $ii < count($pr_ids); $ii ++) {
									if ($pr_ids[$ii] == xtc_get_prid($order->products[$i]['id'])) {
										if ($get_result['coupon_type'] == 'P') {
											$pr_c = $this->product_price($order->products[$i]['id']); //Fred 2003-10-28, fix for the row above, otherwise the discount is calc based on price excl VAT!
											$pod_amount = round($pr_c*10)/10*$c_deduct/100;
											$od_amount = $od_amount + $pod_amount;
										
										} else {
											// BOF GM_MOD
											$t_gm_price_total += $this->product_price($order->products[$i]['id']);
											if($t_gm_price_total < $c_deduct)
											{
												$od_amount = $t_gm_price_total;
											}
											else
											{
												$od_amount = $c_deduct;
											}
											// EOF GM_MOD
										}
									}
								}
							} else {
								$cat_ids = explode(',', $get_result['restrict_to_categories']);
								for ($i = 0; $i < sizeof($order->products); $i ++) {
									$my_path = xtc_get_product_path(xtc_get_prid($order->products[$i]['id']));
									$sub_cat_ids = explode('_', $my_path);
									for ($iii = 0; $iii < count($sub_cat_ids); $iii ++) {
										for ($ii = 0; $ii < count($cat_ids); $ii ++) {
											if ($sub_cat_ids[$iii] == $cat_ids[$ii]) {
												if ($get_result['coupon_type'] == 'P') {
													$pr_c = $this->product_price($order->products[$i]['id']); //Fred 2003-10-28, fix for the row above, otherwise the discount is calc based on price excl VAT!
													$pod_amount = round($pr_c*10)/10*$c_deduct/100;
													$od_amount = $od_amount + $pod_amount;
                                                       continue 3;      // v5.13a Tanaka 2005-4-30: to prevent double counting of a product discount
												} else {
													// BOF GM_MOD
													$t_gm_price_total += $this->product_price($order->products[$i]['id']);
													
													if($t_gm_price_total < $c_deduct)
													{
														$od_amount = $t_gm_price_total;
													}
													else
													{
														$od_amount = $c_deduct;
													}
													// EOF GM_MOD
													continue 3;
     											}
											}
										}
									}
								}
							}
						}
					} else {
						if ($get_result['coupon_type'] != 'P') {
							$od_amount = $c_deduct;
						} else {
							$od_amount = $amount * $get_result['coupon_amount'] / 100;
						}
					}
				}
			}
			// BOF GM_MOD
			if($get_result['coupon_type'] == 'S' && $get_result['coupon_minimum_order'] <= $t_order_total)
			{
				$od_amount += $order->info['shipping_cost'];
			}
			
			if($od_amount > $amount && $get_result['coupon_type'] == 'S')
			{
				if($this->include_shipping == 'true')
				{
					$amount -= $order->info['shipping_cost'];
				}
				
				if($od_amount > ($amount + $order->info['shipping_cost']))
				{
					$od_amount = $amount + $order->info['shipping_cost'];
				}
			}			
			else if($od_amount > $amount)
			{
				$od_amount = $amount;
			}		
			// EOF GM_MOD
		}
		return $od_amount;
	}

	function calculate_tax_deduction($amount, $od_amount, $method) {
		global $order;
		// BOF GM_MOD
		$coo_gm_main = new main();
		$t_gm_tax_before_deduction = $order->info['tax'];
		// EOF GM_MOD
		
		$coupon_query = xtc_db_query("select coupon_code from ".TABLE_COUPONS." where coupon_id = '".$_SESSION['cc_id']."'");
		if (xtc_db_num_rows($coupon_query) != 0) {
			$coupon_result = xtc_db_fetch_array($coupon_query);
			$coupon_get = xtc_db_query("select coupon_amount, coupon_minimum_order, restrict_to_products, restrict_to_categories, coupon_type from ".TABLE_COUPONS." where coupon_code = '".$coupon_result['coupon_code']."'");
			$get_result = xtc_db_fetch_array($coupon_get);
			
			// BOF GM_MOD:
			//if ($get_result['coupon_type'] != 'S') {
						
				//RESTRICTION--------------------------------
				if ($get_result['restrict_to_products'] || $get_result['restrict_to_categories']) {
					// What to do here.
					// Loop through all products and build a list of all product_ids, price, tax class
					// at the same time create total net amount.
					// then
					// for percentage discounts. simply reduce tax group per product by discount percentage
					// or
					// for fixed payment amount
					// calculate ratio based on total net
					// for each product reduce tax group per product by ratio amount.
					$products = $_SESSION['cart']->get_products();
					
					
					$valid_product = false;
					for ($i = 0; $i < sizeof($products); $i ++) {
						$valid_product = false;
					
						$t_prid = xtc_get_prid($products[$i]['id']);
						$cc_query = xtc_db_query("select products_tax_class_id from ".TABLE_PRODUCTS." where products_id = '".$t_prid."'");
						$cc_result = xtc_db_fetch_array($cc_query);
						
						
						if ($get_result['restrict_to_products']) {
							$pr_ids = explode(',', $get_result['restrict_to_products']);
							for ($p = 0; $p < sizeof($pr_ids); $p++) {
								if ($pr_ids[$p] == $t_prid)
									$valid_product = true;
							}
						}
						                                          
						if ($get_result['restrict_to_categories']) {
	                        // v5.13a Tanaka 2005-4-30:  New code, this correctly identifies valid products in subcategories
	                        $cat_ids = explode(',', $get_result['restrict_to_categories']);
	                        $my_path = xtc_get_product_path($t_prid);
	                        $sub_cat_ids = explode('_', $my_path);
	                        for ($iii = 0; $iii < count($sub_cat_ids); $iii++) {
	                            for ($ii = 0; $ii < count($cat_ids); $ii++) {
	                                if ($sub_cat_ids[$iii] == $cat_ids[$ii]) {
	                                    $valid_product = true;
	                                    continue 2;
	                                }
	                            }
	                            
	                        }
						}					 
						
						if ($valid_product) {
							$price_excl_vat = $products[$i]['final_price'] * $products[$i]['quantity'];
							$price_incl_vat = $this->product_price($products[$i]['id']);
							$valid_array[] = array ('product_id' => $t_prid, 'products_price' => $price_excl_vat, 'products_tax_class' => $cc_result['products_tax_class_id']);
							$total_price += $price_excl_vat; 
						}
					}
					
					if (sizeof($valid_array) > 0) { // if ($valid_product) {
						if ($get_result['coupon_type'] == 'P') {
							$ratio = $get_result['coupon_amount'] / 100;
						} else {
							$ratio = $od_amount / $total_price;
						}
						
						if ($get_result['coupon_type'] == 'S')
							$ratio = 1;
						if ($method == 'Credit Note') {
							$tax_rate = xtc_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
							// BOF GM_MOD
							//$tax_desc = xtc_get_tax_description($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
							$tax_desc = $coo_gm_main->getTaxInfo($tax_rate);
							
							if($get_result['coupon_type'] == 'S')
							{
								$t_gm_od_amount = $od_amount - $order->info['shipping_cost'];
								$t_gm_shipping_tax_rate = ($order->info['shipping_cost'] / $_SESSION['shipping']['cost'] - 1) * 100;
								$t_gm_shipping_tax_desc = $coo_gm_main->getTaxInfo($t_gm_shipping_tax_rate);
								$order->info['tax_groups'][$t_gm_shipping_tax_desc] = $order->info['tax_groups'][$t_gm_shipping_tax_desc] - ((($order->info['shipping_cost'] / (1 + $t_gm_shipping_tax_rate / 100)) - $order->info['shipping_cost']) * (-1));
								$order->info['tax'] = $order->info['tax'] - ((($order->info['shipping_cost'] / (1 + $t_gm_shipping_tax_rate / 100)) - $order->info['shipping_cost']) * (-1));
							}
							else
							{
								$t_gm_od_amount = $od_amount;
							}
							
							$order->info['tax_groups'][$tax_desc] = $order->info['tax_groups'][$tax_desc] - ((($t_gm_od_amount / (1 + $tax_rate / 100)) - $t_gm_od_amount) * (-1));
							$order->info['tax'] = $order->info['tax'] - ((($t_gm_od_amount / (1 + $tax_rate / 100)) - $t_gm_od_amount) * (-1));
							/*
							if ($get_result['coupon_type'] == 'P') {
								$tod_amount = $od_amount / (100 + $tax_rate) * $tax_rate;
							} else {
								$tod_amount = $order->info['tax_groups'][$tax_desc] * $od_amount / 100;
							}
							$order->info['tax_groups'][$tax_desc] -= $tod_amount;
							$order->info['total'] -= $tod_amount;
							$order->info['tax'] -= $tod_amount;
							*/
							// EOF GM_MOD
						} else {
							
							for ($p = 0; $p < sizeof($valid_array); $p ++) {
								// BOF GM_MOD
								/*
								$tax_rate = xtc_get_tax_rate($valid_array[$p]['products_tax_class'], $order->delivery['country']['id'], $order->delivery['zone_id']);
								$tax_desc = xtc_get_tax_description($valid_array[$p]['products_tax_class'], $order->delivery['country']['id'], $order->delivery['zone_id']);
								if ($tax_rate > 0) {
									$tod_amount = ($valid_array[$p]['products_price'] * $tax_rate) / 100 * $ratio;
									$order->info['tax_groups'][$tax_desc] -= ($valid_array[$p]['products_price'] * $tax_rate) / 100 * $ratio;
									$order->info['total'] -= ($valid_array[$p]['products_price'] * $tax_rate) / 100 * $ratio;
									$order->info['tax'] -= ($valid_array[$p]['products_price'] * $tax_rate) / 100 * $ratio;
								}
								*/
								
								$tax_rate = xtc_get_tax_rate($valid_array[$p]['products_tax_class'], $order->delivery['country']['id'], $order->delivery['zone_id']);
								$tax_desc = $coo_gm_main->getTaxInfo($tax_rate);
								
								$t_gm_ratio = ((100 / $total_price) * $valid_array[$p]['products_price']) / 100;
								
								if($tax_rate > 0)
								{
									if($get_result['coupon_type'] == 'S' && $_SESSION['shipping']['cost'] * ( 1 + ($tax_rate / 100)) == $order->info['shipping_cost'])
									{
										$order->info['tax_groups'][$tax_desc] -= $_SESSION['shipping']['cost'] * ($tax_rate / 100);
										$order->info['tax'] -= $_SESSION['shipping']['cost'] * ($tax_rate / 100);
									}
									
									//$tod_amount = ($valid_array[$p]['products_price'] * $tax_rate) / 100 * $t_gm_ratio;
									$t_gm_reduced_price = $valid_array[$p]['products_price'] - $od_amount * $t_gm_ratio;
									$t_gm_reduced_price_tax = (($t_gm_reduced_price / (1 + $tax_rate / 100)) - $t_gm_reduced_price) * (-1);
									$t_gm_reduce_tax = ((($valid_array[$p]['products_price'] / (1 + $tax_rate / 100)) - $valid_array[$p]['products_price']) * (-1)) - $t_gm_reduced_price_tax;
									$order->info['tax_groups'][$tax_desc] -= $t_gm_reduce_tax;
									$order->info['tax'] -= $t_gm_reduce_tax;
									
									if($order->info['tax_groups'][$tax_desc] < 0.005)
									{
										$order->info['tax_groups'][$tax_desc] = 0;
									}
									if($order->info['tax'] < 0.005)
									{
										$order->info['tax'] = 0;
									}
								}
								// EOF GM_MOD
							}
						}
					}
				//NO RESTRICTION--------------------------------
				} else {
					// BOF GM_MOD:
					if ($get_result['coupon_type'] == 'F' || $get_result['coupon_type'] == 'S') {
						$tod_amount = 0;
						if ($method == 'Credit Note') {
							$tax_rate = xtc_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
							
							// BOF GM_MOD
							//$tax_desc = xtc_get_tax_description($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
							$tax_desc = $coo_gm_main->getTaxInfo($tax_rate);
							
							if($get_result['coupon_type'] == 'S')
							{
								$t_gm_od_amount = $od_amount - $order->info['shipping_cost'];
								$t_gm_shipping_tax_rate = ($order->info['shipping_cost'] / $_SESSION['shipping']['cost'] - 1) * 100;
								$t_gm_shipping_tax_desc = $coo_gm_main->getTaxInfo($t_gm_shipping_tax_rate);
								$order->info['tax_groups'][$t_gm_shipping_tax_desc] = $order->info['tax_groups'][$t_gm_shipping_tax_desc] - ((($order->info['shipping_cost'] / (1 + $t_gm_shipping_tax_rate / 100)) - $order->info['shipping_cost']) * (-1));
								$order->info['tax'] = $order->info['tax'] - ((($order->info['shipping_cost'] / (1 + $t_gm_shipping_tax_rate / 100)) - $order->info['shipping_cost']) * (-1));
							}
							else
							{
								$t_gm_od_amount = $od_amount;
							}
							
							$order->info['tax_groups'][$tax_desc] = $order->info['tax_groups'][$tax_desc] - ((($t_gm_od_amount / (1 + $tax_rate / 100)) - $t_gm_od_amount) * (-1));
							$order->info['tax'] = $order->info['tax'] - ((($t_gm_od_amount / (1 + $tax_rate / 100)) - $t_gm_od_amount) * (-1));
							//$tod_amount = $od_amount / (100 + $tax_rate) * $tax_rate;
							//$order->info['tax_groups'][TAX_ADD_TAX.$tax_desc] -= $tod_amount;
							// EOF GM_MOD
						} else {
							
							// BOF GM_MOD
							$t_gm_tax_class = array();
							$t_gm_tax_class[] = 0;
							
							if(empty($_SESSION['cart']->tax))
							{
								$t_gm_cart_tax = array();
								$t_gm_cart_products = $order->products;
								for($i = 0; $i < count($t_gm_cart_products); $i++)
								{
									if(!isset($t_gm_cart_tax[$t_gm_cart_products[$i]['tax_class_id']]) && $t_gm_cart_products[$i]['tax_class_id'] != 0)
									{
										$t_gm_cart_tax[$t_gm_cart_products[$i]['tax_class_id']] = array();
										$t_gm_cart_tax_desc = $coo_gm_main->getTaxInfo($t_gm_cart_products[$i]['tax']);
										$t_gm_cart_tax[$t_gm_cart_products[$i]['tax_class_id']]['value'] = $t_gm_cart_products[$i]['final_price'] * ($t_gm_cart_products[$i]['tax'] / 100);
										$t_gm_cart_tax[$t_gm_cart_products[$i]['tax_class_id']]['desc'] = $t_gm_cart_tax_desc;
									}
									else if($t_gm_cart_products[$i]['tax_class_id'] != 0)
									{
										$t_gm_cart_tax[$t_gm_cart_products[$i]['tax_class_id']]['value'] += $t_gm_cart_products[$i]['final_price'] * ($t_gm_cart_products[$i]['tax'] / 100);	
									}										
								}
							}
							else
							{
								$t_gm_cart_tax = $_SESSION['cart']->tax;
							}
							
							foreach($t_gm_cart_tax AS $t_gm_key => $t_gm_value)
							{
								$t_gm_tax_class[] = $t_gm_key;
							}
							
							$t_gm_products = array();
							$t_gm_total = 0;
							foreach($t_gm_tax_class AS $t_gm_tax_class_id)
							{
								for($i = 0; $i < count($order->products); $i++)
								{
									if($order->products[$i]['tax_class_id'] == $t_gm_tax_class_id)
									{
										if($_SESSION['customers_status']['customers_status_show_price_tax'] == 1)
										{
											$t_gm_products[$t_gm_tax_class_id]['PRICE'] += $order->products[$i]['final_price'];
											$t_gm_total += $order->products[$i]['final_price'];
										}
										else
										{
											$t_gm_products[$t_gm_tax_class_id]['PRICE'] += $order->products[$i]['final_price'] + $order->products[$i]['final_price'] * $order->products[$i]['tax'] / 100;
											$t_gm_total += $order->products[$i]['final_price'] + $order->products[$i]['final_price'] * $order->products[$i]['tax'] / 100;
										}
										
										
										$t_gm_products[$t_gm_tax_class_id]['TAX_RATE'] = $order->products[$i]['tax'];
										$t_gm_products[$t_gm_tax_class_id]['TAX_DESC'] = $_SESSION['cart']->tax[$order->products[$i]['tax_class_id']]['desc'];
									}
								}								
							}
							
							if($get_result['coupon_type'] == 'S')
							{
								$od_amount = $od_amount - round($order->info['shipping_cost'], 2);
								if($od_amount > $t_gm_total)
								{
									$od_amount = $t_gm_total;
								}
							}
							
							foreach($t_gm_products AS $t_gm_key => $t_gm_value)
							{
								$t_gm_products[$t_gm_key]['RATIO'] = (100 / $t_gm_total) * $t_gm_products[$t_gm_key]['PRICE'];
								if($t_gm_products[$t_gm_key]['TAX_RATE'] != 0 && $t_gm_products[$t_gm_key]['PRICE'] != 0)
								{
									$t_gm_products[$t_gm_key]['TAX'] = ((($t_gm_products[$t_gm_key]['PRICE'] / (1 + $t_gm_products[$t_gm_key]['TAX_RATE'] / 100)) - $t_gm_products[$t_gm_key]['PRICE']) * (-1));
									$t_gm_products[$t_gm_key]['TAX_AFTER_DEDUCTION'] = (((($t_gm_products[$t_gm_key]['PRICE'] - round($od_amount * ($t_gm_products[$t_gm_key]['RATIO'] / 100), 2)) / (1 + $t_gm_products[$t_gm_key]['TAX_RATE'] / 100)) - ($t_gm_products[$t_gm_key]['PRICE'] - round($od_amount * ($t_gm_products[$t_gm_key]['RATIO'] / 100), 2))) * (-1));
									$t_gm_products[$t_gm_key]['TAX_DEDUCTION'] = $t_gm_products[$t_gm_key]['TAX'] - $t_gm_products[$t_gm_key]['TAX_AFTER_DEDUCTION'];
									
									if($t_gm_products[$t_gm_key]['TAX_AFTER_DEDUCTION'] < 0)
									{
										$t_gm_products[$t_gm_key]['TAX_AFTER_DEDUCTION'] = 0;
										$t_gm_products[$t_gm_key]['TAX_DEDUCTION'] = $t_gm_products[$t_gm_key]['TAX'];
									}
									
									$order->info['tax_groups'][$t_gm_products[$t_gm_key]['TAX_DESC']] -= $t_gm_products[$t_gm_key]['TAX_DEDUCTION'];
									$order->info['tax'] -= $t_gm_products[$t_gm_key]['TAX_DEDUCTION'];
									
									if($get_result['coupon_type'] == 'S' && $_SESSION['shipping']['cost'] * ( 1 + ($t_gm_products[$t_gm_key]['TAX_RATE'] / 100)) == $order->info['shipping_cost'])
									{
										$order->info['tax_groups'][$t_gm_products[$t_gm_key]['TAX_DESC']] -= $_SESSION['shipping']['cost'] * ($t_gm_products[$t_gm_key]['TAX_RATE'] / 100);
										$order->info['tax'] -= $_SESSION['shipping']['cost'] * ($t_gm_products[$t_gm_key]['TAX_RATE'] / 100);
									}
									
									if($_SESSION['shipping']['cost'] * ( 1 + ($t_gm_products[$t_gm_key]['TAX_RATE'] / 100)) == $order->info['shipping_cost'] && $t_gm_total < $od_amount)
									{
										$t_shipping_costs_reduction = $od_amount - $t_gm_total;
										if($t_shipping_costs_reduction > 0)
										{
											$t_gm_shipping_costs = round($order->info['shipping_cost'] , 2);
											$t_gm_shipping_costs_tax_old = ($t_gm_shipping_costs / (1 + ($t_gm_products[$t_gm_key]['TAX_RATE'] / 100)) - $t_gm_shipping_costs) * (-1);
											$t_gm_shipping_costs -= $t_shipping_costs_reduction;
											$t_gm_shipping_costs_tax_new = ($t_gm_shipping_costs / (1 + ($t_gm_products[$t_gm_key]['TAX_RATE'] / 100)) - $t_gm_shipping_costs) * (-1);
											$order->info['tax_groups'][$t_gm_products[$t_gm_key]['TAX_DESC']] = $order->info['tax_groups'][$t_gm_products[$t_gm_key]['TAX_DESC']] - $t_gm_shipping_costs_tax_old + $t_gm_shipping_costs_tax_new;
											$order->info['tax'] = $order->info['tax'] - $t_gm_shipping_costs_tax_old + $t_gm_shipping_costs_tax_new;
										}
										else
										{
											$order->info['tax'] -= $order->info['tax_groups'][$t_gm_products[$t_gm_key]['TAX_DESC']];
											$order->info['tax_groups'][$t_gm_products[$t_gm_key]['TAX_DESC']] = 0;				
										}
									}
									
									if($order->info['tax_groups'][$t_gm_products[$t_gm_key]['TAX_DESC']] < 0.005)
									{
										$order->info['tax_groups'][$t_gm_products[$t_gm_key]['TAX_DESC']] = 0;
									}
									if($order->info['tax'] < 0.005)
									{
										$order->info['tax'] = 0;
									}
								}
								else
								{
									$t_gm_products[$t_gm_key]['TAX'] = 0;
									$t_gm_products[$t_gm_key]['TAX_AFTER_DEDUCTION'] = 0;
									$t_gm_products[$t_gm_key]['TAX_DEDUCTION'] = 0;
									$t_gm_reduced_price = ((100 / $t_gm_total) * $t_gm_products[$t_gm_key]['PRICE']) * $t_gm_products[$t_gm_key]['PRICE'];
								}
							}

							/*
							reset($order->info['tax_groups']);
							while (list ($key, $value) = each($order->info['tax_groups'])) {
								$ratio1 = $od_amount / ($amount - $order->info['tax_groups'][$key]); 
								$tax_rate = xtc_get_tax_rate_from_desc( str_replace(TAX_ADD_TAX, "", $key) );
								$net = $tax_rate * $order->info['tax_groups'][$key];
								if ($net > 0) {
									$god_amount = $od_amount * $tax_rate / (100 + $tax_rate);
									$tod_amount += $god_amount;
									$order->info['tax_groups'][$key] -= $god_amount;
								}
							}
							*/
							// EOF GM_MOD
						}
						// BOF GM_MOD
						/*
						$order->info['total'] -= $tod_amount;						
						$order->info['tax'] -= $tod_amount;
						*/
						// EOF GM_MOD
					}
					
					if ($get_result['coupon_type'] == 'P') {
						$tod_amount = 0;
						if ($method == 'Credit Note') {
							// BOF GM_MOD
							$t_gm_tax_rate = xtc_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
							$tax_desc = $coo_gm_main->getTaxInfo($t_gm_tax_rate);
							
							if($get_result['coupon_type'] == 'S')
							{
								$t_gm_od_amount = $od_amount - $order->info['shipping_cost'];
								$t_gm_shipping_tax_rate = ($order->info['shipping_cost'] / $_SESSION['shipping']['cost'] - 1) * 100;
								$t_gm_shipping_tax_desc = $coo_gm_main->getTaxInfo($t_gm_shipping_tax_rate);
								$order->info['tax_groups'][$t_gm_shipping_tax_desc] = $order->info['tax_groups'][$t_gm_shipping_tax_desc] - ((($order->info['shipping_cost'] / (1 + $t_gm_shipping_tax_rate / 100)) - $order->info['shipping_cost']) * (-1));
								$order->info['tax'] = $order->info['tax'] - ((($order->info['shipping_cost'] / (1 + $t_gm_shipping_tax_rate / 100)) - $order->info['shipping_cost']) * (-1));
							}
							else
							{
								$_SESSION['gm_coupon_type'] = $get_result['coupon_type'];
								$t_gm_od_amount = $od_amount;
							}
							
							if($_SESSION['customers_status']['customers_status_show_price_tax'] == 0)
							{
								$order->info['tax_groups'][$tax_desc] -= ($t_gm_od_amount * ($t_gm_tax_rate / 100));
								$order->info['tax'] -= ($t_gm_od_amount * ($t_gm_tax_rate / 100));
							}
							else
							{
								$order->info['tax_groups'][$tax_desc] = $order->info['tax_groups'][$tax_desc] - ((($t_gm_od_amount / (1 + $t_gm_tax_rate / 100)) - $t_gm_od_amount) * (-1));
								$order->info['tax'] = $order->info['tax'] - ((($t_gm_od_amount / (1 + $t_gm_tax_rate / 100)) - $t_gm_od_amount) * (-1));		
							}
							//$tax_desc = xtc_get_tax_description($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
							//$tod_amount = $order->info['tax_groups'][$tax_desc] * $od_amount / 100;
							//$order->info['tax_groups'][TAX_ADD_TAX.$tax_desc] -= $tod_amount;
							// EOF GM_MOD
						} else {
							reset($order->info['tax_groups']);
							while (list ($key, $value) = each($order->info['tax_groups'])) {
								// BOF GM_MOD
								$_SESSION['gm_coupon_type'] = $get_result['coupon_type'];
								$gm_tax_class = 0;
								foreach($_SESSION['cart']->tax AS $gm_key => $gm_value)
								{
									if($gm_value[desc] == $key)
									{
										$gm_tax_class = $gm_key;
									}
								}
								
								$tax_rate = xtc_get_tax_rate($gm_tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
								
								if(!empty($tax_rate))
								{
									if($_SESSION['customers_status']['customers_status_show_price_tax'] == 0)
									{
										$order->info['tax_groups'][$key] -= ($od_amount * ($tax_rate / 100));
										$order->info['tax'] -= ($od_amount * ($tax_rate / 100));
									}
									else
									{
										$order->info['tax_groups'][$key] -= (( ($od_amount / (1 + ($tax_rate / 100)) ) - $od_amount ) * -1);
										$order->info['tax'] -= (( ($od_amount / (1 + ($tax_rate / 100)) ) - $od_amount ) * -1);
									}
								}
								
								/*
								$god_amout = 0;
								$tax_rate = xtc_get_tax_rate_from_desc( str_replace(TAX_ADD_TAX, "", $key) );
								$net = $tax_rate * $order->info['tax_groups'][$key];
								if ($net > 0) {
									$god_amount = $order->info['tax_groups'][$key] * $get_result['coupon_amount'] / 100;
									$tod_amount += $god_amount;
									$order->info['tax_groups'][$key] = $order->info['tax_groups'][$key] - $god_amount;
								}
								*/
								// EOF GM_MOD
							}							
						}
						// BOF GM_MOD:
						//$order->info['tax'] -= $tod_amount;
					}
				}
			}
		//}
		// BOF GM_MOD
		if(empty($tod_amount))
		{
			$tod_amount = $t_gm_tax_before_deduction - $order->info['tax'];
		}
		// EOF GM_MOD
		return $tod_amount;
	}

	function update_credit_account($i) {
		return false;
	}

	function apply_credit() {
		global $insert_id, $REMOTE_ADDR;

		if ($this->deduction != 0) {
			xtc_db_query("insert into ".TABLE_COUPON_REDEEM_TRACK." (coupon_id, redeem_date, redeem_ip, customer_id, order_id) values ('".$_SESSION['cc_id']."', now(), '".$REMOTE_ADDR."', '".$_SESSION['customer_id']."', '".$insert_id."')");
		}
		unset ($_SESSION['cc_id']);
	}

	function get_order_total() {
		global $order, $xtPrice;

		$order_total = $order->info['total'];
		// Check if gift voucher is in cart and adjust total
		$products = $_SESSION['cart']->get_products();
		for ($i = 0; $i < sizeof($products); $i ++) {
			$t_prid = xtc_get_prid($products[$i]['id']);
			$gv_query = xtc_db_query("select products_price, products_tax_class_id, products_model from ".TABLE_PRODUCTS." where products_id = '".$t_prid."'");
			$gv_result = xtc_db_fetch_array($gv_query);
			if (preg_match('/^GIFT/', addslashes($gv_result['products_model']))) {
				$qty = $_SESSION['cart']->get_quantity($t_prid);
				$products_tax = $xtPrice->TAX[$gv_result['products_tax_class_id']];
				if ($this->include_tax == 'false') {
					$gv_amount = $gv_result['products_price'] * $qty;
				} else {
					$gv_amount = ($gv_result['products_price'] + $xtPrice->calcTax($gv_result['products_price'], $products_tax)) * $qty;
				}
				$order_total = $order_total - $gv_amount;
			}
		}
		if ($this->include_tax == 'false')
			$order_total = $order_total - $order->info['tax'];
		if ($this->include_shipping == 'false')
			$order_total = $order_total - $order->info['shipping_cost'];
		// OK thats fine for global coupons but what about restricted coupons
		// where you can only redeem against certain products/categories.
		// and I though this was going to be easy !!!
		$coupon_query = xtc_db_query("select coupon_code from ".TABLE_COUPONS." where coupon_id='".$_SESSION['cc_id']."'");
		if (xtc_db_num_rows($coupon_query) != 0) {
			$coupon_result = xtc_db_fetch_array($coupon_query);
			$coupon_get = xtc_db_query("select coupon_amount, coupon_minimum_order,restrict_to_products,restrict_to_categories, coupon_type from ".TABLE_COUPONS." where coupon_code='".$coupon_result['coupon_code']."'");
			$get_result = xtc_db_fetch_array($coupon_get);
			$in_cat = true;
			if ($get_result['restrict_to_categories']) {
				$cat_ids = explode(',', $get_result['restrict_to_categories']);
				$in_cat = false;
				for ($i = 0; $i < count($cat_ids); $i++) {
					if (is_array($this->contents)) {
						reset($this->contents);
						while (list ($products_id,) = each($this->contents)) {
							$cat_query = xtc_db_query("select products_id from products_to_categories where products_id = '".$products_id."' and categories_id = '".$cat_ids[$i]."'");
							if (xtc_db_num_rows($cat_query) != 0) {
								$in_cat = true;
								$total_price += $this->get_product_price($products_id);
							}
						}
					}
				}
			}
			$in_cart = true;
			if ($get_result['restrict_to_products']) {

				$pr_ids = explode(',', $get_result['restrict_to_products']);
				$in_cart = false;
				$products_array = $_SESSION['cart']->get_products();

				for ($i = 0; $i < sizeof($pr_ids); $i++) {
					for ($ii = 1; $ii <= sizeof($products_array); $ii++) {
						if (xtc_get_prid($products_array[$ii-1]['id']) == $pr_ids[$i]) {
							$in_cart = true;
							$total_price += $this->get_product_price($products_array[$ii -1]['id']);
						}
					}
				}
				$order_total = $total_price;
			}
		}
		return $order_total;
	}

	function get_product_price($product_id) {
		global $order,$xtPrice;
		// BOF GM_MOD:
		$qty = $_SESSION['cart']->contents[$product_id]['qty'];
		
		$products_id = xtc_get_prid($product_id);
		// products price
		$product_query = xtc_db_query("select products_id, products_price, products_tax_class_id, products_weight from ".TABLE_PRODUCTS." where products_id='".(int)$product_id."'");
		if ($product = xtc_db_fetch_array($product_query)) {
			$prid = $product['products_id'];


			if ($this->include_tax == 'true') {
				$total_price += $qty * $xtPrice->xtcGetPrice($product['products_id'], $format = false, 1, $product['products_tax_class_id'], $product['products_price'], 1);
				$_SESSION['total_price']=$total_price;
			} else {
				$total_price += $qty * $xtPrice->xtcGetPrice($product['products_id'], $format = false, 1, 0, $product['products_price'], 1);
			}

			// BOF GM_MOD:
			$products_tax = $xtPrice->TAX[$product['products_tax_class_id']];
			
			// attributes price
			if (isset ($_SESSION['cart']->contents[$product_id]['attributes'])) {
				reset($_SESSION['cart']->contents[$product_id]['attributes']);
				while (list ($option, $value) = each($_SESSION['cart']->contents[$product_id]['attributes'])) {
					$attribute_price_query = xtc_db_query("select options_values_price, price_prefix from ".TABLE_PRODUCTS_ATTRIBUTES." where products_id = '".$prid."' and options_id = '".$option."' and options_values_id = '".$value."'");
					$attribute_price = xtc_db_fetch_array($attribute_price_query);
					if ($attribute_price['price_prefix'] == '+') {
						if ($this->include_tax == 'true') {
							$total_price += $qty * ($attribute_price['options_values_price'] + xtc_calculate_tax($attribute_price['options_values_price'], $products_tax));
						} else {
							$total_price += $qty * ($attribute_price['options_values_price']);
						}
					} else {
						if ($this->include_tax == 'true') {
							$total_price -= $qty * ($attribute_price['options_values_price'] + xtc_calculate_tax($attribute_price['options_values_price'], $products_tax));
						} else {
							$total_price -= $qty * ($attribute_price['options_values_price']);
						}
					}
				}
			}
		}

		if($_SESSION['customers_status']['customers_status_ot_discount_flag'] == 1)
		{
			$total_price -= $total_price / 100 * $_SESSION['customers_status']['customers_status_ot_discount'];
		}
		
		if ($this->include_shipping == 'true') {

			$total_price += $order->info['shipping_cost'];
		}
		return $total_price;
	}

	function product_price($product_id) {
		global $order;

		$total_price = $this->get_product_price($product_id);
		if ($this->include_shipping == 'true')
			$total_price -= $order->info['shipping_cost'];
		return $total_price;
	}

	function check() {
		if (!isset ($this->check)) {
			$check_query = xtc_db_query("select configuration_value from ".TABLE_CONFIGURATION." where configuration_key = 'MODULE_ORDER_TOTAL_COUPON_STATUS'");
			$this->check = xtc_db_num_rows($check_query);
		}

		return $this->check;
	}

	function keys() {
		return array ('MODULE_ORDER_TOTAL_COUPON_STATUS', 'MODULE_ORDER_TOTAL_COUPON_SORT_ORDER', 'MODULE_ORDER_TOTAL_COUPON_INC_SHIPPING', 'MODULE_ORDER_TOTAL_COUPON_INC_TAX', 'MODULE_ORDER_TOTAL_COUPON_CALC_TAX', 'MODULE_ORDER_TOTAL_COUPON_TAX_CLASS');
	}

	function install() {
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('', 'MODULE_ORDER_TOTAL_COUPON_STATUS', 'true', '6', '1','gm_cfg_select_option(array(\'true\', \'false\'), ', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('', 'MODULE_ORDER_TOTAL_COUPON_SORT_ORDER', '70', '6', '2', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, set_function ,date_added) values ('', 'MODULE_ORDER_TOTAL_COUPON_INC_SHIPPING', 'true', '6', '5', 'gm_cfg_select_option(array(\'true\', \'false\'), ', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, set_function ,date_added) values ('', 'MODULE_ORDER_TOTAL_COUPON_INC_TAX', 'true', '6', '6','gm_cfg_select_option(array(\'true\', \'false\'), ', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, set_function ,date_added) values ('', 'MODULE_ORDER_TOTAL_COUPON_CALC_TAX', 'None', '6', '7','xtc_cfg_select_option(array(\'None\', \'Standard\', \'Credit Note\'), ', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, date_added) values ('', 'MODULE_ORDER_TOTAL_COUPON_TAX_CLASS', '0', '6', '0', 'xtc_get_tax_class_title', 'xtc_cfg_pull_down_tax_classes(', now())");
	}

	function remove() {
		$keys = '';
		$keys_array = $this->keys();
		for ($i = 0; $i < sizeof($keys_array); $i ++) {
			$keys .= "'".$keys_array[$i]."',";
		}
		$keys = substr($keys, 0, -1);

		xtc_db_query("delete from ".TABLE_CONFIGURATION." where configuration_key in (".$keys.")");
	}
}

MainFactory::load_origin_class('ot_coupon');
?>