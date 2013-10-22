<?php
/* --------------------------------------------------------------
   cart_dropdown.php 2011-03-09 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
 */



# ShoppingCartDropdown
$coo_content_view = MainFactory::create_object('ShoppingCartDropdown');

#build dropdown with default template
$t_html = $coo_content_view->get_html();
$smarty->assign('SHOPPING_CART_DROPDOWN', $t_html);

#build head with another template
$coo_content_view->set_content_template('boxes/box_cart_head.html');
$t_html = $coo_content_view->get_html();
$smarty->assign('SHOPPING_CART_HEAD', $t_html);

?>