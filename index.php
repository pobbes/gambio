<?php
/* --------------------------------------------------------------
   index.php 2012-05-07 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(default.php,v 1.84 2003/05/07); www.oscommerce.com
   (c) 2003	 nextcommerce (default.php,v 1.13 2003/08/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: index.php 1321 2005-10-26 20:55:07Z mz $)

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   Enable_Disable_Categories 1.3        	Autor: Mikel Williams | mikel@ladykatcostumes.com
   Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');

// create smarty elements
$smarty = new Smarty;

# GM_MOD FeatureFilter
if(isset($_GET['filter_fv_id']) || isset($_GET['filter_price_min']) || isset($_GET['filter_price_max']) || isset($_GET['value_conjunction']))
{
	# clear filter and deactivate
	$_SESSION['coo_filter_manager']->reset();

	# set current category
	$_SESSION['coo_filter_manager']->set_categories_id((int)$_GET['filter_categories_id']);

	# set price range
	if(isset($_GET['filter_price_min']) && !empty($_GET['filter_price_min'] )) $_SESSION['coo_filter_manager']->set_price_range_start($_GET['filter_price_min']);
	if(isset($_GET['filter_price_max']) && !empty($_GET['filter_price_max'] )) $_SESSION['coo_filter_manager']->set_price_range_end($_GET['filter_price_max']);
	
	if(is_array($_GET['filter_fv_id']) == false) {
		# filter_fv_id is a single id
		$_SESSION['coo_filter_manager']->add_feature_value_id($_GET['filter_fv_id']);
	}
	else {
		# filter_fv_id is an array. add groups.
		foreach($_GET['filter_fv_id'] as $f_feature_id => $f_feature_value_id_array)
		{
			$c_feature_id = (int)$f_feature_id;
			$f_conjunction = $_GET['value_conjunction'][$c_feature_id];
			
			$_SESSION['coo_filter_manager']->add_feature_value_group($f_feature_value_id_array, $f_conjunction);
		}

	}
	# activate filter
	$_SESSION['coo_filter_manager']->set_active(true);
	
	# get filter data for check
	$t_id_array = $_SESSION['coo_filter_manager']->get_feature_value_id_array();
	$t_group_array = $_SESSION['coo_filter_manager']->get_feature_value_group_array();
	$t_price_start = $_SESSION['coo_filter_manager']->get_price_range_start();
	$t_price_end = $_SESSION['coo_filter_manager']->get_price_range_end();
	
	if(sizeof($t_id_array) == 0 && sizeof($t_group_array) == 0 && $t_price_start == 0 && $t_price_end == 0)
	{
		# filter manager is empty -> deactivate
		$_SESSION['coo_filter_manager']->set_active(false);
	}
}
else {
	# no filter information given. deactivate filter
	$_SESSION['coo_filter_manager']->set_active(false);
	$_SESSION['coo_filter_manager']->reset();
}



// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');

// the following cPath references come from application_top.php
$category_depth = 'top';
if ((strpos(strtolower(gm_get_env_info("PHP_SELF")), FILENAME_DEFAULT) !== false && $_SESSION['coo_filter_manager']->is_active() ) || isset ($cPath) && xtc_not_null($cPath)) {

	// BOF GM_MOD
	if(GROUP_CHECK == 'false')
	{
		$categories_products_query = "SELECT COUNT(*) AS total
										FROM
											".TABLE_PRODUCTS_TO_CATEGORIES." ptc,
											" . TABLE_PRODUCTS . " p
										WHERE
											ptc.categories_id = '".$current_category_id."'
											AND ptc.products_id = p.products_id
											AND p.products_status = '1'";
	}
	else
	{
		$c_gm_customers_status_id = (int)$_SESSION['customers_status']['customers_status_id'];

		$categories_products_query = "SELECT COUNT(*) AS total
										FROM
											".TABLE_PRODUCTS_TO_CATEGORIES." ptc,
											" . TABLE_PRODUCTS . " p
										WHERE
											ptc.categories_id = '".$current_category_id."'
											AND ptc.products_id = p.products_id
											AND p.products_status = '1'
											AND p.group_permission_" . $c_gm_customers_status_id . " = '1'";
	}
	// EOF GM_MOD

	$categories_products_query = xtDBquery($categories_products_query);
	$cateqories_products = xtc_db_fetch_array($categories_products_query, true);
	if ($cateqories_products['total'] > 0) {
		#$category_depth = 'products'; // display products
		$category_depth = 'nested'; // navigate through the categories
	} else {
		$category_parent_query = "select count(*) as total from ".TABLE_CATEGORIES." where parent_id = '".$current_category_id."'";
		$category_parent_query = xtDBquery($category_parent_query);
		$category_parent = xtc_db_fetch_array($category_parent_query, true);
		if ($category_parent['total'] > 0) {
			$category_depth = 'nested'; // navigate through the categories
			//$category_depth = 'products'; // navigate through the categories
		} else {
			$category_depth = 'products'; // category has no products, but display the 'no products' message
		}
	}
}
elseif(isset($_GET['manufacturers_id'])) {
	$category_depth = 'products';
}

require (DIR_WS_INCLUDES.'header.php');

include (DIR_WS_MODULES.'default.php');
$smarty->assign('language', $_SESSION['language']);

$smarty->caching = 0;

// Normale Startseite:
//if (!defined(RM))
//	$smarty->load_filter('output', 'note');
//$smarty->display(CURRENT_TEMPLATE.'/index.html');

// Andere Startseite:
if($category_depth == 'top'){
	$smarty->display(CURRENT_TEMPLATE.'/home.html');
}else{ 
	$smarty->display(CURRENT_TEMPLATE.'/index.html');
}

include ('includes/application_bottom.php');
?>