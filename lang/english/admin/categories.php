<?php
/* --------------------------------------------------------------
   categories.php 2012-07-03 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(categories.php,v 1.22 2002/08/17); www.oscommerce.com
   (c) 2003	 nextcommerce (categories.php,v 1.10 2003/08/14); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: categories.php 1249 2005-09-27 12:06:40Z gwinger $)

   Released under the GNU General Public License
   --------------------------------------------------------------*/
 
define('TEXT_EDIT_STATUS', 'Status');
define('HEADING_TITLE', 'Categories / Products');
define('HEADING_TITLE_SEARCH', 'Search: ');
define('HEADING_TITLE_GOTO', 'Go To:');

// BOF GM_MOD
define('HEADING_SUB_TITLE', 'Catalog');
define('GM_TITLE_NO_ENTRY', 'No Entry.');
// EOF GM_MOD

define('TABLE_HEADING_ID', 'ID');
define('TABLE_HEADING_CATEGORIES_PRODUCTS', 'Categories / Products');
define('TABLE_HEADING_ACTION', 'Action');
define('TABLE_HEADING_STATUS', 'Status');
define('TABLE_HEADING_STARTPAGE', 'TOP');
define('TABLE_HEADING_STOCK','Stock Warning');
define('TABLE_HEADING_SORT','Sort');
define('TABLE_HEADING_MAX','Max.');
define('TABLE_HEADING_EDIT','Edit');

define('TEXT_ACTIVE_ELEMENT','Active Element');
define('TEXT_INFORMATIONS','Information');
define('TEXT_MARKED_ELEMENTS','Marked Element');
define('TEXT_INSERT_ELEMENT','New Element');

define('TEXT_WARN_MAIN','Main');
define('TEXT_NEW_PRODUCT', 'New Product in &quot;%s&quot;');
define('TEXT_CATEGORIES', 'Categories:');
define('TEXT_PRODUCTS', 'Products:');
define('TEXT_PRODUCTS_PRICE_INFO', 'Price:');
define('TEXT_PRODUCTS_TAX_CLASS', 'Tax Class:');
define('TEXT_PRODUCTS_AVERAGE_RATING', 'Average Rating:');
define('TEXT_PRODUCTS_QUANTITY_INFO', 'Quantity:');
define('TEXT_PRODUCTS_DISCOUNT_ALLOWED_INFO', 'Maximum Discound Allowed:');
define('TEXT_DATE_ADDED', 'Date Added:');
define('TEXT_DATE_AVAILABLE', 'Date Available:');
define('TEXT_LAST_MODIFIED', 'Last Modified:');
define('TEXT_IMAGE_NONEXISTENT', 'IMAGE DOES NOT EXIST');
define('TEXT_NO_CHILD_CATEGORIES_OR_PRODUCTS', 'Please insert a new category or product in <br />&nbsp;<br /><b>%s</b>');
define('TEXT_PRODUCT_MORE_INFORMATION', 'For more information, please visit the <a href="http://%s" target="blank"><u>web page</u></a> for this product.');
define('TEXT_PRODUCT_DATE_ADDED', 'This product was added to our catalog on %s.');
define('TEXT_PRODUCT_DATE_AVAILABLE', 'This product will be in stock on %s.');
define('TEXT_CHOOSE_INFO_TEMPLATE', 'Product Info Template:');
define('TEXT_CHOOSE_OPTIONS_TEMPLATE', 'Product Options Template:');
define('TEXT_SELECT', 'Please select:');

define('TEXT_EDIT_INTRO', 'Please make any necessary changes');
define('TEXT_EDIT_CATEGORIES_ID', 'Category ID:');
define('TEXT_EDIT_CATEGORIES_NAME', 'Category Name:');
define('TEXT_EDIT_CATEGORIES_HEADING_TITLE', 'Category Heading:');
define('TEXT_EDIT_CATEGORIES_DESCRIPTION', 'Category Description:');
define('TEXT_EDIT_CATEGORIES_IMAGE', 'Category Image:');

define('TEXT_EDIT_SORT_ORDER', 'Sort Order:');

define('TEXT_INFO_COPY_TO_INTRO', 'Please choose a new category you wish to copy this product to');
define('TEXT_INFO_CURRENT_CATEGORIES', 'Current Categories:');

