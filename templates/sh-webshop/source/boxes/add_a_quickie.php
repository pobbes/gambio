<?php
/* --------------------------------------------------------------
   add_a_quickie.php 2008-08-09 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(add_a_quickie.php,v 1.10 2001/12/19); www.oscommerce.com
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: add_a_quickie.php 1262 2005-09-30 10:00:32Z mz $) 

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contribution:
   Add A Quickie v1.0 Autor  Harald Ponce de Leon
    
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

$coo_add_a_quickie = MainFactory::create_object('AddAQuickieContentView');
$t_box_html = $coo_add_a_quickie->get_html();

$gm_box_pos = $coo_template_control->get_menubox_position('add_quickie');
$smarty->assign($gm_box_pos, $t_box_html);
?>