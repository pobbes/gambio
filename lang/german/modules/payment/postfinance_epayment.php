<?php
/* -----------------------------------------------------------------------------------------
   $Id: postfinance_epayment.php,v1.2 2012/02/14 swisswebXperts N�f

   Changelog:
   v1.2
   - Images constants
   
   v1.1
   - Links to postfinance and swisswebxperts

	 Copyright (c) 2009 swisswebXperts N�f www.swisswebxperts.ch
	 Released under the GNU General Public License (Version 2)
	 [http://www.gnu.org/licenses/gpl-2.0.html]
   ---------------------------------------------------------------------------------------*/

define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_TEXT_TITLE', 'Postfinance e-payment');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_TEXT_DESCRIPTION', 'Postfinance e-payment <br />Information: <a href="http://www.postfinance.ch/pf/content/de/seg/biz/product/eserv/epay/seller/offer.html" target="_blank">www.postfinance.ch</a><br />Support: <a href="http://www.swisswebxperts.ch/postfinance.php" target="_blank">www.swisswebXperts.ch</a>');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_TEXT_INFO', '');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_TEXT_ERROR', 'Postfinance e-payment - Transaktionsfehler');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_ERROR', 'Die Zahlung wurde von der Postfinance abgelehnt!');	
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_LANGUAGE_TITLE', 'Benutzermaskensprache');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_LANGUAGE_DESC', 'Sprache in der die Postfinance Benutzeroberfl�che angezeigt wird');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_PSPID_TITLE', 'PSPID');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_PSPID_DESC', 'Ihr Teilnehmername bei Postfinance');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_ALLOWED_TITLE' , 'Erlaubte Zonen');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_ALLOWED_DESC' , 'Geben Sie <b>einzeln</b> die Zonen an, welche f&uuml;r dieses Modul erlaubt sein sollen. (z.B. CH,AT,DE (wenn leer, werden alle Zonen erlaubt))');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_STATUS_TITLE' , 'Postfinance Modul aktivieren');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_STATUS_DESC' , 'M&ouml;chten Sie Zahlungen per Postfinance akzeptieren?');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_ID_TITLE' , 'eMail Adresse');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_ID_DESC' , 'eMail Adresse, welche f&uuml;r Postfinance verwendet wird');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_PROD_TITLE', 'Test- oder Produktivlink verwenden');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_PROD_DESC', 'W�hlen True, wenn Ihr Shop Produktiv ist ansonsten False');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_IMAGES_TITLE', 'Icons der Zahlungsvarianten anzeigen');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_IMAGES_DESC', '(z.B. postcard,visa,master,amex,diners)');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_CURRENCY_TITLE' , 'W&auml;hrung');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_CURRENCY_DESC' , 'W&auml;hrung, welche f&uuml;r Kreditkartentransaktionen verwendet wird');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_SORT_ORDER_TITLE' , 'Anzeigereihenfolge');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_SORT_ORDER_DESC' , 'Reihenfolge der Anzeige. Kleinste Ziffer wird zuerst angezeigt');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_ZONE_TITLE' , 'Zahlungszone');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_ZONE_DESC' , 'Wenn eine Zone ausgew&auml;hlt ist, gilt die Zahlungsmethode nur f&uuml;r diese Zone.');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_ORDER_STATUS_ID_TITLE' , 'Bestellstatus festlegen');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_ORDER_STATUS_ID_DESC' , 'Bestellungen, welche mit diesem Modul gemacht werden, auf diesen Status setzen');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_SHA1_SIGNATURE_TITLE', 'SHA-1 Signature');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_SHA1_SIGNATURE_DESC', 'Ihre SHA-1 Signature f�r die Daten�berpr�fung');
	
?>