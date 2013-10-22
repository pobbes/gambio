<?php
/* --------------------------------------------------------------
   JSOptionsSource.inc.php 2012-09-12 tb@gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

class JSOptionsSource
{
	var $v_js_options_path;
    var $v_js_options_user_classes_path;
	var $v_js_options_array = array();

	function JSOptionsSource()
	{
		$this->v_js_options_path = DIR_FS_CATALOG.'system/conf/JSOptions/';
        $this->v_js_options_user_classes_path = DIR_FS_CATALOG.'user_classes/conf/JSOptions/';
	}

	function init_structure_array( )
	 {
		$t_directory = opendir($this->v_js_options_path);
		while ($t_file = readdir($t_directory)){
			if($t_file != "." && $t_file != ".." && substr($t_file, -4) == ".php"){
				include($this->v_js_options_path.$t_file);
			}
		} 
        
        $t_directory = opendir($this->v_js_options_user_classes_path);
		while ($t_file = readdir($t_directory)){
			if($t_file != "." && $t_file != ".." && substr($t_file, -4) == ".php"){
				include($this->v_js_options_user_classes_path.$t_file);
			}
		} 
        
		$array = $this->utf8_encode_mix($array);
		$this->v_js_options_array = $array;
	}
	
	function get_array(){
		return $this->v_js_options_array;
	}
    
    function get_js_options_path(){
        return $this->v_js_options_path;
    }
    
    function set_js_options_path($p_js_options_path){
        $t_js_options_path = (string)$p_js_options_path;
        $this->v_js_options_path = $t_js_options_path;
    }
    
    function get_js_options_user_classes_path(){
        return $this->v_js_options_user_classes_path;
    }
    
    function set_js_options_user_classes_path($p_js_options_user_classes_path){
        $t_js_options_user_classes_path = (string)$p_js_options_user_classes_path;
        $this->v_js_options_user_classes_path = $t_js_options_user_classes_path;
    }
    
    function utf8_encode_mix($input, $encode_keys=false)
    {
        if(is_array($input))
        {
            $result = array();
            foreach($input as $k => $v)
            {
				$key = ($encode_keys)? utf8_encode($k) : $k;
                $result[$key] = $this->utf8_encode_mix( $v, $encode_keys);
            }
        }
        else if(is_string($input))
        {
            $result = utf8_encode($input);
        }
		else
		{
			$result = $input;
		}

        return $result;
    } 
}
?>