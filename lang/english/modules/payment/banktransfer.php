<?php
/* -----------------------------------------------------------------------------------------
   $Id: banktransfer.php 998 2005-07-07 14:18:20Z mz $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(banktransfer.php,v 1.9 2003/02/18 19:22:15); www.oscommerce.com 
   (c) 2003	 nextcommerce (banktransfer.php,v 1.5 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   OSC German Banktransfer v0.85a       	Autor:	Dominik Guder <osc@guder.org>
   
   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
define('MODULE_PAYMENT_TYPE_PERMISSION', 'bt');

define('MODULE_PAYMENT_BANKTRANSFER_TEXT_TITLE', 'Bank Transfer');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_DESCRIPTION', 'Payments via bank transfer');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK', 'Bank transfer');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_EMAIL_FOOTER', 'Note: You can download our fax confirmation form here: ' . HTTP_SERVER . DIR_WS_CATALOG . MODULE_PAYMENT_BANKTRANSFER_URL_NOTE . '');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_INFO', 'Please note that bank transfer payments are <b>only</b> available from a <b>German</b> bank account!');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_OWNER', 'Account holder:');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_NUMBER', 'Account number:');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_BLZ', 'Bank code:');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_NAME', 'Bank:');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_FAX', 'Bank transfer payment will be confirmed by fax');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_INFO','');

define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_ERROR', 'ERROR:');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_ERROR_1', 'Account number and bank code do not match! Please check again.');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_ERROR_2', 'No plausibility check method available for this bank code!');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_ERROR_3', 'Account number cannot be verified!');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_ERROR_4', 'Account number cannot be verified! Please check again.');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_ERROR_5', 'Bank code not found! Please check again.');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_ERROR_8', 'Incorrect bank code or no bank code entered!');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_ERROR_9', 'No account number entered!');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_ERROR_10', 'No account holder entered!');

define('MODULE_PAYMENT_BANKTRANSFER_TEXT_NOTE', 'Note:');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_NOTE2', 'If you do not want to send your<br />account details over the Internet, you can download our ');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_NOTE3', 'fax form');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_NOTE4', ' and return it to us.');

define('JS_BANK_BLZ', 'Please enter the bank code of your bank!\n');
define('JS_BANK_NAME', 'Please enter the name of your bank!\n');
define('JS_BANK_NUMBER', 'Please enter your account number!\n');
define('JS_BANK_OWNER', 'Please enter the name of the account holder!\n');

define('MODULE_PAYMENT_BANKTRANSFER_DATABASE_BLZ_TITLE' , 'Use database lookup for bank code?');
define('MODULE_PAYMENT_BANKTRANSFER_DATABASE_BLZ_DESC' , 'Would you like to use database lookup for the bank code? Ensure that the table banktransfer_blz exists and is set up correctly!');
define('MODULE_PAYMENT_BANKTRANSFER_URL_NOTE_TITLE' , 'Fax Url');
define('MODULE_PAYMENT_BANKTRANSFER_URL_NOTE_DESC' , 'The fax confirmation file; this should be located in the catalog dir');
define('MODULE_PAYMENT_BANKTRANSFER_FAX_CONFIRMATION_TITLE' , 'Allow Fax Confirmation');
define('MODULE_PAYMENT_BANKTRANSFER_FAX_CONFIRMATION_DESC' , 'Do you want to allow fax confirmation?');
define('MODULE_PAYMENT_BANKTRANSFER_SORT_ORDER_TITLE' , 'Display Sort Order');
define('MODULE_PAYMENT_BANKTRANSFER_SORT_ORDER_DESC' , 'Display sort order; the lowest value is displayed first.');
define('MODULE_PAYMENT_BANKTRANSFER_ORDER_STATUS_ID_TITLE' , 'Set Order Status');
define('MODULE_PAYMENT_BANKTRANSFER_ORDER_STATUS_ID_DESC' , 'Set the status of orders made with this payment module');
define('MODULE_PAYMENT_BANKTRANSFER_ZONE_TITLE' , 'Payment Zone');
define('MODULE_PAYMENT_BANKTRANSFER_ZONE_DESC' , 'When a zone is selected, this payment method will be enabled for that zone only.');
define('MODULE_PAYMENT_BANKTRANSFER_ALLOWED_TITLE' , 'Allowed Zones');
define('MODULE_PAYMENT_BANKTRANSFER_ALLOWED_DESC' , 'Please enter the zones <b>individually</b> that should be allowed to use this module (e.g. US, UK (leave blank to allow all zones))');
define('MODULE_PAYMENT_BANKTRANSFER_STATUS_TITLE' , 'Allow Bank Transfer Payments');
define('MODULE_PAYMENT_BANKTRANSFER_STATUS_DESC' , 'Do you want to accept bank transfer payments?');
define('MODULE_PAYMENT_BANKTRANSFER_MIN_ORDER_TITLE' , 'Minimum Orders');
define('MODULE_PAYMENT_BANKTRANSFER_MIN_ORDER_DESC' , 'Minimum orders for a customer to view this option.');
define('MODULE_PAYMENT_BANKTRANSFER_DATACHECK_TITLE', 'Check bankdata?');
define('MODULE_PAYMENT_BANKTRANSFER_DATACHECK_DESC', 'Shall the entered bank data be checked?');#
?>