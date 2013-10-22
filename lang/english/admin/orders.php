<?php
/* --------------------------------------------------------------
   orders.php 2012-04-19 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(orders.php,v 1.27 2003/02/16); www.oscommerce.com
   (c) 2003	 nextcommerce (orders.php,v 1.7 2003/08/14); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: orders.php 1193 2005-08-28 17:02:03Z matthias $)

   Released under the GNU General Public License
   --------------------------------------------------------------*/
define('TEXT_BANK', 'Bank Collection');
define('TEXT_BANK_OWNER', 'Account Holder:');
define('TEXT_BANK_NUMBER', 'Account Number:');
define('TEXT_BANK_BLZ', 'Bank Code:');
define('TEXT_BANK_NAME', 'Bank:');
define('TEXT_BANK_FAX', 'Collect authorization will be approved by fax');
define('TEXT_BANK_STATUS', 'Verify Status:');
define('TEXT_BANK_PRZ', 'Method of Verify:');
define('TEXT_MARKED_ELEMENTS','Marked Elements');

define('TEXT_BANK_ERROR_1', 'Account number and bank code are not compatible!<br />Please try again!');
define('TEXT_BANK_ERROR_2', 'Sorry, we are unable to proof this account number!');
define('TEXT_BANK_ERROR_3', 'Account number not proofable! Method of verify not implemented');
define('TEXT_BANK_ERROR_4', 'Account number technically not proofable!<br />Please try again!');
define('TEXT_BANK_ERROR_5', 'Bank code not found!<br />Please try again.!');
define('TEXT_BANK_ERROR_8', 'No match for your bank code or bank code not provided!');
define('TEXT_BANK_ERROR_9', 'No account number provided!');
define('TEXT_BANK_ERRORCODE', 'Error code:');

define('HEADING_TITLE', 'Orders');
define('HEADING_TITLE_SEARCH', 'Order ID:');
define('HEADING_TITLE_STATUS', 'Status:');
define('HEADING_SUB_TITLE', 'Customers');


define('TABLE_HEADING_COMMENTS', 'Comments');
define('TABLE_HEADING_CUSTOMERS', 'Customers');
define('TABLE_HEADING_ORDER_TOTAL', 'Order Total');
define('TABLE_HEADING_DATE_PURCHASED', 'Date Purchased');
define('TABLE_HEADING_STATUS', 'Status');
define('TABLE_HEADING_ACTION', 'Action');
define('TABLE_HEADING_QUANTITY', 'Qty');
define('TABLE_HEADING_PRODUCTS_MODEL', 'Model');
define('TABLE_HEADING_PRODUCTS', 'Products');
define('TABLE_HEADING_TAX', 'Tax');
define('TABLE_HEADING_TOTAL', 'Total');
define('TABLE_HEADING_STATUS', 'Status');
define('TABLE_HEADING_PRICE_EXCLUDING_TAX', 'Price (excl)');
define('TABLE_HEADING_PRICE_INCLUDING_TAX', 'Price (incl)');
define('TABLE_HEADING_TOTAL_EXCLUDING_TAX', 'Total (excl)');
define('TABLE_HEADING_TOTAL_INCLUDING_TAX', 'Total');
define('TABLE_HEADING_AFTERBUY','Afterbuy');

define('TABLE_HEADING_STATUS', 'Status');
define('TABLE_HEADING_CUSTOMER_NOTIFIED', 'Customer Notified');
define('TABLE_HEADING_DATE_ADDED', 'Date Added');

define('ENTRY_CUSTOMER', 'Customer:');
define('ENTRY_SOLD_TO', 'SOLD TO:');
define('ENTRY_STREET_ADDRESS', 'Street Address:');
define('ENTRY_SUBURB', 'Suburb:');
define('ENTRY_CITY', 'City:');
define('ENTRY_POST_CODE', 'Postcode (ZIP):');
define('ENTRY_STATE', 'State:');
define('ENTRY_COUNTRY', 'Country:');
define('ENTRY_TELEPHONE', 'Telephone:');
define('ENTRY_EMAIL_ADDRESS', 'Email Address:');
define('ENTRY_DELIVERY_TO', 'Delivery To:');
define('ENTRY_SHIP_TO', 'SHIP TO:');
define('ENTRY_SHIPPING_ADDRESS', 'Shipping Address:');
define('ENTRY_BILLING_ADDRESS', 'Billing Address:');
define('ENTRY_PAYMENT_METHOD', 'Payment Method:');
define('ENTRY_CREDIT_CARD_TYPE', 'Credit Card Type:');
define('ENTRY_CREDIT_CARD_OWNER', 'Credit Card Owner:');
define('ENTRY_CREDIT_CARD_NUMBER', 'Credit Card Number:');
define('ENTRY_CREDIT_CARD_CVV', 'Security Code (CVV)):');
define('ENTRY_CREDIT_CARD_EXPIRES', 'Credit Card Expires:');
define('ENTRY_SUB_TOTAL', 'Subtotal:');
define('ENTRY_TAX', 'Tax:');
define('ENTRY_SHIPPING', 'Shipping:');
define('ENTRY_TOTAL', 'Total:');
define('ENTRY_DATE_PURCHASED', 'Date Purchased:');
define('ENTRY_STATUS', 'Status:');
define('ENTRY_DATE_LAST_UPDATED', 'Date Last Updated:');
define('ENTRY_NOTIFY_CUSTOMER', 'Notify Customer:');
define('ENTRY_NOTIFY_COMMENTS', 'Append Comments:');
define('ENTRY_PRINTABLE', 'Print Invoice');

