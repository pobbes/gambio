<?php
/* --------------------------------------------------------------
   tax_classes.php 2008-08-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(tax_classes.php,v 1.5 2002/01/28); www.oscommerce.com 
   (c) 2003	 nextcommerce (tax_classes.php,v 1.4 2003/08/14); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: tax_classes.php 899 2005-04-29 02:40:57Z hhgag $)

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'Steuerklassen');

// BOF GM_MOD
define('HEADING_SUB_TITLE', 'L&auml;nder / Steuern');
define('HEADING_WARNING', '<strong><font face="arial" style="font-size: 11px"><font color="#FF0000">ACHTUNG:</font> 
&Auml;nderungen in diesem Bereich k&ouml;nnen dazu f&uuml;hren, dass der Shop fehlerhaft arbeitet.
In der Regel sind die Einstellungen in diesem Bereich bereits standardm&auml;&szlig;ig korrekt und es ist
keine Bearbeitung notwendig. Bitte f&uuml;hren Sie nur &Auml;nderungen durch, wenn Sie sich &uuml;ber die
Folgen im Klaren sind!</strong></font><br /><br />');
// EOF GM_MOD

define('TABLE_HEADING_TAX_CLASSES', 'Steuerklassen');
define('TABLE_HEADING_ACTION', 'Aktion');

define('TEXT_INFO_EDIT_INTRO', 'Bitte f&uuml;hren Sie alle notwendigen &Auml;nderungen durch.');
define('TEXT_INFO_CLASS_TITLE', 'Name der Steuerklasse:');
define('TEXT_INFO_CLASS_DESCRIPTION', 'Beschreibung:');
define('TEXT_INFO_DATE_ADDED', 'hinzugef&uuml;gt am:');
define('TEXT_INFO_LAST_MODIFIED', 'letzte &Auml;nderung:');
define('TEXT_INFO_INSERT_INTRO', 'Bitte geben Sie die neue Steuerklasse mit allen relevanten Daten ein.');
define('TEXT_INFO_DELETE_INTRO', 'Sind Sie sicher, dass Sie diese Steuerklasse l&ouml;schen m&ouml;chten?');
define('TEXT_INFO_HEADING_NEW_TAX_CLASS', 'neue Steuerklasse');
define('TEXT_INFO_HEADING_EDIT_TAX_CLASS', 'Steuerklasse bearbeiten');
define('TEXT_INFO_HEADING_DELETE_TAX_CLASS', 'Steuerklasse l&ouml;schen');
?>