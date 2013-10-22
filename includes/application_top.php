<?php
/* --------------------------------------------------------------
   application_top.php 2012-12-12 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(application_top.php,v 1.273 2003/05/19); www.oscommerce.com
   (c) 2003	 nextcommerce (application_top.php,v 1.54 2003/08/25); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: application_top.php 1323 2005-10-27 17:58:08Z mz $)

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contribution:
   Add A Quickie v1.0 Autor  Harald Ponce de Leon

   Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
   http://www.oscommerce.com/community/contributions,282
   Copyright (c) Strider | Strider@oscworks.com
   Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
   Copyright (c) Andre ambidex@gmx.net
   Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

if(file_exists(str_replace('\\', '/', dirname(dirname(__FILE__))) . '/GProtector'))
{
	require_once(str_replace('\\', '/', dirname(dirname(__FILE__))) . '/GProtector/start.inc.php');
}

@ini_set('session.use_only_cookies', 0);

if(empty($_SERVER['PATH_INFO'])) {
	$_SERVER['PATH_INFO'] = str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['REQUEST_URI']);
	$_SERVER['PATH_INFO'] = strtok($_SERVER['PATH_INFO'], '?');
}

$t_timezone = @date_default_timezone_get();
if(is_string($t_timezone) && !empty($t_timezone))
{
	@date_default_timezone_set($t_timezone);
}
unset($t_timezone);

# info for shared functions
if(defined('APPLICATION_RUN_MODE') == false) define('APPLICATION_RUN_MODE', 'frontend');

$php4_3_10 = (0 == version_compare(phpversion(), "4.3.10"));
define('PHP4_3_10', $php4_3_10);
define('PROJECT_VERSION', 'xt:Commerce v3.0.4 SP2.1');
define('FIRST_GX2_TEMPLATE_VERSION', 2.0);
define('PAGE_PARSE_START_TIME', microtime());
define('_GM_VALID_CALL', 1);

# Set the local configuration parameters - mainly for developers - if exists else the mainconfigure
if (file_exists('includes/local/configure.php')) {
	include ('includes/local/configure.php');
} else {
	include ('includes/configure.php');
}

require_once(DIR_FS_INC.'htmlentities_wrapper.inc.php');
require_once(DIR_FS_INC.'htmlspecialchars_wrapper.inc.php');

require_once(DIR_FS_CATALOG.'gm/classes/FileLog.php');
require_once(DIR_FS_CATALOG.'gm/classes/ErrorHandler.php');
require_once(DIR_FS_CATALOG.'gm/inc/check_data_type.inc.php');
require_once(DIR_FS_CATALOG.'gm/inc/gm_get_env_info.inc.php');
require_once(DIR_FS_CATALOG.'system/gngp_layer_init.inc.php');

# custom error handler with DEFAULT SETTINGS
set_error_handler(array(new ErrorHandler(), 'HandleError'));

# custom class autoloader
spl_autoload_register(array(new MainAutoloader('frontend'), 'load'));

# total time output in application_bottom.php
$coo_stop_watch_array = array();

# global debugger object
$coo_debugger = new Debugger();

# set the type of request (secure or not)
$request_type = (getenv('HTTPS') == '1' || getenv('HTTPS') == 'on') ? 'SSL' : 'NONSSL';

if($request_type == 'SSL' || !empty($_SERVER['HTTP_X_FORWARDED_HOST'])) {
	define('GM_HTTP_SERVER', HTTPS_SERVER);
} else {
	define('GM_HTTP_SERVER', HTTP_SERVER);
}

# set php_self in the local scope
$PHP_SELF = gm_get_env_info('PHP_SELF');

// include the list of project filenames
require (DIR_WS_INCLUDES.'filenames.php');

// include the list of project database tables
require (DIR_WS_INCLUDES.'database_tables.php');

// SQL caching dir
define('SQL_CACHEDIR', DIR_FS_CATALOG.'cache/');

// graduated prices model or products assigned ?
define('GRADUATED_ASSIGN', 'true');

// Database
require_once (DIR_FS_INC.'xtc_db_connect.inc.php');
require_once (DIR_FS_INC.'xtc_db_close.inc.php');
require_once (DIR_FS_INC.'xtc_db_error.inc.php');
require_once (DIR_FS_INC.'xtc_db_perform.inc.php');
require_once (DIR_FS_INC.'xtc_db_query.inc.php');
require_once (DIR_FS_INC.'xtc_db_queryCached.inc.php');
require_once (DIR_FS_INC.'xtc_db_fetch_array.inc.php');
require_once (DIR_FS_INC.'xtc_db_num_rows.inc.php');
require_once (DIR_FS_INC.'xtc_db_data_seek.inc.php');
require_once (DIR_FS_INC.'xtc_db_insert_id.inc.php');
require_once (DIR_FS_INC.'xtc_db_free_result.inc.php');
require_once (DIR_FS_INC.'xtc_db_fetch_fields.inc.php');
require_once (DIR_FS_INC.'xtc_db_output.inc.php');
require_once (DIR_FS_INC.'xtc_db_input.inc.php');
require_once (DIR_FS_INC.'xtc_db_prepare_input.inc.php');
require_once (DIR_FS_INC.'xtc_get_top_level_domain.inc.php');
require_once (DIR_FS_INC.'xtc_hide_session_id.inc.php');

// include needed functions
require_once(DIR_FS_INC . 'get_usermod.inc.php');
require_once(DIR_FS_INC . 'xtc_create_random_value.inc.php');
require_once(DIR_FS_INC . 'xtc_get_prid.inc.php');
require_once(DIR_FS_INC . 'xtc_draw_form.inc.php');
require_once(DIR_FS_INC . 'xtc_draw_input_field.inc.php');
require_once(DIR_FS_INC . 'xtc_image_submit.inc.php');
require_once(DIR_FS_INC . 'xtc_get_prid.inc.php');

// html basics
require_once (DIR_FS_INC.'xtc_href_link.inc.php');
require_once (DIR_FS_INC.'xtc_draw_separator.inc.php');
require_once (DIR_FS_INC.'xtc_php_mail.inc.php');

require_once (DIR_FS_INC.'xtc_product_link.inc.php');
require_once (DIR_FS_INC.'xtc_category_link.inc.php');
require_once (DIR_FS_INC.'xtc_manufacturer_link.inc.php');

// html functions
require_once (DIR_FS_INC.'xtc_draw_checkbox_field.inc.php');
require_once (DIR_FS_INC.'xtc_draw_form.inc.php');
require_once (DIR_FS_INC.'xtc_draw_hidden_field.inc.php');
require_once (DIR_FS_INC.'xtc_draw_input_field.inc.php');
require_once (DIR_FS_INC.'xtc_draw_password_field.inc.php');
require_once (DIR_FS_INC.'xtc_draw_pull_down_menu.inc.php');
require_once (DIR_FS_INC.'xtc_draw_radio_field.inc.php');
require_once (DIR_FS_INC.'xtc_draw_selection_field.inc.php');
require_once (DIR_FS_INC.'xtc_draw_separator.inc.php');
require_once (DIR_FS_INC.'xtc_draw_textarea_field.inc.php');
require_once (DIR_FS_INC.'xtc_image_button.inc.php');

require_once (DIR_FS_INC.'xtc_not_null.inc.php');
require_once (DIR_FS_INC.'xtc_update_whos_online.inc.php');
require_once (DIR_FS_INC.'xtc_activate_banners.inc.php');
require_once (DIR_FS_INC.'xtc_expire_banners.inc.php');
require_once (DIR_FS_INC.'xtc_expire_specials.inc.php');
require_once (DIR_FS_INC.'xtc_parse_category_path.inc.php');
require_once (DIR_FS_INC.'xtc_get_product_path.inc.php');
require_once (DIR_FS_INC.'xtc_get_category_path.inc.php');
require_once (DIR_FS_INC.'xtc_get_parent_categories.inc.php');
require_once (DIR_FS_INC.'xtc_redirect.inc.php');
require_once (DIR_FS_INC.'xtc_get_uprid.inc.php');
require_once (DIR_FS_INC.'xtc_get_all_get_params.inc.php');
require_once (DIR_FS_INC.'xtc_has_product_attributes.inc.php');
require_once (DIR_FS_INC.'xtc_image.inc.php');
require_once (DIR_FS_INC.'xtc_check_stock_attributes.inc.php');
require_once (DIR_FS_INC.'xtc_currency_exists.inc.php');
require_once (DIR_FS_INC.'xtc_remove_non_numeric.inc.php');
require_once (DIR_FS_INC.'xtc_get_ip_address.inc.php');
require_once (DIR_FS_INC.'xtc_setcookie.inc.php');
require_once (DIR_FS_INC.'xtc_check_agent.inc.php');
require_once (DIR_FS_INC.'xtc_count_cart.inc.php');
require_once (DIR_FS_INC.'xtc_get_qty.inc.php');
require_once (DIR_FS_INC.'create_coupon_code.inc.php');
require_once (DIR_FS_INC.'xtc_gv_account_update.inc.php');
require_once (DIR_FS_INC.'xtc_get_tax_rate_from_desc.inc.php');
require_once (DIR_FS_INC.'xtc_get_tax_rate.inc.php');
require_once (DIR_FS_INC.'xtc_add_tax.inc.php');
require_once (DIR_FS_INC.'xtc_cleanName.inc.php');
require_once (DIR_FS_INC.'xtc_calculate_tax.inc.php');
require_once (DIR_FS_INC.'xtc_input_validation.inc.php');
require_once (DIR_FS_INC.'xtc_js_lang.php');
require_once (DIR_FS_INC.'xtc_get_products_name.inc.php');

require_once (DIR_FS_CATALOG . 'gm/modules/gm_gprint_application_top.php');
require_once (DIR_FS_CATALOG . 'gm/classes/GMCounter.php');
require_once (DIR_FS_CATALOG . 'gm/classes/GMLightboxControl.php');
require_once (DIR_FS_CATALOG . 'admin/gm/classes/GMOpenSearch.php');
require_once (DIR_FS_CATALOG . 'gm/inc/gm_clear_string.inc.php');
require_once (DIR_FS_CATALOG . 'gm/inc/gm_prepare_string.inc.php');
require_once (DIR_FS_CATALOG . 'gm/inc/gm_set_conf.inc.php');
require_once (DIR_FS_CATALOG . 'gm/inc/gm_get_conf.inc.php');
require_once (DIR_FS_CATALOG . 'gm/inc/gm_set_content.inc.php');
require_once (DIR_FS_CATALOG . 'gm/inc/gm_get_content.inc.php');
require_once (DIR_FS_CATALOG . 'gm/inc/gm_get_content_by_group_id.inc.php');
require_once (DIR_FS_CATALOG . 'gm/inc/gm_get_categories_icon.inc.php');
require_once (DIR_FS_CATALOG . 'gm/inc/gm_mega_flyover_prepare.inc.php');
require_once (DIR_FS_CATALOG . 'gm/inc/gm_is_valid_trusted_shop_id.inc.php');
require_once (DIR_FS_CATALOG . 'gm/inc/gm_convert_qty.inc.php');
require_once (DIR_FS_CATALOG . 'gm/inc/gm_create_corner.inc.php');
require_once (DIR_FS_CATALOG . 'gm/inc/gm_get_privacy_link.inc.php');

# make a connection to the database... now
xtc_db_connect() or die('Unable to connect to database server!');

$configuration_query = xtc_db_query('select configuration_key as cfgKey, configuration_value as cfgValue from '.TABLE_CONFIGURATION);
while ($configuration = xtc_db_fetch_array($configuration_query)) {
	define($configuration['cfgKey'], $configuration['cfgValue']);
}

# custom error handler with USER DEFINED settings
set_error_handler(array(new ErrorHandler(), 'HandleError'));

clearstatcache();
# include external StyleEdit, if available
if(is_dir(DIR_FS_CATALOG.'StyleEdit/'))
{
	require_once(DIR_FS_CATALOG.'StyleEdit/classes/GMSESecurity.php');
	require_once(DIR_FS_CATALOG.'StyleEdit/classes/GMCSSManager.php');
	require_once(DIR_FS_CATALOG.'StyleEdit/classes/GMBoxesMaster.php');
	$gmBoxesMaster = new GMBoxesMaster(CURRENT_TEMPLATE);
}

# build template control instance
$coo_template_control =& MainFactory::create_object('TemplateControl', array(CURRENT_TEMPLATE), true);

$gmLangFileMaster = MainFactory::create_object('GMLangFileMaster');
$gmSEOBoost = MainFactory::create_object('GMSEOBoost');

require_once (DIR_WS_CLASSES.'class.phpmailer.php');
if (EMAIL_TRANSPORT == 'smtp')
	require_once (DIR_WS_CLASSES.'class.smtp.php');
require_once (DIR_FS_INC.'xtc_Security.inc.php');

function xtDBquery($query) {
	if (DB_CACHE == 'true') {
		$result = xtc_db_queryCached($query);
	} else {
		$result = xtc_db_query($query);
	}
	return $result;
}

function CacheCheck() {
	if (USE_CACHE == 'false') return false;
	if (!isset($_COOKIE['XTCsid'])) return false;
	return true;
}

// if gzip_compression is enabled, start to buffer the output
$coo_http_caching = MainFactory::create_object('HTTPCaching');
$coo_http_caching->start_gzip();

# handle SEF URLs for GET array BOF
$coo_url_handler = MainFactory::create_object('ShopURLHandler');
$t_sef_url_values_array = $coo_url_handler->get_sef_url_values();

while(list($key, $value) = each($t_sef_url_values_array)) {
	$_GET[$key] = $value;
}
# SEF EOF

# check GET/POST/COOKIE VARS
require (DIR_WS_CLASSES.'class.inputfilter.php');
$InputFilter = new InputFilter();
$_GET = $InputFilter->process($_GET, true);
$_POST = $InputFilter->process($_POST);

# set the top level domains
$http_domain = xtc_get_top_level_domain(HTTP_SERVER);
$https_domain = xtc_get_top_level_domain(HTTPS_SERVER);
$current_domain = (($request_type == 'NONSSL') ? $http_domain : $https_domain);

// include shopping cart class
//require (DIR_WS_CLASSES.'shopping_cart.php');
//require (DIR_WS_CLASSES.'wish_list.php');

// include navigation history class
require (DIR_WS_CLASSES.'navigation_history.php');

// some code to solve compatibility issues
require (DIR_WS_FUNCTIONS.'compatibility.php');

// define how the session functions will be used
require (DIR_WS_FUNCTIONS.'sessions.php');

// set the session name and save path
session_name('XTCsid');
if (STORE_SESSIONS != 'mysql') session_save_path(SESSION_WRITE_DIRECTORY);

// set the session cookie parameters
if (function_exists('session_set_cookie_params')) {
	session_set_cookie_params(0, '/', (xtc_not_null($current_domain) ? '.'.$current_domain : ''));
}
elseif (function_exists('ini_set')) {
	ini_set('session.cookie_lifetime', '0');
	ini_set('session.cookie_path', '/');
	ini_set('session.cookie_domain', (xtc_not_null($current_domain) ? '.'.$current_domain : ''));
}

// set the session ID if it exists
if (isset ($_POST[session_name()]) && !empty($_POST[session_name()]) && preg_replace('/[^a-zA-Z0-9,-]/', "", $_POST[session_name()]) === $_POST[session_name()]) {
	session_id($_POST[session_name()]);
}
elseif (($request_type == 'SSL') && isset ($_GET[session_name()]) && !empty($_GET[session_name()]) && preg_replace('/[^a-zA-Z0-9,-]/', "", $_GET[session_name()]) === $_GET[session_name()]) {
	session_id($_GET[session_name()]);
}

if(isset($_POST[session_name()]) && (empty($_POST[session_name()]) || preg_replace('/[^a-zA-Z0-9,-]/', "", $_POST[session_name()]) !== $_POST[session_name()]))
{
	unset($_POST[session_name()]);
}

if(isset($_GET[session_name()]) && (empty($_GET[session_name()]) || preg_replace('/[^a-zA-Z0-9,-]/', "", $_GET[session_name()]) !== $_GET[session_name()]))
{
	unset($_GET[session_name()]);
}

// start the session
$session_started = false;
if (SESSION_FORCE_COOKIE_USE == 'True') {
	xtc_setcookie('cookie_test', 'please_accept_for_session', time() + 60 * 60 * 24 * 30, '/', $current_domain);

	if (isset ($_COOKIE['cookie_test'])) {
		session_start();
		include (DIR_WS_INCLUDES.'tracking.php');
		$session_started = true;
	}
} else {
	session_start();
	include (DIR_WS_INCLUDES.'tracking.php');
	$session_started = true;
}

// check the Agent
$truncate_session_id = false;
if (CHECK_CLIENT_AGENT) {
	if (xtc_check_agent() == 1) {
		$truncate_session_id = true;
	}
}

// verify the ssl_session_id if the feature is enabled
if (($request_type == 'SSL') && (SESSION_CHECK_SSL_SESSION_ID == 'True') && (ENABLE_SSL == true) && ($session_started == true)) {
	$ssl_session_id = getenv('SSL_SESSION_ID');
	if (!isset($_SESSION['SESSION_SSL_ID'])) {
		$_SESSION['SESSION_SSL_ID'] = $ssl_session_id;
	}

	if ($_SESSION['SESSION_SSL_ID'] != $ssl_session_id) {
		session_destroy();
		xtc_redirect(xtc_href_link(FILENAME_SSL_CHECK));
	}
}

// verify the browser user agent if the feature is enabled
if (SESSION_CHECK_USER_AGENT == 'True') {
	$http_user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
	$http_user_agent2 = strtolower(getenv("HTTP_USER_AGENT"));
	$http_user_agent = ($http_user_agent == $http_user_agent2) ? $http_user_agent : $http_user_agent.';'.$http_user_agent2;
	if (!isset ($_SESSION['SESSION_USER_AGENT'])) {
		$_SESSION['SESSION_USER_AGENT'] = $http_user_agent;
	}

	if ($_SESSION['SESSION_USER_AGENT'] != $http_user_agent) {
		session_destroy();
		xtc_redirect(xtc_href_link(FILENAME_LOGIN));
	}
}

// verify the IP address if the feature is enabled
if (SESSION_CHECK_IP_ADDRESS == 'True') {
	$ip_address = xtc_get_ip_address();
	if (!isset ($_SESSION['SESSION_IP_ADDRESS'])) {
		$_SESSION['SESSION_IP_ADDRESS'] = $ip_address;
	}

	if ($_SESSION['SESSION_IP_ADDRESS'] != $ip_address) {
		session_destroy();
		xtc_redirect(xtc_href_link(FILENAME_LOGIN));
	}
}

// set the language
if (!isset ($_SESSION['language']) || isset ($_GET['language'])) {
	include (DIR_WS_CLASSES.'language.php');
	$lng = new language(xtc_input_validation($_GET['language'], 'char', ''));

	if(!isset($_GET['language']) && gm_get_conf('GM_CHECK_BROWSER_LANGUAGE') === '1')
	{
		$lng->get_browser_language();
	}

	$_SESSION['language'] = $lng->language['directory'];
	$_SESSION['languages_id'] = $lng->language['id'];
	$_SESSION['language_charset'] = $lng->language['language_charset'];
	$_SESSION['language_code'] = $lng->language['code'];
}

if (isset($_SESSION['language']) && !isset($_SESSION['language_charset'])) {
	include (DIR_WS_CLASSES.'language.php');
	$lng = new language(xtc_input_validation($_SESSION['language'], 'char', ''));
	$_SESSION['language'] = $lng->language['directory'];
	$_SESSION['languages_id'] = $lng->language['id'];
	$_SESSION['language_charset'] = $lng->language['language_charset'];
	$_SESSION['language_code'] = $lng->language['code'];

}

// include the language translations
require (DIR_WS_LANGUAGES.$_SESSION['language'].'/'.$_SESSION['language'].'.php');

// currency
if (!isset ($_SESSION['currency']) || isset ($_GET['currency']) || ((USE_DEFAULT_LANGUAGE_CURRENCY == 'true') && (LANGUAGE_CURRENCY != $_SESSION['currency']))) {
	if (isset ($_GET['currency'])) {
		if (!$_SESSION['currency'] = xtc_currency_exists($_GET['currency']))
			$_SESSION['currency'] = (USE_DEFAULT_LANGUAGE_CURRENCY == 'true') ? LANGUAGE_CURRENCY : DEFAULT_CURRENCY;
	} else {
		$_SESSION['currency'] = (USE_DEFAULT_LANGUAGE_CURRENCY == 'true' && xtc_currency_exists(LANGUAGE_CURRENCY)) ? LANGUAGE_CURRENCY : DEFAULT_CURRENCY;
	}
}
if (isset ($_SESSION['currency']) && $_SESSION['currency'] == '') {
	$_SESSION['currency'] = DEFAULT_CURRENCY;
}

// write customers status in session
require (DIR_WS_INCLUDES.'write_customers_status.php');

//require (DIR_WS_CLASSES.'main.php');
$main = new main();

require (DIR_WS_CLASSES.'xtcPrice.php');
$xtPrice = new xtcPrice($_SESSION['currency'], $_SESSION['customers_status']['customers_status_id']);

// econda tracking
if (TRACKING_ECONDA_ACTIVE=='true') {
	require(DIR_WS_INCLUDES . 'econda/class.econda304SP2.php');
	$econda = new econda();
}

// paypal
require_once (DIR_WS_CLASSES.'paypal_checkout.php');
$o_paypal = new paypal_checkout();

// create the shopping cart & fix the cart if necesary
if (!is_object($_SESSION['cart'])) {
	$_SESSION['cart'] = new shoppingCart();
}
// create the wish list & fix the list if necesary
if (!is_object($_SESSION['wishList'])) {
  $_SESSION['wishList'] = new wishList();
}

if (!is_object($_SESSION['lightbox'])) {
  $_SESSION['lightbox'] = new GMLightboxControl();
}

if (!is_object($_SESSION['coo_filter_manager'])) {
	$_SESSION['coo_filter_manager'] = MainFactory::create_object('FilterManager');
}

require (DIR_WS_CLASSES.'boxes.php');

// initialize the message stack for output messages
require (DIR_WS_CLASSES.'message_stack.php');
$messageStack = new messageStack;

require (DIR_WS_INCLUDES.FILENAME_CART_ACTIONS);

// include the who's online functions
xtc_update_whos_online();

require (DIR_WS_CLASSES.'product.php');

// auto activate and expire banners
xtc_activate_banners();
xtc_expire_banners();
xtc_expire_specials();

/******** SHOPGATE **********/
include_once(DIR_FS_CATALOG.'shopgate/gambiogx/includes/application_top.php');
/******** SHOPGATE **********/

