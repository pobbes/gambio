<?php
/*
	--------------------------------------------------------------
	header.php 2012-02-08 gm
	Gambio GmbH
	http://www.gambio.de
	Copyright (c) 2012 Gambio GmbH
    Released under the GNU General Public License (Version 2)
    [http://www.gnu.org/licenses/gpl-2.0.html]
	--------------------------------------------------------------

	based on:
	(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
	(c) 2002-2003 osCommerce(header.php,v 1.40 2003/03/14); www.oscommerce.com
	(c) 2003	 nextcommerce (header.php,v 1.13 2003/08/17); www.nextcommerce.org
	(c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: header.php 1140 2005-08-10 10:16:00Z mz $)

	Released under the GNU General Public License
	-----------------------------------------------------------------------------------------
	Third Party contribution:

	Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
	http://www.oscommerce.com/community/contributions,282
	Copyright (c) Strider | Strider@oscworks.com
	Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
	Copyright (c) Andre ambidex@gmx.net
	Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org

	Released under the GNU General Public License
	---------------------------------------------------------------------------------------*/
?>
<?php 
/******* SHOPGATE **********/
include_once DIR_FS_CATALOG.'/shopgate/gambiogx/includes/header.php';
/******* SHOPGATE **********/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
 "http://www.w3.org/TR/html4/strict.dtd">
<head>
<?php

if(gm_get_env_info('TEMPLATE_VERSION') < FIRST_GX2_TEMPLATE_VERSION)
{
	echo '<meta http-equiv="X-UA-Compatible" content="IE=7" />';
}
else
{
	echo '<meta http-equiv="X-UA-Compatible" content="IE=edge" />';
}
/*
  The following copyright announcement is in compliance
  to section 2c of the GNU General Public License, and
  thus can not be removed, or can only be modified
  appropriately.

  Please leave this comment intact together with the
  following copyright announcement.

*/
?>
<!--

=========================================================
Shopsoftware by Gambio GmbH (c) 2005-2011 [www.gambio.de]
=========================================================

