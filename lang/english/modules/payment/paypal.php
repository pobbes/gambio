<?php
/* --------------------------------------------------------------
   paypal.php 2010-08-17 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(paypal.php,v 1.7 2002/04/17); www.oscommerce.com
   (c) 2003	 nextcommerce (paypal.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: paypal.php 192 2007-02-24 16:24:52Z mzanier $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

define('MODULE_PAYMENT_PAYPAL_TEXT_TITLE', 'PayPal');
define('MODULE_PAYMENT_PAYPAL_TEXT_DESCRIPTION', 'PayPal');
define('MODULE_PAYMENT_PAYPAL_TEXT_INFO', '');
define('MODULE_PAYMENT_PAYPAL_STATUS_TITLE', 'Enable PayPal Module');
define('MODULE_PAYMENT_PAYPAL_STATUS_DESC', 'Do you want to accept PayPal payments?');
define('MODULE_PAYMENT_PAYPAL_ID_TITLE', 'Email Address');
define('MODULE_PAYMENT_PAYPAL_ID_DESC', 'Email address to use for the PayPal service');
define('MODULE_PAYMENT_PAYPAL_CURRENCY_TITLE', 'Transaction Currency');
define('MODULE_PAYMENT_PAYPAL_CURRENCY_DESC', 'The currency to use for credit card transactions');
define('MODULE_PAYMENT_PAYPAL_TMP_STATUS_ID_TITLE', 'Pending Order Status');
define('MODULE_PAYMENT_PAYPAL_TMP_STATUS_ID_DESC', 'Set the status for pending transactions');
define('MODULE_PAYMENT_PAYPAL_USE_CURL_TITLE', 'cURL');
define('MODULE_PAYMENT_PAYPAL_USE_CURL_DESC', 'Use cURL or redirection.');

define('MODULE_PAYMENT_PAYPAL_COST_TITLE', 'Payment fee');
define('MODULE_PAYMENT_PAYPAL_COST_DESC', '');
define('MODULE_PAYMENT_PAYPAL_ZONE_TITLE', 'Allowed Zones');
define('MODULE_PAYMENT_PAYPAL_ZONE_DESC', 'Please enter the zones individually that should be allowed to use this module (e.g. US, UK (leave blank to allow all zones))');
define('MODULE_PAYMENT_PAYPAL_ALLOWED_TITLE', 'Payment Zone');
define('MODULE_PAYMENT_PAYPAL_ALLOWED_DESC', 'When a zone is selected, this payment method will be enabled for that zone only.');
define('MODULE_PAYMENT_PAYPAL_SORT_ORDER_TITLE', 'Display Sort Order');
define('MODULE_PAYMENT_PAYPAL_SORT_ORDER_DESC', 'Display sort order; the lowest value is displayed first.');
define('MODULE_PAYMENT_PAYPAL_ORDER_STATUS_ID_TITLE', 'Set Order Status');
define('MODULE_PAYMENT_PAYPAL_ORDER_STATUS_ID_DESC', 'Set the status of orders made using this payment module to this value');
?>