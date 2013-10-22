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

// reset var
$box_smarty = new smarty;
$box_content='';
$box_smarty->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/');

$box_smarty->assign('BOX_HEADING', 'test');
$box_smarty->assign('BOX_CONTENT', 'test');
$box_smarty->assign('language', $_SESSION['language']);
// set cache ID
if (USE_CACHE=='false') {
	$box_smarty->caching = 0;
	$box_paypal= $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_paypal.html');
} else {
	$box_smarty->caching = 1;
	$box_smarty->cache_lifetime=CACHE_LIFETIME;
	$box_smarty->cache_modified_check=CACHE_CHECK;
	$cache_id = $_SESSION['language'];
	$box_paypal= $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_paypal.html',$cache_id);
}

$gm_box_pos = $coo_template_control->get_menubox_position('paypal');

$t_get_paypal_status = xtc_db_query("SELECT configuration_value 
										FROM " . TABLE_CONFIGURATION . "
										WHERE
											(configuration_key = 'MODULE_PAYMENT_PAYPALEXPRESS_STATUS'
											OR
											configuration_key = 'MODULE_PAYMENT_PAYPAL_STATUS')
											AND configuration_value = 'true'");
if(xtc_db_num_rows($t_get_paypal_status) > 0)
{
	$smarty->assign($gm_box_pos, $box_paypal);
}
elseif($_SESSION['style_edit_mode'] == 'edit') {
	$smarty->assign($gm_box_pos, $box_paypal);
}
?>