<?php
/* --------------------------------------------------------------
   RequestRouter.inc.php 2012-01-01 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

/**
 * Description of RequestRouter
 *
 * @author ncapuno
 */
class RequestRouter
{
	var $v_data_array = NULL;
	var $v_output_buffer = '';
	var $v_system_class_dir = '';
	var $v_user_class_dir = '';
	var $v_class_name_suffix = '';

	function RequestRouter($p_system_class_dir, $p_user_class_dir, $p_class_name_suffix)
	{
		$this->set_system_class_dir($p_system_class_dir);
		$this->set_user_class_dir($p_user_class_dir);
		$this->set_class_name_suffix($p_class_name_suffix);
	}

	function set_data($p_key, $p_value)
	{
		$c_key = trim((string) $p_key);
		if($c_key == '') {
			trigger_error('empty key given', E_USER_WARNING);
		}
		$this->v_data_array[$c_key] = $p_value;
	}

	function set_system_class_dir($p_dir)
	{
		$this->v_system_class_dir = (string)$p_dir;
	}

	function get_system_class_dir()
	{
		return $this->v_system_class_dir;
	}

	function set_user_class_dir($p_dir)
	{
		$this->v_user_class_dir = (string)$p_dir;
	}

	function get_user_class_dir()
	{
		return $this->v_user_class_dir;
	}

	function set_class_name_suffix($p_suffix)
	{
		$this->v_class_name_suffix = (string)$p_suffix;
	}

	function get_class_name_suffix()
	{
		return $this->v_class_name_suffix;
	}

	function create_module_object($p_module_name)
	{
		$coo_output_object = NULL;
		$t_system_class_dir = $this->get_system_class_dir();
		$t_user_class_dir = $this->get_user_class_dir();
		$t_class_name_suffix = $this->get_class_name_suffix();

		#class name for factory
		$t_class_name = $p_module_name.$t_class_name_suffix;

		#file path for security file check
		$t_system_class_file_path = $t_system_class_dir.$t_class_name.'.inc.php';
		$t_user_class_file_path = $t_user_class_dir.$t_class_name.'.inc.php';

		if(file_exists($t_system_class_file_path) || file_exists($t_user_class_file_path))
		{
			#class file found, build object in factory
			$coo_output_object = MainFactory::create_object($t_class_name);
		}
		return $coo_output_object;
	}

	function proceed($p_module_name)
	{
		#clean module name (path injections)
		$c_module_name = htmlentities_wrapper($p_module_name);
		$c_module_name = str_replace('/', '', $c_module_name);
		$c_module_name = str_replace('.', '', $c_module_name);

		#find and build module object
		$coo_module = $this->create_module_object($c_module_name);
		if($coo_module == NULL)
		{
			#could not build module object
			return false;
		}

		#transfer given request data to module_object
		foreach($this->v_data_array as $t_key => $t_value)
		{
			$coo_module->set_data($t_key, $t_value);
		}

		if($coo_module->get_permission_status() == false)
		{
			#permission check failed
			trigger_error('using this module ['.$c_module_name.'] is not permitted in this context', E_USER_WARNING);
			return false;
		}

		# proceed module and write response to buffer
		$coo_module->proceed();
		$this->v_output_buffer = $coo_module->get_response();
		
		return true;
	}
	
	function get_response()
	{
		$t_output = $this->v_output_buffer;
		return $t_output;
	}
}
?>