<?php
/* --------------------------------------------------------------
   english.php 2008-11-07 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(german.php,v 1.119 2003/05/19); www.oscommerce.com
   (c) 2003  nextcommerce (german.php,v 1.25 2003/08/25); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: english.php 1260 2005-09-29 17:48:04Z gwinger $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

/*
 *
 *  DATE / TIME
 *
 */

define('TITLE', STORE_NAME);
define('HEADER_TITLE_TOP', 'Main page');
define('HEADER_TITLE_CATALOG', 'Catalog');

define('HTML_PARAMS','dir="ltr" lang="en"');

@setlocale(LC_TIME, 'en_EN@euro', 'en_US', 'en-US', 'en', 'en_US.ISO_8859-1', 'English','en_US.ISO_8859-15');

define('DATE_FORMAT_SHORT', '%m.%d.%Y');  // this is used for strftime()
define('DATE_FORMAT_LONG', '%A, %d. %B %Y'); // this is used for strftime()
define('DATE_FORMAT', 'm.d.Y');  // this is used for strftime()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');
define('DOB_FORMAT_STRING', 'mm.dd.yyyy');

function xtc_date_raw($date, $reverse = false) {
  if ($reverse) {
    return substr($date, 0, 2) . substr($date, 3, 2) . substr($date, 6, 4);
  } else {
    return substr($date, 6, 4) . substr($date, 3, 2) . substr($date, 0, 2);
  }
}

// if USE_DEFAULT_LANGUAGE_CURRENCY is true, use the following currency, instead of the applications default currency (used when changing language)
define('LANGUAGE_CURRENCY', 'USD');

define('MALE', 'Mr');
define('FEMALE', 'Miss/Ms/Mrs');

/*
 *
 *  BOXES
 *
 */

// text for gift voucher redeeming
define('IMAGE_REDEEM_GIFT','Redeem Gift Voucher!');

define('BOX_TITLE_STATISTICS','Statistics:');
define('BOX_ENTRY_CUSTOMERS','Customers');
define('BOX_ENTRY_PRODUCTS','Products');
define('BOX_ENTRY_REVIEWS','Reviews');
define('TEXT_VALIDATING','Not validated');

// manufacturer box text
define('BOX_MANUFACTURER_INFO_HOMEPAGE', '%s Home page');
define('BOX_MANUFACTURER_INFO_OTHER_PRODUCTS', 'More Products');

define('BOX_HEADING_ADD_PRODUCT_ID','Add to Cart');

define('BOX_LOGINBOX_STATUS','Customer group:');
define('BOX_LOGINBOX_DISCOUNT','Product discount');
define('BOX_LOGINBOX_DISCOUNT_TEXT','Discount');
define('BOX_LOGINBOX_DISCOUNT_OT','');

// reviews box text in includes/boxes/reviews.php
define('BOX_REVIEWS_WRITE_REVIEW', 'Review this product!');
define('BOX_REVIEWS_TEXT_OF_5_STARS', '%s out of 5 stars!');

// pull down default text
define('PULL_DOWN_DEFAULT', 'Please choose');

// javascript messages
define('JS_ERROR', 'Missing necessary information!\nPlease complete correctly.\n\n');

define('JS_REVIEW_TEXT', '* The text must consist of at least ' . REVIEW_TEXT_MIN_LENGTH . ' alphabetical characters..\n');
define('JS_REVIEW_RATING', '* Enter your review.\n');
define('JS_ERROR_NO_PAYMENT_MODULE_SELECTED', '* Please choose a method of payment for your order.\n');
define('JS_ERROR_SUBMITTED', 'This page has already been confirmed. Please click OK and wait until the process has finished.');
define('ERROR_NO_PAYMENT_MODULE_SELECTED', 'Please choose a method of payment for your order.');

define('ADMIN_LINK_INFO_TEXT', 'Click Cancel to edit the link instead of open it.');

/*
 *
 * ACCOUNT FORMS
 *
 */
