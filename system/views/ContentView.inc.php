<?php
/* --------------------------------------------------------------
   ContentView.inc.php 2012-06-14 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/


class ContentView 
{
	var $v_env_get_array = array();
	var $v_env_post_array = array();
	
	var $v_content_template = '';
	var $v_content_array = array();
	var $v_max_deprecation_level = 3;

	var $v_flat_assigns = false;

	var $v_coo_smarty = false;
	var $v_cache_id_elements_array = array();

	var $v_template_dir = '';

	var $v_caching_enabled = false; # set in init_smarty()
	var $v_compile_check_enabled = false; # set in init_smarty()

	var $v_session_id_placeholder = '[#%_SESSION_ID_PLACEHOLDER_%#]';

#	var $v_caching_enabled = false;
#	var $v_compile_check_enabled = true;


	function ContentView($p_get_array=false, $p_post_array=false) 
	{
		if($p_get_array) $this->v_env_get_array = $p_get_array;
		if($p_post_array) $this->v_env_post_array = $p_post_array;
	}

	function init_smarty()
	{
		if($this->v_coo_smarty === false)
		{
			$coo_template_control = MainFactory::create_object('TemplateControl', array(), true);
			if($coo_template_control->get_template_presentation_version() < FIRST_GX2_TEMPLATE_VERSION)
			{
				# disable caching for old templates
				$this->set_caching_enabled(false);

				# activate compatibility mode for old templates
				$this->set_flat_assigns(true);
			}

			if(is_object($GLOBALS['coo_debugger']) == true && $GLOBALS['coo_debugger']->is_enabled('smarty_compile_check') == true)
			{
				# overwrite only, if compile_check is enabled in debug_config
				$this->set_compile_check_enabled(true);
				$this->set_caching_enabled(false);
			}

			# create smarty
			$this->v_coo_smarty = new Smarty();

			# cache settings
			$this->v_coo_smarty->caching = $this->is_caching_enabled();
			$this->v_coo_smarty->cache_lifetime = -1;
			$this->v_coo_smarty->use_sub_dirs = false;

			# compile settings
			$this->v_coo_smarty->compile_check = $this->is_compile_check_enabled();
			$this->v_coo_smarty->compile_dir = DIR_FS_CATALOG.'templates_c/';
			$this->v_coo_smarty->cache_dir = DIR_FS_CATALOG.'cache/';

			if($this->v_template_dir == '')
			{
				# set only, if it's empty
				$this->v_template_dir = DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/';
			}

			# default elements for cache_id building
			$t_cache_id_parameter_array = array(
											$this->get_content_template(),
											$_SESSION['language'],
											$_SESSION['currency'],
											$_SESSION['customers_status']['customers_status_id']
										);
			$this->add_cache_id_elements($t_cache_id_parameter_array);
		}
	}

	# should be overwritten by sub-classes
	function get_html()	
	{
		$t_html_output = $this->build_html();
		return $t_html_output;
	}

	function set_template_dir($p_dir_path)
	{
		if(is_dir($p_dir_path) == false)
		{
			trigger_error('dir not found: '. $p_dir_path, E_USER_WARNING);
			return false;
		}
		$this->v_template_dir = $p_dir_path;
		return true;
	}

	function set_flat_assigns($p_status)
	{
		$this->v_flat_assigns = $p_status;
	}

	function get_flat_assigns()
	{
		return $this->v_flat_assigns;
	}

	function set_content_data($p_content_name, $p_content_item, $p_deprecation_level=0)
	{
		$t_deprecation_level = (int)$p_deprecation_level;
		if($t_deprecation_level < 0 || $t_deprecation_level > $this->v_max_deprecation_level) trigger_error('invalid p_deprecation_level: '. $p_deprecation_level, E_USER_WARNING);
		
		$this->v_content_array[$t_deprecation_level][$p_content_name] = $p_content_item;
	}

	function get_content_array($p_max_deprecation_level=false)
	{
		$t_output_array = array();

		if($p_max_deprecation_level === false) {
			$t_max_level = $this->v_max_deprecation_level;
		} else {
			$t_max_level = $p_max_deprecation_level;
		}

		# merge all levels
		for($i=0; $i<=$t_max_level; $i++)
		{
			if($i >= sizeof($this->v_content_array)) break; # break, if there's no such level
			$t_output_array = array_merge($t_output_array, $this->v_content_array[$i]);
		}
		return $t_output_array;
	}

	function set_content_template($p_filepath) 
	{
		$this->v_content_template = $p_filepath;
	}
	
	function get_content_template() {
		return $this->v_content_template;
	}
	
	function add_cache_id_elements($p_elements_array)
	{
		$this->v_cache_id_elements_array = array_merge($this->v_cache_id_elements_array, $p_elements_array);
	}

	function clear_cache_id_elements()
	{
		$this->v_cache_id_elements_array = array();
	}

	function get_cache_id()
	{
		$t_cache_id_parameter_array = $this->v_cache_id_elements_array;
		
		# build cache_id
		$t_cache_id = implode('_', $t_cache_id_parameter_array);
		$t_cache_id = 'view_'.md5($t_cache_id);

		return $t_cache_id;
	}

	function is_cached()
	{
		$this->init_smarty();
		
		$t_template = $this->v_template_dir.$this->get_content_template();
		$t_cache_id = $this->get_cache_id();

		$t_cache_status = $this->v_coo_smarty->is_cached($t_template, $t_cache_id);

		if($t_cache_status == true) $t_cache_status_log = 'TRUE'; else $t_cache_status_log = 'FALSE';
		if(is_object($GLOBALS['coo_debugger'])) $GLOBALS['coo_debugger']->log('cache_id:'. $t_cache_id .' is_cached='.$t_cache_status_log, 'SmartyCache');

		return $t_cache_status;
	}

	function build_html($p_content_data_array=false, $p_template_file=false)
	{
		$this->init_smarty();

		# set using array and template
		$t_content_data_array = $p_content_data_array;
		$t_template_file = $p_template_file;

		if($t_content_data_array === false) $t_content_data_array = $this->get_content_array();
		if($t_template_file === false) $t_template_file = $this->get_content_template();
		if($t_template_file == '') trigger_error('t_template_file empty', E_USER_WARNING);

		if($this->is_caching_enabled() == false || $this->is_cached() == false)
		{
			# assign module content
			if($this->get_flat_assigns() == false)
			{
				$this->v_coo_smarty->assign('content_data', $t_content_data_array);
			}
			else
			{
				for($i=0; $i<sizeof($t_content_data_array); $i++)
				{
					$t_data_key = key($t_content_data_array);
					$t_data_value = current($t_content_data_array);

					$this->v_coo_smarty->assign($t_data_key, $t_data_value);
					next($t_content_data_array);
				}
			}

			# assign global content
			$this->v_coo_smarty->assign('session_id_placeholder', $this->get_session_id_placeholder());
			$this->v_coo_smarty->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
			$this->v_coo_smarty->assign('language', $_SESSION['language']);
			$this->v_coo_smarty->assign('language_code', $_SESSION['language_code']);
			$this->v_coo_smarty->assign('page_url', htmlspecialchars_wrapper(gm_get_env_info('REQUEST_URI') ));
			if($_SESSION['style_edit_mode'] == 'edit') $this->v_coo_smarty->assign('style_edit_active', true);
			
			# clear templates_c
			//$coo_smarty->clear_compiled_tpl($t_full_template_path);
			//$coo_smarty->clear_compiled_tpl();
		}

		# get html content
		$t_full_template_path = $this->v_template_dir.$t_template_file;
		
		$t_cache_id = $this->get_cache_id();
		$t_html_output = $this->v_coo_smarty->fetch($t_full_template_path, $t_cache_id);

		# insert session_ids
		$t_html_output = $this->replace_session_id_placeholder($t_html_output);
		
		return $t_html_output;
	}

	function set_caching_enabled($p_status)
	{
		$this->v_caching_enabled = $p_status;
	}
	function is_caching_enabled()
	{
		return $this->v_caching_enabled;
	}

	function set_compile_check_enabled($p_status)
	{
		$this->v_compile_check_enabled = $p_status;
	}
	function is_compile_check_enabled()
	{
		return $this->v_compile_check_enabled;
	}

	function replace_session_id_placeholder($p_content)
	{
		$t_placeholder = $this->get_session_id_placeholder();
		$t_session_id = xtc_session_id();

		$t_output = str_replace($t_placeholder, $t_session_id, $p_content);
		return $t_output;
	}

	function get_session_id_placeholder()
	{
		return $this->v_session_id_placeholder;
	}
	
	/**
	 * get the first template from folder
	 * 
	 * this function gets the first template from the folder,
	 * if the given filepath not an file
	 * 
	 * @param string $p_path Path to the templates
	 * @param string $p_template Name of the template
	 * @return string Template basname
	 */
	function get_default_template($p_filepath, $p_template)
	{
		// cast filepath to string
		$t_filepath = (string)$p_filepath;
		// get basename of the given template and cast to string
		$t_template = basename((string)$p_template);
		
		// get default template if given template not exists
		if(!is_file($t_filepath.$p_template))
		{
			// get all html templates and select the first
			$files = glob($t_filepath.'*.html');
			$t_template = basename($files[0]);
			// log if given template not exists and it is not the default
			if($p_template != 'default' && $p_template != '') {
				$t_message = 'Template nicht vorhanden: "' . $t_filepath.$p_template . '"'."\n";
				$t_message .= 'Template verwendet: "' . $t_filepath.$t_template . '"';
				$coo_log = new FileLog('errors');
				$coo_log->write("================================================================================\n");
				$coo_log->write(date('Y-m-j H-i-s')."\n");        
				$coo_log->write("WARNING: ".$t_message."\n");
				$coo_log->write("\n");
			}
		}

		return $t_template;
	}
}

?>