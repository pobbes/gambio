<?php
/* --------------------------------------------------------------
   ExtraboxesContentView.inc.php 2010-09-24 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommercebased on original files FROM OSCommerce CVS 2.2 2002/08/28 02:14:35 www.oscommerce.com
   (c) 2003	 nextcommerce (admin.php,v 1.12 2003/08/13); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: admin.php 1262 2005-09-30 10:00:32Z mz $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class ExtraboxesContentView extends ContentView
{
	function ExtraboxesContentView()
	{
		$this->set_content_template('boxes/box_extrabox.html');
	}

	function get_html($p_extrabox_number)
	{
		$c_extrabox_number = (int)$p_extrabox_number;
		$t_group_number = 60 + $c_extrabox_number;
		$t_html_output = '';

		if(GROUP_CHECK=='true')
		{
			$group_check = "AND group_ids LIKE '%c_".$_SESSION['customers_status']['customers_status_id']."_group%'";
		}

		$t_result = xtDBquery("SELECT *
								FROM ".TABLE_CONTENT_MANAGER."
								WHERE
									content_group='" . $t_group_number . "' and languages_id = '".$_SESSION['languages_id']."'
									" . $group_check);
		$t_content_data_array = xtc_db_fetch_array($t_result, true);

		if((xtc_db_num_rows($t_result) && $t_content_data_array['content_status'] == '1') || $_SESSION['style_edit_mode'] == 'edit')
		{
			if($t_content_data_array['content_file'] != '')
			{
				ob_start();
				if(strpos($t_content_data_array['content_file'], '.txt'))
				{
					echo '<pre>';
				}

				include(DIR_FS_CATALOG . 'media/content/' . basename($t_content_data_array['content_file']));

				if(strpos($t_content_data_array['content_file'], '.txt'))
				{
					echo '</pre>';
				}

				$t_content_body = ob_get_contents();
				ob_end_clean();
			}
			else
			{
				$t_content_body = $t_content_data_array['content_text'];
			}

			$this->set_content_data('NUMBER', $c_extrabox_number);
			$this->set_content_data('HEADING', $t_content_data_array['content_heading']);

			if($_SESSION['style_edit_mode'] == 'edit')
			{
				$t_content_body = preg_replace('!(.*?)<script.*?</script>(.*?)!is', "$1$2", $t_content_body);
			}
			$this->set_content_data('CONTENT', $t_content_body);

			$t_html_output = $this->build_html();
		}
		
		return $t_html_output;
	}
}

?>