define('TEXT_INFO_HEADING_DELETE_ORDER', 'Delete Order');
define('TEXT_INFO_DELETE_INTRO', 'Are you sure you want to delete this order?');
define('TEXT_INFO_RESTOCK_PRODUCT_QUANTITY', 'Restock product quantity');
define('TEXT_DATE_ORDER_CREATED', 'Date Created:');
define('TEXT_DATE_ORDER_LAST_MODIFIED', 'Last Modified:');
define('TEXT_INFO_PAYMENT_METHOD', 'Payment Method:');
define('TEXT_INFO_RESHIPP', 'Delivery status recalculate');

define('TEXT_ALL_ORDERS', 'All Orders');
define('TEXT_NO_ORDER_HISTORY', 'No Order History Available');

define('EMAIL_SEPARATOR', '------------------------------------------------------');
define('EMAIL_TEXT_SUBJECT', 'Order Update');
define('EMAIL_TEXT_ORDER_NUMBER', 'Order Number:');
define('EMAIL_TEXT_INVOICE_URL', 'Detailed Invoice:');
define('EMAIL_TEXT_DATE_ORDERED', 'Date Ordered:');
define('EMAIL_TEXT_STATUS_UPDATE', 'Your order has been updated to the following status.' . "\n\n" . 'New status: %s' . "\n\n" . 'Please reply to this email if you have any questions.' . "\n");
define('EMAIL_TEXT_COMMENTS_UPDATE', 'Comments on your order:' . "\n\n%s\n\n");

define('ERROR_ORDER_DOES_NOT_EXIST', 'Error: Order does not exist.');
define('SUCCESS_ORDER_UPDATED', 'Success: Order has been updated successfully.');
define('WARNING_ORDER_NOT_UPDATED', 'Warning: Nothing to change. The order was not updated.');

define('TABLE_HEADING_DISCOUNT','Discount');
define('ENTRY_CUSTOMERS_GROUP','Customer Group:');
define('ENTRY_CUSTOMERS_VAT_ID','VAT No.:');
define('TEXT_VALIDATING','Not validated');
// zmb
// ClickandBuy
define('HEADING_CLICKANDBUY_V2_EMS', 'ClickandBuy EMS Events');
define('TABLE_HEADING_CLICKANDBUY_V2_EMS_TIMESTAMP', 'Timestamp');
define('TABLE_HEADING_CLICKANDBUY_V2_EMS_TYPE', 'Type');
define('TABLE_HEADING_CLICKANDBUY_V2_EMS_ACTION', 'Action');
define('TEXT_CLICKANDBUY_V2_EMS_NO_EVENTS', 'No EMS events.');
// /ClickandBuy
// zmb

/* BOF GM*/
define('TABLE_HEADING_GM_STATUS', 'Status');
define('TEXT_GM_STATUS', 'Change Status');
define('HEADING_GM_STATUS', 'Change Order Status');
define('TITLE_ORDER', 'Show Order');
define('TITLE_SEND_ORDER', 'Send Order Acceptance');
define('TITLE_ORDERS_BILLING_CODE', 'Invoice Code');
define('TITLE_RECREATE_ORDER', 'Create Order Acceptance');
define('TITLE_PACKINGS_BILLING_CODE', 'Packing Slip Billing Code');
define('TITLE_INVOICE', 'Invoice');
define('TITLE_INVOICE_MAIL', 'Email Invoice');
define('TITLE_PACKINGSLIP', 'Packing Slip');

define('GM_PRODUCTS', 'Product(s)');
define('GM_ORDERS_EDIT_CLOCK', ' o\'clock');
define('GM_ORDERS_NUMBER', 'Order No.: ');
define('GM_MAIL', 'Email:');
define('TITLE_CUSTOMER_ID', 'Customer ID:');
define('TITLE_GIFT_MAIL', 'Email Coupon');
define('TITLE_BANK_INFO', 'Bank Transfer');
define('TITLE_CC_INFO', 'Credit Card Info');
define('TABLE_HEADING_PAYPAL', 'Paypal');

define('GM_SEND_ORDER_STATUS_MONO', 'The order marked did not receive an order acceptance.');
define('GM_SEND_ORDER_STATUS_STEREO', 'The order marked did not receive an order acceptance.');
define('BUTTON_GM_CANCEL', 'Cancel');

define('BUTTON_EKOMI_SEND_MAIL', 'Send eKomi-e-mail');
define('EKOMI_SEND_MAIL_SUCCESS', 'The eKomi-e-mail was successfully sent.');
define('EKOMI_ALREADY_SEND_MAIL_ERROR', 'The eKomi-e-mail was not sent, because the mail was already sent in the past.');
define('EKOMI_SEND_MAIL_ERROR', 'The eKomi-e-mail was not sent, because a failure occurred. Look into the ekomi-errors-logfile in the export-directory for further information.');
/* EOF GM*/

//NEW
define('TITLE_RECREATE_ORDER', 'Recreate Order Acceptance');
define('HEADING_TITLE_SEARCH_INVOICE', 'Invoice ID:');
define('TITLE_ORDER_CONFIRMATION',		'Order Confirmation');
define('TITLE_SEND_ORDER_CONFIRMATION', 'Send Order Confirmation');
define('TEXT_PPNOTIFICATION_LOADING','The PayPal payment information are loading.<br />The charging process stops after 60 seconds.<br />Please note, in this case, the notice.');
define('TEXT_PPNOTIFICATION_ERROR','There is a connection problem with PayPal.<br />The payment information can not be loaded.<br />Please try again later.');
define('BUTTON_PP_RELOAD', 'reload');
?>