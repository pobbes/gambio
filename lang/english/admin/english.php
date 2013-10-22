<?php
/* --------------------------------------------------------------
   english.php 2012-08-10 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(german.php,v 1.99 2003/05/28); www.oscommerce.com
   (c) 2003	 nextcommerce (german.php,v 1.24 2003/08/24); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: english.php 1231 2005-09-21 13:05:36Z mz $)

   Released under the GNU General Public License
   --------------------------------------------------------------
   Third Party contributions:
   Customers Status v3.x (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

   Released under the GNU General Public License
   --------------------------------------------------------------*/

// look in your $PATH_LOCALE/locale directory for available locales..
// on RedHat6.0 I used 'en_US'
// on FreeBSD 4.0 I use 'en_US.ISO_8859-1'
// this may not work under win32 environments..

setlocale(LC_TIME, 'en_US@euro', 'en_US', 'en-US', 'en', 'en_US.ISO_8859-1', 'English','en_US.ISO_8859-15');
define('DATE_FORMAT_SHORT', '%m/%d/%Y');  // this is used for strftime()
define('DATE_FORMAT_LONG', '%A %d %B, %Y'); // this is used for strftime()
define('DATE_FORMAT', 'm/d/Y');  // this is used for strftime()
define('PHP_DATE_TIME_FORMAT', 'm/d/Y H:i:s'); // this is used for date()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');

////
// Return date in raw format
// $date should be in format mm/dd/yyyy
// raw date is in format YYYYMMDD, or DDMMYYYY
function xtc_date_raw($date, $reverse = false) {
  if ($reverse) {
    return substr($date, 3, 2) . substr($date, 0, 2) . substr($date, 6, 4);
  } else {
    return substr($date, 6, 4) . substr($date, 0, 2) . substr($date, 3, 2);
  }
}

// Global entries for the <html> tag
define('HTML_PARAMS','dir="ltr" lang="en"');


// page title
define('TITLE', 'Gambio GX2 Administration');

// header text in includes/header.php
define('HEADER_TITLE_TOP', 'Administration');
define('HEADER_TITLE_SUPPORT_SITE', 'Support Site');
define('HEADER_TITLE_ONLINE_CATALOG', 'Online Catalog');
define('HEADER_TITLE_ADMINISTRATION', 'Administration');

// text for gender
define('MALE', 'Male');
define('FEMALE', 'Female');

// text for date of birth example
define('DOB_FORMAT_STRING', 'mm/dd/yyyy');

// configuration box text in includes/boxes/configuration.php
define('BOX_HEADING_CONFIGURATION','Configuration');
define('BOX_HEADING_MODULES','Modules');
define('BOX_HEADING_ZONE','Zone / Tax');
define('BOX_HEADING_CUSTOMERS','Customers');
define('BOX_HEADING_PRODUCTS','Catalog');
define('BOX_HEADING_STATISTICS','Statistics');
define('BOX_HEADING_TOOLS','Toolbox');

define('BOX_CONTENT','Content Manager');
define('TEXT_ALLOWED', 'Permission');
define('TEXT_ACCESS', 'Useable Area');
define('BOX_CONFIGURATION', 'General Options');
define('BOX_API_TOOL', 'Get now API-Signatur from PayPal');
define('BOX_PAYPAL_EXPRESS_HINT', 'Hint:<br />The use of PayPal Express in conjunction with credit and download articles is not technically possible!<br />This means that the buyer choose the credit can not pay process and download articles can not be paid with PayPal Express!');
define('BOX_CONFIGURATION_1', 'My Shop');
define('BOX_CONFIGURATION_2', 'Minimum Values');
define('BOX_CONFIGURATION_3', 'Maximum Values');
define('BOX_CONFIGURATION_4', 'Image Options');
define('BOX_CONFIGURATION_5', 'Customer Details');
define('BOX_CONFIGURATION_6', 'Module Options');
define('BOX_CONFIGURATION_7', 'Shipping Options');
define('BOX_CONFIGURATION_8', 'Product Listing Options');
define('BOX_CONFIGURATION_9', 'Stock Options');
define('BOX_CONFIGURATION_10', 'Logging Options');
define('BOX_CONFIGURATION_11', 'Cache Options');
define('BOX_CONFIGURATION_12', 'Email Options');
define('BOX_CONFIGURATION_13', 'Download Options');
define('BOX_CONFIGURATION_14', 'Gzip Compression');
define('BOX_CONFIGURATION_15', 'Sessions');
define('BOX_CONFIGURATION_16', 'Search Engines');
define('BOX_CONFIGURATION_17', 'Special Modules');
define('BOX_CONFIGURATION_19', 'Interfaces');
define('BOX_CONFIGURATION_21', 'Interfaces');
define('BOX_CONFIGURATION_22', 'Search Options');
define('BOX_CONFIGURATION_25', 'Interfaces');
define('BOX_CONFIGURATION_26', 'brickfox Connect');
define('BOX_CONFIGURATION_31', 'Moneybookers');
define('BOX_CONFIGURATION_753', 'Shop-Key');
define('BOX_CONFIGURATION_32', 'Skrill');

