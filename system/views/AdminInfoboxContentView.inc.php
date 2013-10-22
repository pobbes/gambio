<?php
/* --------------------------------------------------------------
   AdminInfoboxContentView.inc.php 2012-08-17 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

class AdminInfoboxContentView extends ContentView
{

	function AdminInfoboxContentView()
	{
		$this->set_template_dir(DIR_FS_CATALOG.'admin/templates/');
		$this->set_content_template('admin_infobox.html');
		$this->set_caching_enabled(false);

		$this->init_smarty();
		$this->set_flat_assigns(false);
	}

	function get_html()
	{
		$coo_admin_infobox_control = MainFactory::create_object('AdminInfoboxControl');
		$t_messages_array = $coo_admin_infobox_control->get_all_messages();
		
		$this->set_content_data('messages_array', $t_messages_array);
		
		$t_html_output = $this->build_html();
	
		return $t_html_output;    
	}
}
?>