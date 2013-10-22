<?php
/* --------------------------------------------------------------
   ekomi.php 2012-01-24 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/
?><?php
define('HEADING_TITLE', 'eKomi');

define('EKOMI_REGISTRATION_HEADING', 'Activation');
define('EKOMI_SETTINGS_HEADING', 'Configuration');

define('EKOMI_REGISTRATION', 'eKomi-Activation');
define('EKOMI_REGISTRATION_TEXT', 'Dieses Starterpackage wurde speziell für Gambio-Kunden entwickelt. Mit diesem Produkt k&ouml;nnen Sie kostenfrei Anbieter- und Produktbewertungen sammeln. Eine redaktionelle &Uuml;berpr&uuml;fung der Bewertungen sowie eine Moderation findet nicht statt.<br />Das Starterpackage eignet sich perfekt f&uuml;r Shops/Anbieter, die einen &Uuml;berblick dar&uuml;ber erhalten m&ouml;chten, wie Ihre Kunden &uuml;ber den Shop und/oder Dienstleistung denken bzw. sprechen. Shops, die dar&uuml;ber hinaus mit Ihren Kundenbewertungen mehr Verk&auml;ufe realisieren m&ouml;chten, kontaktieren ihren pers&ouml;nlichen eKomi-Berater unter:<br />Tel: +49 (0)30 2000 444 999 oder <a href="mailto:info@ekomi.de" style="font-size: 12px">info@ekomi.de</a>');
define('EKOMI_REGISTRATION_BOTTOM_TEXT', 'To perform the activation, your data must be transmitted to eKomi.<br /><br />By clicking on the button &quot;Try now for free!&quot; you agree to the <a href="http://www.ekomi.de/de/sites/default/files/downloads/eKomi-AGB.pdf" target="_blank" style="text-decoration:underline">Conditions</a>.');

define('EKOMI_REGISTRATION_OK', 'The eKomi module is installed. The interface data, entered on the configuration page, is valid.');
define('EKOMI_REGISTRATION_WRONG', 'The interface data entered is invalid.');

define('EKOMI_ACCOUNT_NAME_LABEL', 'Account name: ');
define('EKOMI_ACCOUNT_URL_LABEL', 'Shop-URL: ');
define('EKOMI_ACCOUNT_LOGO_LABEL', 'Shop-Logo: ');
define('EKOMI_ACCOUNT_DESC_LABEL', 'Shop-Description: ');
define('EKOMI_ACCOUNT_RESP_LABEL', 'Responsible person: ');
define('EKOMI_ACCOUNT_COMPANY_LABEL', 'Company: ');
define('EKOMI_ACCOUNT_STREET_LABEL', 'Street No.: ');
define('EKOMI_ACCOUNT_ADDRESS_LABEL', 'ZIP City: ');
define('EKOMI_ACCOUNT_PHONE_LABEL', 'Telephone: ');
define('EKOMI_ACCOUNT_FAX_LABEL', 'Fax: ');
define('EKOMI_ACCOUNT_MAIL_LABEL', 'E-Mail: ');
define('EKOMI_ACCOUNT_PRIVATE_MAIL_LABEL', '* private E-Mail: ');

define('EKOMI_ACCOUNT_MAIL_SUBJECT', 'Your eKomi Login Credentials');
define('EKOMI_ACCOUNT_MAIL_MESSAGE_TXT', "Your eKomi account was successfully created and activated. You can login with the following login information on https://www.ekomi.co.uk/login.php:\n\nE-mail: %s\nPassword: %s\n\nPlease change your password after the first login, because this e-mail was transmitted unencrypted.");
define('EKOMI_ACCOUNT_MAIL_MESSAGE_HTML', "Your eKomi account was successfully created and activated. You can login with the following login information on <a href=\"https://www.ekomi.co.uk/login.php\" target=\"_blank\">https://www.ekomi.co.uk/login.php</a>:<br /><br />E-mail: %s<br />Password: %s<br /><br />Please change your password after the first login, because this e-mail was transmitted unencrypted.");

define('EKOMI_ACCOUNT_NAME_TEXT', 'Title of your eKomi-account');
define('EKOMI_ACCOUNT_URL_TEXT', 'URL to your onlinestore');
define('EKOMI_ACCOUNT_LOGO_TEXT', 'https-link to your logo (150 x 75px)');
define('EKOMI_ACCOUNT_DESC_TEXT', 'Description of your store displayed on the public certificate page');
define('EKOMI_ACCOUNT_RESP_TEXT', 'Responsible person displayed on the public certificate page');
define('EKOMI_ACCOUNT_COMPANY_TEXT', 'Company displayed on the public certificate page');
define('EKOMI_ACCOUNT_STREET_TEXT', 'Street displayed on the public certificate page');
define('EKOMI_ACCOUNT_ADDRESS_TEXT', 'ZIP and city displayed on the public certificate page');
define('EKOMI_ACCOUNT_PHONE_TEXT', 'Telephone number displayed on the public certificate page');
define('EKOMI_ACCOUNT_FAX_TEXT', 'Fax number displayed on the public certificate page');
define('EKOMI_ACCOUNT_MAIL_TEXT', 'E-mail address displayed on the public certificate page');
define('EKOMI_ACCOUNT_PRIVATE_MAIL_TEXT', 'E-mail address used for internal communication (* required)');
define('EKOMI_ACCOUNT_SUCCESS', 'Thank you.<br /><br />Your registration was successful.<br /><br />To manage your customer opinions, please log in on <a href="https://www.ekomi.co.uk/login.php" target="_blank" style="text-decoration:underline">https://www.ekomi.co.uk/login.php</a> using the login credentials you have just received by e-mail.');
define('EKOMI_MAIL_IS_MISSING', 'The &quot;private E-Mail&quot; is missing.');

define('EKOMI_REGISTRATION_SETTINGS', 'eKomi-Configuration');
define('EKOMI_REGISTRATION_SETTINGS_TEXT', 'The widget embed code you find in the customer area of eKomi (INSTALLATION -> WIDGET INSTALLATION).');
define('EKOMI_STATUS_TEXT', 'eKomi active:');
define('EKOMI_API_ID_TEXT', 'Interface-ID:');
define('EKOMI_API_PASSWORD_TEXT', 'Interface-Password:');
define('EKOMI_WIDGET_CODE_TEXT', 'Widget embed code:');

define('EKOMI_SEND_MAILS_HEADING', 'eKomi e-mails');
define('EKOMI_SEND_MAILS', 'eKomi review e-mails');
define('EKOMI_SEND_MAILS_TEXT', 'You can open the cronjob URL in the browser to send review e-mails or use the URL to set up a cronjob in the customer area of your provider to automate the e-mail delivery. Ask your provider how to set up cronjobs.');
define('EKOMI_SEND_MAILS_URL_TEXT', 'Cronjob-URL:');

define('EKOMI_SUCCESS', 'Update successfully saved');

define('BUTTON_EKOMI_SEND', 'Try now for free!');
?>