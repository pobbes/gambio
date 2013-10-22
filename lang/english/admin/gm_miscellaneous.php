<?php
/* --------------------------------------------------------------
   gm_miscellaneous.php 2012-01-12 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/
?><?php

	define('HEADING_TITLE', 'Miscellaneous');
	define('HEADING_SUB_TITLE', 'Gambio');
	define('BUTTON_SAVE','Save');

	define('GM_TITLE_STOCK', 'Show stock');
	define('GM_CAT_STOCK', 'Show stock in <strong>all</strong> categories?');
	define('GM_PRODUCT_STOCK', 'Show stock in <strong>all</strong> products?');
	define('BUTTON_EXECUTE', 'Execute');
	define('GM_CAT_STOCK_SUCCESS', 'Categories were successfully updated.');
	define('GM_PRODUCT_STOCK_SUCCESS', 'Products were successfully updated.');

	define('GM_DELETE_IMAGES_TITLE', 'Delete Original Product Images');
	define('GM_DELETE_IMAGES', 'Delete all original product images permanently?');
	define('GM_DELETE_IMAGES_MESSAGE_1', '');
	define('GM_DELETE_IMAGES_MESSAGE_2', ' of ');
	define('GM_DELETE_IMAGES_MESSAGE_3', ' files were successfully deleted.');
	define('GM_DELETE_IMAGES_ADVICE_1', ' file could not be deleted, because the script user does not have sufficient rights.');
	define('GM_DELETE_IMAGES_ADVICE_2', ' files could not be deleted, because the script user does not have sufficient rights.');

	define('GM_TRUNCATE_PRODUCTS_NAME', 'Truncate product name on start page after X characters.');
	define('GM_TRUNCATE_PRODUCTS_HISTORY', 'Truncate product name in menu box ordering information after X characters.');
	define('GM_TRUNCATE_FLYOVER_TEXT', 'Truncate product name in "flyover" after X characters.');
	define('GM_TRUNCATE_FLYOVER', 'Truncate products short description in "flyover" after X characters.');
	define('GM_ORDER_STATUS_CANCEL_ID', 'ID in the MySQL table "orders_status" for the order status of the cancelation. This ID should only be modified if the new ID is known or the ID has not been saved. The default value here is "99"');
	define('GM_TELL_A_FRIEND', 'Activate &quot;Tell a friend&quot; module?');

	define('GM_TAX_FREE', 'VAT exempt as per current regulations');

	define('GM_HIDE_MSRP_TEXT', 'Disable MSRP display for group prices');

	define('GM_MISCELLANEOUS_SUCCESS', 'Changes were successfully updated.');

	/*law and order */
	define('TITLE_LAW',										'Rights');
	define('TITLE_PRIVACY',									'Privacy');
	define('TITLE_CONDITIONS',								'Conditions');
	define('TITLE_WITHDRAWAL',								'Right of Withdrawal');

	define('TITLE_CONDITIONS_SHOW_ORDER',					'Show in Checkout');
	define('TITLE_CONDITIONS_CHECK_ORDER',					'Confirm in Checkout');

	define('TITLE_PRIVACY_SHOW_REGISTRATION',				'Show in Registration');
	define('TITLE_PRIVACY_CHECK_REGISTRATION',				'Confirm in Registration');

	define('TITLE_WITHDRAWAL_SHOW_ORDER',					'Show in Checkout');
	define('TITLE_WITHDRAWAL_CHECK_ORDER',					'Confirm in Registration');
	define('TITLE_WITHDRAWAL_CONTENT_ID_ORDER',					'Content ID');

	define('TITLE_CONFIRMATION', 'Checkout Confirmation Page');
	define('TITLE_PRIVACY_CONFIRMATION', 'Show Privacy Conditions Link');
	define('TITLE_CONDITIONS_CONFIRMATION', 'Show General Terms and Conditions Link');
	define('TITLE_WITHDRAWAL_CONFIRMATION', 'Show Right of Withdrawal Conditions Link');

	define('TITLE_IP_LOG',			'IP Log in Checkout' );
	define('TEXT_LOG_IP',			'Save IP in checkout');
	define('TEXT_SHOW_IP',			'Show IP info in checkout');
	define('TEXT_CONFIRM_IP',		'Confirm IP logging in checkout');

	define('TEXT_LOG_IP_LOGIN',		'Save IP at login and registration');
	define('TEXT_NOTE_LOGGING',		'');

	define('TITLE_DISPLAY_TAX', 'VAT display');
	define('TEXT_DISPLAY_TAX', 'Show VAT information under product prices');

	/* delete stats */
	define('GM_TITLE_STATS', 'Delete statistics');

	define('TITLE_STAT_PRODUCTS_VIEWED',	'Products Searched');
	define('TITLE_STAT_PRODUCTS_PURCHASED', 'Products Purchased');
	define('TITLE_STAT_INTERN_KEWORDS',		'Internal Keywords');
	define('TITLE_STAT_EXTERN_KEWORDS',		'External Keywords');
	define('TITLE_STAT_IMPRESSIONS',		'Page Impressions');
	define('TITLE_STAT_VISTORS',			'Visitors');

	/* Privacy */
	define('TITLE_PRIVACY_CALLBACK',			'Show in callback service');
	define('TITLE_PRIVACY_CONTACT',				'Show in contact');
	define('TITLE_PRIVACY_GUESTBOOK',			'Show in guestbook');

	define('TITLE_PRIVACY_TELL_A_FRIEND',		'Show in module &quot;Tell a friend&quot;');
	define('TITLE_PRIVACY_FOUND_CHEAPER',		'Show in module &quot;Found cheaper&quot;');
	define('TITLE_PRIVACY_REVIEWS',				'Show in reviews');

	define('TITLE_PRIVACY_ACCOUNT_CONTACT',		'Show in account information');
	define('TITLE_PRIVACY_ACCOUNT_ADDRESS_BOOK','Show in account address book');

	define('TITLE_PRIVACY_ACCOUNT_NEWSLETTER',	'Show in newsletter');

	define('TITLE_PRIVACY_CHECKOUT_SHIPPING',	'Show in checkout &quot;mailing address&quot;');
	define('TITLE_PRIVACY_CHECKOUT_PAYMENT',	'Show in checkout &quot;billing address&quot;');


	//NEW
	define('GM_SHOW_PRODUCTS_WEIGHT',	'Show Products Weight in Products Info Page');
	define('TITLE_LOG_IP',				'IP Logging' );
	define('GM_TITLE_STAT',				'Order Status');
	define('TITLE_STAT_USER_INFO',		'User Info');

?>