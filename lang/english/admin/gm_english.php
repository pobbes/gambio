<?php
/* --------------------------------------------------------------
   gm_english.php 2012-04-18 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/
?><?php

// Template Advice
define('TEMPLATE_ADVICE', 'This setting/function not applies if the EyeCandy-template is used.');

// Settings
define('GM_SETTINGS_OFFLINE', 'Shop offline <br /><font color="red">(Access with admin data only via the URL <a href="'. HTTP_SERVER.DIR_WS_CATALOG.'login_admin.php" target="_blank"><font color="red">'. HTTP_SERVER.DIR_WS_CATALOG.'login_admin.php</font></a>)</font>');
define('GM_SETTINGS_OFFLINE_PWD', 'Username: <strong>gambio</strong>, Password');
define('GM_SETTINGS_OFFLINE_MSG', 'Offline message');
define('GM_SETTINGS_PAYPAL_ERROR_FIREWALL', 'There seems to be a server-side firewall to block the request or response of the PayPal server. If you have so make sure your provider with a request that may be established via cURL to connect to the following addresses:<br /><br />https://api-3t.sandbox.paypal.com<br />https://www.sandbox.paypal.com<br />https://api.paypal.com<br />https://api-aa.paypal.com<br />https://api-3t.paypal.com<br />https://api-aa-3t.paypal.com<br />https://notify.paypal.com<br />https://reports.paypal.com<br />https://www.paypal.com<br />https://paypal.com<br />https://svcs.paypal.com<br />https://paypalobjects.com');
define('GM_SETTINGS_PAYPAL_ERROR_API', 'You may have entered wrong or none PayPal API information. Please recheck your configuration under "Configuration -> Initerfaces -> PayPal" before usage of this module.');
define('GM_SETTINGS_PAYPAL_ERROR_CURL', 'The cURL Extension is not installed on you server. Without this extension the PayPal module is not usable.');
define('GM_SETTINGS_PAYPAL_ERROR_OPENSSL', 'Your server does not support openSSL. Without this extension the PayPal module is not usable.');
define('GM_SETTINGS_PAYPAL_ERROR_STATE', 'You would like to deliver in a country where PayPal requires the field "State".<br />Please set "State" to "yes" in "Configuration -> Customer Details".<br />Set a value greater than "0" in the field "State" in "Konfiguration -> Minimum Werte", for example set the value "2"');

// BOF GM_MOD
// PayPal order status
define('STATUS_ERRORCODE_10011', 'The PayPal payment is not completed<br />Note: Please take contact with the customer on.');
define('STATUS_ERRORCODE_10002', 'This transaction was not processed by PayPal, because you wrong, or do not have PayPal API data entered.<br />Note: Please take contact with the customer on.');
define('STATUS_ERRORCODE_10004', 'The PayPal payment status could not be determined because a parameter is incorrect.');
define('STATUS_ERRORCODE_10412', 'Payment has already been made for this Invoice.<br />Notes:<br />Please correct your number range. PayPal identified the payments on the basis of order id.<br />Please take contact with the customer on.');
define('STATUS_ERRORCODE_10422', 'Customer must go to the PayPal-Website and choose new funding sources.<br /><br />Note: Please take contact with the customer on.');
define('STATUS_ERRORCODE_10445', 'This transaction was not processed by PayPal at the time.<br />Note: Please take contact with the customer on.');
define('STATUS_ERRORCODE_10729', 'The PayPal payment was not completed. The state in the delivery address was missing.<br />Note: Please take contact with the customer on.');
define('STATUS_ERRORCODE_10736', 'The customer\'s delivery address was invalid. City, state and zip code did not match.<br />Note: Please take contact with the customer on.');
define('STATUS_ERRORCODE_00005', 'The amount to be booked is too high. Please select the maximum of the open amount.');
define('STATUS_ERRORCODE_00010', 'Please choose a higher amount.');
define('STATUS_ERRORCODE_10009', 'You can not refund this type of transaction.');
define('STATUS_ERRORCODE_10417', 'The PayPal payment could not be completed because there is a problem with the customers PayPal account.<br />Note: Please take contact with the customer on.');
define('STATUS_ERRORCODE_10600', 'Authorization has been voided.');
define('STATUS_ERRORCODE_10622', 'Order is voided.');
define('STATUS_ERRORCODE_10628', 'This transaction cannot be processed at this time. Please try again later.');
define('STATUS_ERRORCODE_10001', 'PayPal reports an internal error. Pleas try again later.');
define('STATUS_ERRORCODE_10610', 'Amount specified exceeds allowable limit.');
define('STATUS_ERRORCODE_13113', 'The Buyer cannot pay with PayPal for this Transaction.<br /><br />Note: Please take contact with the customer on.');
// EOF GM_MOD

// Gambio Box
define('BOX_HEADING_GAMBIO', 'Gambio');
define('BOX_HEADING_LAYOUT_DESIGN', 'Layout / Design');
define('BOX_GM_COUNTER', 'Counter');
define('BOX_GM_EBAY', 'eBay Listing');
define('BOX_GM_PDF', 'Invoice/Packing Slip');
define('BOX_GM_LOGO', 'Logo Manager');
define('BOX_GM_SECURITY', 'Security Center');
define('BOX_HEADING_GAMBIO_SEO', 'Gambio SEO');
define('BOX_GM_META', 'Meta Data');
define('BOX_GM_SITEMAP', 'Sitemap Generator');
define('BOX_GM_BOOKMARKS', 'Social Bookmarking');
define('BOX_GM_SCROLLER', 'News Scroller');
define('BOX_GM_ID_STARTS', 'ID Starts');
define('BOX_GM_STATUSBAR', 'Status Bar Text');
define('BOX_GM_EMAILS', 'Edit Templates');
define('BOX_GM_GUESTBOOK', 'Guestbook');
define('BOX_GM_STYLE_EDIT', 'Template Settings');
define('BOX_GM_LANG_EDIT', 'Edit Text');
define('BOX_GM_MISCELLANEOUS', 'Miscellaneous');
define('BOX_GM_ANALYTICS', 'Tracking-Codes');
define('BOX_GM_SQL', 'SQL');
define('BOX_GM_OFFLINE', 'Shop Online/Offline');
define('BOX_GM_LIGHTBOX', 'Lightbox Configuration');
define('BOX_GM_TRUSTED_WIDGET', 'Trusted Shops Buyer Rating');
define('BOX_GM_TRUSTED_INFO', 'Trusted Shops Info');
define('BOX_GM_TRUSTED_SHOP_ID', 'Trusted Shops Seal of Approval');
define('BOX_GM_SEO_BOOST', 'Gambio SEO Boost');
define('BOX_GM_OPENSEARCH', 'OpenSearch Plugin');
define('BOX_GM_MODULE_EXPORT', 'Customer Export');
define('BOX_GM_BACKUP_FILES_ZIP','Backup files');
define('BOX_GM_CUSTOMER_UPLOAD', 'Upload at Rregistration');
define('BOX_GM_PRODUCT_EXPORT', 'Product Export');
define('BOX_GM_GMOTION', 'G-Motion');
define('BOX_GM_FEATURE_CONTROL', 'Product-Filter');
define('BOX_GM_SLIDER', 'Teaser-Slider');
define('BOX_QUANTITYUNITS', 'Quantity Units');
define('BOX_ROBOTS', 'Robots file');
define('BOX_GM_INVOICING', 'Invoicing');

// buttons
define('GM_BUTTON_ADD_SPECIAL', 'New Special');
define('GM_BUTTON_EDIT_SPECIAL', 'Edit Special');

// configuration table constants
define('GM_CFG_TRUE', 'true');
define('GM_CFG_FALSE', 'false');
define('GM_CFG_AND', 'and');
define('GM_CFG_OR', 'or');
define('GM_CFG_ACCOUNT', 'customer account');
define('GM_CFG_GUEST', 'guest account');
define('GM_CFG_BOTH', 'both');
define('GM_CFG_ASC', 'ascending');
define('GM_CFG_DESC', 'descending');
define('GM_CFG_PRODUCTS_NAME', 'product name');
define('GM_CFG_DATE_EXPECTED', 'date expected');
define('GM_CFG_SENDMAIL', 'sendmail');
define('GM_CFG_SMTP', 'SMTP');
define('GM_CFG_MAIL', 'mail');
define('GM_CFG_LF', 'LF');
define('GM_CFG_CRLF', 'CRLF');
define('GM_CFG_WEIGHT', 'weight');
define('GM_CFG_PRICE', 'price');
define('GM_CFG_SHOP_OWNER', 'Owner E-Mail');
define('GM_CFG_CUSTOMER_MAIL', 'Customer E-Mail <b>(Standard)</b>');


define('GM_CLOSE_WINDOW', 'close window');

define('GM_ATTRIBUTES_IMAGE_UPLOAD_IMAGE', 'Image');
define('GM_ATTRIBUTES_IMAGE_UPLOAD_DELETE', 'Delete');

define('GM_TEXT_CHOOSE_OPTIONS_TEMPLATE','Product options template products overview');
define('GM_TEXT_SHOW_ATTRIBUTES', 'Show article attributes');
define('GM_TEXT_SHOW_GRADUATED_PRICES', 'Show graduated prices');
define('GM_TEXT_SHOW_QTY', 'Show quantity field');

define('IMAGE_ICON_STATUS_RED', 'no');
define('IMAGE_ICON_STATUS_GREEN_LIGHT', 'yes');
define('IMAGE_ICON_STATUS_RED_LIGHT', 'inactive');
define('IMAGE_ICON_STATUS_GREEN', 'active');
define('IMAGE_ICON_STATUS_GREEN_STOCK', 'in stock');

define('GM_IMAGE_PROCESS_TEXT_1', 'Image ');
define('GM_IMAGE_PROCESS_TEXT_2', ' of ');
define('GM_IMAGE_PROCESS_TEXT_3', ' images of ');
define('GM_IMAGE_PROCESS_TEXT_4', ' processed.');

define('GM_IMAGE_PROCESS_ERROR_TEXT_1', 'There were errors!');
define('GM_IMAGE_PROCESS_ERROR_TEXT_2', 'Please note the log.');

// JS
define('GM_GV_DELETE', 'Do you really want to delete this gift voucher?');


//NEW
define('BOX_GM_SEO_OPTIONS', 'Options');

?>