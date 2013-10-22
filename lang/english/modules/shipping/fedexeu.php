<?php
/* -----------------------------------------------------------------------------------------
   $Id: fedexeu.php 899 2005-04-29 02:40:57Z hhgag $   

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



define('MODULE_SHIPPING_FEDEXEU_TEXT_TITLE', 'FedEx Express Europe');
define('MODULE_SHIPPING_FEDEXEU_TEXT_DESCRIPTION', 'FedEx Express Europe');
define('MODULE_SHIPPING_FEDEXEU_TEXT_WAY', 'Dispatch to');
define('MODULE_SHIPPING_FEDEXEU_TEXT_UNITS', 'kg');
define('MODULE_SHIPPING_FEDEXEU_INVALID_ZONE', 'No shipping available to the country selected');
define('MODULE_SHIPPING_FEDEXEU_UNDEFINED_RATE', 'Shipping costs cannot be calculated currently');
define('MODULE_SHIPPING_FEDEXEU_STATUS_TITLE' , 'FedEx Express Europe');
define('MODULE_SHIPPING_FEDEXEU_STATUS_DESC' , 'Do you want to offer shipping via FedEx Express Europe?');
define('MODULE_SHIPPING_FEDEXEU_HANDLING_TITLE' , 'Handling Fee');
define('MODULE_SHIPPING_FEDEXEU_HANDLING_DESC' , 'Handling fee for this shipping method in Euros');
define('MODULE_SHIPPING_FEDEXEU_TAX_CLASS_TITLE' , 'Tax Rate');
define('MODULE_SHIPPING_FEDEXEU_TAX_CLASS_DESC' , 'Select the sales tax rate for this shipping method.');
define('MODULE_SHIPPING_FEDEXEU_ZONE_TITLE' , 'Shipping Zone');
define('MODULE_SHIPPING_FEDEXEU_ZONE_DESC' , 'If a zone is selected, this payment method will be enabled for that zone only.');
define('MODULE_SHIPPING_FEDEXEU_SORT_ORDER_TITLE' , 'Display Sort Order');
define('MODULE_SHIPPING_FEDEXEU_SORT_ORDER_DESC' , 'The lowest value is displayed first.');
define('MODULE_SHIPPING_FEDEXEU_ALLOWED_TITLE' , 'Allowed Shipping Zones');
define('MODULE_SHIPPING_FEDEXEU_ALLOWED_DESC' , 'Please enter the zones <b>individually</b> that should be allowed to use this module (e.g. US, UK (leave blank to allow all zones))');
define('MODULE_SHIPPING_FEDEXEU_COUNTRIES_1_TITLE' , 'Europe Zone 1 Countries');
define('MODULE_SHIPPING_FEDEXEU_COUNTRIES_1_DESC' , 'Comma separated list of 2-char ISO country codes in zone 1');
define('MODULE_SHIPPING_FEDEXEU_COST_PAK_1_TITLE' , 'Tariffs for Zone 1 up to 2.50 kg PAR');
define('MODULE_SHIPPING_FEDEXEU_COST_PAK_1_DESC' , 'Tariffs for zone 1 based on <b>\'PAR\'</b> up to 2.50 kg shipping weight.');
define('MODULE_SHIPPING_FEDEXEU_COST_BOX_1_TITLE' , 'Tariffs for Zone 1 up to 10 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_COST_BOX_1_DESC' , 'Tariffs for zone 1 based on <b>\'BOX\'</b> up to 10 kg shipping weight.');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_20_1_TITLE' , 'Surcharge up to 20 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_20_1_DESC' , 'Surcharge for each additional 0.50 kg in Euros');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_40_1_TITLE' , 'Surcharge up to 40 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_40_1_DESC' , 'Surcharge for each additional 0.50 kg in Euros');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_70_1_TITLE' , 'Surcharge up to 70 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_70_1_DESC' , 'Surcharge for each additional 0.50 kg in Euros');
define('MODULE_SHIPPING_FEDEXEU_COUNTRIES_2_TITLE' , 'Europe Zone 2 Countries');
define('MODULE_SHIPPING_FEDEXEU_COUNTRIES_2_DESC' , 'Comma separated list of 2-char ISO country codes in zone 2.');
define('MODULE_SHIPPING_FEDEXEU_COST_PAK_2_TITLE' , 'Tariffs for Zone 2 up to 2.50 kg PAR');
define('MODULE_SHIPPING_FEDEXEU_COST_PAK_2_DESC' , 'Tariffs for zone 2 based on <b>\'PAR\'</b> up to 2.50 kg shipping weight.');
define('MODULE_SHIPPING_FEDEXEU_COST_BOX_2_TITLE' , 'Tariffs for Zone 2 up to 10 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_COST_BOX_2_DESC' , 'Tariffs for zone 2 based on <b>\'BOX\'</b> up to 10 kg shipping weight.');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_20_2_TITLE' , 'Surcharge up to 20 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_20_2_DESC' , 'Surcharge for each additional 0.50 kg in Euros');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_40_2_TITLE' , 'Surcharge up to 40 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_40_2_DESC' , 'Surcharge for each additional 0.50 kg in Euros');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_70_2_TITLE' , 'Surcharge up to 70 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_70_2_DESC' , 'Surcharge for each additional 0.50 kg in Euros');
define('MODULE_SHIPPING_FEDEXEU_COUNTRIES_3_TITLE' , 'Europe Zone 3 Countries');
define('MODULE_SHIPPING_FEDEXEU_COUNTRIES_3_DESC' , 'Comma separated list of 2-char ISO country codes in zone 3.');
define('MODULE_SHIPPING_FEDEXEU_COST_PAK_3_TITLE' , 'Tariffs for Zone 3 up to 2.50 kg PAR');
define('MODULE_SHIPPING_FEDEXEU_COST_PAK_3_DESC' , 'Tariffs for zone 3 based on <b>\'PAR\'</b> up to 2.50 kg shipping weight.');
define('MODULE_SHIPPING_FEDEXEU_COST_BOX_3_TITLE' , 'Tariffs for Zone 3 up to 10 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_COST_BOX_3_DESC' , 'Tariffs for zone 3 based on <b>\'BOX\'</b> up to 10 kg shipping weight.');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_20_3_TITLE' , 'Surcharge up to 20 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_20_3_DESC' , 'Surcharge for each additional 0.50 kg in Euros');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_40_3_TITLE' , 'Surcharge up to 40 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_40_3_DESC' , 'Surcharge for each additional 0.50 kg in Euros');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_70_3_TITLE' , 'Surcharge up to 70 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_70_3_DESC' , 'Surcharge for each additional 0.50 kg in Euros');
define('MODULE_SHIPPING_FEDEXEU_COUNTRIES_4_TITLE' , 'World Zone A Countries');
define('MODULE_SHIPPING_FEDEXEU_COUNTRIES_4_DESC' , 'Comma separated list of 2-char ISO country codes in world zone A.');
define('MODULE_SHIPPING_FEDEXEU_COST_PAK_4_TITLE' , 'Tariffs for Zone A up to 2.50 kg PAR');
define('MODULE_SHIPPING_FEDEXEU_COST_PAK_4_DESC' , 'Tariffs for Zone A based on <b>\'PAR\'</b> up to 2.50 kg shipping weight.');
define('MODULE_SHIPPING_FEDEXEU_COST_BOX_4_TITLE' , 'Tariffs for Zone A up to 10 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_COST_BOX_4_DESC' , 'Tariffs for Zone A based on <b>\'BOX\'</b> up to 10 kg shipping weight.');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_20_4_TITLE' , 'Surcharge up to 20 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_20_4_DESC' , 'Surcharge for each additional 0.50 kg in Euros');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_40_4_TITLE' , 'Surcharge up to 40 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_40_4_DESC' , 'Surcharge for each additional 0.50 kg in Euros');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_70_4_TITLE' , 'Surcharge up to 70 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_70_4_DESC' , 'Surcharge for each additional 0.50 kg in Euros');
define('MODULE_SHIPPING_FEDEXEU_COUNTRIES_5_TITLE' , 'World Zone B Countries');
define('MODULE_SHIPPING_FEDEXEU_COUNTRIES_5_DESC' , 'Comma separated list of 2-char ISO country codes in world zone B.');
define('MODULE_SHIPPING_FEDEXEU_COST_PAK_5_TITLE' , 'Tariffs for Zone B up to 2.50 kg PAR');
define('MODULE_SHIPPING_FEDEXEU_COST_PAK_5_DESC' , 'Tariffs for Zone B based on <b>\'PAR\'</b> up to 2.50 kg shipping weight.');
define('MODULE_SHIPPING_FEDEXEU_COST_BOX_5_TITLE' , 'Tariffs for Zone B up to 10 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_COST_BOX_5_DESC' , 'Tariffs for Zone B based on <b>\'BOX\'</b> up to 10 kg shipping weight.');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_20_5_TITLE' , 'Surcharge up to 20 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_20_5_DESC' , 'Surcharge for each additional 0.50 kg in Euros');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_40_5_TITLE' , 'Surcharge up to 40 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_40_5_DESC' , 'Surcharge for each additional 0.50 kg in Euros');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_70_5_TITLE' , 'Surcharge up to 70 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_70_5_DESC' , 'Surcharge for each additional 0.50 kg in Euros');
define('MODULE_SHIPPING_FEDEXEU_COUNTRIES_6_TITLE' , 'World Zone C Countries');
define('MODULE_SHIPPING_FEDEXEU_COUNTRIES_6_DESC' , 'Comma separated list of 2-char ISO country codes in world zone C.');
define('MODULE_SHIPPING_FEDEXEU_COST_PAK_6_TITLE' , 'Tariffs for Zone C up to 2.50 kg PAR');
define('MODULE_SHIPPING_FEDEXEU_COST_PAK_6_DESC' , 'Tariffs for Zone C based on <b>\'PAR\'</b> up to 2.50 kg shipping weight.');
define('MODULE_SHIPPING_FEDEXEU_COST_BOX_6_TITLE' , 'Tariffs for Zone C up to 10 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_COST_BOX_6_DESC' , 'Tariffs for Zone C based on <b>\'BOX\'</b> up to 10 kg shipping weight.');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_20_6_TITLE' , 'Surcharge up to 20 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_20_6_DESC' , 'Surcharge for each additional 0.50 kg in Euros');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_40_6_TITLE' , 'Surcharge up to 40 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_40_6_DESC' , 'Surcharge for each additional 0.50 kg in Euros');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_70_6_TITLE' , 'Surcharge up to 70 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_70_6_DESC' , 'Surcharge for each additional 0.50 kg in Euros');
define('MODULE_SHIPPING_FEDEXEU_COUNTRIES_7_TITLE' , 'World Zone D Countries');
define('MODULE_SHIPPING_FEDEXEU_COUNTRIES_7_DESC' , 'Comma separated list of 2-char ISO country codes that are part of world zone D.');
define('MODULE_SHIPPING_FEDEXEU_COST_PAK_7_TITLE' , 'Tariffs for Zone D up to 2.50 kg PAR');
define('MODULE_SHIPPING_FEDEXEU_COST_PAK_7_DESC' , 'Tariffs for Zone D based on <b>\'PAR\'</b> up to 2.50 kg shipping weight.');
define('MODULE_SHIPPING_FEDEXEU_COST_BOX_7_TITLE' , 'Tariffs for Zone D up to 10 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_COST_BOX_7_DESC' , 'Tariffs for Zone D based on <b>\'BOX\'</b> up to 10 kg shipping weight.');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_20_7_TITLE' , 'Surcharge up to 20 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_20_7_DESC' , 'Surcharge for each additional 0.50 kg in Euros');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_40_7_TITLE' , 'Surcharge up to 40 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_40_7_DESC' , 'Surcharge for each additional 0.50 kg in Euros');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_70_7_TITLE' , 'Surcharge up to 70 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_70_7_DESC' , 'Surcharge for each additional 0.50 kg in Euros');
define('MODULE_SHIPPING_FEDEXEU_COUNTRIES_8_TITLE' , 'World Zone E Countries');
define('MODULE_SHIPPING_FEDEXEU_COUNTRIES_8_DESC' , 'Comma separated list of 2-char ISO country codes in world zone E.');
define('MODULE_SHIPPING_FEDEXEU_COST_PAK_8_TITLE' , 'Tariffs for Zone E up to 2.50 kg PAR');
define('MODULE_SHIPPING_FEDEXEU_COST_PAK_8_DESC' , 'Tariffs for zone E based on <b>\'PAR\'</b> up to 2.50 kg shipping weight.');
define('MODULE_SHIPPING_FEDEXEU_COST_BOX_8_TITLE' , 'Tariffs for Zone E up to 10 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_COST_BOX_8_DESC' , 'Tariffs for zone E based on <b>\'BOX\'</b> up to 10 kg shipping weight.');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_20_8_TITLE' , 'Surcharge up to 20 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_20_8_DESC' , 'Surcharge for each additional 0.50 kg in Euros');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_40_8_TITLE' , 'Surcharge up to 30 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_40_8_DESC' , 'Surcharge for each additional 0.50 kg in Euros');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_70_8_TITLE' , 'Surcharge up to 50 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_70_8_DESC' , 'Surcharge for each additional 0.50 kg in Euros');

?>