<?php
/* --------------------------------------------------------------
   search.php 2010-09-23 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(search.php,v 1.22 2003/02/10); www.oscommerce.com 
   (c) 2003	 nextcommerce (search.php,v 1.9 2003/08/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: search.php 1262 2005-09-30 10:00:32Z mz $)

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

$coo_search = MainFactory::create_object('SearchContentView');
$t_box_html = $coo_search->get_html();

$gm_box_pos = $coo_template_control->get_menubox_position('search');
$smarty->assign($gm_box_pos, $t_box_html);

?>