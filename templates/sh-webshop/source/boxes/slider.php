<?php
/* --------------------------------------------------------------
   slider.php 2011-05-01 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
 */

$t_slider_set_id = 0;

# on index.php? (home or category)
if(strpos(strtolower(gm_get_env_info("PHP_SELF")), FILENAME_DEFAULT) !== false && isset($_GET['manufacturers_id']) == false)
{
	if(empty($cID) == true && isset($_GET['filter_fv_id']) == false && isset($_GET['filter_price_min']) == false && isset($_GET['filter_price_max']) == false)
	{
		# use default slider for home
		$t_slider_set_id = (int)gm_get_conf('GM_SLIDER_INDEX_ID');
	}
	else
	{
		# look for slider_id for category
		$coo_cat_slider_handler = MainFactory::create_object('CategorySliderHandler');
		$t_slider_set_id = $coo_cat_slider_handler->get_category_slider_id($cID);
	}
}

// slider for productinfo
if(strpos(strtolower(gm_get_env_info("PHP_SELF")), FILENAME_PRODUCT_INFO) !== false && isset($_GET['manufacturers_id']) == false)
{
	if(!empty($actual_products_id))
	{
		# look for slider_id for product
		$coo_product_slider_handler = MainFactory::create_object('ProductSliderHandler');
		$t_slider_set_id = $coo_product_slider_handler->get_product_slider_id($actual_products_id);
	}
}
// slider for content
if(strpos(strtolower(gm_get_env_info("PHP_SELF")), FILENAME_CONTENT) !== false && isset($_GET['manufacturers_id']) == false)
{
	if(!empty($_GET['coID']))
	{
		# look for slider_id for content
		$coo_content_slider_handler = MainFactory::create_object('ContentSliderHandler');
		$t_slider_set_id = $coo_content_slider_handler->get_content_slider_id($_GET['coID']);
	}
}

# slider available?
if($t_slider_set_id != 0)
{
	$c_language_id = (int) $_SESSION['languages_id'];
	$coo_slider_content_view = MainFactory::create_object('ImageSliderContentView');

	$t_html = $coo_slider_content_view->get_html($t_slider_set_id, $c_language_id);
	$smarty->assign('IMGSLIDER', $t_html);
}
?>