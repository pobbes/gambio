<?php
/* --------------------------------------------------------------
   products_attributes.php 2010-01-20 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(products_attributes.php,v 1.9 2002/03/30); www.oscommerce.com
   (c) 2003	 nextcommerce (products_attributes.php,v 1.4 2003/08/1); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: products_attributes.php 1101 2005-07-24 14:51:13Z mz $)

   Released under the GNU General Public License
   --------------------------------------------------------------*/

// BOF GM_MOD
define('HEADING_TITLE', 'Product Options');
define('HEADING_SUB_TITLE', 'Catalog');
define('TABLE_HEADING_GM_SORT_ORDER', 'Sort Order');
// EOF GM_MOD

define('HEADING_TITLE_OPT', 'Product Options');
define('HEADING_TITLE_VAL', 'Option Values');
define('HEADING_TITLE_ATRIB', 'Product Attributes');

define('TABLE_HEADING_ID', 'ID');
define('TABLE_HEADING_PRODUCT', 'Product Name');
define('TABLE_HEADING_OPT_NAME', 'Option Name');
define('TABLE_HEADING_OPT_VALUE', 'Option Value');
define('TABLE_HEADING_OPT_PRICE', 'Price');
define('TABLE_HEADING_OPT_PRICE_PREFIX', 'Prefix (+/-)');
define('TABLE_HEADING_ACTION', 'Action');
define('TABLE_HEADING_DOWNLOAD', 'Downloadable products:');
define('TABLE_TEXT_FILENAME', 'Filename:');
define('TABLE_TEXT_MAX_DAYS', 'Days to expiry:');
define('TABLE_TEXT_MAX_COUNT', 'Maximum download count:');

define('MAX_ROW_LISTS_OPTIONS', 10);

define('TEXT_WARNING_OF_DELETE', 'This option has products and values linked to it; it is not safe to delete it.');
define('TEXT_OK_TO_DELETE', 'This option has no products and values linked to it; it is safe to delete it.');
define('TEXT_SEARCH','Search:');
define('TEXT_OPTION_ID', 'Option ID');
define('TEXT_OPTION_NAME', 'Option Name');
define('TEXT_SORT', 'Sort: ');


// NEW
define('TEXT_SORT', 'Sort Order: ');
?>