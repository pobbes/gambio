<?php
/* --------------------------------------------------------------
   clickandbuy_v2.php 2009-12-21 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2009 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

$Id: clickandbuy.php,v 1.0 2005/10/05

  osCommerce payment contribution

  Copyright (c) 2005 by Julius Firl | jfirl@fotocommunity.com | fotocommuntiy.de

  Released under the GNU General Public License
*/

  define('MODULE_PAYMENT_CLICKANDBUY_V2_TEXT_TITLE', 'ClickandBuy</b><br>');
  define('MODULE_PAYMENT_CLICKANDBUY_V2_TEXT_DESCRIPTION', 'ClickandBuy');
  define('MODULE_PAYMENT_CLICKANDBUY_V2_STATUS_TITLE', 'Enable clickandbuy Module');
  define('MODULE_PAYMENT_CLICKANDBUY_V2_STATUS_DESC', 'Do you want to accept clickandbuy payments?');
  define('MODULE_PAYMENT_CLICKANDBUY_V2_ID_TITLE', 'Premium-Link');
  define('MODULE_PAYMENT_CLICKANDBUY_V2_ID_DESC', 'Your premium-link from clickandbuy to transfer payments');
  define('MODULE_PAYMENT_CLICKANDBUY_V2_REDIRECT_TITLE', 'Redirect-Filename');
  define('MODULE_PAYMENT_CLICKANDBUY_V2_REDIRECT_DESC', 'The redirection-Filename for clickandbuy (YOU CAN NOT CHANGE!!!)');
  define('MODULE_PAYMENT_CLICKANDBUY_V2_CURRENCY_TITLE', 'Transaction Currency');
  define('MODULE_PAYMENT_CLICKANDBUY_V2_CURRENCY_DESC', 'The currency to use for clickandbuy transactions');
  define('MODULE_PAYMENT_CLICKANDBUY_V2_SORT_ORDER_TITLE', 'Sort order of display.');
  define('MODULE_PAYMENT_CLICKANDBUY_V2_SORT_ORDER_DESC', 'Sort order of display. Lowest is displayed first.');
  define('MODULE_PAYMENT_CLICKANDBUY_V2_ZONE_TITLE', 'Payment Zone');
  define('MODULE_PAYMENT_CLICKANDBUY_V2_ZONE_DESC', 'If a zone is selected, only enable this payment method for that zone.');
  define('MODULE_PAYMENT_CLICKANDBUY_V2_ORDER_STATUS_ID_TITLE', 'Set Order Status');
  define('MODULE_PAYMENT_CLICKANDBUY_V2_ORDER_STATUS_ID_DESC', 'Set the status of orders made with this payment module to this value');
  define('MODULE_PAYMENT_CLICKANDBUY_V2_ALLOWED_TITLE' , 'Erlaubte Zonen');
//zmb clickandbuy
define('MODULE_PAYMENT_CLICKANDBUY_V2_ALLOWED_DESC' , 'Enter <b>each</b> Zone for which this module should be enabled (e.g. "UK,DE"). If left empty, all zones are allowed.');
define('MODULE_PAYMENT_CLICKANDBUY_V2_SECONDCONFIRMATION_STATUS_TITLE', 'Use Second Confirmation?');
define('MODULE_PAYMENT_CLICKANDBUY_V2_SECONDCONFIRMATION_STATUS_DESC', 'Enable Second Confirmation check for orders?');
define('MODULE_PAYMENT_CLICKANDBUY_V2_SELLER_ID_TITLE', 'Seller ID');
define('MODULE_PAYMENT_CLICKANDBUY_V2_SELLER_ID_DESC', 'Your merchant account seller ID.');
define('MODULE_PAYMENT_CLICKANDBUY_V2_TMI_PASSWORD_TITLE', 'Transaction Manager Password');
define('MODULE_PAYMENT_CLICKANDBUY_V2_TMI_PASSWORD_DESC', 'Your password for the Transaction Manager Interface.');


// More Info Link
define('MODULE_PAYMENT_CLICKANDBUY_V2_MORE_INFO_LINK_TITLE', 'More information about ClickandBuy');

// ClickandBuy
define('CLICKANDBUY_V2_PAYMENT_ERROR_DB', 'A database error occurred. Please choose a different payment method.');
define('CLICKANDBUY_V2_PAYMENT_ERROR_NO_USERID', 'Error #3 while executing payment. Please try again.');
define('CLICKANDBUY_V2_PAYMENT_ERROR_NO_TRANSACTIONID', 'Error #4 while executing payment. Please try again.');
define('CLICKANDBUY_V2_PAYMENT_ERROR_NO_EXTERNALBDRID', 'Error #5 while executing payment. Please try again.');
define('CLICKANDBUY_V2_PAYMENT_ERROR_NO_PRICE', 'Error #6 while executing payment. Please choose a different payment method.');
define('CLICKANDBUY_V2_PAYMENT_ERROR_INVALID_TRANSACTIONID', 'Error #7 while executing payment. Please choose a different payment method.');
define('CLICKANDBUY_V2_PAYMENT_ERROR_INVALID_IP', 'Error #8 while executing payment. Please choose a different payment method.');
define('CLICKANDBUY_V2_PAYMENT_ERROR_NO_XUSERID', 'Error #9 while executing payment. Please choose a different payment method.');
define('CLICKANDBUY_V2_PAYMENT_ERROR_NO_BASKET', 'Error #10 while executing payment. Please choose a different payment method.');
define('CLICKANDBUY_V2_PAYMENT_ERROR_INVALID_BASKET', 'Error #11 while executing payment. Please choose a different payment method.');
// /ClickandBuy
// zmb clickandbuy
?>