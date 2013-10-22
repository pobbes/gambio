<?php
/* --------------------------------------------------------------
   ProductMediaContentView.inc.php 2010-11-18 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2003	 nextcommerce (products_media.php,v 1.8 2003/08/25); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: products_media.php 1259 2005-09-29 16:11:19Z mz $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

require_once(DIR_FS_INC . 'xtc_filesize.inc.php');
require_once(DIR_FS_INC . 'xtc_in_array.inc.php');

class ProductMediaContentView extends ContentView
{
	function ProductMediaContentView()
	{
		$this->set_content_template('module/products_media.html');
		$this->set_flat_assigns(true);
	}
	
	function get_html($p_products_id, $p_languages_id)
	{
		$c_products_id = (int)$p_products_id;
		$c_languages_id = (int)$p_languages_id;
		$t_html_output = '';
				
		// check if allowed to see
		$t_check_result = xtDBquery("SELECT DISTINCT
											products_id
										FROM " . TABLE_PRODUCTS_CONTENT . "
										WHERE languages_id = '" . $c_languages_id . "'");

		$t_check_data_array = array();
		$i = 0;
		while($t_content_data_array = xtc_db_fetch_array($t_check_result,true))
		{
			$t_check_data_array[$i] = $t_content_data_array['products_id'];
			$i++;
		}
		
		if(xtc_in_array($c_products_id, $t_check_data_array))
		{
			$t_module_content_array = array ();

			// get content data
			if(GROUP_CHECK == 'true')
			{
				$t_group_check = "group_ids LIKE '%c_" . $_SESSION['customers_status']['customers_status_id'] . "_group%' AND";
			}
			
			//get download
			$t_content_result = xtDBquery("SELECT
												content_id,
												content_name,
												content_link,
												content_file,
												content_read,
												file_comment
											FROM " . TABLE_PRODUCTS_CONTENT . "
											WHERE
												products_id = '" . $c_products_id . "' AND
												" . $t_group_check . "
												languages_id = '" . $c_languages_id . "'");
			while($t_content_data_array = xtc_db_fetch_array($t_content_result, true))
			{
				$t_filename = '';

				if($t_content_data_array['content_link'] != '')
				{
					$t_icon = xtc_image(DIR_WS_CATALOG . 'admin/images/icons/icon_link.gif');
					$t_icon_url = DIR_WS_CATALOG . 'admin/images/icons/icon_link.gif';
				} 
				else
				{
					$t_icon = xtc_image(DIR_WS_CATALOG . 'admin/images/icons/icon_' . str_replace('.', '', strstr($t_content_data_array['content_file'], '.')) . '.gif');
					$t_icon_url = DIR_WS_CATALOG . 'admin/images/icons/icon_' . str_replace('.', '', strstr($t_content_data_array['content_file'], '.')) . '.gif';
				}

				$t_filename .= $t_content_data_array['content_name'];

				if($t_content_data_array['content_link'] != '')
				{
					$t_filename = '<a href="' . $t_content_data_array['content_link'] . '" target="_blank">' . $t_filename . '</a>';
					$t_button_link = $t_content_data_array['content_link'];
				}
								
				$t_button = '';
				$t_button_link = 'link';

				if($t_content_data_array['content_link'] == '')
				{
					if(
						strpos(strtolower($t_content_data_array['content_file']), '.htm') !== false ||
						strpos(strtolower($t_content_data_array['content_file']), '.txt') !== false ||
						strpos(strtolower($t_content_data_array['content_file']), '.bmp') !== false ||
						strpos(strtolower($t_content_data_array['content_file']), '.jpg') !== false ||
						strpos(strtolower($t_content_data_array['content_file']), '.gif') !== false ||
						strpos(strtolower($t_content_data_array['content_file']), '.png') !== false ||
						strpos(strtolower($t_content_data_array['content_file']), '.tif') !== false ||
						strpos(strtolower($t_content_data_array['content_file']), '.jpeg') !== false ||
						strpos(strtolower($t_content_data_array['content_file']), '.pjpeg') !== false
					)
					{
						$t_button = '<a style="cursor:hand" onClick="javascript:window.open(\'' . xtc_href_link(FILENAME_MEDIA_CONTENT, 'coID='.$t_content_data_array['content_id']) . '\', \'popup\', \'toolbar=0, width=640, height=600\')">' . xtc_image_button('button_view.gif', TEXT_VIEW) . '</a>';
						$t_button_link = 'popup';
						$t_button_link = xtc_href_link(FILENAME_MEDIA_CONTENT, 'coID='.$t_content_data_array['content_id']);
					}
					else
					{
						$t_button = '<a href="' . xtc_href_link('media/products/' . $t_content_data_array['content_file']) . '" target="_blank">' . xtc_image_button('button_download.gif', TEXT_DOWNLOAD) . '</a>';
						$t_button_link = 'download';
						$t_button_link = xtc_href_link('media/products/' . $t_content_data_array['content_file']);
					}
				}
	
				$t_module_content_array[] = array(	'ICON' => $t_icon,
													'ICON_URL' => $t_icon_url,
													'FILENAME' => $t_filename,
													'DESCRIPTION' => $t_content_data_array['file_comment'],
													'FILESIZE' => xtc_filesize($t_content_data_array['content_file']),
													'BUTTON' => $t_button,
													'BUTTON_URL' => $t_button_link,
													'BUTTON_TYPE' => $t_button_type,
													'CONTENT_NAME' => $t_content_data_array['content_name'],
													'HITS' => $t_content_data_array['content_read']);
			}

			$this->set_content_data('module_content', $t_module_content_array);
			
			$t_html_output = $this->build_html();
		}

		
		return $t_html_output;
	}
	
}
?>