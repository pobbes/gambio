<?php
/* --------------------------------------------------------------
   customers_status.php 2008-08-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(customers.php,v 1.76 2003/05/04); www.oscommerce.com
   (c) 2003	 nextcommerce (customers_status.php,v 1.12 2003/08/14); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: customers_status.php 1062 2005-07-21 19:57:29Z gwinger $)

   Released under the GNU General Public License
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'Customer Groups');
define('ENTRY_CUSTOMERS_FSK18','Lock buy function for FSK18 products?');
define('ENTRY_CUSTOMERS_FSK18_DISPLAY','Display FSK18 products?');
define('ENTRY_CUSTOMERS_STATUS_ADD_TAX','Show tax in order total');
define('ENTRY_CUSTOMERS_STATUS_MIN_ORDER','Minimum order value:');
define('ENTRY_CUSTOMERS_STATUS_MAX_ORDER','Maximum order value:');
define('ENTRY_CUSTOMERS_STATUS_BT_PERMISSION','Via Bank Collection');
define('ENTRY_CUSTOMERS_STATUS_CC_PERMISSION','Via Credit Card');
define('ENTRY_CUSTOMERS_STATUS_COD_PERMISSION','Via Cash on Delivery');
define('ENTRY_CUSTOMERS_STATUS_DISCOUNT_ATTRIBUTES','Discount');
define('ENTRY_CUSTOMERS_STATUS_PAYMENT_UNALLOWED','Enter unallowed payment methods');
define('ENTRY_CUSTOMERS_STATUS_PUBLIC','Public');
define('ENTRY_CUSTOMERS_STATUS_SHIPPING_UNALLOWED','Enter unallowed shipping modules');
define('ENTRY_CUSTOMERS_STATUS_SHOW_PRICE','Price');
define('ENTRY_CUSTOMERS_STATUS_SHOW_PRICE_TAX','Prices incl. tax');
define('ENTRY_CUSTOMERS_STATUS_WRITE_REVIEWS','Customer group is allowed to write reviews:');
define('ENTRY_CUSTOMERS_STATUS_READ_REVIEWS','Customer group is allowed to read reviews:');
define('ENTRY_GRADUATED_PRICES','Graduated Prices');
define('ENTRY_NO','No');
define('ENTRY_OT_XMEMBER', 'Customer discount on order total?:');
define('ENTRY_YES','Yes');
define('TEXT_MARKED_ELEMENTS','Marked Element');

define('ERROR_REMOVE_DEFAULT_CUSTOMER_STATUS', 'Error: You cannot delete the default customer group. Please set another group to the default customer group and try again.');
define('ERROR_REMOVE_DEFAULT_CUSTOMERS_STATUS','ERROR! You cannot delete a default group');
define('ERROR_STATUS_USED_IN_CUSTOMERS', 'Error: This customer group is currently being used.');
define('ERROR_STATUS_USED_IN_HISTORY', 'Error: This customer group is currently being used in the order summary.');

define('YES','yes');
define('NO','no');

define('TABLE_HEADING_ACTION','Action');
define('TABLE_HEADING_CUSTOMERS_GRADUATED','Graduated Price');
define('TABLE_HEADING_CUSTOMERS_STATUS','Customer Group');
define('TABLE_HEADING_CUSTOMERS_UNALLOW','unallowed payment methods');
define('TABLE_HEADING_CUSTOMERS_UNALLOW_SHIPPING','unallowed shipping modules');
define('TABLE_HEADING_DISCOUNT','Discount');
define('TABLE_HEADING_TAX_PRICE','Price / Tax');

define('TAX_NO','excl');
define('TAX_YES','incl');

define('TEXT_DISPLAY_NUMBER_OF_CUSTOMERS_STATUS', 'Existing customer groups:');

define('TEXT_INFO_CUSTOMERS_FSK18_DISPLAY_INTRO','<b>FSK18 Products</b>');
define('TEXT_INFO_CUSTOMERS_FSK18_INTRO','<b>FSK18 Lock</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_ADD_TAX_INTRO','<b>If prices incl. tax = set to "No"</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_MIN_ORDER_INTRO','Define a minimum order value or leave the field blank.');
define('TEXT_INFO_CUSTOMERS_STATUS_MAX_ORDER_INTRO','Define a maximum order value or leave the field blank.');
define('TEXT_INFO_CUSTOMERS_STATUS_BT_PERMISSION_INTRO', '<b>Allow customers in this group to pay via bank collection?</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_CC_PERMISSION_INTRO', '<b>Allow customers in this group to pay with credit cards?</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_COD_PERMISSION_INTRO', '<b>Allow customers in this group to pay COD?</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_ATTRIBUTES_INTRO','<b>Discount on product attributes</b><br>(Max. % discount on single product)');
define('TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_OT_XMEMBER_INTRO','<b>Discount on total order</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_PRICE', 'Discount (0 to 100%):');
define('TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_PRICE_INTRO', 'Please define a discount between 0 and 100% to be used on each product displayed.');
define('TEXT_INFO_CUSTOMERS_STATUS_GRADUATED_PRICES_INTRO','<b>Graduated Prices</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_IMAGE', 'Customer group image:');
define('TEXT_INFO_CUSTOMERS_STATUS_NAME','<b>Group name</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_PAYMENT_UNALLOWED_INTRO','<b>unallowed payment methods</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_PUBLIC_INTRO','<b>Show Public?</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_SHIPPING_UNALLOWED_INTRO','<b>unallowed shipping modules</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_SHOW_PRICE_INTRO','<b>Show price in store</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_SHOW_PRICE_TAX_INTRO', 'Do you want to display prices including or excluding tax?');
define('TEXT_INFO_CUSTOMERS_STATUS_WRITE_REVIEWS_INTRO','<b>Write product reviews</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_READ_REVIEWS_INTRO', '<b>Read product reviews</b>');

define('TEXT_INFO_DELETE_INTRO', 'Are you sure you want to delete this customer group?');
define('TEXT_INFO_EDIT_INTRO', 'Please make all neccessary changes');
define('TEXT_INFO_INSERT_INTRO', 'Please create a new customer group with the required values.');

define('TEXT_INFO_HEADING_DELETE_CUSTOMERS_STATUS', 'Delete Customer Group');
define('TEXT_INFO_HEADING_EDIT_CUSTOMERS_STATUS','Edit Group Data');
define('TEXT_INFO_HEADING_NEW_CUSTOMERS_STATUS', 'New Customer Group');

define('TEXT_INFO_CUSTOMERS_STATUS_BASE', '<b>Base customer group for product prices</b>');
define('ENTRY_CUSTOMERS_STATUS_BASE', 'will be selected as the basis for the prices for the new customer group. If choice = Admin, no prices will be set for the new customer group.');

include(DIR_FS_LANGUAGES . $_SESSION['language'] . '/admin/gm_customers_status.php');

?>