<?php
/* --------------------------------------------------------------
   accordion_menu.php 2013-04-17
   ---------------------------------------------------------------------------------------*/

$coo_accordion_menu = MainFactory::create_object('AccordionMenuContentView');
$coo_accordion_menu->set_content_template('boxes/box_accordion_menu.html');
$coo_accordion_menu->set_tree_depth(1);
$t_accordion_menu_html = $coo_accordion_menu->get_html();

$smarty->assign('ACCORDION_MENU', $t_accordion_menu_html);

?>