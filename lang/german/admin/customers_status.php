<?php
/* --------------------------------------------------------------
   customers_status.php 2010-08-17 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(customers.php,v 1.76 2003/05/04); www.oscommerce.com 
   (c) 2003	 nextcommerce (customers_status.php,v 1.12 2003/08/14); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: customers_status.php 1062 2005-07-21 19:57:29Z gwinger $)

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'Kundengruppen');

define('ENTRY_CUSTOMERS_FSK18','Kauf von FSK18 Artikeln verbieten:');
define('ENTRY_CUSTOMERS_FSK18_DISPLAY','Anzeige von FSK18 Artikeln:');
define('ENTRY_CUSTOMERS_STATUS_ADD_TAX','MwSt. in Rechnung ausweisen:');
define('ENTRY_CUSTOMERS_STATUS_MIN_ORDER','Mindestbestellwert:');
define('ENTRY_CUSTOMERS_STATUS_MAX_ORDER','H&ouml;chstbestellwert:');
define('ENTRY_CUSTOMERS_STATUS_BT_PERMISSION','Per Bankeinzug');
define('ENTRY_CUSTOMERS_STATUS_CC_PERMISSION','Per Kreditkarte');
define('ENTRY_CUSTOMERS_STATUS_COD_PERMISSION','Per Nachnahme');
define('ENTRY_CUSTOMERS_STATUS_DISCOUNT_ATTRIBUTES','obigen Rabatt auch auf Artikelattribute anwenden:');
define('ENTRY_CUSTOMERS_STATUS_PAYMENT_UNALLOWED','Geben Sie unerlaubte Zahlungsweisen ein<br />(z. B.: banktransfer,cod,paypal):');
define('ENTRY_CUSTOMERS_STATUS_PUBLIC','Kundengruppe einsehbar:');
define('ENTRY_CUSTOMERS_STATUS_SHIPPING_UNALLOWED','Geben Sie unerlaubte Versandarten ein<br />(z. B.: flat,table):<br />');
define('ENTRY_CUSTOMERS_STATUS_SHOW_PRICE','Preisanzeige:');
define('ENTRY_CUSTOMERS_STATUS_SHOW_PRICE_TAX','Preise:');
define('ENTRY_CUSTOMERS_STATUS_WRITE_REVIEWS','Kundengruppe darf Artikel bewerten:');
define('ENTRY_CUSTOMERS_STATUS_READ_REVIEWS','Kundengruppe darf Artikelbewertungen lesen:');
define('ENTRY_CUSTOMERS_STATUS_BASE','Preise dieser Kundengruppe werden f&uuml;r die neue genutzt. W&auml;hlen Sie Admin, wenn keine Preise gesetzt werden sollen.');
define('ENTRY_GRADUATED_PRICES','Staffelpreise aktivieren:');
define('ENTRY_NO','Nein');
define('ENTRY_OT_XMEMBER', 'Kundenrabatt auf Gesamtbestellwert:');
define('ENTRY_YES','Ja');
define('TEXT_MARKED_ELEMENTS','Markiertes Element');

define('ERROR_REMOVE_DEFAULT_CUSTOMER_STATUS', 'Fehler: Die Standard-Kundengruppe kann nicht gel&ouml;scht werden. Bitte legen Sie zuerst eine andere Standard-Kundengruppe an und versuchen Sie es erneut.');
define('ERROR_REMOVE_DEFAULT_CUSTOMERS_STATUS','ACHTUNG: Eine Standard-Kundengruppe kann nicht gel&ouml;scht werden.');
define('ERROR_STATUS_USED_IN_CUSTOMERS', 'Fehler: Diese Kundengruppe ist zurzeit bei Kunden in Verwendung.');
define('ERROR_STATUS_USED_IN_HISTORY', 'Fehler: Diese Kundengruppe wird zurzeit in der Bestell&uuml;bersicht verwendet.');

define('YES','ja');
define('NO','nein');

define('TABLE_HEADING_ACTION','Aktion');
define('TABLE_HEADING_CUSTOMERS_GRADUATED','Staffel Preis');
define('TABLE_HEADING_CUSTOMERS_STATUS','Kundengruppe');
define('TABLE_HEADING_CUSTOMERS_UNALLOW','unerlaubte Zahlungsart');
define('TABLE_HEADING_CUSTOMERS_UNALLOW_SHIPPING','unerlaubte Versandart');
define('TABLE_HEADING_DISCOUNT','Rabatt');
define('TABLE_HEADING_TAX_PRICE','MwSt');

define('TAX_NO','exkl.');
define('TAX_YES','inkl.');

define('TEXT_DISPLAY_NUMBER_OF_CUSTOMERS_STATUS', 'Vorhandene Kundengruppen:');

define('TEXT_INFO_CUSTOMERS_FSK18_DISPLAY_INTRO','<b>FSK18 Artikel</b>');
define('TEXT_INFO_CUSTOMERS_FSK18_INTRO','<b>FSK18 Sperre</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_ADD_TAX_INTRO','<b>Soll MwSt. in Rechnung ausgewiesen werden, wenn Preise exkl. MwSt. angezeigt werden?</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_MIN_ORDER_INTRO','Tragen Sie einen Mindestbestellwert ein oder lassen Sie dieses Feld leer.');
define('TEXT_INFO_CUSTOMERS_STATUS_MAX_ORDER_INTRO','Tragen Sie einen H&ouml;chstbestellwert ein oder lassen Sie dieses Feld leer.');
define('TEXT_INFO_CUSTOMERS_STATUS_BT_PERMISSION_INTRO', '<b>M&ouml;chten Sie erlauben, dass diese Kundengruppe per Bankeinzug bezahlen darf?</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_CC_PERMISSION_INTRO', '<b>M&ouml;chten Sie erlauben, dass diese Kundengruppe per Kreditkarte bezahlen darf?</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_COD_PERMISSION_INTRO', '<b>M&ouml;chten Sie erlauben, dass diese Kundengruppe per Nachnahme bezahlen darf?</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_ATTRIBUTES_INTRO','<b>Rabatt auf Artikel-Attribute</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_OT_XMEMBER_INTRO','<b>Rabatt auf gesamte Bestellung</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_PRICE', 'Rabatt (0 bis 100%):');
define('TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_PRICE_INTRO', 'Maximaler Rabatt auf Artikel (abh&auml;ngig vom eingetragenen Rabatt in der Artikelbearbeitung).');
define('TEXT_INFO_CUSTOMERS_STATUS_GRADUATED_PRICES_INTRO','<b>Staffelpreise</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_IMAGE', 'Kundengruppen-Bild:');
define('TEXT_INFO_CUSTOMERS_STATUS_NAME','<b>Kundengruppenname</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_PAYMENT_UNALLOWED_INTRO','<b>Nicht erlaubte Zahlungsweisen</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_PUBLIC_INTRO','<b>Kunde sieht seine Kundengruppe in Kundengruppen-Box?</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_SHIPPING_UNALLOWED_INTRO','<b>Nicht erlaubte Versandarten</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_SHOW_PRICE_INTRO','<b>Preisanzeige im Shop</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_SHOW_PRICE_TAX_INTRO', 'M&ouml;chten Sie die Preise inklusive oder exklusive Steuer anzeigen?');
define('TEXT_INFO_CUSTOMERS_STATUS_WRITE_REVIEWS_INTRO','<b>Artikelbewertungen schreiben</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_READ_REVIEWS_INTRO', '<b>Artikelbewertungen lesen</b>');

define('TEXT_INFO_DELETE_INTRO', 'Sind Sie sicher, dass Sie diese Kundengruppe l&ouml;schen wollen?');
define('TEXT_INFO_EDIT_INTRO', 'Bitte nehmen Sie alle n&ouml;tigen Einstellungen vor.');
define('TEXT_INFO_INSERT_INTRO', 'Bitte erstellen Sie eine neue Kundengruppe mit den gew&uuml;nschten Einstellungen.');

define('TEXT_INFO_HEADING_DELETE_CUSTOMERS_STATUS', 'Kundengruppe l&ouml;schen');
define('TEXT_INFO_HEADING_EDIT_CUSTOMERS_STATUS','Kundengruppendaten bearbeiten');
define('TEXT_INFO_HEADING_NEW_CUSTOMERS_STATUS', 'Neue Kundengruppe');

define('TEXT_INFO_CUSTOMERS_STATUS_BASE', '<b>Basis-Kundengruppe f&uuml;r Artikelpreise</b>');

include(DIR_FS_LANGUAGES . $_SESSION['language'] . '/admin/gm_customers_status.php');
?>