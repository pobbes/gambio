<?php
/* --------------------------------------------------------------
   CacheControl.inc.php 2012-01-02  gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CacheControl
 *
 *
 * @author ncapuno
 */
class CacheControl
{
	function CacheControl()
	{
	}

	
	function reset_cache($p_touched_group='all')
	{
		switch($p_cache_group)
		{
			case 'styles':
				$this->clear_css_cache();
				break;

			case 'modules':
				$this->clear_data_cache();
				$this->clear_content_view_cache();
				$this->clear_templates_c();
				break;

			case 'configuration':
				$this->clear_data_cache();
				$this->clear_content_view_cache();
				$this->clear_css_cache();
				break;

			case 'categories':
				$this->clear_data_cache();
				$this->clear_content_view_cache();
				$this->rebuild_products_categories_index();
				$this->rebuild_categories_submenus_cache();
				break;

			case 'products':
				$this->clear_content_view_cache();
				$this->rebuild_products_categories_index();
				break;

			case 'features':
				$this->rebuild_products_feature_index();
				break;

			case 'properties':
				$this->rebuild_products_properties_index();
				break;

			case 'all':
			default:
				$this->clear_data_cache();
				$this->clear_content_view_cache();
				$this->clear_templates_c();
				$this->clear_css_cache();
				$this->rebuild_products_categories_index();
				$this->rebuild_products_properties_index();
				$this->rebuild_products_feature_index();
				$this->rebuild_categories_submenus_cache();
		}
	}


	function set_reset_token()
	{
		$t_token_file = DIR_FS_CATALOG.'cache/reset_cache';
		$t_token_content = 'reset_cache';

		$fp = fopen($t_token_file, 'w');
			fwrite($fp, $t_token_content);
		fclose($fp);
	}

	function remove_reset_token()
	{
		if($this->reset_token_exists())
		{
			$t_token_file = DIR_FS_CATALOG.'cache/reset_cache';
			unlink($t_token_file);
			
			$coo_admin_infobox_control = MainFactory::create_object('AdminInfoboxControl');
			$coo_admin_infobox_control->delete_by_identifier('clear_cache');
		}
	}

	function reset_token_exists()
	{
		$t_output = false;
		$t_token_file = DIR_FS_CATALOG.'cache/reset_cache';

		if(file_exists($t_token_file))
		{
			$t_output = true;
		}
		return $t_output;
	}



	


	/*
	 * CategoriesAgent
	 * LanguageTextManager
	 * ClassRegistry
	 * CachedDirectory
	 * AdminMenu
	 */
	function clear_data_cache()
	{
		$coo_cache =& DataCache::get_instance();
		$coo_cache->clear_cache();
	}

	function clear_content_view_cache()
	{
		$coo_cache =& DataCache::get_instance();
		$coo_cache->clear_cache_by_tag('TEMPLATE');		
		
		$t_dir = DIR_FS_CATALOG.'cache/';
		$t_file_pattern = 'view_*.html';

		# get list of content_view cache files
		$t_cache_files_array = glob($t_dir.$t_file_pattern);
		if(is_array($t_cache_files_array) == false) return true;

		foreach($t_cache_files_array as $t_cache_file)
		{
			# delete found cache files
			unlink($t_cache_file);
		}
		return true;
	}

	function clear_templates_c()
	{
		$t_dir = DIR_FS_CATALOG.'templates_c/';
		$t_file_pattern = '*.php';

		# get list of content_view cache files
		$t_cache_files_array = glob($t_dir.$t_file_pattern);
		if(is_array($t_cache_files_array) == false) return true;

		foreach($t_cache_files_array as $t_cache_file)
		{
			# delete found cache files
			unlink($t_cache_file);
		}
		return true;
	}

	function clear_css_cache()
	{
		$t_filename = DIR_FS_CATALOG.'cache/__dynamics.css';
		if(file_exists($t_filename))
		{
			unlink($t_filename);
		}
	}

