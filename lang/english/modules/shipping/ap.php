<?php
/* -----------------------------------------------------------------------------------------
   $Id: ap.php 899 2005-04-29 02:40:57Z hhgag $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(ap.php,v 1.02 2003/02/18); www.oscommerce.com 
   (c) 2003	 nextcommerce (ap.php,v 1.4 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   austrian_post_1.05       	Autor:	Copyright (C) 2002 - 2003 TheMedia, Dipl.-Ing Thomas Plänkers | http://www.themedia.at & http://www.oscommerce.at

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   

define('MODULE_SHIPPING_AP_TEXT_TITLE', 'Austrian Post AG');
define('MODULE_SHIPPING_AP_TEXT_DESCRIPTION', 'Austrian Post AG worldwide shipping');
define('MODULE_SHIPPING_AP_TEXT_WAY', 'Dispatch to');
define('MODULE_SHIPPING_AP_TEXT_UNITS', 'kg');
define('MODULE_SHIPPING_AP_INVALID_ZONE', 'No shipping available to the country selected');
define('MODULE_SHIPPING_AP_UNDEFINED_RATE', 'Shipping costs cannot be calculated currently');

define('MODULE_SHIPPING_AP_STATUS_TITLE' , 'Austrian Post AG');
define('MODULE_SHIPPING_AP_STATUS_DESC' , 'Do you want to offer shipping via Austrian Post AG?');
define('MODULE_SHIPPING_AP_HANDLING_TITLE' , 'Handling Fee');
define('MODULE_SHIPPING_AP_HANDLING_DESC' , 'Handling fee for this shipping method in Euros');
define('MODULE_SHIPPING_AP_TAX_CLASS_TITLE' , 'Tax Rate');
define('MODULE_SHIPPING_AP_TAX_CLASS_DESC' , 'Select the sales tax rate for this shipping method.');
define('MODULE_SHIPPING_AP_ZONE_TITLE' , 'Shipping Zone');
define('MODULE_SHIPPING_AP_ZONE_DESC' , 'If a zone is selected, this payment method will be enabled for that zone only.');
define('MODULE_SHIPPING_AP_SORT_ORDER_TITLE' , 'Display Sort Order');
define('MODULE_SHIPPING_AP_SORT_ORDER_DESC' , 'The lowest value is displayed first.');
define('MODULE_SHIPPING_AP_ALLOWED_TITLE' , 'Allowed Shipping Zones');
define('MODULE_SHIPPING_AP_ALLOWED_DESC' ,'Please enter the zones <b>individually</b> that should be allowed to use this module (e.g. US, UK (leave blank to allow all zones))');
define('MODULE_SHIPPING_AP_COUNTRIES_1_TITLE' , 'Zone 1a Countries');
define('MODULE_SHIPPING_AP_COUNTRIES_1_DESC' , 'Comma separated list of the 2-char ISO country codes in zone 1a.');
define('MODULE_SHIPPING_AP_COST_1_TITLE' , 'Zone 1a Tariffs up to 20 kg');
define('MODULE_SHIPPING_AP_COST_1_DESC' , 'Tariffs for zone 1a based on <b>\'Express Parcel\'</b> up to 20 kg shipping weight.');
define('MODULE_SHIPPING_AP_COUNTRIES_2_TITLE' , 'Zone 1b Countries');
define('MODULE_SHIPPING_AP_COUNTRIES_2_DESC' , 'Comma separated list of the 2-char ISO country codes in zone 1b.');
define('MODULE_SHIPPING_AP_COST_2_TITLE' , 'Zone 1b Tariffs up to 20 kg');
define('MODULE_SHIPPING_AP_COST_2_DESC' , 'Tariffs for zone 1b based on <b>\'Express Parcel\'</b> up to 20 kg shipping weight.');
define('MODULE_SHIPPING_AP_COUNTRIES_3_TITLE' , 'Zone 2 Countries');
define('MODULE_SHIPPING_AP_COUNTRIES_3_DESC' , 'Comma separated list of the 2-char ISO country codes in zone 2.');
define('MODULE_SHIPPING_AP_COST_3_TITLE' , 'Zone 2 Tariffs up to 20 kg');
define('MODULE_SHIPPING_AP_COST_3_DESC' , 'Tariffs for zone 2 based on <b>\'Express Parcel\'</b> up to 20 kg shipping weight.');
define('MODULE_SHIPPING_AP_COUNTRIES_4_TITLE' , 'Zone 3 Countries');
define('MODULE_SHIPPING_AP_COUNTRIES_4_DESC' , 'Comma separated list of the 2-char ISO country codes in zone 3.');
define('MODULE_SHIPPING_AP_COST_4_TITLE' , 'Zone 3 Tariffs up to 20 kg');
define('MODULE_SHIPPING_AP_COST_4_DESC' , 'Tariffs for zone 3 based on <b>\'Express Parcel\'</b> up to 20 kg shipping weight.');
define('MODULE_SHIPPING_AP_COUNTRIES_5_TITLE' , 'Zone 4 Countries');
define('MODULE_SHIPPING_AP_COUNTRIES_5_DESC' , 'Comma separated list of the 2-char ISO country codes in zone 4.');
define('MODULE_SHIPPING_AP_COST_5_TITLE' , 'Zone 4 Tariffs up to 20 kg');
define('MODULE_SHIPPING_AP_COST_5_DESC' , 'Tariffs for zone 4 based on <b>\'Express Parcel\'</b> up to 20 kg shipping weight.');
define('MODULE_SHIPPING_AP_COUNTRIES_6_TITLE' , 'Zone 4 Countries');
define('MODULE_SHIPPING_AP_COUNTRIES_6_DESC' ,'Comma separated list of the 2-char ISO country codes in zone 4.');
define('MODULE_SHIPPING_AP_COST_6_TITLE' , 'Zone 4 Tariffs up to 20 kg');
define('MODULE_SHIPPING_AP_COST_6_DESC' , 'Tariffs for zone 4 based on <b>\'Express Parcel\'</b> up to 20 kg shipping weight.');
define('MODULE_SHIPPING_AP_COUNTRIES_7_TITLE' , 'Zone 5 Countries');
define('MODULE_SHIPPING_AP_COUNTRIES_7_DESC' ,'Comma separated list of the 2-char ISO country codes in zone 5.');
define('MODULE_SHIPPING_AP_COST_7_TITLE' , 'Zone 5 Tariffs up to 20 kg');
define('MODULE_SHIPPING_AP_COST_7_DESC' , 'Tariffs for zone 5 based on <b>\'Express Parcel\'</b> up to 20 kg shipping weight.');
define('MODULE_SHIPPING_AP_COUNTRIES_8_TITLE' , 'Inland Zone');
define('MODULE_SHIPPING_AP_COUNTRIES_8_DESC' , 'Inland zone');
define('MODULE_SHIPPING_AP_COST_8_TITLE' , 'Inland Zone Tariffs up to 31.5 kg');
define('MODULE_SHIPPING_AP_COST_8_DESC' , 'Tariffs for the inland zone up to 31.5 kg shipping weight.');

?>