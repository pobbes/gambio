<?php
/* --------------------------------------------------------------
   whats_new.php 2010-09-30 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(whats_new.php,v 1.31 2003/02/10); www.oscommerce.com 
   (c) 2003	 nextcommerce (whats_new.php,v 1.12 2003/08/21); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: whats_new.php 1292 2005-10-07 16:10:55Z mz $)

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   Enable_Disable_Categories 1.3        	Autor: Mikel Williams | mikel@ladykatcostumes.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

$coo_whats_new = MainFactory::create_object('WhatsNewContentView');
$f_products_id = false;
if(!empty($_GET['products_id']))
{
	$f_products_id = $_GET['products_id'];
}
$t_box_html = $coo_whats_new->get_html($product, $xtPrice, $f_products_id);

$gm_box_pos = $coo_template_control->get_menubox_position('whatsnew');
$smarty->assign($gm_box_pos, $t_box_html);

?>