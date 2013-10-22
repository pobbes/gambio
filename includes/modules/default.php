<?php
/* --------------------------------------------------------------
   default.php 2012-12-12 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


  based on:
  (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
  (c) 2002-2003 osCommerce(default.php,v 1.84 2003/05/07); www.oscommerce.com
  (c) 2003  nextcommerce (default.php,v 1.11 2003/08/22); www.nextcommerce.org
  (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: default.php 1292 2005-10-07 16:10:55Z mz $)

  Released under the GNU General Public License
  -----------------------------------------------------------------------------------------
  Third Party contributions:
  Enable_Disable_Categories 1.3        Autor: Mikel Williams | mikel@ladykatcostumes.com
  Customers Status v3.x  © 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs...by=date#dirlist

  Released under the GNU General Public License
  ---------------------------------------------------------------------------------------*/

$default_smarty = new smarty;
$default_smarty->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
$default_smarty->assign('session', session_id());
$main_content = '';
// include needed functions
require_once (DIR_FS_INC.'xtc_customer_greeting.inc.php');
require_once (DIR_FS_INC.'xtc_get_path.inc.php');
require_once (DIR_FS_INC.'xtc_check_categories_status.inc.php');

if(xtc_check_categories_status($current_category_id) >= 1)
{
	$error = CATEGORIE_NOT_FOUND;
	include (DIR_WS_MODULES.FILENAME_ERROR_HANDLER);

}
else 
{
	switch($category_depth)
	{
		case 'nested':
			if(GROUP_CHECK == 'true')
			{
				$group_check = "and c.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
			}
			$category_query = "select
									cd.categories_description,
									cd.categories_name,
									cd.categories_heading_title,
									cd.gm_alt_text,
									c.show_sub_categories,
									c.show_sub_categories_images,
									c.show_sub_categories_names,
									c.show_sub_products,
									c.categories_template,
									c.view_mode_tiled,
									c.categories_image from ".TABLE_CATEGORIES." c, ".TABLE_CATEGORIES_DESCRIPTION." cd
								where c.categories_id = '".$current_category_id."'
									and cd.categories_id = '".$current_category_id."'
									".$group_check."
									and cd.language_id = '".(int) $_SESSION['languages_id']."'";

			$category_query = xtDBquery($category_query);
			$category = xtc_db_fetch_array($category_query, true);

			if($category['show_sub_products'] == 1 && $_SESSION['coo_filter_manager']->is_active() == false)
			{
				$_SESSION['coo_filter_manager']->reset();
				$_SESSION['coo_filter_manager']->set_categories_id((int)$current_category_id);
				$_SESSION['coo_filter_manager']->set_price_range_start(0);
				$_SESSION['coo_filter_manager']->set_active(true);
			}

			if($category['show_sub_categories'] == 1)
			{
					if(GROUP_CHECK == 'true')
					{
						$group_check = "and c.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
					}
					$categories_query = "select
												cd.categories_description,
												c.categories_id,
												cd.categories_name,
												cd.gm_alt_text,
												cd.categories_heading_title,
												c.categories_image,
												c.parent_id from ".TABLE_CATEGORIES." c, ".TABLE_CATEGORIES_DESCRIPTION." cd
											where c.categories_status = '1'
												and c.parent_id = '".$current_category_id."'
												and c.categories_id = cd.categories_id
												".$group_check."
												and cd.language_id = '".(int) $_SESSION['languages_id']."'
											order by sort_order, cd.categories_name";
				$categories_query = xtDBquery($categories_query);

				$rows = 0;
				while($categories = xtc_db_fetch_array($categories_query, true))
				{
					$rows ++;

					$cPath_new = xtc_category_link($categories['categories_id'],$categories['categories_name']);

					$width = (int) (100 / MAX_DISPLAY_CATEGORIES_PER_ROW).'%';
					$image = '';
					if($categories['categories_image'] != '')
					{
						$image = DIR_WS_IMAGES.'categories/'.$categories['categories_image'];
					}

					if($gmSEOBoost->boost_categories)
					{
						$gm_category_link = $gmSEOBoost->get_boosted_category_url($categories['categories_id']);
					}
					else
					{
						$gm_category_link = xtc_href_link(FILENAME_DEFAULT, $cPath_new);
					}

					$categories_content[] = array (
													'CATEGORIES_NAME' => $categories['categories_name'],
													'CATEGORIES_ALT_TEXT' => $categories['gm_alt_text'],
													'CATEGORIES_HEADING_TITLE' => $categories['categories_heading_title'],
													'CATEGORIES_IMAGE' => $image,
													'CATEGORIES_LINK' => $gm_category_link,
													'CATEGORIES_DESCRIPTION' => $categories['categories_description']
												);

				}
				$new_products_category_id = $current_category_id;
				// BOF GM_MOD
				define('GM_CAT_COUNT', count($categories_content));

				if(count($categories_content) > 0)
				{
					if(MAX_DISPLAY_CATEGORIES_PER_ROW > count($categories_content))
					{
						$default_smarty->assign('GM_LI_WIDTH', 100/count($categories_content) - 2);
					}
					else
					{
						$default_smarty->assign('GM_LI_WIDTH', 100/MAX_DISPLAY_CATEGORIES_PER_ROW - 2);
					}
					//include (DIR_WS_MODULES.FILENAME_NEW_PRODUCTS);
					// EOF GM_MOD

					$image = '';
					if($category['categories_image'] != '')
					{
						$image = DIR_WS_IMAGES.'categories/'.$category['categories_image'];
					}
					$default_smarty->assign('CATEGORIES_NAME', $category['categories_name']);
					$default_smarty->assign('CATEGORIES_HEADING_TITLE', $category['categories_heading_title']);

					$default_smarty->assign('CATEGORIES_IMAGE', $image);
					$default_smarty->assign('CATEGORIES_ALT_TEXT', $category['gm_alt_text']);
					$default_smarty->assign('CATEGORIES_DESCRIPTION', $category['categories_description']);

					$default_smarty->assign('SHOW_SUB_CATEGORIES_IMAGES', $category['show_sub_categories_images']);
					$default_smarty->assign('SHOW_SUB_CATEGORIES_NAMES', $category['show_sub_categories_names']);

					$default_smarty->assign('language', $_SESSION['language']);
					$default_smarty->assign('module_content', $categories_content);

					// get default template
					$coo_content_view = MainFactory::create_object('ContentView');
					$t_template = $coo_content_view->get_default_template(DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/module/categorie_listing/', $category['categories_template']);

					$default_smarty->caching = 0;
					$main_content .= $default_smarty->fetch(CURRENT_TEMPLATE.'/module/categorie_listing/'.$t_template);
				}
				//$smarty->assign('main_content', $main_content);
				#break;
			}

		case 'products':
			//elseif ($category_depth == 'products' || $_GET['manufacturers_id'])
			//fsk18 lock
			$fsk_lock = '';
			if($_SESSION['customers_status']['customers_fsk18_display'] == '0')
			{
				$fsk_lock = ' and p.products_fsk18!=1';
			}
			
			$t_select_part = '';
			$t_from_part = '';
			$t_where_part = '';
			
			// show the products of a specified manufacturer
			if(isset ($_GET['manufacturers_id']))
			{
				if(isset ($_GET['filter_id']) && xtc_not_null($_GET['filter_id']))
				{
					// sorting query
					$sorting_query = xtDBquery("SELECT products_sorting,
												products_sorting2 FROM ".TABLE_CATEGORIES."
												where categories_id='".(int) $_GET['filter_id']."'");
					$sorting_data = xtc_db_fetch_array($sorting_query,true);
					if(!$sorting_data['products_sorting'])
					{
						$sorting_data['products_sorting'] = 'pd.products_name';
					}
					$sorting = ' ORDER BY '.$sorting_data['products_sorting'].' '.$sorting_data['products_sorting2'].' ';

					# GM_MOD sorting
					if(isset($_GET['listing_sort'])) {
						$coo_listing_manager = MainFactory::create_object('ListingManager');
						$t_orderby = $coo_listing_manager->get_sql_sort_part($_GET['listing_sort']);
						if($t_orderby != '') $sorting = $t_orderby;
					}

					// We are asked to show only a specific category
					if (GROUP_CHECK == 'true')
					{
						$group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
					}

					// sort by price
					if(strpos($t_orderby, 'p.products_price') !== false)
					{
						if($_SESSION['customers_status']['customers_status_show_price_tax'] != 0)
						{
							if(!isset ($_SESSION['customer_country_id']))
							{
								$_SESSION['customer_country_id'] = STORE_COUNTRY;
								$_SESSION['customer_zone_id'] = STORE_ZONE;
							}

							$t_select_part = ", ROUND(IF(s.status = '1' AND p.products_id = s.products_id, s.specials_new_products_price, p.products_price) * (IF(p.products_tax_class_id = 0,0,tax_rate)/100+1), 2) AS final_price ";
							$t_from_part = "LEFT JOIN " . TABLE_TAX_RATES . " AS tr ON (p.products_tax_class_id = tr.tax_class_id OR p.products_tax_class_id = 0) 
											LEFT JOIN " . TABLE_ZONES_TO_GEO_ZONES . " AS gz ON (tr.tax_zone_id = gz.geo_zone_id AND gz.zone_country_id = '" . (int)$_SESSION['customer_country_id'] . "') ";
							$t_where_part = " AND (gz.zone_id = '0' OR gz.zone_id = '" . (int)$_SESSION['customer_zone_id'] . "') ";
						}
						else
						{
							$t_select_part = ", ROUND(IF(s.status = '1' AND p.products_id = s.products_id, s.specials_new_products_price, p.products_price), 2) AS final_price ";
						}
							
						$sorting = str_replace('p.products_price', 'final_price', $sorting);
					}
					
					$listing_sql = "SELECT DISTINCT p.products_fsk18,
											p.products_shippingtime,
											p.products_model,
											p.products_ean,
											pd.products_name,
											m.manufacturers_name,
											p.products_quantity,
											p.products_image,
											p.products_weight,
											p.gm_show_weight,
											pd.products_short_description,
											pd.products_description,
											pd.gm_alt_text,
											pd.products_meta_description,
											p.products_id,
											p.manufacturers_id,
											p.products_price,
											p.products_vpe,
											p.products_vpe_status,
											p.products_vpe_value,
											p.products_discount_allowed,
											p.products_tax_class_id
											" . $t_select_part . "
										FROM  " . TABLE_PRODUCTS . " p
										LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " AS pd ON (pd.products_id = p.products_id) 
										LEFT JOIN " . TABLE_PRODUCTS_TO_CATEGORIES . " AS ptc ON (ptc.products_id = p.products_id) 
										LEFT JOIN " . TABLE_MANUFACTURERS . " AS m ON (m.manufacturers_id = p.manufacturers_id) 
										LEFT JOIN " . TABLE_SPECIALS . " AS s ON (s.products_id = p.products_id) 
										" . $t_from_part . "
										WHERE 	
											p.products_status = 1 AND
											pd.language_id = '" . (int)$_SESSION['languages_id'] . "' AND
											ptc.categories_id = '" . (int)$_GET['filter_id'] . "' AND
											m.manufacturers_id =  '" . (int)$_GET['manufacturers_id'] . "'
											" . $t_where_part . "
											" . $group_check . "
											" . $fsk_lock . "
											" . $sorting;
				}
				else
				{
					// We show them all
					if (GROUP_CHECK == 'true')
					{
						$group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
					}

					$sorting = '';
					# GM_MOD sorting
					if(isset($_GET['listing_sort'])) {
						$coo_listing_manager = MainFactory::create_object('ListingManager');
						$t_orderby = $coo_listing_manager->get_sql_sort_part($_GET['listing_sort']);
						if($t_orderby != '') $sorting = $t_orderby;
					}
					
					// sort by price
					if(strpos($t_orderby, 'p.products_price') !== false)
					{
						if($_SESSION['customers_status']['customers_status_show_price_tax'] != 0)
						{
							if(!isset ($_SESSION['customer_country_id']))
							{
								$_SESSION['customer_country_id'] = STORE_COUNTRY;
								$_SESSION['customer_zone_id'] = STORE_ZONE;
							}

							$t_select_part = ", ROUND(IF(s.status = '1' AND p.products_id = s.products_id, s.specials_new_products_price, p.products_price) * (IF(p.products_tax_class_id = 0,0,tax_rate)/100+1), 2) AS final_price ";
							$t_from_part = "LEFT JOIN " . TABLE_TAX_RATES . " AS tr ON (p.products_tax_class_id = tr.tax_class_id OR p.products_tax_class_id = 0) 
											LEFT JOIN " . TABLE_ZONES_TO_GEO_ZONES . " AS gz ON (tr.tax_zone_id = gz.geo_zone_id AND gz.zone_country_id = '" . (int)$_SESSION['customer_country_id'] . "') ";
							$t_where_part = " AND (gz.zone_id = '0' OR gz.zone_id = '" . (int)$_SESSION['customer_zone_id'] . "') ";
						}
						else
						{
							$t_select_part = ", ROUND(IF(s.status = '1' AND p.products_id = s.products_id, s.specials_new_products_price, p.products_price), 2) AS final_price ";
						}
							
						$sorting = str_replace('p.products_price', 'final_price', $sorting);
					}
					
					$listing_sql = "SELECT DISTINCT p.products_fsk18,
											p.products_shippingtime,
											p.products_model,
											p.products_ean,
											pd.products_name,
											m.manufacturers_name,
											p.products_quantity,
											p.products_image,
											p.products_weight,
											p.gm_show_weight,
											pd.products_short_description,
											pd.products_description,
											pd.gm_alt_text,
											pd.products_meta_description,
											p.products_id,
											p.manufacturers_id,
											p.products_price,
											p.products_vpe,
											p.products_vpe_status,
											p.products_vpe_value,
											p.products_discount_allowed,
											p.products_tax_class_id
											" . $t_select_part . "
										FROM  " . TABLE_PRODUCTS . " p
										LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " AS pd ON (pd.products_id = p.products_id) 
										LEFT JOIN " . TABLE_MANUFACTURERS . " AS m ON (m.manufacturers_id = p.manufacturers_id) 
										LEFT JOIN " . TABLE_SPECIALS . " AS s ON (s.products_id = p.products_id) 
										" . $t_from_part . "
										WHERE 	
											p.products_status = 1 AND
											pd.language_id = '" . (int)$_SESSION['languages_id'] . "' AND
											m.manufacturers_id =  '" . (int)$_GET['manufacturers_id'] . "'
											" . $t_where_part . "
											" . $group_check . "
											" . $fsk_lock . "
											" . $sorting;
				}
			}
			else
			{
				// show the products in a given categorie
				if(isset ($_GET['filter_id']) && xtc_not_null($_GET['filter_id']))
				{
					// sorting query
					$sorting_query = xtDBquery("SELECT products_sorting,
												products_sorting2 FROM ".TABLE_CATEGORIES."
												where categories_id='".$current_category_id."'");
					$sorting_data = xtc_db_fetch_array($sorting_query,true);
					if(!$sorting_data['products_sorting'])
					{
						$sorting_data['products_sorting'] = 'pd.products_name';
					}
					$sorting = ' ORDER BY '.$sorting_data['products_sorting'].' '.$sorting_data['products_sorting2'].' ';
					// We are asked to show only specific catgeory
					if (GROUP_CHECK == 'true')
					{
						$group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
					}

					# GM_MOD sorting
					if(isset($_GET['listing_sort'])) {
						$coo_listing_manager = MainFactory::create_object('ListingManager');
						$t_orderby = $coo_listing_manager->get_sql_sort_part($_GET['listing_sort']);
						if($t_orderby != '') $sorting = $t_orderby;
					}
					
					// sort by price
					if(strpos($t_orderby, 'p.products_price') !== false)
					{
						if($_SESSION['customers_status']['customers_status_show_price_tax'] != 0)
						{
							if(!isset ($_SESSION['customer_country_id']))
							{
								$_SESSION['customer_country_id'] = STORE_COUNTRY;
								$_SESSION['customer_zone_id'] = STORE_ZONE;
							}

							$t_select_part = ", ROUND(IF(s.status = '1' AND p.products_id = s.products_id, s.specials_new_products_price, p.products_price) * (IF(p.products_tax_class_id = 0,0,tax_rate)/100+1), 2) AS final_price ";
							$t_from_part = "LEFT JOIN " . TABLE_TAX_RATES . " AS tr ON (p.products_tax_class_id = tr.tax_class_id OR p.products_tax_class_id = 0) 
											LEFT JOIN " . TABLE_ZONES_TO_GEO_ZONES . " AS gz ON (tr.tax_zone_id = gz.geo_zone_id AND gz.zone_country_id = '" . (int)$_SESSION['customer_country_id'] . "') ";
							$t_where_part = " AND (gz.zone_id = '0' OR gz.zone_id = '" . (int)$_SESSION['customer_zone_id'] . "') ";
						}
						else
						{
							$t_select_part = ", ROUND(IF(s.status = '1' AND p.products_id = s.products_id, s.specials_new_products_price, p.products_price), 2) AS final_price ";
						}
							
						$sorting = str_replace('p.products_price', 'final_price', $sorting);
					}
					
					$listing_sql = "SELECT DISTINCT p.products_fsk18,
											p.products_shippingtime,
											p.products_model,
											p.products_ean,
											pd.products_name,
											m.manufacturers_name,
											p.products_quantity,
											p.products_image,
											p.products_weight,
											p.gm_show_weight,
											pd.products_short_description,
											pd.products_description,
											pd.gm_alt_text,
											pd.products_meta_description,
											p.products_id,
											p.manufacturers_id,
											p.products_price,
											p.products_vpe,
											p.products_vpe_status,
											p.products_vpe_value,
											p.products_discount_allowed,
											p.products_tax_class_id
											" . $t_select_part . "
										FROM  " . TABLE_PRODUCTS . " p
										LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " AS pd ON (pd.products_id = p.products_id) 
										LEFT JOIN " . TABLE_PRODUCTS_TO_CATEGORIES . " AS ptc ON (ptc.products_id = p.products_id) 
										LEFT JOIN " . TABLE_MANUFACTURERS . " AS m ON (m.manufacturers_id = p.manufacturers_id) 
										LEFT JOIN " . TABLE_SPECIALS . " AS s ON (s.products_id = p.products_id) 
										" . $t_from_part . "
										WHERE 	
											p.products_status = 1 AND
											pd.language_id = '" . (int)$_SESSION['languages_id'] . "' AND
											ptc.categories_id = '" . $current_category_id . "' AND
											m.manufacturers_id = '" . (int)$_GET['filter_id'] . "'
											" . $t_where_part . "
											" . $group_check . "
											" . $fsk_lock . "
											" . $sorting;
				}
				else
				{
					/* DEFAULT PRODUCT LISTING PAGE */

					// sorting query
					$sorting_query = xtDBquery("SELECT products_sorting,
												products_sorting2 FROM ".TABLE_CATEGORIES."
												where categories_id='".$current_category_id."'");
					$sorting_data = xtc_db_fetch_array($sorting_query,true);
					if(!$sorting_data['products_sorting'])
					{
						$sorting_data['products_sorting'] = 'pd.products_name';
					}
					$sorting = ' ORDER BY '.$sorting_data['products_sorting'].' '.$sorting_data['products_sorting2'].' ';
					// We show them all
					if(GROUP_CHECK == 'true')
					{
						$group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
					}

					# GM_MOD sorting
					if(isset($_GET['listing_sort'])) {
						$coo_listing_manager = MainFactory::create_object('ListingManager');
						$t_orderby = $coo_listing_manager->get_sql_sort_part($_GET['listing_sort']);
						if($t_orderby != '') $sorting = $t_orderby;
					}

					# GM_MOD product filter
					if($_SESSION['coo_filter_manager']->is_active() == true)
					{
						# filter is active
						$coo_finder = MainFactory::create_object('IndexFeatureProductFinder');

						# set categories_id
						$t_categories_id = $_SESSION['coo_filter_manager']->get_categories_id();
						$coo_finder->add_categories_id((int)$current_category_id);

						# set price range
						$t_price_start = $_SESSION['coo_filter_manager']->get_price_range_start();
						$t_price_end = $_SESSION['coo_filter_manager']->get_price_range_end();
						if($t_price_start !== false) $coo_finder->set_price_range_start($t_price_start);
						if($t_price_end !== false) $coo_finder->set_price_range_end($t_price_end);

						# get feature_value_groups from FilterManager
						$t_feature_value_group_array = $_SESSION['coo_filter_manager']->get_feature_value_group_array();

						# transfer feature_value_groups to product finder
						foreach($t_feature_value_group_array as $t_feature_value_group)
						{
							$coo_finder->add_feature_value_group($t_feature_value_group);
						}

						# get built sql query for product_listing
						$t_filter_sql = $coo_finder->get_products_listing_sql_string($group_check . $fsk_lock, $sorting);

						# set filter query for listing
						$listing_sql = $t_filter_sql;						
					}
					else
					{
						# use default listing		
							
						// sort by price
						if(strpos($t_orderby, 'p.products_price') !== false)
						{
							if($_SESSION['customers_status']['customers_status_show_price_tax'] != 0)
							{
								if(!isset ($_SESSION['customer_country_id']))
								{
									$_SESSION['customer_country_id'] = STORE_COUNTRY;
									$_SESSION['customer_zone_id'] = STORE_ZONE;
								}
								
								$t_select_part = ", ROUND(IF(s.status = '1' AND p.products_id = s.products_id, s.specials_new_products_price, p.products_price) * (IF(p.products_tax_class_id = 0,0,tax_rate)/100+1), 2) AS final_price ";
								$t_from_part = "LEFT JOIN " . TABLE_TAX_RATES . " AS tr ON (p.products_tax_class_id = tr.tax_class_id OR p.products_tax_class_id = 0) 
												LEFT JOIN " . TABLE_ZONES_TO_GEO_ZONES . " AS gz ON (tr.tax_zone_id = gz.geo_zone_id AND gz.zone_country_id = '" . (int)$_SESSION['customer_country_id'] . "') ";
								$t_where_part = " AND (gz.zone_id = '0' OR gz.zone_id = '" . (int)$_SESSION['customer_zone_id'] . "') ";
							}
							else
							{
								$t_select_part = ", ROUND(IF(s.status = '1' AND p.products_id = s.products_id, s.specials_new_products_price, p.products_price), 2) AS final_price ";
							}
							
							$sorting = str_replace('p.products_price', 'final_price', $sorting);
						}
						
						$listing_sql = "SELECT DISTINCT p.products_fsk18,
											p.products_shippingtime,
											p.products_model,
											p.products_ean,
											pd.products_name,
											m.manufacturers_name,
											p.products_quantity,
											p.products_image,
											p.products_weight,
											p.gm_show_weight,
											pd.products_short_description,
											pd.products_description,
											pd.gm_alt_text,
											pd.products_meta_description,
											p.products_id,
											p.manufacturers_id,
											p.products_price,
											p.products_vpe,
											p.products_vpe_status,
											p.products_vpe_value,
											p.products_discount_allowed,
											p.products_tax_class_id
											" . $t_select_part . "
										FROM  " . TABLE_PRODUCTS . " p
										LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " AS pd ON (pd.products_id = p.products_id) 
										LEFT JOIN " . TABLE_PRODUCTS_TO_CATEGORIES . " AS ptc ON (ptc.products_id = p.products_id) 
										LEFT JOIN " . TABLE_MANUFACTURERS . " AS m ON (m.manufacturers_id = p.manufacturers_id) 
										LEFT JOIN " . TABLE_SPECIALS . " AS s ON (s.products_id = p.products_id) 
										" . $t_from_part . "
										WHERE 	
											p.products_status = 1 AND
											pd.language_id = '" . (int)$_SESSION['languages_id'] . "' AND
											ptc.categories_id = '" . $current_category_id . "'
											" . $t_where_part . "
											" . $group_check . "
											" . $fsk_lock . "
											" . $sorting;
					}
				}
			}

			// optional Product List Filter
			if(PRODUCT_LIST_FILTER > 0)
			{
				if(isset ($_GET['manufacturers_id']))
				{
					$filterlist_sql = "select distinct c.categories_id as id, cd.categories_name as name from ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_TO_CATEGORIES." p2c, ".TABLE_CATEGORIES." c, ".TABLE_CATEGORIES_DESCRIPTION." cd where p.products_status = '1' and p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and p2c.categories_id = cd.categories_id and cd.language_id = '".(int) $_SESSION['languages_id']."' and p.manufacturers_id = '".(int) $_GET['manufacturers_id']."' order by cd.categories_name";
				}
				else
				{
					$filterlist_sql = "select distinct m.manufacturers_id as id, m.manufacturers_name as name from ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_TO_CATEGORIES." p2c, ".TABLE_MANUFACTURERS." m where p.products_status = '1' and p.manufacturers_id = m.manufacturers_id and p.products_id = p2c.products_id and p2c.categories_id = '".$current_category_id."' order by m.manufacturers_name";
				}
				$filterlist_query = xtDBquery($filterlist_sql);
				if(xtc_db_num_rows($filterlist_query, true) > 1)
				{
					$t_manufacturers_data_array = array();
					$t_manufacturers_data_array['FORM']['ID'] = 'filter';
					$t_manufacturers_data_array['FORM']['ACTION'] = xtc_href_link(FILENAME_DEFAULT, '', 'NONSSL', true, true, true);
					$t_manufacturers_data_array['FORM']['METHOD'] = 'get';


					$manufacturer_dropdown = xtc_draw_form('filter', xtc_href_link(FILENAME_DEFAULT, '', 'NONSSL', true, true, true), 'get', 'style="float:right"');
					if(isset($_GET['manufacturers_id']))
					{
						$manufacturer_dropdown .= xtc_draw_hidden_field('manufacturers_id', (int)$_GET['manufacturers_id']);
						$options = array (array ('text' => TEXT_ALL_CATEGORIES));
						$t_manufacturers_data_array['HIDDEN'][0]['NAME'] = 'manufacturers_id';
						$t_manufacturers_data_array['HIDDEN'][0]['VALUE'] = (int)$_GET['manufacturers_id'];
						$t_manufacturers_data_array['OPTIONS'][0]['VALUE'] = '';
						$t_manufacturers_data_array['OPTIONS'][0]['NAME'] = TEXT_ALL_CATEGORIES;
					}
					else
					{
						$manufacturer_dropdown .= xtc_draw_hidden_field('cat', $_GET['cat']);
						$options = array (array ('text' => TEXT_ALL_MANUFACTURERS));
						$t_manufacturers_data_array['HIDDEN'][0]['NAME'] = 'cat';
						$t_manufacturers_data_array['HIDDEN'][0]['VALUE'] = $_GET['cat'];
						$t_manufacturers_data_array['OPTIONS'][0]['VALUE'] = '';
						$t_manufacturers_data_array['OPTIONS'][0]['NAME'] = TEXT_ALL_MANUFACTURERS;
					}
					$manufacturer_dropdown .= xtc_draw_hidden_field('sort', $_GET['sort']);
					$manufacturer_dropdown .= xtc_draw_hidden_field(xtc_session_name(), xtc_session_id());
					$t_manufacturers_data_array['HIDDEN'][1]['NAME'] = 'sort';
					$t_manufacturers_data_array['HIDDEN'][1]['VALUE'] = $_GET['sort'];
					$t_manufacturers_data_array['HIDDEN'][2]['NAME'] = xtc_session_name();
					$t_manufacturers_data_array['HIDDEN'][2]['VALUE'] = xtc_session_id();
					$count_options = 1;
					while($filterlist = xtc_db_fetch_array($filterlist_query, true))
					{
						$options[] = array ('id' => $filterlist['id'], 'text' => $filterlist['name']);
						$t_manufacturers_data_array['OPTIONS'][$count_options]['VALUE'] = $filterlist['id'];
						$t_manufacturers_data_array['OPTIONS'][$count_options]['NAME'] = $filterlist['name'];
						$count_options++;
					}
					$t_manufacturers_data_array['DEFAULT'] = $_GET['filter_id'];
					$t_manufacturers_data_array['NAME'] = 'filter_id';
					$manufacturer_dropdown .= xtc_draw_pull_down_menu('filter_id', $options, $_GET['filter_id'], 'onchange="this.form.submit()"');
					$manufacturer_dropdown .= '</form>'."\n";


				}
			}

			// Get the right image for the top-right
			$image = DIR_WS_IMAGES.'table_background_list.gif';
			if(isset ($_GET['manufacturers_id']))
			{
				$image = xtDBquery("select manufacturers_image from ".TABLE_MANUFACTURERS." where manufacturers_id = '".(int) $_GET['manufacturers_id']."'");
				$image = xtc_db_fetch_array($image,true);
				$image = $image['manufacturers_image'];
			}
			elseif ($current_category_id) {
				$image = xtDBquery("select categories_image from ".TABLE_CATEGORIES." where categories_id = '".$current_category_id."'");
				$image = xtc_db_fetch_array($image,true);
				$image = $image['categories_image'];
			}
			include (DIR_WS_MODULES.FILENAME_PRODUCT_LISTING);
			break;

		default:
			//// default page
			if(GROUP_CHECK == 'true')
			{
				$group_check = "and group_ids LIKE '%c_".$_SESSION['customers_status']['customers_status_id']."_group%'";
			}
			$shop_content_query = xtDBquery("SELECT
												content_title,
												content_heading,
												content_text,
												content_file
											FROM ".TABLE_CONTENT_MANAGER."
											WHERE content_group='5'
												".$group_check."
												AND languages_id='".$_SESSION['languages_id']."'");
			$shop_content_data = xtc_db_fetch_array($shop_content_query,true);

			$default_smarty->assign('title', $shop_content_data['content_heading']);
			include (DIR_WS_INCLUDES.FILENAME_CENTER_MODULES);



			if($shop_content_data['content_file'] != '')
			{
				ob_start();
				if(strpos($shop_content_data['content_file'], '.txt'))
				{
					echo '<pre>';
				}
				include (DIR_FS_CATALOG.'media/content/'.$shop_content_data['content_file']);
				if(strpos($shop_content_data['content_file'], '.txt'))
				{
					echo '</pre>';
				}
				$shop_content_data['content_text'] = ob_get_contents();
				ob_end_clean();
			}

			$default_smarty->assign('text', str_replace('{$greeting}', xtc_customer_greeting(), $shop_content_data['content_text']));


			if(GROUP_CHECK == 'true')
			{
				$group_check = "and group_ids LIKE '%c_".$_SESSION['customers_status']['customers_status_id']."_group%'";
			}
			$shop_content_query = xtDBquery("SELECT
												content_title,
												content_heading,
												content_text,
												content_file
											FROM ".TABLE_CONTENT_MANAGER."
											WHERE content_group='10'
												".$group_check."
												AND languages_id='".$_SESSION['languages_id']."'");
			$shop_content_data = xtc_db_fetch_array($shop_content_query,true);

			$default_smarty->assign('title_center', $shop_content_data['content_heading']);



			if($shop_content_data['content_file'] != '')
			{
				ob_start();
				if(strpos($shop_content_data['content_file'], '.txt'))
				{
					echo '<pre>';
				}
				include (DIR_FS_CATALOG.'media/content/'.$shop_content_data['content_file']);
				if(strpos($shop_content_data['content_file'], '.txt'))
				{
					echo '</pre>';
				}
				$shop_content_data['content_text'] = ob_get_contents();
				ob_end_clean();
			}

			$default_smarty->assign('text_center', str_replace('{$greeting}', xtc_customer_greeting(), $shop_content_data['content_text']));

			if(GROUP_CHECK == 'true')
			{
				$group_check = "and group_ids LIKE '%c_".$_SESSION['customers_status']['customers_status_id']."_group%'";
			}
			$shop_content_query = xtDBquery("SELECT
												content_title,
												content_heading,
												content_text,
												content_file
											FROM ".TABLE_CONTENT_MANAGER."
											WHERE content_group='11'
												".$group_check."
												AND languages_id='".$_SESSION['languages_id']."'");
			$shop_content_data = xtc_db_fetch_array($shop_content_query,true);

			$default_smarty->assign('title_bottom', $shop_content_data['content_heading']);



			if($shop_content_data['content_file'] != '')
			{
				ob_start();
				if(strpos($shop_content_data['content_file'], '.txt'))
				{
					echo '<pre>';
				}
				include (DIR_FS_CATALOG.'media/content/'.$shop_content_data['content_file']);
				if(strpos($shop_content_data['content_file'], '.txt'))
				{
					echo '</pre>';
				}
				$shop_content_data['content_text'] = ob_get_contents();
				ob_end_clean();
			}

			$default_smarty->assign('text_bottom', str_replace('{$greeting}', xtc_customer_greeting(), $shop_content_data['content_text']));
			$default_smarty->assign('language', $_SESSION['language']);

			// set cache ID
			$default_smarty->caching = 0;
			$main_content = $default_smarty->fetch(CURRENT_TEMPLATE.'/module/main_content.html');

			//$smarty->assign('main_content', $main_content);
	}
	$smarty->assign('main_content', $main_content);
	
}
?>