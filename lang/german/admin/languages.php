<?php
/* --------------------------------------------------------------
   languages.php 2010-03-10 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(languages.php,v 1.10 2002/01/19); www.oscommerce.com 
   (c) 2003	 nextcommerce (languages.php,v 1.5 2003/08/14); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: languages.php 899 2005-04-29 02:40:57Z hhgag $)

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'Sprachen');

// BOF GM_MOD
define('HEADING_SUB_TITLE', 'L&auml;nder / Steuern');
define('HEADING_WARNING', '<strong><font face="arial" style="font-size: 11px"><font color="#FF0000">ACHTUNG:</font> 
&Auml;nderungen in diesem Bereich k&ouml;nnen dazu f&uuml;hren, dass der Shop fehlerhaft arbeitet.
In der Regel sind die Einstellungen in diesem Bereich bereits standardm&auml;&szlig;ig korrekt und es ist
keine Bearbeitung notwendig. Bitte f&uuml;hren Sie nur &Auml;nderungen durch, wenn Sie sich &uuml;ber die
Folgen im Klaren sind!</strong></font><br /><br />');

define('GM_LANGUAGE_CONFIGURATION_TITLE', 'Konfiguration');
define('GM_LANGUAGE_CONFIGURATION_TEXT', 'Sprache anhand der Browsersprache automatisch ausw&auml;hlen');
define('GM_LANGUAGE_CONFIGURATION_SUCCESS', 'Die &Auml;nderungen wurden erfolgreich gespeichert!');
// EOF GM_MOD

define('TABLE_HEADING_LANGUAGE_NAME', 'Sprache');
define('TABLE_HEADING_LANGUAGE_CODE', 'Codierung');
define('TABLE_HEADING_ACTION', 'Aktion');

define('TEXT_INFO_EDIT_INTRO', 'Bitte f&uuml;hren Sie alle notwendigen &Auml;nderungen durch.');
define('TEXT_INFO_LANGUAGE_NAME', 'Name:');
define('TEXT_INFO_LANGUAGE_CODE', 'Codierung:');
define('TEXT_INFO_LANGUAGE_IMAGE', 'Symbol:');
define('TEXT_INFO_LANGUAGE_DIRECTORY', 'Verzeichnis:');
define('TEXT_INFO_LANGUAGE_SORT_ORDER', 'Sortierreihenfolge:');
define('TEXT_INFO_INSERT_INTRO', 'Bitte geben Sie die neue Sprache mit allen relevanten Daten ein.');
define('TEXT_INFO_DELETE_INTRO', 'Sind Sie sicher, dass Sie die Sprache l&ouml;schen m&ouml;chten?');
define('TEXT_INFO_HEADING_NEW_LANGUAGE', 'Neue Sprache');
define('TEXT_INFO_HEADING_EDIT_LANGUAGE', 'Sprache bearbeiten');
define('TEXT_INFO_HEADING_DELETE_LANGUAGE', 'Sprache l&ouml;schen');
define('TEXT_INFO_LANGUAGE_CHARSET','Charset');
define('TEXT_INFO_LANGUAGE_CHARSET_INFO','meta-content:');


define('ERROR_REMOVE_DEFAULT_LANGUAGE', 'Fehler: Die Standardsprache darf nicht gel&ouml;scht werden. Bitte definieren Sie eine neue Standardsprache und wiederholen Sie den Vorgang.');
?>