define('TEXT_INFO_HEADING_NEW_CATEGORY', 'New Category');
define('TEXT_INFO_HEADING_EDIT_CATEGORY', 'Edit Category');
define('TEXT_INFO_HEADING_DELETE_CATEGORY', 'Delete Category');
define('TEXT_INFO_HEADING_MOVE_CATEGORY', 'Move Category');
define('TEXT_INFO_HEADING_DELETE_PRODUCT', 'Delete Product');
define('TEXT_INFO_HEADING_MOVE_PRODUCT', 'Move Product');
define('TEXT_INFO_HEADING_COPY_TO', 'Copy To');
define('TEXT_INFO_HEADING_MOVE_ELEMENTS', 'Move Elements');
define('TEXT_INFO_HEADING_DELETE_ELEMENTS', 'Delete Elements');

define('TEXT_DELETE_CATEGORY_INTRO', 'Are you sure you want to delete this category?');
define('TEXT_DELETE_PRODUCT_INTRO', 'Are you sure you want to permanently delete this product?');

define('TEXT_DELETE_WARNING_CHILDS', '<b>WARNING:</b> There are %s (child) categories still linked to this category!');
define('TEXT_DELETE_WARNING_PRODUCTS', '<b>WARNING:</b> There are %s products still linked to this category!');

define('TEXT_MOVE_WARNING_CHILDS', '<b>Warning:</b> There are %s (child) categories still linked to this category!');
define('TEXT_MOVE_WARNING_PRODUCTS', '<b>Warning:</b> There are %s products still linked to this category!');

define('TEXT_MOVE_PRODUCTS_INTRO', 'Please select in which category you want to place <b>%s</b>');
define('TEXT_MOVE_CATEGORIES_INTRO', 'Please select in which category you want to place <b>%s</b>');
define('TEXT_MOVE', 'Move <b>%s</b> to:');
define('TEXT_MOVE_ALL', 'Move all to:');

define('TEXT_NEW_CATEGORY_INTRO', 'Please complete the following information for the new category.');
define('TEXT_CATEGORIES_NAME', 'Category Name:');
define('TEXT_CATEGORIES_IMAGE', 'Category Image:');
define('TEXT_CATEGORIES_ICON', 'Category Icon:');

define('TEXT_META_TITLE', 'Meta Title:');
define('TEXT_META_DESCRIPTION', 'Meta Description:');
define('TEXT_META_KEYWORDS', 'Meta Keywords:');

define('TEXT_SORT_ORDER', 'Sort Order:');

define('TEXT_PRODUCTS_STATUS', 'Product Status:');
define('TEXT_PRODUCTS_STARTPAGE', 'Show on start page:');
define('TEXT_PRODUCTS_STARTPAGE_YES', 'Yes');
define('TEXT_PRODUCTS_STARTPAGE_NO', 'No');
define('TEXT_PRODUCTS_STARTPAGE_SORT', 'Sort Order (start page):');
define('TEXT_PRODUCTS_DATE_AVAILABLE', 'Date Available:');
define('TEXT_PRODUCT_AVAILABLE', 'In Stock');
define('TEXT_PRODUCT_NOT_AVAILABLE', 'Out of Stock');
define('TEXT_PRODUCTS_MANUFACTURER', 'Product Manufacturer:');
define('TEXT_PRODUCTS_NAME', 'Product Name:');
define('TEXT_PRODUCTS_DESCRIPTION', 'Product Description:');
define('TEXT_PRODUCTS_QUANTITY', 'Product Quantity:');
define('TEXT_PRODUCTS_MODEL', 'Product Model:');
define('TEXT_PRODUCTS_IMAGE', 'Product Image:');
define('TEXT_PRODUCTS_URL', 'Product URL:');
define('TEXT_PRODUCTS_URL_WITHOUT_HTTP', '<small>(without http://)</small>');
define('TEXT_PRODUCTS_PRICE', 'Product Price:');
define('TEXT_PRODUCTS_WEIGHT', 'Product Weight:');
define('TEXT_PRODUCTS_EAN','Barcode/EAN');
define('TEXT_PRODUCT_LINKED_TO','Linked to:');

