<?php
/* --------------------------------------------------------------
   gm_german.php 2012-04-18 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/
?><?php

// Template Advice
define('TEMPLATE_ADVICE', 'Diese Einstellung/Funktion wird vom EyeCandy-Template nicht mehr unterst&uuml;tzt.');

// Settings
define('GM_SETTINGS_OFFLINE', 'Shop offline <br /><font color="red">(Zugriff nur noch mit Admin-Daten über die URL <a href="'. HTTP_SERVER.DIR_WS_CATALOG.'login_admin.php" target="_blank"><font color="red">'. HTTP_SERVER.DIR_WS_CATALOG.'login_admin.php</font></a>)</font>');
define('GM_SETTINGS_OFFLINE_PWD', 'Benutzername: <strong>gambio</strong>, Passwort');
define('GM_SETTINGS_OFFLINE_MSG', 'Offline Nachricht');
define('GM_SETTINGS_PAYPAL_ERROR_FIREWALL', 'Es scheint eine serverseitige Firewall die Anfrage oder Antwort des PayPal-Servers zu blocken. Wenden Sie sich daher an Ihren Provider mit der Bitte sicherzustellen, dass über cURL zu folgenden Adressen eine Verbindung aufgebaut werden darf:<br /><br />https://api-3t.sandbox.paypal.com<br />https://www.sandbox.paypal.com<br />https://api.paypal.com<br />https://api-aa.paypal.com<br />https://api-3t.paypal.com<br />https://api-aa-3t.paypal.com<br />https://notify.paypal.com<br />https://reports.paypal.com<br />https://www.paypal.com<br />https://paypal.com<br />https://svcs.paypal.com<br />https://paypalobjects.com');
define('GM_SETTINGS_PAYPAL_ERROR_API', 'Sie haben falsche, oder keine PayPal API Daten eingegeben. Bitte kontrollieren Sie Ihre Angaben unter "Konfiguration -> Schnittstellen -> PayPal" bevor das Modul genutzt werden kann.');
define('GM_SETTINGS_PAYPAL_ERROR_CURL', 'Auf Ihrem Server ist kein cURL installiert. Ohne diese Erweiterung ist das PayPal Modul nicht nutzbar.');
define('GM_SETTINGS_PAYPAL_ERROR_OPENSSL', 'Ihr Webserver unterstützt kein openSSL. Ohne diese Erweiterung ist das PayPal Modul nicht nutzbar.');
define('GM_SETTINGS_PAYPAL_ERROR_STATE', 'Sie liefern in ein Land, bei dem PayPal das Bundesland als Pflichtangabe voraussetzt!<br />Bitte stellen Sie unter "Konfiguration -> Kunden-Details" das Bundesland auf "Ja".<br />Geben Sie unter "Konfiguration -> Minimum Werte" für das Bundesland eine Zahl gr&ouml;&szlig;er als 0 ein,  z.B. "2".');

// BOF GM_MOD
// PayPal order status
define('STATUS_ERRORCODE_10011', 'Die PayPal Zahlung wurde nicht abgeschlossen.<br />M&ouml;glicherweise hat der Kunde die Zahlung abgebrochen.<br />Hinweis: Bitte setzen Sie sich mit dem Kunden in Verbindung.');
define('STATUS_ERRORCODE_10002', 'Diese Transaktion konnte von PayPal nicht bearbeitet werden, da Sie falsche, oder keine PayPal API Daten eingegeben haben.<br />Hinweis: Bitte setzen Sie sich mit dem Kunden in Verbindung.');
define('STATUS_ERRORCODE_10004', 'Der PayPal-Zahlungsstatus konnte nicht ermittelt werden, da ein Parameter fehlerhat ist.');
define('STATUS_ERRORCODE_10412', 'Eine andere Zahlung mit diese Bestellnummer wurde bereits durchgef&uuml;hrt, weshalb PayPal die Zahlung abgelehnt hat.<br /><br /><br />Hinweise:<br /><br />Bitte korrigieren Sie Ihren Nummernkreis unter "Konfiguration->Nummernkreise->N&auml;chste Bestellnummer", da PayPal die Zahlungen anhand der Bestellnummer identifiziert.<br /><br />Bitte setzen Sie sich mit dem Kunden in Verbindung.');
define('STATUS_ERRORCODE_10422', 'Die Zahlung wurde nicht durchgef&uuml;hrt. Der K&auml;ufer muss zur PayPal-Website zur&uuml;ckkehren, eine andere Zahlungsmethode ausw&auml;hlen und eine neue Bestellung ausf&uuml;hren.<br /><br />Hinweis:<br />Bitte setzen Sie sich mit dem Kunden in Verbindung.');
define('STATUS_ERRORCODE_10445', 'Diese Transaktion konnte von PayPal zur Zeit nicht bearbeitet werden.<br /><br />Hinweis:<br />Bitte setzen Sie sich mit dem Kunden in Verbindung.');
define('STATUS_ERRORCODE_10729', 'Die PayPal Zahlung wurde nicht abgeschlossen. Der Bundesstaat in der Lieferadresse fehlte.<br />Hinweis: Bitte setzen Sie sich mit dem Kunden in Verbindung.');
define('STATUS_ERRORCODE_10736', 'Lieferadresse des Kunden war ung&uuml;ltig. Stadt, Bundesland und Postleitzahl stimmten nicht &uuml;berein.<br />Hinweis: Bitte setzen Sie sich mit dem Kunden in Verbindung.');
define('STATUS_ERRORCODE_00005', 'Der zu buchende Betrag ist zu hoch. Bitte w&auml;hlen Sie maximal den offenen Betrag.');
define('STATUS_ERRORCODE_00010', 'Bitte w&auml;hlen Sie einen h&ouml;heren Betrag.');
define('STATUS_ERRORCODE_10009', 'Sie k&ouml;nnen diese art der Transaktion nicht erstatten.');
define('STATUS_ERRORCODE_10417', 'Die PayPal Zahlung konnte nicht abgeschlossen werden, da es ein Problem mit dem PayPal Kontos des Kunden gab.<br />Hinweis: Bitte setzen Sie sich mit dem Kunden in Verbindung.');
define('STATUS_ERRORCODE_10600', 'Die Anforderung wurde bereits abgelehnt.');
define('STATUS_ERRORCODE_10622', 'Auftrag wurde storniert.');
define('STATUS_ERRORCODE_10628', 'Die Transaktion kann derzeit von PayPal nicht bearbeitet werden. Bitte versuchen Sie es sp&auml;ter noch einmal.');
define('STATUS_ERRORCODE_10001', 'PayPal meldet einen internen Error. Bitte versuchen Sie es sp&auml;ter noch einmal.');
define('STATUS_ERRORCODE_10610', 'Der angeforderte Betrag stimmt nicht mit dem reserviertem Betrag überein. Bitte &uuml;berpr&uuml;fen Sie Ihre Eingabe.');
define('STATUS_ERRORCODE_13113', 'PayPal meldet das der Kunde diese Transaktion nicht mit PayPal zahlen kann.<br /><br />Hinweis: Bitte setzen Sie sich mit dem Kunden in Verbindung.');
// EOF GM_MOD

// Gambio Box
define('BOX_HEADING_GAMBIO', 'Gambio');
define('BOX_HEADING_LAYOUT_DESIGN', 'Layout / Design');
define('BOX_GM_EBAY', 'eBay Listing');
define('BOX_GM_PDF', 'Rechnung/Lieferschein');
define('BOX_GM_LOGO', 'Logo Manager');
define('BOX_GM_SECURITY', 'Sicherheitscenter');
define('BOX_GM_SCROLLER', 'News-Scroller');
define('BOX_GM_ID_STARTS', 'Nummernkreise');
define('BOX_GM_STATUSBAR', 'Statusleistenlauftext');
define('BOX_GM_EMAILS', 'E-Mail Vorlagen');
define('BOX_GM_GUESTBOOK', 'G&auml;stebuch');
define('BOX_GM_COUNTER', 'Besucherstatistik');
define('BOX_HEADING_GAMBIO_SEO', 'Gambio SEO');
define('BOX_GM_META', 'Meta-Angaben');
define('BOX_GM_ANALYTICS', 'Tracking-Codes');
define('BOX_GM_BOOKMARKS', 'Social Bookmarking');
define('BOX_GM_SITEMAP', 'Sitemap Generator');
define('BOX_GM_SEO_OPTIONS', 'Einstellungen');
define('BOX_GM_SEO_BOOST', 'Gambio SEO Boost');
define('BOX_GM_STYLE_EDIT', 'Template-Einstellungen');
define('BOX_GM_LANG_EDIT', 'Texte anpassen');
define('BOX_GM_MISCELLANEOUS', 'Allgemeines');
define('BOX_GM_SQL', 'SQL');
define('BOX_GM_OFFLINE', 'Shop online/offline');
define('BOX_GM_LIGHTBOX', 'Lightbox Konfiguration');
define('BOX_GM_TRUSTED_WIDGET',		'Trusted Shops Kundenbewertungen');
define('BOX_GM_TRUSTED_INFO',		'Trusted Shops Info');
define('BOX_GM_TRUSTED_SHOP_ID',	'Trusted Shops G&uuml;tesiegel');
define('BOX_GM_OPENSEARCH', 'OpenSearch Plugin');
define('BOX_GM_MODULE_EXPORT', 'Kundenexport');
define('BOX_GM_BACKUP_FILES_ZIP', 'Dateien sichern');
define('BOX_GM_PRODUCT_EXPORT', 'Artikelexport');
define('BOX_GM_GMOTION', 'G-Motion');
define('BOX_GM_FEATURE_CONTROL', 'Artikel-Filter');
define('BOX_GM_SLIDER', 'Teaser-Slider');
define('BOX_QUANTITYUNITS', 'Mengeneinheiten');
define('BOX_ROBOTS', 'Robots Datei');
define('BOX_GM_INVOICING', 'Rechnungsexport');

// configuration table constants
define('GM_CFG_TRUE', 'Ja');
define('GM_CFG_FALSE', 'Nein');
define('GM_CFG_AND', 'und');
define('GM_CFG_OR', 'oder');
define('GM_CFG_ACCOUNT', 'Kundenkonto');
define('GM_CFG_GUEST', 'Gastkonto');
define('GM_CFG_BOTH', 'beides');
define('GM_CFG_ASC', 'aufsteigend');
define('GM_CFG_DESC', 'absteigend');
define('GM_CFG_PRODUCTS_NAME', 'Artikelname');
define('GM_CFG_DATE_EXPECTED', 'Erscheinungsdatum');
define('GM_CFG_SENDMAIL', 'sendmail');
define('GM_CFG_SMTP', 'SMTP');
define('GM_CFG_MAIL', 'mail');
define('GM_CFG_LF', 'LF');
define('GM_CFG_CRLF', 'CRLF');
define('GM_CFG_WEIGHT', 'Gewicht');
define('GM_CFG_PRICE', 'Preis');
define('GM_CFG_SHOP_OWNER', 'Betreiber E-Mail');
define('GM_CFG_CUSTOMER_MAIL', 'Kunden E-Mail <b>(Standard)</b>');

// Buttons
define('GM_BUTTON_ADD_SPECIAL', 'Neues Angebot');
define('GM_BUTTON_EDIT_SPECIAL', 'Sonderangebot');


define('GM_CLOSE_WINDOW', 'Fenster schlie&szlig;en');

define('GM_ATTRIBUTES_IMAGE_UPLOAD_IMAGE', 'Bild');
define('GM_ATTRIBUTES_IMAGE_UPLOAD_DELETE', 'L&ouml;schen');

define('GM_TEXT_CHOOSE_OPTIONS_TEMPLATE', 'Vorlage für Artikelattribute in &Uuml;bersicht');
define('GM_TEXT_SHOW_ATTRIBUTES', 'Artikelattribute anzeigen');
define('GM_TEXT_SHOW_GRADUATED_PRICES', 'Staffelpreise anzeigen');
define('GM_TEXT_SHOW_QTY', 'Mengeneingabefeld anzeigen');

define('IMAGE_ICON_STATUS_RED', 'nein');
define('IMAGE_ICON_STATUS_GREEN_LIGHT', 'ja');
define('IMAGE_ICON_STATUS_RED_LIGHT', 'inaktiv');
define('IMAGE_ICON_STATUS_GREEN', 'aktiv');
define('IMAGE_ICON_STATUS_GREEN_STOCK', 'auf Lager');

define('GM_IMAGE_PROCESS_TEXT_1', 'Bild ');
define('GM_IMAGE_PROCESS_TEXT_2', ' von ');
define('GM_IMAGE_PROCESS_TEXT_3', ' Bilder von ');
define('GM_IMAGE_PROCESS_TEXT_4', ' verarbeitet.');

define('GM_IMAGE_PROCESS_ERROR_TEXT_1', 'Es sind Fehler aufgetreten!');
define('GM_IMAGE_PROCESS_ERROR_TEXT_2', 'Bitte das Log beachten.');
// JS
define('GM_GV_DELETE', 'Wollen Sie den Gutschein wirklich löschen?');
?>