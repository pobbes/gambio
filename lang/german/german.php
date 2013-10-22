<?php
/* --------------------------------------------------------------
   german.php 2010-01-14 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(german.php,v 1.119 2003/05/19); www.oscommerce.com
   (c) 2003  nextcommerce (german.php,v 1.25 2003/08/25); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: german.php 1308 2005-10-15 14:22:18Z hhgag $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

function xtc_date_raw($date, $reverse = false) {
  if ($reverse) {
    return substr($date, 0, 2) . substr($date, 3, 2) . substr($date, 6, 4);
  } else {
    return substr($date, 6, 4) . substr($date, 3, 2) . substr($date, 0, 2);
  }
}

/*
 *
 *  ZEIT / DATUM
 *
 */

@setlocale(LC_TIME, 'de_DE@euro', 'de_DE', 'de-DE', 'de', 'ge', 'de_DE.ISO_8859-1', 'German','de_DE.ISO_8859-15', 'de_DE.utf8');
define('HTML_PARAMS','dir="ltr" lang="de"');


define('DATE_FORMAT_SHORT', '%d.%m.%Y');  // this is used for strftime()
define('DATE_FORMAT_LONG', '%A, %d. %B %Y'); // this is used for strftime()
define('DATE_FORMAT', 'd.m.Y');  // this is used for strftime()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');
define('DOB_FORMAT_STRING', 'tt.mm.jjjj');


