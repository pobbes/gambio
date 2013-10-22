<?php
/* --------------------------------------------------------------
   xtcPrice.php 2008-11-27 gm
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(currencies.php,v 1.15 2003/03/17); www.oscommerce.com
   (c) 2003         nextcommerce (currencies.php,v 1.9 2003/08/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: xtcPrice.php 1316 2005-10-21 15:30:58Z mz $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class xtcPrice_ORIGIN {
	var $currencies;

	// class constructor
	function xtcPrice_ORIGIN($currency, $cGroup) {

		$this->currencies = array ();
		$this->cStatus = array ();
		$this->actualGroup = $cGroup;
		$this->actualCurr = $currency;
		$this->TAX = array ();
		$this->SHIPPING = array();
		$this->showFrom_Attributes = true;
		// BOF GM_MOD:
		$this->content_type = null;

		// select Currencies

		$currencies_query = "SELECT *
				                                    FROM
				                                         ".TABLE_CURRENCIES;
		$currencies_query = xtDBquery($currencies_query);
		while ($currencies = xtc_db_fetch_array($currencies_query, true)) {
			$this->currencies[$currencies['code']] = array ('title' => $currencies['title'], 'symbol_left' => $currencies['symbol_left'], 'symbol_right' => $currencies['symbol_right'], 'decimal_point' => $currencies['decimal_point'], 'thousands_point' => $currencies['thousands_point'], 'decimal_places' => $currencies['decimal_places'], 'value' => $currencies['value']);
		}
		// select Customers Status data
		$customers_status_query = "SELECT *
				                                        FROM
				                                             ".TABLE_CUSTOMERS_STATUS."
				                                        WHERE
				                                             customers_status_id = '".$this->actualGroup."' AND language_id = '".$_SESSION['languages_id']."'";
		$customers_status_query = xtDBquery($customers_status_query);
		$customers_status_value = xtc_db_fetch_array($customers_status_query, true);
		$this->cStatus = array ('customers_status_id' => $this->actualGroup, 'customers_status_name' => $customers_status_value['customers_status_name'], 'customers_status_image' => $customers_status_value['customers_status_image'], 'customers_status_public' => $customers_status_value['customers_status_public'], 'customers_status_discount' => $customers_status_value['customers_status_discount'], 'customers_status_ot_discount_flag' => $customers_status_value['customers_status_ot_discount_flag'], 'customers_status_ot_discount' => $customers_status_value['customers_status_ot_discount'], 'customers_status_graduated_prices' => $customers_status_value['customers_status_graduated_prices'], 'customers_status_show_price' => $customers_status_value['customers_status_show_price'], 'customers_status_show_price_tax' => $customers_status_value['customers_status_show_price_tax'], 'customers_status_add_tax_ot' => $customers_status_value['customers_status_add_tax_ot'], 'customers_status_payment_unallowed' => $customers_status_value['customers_status_payment_unallowed'], 'customers_status_shipping_unallowed' => $customers_status_value['customers_status_shipping_unallowed'], 'customers_status_discount_attributes' => $customers_status_value['customers_status_discount_attributes'], 'customers_fsk18' => $customers_status_value['customers_fsk18'], 'customers_fsk18_display' => $customers_status_value['customers_fsk18_display']);

		// prefetch tax rates for standard zone
		$zones_query = xtDBquery("SELECT tax_class_id as class FROM ".TABLE_TAX_CLASS);
		while ($zones_data = xtc_db_fetch_array($zones_query,true)) {

			// calculate tax based on shipping or deliverey country (for downloads)
			if (isset($_SESSION['billto']) && isset($_SESSION['sendto'])) {
				$content_type = null;
				if(isset($_SESSION['cart']) && method_exists($_SESSION['cart'],'get_content_type')) {
					$content_type = $_SESSION['cart']->get_content_type();
				}
				$tax_address_query = xtc_db_query("select ab.entry_country_id, ab.entry_zone_id from " . TABLE_ADDRESS_BOOK . " ab left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id) where ab.customers_id = '" . $_SESSION['customer_id'] . "' and ab.address_book_id = '" . ($content_type == 'virtual' ? xtc_db_input($_SESSION['billto']) : xtc_db_input($_SESSION['sendto'])) . "'");
				$tax_address = xtc_db_fetch_array($tax_address_query);
				$this->TAX[$zones_data['class']]=xtc_get_tax_rate($zones_data['class'],$tax_address['entry_country_id'], $tax_address['entry_zone_id']);
			} else {
				$this->TAX[$zones_data['class']]=xtc_get_tax_rate($zones_data['class']);
			}


		}

	}

	// get products Price
	function xtcGetPrice($pID, $format = true, $qty, $tax_class, $pPrice, $vpeStatus = 0, $cedit_id = 0) {

		// check if group is allowed to see prices
		// BOF GM_MOD:
		if ($this->cStatus['customers_status_show_price'] == '0' && $this->gm_check_price_status($pID) != 1)
			return $this->xtcShowNote($vpeStatus, $vpeStatus);

		// BOF GM_MOD
		// check price status
		if($this->gm_check_price_status($pID) != 0){
			if($this->gm_check_price_status($pID) == 2){
				$gm_pPrice = $this->getPprice($pID);
				if($gm_pPrice == 0) return $this->gm_show_price_status($this->gm_check_price_status($pID), $vpeStatus);
			}
			else return $this->gm_show_price_status($this->gm_check_price_status($pID), $vpeStatus);
		};

		// EOF GM_MOD

		// get Tax rate
		if ($cedit_id != 0) {
			$cinfo = xtc_oe_customer_infos($cedit_id);
			$products_tax = xtc_get_tax_rate($tax_class, $cinfo['country_id'], $cinfo['zone_id']);
		} else {
			$products_tax = $this->TAX[$tax_class];
		}

		if ($this->cStatus['customers_status_show_price_tax'] == '0')
			$products_tax = '';

		// add taxes
		if ($pPrice == 0)
			$pPrice = $this->getPprice($pID);
		$pPrice = $this->xtcAddTax($pPrice, $products_tax);

		// xs:booster Auktionspreis pruefen
		if ($sPrice = $this->xtcCheckXTBAuction($pID))
			return $this->xtcFormatSpecial($pID, $sPrice, $pPrice, $format, $vpeStatus);

		// check specialprice
		if ($sPrice = $this->xtcCheckSpecial($pID))
			return $this->xtcFormatSpecial($pID, $this->xtcAddTax($sPrice, $products_tax), $pPrice, $format, $vpeStatus);

		// check graduated
		if ($this->cStatus['customers_status_graduated_prices'] == '1') {
			// BOF GM_MOD
			if ($sPrice = $this->xtcGetGraduatedPrice($pID, $qty)){
				$gm_sPrice = $sPrice/100 * $products_tax + $sPrice;
				$gm_sPrice = $this->xtcCalculateCurr($gm_sPrice);
				$gm_sPrice = $this->xtcFormat($gm_sPrice, false);
				if ($gm_sPrice >= $pPrice) $pPrice = $gm_sPrice;
				else return $this->xtcFormatSpecialGraduated($pID, $this->xtcAddTax($sPrice, $products_tax), $pPrice, $format, $vpeStatus, $pID);
			}
			// EOF GM_MOD
		} else {
			// check Group Price
			// BOF GM_MOD
			if ($sPrice = $this->xtcGetGroupPrice($pID, 1)){
				$gm_sPrice = $sPrice/100 * $products_tax + $sPrice;
				$gm_sPrice = $this->xtcCalculateCurr($gm_sPrice);
				$gm_sPrice = $this->xtcFormat($gm_sPrice, false);
				if ($gm_sPrice >= $pPrice) $pPrice = $gm_sPrice;
				else return $this->xtcFormatSpecialGraduated($pID, $this->xtcAddTax($sPrice, $products_tax), $pPrice, $format, $vpeStatus, $pID);
			}
			// EOF GM_MOD
		}

		// check Product Discount
		if ($discount = $this->xtcCheckDiscount($pID))
			return $this->xtcFormatSpecialDiscount($pID, $discount, $pPrice, $format, $vpeStatus);

		return $this->xtcFormat($pPrice, $format, 0, false, $vpeStatus, $pID);

	}

	// BOF GM_MOD
	function gm_check_price_status($pID){
		$price_status = array();
		$get_price_status = xtc_db_query("SELECT gm_price_status FROM products WHERE products_id = '" . (int)$pID . "'");
		if(xtc_db_num_rows($get_price_status) == 1){
			$price_status = xtc_db_fetch_array($get_price_status);
		}
		return $price_status['gm_price_status'];
	}

	function gm_show_price_status($price_status, $vpeStatus){
		switch($price_status){
			case 1:
				if($vpeStatus == 1) return array('formated' => GM_SHOW_PRICE_ON_REQUEST, 'plain' => 0);
				else return 0;
				break;
			case 2:
				if($vpeStatus == 1) return array('formated' => GM_SHOW_NO_PRICE, 'plain' => 0);
				else return 0;
				break;
			default:
				return false;
		}
	}
	// EOF GM_MOD

	function getPprice($pID) {
		$pQuery = "SELECT products_price FROM ".TABLE_PRODUCTS." WHERE products_id='".(int)$pID."'";
		$pQuery = xtDBquery($pQuery);
		$pData = xtc_db_fetch_array($pQuery, true);
		return $pData['products_price'];


	}

	function xtcAddTax($price, $tax) {
		$price = $price + $price / 100 * $tax;
		$price = $this->xtcCalculateCurr($price);
		return round($price, $this->currencies[$this->actualCurr]['decimal_places']);
	}

        // xs:booster start (v1.041)
        function xtcCheckXTBAuction($pID)
        {
			if(isset($_SESSION['xtb0']))
			{
                if(($pos=strpos($pID,"{"))) $pID=substr($pID,0,$pos);
                if(!is_array($_SESSION['xtb0']['tx'])) return false;
                foreach($_SESSION['xtb0']['tx'] as $tx) {
                        if($tx['products_id']==$pID&&$tx['XTB_QUANTITYPURCHASED']!=0) {
                                 $this->actualCurr=$tx['XTB_AMOUNTPAID_CURRENCY'];
                                 return round($tx['XTB_AMOUNTPAID'], $this->currencies[$this->actualCurr]['decimal_places']);
                        }
                }
			}

			return false;
        }
        // xs:booster end

	function xtcCheckDiscount($pID) {

		// check if group got discount
		if ($this->cStatus['customers_status_discount'] != '0.00') {

			$discount_query = "SELECT products_discount_allowed FROM ".TABLE_PRODUCTS." WHERE products_id = '".(int)$pID."'";
			$discount_query = xtDBquery($discount_query);
			$dData = xtc_db_fetch_array($discount_query, true);

			$discount = $dData['products_discount_allowed'];
			if ($this->cStatus['customers_status_discount'] < $discount)
				$discount = $this->cStatus['customers_status_discount'];
			if ($discount == '0.00')
				return false;
			return $discount;

		}
		return false;
	}

	function xtcGetGraduatedPrice($pID, $qty) {
		if (GRADUATED_ASSIGN == 'true')
			if (xtc_get_qty($pID) > $qty)
				$qty = xtc_get_qty($pID);
		//if (!is_int($this->cStatus['customers_status_id']) && $this->cStatus['customers_status_id']!=0) $this->cStatus['customers_status_id'] = DEFAULT_CUSTOMERS_STATUS_ID_GUEST;
		$graduated_price_query = "SELECT max(quantity) as qty
				                                FROM ".TABLE_PERSONAL_OFFERS_BY.$this->actualGroup."
				                                WHERE products_id='".(int)$pID."'
				                                AND quantity<='".xtc_db_input($qty)."'";
		$graduated_price_query = xtDBquery($graduated_price_query);
		$graduated_price_data = xtc_db_fetch_array($graduated_price_query, true);
		if ($graduated_price_data['qty']) {
			$graduated_price_query = "SELECT personal_offer
						                                FROM ".TABLE_PERSONAL_OFFERS_BY.$this->actualGroup."
						                                WHERE products_id='".(int)$pID."'
						                                AND quantity='".$graduated_price_data['qty']."'";
			$graduated_price_query = xtDBquery($graduated_price_query);
			$graduated_price_data = xtc_db_fetch_array($graduated_price_query, true);

			$sPrice = $graduated_price_data['personal_offer'];
			if ($sPrice != 0.00)
				return $sPrice;
		} else {
			return;
		}

	}

	function xtcGetGroupPrice($pID, $qty) {

		$graduated_price_query = "SELECT max(quantity) as qty
				                                FROM ".TABLE_PERSONAL_OFFERS_BY.$this->actualGroup."
				                                WHERE products_id='".(int)$pID."'
				                                AND quantity<='".xtc_db_input($qty)."'";
		$graduated_price_query = xtDBquery($graduated_price_query);
		$graduated_price_data = xtc_db_fetch_array($graduated_price_query, true);
		if ($graduated_price_data['qty']) {
			$graduated_price_query = "SELECT personal_offer
						                                FROM ".TABLE_PERSONAL_OFFERS_BY.$this->actualGroup."
						                                WHERE products_id='".(int)$pID."'
						                                AND quantity='".xtc_db_input($graduated_price_data['qty'])."'";
			$graduated_price_query = xtDBquery($graduated_price_query);
			$graduated_price_data = xtc_db_fetch_array($graduated_price_query, true);

			$sPrice = $graduated_price_data['personal_offer'];
			if ($sPrice != 0.00)
				return $sPrice;
		} else {
			return;
		}

	}

	function xtcGetOptionPrice($pID, $option, $value) {
		$attribute_price_query = "select pd.products_discount_allowed,pd.products_tax_class_id, p.options_values_price, p.price_prefix, p.options_values_weight, p.weight_prefix from ".TABLE_PRODUCTS_ATTRIBUTES." p, ".TABLE_PRODUCTS." pd where p.products_id = '".(int)$pID."' and p.options_id = '".(int)$option."' and pd.products_id = p.products_id and p.options_values_id = '".(int)$value."'";
		$attribute_price_query = xtDBquery($attribute_price_query);
		$attribute_price_data = xtc_db_fetch_array($attribute_price_query, true);
		$discount = 0; // BOF GM_MOD
		if ($this->cStatus['customers_status_discount_attributes'] == 1 && $this->cStatus['customers_status_discount'] != 0.00) {
			$discount = $this->cStatus['customers_status_discount'];
			if ($attribute_price_data['products_discount_allowed'] < $this->cStatus['customers_status_discount'])
				$discount = $attribute_price_data['products_discount_allowed'];
		}
		// BOF GM_MOD
		if($attribute_price_data['products_tax_class_id'] != 0) $price = $this->xtcFormat($attribute_price_data['options_values_price'], false, $attribute_price_data['products_tax_class_id']);
		else $price = $this->xtcFormat($attribute_price_data['options_values_price'], false, $attribute_price_data['products_tax_class_id'], true);
		// EOF GM_MOD
		if ($attribute_price_data['weight_prefix'] != '+')
			$attribute_price_data['options_values_weight'] *= -1;
		if ($attribute_price_data['price_prefix'] == '+') {
			$price = $price - $price / 100 * $discount;
		} else {
			// BOF GM_MOD:
			$price = ($price - $price / 100 * $discount) * -1;
		}

		return array ('weight' => $attribute_price_data['options_values_weight'], 'price' => $price);
	}

	function xtcShowNote($vpeStatus, $vpeStatus = 0) {
		if ($vpeStatus == 1)
			return array ('formated' => NOT_ALLOWED_TO_SEE_PRICES, 'plain' => 0);
		return NOT_ALLOWED_TO_SEE_PRICES;
	}

	function xtcCheckSpecial($pID) {
		$product_query = "select specials_new_products_price from ".TABLE_SPECIALS." where products_id = '".(int)$pID."' and status=1";
		$product_query = xtDBquery($product_query);
		$product = xtc_db_fetch_array($product_query, true);

		return $product['specials_new_products_price'];

	}

	function xtcCalculateCurr($price) {
		return $this->currencies[$this->actualCurr]['value'] * $price;
	}

	function calcTax($price, $tax) {
		return $price * $tax / 100;
	}

	function xtcRemoveCurr($price) {

		// check if used Curr != DEFAULT curr
		if (DEFAULT_CURRENCY != $this->actualCurr) {
			return $price * (1 / $this->currencies[$this->actualCurr]['value']);
		} else {
			return $price;
		}

	}

	function xtcRemoveTax($price, $tax) {
		$price = ($price / (($tax +100) / 100));
		return $price;
	}

	function xtcGetTax($price, $tax) {
		$tax = $price - $this->xtcRemoveTax($price, $tax);
		return $tax;
	}

	function xtcRemoveDC($price,$dc) {

		$price = $price - ($price/100*$dc);

		return $price;
	}

	function xtcGetDC($price,$dc) {

		$dc = $price/100*$dc;

		return $dc;
	}

	function checkAttributes($pID) {
		if (!$this->showFrom_Attributes) return;
		if ($pID == 0)
			return;
		$products_attributes_query = "SELECT COUNT(*) AS total
										FROM
											" . TABLE_PRODUCTS_OPTIONS . " popt,
											" . TABLE_PRODUCTS_ATTRIBUTES . " patrib
										WHERE
											patrib.products_id = '" . (int)$pID . "' AND
											patrib.options_id = popt.products_options_id AND
											patrib.options_values_price > 0 AND
											popt.language_id = '" . (int)$_SESSION['languages_id'] . "'";
		$products_attributes = xtDBquery($products_attributes_query);
		$products_attributes = xtc_db_fetch_array($products_attributes, true);
		if ($products_attributes['total'] > 0)
			return ' '.strtolower(FROM).' ';
	}

	function xtcCalculateCurrEx($price, $curr) {
		return $price * ($this->currencies[$curr]['value'] / $this->currencies[$this->actualCurr]['value']);
	}

	/*
	*
	*    Format Functions
	*
	*
	*
	*/

	function xtcFormat($price, $format, $tax_class = 0, $curr = false, $vpeStatus = 0, $pID = 0) {

		if ($curr)
			$price = $this->xtcCalculateCurr($price);

		if ($tax_class != 0) {
			$products_tax = $this->TAX[$tax_class];
			if ($this->cStatus['customers_status_show_price_tax'] == '0')
				$products_tax = '';
			$price = $this->xtcAddTax($price, $products_tax);
		}

		if ($format) {
			$Pprice = number_format((double)$price, (double)$this->currencies[$this->actualCurr]['decimal_places'], $this->currencies[$this->actualCurr]['decimal_point'], $this->currencies[$this->actualCurr]['thousands_point']);
			$Pprice = $this->checkAttributes($pID).$this->currencies[$this->actualCurr]['symbol_left'].' '.$Pprice.' '.$this->currencies[$this->actualCurr]['symbol_right'];
			if ($vpeStatus == 0) {
				return $Pprice;
			} else {
				return array ('formated' => $Pprice, 'plain' => $price);
			}
		} else {

			return round($price, $this->currencies[$this->actualCurr]['decimal_places']);

		}

	}

	function xtcFormatSpecialDiscount($pID, $discount, $pPrice, $format, $vpeStatus = 0, $p_attributes_price = 0) {
		$sPrice = $pPrice - ($pPrice / 100) * $discount + $p_attributes_price;
		if ($format) {
			// BOF GM_MOD:
			$price = '<span class="productOldPrice">'.INSTEAD.$this->xtcFormat($pPrice+$p_attributes_price, $format).'</span><br />'.ONLY.$this->checkAttributes($pID).$this->xtcFormat($sPrice, $format).'<br />'.YOU_SAVE.round($discount, 2).'%';
			if ($vpeStatus == 0) {
				return $price;
			} else {
				return array ('formated' => $price, 'plain' => $sPrice);
			}
		} else {
			return round($sPrice, $this->currencies[$this->actualCurr]['decimal_places']);
		}
	}

	function xtcFormatSpecial($pID, $sPrice, $pPrice, $format, $vpeStatus = 0) {
		if ($format) {
			$price = '<span class="productOldPrice">'.INSTEAD.$this->xtcFormat($pPrice, $format).'</span><br />'.ONLY.$this->checkAttributes($pID).$this->xtcFormat($sPrice, $format);
			if ($vpeStatus == 0) {
				return $price;
			} else {
				return array ('formated' => $price, 'plain' => $sPrice);
			}
		} else {
			return round($sPrice, $this->currencies[$this->actualCurr]['decimal_places']);
		}
	}

	function xtcFormatSpecialGraduated($pID, $sPrice, $pPrice, $format, $vpeStatus = 0, $pID) {
		if ($pPrice == 0) return $this->xtcFormat($sPrice, $format, 0, false, $vpeStatus);
		// BOF GM_MOD
		$discount = $this->xtcCheckDiscount($pID);
		if ($discount) $sPrice -= $sPrice / 100 * $discount;
		if ($sPrice != $pPrice && $discount) {
			return $this->xtcFormatSpecialDiscount($pID, $discount, $pPrice, $format, $vpeStatus);
		}
		// EOF GM_MOD
		if ($format) {
			if ($sPrice != $pPrice) {
				$price = '<span class="productOldPrice">'.MSRP.$this->xtcFormat($pPrice, $format).'</span><br />'.YOUR_PRICE;
				if(gm_get_conf('GM_HIDE_MSRP') == '1')
				{
					$price = '';
				}
				$price .= $this->checkAttributes($pID).$this->xtcFormat($sPrice, $format);
			} else {
				$price = $this->checkAttributes($pID).$this->xtcFormat($sPrice, $format);
			}
			if ($vpeStatus == 0) {
				return $price;
			} else {
				return array ('formated' => $price, 'plain' => $sPrice);
			}
		} else {
			return round($sPrice, $this->currencies[$this->actualCurr]['decimal_places']);
		}
	}

	function get_decimal_places($code) {
		return $this->currencies[$this->actualCurr]['decimal_places'];
	}

}
?>