<?php
/* --------------------------------------------------------------
   countries.php 2008-08-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(countries.php,v 1.8 2002/01/19); www.oscommerce.com 
   (c) 2003	 nextcommerce (countries.php,v 1.4 2003/08/14); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: countries.php 899 2005-04-29 02:40:57Z hhgag $)

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'L&auml;nder');

// BOF GM_MOD
define('HEADING_SUB_TITLE', 'L&auml;nder / Steuern');
define('HEADING_WARNING', '<strong><font face="arial" style="font-size: 11px"><font color="#FF0000">ACHTUNG:</font> 
&Auml;nderungen in diesem Bereich k&ouml;nnen dazu f&uuml;hren, dass der Shop fehlerhaft arbeitet.
In der Regel sind die Einstellungen in diesem Bereich bereits standardm&auml;&szlig;ig korrekt und es ist
keine Bearbeitung notwendig. Bitte f&uuml;hren Sie nur &Auml;nderungen durch, wenn Sie sich &uuml;ber die
Folgen im Klaren sind!</strong></font><br /><br />');
// EOF GM_MOD

define('TABLE_HEADING_COUNTRY_NAME', 'Land');
define('TABLE_HEADING_COUNTRY_CODES', 'ISO Codes');
define('TABLE_HEADING_ACTION', 'Aktion');
define('TABLE_HEADING_STATUS', 'Status');

define('TEXT_INFO_EDIT_INTRO', 'Bitte f&uuml;llen Sie alle Felder aus.');
define('TEXT_INFO_COUNTRY_NAME', 'Name:');
define('TEXT_INFO_COUNTRY_CODE_2', 'ISO Code (2):');
define('TEXT_INFO_COUNTRY_CODE_3', 'ISO Code (3):');
define('TEXT_INFO_ADDRESS_FORMAT', 'Adressformat:');
define('TEXT_INFO_INSERT_INTRO', 'Bitte geben Sie das neue Land mit allen relevanten Daten ein.');
define('TEXT_INFO_DELETE_INTRO', 'Sind Sie sicher, dass Sie das Land l&ouml;schen m&ouml;chten?');
define('TEXT_INFO_HEADING_NEW_COUNTRY', 'neues Land');
define('TEXT_INFO_HEADING_EDIT_COUNTRY', 'Land bearbeiten');
define('TEXT_INFO_HEADING_DELETE_COUNTRY', 'Land l&ouml;schen');
define('TEXT_INFO_HEADING_NEW_COUNTRY', 'neues Land');

define('GM_BUTTON_DACH',		'D, A, CH aktivieren');
define('GM_BUTTON_ACTIVE',		'alle aktivieren');
define('GM_BUTTON_INACTIVE',	'alle deaktivieren');

?>