define('BOX_MODULES', 'Payment/Shipping/Billing Modules');
define('BOX_PAYMENT', 'Payment Systems');
define('BOX_SHIPPING', 'Shipping Methods');
define('BOX_ORDER_TOTAL', 'Order Total');
define('BOX_CATEGORIES', 'Categories / Products');
define('BOX_PRODUCTS_ATTRIBUTES', 'Product Options');
define('BOX_MANUFACTURERS', 'Manufacturers');
define('BOX_REVIEWS', 'Product Reviews');
define('BOX_CAMPAIGNS', 'Campaigns');
define('BOX_XSELL_PRODUCTS', 'Cross-selling');
define('BOX_SPECIALS', 'Special Pricing');
define('BOX_PRODUCTS_EXPECTED', 'Expected Offers');
define('BOX_CUSTOMERS', 'Customers');
define('BOX_ACCOUNTING', 'Admin Permissions');
define('BOX_CUSTOMERS_STATUS','Customer Groups');
define('BOX_ORDERS', 'Orders');
define('BOX_COUNTRIES', 'Countries');
define('BOX_ZONES', 'Zones');
define('BOX_GEO_ZONES', 'Tax Zones');
define('BOX_TAX_CLASSES', 'Tax Classes');
define('BOX_TAX_RATES', 'Tax Rates');
define('BOX_HEADING_REPORTS', 'Reports');
define('BOX_PRODUCTS_VIEWED', 'Viewed Products');
define('BOX_STOCK_WARNING','Stock Info');
define('BOX_PRODUCTS_PURCHASED', 'Sold Products');
define('BOX_STATS_CUSTOMERS', 'Purchasing Statistics');
define('BOX_BACKUP', 'Database Manager');
define('BOX_BANNER_MANAGER', 'Banner Manager');
define('BOX_CACHE', 'Cache Control');
define('BOX_DEFINE_LANGUAGE', 'Language Definitions');
define('BOX_FILE_MANAGER', 'File Manager');
define('BOX_MAIL', 'Email Center');
define('BOX_NEWSLETTERS', 'Notification Manager');
define('BOX_SERVER_INFO', 'Server Info');
define('BOX_WHOS_ONLINE', 'Who is Online');
define('BOX_SHOW_LOGS', 'Show logs');
define('BOX_CLEAR_CACHE', 'Clear Cache');
define('BOX_TPL_BOXES','Box Sort Order');
define('BOX_CURRENCIES', 'Currencies');
define('BOX_LANGUAGES', 'Languages');
define('BOX_ORDERS_STATUS', 'Order Status');
define('BOX_ATTRIBUTES_MANAGER','Attribute Manager');
define('BOX_PRODUCTS_ATTRIBUTES','Option Groups');
define('BOX_MODULE_NEWSLETTER','Newsletter');
define('BOX_ORDERS_STATUS','Orders Status');
define('BOX_SHIPPING_STATUS','Shipping status');
define('BOX_SALES_REPORT','Sales Report');
define('BOX_MODULE_EXPORT','Modules-Center');
define('BOX_HEADING_GV_ADMIN', 'Vouchers');
define('BOX_GV_ADMIN_QUEUE', 'Gift Voucher Queue');
define('BOX_GV_ADMIN_MAIL', 'Mail Gift Voucher');
define('BOX_GV_ADMIN_SENT', 'Gift Vouchers sent');
define('BOX_COUPON_ADMIN','Coupon Admin');
define('BOX_TOOLS_BLACKLIST','CC Blacklist');
define('BOX_IMPORT','Import/Export');
define('BOX_PRODUCTS_VPE','Packing Unit');
define('BOX_CAMPAIGNS_REPORT','Campaign Report');
define('BOX_ORDERS_XSELL_GROUP','Cross-sell Groups');
define('BOX_HEADING_XTBOOSTER','eBay');
define('BOX_XTBOOSTER_LISTAUCTIONS','List eBay Auctions');
define('BOX_XTBOOSTER_ADDAUCTIONS','Add eBay Auctions');
define('BOX_XTBOOSTER_CONFIG','xt:booster Configuration');
define('BOX_GM_JANOLAW','janolaw AGB Hosting');
/******* SHOPGATE **********/
include_once DIR_FS_CATALOG.'/shopgate/gambiogx/lang/english/admin/english.php';
/******* SHOPGATE **********/

/* BOF YATEGO */
define('BOX_YATEGO','Yatego');
/* EOF YATEGO */

define('TXT_GROUPS','<b>Groups</b>:');
define('TXT_SYSTEM','System');
define('TXT_CUSTOMERS','Customers/Orders');
define('TXT_PRODUCTS','Products/Categories');
define('TXT_STATISTICS','Statistics');
define('TXT_TOOLS','Tools');
define('TEXT_ACCOUNTING','Admin access for:');

