<?php
/* --------------------------------------------------------------
   order_history.php 2008-08-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(order_history.php,v 1.4 2003/02/10); www.oscommerce.com 
   (c) 2003	 nextcommerce (order_history.php,v 1.9 2003/08/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: order_history.php 1262 2005-09-30 10:00:32Z mz $)

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

/*
*	-> truncate
*/
function gm_truncate($str, $limit = 24) {
	if(strlen($str) <= $limit) {
		return $str; 
	} else {
		return substr_replace($str, '...', $limit);
	}
}

$box_smarty = new smarty;
$box_smarty->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/'); 
$box_content='';
  // include needed functions
  require_once(DIR_FS_INC . 'xtc_get_all_get_params.inc.php');

  if (isset($_SESSION['customer_id']) || $_SESSION['style_edit_mode'] == 'edit') {
    // retreive the last x products purchased
    $orders_query = xtc_db_query("select distinct op.products_id from " . TABLE_ORDERS . " o, " . TABLE_ORDERS_PRODUCTS . " op, " . TABLE_PRODUCTS . " p where o.customers_id = '" . (int)$_SESSION['customer_id'] . "' and o.orders_id = op.orders_id and op.products_id = p.products_id and p.products_status = '1' group by products_id order by o.date_purchased desc limit " . MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX);
    if (xtc_db_num_rows($orders_query)) {



      $product_ids = '';
      while ($orders = xtc_db_fetch_array($orders_query)) {
        $product_ids .= $orders['products_id'] . ',';
      }
      $product_ids = substr($product_ids, 0, -1);


      $products_query = xtc_db_query("select products_id, products_name from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id in (" . $product_ids . ") and language_id = '" . (int)$_SESSION['languages_id'] . "' order by products_name");
      while ($products = xtc_db_fetch_array($products_query)) {

		/* bof gm */
		if($gmSEOBoost->boost_products) {
			$gm_product_link = xtc_href_link($gmSEOBoost->get_boosted_product_url($products['products_id'], $products['products_name']));
		} else {
			$gm_product_link = xtc_href_link(FILENAME_PRODUCT_INFO, xtc_product_link($products['products_id'], $products['products_name']));
		}
		/* eof gm */

        $customer_orders_string .= '<div class="box_left"><a href="' . $gm_product_link . '">' . gm_truncate($products['products_name'], gm_get_conf('TRUNCATE_PRODUCTS_HISTORY')) . '</a></div>' .
                                   '<div class="box_right align_right" valign="top"><a href="' . xtc_href_link(basename($PHP_SELF), xtc_get_all_get_params(array('action')) . 'action=cust_order&pid=' . $products['products_id']) . '">' . xtc_image(DIR_WS_ICONS . 'cart.gif', ICON_CART) . '</a></div>';
      }
	}
  }


    $box_smarty->assign('BOX_CONTENT', $customer_orders_string);

    $box_smarty->caching = 0;
    $box_smarty->assign('language', $_SESSION['language']);
    $box_order_history= $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_order_history.html');
    
			$gm_box_pos = $coo_template_control->get_menubox_position('order_history');
			
	$smarty->assign($gm_box_pos, $box_order_history);
  ?>