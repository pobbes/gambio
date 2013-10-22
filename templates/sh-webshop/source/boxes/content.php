<?php
/* --------------------------------------------------------------
   content.php 2010-09-23 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(information.php,v 1.6 2003/02/10); www.oscommerce.com
   (c) 2003	 nextcommerce (content.php,v 1.2 2003/08/21); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: content.php 1302 2005-10-12 16:21:29Z mz $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

$coo_content = MainFactory::create_object('ContentContentView');
$t_box_html = $coo_content->get_html('content');

$gm_box_pos = $coo_template_control->get_menubox_position('content');
$smarty->assign($gm_box_pos, $t_box_html);

?>