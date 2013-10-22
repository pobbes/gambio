<?php
/*
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
*/

define('MODULE_PAYMENT_HPEPS_TEXT_TITLE', 'EPS');
define('MODULE_PAYMENT_HPEPS_TEXT_DESC', 'EPS over Heidelberger Payment GmbH');

define('MODULE_PAYMENT_HPEPS_SECURITY_SENDER_TITLE', 'Sender ID');
define('MODULE_PAYMENT_HPEPS_SECURITY_SENDER_DESC', 'Your Heidelpay Sender ID');

define('MODULE_PAYMENT_HPEPS_USER_LOGIN_TITLE', 'User Login');
define('MODULE_PAYMENT_HPEPS_USER_LOGIN_DESC', 'Your Heidelpay User Login');

define('MODULE_PAYMENT_HPEPS_USER_PWD_TITLE', 'User Password');
define('MODULE_PAYMENT_HPEPS_USER_PWD_DESC', 'Your Heidelpay User Password');

define('MODULE_PAYMENT_HPEPS_TRANSACTION_CHANNEL_TITLE', 'Channel ID');
define('MODULE_PAYMENT_HPEPS_TRANSACTION_CHANNEL_DESC', 'Your Heidelpay Channel ID');

define('MODULE_PAYMENT_HPEPS_TRANSACTION_MODE_TITLE', 'Transaction Mode');
define('MODULE_PAYMENT_HPEPS_TRANSACTION_MODE_DESC', 'Please choose your transaction mode.');

define('MODULE_PAYMENT_HPEPS_MODULE_MODE_TITLE', 'Module Mode');
define('MODULE_PAYMENT_HPEPS_MODULE_MODE_DESC', 'DIRECT: Paymentinformations will be entered on payment selection with REGISTER function (plus Registerfee). <br>AFTER: Paymentinformations will be entered after process with DEBIT function.');

define('MODULE_PAYMENT_HPEPS_DIRECT_MODE_TITLE', 'Direct Mode');
define('MODULE_PAYMENT_HPEPS_DIRECT_MODE_DESC', 'If Modul Mode is on DIRECT you can decide if the paymentdata should be entered on an extra site or a lightbox.');

define('MODULE_PAYMENT_HPEPS_PAY_MODE_TITLE', 'Payment Mode');
define('MODULE_PAYMENT_HPEPS_PAY_MODE_DESC', 'Select between Debit (DB) and Preauthorisation (PA).');

define('MODULE_PAYMENT_HPEPS_TEST_ACCOUNT_TITLE', 'Test Account');
define('MODULE_PAYMENT_HPEPS_TEST_ACCOUNT_DESC', 'If Transaction Mode is not LIVE, the following Accounts (EMail) can test the payment. (Comma separated)');

define('MODULE_PAYMENT_HPEPS_PROCESSED_STATUS_ID_TITLE', 'Orderstatus - Success');
define('MODULE_PAYMENT_HPEPS_PROCESSED_STATUS_ID_DESC', 'Order Status which will be set in case of successfully payment');

define('MODULE_PAYMENT_HPEPS_PENDING_STATUS_ID_TITLE', 'Orderstatus - Pending');
define('MODULE_PAYMENT_HPEPS_PENDING_STATUS_ID_DESC', 'Order Status which will be set in case of pending payment');

define('MODULE_PAYMENT_HPEPS_CANCELED_STATUS_ID_TITLE', 'Orderstatus - Cancel');
define('MODULE_PAYMENT_HPEPS_CANCELED_STATUS_ID_DESC', 'Order Status which will be set in case of cancel payment');

define('MODULE_PAYMENT_HPEPS_NEWORDER_STATUS_ID_TITLE', 'Orderstatus - New Order');
define('MODULE_PAYMENT_HPEPS_NEWORDER_STATUS_ID_DESC', 'Order Status which will be set in case of beginning payment');

define('MODULE_PAYMENT_HPEPS_STATUS_TITLE', 'Activate Module');
define('MODULE_PAYMENT_HPEPS_STATUS_DESC', 'Do you want to activate the module?');

define('MODULE_PAYMENT_HPEPS_SORT_ORDER_TITLE', 'Sort Order');
define('MODULE_PAYMENT_HPEPS_SORT_ORDER_DESC', 'Sort order for display. Lowest will be shown first.');

define('MODULE_PAYMENT_HPEPS_ZONE_TITLE', 'Paymentzone');
define('MODULE_PAYMENT_HPEPS_ZONE_DESC', 'If a zone is selected, only enable this payment method for that zone.');

define('MODULE_PAYMENT_HPEPS_ALLOWED_TITLE', 'Allowed Zones');
define('MODULE_PAYMENT_HPEPS_ALLOWED_DESC', 'Please enter the zones <b>separately</b> which should be allowed to use this modul (e. g. AT,DE (leave empty if you want to allow all zones))');

define('MODULE_PAYMENT_HPEPS_TEXT_INFO', '');
define('MODULE_PAYMENT_HPEPS_DEBUGTEXT', 'The payment is temporary not available. Please use another one or try again later.');
?>
