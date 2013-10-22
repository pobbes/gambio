<?php
/* --------------------------------------------------------------
   gm_sitemap_creator.php 2008-06-25 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

gm_sitemap_creator.php 08.04.2008 pt@gambio
	Gambio OHG
	http://www.gambio.de
	Copyright (c) 2007 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
	--------------------------------------------------------------
*/
	require('includes/application_top.php');
	require_once(DIR_FS_INC		. 'xtc_category_link.inc.php');
	require_once(DIR_FS_INC		. 'xtc_product_link.inc.php');
	require_once(DIR_FS_INC		. 'xtc_cleanName.inc.php');
	require_once(DIR_FS_CATALOG . 'gm/inc/gm_xtc_href_link.inc.php');
	require_once(DIR_FS_ADMIN	. 'gm/classes/GMSitemapXML.php');
		
	
	if($_GET['action'] == 'create_sitemap') {
		$sitemap = new GMSitemapXML(array($_GET['ping_google'], $_GET['ping_yahoo'], $_GET['ping_ask'],  $_GET['ping_live']));
		echo $sitemap->create();
	}
?>
