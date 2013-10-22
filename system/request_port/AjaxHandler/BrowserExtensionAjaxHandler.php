<?php
/* --------------------------------------------------------------
   BrowserExtensionAjaxHandler.inc.php 2011-11-03 tb@gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

class BrowserExtensionAjaxHandler extends AjaxHandler
{
	function get_permission_status($p_customers_id=NULL)
	{
		return true;
	}

	function proceed()
	{
		$t_output_array = array();
		$t_enable_json_output = true;

		$t_action_request = $this->v_data_array['GET']['action'];
		
		$t_token_request = $this->v_data_array['GET']['token'];
		
		$t_language_request = $this->v_data_array['GET']['language_code'];
		
		$t_data_array_request = explode("-" ,$this->v_data_array['GET']['data']);

		$coo_json = MainFactory::create_object('BrowserExtensionControl', array(false));
		$t_output_array = $coo_json->get_data_array($t_action_request, $t_token_request, $t_language_request, $t_data_array_request);
			
		if($t_enable_json_output && is_array($t_output_array))
		{
			$coo_json = MainFactory::create_object('GMJSON', array(false));
			$t_output_json = $coo_json->encode($t_output_array);

			$this->v_output_buffer = $t_output_json;
		}
		return true;
	}
}
?>