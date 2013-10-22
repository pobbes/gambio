<?php
/* -----------------------------------------------------------------------------------------
   $Id: chronopost.php 899 2005-04-29 02:40:57Z hhgag $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(chronopost.php,v 1.0 2002/04/01 07:07:45); www.oscommerce.com
   (c) 2003	 nextcommerce (chronopost.php,v 1.4 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   chronopost-1.0.1       	Autor:	devteam@e-network.fr | www.oscommerce-fr.info

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/



define('MODULE_SHIPPING_CHRONOPOST_TEXT_TITLE', 'Chronopost Zone Rates');
define('MODULE_SHIPPING_CHRONOPOST_TEXT_DESCRIPTION', 'Chronopost zone-based rates');
define('MODULE_SHIPPING_CHRONOPOST_TEXT_WAY', 'Dispatch to');
define('MODULE_SHIPPING_CHRONOPOST_TEXT_UNITS', 'kg');
define('MODULE_SHIPPING_CHRONOPOST_INVALID_ZONE', 'Chronopost: No shipping available to the country selected');
define('MODULE_SHIPPING_CHRONOPOST_UNDEFINED_RATE', 'Chronopost: Shipping costs cannot be calculated currently');

define('MODULE_SHIPPING_CHRONOPOST_STATUS_TITLE' , 'Enable Chronopost');
define('MODULE_SHIPPING_CHRONOPOST_STATUS_DESC' , 'Do you want to offer shipping via Chronopost? (0=no, 1=yes)');
define('MODULE_SHIPPING_CHRONOPOST_HANDLING_TITLE' , 'Handling Fee');
define('MODULE_SHIPPING_CHRONOPOST_HANDLING_DESC' , 'Handling fee for shipping via Chronopost');
define('MODULE_SHIPPING_CHRONOPOST_ALLOWED_TITLE' , 'Allowed Shipping Zones');
define('MODULE_SHIPPING_CHRONOPOST_ALLOWED_DESC' , 'Please enter the zones <b>individually</b> that should be allowed to use this module (e.g. US, UK (leave blank to allow all zones))');
define('MODULE_SHIPPING_CHRONOPOST_COUNTRIES_1_TITLE' , 'Chronopost Zone 1 Countries');
define('MODULE_SHIPPING_CHRONOPOST_COUNTRIES_1_DESC' , 'Comma separate the 2-char ISO country codes in the same zone');
define('MODULE_SHIPPING_CHRONOPOST_COST_1_TITLE' , 'Chronopost Zone 1 (weight:tariffs)');
define('MODULE_SHIPPING_CHRONOPOST_COST_1_DESC' , 'Chronopost tariffs for zone 1 destinations based on a range of order weights (grams) followed by the Euro tariff (incl. tax). E.g.: 0-2000:28.71,2000-5000:34.38,... Weights less than 2 kg will be charged at 28.71 Euros (incl. tax) for zone 1 destinations');
define('MODULE_SHIPPING_CHRONOPOST_COUNTRIES_2_TITLE' , 'Chronopost Zone 2 Countries');
define('MODULE_SHIPPING_CHRONOPOST_COUNTRIES_2_DESC' , 'Comma separate the 2-char ISO country codes in the same zone');
define('MODULE_SHIPPING_CHRONOPOST_COST_2_TITLE' , 'Chronopost Zone 2 (weight:tariffs)');
define('MODULE_SHIPPING_CHRONOPOST_COST_2_DESC' , 'Chronopost tariffs for zone 2 destinations based on a range of order weights (grams) followed by the Euro tariff (incl. tax). E.g.: 0-2000:28.71,2000-5000:34.38,... Weights less than 2 kg will be charged at 28.71 Euros (incl. tax) for zone 1 destinations');
define('MODULE_SHIPPING_CHRONOPOST_COUNTRIES_3_TITLE' , 'Chronopost Zone 3 Countries');
define('MODULE_SHIPPING_CHRONOPOST_COUNTRIES_3_DESC' , 'Comma separate the 2-char ISO country codes in the same zone');
define('MODULE_SHIPPING_CHRONOPOST_COST_3_TITLE' , 'Chronopost Zone 3 (weight:tariffs)');
define('MODULE_SHIPPING_CHRONOPOST_COST_3_DESC' , 'Chronopost tariffs for zone 3 destinations based on a range of order weights (grams) followed by the Euro tariff (incl. tax). E.g.: 0-2000:28.71,2000-5000:34.38,... Weights less than 2 kg will be charged at 28.71 Euros (incl. tax) for zone 1 destinations');
define('MODULE_SHIPPING_CHRONOPOST_COST_10_TITLE' , 'Chronopost Zone 10 (weight:tariffs)');
define('MODULE_SHIPPING_CHRONOPOST_COST_10_DESC' , 'Chronopost tariffs for zone 10 destinations based on a range of order weights (grams) followed by the Euro tariff (incl. tax). E.g.: 0-2000:28.71,2000-5000:34.38,... Weights less than 2 kg will be charged at 28.71 Euros (incl. tax) for zone 1 destinations');
define('MODULE_SHIPPING_CHRONOPOST_TAX_CLASS_TITLE' , 'Tax Rate');
define('MODULE_SHIPPING_CHRONOPOST_TAX_CLASS_DESC' , 'Apply the following tax rate to the shipping costs.');
define('MODULE_SHIPPING_CHRONOPOST_ZONE_TITLE' , 'Shipping Zone');
define('MODULE_SHIPPING_CHRONOPOST_ZONE_DESC' , 'If a zone is selected, only enable this shipping method for that zone.');
define('MODULE_SHIPPING_CHRONOPOST_SORT_ORDER_TITLE' , 'Sort Order');
define('MODULE_SHIPPING_CHRONOPOST_SORT_ORDER_DESC' , 'Sort display order.');
define('MODULE_SHIPPING_CHRONOPOST_COUNTRIES_10_TITLE' , 'Chronopost Zone 10 Countries');
define('MODULE_SHIPPING_CHRONOPOST_COUNTRIES_10_DESC' , 'Comma separate the 2-char ISO country codes in the same zone');
define('MODULE_SHIPPING_CHRONOPOST_COST_9_TITLE' , 'Chronopost Zone 9 (weight:tariffs)');
define('MODULE_SHIPPING_CHRONOPOST_COST_9_DESC' , 'Chronopost tariffs for zone 9 destinations based on a range of order weights (grams) followed by the Euro tariff (incl. tax). E.g.: 0-2000:28.71,2000-5000:34.38,... Weights less than 2 kg will be charged at 28.71 Euros (incl. tax) for zone 1 destinations');
define('MODULE_SHIPPING_CHRONOPOST_COUNTRIES_9_TITLE' , 'Chronopost Zone 9 Countries');
define('MODULE_SHIPPING_CHRONOPOST_COUNTRIES_9_DESC' , 'Comma separate the 2-char ISO country codes in the same zone');
define('MODULE_SHIPPING_CHRONOPOST_COST_8_TITLE' , 'Chronopost Zone 8 (weight:tariffs)');
define('MODULE_SHIPPING_CHRONOPOST_COST_8_DESC' , 'Chronopost tariffs for zone 8 destinations based on a range of order weights (grams) followed by the Euro tariff (incl. tax). E.g.: 0-2000:28.71,2000-5000:34.38,... Weights less than 2 kg will be charged at 28.71 Euros (incl. tax) for zone 1 destinations');
define('MODULE_SHIPPING_CHRONOPOST_COUNTRIES_8_TITLE' , 'Chronopost Zone 8 Countries');
define('MODULE_SHIPPING_CHRONOPOST_COUNTRIES_8_DESC' , 'Comma separate the 2-char ISO country codes in the same zone');
define('MODULE_SHIPPING_CHRONOPOST_COST_7_TITLE' , 'Chronopost Zone 7 (weight:tariffs)');
define('MODULE_SHIPPING_CHRONOPOST_COST_7_DESC' , 'Chronopost tariffs for zone 7 destinations based on a range of order weights (grams) followed by the Euro tariff (incl. tax). E.g.: 0-2000:28.71,2000-5000:34.38,... Weights less than 2 kg will be charged at 28.71 Euros (incl. tax) for zone 1 destinations');
define('MODULE_SHIPPING_CHRONOPOST_COUNTRIES_7_TITLE' , 'Chronopost Zone 7 Countries');
define('MODULE_SHIPPING_CHRONOPOST_COUNTRIES_7_DESC' , 'Comma separate the 2-char ISO country codes in the same zone');
define('MODULE_SHIPPING_CHRONOPOST_COUNTRIES_6_TITLE' , 'Chronopost Zone 6 Countries');
define('MODULE_SHIPPING_CHRONOPOST_COUNTRIES_6_DESC' , 'Comma separate the 2-char ISO country codes in the same zone');
define('MODULE_SHIPPING_CHRONOPOST_COST_6_TITLE' , 'Chronopost Zone 6 (weight:tariffs)');
define('MODULE_SHIPPING_CHRONOPOST_COST_6_DESC' , 'Chronopost tariffs for zone 6 destinations based on a range of order weights (grams) followed by the Euro tariff (incl. tax). E.g.: 0-2000:28.71,2000-5000:34.38,... Weights less than 2 kg will be charged at 28.71 Euros (incl. tax) for zone 1 destinations');
define('MODULE_SHIPPING_CHRONOPOST_COUNTRIES_4_TITLE' , 'Chronopost Zone 4 Countries');
define('MODULE_SHIPPING_CHRONOPOST_COUNTRIES_4_DESC' , 'Comma separate the 2-char ISO country codes in the same zone');
define('MODULE_SHIPPING_CHRONOPOST_COST_4_TITLE' , 'Chronopost Zone 4 (weight:tariffs)');
define('MODULE_SHIPPING_CHRONOPOST_COST_4_DESC' , 'Chronopost tariffs for zone 4 destinations based on a range of order weights (grams) followed by the Euro tariff (incl. tax). E.g.: 0-2000:28.71,2000-5000:34.38,... Weights less than 2 kg will be charged at 28.71 Euros (incl. tax) for zone 1 destinations');
define('MODULE_SHIPPING_CHRONOPOST_COST_5_TITLE' , 'Chronopost Zone 5 (weight:tariffs)');
define('MODULE_SHIPPING_CHRONOPOST_COST_5_DESC' ,'Chronopost tariffs for zone 5 destinations based on a range of order weights (grams) followed by the Euro tariff (incl. tax). E.g.: 0-2000:28.71,2000-5000:34.38,... Weights less than 2 kg will be charged at 28.71 Euros (incl. tax) for zone 1 destinations');
define('MODULE_SHIPPING_CHRONOPOST_COUNTRIES_5_TITLE' , 'Chronopost Zone 5 Countries');
define('MODULE_SHIPPING_CHRONOPOST_COUNTRIES_5_DESC' , 'Comma separate the 2-char ISO country codes in the same zone');
?>