if(xtc_not_null($_GET['gm_boosted_content']))
{
	$boosted_name = xtc_db_prepare_input($_GET['gm_boosted_content']);
	$_GET['coID'] = $gmSEOBoost->get_content_coID_by_boost($boosted_name);

	if((int)$_GET['coID'] == 0)
	{
		# gm error 404 handling
		header("HTTP/1.0 404 Not Found");
		if(file_exists(DIR_FS_CATALOG.'error404.html')) {
			include(DIR_FS_CATALOG.'error404.html');
			mysql_close();
			die();
		}
	}
}

if(xtc_not_null($_GET['gm_boosted_product']))
{
	$boosted_name = xtc_db_prepare_input($_GET['gm_boosted_product']);
	$_GET['products_id'] = $gmSEOBoost->get_products_id_by_boost($boosted_name);

	if((int)$_GET['products_id'] == 0)
	{
		# gm error 404 handling
		header("HTTP/1.0 404 Not Found");
		if(file_exists(DIR_FS_CATALOG.'error404.html')) {
			include(DIR_FS_CATALOG.'error404.html');
			mysql_close();
			die();
		}
	}
}
elseif(xtc_not_null($_GET['gm_boosted_category']))
{
	$boosted_name = xtc_db_prepare_input($_GET['gm_boosted_category']);
	$_GET['cat'] = 'c'.$gmSEOBoost->get_categories_id_by_boost($boosted_name);

	if( $_GET['cat'] == 'c0')
	{
		# gm error 404 handling
		header("HTTP/1.0 404 Not Found");
		if(file_exists(DIR_FS_CATALOG.'error404.html')) {
			include(DIR_FS_CATALOG.'error404.html');
			mysql_close();
			die();
		}
	}
}

