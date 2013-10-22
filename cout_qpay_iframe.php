<?php
include_once('includes/application_top.php');
if(is_dir(DIR_FS_CATALOG.'StyleEdit'))
{
    global $gmBoxesMaster;
}

$smarty = new Smarty;
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');
require (DIR_WS_INCLUDES.'header.php');
$smarty->assign('language', $_SESSION['language']);

$smarty->assign('FORM_ACTION', $_SESSION['qpay']['process_form'].$_SESSION['qpay']['process_js']);
$smarty->assign('BUTTON_CONTINUE', xtc_image_submit('contgr.gif', IMAGE_BUTTON_CONTINUE));
$smarty->assign('FORM_END', '</form>'.$_SESSION['qpay']['process_js']);
$smarty->assign('CHECKOUT_TITLE', $_SESSION['qpay']['translation']['title']);
$smarty->assign('CHECKOUT_HEADER', $_SESSION['qpay']['translation']['header']);
$smarty->assign('CHECKOUT_CONTENT', $_SESSION['qpay']['translation']['content']);
$smarty->assign('language', $_SESSION['language']);
$smarty->caching = 0;
$smarty->display(CURRENT_TEMPLATE.'/module/checkout_qpay_iframe.html');
include ('includes/application_bottom.php');
