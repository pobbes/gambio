<?php

/* -----------------------------------------------------------------------------------------
   $Id: skrill_netpay.php 40 2009-01-22 15:54:43Z mzanier $

   xt:Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2007 xt:Commerce

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

define('MODULE_PAYMENT_SKRILL_NETPAY_TEXT_TITLE', 'Netpay');
$_var = 'Netpay &uuml;ber Skrill';
if (_PAYMENT_SKRILL_EMAILID=='') {
	$_var.='<br /><br /><b><font color="red">Bitte nehmen Sie zuerst die Einstellungen unter<br /> Konfiguration -> Schnittstellen -> Skrill.com vor!</font></b>';
}
$_var .= '<br><br>Bitte nehmen Sie die Konfiguration der Skrill-Module unter <a href="'.DIR_WS_ADMIN.'configuration.php?gID=32">Konfiguration -> Schnittstellen -> Skrill.com</a> vor.';
define('MODULE_PAYMENT_SKRILL_NETPAY_TEXT_DESCRIPTION', $_var);
define('MODULE_PAYMENT_SKRILL_NETPAY_NOCURRENCY_ERROR', 'Es ist keine von Skrill akzeptierte W&auml;hrung installiert!');
define('MODULE_PAYMENT_SKRILL_NETPAY_ERRORTEXT1', 'payment_error=');
define('MODULE_PAYMENT_SKRILL_NETPAY_TEXT_INFO', '');
define('MODULE_PAYMENT_SKRILL_NETPAY_ERRORTEXT2', '&error=Fehler w&auml;hrend Ihrer Bezahlung bei Skrill!');
define('MODULE_PAYMENT_SKRILL_NETPAY_ORDER_TEXT', 'Bestelldatum: ');
define('MODULE_PAYMENT_SKRILL_NETPAY_TEXT_ERROR', 'Fehler bei Zahlung!');
define('MODULE_PAYMENT_SKRILL_NETPAY_CONFIRMATION_TEXT', 'Danke f&uuml;r Ihre Bestellung!');
define('MODULE_PAYMENT_SKRILL_NETPAY_TRANSACTION_FAILED_TEXT', 'Ihre Zahlungstransaktion bei skrill.com ist fehlgeschlagen. Bitte versuchen Sie es nochmal, oder w&auml;hlen Sie eine andere Zahlungsm&ouml;glichkeit!');



define('MODULE_PAYMENT_SKRILL_NETPAY_STATUS_TITLE', 'Skrill aktivieren');
define('MODULE_PAYMENT_SKRILL_NETPAY_STATUS_DESC', 'M&ouml;chten Sie Zahlungen per Skrill akzeptieren?');
define('MODULE_PAYMENT_SKRILL_NETPAY_SORT_ORDER_TITLE', 'Anzeigereihenfolge');
define('MODULE_PAYMENT_SKRILL_NETPAY_SORT_ORDER_DESC', 'Reihenfolge der Anzeige. Kleinste Ziffer wird zuerst angezeigt.');
define('MODULE_PAYMENT_SKRILL_NETPAY_ZONE_TITLE', 'Zahlungszone');
define('MODULE_PAYMENT_SKRILL_NETPAY_ZONE_DESC', 'Wenn eine Zone ausgew&auml;hlt ist, gilt die Zahlungsmethode nur f&uuml;r diese Zone.');
define('MODULE_PAYMENT_SKRILL_NETPAY_ALLOWED_TITLE', 'Erlaubte Zonen');
define('MODULE_PAYMENT_SKRILL_NETPAY_ALLOWED_DESC', 'Geben Sie <b>einzeln</b> die Zonen an, welche f&uuml;r dieses Modul erlaubt sein sollen. (z.B. AT,DE (wenn leer, werden alle Zonen erlaubt))');
?>
