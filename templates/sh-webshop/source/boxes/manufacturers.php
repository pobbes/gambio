<?php
/* --------------------------------------------------------------
   manufacturers.php 2010-09-30 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(manufacturers.php,v 1.18 2003/02/10); www.oscommerce.com
   (c) 2003	 nextcommerce (manufacturers.php,v 1.9 2003/08/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: manufacturers.php 1262 2005-09-30 10:00:32Z mz $)

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

$coo_manufacturers = MainFactory::create_object('ManufacturersContentView');
$f_manufacturers_id = false;
if(!empty($_GET['manufacturers_id']))
{
	$f_manufacturers_id = $_GET['manufacturers_id'];
}
$t_box_html = $coo_manufacturers->get_html($f_manufacturers_id);

$gm_box_pos = $coo_template_control->get_menubox_position('manufacturers');
$smarty->assign($gm_box_pos, $t_box_html);

?>