//Dividers text for menu

define('BOX_HEADING_MODULES', 'Modules');
define('BOX_HEADING_LOCALIZATION', 'Languages/Currencies');
define('BOX_HEADING_TEMPLATES','Templates');
define('BOX_HEADING_TOOLS', 'Tools');
define('BOX_HEADING_LOCATION_AND_TAXES', 'Location / Tax');
define('BOX_HEADING_CUSTOMERS', 'Customers');
define('BOX_HEADING_CATALOG', 'Catalog');
define('BOX_MODULE_NEWSLETTER','Newsletter');

// javascript messages
define('JS_ERROR', 'An error has occured during the processing of your form!\nPlease make the following corrections:\n\n');

define('JS_OPTIONS_VALUE_PRICE', '* The new product attribute requires a price value\n');
define('JS_OPTIONS_VALUE_PRICE_PREFIX', '* The new product attribute requires a price prefix (+/-)\n');

define('JS_PRODUCTS_NAME', '* The new product requires a name\n');
define('JS_PRODUCTS_DESCRIPTION', '* The new product requires a description\n');
define('JS_PRODUCTS_PRICE', '* The new product requires a price value\n');
define('JS_PRODUCTS_WEIGHT', '* The new product requires a weight value\n');
define('JS_PRODUCTS_QUANTITY', '* The new product requires a quantity value\n');
define('JS_PRODUCTS_MODEL', '* The new product requires a model value\n');
define('JS_PRODUCTS_IMAGE', '* The new product requires an image value\n');

define('JS_SPECIALS_PRODUCTS_PRICE', '* A new price for this product must be set\n');

