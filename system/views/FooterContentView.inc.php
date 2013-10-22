<?php
/* --------------------------------------------------------------
   FooterContentView.inc.php 2010-12-20 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(add_a_quickie.php,v 1.10 2001/12/19); www.oscommerce.com
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: add_a_quickie.php,v 1.1 2004/04/26 20:26:42 fanta2k Exp $)

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contribution:
   Add A Quickie v1.0 Autor  Harald Ponce de Leon

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/


class FooterContentView extends ContentView
{
	function FooterContentView()
	{
		$this->set_content_template('module/footer.html');
		//$this->set_caching_enabled(true);
	}
	
	function get_html()
	{
		$t_html_output = '';

		if(gm_get_conf('SHOW_FOOTER') == 'true')
		{
			if(GROUP_CHECK == 'true')
			{
				$t_group_check = "and group_ids LIKE '%c_" . $_SESSION['customers_status']['customers_status_id'] . "_group%'";
			}

			$t_content_query = xtc_db_query("SELECT *
											FROM ".TABLE_CONTENT_MANAGER."
											WHERE
												content_group = '199' AND
												languages_id = '" . $_SESSION['languages_id'] . "'
												$t_group_check
											");
			$t_content_array = xtc_db_fetch_array($t_content_query, true);

			if((xtc_db_num_rows($t_content_query) == 1 && $t_content_array['content_status'] == '1') || $_SESSION['style_edit_mode'] == 'edit')
			{
				$t_content = '';

				if($t_content_array['content_file'] != '')
				{
					ob_start();

					if(strpos($t_content_array['content_file'], '.txt'))
					{
						echo '<pre>';
					}

					include (DIR_FS_CATALOG . 'media/content/' . $t_content_array['content_file']);

					if(strpos($t_content_array['content_file'], '.txt'))
					{
						echo '</pre>';
					}

					$t_content = ob_get_contents();
					ob_end_clean();
				}
				else
				{
					$t_content = $t_content_array['content_text'];
				}

				$this->set_content_data('HTML', $t_content);

				// COPYRIGHT
				$this->set_content_data('COPYRIGHT_FOOTER', gm_get_conf('GM_FOOTER'));

				$t_html_output = $this->build_html();
			}
		}

		return $t_html_output;
	}
}
?>