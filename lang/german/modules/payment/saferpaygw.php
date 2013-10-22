<?php
/* -----------------------------------------------------------------------------------------
   $Id: saferpaygw.php,v 1.0 2005/03/01 14:19:25 atmiral Exp $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2006 Alexander Federau
   -----------------------------------------------------------------------------------------
 
   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  define('MODULE_PAYMENT_SAFERPAYGW_TEXT_TITLE', 'Kreditkarte, Lastschrift<br />Sicheres Bezahlen mit Saferpay');
  define('MODULE_PAYMENT_SAFERPAYGW_TEXT_DESCRIPTION', '<b>Saferpay-Zahlung</b><br />'.(defined('MODULE_PAYMENT_SAFERPAYGW_STATUS') && MODULE_PAYMENT_SAFERPAYGW_STATUS=='true' && ($admin_access['saferpay'] == '1')?'(<a style="color:red" href="'.xtc_href_link('saferpay.php').'">Zu Transaktionen</a>)<br />':'').'<br /><b>Saferpay Testkonto</b><br />ACCOUNTID: 99867-94913159<br />Normale Testkarte: 9451123100000004<br />Gültig bis: 12/10, CVC 123<br /><br />Testkarte für 3D-Secure: 9451123100000111<br />Gültig bis: 12/10, CVC 123<br /><br /><b>Login für das Backoffice<br />auf www.saferpay.com:</b><br />Benutzername: e99867001<br />Passwort: XAjc3Kna<br /><hr>');
  define('SAFERPAYGW_ERROR_HEADING', 'Ein Fehler bei Verbindung zum Saferpay Gateway.');
  define('SAFERPAYGW_ERROR_MESSAGE', 'Bitte kontrollieren Sie die Daten Ihrer Kreditkarte!');
  define('TEXT_SAFERPAYGW_CONFIRMATION_ERROR', 'There has been an error confirmation your payment');
  define('TEXT_SAFERPAYGW_CAPTURING_ERROR', 'There has been an error capturing your credit card');
  define('TEXT_SAFERPAYGW_SETUP_ERROR', 'There has been an error creating request! Please check your setings!');
  
  define('MODULE_PAYMENT_SAFERPAYGW_STATUS_TITLE', 'Saferpay Modul aktivieren');
  define('MODULE_PAYMENT_SAFERPAYGW_STATUS_DESC', 'M&ouml;chten Sie Zahlungen per Saferpay akzeptieren?');
  define('MODULE_PAYMENT_SAFERPAYGW_ALLOWED_TITLE', 'Erlaubte Zonen');
  define('MODULE_PAYMENT_SAFERPAYGW_ALLOWED_DESC', 'Geben Sie <b>einzeln</b> die Zonen an, welche f&uuml;r dieses Modul erlaubt sein sollen. (z.B. AT,DE (wenn leer, werden alle Zonen erlaubt))');
  define('MODULE_PAYMENT_SAFERPAYGW_SORT_ORDER_TITLE', 'Anzeigereihenfolge');
  define('MODULE_PAYMENT_SAFERPAYGW_SORT_ORDER_DESC', 'Reihenfolge der Anzeige. Kleinste Ziffer wird zuerst angezeigt.');
  define('MODULE_PAYMENT_SAFERPAYGW_ZONE_TITLE', '<hr><br />Zahlungszone');
  define('MODULE_PAYMENT_SAFERPAYGW_ZONE_DESC', 'Wenn eine Zone ausgew&auml;hlt ist, gilt die Zahlungsmethode nur f&uuml;r diese Zone.');
  define('MODULE_PAYMENT_SAFERPAYGW_ORDER_STATUS_ID_TITLE', 'Bestellstatus festlegen');
  define('MODULE_PAYMENT_SAFERPAYGW_ORDER_STATUS_ID_DESC', 'Mit Saferpay bezahlte Bestellungen, auf diesen Status setzen');
  define('MODULE_PAYMENT_SAFERPAYGW_CURRENCY_TITLE', 'Transaktionswährung');
  define('MODULE_PAYMENT_SAFERPAYGW_CURRENCY_DESC', 'Währung für die Zahlungsanfragen');

  define('MODULE_PAYMENT_SAFERPAYGW_LOGIN_TITLE', 'Saferpay-Loginname');
  define('MODULE_PAYMENT_SAFERPAYGW_LOGIN_DESC' , 'Loginname, welches f&uuml;r Saferpay verwendet wird');
  define('MODULE_PAYMENT_SAFERPAYGW_PASSWORD_TITLE', 'Saferpay-Passwort');
  define('MODULE_PAYMENT_SAFERPAYGW_PASSWORD_DESC', 'Passwort welches f&uuml;r Saferpay verwendet wird');
  define('MODULE_PAYMENT_SAFERPAYGW_ACCOUNT_ID_TITLE' , 'Saferpay-Konto');
  define('MODULE_PAYMENT_SAFERPAYGW_ACCOUNT_ID_DESC' , 'ACCOUNTID des Saferpay Terminals');
  define('MODULE_PAYMENT_SAFERPAYGW_URLREADER_TITLE' , 'Funktion für URL-Lesen');
  define('MODULE_PAYMENT_SAFERPAYGW_URLREADER_DESC' , 'Welche Methode soll benutzt werden um URL zu lesen?');
  define('MODULE_PAYMENT_SAFERPAYGW_PAYINIT_URL_TITLE' , 'PayInit URL');
  define('MODULE_PAYMENT_SAFERPAYGW_PAYINIT_URL_DESC' , 'URL für die Initialisierung der Zahlung');
  define('MODULE_PAYMENT_SAFERPAYGW_CONFIRM_URL_TITLE' , 'PayConfirm URL');
  define('MODULE_PAYMENT_SAFERPAYGW_CONFIRM_URL_DESC' , 'URL für die Bestätigung der Zahlung');
  define('MODULE_PAYMENT_SAFERPAYGW_COMPLETE_URL_TITLE' , 'PayComplete URL');
  define('MODULE_PAYMENT_SAFERPAYGW_COMPLETE_URL_DESC' , 'URL für das Abschließen der Zahlung');

  define('MODULE_PAYMENT_SAFERPAYGW_CCCVC_TITLE' , 'CVC Eingabe');
  define('MODULE_PAYMENT_SAFERPAYGW_CCCVC_DESC' , 'Abfrage der Kartenprüfnummer');
  define('MODULE_PAYMENT_SAFERPAYGW_CCNAME_TITLE' , 'Karteninhaber');
  define('MODULE_PAYMENT_SAFERPAYGW_CCNAME_DESC' , 'Abfrage des Karteninhabernamens');

  define('MODULE_PAYMENT_SAFERPAYGW_COMPLETE_TITLE', 'Transaktion verbuchen');
  define('MODULE_PAYMENT_SAFERPAYGW_COMPLETE_DESC', 'Sofortige Verbuchung der Saferpay Transaktion');
  define('MODULE_PAYMENT_SAFERPAYGW_MENUCOLOR_TITLE', '<hr>Styling-Attribute zur farblichen Anpassung des Saferpay VT (optional)&nbsp;<a href="images/saferpaygw_styling.jpg" target=_blank><img src="images/icons/graphics/unknown.jpg" width="15" border="0" alt="Hilfe"></a><br /><br />MENUCOLOR');
  define('MODULE_PAYMENT_SAFERPAYGW_MENUCOLOR_DESC', 'Farbe inaktiver Reiter.');
  define('MODULE_PAYMENT_SAFERPAYGW_MENUFONTCOLOR_TITLE', 'MENUFONTCOLOR');
  define('MODULE_PAYMENT_SAFERPAYGW_MENUFONTCOLOR_DESC', 'Schriftfarbe des Menüs.');
  define('MODULE_PAYMENT_SAFERPAYGW_BODYFONTCOLOR_TITLE', 'BODYFONTCOLOR');
  define('MODULE_PAYMENT_SAFERPAYGW_BODYFONTCOLOR_DESC', 'Schriftfarbe des Eingabebereichs.');
  define('MODULE_PAYMENT_SAFERPAYGW_BODYCOLOR_TITLE', 'BODYCOLOR');
  define('MODULE_PAYMENT_SAFERPAYGW_BODYCOLOR_DESC', 'Hintergrundfarbe des Saferpay VT.');
  define('MODULE_PAYMENT_SAFERPAYGW_HEADFONTCOLOR_TITLE', 'HEADFONTCOLOR');
  define('MODULE_PAYMENT_SAFERPAYGW_HEADFONTCOLOR_DESC', 'Schriftfarbe der Reiter.');
  define('MODULE_PAYMENT_SAFERPAYGW_HEADCOLOR_TITLE', 'HEADCOLOR');
  define('MODULE_PAYMENT_SAFERPAYGW_HEADCOLOR_DESC', 'Hintergrundfarbe des oberen Bereichs.');
  define('MODULE_PAYMENT_SAFERPAYGW_HEADLINECOLOR_TITLE', 'HEADLINECOLOR');
  define('MODULE_PAYMENT_SAFERPAYGW_HEADLINECOLOR_DESC', 'Farbe der Trennlinie oben links.');
  define('MODULE_PAYMENT_SAFERPAYGW_LINKCOLOR_TITLE', 'LINKCOLOR');
  define('MODULE_PAYMENT_SAFERPAYGW_LINKCOLOR_DESC', 'Schriftfarbe der Links.');
?>
