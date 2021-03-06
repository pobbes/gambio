<?php
/* --------------------------------------------------------------
   orders_edit.php 2011-06-09 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

$Id: orders_edit.php,v 1.0

   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com 
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(orders.php,v 1.27 2003/02/16); www.oscommerce.com 
   (c) 2003	 nextcommerce (orders.php,v 1.7 2003/08/14); www.nextcommerce.org

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

// Allgemeine Texte
define('TABLE_HEADING', 'Bestelldaten bearbeiten');

define('HEADING_WARNING', '<br /><strong><font face="arial" style="font-size: 11px"><font color="#FF0000">ACHTUNG:</font> Bitte beachten Sie, dass das Modul zur manuellen Bestellnachbearbeitung unter Umst&auml;nden nicht korrekt arbeitet. Bitte &uuml;berpr�fen Sie alle errechneten Werte auf deren Korrektheit.</strong></font><br /><br />');

define('TABLE_HEADING_ORDER', 'Bestellung Nr:&nbsp;');
define('TEXT_SAVE_ORDER', 'Nachbearbeitung beenden und Bestellung neu berechnen.');

define('TEXT_EDIT_ADDRESS', 'Adressdaten und Kundendaten bearbeiten und einf&uuml;gen.');
define('TEXT_EDIT_PRODUCTS', 'Artikel und Artikeloptionen bearbeiten und einf&uuml;gen.');
define('TEXT_EDIT_OTHER', 'Versandarten, Zahlungsweisen, W&auml;hrungen, Sprachen usw. bearbeiten und einf&uuml;gen.');

define('IMAGE_EDIT_ADDRESS', 'Adressen bearbeiten oder einf&uuml;gen');
define('IMAGE_EDIT_PRODUCTS', 'Artikel und Optionen bearbeiten oder einf&uuml;gen');
define('IMAGE_EDIT_OTHER', 'Versandarten, Zahlungsweisen, Gutscheine usw. bearbeiten oder einf&uuml;gen');

// Adress�nderung
define('TEXT_INVOICE_ADDRESS', 'Kundenadresse');
define('TEXT_SHIPPING_ADDRESS', 'Versandadresse');
define('TEXT_BILLING_ADDRESS', 'Rechnungsadresse');


define('TEXT_COMPANY', 'Firma:');
define('TEXT_NAME', 'Name:');
define('TEXT_STREET', 'Stra&szlig;e');
define('TEXT_ZIP', 'PLZ:');
define('TEXT_CITY', 'Stadt:');
define('TEXT_COUNTRY', 'Land:');
define('TEXT_CUSTOMER_GROUP', 'Kundengruppe in der Bestellung');
define('TEXT_CUSTOMER_EMAIL', 'E-Mail:');
define('TEXT_CUSTOMER_TELEPHONE', 'Telefon:');
define('TEXT_CUSTOMER_UST', 'USt-IdNr.:');

// Artikelbearbeitung

define('TEXT_EDIT_GIFT', 'Gutscheine und Rabatt bearbeiten oder einf&uuml;gen');
define('TEXT_EDIT_ADDRESS_SUCCESS', 'Adress&auml;nderung wurde gespeichert.');
define('TEXT_SMALL_NETTO', ' (netto)');
define('TEXT_PRODUCT_ID', 'pID');
define('TEXT_PRODUCTS_MODEL', 'Art.Nr.');
define('TEXT_QUANTITY', 'Anzahl');
define('TEXT_PRODUCT', 'Artikel');
define('TEXT_TAX', 'MwSt.');
define('TEXT_PRICE', 'Preis');
define('TEXT_FINAL', 'Gesamt');
define('TEXT_PRODUCT_SEARCH', 'Artikelsuche');

define('TEXT_PRODUCT_OPTION', 'Artikelmerkmal');
define('TEXT_PRODUCT_OPTION_VALUE', 'Optionswert');
define('TEXT_PRICE', 'Preis');
define('TEXT_PRICE_PREFIX', 'Preis-Pr&auml;fix');

// Sonstiges

define('TEXT_PAYMENT', 'Zahlungsweise');
define('TEXT_SHIPPING', 'Versandart');
define('TEXT_LANGUAGE', 'Sprache');
define('TEXT_CURRENCIES', 'W&auml;hrungen');
define('TEXT_ORDER_TOTAL', 'Zusammenfassung');
define('TEXT_SAVE', 'Speichern');
define('TEXT_ACTUAL', 'Aktuell: ');
define('TEXT_NEW', 'Neu: ');
define('TEXT_PRICE', 'Kosten: ');
define('TEXT_ACTUAL', 'aktuell:');
define('TEXT_NEW', 'neu:');
?>