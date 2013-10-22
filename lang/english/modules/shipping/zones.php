<?php
/* -----------------------------------------------------------------------------------------
   $Id: zones.php 899 2005-04-29 02:40:57Z hhgag $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(zones.php,v 1.3 2002/04/17); www.oscommerce.com 
   (c) 2003	 nextcommerce (zones.php,v 1.4 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
   // CUSTOMIZE THIS SETTING
define('NUMBER_OF_ZONES',10);

define('MODULE_SHIPPING_ZONES_TEXT_TITLE', 'Zone Rates');
define('MODULE_SHIPPING_ZONES_TEXT_DESCRIPTION', 'Zone-based rates');
define('MODULE_SHIPPING_ZONES_TEXT_WAY', 'Dispatch to:');
define('MODULE_SHIPPING_ZONES_TEXT_UNITS', 'kg');
define('MODULE_SHIPPING_ZONES_INVALID_ZONE', 'No shipping available to the country selected!');
define('MODULE_SHIPPING_ZONES_UNDEFINED_RATE', 'The shipping costs cannot be calclated currently.');

define('MODULE_SHIPPING_ZONES_STATUS_TITLE' , 'Enable Zones Method');
define('MODULE_SHIPPING_ZONES_STATUS_DESC' , 'Do you want to offer zone rate shipping?');
define('MODULE_SHIPPING_ZONES_ALLOWED_TITLE' , 'Allowed Shipping Zones');
define('MODULE_SHIPPING_ZONES_ALLOWED_DESC' , 'Please enter the zones <b>individually</b> that should be allowed to use this module (e.g. US, UK (leave blank to allow all zones))');
define('MODULE_SHIPPING_ZONES_TAX_CLASS_TITLE' , 'Tax Class');
define('MODULE_SHIPPING_ZONES_TAX_CLASS_DESC' , 'Apply the following tax class to the shipping cost.');
define('MODULE_SHIPPING_ZONES_SORT_ORDER_TITLE' , 'Sort Order');
define('MODULE_SHIPPING_ZONES_SORT_ORDER_DESC' , 'Display sort order.');

/*
for ($ii=0;$ii<NUMBER_OF_ZONES;$ii++) {
define('MODULE_SHIPPING_ZONES_COUNTRIES_'.$ii.'_TITLE' , 'Zone '.$ii.' Countries');
define('MODULE_SHIPPING_ZONES_COUNTRIES_'.$ii.'_DESC' , 'Comma separated list of two character ISO country codes that are part of Zone '.$ii.'.');
define('MODULE_SHIPPING_ZONES_COST_'.$ii.'_TITLE' , 'Zone '.$ii.' Shipping Table');
define('MODULE_SHIPPING_ZONES_COST_'.$ii.'_DESC' , 'Shipping rates to Zone '.$ii.' destinations based on a group of maximum order weights. Example: 3:8.50,7:10.50,... Weights less than or equal to 3 would cost 8.50 for Zone '.$ii.' destinations.');
define('MODULE_SHIPPING_ZONES_HANDLING_'.$ii.'_TITLE' , 'Zone '.$ii.' Handling Fee');
define('MODULE_SHIPPING_ZONES_HANDLING_'.$ii.'_DESC' , 'Handling Fee for this shipping zone');
}
*/

define('MODULE_SHIPPING_ZONES_COUNTRIES_1_TITLE' , 'Zone 1 Countries');
define('MODULE_SHIPPING_ZONES_COUNTRIES_1_DESC' , 'Comma separated list of two character ISO country codes that are part of Zone 1.');
define('MODULE_SHIPPING_ZONES_COST_1_TITLE' , 'Zone 1 Shipping Table');
define('MODULE_SHIPPING_ZONES_COST_1_DESC' , 'Shipping rates to Zone 1 destinations based on a group of maximum order weights. Example: 3:8.50,7:10.50,... Weights less than or equal to 3 would cost 8.50 for Zone 1 destinations.');
define('MODULE_SHIPPING_ZONES_HANDLING_1_TITLE' , 'Zone 1 Handling Fee');
define('MODULE_SHIPPING_ZONES_HANDLING_1_DESC' , 'Handling Fee for this shipping zone');

