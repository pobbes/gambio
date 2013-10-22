<?php

  /* -----------------------------------------------------------------------------------------
  Lettr.de Newsletter Konfiguration
  Digineo GmbH 2011 | www.digineo.de
  Author: Ronny Paschen
  Version 2.0
  Lizenz: GNU 3
  --------------------------------------------------------------------------------------------*/
 
// Heading
define('HEADING_TITLE', 'Lettr.de Mailversand');

// Ãœberschriften
define('MENU_TITLE_NEWSLETTER_EXPORT', 'Newsletter-Export');
define('MENU_TITLE_LETTRMAILEXCHANGE', 'Lettr.de Mailversand');

// ErklÃ?rungen
define('TEXT_LETTR_NEWCUSTOMER', '<a href="https://lettr.de/signup?coupon=gambio"><img src="https://lettr.de/images/i/html-newsletter-versenden.png"></a><br><br>Lettr ist Ihre E-Mail Marketing Software, um professionelle <span style="font-weight: bold;">Newsletter zu erstellen</span> und E-Mails sowie Best&auml;tigungsmails sicher zuzustellen. Verwalten Sie Ihre Empf&auml;nger und machen Ihren Erfolg messbar. <br><br>&Uuml;berzeugen Sie sich von der <span style="font-weight: bold;">Einfachheit</span> der Bedienung, den <span style="font-weight: bold;">vielen Funktionen</span> und den zahlreichen <span style="font-weight: bold;">Auswertungsstatistiken</span>, die lettr Ihnen bietet. Melden Sie sich jetzt kostenlos und unverbindlich an.<br><br>F&uuml;r Neukunden gibt es bei der Anmeldung mit dem Gutscheincode <span style="font-weight: bold;">gambio</span> 5000 Mails gratis! Einfach &uuml;ber das obige Logo anmelden.');
define('TEXT_NEWSLETTER_EXPORT', 'Mit dieser Option schalten Sie den Zugang zur Exportschnittstelle an oder aus.<br /> </br> Wenn Sie die Schnittstelle aktiviert haben k&ouml;nnen Sie auf den Export &uuml;ber folgende Adresse zugreifen:<br /> <br/> <code id="news_export_code" style="font-style: italic;">Wird angezeigt, sobald der API-Key verifiziert wurde...</code><br /> <br />Diese Adresse wird beim Speichern automatisch an Lettr.de &uuml;bermittelt, sofern der API-Key verifiziert werden konnte.');
define('TEXT_NEWSLETTER_EXPORTCUSTOMER', 'Nur Newsletter-Empf&auml;nger exportieren?');
define('TEXT_LETTR_APIKEY', 'Geben Sie hier Ihren lettr.de API-Key an. Diese Option ist nur erforderlich wenn Sie den kompletten Emailversand &uuml;ber lettr.de abwickeln m&ouml;chten. <br /> Sie finden Ihren API-Key <a href="https://lettr.de/setting">hier</a>.');
define('TEXT_LETTR_MAILVIALETTR', 'Der gesamte Emailverkehr Ihres Shops wie Bestellbest&auml;tigungen, Aktivierungsmails und so weiter wird &uuml;ber lettr.de abgewickelt.<br /><br /> Sie profitieren vom Whitelisting welches eine Zustellung bei <a href="http://www.certified-senders.eu/csa_html/de/271.htm">f&uuml;hrenden Emailanbietern</a> sichert.');
define('TEXT_LETTR_MAILWITHATTACH', 'Lettr.de ebenfalls f&uuml;r das Versenden von Attachments verwenden. <span style="font-weight: bold;">Achtung: Dies verursacht Extrakosten!</span> Siehe: <a href="http://lettr.de/preise">http://lettr.de/preise</a>');

// Checkboxen etc.
define('NEWSLETTER_EXPORT_NO', 'Newsletter-Export deaktivieren');
define('NEWSLETTER_EXPORT_YES', 'Newsletter-Export aktivieren');
define('NEWSLETTER_EXPORTALL_NO', 'Nur Newsletter-Empf&auml;nger exportieren');
define('NEWSLETTER_EXPORTALL_YES', 'Alle E-Mail-Adressen exportieren');
define('LETTR_APIKEY', 'Lettr.de API-Key: ');
define('ALLVIALETTR_NO', 'Deaktivieren');
define('ALLVIALETTR_YES', 'Aktivieren');
define('ATTACHVIALETTR_NO', 'Attachments nicht &uuml;ber Lettr.de verschicken');
define('ATTACHVIALETTR_YES', 'Attachments &uuml;ber Lettr.de verschicken');
define('TEXT_BTN_SAVE', 'Speichern');

// Kram
define('FILENAME_LETTR_DE', 'lettr_de.php');

?>
