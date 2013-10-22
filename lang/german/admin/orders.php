<?php
/* --------------------------------------------------------------
   orders.php 2012-04-19 misc
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(orders.php,v 1.27 2003/02/16); www.oscommerce.com
   (c) 2003	 nextcommerce (orders.php,v 1.7 2003/08/14); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: orders.php 1308 2005-10-15 14:22:18Z hhgag $)

   Released under the GNU General Public License
   --------------------------------------------------------------*/
define('TEXT_BANK', 'Bankeinzug');
define('TEXT_BANK_OWNER', 'Kontoinhaber:');
define('TEXT_BANK_NUMBER', 'Kontonummer:');
define('TEXT_BANK_BLZ', 'BLZ:');
define('TEXT_BANK_NAME', 'Bank:');
define('TEXT_BANK_FAX', 'Einzugserm&auml;chtigung wird per Fax best&auml;tigt');
define('TEXT_BANK_STATUS', 'Pr&uuml;fstatus:');
define('TEXT_BANK_PRZ', 'Pr&uuml;fverfahren:');
define('TEXT_MARKED_ELEMENTS','Markierte Elemente');

define('TEXT_BANK_ERROR_1', 'Kontonummer stimmt nicht mit BLZ &uuml;berein!');
define('TEXT_BANK_ERROR_2', 'F&uuml;r diese Kontonummer ist kein Pr&uuml;fverfahren definiert!');
define('TEXT_BANK_ERROR_3', 'Kontonummer nicht pr&uuml;fbar! Pr&uuml;fverfahren nicht implementiert');
define('TEXT_BANK_ERROR_4', 'Kontonummer technisch nicht pr&uuml;fbar!');
define('TEXT_BANK_ERROR_5', 'Bankleitzahl nicht gefunden!');
define('TEXT_BANK_ERROR_8', 'Keine Bankleitzahl angegeben!');
define('TEXT_BANK_ERROR_9', 'Keine Kontonummer angegeben!');
define('TEXT_BANK_ERRORCODE', 'Fehlercode:');

define('HEADING_TITLE', 'Bestellungen');
define('HEADING_TITLE_SEARCH', 'Bestell-Nr.:');
define('HEADING_TITLE_STATUS', 'Status:');

define('HEADING_SUB_TITLE', 'Kunden');

define('TABLE_HEADING_COMMENTS', 'Kommentar');
define('TABLE_HEADING_CUSTOMERS', 'Kunde');
define('TABLE_HEADING_ORDER_TOTAL', 'Gesamtwert');
define('TABLE_HEADING_DATE_PURCHASED', 'Bestelldatum');
define('TABLE_HEADING_STATUS', 'Status');
define('TABLE_HEADING_ACTION', 'Aktion');
define('TABLE_HEADING_QUANTITY', 'Anzahl');
define('TABLE_HEADING_PRODUCTS_MODEL', 'Artikel-Nr.');
define('TABLE_HEADING_PRODUCTS', 'Artikel');
define('TABLE_HEADING_TAX', 'MwSt.');
define('TABLE_HEADING_TOTAL', 'Gesamtsumme');
define('TABLE_HEADING_STATUS', 'Status');
define('TABLE_HEADING_PRICE_EXCLUDING_TAX', 'Preis (exkl.)');
define('TABLE_HEADING_PRICE_INCLUDING_TAX', 'Preis (inkl.)');
define('TABLE_HEADING_TOTAL_EXCLUDING_TAX', 'Total (exkl.)');
define('TABLE_HEADING_TOTAL_INCLUDING_TAX', 'Total');
define('TABLE_HEADING_AFTERBUY','Afterbuy');

define('TABLE_HEADING_STATUS', 'Status');
define('TABLE_HEADING_CUSTOMER_NOTIFIED', 'Kunde benachrichtigt');
define('TABLE_HEADING_DATE_ADDED', 'hinzugef&uuml;gt am:');

