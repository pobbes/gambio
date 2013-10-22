<?php
/* --------------------------------------------------------------
   products_new.php 2012-05-14 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(products_new.php,v 1.25 2003/05/27); www.oscommerce.com 
   (c) 2003	 nextcommerce (products_new.php,v 1.16 2003/08/18); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: products_new.php 1292 2005-10-07 16:10:55Z mz $)

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   Enable_Disable_Categories 1.3        	Autor: Mikel Williams | mikel@ladykatcostumes.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');

$breadcrumb->add(NAVBAR_TITLE_PRODUCTS_NEW, xtc_href_link(FILENAME_PRODUCTS_NEW));

// create smarty elements
$smarty = new Smarty;


// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');
// include needed function
require_once (DIR_FS_INC.'xtc_date_long.inc.php');
require_once (DIR_FS_INC.'xtc_get_vpe_name.inc.php');

require (DIR_WS_INCLUDES.'header.php');

$products_new_array = array ();
$fsk_lock = '';
if ($_SESSION['customers_status']['customers_fsk18_display'] == '0') {
	$fsk_lock = ' and p.products_fsk18!=1';
}
if (GROUP_CHECK == 'true') {
	$group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
}
if (MAX_DISPLAY_NEW_PRODUCTS_DAYS != '0') {
	$date_new_products = date("Y.m.d", mktime(1, 1, 1, date(m), date(d) - MAX_DISPLAY_NEW_PRODUCTS_DAYS, date(Y)));
	$days = " and p.products_date_added > '".$date_new_products."' ";
}

$products_new_query_raw = "SELECT DISTINCT
											p.products_id													
										FROM 
											( SELECT 
													p.products_id,
													p.products_date_added
												FROM " .TABLE_PRODUCTS . " p
												WHERE
													p.products_status = 1
													" . $group_check . "
													" . $fsk_lock . "
												ORDER BY p.products_date_added DESC
											) AS p,
											" . TABLE_PRODUCTS_DESCRIPTION . " pd
										WHERE 
											p.products_id = pd.products_id
											AND pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
											" . $days . " ";

if(version_compare(gm_get_env_info('MYSQL_VERSION'), '4.1') < 0)
{
	$products_new_query_raw = "SELECT DISTINCT
											p.products_id
										FROM 
											" . TABLE_PRODUCTS . " p, 
											" . TABLE_PRODUCTS_DESCRIPTION . " pd
										WHERE 
											p.products_status = '1' 
											AND p.products_id = pd.products_id
											AND pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
											" . $group_check . "
											" . $fsk_lock . "
											" . $days . "
										ORDER BY
											p.products_date_added DESC";
}

$products_new_split = new splitPageResults($products_new_query_raw, $_GET['page'], MAX_DISPLAY_PRODUCTS_NEW, 'p.products_id');

if (($products_new_split->number_of_rows > 0)) {
	
	$gm_smarty_navi = new Smarty;
	
	$gm_smarty_navi->assign('LEFT', $products_new_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW) );
	$gm_smarty_navi->assign('RIGHT', TEXT_RESULT_PAGE.' '.$products_new_split->display_links(MAX_DISPLAY_PAGE_LINKS, xtc_get_all_get_params(array ('page', 'info', 'x', 'y'))) );
	$navigation = $gm_smarty_navi->fetch(CURRENT_TEMPLATE.'/module/gm_navigation.html');	
	$smarty->assign('NAVIGATION_INFO', $products_new_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS));

	$smarty->assign('NAVIGATION_BAR', $navigation);
}

$module_content = array();

if ($products_new_split->number_of_rows > 0) {
	
	if(xtc_not_null(SID)) {
		$t_use_sid = 'sid_TRUE';
	} else {
		$t_use_sid = 'sid_FALSE';
	}
	
	// parameter list for cache matching
	$t_cache_key_source = 'products_new-'.(int)$_GET['page'].'-'.$_SESSION['languages_id'].'-'.$_SESSION['currency'].'-'.$_SESSION['customers_status'].'-'.$_SESSION['customers_status_id'].'-'.$t_use_sid;
	
	$coo_cache =& DataCache::get_instance();
	$t_cache_key = $coo_cache->build_key($t_cache_key_source);

	if($coo_cache->key_exists($t_cache_key, true))
	{
		// use cached result
		$module_content = $coo_cache->get_data($t_cache_key);
	}
	else
	{	
		$products_new_query = xtc_db_query($products_new_split->sql_query);
		while ($products_new = xtc_db_fetch_array($products_new_query)) {
			$products_price = $xtPrice->xtcGetPrice($products_new['products_id'], $format = true, 1, $products_new['products_tax_class_id'], $products_new['products_price'], 1);
			$vpePrice = '';
			if ($products_new['products_vpe_status'] == 1 && $products_new['products_vpe_value'] != 0.0)
				$vpePrice = $xtPrice->xtcFormat($products_price['plain'] * (1 / $products_new['products_vpe_value']), true).TXT_PER.xtc_get_vpe_name($products_new['products_vpe']);
			$buy_now = '';
			if ($_SESSION['customers_status']['customers_fsk18'] == '1') {
				if ($products_new['products_fsk18'] == '0')
					$buy_now = '<a href="'.xtc_href_link(basename($PHP_SELF), xtc_get_all_get_params(array ('action')).'action=buy_now&BUYproducts_id='.$products_new['products_id'], 'NONSSL').'">'.xtc_image_button('button_buy_now.gif', TEXT_BUY.$products_new['products_name'].TEXT_NOW).'</a>';
			} else {
				$buy_now = '<a href="'.xtc_href_link(basename($PHP_SELF), xtc_get_all_get_params(array ('action')).'action=buy_now&BUYproducts_id='.$products_new['products_id'], 'NONSSL').'">'.xtc_image_button('button_buy_now.gif', TEXT_BUY.$products_new['products_name'].TEXT_NOW).'</a>';
			}
			if ($products_new['products_image'] != '') {
				$products_image = DIR_WS_THUMBNAIL_IMAGES.$products_new['products_image'];
			} else {
				$products_image = '';
			}
			
			if ($_SESSION['customers_status']['customers_status_show_price'] != 0 && ($products_new['gm_price_status'] == 0 || ($products_new['gm_price_status'] == 2 && $products_new['products_price'] > 0)) ) {
				$tax_rate = $xtPrice->TAX[$products_new['products_tax_class_id']];
				$tax_info = $main->getTaxInfo($tax_rate);
			}
			$ship_info="";
			
			if (SHOW_SHIPPING=='true' && $products_new['gm_price_status'] == 0) {
			$ship_info=' '.SHIPPING_EXCL.'<a href="javascript:newWin=void(window.open(\''.xtc_href_link(FILENAME_POPUP_CONTENT, 'coID='.SHIPPING_INFOS).'\', \'popup\', \'toolbar=0, width=640, height=600\'))"> '.SHIPPING_COSTS.'</a>';
			}
			
			if($gmSEOBoost->boost_products) {
				$gm_product_link = $gmSEOBoost->get_boosted_product_url($products_new['products_id'], $products_new['products_name']);
			} 
			else
			{
				$gm_product_link = xtc_href_link(FILENAME_PRODUCT_INFO, xtc_product_link($products_new['products_id'], $products_new['products_name']));
			}

			$coo_product = MainFactory::create_object('product', array($products_new['products_id']));
			$module_content[] = $coo_product->buildDataArray($coo_product->data);
		}

		$coo_cache->set_data($t_cache_key, $module_content, true, array('TEMPLATE', 'CHECKOUT')); 				
	}
} else {
	$smarty->assign('ERROR', TEXT_NO_NEW_PRODUCTS);
}

$smarty->assign('GM_THUMBNAIL_WIDTH', PRODUCT_IMAGE_THUMBNAIL_WIDTH + 10);

$smarty->assign('language', $_SESSION['language']);
$smarty->caching = 0;
$smarty->assign('module_content', $module_content);
$main_content = $smarty->fetch(CURRENT_TEMPLATE.'/module/new_products_overview.html');
$smarty->assign('main_content', $main_content);

$smarty->assign('language', $_SESSION['language']);
$smarty->caching = 0;
if (!defined(RM))
	$smarty->load_filter('output', 'note');
$smarty->display(CURRENT_TEMPLATE.'/index.html');
include ('includes/application_bottom.php');
?>