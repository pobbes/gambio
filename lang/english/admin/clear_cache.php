<?php
/* --------------------------------------------------------------
   clear_cache.php 2012-01-27 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

define('HEADING_TITLE', 'Clear cache');
define('TEXT_MESSAGE', 'The cache has been emptied and will be regenerated the next page request in the shop.');
define('TEXT_ERROR_MESSAGE', 'The cache could not be emptied.');

define('BUTTON_OUTPUT_CACHE', 'Empty page output cache');
define('BUTTON_DATA_CACHE', 'Empty modules cache');
define('BUTTON_SUBMENUS_CACHE', 'Empty submenus cache');
define('BUTTON_CATEGORIES_CACHE', 'Empty categories and products cache');
define('BUTTON_PROPERTIES_CACHE', 'Empty properties cache');
define('BUTTON_FEATURES_CACHE', 'Empty filter cache');

define('TEXT_OUTPUT_CACHE', 'Empty the cache when you make changes to category or product data or settings you have made to effect a change in the output of shop sites, such as text or price changes, new modules, changes in status of categories/products.');
define('TEXT_DATA_CACHE', 'Empty the cache, if you made ??any changes to the category structure or the language files or if new modules for the shop have installed and activated.');
define('TEXT_SUBMENUS_CACHE', 'If you have emptied the page output cache and work with a large number of categories, it can accelerate the next page load times if you recreate the submenus cache now.');
define('TEXT_CATEGORIES_CACHE', 'Create this cache, if you imported products or categories via an external system or if you changed data via an ERP system or a direct database access.');
define('TEXT_PROPERTIES_CACHE', 'Create this cache, if you have made ??changes to properties that were already assigned to products.');
define('TEXT_FEATURES_CACHE', 'In exceptional cases it may be necessary to repair the filter mappings, if products are not found using a filter.');
?>