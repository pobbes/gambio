<?php
/* --------------------------------------------------------------
   AdvancedSearchContentView.inc.php 2012-06-26 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(advanced_search.php,v 1.49 2003/02/13); www.oscommerce.com
   (c) 2003	 nextcommerce (advanced_search.php,v 1.13 2003/08/21); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: advanced_search.php 988 2005-06-18 16:42:42Z mz $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

// include needed functions
require_once(DIR_FS_INC . 'xtc_get_categories.inc.php');
require_once(DIR_FS_INC . 'xtc_get_manufacturers.inc.php');
require_once(DIR_FS_INC . 'xtc_checkdate.inc.php');

class AdvancedSearchContentView extends ContentView
{
	function AdvancedSearchContentView()
	{
		$this->set_content_template('module/advanced_search.html');
		$this->set_flat_assigns(true);
	}
	
	function get_html()
	{
		$this->set_content_data('FORM_ACTION', xtc_draw_form('advancedsearch', xtc_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', 'NONSSL', false, true, true), 'get', '').xtc_hide_session_id(), 1);
		$this->set_content_data('FORM_ID', 'advancedsearch');
		$this->set_content_data('FORM_ACTION_URL', xtc_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', 'NONSSL', false, true, true));
		$this->set_content_data('FORM_METHOD', 'get');

		$this->set_content_data('SESSION_ID', xtc_session_id());

		$this->set_content_data('INPUT_KEYWORDS', xtc_draw_input_field('keywords', '', '', 'text', true, 'gm_class_input inactive_input'), 1);
		$this->set_content_data('INPUT_KEYWORDS_NAME', 'keywords');

		$this->set_content_data('HELP_LINK', 'javascript:popupWindow(\''.xtc_href_link(FILENAME_POPUP_SEARCH_HELP).'\')', 1);
		$this->set_content_data('HELP_URL', xtc_href_link(FILENAME_POPUP_SEARCH_HELP));
		$this->set_content_data('BUTTON_SUBMIT', xtc_image_submit('button_search.gif', IMAGE_BUTTON_SEARCH));

		$t_categories_array = array();
		$t_categories_array = xtc_get_categories(array(array('id' => '', 'text' => TEXT_ALL_CATEGORIES)));
		$this->set_content_data('categories_data', $t_categories_array);
		$this->set_content_data('SELECT_CATEGORIES_NAME', 'categories_id');
		$this->set_content_data('SELECT_CATEGORIES',xtc_draw_pull_down_menu('categories_id', xtc_get_categories(array (array ('id' => '', 'text' => TEXT_ALL_CATEGORIES))), '',''), 1);
		
		$this->set_content_data('ENTRY_SUBCAT',xtc_draw_checkbox_field('inc_subcat', '1', true), 1);
		$this->set_content_data('INPUT_SUBCAT_NAME', 'inc_subcat');
		$this->set_content_data('INPUT_SUBCAT_VALUE', '1');
		
		$t_manufacturers_array = array();
		$t_manufacturers_array = xtc_get_manufacturers(array(array('id' => '', 'text' => TEXT_ALL_MANUFACTURERS)));
		$this->set_content_data('manufacturers_data', $t_manufacturers_array);
		$this->set_content_data('SELECT_MANUFACTURERS_NAME', 'manufacturers_id');
		$this->set_content_data('SELECT_MANUFACTURERS',xtc_draw_pull_down_menu('manufacturers_id', xtc_get_manufacturers(array (array ('id' => '', 'text' => TEXT_ALL_MANUFACTURERS))), '',''), 1);
		
		$this->set_content_data('SELECT_PFROM',xtc_draw_input_field('pfrom', '', '', 'text', true, 'gm_class_input inactive_input'), 1);
		$this->set_content_data('SELECT_PFROM_NAME', 'pfrom');

		$this->set_content_data('SELECT_PTO',xtc_draw_input_field('pto', '', '', 'text', true, 'gm_class_input inactive_input'), 1);
		$this->set_content_data('SELECT_PTO_NAME', 'pto');

		$error = '';
		if (isset ($_GET['errorno'])) {
			if (($_GET['errorno'] & 1) == 1) {
				$error .= str_replace('\n', '<br />', JS_AT_LEAST_ONE_INPUT);
			}
			if (($_GET['errorno'] & 10) == 10) {
				$error .= str_replace('\n', '<br />', JS_INVALID_FROM_DATE);
			}
			if (($_GET['errorno'] & 100) == 100) {
				$error .= str_replace('\n', '<br />', JS_INVALID_TO_DATE);
			}
			if (($_GET['errorno'] & 1000) == 1000) {
				$error .= str_replace('\n', '<br />', JS_TO_DATE_LESS_THAN_FROM_DATE);
			}
			if (($_GET['errorno'] & 10000) == 10000) {
				$error .= str_replace('\n', '<br />', JS_PRICE_FROM_MUST_BE_NUM);
			}
			if (($_GET['errorno'] & 100000) == 100000) {
				$error .= str_replace('\n', '<br />', JS_PRICE_TO_MUST_BE_NUM);
			}
			if (($_GET['errorno'] & 1000000) == 1000000) {
				$error .= str_replace('\n', '<br />', JS_PRICE_TO_LESS_THAN_PRICE_FROM);
			}
			if (($_GET['errorno'] & 10000000) == 10000000) {
				$error .= str_replace('\n', '<br />', JS_INVALID_KEYWORDS);
			}
		}

		if(gm_get_conf('GM_OPENSEARCH_SEARCH') == 1)
		{
			$this->set_content_data('gm_opensearch_link_text', gm_get_content('GM_OPENSEARCH_LINK', $_SESSION['languages_id']));
			$this->set_content_data('gm_opensearch_link', xtc_href_link('export/opensearch_' . $_SESSION['languages_id']  . '.xml'));
		}

		$this->set_content_data('error', $error);
		$this->set_content_data('FORM_END', '</form>', 1);

		$t_html_output = $this->build_html();		

		return $t_html_output;
	}
}
?>