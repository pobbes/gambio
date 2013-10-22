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
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: ot_cod_fee.php 914 2005-04-30 02:54:02Z matthias $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

  define('MODULE_ORDER_TOTAL_COD_FEE_FEDEXEU_TITLE','FedEx Express Europa');
  define('MODULE_ORDER_TOTAL_COD_FEE_FEDEXEU_DESC','&lt;ISO2 code&gt;:&lt;Price&gt;, ....<br />
   00 as ISO2 code allows COD shipping in all countries. If
  00 is used, you must enter it as the last argument. If
  no 00:9.99 is entered, COD shipping to foreign countries will not be calculated
  (not possible).');

  define('MODULE_ORDER_TOTAL_COD_FEE_GAMBIOULTRA_TITLE','Fixed Shipping Costs per Product');
  define('MODULE_ORDER_TOTAL_COD_FEE_GAMBIOULTRA_DESC','&lt;ISO2 code&gt;:&lt;Price&gt;, ....<br />
    00 as ISO2 code allows COD shipping in all countries. If
  00 is used, you must enter it as the last argument. If
  no 00:9.99 is entered, COD shipping to foreign countries will not be calculated
  (not possible).');

  define('MODULE_ORDER_TOTAL_COD_FEE_SELFPICKUP_TITLE','Self Pickup');
  define('MODULE_ORDER_TOTAL_COD_FEE_SELFPICKUP_DESC','&lt;ISO2 code&gt;:&lt;Price&gt;, ....<br />
   00 as ISO2 code allows COD shipping in all countries. If
  00 is used, you must enter it as the last argument. If
  no 00:9.99 is entered, COD shipping to foreign countries will not be calculated
  (not possible).');

  define('MODULE_ORDER_TOTAL_COD_FEE_ZONESE_TITLE','Registered Mail');
  define('MODULE_ORDER_TOTAL_COD_FEE_ZONESE_DESC','&lt;ISO2 code&gt;:&lt;Price&gt;, ....<br />
  00 as ISO2 code allows COD shipping in all countries. If
  00 is used, you must enter it as the last argument. If
  no 00:9.99 is entered, COD shipping to foreign countries will not be calculated
  (not possible).');

  
  define('MODULE_ORDER_TOTAL_COD_FEE_TITLE', 'COD Fee');
  define('MODULE_ORDER_TOTAL_COD_FEE_DESCRIPTION', 'Calculation of the COD fee');

  define('MODULE_ORDER_TOTAL_COD_FEE_STATUS_TITLE','COD Fee');
  define('MODULE_ORDER_TOTAL_COD_FEE_STATUS_DESC','Calculation of the COD fee');

  define('MODULE_ORDER_TOTAL_COD_FEE_SORT_ORDER_TITLE','Sort Order');
  define('MODULE_ORDER_TOTAL_COD_FEE_SORT_ORDER_DESC','Display sort order');

  define('MODULE_ORDER_TOTAL_COD_FEE_FLAT_TITLE','Flat Shipping Costs');
  define('MODULE_ORDER_TOTAL_COD_FEE_FLAT_DESC','&lt;ISO2 code&gt;:&lt;Price&gt;, ....<br />
 00 as ISO2 code allows COD shipping in all countries. If
  00 is used, you must enter it as the last argument. If
  no 00:9.99 is entered, COD shipping to foreign countries will not be calculated
  (not possible).');

  define('MODULE_ORDER_TOTAL_COD_FEE_ITEM_TITLE','Shipping Cost per Unit');
  define('MODULE_ORDER_TOTAL_COD_FEE_ITEM_DESC','&lt;ISO2 code&gt;:&lt;Price&gt;, ....<br />
 00 as ISO2 code allows COD shipping in all countries. If
  00 is used, you must enter it as the last argument. If
  no 00:9.99 is entered, COD shipping to foreign countries will not be calculated
  (not possible).');

  define('MODULE_ORDER_TOTAL_COD_FEE_TABLE_TITLE','Tabular Shipping Costs');
  define('MODULE_ORDER_TOTAL_COD_FEE_TABLE_DESC','&lt;ISO2 code&gt;:&lt;Price&gt;, ....<br />
  00 as ISO2 code allows COD shipping in all countries. If
  00 is used, you must enter it as the last argument. If
  no 00:9.99 is entered, COD shipping to foreign countries will not be calculated
  (not possible).');

  define('MODULE_ORDER_TOTAL_COD_FEE_ZONES_TITLE','Shipping Costs for Zones');
  define('MODULE_ORDER_TOTAL_COD_FEE_ZONES_DESC','&lt;ISO2 code&gt;:&lt;Price&gt;, ....<br />
  00 as ISO2 code allows COD shipping in all countries. If
  00 is used you have to enter it as last argument. If
  no 00:9.99 is entered, COD shipping to foreign countries will not be calculated
  (not possible).');

  define('MODULE_ORDER_TOTAL_COD_FEE_AP_TITLE','Austrian Post AG');
  define('MODULE_ORDER_TOTAL_COD_FEE_AP_DESC','&lt;ISO2 code&gt;:&lt;Price&gt;, ....<br />
  00 as ISO2 code allows COD shipping in all countries. If
  00 is used, you must enter it as the last argument. If
  no 00:9.99 is entered, COD shipping to foreign countries will not be calculated
  (not possible).');

  define('MODULE_ORDER_TOTAL_COD_FEE_CHP_TITLE','Swiss Post');
  define('MODULE_ORDER_TOTAL_COD_FEE_CHP_DESC','&lt;ISO2 code&gt;:&lt;Price&gt;, ....<br />
 00 as ISO2 code allows COD shipping in all countries. If
  00 is used, you must enter it as the last argument. If
  no 00:9.99 is entered, COD shipping to foreign countries will not be calculated
  (not possible).');

  define('MODULE_ORDER_TOTAL_COD_FEE_CHRONOPOST_TITLE','Chronopost');
  define('MODULE_ORDER_TOTAL_COD_FEE_CHRONOPOST_DESC','&lt;ISO2 code&gt;:&lt;Price&gt;, ....<br />
 00 as ISO2 code allows COD shipping in all countries. If
  00 is used, you must enter it as the last argument. If
  no 00:9.99 is entered, COD shipping to foreign countries will not be calculated
  (not possible).');

  define('MODULE_ORDER_TOTAL_COD_FEE_DHL_TITLE','DHL Austria');
  define('MODULE_ORDER_TOTAL_COD_FEE_DHL_DESC','&lt;ISO2 code&gt;:&lt;Price&gt;, ....<br />
  00 as ISO2 code allows COD shipping in all countries. If
  00 is used, you must enter it as the last argument. If
  no 00:9.99 is entered, COD shipping to foreign countries will not be calculated
  (not possible).');

  define('MODULE_ORDER_TOTAL_COD_FEE_DP_TITLE','German Post AG');
  define('MODULE_ORDER_TOTAL_COD_FEE_DP_DESC','&lt;ISO2 code&gt;:&lt;Price&gt;, ....<br />
 00 as ISO2 code allows COD shipping in all countries. If
  00 is used, you must enter it as the last argument. If
  no 00:9.99 is entered, COD shipping to foreign countries will not be calculated
  (not possible).');

  define('MODULE_ORDER_TOTAL_COD_FEE_FREE_TITLE','Free Shipping (Order Total Module Shipping)');
  define('MODULE_ORDER_TOTAL_COD_FEE_FREE_DESC','&lt;ISO2 code&gt;:&lt;Price&gt;, ....<br />
  00 as ISO2 code allows COD shipping in all countries. If
  00 is used, you must enter it as the last argument. If
  no 00:9.99 is entered, COD shipping to foreign countries will not be calculated
  (not possible).');

  define('MODULE_ORDER_TOTAL_COD_FEE_DPD_TITLE','DPD');
  define('MODULE_ORDER_TOTAL_COD_FEE_DPD_DESC','&lt;ISO2 code&gt;:&lt;Price&gt;, ....<br />
 00 as ISO2 code allows COD shipping in all countries. If
  00 is used, you must enter it as the last argument. If
  no 00:9.99 is entered, COD shipping to foreign countries will not be calculated
  (not possible).');
  
  define('MODULE_ORDER_TOTAL_FREEAMOUNT_FREE_TITLE','Free Shipping (Module Free Shipping)');
  define('MODULE_ORDER_TOTAL_FREEAMOUNT_FREE_DESC','&lt;ISO2 code&gt;:&lt;Price&gt;, ....<br />
  00 as ISO2 code allows COD shipping in all countries. If
  00 is used, you must enter it as the last argument. If
  no 00:9.99 is entered, COD shipping to foreign countries will not be calculated
  (not possible).');

  define('MODULE_ORDER_TOTAL_COD_FEE_TAX_CLASS_TITLE','Tax Class');
  define('MODULE_ORDER_TOTAL_COD_FEE_TAX_CLASS_DESC','Select a tax class.');
  
   define('MODULE_ORDER_TOTAL_COD_FEE_UPS_TITLE','UPS');
  define('MODULE_ORDER_TOTAL_COD_FEE_UPS_DESC','&lt;ISO2-Code&gt;:&lt;Price&gt;, ....<br />
  00 as ISO2 code allows COD shipping in all countries. If
  00 is used, you must enter it as the last argument. If
  no 00:9.99 is entered, COD shipping to foreign countries will not be calculated
  (not possible).');  

  define('MODULE_ORDER_TOTAL_COD_FEE_UPSE_TITLE','UPS Express');
  define('MODULE_ORDER_TOTAL_COD_FEE_UPSE_DESC','&lt;ISO2-Code&gt;:&lt;Price&gt;, ....<br />
  00 as ISO2 code allows COD shipping in all countries. If
  00 is used, you must enter it as the last argument. If
  no 00:9.99 is entered, COD shipping to foreign countries will not be calculated
  (not possible).'); 
?>