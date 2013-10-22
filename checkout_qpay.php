<?php

include_once('includes/application_top.php');
global $breadcrumb, $xtPrice, $order, $product, $main, $request_type, $coo_template_control;
if(is_dir(DIR_FS_CATALOG.'StyleEdit'))
{
    global $gmBoxesMaster;
}

$smarty = new Smarty;
$breadcrumb->add(NAVBAR_TITLE_1_CHECKOUT_SUCCESS);
$breadcrumb->add(NAVBAR_TITLE_2_CHECKOUT_SUCCESS);
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');
require (DIR_WS_INCLUDES.'header.php');
$smarty->assign('language', $_SESSION['language']);

if(isset($_GET['cancel']))
{
    require ('lang/'.strtolower($_SESSION['language']).'/modules/payment/qpay.php');
    $smarty->assign('CHECKOUT_TITLE', CHECKOUT_CANCEL_TITLE);
    $smarty->assign('CHECKOUT_HEADER', CHECKOUT_CANCEL_HEADER);
    $smarty->assign('CHECKOUT_CONTENT', CHECKOUT_CANCEL_CONTENT);
    $smarty->assign('SHOW_STEPS', false);
}
elseif(isset($_GET['failure']))
{
    require ('lang/'.strtolower($_SESSION['language']).'/modules/payment/qpay.php');
    $smarty->assign('CHECKOUT_TITLE', CHECKOUT_FAILURE_TITLE);
    $smarty->assign('CHECKOUT_HEADER', CHECKOUT_FAILURE_HEADER);
    $smarty->assign('CHECKOUT_CONTENT', CHECKOUT_FAILURE_CONTENT);
    $smarty->assign('SHOW_STEPS', false);
}
elseif($_SESSION['qpay']['useIFrame'] == 'True')
{
    $iFrame = '<iframe src="cout_qpay_iframe.php?'.SID.'" width="100%" height="430" border="0" frameborder="0"></iframe>';
    $smarty->assign('FORM_ACTION', $iFrame);
    $smarty->assign('CHECKOUT_TITLE', $_SESSION['qpay']['translation']['title']);
    $smarty->assign('CHECKOUT_HEADER', '');
    $smarty->assign('CHECKOUT_CONTENT', '');
    $smarty->assign('IFRAME', true);
    $smarty->assign('SHOW_STEPS', true);
}
else
{
    $smarty->assign('FORM_ACTION', $_SESSION['qpay']['process_form'].$_SESSION['qpay']['process_js']);
    $smarty->assign('BUTTON_CONTINUE', xtc_image_submit('contgr.gif', IMAGE_BUTTON_CONTINUE));
    $smarty->assign('FORM_END', '</form>'.$_SESSION['qpay']['process_js']);
    $smarty->assign('CHECKOUT_TITLE', $_SESSION['qpay']['translation']['title']);
    $smarty->assign('CHECKOUT_HEADER', $_SESSION['qpay']['translation']['header']);
    $smarty->assign('CHECKOUT_CONTENT', $_SESSION['qpay']['translation']['content']);
    $smarty->assign('SHOW_STEPS', true);
    $smarty->assign('IFRAME', false);
    $smarty->assign('GM_CART_ON_TOP', false);
}

$smarty->assign('LIGHTBOX', gm_get_conf('GM_LIGHTBOX_CHECKOUT'));
$smarty->caching = 0;
$main_content = $smarty->fetch(CURRENT_TEMPLATE.'/module/checkout_qpay.html');
$smarty->assign('main_content', $main_content.$process_js);
$smarty->display(CURRENT_TEMPLATE.'/index.html');
include ('includes/application_bottom.php');
