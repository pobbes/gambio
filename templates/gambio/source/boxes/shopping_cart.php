<?php
/* --------------------------------------------------------------
   shopping_cart.php 2008-08-05 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(shopping_cart.php,v 1.18 2003/02/10); www.oscommerce.com
   (c) 2003	 nextcommerce (shopping_cart.php,v 1.15 2003/08/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: shopping_cart.php 1281 2005-10-03 09:30:17Z mz $) 

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
$box_smarty = new smarty;
$box_smarty->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
$box_content = '';
$box_price_string = '';
// include needed files
require_once (DIR_FS_INC.'xtc_recalculate_price.inc.php');

// BOF GM_MOD
$box_smarty->assign('GM_CART_ON_TOP', gm_get_conf('GM_CART_ON_TOP'));
$smarty->assign('GM_CART_ON_TOP', gm_get_conf('GM_CART_ON_TOP'));
// EOF GM_MOD

if (strstr($PHP_SELF, FILENAME_CHECKOUT_PAYMENT) or strstr($PHP_SELF, FILENAME_CHECKOUT_CONFIRMATION) or strstr($PHP_SELF, FILENAME_CHECKOUT_SHIPPING))
	$box_smarty->assign('deny_cart', 'true');

if ($_SESSION['cart']->count_contents() > 0) {
	$products = $_SESSION['cart']->get_products();
	$products_in_cart = array ();
	$qty = 0;
	for ($i = 0, $n = sizeof($products); $i < $n; $i ++) {
		$qty += $products[$i]['quantity'];
		$products_in_cart[] = array ('QTY' => $products[$i]['quantity'], 
									 'LINK' => xtc_href_link(FILENAME_PRODUCT_INFO, xtc_product_link($products[$i]['id'],$products[$i]['name'])), 
									 'NAME' => $products[$i]['name']);

	}
	$box_smarty->assign('PRODUCTS', $qty);
	$box_smarty->assign('empty', 'false');
} else {
	// cart empty
	$box_smarty->assign('empty', 'true');
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
	$box_smarty->assign('DISCOUNT', $xtPrice->xtcFormat(($discount * (-1)), $price_special = 1, $calculate_currencies = false));
	
}


if ($_SESSION['customers_status']['customers_status_show_price'] == '1') {
	if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 0) $total-=$discount;
	if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) $total-=$discount;
	if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 1) $total-=$discount;
	$box_smarty->assign('TOTAL', $xtPrice->xtcFormat($total, true));
} 
	
	//GM_MOD:
	if(gm_get_conf('TAX_INFO_TAX_FREE') == 'true') {
		$gm_cart_tax_info = GM_TAX_FREE .'<br />';
	} else {
		$gm_cart_tax_info = $_SESSION['cart']->show_tax();
	}
	//GM_MOD:
	$box_smarty->assign('UST', $gm_cart_tax_info);
	
	if (SHOW_SHIPPING=='true') { 
		// BOF GM_MOD:
		$box_smarty->assign('SHIPPING_INFO', $main->getShippingLink(true));
	}
}
if (ACTIVATE_GIFT_SYSTEM == 'true') {
	$box_smarty->assign('ACTIVATE_GIFT', 'true');
}

// GV Code Start
if (isset ($_SESSION['customer_id'])) {
	$gv_query = xtc_db_query("select amount from ".TABLE_COUPON_GV_CUSTOMER." where customer_id = '".$_SESSION['customer_id']."'");
	$gv_result = xtc_db_fetch_array($gv_query);
	if ($gv_result['amount'] > 0) {
		$box_smarty->assign('GV_AMOUNT', $xtPrice->xtcFormat($gv_result['amount'], true, 0, true));
		$box_smarty->assign('GV_SEND_TO_FRIEND_LINK', '<a href="'.xtc_href_link(FILENAME_GV_SEND).'">');
	}
}
if (isset ($_SESSION['gv_id'])) {
	$gv_query = xtc_db_query("select coupon_amount from ".TABLE_COUPONS." where coupon_id = '".$_SESSION['gv_id']."'");
	$coupon = xtc_db_fetch_array($gv_query);
	$box_smarty->assign('COUPON_AMOUNT2', $xtPrice->xtcFormat($coupon['coupon_amount'], true, 0, true));
}
if (isset ($_SESSION['cc_id'])) {
	$box_smarty->assign('COUPON_HELP_LINK', '<a href="javascript:popupWindow(\''.xtc_href_link(FILENAME_POPUP_COUPON_HELP, 'cID='.$_SESSION['cc_id']).'\')">');
}
// GV Code End
$box_smarty->assign('LINK_CART', xtc_href_link(FILENAME_SHOPPING_CART, '', 'SSL'));
$box_smarty->assign('products', $products_in_cart);

$box_smarty->caching = 0;
$box_smarty->assign('language', $_SESSION['language']);

//$box_shopping_cart = $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_cart.html');

  // BOF GM_MOD
  if($_SESSION['style_edit_mode'] == 'edit') 
  {
		$box_shopping_cart = $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_cart_top.html');
		$smarty->assign('gm_box_cart', $box_shopping_cart);
		
		$box_shopping_cart = $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_cart.html');
		$gm_box_pos = $coo_template_control->get_menubox_position('cart');
		$smarty->assign($gm_box_pos, $box_shopping_cart);
  }
  else 
  {
		if(gm_get_conf('GM_CART_ON_TOP') == 'true') {
			$box_shopping_cart = $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_cart_top.html');
			$smarty->assign('gm_box_cart', $box_shopping_cart);
		}
		else 
		{
				$gm_box_pos = $coo_template_control->get_menubox_position('cart');
			$box_shopping_cart = $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_cart.html');
			$smarty->assign($gm_box_pos, $box_shopping_cart);
		}
  }
?>