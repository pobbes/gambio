<?php
/* --------------------------------------------------------------
   content_manager.php 2008-11-13 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2003	 nextcommerce (content_manager.php,v 1.8 2003/08/25); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: content_manager.php 899 2005-04-29 02:40:57Z hhgag $)
   
   Released under the GNU General Public License 
   --------------------------------------------------------------*/
   
define('HEADING_TITLE','Content Manager');

// BOF GM_MOD
define('HEADING_SUB_TITLE', 'Hilfsprogramme');
// EOF GM_MOD

define('HEADING_CONTENT','Seiten Content');
define('HEADING_PRODUCTS_CONTENT','Artikel Content');
define('TABLE_HEADING_CONTENT_ID','Link ID');
define('TABLE_HEADING_CONTENT_TITLE','Titel');
define('TABLE_HEADING_CONTENT_FILE','Datei');
define('TABLE_HEADING_CONTENT_STATUS','In Box<br/> sichtbar');
define('TABLE_HEADING_CONTENT_BOX','Box');
define('TABLE_HEADING_PRODUCTS_ID','ID');
define('TABLE_HEADING_PRODUCTS','Artikel');
define('TABLE_HEADING_PRODUCTS_CONTENT_ID','ID');
define('TABLE_HEADING_LANGUAGE','Sprache');
define('TABLE_HEADING_CONTENT_NAME','Name/Dateiname');
define('TABLE_HEADING_CONTENT_LINK','Link');
define('TABLE_HEADING_CONTENT_HITS','Hits');
define('TABLE_HEADING_CONTENT_GROUP','Gruppe');
define('TABLE_HEADING_CONTENT_SORT','Reihen- folge');
define('TEXT_YES','Ja');
define('TEXT_NO','Nein');
define('TABLE_HEADING_CONTENT_ACTION','Aktion');
define('TEXT_DELETE','L&ouml;schen');
define('TEXT_EDIT','Bearbeiten');
define('TEXT_PREVIEW','Vorschau');
define('CONFIRM_DELETE','Wollen Sie den Content wirklich l&ouml;schen ?');
define('CONTENT_NOTE','Content markiert mit <font color="#ff0000">*</font> geh&ouml;rt zum System und kann nicht gel&ouml;scht werden!');


// edit
define('TEXT_LANGUAGE','Sprache:');
define('TEXT_STATUS','sichtbar:');
define('TEXT_STATUS_DESCRIPTION','wenn ausgew&auml;hlt, wird Link bzw. Zusatzbox zum Content angezeigt');
define('TEXT_TITLE','Titel:');
define('TEXT_TITLE_FILE','Titel/Dateiname:');
define('TEXT_SELECT','-Bitte w&auml;hlen-');
define('TEXT_HEADING','&Uuml;berschrift:');
define('TEXT_CONTENT','Text:');
define('TEXT_UPLOAD_FILE','Datei hochladen:');
define('TEXT_UPLOAD_FILE_LOCAL','(von Ihrem lokalen System)');
define('TEXT_CHOOSE_FILE','Datei w&auml;hlen:');
define('TEXT_CHOOSE_FILE_DESC','Sie k&ouml;nnen ebenfals eine bereits verwendete Datei aus der Liste ausw&auml;hlen.');
define('TEXT_NO_FILE','Auswahl l&ouml;schen');
define('TEXT_CHOOSE_FILE_SERVER','(Falls Sie Ihre Dateien selbst via FTP auf ihren Server gespeichert haben <i>(media/content)</i>, k&ouml;nnen Sie hier die Datei ausw&auml;hlen.');
define('TEXT_CURRENT_FILE','Aktuelle Datei:');
define('TEXT_FILE_DESCRIPTION','<b>Info:</b><br />Sie haben ebenfalls die M&ouml;glichkeit eine <b>.html</b> oder <b>.htm</b> Datei als Content einzubinden.<br /> Falls Sie eine Datei ausw&auml;hlen oder hochladen, wird der Text im Textfeld ignoriert.<br /><br />');
define('ERROR_FILE','Falsches Dateiformat (nur .html oder .htm)');
define('ERROR_TITLE','Bitte geben Sie einen Titel ein!');
define('ERROR_COMMENT','Bitte geben Sie eine Dateibeschreibung ein!');
define('TEXT_FILE_FLAG','Box:');
define('TEXT_PARENT','Hauptdokument:');
define('TEXT_PARENT_DESCRIPTION','Diesem Dokument zuweisen');
define('TEXT_PRODUCT','Artikel:');
define('TEXT_LINK','Link:');
define('TEXT_SORT_ORDER','Sortierung:');
define('TEXT_GROUP','Sprachgruppe:');
define('TEXT_GROUP_DESC',' Mit dieser ID verkn&uuml;pfen Sie gleiche Themen unterschiedlicher Sprachen miteinander.');
define('TITLE_CONTENT_SLIDER',' Content Teaser-Slider');
define('TEXT_SELECT_NONE', 'kein Teaser Slider');

define('TEXT_CONTENT_DESCRIPTION','Mit dem Content Manager haben Sie die M&ouml;glichkeit, jeden beliebige Dateityp einem Artikel hinzuzuf&uuml;gen.<br />Z.&nbsp;B. Artikelbeschreibungen, Handb&uuml;cher, technische Datenbl&auml;tter, H&ouml;rproben usw..<br />Diese Elemente werden in der Artikeldetailansicht angezeigt.<br /><br />');
define('TEXT_FILENAME','Benutze Datei:');
define('TEXT_FILE_DESC','Beschreibung:');
define('USED_SPACE','Verwendeter Speicherplatz: ');
define('TABLE_HEADING_CONTENT_FILESIZE','Dateigr&ouml;ße');
  
	
// BOF GM_MOD:
define('GM_LINK', 'Link:');
define('GM_LINK_TOP', 'in selbem Fenster &ouml;ffnen');
define('GM_LINK_BLANK', 'in neuem Fenster &ouml;ffnen');

define('GM_SITEMAP_CHANGEFREQ', '&Auml;nderungsfrequenz in der Sitemap');
define('GM_SITEMAP_PRIORITY', 'Priorit&auml;t in der Sitemap');
define('TITLE_ALWAYS', 'Immer');
define('TITLE_HOURLY', 'St&uuml;ndlich');
define('TITLE_DAILY', 'T&auml;glich');
define('TITLE_WEEKLY', 'W&ouml;chentlich');
define('TITLE_MONTHLY', 'Monatlich');
define('TITLE_YEARLY', 'J&auml;hrlich');
define('TITLE_NEVER', 'Nie');	
define('GM_SITEMAP_ENTRY', 'In die Sitemap aufnehmen');	

define('GM_WARNING_CONTENT_GROUP_ID_EXISTS',	'Die eingegebene Sprachgruppe existiert bereits. W&auml;hlen Sie eine noch nicht vergebene Sprachgruppe wie z.B. "{ID}"');	
define('GM_ERROR_CONTENT_GROUP_ID_EXISTS',	'Die eingegebene Sprachgruppe existiert bereits. W&auml;hlen Sie eine noch nicht vergebene Sprachgruppe wie z.B. "{ID}". Ihre Eingaben wurden dennoch abgespeichert.');	

define('GM_META_TITLE', 'Meta Title:');
define('GM_META_KEYWORDS', 'Meta Keywords:');
define('GM_META_DESCRIPTION', 'Meta Description:');

define('GM_URL_KEYWORDS', 'URL Keywords:');

// EOF GM_MOD:
?>