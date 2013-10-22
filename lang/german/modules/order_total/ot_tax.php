<?php
/* --------------------------------------------------------------
   ot_tax.php 2008-08-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(ot_tax.php,v 1.2 2002/04/17); www.oscommerce.com 
   (c) 2003	 nextcommerce (ot_tax.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: ot_tax.php 899 2005-04-29 02:40:57Z hhgag $)

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

global $gmLangFileMaster;
$gmLangFileMaster->define_lang_file_content('lang/german/modules/order_total/ot_tax.php');



  define('MODULE_ORDER_TOTAL_TAX_TITLE', 'MwSt.');
  define('MODULE_ORDER_TOTAL_TAX_DESCRIPTION', 'Mehrwertsteuer');
  
  define('MODULE_ORDER_TOTAL_TAX_STATUS_TITLE','Mehrwertsteuer');
  define('MODULE_ORDER_TOTAL_TAX_STATUS_DESC','Anzeige der Mehrwertsteuer?');
  
  define('MODULE_ORDER_TOTAL_TAX_SORT_ORDER_TITLE','Sortierreihenfolge');
  define('MODULE_ORDER_TOTAL_TAX_SORT_ORDER_DESC','Anzeigereihenfolge.');
	
	
?>