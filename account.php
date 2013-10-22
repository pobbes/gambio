<?php
/* --------------------------------------------------------------
   account.php 2011-09-15 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project (earlier name of osCommerce)
   (c) 2002-2003 osCommerce (account.php,v 1.59 2003/05/19); www.oscommerce.com
   (c) 2003      nextcommerce (account.php,v 1.12 2003/08/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: account.php 1124 2005-07-28 08:50:04Z mz $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');

if(!isset($_SESSION['customer_id']))
{
	xtc_redirect(xtc_href_link(FILENAME_LOGIN, '', 'SSL'));
}

$breadcrumb->add(NAVBAR_TITLE_ACCOUNT, xtc_href_link(FILENAME_ACCOUNT, '', 'SSL'));

// create smarty elements
$smarty = new Smarty;
// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');
require (DIR_WS_INCLUDES.'header.php');

$f_post_action = false;
$f_post_content = false;
if(isset($_POST['action']) && $_POST['action'] == 'gm_delete_account')
{
	$f_post_action = $_POST['action'];
	$f_post_content = $_POST['gm_content'];
}

$coo_account = MainFactory::create_object('AccountContentView');
$t_view_html = $coo_account->get_html($messageStack, $product, $f_post_action, $f_post_content);

$smarty->assign('main_content', $t_view_html);
$smarty->assign('language', $_SESSION['language']);
$smarty->caching = 0;
if (!defined(RM))
	$smarty->load_filter('output', 'note');
$smarty->display(CURRENT_TEMPLATE.'/index.html');
include ('includes/application_bottom.php');
?>