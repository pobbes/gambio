<?php
/* --------------------------------------------------------------
   currencies.php 2008-08-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(currencies.php,v 1.15 2003/05/02); www.oscommerce.com 
   (c) 2003	 nextcommerce (currencies.php,v 1.4 2003/08/14); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: currencies.php 899 2005-04-29 02:40:57Z hhgag $)

   Released under the GNU General Public License 
   --------------------------------------------------------------*/
   
define('HEADING_TITLE', 'W&auml;hrungen');

// BOF GM_MOD
define('HEADING_SUB_TITLE', 'L&auml;nder / Steuern');
define('HEADING_WARNING', '<strong><font face="arial" style="font-size: 11px"><font color="#FF0000">ACHTUNG: </font>Bitte l&ouml;schen Sie die Standardw&auml;hrung nicht, da dies zu Problemen f&uuml;hren kann.</strong></font><br /><br />');
// EOF GM_MOD

define('TABLE_HEADING_CURRENCY_NAME', 'W&auml;hrung');
define('TABLE_HEADING_CURRENCY_CODES', 'K&uuml;rzel');
define('TABLE_HEADING_CURRENCY_VALUE', 'Wert');
define('TABLE_HEADING_ACTION', 'Aktion');

define('TEXT_INFO_EDIT_INTRO', 'Bitte f&uuml;hren Sie alle notwendigen &Auml;nderungen durch.');
define('TEXT_INFO_CURRENCY_TITLE', 'Name:');
define('TEXT_INFO_CURRENCY_CODE', 'K&uuml;rzel:');
define('TEXT_INFO_CURRENCY_SYMBOL_LEFT', 'Symbol links:');
define('TEXT_INFO_CURRENCY_SYMBOL_RIGHT', 'Symbol rechts:');
define('TEXT_INFO_CURRENCY_DECIMAL_POINT', 'Dezimaltrennzeichen:');
define('TEXT_INFO_CURRENCY_THOUSANDS_POINT', 'Tausendertrennzeichen:');
define('TEXT_INFO_CURRENCY_DECIMAL_PLACES', 'Dezimalstellen:');
define('TEXT_INFO_CURRENCY_LAST_UPDATED', 'letzte &Auml;nderung:');
define('TEXT_INFO_CURRENCY_VALUE', 'Wert (bei Standardw&auml;hrung 1.00000000):');
define('TEXT_INFO_CURRENCY_EXAMPLE', 'Beispiel:');
define('TEXT_INFO_INSERT_INTRO', 'Bitte geben Sie die neue W&auml;hrung mit allen relevanten Daten ein.');
define('TEXT_INFO_DELETE_INTRO', 'Sind Sie sicher, dass Sie diese W&auml;hrung l&ouml;schen m&ouml;chten?');
define('TEXT_INFO_HEADING_NEW_CURRENCY', 'neue W&auml;hrung');
define('TEXT_INFO_HEADING_EDIT_CURRENCY', 'W&auml;hrung bearbeiten');
define('TEXT_INFO_HEADING_DELETE_CURRENCY', 'W&auml;hrung l&ouml;schen');
define('TEXT_INFO_SET_AS_DEFAULT', TEXT_SET_DEFAULT . ' (manuelles Aktualisieren der Wechselkurse erforderlich.)');
define('TEXT_INFO_CURRENCY_UPDATED', 'Der Wechselkurs %s (%s) wurde erfolgreich aktualisiert.');

define('ERROR_REMOVE_DEFAULT_CURRENCY', 'Fehler: Die Standardw&auml;hrung darf nicht gel&ouml;scht werden. Bitte definieren Sie eine neue Standardw&auml;hrung und wiederholen Sie den Vorgang.');
define('ERROR_CURRENCY_INVALID', 'Fehler: Der Wechselkurs f&uuml;r %s (%s) wurde nicht aktualisiert. Ist dies ein g&uuml;ltiges W&auml;hrungsk&uuml;rzel?');
?>