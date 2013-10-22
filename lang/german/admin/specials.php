<?php
/* --------------------------------------------------------------
   specials.php 2008-08-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(specials.php,v 1.10 2002/01/31); www.oscommerce.com 
   (c) 2003	 nextcommerce (specials.php,v 1.4 2003/08/14); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: specials.php 899 2005-04-29 02:40:57Z hhgag $)

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'Sonderangebote');

// BOF GM_MOD
define('HEADING_SUB_TITLE', 'Artikelkatalog');
// EOF GM_MOD

define('TABLE_HEADING_PRODUCTS', 'Artikel');
define('TABLE_HEADING_PRODUCTS_PRICE', 'Artikelpreis');
define('TABLE_HEADING_STATUS', 'Status');
define('TABLE_HEADING_ACTION', 'Aktion');
define('TEXT_MARKED_ELEMENTS','Markiertes Element');
define('TEXT_SPECIALS_PRODUCT', 'Artikel:');
define('TEXT_SPECIALS_SPECIAL_PRICE', 'Angebotspreis:');
define('TEXT_SPECIALS_SPECIAL_QUANTITY', 'Anzahl:');
define('TEXT_SPECIALS_EXPIRES_DATE', 'g&uuml;ltig bis:<br><small>(tt.mm.jjjj)</small>');
define('TEXT_SPECIALS_PRICE_TIP', '<b>Bemerkung:</b><ul><li>Sie k&ouml;nnen im Feld Angebotspreis auch prozentuale Werte angeben, z.&nbsp;B.: <b>20%</b></li><li>Wenn Sie einen neuen Preis eingeben, m&uuml;ssen die Nachkommastellen mit einem \'.\' getrennt werden, z.&nbsp;B.: <b>49.99</b></li><li>Lassen Sie das Feld <b>\'g&uuml;ltig bis\'</b> leer, wenn der Angebotspreis zeitlich unbegrenzt gelten soll.</li></ul>');

define('TEXT_INFO_DATE_ADDED', 'hinzugef&uuml;gt am:');
define('TEXT_INFO_LAST_MODIFIED', 'letzte &Auml;nderung:');
define('TEXT_INFO_NEW_PRICE', 'neuer Preis:');
define('TEXT_INFO_ORIGINAL_PRICE', 'alter Preis:');
define('TEXT_INFO_PERCENTAGE', 'Prozent:');
define('TEXT_INFO_EXPIRES_DATE', 'g&uuml;ltig bis:');
define('TEXT_INFO_STATUS_CHANGE', 'Status ge&auml;ndert:');

define('TEXT_INFO_HEADING_DELETE_SPECIALS', 'Sonderangebot l&ouml;schen');
define('TEXT_INFO_DELETE_INTRO', 'Sind Sie sicher, dass Sie das Sonderangebot l&ouml;schen m&ouml;chten?');

define('TEXT_IMAGE_NONEXISTENT','Kein Bild verf&uuml;gbar!');
?>