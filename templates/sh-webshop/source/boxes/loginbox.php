<?php
/* --------------------------------------------------------------
   loginbox.php 2008-08-09 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommercebased on original files from OSCommerce CVS 2.2 2002/08/28 02:14:35 www.oscommerce.com 
   (c) 2003	 nextcommerce (loginbox.php,v 1.10 2003/08/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: loginbox.php 1262 2005-09-30 10:00:32Z mz $)

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   Loginbox V1.0        	Aubrey Kilian <aubrey@mycon.co.za>

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

$coo_login = MainFactory::create_object('LoginboxContentView');
$t_box_html = $coo_login->get_html();

$gm_box_pos = $coo_template_control->get_menubox_position('login');
$smarty->assign($gm_box_pos, $t_box_html);

?>