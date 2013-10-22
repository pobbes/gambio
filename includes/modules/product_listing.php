<?php
/* --------------------------------------------------------------
   product_listing.php 2012-06-14 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(product_listing.php,v 1.42 2003/05/27); www.oscommerce.com
   (c) 2003	 nextcommerce (product_listing.php,v 1.19 2003/08/1); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: product_listing.php 1286 2005-10-07 10:10:18Z mz $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

$module_smarty = new Smarty;
$module_smarty->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
/* bof gm */
$module_smarty->assign('GM_THUMBNAIL_WIDTH', PRODUCT_IMAGE_THUMBNAIL_WIDTH + 10);
/* eof gm */

$result = true;
// include needed functions
require_once (DIR_FS_INC.'xtc_get_all_get_params.inc.php');
require_once (DIR_FS_INC.'xtc_get_vpe_name.inc.php');

# GM_MOD listing_count
$t_max_display_search_results = MAX_DISPLAY_SEARCH_RESULTS;
if(isset($_GET['listing_count'])) {
	$t_max_display_search_results = (int)$_GET['listing_count'];
}
if($t_max_display_search_results < 1) $t_max_display_search_results = 1;

# save last listing query for ProductNavigator
$_SESSION['last_listing_sql'] = $listing_sql;

$listing_split = new splitPageResults($listing_sql, (int)$_GET['page'], $t_max_display_search_results, 'p.products_id');
$module_content = array ();
if ($listing_split->number_of_rows > 0) {

	// BOF GM_MOD
	$gm_smarty_navi = new Smarty;
	
	$gm_smarty_navi->assign('LEFT', $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS));
	$gm_smarty_navi->assign('RIGHT', TEXT_RESULT_PAGE.' '.$listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, xtc_get_all_get_params(array ('gm_boosted_category', 'page', 'info', 'x', 'y'))) );
	$navigation = $gm_smarty_navi->fetch(CURRENT_TEMPLATE.'/module/gm_navigation.html');
	$module_smarty->assign('NAVIGATION_INFO', $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS));
	// EOF GM_MOD
		
	if (GROUP_CHECK == 'true') {
		$group_check = "and c.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
	}
	// BOF GM_MOD:
	$category_query = xtDBquery("select
											cd.categories_description,
											cd.categories_name,
											cd.categories_heading_title,
											cd.gm_alt_text, 	
											c.listing_template,
											c.categories_image,
											c.view_mode_tiled,
											c.gm_show_attributes,
											c.gm_show_graduated_prices,
											c.gm_show_qty,
											c.gm_show_qty_info 
											from ".TABLE_CATEGORIES." c, ".TABLE_CATEGORIES_DESCRIPTION." cd
		                                    where c.categories_id = '".$current_category_id."'
		                                    and cd.categories_id = '".$current_category_id."'
		                                    ".$group_check."
		                                    and cd.language_id = '".$_SESSION['languages_id']."'");

	$category = xtc_db_fetch_array($category_query,true);
	$image = '';
	if ($category['categories_image'] != '')
		$image = DIR_WS_IMAGES.'categories/'.$category['categories_image'];

	if(GM_CAT_COUNT == 0)
	{
		$module_smarty->assign('CATEGORIES_NAME',			htmlspecialchars_wrapper($category['categories_name']));
		$module_smarty->assign('CATEGORIES_HEADING_TITLE',	htmlspecialchars_wrapper($category['categories_heading_title']));
		$module_smarty->assign('CATEGORIES_GM_ALT_TEXT',	htmlspecialchars_wrapper($category['gm_alt_text']));

		$module_smarty->assign('CATEGORIES_IMAGE', $image);
                $t_categories_description = $category['categories_description'];
		if( trim($t_categories_description) == '<br />' )
                {
                    $t_categories_description = '';
                }
		$module_smarty->assign('CATEGORIES_DESCRIPTION', $t_categories_description);
	}

	if((isset($category['gm_show_qty']) && $category['gm_show_qty'] == '1') || (gm_get_conf('MAIN_SHOW_QTY') == 'true' && !isset($category['gm_show_qty'])))
	{
		$module_smarty->assign('GM_SHOW_QTY', '1');
	}
	else
	{
		$module_smarty->assign('GM_SHOW_QTY', '0');
	}
	$module_smarty->assign('GM_HIDDEN_QTY', xtc_draw_hidden_field('products_qty', '1'));
	$module_smarty->assign('HIDDEN_QTY_NAME', 'products_qty');
	$module_smarty->assign('HIDDEN_QTY_VALUE', '1');

	if((isset($category['gm_show_qty_info']) && $category['gm_show_qty_info'] == '1') || (gm_get_conf('MAIN_SHOW_QTY_INFO') == 'true' && !isset($category['gm_show_qty_info'])))
	{
            $categorie_show_quantity = true;
	}
	else
	{
            $categorie_show_quantity = false;
	}
	
	$rows = 0;
	$listing_query = xtDBquery($listing_split->sql_query);
	while ($listing = xtc_db_fetch_array($listing_query, true)) {
		$rows ++;
		$module_content[] = $product->buildDataArray($listing);
		// BOF GM_MOD
		$product = new product($listing['products_id']);
                
                // check if product has properties
                $coo_data_group = MainFactory::create_object('GMDataObjectGroup', array('products_properties_index', array('products_id' => $listing['products_id']) )); 
 	  	$t_data_object_array = $coo_data_group->get_data_objects_array();  
                if(sizeof($t_data_object_array) > 0){
                    $product_has_properties = true;
                }else{
                    $product_has_properties = false;
                }
		
		$gm_attr_content = '';
        if((gm_get_conf('MAIN_SHOW_ATTRIBUTES') == 'true' && !isset($category['gm_show_attributes'])) || $category['gm_show_attributes'] == '1'){
            include(DIR_FS_CATALOG . 'gm/modules/gm_product_attributes.php');  
		
            $coo_product_attributes = MainFactory::create_object('ProductAttributesContentView');
			// get default template
			$filepath = DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/module/gm_product_options/';
			$c_template = $coo_product_attributes->get_default_template($filepath, $product->data['gm_options_template']);
			$coo_product_attributes->set_content_template('module/gm_product_options/' . $c_template);
            $gm_attr_content = $coo_product_attributes->get_html($product);
        }
        
		$gm_graduated_content = '';
		if ($_SESSION['customers_status']['customers_status_graduated_prices'] == 1 && 
				($category['gm_show_graduated_prices'] == '1' || (gm_get_conf('MAIN_SHOW_GRADUATED_PRICES') == 'true') && !isset($category['gm_show_graduated_prices'])) ){
			include(DIR_FS_CATALOG . 'gm/modules/gm_graduated_prices.php');  
			$gm_graduated_content = $module;
		}
		
		if(!empty($products_options_data)) $gm_has_attributes = 1;
		else $gm_has_attributes = 0;
		
		$module_content[sizeof($module_content) - 1] = array_merge($module_content[sizeof($module_content) - 1], array('GM_ATTRIBUTES' => $gm_attr_content, 'GM_GRADUATED_PRICES' => $gm_graduated_content, 'GM_HAS_ATTRIBUTES' => $gm_has_attributes)); 
        
		if(!empty($product->data['quantity_unit_id']) && (!$product_has_properties || ($product_has_properties && $product->data['use_properties_combis_quantity'] == '0')))
		{
			$module_content[sizeof($module_content) - 1] = array_merge($module_content[sizeof($module_content) - 1], array('UNIT' => $product->data['unit_name']));
		}
		
		if($categorie_show_quantity){
			if(!empty($product->data['gm_show_qty_info']) && (!$product_has_properties || ($product_has_properties && $product->data['use_properties_combis_quantity'] == '0')))
			{
					$module_content[sizeof($module_content) - 1] = array_merge($module_content[sizeof($module_content) - 1], array('PRODUCTS_QUANTITY' => $product->data['products_quantity']));
			}
		}

		if($product_has_properties)
		{
			$module_content[sizeof($module_content) - 1]['SHOW_PRODUCTS_WEIGHT'] = 0;
		}
		        
		if($product_has_properties && $product->data['use_properties_combis_shipping_time'] == '1')
		{
			$module_content[sizeof($module_content) - 1] = array_merge($module_content[sizeof($module_content) - 1], array('PRODUCTS_SHIPPING_NAME' => ''));
		}
		
		unset($products_options_data);
		// EOF GM_MOD
	}  
} else {
	// no product found
	$result = false;
}
			
