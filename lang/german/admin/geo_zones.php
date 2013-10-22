<?php
/* --------------------------------------------------------------
   geo_zones.php 2008-08-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(geo_zones.php,v 1.11 2003/05/07); www.oscommerce.com 
   (c) 2003	 nextcommerce ( geo_zones.php,v 1.4 2003/08/1); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: geo_zones.php 899 2005-04-29 02:40:57Z hhgag $)

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'Steuerzonen');

// BOF GM_MOD
define('HEADING_SUB_TITLE', 'L&auml;nder / Steuern');
define('HEADING_WARNING', '<strong><font face="arial" style="font-size: 11px"><font color="#FF0000">ACHTUNG:</font> 
&Auml;nderungen in diesem Bereich k&ouml;nnen dazu f&uuml;hren, dass der Shop fehlerhaft arbeitet.
In der Regel sind die Einstellungen in diesem Bereich bereits standardm&auml;&szlig;ig korrekt und es ist
keine Bearbeitung notwendig. Bitte f&uuml;hren Sie nur &Auml;nderungen durch, wenn Sie sich &uuml;ber die
Folgen im Klaren sind!</strong></font><br /><br />');
// EOF GM_MOD

define('TABLE_HEADING_COUNTRY', 'Land');
define('TABLE_HEADING_COUNTRY_ZONE', 'Bundesland');
define('TABLE_HEADING_TAX_ZONES', 'Steuerzonen');
define('TABLE_HEADING_ACTION', 'Aktion');

define('TEXT_INFO_HEADING_NEW_ZONE', 'Neue Steuerzone');
define('TEXT_INFO_NEW_ZONE_INTRO', 'Bitte geben Sie die neue Steuerzone mit allen relevanten Daten ein.');

define('TEXT_INFO_HEADING_EDIT_ZONE', 'Steuerzone bearbeiten');
define('TEXT_INFO_EDIT_ZONE_INTRO', 'Bitte f&uuml;hren Sie alle notwendigen &Auml;nderungen durch.');

define('TEXT_INFO_HEADING_DELETE_ZONE', 'Steuerzone l&ouml;schen');
define('TEXT_INFO_DELETE_ZONE_INTRO', 'Sind Sie sicher, dass Sie diese Steuerzone l&ouml;schen wollen?');

define('TEXT_INFO_HEADING_NEW_SUB_ZONE', 'Neue Unterzone');
define('TEXT_INFO_NEW_SUB_ZONE_INTRO', 'Bitte geben Sie die neue Unterzone mit allen relevanten Daten ein.');

define('TEXT_INFO_HEADING_EDIT_SUB_ZONE', 'Unterzone bearbeiten');
define('TEXT_INFO_EDIT_SUB_ZONE_INTRO', 'Bitte f&uuml;hren Sie alle notwendigen &Auml;nderungen durch.');

define('TEXT_INFO_HEADING_DELETE_SUB_ZONE', 'Unterzone l&ouml;schen');
define('TEXT_INFO_DELETE_SUB_ZONE_INTRO', 'Sind Sie sicher, dass Sie diese Unterzone l&ouml;schen wollen?');

define('TEXT_INFO_DATE_ADDED', 'hinzugef&uuml;gt am:');
define('TEXT_INFO_LAST_MODIFIED', 'letzte &Auml;nderung:');
define('TEXT_INFO_ZONE_NAME', 'Name der Steuerzone:');
define('TEXT_INFO_NUMBER_ZONES', 'Anzahl der Steuerzonen:');
define('TEXT_INFO_ZONE_DESCRIPTION', 'Beschreibung:');
define('TEXT_INFO_COUNTRY', 'Land:');
define('TEXT_INFO_COUNTRY_ZONE', 'Bundesland:');
define('TYPE_BELOW', 'Alle Bundesl&auml;nder');
define('PLEASE_SELECT', 'Alle Bundesl&auml;nder');
define('TEXT_ALL_COUNTRIES', 'Alle L&auml;nder');
?>