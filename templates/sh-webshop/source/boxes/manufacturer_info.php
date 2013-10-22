<?php
/* --------------------------------------------------------------
   manufacturer_info.php 2010-09-23 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(manufacturer_info.php,v 1.10 2003/02/12); www.oscommerce.com
   (c) 2003	 nextcommerce (manufacturer_info.php,v 1.6 2003/08/13); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: manufacturer_info.php 1262 2005-09-30 10:00:32Z mz $) 

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

$coo_manufacturers_info = MainFactory::create_object('ManufacturersInfoContentView');
$t_box_html = $coo_manufacturers_info->get_html($product);

$gm_box_pos = $coo_template_control->get_menubox_position('manufacturers_info');
$smarty->assign($gm_box_pos, $t_box_html);

?>