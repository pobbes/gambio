<?php
/* --------------------------------------------------------------
   gm_scroller.php 2010-08-12 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
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
	if(isset($_SESSION['languages_id'])) $lang_id = $_SESSION['languages_id'];
	else $lang_id = '2';
	
	$box_smarty = new smarty;
	$box_smarty->assign('tpl_path', 'templates/' . CURRENT_TEMPLATE . '/'); 
	$box_smarty->assign('BOX_CONTENT', $gm_scroller_content = gm_get_content('GM_SCROLLER_CONTENT', $lang_id));
	$box_smarty->assign('gm_scroller_height', gm_get_conf('GM_SCROLLER_HEIGHT'));

	// set cache ID
  $box_smarty->caching = 0;
	$box_smarty->assign('language', $_SESSION['language']);
  $box_gm_scroller = $box_smarty->fetch(CURRENT_TEMPLATE . '/boxes/box_gm_scroller.html');

			$gm_box_pos = $coo_template_control->get_menubox_position('gm_scroller');
	$smarty->assign($gm_box_pos,$box_gm_scroller);
?>