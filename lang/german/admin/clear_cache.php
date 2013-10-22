<?php
/* --------------------------------------------------------------
   clear_cache.php 2012-01-27 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

define('HEADING_TITLE', 'Cache leeren');
define('TEXT_MESSAGE', 'Der Cache wurde geleert und wird mit dem nächsten Seitenaufruf im Shop neu generiert.');
define('TEXT_ERROR_MESSAGE', 'Der Cache konnte nicht geleert werden.');

define('BUTTON_OUTPUT_CACHE', 'Cache f&uuml;r Seitenausgabe leeren');
define('BUTTON_DATA_CACHE', 'Cache f&uuml;r Modulinformationen leeren');
define('BUTTON_SUBMENUS_CACHE', 'Cache f&uuml;r Ausgabe der Kategoriemen&uuml;s neu erzeugen');
define('BUTTON_CATEGORIES_CACHE', 'Cache f&uuml;r Artikel- und Kategoriezuordnungen neu erzeugen');
define('BUTTON_PROPERTIES_CACHE', 'Cache f&uuml;r Artikeleigenschaftenzuordnungen neu erzeugen');
define('BUTTON_FEATURES_CACHE', 'Filterzuordnungen in Artikeln reparieren');

define('TEXT_OUTPUT_CACHE', 'Leeren Sie diesen Cache, wenn Sie &Auml;nderungen an Kategorie- oder Artikeldaten oder Einstellungen vorgenommen haben, die eine ver&auml;nderte Ausgabe von Shopseiten bewirken, z. B. Text- oder Preis&auml;nderungen, Einblenden neuer Module, Status&auml;nderungen bei Kategorien/Artikeln.');
define('TEXT_DATA_CACHE', 'Leeren Sie diesen Cache, wenn Sie &Auml;nderungen an der Kategoriestruktur oder den Sprachdateien vorgenommen oder neue Module f&uuml;r den Shop installiert bzw. aktiviert haben.');
define('TEXT_SUBMENUS_CACHE', 'Wenn Sie den Seitenausgabe-Cache geleert haben und Sie &uuml;ber einer hohen Anzahl von Kategorien arbeiten, kann es die n&auml;chsten Seitenausgaben beschleunigen, wenn Sie nun vorab den Cache f&uuml;r die Ausgabe der Kategoriemen&uuml;s neu erzeugen.');
define('TEXT_CATEGORIES_CACHE', 'Erzeugen Sie diesen Cache neu, wenn Sie &uuml;ber ein externes System Artikel und/oder Kategorien angelegt oder dessen Zuordnungen ver&auml;ndert haben (z.B. &uuml;ber ein Warenwirtschaftssystem oder einen direkten Datenbankzugriff).');
define('TEXT_PROPERTIES_CACHE', 'Erzeugen Sie diesen Cache neu, wenn Sie &Auml;nderungen an Artikeleigenschaften vorgenommen haben, die bereits Artikeln zugewiesen waren.');
define('TEXT_FEATURES_CACHE', 'In Ausnahmef&auml;llen kann es erforderlich sein, die Filterzuordnungen zu reparieren, falls Artikel &uuml;ber den Filter nicht richtig gefunden werden.');
?>