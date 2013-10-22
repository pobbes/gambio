<?php
/* --------------------------------------------------------------
   configuration.php 2012-12-06 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(configuration.php,v 1.8 2002/01/04); www.oscommerce.com
   (c) 2003	 nextcommerce (configuration.php,v 1.16 2003/08/25); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: configuration.php 1286 2005-10-07 10:10:18Z mz $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

// BOF GM_MOD
define('HEADING_SUB_TITLE', 'Configuration');
// EOF GM_MOD

define('TABLE_HEADING_CONFIGURATION_TITLE', 'Title');
define('TABLE_HEADING_CONFIGURATION_VALUE', 'Value');
define('TABLE_HEADING_ACTION', 'Action');

define('TEXT_INFO_EDIT_INTRO', 'Please make any necessary changes');
define('TEXT_INFO_DATE_ADDED', 'Date Added:');
define('TEXT_INFO_LAST_MODIFIED', 'Last Modified:');

// language definitions for config
define('STORE_NAME_TITLE' , 'Store Name');
define('STORE_NAME_DESC' , 'My store name');
define('STORE_OWNER_TITLE' , 'Store Owner');
define('STORE_OWNER_DESC' , 'The name of my store owner');
define('STORE_OWNER_EMAIL_ADDRESS_TITLE' , 'Email Address');
define('STORE_OWNER_EMAIL_ADDRESS_DESC' , 'The email address of my store owner');

define('EMAIL_FROM_TITLE' , 'Email from');
define('EMAIL_FROM_DESC' , 'The Email address used in (sent) emails.');

define('STORE_COUNTRY_TITLE' , 'Country');
define('STORE_COUNTRY_DESC' , 'The country in which my store is located <br /><br /><b>Note: Please remember to update the store zone.</b>');
define('STORE_ZONE_TITLE' , 'Zone');
define('STORE_ZONE_DESC' , 'The zone in which my store is located.');

define('EXPECTED_PRODUCTS_SORT_TITLE' , 'Expected Products Sort Order');
define('EXPECTED_PRODUCTS_SORT_DESC' , 'This is the sort order used in the expected product announcement box.');
define('EXPECTED_PRODUCTS_FIELD_TITLE' , 'Expected Product Sort Field');
define('EXPECTED_PRODUCTS_FIELD_DESC' , 'The column to sort by in the expected product announcement box.');

define('USE_DEFAULT_LANGUAGE_CURRENCY_TITLE' , 'Switch to Default Language Currency');
define('USE_DEFAULT_LANGUAGE_CURRENCY_DESC' , 'Automatically switch to the currency of the language when it is changed.');

define('SEND_EXTRA_ORDER_EMAILS_TO_TITLE' , 'Send extra order emails to:');
define('SEND_EXTRA_ORDER_EMAILS_TO_DESC' , 'Send extra order emails to the following email addresses in this format: Name1 &lt;email@address1&gt;, Name2 &lt;email@address2&gt;');

define('SEARCH_ENGINE_FRIENDLY_URLS_TITLE' , 'Use Search Engine Safe URLs?');
define('SEARCH_ENGINE_FRIENDLY_URLS_DESC' , 'Use search engine safe urls for all site links. Make sure mod_rewrite is installed on your web space.');

define('DISPLAY_CART_TITLE' , 'Display Cart After Adding a Product?');
define('DISPLAY_CART_DESC' , 'Display the shopping cart after adding a product, switch to cart or remain on the current page?');

define('ALLOW_GUEST_TO_TELL_A_FRIEND_TITLE' , 'Allow Guest To Tell a Friend?');
define('ALLOW_GUEST_TO_TELL_A_FRIEND_DESC' , 'Allow guests to tell a friend about a product?');

define('ADVANCED_SEARCH_DEFAULT_OPERATOR_TITLE' , 'Default Search Operator');
define('ADVANCED_SEARCH_DEFAULT_OPERATOR_DESC' , 'Default search operators.');

define('STORE_NAME_ADDRESS_TITLE' , 'Store address and phone number');
define('STORE_NAME_ADDRESS_DESC' , 'This is the store name, address and phone number used on printable documents and displayed online.');

define('SHOW_COUNTS_TITLE' , 'Show Category Counts');
define('SHOW_COUNTS_DESC' , 'Count recursively how many products are in each category');

define('DISPLAY_PRICE_WITH_TAX_TITLE' , 'Display Prices incl. tax');
define('DISPLAY_PRICE_WITH_TAX_DESC' , 'Display prices with tax included (true) or add the tax at the end (false)');

define('DEFAULT_CUSTOMERS_STATUS_ID_ADMIN_TITLE' , 'Customer Group for the Administrators');
define('DEFAULT_CUSTOMERS_STATUS_ID_ADMIN_DESC' , 'Choose the customer group the administrators!');
define('DEFAULT_CUSTOMERS_STATUS_ID_GUEST_TITLE' , 'Customer Group Guest');
define('DEFAULT_CUSTOMERS_STATUS_ID_GUEST_DESC' , 'What would the default customer group be for a guest before he/she logged in?');
define('DEFAULT_CUSTOMERS_STATUS_ID_TITLE' , 'Customer Group for New Customers');
define('DEFAULT_CUSTOMERS_STATUS_ID_DESC' , 'What would the default customer group be for a new customer?');

define('ALLOW_ADD_TO_CART_TITLE' , 'Allow add to cart');
define('ALLOW_ADD_TO_CART_DESC' , 'Allow customers to add products to the cart if the group setting for "show prices" is set to 0');
define('ALLOW_DISCOUNT_ON_PRODUCTS_ATTRIBUTES_TITLE' , 'Allow discount on product attribute?');
define('ALLOW_DISCOUNT_ON_PRODUCTS_ATTRIBUTES_DESC' , 'Allow customers to obtain discounts on attribute price (if main product is not a "special" product)');
define('CURRENT_TEMPLATE_TITLE' , 'Template set (theme)');
define('CURRENT_TEMPLATE_DESC' , 'Choose a template set (theme). The theme must be saved in the following folder: www.Your-Domain.com/templates/');

define('CC_KEYCHAIN_TITLE','CC String');
define('CC_KEYCHAIN_DESC','String to encrypt CC number (please change!)');

define('ENTRY_FIRST_NAME_MIN_LENGTH_TITLE' , 'First Name');
define('ENTRY_FIRST_NAME_MIN_LENGTH_DESC' , 'Minimum length of first name');
define('ENTRY_LAST_NAME_MIN_LENGTH_TITLE' , 'Last Name');
define('ENTRY_LAST_NAME_MIN_LENGTH_DESC' , 'Minimum length of last name');
define('ENTRY_DOB_MIN_LENGTH_TITLE' , 'Date of Birth');
define('ENTRY_DOB_MIN_LENGTH_DESC' , 'Minimum length of date of birth');
define('ENTRY_EMAIL_ADDRESS_MIN_LENGTH_TITLE' , 'Email Address');
define('ENTRY_EMAIL_ADDRESS_MIN_LENGTH_DESC' , 'Minimum length of email address');
define('ENTRY_STREET_ADDRESS_MIN_LENGTH_TITLE' , 'Street Address');
define('ENTRY_STREET_ADDRESS_MIN_LENGTH_DESC' , 'Minimum length of street address');
define('ENTRY_COMPANY_MIN_LENGTH_TITLE' , 'Company');
define('ENTRY_COMPANY_MIN_LENGTH_DESC' , 'Minimum length of company name');
define('ENTRY_POSTCODE_MIN_LENGTH_TITLE' , 'Postcode (ZIP)');
define('ENTRY_POSTCODE_MIN_LENGTH_DESC' , 'Minimum length of postcode (ZIP)');
define('ENTRY_CITY_MIN_LENGTH_TITLE' , 'City');
define('ENTRY_CITY_MIN_LENGTH_DESC' , 'Minimum length of city');
define('ENTRY_STATE_MIN_LENGTH_TITLE' , 'State');
define('ENTRY_STATE_MIN_LENGTH_DESC' , 'Minimum length of state');
define('ENTRY_TELEPHONE_MIN_LENGTH_TITLE' , 'Telephone Number');
define('ENTRY_TELEPHONE_MIN_LENGTH_DESC' , 'Minimum length of telephone number');
define('ENTRY_PASSWORD_MIN_LENGTH_TITLE' , 'Password');
define('ENTRY_PASSWORD_MIN_LENGTH_DESC' , 'Minimum length of password');

define('CC_OWNER_MIN_LENGTH_TITLE' , 'Credit Card Owner Name');
define('CC_OWNER_MIN_LENGTH_DESC' , 'Minimum length of credit card owner name');
define('CC_NUMBER_MIN_LENGTH_TITLE' , 'Credit Card Number');
define('CC_NUMBER_MIN_LENGTH_DESC' , 'Minimum length of credit card number');

define('REVIEW_TEXT_MIN_LENGTH_TITLE' , 'Reviews');
define('REVIEW_TEXT_MIN_LENGTH_DESC' , 'Minimum length of review text');

define('MIN_DISPLAY_BESTSELLERS_TITLE' , 'Best Sellers');
define('MIN_DISPLAY_BESTSELLERS_DESC' , 'Minimum number of best sellers to display');
define('MIN_DISPLAY_ALSO_PURCHASED_TITLE' , 'Also Purchased');
define('MIN_DISPLAY_ALSO_PURCHASED_DESC' , 'Minimum number of products to display in the "This Customer Also Purchased" box');

define('MAX_ADDRESS_BOOK_ENTRIES_TITLE' , 'Address Book Entries');
define('MAX_ADDRESS_BOOK_ENTRIES_DESC' , 'Maximum address book entries a customer is allowed to have');
define('MAX_DISPLAY_SEARCH_RESULTS_TITLE' , 'Search Results');
define('MAX_DISPLAY_SEARCH_RESULTS_DESC' , 'Number of products to list');
define('MAX_DISPLAY_PAGE_LINKS_TITLE' , 'Page Links');
define('MAX_DISPLAY_PAGE_LINKS_DESC' , 'Number of "number" links use for page sets');
define('MAX_DISPLAY_SPECIAL_PRODUCTS_TITLE' , 'Special Products');
define('MAX_DISPLAY_SPECIAL_PRODUCTS_DESC' , 'Maximum number of products on special to view');
define('MAX_DISPLAY_NEW_PRODUCTS_TITLE' , 'New Products Module');
define('MAX_DISPLAY_NEW_PRODUCTS_DESC' , 'Maximum number of new products to display in a category <img src="images/gm_icons/warning.png" height="16" width="16" class="template_warning" />');
define('MAX_DISPLAY_UPCOMING_PRODUCTS_TITLE' , 'New Products');
define('MAX_DISPLAY_UPCOMING_PRODUCTS_DESC' , 'Maximum number of new products to be displayed');
define('MAX_DISPLAY_MANUFACTURERS_IN_A_LIST_TITLE' , 'Manufacturer List Threshold');
define('MAX_DISPLAY_MANUFACTURERS_IN_A_LIST_DESC' , 'Used in the manufacturer box; when the number of manufacturers exceeds this number, a drop down list will be displayed instead of the default list');
define('MAX_MANUFACTURERS_LIST_TITLE' , 'Manufacturer List');
define('MAX_MANUFACTURERS_LIST_DESC' , 'Used in the manufacturer box; when this value is "1" the standard drop down list will be used for the manufacturer box, or a list box with the specified number of rows will be displayed.');
define('MAX_DISPLAY_MANUFACTURER_NAME_LEN_TITLE' , 'Length of Manufacturer Name');
define('MAX_DISPLAY_MANUFACTURER_NAME_LEN_DESC' , 'Used in the manufacturer box; maximum length of manufacturer name');
define('MAX_DISPLAY_NEW_REVIEWS_TITLE' , 'New Reviews');
define('MAX_DISPLAY_NEW_REVIEWS_DESC' , 'Maximum number of new reviews to display');
define('MAX_RANDOM_SELECT_REVIEWS_TITLE' , 'Selection of Random Reviews');
define('MAX_RANDOM_SELECT_REVIEWS_DESC' , 'How many records to select from to choose one random product review');
define('MAX_RANDOM_SELECT_NEW_TITLE' , 'Selection of Random New Products');
define('MAX_RANDOM_SELECT_NEW_DESC' , 'How many records to select from to choose one random new product to view');
define('MAX_RANDOM_SELECT_SPECIALS_TITLE' , 'Selection of Products on Special');
define('MAX_RANDOM_SELECT_SPECIALS_DESC' , 'How many records to select from to choose one random product special to view');
define('MAX_DISPLAY_CATEGORIES_PER_ROW_TITLE' , 'Categories to List Per Row');
define('MAX_DISPLAY_CATEGORIES_PER_ROW_DESC' , 'How many categories to list per row');
define('MAX_DISPLAY_PRODUCTS_NEW_TITLE' , 'New Products Listing');
define('MAX_DISPLAY_PRODUCTS_NEW_DESC' , 'Maximum number of new products to display on the new products page');
define('MAX_DISPLAY_BESTSELLERS_TITLE' , 'Best Sellers');
define('MAX_DISPLAY_BESTSELLERS_DESC' , 'Maximum number of best sellers to display');
define('MAX_DISPLAY_ALSO_PURCHASED_TITLE' , 'Also Purchased');
define('MAX_DISPLAY_ALSO_PURCHASED_DESC' , 'Maximum number of products to display in the "This Customer Also Purchased" box');
define('MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX_TITLE' , 'Customer Order History Box');
define('MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX_DESC' , 'Maximum number of products to display in the customer order history box');
define('MAX_DISPLAY_ORDER_HISTORY_TITLE' , 'Order History');
define('MAX_DISPLAY_ORDER_HISTORY_DESC' , 'Maximum number of orders to display on the order history page');
define('MAX_PRODUCTS_QTY_TITLE', 'Maximum Quantity');
define('MAX_PRODUCTS_QTY_DESC', 'Maximum quantity input length');
define('MAX_DISPLAY_NEW_PRODUCTS_DAYS_TITLE' , 'Maximum days for new products');
define('MAX_DISPLAY_NEW_PRODUCTS_DAYS_DESC' , 'Maximum number of days to view new products');


define('PRODUCT_IMAGE_THUMBNAIL_WIDTH_TITLE' , 'Width of Product Thumbnails');
define('PRODUCT_IMAGE_THUMBNAIL_WIDTH_DESC' , 'Maximum width of product thumbnails in pixels');
define('PRODUCT_IMAGE_THUMBNAIL_HEIGHT_TITLE' , 'Height of Product Thumbnails');
define('PRODUCT_IMAGE_THUMBNAIL_HEIGHT_DESC' , 'Maximum height of product thumbnails in pixels');

define('PRODUCT_IMAGE_INFO_WIDTH_TITLE' , 'Width of Product Info Images');
define('PRODUCT_IMAGE_INFO_WIDTH_DESC' , 'Maximum width of product info images in pixels');
define('PRODUCT_IMAGE_INFO_HEIGHT_TITLE' , 'Height of Product Info Images');
define('PRODUCT_IMAGE_INFO_HEIGHT_DESC' , 'Maximum height of product info images in pixels');

define('PRODUCT_IMAGE_POPUP_WIDTH_TITLE' , 'Width of Pop-up Images');
define('PRODUCT_IMAGE_POPUP_WIDTH_DESC' , 'Maximum width of pop-up images in pixels');
define('PRODUCT_IMAGE_POPUP_HEIGHT_TITLE' , 'Height of Pop-up Images');
define('PRODUCT_IMAGE_POPUP_HEIGHT_DESC' , 'Maximum height of pop-up images in pixels');

define('SMALL_IMAGE_WIDTH_TITLE' , 'Small Image Width');
define('SMALL_IMAGE_WIDTH_DESC' , 'The pixel width of small images');
define('SMALL_IMAGE_HEIGHT_TITLE' , 'Small Image Height');
define('SMALL_IMAGE_HEIGHT_DESC' , 'The pixel height of small images');

define('HEADING_IMAGE_WIDTH_TITLE' , 'Heading Image Width');
define('HEADING_IMAGE_WIDTH_DESC' , 'The pixel width of header images');
define('HEADING_IMAGE_HEIGHT_TITLE' , 'Heading Image Height');
define('HEADING_IMAGE_HEIGHT_DESC' , 'The pixel height of header images');

define('SUBCATEGORY_IMAGE_WIDTH_TITLE' , 'Sub-category Image Width');
define('SUBCATEGORY_IMAGE_WIDTH_DESC' , 'The pixel width of sub-category images');
define('SUBCATEGORY_IMAGE_HEIGHT_TITLE' , 'Sub-category Image Height');
define('SUBCATEGORY_IMAGE_HEIGHT_DESC' , 'The pixel height of sub-category images');

define('CONFIG_CALCULATE_IMAGE_SIZE_TITLE' , 'Calculate Image Size');
define('CONFIG_CALCULATE_IMAGE_SIZE_DESC' , 'Calculate the size of images');

define('IMAGE_REQUIRED_TITLE' , 'Image Required');
define('IMAGE_REQUIRED_DESC' , 'Enable the display of broken images. Good for developers.');

//This is for the Images showing your products for preview. All the small stuff.

define('PRODUCT_IMAGE_THUMBNAIL_BEVEL_TITLE' , 'Product Thumbnails:Bevel<br /><img src="images/config_bevel.gif">');
define('PRODUCT_IMAGE_THUMBNAIL_BEVEL_DESC' , 'Product Thumbnails:Bevel<br /><br />Default values: (8,FFCCCC,330000)<br /><br />shaded beveled edges<br />Usage:<br />(edge width, hex light color, hex dark color)');
define('PRODUCT_IMAGE_THUMBNAIL_GREYSCALE_TITLE' , 'Product Thumbnails:Greyscale<br /><img src="images/config_greyscale.gif">');
define('PRODUCT_IMAGE_THUMBNAIL_GREYSCALE_DESC' , 'Product Thumbnails:Greyscale<br /><br />Default values: (32,22,22)<br /><br />basic black and white<br />Usage:<br />(int red, int green, int blue)');
define('PRODUCT_IMAGE_THUMBNAIL_ELLIPSE_TITLE' , 'Product Thumbnails:Ellipse<br /><img src="images/config_eclipse.gif">');
define('PRODUCT_IMAGE_THUMBNAIL_ELLIPSE_DESC' , 'Product Thumbnails:Ellipse<br /><br />Default values: (FFFFFF)<br /><br />ellipse on bg color<br />Usage:<br />(hex background color)');
define('PRODUCT_IMAGE_THUMBNAIL_ROUND_EDGES_TITLE' , 'Product Thumbnails:Round edges<br /><img src="images/config_edge.gif">');
define('PRODUCT_IMAGE_THUMBNAIL_ROUND_EDGES_DESC' , 'Product Thumbnails:Round edges<br /><br />Default values: (5,FFFFFF,3)<br /><br />corner trimming<br />Usage:<br />(edge_radius, background color, anti-alias width)');
define('PRODUCT_IMAGE_THUMBNAIL_MERGE_TITLE' , 'Product Thumbnails:Merge<br /><img src="images/config_merge.gif">');
define('PRODUCT_IMAGE_THUMBNAIL_MERGE_DESC' , 'Product Thumbnails:Merge<br /><br />Default values: (overlay.gif,10,-50,60,FF0000)<br /><br />overlay merge image<br />Usage:<br />(merge image, x start [neg = from right], y start [neg = from base], opacity, transparent color on merge image)');
define('PRODUCT_IMAGE_THUMBNAIL_FRAME_TITLE' , 'Product Thumbnails:Frame<br /><img src="images/config_frame.gif">');
define('PRODUCT_IMAGE_THUMBNAIL_FRAME_DESC' , 'Product Thumbnails:Frame<br /><br />Default values: (FFFFFF,000000,3,EEEEEE)<br /><br />plain raised border<br />Usage:<br />(hex light color, hex dark color, int width of mid bit, hex frame color [optional - defaults to halfway between light and dark edges])');
define('PRODUCT_IMAGE_THUMBNAIL_DROP_SHADDOW_TITLE' , 'Product Thumbnails:Drop Shadow<br /><img src="images/config_shadow.gif">');
define('PRODUCT_IMAGE_THUMBNAIL_DROP_SHADDOW_DESC' , 'Product Thumbnails:Drop Shadow<br /><br />Default values: (3,333333,FFFFFF)<br /><br />more like a dodgy motion blur [semi buggy]<br />Usage:<br />(shadow width, hex shadow color, hex background color)');
define('PRODUCT_IMAGE_THUMBNAIL_MOTION_BLUR_TITLE' , 'Product Thumbnails:Motion Blur<br /><img src="images/config_motion.gif">');
define('PRODUCT_IMAGE_THUMBNAIL_MOTION_BLUR_DESC' , 'Product Thumbnails:Motion Blur<br /><br />Default values: (4,FFFFFF)<br /><br />fading parallel lines<br />Usage:<br />(int number of lines, hex background color)');

//And this is for the Images showing your products in single-view

define('PRODUCT_IMAGE_INFO_BEVEL_TITLE' , 'Product Images:Bevel');
define('PRODUCT_IMAGE_INFO_BEVEL_DESC' , 'Product Images:Bevel<br /><br />Default values: (8,FFCCCC,330000)<br /><br />shaded beveled edges<br />Usage:<br />(edge width, hex light color, hex dark color)');
define('PRODUCT_IMAGE_INFO_GREYSCALE_TITLE' , 'Product Images:Greyscale');
define('PRODUCT_IMAGE_INFO_GREYSCALE_DESC' , 'Product Images:Greyscale<br /><br />Default values: (32,22,22)<br /><br />basic black and white<br />Usage:<br />(int red, int green, int blue)');
define('PRODUCT_IMAGE_INFO_ELLIPSE_TITLE' , 'Product Images:Ellipse');
define('PRODUCT_IMAGE_INFO_ELLIPSE_DESC' , 'Product Images:Ellipse<br /><br />Default values: (FFFFFF)<br /><br />ellipse on bg color<br />Usage:<br />(hex background color)');
define('PRODUCT_IMAGE_INFO_ROUND_EDGES_TITLE' , 'Product Images:Round edges');
define('PRODUCT_IMAGE_INFO_ROUND_EDGES_DESC' , 'Product Images:Round edges<br /><br />Default values: (5,FFFFFF,3)<br /><br />corner trimming<br />Usage:<br />(edge_radius, background color, anti-alias width)');
define('PRODUCT_IMAGE_INFO_MERGE_TITLE' , 'Product Images:Merge');
define('PRODUCT_IMAGE_INFO_MERGE_DESC' , 'Product Images:Merge<br /><br />Default values: (overlay.gif,10,-50,60,FF0000)<br /><br />overlay merge image<br />Usage:<br />(merge image, x start [neg = from right], y start [neg = from base], opacity, transparent color on merge image)');
define('PRODUCT_IMAGE_INFO_FRAME_TITLE' , 'Product Images:Frame');
define('PRODUCT_IMAGE_INFO_FRAME_DESC' , 'Product Images:Frame<br /><br />Default values: (FFFFFF,000000,3,EEEEEE)<br /><br />plain raised border<br />Usage:<br />(hex light color, hex dark color, int width of mid bit, hex frame color [optional - defaults to halfway between light and dark edges])');
define('PRODUCT_IMAGE_INFO_DROP_SHADDOW_TITLE' , 'Product Images:Drop Shadow');
define('PRODUCT_IMAGE_INFO_DROP_SHADDOW_DESC' , 'Product Images:Drop Shadow<br /><br />Default values: (3,333333,FFFFFF)<br /><br />more like a dodgy motion blur [semi buggy]<br />Usage:<br />(shadow width, hex shadow color, hex background color)');
define('PRODUCT_IMAGE_INFO_MOTION_BLUR_TITLE' , 'Product Images:Motion Blur');
define('PRODUCT_IMAGE_INFO_MOTION_BLUR_DESC' , 'Product Images:Motion Blur<br /><br />Default values: (4,FFFFFF)<br /><br />fading parallel lines<br />Usage:<br />(int number of lines, hex background color)');

//so this image is the biggest in the shop this

define('PRODUCT_IMAGE_POPUP_BEVEL_TITLE' , 'Product Pop-up Images:Bevel');
define('PRODUCT_IMAGE_POPUP_BEVEL_DESC' , 'Product Pop-up Images:Bevel<br /><br />Default values: (8,FFCCCC,330000)<br /><br />shaded beveled edges<br />Usage:<br />(edge width, hex light color, hex dark color)');
define('PRODUCT_IMAGE_POPUP_GREYSCALE_TITLE' , 'Product Pop-up Images:Greyscale');
define('PRODUCT_IMAGE_POPUP_GREYSCALE_DESC' , 'Product Pop-up Images:Greyscale<br /><br />Default values: (32,22,22)<br /><br />basic black and white<br />Usage:<br />(int red, int green, int blue)');
define('PRODUCT_IMAGE_POPUP_ELLIPSE_TITLE' , 'Product Pop-up Images:Ellipse');
define('PRODUCT_IMAGE_POPUP_ELLIPSE_DESC' , 'Product Pop-up Images:Ellipse<br /><br />Default values: (FFFFFF)<br /><br />ellipse on bg color<br />Usage:<br />(hex background color)');
define('PRODUCT_IMAGE_POPUP_ROUND_EDGES_TITLE' , 'Product Pop-up Images:Round edges');
define('PRODUCT_IMAGE_POPUP_ROUND_EDGES_DESC' , 'Product Pop-up Images:Round edges<br /><br />Default values: (5,FFFFFF,3)<br /><br />corner trimming<br />Usage:<br />(edge_radius, background color, anti-alias width)');
define('PRODUCT_IMAGE_POPUP_MERGE_TITLE' , 'Product Pop-up Images:Merge');
define('PRODUCT_IMAGE_POPUP_MERGE_DESC' , 'Product Pop-up Images:Merge<br /><br />Default values: (overlay.gif,10,-50,60,FF0000)<br /><br />overlay merge image<br />Usage:<br />(merge image, x start [neg = from right], y start [neg = from base], opacity, transparent color on merge image)');
define('PRODUCT_IMAGE_POPUP_FRAME_TITLE' , 'Product Pop-up Images:Frame');
define('PRODUCT_IMAGE_POPUP_FRAME_DESC' , 'Product Pop-up Images:Frame<br /><br />Default values: (FFFFFF,000000,3,EEEEEE)<br /><br />plain raised border<br />Usage:<br />(hex light color, hex dark color, int width of mid bit, hex frame color [optional - defaults to halfway between light and dark edges])');
define('PRODUCT_IMAGE_POPUP_DROP_SHADDOW_TITLE' , 'Product Pop-up Images:Drop Shadow');
define('PRODUCT_IMAGE_POPUP_DROP_SHADDOW_DESC' , 'Product Pop-up Images:Drop Shadow<br /><br />Default values: (3,333333,FFFFFF)<br /><br />more like a dodgy motion blur [semi buggy]<br />Usage:<br />(shadow width, hex shadow color, hex background color)');
define('PRODUCT_IMAGE_POPUP_MOTION_BLUR_TITLE' , 'Product Pop-up Images:Motion Blur');
define('PRODUCT_IMAGE_POPUP_MOTION_BLUR_DESC' , 'Product Pop-up Images:Motion Blur<br /><br />Default values: (4,FFFFFF)<br /><br />fading parallel lines<br />Usage:<br />(int number of lines, hex background color)');

define('MO_PICS_TITLE','Number of product images');
define('MO_PICS_DESC','if this number is set > 0 , you will be able to upload/display more images per product');

define('IMAGE_MANIPULATOR_TITLE','GDlib processing');
define('IMAGE_MANIPULATOR_DESC','Image Manipulator for GD2 or GD1');

define('ACCOUNT_GENDER_TITLE' , 'Gender');
define('ACCOUNT_GENDER_DESC' , 'Display gender in the customer account');
define('ACCOUNT_DOB_TITLE' , 'Date of Birth');
define('ACCOUNT_DOB_DESC' , 'Display date of birth in the customer account');
define('ACCOUNT_COMPANY_TITLE' , 'Company');
define('ACCOUNT_COMPANY_DESC' , 'Display company in the customer account');
define('ACCOUNT_SUBURB_TITLE' , 'Suburb');
define('ACCOUNT_SUBURB_DESC' , 'Display suburb in the customer account');
define('ACCOUNT_STATE_TITLE' , 'State');
define('ACCOUNT_STATE_DESC' , 'Display state in the customer account');
define('ACCOUNT_TELEPHONE_TITLE' , 'Telephone number');
define('ACCOUNT_TELEPHONE_DESC' , 'Display telephone number on create account page');
define('ACCOUNT_FAX_TITLE' , 'Fax number');
define('ACCOUNT_FAX_DESC' , 'Display fax number on create account page');

define('DEFAULT_CURRENCY_TITLE' , 'Default Currency');
define('DEFAULT_CURRENCY_DESC' , 'Currency used as the default currency');
define('DEFAULT_LANGUAGE_TITLE' , 'Default Language');
define('DEFAULT_LANGUAGE_DESC' , 'Language used as the default language');
define('DEFAULT_ORDERS_STATUS_ID_TITLE' , 'Default Order Status');
define('DEFAULT_ORDERS_STATUS_ID_DESC' , 'Default order status when a new order is placed.');

define('SHIPPING_ORIGIN_COUNTRY_TITLE' , 'Country of Origin');
define('SHIPPING_ORIGIN_COUNTRY_DESC' , 'Select the country of origin to be used in shipping quotes.');
define('SHIPPING_ORIGIN_ZIP_TITLE' , 'Postcode (ZIP code)');
define('SHIPPING_ORIGIN_ZIP_DESC' , 'Enter the postcode (ZIP code) of the store to be used in shipping quotes.');
define('SHIPPING_MAX_WEIGHT_TITLE' , 'Enter the Maximum Package Weight You Will Ship');
define('SHIPPING_MAX_WEIGHT_DESC' , 'Carriers have a max weight limit for a single package. This is common to all.');
define('SHIPPING_BOX_WEIGHT_TITLE' , 'Package Tare Weight');
define('SHIPPING_BOX_WEIGHT_DESC' , 'What is the weight of typical packaging of small to medium packages?');
define('SHIPPING_BOX_PADDING_TITLE' , 'Larger Packages - Percentage Increase');
define('SHIPPING_BOX_PADDING_DESC' , 'For 10% enter 10');
define('SHOW_SHIPPING_DESC' , 'Show shipping costs link in product info');
define('SHOW_SHIPPING_TITLE' , 'Shipping Costs in Product Info');
define('SHIPPING_INFOS_DESC' , 'Group ID of shipping costs content.');
define('SHIPPING_INFOS_TITLE' , 'Group ID');

define('PRODUCT_LIST_FILTER_TITLE' , 'Display Category/Manufacturer Filter');
define('PRODUCT_LIST_FILTER_DESC' , 'Do you want to display the category/manufacturer filter (0=disable; 1=enable)?');

define('STOCK_CHECK_TITLE' , 'Check stock level');
define('STOCK_CHECK_DESC' , 'Check to see if there is sufficent stock available');

define('ATTRIBUTE_STOCK_CHECK_TITLE' , 'Check attribute stock level');
define('ATTRIBUTE_STOCK_CHECK_DESC' , 'Check to see if sufficent attribute stock is available');

define('STOCK_LIMITED_TITLE' , 'Subtract stock');
define('STOCK_LIMITED_DESC' , 'Subtract product in stock by product orders');
define('STOCK_ALLOW_CHECKOUT_TITLE' , 'Allow Checkout');
define('STOCK_ALLOW_CHECKOUT_DESC' , 'Allow customer to checkout even if there is insufficient stock');
define('STOCK_MARK_PRODUCT_OUT_OF_STOCK_TITLE' , 'Mark product out of stock');
define('STOCK_MARK_PRODUCT_OUT_OF_STOCK_DESC' , 'Provide an on-screen indication for the customer to indicate which product has insufficient stock');
define('STOCK_REORDER_LEVEL_TITLE' , 'Stock Re-order Level');
define('STOCK_REORDER_LEVEL_DESC' , 'Define when stock needs to be re-ordered');

define('STORE_PAGE_PARSE_TIME_TITLE' , 'Store Page Parse Time');
define('STORE_PAGE_PARSE_TIME_DESC' , 'Store the time it takes to parse a page');
define('STORE_PAGE_PARSE_TIME_LOG_TITLE' , 'Log Destination');
define('STORE_PAGE_PARSE_TIME_LOG_DESC' , 'Directory and filename of the page parse time log');
define('STORE_PARSE_DATE_TIME_FORMAT_TITLE' , 'Log Date Format');
define('STORE_PARSE_DATE_TIME_FORMAT_DESC' , 'The date format');

define('DISPLAY_PAGE_PARSE_TIME_TITLE' , 'Display The Page Parse Time');
define('DISPLAY_PAGE_PARSE_TIME_DESC' , 'Display the page parse time (store page parse time must be enabled)');

define('STORE_DB_TRANSACTIONS_TITLE' , 'Store Database Queries');
define('STORE_DB_TRANSACTIONS_DESC' , 'Store the database queries in the page parse time log (PHP4 only)');

define('USE_CACHE_TITLE' , 'Use Cache');
define('USE_CACHE_DESC' , 'Use caching features');

define('DB_CACHE_TITLE','Database Caching');
define('DB_CACHE_TITLE','If set to true, store can cache SELECT queries for a period of time to increase process speed');

define('DIR_FS_CACHE_TITLE' , 'Cache Directory');
define('DIR_FS_CACHE_DESC' , 'The directory where the cached files are saved');

define('ACCOUNT_OPTIONS_TITLE','Account Options');
define('ACCOUNT_OPTIONS_DESC','How do you want to manage your store login management?<br />You can choose between Customer Accounts and "One Time Orders" without creating a Customer Account (an account will be created, but the customer will not be notified)');

define('EMAIL_SIGNATURE_TITLE' , 'Email Signature in order mail');
define('EMAIL_SIGNATURE_DESC' , 'You can use the variables {$EMAIL_SIGNATURE_HTML} and {$EMAIL_SIGNATURE_TEXT} in the e-mail templates to insert this signature');

define('EMAIL_TRANSPORT_TITLE' , 'Email Transport Method');
define('EMAIL_TRANSPORT_DESC' , 'Defines if this server uses a local connection to the sendmail program or an SMTP connection via TCP/IP. Servers running on Windows and MacOS should change this setting to SMTP.');

define('SEND_EMAIL_BY_BILLING_ADRESS_TITLE' , 'Sender of the order confirmation e-mails');
define('SEND_EMAIL_BY_BILLING_ADRESS_DESC' , 'If you do not receive order confirmation emails, set this switch to <b>Owner E-Mail</b>.<br /><span style="color:red;">Before changing the settings, please try with a test order if confirmation emails will be sent!</span>');
define('EMAIL_LINEFEED_TITLE' , 'Email Line Feeds');
define('EMAIL_LINEFEED_DESC' , 'Defines the character sequence used to separate mail headers.');
define('EMAIL_USE_HTML_TITLE' , 'Use MIME HTML When Sending Emails');
define('EMAIL_USE_HTML_DESC' , 'Send emails in HTML format');
define('ENTRY_EMAIL_ADDRESS_CHECK_TITLE' , 'Verify Email Addresses Through DNS');
define('ENTRY_EMAIL_ADDRESS_CHECK_DESC' , 'Verify email address through a DNS server');
define('SEND_EMAILS_TITLE' , 'Send Emails');
define('SEND_EMAILS_DESC' , 'Send emails');
define('SENDMAIL_PATH_TITLE' , 'Sendmail Path');
define('SENDMAIL_PATH_DESC' , 'If you use sendmail, you should provide us with the correct path (default: /usr/bin/sendmail):');
define('SMTP_MAIN_SERVER_TITLE' , 'SMTP Server Address');
define('SMTP_MAIN_SERVER_DESC' , 'Please enter the address of your main SMTP server.');
define('SMTP_BACKUP_SERVER_TITLE' , 'SMTP Backup Server Address');
define('SMTP_BACKUP_SERVER_DESC' , 'Please enter the address of your backup SMTP server.');
define('SMTP_USERNAME_TITLE' , 'SMTP Username');
define('SMTP_USERNAME_DESC' , 'Please enter the username for your SMTP account.');
define('SMTP_PASSWORD_TITLE' , 'SMTP Password');
define('SMTP_PASSWORD_DESC' , 'Please enter the password for your SMTP account.');
define('SMTP_AUTH_TITLE' , 'SMTP AUTH');
define('SMTP_AUTH_DESC' , 'Does your SMTP server need secure authentication?');
define('SMTP_PORT_TITLE' , 'SMTP Port');
define('SMTP_PORT_DESC' , 'Please enter the SMTP port for your SMTP server (default: 25)?');

//Constants for contact_us
define('CONTACT_US_EMAIL_ADDRESS_TITLE' , 'Contact Us - Email Address');
define('CONTACT_US_EMAIL_ADDRESS_DESC' , 'Please enter an email address to use for normal "Contact Us" messages via the store to your office');
define('CONTACT_US_NAME_TITLE' , 'Contact Us - Email Address, Name');
define('CONTACT_US_NAME_DESC' , 'Please enter a name to use for normal "Contact Us" messages sent via the store to your office');
define('CONTACT_US_FORWARDING_STRING_TITLE' , 'Contact Us - Forwarding Addresses');
define('CONTACT_US_FORWARDING_STRING_DESC' , 'Please enter additional email addresses (comma separated) to which "Contact Us" messages sent via the store to your office can be forwarded.');
define('CONTACT_US_REPLY_ADDRESS_TITLE' , 'Contact Us - Reply Address');
define('CONTACT_US_REPLY_ADDRESS_DESC' , 'Please enter an email address to which customers can reply.');
define('CONTACT_US_REPLY_ADDRESS_NAME_TITLE' , 'Contact Us - Reply Address, Name');
define('CONTACT_US_REPLY_ADDRESS_NAME_DESC' , 'Sender name for reply emails.');
define('CONTACT_US_EMAIL_SUBJECT_TITLE' , 'Contact Us - Email Subject');
define('CONTACT_US_EMAIL_SUBJECT_DESC' , 'Please enter an email subject for the "Contact Us" messages via the store to your office.');

//Constants for support system
define('EMAIL_SUPPORT_ADDRESS_TITLE' , 'Technical Support - Email Address');
define('EMAIL_SUPPORT_ADDRESS_DESC' , 'Please enter an email address to use for sending emails over the <b>Support System</b> (account creation, password changes, etc.).');
define('EMAIL_SUPPORT_NAME_TITLE' , 'Technical Support - Email Address, Name');
define('EMAIL_SUPPORT_NAME_DESC' , 'Please enter a name to use for sending emails over the <b>Support System</b> (account creation, password changes).');
define('EMAIL_SUPPORT_FORWARDING_STRING_TITLE' , 'Technical Support - Forwarding Addresses');
define('EMAIL_SUPPORT_FORWARDING_STRING_DESC' , 'Please enter additional email addresses to which the emails from the <b>Support System</b> (comma separated) can be forwarded.');
define('EMAIL_SUPPORT_REPLY_ADDRESS_TITLE' , 'Technical Support - Reply Address');
define('EMAIL_SUPPORT_REPLY_ADDRESS_DESC' , 'Please enter an email address to which customers can reply.');
define('EMAIL_SUPPORT_REPLY_ADDRESS_NAME_TITLE' , 'Technical Support - Reply Address, Name');
define('EMAIL_SUPPORT_REPLY_ADDRESS_NAME_DESC' , 'Please enter an email address to which customers can reply.');
define('EMAIL_SUPPORT_SUBJECT_TITLE' , 'Technical Support - Email Subject');
define('EMAIL_SUPPORT_SUBJECT_DESC' , 'Please enter an email subject for the <b>Support System</b> messages via the store to your office.');

//Constants for Billing system
define('EMAIL_BILLING_ADDRESS_TITLE' , 'Billing - Email Address');
define('EMAIL_BILLING_ADDRESS_DESC' , 'Please enter an email address to use for sending emails over the <b>Billing system</b> (order confirmations, status changes, etc.).');
define('EMAIL_BILLING_NAME_TITLE' , 'Billing - Email Address, Name');
define('EMAIL_BILLING_NAME_DESC' , 'Please enter a name to use for sending emails over the <b>Billing System</b> (order confirmations, status changes, etc.).');
define('EMAIL_BILLING_FORWARDING_STRING_TITLE' , 'Billing - Forwarding Addresses');
define('EMAIL_BILLING_FORWARDING_STRING_DESC' , 'Please enter additional addresses to use for emails from the <b>Billing System</b> (comma separated)');
define('EMAIL_BILLING_REPLY_ADDRESS_TITLE' , 'Billing - Reply Address');
define('EMAIL_BILLING_REPLY_ADDRESS_DESC' , 'Please enter an email address to which your customers can reply.');
define('EMAIL_BILLING_REPLY_ADDRESS_NAME_TITLE' , 'Billing - Reply Address, Name');
define('EMAIL_BILLING_REPLY_ADDRESS_NAME_DESC' , 'Please enter a name to use for the email address for replies from your customers.');
define('EMAIL_BILLING_SUBJECT_TITLE' , 'Billing - Email Subject');
define('EMAIL_BILLING_SUBJECT_DESC' , 'Please enter an email subject for the <b>Billing</b> messages via the store to your office.');
define('EMAIL_BILLING_SUBJECT_ORDER_TITLE','Billing - Order Mail Subject');
define('EMAIL_BILLING_SUBJECT_ORDER_DESC','Please enter a subject for order mails generated from xtc. (like <b>our order {$nr},{$date}</b>) Note: you can use {$nr},{$date},{$firstname},{$lastname}');


define('DOWNLOAD_ENABLED_TITLE' , 'Enable download');
define('DOWNLOAD_ENABLED_DESC' , 'Enable the product download functions.');
define('DOWNLOAD_BY_REDIRECT_TITLE' , 'Download by redirect');
define('DOWNLOAD_BY_REDIRECT_DESC' , 'Use browser redirection to download. Disable on non-Unix systems.');
define('DOWNLOAD_MAX_DAYS_TITLE' , 'Expires (days)');
define('DOWNLOAD_MAX_DAYS_DESC' , 'Set number of days before the download link expires; 0 means no limit.');
define('DOWNLOAD_MAX_COUNT_TITLE' , 'Maximum number of downloads');
define('DOWNLOAD_MAX_COUNT_DESC' , 'Set the maximum number of downloads; 0 means no download authorized.');

define('GZIP_COMPRESSION_TITLE' , 'Enable GZip Compression');
define('GZIP_COMPRESSION_DESC' , 'Enable HTTP GZip compression.');
define('GZIP_LEVEL_TITLE' , 'Compression Level');
define('GZIP_LEVEL_DESC' , 'Use a compression level from 1 to 9 (1 = minimum, 9 = maximum).');
define('PREFER_GZHANDLER_TITLE', 'Prefer ob_gzhandler');
define('PREFER_GZHANDLER_DESC', 'Activate this option if GZip compression does not work by default.');

define('SESSION_WRITE_DIRECTORY_TITLE' , 'Session Directory');
define('SESSION_WRITE_DIRECTORY_DESC' , 'If sessions are file-based, store them in this directory.');
define('SESSION_FORCE_COOKIE_USE_TITLE' , 'Favor Cookie Use');
define('SESSION_FORCE_COOKIE_USE_DESC' , 'Start sessions if cookies are enabled.');
define('SESSION_CHECK_SSL_SESSION_ID_TITLE' , 'Check SSL Session ID');
define('SESSION_CHECK_SSL_SESSION_ID_DESC' , 'Validate the SSL_SESSION_ID at every secure HTTPS page request.');
define('SESSION_CHECK_USER_AGENT_TITLE' , 'Check User Agent');
define('SESSION_CHECK_USER_AGENT_DESC' , 'Validate the client\'s browser user agent at every page request.');
define('SESSION_CHECK_IP_ADDRESS_TITLE' , 'Check IP Address');
define('SESSION_CHECK_IP_ADDRESS_DESC' , 'Validate the client\'s IP address at every page request.');
define('SESSION_RECREATE_TITLE' , 'Recreate Session');
define('SESSION_RECREATE_DESC' , 'Recreate the session to generate a new session ID when the customer logs on or creates an account (PHP >=4.1 required).');

define('DISPLAY_CONDITIONS_ON_CHECKOUT_TITLE' , 'Display Conditions Check at Checkout');
define('DISPLAY_CONDITIONS_ON_CHECKOUT_DESC' , 'Display and sign the conditions during the order process');

define('META_MIN_KEYWORD_LENGTH_TITLE' , 'Min. meta keyword length');
define('META_MIN_KEYWORD_LENGTH_DESC' , 'Min. length of a single keyword (generated from the product description)');
define('META_KEYWORDS_NUMBER_TITLE' , 'Number of meta keywords');
define('META_KEYWORDS_NUMBER_DESC' , 'Number of keywords');
define('META_AUTHOR_TITLE' , 'author');
define('META_AUTHOR_DESC' , '<meta name="author">');
define('META_PUBLISHER_TITLE' , 'publisher');
define('META_PUBLISHER_DESC' , '<meta name="publisher">');
define('META_COMPANY_TITLE' , 'company');
define('META_COMPANY_DESC' , '<meta name="conpany">');
define('META_TOPIC_TITLE' , 'page-topic');
define('META_TOPIC_DESC' , '<meta name="page topic">');
define('META_REPLY_TO_TITLE' , 'reply-to');
define('META_REPLY_TO_DESC' , '<meta name="reply to">');
define('META_REVISIT_AFTER_TITLE' , 'revisit-after');
define('META_REVISIT_AFTER_DESC' , '<meta name="revisit after">');
define('META_ROBOTS_TITLE' , 'robots');
define('META_ROBOTS_DESC' , '<meta name="robots">');
define('META_DESCRIPTION_TITLE' , 'Description');
define('META_DESCRIPTION_DESC' , '<meta name="description">');
define('META_KEYWORDS_TITLE' , 'Keywords');
define('META_KEYWORDS_DESC' , '<meta name="keywords">');

define('MODULE_PAYMENT_INSTALLED_TITLE' , 'Installed Payment Modules');
define('MODULE_PAYMENT_INSTALLED_DESC' , 'List of payment module filenames separated by a semicolon. This is automatically updated; no need to edit. (Example: cc.php;cod.php;paypal.php)');
define('MODULE_ORDER_TOTAL_INSTALLED_TITLE' , 'Installed Order Total Modules');
define('MODULE_ORDER_TOTAL_INSTALLED_DESC' , 'List of order_total module filenames separated by a semicolon. This is automatically updated; no need to edit. (Example: ot_subtotal.php;ot_tax.php;ot_shipping.php;ot_total.php)');
define('MODULE_SHIPPING_INSTALLED_TITLE' , 'Installed Shipping Modules');
define('MODULE_SHIPPING_INSTALLED_DESC' , 'List of shipping module filenames separated by a semicolon. This is automatically updated; no need to edit. (Example: ups.php;flat.php;item.php)');

define('CACHE_LIFETIME_TITLE','Cache Lifetime');
define('CACHE_LIFETIME_DESC','This is the number of seconds cached content will persist');
define('CACHE_CHECK_TITLE','Check if cache modified');
define('CACHE_CHECK_DESC','If true, then If-Modified-Since headers are maintained with cached content and appropriate HTTP headers are sent. This ensures that repeated hits to a cached page do not send the entire page to the client every time.');

define('DB_CACHE_TITLE','DB Cache');
define('DB_CACHE_DESC','Cache SELECT query results in files to speed up slow databases.');

define('DB_CACHE_EXPIRE_TITLE','DB Cache lifetime');
define('DB_CACHE_EXPIRE_DESC','Time in seconds to rebuild cached results.');

define('PRODUCT_REVIEWS_VIEW_TITLE','Reviews in Product Details');
define('PRODUCT_REVIEWS_VIEW_DESC','Number of reviews displayed in the product details page');

define('DELETE_GUEST_ACCOUNT_TITLE','Deleting Guest Accounts');
define('DELETE_GUEST_ACCOUNT_DESC','Should guest accounts be deleted after placing orders? (Order data will be saved)');

define('USE_WYSIWYG_TITLE','Activate WYSIWYG Editor');
define('USE_WYSIWYG_DESC','Activate WYSIWYG editor for CMS and products');

define('PRICE_IS_BRUTTO_TITLE','Gross Admin');
define('PRICE_IS_BRUTTO_DESC','Use of prices with tax in admin');

define('PRICE_PRECISION_TITLE','Gross/Net Precision');
define('PRICE_PRECISION_DESC','Gross/Net precision');
define('CHECK_CLIENT_AGENT_TITLE','Prevent Spider Sessions');
define('CHECK_CLIENT_AGENT_DESC','Prevent known spiders from starting a session.');
define('SHOW_IP_LOG_TITLE','IP Log in Checkout?');
define('SHOW_IP_LOG_DESC','Show Text "Your IP will be saved", at checkout?');

define('ACTIVATE_GIFT_SYSTEM_TITLE','Activate Gift Voucher System');
define('ACTIVATE_GIFT_SYSTEM_DESC','Activate gift voucher system');

define('ACTIVATE_SHIPPING_STATUS_TITLE','Activate Shipping Status');
define('ACTIVATE_SHIPPING_STATUS_DESC','Activate shipping status? (Different dispatch times can be specified for individual products. A new item will appear after activation: <b>Delivery Status</b> at product input)');

define('SECURITY_CODE_LENGTH_TITLE','Security Code Length');
define('SECURITY_CODE_LENGTH_DESC','Security code length (gift voucher)');

define('IMAGE_QUALITY_TITLE','Image Quality');
define('IMAGE_QUALITY_DESC','Image quality (0= highest compression, 100=best quality)');

define('GROUP_CHECK_TITLE','Customer Status Check');
define('GROUP_CHECK_DESC','Only allow defined customer groups access to individual categories, products and content elements (after activation, input fields will appear in categories, products and in the content manager');

define('ACTIVATE_REVERSE_CROSS_SELLING_TITLE','Reverse Cross-selling');
define('ACTIVATE_REVERSE_CROSS_SELLING_DESC','Activate reverse cross-selling?');

define('ACTIVATE_NAVIGATOR_TITLE','Activate Product Navigator?');
define('ACTIVATE_NAVIGATOR_DESC','Activate/deactivate product navigator in product_info, (deactivate for enhanced performance with numerous products in the system)');

define('QUICKLINK_ACTIVATED_TITLE','Activate Multi-link/Copy Function');
define('QUICKLINK_ACTIVATED_DESC','The multi-link/copy function changes the handling for the "copy product to" action, it allows you to select multiple categories to copy/link a product with one click');

define('DOWNLOAD_UNALLOWED_PAYMENT_TITLE', 'Download Payment Modules');
define('DOWNLOAD_UNALLOWED_PAYMENT_DESC', 'Unauthorized payment modules for downloads. List, comma separated, e.g. {banktransfer,cod,invoice,moneyorder}');
define('DOWNLOAD_MIN_ORDERS_STATUS_TITLE', 'Min. Order Status');
define('DOWNLOAD_MIN_ORDERS_STATUS_DESC', 'Min. order status to allow download of files.');

// Vat Check
define('STORE_OWNER_VAT_ID_TITLE' , 'Store Owner VAT No.');
define('STORE_OWNER_VAT_ID_DESC' , 'The store owner VAT no.');
define('DEFAULT_CUSTOMERS_VAT_STATUS_ID_TITLE' , 'Customer Group - Correct VAT No. (foreign countries)');
define('DEFAULT_CUSTOMERS_VAT_STATUS_ID_DESC' , 'Customer group for customers with correct VAT no., store country != customer country');
define('ACCOUNT_COMPANY_VAT_CHECK_TITLE' , 'Validate VAT No.');
define('ACCOUNT_COMPANY_VAT_CHECK_DESC' , 'Validate VAT no. (check correct syntax)');
define('ACCOUNT_COMPANY_VAT_LIVE_CHECK_TITLE' , 'Validate VAT No. Live');
define('ACCOUNT_COMPANY_VAT_LIVE_CHECK_DESC' , 'Validate VAT no. live (if no syntax check available for country), live check will use validation gateway for the relevant country');
define('ACCOUNT_COMPANY_VAT_GROUP_TITLE' , 'Automatic Pruning?');
define('ACCOUNT_COMPANY_VAT_GROUP_DESC' , 'Set to true, the customer group will be changed automatically if a correct VAT no. is used.');
define('ACCOUNT_VAT_BLOCK_ERROR_TITLE' , 'Allow Incorrect VAT No.?');
define('ACCOUNT_VAT_BLOCK_ERROR_DESC' , 'Set to true, only validated VAT numbers will be accepted.');
define('DEFAULT_CUSTOMERS_VAT_STATUS_ID_LOCAL_TITLE','Customer Group - Correct VAT No. (Store Country)');
define('DEFAULT_CUSTOMERS_VAT_STATUS_ID_LOCAL_DESC','Customer group for customers with correct VAT no., store country = customer country');
// Google Conversion
define('GOOGLE_CONVERSION_TITLE','Google Conversion Tracking');
define('GOOGLE_CONVERSION_DESC','Track the conversion keywords at orders');
define('GOOGLE_CONVERSION_ID_TITLE','Conversion ID');
define('GOOGLE_CONVERSION_ID_DESC','Your Google conversion ID');
define('GOOGLE_CONVERSION_LABEL_TITLE','Conversion Label');
define('GOOGLE_CONVERSION_LABEL_DESC','Your Google Conversion Label');
define('GOOGLE_LANG_TITLE','Google Language');
define('GOOGLE_LANG_DESC','ISO code of language used');

// Afterbuy
define('AFTERBUY_ACTIVATED_TITLE','Active');
define('AFTERBUY_ACTIVATED_DESC','Activate afterbuy module');
define('AFTERBUY_PARTNERID_TITLE','Partner ID');
define('AFTERBUY_PARTNERID_DESC','Your afterbuy partner ID');
define('AFTERBUY_PARTNERPASS_TITLE','Partner Password');
define('AFTERBUY_PARTNERPASS_DESC','Your partner password for afterbuy XML module');
define('AFTERBUY_USERID_TITLE','User ID');
define('AFTERBUY_USERID_DESC','Your afterbuy user ID');
define('AFTERBUY_ORDERSTATUS_TITLE','Order Status');
define('AFTERBUY_ORDERSTATUS_DESC','Order status for exported orders');
define('AFTERBUY_URL','You will find detailed afterbuy info here: <a href="http://www.xt-commerce.com/modules/wfsection/dossier-65.html" target="new">http://www.xt-commerce.com/modules/wfsection/dossier-65.html</a>');

// Search-Options
define('SEARCH_IN_DESC_TITLE','Search in Product Descriptions');
define('SEARCH_IN_DESC_DESC','Activate to enable search in product descriptions');
define('SEARCH_IN_ATTR_TITLE','Search in Product Attributes');
define('SEARCH_IN_ATTR_DESC','Activate to enable search in product attributes');

// changes for 3.0.4 SP2
define('REVOCATION_ID_TITLE','Revocation ID');
define('REVOCATION_ID_DESC','Content ID of revocation content');
define('DISPLAY_REVOCATION_ON_CHECKOUT_TITLE','Display Right of Revocation?');
define('DISPLAY_REVOCATION_ON_CHECKOUT_DESC','Display right of revocation on checkout_confirmation?');

define('PAYPAL_MODE_TITLE','PayPal Mode:');
define('PAYPAL_MODE_DESC','Live or Test Mode');

define('PAYPAL_API_USER_TITLE','PayPal API User (Live)');
define('PAYPAL_API_USER_DESC','Enter the username here');

define('PAYPAL_API_PWD_TITLE','PayPal API Password (Live)');
define('PAYPAL_API_PWD_DESC','Enter the password here');

define('PAYPAL_API_SIGNATURE_TITLE','PayPal API Signature (Live)');
define('PAYPAL_API_SIGNATURE_DESC','Enter the API signature here');

define('PAYPAL_API_SANDBOX_USER_TITLE','PayPal API User (Sandbox)');
define('PAYPAL_API_SANDBOX_USER_DESC','Enter the username here');

define('PAYPAL_API_SANDBOX_PWD_TITLE','PayPal API Password (Sandbox)');
define('PAYPAL_API_SANDBOX_PWD_DESC','Enter the password here');

define('PAYPAL_API_SANDBOX_SIGNATURE_TITLE','PayPal API Signature (Sandbox)');
define('PAYPAL_API_SANDBOX_SIGNATURE_DESC','Enter the API signature here');

define('PAYPAL_ORDER_STATUS_TMP_ID_TITLE','Temporary Order Status');
define('PAYPAL_ORDER_STATUS_TMP_ID_DESC','Select the temporary order status');

define('PAYPAL_ORDER_STATUS_SUCCESS_ID_TITLE','Order Status OK');
define('PAYPAL_ORDER_STATUS_SUCCESS_ID_DESC','Select the order status for a successful transaction');

define('PAYPAL_ORDER_STATUS_PENDING_ID_TITLE','Order Status "In Progress"');
define('PAYPAL_ORDER_STATUS_PENDING_ID_DESC','Select the order status for a transaction that has not yet been processed by PayPal');

define('PAYPAL_ORDER_STATUS_REJECTED_ID_TITLE','Order Status "Rejected"');
define('PAYPAL_ORDER_STATUS_REJECTED_ID_DESC','Select the order status for a rejected transaction');



define('PAYPAL_SHOP_LOGO_TITLE','Shop logo');
define('PAYPAL_SHOP_LOGO_DESC','URL for the image you want to appear at the top left of the payment page.<br />The image has a maximum size of 750 pixels wide by 90 pixels high.<br />e.g. '.HTTP_SERVER.DIR_WS_CATALOG.DIR_WS_IMAGES.'logos/'.gm_get_conf('GM_LOGO_SHOP'));

define('PAYPAL_ERROR_EMAIL_ADDRESS_TITLE','PayPal Error Email Address');
define('PAYPAL_ERROR_EMAIL_ADDRESS_DESC','Enter the correct email address');



define('PAYPAL_EXPRESS_PAYMENTACTION_TITLE','PayPal Express Methods');
define('PAYPAL_EXPRESS_PAYMENTACTION_DESC','Select the PayPal express method here<br /><strong>Sale</strong> - This is a final sale for which you are requesting payment<br /><strong>Authorization</strong> - This payment is a basic authorization subject to settlement with PayPal Authorization and Capture.<br /><strong>Order</strong> - This payment is an order authorization subject to settlement with PayPal Authorization and Capture.');

define('PAYPAL_COUNTRY_MODE_TITLE','PayPal Country Mode');
define('PAYPAL_COUNTRY_MODE_DESC','Select the country mode setting. Some PayPal functions are only available in the UK (i.e. Direct Payment )');

define('PAYPAL_EXPRESS_ADDRESS_CHANGE_TITLE','PayPal Express Address Data');
define('PAYPAL_EXPRESS_ADDRESS_CHANGE_DESC','Allows customer to change the address data sent to you by PayPal');

define('PAYPAL_EXPRESS_ADDRESS_OVERRIDE_TITLE','Shipping Address');
define('PAYPAL_EXPRESS_ADDRESS_OVERRIDE_DESC','Allows you to change the address data sent to you by PayPal (existing account)');

// bof gm
define('GM_SET_OUT_OF_STOCK_PRODUCTS_TITLE',			'Deactivate Products');
define('GM_SET_OUT_OF_STOCK_PRODUCTS_DESC',				'Deactivate out-of-stock products?<br /><strong>Advice:</strong> Set &quot;Check stock level&quot; and &quot;Subtract stock&quot; on &quot;true&quot; and &quot;Allow Checkout&quot; on &quot;false&quot; to use this option.');

define('GM_SET_OUT_OF_STOCK_ATTRIBUTES_TITLE',			'Deactivate Attributes');
define('GM_SET_OUT_OF_STOCK_ATTRIBUTES_DESC',			'Hide attributes that are out of stock?<br /><strong>Advice:</strong> Also activate the following option to deactivate any out-of-stock products.');

define('GM_SET_OUT_OF_STOCK_ATTRIBUTES_SHOW_TITLE',		'Show Stock Attributes');
define('GM_SET_OUT_OF_STOCK_ATTRIBUTES_SHOW_DESC',		'Show stock attributes');

define('GM_LIVE_CHECK_NOT_READY',		'<br /><br /><font color="#ff0000"><strong>Attention!</strong></font> The php function fsockopen and curl are not available on this server, so you cannot use this option.');
//eof

// NEW
define('SEND_EXTRA_ORDER_E-MailS_TO_TITLE' , 'Send extra order emails to:');
define('SEND_EXTRA_ORDER_E-MailS_TO_DESC' , 'Send extra order emails to the following email addresses in this format: Name1 &lt;email@address1&gt;, Name2 &lt;email@address2&gt;');
// bof brickfox
define('MODULE_BRICKFOX_URL_TITLE' , 'URL');
define('MODULE_BRICKFOX_URL_DESC' , 'Enter the brickfox server URL here');
define('MODULE_BRICKFOX_PORT_TITLE' , 'Port');
define('MODULE_BRICKFOX_PORT_DESC' , 'Enter the Port for access to the brickfox server');
define('MODULE_BRICKFOX_USERNAME_TITLE' , 'brickfox User');
define('MODULE_BRICKFOX_USERNAME_DESC' , 'Enter the brickfox username here');
define('MODULE_BRICKFOX_PASSWORD_TITLE' , 'brickfox Password');
define('MODULE_BRICKFOX_PASSWORD_DESC' , 'Enter the brickfox password here');
define('MODULE_BRICKFOX_EXCLUDE_CATEGORIES_TITLE' , 'excluded  Categories');
define('MODULE_BRICKFOX_EXCLUDE_CATEGORIES_DESC' , 'Enter the exclude categories IDs here (comma separated)');
define('MODULE_BRICKFOX_EXCLUDE_PRODUCTS_TITLE' , 'excluded products');
define('MODULE_BRICKFOX_EXCLUDE_PRODUCTS_DESC' , 'Enter the item numbers of excluded products (comma separated)');
define('MODULE_BRICKFOX_STATUS_TITLE','active<br /><br /><img src="https://manager.brickfox.net/media/brickfox_logo.png?client=gambio&version=' . urlencode(PROJECT_VERSION) . '" width="82">');
define('MODULE_BRICKFOX_STATUS_DESC', '<br />You can find further information about our products
<a href="http://www.brickfox.de/multikanalvertrieb-produkte/online-marktplatz-marketing.html">Marketplace Connect</a> and <a href="http://www.brickfox.de/multikanalvertrieb-produkte/produktsuchmaschinen-marketing.html">Product Connect</a> on our website at <a href="http://www.brickfox.de">www.brickfox.de</a>. To make an inquiry please use our <a href="http://www.brickfox.de/kontakt/anfrage-online-vertrieb.html">inquiry form</a>.<br />');
//eof

define('HTTP_CACHING_TITLE', 'HTTP Caching');
define('HTTP_CACHING_DESC', 'By activating HTTP Caching the browser tries to load the javascripts from local cache first.');

define('LOG_SQL_FRONTEND_TITLE', 'SQL-Logging in Frontend');
define('LOG_SQL_FRONTEND_DESC', 'Log SQL-queries changing data in database.');
define('LOG_SQL_BACKEND_TITLE', 'SQL-Logging in Backend');
define('LOG_SQL_BACKEND_DESC', 'Log SQL-queries changing data in database.');
define('SQL_LOG_MAX_FILESIZE_TITLE', 'Maximum Filesize');
define('SQL_LOG_MAX_FILESIZE_DESC', 'Maximum filesize of the SQL-Logging file in MB.');

define('APPEND_PROPERTIES_MODEL_TITLE', 'Append properties model');
define('APPEND_PROPERTIES_MODEL_DESC', 'Append properties model to the products model instead of replacing it');
define('SHOW_PRODUCTS_MODEL_TITLE', 'Display products model in shopping cart or wish list');
define('SHOW_PRODUCTS_MODEL_DESC', 'Should the products model be displayed in the shopping cart or the wish list?');

define('GAMBIO_SHOP_KEY_TITLE', 'Gambio Shop-Key');
define('GAMBIO_SHOP_KEY_DESC', 'Please enter your Gambio Shop-Key, that you obtained through your login in our Gambio Customer Area at (<a href="http://www.gambio-support.de/" target="_blank">www.gambio-support.de</a>). By entering your Gambio Shop-Key in your shop administration, you gain many advantages: In the future, you will be notified about updates for your shop via the Admin-Infobox on the upper right of the administration . In order to process your support issues in a most efficient and fast way, we need several information about your shop, that is automatically submitted to our Gambio Customer Area, when you deposit your Shop-Key here. <br />
<br />
By entering your Gambio Shop-Key, they key itself, the URL to your online shop, the currently activated language in your online shop and relevant version information from your shop and installed modules (hereinafer referred to as &quot;shop data&quot;) will be transferred to the Customer Area. Your shop data will be transferred and updated automatically by your online shop, thus the data available for us is always up to date. <br />
<br />
Should you no longer want your shop to transfer your shop data to the Customer Area, click &#039;Delete Shop-Key&#039;. Despite the aforementioned data, no further information will be transferred. We will under no circumstances forward your shop data to third parties and only use it in the context that is necessary for providing the services or carrying out the contract. You may review the transmitted shop data anytime in the Customer Area and delete it as and when required.<br />
<br />
For details, please read our <a href="http://www.gambio.de/Datenschutzerklaerung.html" target="_blank"><u>privacy notice</u></a>.<br />
<br />
<a href="#" class="button" onclick="$(\'input[name=GAMBIO_SHOP_KEY]\').val(\'\'); $(\'form[name=configuration]\').submit(); return false;">Delete Shop-Key</a><br />
<br />
<br />
Following shop data will be transferred to the Customer Area:');
?>