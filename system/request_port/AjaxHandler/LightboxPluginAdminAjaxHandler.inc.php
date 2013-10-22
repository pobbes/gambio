<?php
/* --------------------------------------------------------------
   LightboxPluginAdminAjaxHandler.inc.php 2011-12-20 tb@gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

class LightboxPluginAdminAjaxHandler extends AjaxHandler
{
	function get_permission_status($p_customers_id=NULL)
	{
		if($_SESSION['customers_status']['customers_status_id'] === '0')
		{
			#admins only
			return true;
		}
		return false;
	}

	function proceed()
	{
		$t_output_array = array();
		$t_enable_json_output = true;

		$t_action_request = $this->v_data_array['POST']['action'];

		switch($t_action_request)
		{
			case 'get_template':
				$c_template = $this->v_data_array['POST']['template'];
				$c_className = $this->v_data_array['POST']['className'];
				$c_param = $this->v_data_array['POST']['param'];
				$t_html_template = $this->get_template($c_template, $c_className, $c_param);

				$t_enable_json_output = false;
				$this->v_output_buffer = $t_html_template;
				break;
				
			default:
				print_r($_GET);
				trigger_error('t_action_request not found: '. htmlentities_wrapper($t_action_request));
				return false;
		}

		if($t_enable_json_output)
		{
			$coo_json = MainFactory::create_object('GMJSON', array(false));
			$t_output_json = $coo_json->encode($t_output_array);

			$this->v_output_buffer = $t_output_json;
		}
		return true;
	}

	function get_template($p_template_name, $p_className, $p_param)
	{
		$coo_view = MainFactory::create_object($p_className.'ContentView');
		$coo_view->set_template_dir(DIR_FS_CATALOG.'admin/templates/');
		$coo_view->set_content_template($p_template_name);
    
		$t_html = $coo_view->get_html($p_param);
		return $t_html;
	}
}
?>