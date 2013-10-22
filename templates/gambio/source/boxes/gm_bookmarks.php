<?php
/* --------------------------------------------------------------
   gm_bookmarks.php 2008-08-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(languages.php,v 1.14 2003/02/12); www.oscommerce.com
   (c) 2003	 nextcommerce (languages.php,v 1.8 2003/08/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: languages.php 1262 2005-09-30 10:00:32Z mz $) 

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

	// include needed functions
	$boxes = array('GM_BOOKMARKS_START', 'GM_BOOKMARKS_ARTICLES', 'GM_BOOKMARKS_CATEGORIES', 'GM_BOOKMARKS_REST', 'GM_BOOKMARKS_CONTENT');		
	$gm_values = gm_get_conf($boxes);

	// are there any bookmarks?
	$gm_bookmarks_query = xtc_db_query("
										SELECT 
											*
										FROM
											gm_bookmarks
										");		
	
	// show box if there are any bookmarks								
	if(xtc_db_num_rows($gm_bookmarks_query) != 0) {
		
		if(
			($product->pID !=0 && $gm_values['GM_BOOKMARKS_ARTICLES'] == 1)	||
			(!empty($cPath) && $gm_values['GM_BOOKMARKS_CATEGORIES'] == 1)	||				
			(basename($PHP_SELF) == "index.php" && $gm_values['GM_BOOKMARKS_START'] == 1 && empty($_GET['manufacturers_id'])) ||
			(basename($PHP_SELF) == "shop_content.php" && $gm_values['GM_BOOKMARKS_CONTENT'] == 1) || 
			((strstr(basename($PHP_SELF), "reviews") || basename($PHP_SELF) == "products_new.php" || basename($PHP_SELF) == "specials.php" || !empty($_GET['manufacturers_id'])) && $gm_values['GM_BOOKMARKS_REST'] == 1)
			)
		{

			if(isset($_SESSION['languages_id'])) $lang_id = $_SESSION['languages_id'];
			else $lang_id = '2';

			$box_smarty = new smarty;
			$box_smarty->assign('tpl_path', 'templates/' . CURRENT_TEMPLATE . '/');

			// include social bookmarks link
			include(DIR_FS_CATALOG . 'gm/inc/gm_get_bookmarks_link.inc.php');	

			$gm_bookmarks = gm_get_bookmarks_link($PHP_SELF);

			$box_smarty->assign('BOX_CONTENT', $gm_bookmarks);

			// set cache ID
			$box_smarty->caching = 0;
			$box_smarty->assign('language', $_SESSION['language']);
			$box_gm_bookmarks = $box_smarty->fetch(CURRENT_TEMPLATE . '/boxes/box_gm_bookmarks.html');

			$gm_box_pos = $coo_template_control->get_menubox_position('gm_bookmarks');
			
		$smarty->assign($gm_box_pos,$box_gm_bookmarks);
		}
	}
?>