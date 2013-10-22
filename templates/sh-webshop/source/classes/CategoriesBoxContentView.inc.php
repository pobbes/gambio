<?php
/* --------------------------------------------------------------
   CategoriesBoxContentView.inc.php 2011-12-02 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

class CategoriesBoxContentView extends ContentView
{
	function CategoriesBoxContentView()
	{
		$this->set_content_template('boxes/box_categories.html');
		$this->set_caching_enabled(true);
	}
	
	function get_html($p_cPath)
	{
		$this->add_cache_id_elements(array(
										$p_cPath
									));

		if($this->is_cached() == false)
		{
			if(is_object($GLOBALS['coo_debugger'])) $GLOBALS['coo_debugger']->log('CategoriesBoxContentView get_html NO_CACHE', 'SmartyCache');

			$coo_categories_box = MainFactory::create_object('CategoriesBox', array($p_cPath));
			$this->set_content_data('BOX_CONTENT', $coo_categories_box->get());
		}
		else
		{
			if(is_object($GLOBALS['coo_debugger'])) $GLOBALS['coo_debugger']->log('CategoriesBoxContentView get_html USE_CACHE', 'SmartyCache');
		}
		$t_html_output = $this->build_html();
		
		return $t_html_output;
	}
}
?>