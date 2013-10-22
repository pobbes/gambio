<?php
/* --------------------------------------------------------------
   search.php 2012-06-26 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(search.php,v 1.22 2003/02/10); www.oscommerce.com 
   (c) 2003	 nextcommerce (search.php,v 1.9 2003/08/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: search.php 1262 2005-09-30 10:00:32Z mz $)

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
$box_smarty = new smarty;
$box_smarty->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
$box_content = '';

require_once (DIR_FS_INC.'xtc_image_submit.inc.php');
require_once (DIR_FS_INC.'xtc_hide_session_id.inc.php');

$box_smarty->assign('FORM_ACTION', xtc_draw_form('quick_find', xtc_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', 'NONSSL', false, true, true), 'get').xtc_hide_session_id());
$box_smarty->assign('INPUT_SEARCH', xtc_draw_input_field('keywords', '', 'size="20" maxlength="30"'));
// BOF GM_MOD:
$box_smarty->assign('BUTTON_SUBMIT', xtc_image_submit('button_add_quick.gif', IMAGE_BUTTON_SEARCH));
$box_smarty->assign('FORM_END', '</form>');
$box_smarty->assign('LINK_ADVANCED', xtc_href_link(FILENAME_ADVANCED_SEARCH));
$box_smarty->assign('BOX_CONTENT', $box_content);

if(gm_get_conf('GM_OPENSEARCH_BOX') == '1') {
	$oa = '<span class="gm_opensearch" onclick="add_opensearch(\'' . xtc_href_link('export/opensearch_' . $_SESSION['languages_id']  . '.xml') . '\', \'' . TEXT_OPENSEARCH . '\');">' . gm_get_content('GM_OPENSEARCH_TEXT', $_SESSION['languages_id']) . '</span> [<span class="gm_opensearch_info">info</span>]';
	$box_smarty->assign('GM_OPENSEARCH_LINK', $oa);
}

$box_smarty->assign('language', $_SESSION['language']);
// set cache ID
 if (!CacheCheck()) {
	$box_smarty->caching = 0;
	$box_search = $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_search.html');
} else {
	$box_smarty->caching = 1;
	$box_smarty->cache_lifetime = CACHE_LIFETIME;
	$box_smarty->cache_modified_check = CACHE_CHECK;
	$cache_id = $_SESSION['language'];
	$box_search = $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_search.html', $cache_id);
}
			$gm_box_pos = $coo_template_control->get_menubox_position('search');
			
	$smarty->assign($gm_box_pos, $box_search);
?>