define('MODULE_SHIPPING_ZONES_COUNTRIES_2_TITLE' , 'Zone 2 Countries');
define('MODULE_SHIPPING_ZONES_COUNTRIES_2_DESC' , 'Comma separated list of two character ISO country codes that are part of Zone 2.');
define('MODULE_SHIPPING_ZONES_COST_2_TITLE' , 'Zone 2 Shipping Table');
define('MODULE_SHIPPING_ZONES_COST_2_DESC' , 'Shipping rates to Zone 2 destinations based on a group of maximum order weights. Example: 3:8.50,7:10.50,... Weights less than or equal to 3 would cost 8.50 for Zone 2 destinations.');
define('MODULE_SHIPPING_ZONES_HANDLING_2_TITLE' , 'Zone 2 Handling Fee');
define('MODULE_SHIPPING_ZONES_HANDLING_2_DESC' , 'Handling Fee for this shipping zone');

define('MODULE_SHIPPING_ZONES_COUNTRIES_3_TITLE' , 'Zone 3 Countries');
define('MODULE_SHIPPING_ZONES_COUNTRIES_3_DESC' , 'Comma separated list of two character ISO country codes that are part of Zone 3.');
define('MODULE_SHIPPING_ZONES_COST_3_TITLE' , 'Zone 3 Shipping Table');
define('MODULE_SHIPPING_ZONES_COST_3_DESC' , 'Shipping rates to Zone 3 destinations based on a group of maximum order weights. Example: 3:8.50,7:10.50,... Weights less than or equal to 3 would cost 8.50 for Zone 3 destinations.');
define('MODULE_SHIPPING_ZONES_HANDLING_3_TITLE' , 'Zone 3 Handling Fee');
define('MODULE_SHIPPING_ZONES_HANDLING_3_DESC' , 'Handling Fee for this shipping zone');

define('MODULE_SHIPPING_ZONES_COUNTRIES_4_TITLE' , 'Zone 4 Countries');
define('MODULE_SHIPPING_ZONES_COUNTRIES_4_DESC' , 'Comma separated list of two character ISO country codes that are part of Zone 4.');
define('MODULE_SHIPPING_ZONES_COST_4_TITLE' , 'Zone 4 Shipping Table');
define('MODULE_SHIPPING_ZONES_COST_4_DESC' , 'Shipping rates to Zone 4 destinations based on a group of maximum order weights. Example: 3:8.50,7:10.50,... Weights less than or equal to 3 would cost 8.50 for Zone 4 destinations.');
define('MODULE_SHIPPING_ZONES_HANDLING_4_TITLE' , 'Zone 4 Handling Fee');
define('MODULE_SHIPPING_ZONES_HANDLING_4_DESC' , 'Handling Fee for this shipping zone');

define('MODULE_SHIPPING_ZONES_COUNTRIES_5_TITLE' , 'Zone 5 Countries');
define('MODULE_SHIPPING_ZONES_COUNTRIES_5_DESC' , 'Comma separated list of two character ISO country codes that are part of Zone 5.');
define('MODULE_SHIPPING_ZONES_COST_5_TITLE' , 'Zone 5 Shipping Table');
define('MODULE_SHIPPING_ZONES_COST_5_DESC' , 'Shipping rates to Zone 5 destinations based on a group of maximum order weights. Example: 3:8.50,7:10.50,... Weights less than or equal to 3 would cost 8.50 for Zone 5 destinations.');
define('MODULE_SHIPPING_ZONES_HANDLING_5_TITLE' , 'Zone 5 Handling Fee');
define('MODULE_SHIPPING_ZONES_HANDLING_5_DESC' , 'Handling Fee for this shipping zone');