define('TEXT_DELETE', 'Delete');

define('EMPTY_CATEGORY', 'Empty Category');

define('TEXT_HOW_TO_COPY', 'Copy Method:');
define('TEXT_COPY_AS_LINK', 'Link product');
define('TEXT_COPY_AS_DUPLICATE', 'Duplicate product');

define('ERROR_CANNOT_LINK_TO_SAME_CATEGORY', 'Error: Cannot link products in the same directory.');
define('ERROR_CATALOG_IMAGE_DIRECTORY_NOT_WRITEABLE', 'Error: Catalog images directory is not writeable: ' . DIR_FS_CATALOG_IMAGES);
define('ERROR_CATALOG_IMAGE_DIRECTORY_DOES_NOT_EXIST', 'Error: Catalog images directory does not exist: ' . DIR_FS_CATALOG_IMAGES);

define('TEXT_NO_TAX_RATE_BY_GIFT','Gifts: No tax class.');
define('TEXT_PRODUCTS_DISCOUNT_ALLOWED','Discount allowed:');
define('HEADING_PRICES_OPTIONS','<b>Price options</b>');
define('HEADING_PRODUCT_IMAGES','<b>Product Images</b>');
define('TEXT_PRODUCTS_WEIGHT_INFO','<small>(kg)</small>');
define('TEXT_PRODUCTS_ADD_TAB','Add tab');
define('TEXT_PRODUCTS_SHORT_DESCRIPTION','Short description:');
define('TEXT_PRODUCTS_KEYWORDS', 'Extra words for search:');
define('TXT_STK','units: ');
define('TXT_PRICE','a :');
define('TXT_NETTO','Net price: ');
define('TEXT_NETTO','Net: ');
define('TXT_STAFFELPREIS','Graduated Price');

define('HEADING_PRODUCTS_MEDIA','<b>Product Media</b>');
define('TABLE_HEADING_PRICE','Price');

define('TEXT_CHOOSE_INFO_TEMPLATE','Product detail template');
define('TEXT_SELECT','--Select--');
define('TEXT_CHOOSE_OPTIONS_TEMPLATE','Product options template');
define('SAVE_ENTRY','Save?');

define('TEXT_FSK18','FSK 18:');
define('TEXT_CHOOSE_INFO_TEMPLATE_CATEGORIE','Template for Category Listing');
define('TEXT_CHOOSE_INFO_TEMPLATE_LISTING','Template for Product Listing');
define('TEXT_PRODUCTS_SORT','Sorting:');
define('TEXT_EDIT_PRODUCT_SORT_ORDER','Product Sorting');
define('TEXT_QUANTITYUNIT','Quantity unit');
define('TXT_PRICES','Price');
define('TXT_NAME','Product name');
define('TXT_ORDERED','Products ordered');
define('TXT_SORT','Sort Order');
define('TXT_WEIGHT','Weight');
define('TXT_QTY','In Stock');

define('TEXT_MULTICOPY','Multiple');
define('TEXT_MULTICOPY_DESC','Copy elements into the following categories (if one box selected, single settings will be ignored.)');
define('TEXT_SINGLECOPY','Single');
define('TEXT_SINGLECOPY_DESC','Copy elements into the following category');
define('TEXT_SINGLECOPY_CATEGORY','Category:');

define('TEXT_PRODUCTS_VPE','Unit');
define('TEXT_PRODUCTS_VPE_VISIBLE','Show Unit Price:');
define('TEXT_PRODUCTS_VPE_VALUE',' Value:');

define('CROSS_SELLING','Cross-selling for product');
define('CROSS_SELLING_SEARCH','Search product:');
define('BUTTON_EDIT_CROSS_SELLING','Cross-selling');
define('HEADING_DEL','delete');
define('HEADING_SORTING','sort order');
define('HEADING_MODEL','model');
define('HEADING_NAME','product');
define('HEADING_CATEGORY','category');
define('HEADING_ADD','Add?');
define('HEADING_GROUP','Group');

