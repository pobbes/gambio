<?php
/* --------------------------------------------------------------
   LanguagesContentView.inc.php 2010-09-23 gambio
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

class LanguagesContentView extends ContentView
{
	function LanguagesContentView()
	{
		$this->set_content_template('boxes/box_languages.html');
	}

	function get_html($p_coo_languages, $p_request_type)
	{
		$t_html_output = '';
		$t_languages_string = '';
		$t_languages_array = array();
		$t_link = '';
		$languages_count = 0;

		reset($p_coo_languages->catalog_languages);
		while(list($t_key, $t_value) = each($p_coo_languages->catalog_languages))
		{
			$languages_count++;

			$t_params_check = xtc_get_all_get_params(array('language', 'currency'));
			if(!empty($t_params_check))
			{
				$t_languages_string .= ' <a href="' . xtc_href_link(basename(gm_get_env_info('PHP_SELF')), 'language=' . $t_key.'&'.xtc_get_all_get_params(array('language', 'currency')), $p_request_type) . '">' . xtc_image('lang/' .  $t_value['directory'] .'/' . $t_value['image'], $t_value['name']) . '</a> ';
				$t_link = xtc_href_link(basename(gm_get_env_info('PHP_SELF')), 'language=' . $t_key.'&'.xtc_get_all_get_params(array('language', 'currency')), $p_request_type);
			}
			else
			{
				if(strstr(basename(gm_get_env_info('PHP_SELF')), '.') !== false)
				{
					$t_basename = basename(gm_get_env_info('PHP_SELF'));
				}
				else
				{
					$t_basename = '';
				}
				$t_languages_string .= ' <a href="' . xtc_href_link($t_basename, 'language=' . $t_key, $p_request_type) . '">' . xtc_image('lang/' .  $t_value['directory'] .'/' . $t_value['image'], $t_value['name']) . '</a> ';
				$t_link = xtc_href_link($t_basename, 'language=' . $t_key, $p_request_type);
			}

			$t_languages_array[] = array('NAME' => $t_value['name'],
											'ID' => $t_value['id'],
											'ICON' => 'lang/' . basename($t_value['directory']) . '/' . $t_value['image'],
											'ICON_SMALL' => 'lang/' . basename($t_value['directory']) . '/' . basename($t_value['code']) . '.png',
											'CODE' => $t_value['code'],
											'DIRECTORY' => $t_value['directory'],
											'LINK' => $t_link);
		}

		// dont show box if there's only 1 language
		if($languages_count > 1 )
		{
			$this->set_content_data('CONTENT', $t_languages_string);
			$this->set_content_data('CURRENT_LANGUAGES_ID', $_SESSION['languages_id']);
			$this->set_content_data('languages_data', $t_languages_array);
			$t_html_output = $this->build_html();
		}
		
		return $t_html_output;
	}
}

?>