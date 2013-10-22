<?php
/* --------------------------------------------------------------
   gambioultra.php 2008-05-06 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(zones.php,v 1.3 2002/04/17); www.oscommerce.com 
   (c) 2003	 nextcommerce (zones.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: zones.php,v 1.1 2003/12/19 13:19:08 fanta2k Exp $)

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

define('MODULE_SHIPPING_GAMBIOULTRA_TEXT_TITLE', 'Product Rates');
define('MODULE_SHIPPING_GAMBIOULTRA_TEXT_DESCRIPTION', 'Zone-based rates');
define('MODULE_SHIPPING_GAMBIOULTRA_TEXT_WAY', 'Dispatch to:');
define('MODULE_SHIPPING_GAMBIOULTRA_TEXT_UNITS', 'kg');
define('MODULE_SHIPPING_GAMBIOULTRA_INVALID_ZONE', 'No shipping available to the country selected');
define('MODULE_SHIPPING_GAMBIOULTRA_UNDEFINED_RATE', 'Shipping costs cannot be calculated currently.');

define('MODULE_SHIPPING_GAMBIOULTRA_STATUS_TITLE' , 'Enable Shipping Costs by Zone');
define('MODULE_SHIPPING_GAMBIOULTRA_STATUS_DESC' , 'Do you want to offer shipping costs by zone?');
define('MODULE_SHIPPING_GAMBIOULTRA_ALLOWED_TITLE' , 'Allowed Shipping Zones');
define('MODULE_SHIPPING_GAMBIOULTRA_ALLOWED_DESC' , 'Please enter the zones <b>individually</b> that should be allowed to use this module (e.g. US, UK (leave blank to allow all zones))');
define('MODULE_SHIPPING_GAMBIOULTRA_TAX_CLASS_TITLE' , 'Tax Class');
define('MODULE_SHIPPING_GAMBIOULTRA_TAX_CLASS_DESC' , 'Apply the following tax class to the shipping costs');
define('MODULE_SHIPPING_GAMBIOULTRA_SORT_ORDER_TITLE' , 'Sort Order');
define('MODULE_SHIPPING_GAMBIOULTRA_SORT_ORDER_DESC' , 'Display sort order');

define('MODULE_SHIPPING_GAMBIOULTRA_COUNTRIES_1_TITLE' , 'Zone 1 Countries');
define('MODULE_SHIPPING_GAMBIOULTRA_COUNTRIES_1_DESC' , 'Comma separated list of the 2-char ISO country codes in zone 1.');
define('MODULE_SHIPPING_GAMBIOULTRA_COST_1_TITLE' , 'Zone 1 Tariffs');
define('MODULE_SHIPPING_GAMBIOULTRA_COST_1_DESC' , 'Tariffs to zone 1 destinations based on a range of order weights. E.g.: 3:8.50,7:10.50,... Weights greater than 0 and less than or equal to 3 would cost 8.50 for zone 1 destinations');
define('MODULE_SHIPPING_GAMBIOULTRA_HANDLING_1_TITLE' , 'Zone 1 Handling Fee');
define('MODULE_SHIPPING_GAMBIOULTRA_HANDLING_1_DESC' , 'Handling fee for this shipping zone');

define('MODULE_SHIPPING_GAMBIOULTRA_COUNTRIES_2_TITLE' , 'Zone 2 Countries');
define('MODULE_SHIPPING_GAMBIOULTRA_COUNTRIES_2_DESC' , 'Comma separated list of the 2-char ISO country codes in zone 2.');
define('MODULE_SHIPPING_GAMBIOULTRA_COST_2_TITLE' , 'Zone 2 Tariffs');
define('MODULE_SHIPPING_GAMBIOULTRA_COST_2_DESC' , 'Tariffs to zone 2 destinations based on a range of order weights. E.g.: 3:8.50,7:10.50,... Weights greater than 0 and less than or equal to 3 would cost 8.50 for zone 1 destinations');
define('MODULE_SHIPPING_GAMBIOULTRA_HANDLING_2_TITLE' , 'Zone 2 Handling Fee');
define('MODULE_SHIPPING_GAMBIOULTRA_HANDLING_2_DESC' , 'Handling fee for this shipping zone');

define('MODULE_SHIPPING_GAMBIOULTRA_COUNTRIES_3_TITLE' , 'Zone 3 Countries');
define('MODULE_SHIPPING_GAMBIOULTRA_COUNTRIES_3_DESC' , 'Comma separated list of the 2-char ISO country codes in zone 3.');
define('MODULE_SHIPPING_GAMBIOULTRA_COST_3_TITLE' , 'Zone 3 Tariffs');
define('MODULE_SHIPPING_GAMBIOULTRA_COST_3_DESC' , 'Tariffs to zone 3 destinations based on a range of order weights. E.g.: 3:8.50,7:10.50,... Weights greater than 0 and less than or equal to 3 would cost 8.50 for zone 1 destinations');
define('MODULE_SHIPPING_GAMBIOULTRA_HANDLING_3_TITLE' , 'Zone 3 Handling Fee');
define('MODULE_SHIPPING_GAMBIOULTRA_HANDLING_3_DESC' , 'Handling fee for this shipping zone');

define('MODULE_SHIPPING_GAMBIOULTRA_COUNTRIES_4_TITLE' , 'Zone 4 Countries');
define('MODULE_SHIPPING_GAMBIOULTRA_COUNTRIES_4_DESC' , 'Comma separated list of the 2-char ISO country codes in zone 4.');
define('MODULE_SHIPPING_GAMBIOULTRA_COST_4_TITLE' , 'Zone 4 Tariffs');
define('MODULE_SHIPPING_GAMBIOULTRA_COST_4_DESC' , 'Tariffs to zone 4 destinations based on a range of order weights. E.g.: 3:8.50,7:10.50,... Weights greater than 0 and less than or equal to 3 would cost 8.50 for zone 1 destinations');
define('MODULE_SHIPPING_GAMBIOULTRA_HANDLING_4_TITLE' , 'Zone 4 Handling Fee');
define('MODULE_SHIPPING_GAMBIOULTRA_HANDLING_4_DESC' , 'Handling fee for this shipping zone');

define('MODULE_SHIPPING_GAMBIOULTRA_COUNTRIES_5_TITLE' , 'Zone 5 Countries');
define('MODULE_SHIPPING_GAMBIOULTRA_COUNTRIES_5_DESC' , 'Comma separated list of the 2-char ISO country codes in zone 5.');
define('MODULE_SHIPPING_GAMBIOULTRA_COST_5_TITLE' , 'Zone 5 Tariffs');
define('MODULE_SHIPPING_GAMBIOULTRA_COST_5_DESC' , 'Tariffs to zone 5 destinations based on a range of order weights. E.g.: 3:8.50,7:10.50,... Weights greater than 0 and less than or equal to 3 would cost 8.50 for zone 1 destinations');
define('MODULE_SHIPPING_GAMBIOULTRA_HANDLING_5_TITLE' , 'Zone 5 Handling Fee');
define('MODULE_SHIPPING_GAMBIOULTRA_HANDLING_5_DESC' , 'Handling fee for this shipping zone');

define('MODULE_SHIPPING_GAMBIOULTRA_COUNTRIES_6_TITLE' , 'Zone 6 Countries');
define('MODULE_SHIPPING_GAMBIOULTRA_COUNTRIES_6_DESC' , 'Comma separated list of the 2-char ISO country codes in zone 6.');
define('MODULE_SHIPPING_GAMBIOULTRA_COST_6_TITLE' , 'Zone 6 Tariffs');
define('MODULE_SHIPPING_GAMBIOULTRA_COST_6_DESC' , 'Tariffs to zone 6 destinations based on a range of order weights. E.g.: 3:8.50,7:10.50,... Weights greater than 0 and less than or equal to 3 would cost 8.50 for zone 1 destinations');
define('MODULE_SHIPPING_GAMBIOULTRA_HANDLING_6_TITLE' , 'Zone 6 Handling Fee');
define('MODULE_SHIPPING_GAMBIOULTRA_HANDLING_6_DESC' , 'Handling fee for this shipping zone');

define('MODULE_SHIPPING_GAMBIOULTRA_COUNTRIES_7_TITLE' , 'Zone 7 Countries');
define('MODULE_SHIPPING_GAMBIOULTRA_COUNTRIES_7_DESC' , 'Comma separated list of the 2-char ISO country codes in zone 7.');
define('MODULE_SHIPPING_GAMBIOULTRA_COST_7_TITLE' , 'Zone 7 Tariffs');
define('MODULE_SHIPPING_GAMBIOULTRA_COST_7_DESC' , 'Tariffs to zone 7 destinations based on a range of order weights. E.g.: 3:8.50,7:10.50,... Weights greater than 0 and less than or equal to 3 would cost 8.50 for zone 1 destinations');
define('MODULE_SHIPPING_GAMBIOULTRA_HANDLING_7_TITLE' , 'Zone 7 Handling Fee');
define('MODULE_SHIPPING_GAMBIOULTRA_HANDLING_7_DESC' , 'Handling fee for this shipping zone');

define('MODULE_SHIPPING_GAMBIOULTRA_COUNTRIES_8_TITLE' , 'Zone 8 Countries');
define('MODULE_SHIPPING_GAMBIOULTRA_COUNTRIES_8_DESC' , 'Comma separated list of the 2-char ISO country codes in zone 8.');
define('MODULE_SHIPPING_GAMBIOULTRA_COST_8_TITLE' , 'Zone 8 Tariffs');
define('MODULE_SHIPPING_GAMBIOULTRA_COST_8_DESC' , 'Tariffs to zone 8 destinations based on a range of order weights. E.g.: 3:8.50,7:10.50,... Weights greater than 0 and less than or equal to 3 would cost 8.50 for zone 1 destinations.');
define('MODULE_SHIPPING_GAMBIOULTRA_HANDLING_8_TITLE' , 'Zone 8 Handling Fee');
define('MODULE_SHIPPING_GAMBIOULTRA_HANDLING_8_DESC' , 'Handling fee for this shipping zone');

define('MODULE_SHIPPING_GAMBIOULTRA_COUNTRIES_9_TITLE' , 'Zone 9 Countries');
define('MODULE_SHIPPING_GAMBIOULTRA_COUNTRIES_9_DESC' , 'Comma separated list of the 2-char ISO country codes in zone 9.');
define('MODULE_SHIPPING_GAMBIOULTRA_COST_9_TITLE' , 'Zone 9 Tariffs');
define('MODULE_SHIPPING_GAMBIOULTRA_COST_9_DESC' , 'Tariffs to zone 9 destinations based on a range of order weights. E.g.: 3:8.50,7:10.50,... Weights greater than 0 and less than or equal to 3 would cost 8.50 for zone 1 destinations');
define('MODULE_SHIPPING_GAMBIOULTRA_HANDLING_9_TITLE' , 'Zone 9 Handling Fee');
define('MODULE_SHIPPING_GAMBIOULTRA_HANDLING_9_DESC' , 'Handling fee for this shipping zone');

define('MODULE_SHIPPING_GAMBIOULTRA_COUNTRIES_10_TITLE' , 'Zone 10 Countries');
define('MODULE_SHIPPING_GAMBIOULTRA_COUNTRIES_10_DESC' , 'Comma separated list of the 2-char ISO country codes in zone 10.');
define('MODULE_SHIPPING_GAMBIOULTRA_COST_10_TITLE' , 'Zone 10 Tariffs');
define('MODULE_SHIPPING_GAMBIOULTRA_COST_10_DESC' , 'Tariffs to zone 10 destinations based on a range of order weights. E.g.: 3:8.50,7:10.50,... Weights greater than 0 and less than or equal to 3 would cost 8.50 for zone 1 destinations');
define('MODULE_SHIPPING_GAMBIOULTRA_HANDLING_10_TITLE' , 'Zone 10 Handling Fee');
define('MODULE_SHIPPING_GAMBIOULTRA_HANDLING_10_DESC' , 'Handling fee for this shipping zone');
?>