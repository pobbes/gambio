<?php

  /* -----------------------------------------------------------------------------------------
  Lettr.de Newsletter Konfiguration
  Digineo GmbH 2011 | www.digineo.de
  Author: Ronny Paschen
  Version 2.0
  Lizenz: GNU 3
  --------------------------------------------------------------------------------------------*/


// Heading
define('HEADING_TITLE', 'Lettr.de Mailexchange');

// Ãœberschriften
define('MENU_TITLE_NEWSLETTER_EXPORT', 'Newsletter-Export');
define('MENU_TITLE_LETTRMAILEXCHANGE', 'Lettr.de Mailexchange');

// ErklÃ?rungen
define('TEXT_LETTR_NEWCUSTOMER', '<a href="https://lettr.de/signup?coupon=gambio"><img src="https://lettr.de/images/i/html-newsletter-versenden.png"></a><br><br>Lettr is your e-mail marketing software, to delivery professional <span style="font-weight: bold;">newsletter</span>, e-mails and order confirmations. Manage your recipients and make your success visible. <br><br>Sign up for your free account now: The <span style="font-weight: bold;">simplicity</span>, the <span style="font-weight: bold;">usuability</span> and a lot of <span style="font-weight: bold;">amazing functions</span> will persuade you.<br><br>New customers will get a bonus of 5000 mails with the coupon code <span style="font-weight: bold;">gambio</span>!');
define('TEXT_NEWSLETTER_EXPORT', 'This option will enable or disable the access to the export-module.<br /> </br> If you enable the interface, you can access the export-module using this address:<br /> <br/> <code id="news_export_code" style="font-style: italic;">Will be displayed after the successful validation of your API-Key...</code><br /> <br />This address will be stored in your lettr.de account after your API-Key has been validated.');
define('TEXT_NEWSLETTER_EXPORTCUSTOMER', 'Export only newsletter recipients?');
define('TEXT_LETTR_APIKEY', 'Enter your <a href="https://lettr.de/signup?coupon=gambio">lettr.de</a> API-Key. This option is only required, if you want to use the lettr-API for all mail transactions. <br /> You can lookup your API-Key <a href="https://lettr.de/setting">here</a>.');
define('TEXT_LETTR_MAILVIALETTR', 'All mails send by your Shop, like order confirmations or activation mails will be delivered using lettr.de.<br /><br /> You will profit from whitelisting, which warrants a delivery to <a href="http://www.certified-senders.eu/csa_html/de/271.htm">leading mailproviders</a>.');
define('TEXT_LETTR_MAILWITHATTACH', 'Use lettr.de also for sending mails with attachments. <span style="font-weight: bold;">Warning: This will incur additional costs!</span> See: <a href="http://lettr.de/preise">http://lettr.de/preise</a>');

// Checkboxen etc.
define('NEWSLETTER_EXPORT_NO', 'Disable newsletter export');
define('NEWSLETTER_EXPORT_YES', 'Enable newsletter export');
define('NEWSLETTER_EXPORTALL_NO', 'Export only newsletter recipients');
define('NEWSLETTER_EXPORTALL_YES', 'Export all mail recipients');
define('LETTR_APIKEY', 'Lettr.de API-Key: ');
define('ALLVIALETTR_NO', 'Disable');
define('ALLVIALETTR_YES', 'Enable');
define('ATTACHVIALETTR_NO', 'Do not send attachments via lettr.de');
define('ATTACHVIALETTR_YES', 'Attachments send via lettr.de');
define('TEXT_BTN_SAVE', 'Save');

// Kram
define('FILENAME_LETTR_DE', 'lettr_de.php');

?>
