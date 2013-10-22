<?php
/* --------------------------------------------------------------
   SearchContentView.inc.php 2012-06-25 gm
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

require_once(DIR_FS_INC . 'xtc_image_submit.inc.php');
require_once(DIR_FS_INC . 'xtc_hide_session_id.inc.php');

class SearchContentView extends ContentView
{
	function SearchContentView()
	{
		$this->set_content_template('boxes/box_search.html');
	}

	function get_html()
	{
		$this->set_content_data('FORM_ACTION', xtc_draw_form('quick_find', xtc_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', 'NONSSL', false, true, true), 'get').xtc_hide_session_id(), 1);
		$this->set_content_data('FORM_ID', 'quick_find');
		$this->set_content_data('FORM_METHOD', 'get');
		$this->set_content_data('FORM_ACTION_URL', xtc_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', 'NONSSL', false, true, true));
		$this->set_content_data('SESSION_ID', xtc_session_id());
		$this->set_content_data('INPUT_SEARCH', xtc_draw_input_field('keywords', '', 'size="20" maxlength="30"'), 1);
		$this->set_content_data('INPUT_NAME', 'keywords');
		$this->set_content_data('BUTTON_SUBMIT', xtc_image_submit('button_add_quick.gif', IMAGE_BUTTON_SEARCH), 1);
		$this->set_content_data('FORM_END', '</form>', 1);
		$this->set_content_data('LINK_ADVANCED', xtc_href_link(FILENAME_ADVANCED_SEARCH));

		if(gm_get_conf('GM_OPENSEARCH_BOX') == '1')
		{
			$t_opensearch = '<span class="gm_opensearch" onclick="add_opensearch(\'' . xtc_href_link('export/opensearch_' . $_SESSION['languages_id']  . '.xml') . '\', \'' . TEXT_OPENSEARCH . '\');">' . gm_get_content('GM_OPENSEARCH_TEXT', $_SESSION['languages_id']) . '</span> [<span class="gm_opensearch_info">info</span>]';
			$this->set_content_data('GM_OPENSEARCH_LINK', $t_opensearch, 1);
			$this->set_content_data('GM_OPENSEARCH_TITLE', TEXT_OPENSEARCH);
			$this->set_content_data('GM_OPENSEARCH_TEXT', gm_get_content('GM_OPENSEARCH_TEXT', $_SESSION['languages_id']));

		}

		$t_html_output = $this->build_html();
		
		return $t_html_output;
	}
}

?>