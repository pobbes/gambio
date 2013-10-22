<?php
/* --------------------------------------------------------------
   zones.php 2008-08-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(zones.php,v 1.6 2002/01/28); www.oscommerce.com 
   (c) 2003	 nextcommerce (zones.php,v 1.4 2003/08/14); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: zones.php 899 2005-04-29 02:40:57Z hhgag $)

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'Bundesl&auml;nder');

// BOF GM_MOD
define('HEADING_SUB_TITLE', 'L&auml;nder / Steuern');
define('HEADING_WARNING', '<strong><font face="arial" style="font-size: 11px"><font color="#FF0000">ACHTUNG:</font> 
&Auml;nderungen in diesem Bereich k&ouml;nnen dazu f&uuml;hren, dass der Shop fehlerhaft arbeitet.
In der Regel sind die Einstellungen in diesem Bereich bereits standardm&auml;&szlig;ig korrekt und es ist
keine Bearbeitung notwendig. Bitte f&uuml;hren Sie nur &Auml;nderungen durch, wenn Sie sich &uuml;ber die
Folgen im Klaren sind!</strong></font><br /><br />');
// EOF GM_MOD

define('TABLE_HEADING_COUNTRY_NAME', 'Land');
define('TABLE_HEADING_ZONE_NAME', 'Bundesland');
define('TABLE_HEADING_ZONE_CODE', 'Code');
define('TABLE_HEADING_ACTION', 'Aktion');

define('TEXT_INFO_EDIT_INTRO', 'Bitte f&uuml;llen Sie alle Felder aus.');
define('TEXT_INFO_ZONES_NAME', 'Name des Bundeslandes:');
define('TEXT_INFO_ZONES_CODE', 'Code des Bundeslandes:');
define('TEXT_INFO_COUNTRY_NAME', 'Land:');
define('TEXT_INFO_INSERT_INTRO', 'Bitte geben Sie das neue Bundesland mit allen relevanten Daten ein.');
define('TEXT_INFO_DELETE_INTRO', 'Sind Sie sicher, dass Sie dieses Bundesland l&ouml;schen wollen?');
define('TEXT_INFO_HEADING_NEW_ZONE', 'Neues Bundesland');
define('TEXT_INFO_HEADING_EDIT_ZONE', 'Bundesland bearbeiten');
define('TEXT_INFO_HEADING_DELETE_ZONE', 'Bundesland l&ouml;schen');
?>