<?php
/* --------------------------------------------------------------
   filter.php 2011-03-09 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
 */

# shop language id
$t_shop_language_id = (int) $_SESSION['languages_id'];

if(isset($_GET['filter_categories_id'])) {
	$c_filter_categories_id = (int)$_GET['filter_categories_id'];
} else {
	$c_filter_categories_id = (int)$cID;
}

$t_is_index = strpos(strtolower(gm_get_env_info("PHP_SELF")), FILENAME_DEFAULT);
if(($t_is_index !== false && $actual_products_id == '' && $c_filter_categories_id >= 0) || $_SESSION['style_edit_mode'] == 'edit')
{
	$t_selected_feature_value_id_array = array();

	$t_feature_value_group_array = $_SESSION['coo_filter_manager']->get_feature_value_group_array();
	for($i=0; $i<sizeof($t_feature_value_group_array); $i++)
	{
		$t_selected_feature_value_id_array = array_merge($t_selected_feature_value_id_array, $t_feature_value_group_array[$i]['FEATURE_VALUE_ID_ARRAY']);
	}

	if(isset($_GET['filter_price_min'])) $t_price_start = $_GET['filter_price_min']; else $t_price_start = '';
	if(isset($_GET['filter_price_max'])) $t_price_end = $_GET['filter_price_max']; else $t_price_end = '';

	$coo_content_view = MainFactory::create_object('FilterContentView');
	$t_html = $coo_content_view->get_html($c_filter_categories_id, $t_shop_language_id, $t_selected_feature_value_id_array, $t_price_start, $t_price_end);
	$smarty->assign($coo_template_control->get_menubox_position('filter'), $t_html);
}
?>