<?php

/* --------------------------------------------------------------
  ExtenderComponent.inc.php 2012-01-16 gm
  Gambio GmbH
  http://www.gambio.de
  Copyright (c) 2012 Gambio GmbH
  Released under the GNU General Public License (Version 2)
  [http://www.gnu.org/licenses/gpl-2.0.html]
  --------------------------------------------------------------
 */

class ExtenderComponent
{
	var $v_output_buffer;
	var $v_data_array;

	
	function set_data($p_key, $p_value)
	{
		$c_key = trim((string) $p_key);
		if($c_key != '')
		{
			$this->v_data_array[$c_key] = $p_value;

			return true;
		}

		return false;
	}


	function proceed()
	{
		
	}
	

	function get_response()
	{
		return $this->v_output_buffer;
	}
}
?>