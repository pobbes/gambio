<?php
/* --------------------------------------------------------------
   popup_search_help.php 2010-01-18 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(popup_search_help.php,v 1.3 2003/02/13); www.oscommerce.com
   (c) 2003	 nextcommerce (popup_search_help.php,v 1.6 2003/08/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: http://dev1.gambio-shop.de/2008/shop/gambio/icons/persdaten.png 1238 2005-09-24 10:51:19Z mz $) 

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');

$smarty = new Smarty;
require_once (DIR_FS_CATALOG . 'gm/modules/gm_popup_header.php');
$smarty->assign('link_close', 'javascript:window.close()');
$smarty->assign('language', $_SESSION['language']);
$smarty->assign('tpl_path', CURRENT_TEMPLATE);


// set cache ID
 if (!CacheCheck()) {
	$smarty->caching = 0;
	$smarty->display(CURRENT_TEMPLATE.'/module/popup_search_help.html');
} else {
	$smarty->caching = 1;
	$smarty->cache_lifetime = CACHE_LIFETIME;
	$smarty->cache_modified_check = CACHE_CHECK;
	$cache_id = $_SESSION['language'];
	$smarty->display(CURRENT_TEMPLATE.'/module/popup_search_help.html', $cache_id);
}

// BOF GM_MOD:
mysql_close(); 
?>