// new p URLS
if (isset ($_GET['info'])) {
	$site = explode('_', $_GET['info']);
	if(substr($site[0], 0, 1) == 'p')
	{
		$pID = $site[0];
		$actual_products_id = (int) str_replace('p', '', $pID);
		$product = new product($actual_products_id);
	}
} // also check for old 3.0.3 URLS
elseif (isset($_GET['products_id'])) {
	$actual_products_id = (int) $_GET['products_id'];
	$product = new product($actual_products_id);

}
/* BOF GM SEO MOD */
if (!is_object($product)) {
	$product = new product();
}
else
{
	if(isset($_GET['no_boost']) == false)
	{
		$gm_redirected_url = $_SERVER['REDIRECT_URL'];
		if(isset($_SERVER['REDIRECT_SCRIPT_URL']) && !empty($_SERVER['REDIRECT_SCRIPT_URL']))
		{
			$gm_redirected_url = $_SERVER['REDIRECT_SCRIPT_URL'];
		}
		if(isset($_SERVER['SCRIPT_URL']) && strpos($gm_redirected_url, '/product_info.php') !== false)
		{
			$gm_redirected_url = $_SERVER['SCRIPT_URL'];
		}
		if(isset($_SERVER['PATH_INFO']) && strpos($gm_redirected_url, '/product_info.php') !== false)
		{
			$gm_redirected_url = $_SERVER['PATH_INFO'];
		}
		if(isset($_SERVER['REQUEST_URI']) && strpos($gm_redirected_url, '/product_info.php') !== false)
		{
			$gm_redirected_url = $_SERVER['REQUEST_URI'];
		}
		$gm_redirected_url = strtok($gm_redirected_url, '?');

		if($product->isProduct === false && strpos($PHP_SELF, '/product_info.php') !== false)
		{
			header("HTTP/1.0 404 Not Found");
			if(file_exists(DIR_FS_CATALOG.'error404.html')) {
				include(DIR_FS_CATALOG.'error404.html');
				mysql_close();
				die();
			}
		}
		elseif($gmSEOBoost->boost_products && xtc_not_null($_GET['gm_boosted_product']) == false && strpos($PHP_SELF, '/product_info.php') !== false)
		{
			$gm_seo_product_link = xtc_href_link($gmSEOBoost->get_boosted_product_url($product->data['products_id'], $product->data['products_name']));
			if(!isset($_SESSION['last_redirect_url']) || $_SESSION['last_redirect_url'] != $gm_seo_product_link)
			{
				$_SESSION['last_redirect_url'] = $gm_seo_product_link;
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: ". $gm_seo_product_link);
				exit;
			}
			else
			{
				$coo_file_log = new FileLog('redirect_loops');
				$t_redirect_error = '(1) URL: ' . $gm_seo_product_link . "\n";
				$t_redirect_error .= '$gm_redirected_url: ' . $gm_redirected_url . "\n";
				$t_redirect_error .= '$_SERVER: ' . print_r($_SERVER, true);
				$t_redirect_error .= "\n============================================\n";
				$coo_file_log->write($t_redirect_error);
			}
		}
		elseif($gmSEOBoost->boost_products
					&& !empty($_GET['gm_boosted_product'])
					&&
						(strpos($gm_redirected_url, DIR_WS_CATALOG . $gmSEOBoost->get_boosted_product_url($gmSEOBoost->get_products_id_by_boost($_GET['gm_boosted_product']), $_GET['gm_boosted_product'])) === false
					 || strpos($gm_redirected_url, DIR_WS_CATALOG . $gmSEOBoost->get_boosted_product_url($gmSEOBoost->get_products_id_by_boost($_GET['gm_boosted_product']), $_GET['gm_boosted_product'])) !== 0
						)
					&& strpos($PHP_SELF, '/product_info.php') !== false)
		{

			$gm_seo_product_link = xtc_href_link($gmSEOBoost->get_boosted_product_url($product->data['products_id'], $product->data['products_name']));

			if(!isset($_SESSION['last_redirect_url']) || $_SESSION['last_redirect_url'] != $gm_seo_product_link)
			{
				$_SESSION['last_redirect_url'] = $gm_seo_product_link;
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: ". $gm_seo_product_link);
				exit;
			}
			else
			{
				$coo_file_log = new FileLog('redirect_loops');
				$t_redirect_error = '(2) URL: ' . $gm_seo_product_link . "\n";
				$t_redirect_error .= '$gm_redirected_url: ' . $gm_redirected_url . "\n";
				$t_redirect_error .= '$_SERVER: ' . print_r($_SERVER, true);
				$t_redirect_error .= "\n============================================\n";
				$coo_file_log->write($t_redirect_error);
			}
		}
	}
}

