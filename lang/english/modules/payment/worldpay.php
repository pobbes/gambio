<?php
/* -----------------------------------------------------------------------------------------
   $Id: worldpay.php,v 1.0
   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   Anpassung Worldpay by XTC-Webservice.de, Matthias Hinsche
   -----------------------------------------------------------------------------------------
   based on:

  Author : 	Graeme Conkie (graeme@conkie.net)
  Title: WorldPay Payment Callback Module V4.0 Version 1.4

  Revisions:
	Version MS1a Cleaned up code, moved static English to language file to allow for bi-lingual use,
	        Now posting language code to WP, Redirect on failure now to Checkout Payment,
			Reduced re-direct time to 8 seconds, added MD5, made callback dynamic 
			NOTE: YOU MUST CHANGE THE CALLBACK URL IN WP ADMIN TO <wpdisplay item="MC_callback">
	Version 1.4 Removes boxes to prevent users from clicking away before update, 
			Fixes currency for Yen, 
			Redirects to Checkout_Process after 10 seconds or click by user
	Version 1.3 Fixes problem with Multi Currency
	Version 1.2 Added Sort Order and Default order status to work with snapshots after 14 Jan 2003
	Version 1.1 Added Worldpay Pre-Authorisation ability
	Version 1.0 Initial Payment Module

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
define('MODULE_PAYMENT_WORLDPAY_TEXT_TITLE', 'Secure Credit Card Payment');
define('MODULE_PAYMENT_WORLDPAY_TEXT_DESC', 'WorldPay payment module');
define('MODULE_PAYMENT_WORLDPAY_TEXT_INFO','');
define('MODULE_PAYMENT_WORLDPAY_STATUS_TITLE', 'Enable WorldPay Module');
define('MODULE_PAYMENT_WORLDPAY_STATUS_DESC', 'Do you want to accept WorldPay payments?');

define('MODULE_PAYMENT_WORLDPAY_ID_TITLE', 'WorldPay Installation ID');
define('MODULE_PAYMENT_WORLDPAY_ID_DESC', 'Your WorldPay select junior ID');

define('MODULE_PAYMENT_WORLDPAY_MODE_TITLE', 'Mode');
define('MODULE_PAYMENT_WORLDPAY_MODE_DESC', 'The mode you are working in (100 = Test Mode Accept, 101 = Test Mode Decline, 0 = Live');

define('MODULE_PAYMENT_WORLDPAY_USEMD5_TITLE', 'Use MD5');
define('MODULE_PAYMENT_WORLDPAY_USEMD5_DESC', 'Use MD5 encryption for transactions? (1 = Yes, 0 = No)');

define('MODULE_PAYMENT_WORLDPAY_MD5KEY_TITLE', 'Use MD5');
define('MODULE_PAYMENT_WORLDPAY_MD5KEY_DESC', 'Use MD5 encryption for transactions? (1 = Yes, 0 = No)');

define('MODULE_PAYMENT_WORLDPAY_SORT_ORDER_TITLE', 'Display Sort Order');
define('MODULE_PAYMENT_WORLDPAY_SORT_ORDER_DESC', 'Display sort order; the lowest value is displayed first.');

define('MODULE_PAYMENT_WORLDPAY_USEPREAUTH_TITLE', 'Use Pre-authorization?');
define('MODULE_PAYMENT_WORLDPAY_USEPREAUTH_DESC', 'Do you want to pre-authorize payments? Default = False. You must request this from WorldPay before using it.');

define('MODULE_PAYMENT_WORLDPAY_ORDER_STATUS_ID_TITLE', 'Set Order Status');
define('MODULE_PAYMENT_WORLDPAY_ORDER_STATUS_ID_DESC', 'Set the status of orders made with this payment module to this value');

define('MODULE_PAYMENT_WORLDPAY_PREAUTH_TITLE', 'Pre-auth');
define('MODULE_PAYMENT_WORLDPAY_PREAUTH_DESC', 'The mode you are working in (A = Pay Now, E = Pre-auth). Ignored if using pre-auth = false.');

define('MODULE_PAYMENT_WORLDPAY_ZONE_TITLE', 'Payment Zone');
define('MODULE_PAYMENT_WORLDPAY_ZONE_DESC', 'When a zone is selected, this payment method will be enabled for that zone only.');

define('MODULE_PAYMENT_WORLDPAY_ALLOWED_TITLE' , 'Allowed Zones');
define('MODULE_PAYMENT_WORLDPAY_ALLOWED_DESC' , 'Enter the zones <b>individually</b> that should be allowed for this module. (e.g. US, UK (leave blank to allow all zones))');
?>