<?php
/* -----------------------------------------------------------------------------------------
   $Id: UPS.php,v 1.1 2003/09/06 21:54:34 fanta2k Exp $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce( fedexeu.php,v 1.01 2003/02/18 03:25:00); www.oscommerce.com 
   (c) 2003	 nextcommerce (fedexeu.php,v 1.5 2003/08/1); www.nextcommerce.org

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   fedex_europe_1.02        	Autor:	Copyright (C) 2002 - 2003 TheMedia, Dipl.-Ing Thomas Plänkers | http://www.themedia.at & http://www.oscommerce.at

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/



define('MODULE_SHIPPING_UPSE_TEXT_TITLE', 'United Parcel Service Express');
define('MODULE_SHIPPING_UPSE_TEXT_DESCRIPTION', 'United Parcel Service Express shipping module');
define('MODULE_SHIPPING_UPSE_TEXT_WAY', 'Dispatch to');
define('MODULE_SHIPPING_UPSE_TEXT_UNITS', 'kg');
define('MODULE_SHIPPING_UPSE_INVALID_ZONE', 'No shipping available to the country selected');
define('MODULE_SHIPPING_UPSE_UNDEFINED_RATE',  'Shipping costs cannot be calculated currently');

define('MODULE_SHIPPING_UPSE_STATUS_TITLE' , 'UPS Express');
define('MODULE_SHIPPING_UPSE_STATUS_DESC' , 'Do you want to offer shipping via UPS Express?');
define('MODULE_SHIPPING_UPSE_HANDLING_TITLE' , 'Handling Fee');
define('MODULE_SHIPPING_UPSE_HANDLING_DESC' , 'Handling fee for this shipping method in Euros');
define('MODULE_SHIPPING_UPSE_TAX_CLASS_TITLE' , 'Tax Class');
define('MODULE_SHIPPING_UPSE_TAX_CLASS_DESC' , 'Select the tax class for this shipping method.');
define('MODULE_SHIPPING_UPSE_ZONE_TITLE' , 'Shipping Zone');
define('MODULE_SHIPPING_UPSE_ZONE_DESC' ,  'If a zone is selected, this payment method will be enabled for that zone only.');
define('MODULE_SHIPPING_UPSE_SORT_ORDER_TITLE' , 'Display Sort Order');
define('MODULE_SHIPPING_UPSE_SORT_ORDER_DESC' , 'The lowest value is displayed first.');
define('MODULE_SHIPPING_UPSE_ALLOWED_TITLE' , 'Allowed Shipping Zones');
define('MODULE_SHIPPING_UPSE_ALLOWED_DESC' , 'Please enter the zones <b>individually</b> that should be allowed to use this module (e.g. US, UK (leave blank to allow all zones))');



/* UPS Express

*/

define('MODULE_SHIPPING_UPSE_COUNTRIES_1_TITLE' , 'UPS Express Zone 1 Countries');
define('MODULE_SHIPPING_UPSE_COUNTRIES_1_DESC' , 'Comma separated list of 2-char ISO country codes in zone 1.');
define('MODULE_SHIPPING_UPSE_COST_1_TITLE' , 'UPS Express Zone 1 Tariffs');
define('MODULE_SHIPPING_UPSE_COST_1_DESC' , 'Weight-based tariffs in zone 1. E.g.: shipping between 0 and 0.5 kg costs 22.70 Euros = 0.5:22.7,...');

define('MODULE_SHIPPING_UPSE_COUNTRIES_2_TITLE' , 'UPS Express Zone 2 Countries');
define('MODULE_SHIPPING_UPSE_COUNTRIES_2_DESC' ,'Comma separated list of 2-char ISO country codes in zone 2.');
define('MODULE_SHIPPING_UPSE_COST_2_TITLE' , 'UPS Express Zone 2 Tariffs');
define('MODULE_SHIPPING_UPSE_COST_2_DESC' , 'Weight-based tariffs in zone 2. E.g.: shipping between 0 and 0.5 kg costs 51.55 Euros = 0.5:51.55,...');