define('ENTRY_CUSTOMER', 'Kunde:');
define('ENTRY_SOLD_TO', 'Rechnungsadresse:');
define('ENTRY_STREET_ADDRESS', 'Stra&szlig;e:');
define('ENTRY_SUBURB', 'zus. Anschrift:');
define('ENTRY_CITY', 'Stadt:');
define('ENTRY_POST_CODE', 'PLZ:');
define('ENTRY_STATE', 'Bundesland:');
define('ENTRY_COUNTRY', 'Land:');
define('ENTRY_TELEPHONE', 'Telefon:');
define('ENTRY_EMAIL_ADDRESS', 'E-Mail:');
define('ENTRY_DELIVERY_TO', 'Lieferanschrift:');
define('ENTRY_SHIP_TO', 'Lieferanschrift:');
define('ENTRY_SHIPPING_ADDRESS', 'Versandadresse:');
define('ENTRY_BILLING_ADDRESS', 'Rechnungsadresse:');
define('ENTRY_PAYMENT_METHOD', 'Zahlungsweise:');
define('ENTRY_CREDIT_CARD_TYPE', 'Kreditkartentyp:');
define('ENTRY_CREDIT_CARD_OWNER', 'Kreditkarteninhaber:');
define('ENTRY_CREDIT_CARD_NUMBER', 'Kerditkartennnummer:');
define('ENTRY_CREDIT_CARD_CVV', 'Sicherheitscode (CVV)):');
define('ENTRY_CREDIT_CARD_EXPIRES', 'Kreditkarte l&auml;uft ab am:');
define('ENTRY_SUB_TOTAL', 'Zwischensumme:');
define('ENTRY_TAX', 'MwSt.:');
define('ENTRY_SHIPPING', 'Versandkosten:');
define('ENTRY_TOTAL', 'Gesamtsumme:');
define('ENTRY_DATE_PURCHASED', 'Bestelldatum:');
define('ENTRY_STATUS', 'Status:');
define('ENTRY_DATE_LAST_UPDATED', 'zuletzt aktualisiert am:');
define('ENTRY_NOTIFY_CUSTOMER', 'Kunde benachrichtigen');
define('ENTRY_NOTIFY_COMMENTS', 'Kommentare mitsenden');
define('ENTRY_PRINTABLE', 'Rechnung drucken');

define('TEXT_INFO_HEADING_DELETE_ORDER', 'Bestellung l&ouml;schen');
define('TEXT_INFO_DELETE_INTRO', 'Sind Sie sicher, das Sie diese Bestellung l&ouml;schen m&ouml;chten?');
define('TEXT_INFO_RESTOCK_PRODUCT_QUANTITY', 'Artikelanzahl dem Lager gutschreiben');
define('TEXT_DATE_ORDER_CREATED', 'erstellt am:');
define('TEXT_DATE_ORDER_LAST_MODIFIED', 'letzte &Auml;nderung:');
define('TEXT_INFO_PAYMENT_METHOD', 'Zahlungsweise:');
define('TEXT_INFO_RESHIPP', 'Lieferstatus neu berechnen');

define('TEXT_ALL_ORDERS', 'Alle Bestellungen');
define('TEXT_NO_ORDER_HISTORY', 'Keine Bestellhistorie verf&uuml;gbar');

define('EMAIL_SEPARATOR', '------------------------------------------------------');
define('EMAIL_TEXT_SUBJECT', 'Status&auml;nderung Ihrer Bestellung');
define('EMAIL_TEXT_ORDER_NUMBER', 'Bestell-Nr.:');
define('EMAIL_TEXT_INVOICE_URL', 'Ihre Bestellung k&ouml;nnen Sie unter folgender Adresse einsehen:');
define('EMAIL_TEXT_DATE_ORDERED', 'Bestelldatum:');
define('EMAIL_TEXT_STATUS_UPDATE', 'Der Status Ihrer Bestellung wurde aktualisiert.' . "\n\n" . 'Neuer Status: %s' . "\n\n" . 'Bei Fragen zu Ihrer Bestellung antworten Sie bitte auf diese E-Mail.' . "\n\n" . 'Mit freundlichen Gr&uuml;&szlig;en' . "\n");
define('EMAIL_TEXT_COMMENTS_UPDATE', 'Anmerkungen und Kommentare zu Ihrer Bestellung:' . "\n\n%s\n\n");

define('ERROR_ORDER_DOES_NOT_EXIST', 'Fehler: Die Bestellung existiert nicht!.');
define('SUCCESS_ORDER_UPDATED', 'Erfolg: Die Bestellung wurde erfolgreich aktualisiert.');
define('WARNING_ORDER_NOT_UPDATED', 'Hinweis: Es wurde nichts ge&auml;ndert. Daher wurde diese Bestellung nicht aktualisiert.');

