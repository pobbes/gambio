<?php
/* -----------------------------------------------------------------------------------------
   $Id: chp.php 899 2005-04-29 02:40:57Z hhgag $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(chp.php,v 1.01 2003/02/18 03:30:00); www.oscommerce.com 
   (c) 2003	 nextcommerce (chp.php,v 1.4 2003/08/1); www.nextcommerce.org

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   swiss_post_1.02       	Autor:	Copyright (C) 2002 - 2003 TheMedia, Dipl.-Ing Thomas Plänkers | http://www.themedia.at & http://www.oscommerce.at

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/


define('MODULE_SHIPPING_CHP_TEXT_TITLE', 'Swiss Post');
define('MODULE_SHIPPING_CHP_TEXT_DESCRIPTION', 'Swiss Post');
define('MODULE_SHIPPING_CHP_TEXT_WAY', 'Dispatch to');
define('MODULE_SHIPPING_CHP_TEXT_UNITS', 'kg');
define('MODULE_SHIPPING_CHP_INVALID_ZONE', 'No shipping available to the country selected');
define('MODULE_SHIPPING_CHP_UNDEFINED_RATE', 'Shipping costs cannot be calculated currently');

define('MODULE_SHIPPING_CHP_COST_PRI_5_TITLE' , 'Zone 4 Tariffs up to 30 kg PRI');
define('MODULE_SHIPPING_CHP_COST_PRI_5_DESC' , 'Tariffs for zone 4 based on <b>\'PRI\'</b> up to 30 kg shipping weight.');
define('MODULE_SHIPPING_CHP_COST_ECO_5_TITLE' , 'Zone 4 Tariffs up to 30 kg ECO');
define('MODULE_SHIPPING_CHP_COST_ECO_5_DESC' , ' Tariffs for zone 4 based on <b>\'ECO\'</b> up to 30 kg shipping weight.');
define('MODULE_SHIPPING_CHP_COUNTRIES_5_TITLE' , 'Tariff Zone 4 Countries');
define('MODULE_SHIPPING_CHP_COUNTRIES_5_DESC' , 'Comma separated list of the 2-char ISO country codes in zone 4.');
define('MODULE_SHIPPING_CHP_COST_ECO_4_TITLE' , 'Zone 3 Tariffs up to 30 kg ECO');
define('MODULE_SHIPPING_CHP_COST_ECO_4_DESC' , 'Tariffs for zone 3 based on <b>\'ECO\'</b> up to 30 kg shipping weight.');
define('MODULE_SHIPPING_CHP_COST_PRI_4_TITLE' , 'Zone 3 Tariffs up to 30 kg PRI');
define('MODULE_SHIPPING_CHP_COST_PRI_4_DESC' , 'Tariffs for zone 3 based on <b>\'PRI\'</b> up to 30 kg shipping weight.');
define('MODULE_SHIPPING_CHP_COST_URG_4_TITLE' , 'Zone 3 Tariffs up to 30 kg URG');
define('MODULE_SHIPPING_CHP_COST_URG_4_DESC' , 'Tariffs for zone 3 based on <b>\'URG\'</b> up to 30 kg shipping weight.');
define('MODULE_SHIPPING_CHP_COST_URG_3_TITLE' , 'Zone 2 Tariffs up to 30 kg URG');
define('MODULE_SHIPPING_CHP_COST_URG_3_DESC' , 'Tariffs for zone 2 based on <b>\'URG\'</b> up to 30 kg shipping weight.');
define('MODULE_SHIPPING_CHP_COUNTRIES_4_TITLE' , 'Tariff Zone 3 Countries');
define('MODULE_SHIPPING_CHP_COUNTRIES_4_DESC' , 'Comma separated list of the 2-char ISO country codes in zone 3.');
define('MODULE_SHIPPING_CHP_STATUS_TITLE' , 'Swiss Post');
define('MODULE_SHIPPING_CHP_STATUS_DESC' , 'Do you want to offer shipping via Swiss Post?');
define('MODULE_SHIPPING_CHP_HANDLING_TITLE' , 'Handling Fee');
define('MODULE_SHIPPING_CHP_HANDLING_DESC' , 'Handling fee for this shipping method in Swiss Francs');
define('MODULE_SHIPPING_CHP_TAX_CLASS_TITLE' , 'Tax Rate');
define('MODULE_SHIPPING_CHP_TAX_CLASS_DESC' , 'Select the sales tax rate for this shipping method.');
define('MODULE_SHIPPING_CHP_ZONE_TITLE' , 'Shipping Zone');
define('MODULE_SHIPPING_CHP_ZONE_DESC' , 'If a zone is selected, this payment method will be enabled for that zone only.');
define('MODULE_SHIPPING_CHP_SORT_ORDER_TITLE' , 'Display Sort Order');
define('MODULE_SHIPPING_CHP_SORT_ORDER_DESC' , 'The lowest value is displayed first.');
define('MODULE_SHIPPING_CHP_ALLOWED_TITLE' , 'Allowed Shipping Zones');
define('MODULE_SHIPPING_CHP_ALLOWED_DESC' , 'Please enter the zones <b>individually</b> that should be allowed to use this module (e.g. US, UK)');
define('MODULE_SHIPPING_CHP_COUNTRIES_1_TITLE' , 'Tariff Zone 0 Countries');
define('MODULE_SHIPPING_CHP_COUNTRIES_1_DESC' , 'Inland zone');
define('MODULE_SHIPPING_CHP_COST_ECO_1_TITLE' , 'Zone 0 Tariffs up to 30 kg ECO');
define('MODULE_SHIPPING_CHP_COST_ECO_1_DESC' , 'Tariffs for the inland zone based on <b>\'ECO\'</b> up to 30 kg shipping weight.');
define('MODULE_SHIPPING_CHP_COST_PRI_1_TITLE' , 'Zone 0 Tariffs up to 30 kg PRI');
define('MODULE_SHIPPING_CHP_COST_PRI_1_DESC' , 'Tariffs for the inland zone based on <b>\'PRI\'</b> up to 30 kg shipping weight.');
define('MODULE_SHIPPING_CHP_COUNTRIES_2_TITLE' , 'Tariff Zone 1 Countries');
define('MODULE_SHIPPING_CHP_COUNTRIES_2_DESC' , 'Comma separated list of the 2-char ISO country codes in zone 1.');
define('MODULE_SHIPPING_CHP_COST_ECO_2_TITLE' , 'Zone 1 Tariffs up to 30 kg ECO');
define('MODULE_SHIPPING_CHP_COST_ECO_2_DESC' , 'Tariffs for zone 1 based on <b>\'ECO\'</b> up to 30 kg shipping weight.');
define('MODULE_SHIPPING_CHP_COST_PRI_2_TITLE' , 'Zone 1 Tariffs up to 30 kg PRI');
define('MODULE_SHIPPING_CHP_COST_PRI_2_DESC' , 'Tariffs for zone 1 based on <b>\'PRI\'</b> up to 30 kg shipping weight.');
define('MODULE_SHIPPING_CHP_COST_URG_2_TITLE' , 'Tariffs for Zone 1 up to 30 kg URG');
define('MODULE_SHIPPING_CHP_COST_URG_2_DESC' , 'Tariffs for Zone 1 based on <b>\'URG\'</b> up to 30 kg shipping weight.');
define('MODULE_SHIPPING_CHP_COUNTRIES_3_TITLE' , 'Tariff Zone 2 Countries');
define('MODULE_SHIPPING_CHP_COUNTRIES_3_DESC' , 'Comma separated list of the 2-char ISO country codes in zone 2.');
define('MODULE_SHIPPING_CHP_COST_ECO_3_TITLE' , 'Zone 2 Tariffs up to 30 kg ECO');
define('MODULE_SHIPPING_CHP_COST_ECO_3_DESC' , 'Tariffs for zone 2 based on <b>\'ECO\'</b> up to 30 kg shipping weight.');
define('MODULE_SHIPPING_CHP_COST_PRI_3_TITLE' , 'Zone 2 Tariffs up to 30 kg PRI');
define('MODULE_SHIPPING_CHP_COST_PRI_3_DESC' , 'Tariffs for zone 2 based on <b>\'PRI\'</b> up to 30 kg shipping weight.');
define('MODULE_SHIPPING_CHP_COST_URG_5_TITLE' , ' Zone 4 Tariffs up to 30 kg URG');
define('MODULE_SHIPPING_CHP_COST_URG_5_DESC' , 'Tariffs for zone 4 based on <b>\'URG\'</b> up to 30 kg shipping weight.');
define('MODULE_SHIPPING_CHP_COUNTRIES_6_TITLE' , 'Tariff Zone 4 Countries');
define('MODULE_SHIPPING_CHP_COUNTRIES_6_DESC' , 'Comma separated list of the 2-char ISO country codes in zone 4.');
define('MODULE_SHIPPING_CHP_COST_ECO_6_TITLE' , 'Zone 4 Tariffs up to 30 kg ECO');
define('MODULE_SHIPPING_CHP_COST_ECO_6_DESC' , 'Tariffs for zone 4 based on <b>\'ECO\'</b> up to 30 kg shipping weight.');
define('MODULE_SHIPPING_CHP_COST_PRI_6_TITLE' , 'Zone 4 Tariffs up to 30 kg PRI');
define('MODULE_SHIPPING_CHP_COST_PRI_6_DESC' , ' Tariffs for zone 4 based on <b>\'PRI\'</b> up to 30 kg shipping weight.');
define('MODULE_SHIPPING_CHP_COST_URG_6_TITLE' , 'Zone 4 Tariffs up to 30 kg URG');
define('MODULE_SHIPPING_CHP_COST_URG_6_DESC' , ' Tariffs for zone 4 based on <b>\'URG\'</b> up to 30 kg shipping weight.');
define('MODULE_SHIPPING_CHP_COUNTRIES_7_TITLE' , 'Tariff Zone 5 Countries');
define('MODULE_SHIPPING_CHP_COUNTRIES_7_DESC' , 'Comma separated list of the 2-char ISO country codes in zone 5.');
define('MODULE_SHIPPING_CHP_COST_ECO_7_TITLE' , 'Zone 5 Tariffs up to 30 kg ECO');
define('MODULE_SHIPPING_CHP_COST_ECO_7_DESC' , 'Tariffs for zone 5 based on <b>\'ECO\'</b> up to 30 kg shipping weight.');
define('MODULE_SHIPPING_CHP_COST_PRI_7_TITLE' , ' Zone 5 Tariffs up to 30 kg PRI');
define('MODULE_SHIPPING_CHP_COST_PRI_7_DESC' , 'Tariffs for zone 5 based on <b>\'PRI\'</b> up to 30 kg shipping weight.');
define('MODULE_SHIPPING_CHP_COST_URG_7_TITLE' , ' Zone 5 Tariffs up to 30 kg URG');
define('MODULE_SHIPPING_CHP_COST_URG_7_DESC' , 'Tariffs for zone 5 based on <b>\'URG\'</b> up to 30 kg shipping weight.');
?>