// new c URLS
if (isset ($_GET['cat'])) {
	$site = explode('_', $_GET['cat']);
	$cID = $site[0];
	$cID = str_replace('c', '', $cID);
	$_GET['cPath'] = xtc_get_category_path($cID);
	$gm_redirected_url = (string)$_SERVER['REDIRECT_URL'];
	if(isset($_SERVER['REDIRECT_SCRIPT_URL']) && !empty($_SERVER['REDIRECT_SCRIPT_URL']))
	{
		$gm_redirected_url = $_SERVER['REDIRECT_SCRIPT_URL'];
	}
	if(isset($_SERVER['SCRIPT_URL']) && (strpos($gm_redirected_url, '/index.php') !== false || $gm_redirected_url == ''))
	{
		$gm_redirected_url = $_SERVER['SCRIPT_URL'];
	}
	if(isset($_SERVER['PATH_INFO']) && (strpos($gm_redirected_url, '/index.php') !== false || $gm_redirected_url == ''))
	{
		$gm_redirected_url = $_SERVER['PATH_INFO'];
	}
	if(isset($_SERVER['REQUEST_URI']) && (strpos($gm_redirected_url, '/index.php') !== false || $gm_redirected_url == ''))
	{
		$gm_redirected_url = $_SERVER['REQUEST_URI'];
	}
  	$gm_redirected_url = strtok($gm_redirected_url, '?');

	if($gmSEOBoost->boost_categories && xtc_not_null($_GET['gm_boosted_category']) == false && (!isset($_GET['page']) || $_GET['page'] == 1) && !isset($_GET['filter_fv_id']) && !isset($_GET['filter_price_min'])  && !isset($_GET['filter_price_max']) && !isset($_GET['manufacturers_id']) && !isset($_GET['filter_id']) && !isset($_GET['view_mode']) && !isset($_GET['listing_sort']) && !isset($_GET['listing_count']))
	{
		$gm_seo_cat_link = xtc_href_link($gmSEOBoost->get_boosted_category_url($cID));

		if(!isset($_SESSION['last_redirect_url']) || $_SESSION['last_redirect_url'] != $gm_seo_cat_link)
		{
			$_SESSION['last_redirect_url'] = $gm_seo_cat_link;
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: ". $gm_seo_cat_link);
			exit;
		}
		else
		{
			$coo_file_log = new FileLog('redirect_loops');
			$t_redirect_error = '(3) URL: ' . $gm_seo_cat_link . "\n";
			$t_redirect_error .= '$gm_redirected_url: ' . $gm_redirected_url . "\n";
			$t_redirect_error .= '$_SERVER: ' . print_r($_SERVER, true);
			$t_redirect_error .= "\n============================================\n";
			$coo_file_log->write($t_redirect_error);
		}
	}
	elseif($gmSEOBoost->boost_categories
		&& !empty($_GET['gm_boosted_category'])
		&& !isset($_GET['filter_fv_id'])
		&& !isset($_GET['filter_price_min'])
		&& !isset($_GET['filter_price_max'])
		&& !isset($_GET['manufacturers_id'])
		&& !isset($_GET['filter_id'])
		&& !isset($_GET['view_mode'])
		&& !isset($_GET['listing_sort'])
		&& !isset($_GET['listing_count'])
		&& $gm_redirected_url != DIR_WS_CATALOG . $gmSEOBoost->get_boosted_category_url($cID)
		&& $cID != 0
		&& (!isset($_GET['page']) || $_GET['page'] == 1)
		)
	{
		$gm_seo_cat_link = xtc_href_link($gmSEOBoost->get_boosted_category_url($cID));

		if(!isset($_SESSION['last_redirect_url']) || $_SESSION['last_redirect_url'] != $gm_seo_cat_link)
		{
			$_SESSION['last_redirect_url'] = $gm_seo_cat_link;
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: ". $gm_seo_cat_link);
			exit;
		}
		else
		{
			$coo_file_log = new FileLog('redirect_loops');
			$t_redirect_error = '(4) URL: ' . $gm_seo_cat_link . "\n";
			$t_redirect_error .= '$gm_redirected_url: ' . $gm_redirected_url . "\n";
			$t_redirect_error .= '$_SERVER: ' . print_r($_SERVER, true);
			$t_redirect_error .= "\n============================================\n";
			$coo_file_log->write($t_redirect_error);
		}
	}
}