// get default template
$filepath = DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/module/product_listing/';
$coo_product_listing = MainFactory::create_object('ContentView');
$category['listing_template'] = $coo_product_listing->get_default_template($filepath, $category['listing_template']);
unset($coo_product_listing);

if($result == false && GM_CAT_COUNT > 0) # products FALSE, sub-categories TRUE
{
	$smarty->assign('main_content', $main_content);
}
elseif ($result != false) # products TRUE, sub-categories TRUE/FALSE
{
	// bof gm
	$module_smarty->assign('gm_manufacturers_id', htmlentities_wrapper($_GET['manufacturers_id']));
	//eof gm
	$module_smarty->assign('MANUFACTURER_DROPDOWN', $manufacturer_dropdown);
	$module_smarty->assign('manufacturers_data', $t_manufacturers_data_array);
	$module_smarty->assign('language', $_SESSION['language']);
	$module_smarty->assign('module_content', $module_content);

	$module_smarty->assign('NAVIGATION', $navigation);

	$t_page_url = gm_get_env_info('REQUEST_URI');
	$t_page_url_array = explode('?', $t_page_url);
	$t_get_params_hidden_array = array();

	if(count($t_page_url_array) == 2)
	{
		$t_page_url_get_params = $t_page_url_array[1];
		$t_page_url_get_params = str_replace('&amp;', '&', $t_page_url_get_params);
		$t_get_params_array = explode('&', $t_page_url_get_params);
		for($i = 0; $i < count($t_get_params_array); $i++)
		{
			$t_get_data_array = explode('=', $t_get_params_array[$i]);
			if($t_get_data_array[0] != 'listing_sort' && $t_get_data_array[0] != 'listing_count')
			{
				if(isset($t_get_data_array[1]))
				{
					$t_get_params_hidden_array[] = array('NAME' => htmlspecialchars_wrapper(urldecode($t_get_data_array[0])),
															'VALUE' => htmlspecialchars_wrapper(urldecode($t_get_data_array[1]))
														);
				}
			}
		}
	}
	$module_smarty->assign('SORTING_FORM_ACTION_URL', htmlspecialchars_wrapper($t_page_url_array[0]));
	$module_smarty->assign('get_params_hidden_data', $t_get_params_hidden_array);
	if(isset($_GET['listing_sort']))
	{
		$module_smarty->assign('SORT', htmlspecialchars_wrapper($_GET['listing_sort']));
	}
	if(isset($_GET['listing_count']))
	{
		$module_smarty->assign('ITEM_COUNT', htmlspecialchars_wrapper($_GET['listing_count']));
	}

	$coo_seo_boost = MainFactory::create_object('GMSEOBoost');
	if($coo_seo_boost->boost_categories == true && $current_category_id != 0)
	{
		# use boosted url
		$t_href_url = $coo_seo_boost->get_current_boost_url();
		if($t_href_url == '') {
			$t_exclude_parameters = array('view_mode');
		} else {
			$t_exclude_parameters = array('view_mode', 'gm_boosted_category', 'cat', 'cPath');
		}
	}
	else {
		# use default url for splitting urls
		$t_href_url = basename($PHP_SELF);
		$t_exclude_parameters = array('view_mode');
	}

	if(isset($_GET['page']) == false) $t_page = 'page=0&'; else $t_page = '';
	$module_smarty->assign('VIEW_MODE_URL_DEFAULT', xtc_href_link($t_href_url, xtc_get_all_get_params($t_exclude_parameters).$t_page.'view_mode=default', 'NONSSL') );
	$module_smarty->assign('VIEW_MODE_URL_TILED', xtc_href_link($t_href_url, xtc_get_all_get_params($t_exclude_parameters).$t_page.'view_mode=tiled', 'NONSSL') );

	$t_view_mode = '';
	if(gm_get_conf('MAIN_VIEW_MODE_TILED') == 'true')
	{
		$t_view_mode = 'tiled';
	}

	if(isset($_GET['view_mode'])) {
		$t_view_mode = htmlentities_wrapper($_GET['view_mode']);
	}
	elseif($category['view_mode_tiled'] == 1) {
		$t_view_mode = 'tiled';
	}
	$module_smarty->assign('VIEW_MODE', $t_view_mode);

	$t_start_count_value = (int)MAX_DISPLAY_SEARCH_RESULTS;
	$t_count_value_2 = $t_start_count_value * 2;
	$t_count_value_3 = $t_start_count_value + $t_count_value_2;
	$t_count_value_4 = $t_count_value_3 * 2;
	$t_count_value_5 = $t_count_value_4 * 2;
	$module_smarty->assign('COUNT_VALUE_1', $t_start_count_value);
	$module_smarty->assign('COUNT_VALUE_2', $t_count_value_2);
	$module_smarty->assign('COUNT_VALUE_3', $t_count_value_3);
	$module_smarty->assign('COUNT_VALUE_4', $t_count_value_4);
	$module_smarty->assign('COUNT_VALUE_5', $t_count_value_5);

	if(isset($_GET['keywords']))
	{
		$module_smarty->assign('SEARCH_RESULT_PAGE', 1);
		$module_smarty->assign('KEYWORDS', gm_prepare_string($_GET['keywords'], true));
	}

	// set cache ID
	 if (!CacheCheck()) {
		$module_smarty->caching = 0;
		$module = $module_smarty->fetch(CURRENT_TEMPLATE.'/module/product_listing/'.$category['listing_template']);
	} else {
		$module_smarty->caching = 1;
		$module_smarty->cache_lifetime = CACHE_LIFETIME;
		$module_smarty->cache_modified_check = CACHE_CHECK;
		$cache_id = $current_category_id.'_'.$_SESSION['language'].'_'.$_SESSION['customers_status']['customers_status_name'].'_'.$_SESSION['currency'].'_'.$_GET['manufacturers_id'].'_'.$_GET['filter_id'].'_'.$_GET['page'].'_'.$_GET['keywords'].'_'.$_GET['categories_id'].'_'.$_GET['pfrom'].'_'.$_GET['pto'].'_'.$_GET['x'].'_'.$_GET['y'].'_'.md5(print_r($_GET['filter_fv_id'],true)).'_'.$_GET['filter_price_min'].'_'.$_GET['filter_price_max'].'_'.$_GET['view_mode'].'_'.$_GET['listing_sort'].'_'.$_GET['listing_count'];
		$module = $module_smarty->fetch(CURRENT_TEMPLATE.'/module/product_listing/'.$category['listing_template'], $cache_id);
	}
	$main_content .= $module;
	//$smarty->assign('main_content', $module);
}
else # products FALSE, sub-categories FALSE
{
	$error = TEXT_PRODUCT_NOT_FOUND;
	include (DIR_WS_MODULES.FILENAME_ERROR_HANDLER);
}
?>