<?php
/* --------------------------------------------------------------
   ot_loworderfee.php 2008-08-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(ot_loworderfee.php,v 1.2 2002/04/17); www.oscommerce.com 
   (c) 2003	 nextcommerce (ot_loworderfee.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: ot_loworderfee.php 899 2005-04-29 02:40:57Z hhgag $)

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

global $gmLangFileMaster;
$gmLangFileMaster->define_lang_file_content('lang/german/modules/order_total/ot_loworderfee.php');
/*


  define('MODULE_ORDER_TOTAL_LOWORDERFEE_TITLE', 'Mindermengenzuschlag');
  define('MODULE_ORDER_TOTAL_LOWORDERFEE_DESCRIPTION', 'Zuschlag bei Unterschreitung des Mindestbestellwertes');
  
  define('MODULE_ORDER_TOTAL_LOWORDERFEE_STATUS_TITLE','Mindermengenzuschlag anzeigen');
  define('MODULE_ORDER_TOTAL_LOWORDERFEE_STATUS_DESC','M&ouml;chten Sie sich den Mindermengenzuschlag ansehen?');
  
  define('MODULE_ORDER_TOTAL_LOWORDERFEE_SORT_ORDER_TITLE','Sortierreihenfolge');
  define('MODULE_ORDER_TOTAL_LOWORDERFEE_SORT_ORDER_DESC','Anzeigereihenfolge.');
  
  define('MODULE_ORDER_TOTAL_LOWORDERFEE_LOW_ORDER_FEE_TITLE','Mindermengenzuschlag erlauben');
  define('MODULE_ORDER_TOTAL_LOWORDERFEE_LOW_ORDER_FEE_DESC','M&ouml;chten Sie Mindermengenzuschl&auml;ge erlauben?');
  
  define('MODULE_ORDER_TOTAL_LOWORDERFEE_ORDER_UNDER_TITLE','Mindermengenzuschlag f&uuml;r Bestellungen unter');
  define('MODULE_ORDER_TOTAL_LOWORDERFEE_ORDER_UNDER_DESC','Mindermengenzuschlag wird f�r Bestellungen unter diesem Wert hinzugef&uuml;gt.');
  
  define('MODULE_ORDER_TOTAL_LOWORDERFEE_FEE_TITLE','Zuschlag');
  define('MODULE_ORDER_TOTAL_LOWORDERFEE_FEE_DESC','Mindermengenzuschlag.');
  
  define('MODULE_ORDER_TOTAL_LOWORDERFEE_DESTINATION_TITLE','Mindestmengenzuschlag nach Zonen berechnen');
  define('MODULE_ORDER_TOTAL_LOWORDERFEE_DESTINATION_DESC','Mindestmengenzuschlag f&uuml;r Bestellungen, die an diesen Ort versandt werden.');
  
  define('MODULE_ORDER_TOTAL_LOWORDERFEE_TAX_CLASS_TITLE','Steuerklasse');
  define('MODULE_ORDER_TOTAL_LOWORDERFEE_TAX_CLASS_DESC','Folgende Steuerklasse f�r den Mindermengenzuschlag verwenden.');
	
*/
?>