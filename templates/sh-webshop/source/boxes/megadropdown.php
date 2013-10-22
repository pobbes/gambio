<?php
/* --------------------------------------------------------------
   megadropdown.php 2011-03-09 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
 */

# Categories Top
$coo_content_view = MainFactory::create_object('CategoriesContentView');
$coo_content_view->set_content_template('boxes/box_categories_top.html');
$coo_content_view->set_tree_depth(1);
//$t_categories_html = $coo_categories_top->get_html($cID);
$t_html = $coo_content_view->get_html(0);
$smarty->assign('CATEGORIES_TOP', $t_html);


# Megadropdowns
$coo_content_view = MainFactory::create_object('CategoriesContentView');
$coo_content_view->set_content_template('module/megadropdown.html');
$coo_content_view->set_tree_depth(1);

$coo_categories_agent =& MainFactory::create_object('CategoriesAgent', array(), true);
$t_categories_info_array = $coo_categories_agent->get_categories_info_tree(0, $_SESSION['languages_id'], 0);

$t_html = '';
for($i=0; $i<sizeof($t_categories_info_array); $i++)
{
	$t_categories_id = $t_categories_info_array[$i]['data']['id'];
	$t_html .= $coo_content_view->get_html($t_categories_id);
}
$smarty->assign('CATEGORIES_DROPDOWN', $t_html);

?>