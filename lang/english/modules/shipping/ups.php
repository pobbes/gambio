<?php
/* -----------------------------------------------------------------------------------------
   $Id: UPS.php,v 1.1 2003/09/06 21:54:34 fanta2k Exp $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(UPS.php,v 1.4 2003/02/18 04:28:00); www.oscommerce.com 
   (c) 2003	 nextcommerce (UPS.php,v 1.5 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   German Post (Deutsche Post WorldNet)
   Autor:	Copyright (C) 2002 - 2003 TheMedia, Dipl.-Ing Thomas Plänkers | http://www.themedia.at & http://www.oscommerce.at
   Changes for personal use: Copyright (C) 2004 Comm4All, Bernd Blazynski | http://www.comm4all.com & http://www.cheapshirt.de

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/


define('MODULE_SHIPPING_UPS_TEXT_TITLE', 'United Parcel Service Standard');
define('MODULE_SHIPPING_UPS_TEXT_DESCRIPTION', 'United Parcel Service Standard shipping module');
define('MODULE_SHIPPING_UPS_TEXT_WAY', 'Dispatch to');
define('MODULE_SHIPPING_UPS_TEXT_UNITS', 'kg');
define('MODULE_SHIPPING_UPS_TEXT_FREE', 'We will ship orders over ' . MODULE_SHIPPING_UPS_FREEAMOUNT . ' Euros free of charge!');
define('MODULE_SHIPPING_UPS_TEXT_LOW', 'We will ship orders over ' . MODULE_SHIPPING_UPS_FREEAMOUNT . ' Euros at a reduced tariff!');
define('MODULE_SHIPPING_UPS_INVALID_ZONE', 'No shipping available to the country selected');
define('MODULE_SHIPPING_UPS_UNDEFINED_RATE', 'Shipping costs cannot be calculated currently');

define('MODULE_SHIPPING_UPS_STATUS_TITLE' , 'UPS Standard');
define('MODULE_SHIPPING_UPS_STATUS_DESC' , 'Do you want to offer shipping via UPS Standard?');
define('MODULE_SHIPPING_UPS_HANDLING_TITLE' , 'Handling Fee');
define('MODULE_SHIPPING_UPS_HANDLING_DESC' , 'Handling fee for this shipping method in Euros');
define('MODULE_SHIPPING_UPS_TAX_CLASS_TITLE' , 'Tax Class');
define('MODULE_SHIPPING_UPS_TAX_CLASS_DESC' , 'Select the tax class for this shipping method.');
define('MODULE_SHIPPING_UPS_ZONE_TITLE' , 'Shipping Zone');
define('MODULE_SHIPPING_UPS_ZONE_DESC' , 'If a zone is selected, this payment method will be enabled for that zone only.');
define('MODULE_SHIPPING_UPS_SORT_ORDER_TITLE' , 'Display Sort Order');
define('MODULE_SHIPPING_UPS_SORT_ORDER_DESC' , 'The lowest value is displayed first.');
define('MODULE_SHIPPING_UPS_ALLOWED_TITLE' , 'Allowed Shipping Zones');
define('MODULE_SHIPPING_UPS_ALLOWED_DESC' , 'Please enter the zones <b>individually</b> that should be allowed to use this module (e.g. US, UK (leave blank to allow all zones))');
define('MODULE_SHIPPING_UPS_FREEAMOUNT_TITLE' , 'Free Shipping Inland');
define('MODULE_SHIPPING_UPS_FREEAMOUNT_DESC' , 'Minimum order value for free shipping inland and a reduced tariff to foreign countries.');

define('MODULE_SHIPPING_UPS_COUNTRIES_1_TITLE' , 'UPS Standard Zone 1 Countries');
define('MODULE_SHIPPING_UPS_COUNTRIES_1_DESC' , 'Comma separated list of 2-char ISO country codes in zone 1.');
define('MODULE_SHIPPING_UPS_COST_1_TITLE' , 'UPS Standard Zone 1 Tariffs');
define('MODULE_SHIPPING_UPS_COST_1_DESC' , 'Weight-based tariffs in zone 1. E.g.: shipping between 0 and 4 kg costs 5.15 Euros = 4:5.15,...');

define('MODULE_SHIPPING_UPS_COUNTRIES_2_TITLE' , 'UPS Standard Zone 3 Countries');
define('MODULE_SHIPPING_UPS_COUNTRIES_2_DESC' , 'Comma separated list of 2-char ISO country codes in zone 3.');
define('MODULE_SHIPPING_UPS_COST_2_TITLE' , 'UPS Standard Zone 3 Tariffs');
define('MODULE_SHIPPING_UPS_COST_2_DESC' , 'Weight-based tariffs in zone 3. E.g.: shipping between 0 and 4 kg costs 13.75 Euros = 4:13.75,...');
define('MODULE_SHIPPING_UPS_COUNTRIES_3_TITLE' , 'UPS Standard Zone 31 Countries');
define('MODULE_SHIPPING_UPS_COUNTRIES_3_DESC' , 'Comma separated list of 2-char ISO country codes in zone 31.');
define('MODULE_SHIPPING_UPS_COST_3_TITLE' , 'UPS Standard Zone 31 Countries Tariffs');
define('MODULE_SHIPPING_UPS_COST_3_DESC' , 'Weight-based tariffs in zone 31. E.g.: shipping between 0 and 4 kg costs 23.50 Euros = 4:23.50,...');
define('MODULE_SHIPPING_UPS_COUNTRIES_4_TITLE' , 'UPS Standard Zone 4 Countries');
define('MODULE_SHIPPING_UPS_COUNTRIES_4_DESC' , 'Comma separated list of 2-char ISO country codes in zone 4.');
define('MODULE_SHIPPING_UPS_COST_4_TITLE' , 'UPS Standard Zone 4 Tariffs');
define('MODULE_SHIPPING_UPS_COST_4_DESC' , 'Weight-based tariffs in zone 4. E.g.: shipping between 0 and 4 kg costs 25.40 Euros = 4:25.40,...');
define('MODULE_SHIPPING_UPS_COUNTRIES_5_TITLE' , 'UPS Standard Zone 41 Countries');
define('MODULE_SHIPPING_UPS_COUNTRIES_5_DESC' , 'Comma separated list of 2-char ISO country codes in zone 41.');
define('MODULE_SHIPPING_UPS_COST_5_TITLE' , 'Tariffs for UPS Standard Zone 41');
define('MODULE_SHIPPING_UPS_COST_5_DESC' , 'Weight-based tariffs in zone 41. E.g.: shipping between 0 and 4 kg costs 30.00 Euros = 4:30.00,...');
define('MODULE_SHIPPING_UPS_COUNTRIES_6_TITLE' , 'UPS Standard Zone 5 Countries');
define('MODULE_SHIPPING_UPS_COUNTRIES_6_DESC' , 'Comma separated list of 2-char ISO country codes in zone 5.');
define('MODULE_SHIPPING_UPS_COST_6_TITLE' , 'UPS Standard Zone 5 Tariffs');
define('MODULE_SHIPPING_UPS_COST_6_DESC' , 'Weight-based tariffs in zone 4. E.g.: shipping between 0 and 4 kg costs 34.35 Euros = 4:34.35,...');
define('MODULE_SHIPPING_UPS_COUNTRIES_7_TITLE' , 'UPS Standard Zone 6 Countries');
define('MODULE_SHIPPING_UPS_COUNTRIES_7_DESC' , 'Comma separated list of 2-char ISO country codes in zone 6.');
define('MODULE_SHIPPING_UPS_COST_7_TITLE' , 'UPS Standard Zone 6 Tariffs');
define('MODULE_SHIPPING_UPS_COST_7_DESC' ,  'Weight-based tariffs in zone 6. E.g.: shipping between 0 and 4 kg costs 37.10 Euros = 4:37.10,...');

?>