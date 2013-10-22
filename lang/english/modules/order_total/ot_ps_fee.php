<?php
/* --------------------------------------------------------------
   ot_ps_fee.php 2008-08-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

$Id: ot_cod_fee.php,v 1.0

   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com 
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(ot_cod_fee.php,v 1.02 2003/02/24); www.oscommerce.com
   (C) 2001 - 2003 TheMedia, Dipl.-Ing Thomas Plänkers ; http://www.themedia.at & http://www.oscommerce.at

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/


  define('MODULE_ORDER_TOTAL_PS_FEE_TITLE', 'Personal Shipping');
  define('MODULE_ORDER_TOTAL_PS_FEE_DESCRIPTION', 'Calculation of the personal shipping fee');

  define('MODULE_ORDER_TOTAL_PS_FEE_STATUS_TITLE','Personal Shipping');
  define('MODULE_ORDER_TOTAL_PS_FEE_STATUS_DESC','Calculation of the personal shipping fee');

  define('MODULE_ORDER_TOTAL_COD_SORT_ORDER_TITLE','Sort Order');
  define('MODULE_ORDER_TOTAL_COD_SORT_ORDER_DESC','Display sort order');

  define('MODULE_ORDER_TOTAL_COD_FEE_FLAT_TITLE','Flat Shipping Fee');
  define('MODULE_ORDER_TOTAL_COD_FEE_FLAT_DESC','&lt;ISO2 code&gt;:&lt;Price&gt;, ....<br>
  00 as ISO2 Code allows COD shipping in all countries. If
  00 is used, you must enter it as the last argument. If
  no 00:9.99 is entered, COD shipping to foreign countries will not be calculated
  (not possible).');

  define('MODULE_ORDER_TOTAL_COD_FEE_ITEM_TITLE','Shipping Costs per Unit');
  define('MODULE_ORDER_TOTAL_COD_FEE_ITEM_DESC','&lt;ISO2 code&gt;:&lt;Price&gt;, ....<br>
  00 as ISO2 code allows COD shipping in all countries. If
  00 is used, you must enter it as the last argument. If
  no 00:9.99 is entered, COD shipping to foreign countries will not be calculated
  (not possible).');

  define('MODULE_ORDER_TOTAL_COD_FEE_TABLE_TITLE','Tabular Shipping Costs');
  define('MODULE_ORDER_TOTAL_COD_FEE_TABLE_DESC','&lt;ISO2 code&gt;:&lt;Price&gt;, ....<br>
  00 as ISO2 code allows COD shipping in all countries. If
  00 is used, you must enter it as the last argument. If
  no 00:9.99 is entered, COD shipping to foreign countries will not be calculated
  (not possible).');

  define('MODULE_ORDER_TOTAL_COD_FEE_ZONES_TITLE','Shipping Costs for Zones');
  define('MODULE_ORDER_TOTAL_COD_FEE_ZONES_DESC','&lt;ISO2 code&gt;:&lt;Price&gt;, ....<br>
  00 as ISO2 code allows COD shipping in all countries. If
  00 is used, you must enter it as the last argument. If
  no 00:9.99 is entered, COD shipping to foreign countries will not be calculated
  (not possible).');

  define('MODULE_ORDER_TOTAL_COD_FEE_AP_TITLE','Austrian Post AG');
  define('MODULE_ORDER_TOTAL_COD_FEE_AP_DESC','&lt;ISO2 code&gt;:&lt;Price&gt;, ....<br>
  00 as ISO2 code allows COD shipping in all countries. If
  00 is used, you must enter it as the last argument. If
  no 00:9.99 is entered, COD shipping to foreign countries will not be calculated
  (not possible).');

  define('MODULE_ORDER_TOTAL_COD_FEE_DP_TITLE','German Post AG');
  define('MODULE_ORDER_TOTAL_COD_FEE_DP_DESC','&lt;ISO2 code&gt;:&lt;Price&gt;, ....<br>
  00 as ISO2 code allows COD shipping in all countries. If
  00 is used, you must enter it as the last argument. If
  no 00:9.99 is entered, COD shipping to foreign countries will not be calculated
  (not possible).');
	
  define('MODULE_ORDER_TOTAL_COD_FEE_DPD_TITLE','DPD');
  define('MODULE_ORDER_TOTAL_COD_FEE_DPD_DESC','&lt;ISO2 code&gt;:&lt;Price&gt;, ....<br>
  00 as ISO2 code allows COD shipping in all countries. If
  00 is used, you must enter it as the last argument. If
  no 00:9.99 is entered, COD shipping to foreign countries will not be calculated
  (not possible).');

  define('MODULE_ORDER_TOTAL_COD_TAX_CLASS_TITLE','Tax Class');
  define('MODULE_ORDER_TOTAL_COD_TAX_CLASS_DESC','Select a tax class.');
  
      define('MODULE_ORDER_TOTAL_PS_FEE_SORT_ORDER_TITLE','Sort Order');
	define('MODULE_ORDER_TOTAL_PS_FEE_SORT_ORDER_DESC','Display sort order');

define('MODULE_ORDER_TOTAL_PS_FEE_FLAT_TITLE','Flat Shipping Costs');
	define('MODULE_ORDER_TOTAL_PS_FEE_FLAT_DESC','&lt;ISO2 code&gt;:&lt;Price&gt;, ....<br>
	  00 as ISO2 code allows COD shipping in all countries. If
  00 is used, you must enter it as the last argument. If
  no 00:9.99 is entered, COD shipping to foreign countries will not be calculated
  (not possible).');
	
	define('MODULE_ORDER_TOTAL_PS_FEE_ITEM_TITLE','Shipping Costs each');
	define('MODULE_ORDER_TOTAL_PS_FEE_ITEM_DESC','&lt;ISO2 code&gt;:&lt;Price&gt;, ....<br>
  00 as ISO2 code allows COD shipping in all countries. If
  00 is used, you must enter it as the last argument. If
  no 00:9.99 is entered, COD shipping to foreign countries will not be calculated
  (not possible).');

		define('MODULE_ORDER_TOTAL_PS_FEE_TABLE_TITLE','Tabular Shipping Costs');
	define('MODULE_ORDER_TOTAL_PS_FEE_TABLE_DESC','&lt;ISO2 code&gt;:&lt;Price&gt;, ....<br>
  00 as ISO2 code allows COD shipping in all countries. If
  00 is used, you must enter it as the last argument. If
  no 00:9.99 is entered, COD shipping to foreign countries will not be calculated
  (not possible).');

	define('MODULE_ORDER_TOTAL_PS_FEE_ZONES_TITLE','Shipping Costs for Zones');
	define('MODULE_ORDER_TOTAL_PS_FEE_ZONES_DESC','&lt;ISO2 code&gt;:&lt;Price&gt;, ....<br>
	  00 as ISO2 code allows COD shipping in all countries. If
  00 is used, you must enter it as the last argument. If
  no 00:9.99 is entered, COD shipping to foreign countries will not be calculated
  (not possible).');

	define('MODULE_ORDER_TOTAL_PS_FEE_AP_TITLE','Austrian Post AG');
	define('MODULE_ORDER_TOTAL_PS_FEE_AP_DESC','&lt;ISO2 code&gt;:&lt;Price&gt;, ....<br>
  00 as ISO2 code allows COD shipping in all countries. If
  00 is used, you must enter it as the last argument. If
  no 00:9.99 is entered, COD shipping to foreign countries will not be calculated
  (not possible).');

		define('MODULE_ORDER_TOTAL_PS_FEE_DP_TITLE','German Post AG');
	define('MODULE_ORDER_TOTAL_PS_FEE_DP_DESC','&lt;ISO2 code&gt;:&lt;Price&gt;, ....<br>
  00 as ISO2 code allows COD shipping in all countries. If
  00 is used, you must enter it as the last argument. If
  no 00:9.99 is entered, COD shipping to foreign countries will not be calculated
  (not possible).');
	
	define('MODULE_ORDER_TOTAL_PS_FEE_DPD_TITLE','DPD');
	define('MODULE_ORDER_TOTAL_PS_FEE_DPD_DESC','&lt;ISO2-Code&gt;:&lt;Price&gt;, ....<br>
  00 as ISO2 code allows COD shipping in all countries. If
  00 is used, you must enter it as the last argument. If
  no 00:9.99 is entered, COD shipping to foreign countries will not be calculated
  (not possible).');

	define('MODULE_ORDER_TOTAL_PS_FEE_TAX_CLASS_TITLE','Tax Class');
	define('MODULE_ORDER_TOTAL_PS_FEE_TAX_CLASS_DESC','Select a tax class.');


?>