// BOF GM_MOD
define('GM_STATUSBAR_TEXT','Status bar text:');
define('GM_SORT_ASC','ascending');
define('GM_SORT_DESC','descending');
define('GM_TEXT_SHOW_DATE_ADDED','Show release date:');
define('GM_TEXT_SHOW_PRICE_OFFER','&quot;Found cheaper?&quot; Show module:');
define('GM_PRICE_STATUS', 'Item price status:');
define('GM_PRICE_STATUS_0', 'normal');
define('GM_PRICE_STATUS_1', 'price on request');
define('GM_PRICE_STATUS_2', 'not available for purchase');
define('GM_TEXT_MIN_ORDER', 'Minimum order amount: ');
define('GM_TEXT_GRADUATED_QTY', 'Possible amount interval: ');
define('GM_TEXT_INPUT_ADVICE', ' <strong>has to be</strong> > 0');
define('GM_TEXT_URL_KEYWORDS','URL keywords:');
define('GM_TEXT_SHOW_WEIGHT','Show weight:');
define('GM_TEXT_SHOW_QTY_INFO', 'Show stock:');
define('GM_TEXT_SHOW_CAT_QTY_INFO', 'Show stock');

define('TEXT_NC_GAMBIOULTRA_COSTS', 'Shipping costs:');
define('GM_SITEMAP_CHANGEFREQ', 'change frequency in sitemap');
define('GM_SITEMAP_PRIORITY', 'priority in sitemap');
define('TITLE_ALWAYS', 'always');
define('TITLE_HOURLY', 'hourly');
define('TITLE_DAILY', 'daily');
define('TITLE_WEEKLY', 'weekly');
define('TITLE_MONTHLY', 'monthly');
define('TITLE_YEARLY', 'annually');
define('TITLE_NEVER', 'never');	
define('GM_SITEMAP_ENTRY', 'link in sitemap');	

define('GM_TEXT_COPY_FEATURES', 'Copy options for products');	
define('GM_TEXT_COPY_ATTRIBUTES', 'Copy attributes');	
define('GM_TEXT_COPY_SPECIALS', 'Copy specials');	
define('GM_TEXT_COPY_CROSS_SELLS', 'Copy cross-sells');	

define('GM_GMOTION_ACTIVATE', 'Activate G-Motion');
define('GM_GMOTION_POSITION', 'Position on product info page');
define('GM_GMOTION_DIMENSIONS', 'Dimensions');
define('GM_GMOTION_WIDTH', 'Width');
define('GM_GMOTION_HEIGHT', 'Height');
define('GM_GMOTION_AUTO_WIDTH', 'Maximum instead of fixed width');
define('GM_GMOTION_LIGHTBOX', 'Animation in lightbox');
define('GM_GMOTION_LIGHTBOX_WIDTH', 'Width in lightbox');
define('GM_GMOTION_LIGHTBOX_HEIGHT', 'Height in lightbox');

define('TITLE_FEATURES', 'Features');
define('TEXT_DELETE_SETUP', 'deselect all');
define('TEXT_FEATURE_CATEGORIE', 'All features from category');
define('TEXT_FEATURE_PRODUCT', 'All other features');
define('TEXT_FEATURE_CREATE', 'First you have to create feature before connecting them with a category.');
define('TEXT_FEATURE_BTN_OPEN', 'open');
define('TEXT_FEATURE_BTN_CLOSE', 'close');

define('TITLE_CAT_SLIDER', 'Category Teaser Slider');
define('TITLE_PRODUCT_SLIDER', 'Product Teaser Slider');
define('TEXT_SELECT_NONE', 'no Teaser Slider');

include(DIR_FS_LANGUAGES . 'english/admin/gm_product_images.php');
include(DIR_FS_LANGUAGES . 'english/admin/gm_gmotion.php');

define('TEXT_SHOW_SUB_CATEGORIES', 'Show subcategories');
define('TEXT_SHOW_SUB_CATEGORIES_IMAGES', 'Show category image');
define('TEXT_SHOW_SUB_CATEGORIES_NAMES', 'Show category heading');
define('TEXT_SHOW_SUB_PRODUCTS', 'Show articles from subcategories');
define('TEXT_SHOW_TILED_LISTING', 'Tiled Article Listing');
// EOF GM_MOD

// NEW
define('TXT_DATE_ADDED','Date added');

define('TEXT_CHECKOUT_INFORMATION', 'Essential features (order summary):');
define('TEXT_COPY', 'Copy');
?>