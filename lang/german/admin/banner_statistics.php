<?php
/* --------------------------------------------------------------
   banner_statistics.php 2008-08-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(banner_statistics.php,v 1.3 2003/02/16); www.oscommerce.com 
   (c) 2003	 nextcommerce (banner_statistics.php,v 1.4 2003/08/14); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: banner_statistics.php 899 2005-04-29 02:40:57Z hhgag $)

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'Bannerstatistik');

// BOF GM_MOD
define('HEADING_SUB_TITLE', 'Hilfsprogramme');
// EOF GM_MOD

define('TABLE_HEADING_SOURCE', 'Grundlage');
define('TABLE_HEADING_VIEWS', 'Anzeigen');
define('TABLE_HEADING_CLICKS', 'Klicks');

define('TEXT_BANNERS_DATA', 'D<br />A<br />T<br />E<br />N');
define('TEXT_BANNERS_DAILY_STATISTICS', '%s Tagesstatistik für %s %s');
define('TEXT_BANNERS_MONTHLY_STATISTICS', '%s Monatsstatistik für %s');
define('TEXT_BANNERS_YEARLY_STATISTICS', '%s Jahresstatistik');

define('STATISTICS_TYPE_DAILY', 't&auml;glich');
define('STATISTICS_TYPE_MONTHLY', 'monatlich');
define('STATISTICS_TYPE_YEARLY', 'j&auml;hrlich');

define('TITLE_TYPE', 'Zeitintervall:');
define('TITLE_YEAR', 'Jahr:');
define('TITLE_MONTH', 'Monat:');

define('ERROR_GRAPHS_DIRECTORY_DOES_NOT_EXIST', 'Fehler: Das Verzeichnis \'graphs\' ist nicht vorhanden! Bitte erstellen Sie ein Verzeichnis \'graphs\' im Verzeichnis \'images\'.');
define('ERROR_GRAPHS_DIRECTORY_NOT_WRITEABLE', 'Fehler: Das Verzeichnis \'graphs\' ist schreibgesch&uuml;tzt!');
?>