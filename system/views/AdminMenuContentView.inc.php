<?php
/* --------------------------------------------------------------
   AdminMenuContentView.inc.php 2011-09-05 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

class AdminMenuContentView extends ContentView
{

  function AdminMenuContentView()
	{
		$this->set_template_dir(DIR_FS_CATALOG.'admin/templates/');
		$this->set_content_template('admin_menu.html');

		$this->init_smarty();
		$this->set_flat_assigns(false);
	}

	function get_html( $p_customers_id )
	{
		$coo_menu_control = MainFactory::create_object('AdminMenuControl', array(false));
		$t_set_data_array = $coo_menu_control->get_menu_array($p_customers_id);
    
		if (sizeof($t_set_data_array) > 0) {
      $data_output_array = array();
      foreach($t_set_data_array AS $key1 => $t_data_group){
        if(sizeof($t_data_group['menuitems']) > 0 || $t_data_group['id'] == "BOX_HEADING_FAVORITES"){
          $data_output_array[$key1] = $t_data_group;
          foreach($t_data_group['menuitems'] AS $key2 => $t_data_item){
            $data_output_array[$key1]['menuitems'][$key2] = $t_data_item;
          }
        }
      }
			$this->set_content_data('DATA', $data_output_array);

      $t_html_output = $this->build_html();
		}
    return $t_html_output;    
  }
} 
?>