define('ENTRY_PRIVACY_ERROR', 'You have not confirmed the privacy notice');
define('ENTRY_CHECK_PRIVACY', 'I have read the <a href="%s" target="_blank">privacy notice</a> and confirm my agreement. *');
define('ENTRY_SHOW_PRIVACY', 'I have read the <a href="%s" target="_blank">privacy notice</a>.');
define('ENTRY_COMPANY_ERROR', '');
define('ENTRY_COMPANY_TEXT', '');
define('ENTRY_GENDER_ERROR', 'Please select your gender.');
define('ENTRY_GENDER_TEXT', '*');
define('ENTRY_FIRST_NAME_ERROR', 'at least  ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' characters');
define('ENTRY_FIRST_NAME_TEXT', '*');
define('ENTRY_LAST_NAME_ERROR', 'at least ' . ENTRY_LAST_NAME_MIN_LENGTH . ' characters');
define('ENTRY_LAST_NAME_TEXT', '*');
define('ENTRY_DATE_OF_BIRTH_ERROR', 'MM.DD.YYYY (e.g. 05.21.1970)');
define('ENTRY_DATE_OF_BIRTH_TEXT', '* (e.g. 05.21.1970)');
define('ENTRY_EMAIL_ADDRESS_ERROR', 'at least  ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' characters');
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', 'The email address you entered is incorrect; please check it');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 'The email address you entered already exists in our database; please check it');
define('ENTRY_EMAIL_ADDRESS_TEXT', '*');
define('ENTRY_STREET_ADDRESS_ERROR', 'at least ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' characters');
define('ENTRY_STREET_ADDRESS_TEXT', '*');
define('ENTRY_SUBURB_TEXT', '');
define('ENTRY_POST_CODE_ERROR', 'at least ' . ENTRY_POSTCODE_MIN_LENGTH . ' characters');
define('ENTRY_POST_CODE_TEXT', '*');
define('ENTRY_CITY_ERROR', 'at least ' . ENTRY_CITY_MIN_LENGTH . ' characters');
define('ENTRY_CITY_TEXT', '*');
define('ENTRY_STATE_ERROR', 'at least ' . ENTRY_STATE_MIN_LENGTH . ' characters');
define('ENTRY_STATE_ERROR_SELECT', 'Please select your state from the list.');
define('ENTRY_STATE_TEXT', '*');
define('ENTRY_COUNTRY_ERROR', 'Please select your country.');
define('ENTRY_COUNTRY_TEXT', '*');
define('ENTRY_TELEPHONE_NUMBER_ERROR', 'at least ' . ENTRY_TELEPHONE_MIN_LENGTH . ' characters');
define('ENTRY_TELEPHONE_NUMBER_TEXT', '*');
define('ENTRY_FAX_NUMBER_TEXT', '');
define('ENTRY_NEWSLETTER_TEXT', '');
define('ENTRY_PASSWORD_ERROR', 'at least ' . ENTRY_PASSWORD_MIN_LENGTH . ' characters');
define('ENTRY_PASSWORD_ERROR_NOT_MATCHING', 'Your passwords do not match.');
define('ENTRY_PASSWORD_TEXT', '*');
define('ENTRY_PASSWORD_CONFIRMATION_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT_ERROR','at least ' . ENTRY_PASSWORD_MIN_LENGTH . ' characters');
define('ENTRY_PASSWORD_NEW_TEXT', '*');
define('ENTRY_PASSWORD_NEW_ERROR', 'at least ' . ENTRY_PASSWORD_MIN_LENGTH . ' characters');
define('ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING', 'Your passwords do not match.');

/*
 *
 *  RESTULTPAGES
 *
 */

define('TEXT_RESULT_PAGE', 'Page:');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'Show <b>%d</b> to <b>%d</b> (from a total of <b>%d</b> products)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', 'Show <b>%d</b> to <b>%d</b> (from a total of <b>%d</b> orders)');
define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', 'Show <b>%d</b> to <b>%d</b> (from a total of <b>%d</b> reviews)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW', 'Show <b>%d</b> to <b>%d</b> (from a total of <b>%d</b> new products)');
define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', 'Show <b>%d</b> to <b>%d</b> (from a total of <b>%d</b> special offers)');

/*
 *
 * SITE NAVIGATION
 *
 */

define('PREVNEXT_TITLE_PREVIOUS_PAGE', 'previous page');
define('PREVNEXT_TITLE_NEXT_PAGE', 'next page');
define('PREVNEXT_TITLE_PAGE_NO', 'page %d');
define('PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE', 'Previous %d pages');
define('PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE', 'Next %d pages');

/*
 *
 * PRODUCT NAVIGATION
 *
 */

define('PREVNEXT_BUTTON_PREV', '[&lt;&lt;]');
define('PREVNEXT_BUTTON_NEXT', '[&gt;&gt;]');

/*
 *
 * IMAGE BUTTONS
 *
 */

define('IMAGE_BUTTON_ADD_ADDRESS', 'New address');
define('IMAGE_BUTTON_BACK', 'Back');
define('IMAGE_BUTTON_CHANGE_ADDRESS', 'Change address');
define('IMAGE_BUTTON_CHECKOUT', 'Checkout');
define('IMAGE_BUTTON_CONFIRM_ORDER', 'Confirm order');
define('IMAGE_BUTTON_CONTINUE', 'Next');
define('IMAGE_BUTTON_DELETE', 'Delete');
define('IMAGE_BUTTON_LOGIN', 'Log in');
define('IMAGE_BUTTON_IN_CART', 'Add to cart');
define('IMAGE_BUTTON_SEARCH', 'Search');
define('IMAGE_BUTTON_UPDATE', 'Update');
define('IMAGE_BUTTON_UPDATE_CART', 'Update cart');
define('IMAGE_BUTTON_WRITE_REVIEW', 'Write a review');
define('IMAGE_BUTTON_ADMIN', 'Admin');
define('IMAGE_BUTTON_PRODUCT_EDIT', 'Edit product');
define('IMAGE_BUTTON_LOGIN', 'Log in');

define('SMALL_IMAGE_BUTTON_DELETE', 'Delete');
define('SMALL_IMAGE_BUTTON_EDIT', 'Edit');
define('SMALL_IMAGE_BUTTON_VIEW', 'View');

define('ICON_ARROW_RIGHT', 'Show more');
define('ICON_CART', 'Add to cart');
define('ICON_SUCCESS', 'Success');
define('ICON_WARNING', 'Warning');

/*
 *
 *  GREETINGS
 *
 */

define('TEXT_GREETING_PERSONAL', 'Nice to see you again <span class="greetUser">%s!</span> Would you like to view our <a style="text-decoration:underline;" href="%s">new products</a>?');
define('TEXT_GREETING_PERSONAL_RELOGON', '<small>If you are not %s, please <a style="text-decoration:underline;" href="%s">log in</a> using your account.</small>');
define('TEXT_GREETING_GUEST', 'Welcome <span class="greetUser">visitor!</span> Would you like to <a style="text-decoration:underline;" href="%s">log in</a>? Or would you like to create a new <a style="text-decoration:underline;" href="%s">account</a>?');

define('TEXT_SORT_PRODUCTS', 'Products are sorted in ');
define('TEXT_DESCENDINGLY', 'descending order');
define('TEXT_ASCENDINGLY', 'ascending order');
define('TEXT_BY', ' by ');

define('TEXT_REVIEW_BY', 'by %s');
define('TEXT_REVIEW_WORD_COUNT', '%s words');
define('TEXT_REVIEW_RATING', 'Review: %s [%s]');
define('TEXT_REVIEW_DATE_ADDED', 'Date added: %s');
define('TEXT_NO_REVIEWS', 'There are no reviews yet.');
define('TEXT_NO_NEW_PRODUCTS', 'There are no new products currently.');
define('TEXT_UNKNOWN_TAX_RATE', 'Unknown tax rate');

/*
 *
 * WARNINGS
 *
 */

define('WARNING_INSTALL_DIRECTORY_EXISTS', 'Warning: The installation directory is still available on: ' . dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']) . '/gambio_installer. Please delete this directory for security reasons!');
define('WARNING_CONFIG_FILE_WRITEABLE', 'Warning: XT-Commerce is able to write to the configuration directory: ' . dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']) . '/includes/configure.php. This represents a potential security risk. Please change the user access rights for this directory!');
define('WARNING_SESSION_DIRECTORY_NON_EXISTENT', 'Warning: Directory for sesssions does not exist: ' . xtc_session_save_path() . '. Sessions will not work until this directory has been created!');
define('WARNING_SESSION_DIRECTORY_NOT_WRITEABLE', 'Warning: XT-Commerce is unable to write to the session directory: ' . xtc_session_save_path() . '. Sessions will not work until the user access rights for this directory have been changed!');
define('WARNING_SESSION_AUTO_START', 'Warning: session.auto_start is activated (enabled). Please deactivate (disable) this PHP feature in php.ini
 and restart your web server!');
define('WARNING_DOWNLOAD_DIRECTORY_NON_EXISTENT', 'Warning: Directory for product download does not exist: ' . DIR_FS_DOWNLOAD . '. This feature will not work until this directory has been created!');

define('SUCCESS_ACCOUNT_UPDATED', 'Your account has been updated successfully.');
define('SUCCESS_PASSWORD_UPDATED', 'Your password has been changed successfully!');
define('ERROR_CURRENT_PASSWORD_NOT_MATCHING', 'The password entered does not match the password stored. Please try again.');
define('TEXT_MAXIMUM_ENTRIES', '<font color="#ff0000"><b>Reference:</b></font> You can choose from %s entries in you address book!');
define('SUCCESS_ADDRESS_BOOK_ENTRY_DELETED', 'The selected entry has been deleted successfully.');
define('SUCCESS_ADDRESS_BOOK_ENTRY_UPDATED', 'Your address book has been updated sucessfully!');
define('WARNING_PRIMARY_ADDRESS_DELETION', 'The standard postal address cannot be deleted. Please create another address and define it as the standard postal address first. This entry can then be deleted.');
define('ERROR_NONEXISTING_ADDRESS_BOOK_ENTRY', 'This address book entry is not available.');
define('ERROR_ADDRESS_BOOK_FULL', 'Your address book is full; you must delete one address first before you can save another.');

//  conditions check

define('ERROR_CONDITIONS_NOT_ACCEPTED', '* We cannot accept your order if you do not accept our General Business and Right of Withdrawal Conditions!');

define('SUB_TITLE_OT_DISCOUNT','Discount:');

define('TAX_ADD_TAX','incl. ');
define('TAX_NO_TAX','plus ');

define('NOT_ALLOWED_TO_SEE_PRICES','You do not have permission to view the prices ');
define('NOT_ALLOWED_TO_SEE_PRICES_TEXT','You do not have permission to view the prices; please create an account.');

define('TEXT_DOWNLOAD','Download');
define('TEXT_VIEW','View');

define('TEXT_BUY', '1 x \'');
define('TEXT_NOW', '\' order');
define('TEXT_GUEST','Visitor');

/*
 *
 * ADVANCED SEARCH
 *
 */

define('TEXT_ALL_CATEGORIES', 'All categories');
define('TEXT_ALL_MANUFACTURERS', 'All manufacturers');
define('JS_AT_LEAST_ONE_INPUT', '* One of the following fields must be completed:\n    Keywords\n    Date added from\n    Date added to\n    Price over\n    Price up to\n');
define('AT_LEAST_ONE_INPUT', 'One of the following fields must be completed:<br />keywords must contain at least 3 characters<br />Price over<br />Price up to<br />');
define('JS_INVALID_FROM_DATE', '* Invalid from date\n');
define('JS_INVALID_TO_DATE', '* Invalid to date\n');
define('JS_TO_DATE_LESS_THAN_FROM_DATE', '* The from date must be later or the same as the to date\n');
define('JS_PRICE_FROM_MUST_BE_NUM', '* Price over must be a number\n');
define('JS_PRICE_TO_MUST_BE_NUM', '* Price up to must be a number\n');
define('JS_PRICE_TO_LESS_THAN_PRICE_FROM', '* Price up to must be greater or the same as price over.\n');
define('JS_INVALID_KEYWORDS', '* Invalid search key\n');
define('TEXT_LOGIN_ERROR', '<font color="#ff0000"><b>ERROR:</b></font> The \'email address\' and/or \'password\' entered do not match.');
define('TEXT_NO_EMAIL_ADDRESS_FOUND', '<font color="#ff0000"><b>WARNING:</b></font> The email address entered is not registered. Please try again.');
define('TEXT_PASSWORD_SENT', 'A new password has been sent by email.');
define('TEXT_PRODUCT_NOT_FOUND', 'Product not found!');
define('TEXT_MORE_INFORMATION', 'For more information, please visit the <a style="text-decoration:underline;" href="%s" onclick="window.open(this.href); return false;">home page</a> for this product.');
define('TEXT_DATE_ADDED', 'This product was added to our catalog on %s.');
define('TEXT_DATE_AVAILABLE', 'This product is expected to be in stock again on %s ');
define('SUB_TITLE_SUB_TOTAL', 'Subtotal:');

define('OUT_OF_STOCK_CANT_CHECKOUT', 'The products marked ' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . ' , are not in stock in the quantity you requested.<br />Please reduce the quantity of the marked products on your order. Thank you');
define('OUT_OF_STOCK_CAN_CHECKOUT', 'The products marked ' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . ' , are not in stock in the quantity you requested.<br />The quantity entered will be supplied by us very soon. We can do a part delivery on request.');

define('MINIMUM_ORDER_VALUE_NOT_REACHED_1', 'You must reach the minimum order value of: ');
define('MINIMUM_ORDER_VALUE_NOT_REACHED_2', ' <br />Please increase your order for at least an additional: ');
define('MAXIMUM_ORDER_VALUE_REACHED_1', 'You ordered more than the permitted amount of: ');
define('MAXIMUM_ORDER_VALUE_REACHED_2', '<br />Please reduce your order to under: ');

define('ERROR_INVALID_PRODUCT', 'The product chosen was not found!');

/*
 *
 * NAVBAR Titel
 *
 */

define('NAVBAR_TITLE_ACCOUNT', 'Your account');
define('NAVBAR_TITLE_1_ACCOUNT_EDIT', 'Your account');
define('NAVBAR_TITLE_2_ACCOUNT_EDIT', 'Changing your personal data');
define('NAVBAR_TITLE_1_ACCOUNT_HISTORY', 'Your account');
define('NAVBAR_TITLE_2_ACCOUNT_HISTORY', 'Your completed orders');
define('NAVBAR_TITLE_1_ACCOUNT_HISTORY_INFO', 'Your account');
define('NAVBAR_TITLE_2_ACCOUNT_HISTORY_INFO', 'Completed orders');
define('NAVBAR_TITLE_3_ACCOUNT_HISTORY_INFO', 'Order number %s');
define('NAVBAR_TITLE_1_ACCOUNT_PASSWORD', 'Your account');
define('NAVBAR_TITLE_2_ACCOUNT_PASSWORD', 'Change password');
define('NAVBAR_TITLE_1_ADDRESS_BOOK', 'Your account');
define('NAVBAR_TITLE_2_ADDRESS_BOOK', 'Address book');
define('NAVBAR_TITLE_1_ADDRESS_BOOK_PROCESS', 'Your account');
define('NAVBAR_TITLE_2_ADDRESS_BOOK_PROCESS', 'Address book');
define('NAVBAR_TITLE_ADD_ENTRY_ADDRESS_BOOK_PROCESS', 'New entry');
define('NAVBAR_TITLE_MODIFY_ENTRY_ADDRESS_BOOK_PROCESS', 'Change entry');
define('NAVBAR_TITLE_DELETE_ENTRY_ADDRESS_BOOK_PROCESS', 'Delete entry');
define('NAVBAR_TITLE_ADVANCED_SEARCH', 'Advanced Search');
define('NAVBAR_TITLE1_ADVANCED_SEARCH', 'Advanced Search');
define('NAVBAR_TITLE2_ADVANCED_SEARCH', 'Search results');
define('NAVBAR_TITLE_1_CHECKOUT_CONFIRMATION', 'Checkout');
define('NAVBAR_TITLE_2_CHECKOUT_CONFIRMATION', 'Confirmation');
define('NAVBAR_TITLE_1_CHECKOUT_PAYMENT', 'Checkout');
define('NAVBAR_TITLE_2_CHECKOUT_PAYMENT', 'Method of payment');
define('NAVBAR_TITLE_1_PAYMENT_ADDRESS', 'Checkout');
define('NAVBAR_TITLE_2_PAYMENT_ADDRESS', 'Change billing address');
define('NAVBAR_TITLE_1_CHECKOUT_SHIPPING', 'Checkout');
define('NAVBAR_TITLE_2_CHECKOUT_SHIPPING', 'Shipping information');
define('NAVBAR_TITLE_1_CHECKOUT_SHIPPING_ADDRESS', 'Checkout');
define('NAVBAR_TITLE_2_CHECKOUT_SHIPPING_ADDRESS', 'Change shipping address');
define('NAVBAR_TITLE_1_CHECKOUT_SUCCESS', 'Checkout');
define('NAVBAR_TITLE_2_CHECKOUT_SUCCESS', 'Success');
define('NAVBAR_TITLE_CREATE_ACCOUNT', 'Create account');
if ($navigation->snapshot['page'] == FILENAME_CHECKOUT_SHIPPING) {
  define('NAVBAR_TITLE_LOGIN', 'Order');
} else {
  define('NAVBAR_TITLE_LOGIN', 'Log in');
}
define('NAVBAR_TITLE_LOGOFF','Goodbye');
define('NAVBAR_TITLE_PRODUCTS_NEW', 'New products');
define('NAVBAR_TITLE_SHOPPING_CART', 'Shopping cart');
define('NAVBAR_TITLE_SPECIALS', 'Special offers');
define('NAVBAR_TITLE_COOKIE_USAGE', 'Cookie usage');
define('NAVBAR_TITLE_PRODUCT_REVIEWS', 'Reviews');
define('NAVBAR_TITLE_REVIEWS_WRITE', 'Opinions');
define('NAVBAR_TITLE_REVIEWS','Reviews');
define('NAVBAR_TITLE_SSL_CHECK', 'Note on security');
define('NAVBAR_TITLE_CREATE_GUEST_ACCOUNT','Create account');
define('NAVBAR_TITLE_PASSWORD_DOUBLE_OPT','Forgotten password?');
define('NAVBAR_TITLE_NEWSLETTER','Newsletter');
define('NAVBAR_GV_REDEEM', 'Redeem voucher');
define('NAVBAR_GV_SEND', 'Send voucher');

/*
 *
 *  MISC
 *
 */

define('TEXT_NEWSLETTER','Do you want to be kept up to date?<br />No problem, you can receive our newsletter to ensure you always have the latest information.');
define('TEXT_EMAIL_INPUT','Your email address has been registered on our system.<br />You will therefore receive an email containing your personal confirmation code link. Once you have received the email, please click on the hyperlink or no newsletter will be sent to you!');

define('TEXT_WRONG_CODE','<font color="#FF0000">Please fill in the email field and the security code again. <br />Watch out for typos!</font>');
define('TEXT_NO_CHOICE','<font color="#FF0000">Please select an option (subscribe or unsubscribe).</font>');
define('TEXT_EMAIL_EXIST_NO_NEWSLETTER','<font color="#FF0000">This email address has been registered, but is not yet activated!</font>');
define('TEXT_EMAIL_EXIST_NEWSLETTER','<font color="#FF0000">This email address has been registered and has been activated for the newsletter!</font>');
define('TEXT_EMAIL_NOT_EXIST','<font color="#FF0000">This email address has not been registered for the newsletter!</font>');
define('TEXT_EMAIL_DEL','Your email address has been deleted from our newsletter database.');
define('TEXT_EMAIL_DEL_ERROR','<font color="#FF0000">An error occurred; your email address has not been deleted!</font>');
define('TEXT_EMAIL_ACTIVE','Your email address has been integrated into our newsletter service!');
define('TEXT_EMAIL_ACTIVE_ERROR','<font color="#FF0000">An error occurred; your email address has not been activated for the newsletter!</font>');
define('TEXT_EMAIL_SUBJECT','Your Newsletter Account');

define('TEXT_CUSTOMER_GUEST','Guest');

define('TEXT_LINK_MAIL_SENDED','Your inquiry for a new password must be confirmed by you personally.<br />You will therefore receive an email with your personal confirmation code link. Once you have received the email, please click on the hyperlink and you will receive another email containing your new login password. If you do not click on the link, you will not receive a new password!');
define('TEXT_PASSWORD_MAIL_SENDED','You will receive an email containing your new password in a few minutes.<br />After you have logged in for the first time, please change your password to a password of your choice.');
define('TEXT_CODE_ERROR','Please complete
 the email field and the security code again. <br />Watch out for typos!');
define('TEXT_EMAIL_ERROR','Please fill in the email field and the security code again. <br />Watch out for typos!');
define('TEXT_NO_ACCOUNT','We regret to inform you that your inquiry for a new login password was either invalid or timed out.<br />Please try again.');
define('HEADING_PASSWORD_FORGOTTEN','Password renewal?');
define('TEXT_PASSWORD_FORGOTTEN','Change your password in three easy steps.');
define('TEXT_EMAIL_PASSWORD_FORGOTTEN','Confirmation mail for password renewal');
define('TEXT_EMAIL_PASSWORD_NEW_PASSWORD','Your new password');
define('ERROR_MAIL','Please check the data entered on the form');

define('CATEGORIE_NOT_FOUND','Category was not found');

define('GV_FAQ', 'Gift voucher FAQ');
define('ERROR_NO_REDEEM_CODE', 'You did not enter a redeem code.');
define('ERROR_NO_INVALID_REDEEM_GV', 'Invalid gift voucher code');
define('TABLE_HEADING_CREDIT', 'Credits available');
define('EMAIL_GV_TEXT_SUBJECT', 'A gift from %s');
define('MAIN_MESSAGE', 'You have decided to send a gift voucher worth %s to %s, whose email address is %s<br /><br />The text accompanying the email will read:<br /><br />Dear %s<br /><br />You have been sent a gift voucher worth %s from %s');
define('REDEEMED_AMOUNT','Your gift voucher was successfully added to your account. Gift voucher amount:');
define('REDEEMED_COUPON','Your coupon has been registered and will be redeemed automatically with your next order.');

define('ERROR_INVALID_USES_USER_COUPON','Customers can redeem this coupon ');
define('ERROR_INVALID_USES_COUPON','Customers can redeem this coupon ');
define('TIMES',' times only.');
define('ERROR_INVALID_STARTDATE_COUPON','Your coupon is not yet available.');
define('ERROR_INVALID_FINISDATE_COUPON','Your coupon is out of date.');
define('PERSONAL_MESSAGE', '%s says:');

//Popup Window
define('TEXT_CLOSE_WINDOW', 'Close window.');

/*
 *
 * CUOPON POPUP
 *
 */

define('TEXT_CLOSE_WINDOW', 'Close Window [x]');
define('TEXT_COUPON_HELP_HEADER', 'Congratulations! You have redeemed a discount coupon.');
define('TEXT_COUPON_HELP_NAME', '<br /><br />Coupon name: %s');
define('TEXT_COUPON_HELP_FIXED', '<br /><br />The coupon applies a discount of %s to your order');
define('TEXT_COUPON_HELP_MINORDER', '<br /><br />You must spend %s to use this coupon');
define('TEXT_COUPON_HELP_FREESHIP', '<br /><br />This coupon entitles you to free shipping on your order');
define('TEXT_COUPON_HELP_DESC', '<br /><br />Coupon description: %s');
define('TEXT_COUPON_HELP_DATE', '<br /><br />The coupon is valid from %s to %s');
define('TEXT_COUPON_HELP_RESTRICT', '<br /><br />Product / Category Restrictions');
define('TEXT_COUPON_HELP_CATEGORIES', 'Category');
define('TEXT_COUPON_HELP_PRODUCTS', 'Product');

// VAT ID
define('ENTRY_VAT_TEXT','');
define('ENTRY_VAT_ERROR', '<br />Please enter a valid VAT number or leave the field blank.');
define('MSRP','MSRP');
define('YOUR_PRICE','your price ');
define('ONLY',' only ');
define('FROM','');
define('YOU_SAVE','you save ');
define('INSTEAD','instead ');
define('TXT_PER',' per ');
define('TAX_INFO_INCL','incl. %s tax');
define('TAX_INFO_EXCL','excl. %s tax');
define('TAX_INFO_ADD','plus %s tax');
define('SHIPPING_EXCL','excl. ');
define('SHIPPING_COSTS','Shipping costs');

// changes 3.0.4 SP2
define('SHIPPING_TIME','Shipping time: ');
define('MORE_INFO','[More]');

// BOF GM_MOD
define('GM_OUT_OF_STOCK_NOTIFY_TEXT', 'Product availability');
define('GM_ORDER_QUANTITY_CHECKER_MIN_ERROR_1', 'The minimum order quantity of ');
define('GM_ORDER_QUANTITY_CHECKER_MIN_ERROR_2', ' has not been reached yet!<br />');
define('GM_ORDER_QUANTITY_CHECKER_GRADUATED_ERROR_1', 'The order quantity must be divisible by ');
define('GM_ORDER_QUANTITY_CHECKER_GRADUATED_ERROR_2', ' without decimals!');

define('NAVBAR_TITLE_PAYPAL_CHECKOUT','PayPal Checkout');

define('GM_TAX_FREE','VAT exempt according to current tax regulations');


define('GM_ATTR_STOCK_TEXT_BEFORE', '[available: ');
define('GM_ATTR_STOCK_TEXT_AFTER', ']');

define('GM_CONTACT_ERROR_WRONG_VVCODE','Incorrect code!');

define('GM_ENTRY_EMAIL_ADDRESS_ERROR', 'This email address already exists.');

define('GM_GIFT_INPUT', 'Redeem voucher?');

define('GM_REVIEWS_WRONG_CODE', 'Incorrect code!');
define('GM_REVIEWS_VALIDATION', 'Enter the verification code.');
define('GM_SHOW_NO_PRICE', 'not for sale');
define('GM_SHOW_PRICE_ON_REQUEST', 'price on request');


  define('NC_WISHLIST','Wish list');
  define('NC_WISHLIST_CONTAINS','Your wish list contains:');
  define('NC_WISHLIST_EMPTY','Your wish list is empty.');

define('TEXT_ADD_TO_CART', 'Add to cart');

define('GM_LIGHTBOX_PLEASE_WAIT', 'please wait');
define('GM_CONFIRM_CLOSE_LIGHTBOX', 'Do you really want to cancel the checkout progress and go to the start page?');

define('ERROR_CONDITIONS_NOT_ACCEPTED_AGB', '* We cannot accept your order if you do not accept our General Business Conditions!');
define('ERROR_CONDITIONS_NOT_ACCEPTED_WITHDRAWAL', '* We cannot accept your order if you do not accept our Right of Withdrawal Conditions!');

define('GM_CONFIRMATION_PRIVACY', 'Show privacy conditions');
define('GM_CONFIRMATION_CONDITIONS', 'Show general terms and conditions');
define('GM_CONFIRMATION_WITHDRAWAL', 'Show right of withdrawal conditions');

define('NAVBAR_TITLE_WISHLIST', 'Wish list');

// JS Meldung -> keine HTML-Umlaute!
define('GM_WISHLIST_NOTHING_CHECKED', 'Please select the products you wish to buy!');
define('JS_ERROR_CONDITIONS_NOT_ACCEPTED_AGB', 'We cannot accept your order if you do not accept our General Business Conditions!\n\n');
define('JS_ERROR_CONDITIONS_NOT_ACCEPTED_WITHDRAWAL', 'We cannot accept your order if you do not accept our Right of Withdrawal Conditions!\n\n');

define('GM_PAYPAL_ERROR', '<br />The payment via PayPal was canceled. Please choose another payment method.');
define('GM_PAYPAL_SESSION_ERROR', 'Your session has expired, please try to place your order again.');
define('GM_PAYPAL_UNALLOWED_COUNTRY_ERROR', 'The country of your address selected on the PayPal web site is not allowed in this store.');
define('GM_PAYPAL_ERROR_10001', 'PayPal reports an internal error. Pleas try again later.');
define('GM_PAYPAL_ERROR_10422', 'You must return to the PayPal website and select a different payment method');
define('GM_PAYPAL_ERROR_10445', 'This transaction cannot be processed at this time. Please try again later.');
define('GM_PAYPAL_ERROR_10525', 'This transaction cannot be processed. The amount to be charged is zero. Please contact the store owner.');
define('GM_PAYPAL_ERROR_10725', 'There was an error in the shipping address country field.');
define('GM_PAYPAL_ERROR_10729', 'There\'s an error with this transaction. Please enter your state in the shipping address.');
define('GM_PAYPAL_ERROR_10736', 'A match of the Shipping Address City, State, and Postal Code failed.');
define('PAYPAL_ERROR','PayPal abort');
	
define('GM_MESSAGE_NO_RESULT', 'No result');
define('GM_PAGE', 'Page');
define('GM_TITLE_EBAY', 'My eBay Item');
define('TEXT_OPENSEARCH', 'The instant search is only available for Internet Explorer 7 and Mozilla Firefox.');

include(DIR_WS_LANGUAGES . 'english/gm_logger.php');
include(DIR_WS_LANGUAGES . 'english/gm_shopping_cart.php');
include(DIR_WS_LANGUAGES . 'english/gm_account_delete.php');
include(DIR_WS_LANGUAGES . 'english/gm_price_offer.php');
include(DIR_WS_LANGUAGES . 'english/gm_tell_a_friend.php');
include(DIR_WS_LANGUAGES . 'english/gm_callback_service.php');

// EOF GM_MOD

define('GM_EBAY_FORWARD', 'Forward');
define('GM_REVIEWS_WRONG_CODE', 'Incorrect code!');
define('GM_REVIEWS_VALIDATION', 'Please enter the code shown in the image to the right');
define('GM_SHOW_NO_PRICE', 'Not for sale');
define('GM_SHOW_PRICE_ON_REQUEST', 'Price on request');

//NEW
define('GM_EBAY_BACK', 'Back');
define('GM_REVIEWS_TOO_SHORT', 'Your review is too short; %s characters are required.');

/* BOF GM CUSTOMER UPLOAD FIELDS */
define('ENTRY_CUSTOMER_UPLOAD_TEXT',			'*');
define('CUSTOMER_UPLOAD_ERROR',					'Error! ');
define('CUSTOMER_UPLOAD_ERROR_WRONG_FILE_TYP',	'Allowed Filetypes: ');
define('CUSTOMER_UPLOAD_ERROR_FILE_REQUIRED',	'Choose a File');
/* EOF GM CUSTOMER UPLOAD FIELDS */

// product_info standard tab-text
define('PRODUCT_DESCRIPTION', 'Product description');

define('ERROR_INVALID_SHIPPING_COUNTRY', 'Shipping in the selected shipping destination country is not possible.');
define('ERROR_INVALID_PAYMENT_COUNTRY', 'The country of your billing address is not allowed.');
?>