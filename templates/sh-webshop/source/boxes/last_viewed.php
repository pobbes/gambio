<?php
/* --------------------------------------------------------------
   last_viewed.php 2010-09-24 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: last_viewed.php 1292 2005-10-07 16:10:55Z mz $)

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

$coo_last_viewed = MainFactory::create_object('LastViewedContentView');
$t_box_html = $coo_last_viewed->get_html($product, $xtPrice);

$gm_box_pos = $coo_template_control->get_menubox_position('last_viewed');
$smarty->assign($gm_box_pos, $t_box_html);

?>