define('MODULE_SHIPPING_UPSE_COUNTRIES_3_TITLE' , 'UPS Express Zone 3 Countries');
define('MODULE_SHIPPING_UPSE_COUNTRIES_3_DESC' , 'Comma separated list of 2-char ISO country codes in zone 3.');
define('MODULE_SHIPPING_UPSE_COST_3_TITLE' , 'UPS Express Zone 3 Tariffs');
define('MODULE_SHIPPING_UPSE_COST_3_DESC' , 'Weight-based tariffs in zone 3. E.g.: shipping between 0 and 0.5 kg costs 60.70 Euros = 0.5:60.70,...');

define('MODULE_SHIPPING_UPSE_COUNTRIES_4_TITLE' , 'UPS Express Zone 4 Countries');
define('MODULE_SHIPPING_UPSE_COUNTRIES_4_DESC' , 'Comma separated list of 2-char ISO country codes in zone 4.');
define('MODULE_SHIPPING_UPSE_COST_4_TITLE' , 'UPS Express Zone 4 Tariffs');
define('MODULE_SHIPPING_UPSE_COST_4_DESC' , 'Weight-based tariffs in zone 4. E.g.: shipping between 0 and 0.5 kg costs 66.90 Euros = 0.5:66.90,...');

define('MODULE_SHIPPING_UPSE_COUNTRIES_5_TITLE' , 'UPS Express Zone 41 Countries');
define('MODULE_SHIPPING_UPSE_COUNTRIES_5_DESC' , 'Comma separated list of 2-char ISO country codes in zone 41.');
define('MODULE_SHIPPING_UPSE_COST_5_TITLE' , 'UPS Express Zone 41 Tariffs');
define('MODULE_SHIPPING_UPSE_COST_5_DESC' , 'Weight-based tariffs in zone 41. E.g.: shipping between 0 and 0.5 kg costs 82.10 Euros = 0.5:82.10,...');

define('MODULE_SHIPPING_UPSE_COUNTRIES_6_TITLE' , 'UPS Express Zone 42 Countries');
define('MODULE_SHIPPING_UPSE_COUNTRIES_6_DESC' , 'Comma separated list of 2-char ISO country codes in zone 42.');
define('MODULE_SHIPPING_UPSE_COST_6_TITLE' , 'UPS Express Zone 42 Countries');
define('MODULE_SHIPPING_UPSE_COST_6_DESC' , 'Weight-based tariffs in zone 42. E.g.: shipping between 0 and 0.5 kg costs 82.90 Euros = 0.5:82.90,...');

define('MODULE_SHIPPING_UPSE_COUNTRIES_7_TITLE' , 'UPS Express Zone 5 Countries');
define('MODULE_SHIPPING_UPSE_COUNTRIES_7_DESC' , 'Comma separated list of 2-char ISO country codes in zone 5.');
define('MODULE_SHIPPING_UPSE_COST_7_TITLE' , 'UPS Express Zone 5 Tariffs');
define('MODULE_SHIPPING_UPSE_COST_7_DESC' , 'Weight-based tariffs in zone 5. E.g.: shipping between 0 and 0.5 kg costs 59.00 Euros = 0.5:59.00,...');

define('MODULE_SHIPPING_UPSE_COUNTRIES_8_TITLE' , 'UPS Express Zone 6 Countries');
define('MODULE_SHIPPING_UPSE_COUNTRIES_8_DESC' , 'Comma separated list of 2-char ISO country codes in zone 6.');
define('MODULE_SHIPPING_UPSE_COST_8_TITLE' , 'UPS Express Zone 6 Tariffs');
define('MODULE_SHIPPING_UPSE_COST_8_DESC' , 'Weight-based tariffs in zone 6. E.g.: shipping between 0 and 0.5 kg costs 84.50 Euros = 0.5:84.50,...');

