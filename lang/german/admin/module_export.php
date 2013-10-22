<?php
/* --------------------------------------------------------------
   module_export.php 2010-09-17 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(modules.php,v 1.8 2002/04/09); www.oscommerce.com 
   (c) 2003	 nextcommerce (modules.php,v 1.5 2003/08/14); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: module_export.php 899 2005-04-29 02:40:57Z hhgag $)

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('HEADING_TITLE_MODULES_EXPORT', 'Modul-Center');

// BOF GM_MOD
define('HEADING_SUB_TITLE', 'Module');
define('HEADING_WARNING', '<strong><font face="arial" style="font-size: 11px"><font color="#FF0000">HINWEIS:</font> 
Neue Versionen der hier gelisteten Exportschnittschnellen finden Sie unter dem Men&uuml;punkt ARTIKEL -> <a href="gm_product_export.php" style="font-weight: bold; text-decoration: underline;">Artikelexport</a>.</strong></font><br />');
// EOF GM_MOD

define('TABLE_HEADING_MODULES', 'Modul');
define('TABLE_HEADING_SORT_ORDER', 'Reihenfolge');
define('TABLE_HEADING_STATUS', 'Status');
define('TABLE_HEADING_ACTION', 'Aktion');

define('TEXT_MODULE_DIRECTORY', 'Modul Verzeichnis:');
define('TEXT_MARKED_ELEMENTS','Markiertes Element');
define('TABLE_HEADING_FILENAME','Modulname (f&uuml;r internen Gebrauch)');
define('ERROR_EXPORT_FOLDER_NOT_WRITEABLE','export/ Verzeichniss nicht beschreibbar!');
?>