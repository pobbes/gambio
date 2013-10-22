<?php
/* --------------------------------------------------------------
   content.php 2008-08-09 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(information.php,v 1.6 2003/02/10); www.oscommerce.com
   (c) 2003	 nextcommerce (content.php,v 1.2 2003/08/21); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: content.php 1302 2005-10-12 16:21:29Z mz $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
$box_smarty = new smarty;
$content_string = '';

$box_smarty->assign('language', $_SESSION['language']);
// set cache ID
if (!CacheCheck()) {
	$cache=false;
	$box_smarty->caching = 0;
} else {
	$cache=true;
	$box_smarty->caching = 1;
	$box_smarty->cache_lifetime = CACHE_LIFETIME;
	$box_smarty->cache_modified_check = CACHE_CHECK;
	$cache_id = $_SESSION['language'].$_SESSION['customers_status']['customers_status_id'];
}

if (!$box_smarty->is_cached(CURRENT_TEMPLATE.'/boxes/box_content.html', $cache_id) || !$cache) {

	$box_smarty->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');

	if (GROUP_CHECK == 'true') {
		$group_check = "and group_ids LIKE '%c_".$_SESSION['customers_status']['customers_status_id']."_group%'";
	}
	// BOF GM_MOD
	$content_query = "SELECT
	 					content_id,
	 					categories_id,
	 					parent_id,
	 					content_title,
	 					content_group,
						gm_link,
						gm_link_target
	 					FROM ".TABLE_CONTENT_MANAGER."
	 					WHERE languages_id='".(int) $_SESSION['languages_id']."'
	 					and file_flag=1 ".$group_check." and content_status=1 order by sort_order";

	$content_query = xtDBquery($content_query);

	while ($content_data = xtc_db_fetch_array($content_query, true)) {
		if($content_data['content_group'] == '98' && gm_get_conf('GM_EBAY_ACTIVE') == 'false') {
		
		} else {
			$SEF_parameter = '';
			if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
				$SEF_parameter = '&content='.xtc_cleanName($content_data['content_title']);

			// BOF GM_MOD
			if(empty($content_data['gm_link']))
			{
				if($gmSEOBoost->boost_content) {
					$gm_content_url = xtc_href_link($gmSEOBoost->get_boosted_content_url($content_data['content_id'], $_SESSION['languages_id']));
				} else {
					$gm_content_url = xtc_href_link(FILENAME_CONTENT, 'coID='.$content_data['content_group'].$SEF_parameter);
				}
				$content_string .= '<img src="templates/'.CURRENT_TEMPLATE.'/img/icon_arrow.gif" alt="" /> <a href="'.$gm_content_url.'">'.htmlspecialchars($content_data['content_title']).'</a><br />';
			}
			else{
				$content_string .= '<img src="templates/'.CURRENT_TEMPLATE.'/img/icon_arrow.gif" alt="" /> <a href="'.$content_data['gm_link'].'" target="'.$content_data['gm_link_target'].'">'.htmlspecialchars($content_data['content_title']).'</a><br />';
			}		
			// EOF GM_MOD
		}
	}

		if ($content_string != '')
			$box_smarty->assign('BOX_CONTENT', $content_string);
	
}

if (!$cache) {
	$box_content = $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_content.html');
} else {
	$box_content = $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_content.html', $cache_id);
}

			$gm_box_pos = $coo_template_control->get_menubox_position('content');
			
	$smarty->assign($gm_box_pos, $box_content);
?>