<?php
/* --------------------------------------------------------------
   Debugger.inc.php 2010-11-16 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

class Debugger
{
	var $v_config_array = false;

	/*
	* constructor
	*/
	function Debugger()
	{
		$t_config = $this->get_config();
		$this->v_config_array = $t_config;
	}

	function log($p_message, $p_source='notice', $p_type='general')
	{
		$t_do_log = $GLOBALS['coo_debugger']->is_enabled($p_source);

		if($t_do_log)
		{
			# filename for log
			$t_name = 'debug-'.$p_type;

			$t_stamp	= date("Y-m-d H:i:s");
			$t_ip		= $_SERVER['REMOTE_ADDR'];
			$t_source	= $p_source;
			$t_message	= $p_message;
			$t_break	= "\n";

			# content for log entry
			$t_content = "$t_stamp [$t_ip] <$t_source> $t_message $t_break";
			
			$coo_error_log = new FileLog($t_name, true);
			$coo_error_log->write($t_content);
		}
	}

	function is_enabled($p_source)
	{
		//return false;
		$t_output = false;

		if($this->v_config_array !== false)
		{
			# debug config found
			if(in_array($p_source, $this->v_config_array['ENABLED_SOURCES']))
			{
				# source output enabled in config file
				$t_output = true;
			}
		}
		return $t_output;
	}

	function get_config()
	{
		$t_output = false;
		$t_config_file = DIR_FS_CATALOG.'includes/debug_config.inc.php';

		if(file_exists($t_config_file) == true)
		{
			$t_output = true;
			
			# load found config file
			include($t_config_file);

			# check config array and load
			if(isset($t_debug_config) && is_array($t_debug_config))
			{
				$t_output = $t_debug_config;
			}
		}
		return $t_output;
	}

}
?>