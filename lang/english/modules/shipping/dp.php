<?php
/* --------------------------------------------------------------
   dp.php 2010-01-08 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(dp.php,v 1.4 2003/02/18 04:28:00); www.oscommerce.com 
   (c) 2003	 nextcommerce (dp.php,v 1.5 2003/08/13); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: dp.php 899 2005-04-29 02:40:57Z hhgag $)

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   German Post (Deutsche Post WorldNet)         	Autor:	Copyright (C) 2002 - 2003 TheMedia, Dipl.-Ing Thomas Plänkers | http://www.themedia.at & http://www.oscommerce.at

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/


define('MODULE_SHIPPING_DP_TEXT_TITLE', 'German Post');
define('MODULE_SHIPPING_DP_TEXT_DESCRIPTION', 'German Post worldwide shipping module');
define('MODULE_SHIPPING_DP_TEXT_WAY', 'Dispatch to');
define('MODULE_SHIPPING_DP_TEXT_UNITS', 'kg');
define('MODULE_SHIPPING_DP_INVALID_ZONE', 'No shipping available to the country selected!');
define('MODULE_SHIPPING_DP_UNDEFINED_RATE', 'Shipping costs cannot be calculated currently');

define('MODULE_SHIPPING_DP_STATUS_TITLE' , 'German Post WorldNet');
define('MODULE_SHIPPING_DP_STATUS_DESC' , 'Do you want to offer shipping via German Post?');
define('MODULE_SHIPPING_DP_HANDLING_TITLE' , 'Handling Fee');
define('MODULE_SHIPPING_DP_HANDLING_DESC' , 'Handling fee for this shipping method in Euros');
define('MODULE_SHIPPING_DP_TAX_CLASS_TITLE' , 'Tax Rate');
define('MODULE_SHIPPING_DP_TAX_CLASS_DESC' , 'Select the sales tax rate for this shipping method.');
define('MODULE_SHIPPING_DP_ZONE_TITLE' , 'Shipping Zone');
define('MODULE_SHIPPING_DP_ZONE_DESC' , 'If a zone is selected, this payment method will be enabled for that zone only.');
define('MODULE_SHIPPING_DP_SORT_ORDER_TITLE' , 'Display Sort Order');
define('MODULE_SHIPPING_DP_SORT_ORDER_DESC' , 'The lowest value is displayed first.');
define('MODULE_SHIPPING_DP_ALLOWED_TITLE' , 'Allowed Shipping Zones');
define('MODULE_SHIPPING_DP_ALLOWED_DESC' , 'Please enter the zones <b>individually</b> that should be allowed to use this module (e.g. US, UK (leave blank to allow all zones))');
define('MODULE_SHIPPING_DP_COUNTRIES_1_TITLE' , 'German Post Zone 1 Countries');
define('MODULE_SHIPPING_DP_COUNTRIES_1_DESC' , 'Comma separated list of 2-char ISO country codes in zone 1');
define('MODULE_SHIPPING_DP_COST_1_TITLE' , 'German Post Zone 1 Tariffs');
define('MODULE_SHIPPING_DP_COST_1_DESC' , 'Tariffs to Zone 1 destinations based on a range of order weights. E.g: 5:16.50,10:20.50,... Weights greater than 0 and less than or equal to 5 would cost 16.50 for Zone 1 destinations.');
define('MODULE_SHIPPING_DP_COUNTRIES_2_TITLE' , 'German Post Zone 2 Countries');
define('MODULE_SHIPPING_DP_COUNTRIES_2_DESC' , 'Comma separated list of 2-char ISO country codes in zone 2');
define('MODULE_SHIPPING_DP_COST_2_TITLE' , 'German Post Zone 2 Tariffs');
define('MODULE_SHIPPING_DP_COST_2_DESC' , 'Tariffs to zone 2 destinations based on a range of order weights. E.g: 5:25.00,10:35.00,... Weights greater than 0 and less than or equal to 5 would cost 25.00 for zone 2 destinations.');
define('MODULE_SHIPPING_DP_COUNTRIES_3_TITLE' , 'German Post Zone 3 Countries');
define('MODULE_SHIPPING_DP_COUNTRIES_3_DESC' , 'Comma separated list of 2-char ISO country codes in zone 3');
define('MODULE_SHIPPING_DP_COST_3_TITLE' , 'German Post Zone 3 Tariffs');
define('MODULE_SHIPPING_DP_COST_3_DESC' , 'Tariffs to zone 3 destinations based on a range of order weights. E.g: 5:29.00,10:39.00,... Weights greater than 0 and less than or equal to 5 would cost 29.00 for zone 3 destinations.');
define('MODULE_SHIPPING_DP_COUNTRIES_4_TITLE' , 'German Post Zone 4 Countries');
define('MODULE_SHIPPING_DP_COUNTRIES_4_DESC' , 'Comma separated list of 2-char ISO country codes in zone 4');
define('MODULE_SHIPPING_DP_COST_4_TITLE' , 'German Post Zone 4 Tariffs');
define('MODULE_SHIPPING_DP_COST_4_DESC' , 'Tariffs to zone 4 destinations based on a range of order weights. E.g: 5:35.00,10:50.00,... Weights greater than 0 and less than or equal to 5 would cost 35.00 for zone 4 destinations.');
define('MODULE_SHIPPING_DP_COUNTRIES_5_TITLE' , 'German Post Zone 5 Countries');
define('MODULE_SHIPPING_DP_COUNTRIES_5_DESC' , 'Comma separated list of 2-char ISO country codes in zone 5');
define('MODULE_SHIPPING_DP_COST_5_TITLE' , 'German Post Zone 5 Tariffs');
define('MODULE_SHIPPING_DP_COST_5_DESC' , 'Tariffs to zone 5 destinations based on a range of order weights. E.g: 5:35.00,10:50.00,... Weights greater than 0 and less than or equal to 5 would cost 35.00 for zone 5 destinations.');
define('MODULE_SHIPPING_DP_COUNTRIES_6_TITLE' , 'German Post Zone 6 Countries');
define('MODULE_SHIPPING_DP_COUNTRIES_6_DESC' , 'Comma separated list of 2-char ISO country codes in zone 6');
define('MODULE_SHIPPING_DP_COST_6_TITLE' , 'German Post Zone 6 Tariffs');
define('MODULE_SHIPPING_DP_COST_6_DESC' , 'Tariffs to zone 6 destinations based on a range of order weights. E.g: 5:6.70,10:9.70,... Weights greater than 0 and less than or equal to 5 would cost 6.70 for zone 6 destinations.');
?>