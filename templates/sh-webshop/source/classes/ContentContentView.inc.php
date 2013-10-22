<?php
/* --------------------------------------------------------------
   ContentContentView.inc.php 2011-11-30 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio GmbH
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

class ContentContentView extends ContentView
{
	function ContentContentView()
	{
		$this->set_content_template('boxes/box_content.html');
	}

	function get_html($p_file_flag_name)
	{
		$coo_seo_boost = MainFactory::create_object('GMSEOBoost');
		$t_html_output = '';
		
		if(GROUP_CHECK == 'true')
		{
			$t_group_check = "AND group_ids LIKE '%c_".$_SESSION['customers_status']['customers_status_id']."_group%'";
		}
	
		$t_sql = "SELECT
						content_id,
						categories_id,
						parent_id,
						content_title,
						content_group,
						gm_link,
						gm_link_target
					FROM
						content_manager AS cm LEFT JOIN cm_file_flags AS ff USING (file_flag)
					WHERE
						ff.file_flag_name = '". addslashes($p_file_flag_name) ."' AND
						languages_id = '". (int) $_SESSION['languages_id'] ."' AND
						content_status = 1
						".$t_group_check."
					ORDER BY
						sort_order";

		$t_result = xtDBquery($t_sql);

		$t_content_links_array = array();

		while($t_content_array = xtc_db_fetch_array($t_result, true))
		{
			if($t_content_array['content_group'] == '98' && gm_get_conf('GM_EBAY_ACTIVE') == 'false')
			{
		
			} 
			else
			{
				$t_sef_parameter = '';
				if(SEARCH_ENGINE_FRIENDLY_URLS == 'true')
				{
					$t_sef_parameter = '&content=' . xtc_cleanName($t_content_array['content_title']);
				}
				
				if(empty($t_content_array['gm_link']))
				{
					if($coo_seo_boost->boost_content)
					{
						$t_content_url = xtc_href_link($coo_seo_boost->get_boosted_content_url($t_content_array['content_id'], $_SESSION['languages_id']));
					}
					else
					{
						$t_content_url = xtc_href_link(FILENAME_CONTENT, 'coID='.$t_content_array['content_group'].$t_sef_parameter);
					}
					$t_content_string .= '<li><a href="'.$t_content_url.'">'.htmlspecialchars_wrapper($t_content_array['content_title']).'</a></li>';

					if(strstr($t_content_url, $_SERVER['REQUEST_URI']) !== false && $_SERVER['REQUEST_URI'] != DIR_WS_CATALOG) $t_selected = true; else $t_selected = false;
					$t_content_links_array[] = array(
												'NAME' => htmlspecialchars_wrapper($t_content_array['content_title']),
												'SELECTED' => (int)$t_selected,
												'URL' => $t_content_url,
												'URL_TARGET' => ''
											);
				}
				else
				{
					$t_content_string .= '<li><a href="'.$t_content_array['gm_link'].'" target="'.$t_content_array['gm_link_target'].'">'.htmlspecialchars_wrapper($t_content_array['content_title']).'</a></li>';

					if(strstr($t_content_array['gm_link'], $_SERVER['REQUEST_URI']) !== false && $_SERVER['REQUEST_URI'] != DIR_WS_CATALOG) $t_selected = true; else $t_selected = false;
					$t_content_links_array[] = array(
												'NAME' => htmlspecialchars_wrapper($t_content_array['content_title']),
												'SELECTED' => (int)$t_selected,
												'URL' => $t_content_array['gm_link'],
												'URL_TARGET' => $t_content_array['gm_link_target']
											);
				}
			}
		}
		
		if($t_content_string != '')
		{
			$this->set_content_data('CONTENT_LINKS_DATA', $t_content_links_array);
			$this->set_content_data('CONTENT', $t_content_string);
			$t_html_output = $this->build_html();
		}
				
		return $t_html_output;
	}
}

?>