define('JS_GENDER', '* The \'Gender\' value must be chosen.\n');
define('JS_FIRST_NAME', '* The \'First Name\' entry must have at least ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' characters.\n');
define('JS_LAST_NAME', '* The \'Last Name\' entry must have at least ' . ENTRY_LAST_NAME_MIN_LENGTH . ' characters.\n');
define('JS_DOB', '* The \'Date of Birth\' entry must be in the format: xx/xx/xxxx (month/date/year).\n');
define('JS_EMAIL_ADDRESS', '* The \'Email Address\' entry must have at least ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' characters.\n');
define('JS_ADDRESS', '* The \'Street Address\' entry must have at least ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' characters.\n');
define('JS_POST_CODE', '* The \'ZIP Code\' entry must have at least ' . ENTRY_POSTCODE_MIN_LENGTH . ' characters.\n');
define('JS_CITY', '* The \'City\' entry must have at least ' . ENTRY_CITY_MIN_LENGTH . ' characters.\n');
define('JS_STATE', '* The \'State\' entry must be selected.\n');
define('JS_STATE_SELECT', '-- Select above --');
define('JS_ZONE', '* The \'State\' entry must be selected from the list for this country.');
define('JS_COUNTRY', '* The \'Country\' value must be chosen.\n');
define('JS_TELEPHONE', '* The \'Telephone Number\' entry must have at least ' . ENTRY_TELEPHONE_MIN_LENGTH . ' characters.\n');
define('JS_PASSWORD', '* The \'Password\' and \'Confirmation\' entries must match and have at least ' . ENTRY_PASSWORD_MIN_LENGTH . ' characters.\n');

define('JS_ORDER_DOES_NOT_EXIST', 'Order Number %s does not exist!');

define('CATEGORY_PERSONAL', 'Personal');
define('CATEGORY_ADDRESS', 'Address');
define('CATEGORY_CONTACT', 'Contact');
define('CATEGORY_COMPANY', 'Company');
define('CATEGORY_OPTIONS', 'More Options');

define('ENTRY_GENDER', 'Gender:');
define('ENTRY_GENDER_ERROR', '&nbsp;<span class="errorText">required</span>');
define('ENTRY_FIRST_NAME', 'First Name:');
define('ENTRY_FIRST_NAME_ERROR', '&nbsp;<span class="errorText">min. ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' chars</span>');
define('ENTRY_LAST_NAME', 'Last Name:');
define('ENTRY_LAST_NAME_ERROR', '&nbsp;<span class="errorText">min. ' . ENTRY_LAST_NAME_MIN_LENGTH . ' chars</span>');
define('ENTRY_DATE_OF_BIRTH', 'Date of Birth:');
define('ENTRY_DATE_OF_BIRTH_ERROR', '&nbsp;<span class="errorText">(e.g. 05/21/1970)</span>');
define('ENTRY_EMAIL_ADDRESS', 'Email Address:');
define('ENTRY_EMAIL_ADDRESS_ERROR', '&nbsp;<span class="errorText">min. ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' chars</span>');
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', '&nbsp;<span class="errorText">Invalid email address!</span>');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', '&nbsp;<span class="errorText">This email address already exists!</span>');
define('ENTRY_COMPANY', 'Company Name:');
define('ENTRY_STREET_ADDRESS', 'Street Address:');
define('ENTRY_STREET_ADDRESS_ERROR', '&nbsp;<span class="errorText">min. ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' Chars</span>');
define('ENTRY_SUBURB', 'Suburb:');
define('ENTRY_POST_CODE', 'Postcode (ZIP):');
define('ENTRY_POST_CODE_ERROR', '&nbsp;<span class="errorText">min. ' . ENTRY_POSTCODE_MIN_LENGTH . ' chars</span>');
define('ENTRY_CITY', 'City:');
define('ENTRY_CITY_ERROR', '&nbsp;<span class="errorText">min. ' . ENTRY_CITY_MIN_LENGTH . ' chars</span>');
define('ENTRY_STATE', 'State:');
define('ENTRY_STATE_ERROR', '&nbsp;<span class="errorText">required</font></small>');
define('ENTRY_COUNTRY', 'County:');
define('ENTRY_TELEPHONE_NUMBER', 'Telephone Number:');
define('ENTRY_TELEPHONE_NUMBER_ERROR', '&nbsp;<span class="errorText">min. ' . ENTRY_TELEPHONE_MIN_LENGTH . ' chars</span>');
define('ENTRY_FAX_NUMBER', 'Fax Number:');
define('ENTRY_NEWSLETTER', 'Newsletter:');
define('ENTRY_CUSTOMERS_STATUS', 'Customer Status:');
define('ENTRY_NEWSLETTER_YES', 'Subscribed');
define('ENTRY_NEWSLETTER_NO', 'Unsubscribed');
define('ENTRY_MAIL_ERROR','&nbsp;<span class="errorText">Please choose an option</span>');
define('ENTRY_PASSWORD','Password (generated)');
define('ENTRY_PASSWORD_ERROR','&nbsp;<span class="errorText">min. ' . ENTRY_PASSWORD_MIN_LENGTH . ' chars</span>');
define('ENTRY_MAIL_COMMENTS','additional email text:');

define('ENTRY_MAIL','Send email with password to customer?');
define('YES','yes');
define('NO','no');
define('SAVE_ENTRY','Save changes?');
define('TEXT_CHOOSE_INFO_TEMPLATE','Template for product details');
define('TEXT_CHOOSE_OPTIONS_TEMPLATE','Template for product options');
define('TEXT_SELECT','-- Please Select --');

// Icons
define('ICON_CROSS', 'False');
define('ICON_CURRENT_FOLDER', 'Current Folder');
define('ICON_DELETE', 'Delete');
define('ICON_ERROR', 'Error');
define('ICON_FILE', 'File');
define('ICON_FILE_DOWNLOAD', 'Download');
define('ICON_FOLDER', 'Folder');
define('ICON_LOCKED', 'Locked');
define('ICON_PREVIOUS_LEVEL', 'Previous Level');
define('ICON_PREVIEW', 'Preview');
define('ICON_STATISTICS', 'Statistics');
define('ICON_SUCCESS', 'Success');
define('ICON_TICK', 'True');
define('ICON_UNLOCKED', 'Unlocked');
define('ICON_WARNING', 'Warning');

// constants for use in tep_prev_next_display function
define('TEXT_RESULT_PAGE', 'Page %s of %d');
define('TEXT_DISPLAY_NUMBER_OF_BANNERS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> banners)');
define('TEXT_DISPLAY_NUMBER_OF_COUNTRIES', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> countries)');
define('TEXT_DISPLAY_NUMBER_OF_CUSTOMERS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> customers)');
define('TEXT_DISPLAY_NUMBER_OF_CURRENCIES', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> currencies)');
define('TEXT_DISPLAY_NUMBER_OF_LANGUAGES', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> languages)');
define('TEXT_DISPLAY_NUMBER_OF_MANUFACTURERS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> manufacturers)');
define('TEXT_DISPLAY_NUMBER_OF_NEWSLETTERS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> newsletters)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> orders)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS_STATUS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> orders status)');
define('TEXT_DISPLAY_NUMBER_OF_XSELL_GROUP', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> cross-sell groups)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_VPE', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> packing units)');
define('TEXT_DISPLAY_NUMBER_OF_SHIPPING_STATUS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> shipping status)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> products)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_EXPECTED', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> products expected)');
define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> reviews)');
define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> products on special)');
define('TEXT_DISPLAY_NUMBER_OF_TAX_CLASSES', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> tax classes)');
define('TEXT_DISPLAY_NUMBER_OF_TAX_ZONES', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> tax zones)');
define('TEXT_DISPLAY_NUMBER_OF_TAX_RATES', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> tax rates)');
define('TEXT_DISPLAY_NUMBER_OF_ZONES', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> zones)');

define('PREVNEXT_BUTTON_PREV', '&lt;&lt;');
define('PREVNEXT_BUTTON_NEXT', '&gt;&gt;');

define('TEXT_DEFAULT', 'Default');
define('TEXT_SET_DEFAULT', 'Set as default');
define('TEXT_FIELD_REQUIRED', '&nbsp;<span class="fieldRequired">* Required</span>');

define('ERROR_NO_DEFAULT_CURRENCY_DEFINED', 'Error: There is currently no default currency set. Please set a currency in: Administration Tool -> Localization -> Currencies');

define('TEXT_CACHE_CATEGORIES', 'Categories Box');
define('TEXT_CACHE_MANUFACTURERS', 'Manufacturer Box');
define('TEXT_CACHE_ALSO_PURCHASED', 'Also Purchased Module');

define('TEXT_NONE', '--none--');
define('TEXT_TOP', 'Top');

define('ERROR_DESTINATION_DOES_NOT_EXIST', 'Error: Destination does not exist.');
define('ERROR_DESTINATION_NOT_WRITEABLE', 'Error: Destination is not writeable.');
define('ERROR_FILE_NOT_SAVED', 'Error: File upload not saved.');
define('ERROR_FILETYPE_NOT_ALLOWED', 'Error: File upload type not allowed.');
define('SUCCESS_FILE_SAVED_SUCCESSFULLY', 'Success: File upload saved successfully.');
define('WARNING_NO_FILE_UPLOADED', 'Warning: No file uploaded.');

define('DELETE_ENTRY','Delete entry?');
define('TEXT_PAYMENT_ERROR','<b>WARNING:</b><br />Please activate a payment module!');
define('TEXT_SHIPPING_ERROR','<b>WARNING:</b><br />Please activate a shipping module!');

define('TEXT_NETTO','no tax: ');

define('ENTRY_CID','Customer ID:');
define('IP','Order IP:');
define('CUSTOMERS_MEMO','Memos:');
define('DISPLAY_MEMOS','Show/Write');
define('TITLE_MEMO','Customer MEMO');
define('ENTRY_LANGUAGE','Language:');
define('CATEGORIE_NOT_FOUND','Category not found!');

define('IMAGE_RELEASE', 'Redeem Gift Voucher');

define('_JANUARY', 'January');
define('_FEBRUARY', 'February');
define('_MARCH', 'March');
define('_APRIL', 'April');
define('_MAY', 'May');
define('_JUNE', 'June');
define('_JULY', 'July');
define('_AUGUST', 'August');
define('_SEPTEMBER', 'September');
define('_OCTOBER', 'October');
define('_NOVEMBER', 'November');
define('_DECEMBER', 'December');

define('TEXT_DISPLAY_NUMBER_OF_GIFT_VOUCHERS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> gift vouchers)');
define('TEXT_DISPLAY_NUMBER_OF_COUPONS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> coupons)');

define('TEXT_VALID_PRODUCTS_LIST', 'Product List');
define('TEXT_VALID_PRODUCTS_ID', 'Product ID');
define('TEXT_VALID_PRODUCTS_NAME', 'Product Name');
define('TEXT_VALID_PRODUCTS_MODEL', 'Product Model');

define('TEXT_VALID_CATEGORIES_LIST', 'Categories List');
define('TEXT_VALID_CATEGORIES_ID', 'Category ID');
define('TEXT_VALID_CATEGORIES_NAME', 'Category Name');

define('SECURITY_CODE_LENGTH_TITLE', 'Length of Gift Voucher Code');
define('SECURITY_CODE_LENGTH_DESC', 'Enter the length of the gift voucher code here (max. 16 characters)');

define('NEW_SIGNUP_GIFT_VOUCHER_AMOUNT_TITLE', 'Welcome Gift Voucher Amount');
define('NEW_SIGNUP_GIFT_VOUCHER_AMOUNT_DESC', 'Welcome Gift Voucher Amount: If you do not wish to send a gift voucher in your create account email, enter 0 for no amount or enter the amount here, i.e. 10.00 or 50.00, and use no currency signs');
define('NEW_SIGNUP_DISCOUNT_COUPON_TITLE', 'Welcome Discount Coupon Code');
define('NEW_SIGNUP_DISCOUNT_COUPON_DESC', 'Welcome Discount Coupon Code: if you do not want to send a discount coupon in your create account email, leave this field blank or enter the coupon code here that you wish to use');

define('TXT_ALL','All');

// UST ID
define('BOX_CONFIGURATION_18', 'VAT No.');
define('HEADING_TITLE_VAT','VAT No.');
define('HEADING_TITLE_VAT','VAT No.');
define('ENTRY_VAT_ID','VAT No.');
define('TEXT_VAT_FALSE','<font color="#FF0000">Checked/False!</font>');
define('TEXT_VAT_TRUE','<font color="#FF0000">Checked/True!</font>');
define('TEXT_VAT_UNKNOWN_COUNTRY','<font color="#FF0000">Not Checked/Unknown Country!</font>');
define('TEXT_VAT_UNKNOWN_ALGORITHM','<font color="#FF0000">Not Checked/No Check available!</font>');
define('ENTRY_VAT_ID_ERROR', '<font color="#FF0000">* Your VAT No. is incorrect!</font>');

define('ERROR_GIF_MERGE','Missing GDlib gif support, merge failed');
define('ERROR_GIF_UPLOAD','Missing GDlib gif support, processing of gif image failed');

define('TEXT_REFERER','Referrer: ');

define('BOX_PAYPAL','PayPal');


define('GM_QUICK_SEARCH_INVOICE_ID', 'INVOICE NO');

define('GM_QUICK_SEARCH', 'Quick Search');
define('GM_QUICK_SEARCH_CUSTOMER', 'CUSTOMER');
define('GM_QUICK_SEARCH_ORDER_ID', 'ORDER NO');
define('GM_QUICK_SEARCH_ARTICLE', 'PRODUCT');

define('GM_TOP_MENU_CREDITS', 'Credits');
define('GM_TOP_MENU_START', 'Start');
define('GM_TOP_MENU_SHOP', 'Shop');
define('GM_TOP_MENU_PREVIEW', 'Preview');
define('GM_TOP_MENU_LOGOUT', 'Log out');
define('GM_TOP_MENU_CLEARCACHE', 'Clear cache');
define('GM_TOP_MENU_CLEARCACHE_HINT', 'You have made changes that may affect the page output in the shop.<br />Empty the page output cache to make the changes visible in the shop.');
define('GM_TOP_MENU_CACHE_EMPTIED', 'Cache has been emptied!');

// BOF GM_MOD
include(DIR_FS_LANGUAGES . 'english/admin/gm_english.php');
// EOF GM_MOD


// NEW
define('BOX_HEADING_COUPON_ADMIN','Discount Coupon');
define('TEXT_NEWSLETTER_REMOVE', 'to unsubscribe to a newsletter, click here:');
define('ENTRY_CUSTOMERS_VAT_ID', 'VAT No.:');

/* BOF GM MONEYBOOKERS */
define('_PAYMENT_MONEYBOOKERS_EMAILID_TITLE','Moneybookers E-Mail Adresse');
define('_PAYMENT_MONEYBOOKERS_EMAILID_DESC','E-Mail Adresse mitwelcher Sie bei Moneybookers.com registriert sind.<br />Wenn Sie noch &uuml;ber kein Konto verf&uuml;gen, <b>melden Sie sich</b> jetzt bei <a href="https://www.moneybookers.com/app/register.pl" target="_blank"><b>Moneybookers</b></a> <b>gratis</b> an.');
define('_PAYMENT_MONEYBOOKERS_MERCHANTID_TITLE','Moneybookers H&auml;ndler ID');
define('_PAYMENT_MONEYBOOKERS_MERCHANTID_DESC','Ihre Moneybookers.com H&auml;ndler ID');
define('_PAYMENT_MONEYBOOKERS_PWD_TITLE','Moneybookers Geheimwort');
define('_PAYMENT_MONEYBOOKERS_PWD_DESC','Mit der Eingabe des Geheimwortes wird die Verbindung beim Bezahlvorgang verschl&uuml;sselt. So wird h&ouml;chste Sicherheit gew&auml;hrleistet. Geben Sie Ihr Moneybookers Geheimwort ein (dies ist nicht ihr Passwort!). Das Geheimwort darf nur aus Kleinbuchstaben und Zahlen bestehen. Sie k&ouml;nnen Ihr Geheimwort <b><font color="red">nach der Freischaltung</b></font> in Ihrem Moneybookers-Benutzerkonto definieren. (H&auml;ndlereinstellungen).<br /><br />
<font color="red">So schalten Sie Ihren Moneybookers.com Account f&uuml;er die Gambio Zahlungsabwicklung frei!</font><br /><br />

Senden Sie eine E-Mail mit:<br/>
- Ihrer Shopdomain<br/>
- Ihrer Moneybookers E-Mail-Adresse<br /><br />

An: <a href="mailto:ecommerce@moneybookers.com?subject=Gambio: Aktivierung fuer Moneybookers Quick Checkout">ecommerce@moneybookers.com</a>

');
define('_PAYMENT_MONEYBOOKERS_TMP_STATUS_ID_TITLE','Bestellstatus - Zahlungsvorgang');
define('_PAYMENT_MONEYBOOKERS_TMP_STATUS_ID_DESC',' Sobald der Kunde im Shop auf "Bestellung absenden" dr&uuml;ckt, wird von Gambio eine "Tempor&auml;re Bestellung" angelegt. Dies hat den Vorteil, dass bei Kunden die den Zahlungsvorgang bei Moneybookes abbrechen eine Bestellung aufgezeichnet wurde.');
define('_PAYMENT_MONEYBOOKERS_PROCESSED_STATUS_ID_TITLE','Bestellstatus - Zahlung OK');
define('_PAYMENT_MONEYBOOKERS_PROCESSED_STATUS_ID_DESC','Erscheint, wenn die Zahlung von Moneybookers best&auml;tigt wurde.');
define('_PAYMENT_MONEYBOOKERS_PENDING_STATUS_ID_TITLE','Bestellstatus - Zahlung in Warteschleife');
define('_PAYMENT_MONEYBOOKERS_PENDING_STATUS_ID_DESC','');
define('_PAYMENT_MONEYBOOKERS_CANCELED_STATUS_ID_TITLE','Bestellstatus - Zahlung Storniert');
define('_PAYMENT_MONEYBOOKERS_CANCELED_STATUS_ID_DESC','Wird erscheinen, wenn z.B. eine Kreditkarte abgelehnt wurde');
define('MB_TEXT_MBDATE', 'Letzte Aktualisierung:');
define('MB_TEXT_MBTID', 'TR ID:');
define('MB_TEXT_MBERRTXT', 'Status:');
define('MB_ERROR_NO_MERCHANT','Es Existiert kein Moneybookers.com Account mit dieser E-Mail Adresse!');
define('MB_MERCHANT_OK','Moneybookers.com Account korrekt, H&auml;ndler ID %s von Moneybookers.com empfangen und gespeichert.');

define('MB_INFO','<img src="../images/icons/moneybookers/MBbanner.jpg" /><br /><br />Gambio k&ouml;nnen jetzt Kreditkarten, Lastschrift, Sofort&uuml;berweisung, Giropay sowie alle weiteren wichtigen lokalen Bezahloptionen direkt akzeptieren mit einer simplen Aktivierung im Shop. Mit Moneybookers als All-in-One-L&ouml;sung brauchen Sie dabei keine Einzelvertr&auml;ge pro Zahlart abzuschliesen. Sie brauchen lediglich einen <a href="https://www.moneybookers.com/app/register.pl" target="_blank"><b>kostenlosen Moneybookers Account</b></a> um alle wichtigen Bezahloptionen in Ihrem Shop zu akzeptieren. Zus&auml;tzliche Bezahlarten sind ohne Mehrkosten und das Modul beinhaltet <b>keine monatliche Fixkosten oder Installationskosten</b>.
<br /><br />
<b>Ihre Vorteile:</b><br />
-Die Akzeptanz der wichtigsten Bezahloptionen steigern Ihren Umsatz<br />
-Ein Anbieter reduziert Ihre Aufw&auml;nde und Ihre Kosten<br />
-Ihr Kunde bezahlt direkt und ohne Registrierungsprozedur<br />
-Ein-Klick-Aktivierung und Integration<br />
-Sehr attraktive <a href="http://www.moneybookers.com/app/help.pl?s=m_fees" target="_blank"><b>Konditionen</b></a> <br />
-sofortige Zahlungsbest&auml;tigung und Pr&uuml;fung der Kundendaten<br />
-Bezahlabwicklung auch im Ausland und ohne Mehrkosten<br />
-6 Millionen Kunden weltweit vertrauen Moneybookers');
/* EOF GM MONEYBOOKERS */

/* BOF GM SKRILL */
define('_PAYMENT_SKRILL_EMAILID_TITLE','Skrill E-Mail Adresse');
define('_PAYMENT_SKRILL_EMAILID_DESC','E-Mail Adresse mitwelcher Sie bei Skrill.com registriert sind.<br />Wenn Sie noch &uuml;ber kein Konto verf&uuml;gen, <b>melden Sie sich</b> jetzt bei <a href="http://www.moneybookers.com/ads/partners/de/aktivierung/index.html?p=Gambio" target="_blank"><b>Skrill</b></a> <b>gratis</b> an.');
define('_PAYMENT_SKRILL_MERCHANTID_TITLE','Skrill H&auml;ndler ID');
define('_PAYMENT_SKRILL_MERCHANTID_DESC','Ihre Skrill.com H&auml;ndler ID');
define('_PAYMENT_SKRILL_PWD_TITLE','Skrill Geheimwort');
define('_PAYMENT_SKRILL_PWD_DESC','Mit der Eingabe des Geheimwortes wird die Verbindung beim Bezahlvorgang verschl&uuml;sselt. So wird h&ouml;chste Sicherheit gew&auml;hrleistet. Geben Sie Ihr Skrill Geheimwort ein (dies ist nicht ihr Passwort!). Das Geheimwort darf nur aus Kleinbuchstaben und Zahlen bestehen. Sie k&ouml;nnen Ihr Geheimwort <strong><span style="color:#f00">nach der Freischaltung</span></strong> in Ihrem Skrill-Benutzerkonto definieren. (H&auml;ndlereinstellungen).<br /><br />
<span style="color:#f00">So schalten Sie Ihren Skrill.com Account f&uuml;er die Gambio Zahlungsabwicklung frei:</span><br /><br />

Senden Sie eine E-Mail mit
<ul>
<li>Ihrer Shopdomain</li>
<li>Ihrer Skrill E-Mail-Adresse</li>
</ul>
an: <a href="mailto:ecommerce@skrill.com?subject=Gambio: Aktivierung fuer Skrill Quick Checkout">ecommerce@skrill.com</a>
');
define('_PAYMENT_SKRILL_TMP_STATUS_ID_TITLE','Bestellstatus - Zahlungsvorgang');
define('_PAYMENT_SKRILL_TMP_STATUS_ID_DESC',' Sobald der Kunde im Shop auf "Bestellung absenden" dr&uuml;ckt, wird von Gambio eine "Tempor&auml;re Bestellung" angelegt. Dies hat den Vorteil, dass bei Kunden die den Zahlungsvorgang bei Skrill abbrechen eine Bestellung aufgezeichnet wurde.');
define('_PAYMENT_SKRILL_PROCESSED_STATUS_ID_TITLE','Bestellstatus - Zahlung OK');
define('_PAYMENT_SKRILL_PROCESSED_STATUS_ID_DESC','Erscheint, wenn die Zahlung von Skrill best&auml;tigt wurde.');
define('_PAYMENT_SKRILL_PENDING_STATUS_ID_TITLE','Bestellstatus - Zahlung in Warteschleife');
define('_PAYMENT_SKRILL_PENDING_STATUS_ID_DESC','');
define('_PAYMENT_SKRILL_CANCELED_STATUS_ID_TITLE','Bestellstatus - Zahlung Storniert');
define('_PAYMENT_SKRILL_CANCELED_STATUS_ID_DESC','Wird erscheinen, wenn z.B. eine Kreditkarte abgelehnt wurde');
define('_PAYMENT_SKRILL_MODULES_TITLE', 'Zahlungsweisen');
define('_PAYMENT_SKRILL_MODULES_DESC', 'Bitte aktivieren Sie die zu verwendenden Zahlungsweisen');
define('_PAYMENT_SKRILL_CLASSIC_MODULES', 'Beliebteste Zahlungsweisen');
define('_PAYMENT_SKRILL_OTHER_MODULES', 'Weitere Zahlungsweisen');
define('_PAYMENT_SKRILL_EXPERTMODE_TITLE', 'Expert Mode');
define('_PAYMENT_SKRILL_EXPERTMODE_DESC', 'Please do not modify this value unless instructed to do so by Skrill! (Default: 0)');
define('SKRILL_TEXT_SKRILLDATE', 'Letzte Aktualisierung:');
define('SKRILL_TEXT_SKRILLTID', 'TR ID:');
define('SKRILL_TEXT_SKRILLERRTXT', 'Status:');
define('SKRILL_ERROR_NO_MERCHANT','Es existiert kein Skrill-Account mit dieser E-Mail-Adresse!');
define('SKRILL_MERCHANT_OK','Skrill.com Account korrekt, H&auml;ndler ID %s von Skrill.com empfangen und gespeichert.');

define('SKRILL_INFO','<img src="../images/icons/skrill/SKRILLbanner.jpg" /><br /><br />Gambio k&ouml;nnen jetzt Kreditkarten, Lastschrift, Sofort&uuml;berweisung, Giropay sowie alle weiteren wichtigen lokalen Bezahloptionen direkt akzeptieren mit einer simplen Aktivierung im Shop. Mit Skrill als All-in-One-L&ouml;sung brauchen Sie dabei keine Einzelvertr&auml;ge pro Zahlart abzuschliesen. Sie brauchen lediglich einen <a href="https://www.skrill.com/app/register.pl" target="_blank"><b>kostenlosen Skrill Account</b></a> um alle wichtigen Bezahloptionen in Ihrem Shop zu akzeptieren. Zus&auml;tzliche Bezahlarten sind ohne Mehrkosten und das Modul beinhaltet <strong>keine monatliche Fixkosten oder Installationskosten</strong>.
<br /><br />
<strong>Ihre Vorteile:</strong><br />
<ul>
<li>Die Akzeptanz der wichtigsten Bezahloptionen steigern Ihren Umsatz</li>
<li>Ein Anbieter reduziert Ihre Aufw&auml;nde und Ihre Kosten</li>
<li>Ihr Kunde bezahlt direkt und ohne Registrierungsprozedur</li>
<li>Ein-Klick-Aktivierung und Integration</li>
<li>Sehr attraktive <a href="http://www.skrill.com/app/help.pl?s=m_fees" target="_blank"><strong>Konditionen</strong></a></li>
<li>sofortige Zahlungsbest&auml;tigung und Pr&uuml;fung der Kundendaten</li>
<li>Bezahlabwicklung auch im Ausland und ohne Mehrkosten</li>
<li>6 Millionen Kunden weltweit vertrauen Skrill</li>
</ul>');
/* EOF GM SKRILL */
/* BOF YOOCHOOSE */
require_once(DIR_FS_CATALOG . 'admin/yoochoose/yoo_lang_english.php');
/* EOF YOOCHOOSE */

// BOF GM_MOD
define('TEXT_NO_CONTENT', 'The content cannot be loaded, because the server is currently unavailable.');
define('TEXT_CONTENT_LOADING', 'Loading content...');
// EOF GM_MOD

define('ERROR_QUICKSEARCH_ORDER_ID', 'Only numbers are allowed for searching.');
?>