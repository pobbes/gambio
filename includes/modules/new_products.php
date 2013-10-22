<?php
/* --------------------------------------------------------------
   new_products.php 2008-08-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(new_products.php,v 1.33 2003/02/12); www.oscommerce.com
   (c) 2003	 nextcommerce (new_products.php,v 1.9 2003/08/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: new_products.php 1292 2005-10-07 16:10:55Z mz $)

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   Enable_Disable_Categories 1.3        	Autor: Mikel Williams | mikel@ladykatcostumes.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
if(!gm_get_conf("GM_PRODUCTS_STARTPAGE")) {
	
	$gm_result = xtc_db_query("SELECT 
									products_startpage 
								FROM " . 
									TABLE_PRODUCTS . " 
								WHERE 
									products_startpage = '1'
							");
							
	if(xtc_db_num_rows($gm_result) > 0) {
		gm_set_conf("GM_PRODUCTS_STARTPAGE", "1");
	} else {
		gm_set_conf("GM_PRODUCTS_STARTPAGE", "0");
	}
} 

if(gm_get_conf("GM_PRODUCTS_STARTPAGE") == '1') {

	$module_smarty = new Smarty;
	$module_smarty->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
	// bof gm
	$module_smarty->assign('thumbnail_heigth', PRODUCT_IMAGE_THUMBNAIL_HEIGHT + 40);

	$gm_image_len = PRODUCT_IMAGE_THUMBNAIL_HEIGHT;
	if($gm_image_len < PRODUCT_IMAGE_THUMBNAIL_WIDTH) $gm_image_len = PRODUCT_IMAGE_THUMBNAIL_WIDTH;

	$module_smarty->assign('gm_thumbnail_heigth',	$gm_image_len + 8);
	$module_smarty->assign('gm_thumbnail_width',	$gm_image_len + 8);


	// eof gm
	//fsk18 lock
	$fsk_lock = '';
	if ($_SESSION['customers_status']['customers_fsk18_display'] == '0')
		$fsk_lock = ' and p.products_fsk18!=1';

	if ((!isset ($new_products_category_id)) || ($new_products_category_id == '0')) {
		if (GROUP_CHECK == 'true')
			$group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";

		// BOF GM_MOD:
		$new_products_query = "SELECT * FROM
												 ".TABLE_PRODUCTS." p,
												 ".TABLE_PRODUCTS_DESCRIPTION." pd WHERE
												 p.products_id=pd.products_id and
												 p.products_startpage = '1'
												 ".$group_check."
												 ".$fsk_lock."
												 and p.products_status = '1' and pd.language_id = '".(int) $_SESSION['languages_id']."'
												 order by p.products_startpage_sort ASC";
	} else {

		if (GROUP_CHECK == 'true')
			$group_check = "and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";

		if (MAX_DISPLAY_NEW_PRODUCTS_DAYS != '0') {
			$date_new_products = date("Y.m.d", mktime(1, 1, 1, date(m), date(d) - MAX_DISPLAY_NEW_PRODUCTS_DAYS, date(Y)));
			$days = " and p.products_date_added > '".$date_new_products."' ";
		}
		$new_products_query = "SELECT * FROM
												".TABLE_PRODUCTS." p,
												".TABLE_PRODUCTS_DESCRIPTION." pd,
												".TABLE_PRODUCTS_TO_CATEGORIES." p2c,
												".TABLE_CATEGORIES." c
												where c.categories_status='1'
												and p.products_id = p2c.products_id and p.products_id=pd.products_id
												and p2c.categories_id = c.categories_id
												".$group_check."
												".$fsk_lock."
												and c.parent_id = '".$new_products_category_id."'
												and p.products_status = '1' and pd.language_id = '".(int) $_SESSION['languages_id']."'
												order by p.products_date_added DESC limit ".MAX_DISPLAY_NEW_PRODUCTS;
	}
	$row = 0;
	$module_content = array ();
	$new_products_query = xtDBquery($new_products_query);
	while ($new_products = xtc_db_fetch_array($new_products_query, true)) {
		$module_content[] = $product->buildDataArray($new_products);
		
		// bof gm
		/*
		$gm_count = count($module_content);
		if(!empty($module_content[$gm_count-1]['PRODUCTS_IMAGE'])) {
			$gm_count = count($module_content);
			$gm_imagesize = getimagesize(DIR_FS_CATALOG . $module_content[$gm_count-1]['PRODUCTS_IMAGE']);
			$module_content[$gm_count-1]['GM_IMAGE_PADDING'] = ((PRODUCT_IMAGE_THUMBNAIL_HEIGHT + 8) - $gm_imagesize[1])/2;
		}
		*/
		// eof gm
	}

	// BOF GM_MOD
	$module_smarty->assign('TEXT_ADD_TO_CART', TEXT_ADD_TO_CART);
	$module_smarty->assign('TRUNCATE_PRODUCTS_NAME', gm_get_conf('TRUNCATE_PRODUCTS_NAME'));
	// EOF GM_MOD

	if (sizeof($module_content) >= 1) {
		$module_smarty->assign('language', $_SESSION['language']);
		$module_smarty->assign('module_content', $module_content);
		
		// set cache ID
		 if (!CacheCheck()) {
			$module_smarty->caching = 0;
			if ((!isset ($new_products_category_id)) || ($new_products_category_id == '0')) {
				$module = $module_smarty->fetch(CURRENT_TEMPLATE.'/module/new_products_default.html');
			} else {
				$module = $module_smarty->fetch(CURRENT_TEMPLATE.'/module/new_products.html');
			}
		} else {
			$module_smarty->caching = 1;
			$module_smarty->cache_lifetime = CACHE_LIFETIME;
			$module_smarty->cache_modified_check = CACHE_CHECK;
			$cache_id = $new_products_category_id.$_SESSION['language'].$_SESSION['customers_status']['customers_status_name'].$_SESSION['currency'];
			if ((!isset ($new_products_category_id)) || ($new_products_category_id == '0')) {
				$module = $module_smarty->fetch(CURRENT_TEMPLATE.'/module/new_products_default.html', $cache_id);
			} else {
				$module = $module_smarty->fetch(CURRENT_TEMPLATE.'/module/new_products.html', $cache_id);
			}
		}
		$default_smarty->assign('MODULE_new_products', $module);
	}
}
?>