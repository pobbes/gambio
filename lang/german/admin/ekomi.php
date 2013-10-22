<?php
/* --------------------------------------------------------------
   ekomi.php 2012-12-24 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/
?><?php
define('HEADING_TITLE', 'eKomi');

define('EKOMI_REGISTRATION_HEADING', 'Aktivierung');
define('EKOMI_SETTINGS_HEADING', 'Konfiguration');

define('EKOMI_REGISTRATION', 'eKomi-Aktivierung');
define('EKOMI_REGISTRATION_TEXT', 'Dieses Starterpackage wurde speziell für Gambio-Kunden entwickelt. Mit diesem Produkt k&ouml;nnen Sie kostenfrei Anbieter- und Produktbewertungen sammeln. Eine redaktionelle &Uuml;berpr&uuml;fung der Bewertungen sowie eine Moderation findet nicht statt.<br />Das Starterpackage eignet sich perfekt f&uuml;r Shops/Anbieter, die einen &Uuml;berblick dar&uuml;ber erhalten m&ouml;chten, wie Ihre Kunden &uuml;ber den Shop und/oder Dienstleistung denken bzw. sprechen. Shops, die dar&uuml;ber hinaus mit Ihren Kundenbewertungen mehr Verk&auml;ufe realisieren m&ouml;chten, kontaktieren ihren pers&ouml;nlichen eKomi-Berater unter:<br />Tel: +49 (0)30 2000 444 999 oder <a href="mailto:info@ekomi.de" style="font-size: 12px">info@ekomi.de</a>');
define('EKOMI_REGISTRATION_BOTTOM_TEXT', 'Um die Aktivierung vorzunehmen, m&uuml;ssen Ihre Daten an eKomi &uuml;bermittelt werden.<br /><br />Mit Klick auf den Button &quotJetzt kostenlos Testen!&quot; erkl&auml;ren Sie sich mit den <a href="http://www.ekomi.de/de/sites/default/files/downloads/eKomi-AGB.pdf" target="_blank" style="text-decoration:underline">AGB</a> einverstanden.');

define('EKOMI_REGISTRATION_OK', 'Das eKomi-Modul ist eingerichtet. Die in der Konfiguration eingetragenen Interface-Daten sind g&uuml;ltig.');
define('EKOMI_REGISTRATION_WRONG', 'Die Interface-Daten sind ung&uuml;ltig.');

define('EKOMI_ACCOUNT_NAME_LABEL', 'Account Name: ');
define('EKOMI_ACCOUNT_URL_LABEL', 'Shop-URL: ');
define('EKOMI_ACCOUNT_LOGO_LABEL', 'Shop-Logo: ');
define('EKOMI_ACCOUNT_DESC_LABEL', 'Shop-Beschreibung: ');
define('EKOMI_ACCOUNT_RESP_LABEL', 'Verantwortlicher: ');
define('EKOMI_ACCOUNT_COMPANY_LABEL', 'Firma: ');
define('EKOMI_ACCOUNT_STREET_LABEL', 'Stra&szlig;e Nr.: ');
define('EKOMI_ACCOUNT_ADDRESS_LABEL', 'PLZ Ort: ');
define('EKOMI_ACCOUNT_PHONE_LABEL', 'Telefon: ');
define('EKOMI_ACCOUNT_FAX_LABEL', 'Fax: ');
define('EKOMI_ACCOUNT_MAIL_LABEL', 'E-Mail: ');
define('EKOMI_ACCOUNT_PRIVATE_MAIL_LABEL', '* private E-Mail: ');

define('EKOMI_ACCOUNT_MAIL_SUBJECT', 'Ihre eKomi-Zugangsdaten');
define('EKOMI_ACCOUNT_MAIL_MESSAGE_TXT', "Ihr eKomi-Account wurde erfolgreich angelegt und aktiviert. Sie können sich mit folgenden Login-Daten auf https://www.ekomi.de/login.php einloggen:\n\nE-Mail: %s\nPasswort: %s\n\nBitte ändern Sie nach dem ersten Login unbedingt Ihr Passwort, da diese E-Mail unverschlüsselt übertragen wurde.");
define('EKOMI_ACCOUNT_MAIL_MESSAGE_HTML', "Ihr eKomi-Account wurde erfolgreich angelegt und aktiviert. Sie k&ouml;nnen sich mit folgenden Login-Daten auf <a href=\"https://www.ekomi.de/login.php\" target=\"_blank\">https://www.ekomi.de/login.php</a> einloggen:<br /><br />E-Mail: %s<br />Passwort: %s<br /><br />Bitte &auml;ndern Sie nach dem ersten Login unbedingt Ihr Passwort, da diese E-Mail unverschl&uuml;sselt &uuml;bertragen wurde.");

define('EKOMI_ACCOUNT_NAME_TEXT', 'Bezeichnung Ihres eKomi-Accounts');
define('EKOMI_ACCOUNT_URL_TEXT', 'URL zu Ihrem Shop');
define('EKOMI_ACCOUNT_LOGO_TEXT', 'https-Link zu Ihrem Shoplogo (150 x 75px)');
define('EKOMI_ACCOUNT_DESC_TEXT', 'Beschreibung Ihres Shops auf der &ouml;ffentlichen Zertifikatsseite');
define('EKOMI_ACCOUNT_RESP_TEXT', 'Verantwortlicher f&uuml;r die Anzeige auf der &ouml;ffentlichen Zertifikatsseite');
define('EKOMI_ACCOUNT_COMPANY_TEXT', 'Firma f&uuml;r die Anzeige auf der &ouml;ffentlichen Zertifikatsseite');
define('EKOMI_ACCOUNT_STREET_TEXT', 'Stra&szlig f&uuml;r die Anzeige auf der &ouml;ffentlichen Zertifikatsseite');
define('EKOMI_ACCOUNT_ADDRESS_TEXT', 'Postleitzahl und Ort f&uuml;r die Anzeige auf der &ouml;ffentlichen Zertifikatsseite');
define('EKOMI_ACCOUNT_PHONE_TEXT', 'Telefon f&uuml;r die Anzeige auf der &ouml;ffentlichen Zertifikatsseite');
define('EKOMI_ACCOUNT_FAX_TEXT', 'Fax f&uuml;r die Anzeige auf der &ouml;ffentlichen Zertifikatsseite');
define('EKOMI_ACCOUNT_MAIL_TEXT', 'E-Mail f&uuml;r die Anzeige auf der &ouml;ffentlichen Zertifikatsseite');
define('EKOMI_ACCOUNT_PRIVATE_MAIL_TEXT', 'E-Mail f&uuml;r die eKomi-interne Kommunikation (* Pflichtfeld)');
define('EKOMI_ACCOUNT_SUCCESS', 'Vielen Dank.<br /><br />Ihre Registrierung war erfolgreich.<br /><br />Um Ihre Kundenmeinungen zu verwalten, loggen Sie sich auf <a href="https://www.ekomi.de/login.php" target="_blank" style="text-decoration:underline">https://www.ekomi.de/login.php</a> mit den Zugangsdaten, die Sie soeben per E-Mail erhalten haben, ein.');
define('EKOMI_MAIL_IS_MISSING', 'Sie haben das Feld &quot;private E-Mail&quot; nicht korrekt ausgef&uuml;llt.');

define('EKOMI_REGISTRATION_SETTINGS', 'eKomi-Konfiguration');
define('EKOMI_REGISTRATION_SETTINGS_TEXT', 'Den Widget-Einbindungcode f&uuml;r die Anzeige der Kundenbewertungen in einer Men&uuml;box finden Sie im Kundenbereich von eKomi unter dem Men&uuml;punkt &quot;INSTALLATION -> WIDGET EINBAUEN&quot; (in der kostenlosen eKomi-Version nicht verf&uuml;gbar).');
define('EKOMI_STATUS_TEXT', 'eKomi aktiv:');
define('EKOMI_API_ID_TEXT', 'Interface-ID:');
define('EKOMI_API_PASSWORD_TEXT', 'Interface-Passwort:');
define('EKOMI_WIDGET_CODE_TEXT', 'Widget-Einbindungscode:');

define('EKOMI_SEND_MAILS_HEADING', 'Bewertungs-E-Mail-Versand');
define('EKOMI_SEND_MAILS', 'Bewertungs-E-Mail-Versand');
define('EKOMI_SEND_MAILS_TEXT', 'Sie k&ouml;nnen die Cronjob-URL im Browser aufrufen, um noch nicht versendete Bewertungs-E-Mails zu verschicken oder die URL im Kundenbereich Ihres Providers f&uuml;r die Einrichtung eines Cronjobs nutzen, um den E-Mail-Versand zu automatisieren. Ob und wie Cronjobs eingerichtet werden k&ouml;nnen, kann Ihnen Ihr Hosting-Provider mitteilen.');
define('EKOMI_SEND_MAILS_URL_TEXT', 'Cronjob-URL:');

define('EKOMI_SUCCESS', 'Aktualisierung erfolgreich durchgef&uuml;hrt.');

define('BUTTON_EKOMI_SEND', 'Jetzt kostenlos Testen!');
?>