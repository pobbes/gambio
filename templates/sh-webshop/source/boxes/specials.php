<?php
/* --------------------------------------------------------------
   specials.php 2008-11-28 mb
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(specials.php,v 1.30 2003/02/10); www.oscommerce.com 
   (c) 2003	 nextcommerce (specials.php,v 1.10 2003/08/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: specials.php 1292 2005-10-07 16:10:55Z mz $)

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

$coo_specials = MainFactory::create_object('SpecialsContentView');
$t_box_html = $coo_specials->get_html($product);

$gm_box_pos = $coo_template_control->get_menubox_position('specials');
$smarty->assign($gm_box_pos, $t_box_html);

?>