// if USE_DEFAULT_LANGUAGE_CURRENCY is true, use the following currency, instead of the applications default currency (used when changing language)
define('LANGUAGE_CURRENCY', 'EUR');
define('WARNING_INSTALL_DIRECTORY_EXISTS', 'Warnung: Das Installationverzeichnis ist noch vorhanden auf: ' . dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']) . '/gambio_installer. Bitte l&ouml;schen Sie das Verzeichnis aus Gr&uuml;nden der Sicherheit!');
define('WARNING_CONFIG_FILE_WRITEABLE', 'Warnung: Konfigurationsdatei ist beschreibbar: ' . dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']) . '/includes/configure.php. Das stellt ein m&ouml;gliches Sicherheitsrisiko dar - bitte korrigieren Sie die Benutzerberechtigungen zu dieser Datei!');
define('WARNING_SESSION_DIRECTORY_NON_EXISTENT', 'Warnung: Das Verzeichnis f&uuml;r die Sessions existiert nicht: ' . xtc_session_save_path() . '. Die Sessions werden nicht funktionieren bis das Verzeichnis erstellt wurde!');
define('WARNING_SESSION_DIRECTORY_NOT_WRITEABLE', 'Warnung: XSessions Verzeichnis nicht beschreibbar: ' . xtc_session_save_path() . '. Die Sessions werden nicht funktionieren bis die richtigen Benutzerberechtigungen gesetzt wurden!');
define('WARNING_SESSION_AUTO_START', 'Warnung: session.auto_start ist aktiviert (enabled) - Bitte deaktivieren (disabled) Sie dieses PHP Feature in der php.ini und starten Sie den WEB-Server neu!');
define('WARNING_DOWNLOAD_DIRECTORY_NON_EXISTENT', 'Warnung: Das Verzeichnis f&uuml;r den Artikel Download existiert nicht: ' . DIR_FS_DOWNLOAD . '. Diese Funktion wird nicht funktionieren bis das Verzeichnis erstellt wurde!');

if ($navigation->snapshot['page'] == FILENAME_CHECKOUT_SHIPPING) {
  define('NAVBAR_TITLE_LOGIN', 'Bestellen');
} else {
  define('NAVBAR_TITLE_LOGIN', 'Anmelden');
}



global $gmLangFileMaster;
$gmLangFileMaster->define_lang_file_content('lang/german/german.php');
/*

define('TITLE', STORE_NAME);
define('HEADER_TITLE_TOP', 'Startseite');
define('HEADER_TITLE_CATALOG', 'Katalog');

define('MALE', 'Herr');
define('FEMALE', 'Frau');

define('IMAGE_REDEEM_GIFT','Gutschein einl&ouml;sen!');

define('BOX_TITLE_STATISTICS','Statistik:');
define('BOX_ENTRY_CUSTOMERS','Kunden');
define('BOX_ENTRY_PRODUCTS','Artikel');
define('BOX_ENTRY_REVIEWS','Bewertungen');
define('TEXT_VALIDATING','Nicht best&auml;tigt');

define('BOX_MANUFACTURER_INFO_HOMEPAGE', '%s Homepage');
define('BOX_MANUFACTURER_INFO_OTHER_PRODUCTS', 'Mehr Artikel');

define('BOX_HEADING_ADD_PRODUCT_ID','In den Korb legen');

define('BOX_LOGINBOX_STATUS','Kundengruppe: ');
define('BOX_LOGINBOX_DISCOUNT','Artikelrabatt');
define('BOX_LOGINBOX_DISCOUNT_TEXT','Rabatt');
define('BOX_LOGINBOX_DISCOUNT_OT','');

define('BOX_REVIEWS_WRITE_REVIEW', 'Bewerten Sie diesen Artikel!');
define('BOX_REVIEWS_TEXT_OF_5_STARS', '%s von 5 Sternen!');

define('PULL_DOWN_DEFAULT', 'Bitte w&auml;hlen');

define('JS_ERROR', 'Notwendige Angaben fehlen! Bitte korrekt ausf&uuml;llen.\n\n');

define('JS_REVIEW_TEXT', '* Der Text muss aus mindestens ' . REVIEW_TEXT_MIN_LENGTH . ' Buchstaben bestehen.\n\n');
define('JS_REVIEW_RATING', '* Geben Sie Ihre Bewertung ein.\n\n');
define('JS_ERROR_NO_PAYMENT_MODULE_SELECTED', '* Bitte wählen Sie eine Zahlungsweise für Ihre Bestellung.\n');
define('JS_ERROR_SUBMITTED', 'Diese Seite wurde bereits best&auml;tigt. Klicken Sie bitte OK und warten bis der Prozess durchgef&uuml;hrt wurde.');
define('ERROR_NO_PAYMENT_MODULE_SELECTED', '* Bitte wählen Sie eine Zahlungsweise für Ihre Bestellung.');

 
define('ENTRY_PRIVACY_ERROR', 'Sie haben die Datenschutzbestimmungen nicht best&auml;tigt.');
define('ENTRY_CHECK_PRIVACY', 'Die <a href="%s" target="_blank" class="lightbox_iframe">Datenschutzbestimmungen</a> habe ich zur Kenntnis genommen und stimme ihnen zu.');
define('ENTRY_SHOW_PRIVACY', 'Die <a href="%s" target="_blank" class="lightbox_iframe">Datenschutzbestimmungen</a> habe ich zur Kenntnis genommen.');
define('ENTRY_COMPANY_ERROR', '');
define('ENTRY_COMPANY_TEXT', '');
define('ENTRY_GENDER_ERROR', 'Bitte w&auml;hlen Sie Ihre Anrede aus.');
define('ENTRY_GENDER_TEXT', '*');
define('ENTRY_FIRST_NAME_ERROR', 'mindestens ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' Zeichen');
define('ENTRY_FIRST_NAME_TEXT', '*');
define('ENTRY_LAST_NAME_ERROR', 'mindestens ' . ENTRY_LAST_NAME_MIN_LENGTH . ' Zeichen');
define('ENTRY_LAST_NAME_TEXT', '*');
define('ENTRY_DATE_OF_BIRTH_ERROR', 'Pflichtangabe im Format TT.MM.JJJJ');
define('ENTRY_DATE_OF_BIRTH_TEXT', '* (z.&nbsp;B. 21.05.1970)');
define('ENTRY_EMAIL_ADDRESS_ERROR', 'mindestens ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' Zeichen');
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', 'Ihre eingegebene E-Mail-Adresse ist fehlerhaft - bitte &uuml;berpr&uuml;fen Sie diese.');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 'Ihre eingegebene E-Mail-Adresse existiert bereits - bitte &uuml;berpr&uuml;fen Sie diese.');
define('ENTRY_EMAIL_ADDRESS_TEXT', '*');
define('ENTRY_STREET_ADDRESS_ERROR', 'mindestens ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' Zeichen');
define('ENTRY_STREET_ADDRESS_TEXT', '*');
define('ENTRY_SUBURB_TEXT', '');
define('ENTRY_POST_CODE_ERROR', 'mindestens ' . ENTRY_POSTCODE_MIN_LENGTH . ' Zeichen');
define('ENTRY_POST_CODE_TEXT', '*');
define('ENTRY_CITY_ERROR', 'mindestens ' . ENTRY_CITY_MIN_LENGTH . ' Zeichen');
define('ENTRY_CITY_TEXT', '*');
define('ENTRY_STATE_ERROR', 'mindestens ' . ENTRY_STATE_MIN_LENGTH . ' Zeichen');
define('ENTRY_STATE_ERROR_SELECT', 'Bitte Bundesland ausw&auml;hlen.');
define('ENTRY_STATE_TEXT', '*');
define('ENTRY_COUNTRY_ERROR', 'Bitte w&auml;hlen Sie ihr Land aus der Liste aus.');
define('ENTRY_COUNTRY_TEXT', '*');
define('ENTRY_TELEPHONE_NUMBER_ERROR', 'mindestens ' . ENTRY_TELEPHONE_MIN_LENGTH . ' Zeichen');
define('ENTRY_TELEPHONE_NUMBER_TEXT', '*');
define('ENTRY_FAX_NUMBER_TEXT', '');
define('ENTRY_NEWSLETTER_TEXT', '');
define('ENTRY_PASSWORD_ERROR', 'mindestens ' . ENTRY_PASSWORD_MIN_LENGTH . ' Zeichen');
define('ENTRY_PASSWORD_ERROR_NOT_MATCHING', 'Ihre Passw&ouml;rter stimmen nicht &uuml;berein.');
define('ENTRY_PASSWORD_TEXT', '*');
define('ENTRY_PASSWORD_CONFIRMATION_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT_ERROR', 'mindestens ' . ENTRY_PASSWORD_MIN_LENGTH . ' Zeichen');
define('ENTRY_PASSWORD_NEW_TEXT', '*');
define('ENTRY_PASSWORD_NEW_ERROR', 'mindestens ' . ENTRY_PASSWORD_MIN_LENGTH . ' Zeichen');
define('ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING', 'Ihre Passw&ouml;rter stimmen nicht &uuml;berein.');


define('TEXT_RESULT_PAGE', 'Seiten:');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'Zeige <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> Artikeln)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', 'Zeige <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> Bestellungen)');
define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', 'Zeige <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> Bewertungen)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW', 'Zeige <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> neuen Artikeln)');
define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', 'Zeige <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> Angeboten)');

define('PREVNEXT_TITLE_PREVIOUS_PAGE', 'vorherige Seite');
define('PREVNEXT_TITLE_NEXT_PAGE', 'n&auml;chste Seite');
define('PREVNEXT_TITLE_PAGE_NO', 'Seite %d');
define('PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE', 'Vorhergehende %d Seiten');
define('PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE', 'N&auml;chste %d Seiten');


define('PREVNEXT_BUTTON_PREV', '[&lt;&lt;&nbsp;vorherige]');
define('PREVNEXT_BUTTON_NEXT', '[n&auml;chste&nbsp;&gt;&gt;]');


define('IMAGE_BUTTON_ADD_ADDRESS', 'Neue Adresse');
define('IMAGE_BUTTON_BACK', 'Zur&uuml;ck');
define('IMAGE_BUTTON_CHANGE_ADDRESS', 'Adresse &auml;ndern');
define('IMAGE_BUTTON_CHECKOUT', 'Kasse');
define('IMAGE_BUTTON_CONFIRM_ORDER', 'Bestellung best&auml;tigen');
define('IMAGE_BUTTON_CONTINUE', 'Weiter');
define('IMAGE_BUTTON_DELETE', 'L&ouml;schen');
define('IMAGE_BUTTON_LOGIN', 'Anmelden');
define('IMAGE_BUTTON_IN_CART', 'In den Warenkorb');
define('IMAGE_BUTTON_SEARCH', 'Suchen');
define('IMAGE_BUTTON_UPDATE', 'Aktualisieren');
define('IMAGE_BUTTON_UPDATE_CART', 'Warenkorb aktualisieren');
define('IMAGE_BUTTON_WRITE_REVIEW', 'Bewertung schreiben');
define('IMAGE_BUTTON_ADMIN', 'Admin');
define('IMAGE_BUTTON_PRODUCT_EDIT', 'Artikel bearbeiten');
define('IMAGE_BUTTON_LOGIN', 'Anmelden');

define('SMALL_IMAGE_BUTTON_DELETE', 'L&ouml;schen');
define('SMALL_IMAGE_BUTTON_EDIT', '&Auml;ndern');
define('SMALL_IMAGE_BUTTON_VIEW', 'Anzeigen');

define('ICON_ARROW_RIGHT', 'Zeige mehr');
define('ICON_CART', 'In den Warenkorb');
define('ICON_SUCCESS', 'Erfolg');
define('ICON_WARNING', 'Warnung');


define('TEXT_GREETING_PERSONAL', 'Sch&ouml;n, dass Sie wieder da sind, <span class="greetUser">%s!</span> M&ouml;chten Sie sich unsere <a style="text-decoration:underline;" href="%s">neuen Artikel</a> ansehen?');
define('TEXT_GREETING_PERSONAL_RELOGON', '<small>Wenn Sie nicht %s sind, melden Sie sich bitte <a style="text-decoration:underline;" href="%s">hier</a> mit Ihren Anmeldedaten an.</small>');
define('TEXT_GREETING_GUEST', 'Herzlich Willkommen <span class="greetUser">Gast!</span> M&ouml;chten Sie sich <a style="text-decoration:underline;" href="%s">anmelden</a>? Oder wollen Sie ein <a style="text-decoration:underline;" href="%s">Kundenkonto</a> er&ouml;ffnen?');

define('TEXT_SORT_PRODUCTS', 'Sortierung der Artikel ist ');
define('TEXT_DESCENDINGLY', 'absteigend');
define('TEXT_ASCENDINGLY', 'aufsteigend');
define('TEXT_BY', ' nach ');

define('TEXT_REVIEW_BY', 'von %s');
define('TEXT_REVIEW_WORD_COUNT', '%s Worte');
define('TEXT_REVIEW_RATING', 'Bewertung: %s [%s]');
define('TEXT_REVIEW_DATE_ADDED', 'Hinzugef&uuml;gt am: %s');
define('TEXT_NO_REVIEWS', 'Es liegen noch keine Bewertungen vor.');
define('TEXT_NO_NEW_PRODUCTS', 'Zur Zeit gibt es keine neuen Artikel.');
define('TEXT_UNKNOWN_TAX_RATE', 'Unbekannter Steuersatz');



define('SUCCESS_ACCOUNT_UPDATED', 'Ihr Konto wurde erfolgreich aktualisiert.');
define('SUCCESS_PASSWORD_UPDATED', 'Ihr Passwort wurde erfolgreich ge&auml;ndert!');
define('ERROR_CURRENT_PASSWORD_NOT_MATCHING', 'Das eingegebene Passwort stimmt nicht mit dem gespeichertem Passwort &uuml;berein. Bitte versuchen Sie es noch einmal.');
define('TEXT_MAXIMUM_ENTRIES', 'Hinweis: Ihnen stehen %s Adressbucheintr&auml;ge zur Verf&uuml;gung!');
define('SUCCESS_ADDRESS_BOOK_ENTRY_DELETED', 'Der ausgew&auml;hlte Eintrag wurde erfolgreich gel&ouml;scht.');
define('SUCCESS_ADDRESS_BOOK_ENTRY_UPDATED', 'Ihr Adressbuch wurde erfolgreich aktualisiert!');
define('WARNING_PRIMARY_ADDRESS_DELETION', 'Die Standardadresse kann nicht gel&ouml;scht werden. Bitte erst eine andere Standardadresse w&auml;hlen. Danach kann der Eintrag gel&ouml;scht werden.');
define('ERROR_NONEXISTING_ADDRESS_BOOK_ENTRY', 'Dieser Adressbucheintrag ist nicht vorhanden.');
define('ERROR_ADDRESS_BOOK_FULL', 'Ihr Adressbuch kann keine weiteren Adressen aufnehmen. Bitte l&ouml;schen Sie eine nicht mehr ben&ouml;tigte Adresse. Danach k&ouml;nnen Sie einen neuen Eintrag speichern.');


define('ERROR_CONDITIONS_NOT_ACCEPTED', '* Sofern Sie unsere Allgemeinen Gesch&auml;ftsbedingungen und unser Widerrufsrecht nicht akzeptieren,\n k&ouml;nnen wir Ihre Bestellung leider nicht entgegennehmen! \n\n');

define('SUB_TITLE_OT_DISCOUNT','Rabatt:');

define('TAX_ADD_TAX','inkl. ');
define('TAX_NO_TAX','zzgl. ');

define('NOT_ALLOWED_TO_SEE_PRICES','Sie k&ouml;nnen als Gast (bzw. mit Ihrem derzeitigen Status) keine Preise sehen');
define('NOT_ALLOWED_TO_SEE_PRICES_TEXT','Sie haben keine Erlaubnis Preise zu sehen, erstellen Sie bitte ein Kundenkonto.');

define('TEXT_DOWNLOAD','Download');
define('TEXT_VIEW','Ansehen');

define('TEXT_BUY', '1 x \'');
define('TEXT_NOW', '\' bestellen');
define('TEXT_GUEST','Gast');


define('TEXT_ALL_CATEGORIES', 'Alle Kategorien');
define('TEXT_ALL_MANUFACTURERS', 'Alle Hersteller');
define('JS_AT_LEAST_ONE_INPUT', '* Eines der folgenden Felder muss ausgef&uuml;llt werden:\n    Stichworte\n    Preis ab\n    Preis bis\n');
define('AT_LEAST_ONE_INPUT', 'Eines der folgenden Felder muss ausgef&uuml;llt werden:<br />Stichworte mit mindestens drei Zeichen<br />Preis ab<br />Preis bis<br />');
define('JS_INVALID_FROM_DATE', '* ung&uuml;ltiges Datum (von)\n');
define('JS_INVALID_TO_DATE', '* ung&uuml;ltiges Datum (bis)\n');
define('JS_TO_DATE_LESS_THAN_FROM_DATE', '* Das Datum (von) muss gr&ouml;&szlig;er oder gleich sein als das Datum (bis)\n');
define('JS_PRICE_FROM_MUST_BE_NUM', '* \"Preis ab\" muss eine Zahl sein\n\n');
define('JS_PRICE_TO_MUST_BE_NUM', '* \"Preis bis\" muss eine Zahl sein\n\n');
define('JS_PRICE_TO_LESS_THAN_PRICE_FROM', '* \"Preis bis\" muss gr&ouml;sser oder gleich \"Preis ab\" sein.\n');
define('JS_INVALID_KEYWORDS', '* Suchbegriff unzul&auml;ssig\n');
define('TEXT_LOGIN_ERROR', '<font color="#ff0000"><b>FEHLER:</b></font> Keine &Uuml;bereinstimmung der eingegebenen \'E-Mail-Adresse\' und/oder dem \'Passwort\'.');
define('TEXT_NO_EMAIL_ADDRESS_FOUND', '<font color="#ff0000"><b>ACHTUNG:</b></font> Die eingegebene E-Mail-Adresse ist nicht registriert. Bitte versuchen Sie es noch einmal.');
define('TEXT_PASSWORD_SENT', 'Ein neues Passwort wurde per E-Mail verschickt.');
define('TEXT_PRODUCT_NOT_FOUND', 'Artikel wurde nicht gefunden!');
define('TEXT_MORE_INFORMATION', 'F&uuml;r weitere Informationen besuchen Sie bitte die <a href="%s" target="_blank">Homepage</a> zu diesem Artikel.');
define('TEXT_DATE_ADDED', 'Diesen Artikel haben wir am %s in den Shop aufgenommen.');
define('TEXT_DATE_AVAILABLE', 'Dieser Artikel wird voraussichtlich ab dem %s wieder vorr&auml;tig sein.');
define('SUB_TITLE_SUB_TOTAL', 'Zwischensumme:');

define('OUT_OF_STOCK_CANT_CHECKOUT', 'Die mit ' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . ' markierten Artikel sind leider nicht in der von Ihnen gew&uuml;nschten Menge auf Lager.<br />Bitte reduzieren Sie Ihre Bestellmenge f&uuml;r die gekennzeichneten Artikel. Vielen Dank.');
define('OUT_OF_STOCK_CAN_CHECKOUT', 'Die mit ' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . ' markierten Artikel sind leider nicht in der von Ihnen gew&uuml;nschten Menge auf Lager.<br />Die bestellte Menge wird kurzfristig von uns geliefert. Falls Sie es w&uuml;nschen, nehmen wir auch eine Teillieferung vor.');

define('MINIMUM_ORDER_VALUE_NOT_REACHED_1', 'Sie haben den Mindestbestellwert von: ');
define('MINIMUM_ORDER_VALUE_NOT_REACHED_2', ' leider noch nicht erreicht.<br />Bitte bestellen Sie f&uuml;r mindestens weitere: ');
define('MAXIMUM_ORDER_VALUE_REACHED_1', 'Sie haben die H&ouml;chstbestellsumme von: ');
define('MAXIMUM_ORDER_VALUE_REACHED_2', '&uuml;berschritten.<br />Bitte reduzieren Sie Ihre Bestellung um mindestens: ');

define('ERROR_INVALID_PRODUCT', 'Der von Ihnen gew&auml;hlte Artikel wurde nicht gefunden!');


define('NAVBAR_TITLE_ACCOUNT', 'Ihr Konto');
define('NAVBAR_TITLE_1_ACCOUNT_EDIT', 'Ihr Konto');
define('NAVBAR_TITLE_2_ACCOUNT_EDIT', 'Ihre pers&ouml;nliche Daten &auml;ndern');
define('NAVBAR_TITLE_1_ACCOUNT_HISTORY', 'Ihr Konto');
define('NAVBAR_TITLE_2_ACCOUNT_HISTORY', 'Ihre get&auml;tigten Bestellungen');
define('NAVBAR_TITLE_1_ACCOUNT_HISTORY_INFO', 'Ihr Konto');
define('NAVBAR_TITLE_2_ACCOUNT_HISTORY_INFO', 'Get&auml;tigte Bestellung');
define('NAVBAR_TITLE_3_ACCOUNT_HISTORY_INFO', 'Bestellnummer %s');
define('NAVBAR_TITLE_1_ACCOUNT_PASSWORD', 'Ihr Konto');
define('NAVBAR_TITLE_2_ACCOUNT_PASSWORD', 'Passwort &auml;ndern');
define('NAVBAR_TITLE_1_ADDRESS_BOOK', 'Ihr Konto');
define('NAVBAR_TITLE_2_ADDRESS_BOOK', 'Adressbuch');
define('NAVBAR_TITLE_1_ADDRESS_BOOK_PROCESS', 'Ihr Konto');
define('NAVBAR_TITLE_2_ADDRESS_BOOK_PROCESS', 'Adressbuch');
define('NAVBAR_TITLE_ADD_ENTRY_ADDRESS_BOOK_PROCESS', 'Neuer Eintrag');
define('NAVBAR_TITLE_MODIFY_ENTRY_ADDRESS_BOOK_PROCESS', 'Eintrag &auml;ndern');
define('NAVBAR_TITLE_DELETE_ENTRY_ADDRESS_BOOK_PROCESS', 'Eintrag l&ouml;schen');
define('NAVBAR_TITLE_ADVANCED_SEARCH', 'Erweiterte Suche');
define('NAVBAR_TITLE1_ADVANCED_SEARCH', 'Erweiterte Suche');
define('NAVBAR_TITLE2_ADVANCED_SEARCH', 'Suchergebnisse');
define('NAVBAR_TITLE_1_CHECKOUT_CONFIRMATION', 'Kasse');
define('NAVBAR_TITLE_2_CHECKOUT_CONFIRMATION', 'Best&auml;tigung');
define('NAVBAR_TITLE_1_CHECKOUT_PAYMENT', 'Kasse');
define('NAVBAR_TITLE_2_CHECKOUT_PAYMENT', 'Zahlungsweise');
define('NAVBAR_TITLE_1_PAYMENT_ADDRESS', 'Kasse');
define('NAVBAR_TITLE_2_PAYMENT_ADDRESS', 'Rechnungsadresse &auml;ndern');
define('NAVBAR_TITLE_1_CHECKOUT_SHIPPING', 'Kasse');
define('NAVBAR_TITLE_2_CHECKOUT_SHIPPING', 'Versandinformationen');
define('NAVBAR_TITLE_1_CHECKOUT_SHIPPING_ADDRESS', 'Kasse');
define('NAVBAR_TITLE_2_CHECKOUT_SHIPPING_ADDRESS', 'Versandadresse &auml;ndern');
define('NAVBAR_TITLE_1_CHECKOUT_SUCCESS', 'Kasse');
define('NAVBAR_TITLE_2_CHECKOUT_SUCCESS', 'Erfolg');
define('NAVBAR_TITLE_CREATE_ACCOUNT', 'Konto erstellen');

define('NAVBAR_TITLE_LOGOFF','Auf Wiedersehen');
define('NAVBAR_TITLE_PRODUCTS_NEW', 'Neue Artikel');
define('NAVBAR_TITLE_SHOPPING_CART', 'Warenkorb');
define('NAVBAR_TITLE_SPECIALS', 'Angebote');
define('NAVBAR_TITLE_COOKIE_USAGE', 'Cookie-Nutzung');
define('NAVBAR_TITLE_PRODUCT_REVIEWS', 'Bewertungen');
define('NAVBAR_TITLE_REVIEWS_WRITE', 'Bewertungen');
define('NAVBAR_TITLE_REVIEWS','Bewertungen');
define('NAVBAR_TITLE_SSL_CHECK', 'Sicherheitshinweis');
define('NAVBAR_TITLE_CREATE_GUEST_ACCOUNT','Konto erstellen');
define('NAVBAR_TITLE_PASSWORD_DOUBLE_OPT','Passwort vergessen?');
define('NAVBAR_TITLE_NEWSLETTER','Newsletter');
define('NAVBAR_GV_REDEEM', 'Gutschein einl&ouml;sen');
define('NAVBAR_GV_SEND', 'Gutschein versenden');


define('TEXT_NEWSLETTER','Sie m&ouml;chten immer auf dem Laufenden bleiben?<br />Kein Problem, tragen Sie sich in unseren Newsletter ein und Sie sind immer auf dem neuesten Stand.');
define('TEXT_EMAIL_INPUT','Ihre E-Mail-Adresse wurde in unser System eingetragen.<br />Gleichzeitig wurde Ihnen vom System eine E-Mail mit einem Aktivierungslink geschickt. Bitte klicken Sie nach dem Erhalt der E-Mail auf den Link, um Ihre Eintragung zu best&auml;tigen. Ansonsten bekommen Sie keinen Newsletter von uns zugestellt!');

define('TEXT_WRONG_CODE','<font color="#FF0000">Ihr eingegebener Sicherheitscode stimmte nicht mit dem angezeigten Code &uuml;berein. Bitte versuchen Sie es erneut.</font>');
define('TEXT_NO_CHOICE','<font color="#FF0000">Bitte w&auml;hlen Sie eine Option aus (eintragen oder austragen).</font>');
define('TEXT_EMAIL_EXIST_NO_NEWSLETTER','<font color="#FF0000">Diese E-Mail-Adresse existiert bereits in unserer Datenbank, ist aber noch nicht f&uuml;r den Empfang des Newsletters freigeschaltet!</font>');
define('TEXT_EMAIL_EXIST_NEWSLETTER','<font color="#FF0000">Diese E-Mail-Adresse existiert bereits in unserer Datenbank und ist f&uuml;r den Newsletterempfang bereits freigeschaltet!</font>');
define('TEXT_EMAIL_NOT_EXIST','<font color="#FF0000">Diese E-Mail-Adresse existiert nicht in unserer Datenbank!</font>');
define('TEXT_EMAIL_DEL','Ihre E-Mail-Adresse wurde aus unserer Newsletterdatenbank gel&ouml;scht.');
define('TEXT_EMAIL_DEL_ERROR','<font color="#FF0000">Es ist ein Fehler aufgetreten. Ihre E-Mail-Adresse wurde nicht gel&ouml;scht!</font>');
define('TEXT_EMAIL_ACTIVE','Ihre E-Mail-Adresse wurde erfolgreich f&uuml;r den Newsletterempfang freigeschaltet!');
define('TEXT_EMAIL_ACTIVE_ERROR','<font color="#FF0000">Es ist ein Fehler aufgetreten. Ihre eMail-Adresse wurde nicht freigeschaltet!</font>');
define('TEXT_EMAIL_SUBJECT','Ihre Newsletteranmeldung');

define('TEXT_CUSTOMER_GUEST','Gast');

define('TEXT_LINK_MAIL_SENDED','Ihre Anfrage nach einem neuen Passwort muss von Ihnen erst best&auml;tigt werden.<br />Deshalb wurde Ihnen vom System eine E-Mail mit einem Best&auml;tigungslink geschickt. Bitte klicken Sie nach dem Erhalt der E-Mail auf den Link, um eine weitere E-Mail mit Ihrem neuen Anmelde-Passwort zu erhalten. Andernfalls wird Ihnen das neue Passwort nicht zugestellt oder eingerichtet!');
define('TEXT_PASSWORD_MAIL_SENDED','Eine E-Mail mit einem neuen Anmelde-Passwort wurde Ihnen soeben zugestellt.<br />Bitte &auml;ndern Sie nach Ihrer n&auml;chsten Anmeldung das Passwort.');
define('TEXT_CODE_ERROR','Bitte geben Sie Ihre E-Mail-Adresse und den Sicherheitscode erneut ein. <br />Achten Sie dabei auf Tippfehler!');
define('TEXT_EMAIL_ERROR','Bitte geben Sie Ihre E-Mail-Adresse und den Sicherheitscode erneut ein. <br />Achten Sie dabei auf Tippfehler!');
define('TEXT_NO_ACCOUNT','Leider m&uuml;ssen wir Ihnen mitteilen, dass Ihre Anfrage f&uuml;r ein neues Anmelde-Passwort entweder ung&uuml;ltig war oder abgelaufen ist.<br />Bitte versuchen Sie es erneut.');
define('HEADING_PASSWORD_FORGOTTEN','Passwort erneuern?');
define('TEXT_PASSWORD_FORGOTTEN','&Auml;ndern Sie Ihr Passwort in drei Schritten.');

define('TEXT_EMAIL_PASSWORD_FORGOTTEN','Best&auml;tigungs-E-Mail f&uuml;r Passwort&auml;nderung');

define('TEXT_EMAIL_PASSWORD_NEW_PASSWORD','Ihr neues Passwort');
define('ERROR_MAIL','Bitte &uuml;berpr&uuml;fen Sie Ihre eingegebenen Daten im Formular');

define('CATEGORIE_NOT_FOUND','Kategorie wurde nicht gefunden');

define('GV_FAQ', 'Gutschein FAQ');
define('ERROR_NO_REDEEM_CODE', 'Sie haben leider keinen Code eingegeben.');
define('ERROR_NO_INVALID_REDEEM_GV', 'Ung&uuml;ltiger Gutschein-Code');
define('TABLE_HEADING_CREDIT', 'Guthaben');
define('EMAIL_GV_TEXT_SUBJECT', 'Ein Geschenk von %s');
define('MAIN_MESSAGE', 'Sie haben sich dazu entschieden, einen Gutschein im Wert von %s an %s zu versenden, dessen E-Mail-Adresse %s lautet.<br /><br />Folgender Text erscheint in Ihrer E-Mail:<br /><br />Hallo %s,<br /><br />Ihnen wurde ein Gutschein im Wert von %s durch %s geschickt.');
define('REDEEMED_AMOUNT','Ihr Gutschein wurde erfolgreich auf Ihr Konto verbucht. Gutscheinwert:');
define('REDEEMED_COUPON','Ihr Coupon wurde erfolgreich verbucht und wird bei Ihrer n&auml;chsten Bestellung automatisch eingel&ouml;st.');

define('ERROR_INVALID_USES_USER_COUPON','Diesen Kupon k&ouml;nnen Kunden nur ');
define('ERROR_INVALID_USES_COUPON','Sie k&ouml;nnen den Kupon nur ');
define('TIMES',' mal einl&ouml;sen.');
define('ERROR_INVALID_STARTDATE_COUPON','Ihr Kupon ist noch nicht verf&uuml;gbar.');
define('ERROR_INVALID_FINISDATE_COUPON','Ihr Kupon ist bereits abgelaufen.');
define('PERSONAL_MESSAGE', '%s schreibt:');

define('TEXT_CLOSE_WINDOW', 'Fenster schlie&szlig;en.');


define('TEXT_CLOSE_WINDOW', 'Fenster schlie&szlig;en [x]');
define('TEXT_COUPON_HELP_HEADER', 'Ihr Gutschein wurde erfolgreich verbucht.');
define('TEXT_COUPON_HELP_NAME', '<br /><br />Gutscheinbezeichnung: %s');
define('TEXT_COUPON_HELP_FIXED', '<br /><br />Der Gutscheinwert betr&auml;gt %s ');
define('TEXT_COUPON_HELP_MINORDER', '<br /><br />Der Mindestbestellwert betr&auml;gt %s ');
define('TEXT_COUPON_HELP_FREESHIP', '<br /><br />Gutschein f&uuml;r kostenlosen Versand');
define('TEXT_COUPON_HELP_DESC', '<br /><br />Kuponbeschreibung: %s');
define('TEXT_COUPON_HELP_DATE', '<br /><br />Dieser Kupon ist g&uuml;ltig vom %s bis %s');
define('TEXT_COUPON_HELP_RESTRICT', '<br /><br />Artikel / Kategorie Einschr&auml;nkungen');
define('TEXT_COUPON_HELP_CATEGORIES', 'Kategorie');
define('TEXT_COUPON_HELP_PRODUCTS', 'Artikel');

define('ENTRY_VAT_TEXT', '');
define('ENTRY_VAT_ERROR', '<br />Bitte geben Sie eine g&uuml;ltige USt-IdNr. ein oder lassen Sie das Feld leer.');
define('MSRP','UVP');
define('YOUR_PRICE','Ihr Preis ');
define('ONLY',' Nur ');
define('FROM','');
define('YOU_SAVE','Sie sparen ');
define('INSTEAD','Statt ');
define('TXT_PER',' pro ');
define('TAX_INFO_INCL','inkl. %s MwSt.');
define('TAX_INFO_EXCL','zzgl. %s MwSt.');
define('TAX_INFO_ADD','zzgl. %s MwSt.');
define('SHIPPING_EXCL','zzgl. ');
define('SHIPPING_COSTS','Versand');

define('GM_TAX_FREE', 'Kein Steuerausweis gem. Kleinuntern.-Reg. §19 UStG');



define('SHIPPING_TIME','Lieferzeit: ');
define('MORE_INFO','[Mehr]');

define('NAVBAR_TITLE_PAYPAL_CHECKOUT','PayPal-Checkout');


define('GM_OUT_OF_STOCK_NOTIFY_TEXT', 'Verfügbarkeit des Artikels');
define('GM_EBAY_BACK', 'Zur&uuml;ck');
define('GM_EBAY_FORWARD', 'Weiter');
define('GM_REVIEWS_WRONG_CODE', 'Inkorrekter Code!');
define('GM_REVIEWS_VALIDATION', 'Tippen Sie den Sicherheitscode aus der rechten Grafik in das Eingabefeld ab');
define('GM_SHOW_NO_PRICE', 'Nicht k&auml;uflich');
define('GM_SHOW_PRICE_ON_REQUEST', 'Preis auf Anfrage');
define('GM_ORDER_QUANTITY_CHECKER_MIN_ERROR_1', 'Die Mindestbestellmenge von ');
define('GM_ORDER_QUANTITY_CHECKER_MIN_ERROR_2', ' ist nicht erreicht!<br />');
define('GM_ORDER_QUANTITY_CHECKER_GRADUATED_ERROR_1', 'Erlaubt ist nur eine Bestellmenge in ');
define('GM_ORDER_QUANTITY_CHECKER_GRADUATED_ERROR_2', 'er Schritten!');


define('GM_ATTR_STOCK_TEXT_BEFORE', '[verf&uuml;gbar: ');
define('GM_ATTR_STOCK_TEXT_AFTER', ']');

define('GM_CONTACT_ERROR_WRONG_VVCODE','Ihre Sicherheitseingabe stimmt nicht mit dem Code auf der Grafik &uuml;berein'); 

define('GM_ENTRY_EMAIL_ADDRESS_ERROR', 'E-Mail-Adresse existiert bereits.');

define('GM_GIFT_INPUT', 'Gutschein einl&ouml;sen?');

  define('NC_WISHLIST','Merkzettel');
  define('NC_WISHLIST_CONTAINS','Ihr Merkzettel enth&auml;lt:');
  define('NC_WISHLIST_EMPTY','Ihr Merkzettel enth&auml;lt keine Artikel.');
	
define('TEXT_ADD_TO_CART', 'In den Korb');

define('GM_LIGHTBOX_PLEASE_WAIT', 'bitte warten');
define('GM_CONFIRM_CLOSE_LIGHTBOX', 'Wollen Sie den Bestellvorgang wirklich abbrechen und zur Startseite wechseln?');

define('ERROR_CONDITIONS_NOT_ACCEPTED_AGB', '* Sofern Sie unsere Allgemeinen Gesch&auml;ftsbedingungen nicht akzeptieren,\n k&ouml;nnen wir Ihre Bestellung leider nicht entgegennehmen! \n\n');
define('ERROR_CONDITIONS_NOT_ACCEPTED_WITHDRAWAL', '* Sofern Sie unser Widerrufsrecht nicht akzeptieren,\n k&ouml;nnen wir Ihre Bestellung leider nicht entgegennehmen! \n\n');

define('GM_CONFIRMATION_PRIVACY', 'Datenschutzerkl&auml;rung einsehen');
define('GM_CONFIRMATION_CONDITIONS', 'AGB einsehen');
define('GM_CONFIRMATION_WITHDRAWAL', 'Widerrufsrecht einsehen');

define('NAVBAR_TITLE_WISHLIST', 'Merkzettel');

define('ERROR_INVALID_SHIPPING_COUNTRY', 'Der Versand ist in das gew&auml;hlte Versandland nicht m&ouml;glich.');
define('ERROR_INVALID_PAYMENT_COUNTRY', 'Das Land Ihrer Rechnungsadresse ist nicht erlaubt.');

*/

// JS Meldung -> keine HTML-Umlaute!
define('GM_WISHLIST_NOTHING_CHECKED', 'Sie haben keine Artikel ausgewählt, die in den Warenkorb gelegt werden sollen!');
define('JS_ERROR_CONDITIONS_NOT_ACCEPTED_AGB', 'Sofern Sie unsere Allgemeinen Geschäftsbedingungen nicht akzeptieren,\n können wir Ihre Bestellung leider nicht entgegennehmen! \n\n');
define('JS_ERROR_CONDITIONS_NOT_ACCEPTED_WITHDRAWAL', 'Sofern Sie unser Widerrufsrecht nicht akzeptieren,\n können wir Ihre Bestellung leider nicht entgegennehmen! \n\n');

define('GM_PAYPAL_ERROR', '<br />Die Bezahlung per PayPal wurde abgebrochen. Falls Sie nicht per PayPal bezahlen wollen, w&auml;hlen Sie bitte eine andere Zahlungsweise aus.');
define('GM_PAYPAL_SESSION_ERROR', 'Ihre Session ist abgelaufen, bitte f&uuml;hren Sie Ihre Bestellung erneut durch.');
define('GM_PAYPAL_UNALLOWED_COUNTRY_ERROR', 'Das Land der auf der PayPal-Seite gew&auml;hlten Adresse ist in diesem Shop nicht erlaubt.');
// BOF GM_MOD
define('GM_PAYPAL_ERROR_10001', 'PayPal meldet einen internen Error. Bitte versuchen Sie es sp&auml;ter noch einmal.');
define('GM_PAYPAL_ERROR_10422', 'Sie m&uuml;ssen zur PayPal-Website zurückkehren und eine andere Zahlungsmethode auswählen.');
define('GM_PAYPAL_ERROR_10445', 'Diese Transaktion kann zur Zeit nicht bearbeitet werden. Bitte versuchen Sie es sp&auml;ter noch einmal.');
define('GM_PAYPAL_ERROR_10525', 'Diese Transaktion kann nicht verarbeitet werden, da der zu zahlende Betrag null ist. Bitte wenden Sie sich an den Shopbetreiber.');
define('GM_PAYPAL_ERROR_10725', 'Bitte &uuml;berprüfen Sie das Land f&uuml;r die Lieferadresse.');
define('GM_PAYPAL_ERROR_10729', 'Bitte &uuml;berprüfen Sie die Lieferadresse. Der Bundesstaat in der Lieferadresse fehlt.');
define('GM_PAYPAL_ERROR_10736', 'Bitte &uuml;berprüfen Sie die Lieferadresse. Stadt, Bundesland und Postleitzahl stimmen nicht &uuml;berein.');
// PayPal Meldungen sind Umlaute erlaubt
define('PAYPAL_ERROR','PayPal Abbruch');
/// EOF GM_MOD

define('GM_MESSAGE_NO_RESULT', 'Keine entsprechenden Eintr&auml;ge vorhanden.');
define('GM_PAGE', 'Seite');
define('GM_TITLE_EBAY', 'Meine eBay Artikel');
define('TEXT_OPENSEARCH', 'Die Schnell-Suche ist derzeit nur im Internet Explorer 7 und im Mozilla Firefox verf&uuml;gbar.');

define('GM_REVIEWS_TOO_SHORT', 'Ihre Bewertung ist zu kurz. Bitte geben Sie mindestens %s Zeichen ein.');

define('ADMIN_LINK_INFO_TEXT', 'Klicken Sie auf Abbrechen, wenn Sie diesen Link nicht aufrufen, sondern bearbeiten möchten.');

// product_info standard tab-text
define('PRODUCT_DESCRIPTION', 'Artikelbeschreibung');

include(DIR_WS_LANGUAGES . 'german/gm_logger.php');
include(DIR_WS_LANGUAGES . 'german/gm_shopping_cart.php');
include(DIR_WS_LANGUAGES . 'german/gm_account_delete.php');
include(DIR_WS_LANGUAGES . 'german/gm_price_offer.php');
include(DIR_WS_LANGUAGES . 'german/gm_tell_a_friend.php');
include(DIR_WS_LANGUAGES . 'german/gm_callback_service.php');
// EOF GM_MOD
?>