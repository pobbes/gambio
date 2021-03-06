<?php
/* --------------------------------------------------------------
   start.php 2012-12-17 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2003	 nextcommerce (start.php,v 1.1 2003/08/19); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: start.php 893 2005-04-27 11:44:16Z gwinger $)
   
   Released under the GNU General Public License 
   --------------------------------------------------------------*/
 
	define('HEADING_TITLE','Willkommen');  
	define('ATTENTION_TITLE','! ACHTUNG !');
  
	  // text for Warnings:
	define('TEXT_FILE_WARNING','<b>WARNUNG:</b><br />Folgende Dateien sind vom Server beschreibbar. Bitte &auml;ndern Sie die Zugriffsrechte (Permissions) dieser Datei aus Sicherheitsgr&uuml;nden. <b>(444)</b> in unix, <b>(read-only)</b> in Win32.');
	define('TEXT_FOLDER_WARNING','<b>WARNUNG:</b><br />Folgende Verzeichnisse m&uuml;ssen vom Server beschreibbar sein. Bitte &auml;ndern Sie die Zugriffsrechte (Permissions) dieser Verzeichnisse. <b>(777)</b> in unix, <b>(read-write)</b> in Win32.');
	define('TEXT_OBSOLETE_WARNING','<b>WARNUNG:</b><br />Folgende Dateien sind veraltet und m&uuml;ssen aktualisiert werden.');
	define('TEXT_DB_UPDATE_WARNING','<b>WARNUNG:</b><br />Das <a href="' . HTTP_SERVER . DIR_WS_CATALOG . 'gm_updater.php"><u>Datenbankupdate</u></a> zu Ihrer Shopversion wurde noch nicht ausgef&uuml;hrt. Bitte f&uuml;hren Sie dies gem&auml;&szlig; der Installationsanleitung durch.');
	define('REPORT_GENERATED_FOR','Report f&uuml;r:');
	define('REPORT_GENERATED_ON','Erstellt am:');
	define('FIRST_VISIT_ON','Erster Besuch:');
	define('HEADING_QUICK_STATS','Kurz&uuml;bersicht');
	define('VISITS_TODAY','Besuche heute:');
	define('UNIQUE_TODAY','Einzelne Besucher:');
	define('DAILY_AVERAGE','T&auml;glicher Durchschnitt:');
	define('TOTAL_VISITS','Besuche insgesammt:');
	define('TOTAL_UNIQUE','Einzelbesucher insgesammt:');
	define('TOP_REFFERER','Top Refferer:');
	define('TOP_ENGINE','Top Suchmaschine:');
	define('DAY_SUMMARY','30 Tage &Uuml;bersicht:');
	define('VERY_LAST_VISITORS','Letzte 10 Besucher:');
	define('TODAY_VISITORS','Besucher von heute:');
	define('LAST_VISITORS','Letzte 100 Besucher:');
	define('ALL_LAST_VISITORS','Alle Besucher:');
	define('DATE_TIME','Datum / Uhrzeit:');
	define('IP_ADRESS','IP Adresse:');
	define('OPERATING_SYSTEM','Betriebssystem:');
	define('REFFERING_HOST','Referring Host:');
	define('ENTRY_PAGE','Einstiegsseite:');
	define('HOURLY_TRAFFIC_SUMMARY','St&uuml;ndliche Traffic Zusammenfassung');
	define('WEB_BROWSER_SUMMARY','Web Browser &Uuml;bersicht');
	define('OPERATING_SYSTEM_SUMMARY','Betriebssystem &Uuml;bersicht');
	define('TOP_REFERRERS','Top 10 Referrer');
	define('TOP_HOSTS','Top Ten Hosts');
	define('LIST_ALL','Alle anzeigen');    
	define('SEARCH_ENGINE_SUMMARY','Suchmaschinen &Uuml;bersicht');
	define('SEARCH_ENGINE_SUMMARY_TEXT',' ( Prozentangaben basieren auf die Gesamtzahl der Besuche &uuml;ber Suchmaschinen. )');
	define('SEARCH_QUERY_SUMMARY','Suchanfragen &Uuml;bersicht');
	define('SEARCH_QUERY_SUMMARY_TEXT',' ) ( Prozentangaben basieren auf die Gesamtzahl der Suchanfragen die geloggt wurden. )');
	define('REFERRING_URL','Refferrer Url');
	define('HITS','Hits');
	define('PERCENTAGE','Prozentanteil');
	define('HOST','Host');

	// gm Start 
	define('TITLE_Y','Besucher');
	define('TITLE_VISITORS','Besucher gestern und heute');
	define('MENU_TITLE_TO','bis');


	define('TITLE_VISITOR','Besucher');
	define('TITLE_OVERVIEW','&Uuml;bersicht');
	define('TITLE_TOP_LIST','Top-List');
	define('TITLE_ORDERS','Bestellungen');
	define('TITLE_SALES','Ums&auml;tze');
	define('TITLE_IMPRESSIONS','Seitenaufrufe');
	define('TITLE_TODAY','Heute');
	define('TITLE_YESTERDAY','Gestern');
	define('TITLE_RATE','Ver&auml;nderung');
	define('TITLE_NEWS','Gambio News');
	define('SEARCHTERM_EXTERN','Suchbegriffe extern');
	define('SEARCHTERM_INTERN','Suchbegriffe intern');
	define('ARTICLE_SOLD','Verkaufte Artikel');
	// BOF GM_MOD
	define('TEXT_NEWS_LOADING','News werden geladen.');
	// EOF GM_MOD

?>