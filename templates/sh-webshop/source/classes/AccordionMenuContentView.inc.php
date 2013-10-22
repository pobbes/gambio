<?php
/* --------------------------------------------------------------
   AccordionMenuContentView.inc.php 2013-04-17 
   --------------------------------------------------------------
*/

class AccordionMenuContentView extends ContentView
{
    
	var $v_tree_depth = 0;

	function AccordionMenuContentView()
	{
		$this->set_content_template('boxes/box_accordion_menu.html');
		$this->set_caching_enabled(false);
	}
	
	function get_html($p_current_category_id=0)
	{
		$this->add_cache_id_elements(array(
										$this->get_tree_depth(),
										$p_current_category_id
									));

		if($this->is_cached() == false)
		{
			if(is_object($GLOBALS['coo_debugger'])) $GLOBALS['coo_debugger']->log('CategoriesContentView get_html NO_CACHE', 'SmartyCache');

			$c_current_category_id = (int)$p_current_category_id;
			$t_tree_depth = $this->get_tree_depth();

			$coo_categories_agent =& MainFactory::create_object('CategoriesAgent', array(), true);
			$t_categories_info_array = $coo_categories_agent->get_categories_info_tree($c_current_category_id, $_SESSION['languages_id'], $t_tree_depth);

			$this->set_content_data('current_category_id', $c_current_category_id);
			$this->set_content_data('CATEGORIES_DATA', $t_categories_info_array);
		}
		else
		{
			if(is_object($GLOBALS['coo_debugger'])) $GLOBALS['coo_debugger']->log('CategoriesContentView get_html USE_CACHE', 'SmartyCache');
		}
		$t_html_output = $this->build_html();
		return $t_html_output;
	}

	function set_tree_depth($p_depth)
	{
		$this->v_tree_depth = (int)$p_depth;
	}

	function get_tree_depth()
	{
		return $this->v_tree_depth;
	}
    
}
?>