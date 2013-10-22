<?php
/* --------------------------------------------------------------
   gm_account_delete.php 2008-08-07 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(account_password.php,v 1.1 2003/05/19); www.oscommerce.com
   (c) 2003	 nextcommerce (account_password.php,v 1.14 2003/08/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: account_password.php 1218 2005-09-16 11:38:37Z mz $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');
// create smarty elements
$smarty = new Smarty;
$breadcrumb->add(NAVBAR_TITLE_1_ACCOUNT_PASSWORD, xtc_href_link(FILENAME_ACCOUNT, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_GM_ACCOUNT_DELETE, xtc_href_link('gm_account_delete.php', '', 'SSL'));

// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');
// include needed functions

if (!isset ($_SESSION['customer_id']))
	xtc_redirect(xtc_href_link(FILENAME_LOGIN, '', 'SSL'));


require (DIR_WS_INCLUDES.'header.php');

$smarty->assign('FORM_ACTION', xtc_draw_form('gm_account_delete', xtc_href_link(FILENAME_ACCOUNT, '', 'SSL'), 'post').xtc_draw_hidden_field('action', 'gm_delete_account'));
$smarty->assign('FORM_ID', 'gm_account_delete');
$smarty->assign('FORM_ACTION_URL', xtc_href_link(FILENAME_ACCOUNT, '', 'SSL'));
$smarty->assign('FORM_METHOD', 'post');
$smarty->assign('HIDDEN_NAME', 'action');
$smarty->assign('HIDDEN_VALUE', 'gm_delete_account');
$smarty->assign('HIDDEN_ACTION_FIELD', xtc_draw_hidden_field('action', 'gm_delete_account'));
$smarty->assign('GM_COMMENTS_NAME', 'gm_content');
$smarty->assign('GM_COMMENTS', xtc_draw_textarea_field('gm_content', 'soft', 40, 6));
$smarty->assign('BUTTON_BACK', '<a href="'.xtc_href_link(FILENAME_ACCOUNT, '', 'SSL').'">'.xtc_image_button('button_back.gif', IMAGE_BUTTON_BACK).'</a>');
$smarty->assign('BUTTON_BACK_LINK', xtc_href_link(FILENAME_ACCOUNT, '', 'SSL'));
$smarty->assign('BUTTON_SUBMIT', xtc_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE));
$smarty->assign('FORM_END', '</form>');

$smarty->assign('language', $_SESSION['language']);

$smarty->caching = 0;
$main_content = $smarty->fetch(CURRENT_TEMPLATE.'/module/gm_account_delete.html');

$smarty->assign('language', $_SESSION['language']);
$smarty->assign('main_content', $main_content);
$smarty->caching = 0;
if (!defined(RM))
	$smarty->load_filter('output', 'note');
$smarty->display(CURRENT_TEMPLATE.'/index.html');
include ('includes/application_bottom.php');
?>