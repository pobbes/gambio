<?php
/* --------------------------------------------------------------
   gm_topmenu.php 2012-06-26 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

$Id: newsletter.php,v 1.0 

   XTC-NEWSLETTER_RECIPIENTS RC1 - Contribution for XT-Commerce http://www.xt-commerce.com
   by Matthias Hinsche http://www.gamesempire.de

   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com 
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce www.oscommerce.com 
   (c) 2003	 nextcommerce www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

	 
$box_smarty = new smarty;
$box_smarty->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/'); 
$box_content='';

$box_smarty->assign('HOME_URL', xtc_href_link(FILENAME_DEFAULT, '', 'NONSSL'));

if(!isset($_SESSION['customer_id'])) {
	$box_smarty->assign('LOGIN_URL', xtc_href_link(FILENAME_LOGIN, '', 'NONSSL'));
} else {
	$box_smarty->assign('LOGOFF_URL', xtc_href_link(FILENAME_LOGOFF, '', 'NONSSL'));
	$box_smarty->assign('ACCOUNT_URL', xtc_href_link(FILENAME_ACCOUNT, '', 'NONSSL'));
}

$t_gm_show_wishlist = gm_get_conf('GM_SHOW_WISHLIST');
if($t_gm_show_wishlist == 'true')
{
	$box_smarty->assign('WISHLIST_URL', xtc_href_link(FILENAME_WISHLIST, '', 'NONSSL'));
}

$box_smarty->assign('CART_URL', xtc_href_link(FILENAME_SHOPPING_CART, '', 'NONSSL'));
$box_smarty->assign('CHECKOUT_URL', xtc_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));

// BOF GM_MOD:
$box_smarty->assign('SEARCH_FORM_ACTION_URL', xtc_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', 'NONSSL', false, true, true));
$box_smarty->assign('SEARCH_FORM_SUBMIT', xtc_image_submit('button_add_quick.gif', 'Go', 'id="quick_find_submit"'));

// BOF GM_MOD:
$box_smarty->assign('XTCsid', xtc_session_id());


$box_smarty->assign('language', $_SESSION['language']);
$box_smarty->assign('navtrail', $breadcrumb->trail(' &raquo; '));

$group_check = '';
if(GROUP_CHECK == 'true') {
	$group_check = "and group_ids LIKE '%c_".$_SESSION['customers_status']['customers_status_id']."_group%'";
}


$module_data = array();

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
 					and file_flag=3 ".$group_check." and content_status=1 order by sort_order";

$content_query = xtDBquery($content_query);

while($content_data = xtc_db_fetch_array($content_query, true)) 
{
	$SEF_parameter = '';
	if (SEARCH_ENGINE_FRIENDLY_URLS == 'true') 
	{
		$SEF_parameter = '&content='.xtc_cleanName($content_data['content_title']);
	}

	if(empty($content_data['gm_link']))
	{
		if($gmSEOBoost->boost_content) 
		{
			$url = xtc_href_link($gmSEOBoost->get_boosted_content_url($content_data['content_id'], $_SESSION['languages_id']));
		} 
			else 
		{
			$url = xtc_href_link(FILENAME_CONTENT, 'coID='.$content_data['content_group'].$SEF_parameter);
		}
		$target = '';	
	}
	else
	{
		$url = $content_data['gm_link'];
		$target = $content_data['gm_link_target'];
	}

	$module_data[] = array(
							'URL'		=> $url,
							'TARGET'	=> $target,
							'TEXT'		=> htmlspecialchars($content_data['content_title']),
							'IMAGE'		=> ''
						);
}
$box_smarty->assign('module_data', $module_data);


if(gm_get_conf('GM_TOPMENU_MODE') == 'mode1') {
	$tpl_file = 'box_gm_topmenu_mode1.html';
} else {
	$tpl_file = 'box_gm_topmenu_mode2.html';
}

if(gm_get_conf('GM_QUICK_SEARCH') == 'true') $box_smarty->assign('GM_QUICK_SEARCH', 'true');

// set cache ID
// BOF GM_MOD
$box_smarty->caching = 0;
$box_content = $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/'.$tpl_file);
// EOF GM_MOD
 
$smarty->assign('gm_topmenu', $box_content);
?>