Gambio GmbH offers you highly scalable E-Commerce-Solutions and Services.
The Shopsoftware is redistributable under the GNU General Public License (Version 2) [http://www.gnu.org/licenses/gpl-2.0.html].
based on: E-Commerce Engine Copyright (c) 2006 xt:Commerce, created by Mario Zanier & Guido Winger and licensed under GNU/GPL.
Information and contribution at http://www.xt-commerce.com

=========================================================
Please visit our website: www.gambio.de
=========================================================
   
-->
<?php 
$meta = MainFactory::create_object('GMMeta');
$meta->get($cPath, $product);
echo '<base href="' . GM_HTTP_SERVER . DIR_WS_CATALOG . '" />';

$gm_favicon = MainFactory::create_object('GMLogoManager', array("gm_logo_favicon"));
if($gm_favicon->logo_use == '1') {
	echo '<link rel="shortcut icon" href="' . $gm_favicon->logo_path . $gm_favicon->logo_file . '" type="image/x-icon" />' . "\n";
} 
?>

<?php
$t_css_params_array = array();
if($_SESSION['style_edit_mode'] == 'edit' || $_SESSION['style_edit_mode'] == 'sos') {
	echo '<link type="text/css" rel="stylesheet" href="StyleEdit/css/stylesheet.css" />';
	echo '<link type="text/css" rel="stylesheet" href="StyleEdit/css/stylesheet_new.css" />';	
	echo ' <!--[if IE]><link type="text/css" rel="stylesheet" href="StyleEdit/css/ie_stylesheet_new.css" /><![endif]-->';
	echo '<link type="text/css" rel="stylesheet" href="StyleEdit/javascript/jquery/plugins/fancybox/jquery.fancybox-1.3.0.css" />';
	$t_css_params_array[] = 'renew_cache=1&amp;style_edit=1&amp;current_template=' . CURRENT_TEMPLATE;
}
elseif($_SESSION['style_edit_mode'] == 'stop')
{
	$t_css_params_array[] = 'renew_cache=1&amp;stop_style_edit=1&amp;current_template=' . CURRENT_TEMPLATE;
}
else
{
	$t_css_params_array[] = 'current_template=' . CURRENT_TEMPLATE;
}
$t_css_params_array[] = 'http_caching=' . HTTP_CACHING;
$t_css_params_array[] = 'gzip=' . GZIP_COMPRESSION;
$t_css_params_array[] = 'gzip_level=' . GZIP_LEVEL;
$t_css_params_array[] = 'ob_gzhandler=' . PREFER_GZHANDLER;
?>
<?php
if($_SESSION['style_edit_mode'] == 'sos')
{
?>
<link type="text/css" rel="stylesheet" href="<?php echo 'templates/'.CURRENT_TEMPLATE.'/stylesheet.css'; ?>" />
<?php
}
else
{
?>
<link rel="stylesheet" href="<?php echo 'templates/'.CURRENT_TEMPLATE; ?>/css/style.css?<?php echo filemtime('templates/'.CURRENT_TEMPLATE.'/css/style.css') ?>" />
<?php
}
?>

<?php
$t_gm_script_name = '';
$t_gm_request_uri = $_SERVER['REQUEST_URI'];

if(isset($_SERVER['SCRIPT_NAME']) && strpos($_SERVER['SCRIPT_NAME'], '.php') !== false && strpos($_SERVER['SCRIPT_NAME'], DIR_WS_CATALOG) !== false)
{
	$t_gm_script_name = $_SERVER['SCRIPT_NAME'];
	if(empty($t_gm_request_uri))
	{
		$t_gm_request_uri = $_SERVER['SCRIPT_NAME'] . $_SERVER['PATH_INFO'] . '?' . $_SERVER['QUERY_STRING'];
	}
}
elseif(isset($_SERVER['PHP_SELF']) && strpos($_SERVER["PHP_SELF"], '.php') !== false && strpos($_SERVER['PHP_SELF'], DIR_WS_CATALOG) !== false)
{
	$t_gm_script_name = $_SERVER["PHP_SELF"];
	if(empty($t_gm_request_uri))
	{
		$t_gm_request_uri = $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'];
	}
}
elseif(isset($_SERVER['SCRIPT_FILENAME']) && strpos($_SERVER["SCRIPT_FILENAME"], '.php') !== false && strpos($_SERVER['SCRIPT_FILENAME'], DIR_WS_CATALOG) !== false)
{
	$t_gm_script_name = $_SERVER['SCRIPT_FILENAME'];
	if(empty($t_gm_request_uri))
	{
		$t_gm_request_uri = substr($_SERVER['SCRIPT_FILENAME'], strlen($_SERVER['SCRIPT_FILENAME'], $_SERVER['DOCUMENT_ROOT'])) . $_SERVER['PATH_INFO'] . '?' . $_SERVER['QUERY_STRING'];
	}
}
else
{
	$t_gm_script_name = $PHP_SELF;
	if(empty($t_gm_request_uri))
	{
		$t_gm_request_uri = $PHP_SELF;
	}
}

if(strpos(gm_get_env_info('SCRIPT_NAME'), '.php') !== false
	&& strpos(gm_get_env_info('SCRIPT_NAME'), '.js.php') === false
	&& strpos(gm_get_env_info('SCRIPT_NAME'), '.css.php') === false
	&& strpos($t_gm_request_uri, '.js.php') === false
	&& strpos($t_gm_request_uri, '.css.php') === false
	&& strpos($t_gm_request_uri, '.png') === false
	&& strpos($t_gm_request_uri, '.gif') === false
	&& strpos($t_gm_request_uri, '.jpg') === false
	&& strpos($t_gm_request_uri, '.jpeg') === false
	&& strpos($t_gm_request_uri, '.pjpeg') === false
	&& strpos($t_gm_request_uri, '.ico') === false
	&& (strpos(gm_get_env_info('SCRIPT_NAME'), 'index.php') !== false
	|| strpos(gm_get_env_info('SCRIPT_NAME'), 'advanced_search_result.php') !== false
	|| strpos(gm_get_env_info('SCRIPT_NAME'), 'products_new.php') !== false
	|| strpos(gm_get_env_info('SCRIPT_NAME'), 'specials.php') !== false))
{
	if(!is_array($_SESSION['gm_history']))
	{
		$_SESSION['gm_history'] = array();
	}
	$_SESSION['gm_history'][count($_SESSION['gm_history'])] = array('URL' => $t_gm_request_uri,
																		'FILENAME' => $_SERVER['SCRIPT_FILENAME'],
																		'CLOSE' => $t_gm_request_uri);
}

if(substr_count($t_gm_script_name, 'create_account.php') > 0 || substr_count($t_gm_script_name, 'create_guest_account.php') > 0) {
	echo '<meta http-equiv="pragma" content="no-cache" />';
}

// BOF GM_MOD GX-Customizer:
include_once(DIR_FS_CATALOG . 'gm/modules/gm_gprint_header_css.php');

$coo_header_extender_component = MainFactory::create_object('HeaderExtenderComponent');
$coo_header_extender_component->set_data('GET', $_GET);
$coo_header_extender_component->set_data('POST', $_POST);
$coo_header_extender_component->proceed();

// require theme based javascript
require('templates/'.CURRENT_TEMPLATE.'/javascript/general.js.php');


if(strstr($PHP_SELF, FILENAME_CHECKOUT_PAYMENT)) {
	echo $payment_modules->javascript_validation();
}
if(strstr($PHP_SELF, FILENAME_CREATE_ACCOUNT)) {
	require('includes/form_check.js.php');
}
if(strstr($PHP_SELF, FILENAME_CREATE_GUEST_ACCOUNT )) {
	require('includes/form_check.js.php');
}
if(strstr($PHP_SELF, FILENAME_ACCOUNT_PASSWORD )) {
	require('includes/form_check.js.php');
}
if(strstr($PHP_SELF, FILENAME_ACCOUNT_EDIT )) {
	require('includes/form_check.js.php');
}
if(strstr($PHP_SELF, FILENAME_ADDRESS_BOOK_PROCESS )) {
  if(isset($_GET['delete']) == false) {
    include('includes/form_check.js.php');
  }
}
if(strstr($PHP_SELF, FILENAME_CHECKOUT_SHIPPING_ADDRESS )or strstr($PHP_SELF,FILENAME_CHECKOUT_PAYMENT_ADDRESS))
{
	require('includes/form_check.js.php');
	?>
	<script type="text/javascript"><!--
	function check_form_optional(form_name) {
	  var form = form_name;
	
	  var firstname = form.elements['firstname'].value;
	  var lastname = form.elements['lastname'].value;
	  var street_address = form.elements['street_address'].value;
	
	  if (firstname == '' && lastname == '' && street_address == '') {
	    return true;
	  } else {
	    return check_form(form_name);
	  }
	}
	//--></script>
	<?php
}

if(strstr($PHP_SELF, FILENAME_ADVANCED_SEARCH ))
{
	?>
	<script type="text/javascript" src="includes/general.js"></script>
	<script type="text/javascript"><!--
	function check_form() {
	  var error_message = unescape("<?php echo xtc_js_lang(JS_ERROR); ?>");
	  var error_found = false;
	  var error_field;
	  var keywords = document.getElementById("advanced_search").keywords.value;
	  var pfrom = document.getElementById("advanced_search").pfrom.value;
	  var pto = document.getElementById("advanced_search").pto.value;
	  var pfrom_float;
	  var pto_float;
	
	  if ( (keywords == '' || keywords.length < 1) && (pfrom == '' || pfrom.length < 1) && (pto == '' || pto.length < 1) ) {
	    error_message = error_message + unescape("<?php echo xtc_js_lang(JS_AT_LEAST_ONE_INPUT); ?>");
	    error_field = document.getElementById("advanced_search").keywords;
	    error_found = true;
	  }
	
	  if (pfrom.length > 0) {
	    pfrom_float = parseFloat(pfrom);
	    if (isNaN(pfrom_float)) {
	      error_message = error_message + unescape("<?php echo xtc_js_lang(JS_PRICE_FROM_MUST_BE_NUM); ?>");
	      error_field = document.getElementById("advanced_search").pfrom;
	      error_found = true;
	    }
	  } else {
	    pfrom_float = 0;
	  }
	
	  if (pto.length > 0) {
	    pto_float = parseFloat(pto);
	    if (isNaN(pto_float)) {
	      error_message = error_message + unescape("<?php echo xtc_js_lang(JS_PRICE_TO_MUST_BE_NUM); ?>");
	      error_field = document.getElementById("advanced_search").pto;
	      error_found = true;
	    }
	  } else {
	    pto_float = 0;
	  }
	
	  if ( (pfrom.length > 0) && (pto.length > 0) ) {
	    if ( (!isNaN(pfrom_float)) && (!isNaN(pto_float)) && (pto_float < pfrom_float) ) {
	      error_message = error_message + unescape("<?php echo xtc_js_lang(JS_PRICE_TO_LESS_THAN_PRICE_FROM); ?>");
	      error_field = document.getElementById("advanced_search").pto;
	      error_found = true;
	    }
	  }
	
	  if (error_found == true) {
	    alert(error_message);
	    error_field.focus();
	    return false;
	  }
	}
	
	function popupWindow(url) {
	  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=450,height=280,screenX=150,screenY=150,top=150,left=150')
	}
	//--></script>
	<?php
}

if (strstr($PHP_SELF, FILENAME_PRODUCT_REVIEWS_WRITE ))
{
	?>
	<script type="text/javascript"><!--
	function checkForm() {
	  var error = 0;
	  var error_message = unescape("<?php echo xtc_js_lang(JS_ERROR); ?>");

	  var review = document.getElementById("product_reviews_write").review.value;

	  if (review.length < <?php echo REVIEW_TEXT_MIN_LENGTH; ?>) {
		error_message = error_message + unescape("<?php echo xtc_js_lang(JS_REVIEW_TEXT); ?>");
		error = 1;
	  }

	  if (!((document.getElementById("product_reviews_write").rating[0].checked) || (document.getElementById("product_reviews_write").rating[1].checked) || (document.getElementById("product_reviews_write").rating[2].checked) || (document.getElementById("product_reviews_write").rating[3].checked) || (document.getElementById("product_reviews_write").rating[4].checked))) {
		error_message = error_message + unescape("<?php echo xtc_js_lang(JS_REVIEW_RATING); ?>");
		error = 1;
	  }

	  if (error == 1) {
		alert(error_message);
		return false;
	  } else {
		return true;
	  }
	}
	//--></script>
	<?php
}
if (strstr($PHP_SELF, FILENAME_POPUP_IMAGE )) {
	?>
	<script type="text/javascript"><!--
	var i=0;
	function resize() {
	  if (navigator.appName == 'Netscape') i=40;
	  if (document.images[0]) window.resizeTo(document.images[0].width +30, document.images[0].height+60-i);
	  self.focus();
	}
	//--></script>
	<?php
}

?>
</head>
<?php
if (strstr($PHP_SELF, FILENAME_POPUP_IMAGE )) {
	echo '<body onload="resize();"> ';
} else {
	echo '<body>';
}

/******** SHOPGATE **********/
echo $shopgateMobileHeader;
/******** SHOPGATE **********/

// econda tracking
if (TRACKING_ECONDA_ACTIVE=='true') {
	?>
	<script type="text/javascript">
	<!--
	var emos_kdnr='<?php echo TRACKING_ECONDA_ID; ?>';
	//-->
	</script>
	<a name="emos_sid" rel="<?php echo session_id(); ?>" rev=""></a>
	<a name="emos_name" title="siteid" rel="<?php echo $_SESSION['languages_id']; ?>" rev=""></a>
	<?php
}

// include needed functions
require_once('inc/xtc_output_warning.inc.php');
require_once('inc/xtc_image.inc.php');
require_once('inc/xtc_parse_input_field_data.inc.php');
require_once('inc/xtc_draw_separator.inc.php');

// check if the 'install' directory exists, and warn of its existence
if (WARN_INSTALL_EXISTENCE == 'true') {
	if (file_exists(dirname($_SERVER['SCRIPT_FILENAME']) . '/gambio_installer')) {
	  xtc_output_warning(WARNING_INSTALL_DIRECTORY_EXISTS);
	}
}

// check if the configure.php file is writeable
if(WARN_CONFIG_WRITEABLE == 'true') {
	if((file_exists(dirname($_SERVER['SCRIPT_FILENAME']) . '/includes/configure.php')) && (is_writeable(dirname($_SERVER['SCRIPT_FILENAME']) . '/includes/configure.php')) ) {
		xtc_output_warning(WARNING_CONFIG_FILE_WRITEABLE);
	}
}

// check if the session folder is writeable
if (WARN_SESSION_DIRECTORY_NOT_WRITEABLE == 'true') {
	if (STORE_SESSIONS == '') {
		if (!is_dir(xtc_session_save_path())) {
			xtc_output_warning(WARNING_SESSION_DIRECTORY_NON_EXISTENT);
		} elseif (!is_writeable(xtc_session_save_path())) {
			xtc_output_warning(WARNING_SESSION_DIRECTORY_NOT_WRITEABLE);
		}
	}
}

// check session.auto_start is disabled
if((function_exists('ini_get')) && (WARN_SESSION_AUTO_START == 'true') ) {
	if (ini_get('session.auto_start') == '1') {
		xtc_output_warning(WARNING_SESSION_AUTO_START);
	}
}

if((WARN_DOWNLOAD_DIRECTORY_NOT_READABLE == 'true') && (DOWNLOAD_ENABLED == 'true') ) {
	if(!is_dir(DIR_FS_DOWNLOAD)) {
	  xtc_output_warning(WARNING_DOWNLOAD_DIRECTORY_NON_EXISTENT);
	}
}

if(isset($_SESSION['customer_id'])) {
	$smarty->assign('logoff',xtc_href_link(FILENAME_LOGOFF, '', 'SSL'));
}
if($_SESSION['account_type']=='0') {
	$smarty->assign('account',xtc_href_link(FILENAME_ACCOUNT, '', 'SSL'));
}
$smarty->assign('navtrail',$breadcrumb->trail(' &raquo; '));
$smarty->assign('cart',xtc_href_link(FILENAME_SHOPPING_CART, '', 'SSL'));
$smarty->assign('checkout',xtc_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
$smarty->assign('store_name',TITLE);

if(isset($_SESSION['gm_error_message']) && xtc_not_null($_SESSION['gm_error_message'])) {
  	$smarty->assign('error','
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr class="headerError">
        <td class="headerError">'. htmlspecialchars_wrapper(urldecode($_SESSION['gm_error_message'])).'</td>
      </tr>
    </table>');
	unset($_SESSION['gm_error_message']);
}

if (isset($_SESSION['gm_info_message']) && xtc_not_null($_SESSION['gm_info_message'])) {
  	$smarty->assign('error','
	    <table border="0" width="100%" cellspacing="0" cellpadding="2">
	      <tr class="headerInfo">
	        <td class="headerInfo">'.htmlspecialchars_wrapper(urldecode($_SESSION['gm_info_message'])).'</td>
	      </tr>
	    </table>'
  	);
	unset($_SESSION['gm_info_message']);
}
include(DIR_WS_INCLUDES.FILENAME_BANNER);
?>