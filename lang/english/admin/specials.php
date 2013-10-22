<?php
/* --------------------------------------------------------------
   specials.php 2008-08-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(specials.php,v 1.10 2002/01/31); www.oscommerce.com 
   (c) 2003	 nextcommerce (specials.php,v 1.4 2003/08/14); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: specials.php 899 2005-04-29 02:40:57Z hhgag $)

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'Specials');

// BOF GM_MOD
define('HEADING_SUB_TITLE', 'Catalog');
// EOF GM_MOD

define('TABLE_HEADING_PRODUCTS', 'Product');
define('TABLE_HEADING_PRODUCTS_PRICE', 'Product Price');
define('TABLE_HEADING_STATUS', 'Status');
define('TABLE_HEADING_ACTION', 'Action');
define('TEXT_MARKED_ELEMENTS','Marked Element');
define('TEXT_SPECIALS_PRODUCT', 'Product:');
define('TEXT_SPECIALS_SPECIAL_PRICE', 'Special Price:');
define('TEXT_SPECIALS_SPECIAL_QUANTITY', 'Quantity:');  
define('TEXT_SPECIALS_EXPIRES_DATE', 'Expiry Date:');
define('TEXT_SPECIALS_PRICE_TIP', '<b>Specials Notes:</b><ul><li>You can enter a percentage to be deducted in the specials price field, e.g.: <b>20%</b></li><li>If you enter a new price, the decimal separator must be a \'.\' (decimal point), i.e.: <b>49.99</b></li><li>Leave the expiry date blank if no expiry date is applicable</li></ul>');

define('TEXT_INFO_DATE_ADDED', 'Date added:');
define('TEXT_INFO_LAST_MODIFIED', 'Last modified:');
define('TEXT_INFO_NEW_PRICE', 'New price:');
define('TEXT_INFO_ORIGINAL_PRICE', 'Original price:');
define('TEXT_INFO_PERCENTAGE', 'Percentage:');
define('TEXT_INFO_EXPIRES_DATE', 'Expires on:');
define('TEXT_INFO_STATUS_CHANGE', 'Status change:');

define('TEXT_INFO_HEADING_DELETE_SPECIALS', 'Delete Specials');
define('TEXT_INFO_DELETE_INTRO', 'Are you sure you want to delete the special products price?');

define('TEXT_IMAGE_NONEXISTENT','No image available!'); 
?>