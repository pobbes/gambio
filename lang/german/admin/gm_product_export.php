<?php
/* --------------------------------------------------------------
   gm_product_export.php 2012-06-01 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License
   --------------------------------------------------------------
*/
?><?php

define('HEADING_TITLE', 'Artikelexport');
define('HEADING_SUB_TITLE','Gambio');
define('MODULE_NAME' , '<strong>Anbieter</strong>');
define('MODULE_TYPE' , '<strong>Typ</strong>');
define('MODULE_INFO' , '<strong>Informationen</strong>');
define('MODULE_FILE_TITLE' , '<strong>Dateiname</strong>');
define('MODULE_FILE_DESC' , 'Geben Sie einen Dateinamen ein, unter welchem die Exportadatei auf Ihrem Server gespeichert werden soll.<br />(Verzeichnis export/)');
define('MODULE_STATUS_DESC','Modulstatus');
define('MODULE_STATUS_TITLE','Status');
define('MODULE_CURRENCY_TITLE','W&auml;hrung');
define('MODULE_CURRENCY_DESC','Welche W&auml;hrung soll exportiert werden?');
define('EXPORT_YES','speichern und herunterladen');
define('EXPORT_NO','speichern');
define('CURRENCY','<strong>W&auml;hrung</strong>');
define('CURRENCY_DESC','W&auml;hrung in der Exportdatei');
define('EXPORT','Bitte den Sicherungsprozess AUF KEINEN FALL unterbrechen. Dieser kann einige Minuten in Anspruch nehmen.');
define('EXPORT_TYPE','<strong>Speicherart</strong>');
define('EXPORT_STATUS_TYPE','<strong>Kundengruppe</strong>');
define('EXPORT_STATUS','Bitte w&auml;hlen Sie die Kundengruppe, die Basis f&uuml;r den Exportierten Preis bildet. (Falls Sie keine Kundengruppenpreise haben, w&auml;hlen Sie <i>Gast</i>):</strong>');
define('CAMPAIGNS','<strong>Kampagnen</strong>');
define('CAMPAIGNS_DESC','Mit Kampagne zur Nachverfolgung verbinden.');
define('DATE_FORMAT_EXPORT', '%d.%m.%Y');  // this is used for strftime()
define('SHIPPING_COSTS_DESC', 'Pauschale (z. B. 2.90)');
define('SHIPPING_COSTS_TITLE', '<strong>Versandkosten</strong>');
define('SHIPPING_COSTS_FREE_DESC', 'geben Sie an, ab welchem Warenwert der Versand kostenfrei erfolgen soll');
define('SHIPPING_COSTS_FREE_TITLE', '<strong>Versandkostenfrei</strong>');
define('EXPORT_ATTRIBUTES', '<strong>Attributexport</strong>');
define('EXPORT_ATTRIBUTES_DESC', 'Jede Artikelvariation wird als eigenständiger Artikel exportiert');
define('CRONJOB', '<strong>Automatik-Export</strong>');
define('CRONJOB_DESC', 'ja, Modul f&uuml;r zeitgesteuerten Export (Cronjob) freigeben');
define('STOCK', '<strong>Lagerbestand</strong>');
define('STOCK_DESC', 'exportieren, wenn Lagerbestand >= Eingabe ist; bei "0" als Eingabe alle Artikel');
define('XML', '<strong>XML-Export</strong>');
define('XML_DESC', 'ja, auch eine XML Datei erzeugen');
 
define('ADD_VPE_TO_NAME', 'Grundpreis im Namen');
define('ADD_VPE_TO_NAME_NO', 'nein');
define('ADD_VPE_TO_NAME_PREFIX', 'davor');
define('ADD_VPE_TO_NAME_SUFFIX', 'danach');
define('ADD_VPE_TO_NAME_DESC', 'Soll der Grundpreis an den Artikelnamen angeh&auml;ngt werden?');

define('GM_PRODUCT_EXPORT_OFFERER', 'Anbieter');
define('GM_PRODUCT_EXPORT_COMPARISON', 'Preisvergleiche');
define('GM_PRODUCT_EXPORT_SHOPPING_PORTALS', 'Shopping Portale');
define('GM_PRODUCT_EXPORT_MORE_INFORMATION', 'weitere Informationen');
define('GM_PRODUCT_EXPORT_SUCCESS', 'CSV-Export erfolgreich erstellt: ');
define('GM_PRODUCT_SAVE_SUCCESS', 'Konfiguration gespeichert.');
?>