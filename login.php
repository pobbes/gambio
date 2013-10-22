<?php
/* --------------------------------------------------------------
   login.php 2010-10-06 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(login.php,v 1.79 2003/05/19); www.oscommerce.com 
   (c) 2003      nextcommerce (login.php,v 1.13 2003/08/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: login.php 1143 2005-08-11 11:58:59Z gwinger $)

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contribution:

   guest account idea by Ingo T. <xIngox@web.de>
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');



if (isset ($_SESSION['customer_id'])) {
	xtc_redirect(xtc_href_link(FILENAME_ACCOUNT, '', 'SSL'));
}

$breadcrumb->add(NAVBAR_TITLE_LOGIN, xtc_href_link(FILENAME_LOGIN, '', 'SSL'));

// create smarty elements
$smarty = new Smarty;
// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');


// redirect the customer to a friendly cookie-must-be-enabled page if cookies are disabled (or the session has not started)
if ($session_started == false) {
	xtc_redirect(xtc_href_link(FILENAME_COOKIE_USAGE));
}

$f_action = false;
$f_email_address = false;
$f_password = false;
if(isset($_GET['action']) && $_GET['action'] == 'process' && isset($_POST['email_address']) && isset($_POST['password']))
{
	$f_action = $_GET['action'];
	$f_email_address = $_POST['email_address'];
	$f_password = $_POST['password'];
}
$coo_econda = false;
if(is_object($econda))
{
	$coo_econda = $econda;
}
$f_info_message = false;
if(!empty($_GET['info_message']))
{
	$f_info_message = $_GET['info_message'];
}

$coo_account_login = MainFactory::create_object('LoginContentView');
$t_view_html = $coo_account_login->get_html($coo_econda, $f_action, $f_email_address, $f_password, $f_info_message);

require (DIR_WS_INCLUDES.'header.php');

$smarty->assign('main_content', $t_view_html);

$smarty->assign('language', $_SESSION['language']);
$smarty->caching = 0;
if (!defined(RM))
	$smarty->load_filter('output', 'note');
$smarty->display(CURRENT_TEMPLATE.'/index.html');
include ('includes/application_bottom.php');
?>