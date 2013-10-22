<?php
/* --------------------------------------------------------------
   ot_cod_fee.php 2008-08-10 gambio
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
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: ot_cod_fee.php 1003 2005-07-10 18:58:52Z mz $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

global $gmLangFileMaster;
$gmLangFileMaster->define_lang_file_content('lang/german/modules/order_total/ot_cod_fee.php');



/*

  define('MODULE_ORDER_TOTAL_COD_FEE_FEDEXEU_TITLE','FedEx Express Europa');
  define('MODULE_ORDER_TOTAL_COD_FEE_FEDEXEU_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br />
  00 als ISO2-Code erm&ouml;glicht den Nachnahmeversand in alle L&auml;nder. Wenn 
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn 
  kein 00:9.99 eingetragen ist, wird der Nachnahmeversand ins Ausland nicht berechnet 
  (nicht m&ouml;glich).');

  define('MODULE_ORDER_TOTAL_COD_FEE_GAMBIOULTRA_TITLE','Feste Versandkosten je Artikel');
  define('MODULE_ORDER_TOTAL_COD_FEE_GAMBIOULTRA_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br />
  00 als ISO2-Code erm&ouml;glicht den Nachnahmeversand in alle L&auml;nder. Wenn 
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn 
  kein 00:9.99 eingetragen ist, wird der Nachnahmeversand ins Ausland nicht berechnet 
  (nicht m&ouml;glich).');

  define('MODULE_ORDER_TOTAL_COD_FEE_SELFPICKUP_TITLE','Selbstabholung');
  define('MODULE_ORDER_TOTAL_COD_FEE_SELFPICKUP_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br />
  00 als ISO2-Code erm&ouml;glicht den Nachnahmeversand in alle L&auml;nder. Wenn 
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn 
  kein 00:9.99 eingetragen ist, wird der Nachnahmeversand ins Ausland nicht berechnet 
  (nicht m&ouml;glich).');

  define('MODULE_ORDER_TOTAL_COD_FEE_ZONESE_TITLE','Versicherter Versand');
  define('MODULE_ORDER_TOTAL_COD_FEE_ZONESE_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br />
  00 als ISO2-Code erm&ouml;glicht den Nachnahmeversand in alle L&auml;nder. Wenn 
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn 
  kein 00:9.99 eingetragen ist, wird der Nachnahmeversand ins Ausland nicht berechnet 
  (nicht m&ouml;glich).');

  define('MODULE_ORDER_TOTAL_COD_FEE_TITLE', 'Nachnahmegeb&uuml;hr');
  define('MODULE_ORDER_TOTAL_COD_FEE_DESCRIPTION', 'Berechnung der Nachnahmegeb&uuml;hr');

  define('MODULE_ORDER_TOTAL_COD_FEE_STATUS_TITLE','Nachnahmegeb&uuml;hr');
  define('MODULE_ORDER_TOTAL_COD_FEE_STATUS_DESC','Berechnung der Nachnahmegeb&uuml;hr');

  define('MODULE_ORDER_TOTAL_COD_FEE_SORT_ORDER_TITLE','Sortierreihenfolge');
  define('MODULE_ORDER_TOTAL_COD_FEE_SORT_ORDER_DESC','Anzeigereihenfolge');

  define('MODULE_ORDER_TOTAL_COD_FEE_FLAT_TITLE','Pauschale Versandkosten');
  define('MODULE_ORDER_TOTAL_COD_FEE_FLAT_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br />
  00 als ISO2-Code erm&ouml;glicht den Nachnahmeversand in alle L&auml;nder. Wenn 
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn 
  kein 00:9.99 eingetragen ist, wird der Nachnahmeversand ins Ausland nicht berechnet 
  (nicht m&ouml;glich).');

  define('MODULE_ORDER_TOTAL_COD_FEE_ITEM_TITLE','Versandkosten pro St&uuml;ck');
  define('MODULE_ORDER_TOTAL_COD_FEE_ITEM_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br />
  00 als ISO2-Code erm&ouml;glicht den Nachnahmeversand in alle L&auml;nder. Wenn 
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn 
  kein 00:9.99 eingetragen ist, wird der Nachnahmeversand ins Ausland nicht berechnet 
  (nicht m&ouml;glich).');

  define('MODULE_ORDER_TOTAL_COD_FEE_TABLE_TITLE','Tabellarische Versandkosten');
  define('MODULE_ORDER_TOTAL_COD_FEE_TABLE_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br />
  00 als ISO2-Code erm&ouml;glicht den Nachnahmeversand in alle L&auml;nder. Wenn 
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn 
  kein 00:9.99 eingetragen ist, wird der Nachnahmeversand ins Ausland nicht berechnet 
  (nicht m&ouml;glich).');

  define('MODULE_ORDER_TOTAL_COD_FEE_ZONES_TITLE','Versandkosten nach Zonen');
  define('MODULE_ORDER_TOTAL_COD_FEE_ZONES_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br />
  00 als ISO2-Code erm&ouml;glicht den Nachnahmeversand in alle L&auml;nder. Wenn 
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn 
  kein 00:9.99 eingetragen ist, wird der Nachnahmeversand ins Ausland nicht berechnet 
  (nicht m&ouml;glich).');

  define('MODULE_ORDER_TOTAL_COD_FEE_AP_TITLE','&Ouml;sterreichische Post AG');
  define('MODULE_ORDER_TOTAL_COD_FEE_AP_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br />
  00 als ISO2-Code erm&ouml;glicht den Nachnahmeversand in alle L&auml;nder. Wenn 
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn 
  kein 00:9.99 eingetragen ist, wird der Nachnahmeversand ins Ausland nicht berechnet 
  (nicht m&ouml;glich).');

  define('MODULE_ORDER_TOTAL_COD_FEE_CHP_TITLE','Schweizerische Post');
  define('MODULE_ORDER_TOTAL_COD_FEE_CHP_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br />
  00 als ISO2-Code erm&ouml;glicht den Nachnahmeversand in alle L&auml;nder. Wenn
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn
  kein 00:9.99 eingetragen ist, wird der Nachnahmeversand ins Ausland nicht berechnet
  (nicht m&ouml;glich).');

  define('MODULE_ORDER_TOTAL_COD_FEE_CHRONOPOST_TITLE','Chronopost Zone Rates');
  define('MODULE_ORDER_TOTAL_COD_FEE_CHRONOPOST_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br />
  00 als ISO2-Code erm&ouml;glicht den Nachnahmeversand in alle L&auml;nder. Wenn
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn
  kein 00:9.99 eingetragen ist, wird der Nachnahmeversand ins Ausland nicht berechnet
  (nicht m&ouml;glich).');

  define('MODULE_ORDER_TOTAL_COD_FEE_DHL_TITLE','DHL &Ouml;sterreich');
  define('MODULE_ORDER_TOTAL_COD_FEE_DHL_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br />
  00 als ISO2-Code erm&ouml;glicht den Nachnahmeversand in alle L&auml;nder. Wenn
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn
  kein 00:9.99 eingetragen ist, wird der Nachnahmeversand ins Ausland nicht berechnet
  (nicht m&ouml;glich).');

  define('MODULE_ORDER_TOTAL_COD_FEE_DP_TITLE','Deutsche Post AG');
  define('MODULE_ORDER_TOTAL_COD_FEE_DP_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br />
  00 als ISO2-Code erm&ouml;glicht den Nachnahmeversand in alle L&auml;nder. Wenn
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn
  kein 00:9.99 eingetragen ist, wird der Nachnahmeversand ins Ausland nicht berechnet
  (nicht m&ouml;glich).');
  
  define('MODULE_ORDER_TOTAL_COD_FEE_UPS_TITLE','UPS');
  define('MODULE_ORDER_TOTAL_COD_FEE_UPS_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br />
  00 als ISO2-Code erm&ouml;glicht den Nachnahmeversand in alle L&auml;nder. Wenn
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn
  kein 00:9.99 eingetragen ist, wird der Nachnahmeversand ins Ausland nicht berechnet
  (nicht m&ouml;glich).');
  
  define('MODULE_ORDER_TOTAL_COD_FEE_UPSE_TITLE','UPS Express');
  define('MODULE_ORDER_TOTAL_COD_FEE_UPSE_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br />
  00 als ISO2-Code erm&ouml;glicht den Nachnahmeversand in alle L&auml;nder. Wenn
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn
  kein 00:9.99 eingetragen ist, wird der Nachnahmeversand ins Ausland nicht berechnet
  (nicht m&ouml;glich).');
	
  define('MODULE_ORDER_TOTAL_COD_FEE_FREE_TITLE','Versandkostenfrei (Modul Versandkosten in Zusammenfassung)');
  define('MODULE_ORDER_TOTAL_COD_FEE_FREE_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br />
  00 als ISO2-Code erm&ouml;glicht den Nachnahmeversand in alle L&auml;nder. Wenn
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn
  kein 00:9.99 eingetragen ist, wird der Nachnahmeversand ins Ausland nicht berechnet
  (nicht m&ouml;glich).');
  
  define('MODULE_ORDER_TOTAL_COD_FEE_DPD_TITLE','DPD');
  define('MODULE_ORDER_TOTAL_COD_FEE_DPD_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br />
  00 als ISO2-Code erm&ouml;glicht den Nachnahmeversand in alle L&auml;nder. Wenn
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn
  kein 00:9.99 eingetragen ist, wird der Nachnahmeversand ins Ausland nicht berechnet
  (nicht m&ouml;glich).');
	
  define('MODULE_ORDER_TOTAL_FREEAMOUNT_FREE_TITLE','Versandkostenfrei (Modul Versankosten in Versandkosten)');
  define('MODULE_ORDER_TOTAL_FREEAMOUNT_FREE_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br />
  00 als ISO2-Code erm&ouml;glicht den Nachnahmeversand in alle L&auml;nder. Wenn
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn
  kein 00:9.99 eingetragen ist, wird der Nachnahmeversand ins Ausland nicht berechnet
  (nicht m&ouml;glich).');  

  define('MODULE_ORDER_TOTAL_COD_FEE_TAX_CLASS_TITLE','Steuerklasse');
  define('MODULE_ORDER_TOTAL_COD_FEE_TAX_CLASS_DESC','W&auml;hlen Sie eine Steuerklasse.');
	
	*/
?>