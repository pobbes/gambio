<?php
/* --------------------------------------------------------------
   ot_payment.php 2008-08-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

$Id: ot_payment.php,v 1.2.2 2005/10/21 09:58:57 Anotherone Exp $

  André Estel / Estelco http://www.estelco.de

  Copyright (C) 2005 Estelco

  based on:
  Andreas Zimmermann / IT eSolutions http://www.it-esolutions.de

  Copyright (C) 2004 IT eSolutions
  -----------------------------------------------------------------------------------------

  (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com 

  Released under the GNU General Public License

  ---------------------------------------------------------------------------------------*/
global $gmLangFileMaster;
$gmLangFileMaster->define_lang_file_content('lang/german/modules/order_total/ot_payment.php');
/*


  define('MODULE_ORDER_TOTAL_PAYMENT_TITLE', 'Vorkasse Rabatt');
  define('MODULE_ORDER_TOTAL_PAYMENT_DESCRIPTION', 'Rabatt für Zahlungsarten');
  define('MODULE_ORDER_TOTAL_PAYMENT_SHIPPING_NOT_INCLUDED', ' [Ohne Versandkosten]');
  define('MODULE_ORDER_TOTAL_PAYMENT_TAX_NOT_INCLUDED', ' [Ohne Ust]');

  define('MODULE_ORDER_TOTAL_PAYMENT_STATUS_TITLE', 'Rabatt anzeigen');
  define('MODULE_ORDER_TOTAL_PAYMENT_STATUS_DESC', 'Wollen Sie den Zahlungsartrabatt einschalten?');

  define('MODULE_ORDER_TOTAL_PAYMENT_SORT_ORDER_TITLE', 'Sortierreihenfolge');
  define('MODULE_ORDER_TOTAL_PAYMENT_SORT_ORDER_DESC', 'Anzeigereihenfolge');

  define('MODULE_ORDER_TOTAL_PAYMENT_PERCENTAGE_TITLE', 'Erste Rabattstaffel');
  define('MODULE_ORDER_TOTAL_PAYMENT_PERCENTAGE_DESC', 'Rabattierung (Mindestwert:Prozent)');

  define('MODULE_ORDER_TOTAL_PAYMENT_PERCENTAGE2_TITLE', 'Zweite Rabattstaffel');
  define('MODULE_ORDER_TOTAL_PAYMENT_PERCENTAGE2_DESC', 'Rabattierung (Mindestwert:Prozent)');

  define('MODULE_ORDER_TOTAL_PAYMENT_TYPE_TITLE', 'Erste Zahlungsart');
  define('MODULE_ORDER_TOTAL_PAYMENT_TYPE_DESC', 'Zahlungsarten, auf die Rabatt gegeben werden soll');

  define('MODULE_ORDER_TOTAL_PAYMENT_TYPE2_TITLE', 'Zweite Zahlungsart');
  define('MODULE_ORDER_TOTAL_PAYMENT_TYPE2_DESC', 'Zahlungsarten, auf die Rabatt gegeben werden soll');

  define('MODULE_ORDER_TOTAL_PAYMENT_INC_SHIPPING_TITLE', 'Inklusive Versandkosten');
  define('MODULE_ORDER_TOTAL_PAYMENT_INC_SHIPPING_DESC', 'Versandkosten werden mit Rabattiert');

  define('MODULE_ORDER_TOTAL_PAYMENT_INC_TAX_TITLE', 'Inklusive Ust');
  define('MODULE_ORDER_TOTAL_PAYMENT_INC_TAX_DESC', 'Ust wird mit Rabattiert');

  define('MODULE_ORDER_TOTAL_PAYMENT_CALC_TAX_TITLE', 'Ust Berechnung');
  define('MODULE_ORDER_TOTAL_PAYMENT_CALC_TAX_DESC', 'erneutes berechnen der Ust Summe');

  define('MODULE_ORDER_TOTAL_PAYMENT_ALLOWED_TITLE', 'Erlaubte Zonen');
  define('MODULE_ORDER_TOTAL_PAYMENT_ALLOWED_DESC' , 'Geben Sie <b>einzeln</b> die Zonen an, welche f&uuml;r dieses Modul erlaubt sein sollen. (z.B. AT,DE (wenn leer, werden alle Zonen erlaubt))');

  define('MODULE_ORDER_TOTAL_PAYMENT_AMOUNT1', 'Vorkasse Rabatt');
  define('MODULE_ORDER_TOTAL_PAYMENT_AMOUNT2', 'Nachnahme Rabatt');

  define('MODULE_ORDER_TOTAL_PAYMENT_TAX_CLASS_TITLE','Steuerklasse');
  define('MODULE_ORDER_TOTAL_PAYMENT_TAX_CLASS_DESC','Folgende Steuerklasse für den Mindermengenzuschlag verwenden.');
	
*/
?>