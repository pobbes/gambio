<?php
/* --------------------------------------------------------------
   gm_product_export.php 2012-06-01 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License
   --------------------------------------------------------------
*/
?><?php

define('HEADING_TITLE', 'Product Export');
define('HEADING_SUB_TITLE','Gambio');
define('MODULE_NAME' , '<strong>Provider</strong>');
define('MODULE_TYPE' , '<strong>Type</strong>');
define('MODULE_INFO' , '<strong>Partnerlink</strong>');
define('MODULE_FILE_TITLE' , '<strong>Filename</strong>');
define('MODULE_FILE_DESC' , 'Type in the filename for the exported file.<br />(directory export/)');
define('MODULE_STATUS_DESC','Module status');
define('MODULE_STATUS_TITLE','Status');
define('MODULE_CURRENCY_TITLE','Currency');
define('MODULE_CURRENCY_DESC','Which currency should be used for export?');
define('EXPORT_YES','save and download');
define('EXPORT_NO','save');
define('CURRENCY','<strong>Currency</strong>');
define('CURRENCY_DESC','Currency in export file');
define('EXPORT','Please DO NOT ABORT the saving process. It may last several minutes.');
define('EXPORT_TYPE','<strong>Export type</strong>');
define('EXPORT_STATUS_TYPE','<b>Customer group</b>');
define('EXPORT_STATUS','Choose the customer group for calculating prices (choose <i>Guest</i> if you do not use customer group prices):');
define('CAMPAIGNS','<strong>Campaigns<strong>');
define('CAMPAIGNS_DESC','Link with the campaign for tracking.');
define('DATE_FORMAT_EXPORT', '%d.%m.%Y');  // this is used for strftime()
define('SHIPPING_COSTS_DESC', 'Flat rate (e.g. 2.90)');
define('SHIPPING_COSTS_TITLE', '<strong>Shipping costs</strong>');
define('SHIPPING_COSTS_FREE_DESC', 'Price limit for free shipping');
define('SHIPPING_COSTS_FREE_TITLE', '<strong>Free shipping</strong>');
define('EXPORT_ATTRIBUTES', '<strong>Attribute export</strong>');
define('EXPORT_ATTRIBUTES_DESC', 'Every attribute variation will be exported as a single article.');
define('CRONJOB', '<strong>Automatic-Export</strong>');
define('CRONJOB_DESC', 'yes, activate modul for automatic (cronjob) export');
define('STOCK', '<strong>Stock</strong>');
define('STOCK_DESC', 'export only if stock is at least input-value; export all if input is zero');
define('XML', '<strong>XML-Export</strong>');
define('XML_DESC', 'yes, create an additional XML file');

define('ADD_VPE_TO_NAME', 'Add base price to name');
define('ADD_VPE_TO_NAME_NO', 'no');
define('ADD_VPE_TO_NAME_PREFIX', 'as prefix');
define('ADD_VPE_TO_NAME_SUFFIX', 'as suffix');
define('ADD_VPE_TO_NAME_DESC', 'Add the base price to the products name?');

define('GM_PRODUCT_EXPORT_OFFERER', 'Provider');
define('GM_PRODUCT_EXPORT_COMPARISON', 'Price comparison');
define('GM_PRODUCT_EXPORT_SHOPPING_PORTALS', 'Shopping portals');
define('GM_PRODUCT_EXPORT_MORE_INFORMATION', 'more information');
define('GM_PRODUCT_EXPORT_SUCCESS', 'CSV-export successfully generated: ');
define('GM_PRODUCT_SAVE_SUCCESS', 'Configuration saved.');
?>