	function rebuild_categories_submenus_cache($p_show_output=false)
	{
		# get categories
		$coo_categories_group = MainFactory::create_object('GMDataObjectGroup', array('categories', array('categories_status' => '1') ));
		$t_categories_data_array = $coo_categories_group->get_data_objects_array();
		
		# get customers_status
		$coo_status_group = MainFactory::create_object('GMDataObjectGroup', array('customers_status', array('language_id' => $_SESSION['languages_id']) ));
		$t_status_data_array = $coo_status_group->get_data_objects_array();

		# cache maker
		$coo_categories_content_view = MainFactory::create_object('CategoriesSubmenusContentView');

		foreach($t_categories_data_array as $t_categories_item)
		{
			# get categories_id
			$t_categories_id = $t_categories_item->get_data_value('categories_id');

			foreach($t_status_data_array as $t_status_item)
			{
				# get customers_status_id
				$t_customers_status_id = $t_status_item->get_data_value('customers_status_id');

				# switch customers_status_id
				$coo_categories_content_view->set_customers_status_id($t_customers_status_id);

				# build html cache
				$t_dev_null = $coo_categories_content_view->get_html(false, $t_categories_id);

				if($p_show_output) {
					echo '<br/>rebuild_categories_submenus_cache, categories_id: '. $t_categories_id .', customers_status_id: '. $t_customers_status_id;
					flush();
				}
			}
		}
		if($p_show_output) echo '<br/>rebuild_categories_submenus_cache, all done.';
	}

	function rebuild_products_feature_index($p_products_id_array=NULL)
	{
		$coo_feature_handler = MainFactory::create_object('ProductFeatureHandler');

		if(isset($p_products_id_array))
		{
			# rebuild given products_ids
			for($i=0; $i<sizeof($p_products_id_array); $i++)
			{
				$coo_feature_handler->build_feature_index($p_products_id_array[$i]);
			}
		}
		else {
			# no products_ids given -> rebuild all products!
			$t_result = xtc_db_query('SELECT * FROM products');
			while(($t_row = mysql_fetch_array($t_result) ))
			{
				$coo_feature_handler->build_feature_index($t_row['products_id']);
			}
		}

	}

	function rebuild_products_properties_index($p_products_id_array=NULL)
	{
		$coo_properties_data_agent = MainFactory::create_object('PropertiesDataAgent');

		if(isset($p_products_id_array))
		{
			# rebuild given products_ids
			$t_where_or_part = implode(' OR products_id = ', $p_products_id_array);
			$t_where_or_part = mysql_real_escape_string($t_where_or_part);

			$t_sql = 'DELETE FROM products_properties_index WHERE products_id = '.$t_where_or_part;
			xtc_db_query($t_sql);
			
			$t_sql = '
				SELECT products_id
				FROM products_properties_combis
				WHERE products_id = '.$t_where_or_part.'
				GROUP BY products_id
			';
			$t_result = xtc_db_query($t_sql);

			while(($t_row = xtc_db_fetch_array($t_result) ))
			{
				$coo_properties_data_agent->rebuild_properties_index($t_row['products_id']);
			}
		}
		else {
			# no products_ids given -> rebuild all products!
			$t_sql = 'TRUNCATE products_properties_index';
			xtc_db_query($t_sql);

			$t_sql = '
				SELECT products_id
				FROM products_properties_combis
				GROUP BY products_id
			';
			$t_result = xtc_db_query($t_sql);

			while(($t_row = xtc_db_fetch_array($t_result) ))
			{
				$coo_properties_data_agent->rebuild_properties_index($t_row['products_id']);
			}
		}
	}

	function rebuild_products_categories_index($p_products_id_array=NULL)
	{
		$coo_feature_handler = MainFactory::create_object('ProductFeatureHandler');

		if(isset($p_products_id_array))
		{
			# rebuild given products_ids
			for($i=0; $i<sizeof($p_products_id_array); $i++)
			{
				$coo_feature_handler->build_categories_index($p_products_id_array[$i]);
			}
		}
		else {
			# no products_ids given -> rebuild all products!
			$t_result = xtc_db_query('SELECT * FROM products');
			while(($t_row = mysql_fetch_array($t_result) ))
			{
				$coo_feature_handler->build_categories_index($t_row['products_id']);
			}
		}
	}

	# DEPRECATED
	# backward compatibility wrappers
	function clear_cache()       { $this->reset_cache(); }
	function clear_cache_dir()   { $this->clear_content_view_cache(); }
	function clear_compile_dir() { $this->clear_templates_c(); }
}
?>