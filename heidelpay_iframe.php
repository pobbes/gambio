<?php
/*
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
*/
require ('includes/application_top.php');

// workaround for gambio gx2 session rewrite problem
if ($_GET['HpReturn'] == "1") {
	header('Location: '.$_SESSION['HEIDELPAY_FRAMEURL']) ;
	exit();
}
else {

#echo '<pre>'.print_r($_SESSION, 1).'</pre>';

// create smarty elements
$smarty = new Smarty;
// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');

$breadcrumb->add(NAVBAR_TITLE_1_CHECKOUT_PAYMENT, xtc_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_2_CHECKOUT_PAYMENT, xtc_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));

require (DIR_WS_INCLUDES.'header.php');

if (empty($_SESSION['language'])) $_SESSION['language'] = 'german';
$smarty->caching = 0;
//$main_content = $smarty->fetch(CURRENT_TEMPLATE.'/module/checkout_success.html');
$smarty->assign('language', $_SESSION['language']);
$smarty->assign('main_content', $_SESSION['HEIDELPAY_IFRAME']);
$smarty->caching = 0;
if (!defined(RM))
	$smarty->load_filter('output', 'note');
$smarty->display(CURRENT_TEMPLATE.'/index.html');
include ('includes/application_bottom.php');
};
?>
