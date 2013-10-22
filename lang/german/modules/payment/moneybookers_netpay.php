<?php

/* -----------------------------------------------------------------------------------------
   $Id: moneybookers_netpay.php 40 2009-01-22 15:54:43Z mzanier $

   xt:Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2007 xt:Commerce

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

define('MODULE_PAYMENT_MONEYBOOKERS_NETPAY_TEXT_TITLE', 'Netpay');
$_var = 'Netpay &uuml;ber Moneybookers';
if (_PAYMENT_MONEYBOOKERS_EMAILID=='') {
	$_var.='<br /><br /><b><font color="red">Bitte nehmen Sie zuerst die Einstellungen unter<br /> Konfiguration -> Schnittstellen -> Moneybookers.com vor!</font></b>';
}
define('MODULE_PAYMENT_MONEYBOOKERS_NETPAY_TEXT_DESCRIPTION', $_var);
define('MODULE_PAYMENT_MONEYBOOKERS_NETPAY_NOCURRENCY_ERROR', 'Es ist keine von Moneybookers akzeptierte W&auml;hrung installiert!');
define('MODULE_PAYMENT_MONEYBOOKERS_NETPAY_ERRORTEXT1', 'payment_error=');
define('MODULE_PAYMENT_MONEYBOOKERS_NETPAY_TEXT_INFO', '');
define('MODULE_PAYMENT_MONEYBOOKERS_NETPAY_ERRORTEXT2', '&error=Fehler w&auml;hrend Ihrer Bezahlung bei Moneybookers!');
define('MODULE_PAYMENT_MONEYBOOKERS_NETPAY_ORDER_TEXT', 'Bestelldatum: ');
define('MODULE_PAYMENT_MONEYBOOKERS_NETPAY_TEXT_ERROR', 'Fehler bei Zahlung!');
define('MODULE_PAYMENT_MONEYBOOKERS_NETPAY_CONFIRMATION_TEXT', 'Danke f&uuml;r Ihre Bestellung!');
define('MODULE_PAYMENT_MONEYBOOKERS_NETPAY_TRANSACTION_FAILED_TEXT', 'Ihre Zahlungstransaktion bei moneybookers.com ist fehlgeschlagen. Bitte versuchen Sie es nochmal, oder w&auml;hlen Sie eine andere Zahlungsm&ouml;glichkeit!');



define('MODULE_PAYMENT_MONEYBOOKERS_NETPAY_STATUS_TITLE', 'Moneybookers aktivieren');
define('MODULE_PAYMENT_MONEYBOOKERS_NETPAY_STATUS_DESC', 'M&ouml;chten Sie Zahlungen per Moneybookers akzeptieren?');
define('MODULE_PAYMENT_MONEYBOOKERS_NETPAY_SORT_ORDER_TITLE', 'Anzeigereihenfolge');
define('MODULE_PAYMENT_MONEYBOOKERS_NETPAY_SORT_ORDER_DESC', 'Reihenfolge der Anzeige. Kleinste Ziffer wird zuerst angezeigt.');
define('MODULE_PAYMENT_MONEYBOOKERS_NETPAY_ZONE_TITLE', 'Zahlungszone');
define('MODULE_PAYMENT_MONEYBOOKERS_NETPAY_ZONE_DESC', 'Wenn eine Zone ausgew&auml;hlt ist, gilt die Zahlungsmethode nur f&uuml;r diese Zone.');
define('MODULE_PAYMENT_MONEYBOOKERS_NETPAY_ALLOWED_TITLE', 'Erlaubte Zonen');
define('MODULE_PAYMENT_MONEYBOOKERS_NETPAY_ALLOWED_DESC', 'Geben Sie <b>einzeln</b> die Zonen an, welche f&uuml;r dieses Modul erlaubt sein sollen. (z.B. AT,DE (wenn leer, werden alle Zonen erlaubt))');
?>