if(isset($_GET['coID']) && strpos($PHP_SELF, '/shop_content.php') !== false)
{
	if($gmSEOBoost->boost_content && xtc_not_null($_GET['gm_boosted_content']) == false && !isset($_GET['gm_ebay_start']))
	{
		if($gmSEOBoost->get_boosted_content_url($gmSEOBoost->get_content_id_by_content_group($_GET['coID'])) !== false)
		{
			if(!isset($_GET['action']))
			{
				$gm_seo_content_link	= xtc_href_link($gmSEOBoost->get_boosted_content_url($gmSEOBoost->get_content_id_by_content_group($_GET['coID'])));

				if(!isset($_SESSION['last_redirect_url']) || $_SESSION['last_redirect_url'] != $gm_seo_content_link)
				{
					$_SESSION['last_redirect_url'] = $gm_seo_content_link;
					header("HTTP/1.1 301 Moved Permanently");
					header("Location: ". $gm_seo_content_link);
					exit;
				}
				else
				{
					$coo_file_log = new FileLog('redirect_loops');
					$t_redirect_error = '(5) URL: ' . $gm_seo_content_link . "\n";
					$t_redirect_error .= '$PHP_SELF: ' . $PHP_SELF . "\n";
					$t_redirect_error .= '$_SERVER: ' . print_r($_SERVER, true);
					$t_redirect_error .= "\n============================================\n";
					$coo_file_log->write($t_redirect_error);
				}
			}
		}
		else
		{
			header("HTTP/1.0 404 Not Found");
			if(file_exists(DIR_FS_CATALOG.'error404.html')) {
				include(DIR_FS_CATALOG.'error404.html');
				mysql_close();
				die();
			}
		}
	}
}

