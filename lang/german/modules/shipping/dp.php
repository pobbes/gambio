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

global $gmLangFileMaster;
$gmLangFileMaster->define_lang_file_content('lang/german/modules/shipping/dp.php');

/*
define('MODULE_SHIPPING_DP_TEXT_TITLE', 'Deutsche Post');
define('MODULE_SHIPPING_DP_TEXT_DESCRIPTION', 'Deutsche Post - Weltweites Versandmodul');
define('MODULE_SHIPPING_DP_TEXT_WAY', 'Versand nach');
define('MODULE_SHIPPING_DP_TEXT_UNITS', 'kg');
define('MODULE_SHIPPING_DP_INVALID_ZONE', 'Es ist leider kein Versand in dieses Land m&ouml;glich');
define('MODULE_SHIPPING_DP_UNDEFINED_RATE', 'Die Versandkosten k&ouml;nnen im Moment nicht errechnet werden');

define('MODULE_SHIPPING_DP_STATUS_TITLE' , 'Deutsche Post WorldNet');
define('MODULE_SHIPPING_DP_STATUS_DESC' , 'Wollen Sie den Versand über die deutsche Post anbieten?');
define('MODULE_SHIPPING_DP_HANDLING_TITLE' , 'Handling Fee');
define('MODULE_SHIPPING_DP_HANDLING_DESC' , 'Bearbeitungsgebühr für diese Versandart in Euro');
define('MODULE_SHIPPING_DP_TAX_CLASS_TITLE' , 'Steuersatz');
define('MODULE_SHIPPING_DP_TAX_CLASS_DESC' , 'Wählen Sie den MwSt.-Satz für diese Versandart aus.');
define('MODULE_SHIPPING_DP_ZONE_TITLE' , 'Versand Zone');
define('MODULE_SHIPPING_DP_ZONE_DESC' , 'Wenn Sie eine Zone auswählen, wird diese Versandart nur in dieser Zone angeboten.');
define('MODULE_SHIPPING_DP_SORT_ORDER_TITLE' , 'Reihenfolge der Anzeige');
define('MODULE_SHIPPING_DP_SORT_ORDER_DESC' , 'Niedrigste wird zuerst angezeigt.');
define('MODULE_SHIPPING_DP_ALLOWED_TITLE' , 'Einzelne Versandzonen');
define('MODULE_SHIPPING_DP_ALLOWED_DESC' , 'Geben Sie <b>einzeln</b> die Zonen an, in welche ein Versand möglich sein soll. zb AT,DE');
define('MODULE_SHIPPING_DP_COUNTRIES_1_TITLE' , 'Deutsche Post Zone 1 L&auml;nder');
define('MODULE_SHIPPING_DP_COUNTRIES_1_DESC' , 'Kommagetrennte Auflistung von 2-Zeichen ISO-L&auml;nder Codes in Zone 1');
define('MODULE_SHIPPING_DP_COST_1_TITLE' , 'Deutsche Post Zone 1 Versandkosten');
define('MODULE_SHIPPING_DP_COST_1_DESC' , 'Gewichtsbasierende Versandkosten der Zone 1. Z. B.: 5:16.50,10:20.50,... Bestellgewichte gr&ouml;&szlig;er 0kg und kleiner gleich 5kg kosten 16,50 f&uuml;r Zone 1 Versandl&auml;nder.');
define('MODULE_SHIPPING_DP_COUNTRIES_2_TITLE' , 'Deutsche Post Zone 2 L&auml;nder');
define('MODULE_SHIPPING_DP_COUNTRIES_2_DESC' , 'Kommagetrennte Auflistung von 2-Zeichen ISO-L&auml;nder Codes in Zone 2');
define('MODULE_SHIPPING_DP_COST_2_TITLE' , 'Deutsche Post Zone 2 Versandkosten');
define('MODULE_SHIPPING_DP_COST_2_DESC' , 'Gewichtsbasierende Versandkosten der Zone 2. Z. B.: 5:25.00,10:35.00,... Bestellgewichte gr&ouml;&szlig;er 0kg und kleiner gleich 5kg kosten 25,00 f&uuml;r Zone 2 Versandl&auml;nder.');
define('MODULE_SHIPPING_DP_COUNTRIES_3_TITLE' , 'Deutsche Post Zone 3 L&auml;nder');
define('MODULE_SHIPPING_DP_COUNTRIES_3_DESC' , 'Kommagetrennte Auflistung von 2-Zeichen ISO-L&auml;nder Codes in Zone 3');
define('MODULE_SHIPPING_DP_COST_3_TITLE' , 'Deutsche Post Zone 3 Versandkosten');
define('MODULE_SHIPPING_DP_COST_3_DESC' , 'Gewichtsbasierende Versandkosten der Zone 3. Z. B.: 5:29.00,10:39.00,... Bestellgewichte gr&ouml;&szlig;er 0kg und kleiner gleich 5kg kosten 29,50 f&uuml;r Zone 3 Versandl&auml;nder.');
define('MODULE_SHIPPING_DP_COUNTRIES_4_TITLE' , 'Deutsche Post Zone 4 L&auml;nder');
define('MODULE_SHIPPING_DP_COUNTRIES_4_DESC' , 'Kommagetrennte Auflistung von 2-Zeichen ISO-L&auml;nder Codes in Zone 4');
define('MODULE_SHIPPING_DP_COST_4_TITLE' , 'Deutsche Post Zone 4 Versandkosten');
define('MODULE_SHIPPING_DP_COST_4_DESC' , 'Gewichtsbasierende Versandkosten der Zone 4. Z. B.: 5:35.00,10:50.00,... Bestellgewichte gr&ouml;&szlig;er 0kg und kleiner gleich 5kg kosten 35,50 f&uuml;r Zone 4 Versandl&auml;nder.');
define('MODULE_SHIPPING_DP_COUNTRIES_5_TITLE' , 'Deutsche Post Zone 5 L&auml;nder');
define('MODULE_SHIPPING_DP_COUNTRIES_5_DESC' , 'Kommagetrennte Auflistung von 2-Zeichen ISO-L&auml;nder Codes in Zone 5');
define('MODULE_SHIPPING_DP_COST_5_TITLE' , 'Deutsche Post Zone 5 Versandkosten');
define('MODULE_SHIPPING_DP_COST_5_DESC' , 'Gewichtsbasierende Versandkosten der Zone 5. Z. B.: 5:35.00,10:50.00,... Bestellgewichte gr&ouml;&szlig;er 0kg und kleiner gleich 5kg kosten 35,50 f&uuml;r Zone 5 Versandl&auml;nder.');
define('MODULE_SHIPPING_DP_COUNTRIES_6_TITLE' , 'Deutsche Post Zone 6 L&auml;nder');
define('MODULE_SHIPPING_DP_COUNTRIES_6_DESC' , 'Kommagetrennte Auflistung von 2-Zeichen ISO-L&auml;nder Codes in Zone 6');
define('MODULE_SHIPPING_DP_COST_6_TITLE' , 'Deutsche Post Zone 6 Versandkosten');
define('MODULE_SHIPPING_DP_COST_6_DESC' , 'Gewichtsbasierende Versandkosten der Zone 6. Z. B.: E.g: 5:6.70,10:9.70,... Bestellgewichte gr&ouml;&szlig;er 0kg und kleiner gleich 5kg kosten 6,70 f&uuml;r Zone 6 Versandl&auml;nder.');
*/
?>