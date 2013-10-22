<?php
/* --------------------------------------------------------------
   ot_ps_fee.php 2008-08-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(ot_cod_fee.php,v 1.02 2003/02/24); www.oscommerce.com
   (C) 2001 - 2003 TheMedia, Dipl.-Ing Thomas Plänkers ; http://www.themedia.at & http://www.oscommerce.at
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: ot_ps_fee.php 899 2005-04-29 02:40:57Z hhgag $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

global $gmLangFileMaster;
$gmLangFileMaster->define_lang_file_content('lang/german/modules/order_total/ot_ps_fee.php');
/*



  define('MODULE_ORDER_TOTAL_PS_FEE_TITLE', 'Eigenhändig');
  define('MODULE_ORDER_TOTAL_PS_FEE_DESCRIPTION', 'Berechnung Eigenhändig');

  define('MODULE_ORDER_TOTAL_PS_FEE_STATUS_TITLE','Eigenhändig');
  define('MODULE_ORDER_TOTAL_PS_FEE_STATUS_DESC','Berechnung Eigenhändig');

  define('MODULE_ORDER_TOTAL_PS_FEE_SORT_ORDER_TITLE','Sortierreihenfolge');
  define('MODULE_ORDER_TOTAL_PS_FEE_SORT_ORDER_DESC','Anzeigereihenfolge');

  define('MODULE_ORDER_TOTAL_PS_FEE_FLAT_TITLE','Pauschale Versandkosten');
  define('MODULE_ORDER_TOTAL_PS_FEE_FLAT_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br>
  00 als ISO2-Code erm&ouml;glicht die Gebühr für alle L&auml;nder. Wenn 
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn 
  kein 00:9.99 eingetragen ist, wird die Gebühr ins Ausland nicht berechnet 
  (nicht m&ouml;glich).');

  define('MODULE_ORDER_TOTAL_PS_FEE_ITEM_TITLE','Versandkosten pro St&uuml;ck');
  define('MODULE_ORDER_TOTAL_PS_FEE_ITEM_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br>
  00 als ISO2-Code erm&ouml;glicht die Gebühr für alle L&auml;nder. Wenn 
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn 
  kein 00:9.99 eingetragen ist, wird die Gebühr ins Ausland nicht berechnet  
  (nicht m&ouml;glich).');

  define('MODULE_ORDER_TOTAL_PS_FEE_TABLE_TITLE','Tabellarische Versandkosten');
  define('MODULE_ORDER_TOTAL_PS_FEE_TABLE_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br>
  00 als ISO2-Code erm&ouml;glicht die Gebühr für alle L&auml;nder. Wenn 
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn 
  kein 00:9.99 eingetragen ist, wird die Gebühr ins Ausland nicht berechnet  
  (nicht m&ouml;glich).');

  define('MODULE_ORDER_TOTAL_PS_FEE_ZONES_TITLE','Versandkosten nach Zonen');
  define('MODULE_ORDER_TOTAL_PS_FEE_ZONES_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br>
  00 als ISO2-Code erm&ouml;glicht die Gebühr für alle L&auml;nder. Wenn 
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn 
  kein 00:9.99 eingetragen ist, wird die Gebühr ins Ausland nicht berechnet 
  (nicht m&ouml;glich).');

  define('MODULE_ORDER_TOTAL_PS_FEE_AP_TITLE','&Ouml;sterreichische Post AG');
  define('MODULE_ORDER_TOTAL_PS_FEE_AP_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br>
  00 als ISO2-Code erm&ouml;glicht die Gebühr für alle L&auml;nder. Wenn 
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn 
  kein 00:9.99 eingetragen ist, wird die Gebühr ins Ausland nicht berechnet 
  (nicht m&ouml;glich).');

  define('MODULE_ORDER_TOTAL_PS_FEE_DP_TITLE','Deutsche Post AG');
  define('MODULE_ORDER_TOTAL_PS_FEE_DP_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br>
  00 als ISO2-Code erm&ouml;glicht die Gebühr für alle L&auml;nder. Wenn 
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn 
  kein 00:9.99 eingetragen ist, wird die Gebühr ins Ausland nicht berechnet  
  (nicht m&ouml;glich).');
	
  define('MODULE_ORDER_TOTAL_PS_FEE_DPD_TITLE','DPD');
  define('MODULE_ORDER_TOTAL_PS_FEE_DPD_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br>
  00 als ISO2-Code erm&ouml;glicht die Gebühr für alle L&auml;nder. Wenn 
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn 
  kein 00:9.99 eingetragen ist, wird die Gebühr ins Ausland nicht berechnet  
  (nicht m&ouml;glich).');

  define('MODULE_ORDER_TOTAL_PS_FEE_TAX_CLASS_TITLE','Steuerklasse');
  define('MODULE_ORDER_TOTAL_PS_FEE_TAX_CLASS_DESC','W&auml;hlen Sie eine Steuerklasse.');
	
*/
?>