if(isset($_SESSION['last_redirect_url']))
{
	unset($_SESSION['last_redirect_url']);
}
/* EOF GM SEO MOD */
// new m URLS
if (isset ($_GET['manu'])) {
	$site = explode('_', $_GET['manu']);
	$mID = $site[0];
	$mID = (int)str_replace('m', '', $mID);
	$_GET['manufacturers_id'] = $mID;
}

// calculate category path
if (isset ($_GET['cPath'])) {
	$cPath = xtc_input_validation($_GET['cPath'], 'cPath', '');
}
elseif (is_object($product) && !isset ($_GET['manufacturers_id'])) {
	if ($product->isProduct()) {
		$cPath = xtc_get_product_path($actual_products_id);
	} else {
		$cPath = '';
	}
} else {
	$cPath = '';
}

if (xtc_not_null($cPath)) {
	$cPath_array = xtc_parse_category_path($cPath);
	$cPath = implode('_', $cPath_array);
	$current_category_id = $cPath_array[(sizeof($cPath_array) - 1)];
} else {
	$current_category_id = 0;
}

// include the breadcrumb class and start the breadcrumb trail
require (DIR_WS_CLASSES.'breadcrumb.php');
$breadcrumb = new breadcrumb;
$breadcrumb->add(HEADER_TITLE_TOP, xtc_href_link(FILENAME_DEFAULT));