define('MODULE_SHIPPING_ZONES_COUNTRIES_6_TITLE' , 'Zone 6 Countries');
define('MODULE_SHIPPING_ZONES_COUNTRIES_6_DESC' , 'Comma separated list of two character ISO country codes that are part of Zone 6.');
define('MODULE_SHIPPING_ZONES_COST_6_TITLE' , 'Zone 6 Shipping Table');
define('MODULE_SHIPPING_ZONES_COST_6_DESC' , 'Shipping rates to Zone 6 destinations based on a group of maximum order weights. Example: 3:8.50,7:10.50,... Weights less than or equal to 3 would cost 8.50 for Zone 6 destinations.');
define('MODULE_SHIPPING_ZONES_HANDLING_6_TITLE' , 'Zone 6 Handling Fee');
define('MODULE_SHIPPING_ZONES_HANDLING_6_DESC' , 'Handling Fee for this shipping zone');

define('MODULE_SHIPPING_ZONES_COUNTRIES_7_TITLE' , 'Zone 7 Countries');
define('MODULE_SHIPPING_ZONES_COUNTRIES_7_DESC' , 'Comma separated list of two character ISO country codes that are part of Zone 7.');
define('MODULE_SHIPPING_ZONES_COST_7_TITLE' , 'Zone 7 Shipping Table');
define('MODULE_SHIPPING_ZONES_COST_7_DESC' , 'Shipping rates to Zone 7 destinations based on a group of maximum order weights. Example: 3:8.50,7:10.50,... Weights less than or equal to 3 would cost 8.50 for Zone 7 destinations.');
define('MODULE_SHIPPING_ZONES_HANDLING_7_TITLE' , 'Zone 7 Handling Fee');
define('MODULE_SHIPPING_ZONES_HANDLING_7_DESC' , 'Handling Fee for this shipping zone');

define('MODULE_SHIPPING_ZONES_COUNTRIES_8_TITLE' , 'Zone 8 Countries');
define('MODULE_SHIPPING_ZONES_COUNTRIES_8_DESC' , 'Comma separated list of two character ISO country codes that are part of Zone 8.');
define('MODULE_SHIPPING_ZONES_COST_8_TITLE' , 'Zone 8 Shipping Table');
define('MODULE_SHIPPING_ZONES_COST_8_DESC' , 'Shipping rates to Zone 8 destinations based on a group of maximum order weights. Example: 3:8.50,7:10.50,... Weights less than or equal to 3 would cost 8.50 for Zone 8 destinations.');
define('MODULE_SHIPPING_ZONES_HANDLING_8_TITLE' , 'Zone 8 Handling Fee');
define('MODULE_SHIPPING_ZONES_HANDLING_8_DESC' , 'Handling Fee for this shipping zone');

define('MODULE_SHIPPING_ZONES_COUNTRIES_9_TITLE' , 'Zone 9 Countries');
define('MODULE_SHIPPING_ZONES_COUNTRIES_9_DESC' , 'Comma separated list of two character ISO country codes that are part of Zone 9.');
define('MODULE_SHIPPING_ZONES_COST_9_TITLE' , 'Zone 9 Shipping Table');
define('MODULE_SHIPPING_ZONES_COST_9_DESC' , 'Shipping rates to Zone 9 destinations based on a group of maximum order weights. Example: 3:8.50,7:10.50,... Weights less than or equal to 3 would cost 8.50 for Zone 9 destinations.');
define('MODULE_SHIPPING_ZONES_HANDLING_9_TITLE' , 'Zone 9 Handling Fee');
define('MODULE_SHIPPING_ZONES_HANDLING_9_DESC' , 'Handling Fee for this shipping zone');

define('MODULE_SHIPPING_ZONES_COUNTRIES_10_TITLE' , 'Zone 10 Countries');
define('MODULE_SHIPPING_ZONES_COUNTRIES_10_DESC' , 'Comma separated list of two character ISO country codes that are part of Zone 10.');
define('MODULE_SHIPPING_ZONES_COST_10_TITLE' , 'Zone 10 Shipping Table');
define('MODULE_SHIPPING_ZONES_COST_10_DESC' , 'Shipping rates to Zone 10 destinations based on a group of maximum order weights. Example: 3:8.50,7:10.50,... Weights less than or equal to 3 would cost 8.50 for Zone 10 destinations.');
define('MODULE_SHIPPING_ZONES_HANDLING_10_TITLE' , 'Zone 10 Handling Fee');
define('MODULE_SHIPPING_ZONES_HANDLING_10_DESC' , 'Handling Fee for this shipping zone');

?>