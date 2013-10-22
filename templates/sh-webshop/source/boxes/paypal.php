<?php
/* --------------------------------------------------------------
 paypal.php 2009-12-04 gm
 Gambio GmbH
 http://www.gambio.de
 Copyright (c) 2009 Gambio GmbH
 Released under the GNU General Public License
 --------------------------------------------------------------
 

 based on:
 (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
 (c) 2002-2003 osCommerce(add_a_quickie.php,v 1.10 2001/12/19); www.oscommerce.com
 (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: add_a_quickie.php,v 1.1 2004/04/26 20:26:42 fanta2k Exp $)

 Released under the GNU General Public License
 -----------------------------------------------------------------------------------------
 Third Party contribution:
 Add A Quickie v1.0 Autor  Harald Ponce de Leon

 Released under the GNU General Public License
 ---------------------------------------------------------------------------------------*/

$coo_paypal = MainFactory::create_object('PayPalContentView');
$t_box_html = $coo_paypal->get_html();

$gm_box_pos = $coo_template_control->get_menubox_position('paypal');
$smarty->assign($gm_box_pos, $t_box_html);

?>