define('TABLE_HEADING_DISCOUNT','Rabatt');
define('ENTRY_CUSTOMERS_GROUP','Kundengruppe:');
define('TEXT_VALIDATING','Nicht best&auml;tigt');
//zmb
// ClickandBuy
define('HEADING_CLICKANDBUY_V2_EMS', 'ClickandBuy EMS Events');
define('TABLE_HEADING_CLICKANDBUY_V2_EMS_TIMESTAMP', 'Zeitstempel');
define('TABLE_HEADING_CLICKANDBUY_V2_EMS_TYPE', 'Art');
define('TABLE_HEADING_CLICKANDBUY_V2_EMS_ACTION', 'Ereignis');
define('TEXT_CLICKANDBUY_V2_EMS_NO_EVENTS', 'Keine EMS-Events.');
// /ClickandBuy
//zmb
/* BOF GM*/
define('TABLE_HEADING_GM_STATUS', 'Status');
define('TEXT_GM_STATUS', 'Status &auml;ndern');
define('HEADING_GM_STATUS', 'Bestellstatus f&uuml;r mehrere Bestellungen gleichzeitig &auml;ndern');
define('TITLE_ORDER', 'Bestellbest&auml;tigung anzeigen');
define('TITLE_RECREATE_ORDER', 'Bestellbest&auml;tigung neu generieren');
define('TITLE_SEND_ORDER', 'E-Mail Bestellbest&auml;tigung');
define('TITLE_ORDERS_BILLING_CODE', 'Rechnungsnummer');
define('TITLE_PACKINGS_BILLING_CODE', 'Lieferscheinnummer');
define('TITLE_INVOICE', 'Rechnung');
define('TITLE_INVOICE_MAIL', 'E-Mail Rechnung');
define('TITLE_PACKINGSLIP', 'Lieferschein');
define('GM_PRODUCTS', 'Produkt(e)');
define('GM_ORDERS_EDIT_CLOCK', ' Uhr');
define('GM_ORDERS_NUMBER', 'Bestellung Nr.: ');
define('GM_MAIL', 'E-Mail:');
define('TITLE_GIFT_MAIL', 'E-Mail Gutschein');
define('TITLE_BANK_INFO', 'Banktransfer');
define('TITLE_CC_INFO', 'Kreditkarteninfo');
define('TITLE_CUSTOMER_ID', 'Kundennr.:');
define('TABLE_HEADING_PAYPAL', 'Paypal');

define('GM_SEND_ORDER_STATUS_MONO', 'Die unten fett markierte Bestellung hat noch keine E-Mail Bestellbest&auml;tigung erhalten!');
define('GM_SEND_ORDER_STATUS_STEREO', 'Die unten fett markierten Bestellungen haben noch keine E-Mail Bestellbest&auml;tigung erhalten!');

define('BUTTON_GM_CANCEL', 'Stornieren');

define('BUTTON_EKOMI_SEND_MAIL', 'eKomi-E-Mail senden');
define('EKOMI_SEND_MAIL_SUCCESS', 'Die eKomi-E-Mail wurde erfolgreich versendet.');
define('EKOMI_ALREADY_SEND_MAIL_ERROR', 'Die eKomi-E-Mail wurde nicht versendet, da sie bereits in der Vergangenheit versendet wurde.');
define('EKOMI_SEND_MAIL_ERROR', 'Die eKomi-E-Mail wurde nicht versendet, da technische Probleme aufgetreten sind. Informationen dazu finden Sie in der ekomi-errors-Logdatei im export-Ordner.');
define('TEXT_PPNOTIFICATION_LOADING','Die PayPal Zahlungsinformationen werden geladen.<br />Der Ladevorgang bricht nach ca. 60 Sekunden ab.<br />Bitte beachten Sie in diesem Fall den Hinweis an dieser Stelle.');
define('TEXT_PPNOTIFICATION_ERROR','Es liegt ein Verbindungsproblem zu PayPal vor.<br />Die Zahlungsinformationen k&ouml;nnen nicht geladen werden.<br />Bitte versuchen Sie es sp&auml;ter noch einmal.');
define('BUTTON_PP_RELOAD', 'neu laden');
/* EOF GM*/
?>
