<?php
/* --------------------------------------------------------------
   categories.php 2011-12-02 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(categories.php,v 1.23 2002/11/12); www.oscommerce.com 
   (c) 2003	 nextcommerce (categories.php,v 1.10 2003/08/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: categories.php 1302 2005-10-12 16:21:29Z mz $)

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   Enable_Disable_Categories 1.3        	Autor: Mikel Williams | mikel@ladykatcostumes.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
// reset var

if(gm_get_conf('CAT_MENU_LEFT') == 'true')
{
	#menu left
	$coo_categories = MainFactory::create_object('CategoriesContentView');
	$coo_categories->set_content_template('boxes/box_categories_left.html');
	$coo_categories->set_tree_depth(1);
	$t_box_html = $coo_categories->get_html(0);

	#$gm_box_pos = $coo_template_control->get_menubox_position('categories');
	#$smarty->assign($gm_box_pos, $t_box_html);
    $smarty->assign('CATEGORIES', $t_box_html);

	$coo_categories_submenus_content_view = MainFactory::create_object('CategoriesSubmenusContentView');
	$t_html = $coo_categories_submenus_content_view->get_html($cPath);
	$smarty->assign('CATEGORIES_SUBMENUS', $t_html);
}
elseif(gm_get_conf('CAT_MENU_CLASSIC') == 'true')
{
	#classic menu left
	$coo_categories = MainFactory::create_object('CategoriesBoxContentView');
	$t_box_html = $coo_categories->get_html($cPath);

	#$gm_box_pos = $coo_template_control->get_menubox_position('categories');
	#$smarty->assign($gm_box_pos, $t_box_html);
    $smarty->assign('CATEGORIES', $t_box_html);
}
?>