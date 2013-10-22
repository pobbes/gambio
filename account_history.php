<?php
/* --------------------------------------------------------------
   account_history.php 2012-04-02 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(account_history_info.php,v 1.97 2003/05/19); www.oscommerce.com 
   (c) 2003	 nextcommerce (account_history_info.php,v 1.17 2003/08/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: account_history.php 1309 2005-10-17 08:01:11Z mz $)

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');
// create smarty elements
$smarty = new Smarty;
// include boxes

$breadcrumb->add(NAVBAR_TITLE_1_ACCOUNT_HISTORY, xtc_href_link(FILENAME_ACCOUNT, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_2_ACCOUNT_HISTORY, xtc_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL'));

require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');
// include needed functions
require_once (DIR_FS_INC.'xtc_count_customer_orders.inc.php');
require_once (DIR_FS_INC.'xtc_date_long.inc.php');
require_once (DIR_FS_INC.'xtc_image_button.inc.php');
require_once (DIR_FS_INC.'xtc_get_all_get_params.inc.php');

if (!isset ($_SESSION['customer_id']))
	xtc_redirect(xtc_href_link(FILENAME_LOGIN, '', 'SSL'));


require (DIR_WS_INCLUDES.'header.php');

$module_content = array ();
if (($orders_total = xtc_count_customer_orders()) > 0) {
	$history_query_raw = "SELECT 
								o.orders_id, 
								o.date_purchased, 
								o.delivery_name, 
								o.billing_name, 
								ot.text as order_total, 
								s.orders_status_name 
							FROM 
								" . TABLE_ORDERS . " o, 
								" . TABLE_ORDERS_TOTAL . " ot, 
								" . TABLE_ORDERS_STATUS . " s,
								" . TABLE_CUSTOMERS_INFO . " ci
							WHERE 
								o.customers_id = '" . (int)$_SESSION['customer_id'] . "' AND 
								o.orders_id = ot.orders_id AND 
								ot.class = 'ot_total' AND 
								o.orders_status = s.orders_status_id AND 
								s.language_id = '" . (int)$_SESSION['languages_id'] . "' AND
								o.customers_id = ci.customers_info_id AND
								o.date_purchased > ci.customers_info_date_account_created
							ORDER BY orders_id DESC";
	$history_split = new splitPageResults($history_query_raw, $_GET['page'], MAX_DISPLAY_ORDER_HISTORY);
	$history_query = xtc_db_query($history_split->sql_query);

	while ($history = xtc_db_fetch_array($history_query)) {
		$products_query = xtc_db_query("select count(*) as count from ".TABLE_ORDERS_PRODUCTS." where orders_id = '".$history['orders_id']."'");
		$products = xtc_db_fetch_array($products_query);

		if (xtc_not_null($history['delivery_name'])) {
			$order_type = TEXT_ORDER_SHIPPED_TO;
			$order_name = $history['delivery_name'];
		} else {
			$order_type = TEXT_ORDER_BILLED_TO;
			$order_name = $history['billing_name'];
		}
		$module_content[] = array ('ORDER_ID' => $history['orders_id'], 'ORDER_STATUS' => $history['orders_status_name'], 'ORDER_DATE' => xtc_date_long($history['date_purchased']), 'ORDER_PRODUCTS' => $products['count'], 'ORDER_TOTAL' => strip_tags($history['order_total']), 'ORDER_BUTTON' => '<a href="'.xtc_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'page='.(empty($_GET['page']) ? "1" : (int)$_GET['page']) .'&order_id='.$history['orders_id'], 'SSL').'">'.xtc_image_button('small_view.gif', SMALL_IMAGE_BUTTON_VIEW).'</a>', 'BUTTON_URL' => xtc_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'page='.(empty($_GET['page']) ? "1" : (int)$_GET['page']) .'&order_id='.$history['orders_id'], 'SSL'));

	}
}

if ($orders_total > 0) {
	$smarty->assign('SPLIT_BAR', '
	          <div class="smallText" style="clear:both;"><div style="float:left;">'.$history_split->display_count(TEXT_DISPLAY_NUMBER_OF_ORDERS).'</div>
              <div align="right">'.TEXT_RESULT_PAGE.' '.$history_split->display_links(MAX_DISPLAY_PAGE_LINKS, xtc_get_all_get_params(array ('page', 'info', 'x', 'y'))).'</div>
              </div>');

}
$smarty->assign('order_content', $module_content);
$smarty->assign('language', $_SESSION['language']);
$smarty->assign('BUTTON_BACK', '<a href="'.xtc_href_link(FILENAME_ACCOUNT, '', 'SSL').'">'.xtc_image_button('button_back.gif', IMAGE_BUTTON_BACK).'</a>');
$smarty->assign('BUTTON_BACK_LINK', xtc_href_link(FILENAME_ACCOUNT, '', 'SSL'));
$smarty->caching = 0;
$main_content = $smarty->fetch(CURRENT_TEMPLATE.'/module/account_history.html');

$smarty->assign('language', $_SESSION['language']);
$smarty->assign('main_content', $main_content);
$smarty->caching = 0;
if (!defined(RM))
	$smarty->load_filter('output', 'note');
$smarty->display(CURRENT_TEMPLATE.'/index.html');
include ('includes/application_bottom.php');
?>