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
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: start.php 890 2005-04-27 11:34:12Z gwinger $)
   
   Released under the GNU General Public License 
   --------------------------------------------------------------*/
 
  define('HEADING_TITLE','Welcome');
  define('ATTENTION_TITLE','! ATTENTION !');

  // text for Warnings:
  define('TEXT_FILE_WARNING','<b>WARNING:</b><br />The following files are writeable by the server. Please change the permissions for these files for security reasons. <b>(444)</b> in Unix, <b>(read only)</b> in Win32.');
  define('TEXT_FOLDER_WARNING','<b>WARNING:</b><br />The following folders must be writeable by the server. Please change the permissions for these folders. <b>(777)</b> in Unix, <b>(read/write)</b> in Win32.');
  define('TEXT_OBSOLETE_WARNING','<b>WARNING:</b><br />The following files are outdated and need to be updated.');
  define('TEXT_DB_UPDATE_WARNING','<b>WARNING:</b><br />The <a href="' . HTTP_SERVER . DIR_WS_CATALOG . 'gm_updater.php"><u>Database Update</u></a> has not yet been executed. Please follow the instructions in the installation guide.');
  define('REPORT_GENERATED_FOR','Report For:');
  define('REPORT_GENERATED_ON','Generated On:');
  define('FIRST_VISIT_ON','First Visit:');
  define('HEADING_QUICK_STATS','Quick Stats');
  define('VISITS_TODAY','Visits Today:');
  define('UNIQUE_TODAY','Unique Visits Today:');
  define('DAILY_AVERAGE','Daily Average:');
  define('TOTAL_VISITS','Total Visits:');
  define('TOTAL_UNIQUE','Total Unique Visits:');
  define('TOP_REFFERER','Top Referring Host:');
  define('TOP_ENGINE','Top Search Engine:');
  define('DAY_SUMMARY','30-day Summary:');
  define('VERY_LAST_VISITORS','10 Previous Visitors:');
  define('TODAY_VISITORS','Visitors Today:');
  define('LAST_VISITORS','100 Previous Visitors:');
  define('ALL_LAST_VISITORS','All Visitors:');
  define('DATE_TIME','Date / Time:');
  define('IP_ADRESS','IP Address:');
  define('OPERATING_SYSTEM','Operating System:');
  define('REFFERING_HOST','Referring Host:');
  define('ENTRY_PAGE','Entry Page:');
  define('HOURLY_TRAFFIC_SUMMARY','Hourly Traffic Summary');
    define('WEB_BROWSER_SUMMARY','Web Browser Summary');
    define('OPERATING_SYSTEM_SUMMARY','Operating System Summary');
    define('TOP_REFERRERS','Top 10 Referrers');
    define('TOP_HOSTS','Top Ten Hosts');
    define('LIST_ALL','List all');    
    define('SEARCH_ENGINE_SUMMARY','Search Engine Summary');
    define('SEARCH_ENGINE_SUMMARY_TEXT',' ( Percentage is based on the total visits referred by search engines. )');
    define('SEARCH_QUERY_SUMMARY','Search Query Summary');
    define('SEARCH_QUERY_SUMMARY_TEXT',' ) ( Percentage is based on the total search query strings logged. )');
    define('REFERRING_URL','Referring Url');
    define('HITS','Hits');
    define('PERCENTAGE','Percentage');
    define('HOST','Host');
	
	// gm Start 
	define('TITLE_Y','Visitors');
	define('TITLE_VISITORS','Visitors today and yesterday');
	define('MENU_TITLE_TO','to');


	define('TITLE_VISITOR','Visitors');
	define('TITLE_OVERVIEW','Overview');
	define('TITLE_TOP_LIST','Top List');
	define('TITLE_ORDERS','Orders');
	define('TITLE_SALES','Sales');
	define('TITLE_IMPRESSIONS','Impressions');
	define('TITLE_TODAY','Today');
	define('TITLE_YESTERDAY','Yesterday');
	define('TITLE_RATE','Change');
	define('TITLE_NEWS','Gambio News');
	define('SEARCHTERM_EXTERN','External search term');
	define('SEARCHTERM_INTERN','Internal search term');
	define('ARTICLE_SOLD','Product sold');
	// BOF GM_MOD
	define('TEXT_NEWS_LOADING','News will be loaded.');
	// EOF GM_MOD

?>