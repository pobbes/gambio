<?php
/* --------------------------------------------------------------
   clickandbuy_v2.php 2010-01-22 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

$Id: clickandbuy.php,v 1.0 2005/10/05

  osCommerce payment contribution

  Copyright (c) 2005 by Julius Firl | jfirl@fotocommunity.com | fotocommuntiy.de

  Released under the GNU General Public License
*/

  define('MODULE_PAYMENT_CLICKANDBUY_V2_TEXT_TITLE', '<img src="images/clickandbuy_alt_60_outline.gif" border=0 align="left">ClickandBuy</b><br>');
  define('MODULE_PAYMENT_CLICKANDBUY_V2_TEXT_DESCRIPTION', '<br /><center>[<a href="'. xtc_href_link("nc_clickandbuy.php") .'"><strong>Konditionen und ANMELDUNG</strong></a>]</center><br />');
  define('MODULE_PAYMENT_CLICKANDBUY_V2_STATUS_TITLE', 'ClickandBuy Module verwenden');
  define('MODULE_PAYMENT_CLICKANDBUY_V2_STATUS_DESC', 'Möchten Sie Zahlungen via ClickandBuy akzeptieren?');
  define('MODULE_PAYMENT_CLICKANDBUY_V2_ID_TITLE', 'Premium-Link');
  define('MODULE_PAYMENT_CLICKANDBUY_V2_ID_DESC', 'Ihr Premiumlink zum Empfangen von ClickandBuy-Zahlungen');
  define('MODULE_PAYMENT_CLICKANDBUY_V2_REDIRECT_TITLE', 'Redirect-Dateiname');
  define('MODULE_PAYMENT_CLICKANDBUY_V2_REDIRECT_DESC', 'Der redirection-Dateiname für ClickandBuy (NICHT ÄNDERN!)');
  define('MODULE_PAYMENT_CLICKANDBUY_V2_CURRENCY_TITLE', 'Währung');
  define('MODULE_PAYMENT_CLICKANDBUY_V2_CURRENCY_DESC', 'Die Währung für ClickandBuy-Zahlungen');
  define('MODULE_PAYMENT_CLICKANDBUY_V2_SORT_ORDER_TITLE', 'Sortiernummer');
  define('MODULE_PAYMENT_CLICKANDBUY_V2_SORT_ORDER_DESC', 'Reihenfolge der Anzeige. Kleinste Ziffer wird zuerst angezeigt.');
  define('MODULE_PAYMENT_CLICKANDBUY_V2_ZONE_TITLE', 'Zahlungszone');
  define('MODULE_PAYMENT_CLICKANDBUY_V2_ZONE_DESC', 'Wenn eine Zone ausgew&auml;hlt ist, gilt die Zahlungsmethode nur f&uuml;r diese Zone.');
  define('MODULE_PAYMENT_CLICKANDBUY_V2_ORDER_STATUS_ID_TITLE', 'Bestellstatus festlegen');
  define('MODULE_PAYMENT_CLICKANDBUY_V2_ORDER_STATUS_ID_DESC', 'Bestellungen, welche mit diesem Modul gemacht werden, auf diesen Status setzen');
  define('MODULE_PAYMENT_CLICKANDBUY_V2_ALLOWED_TITLE' , 'Erlaubte Zonen');
	define('MODULE_PAYMENT_CLICKANDBUY_V2_ALLOWED_DESC' , 'Geben Sie <b>einzeln</b> die Zonen an, welche f&uuml;r dieses Modul erlaubt sein sollen. (z.B. AT,DE (wenn leer, werden alle Zonen erlaubt))');

//zmb
define('MODULE_PAYMENT_CLICKANDBUY_V2_SECONDCONFIRMATION_STATUS_TITLE', 'Second Confirmation verwenden?');
define('MODULE_PAYMENT_CLICKANDBUY_V2_SECONDCONFIRMATION_STATUS_DESC', 'Gesonderte Best&auml;tigung der Zahlung (Second Confirmation)');
define('MODULE_PAYMENT_CLICKANDBUY_V2_SELLER_ID_TITLE', 'Anbieter-ID');
define('MODULE_PAYMENT_CLICKANDBUY_V2_SELLER_ID_DESC', 'Die Anbieter-ID Ihres Händleraccounts. (ClickandBuy &gt; Einstellungen &gt; Stammdaten)');
define('MODULE_PAYMENT_CLICKANDBUY_V2_TMI_PASSWORD_TITLE', 'Transaktionsmanager-Passwort');
define('MODULE_PAYMENT_CLICKANDBUY_V2_TMI_PASSWORD_DESC', 'Ihr Passwort für das Transaktionsmanager-Interface.');

// More Info Link
define('MODULE_PAYMENT_CLICKANDBUY_V2_MORE_INFO_LINK_TITLE', 'Mehr Informationen zu ClickandBuy');

// ClickandBuy
define('CLICKANDBUY_V2_PAYMENT_ERROR_DB', 'Es ist ein Datenbankfehler aufgetreten. Bitte wählen Sie eine andere Zahlungsart.');
define('CLICKANDBUY_V2_PAYMENT_ERROR_NO_USERID', 'Fehler #3 bei der Bezahlung. Bitte versuchen Sie es erneut.');
define('CLICKANDBUY_V2_PAYMENT_ERROR_NO_TRANSACTIONID', 'Fehler #4 bei der Bezahlung. Bitte versuchen Sie es erneut.');
define('CLICKANDBUY_V2_PAYMENT_ERROR_NO_EXTERNALBDRID', 'Fehler #5 bei der Bezahlung. Bitte versuchen Sie es erneut.');
define('CLICKANDBUY_V2_PAYMENT_ERROR_NO_PRICE', 'Fehler #6 bei der Bezahlung. Bitte wählen Sie eine andere Zahlungsart.');
define('CLICKANDBUY_V2_PAYMENT_ERROR_INVALID_TRANSACTIONID', 'Fehler #7 bei der Bezahlung. Bitte wählen Sie eine andere Zahlungsart.');
define('CLICKANDBUY_V2_PAYMENT_ERROR_INVALID_IP', 'Fehler #8 bei der Bezahlung. Bitte wählen Sie eine andere Zahlungsart.');
define('CLICKANDBUY_V2_PAYMENT_ERROR_NO_XUSERID', 'Fehler #9 bei der Bezahlung. Bitte wählen Sie eine andere Zahlungsart.');
define('CLICKANDBUY_V2_PAYMENT_ERROR_NO_BASKET', 'Fehler #10 bei der Bezahlung. Bitte wählen Sie eine andere Zahlungsart.');
define('CLICKANDBUY_V2_PAYMENT_ERROR_INVALID_BASKET', 'Fehler #11 bei der Bezahlung. Bitte wählen Sie eine andere Zahlungsart.');
// /ClickandBuy
// zmb
?>