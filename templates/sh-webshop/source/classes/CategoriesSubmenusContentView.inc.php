<?php
/* --------------------------------------------------------------
   CategoriesSubmenusContentView.inc.php 2011-08-29 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

class CategoriesSubmenusContentView extends ContentView
{
	var $v_customers_status_id = false;
	var $v_language = false;
	var $v_currency = false;

	function CategoriesSubmenusContentView()
	{
		$this->set_content_template('module/submenus.html');
		$this->set_caching_enabled(true);

		$this->v_customers_status_id = $_SESSION['customers_status']['customers_status_id'];
		$this->v_language = $_SESSION['language'];
		$this->v_currency = $_SESSION['currency'];
	}

	function set_customers_status_id($p_customers_status_id)
	{
		$this->v_customers_status_id = (int)$p_customers_status_id;
	}
	
	function get_html($p_cPath, $p_parent_categories_id = 0)
	{
		$c_parent_categories_id = (int)$p_parent_categories_id;

		$this->clear_cache_id_elements();
		$this->add_cache_id_elements(array(
										$this->v_customers_status_id,
										$this->v_language,
										$this->v_currency,
										$p_cPath,
										$p_parent_categories_id
									));

		if($this->is_cached() == false)
		{
			# Categories Submenus
			$coo_categories_content_view = MainFactory::create_object('CategoriesContentView');
			$coo_categories_content_view->set_content_template('module/categories_submenus.html');
			$coo_categories_content_view->set_tree_depth(1);

			$coo_categories_agent =& MainFactory::create_object('CategoriesAgent', array(), true);
			$t_categories_info_array = $coo_categories_agent->get_categories_info_tree($c_parent_categories_id, $_SESSION['languages_id'], 0);

			$t_html = '';
			for($i=0; $i<sizeof($t_categories_info_array); $i++)
			{
				$t_categories_id = $t_categories_info_array[$i]['data']['id'];
				$t_html .= $coo_categories_content_view->get_html($t_categories_id);
			}

			if(isset($p_cPath))
			{
				$t_categories_array = array();

				if(strpos($p_cPath, '_') === false)
				{
					$t_categories_array[] = $p_cPath;
				}
				else
				{
					$t_categories_array = explode('_', $p_cPath);
				}

				for($i = 0; $i < count($t_categories_array); $i++)
				{
					if((int)$t_categories_array[$i] > 0)
					{
						$t_categories_info_array = $coo_categories_agent->get_categories_info_tree($t_categories_array[$i], $_SESSION['languages_id'], 0);

						for($j = 0; $j < count($t_categories_info_array); $j++)
						{
							$t_categories_id = $t_categories_info_array[$j]['data']['id'];
							$t_html .= $coo_categories_content_view->get_html($t_categories_id);
						}
					}
				}
				unset($t_categories_array);
			}

			$this->set_content_data('HTML',	$t_html);
		}
		else
		{
			if(is_object($GLOBALS['coo_debugger'])) $GLOBALS['coo_debugger']->log('CategoriesSubmenusContentView get_html USE_CACHE', 'SmartyCache');
		}
		
		$t_html_output = $this->build_html();

		return $t_html_output;
	}
}
?>