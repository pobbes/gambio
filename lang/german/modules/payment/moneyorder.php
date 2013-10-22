<?php
/* --------------------------------------------------------------
   moneyorder.php 2008-08-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(moneyorder.php,v 1.8 2003/02/16); www.oscommerce.com 
   (c) 2003	 nextcommerce (moneyorder.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: moneyorder.php 998 2005-07-07 14:18:20Z mz $)

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
global $gmLangFileMaster;
$gmLangFileMaster->define_lang_file_content('lang/german/modules/payment/moneyorder.php');

/*
  define('MODULE_PAYMENT_MONEYORDER_TEXT_TITLE', 'Vorkasse/�berweisung');
  define('MODULE_PAYMENT_MONEYORDER_TEXT_DESCRIPTION', 'Zahlbar an:&nbsp;' . MODULE_PAYMENT_MONEYORDER_PAYTO . '<br />Adressat:<br /><br />' . nl2br(STORE_NAME_ADDRESS) . '<br /><br />' . 'Umgehend nach Geldeingang, wird die Ware, an die von Ihnen gew�nschte Adresse versandt.');
  define('MODULE_PAYMENT_MONEYORDER_TEXT_EMAIL_FOOTER', "Zahlbar an: ". MODULE_PAYMENT_MONEYORDER_PAYTO . "\n\nAdressat:\n" . STORE_NAME_ADDRESS . "\n\n" . 'Umgehend nach Geldeingang, wird die Ware, an die von Ihnen gew�nschte Adresse versandt.');
  define('MODULE_PAYMENT_MONEYORDER_TEXT_INFO','Zahlung im Voraus');
  define('MODULE_PAYMENT_MONEYORDER_STATUS_TITLE' , 'Vorkasse/�berweisung Modul aktivieren');
define('MODULE_PAYMENT_MONEYORDER_STATUS_DESC' , 'M&ouml;chten Sie Zahlungen per Vorkasse/�berweisung akzeptieren?');
define('MODULE_PAYMENT_MONEYORDER_ALLOWED_TITLE' , 'Erlaubte Zonen');
define('MODULE_PAYMENT_MONEYORDER_ALLOWED_DESC' , 'Geben Sie <b>einzeln</b> die Zonen an, welche f&uuml;r dieses Modul erlaubt sein sollen. (z.B. AT,DE (wenn leer, werden alle Zonen erlaubt))');
define('MODULE_PAYMENT_MONEYORDER_PAYTO_TITLE' , 'Zahlbar an:');
define('MODULE_PAYMENT_MONEYORDER_PAYTO_DESC' , 'An wen sollen Zahlungen erfolgen?');
define('MODULE_PAYMENT_MONEYORDER_SORT_ORDER_TITLE' , 'Anzeigereihenfolge');
define('MODULE_PAYMENT_MONEYORDER_SORT_ORDER_DESC' , 'Reihenfolge der Anzeige. Kleinste Ziffer wird zuerst angezeigt.');
define('MODULE_PAYMENT_MONEYORDER_ZONE_TITLE' , 'Zahlungszone');
define('MODULE_PAYMENT_MONEYORDER_ZONE_DESC' , 'Wenn eine Zone ausgew&auml;hlt ist, gilt die Zahlungsmethode nur f&uuml;r diese Zone.');
define('MODULE_PAYMENT_MONEYORDER_ORDER_STATUS_ID_TITLE' , 'Bestellstatus festlegen');
define('MODULE_PAYMENT_MONEYORDER_ORDER_STATUS_ID_DESC' , 'Bestellungen, welche mit diesem Modul gemacht werden, auf diesen Status setzen');

*/
?>