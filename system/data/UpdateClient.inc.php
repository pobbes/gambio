<?php
/* --------------------------------------------------------------
   UpdateClient.inc.php 2012-11-14 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

require_once(DIR_FS_CATALOG . 'gm/classes/JSON.php');

class UpdateClient 
{
	var $v_url = '';
	var $v_get_data_array = array();
	
	function UpdateClient()
	{
		$this->set_url();
		$this->set_get_data(array('name' => 'format_output_module', 'value' => 'GambioUpdate'));
		$this->set_get_data(array('name' => 'header_data_array[]', 'value' => 'Accept: application/json'));
		// todo: correct height
		$this->set_get_data(array('name' => 'iframe_style', 'value' => 'width: 100%; height: 100px;'));
	}
	
	function set_url()
	{
		include(DIR_FS_CATALOG . 'release_info.php');
				
		$t_url = 'https://www.gambio-support.de/updateinfo/';
		
		$t_get_params_array = array();
		$t_get_params_array[] = 'shop_version=' . rawurlencode($gx_version);
		$t_get_params_array[] = 'shop_url=' . rawurlencode(HTTP_SERVER . DIR_WS_CATALOG);
		$t_get_params_array[] = 'shop_key=' . rawurlencode(GAMBIO_SHOP_KEY);
		$t_get_params_array[] = 'language=' . rawurlencode($_SESSION['language_code']);
		
		$t_url .= '?' . implode('&', $t_get_params_array);
		
		$this->v_url = $t_url;
	}
	
	function get_url()
	{
		return $this->v_url;
	}
	
	function set_get_data($t_data_array)
	{
		$this->v_get_data_array[$t_data_array['name']] = $t_data_array['value']; 
	}
	
	function get_get_data_array()
	{
		return $this->v_get_data_array;
	}
	
	function load_url()
	{
		$coo_load_url = MainFactory::create_object('LoadUrl');
		
		$t_server_response = $coo_load_url->load_url($this->get_url(), array('Accept: application/json'), 'width="100%" height="85" scrolling="no" marginheight="8" marginwidth="0" frameborder="0"', false, false, 3);
		$c_server_response = (string)$t_server_response;
		
		$coo_json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
		$t_response_array = $coo_json->decode($c_server_response);
		
		return $t_response_array;
	}
}

?>