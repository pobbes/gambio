<?php
/* --------------------------------------------------------------
   specials.php 2012-06-25 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(specials.php,v 1.47 2003/05/27); www.oscommerce.com 
   (c) 2003	 nextcommerce (specials.php,v 1.12 2003/08/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: specials.php 1292 2005-10-07 16:10:55Z mz $)

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');

$breadcrumb->add(NAVBAR_TITLE_SPECIALS, xtc_href_link(FILENAME_SPECIALS));

$smarty = new Smarty;
// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');

require_once (DIR_FS_INC.'xtc_get_short_description.inc.php');

if(xtc_not_null(SID)) {
	$t_use_sid = 'sid_TRUE';
} else {
	$t_use_sid = 'sid_FALSE';
}

// parameter list for cache matching
$t_cache_key_source = 'specials-'.(int)$_GET['page'].'-'.$_SESSION['languages_id'].'-'.$_SESSION['currency'].'-'.$_SESSION['customers_status'].'-'.$_SESSION['customers_status_id'].'-'.$t_use_sid;

$coo_cache =& DataCache::get_instance();
$t_cache_key = $coo_cache->build_key($t_cache_key_source);
$t_cache_data_array = array();

$module_content = array();

if($coo_cache->key_exists($t_cache_key, true))
{
	// use cached result
	$t_cache_data_array = $coo_cache->get_data($t_cache_key);
	$module_content = $t_cache_data_array['module_content'];
	$specials_split = $t_cache_data_array['specials_split'];
}
else
{	
	//fsk18 lock
	$fsk_lock = '';
	if ($_SESSION['customers_status']['customers_fsk18_display'] == '0') {
		$fsk_lock = ' and p.products_fsk18!=1';
	}
	if (GROUP_CHECK == 'true') {
		$group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
	}

	$specials_query_raw = "SELECT
								p.products_id
							FROM
								(	SELECT
										s.products_id
									FROM
										" . TABLE_SPECIALS . " s
									WHERE
										s.status = '1'
									ORDER BY s.specials_date_added DESC) AS s,
								".TABLE_PRODUCTS." p,
								".TABLE_PRODUCTS_DESCRIPTION." pd
							WHERE
								p.products_id = s.products_id
								and p.products_status = '1'
								and p.products_id = pd.products_id
								".$group_check."
								".$fsk_lock."
								and pd.language_id = '".(int) $_SESSION['languages_id']."'";

	if(version_compare(gm_get_env_info('MYSQL_VERSION'), '4.1') < 0)
	{
		$specials_query_raw = "SELECT
									p.products_id,
									s.specials_date_added
								FROM
									".TABLE_SPECIALS." s,
									".TABLE_PRODUCTS." p,
									".TABLE_PRODUCTS_DESCRIPTION." pd
								WHERE
									s.status = '1'
									and p.products_id = s.products_id
									and p.products_status = '1'
									and p.products_id = pd.products_id
									".$group_check."
									".$fsk_lock."
									and pd.language_id = '".(int) $_SESSION['languages_id']."'
									and s.status = '1'
								ORDER BY s.specials_date_added DESC";
	}
	
	$specials_split = new splitPageResults($specials_query_raw, $_GET['page'], MAX_DISPLAY_SPECIAL_PRODUCTS);

	$specials_query = xtc_db_query($specials_split->sql_query);

	while ($specials = xtc_db_fetch_array($specials_query)) {
		$coo_product = MainFactory::create_object('product', array($specials['products_id']));
		$module_content[] = $coo_product->buildDataArray($coo_product->data);
	}
	
	$t_cache_data_array['module_content'] = $module_content;
	$t_cache_data_array['specials_split'] = $specials_split;
	
	$coo_cache->set_data($t_cache_key, $t_cache_data_array, true, array('TEMPLATE', 'CHECKOUT')); 
}

if (($specials_split->number_of_rows > 0)) {
	$gm_smarty_navi = new Smarty;
	
	$gm_smarty_navi->assign('LEFT', $specials_split->display_count(TEXT_DISPLAY_NUMBER_OF_SPECIALS));
	$gm_smarty_navi->assign('RIGHT', TEXT_RESULT_PAGE.' '.$specials_split->display_links(MAX_DISPLAY_PAGE_LINKS, xtc_get_all_get_params(array ('page', 'info', 'x', 'y'))) );
	$navigation = $gm_smarty_navi->fetch(CURRENT_TEMPLATE.'/module/gm_navigation.html');	
	$smarty->assign('NAVIGATION_INFO', $specials_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS));

	$smarty->assign('NAVBAR', $navigation);
}

$smarty->assign('GM_THUMBNAIL_WIDTH', PRODUCT_IMAGE_THUMBNAIL_WIDTH + 10);

$row = 0;
if ($specials_split->number_of_rows==0) xtc_redirect(xtc_href_link(FILENAME_DEFAULT));
require (DIR_WS_INCLUDES.'header.php');

$smarty->assign('language', $_SESSION['language']);
$smarty->assign('module_content', $module_content);
$smarty->caching = 0;
$main_content = $smarty->fetch(CURRENT_TEMPLATE.'/module/specials.html');

$smarty->assign('language', $_SESSION['language']);
$smarty->assign('main_content', $main_content);
$smarty->caching = 0;
if (!defined(RM))
	$smarty->load_filter('output', 'note');
$smarty->display(CURRENT_TEMPLATE.'/index.html');
include ('includes/application_bottom.php');
?>