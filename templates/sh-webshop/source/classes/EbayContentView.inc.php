<?php
/* --------------------------------------------------------------
   EbayContentView.inc.php 2010-09-24 gambio
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

class EbayContentView extends ContentView
{
	function EbayContentView()
	{
		$this->set_content_template('boxes/box_gm_ebay.html');
	}

	function get_html()
	{
		$coo_seo_boost = MainFactory::create_object('GMSEOBoost');

		if(gm_get_conf('GM_EBAY_ACTIVE') == 'true' || $_SESSION['style_edit_mode'] == 'edit')
		{
			$t_sef_parameter = '';

			if (GROUP_CHECK == 'true' && $_SESSION['style_edit_mode'] != 'edit') {
				$t_group_check = " AND group_ids LIKE '%c_".$_SESSION['customers_status']['customers_status_id']."_group%'";
			} else {
				$t_group_check = '';
			}
			
			$t_result = xtc_db_query("SELECT
											content_title,
											content_id,
											content_group
										FROM " . TABLE_CONTENT_MANAGER . "
										WHERE
											content_group = '98' AND
											languages_id = '".(int) $_SESSION['languages_id'] . "'
											" . $t_group_check);
			$t_content_data_array = xtc_db_fetch_array($t_result);

			if(xtc_db_num_rows($t_result) > 0)
			{
				if($coo_seo_boost->boost_content)
				{
					$t_ebay_url = xtc_href_link($coo_seo_boost->get_boosted_content_url($t_content_data_array['content_id'], $_SESSION['languages_id']));
				}
				else
				{
					if(SEARCH_ENGINE_FRIENDLY_URLS == 'true')
					{
						$t_sef_parameter = '&content='.xtc_cleanName($t_content_data_array['content_title']);
					}
					$t_ebay_url = xtc_href_link(FILENAME_CONTENT, 'coID='.$t_content_data_array['content_group']. $t_sef_parameter);
				}

				if(gm_get_conf('GM_LOGO_EBAY_USE') == '1') {
					$t_ebay_logo = MainFactory::create_object('GMLogoManager', array("gm_logo_ebay"));
					$t_ebay = '<a href="' . $t_ebay_url . '">' . $t_ebay_logo->get_logo(htmlspecialchars_wrapper($t_content_data_array['content_title'])) . '</a>';
				}
				else
				{
					$t_ebay = '<a href="' . $t_ebay_url . '">' . GM_TITLE_EBAY . '</a>';
				}

				$this->set_content_data('CONTENT',	$t_ebay);
				$t_html_output = $this->build_html();
			}
		}
				
		return $t_html_output;
	}
}

?>