<?php
/* --------------------------------------------------------------
   gm_ebay.php 2008-08-10 gambio
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
if(gm_get_conf('GM_EBAY_ACTIVE') == 'true' || $_SESSION['style_edit_mode'] == 'edit') {
	
	$box_smarty = new smarty;
	$box_smarty->assign('tpl_path', 'templates/' . CURRENT_TEMPLATE . '/');
	$SEF_parameter = '';

	if (GROUP_CHECK == 'true' && $_SESSION['style_edit_mode'] != 'edit') {
		$group_check = " AND group_ids LIKE '%c_".$_SESSION['customers_status']['customers_status_id']."_group%'";
	} else {
		$group_check = '';
	}
	
	$gm_query = xtc_db_query("
							SELECT
								content_title,
								content_id,
								content_group
							FROM " . 
								TABLE_CONTENT_MANAGER . "
							WHERE 
								content_group = '98'
							AND
								languages_id='".(int) $_SESSION['languages_id'] . "'
							" . $group_check . "" 
							); 

	$content_data = xtc_db_fetch_array($gm_query);

	if(xtc_db_num_rows($gm_query) > 0){
		if($gmSEOBoost->boost_content) {
			$gm_ebay_url = xtc_href_link($gmSEOBoost->get_boosted_content_url($content_data['content_id'], $_SESSION['languages_id']));
		} else {
			if (SEARCH_ENGINE_FRIENDLY_URLS == 'true') {
				$SEF_parameter = '&content='.xtc_cleanName($content_data['content_title']);
			}
			$gm_ebay_url = xtc_href_link(FILENAME_CONTENT, 'coID='.$content_data['content_group']. $SEF_parameter);
		}

		if(gm_get_conf('GM_LOGO_EBAY_USE') == '1') {
					
			$gm_ebay_logo = MainFactory::create_object('GMLogoManager', array("gm_logo_ebay"));
			$ebay = '<a href="' . $gm_ebay_url . '">' . $gm_ebay_logo->get_logo(htmlspecialchars($content_data['content_title'])) . '</a>';				
		} else {
			$ebay = '<a href="' . $gm_ebay_url . '">' . GM_TITLE_EBAY . '</a>';				
		}
		
		$box_smarty->assign('BOX_CONTENT', $ebay);

		// set cache ID
		$box_smarty->caching = 0;
		$box_smarty->assign('language', $_SESSION['language']);
		$box_gm_ebay = $box_smarty->fetch(CURRENT_TEMPLATE . '/boxes/box_gm_ebay.html');

			$gm_box_pos = $coo_template_control->get_menubox_position('gm_ebay');
		$smarty->assign($gm_box_pos,$box_gm_ebay);
	}
}
?>