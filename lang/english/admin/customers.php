<?php
/* --------------------------------------------------------------
   customers.php 2008-08-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(customers.php,v 1.13 2002/06/15); www.oscommerce.com 
   (c) 2003	 nextcommerce (customers.php,v 1.8 2003/08/15); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: customers.php 1295 2005-10-08 16:59:56Z mz $)

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'Customers');
define('HEADING_TITLE_SEARCH', 'Search:');

// BOF GM_MOD
define('HEADING_SUB_TITLE', 'Customers');
// EOF GM_MOD

define('TABLE_HEADING_FIRSTNAME', 'First Name');
define('TABLE_HEADING_LASTNAME', 'Last Name');
define('TABLE_HEADING_ACCOUNT_CREATED', 'Account Created');
define('TABLE_HEADING_ACTION', 'Action');
define('TEXT_MARKED_ELEMENTS','Marked Element');
define('TEXT_DATE_ACCOUNT_CREATED', 'Account Created:');
define('TEXT_DATE_ACCOUNT_LAST_MODIFIED', 'Last Modified:');
define('TEXT_INFO_DATE_LAST_LOGON', 'Last Logon:');
define('TEXT_INFO_NUMBER_OF_LOGONS', 'Number of Logons:');
define('TEXT_INFO_COUNTRY', 'Country:');
define('TEXT_INFO_NUMBER_OF_REVIEWS', 'Number of Reviews:');
define('TEXT_DELETE_INTRO', 'Are you sure you want to delete this customer?');
define('TEXT_DELETE_REVIEWS', 'Delete %s review(s)');
define('TEXT_INFO_HEADING_DELETE_CUSTOMER', 'Delete Customer');
define('TYPE_BELOW', 'Type below');
define('PLEASE_SELECT', 'Select One');
define('HEADING_TITLE_STATUS','Customer Group');
define('TEXT_ALL_CUSTOMERS','All Groups');
define('TEXT_INFO_HEADING_STATUS_CUSTOMER','Customer Group');
define('TABLE_HEADING_NEW_VALUE','New Status');
define('TABLE_HEADING_DATE_ADDED','Date');
define('TEXT_NO_CUSTOMER_HISTORY','--no modification yet--');
define('TABLE_HEADING_GROUPIMAGE','Icon');
define('ENTRY_MEMO','Memo');
define('TEXT_DATE','Date');
define('TEXT_TITLE','Title');
define('TEXT_POSTER','Poster');
define('ENTRY_PASSWORD_CUSTOMER','Password:');
define('TEXT_SELECT','--Select--');
define('TABLE_HEADING_ACCOUNT_TYPE','Account');
define('TEXT_ACCOUNT','Yes');
define('TEXT_GUEST','No');
define('NEW_ORDER','New order ?');
define('ENTRY_PAYMENT_UNALLOWED','Unallowed payment modules:');
define('ENTRY_SHIPPING_UNALLOWED','Unallowed shipping modules:');
define('ENTRY_NEW_PASSWORD','New Password:');
define('TEXT_CUSTOMERS_ID', 'Customer ID');
define('ALL', 'All');

define('GM_TITLE_CUSTOMER_UPLOAD_FILE_DELETE',	'delete');
define('GM_TITLE_CUSTOMER_UPLOAD_FIELDS',		'File-Upload at Registration');
define('GM_TITLE_CUSTOMER_UPLOAD_FIELD',		'Upload-File');
define('GM_TITLE_CUSTOMER_UPLOAD_FILE',			'There are no Files');
define('GM_TITLE_CUSTOMER_UPLOAD_EMPTY',		'There are no Files and no Upload Fields defined');
?>