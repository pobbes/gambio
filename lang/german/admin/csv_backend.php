<?php
/* --------------------------------------------------------------
   csv_backend.php 2008-11-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

$Id: cvs_backend.php

   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com 

   Released under the GNU General Public License
   --------------------------------------------------------------*/


   define('TITLE','CSV Backend');

   define('IMPORT','Import');
   define('EXPORT','Export');
   define('UPLOAD','Datei hochladen');
   define('SELECT','Import-Datei ausw&auml;hlen <br />(/import Verzeichnis)');
   define('SAVE','Auf Server Speichern (/export Verzeichnis)');
   define('LOAD','Datei an Browser senden');
   define('CSV_TEXTSIGN_TITLE','Texterkennungszeichen');
   define('CSV_TEXTSIGN_DESC','z. B. &quot; (Empfehlung: kein Texterkennungszeichen)');
   define('CSV_SEPERATOR_TITLE','Trennzeichen');
   define('CSV_SEPERATOR_DESC','z. B. | (Empfehlung: | oder ein anderes nicht in den exportieren Daten vorkommendes Zeichen)');
   define('COMPRESS_EXPORT_TITLE','Komprimierung');
   define('COMPRESS_EXPORT_DESC','Komprimierung der exportierten Daten (Empfehlung: Nein)');
   define('CSV_SETUP','Einstellungen');
   define('TEXT_IMPORT','');
   define('TEXT_PRODUCTS','Artikel');
   define('TEXT_EXPORT','Im /export Verzeichnis speichern');

   define('GM_CSV_DELETE_PRODUCTS', '&nbsp;Alle im Shop vorhandenen Artikel unwiderruflich vor dem CSV-Import l&ouml;schen?');
   define('GM_CSV_DELETE_IMAGES', '&nbsp;Alle im Shop vorhandenen Artikelbild-Zuordnungen unwiderruflich vor dem CSV-Import l&ouml;schen?');
   define('GM_CSV_DELETE_CATEGORIES', '&nbsp;Alle im Shop vorhandenen Kategorien unwiderruflich vor dem CSV-Import l&ouml;schen?');
   define('GM_CSV_DELETE_MANUFACTURERS', '&nbsp;Alle im Shop vorhandenen Hersteller unwiderruflich vor dem CSV-Import l&ouml;schen?');
   define('GM_CSV_DELETE_REVIEWS', '&nbsp;Alle im Shop vorhandenen Artikelbewertungen unwiderruflich vor dem CSV-Import l&ouml;schen?');
   define('GM_CSV_DELETE_ATTRIBUTES', '&nbsp;Alle im Shop vorhandenen Artikel-Attributzuweisungen unwiderruflich vor dem CSV-Import l&ouml;schen?');
   define('GM_CSV_DELETE_XSELL', '&nbsp;Alle im Shop vorhandenen Cross-Selling-Artikel und -Gruppen unwiderruflich vor dem CSV-Import l&ouml;schen?');
   define('GM_CSV_DELETE_SPECIALS', '&nbsp;Alle im Shop vorhandenen Sonderangebote unwiderruflich vor dem CSV-Import l&ouml;schen?');
   
?>