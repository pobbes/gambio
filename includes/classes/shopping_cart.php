<?php
/* --------------------------------------------------------------
   shopping_cart.php 2011-10-07 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(shopping_cart.php,v 1.32 2003/02/11); www.oscommerce.com
   (c) 2003	 nextcommerce (shopping_cart.php,v 1.21 2003/08/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: shopping_cart.php 1534 2006-08-20 19:39:22Z mz $)

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contributions:

   Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

   Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
   http://www.oscommerce.com/community/contributions,282
   Copyright (c) Strider | Strider@oscworks.com
   Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
   Copyright (c) Andre ambidex@gmx.net
   Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

// include needed functions
require_once (DIR_FS_INC.'xtc_create_random_value.inc.php');
require_once (DIR_FS_INC.'xtc_get_prid.inc.php');
require_once (DIR_FS_INC.'xtc_draw_form.inc.php');
require_once (DIR_FS_INC.'xtc_draw_input_field.inc.php');
require_once (DIR_FS_INC.'xtc_image_submit.inc.php');
require_once (DIR_FS_INC.'xtc_get_tax_description.inc.php');

class shoppingCart_ORIGIN {
	var $contents, $total, $weight, $cartID, $content_type;

	function shoppingCart_ORIGIN() {
		$this->reset();

	}

	function restore_contents() {

		if (!isset ($_SESSION['customer_id']))
			return false;

		// insert current cart contents in database
		if (is_array($this->contents)) {
			reset($this->contents);
			while (list ($products_id,) = each($this->contents)) {
				$qty = $this->contents[$products_id]['qty'];
				$product_query = xtc_db_query("select products_id from ".TABLE_CUSTOMERS_BASKET." where customers_id = '".$_SESSION['customer_id']."' and products_id = '".xtc_db_input($products_id)."'");
				if (!xtc_db_num_rows($product_query)) {
					xtc_db_query("insert into ".TABLE_CUSTOMERS_BASKET." (customers_id, products_id, customers_basket_quantity, customers_basket_date_added) values ('".$_SESSION['customer_id']."', '".xtc_db_input($products_id)."', '".xtc_db_input($qty)."', '".date('Ymd')."')");
					if (isset ($this->contents[$products_id]['attributes'])) {
						reset($this->contents[$products_id]['attributes']);
						while (list ($option, $value) = each($this->contents[$products_id]['attributes'])) {
							xtc_db_query("insert into ".TABLE_CUSTOMERS_BASKET_ATTRIBUTES." (customers_id, products_id, products_options_id, products_options_value_id) values ('".$_SESSION['customer_id']."', '".xtc_db_input($products_id)."', '".xtc_db_input($option)."', '".xtc_db_input($value)."')");
						}
					}
				} else {
					xtc_db_query("update ".TABLE_CUSTOMERS_BASKET." set customers_basket_quantity = '".xtc_db_input($qty)."' where customers_id = '".$_SESSION['customer_id']."' and products_id = '".xtc_db_input($products_id)."'");
				}
			}
		}

		// reset per-session cart contents, but not the database contents
		$this->reset(false);

		$products_query = xtc_db_query("select products_id, customers_basket_quantity from ".TABLE_CUSTOMERS_BASKET." where customers_id = '".$_SESSION['customer_id']."'");
		while ($products = xtc_db_fetch_array($products_query)) {
			// BOF GM_MOD
			$t_gm_products_id = xtc_get_prid($products['products_id']);
			$t_gm_check_status = xtc_db_query("SELECT
													products_status,
													gm_price_status
												FROM " . TABLE_PRODUCTS . "
												WHERE products_id = '" . (int)$t_gm_products_id . "'");
			if(xtc_db_num_rows($t_gm_check_status) == 1)
			{
				$t_gm_status = xtc_db_fetch_array($t_gm_check_status);

				if($t_gm_status['products_status'] == 1 && (int)$t_gm_status['gm_price_status'] == 0)
				{
					$this->contents[$products['products_id']] = array ('qty' => $products['customers_basket_quantity']);
					// attributes
					$attributes_query = xtc_db_query("select products_options_id, products_options_value_id from ".TABLE_CUSTOMERS_BASKET_ATTRIBUTES." where customers_id = '".$_SESSION['customer_id']."' and products_id = '".xtc_db_input($products['products_id'])."'");
					while ($attributes = xtc_db_fetch_array($attributes_query)) {
						$this->contents[$products['products_id']]['attributes'][$attributes['products_options_id']] = $attributes['products_options_value_id'];
					}

					// assign a temporary unique ID to the order contents to prevent hack attempts during the checkout procedure
					$this->cartID = $this->generate_cart_id();
				}
				else
				{
					$this->remove($products['products_id']);
				}
			}
			// EOF GM_MOD
		}

		$this->cleanup();
	}

	function reset($reset_database = false) {

		$this->contents = array ();
		$this->total = 0;
		$this->weight = 0;
		$this->content_type = false;

		if (isset ($_SESSION['customer_id']) && ($reset_database == true)) {
			xtc_db_query("delete from ".TABLE_CUSTOMERS_BASKET." where customers_id = '".$_SESSION['customer_id']."'");
			xtc_db_query("delete from ".TABLE_CUSTOMERS_BASKET_ATTRIBUTES." where customers_id = '".$_SESSION['customer_id']."'");
		}

		unset ($this->cartID);
		if (isset ($_SESSION['cartID']))
			unset ($_SESSION['cartID']);
	}

	function add_cart($products_id, $qty = '1', $attributes = '', $notify = true, $p_products_properties_combis_id = 0) {
		global $new_products_id_in_cart;

		if(!preg_match('/[0-9]+\{[0-9]+\}[0-9{}]*x[0-9]+/', $products_id))
		{
			#GM_MOD:properties BOF
			$c_products_properties_combis_id = (int)$p_products_properties_combis_id;
			if($c_products_properties_combis_id == 0) #no combis_id given?
			{
				$coo_properties_control = MainFactory::create_object('PropertiesControl'); #check products_id for integrated combis_id
				$t_combis_id = $coo_properties_control->extract_combis_id($products_id);
				if($t_combis_id != '') $c_products_properties_combis_id = $t_combis_id;
			}

			$products_id = xtc_get_uprid($products_id, $attributes, $c_products_properties_combis_id);
			#GM_MOD:properties EOF
		}
		
		if ($notify == true) {
			$_SESSION['new_products_id_in_cart'] = $products_id;
		}

		if ($this->in_cart($products_id)) {
			$this->update_quantity($products_id, $qty, $attributes);
		} else {
			$this->contents[] = array ($products_id);
			$this->contents[$products_id] = array ('qty' => $qty);
			// insert into database
			if (isset ($_SESSION['customer_id']))
				xtc_db_query("insert into ".TABLE_CUSTOMERS_BASKET." (customers_id, products_id, customers_basket_quantity, customers_basket_date_added) values ('".$_SESSION['customer_id']."', '".xtc_db_input($products_id)."', '".xtc_db_input($qty)."', '".date('Ymd')."')");

			if (is_array($attributes)) {
				reset($attributes);
				while (list ($option, $value) = each($attributes)) {
					$this->contents[$products_id]['attributes'][$option] = $value;
					// insert into database
					if (isset ($_SESSION['customer_id']))
						xtc_db_query("insert into ".TABLE_CUSTOMERS_BASKET_ATTRIBUTES." (customers_id, products_id, products_options_id, products_options_value_id) values ('".$_SESSION['customer_id']."', '".xtc_db_input($products_id)."', '".xtc_db_input($option)."', '".xtc_db_input($value)."')");
				}
			}
		}
		$this->cleanup();

		// assign a temporary unique ID to the order contents to prevent hack attempts during the checkout procedure
		$this->cartID = $this->generate_cart_id();
	}

	function update_quantity($products_id, $quantity = '', $attributes = '') {

		if (empty ($quantity))
			return true; // nothing needs to be updated if theres no quantity, so we return true..

                // xs:booster start (v1.041)
               	$pid=strpos($products_id,"{")>0?substr($products_id,0,strpos($products_id,"{")):$products_id;
               	if(is_array($_SESSION['xtb0']['tx']))
                {
               	  $sum = 0; $cc = true;
               	  foreach($_SESSION['xtb0']['tx'] as $tx) {
                       	  if($tx['products_id']==$pid) {
                       		  $sum += $tx['XTB_QUANTITYPURCHASED'];
                                  if($tx['XTB_ALLOW_USER_CHQTY']=='false') $cc=false;
                          }
                  }
               	  if($quantity!=$sum&&$cc==false) $quantity=$sum;
               	}
                // xs:booster end


		$this->contents[$products_id] = array ('qty' => $quantity);
		// update database
		if (isset ($_SESSION['customer_id']))
			xtc_db_query("update ".TABLE_CUSTOMERS_BASKET." set customers_basket_quantity = '".xtc_db_input($quantity)."' where customers_id = '".$_SESSION['customer_id']."' and products_id = '".xtc_db_input($products_id)."'");

		if (is_array($attributes)) {
			reset($attributes);
			while (list ($option, $value) = each($attributes)) {
				$this->contents[$products_id]['attributes'][$option] = $value;
				// update database
				if (isset ($_SESSION['customer_id']))
					xtc_db_query("update ".TABLE_CUSTOMERS_BASKET_ATTRIBUTES." set products_options_value_id = '".(int)$value."' where customers_id = '".$_SESSION['customer_id']."' and products_id = '".xtc_db_input($products_id)."' and products_options_id = '".(int)$option."'");
			}
		}
	}

	function cleanup() {

		reset($this->contents);
		while (list ($key,) = each($this->contents)) {
			// BOF GM_MOD:
			if ($this->contents[$key]['qty'] <= 0) {
				unset ($this->contents[$key]);
				// remove from database
				if (xtc_session_is_registered('customer_id')) {
					xtc_db_query("delete from ".TABLE_CUSTOMERS_BASKET." where customers_id = '".$_SESSION['customer_id']."' and products_id = '".xtc_db_input($key)."'");
					xtc_db_query("delete from ".TABLE_CUSTOMERS_BASKET_ATTRIBUTES." where customers_id = '".$_SESSION['customer_id']."' and products_id = '".xtc_db_input($key)."'");
				}
			}
		}
	}

	function count_contents() { // get total number of items in cart
		$total_items = 0;
		if (is_array($this->contents)) {
			reset($this->contents);
			while (list ($products_id,) = each($this->contents)) {
				$total_items += $this->get_quantity($products_id);
			}
		}

		return $total_items;
	}

	function get_quantity($products_id) {
		if (isset ($this->contents[$products_id])) {
			return $this->contents[$products_id]['qty'];
		} else {
			return 0;
		}
	}

	function in_cart($products_id) {
		if (isset ($this->contents[$products_id])) {
			return true;
		} else {
			return false;
		}
	}

	function remove($products_id) {
		// BOF GM_MOD:
		unset($this->contents[$products_id]);
		// remove from database
		if (xtc_session_is_registered('customer_id')) {
			xtc_db_query("delete from ".TABLE_CUSTOMERS_BASKET." where customers_id = '".$_SESSION['customer_id']."' and products_id = '".xtc_db_input($products_id)."'");
			xtc_db_query("delete from ".TABLE_CUSTOMERS_BASKET_ATTRIBUTES." where customers_id = '".$_SESSION['customer_id']."' and products_id = '".xtc_db_input($products_id)."'");
		}

		// assign a temporary unique ID to the order contents to prevent hack attempts during the checkout procedure
		$this->cartID = $this->generate_cart_id();
	}

	function remove_all() {
		$this->reset();
	}

	function get_product_id_list() {
		$product_id_list = '';
		if (is_array($this->contents)) {
			reset($this->contents);
			while (list ($products_id,) = each($this->contents)) {
				$product_id_list .= ', '.$products_id;
			}
		}

		return substr($product_id_list, 2);
	}

	function calculate() {
		global $xtPrice;
		$this->total = 0;
		$this->weight = 0;
		$this->tax = array ();
		if (!is_array($this->contents))
			return 0;

		reset($this->contents);
		while (list ($products_id,) = each($this->contents)) {
			$qty = $this->contents[$products_id]['qty'];

			// products price
			$product_query = xtc_db_query("select products_id, products_price, products_discount_allowed, products_tax_class_id, products_weight from ".TABLE_PRODUCTS." where products_id='".xtc_db_input(xtc_get_prid($products_id))."'");
			if ($product = xtc_db_fetch_array($product_query)) {

				$products_price = $xtPrice->xtcGetPrice($product['products_id'], $format = false, $qty, $product['products_tax_class_id'], $product['products_price']);
				$products_price = $products_price + $this->properties_price($products_id); #GM_MOD
				$this->total += $products_price * $qty;

				# set combis weight
				$t_properties_weight = $this->properties_weight($products_id, $product['products_weight']);
				if($t_properties_weight == 0)
				{
					$t_properties_weight = $product['products_weight'];
				}
				$this->weight += ($qty * $t_properties_weight);

				// attributes price
				$attribute_price = 0;
				if (isset ($this->contents[$products_id]['attributes'])) {
					reset($this->contents[$products_id]['attributes']);
					while (list ($option, $value) = each($this->contents[$products_id]['attributes'])) {
						
                                            $values = $xtPrice->xtcGetOptionPrice($product['products_id'], $option, $value);
						if ($xtPrice->xtcCheckDiscount($products_id) && $xtPrice->cStatus['customers_status_discount_attributes']=="1"){
							$discount = $xtPrice->xtcCheckDiscount($product['products_id']);
							$values['price'] = $values['price'] / 100 * $discount;
						}
						
						$this->weight += $values['weight'] * $qty;
						$this->total += $values['price'] * $qty;
						$attribute_price+=$values['price'];
					}
				}



				if ($product['products_tax_class_id'] != 0) {

					if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == 1) {
						$products_price_tax = $products_price - ($products_price / 100 * $_SESSION['customers_status']['customers_status_ot_discount']);
						$attribute_price_tax = $attribute_price - ($attribute_price / 100 * $_SESSION['customers_status']['customers_status_ot_discount']);
					}


					$products_tax = $xtPrice->TAX[$product['products_tax_class_id']];
					$products_tax_description = xtc_get_tax_description($product['products_tax_class_id']);


					// price incl tax
					if ($_SESSION['customers_status']['customers_status_show_price_tax'] == '1') {
						if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == 1) {
							$this->tax[$product['products_tax_class_id']]['value'] += ((($products_price_tax+$attribute_price_tax) / (100 + $products_tax)) * $products_tax)*$qty;
							$this->tax[$product['products_tax_class_id']]['desc'] = sprintf(TAX_INFO_INCL, $products_tax.'%');
						} else {
							$this->tax[$product['products_tax_class_id']]['value'] += ((($products_price+$attribute_price) / (100 + $products_tax)) * $products_tax)*$qty;
							$this->tax[$product['products_tax_class_id']]['desc'] = sprintf(TAX_INFO_INCL, $products_tax.'%');
						}
					}

					// excl tax + tax at checkout
					if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
						if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == 1) {
							$this->tax[$product['products_tax_class_id']]['value'] += (($products_price_tax+$attribute_price_tax) / 100) * ($products_tax)*$qty;
							$this->total+=(($products_price_tax+$attribute_price_tax) / 100) * ($products_tax)*$qty;
							$this->tax[$product['products_tax_class_id']]['desc'] = sprintf(TAX_INFO_EXCL, $products_tax.'%');
						} else {
							$this->tax[$product['products_tax_class_id']]['value'] += (($products_price+$attribute_price) / 100) * ($products_tax)*$qty;
							$this->total+= (($products_price+$attribute_price) / 100) * ($products_tax)*$qty;
							$this->tax[$product['products_tax_class_id']]['desc'] = sprintf(TAX_INFO_EXCL, $products_tax.'%');
						}
					}
				}
			}

		}
//		echo 'total_VOR'.$this->total;
		if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] != 0) {
//			$this->total -= $this->total / 100 * $_SESSION['customers_status']['customers_status_ot_discount'];
		}
//		echo 'total_NACH'.$this->total;

	}

	function attributes_price($products_id) {
		global $xtPrice;
		if (isset ($this->contents[$products_id]['attributes'])) {
			reset($this->contents[$products_id]['attributes']);
			while (list ($option, $value) = each($this->contents[$products_id]['attributes'])) {

				$values = $xtPrice->xtcGetOptionPrice($products_id, $option, $value);
				if ($xtPrice->xtcCheckDiscount($products_id) && $xtPrice->cStatus['customers_status_discount_attributes']=="1"){
							$discount = $xtPrice->xtcCheckDiscount($products_id);
							$values['price'] = $values['price'] / 100 * $discount;
						}
				
				$attributes_price += $values['price'];

			}
		}
		return $attributes_price;
	}

	function properties_price($p_products_id) #parameter sample: 1x46
	{
		global $xtPrice;
		$t_output_price = 0;

		$coo_properties_control = MainFactory::create_object('PropertiesControl');
		$t_combis_id = $coo_properties_control->extract_combis_id($p_products_id);

		if($t_combis_id != '')
		{
			$t_output_price = $coo_properties_control->get_properties_combis_price($t_combis_id);
			$t_output_price = $xtPrice->xtcCalculateCurr($t_output_price);
		}
		return $t_output_price;
	}

	function properties_weight($p_products_id, $p_old_weight) #parameter sample: 1x46
	{
		$t_output_weight = 0;

		$coo_properties_control = MainFactory::create_object('PropertiesControl');
		$t_combis_id = $coo_properties_control->extract_combis_id($p_products_id);

		if($t_combis_id != '')
		{
			$t_combis_weight = $coo_properties_control->get_properties_combis_weight($t_combis_id);

			$coo_data_object = MainFactory::create_object('GMDataObject', array('products', array('products_id' => $p_products_id) ));
			if($coo_data_object->get_data_value('use_properties_combis_weight') == 0)
			{
				# 0 = keep old products_weight and add new combis_weight
				$t_output_weight = $p_old_weight + $t_combis_weight;
			}
			else {
				# 1 = replace old products_weight and use new combis_weight only
				$t_output_weight = $t_combis_weight;
			}
		}
		//echo($t_output_weight).'x';
		return $t_output_weight;
	}

	function get_products() {
		global $xtPrice,$main;
		if (!is_array($this->contents))
			return false;

		$products_array = array ();
		reset($this->contents);
		while (list ($products_id,) = each($this->contents)) {
			if($this->contents[$products_id]['qty'] != 0 || $this->contents[$products_id]['qty'] !=''){

				$products_query = xtc_db_query("SELECT
													p.products_id,
													pd.products_name,
													p.products_shippingtime,
													p.products_image,
													p.products_model,
													p.products_price,
													p.products_discount_allowed,
													p.products_weight,
													p.products_tax_class_id ,
													qud.quantity_unit_id,
													qud.unit_name
												FROM
													" . TABLE_PRODUCTS . " p
													LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " pd USING (products_id)
													LEFT JOIN products_quantity_unit pqu USING (products_id)
													LEFT JOIN quantity_unit_description qud ON (pqu.quantity_unit_id = qud.quantity_unit_id AND qud.language_id = '" . (int)$_SESSION['languages_id'] . "')
												WHERE
													p.products_id='".xtc_db_input(xtc_get_prid($products_id))."' AND
													pd.products_id = p.products_id AND
													pd.language_id = '".$_SESSION['languages_id']."'");
				if(xtc_db_num_rows($products_query) == 1)
				{
					$products = xtc_db_fetch_array($products_query);
					$prid = $products['products_id'];

				$products_price = $xtPrice->xtcGetPrice($products['products_id'], $format = false, $this->contents[$products_id]['qty'], $products['products_tax_class_id'], $products['products_price']);
				// BOF GM_MOD:
					$products_price = $xtPrice->xtcGetPrice(
													$products['products_id'],
													$format = false,
													$this->contents[$products_id]['qty'],
													$products['products_tax_class_id'],
													$products['products_price']
												);
					# add attributes price
					$products_price = $products_price + $this->attributes_price($products_id);
					$products_price = $products_price + $this->properties_price($products_id); #GM_MOD

					# set combis weight
					$t_properties_weight = $this->properties_weight($products_id, $products['products_weight']);
					if($t_properties_weight == 0) 
					{
						$t_properties_weight = $products['products_weight'];
					}

					$products_array[] = array(
											'id' => $products_id,
											'name' => $products['products_name'],
											'model' => $products['products_model'],
											'image' => $products['products_image'],
											'price' => $products_price,
											'quantity' => $this->contents[$products_id]['qty'],
											'weight' => $t_properties_weight,
											'shipping_time' => $main->getShippingStatusName($products['products_shippingtime']),
											'final_price' => ($products_price),
											'tax_class_id' => $products['products_tax_class_id'],
											'quantity_unit_id' => $products['quantity_unit_id'],
											'unit_name' => $products['unit_name'],
											'attributes' => $this->contents[$products_id]['attributes']
										);
				}
			}
		}

		return $products_array;
	}

	function show_total() {
		$this->calculate();

		return $this->total;
	}

	function show_weight() {
		$this->calculate();

		return $this->weight;
	}

	function show_tax($format = true) {
		global $xtPrice;
		$this->calculate();
		$output = "";
		$val=0;
		foreach ($this->tax as $key => $value) {
			if ($this->tax[$key]['value'] > 0 ) {
			$output .= $this->tax[$key]['desc'].": ".$xtPrice->xtcFormat($this->tax[$key]['value'], true)."<br />";
			$val = $this->tax[$key]['value'];
			}
		}
		if ($format) {
		return $output;
		} else {
			return $val;
		}
	}

	function generate_cart_id($length = 5) {
		return xtc_create_random_value($length, 'digits');
	}

	function get_content_type() {
		$this->content_type = false;

		if ((DOWNLOAD_ENABLED == 'true') && ($this->count_contents() > 0)) {
			reset($this->contents);
			while (list ($products_id,) = each($this->contents)) {
				if (isset ($this->contents[$products_id]['attributes'])) {
					reset($this->contents[$products_id]['attributes']);
					while (list (, $value) = each($this->contents[$products_id]['attributes'])) {
						$virtual_check_query = xtc_db_query("select count(*) as total from ".TABLE_PRODUCTS_ATTRIBUTES." pa, ".TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD." pad where pa.products_id = '".xtc_db_input($products_id)."' and pa.options_values_id = '".xtc_db_input($value)."' and pa.products_attributes_id = pad.products_attributes_id");
						$virtual_check = xtc_db_fetch_array($virtual_check_query);

						if ($virtual_check['total'] > 0) {
							switch ($this->content_type) {
								case 'physical' :
									$this->content_type = 'mixed';
									return $this->content_type;
									break;

								default :
									$this->content_type = 'virtual';
									break;
							}
						} else {
							switch ($this->content_type) {
								case 'virtual' :
									$this->content_type = 'mixed';
									return $this->content_type;
									break;

								default :
									$this->content_type = 'physical';
									break;
							}
						}
					}
				} else {
					switch ($this->content_type) {
						case 'virtual' :
							$this->content_type = 'mixed';
							return $this->content_type;
							break;

						default :
							$this->content_type = 'physical';
							break;
					}
				}
			}
		} else {
			$this->content_type = 'physical';
		}
		return $this->content_type;
	}

	function unserialize($broken) {
		for (reset($broken); $kv = each($broken);) {
			$key = $kv['key'];
			if (gettype($this-> $key) != "user function")
				$this-> $key = $kv['value'];
		}
	}
	// GV Code Start
	// ------------------------ ICW CREDIT CLASS Gift Voucher Addittion-------------------------------Start
	// amend count_contents to show nil contents for shipping
	// as we don't want to quote for 'virtual' item
	// GLOBAL CONSTANTS if NO_COUNT_ZERO_WEIGHT is true then we don't count any product with a weight
	// which is less than or equal to MINIMUM_WEIGHT
	// otherwise we just don't count gift certificates

	function count_contents_virtual() { // get total number of items in cart disregard gift vouchers and downloads
		$total_items = 0;
		if (is_array($this->contents)) {
			reset($this->contents);
			while (list ($products_id,) = each($this->contents)) {
				$no_count = false;
				$gv_query = xtc_db_query("select products_model from ".TABLE_PRODUCTS." where products_id = '".xtc_db_input($products_id)."'");
				$gv_result = xtc_db_fetch_array($gv_query);
				if (preg_match('/^GIFT/', $gv_result['products_model'])) {
					$no_count = true;
				}
				if (NO_COUNT_ZERO_WEIGHT == 1) {
					$gv_query = xtc_db_query("select products_weight from ".TABLE_PRODUCTS." where products_id = '".xtc_db_input(xtc_get_prid($products_id))."'");
					$gv_result = xtc_db_fetch_array($gv_query);
					if ($gv_result['products_weight'] <= MINIMUM_WEIGHT) {
						$no_count = true;
					}
				}

				// check if product is a download
				if (isset ($this->contents[$products_id]['attributes'])) {
					reset($this->contents[$products_id]['attributes']);
					while (list (, $value) = each($this->contents[$products_id]['attributes'])) {
						$virtual_check_query = xtc_db_query("select count(*) as total from ".TABLE_PRODUCTS_ATTRIBUTES." pa, ".TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD." pad where pa.products_id = '".xtc_db_input($products_id)."' and pa.options_values_id = '".xtc_db_input($value)."' and pa.products_attributes_id = pad.products_attributes_id");
						$virtual_check = xtc_db_fetch_array($virtual_check_query);

						if ($virtual_check['total'] > 0) {
							$no_count = true;
						}
					}
				}

				if (!$no_count)
					$total_items += $this->get_quantity($products_id);
			}
		}
		return $total_items;
	}
	// ------------------------ ICW CREDIT CLASS Gift Voucher Addittion-------------------------------End
	//GV Code End
}
?>