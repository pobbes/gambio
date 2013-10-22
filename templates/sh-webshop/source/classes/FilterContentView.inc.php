<?php
/* --------------------------------------------------------------
   SearchContentView.inc.php 2012-06-25 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/
?><?php

class FilterContentView extends ContentView
{
  /*
   * constructor
   */
	function FilterContentView()
	{
		$this->set_content_template('boxes/box_filter.html');
	}


  /*
   * create HTML code for every feature
   * @param int $p_categories_id  category_id
   * @param int $p_language_id  shop language_id
   * @param array $p_selected_feature_value_id_array  array with feature value ids
   * @return array $t_html_output  the HTML code as array for output
   */
	function get_html($p_categories_id, $p_language_id, $p_selected_feature_value_id_array=false, $p_price_start=false, $p_price_end=false)
	{
		$c_categories_id = (int) $p_categories_id;
    $c_language_id   = (int) $p_language_id;

		$t_selected_feature_value_id_array = array();
		if(is_array($p_selected_feature_value_id_array))
		{
			if(is_object($GLOBALS['coo_debugger'])) $GLOBALS['coo_debugger']->log('FilterContentView get_html() $p_selected_feature_value_id_array: '. print_r($p_selected_feature_value_id_array, true), 'FilterManager');
			$t_selected_feature_value_id_array = $p_selected_feature_value_id_array;
		}
		
		$t_coo_control = MainFactory::create_object('FeatureControl');
		$t_coo_cat_filter = $t_coo_control->get_categories_filter_array(array('categories_id'=>$c_categories_id), array('sort_order'));

		$t_html_output = '';
		$t_html_array = array();

		foreach ($t_coo_cat_filter as $t_key => $t_coo_filter)
		{
			$t_feature_id          = $t_coo_filter->v_feature_id;
			$t_sort_order          = $t_coo_filter->v_sort_order;
			$t_mode                = $t_coo_filter->v_selection_preview_mode;
			$t_template            = $t_coo_filter->v_selection_template;
			$t_value_conjunction   = $t_coo_filter->v_value_conjunction;
			$t_feature_name        = $t_coo_filter->get_feature_name($c_language_id);
			$t_feature_value_array = $t_coo_control->get_feature_value_array(array('feature_id'=>$t_feature_id), array('sort_order'));

			$t_feature_value_data_array = array();
			foreach ($t_feature_value_array as $f_key => $f_coo_feature)
			{
				$t_feature_value_id   = $f_coo_feature->v_feature_value_id;
				$t_feature_value_name = $f_coo_feature->v_feature_value_text_array[$c_language_id];

				# feature_value_id selected TRUE/FALSE
				$t_feature_value_selected = in_array($t_feature_value_id, $t_selected_feature_value_id_array);

				$t_feature_value_data_array[] = array(
													'ID' => $t_feature_value_id,
													'NAME' => $t_feature_value_name,
													'SELECTED' => $t_feature_value_selected
												);
			}

			$t_coo_content_view = new ContentView();
			$t_coo_content_view->set_content_template('module/filter_selection/'.$t_template);

			$t_coo_content_view->set_content_data('FEATURE_NAME', $t_feature_name);
			$t_coo_content_view->set_content_data('FEATURE_VALUE_DATA', $t_feature_value_data_array);
			$t_coo_content_view->set_content_data('FEATURE_ID', $t_feature_id);
			$t_coo_content_view->set_content_data('VALUE_CONJUNCTION', (int)$t_value_conjunction);

			$t_html_array[] = $t_coo_content_view->get_html(0);
		}

		if(sizeof($t_html_array) > 0 || $_SESSION['style_edit_mode'] == 'edit')
		{
			# contains html code for feature_value selections
			$this->set_content_data('FEATURE_DATA', $t_html_array);


			$coo_seo_boost = MainFactory::create_object('GMSEOBoost');
			if($coo_seo_boost->boost_categories == true)
			{
				# use boosted url
				$t_action_url = $coo_seo_boost->get_current_boost_url();
			}
			else {
				# use default url for splitting urls
				$t_action_url = basename($PHP_SELF);
			}
			$t_action_url = xtc_href_link($t_action_url, '', 'NONSSL', true, true, true);
			
			//$t_action_url = gm_get_env_info('REQUEST_URI');
			$this->set_content_data('FORM_ACTION_URL', $t_action_url);
			$this->set_content_data('CURRENCY', $_SESSION['currency']);

			# entered prices
			$t_price_start = '';
			$t_price_end = '';

			if($p_price_start !== false && !empty($p_price_start)) $t_price_start = htmlentities_wrapper($p_price_start);
			if($p_price_end !== false && !empty($p_price_end)) $t_price_end = htmlentities_wrapper($p_price_end);

			$this->set_content_data('DEFAULT_PRICE_START', $t_price_start);
			$this->set_content_data('DEFAULT_PRICE_END', $t_price_end);

			$this->set_content_data('PRICE_FILTER_FROM_ACTIVE', gm_get_conf('PRICE_FILTER_FROM_ACTIVE'));
			$this->set_content_data('PRICE_FILTER_TO_ACTIVE', gm_get_conf('PRICE_FILTER_TO_ACTIVE'));
			
			$t_html_output = $this->build_html();
		}
		return $t_html_output;
	}
}
?>