define('MODULE_SHIPPING_UPSE_COUNTRIES_9_TITLE' , 'UPS Express Zone 7 Countries');
define('MODULE_SHIPPING_UPSE_COUNTRIES_9_DESC' , 'Comma separated list of 2-char ISO country codes in zone 7.');
define('MODULE_SHIPPING_UPSE_COST_9_TITLE' , 'UPS Express Zone 7 Tariffs');
define('MODULE_SHIPPING_UPSE_COST_9_DESC' , 'Weight-based tariffs in zone 7. E.g.: shipping between 0 and 0.5 kg costs 71.85 Euros = 0.5:71.85,...');

define('MODULE_SHIPPING_UPSE_COUNTRIES_10_TITLE' , 'UPS Express Zone 8 Countries');
define('MODULE_SHIPPING_UPSE_COUNTRIES_10_DESC' ,'Comma separated list of 2-char ISO country codes in zone 8.');
define('MODULE_SHIPPING_UPSE_COST_10_TITLE' , 'UPS Express Zone 8 Tariffs');
define('MODULE_SHIPPING_UPSE_COST_10_DESC' , 'Weight-based tariffs in zone 8. E.g.: shipping between 0 and 0.5 kg costs 80.05 Euros = 0.5:80.05,...');

define('MODULE_SHIPPING_UPSE_COUNTRIES_11_TITLE' , 'UPS Express Zone 9 Countries');
define('MODULE_SHIPPING_UPSE_COUNTRIES_11_DESC' ,'Comma separated list of 2-char ISO country codes in zone 9.');
define('MODULE_SHIPPING_UPSE_COST_11_TITLE' , 'UPS Express Zone 9 Tariffs');
define('MODULE_SHIPPING_UPSE_COST_11_DESC' , 'Weight-based tariffs in zone 9. E.g.: shipping between 0 and 0.5 kg costs 85.20 Euros = 0.5:85.20,...');

define('MODULE_SHIPPING_UPSE_COUNTRIES_12_TITLE' , 'UPS Express Zone 10 Countries');
define('MODULE_SHIPPING_UPSE_COUNTRIES_12_DESC' ,'Comma separated list of 2-char ISO country codes in zone 10.');
define('MODULE_SHIPPING_UPSE_COST_12_TITLE' , 'UPS Express Zone 10 Tariffs');
define('MODULE_SHIPPING_UPSE_COST_12_DESC' , 'Weight-based tariffs in zone 10. E.g.: shipping between 0 and 0.5 kg costs EUR 93,10 = 0.5:93.10,...');

define('MODULE_SHIPPING_UPSE_COUNTRIES_13_TITLE' , 'UPS Express Zone 11 Countries');
define('MODULE_SHIPPING_UPSE_COUNTRIES_13_DESC' ,'Comma separated list of 2-char ISO country codes in zone 11.');
define('MODULE_SHIPPING_UPSE_COST_13_TITLE' , 'UPS Express Zone 11 Tariffs');
define('MODULE_SHIPPING_UPSE_COST_13_DESC' , 'Weight-based tariffs in zone 11. E.g.: shipping between 0 and 0.5 kg costs 103.50 Euros = 0.5:103.50,...');

define('MODULE_SHIPPING_UPSE_COUNTRIES_14_TITLE' , 'UPS Express Zone 12 Countries');
define('MODULE_SHIPPING_UPSE_COUNTRIES_14_DESC' , 'Comma separated list of 2-char ISO country codes in zone 12.');
define('MODULE_SHIPPING_UPSE_COST_14_TITLE' , 'UPS Express Zone 12 Tariffs');
define('MODULE_SHIPPING_UPSE_COST_14_DESC' , 'Weight-based tariffs in zone 12. E.g.: shipping between 0 and 0.5 kg costs 105.20 = 0.5:105.20,...');
?>