// add category names or the manufacturer name to the breadcrumb trail
if (isset ($cPath_array)) {
	for ($i = 0, $n = sizeof($cPath_array); $i < $n; $i ++) {
		if (GROUP_CHECK == 'true') {
			$group_check = "and c.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
		}
		$categories_query = xtDBquery("select
				                                        cd.categories_name
				                                        from ".TABLE_CATEGORIES_DESCRIPTION." cd,
				                                        ".TABLE_CATEGORIES." c
				                                        where cd.categories_id = '".$cPath_array[$i]."'
				                                        and c.categories_id=cd.categories_id
				                                        ".$group_check."
				                                        and cd.language_id='".(int) $_SESSION['languages_id']."'");
		if (xtc_db_num_rows($categories_query,true) > 0) {
			$categories = xtc_db_fetch_array($categories_query,true);
			/* bof gm seo */
			if($gmSEOBoost->boost_categories) {
				$gm_seo_cat_link = xtc_href_link($gmSEOBoost->get_boosted_category_url($cPath_array[$i], $_SESSION['languages_id']));
			} else {
				$gm_seo_cat_link = xtc_href_link(FILENAME_DEFAULT, xtc_category_link($cPath_array[$i], $categories['categories_name']));
			}

			$breadcrumb->add(htmlspecialchars_wrapper($categories['categories_name']), $gm_seo_cat_link);
			/* eof gm seo */
		} else {
			break;
		}
	}
}
elseif (xtc_not_null($_GET['manufacturers_id'])) {
	$manufacturers_query = xtDBquery("select manufacturers_name from ".TABLE_MANUFACTURERS." where manufacturers_id = '".(int) $_GET['manufacturers_id']."'");
	$manufacturers = xtc_db_fetch_array($manufacturers_query, true);

	$breadcrumb->add($manufacturers['manufacturers_name'], xtc_href_link(FILENAME_DEFAULT, xtc_manufacturer_link((int) $_GET['manufacturers_id'], $manufacturers['manufacturers_name'])));

}

// add the products model/name to the breadcrumb trail
if ($product->isProduct()) {
	/* bof gm seo */
	if($gmSEOBoost->boost_products) {
		$gm_seo_product_link = xtc_href_link($gmSEOBoost->get_boosted_product_url($product->data['products_id'], $product->data['products_name']));
	} else {
		$gm_seo_product_link = xtc_href_link(FILENAME_PRODUCT_INFO, xtc_product_link($product->data['products_id'], $product->data['products_name']));
	}
	$breadcrumb->add($product->data['products_name'], $gm_seo_product_link);
	/* eof gm seo */
}

// set which precautions should be checked
define('WARN_INSTALL_EXISTENCE', 'true');
define('WARN_CONFIG_WRITEABLE', 'false');
define('WARN_SESSION_DIRECTORY_NOT_WRITEABLE', 'true');
define('WARN_SESSION_AUTO_START', 'true');
define('WARN_DOWNLOAD_DIRECTORY_NOT_READABLE', 'true');

if (isset ($_SESSION['customer_id'])) {
	$account_type_query = xtc_db_query("SELECT
		                                    account_type,
		                                    customers_default_address_id
		                                    FROM
		                                    ".TABLE_CUSTOMERS."
		                                    WHERE customers_id = '".(int) $_SESSION['customer_id']."'");
	$account_type = xtc_db_fetch_array($account_type_query);

	// check if zone id is unset bug #0000169
	if (!isset ($_SESSION['customer_country_id'])) {
		$zone_query = xtc_db_query("SELECT  entry_country_id
				                                     FROM ".TABLE_ADDRESS_BOOK."
				                                     WHERE customers_id='".(int) $_SESSION['customer_id']."'
				                                     and address_book_id='".$account_type['customers_default_address_id']."'");

		$zone = xtc_db_fetch_array($zone_query);
		$_SESSION['customer_country_id'] = $zone['entry_country_id'];
	}
	$_SESSION['account_type'] = $account_type['account_type'];
} else {
	$_SESSION['account_type'] = '0';
}

// modification for nre graduated system
unset ($_SESSION['actual_content']);

xtc_count_cart();

$coo_application_top_extender_component = MainFactory::create_object('ApplicationTopExtenderComponent');
$coo_application_top_extender_component->set_data('GET', $_GET);
$coo_application_top_extender_component->set_data('POST', $_POST);
$coo_application_top_extender_component->proceed();

header('Content-Type: text/html; charset=' . $_SESSION['language_charset'] . '');
?>