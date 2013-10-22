<?php
/* --------------------------------------------------------------
   gm_gprint_ajax.php 2010-03-03 mb
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/
?><?php

require_once('gm/inc/gm_utf8_decode.inc.php');
require_once('gm/classes/GMGPrintFileManager.php');

require_once('includes/application_top.php');

// DEBUG-MODE
// error_reporting(E_ALL);

// decline 'mode' to avoid NOTICE error reports
if(!isset($_GET['mode']))
{
	$_GET['mode'] = '';
}
if(!isset($_POST['mode']))
{
	$_POST['mode'] = '';
}

// security check: valid admin request? 
if($_GET['mode'] == 'backend' || $_POST['mode'] == 'backend')
{
	if($_SESSION['customers_status']['customers_status_id'] !== '0')
	{
		die('session expired');
	}
}

include_once(DIR_FS_CATALOG . 'lang/' . basename($_SESSION['language']) . '/gm_gprint.php');

if(isset($_POST['surfaces_groups_id']))
{
	$f_surfaces_groups_id = $_POST['surfaces_groups_id'];
	$c_surfaces_groups_id = (int)$f_surfaces_groups_id;
}

// kill existing sets
if(isset($_POST['action']) && ($_POST['action'] == 'load_surfaces_group' || $_POST['action'] == 'delete_surfaces_group' || $_POST['action'] == 'update_surfaces_group'))
{
	if($_POST['mode'] == 'frontend' || $_GET['mode'] == 'frontend')
	{
		unset($_SESSION['coo_gprint']);
	}
	elseif($_POST['mode'] == 'backend' || $_GET['mode'] == 'backend')
	{
		unset($_SESSION['coo_gprint_backend']);
	}	
}

if(((!isset($_SESSION['coo_gprint']) || !is_object($_SESSION['coo_gprint'])) && $c_surfaces_groups_id > 0 && ($_POST['mode'] == 'frontend' || $_GET['mode'] == 'frontend')) 
	|| ((isset($_POST['action']) && $_POST['action'] == 'copy_surfaces_group') && ($_POST['mode'] == 'frontend' || $_GET['mode'] == 'frontend'))) 
{
		$_SESSION['coo_gprint'] = new GMGPrintSurfacesManager($c_surfaces_groups_id);
}
elseif(!is_object($_SESSION['coo_gprint']) 
		&& ($_POST['mode'] == 'frontend' || $_GET['mode'] == 'frontend') 
		&& !($c_surfaces_groups_id > 0) 
		&& $_POST['action'] != 'create_surfaces_group' 
		&& $_POST['action'] != 'load_languages_id'
		&& $_POST['action'] != 'load_configuration'
		&& $_POST['action'] != 'add_cart'
		&& $_POST['action'] != 'update_cart'
		&& $_POST['action'] != 'add_wishlist'
		&& $_POST['action'] != 'update_wishlist'
		&& $_POST['action'] != 'wishlist_to_cart'
		&& $_POST['action'] != 'copy_file')
{
	die('ERROR: No object!');
}

if(((!isset($_SESSION['coo_gprint_backend']) || !is_object($_SESSION['coo_gprint_backend'])) && isset($c_surfaces_groups_id) && $c_surfaces_groups_id > 0 && ($_POST['mode'] == 'backend' || $_GET['mode'] == 'backend')) 
	|| ((isset($_POST['action']) && $_POST['action'] == 'copy_surfaces_group') && ($_POST['mode'] == 'backend' || $_GET['mode'] == 'backend'))) 
{
	$_SESSION['coo_gprint_backend'] = new GMGPrintSurfacesManager($c_surfaces_groups_id);
}
elseif((!isset($_SESSION['coo_gprint_backend']) || !is_object($_SESSION['coo_gprint_backend'])) 
		&& ($_POST['mode'] == 'backend' || $_GET['mode'] == 'backend') 
		&& (isset($c_surfaces_groups_id) && !($c_surfaces_groups_id > 0))
		&& (isset($_POST['action']) 
		&& $_POST['action'] != 'create_surfaces_group' 
		&& $_POST['action'] != 'load_languages_id'
		&& $_POST['action'] != 'load_configuration'))
{
	die('ERROR: No object!');
}

// ajax-request return variable
$t_output = '';
$f_action = '';

if(isset($_POST['action']))
{
	$f_action = $_POST['action'];
}


switch($f_action)
{
	case 'add_cart':
		if(!is_object($_SESSION['coo_gprint_cart']))
		{
			$_SESSION['coo_gprint_cart'] = new GMGPrintCartManager();
		}
		
		$f_products_id = $_POST['products_id'];
		
		$t_products_properties_combis_id = 0;
		$t_products_id = $f_products_id;
		
		if(isset($_POST['properties_values_ids']))
		{
			$coo_properties_control = MainFactory::create_object('PropertiesControl');
			$t_products_properties_combis_id = $coo_properties_control->get_combis_id_by_value_ids_array(xtc_get_prid($f_products_id), $_POST['properties_values_ids']);
			$t_products_id .= 'x' . $t_products_properties_combis_id;
			if($t_products_properties_combis_id == 0)
			{
				die('combi not available');
			}
		}
		
		$c_products_id = gm_string_filter($t_products_id, '0-9{}x');
		
		$f_post = $_POST;
		$c_post = gm_utf8_decode($f_post);
		
		foreach($c_post AS $t_key => $t_value)
		{
			if(strpos($t_key, 'element_') === 0)
			{
				$t_elements_id = str_replace('element_', '', $t_key);
				
				$t_new_products_id = $_SESSION['coo_gprint_cart']->check_cart($c_products_id, 'cart', false);
				
				if($t_new_products_id !== false)
				{
					$c_products_id = $t_new_products_id;
				}
				else
				{
					$t_new_products_id = $_SESSION['coo_gprint_cart']->check_cart($c_products_id, 'coo_gprint_cart', false);
				}
			
				if($t_new_products_id !== false)
				{
					$c_products_id = $t_new_products_id;
				}
				
				$_SESSION['coo_gprint_cart']->add($c_products_id, $t_elements_id, $t_value);
			}
		}
		
		if(!empty($_SESSION['customer_id']))
		{
			$_SESSION['coo_gprint_cart']->save();
		}
		
		$coo_json = new GMJSON();
		$t_output = $coo_json->encode(true);
		
		break;	
	case 'update_cart':
		$f_products_id = $_POST['products_id'];
		$c_products_id = gm_string_filter($f_products_id, '0-9{}x');
		
		if(is_object($_SESSION['coo_gprint_cart']))
		{
			$_SESSION['coo_gprint_cart']->remove($c_products_id);
		}		
		
		$coo_json = new GMJSON();
		$t_output = $coo_json->encode(true);
		
		break;
	case 'add_wishlist':
		if(!is_object($_SESSION['coo_gprint_wishlist']))
		{
			$_SESSION['coo_gprint_wishlist'] = new GMGPrintWishlistManager();
		}
		
		$f_products_id = $_POST['products_id'];
		
		$t_products_properties_combis_id = 0;
		$t_products_id = $f_products_id;

		if(isset($_POST['properties_values_ids']))
		{
			$coo_properties_control = MainFactory::create_object('PropertiesControl');
			$t_products_properties_combis_id = $coo_properties_control->get_combis_id_by_value_ids_array(xtc_get_prid($f_products_id), $_POST['properties_values_ids']);
			$t_products_id .= 'x' . $t_products_properties_combis_id;
			if($t_products_properties_combis_id == 0)
			{
				die('combi not available');
			}
		}

		$c_products_id = gm_string_filter($t_products_id, '0-9{}x');
		
		foreach($_POST AS $t_key => $t_value)
		{
			if(strpos($t_key, 'element_') === 0)
			{
				$t_elements_id = str_replace('element_', '', $t_key);
				
				$t_new_products_id = $_SESSION['coo_gprint_wishlist']->check_wishlist($c_products_id, 'wishList', false);
				
				if($t_new_products_id !== false)
				{
					$c_products_id = $t_new_products_id;
				}
				else
				{
					$t_new_products_id = $_SESSION['coo_gprint_wishlist']->check_wishlist($c_products_id, 'coo_gprint_wishlist', false);
				}
				
				if($t_new_products_id !== false)
				{
					$c_products_id = $t_new_products_id;
				}
				
				$_SESSION['coo_gprint_wishlist']->add($c_products_id, $t_elements_id, gm_utf8_decode($t_value));
			}
		}
		
		if(!empty($_SESSION['customer_id']))
		{
			$_SESSION['coo_gprint_wishlist']->save();
		}
		
		$coo_json = new GMJSON();
		$t_output = $coo_json->encode(true);
		
		break;	
	case 'update_wishlist':
		$f_products_id = $_POST['products_id'];
		$c_products_id = gm_string_filter($f_products_id, '0-9{}x');
		
		if(is_object($_SESSION['coo_gprint_wishlist']))
		{
			$_SESSION['coo_gprint_wishlist']->remove($c_products_id);
		}
		
		$coo_json = new GMJSON();
		$t_output = $coo_json->encode(true);
		
		break;
	case 'wishlist_to_cart':
		$f_products_id = $_POST['products_id'];
		$c_products_id = gm_string_filter($f_products_id, '0-9{}x');
		
		if(!is_object($_SESSION['coo_gprint_cart']))
		{
			$_SESSION['coo_gprint_cart'] = new GMGPrintCartManager();
		}
		
		if(isset($_SESSION['coo_gprint_wishlist']->v_elements[$c_products_id]))
		{
			foreach($_SESSION['coo_gprint_wishlist']->v_elements[$c_products_id] AS $t_elements_id => $t_value)
			{
				$_SESSION['coo_gprint_cart']->add($c_products_id, $t_elements_id, $t_value);
			}
			
			if(isset($_SESSION['coo_gprint_wishlist']->v_files[$c_products_id]))
			{
				foreach($_SESSION['coo_gprint_wishlist']->v_files[$c_products_id] AS $t_elements_id => $t_value)
				{
					$t_decrypted_filename = $_SESSION['coo_gprint_wishlist']->get_filename($t_elements_id, $c_products_id, true);
					$t_filename = $_SESSION['coo_gprint_cart']->add_file($c_products_id, $t_elements_id, $t_decrypted_filename);
					
					$coo_file_manager = new GMGPrintFileManager();
							
					$t_source_filename = $_SESSION['coo_gprint_wishlist']->get_filename($t_elements_id, $c_products_id);
					$t_output = $coo_file_manager->copy_file($t_source_filename, $t_filename, DIR_FS_CATALOG . 'gm/customers_uploads/gprint/', DIR_FS_CATALOG . 'gm/customers_uploads/gprint/');
				}
			}
			
			$_SESSION['coo_gprint_cart']->save();
		}
		
		$coo_json = new GMJSON();
		$t_output = $coo_json->encode(true);
		
		break;
	case 'copy_file':
		$f_elements_id = $_POST['elements_id'];
		$c_elements_id = (int)$f_elements_id;
		$f_old_product = $_POST['old_product'];
		$f_new_product = $_POST['new_product'];
		$f_target = $_POST['target'];
		$f_source = $_POST['source'];
		
		$c_old_product = gm_string_filter($f_old_product, '0-9{}x');
		$c_new_product = gm_string_filter($f_new_product, '0-9{}x');
		
		$t_output = false;
		
		if(!is_object($_SESSION['coo_gprint_cart']))
		{
			$_SESSION['coo_gprint_cart'] = new GMGPrintCartManager();
		}
		
		if(!is_object($_SESSION['coo_gprint_wishlist']))
		{
			$_SESSION['coo_gprint_wishlist'] = new GMGPrintWishlistManager();
		}
		
		if($f_target == 'cart')
		{
			if($f_source == 'cart')
			{
				if(isset($_SESSION['coo_gprint_cart']->v_files[$f_old_product][$c_elements_id]))
				{
					$_SESSION['coo_gprint_cart']->add($c_new_product, $c_elements_id, $_SESSION['coo_gprint_cart']->v_elements[$f_old_product][$c_elements_id]);
					$t_decrypted_filename = $_SESSION['coo_gprint_cart']->get_filename($c_elements_id, $f_old_product, true);
					$t_filename = $_SESSION['coo_gprint_cart']->add_file($c_new_product, $c_elements_id, $t_decrypted_filename);
					
					$coo_file_manager = new GMGPrintFileManager();
					
					$t_source_filename = $_SESSION['coo_gprint_cart']->get_filename($c_elements_id, $c_old_product);
					$t_output = $coo_file_manager->copy_file($t_source_filename, $t_filename, DIR_FS_CATALOG . 'gm/customers_uploads/gprint/', DIR_FS_CATALOG . 'gm/customers_uploads/gprint/');
				}
			}
			elseif($f_source == 'wishlist')
			{
				if(isset($_SESSION['coo_gprint_wishlist']->v_files[$f_old_product][$c_elements_id]))
				{
					$_SESSION['coo_gprint_cart']->add($c_new_product, $c_elements_id, $_SESSION['coo_gprint_wishlist']->v_elements[$f_old_product][$c_elements_id]);
					$t_decrypted_filename = $_SESSION['coo_gprint_wishlist']->get_filename($c_elements_id, $f_old_product, true);
					$t_filename = $_SESSION['coo_gprint_cart']->add_file($c_new_product, $c_elements_id, $t_decrypted_filename);
					
					$coo_file_manager = new GMGPrintFileManager();
					
					$t_source_filename = $_SESSION['coo_gprint_wishlist']->get_filename($c_elements_id, $c_old_product);
					$t_output = $coo_file_manager->copy_file($t_source_filename, $t_filename, DIR_FS_CATALOG . 'gm/customers_uploads/gprint/', DIR_FS_CATALOG . 'gm/customers_uploads/gprint/');
				}
			}
		}
		elseif($f_target == 'wishlist')
		{
			if($f_source == 'wishlist')
			{
				if(isset($_SESSION['coo_gprint_wishlist']->v_files[$f_old_product][$c_elements_id]))
				{
					$_SESSION['coo_gprint_wishlist']->add($c_new_product, $c_elements_id, $_SESSION['coo_gprint_wishlist']->v_elements[$f_old_product][$c_elements_id]);
					$t_decrypted_filename = $_SESSION['coo_gprint_wishlist']->get_filename($c_elements_id, $f_old_product, true);
					$t_filename = $_SESSION['coo_gprint_wishlist']->add_file($c_new_product, $c_elements_id, $t_decrypted_filename);
					
					$coo_file_manager = new GMGPrintFileManager();
					
					$t_source_filename = $_SESSION['coo_gprint_wishlist']->get_filename($c_elements_id, $c_old_product);
					$t_output = $coo_file_manager->copy_file($t_source_filename, $t_filename, DIR_FS_CATALOG . 'gm/customers_uploads/gprint/', DIR_FS_CATALOG . 'gm/customers_uploads/gprint/');
				}
			}
			elseif($f_source == 'cart')
			{
				if(isset($_SESSION['coo_gprint_cart']->v_files[$f_old_product][$c_elements_id]))
				{
					$_SESSION['coo_gprint_wishlist']->add($c_new_product, $c_elements_id, $_SESSION['coo_gprint_cart']->v_elements[$f_old_product][$c_elements_id]);
					$t_decrypted_filename = $_SESSION['coo_gprint_cart']->get_filename($c_elements_id, $f_old_product, true);
					$t_filename = $_SESSION['coo_gprint_wishlist']->add_file($c_new_product, $c_elements_id, $t_decrypted_filename);
					
					$coo_file_manager = new GMGPrintFileManager();
					
					$t_source_filename = $_SESSION['coo_gprint_cart']->get_filename($c_elements_id, $c_old_product);
					$t_output = $coo_file_manager->copy_file($t_source_filename, $t_filename, DIR_FS_CATALOG . 'gm/customers_uploads/gprint/', DIR_FS_CATALOG . 'gm/customers_uploads/gprint/');
				}
			}
			
		}
		
		$coo_json = new GMJSON();
		$t_output = $coo_json->encode($t_output);
		
		break;		
	case 'load_surfaces_group':
		if($_POST['mode'] == 'frontend' || $_GET['mode'] == 'frontend')
		{
			if(!isset($_SESSION['coo_gprint_configuration']))
			{
				$_SESSION['coo_gprint_configuration'] = new GMGPrintConfiguration($_SESSION['languages_id']);
			}
			
			$f_product = $_POST['product'];
			$c_product = gm_utf8_decode($f_product);
			
			$t_output = $_SESSION['coo_gprint']->load_surfaces_group($c_surfaces_groups_id, $_SESSION['coo_gprint_configuration'], $c_product);
		}
		elseif($_POST['mode'] == 'backend' || $_GET['mode'] == 'backend')
		{
			if(!isset($_SESSION['coo_gprint_configuration_backend']))
			{
				$_SESSION['coo_gprint_configuration_backend'] = new GMGPrintConfiguration($_SESSION['languages_id']);
			}
			
			$t_output = $_SESSION['coo_gprint_backend']->load_surfaces_group($c_surfaces_groups_id, $_SESSION['coo_gprint_configuration_backend']);
		}	
		break;
	case 'update_surfaces_group':
		if($_POST['mode'] == 'backend')
		{
		if(!isset($_SESSION['coo_gprint_configuration_backend']))
			{
				$_SESSION['coo_gprint_configuration_backend'] = new GMGPrintConfiguration($_SESSION['languages_id']);
			}
			
			$f_name = $_POST['name'];
			$c_name = gm_prepare_string(gm_utf8_decode($f_name));
			
			$coo_json = new GMJSON();
			$t_output = $_SESSION['coo_gprint_backend']->update_name($c_name);
			$t_output = $coo_json->encode($t_output);
		}
		
		break;
	case 'create_surfaces_group':
		if($_POST['mode'] == 'backend')
		{
			$f_name = $_POST['name'];
			$c_name = gm_prepare_string(gm_utf8_decode($f_name));
			
			$coo_surfaces_groups_manager = new GMGPrintSurfacesGroupsManager();
			$t_output = $coo_surfaces_groups_manager->create($c_name);
		}
		
		break;
	case 'copy_surfaces_group':
		if($_POST['mode'] == 'backend')
		{
			if(!isset($_SESSION['coo_gprint_configuration_backend']))
			{
				$_SESSION['coo_gprint_configuration_backend'] = new GMGPrintConfiguration($_SESSION['languages_id']);
			}
			
			$t_json_surfaces_group = $_SESSION['coo_gprint_backend']->load_surfaces_group($c_surfaces_groups_id, $_SESSION['coo_gprint_configuration_backend']);
			
			$coo_surfaces_group_source = $_SESSION['coo_gprint_backend'];
			
			$f_name = $_POST['name'];
			$c_name = gm_prepare_string(gm_utf8_decode($f_name));
			
			$coo_surfaces_groups_manager = new GMGPrintSurfacesGroupsManager();
			$t_surfaces_groups_id = $coo_surfaces_groups_manager->create($c_name);
			
			unset($_SESSION['coo_gprint_backend']);
			$coo_surfaces_group_copy = new GMGPrintSurfacesManager($t_surfaces_groups_id);
					
			foreach($coo_surfaces_group_source->v_surfaces AS $t_surfaces_id => $t_surface)
			{
				$t_new_surfaces_id = $coo_surfaces_group_copy->create_surface($coo_surfaces_group_source->v_surfaces[$t_surfaces_id]->get_names(), $coo_surfaces_group_source->v_surfaces[$t_surfaces_id]->get_width(), $coo_surfaces_group_source->v_surfaces[$t_surfaces_id]->get_height());
				
				foreach($coo_surfaces_group_source->v_surfaces[$t_surfaces_id]->v_elements AS $t_elements_id => $t_element)
				{
					$t_values = $coo_surfaces_group_source->v_surfaces[$t_surfaces_id]->v_elements[$t_elements_id]->get_values();
					
					if($coo_surfaces_group_source->v_surfaces[$t_surfaces_id]->v_elements[$t_elements_id]->get_type() == 'image')
					{
						$coo_file_manager = new GMGPrintFileManager();
						
						foreach($t_values AS $t_languages_id => $t_value)
						{
							$t_new_filename = time() . '_' . $t_value[0];
							$t_copy_file = $coo_file_manager->copy_file($t_value[0], $t_new_filename, DIR_FS_CATALOG . DIR_WS_IMAGES . 'gm/gprint/', DIR_FS_CATALOG . DIR_WS_IMAGES . 'gm/gprint/');
							
							if($t_copy_file)
							{
								$t_values[$t_languages_id] = array($t_new_filename);
							}
						}
					}
					
					$t_new_elements_id = $coo_surfaces_group_copy->v_surfaces[$t_new_surfaces_id]->create_element(
						$coo_surfaces_group_source->v_surfaces[$t_surfaces_id]->v_elements[$t_elements_id]->get_type(), 
						$coo_surfaces_group_source->v_surfaces[$t_surfaces_id]->v_elements[$t_elements_id]->get_names(), 
						$t_values, 
						$coo_surfaces_group_source->v_surfaces[$t_surfaces_id]->v_elements[$t_elements_id]->get_width(), 
						$coo_surfaces_group_source->v_surfaces[$t_surfaces_id]->v_elements[$t_elements_id]->get_height(), 
						$coo_surfaces_group_source->v_surfaces[$t_surfaces_id]->v_elements[$t_elements_id]->get_position_x(), 
						$coo_surfaces_group_source->v_surfaces[$t_surfaces_id]->v_elements[$t_elements_id]->get_position_y(), 
						$coo_surfaces_group_source->v_surfaces[$t_surfaces_id]->v_elements[$t_elements_id]->get_z_index(),
						$coo_surfaces_group_source->v_surfaces[$t_surfaces_id]->v_elements[$t_elements_id]->get_max_characters(),
						$coo_surfaces_group_source->v_surfaces[$t_surfaces_id]->v_elements[$t_elements_id]->get_show_name(),
						$coo_surfaces_group_source->v_surfaces[$t_surfaces_id]->v_elements[$t_elements_id]->get_allowed_extensions(),
						$coo_surfaces_group_source->v_surfaces[$t_surfaces_id]->v_elements[$t_elements_id]->get_minimum_filesize(),
						$coo_surfaces_group_source->v_surfaces[$t_surfaces_id]->v_elements[$t_elements_id]->get_maximum_filesize());
				}
			}
			
			$t_output = $t_surfaces_groups_id;
		}
		
		break;
	case 'create_surface':
		if($_POST['mode'] == 'backend')
		{
			$f_names = $_POST['names'];
			$f_width = $_POST['width'];
			$c_width = (int)$f_width;
			$f_height = $_POST['height'];
			$c_height = (int)$f_height;
			
			$t_names = gm_utf8_decode($f_names);
			
			$t_output = $_SESSION['coo_gprint_backend']->create_surface($t_names, $c_width, $c_height);
		}
		
		break;	
	case 'create_element':
		if($_POST['mode'] == 'backend')
		{
			$t_output = 0;
			
			$f_surfaces_id = $_POST['surfaces_id'];
			$c_surfaces_id = (int)$f_surfaces_id;
			$f_width = $_POST['width'];
			$c_width = (int)$f_width;
			$f_height = $_POST['height'];
			$c_height = (int)$f_height;
			$f_position_x = $_POST['position_x'];
			$c_position_x = (int)$f_position_x;
			$f_position_y = $_POST['position_y'];
			$c_position_y = (int)$f_position_y;
			$f_z_index = $_POST['z_index'];
			$c_z_index = (int)$f_z_index;
			$f_max_characters = $_POST['max_characters'];
			$c_max_characters = (int)$f_max_characters;
			$f_show_name = $_POST['show_name'];
			$c_show_name = (int)$f_show_name;
			$c_allowed_extensions = '';
			if(isset($_POST['allowed_extensions']))
			{
				$f_allowed_extensions = $_POST['allowed_extensions'];
				$c_allowed_extensions = gm_utf8_decode(gm_string_filter($f_allowed_extensions, 'a-z0-9,'));
			}	
			$c_minimum_filesize = 0;
			if(isset($_POST['minimum_filesize']))
			{
				$f_minimum_filesize = $_POST['minimum_filesize'];
				$c_minimum_filesize = (double)str_replace(',', '.', $f_minimum_filesize);
			}	
			$c_maximum_filesize = 0;
			if(isset($_POST['maximum_filesize']))
			{
				$f_maximum_filesize = $_POST['maximum_filesize'];
				$c_maximum_filesize = (double)str_replace(',', '.', $f_maximum_filesize);
			}			
			$f_type = $_POST['type'];
			$c_type = gm_string_filter($f_type, 'a-z_');
			$f_names = $_POST['names'];
			$t_names = gm_utf8_decode($f_names);
			$f_values = $_POST['values'];
			$t_values = gm_utf8_decode($f_values);
			
			$t_output = $_SESSION['coo_gprint_backend']->v_surfaces[$c_surfaces_id]->create_element($c_type, $t_names, $t_values, $c_width, $c_height, $c_position_x, $c_position_y, $c_z_index, $c_max_characters, $c_show_name, $c_allowed_extensions, $c_minimum_filesize, $c_maximum_filesize);
		}
		
		break;
	case 'set_surface_size':
		if($_POST['mode'] == 'backend')
		{
			$f_surfaces_id = $_POST['surfaces_id'];
			$c_surfaces_id = (int)$f_surfaces_id;
			$f_width = $_POST['width'];
			$c_width = (int)$f_width;
			$f_height = $_POST['height'];
			$c_height = (int)$f_height;
			
			$t_output = $_SESSION['coo_gprint_backend']->v_surfaces[$c_surfaces_id]->set_size($c_width, $c_height);
		}
		
		break;
	case 'set_element_size':
		if($_POST['mode'] == 'backend')
		{
			$f_elements_id = $_POST['elements_id'];
			$c_elements_id = (int)$f_elements_id;
			$f_width = $_POST['width'];
			$c_width = (int)$f_width;
			$f_height = $_POST['height'];
			$c_height = (int)$f_height;
			
			$t_output = $_SESSION['coo_gprint_backend']->v_surfaces[$_SESSION['coo_gprint_backend']->get_current_surfaces_id()]->v_elements[$c_elements_id]->set_size($c_width, $c_height);
		}
			
		break;
	case 'set_element_position':
		if($_POST['mode'] == 'backend')
		{
			$f_elements_id = $_POST['elements_id'];
			$c_elements_id = (int)$f_elements_id;
			
			$f_position_x = $_POST['position_x'];
			$c_position_x = (int)$f_position_x;
			$f_position_y = $_POST['position_y'];
			$c_position_y = (int)$f_position_y;
			
			$t_output = $_SESSION['coo_gprint_backend']->v_surfaces[$_SESSION['coo_gprint_backend']->get_current_surfaces_id()]->v_elements[$c_elements_id]->set_position($c_position_x, $c_position_y);
		}
		
		break;
	case 'set_element_z_index':
		if($_POST['mode'] == 'backend')
		{
			$f_elements_id = $_POST['elements_id'];
			$c_elements_id = (int)$f_elements_id;
			$f_z_index = $_POST['z_index'];
			$c_z_index = (int)$f_z_index;
			
			$t_output = $_SESSION['coo_gprint_backend']->v_surfaces[$_SESSION['coo_gprint_backend']->get_current_surfaces_id()]->v_elements[$c_elements_id]->set_element_z_index($c_z_index);
		}
			
		break;
	case 'set_element_max_characters':
		if($_POST['mode'] == 'backend')
		{
			$f_elements_id = $_POST['elements_id'];
			$c_elements_id = (int)$f_elements_id;
			$f_max_characters = $_POST['max_characters'];
			$c_max_characters = (int)$f_max_characters;
			
			if($_SESSION['coo_gprint_backend']->v_surfaces[$_SESSION['coo_gprint_backend']->get_current_surfaces_id()]->v_elements[$c_elements_id]->get_type() == 'text_input' 
				|| $_SESSION['coo_gprint_backend']->v_surfaces[$_SESSION['coo_gprint_backend']->get_current_surfaces_id()]->v_elements[$c_elements_id]->get_type() == 'textarea')
			{
				$t_output = $_SESSION['coo_gprint_backend']->v_surfaces[$_SESSION['coo_gprint_backend']->get_current_surfaces_id()]->v_elements[$c_elements_id]->set_element_max_characters($c_max_characters);
			}
			else
			{
				$t_output = 'true';
			}
		}
			
		break;
	case 'set_element_show_name':
		if($_POST['mode'] == 'backend')
		{
			$f_elements_id = $_POST['elements_id'];
			$c_elements_id = (int)$f_elements_id;
			$f_show_name = $_POST['show_name'];
			$c_show_name = (int)$f_show_name;
			
			if($_SESSION['coo_gprint_backend']->v_surfaces[$_SESSION['coo_gprint_backend']->get_current_surfaces_id()]->v_elements[$c_elements_id]->get_type() == 'text_input' 
				|| $_SESSION['coo_gprint_backend']->v_surfaces[$_SESSION['coo_gprint_backend']->get_current_surfaces_id()]->v_elements[$c_elements_id]->get_type() == 'textarea'
				|| $_SESSION['coo_gprint_backend']->v_surfaces[$_SESSION['coo_gprint_backend']->get_current_surfaces_id()]->v_elements[$c_elements_id]->get_type() == 'dropdown')
			{
				$t_output = $_SESSION['coo_gprint_backend']->v_surfaces[$_SESSION['coo_gprint_backend']->get_current_surfaces_id()]->v_elements[$c_elements_id]->set_element_show_name($c_show_name);
			}
			else
			{
				$t_output = 'true';
			}
		}
			
		break;
	case 'set_element_allowed_extensions':
		if($_POST['mode'] == 'backend')
		{
			$f_elements_id = $_POST['elements_id'];
			$c_elements_id = (int)$f_elements_id;
			$f_allowed_extensions = $_POST['allowed_extensions'];
			$c_allowed_extensions = gm_string_filter($f_allowed_extensions, 'a-z0-9,');
			
			if($_SESSION['coo_gprint_backend']->v_surfaces[$_SESSION['coo_gprint_backend']->get_current_surfaces_id()]->v_elements[$c_elements_id]->get_type() == 'file')
			{
				$t_output = $_SESSION['coo_gprint_backend']->v_surfaces[$_SESSION['coo_gprint_backend']->get_current_surfaces_id()]->v_elements[$c_elements_id]->set_element_allowed_extensions($c_allowed_extensions);
			}
			else
			{
				$t_output = 'true';
			}
		}
			
		break;
	case 'set_element_minimum_filesize':
		if($_POST['mode'] == 'backend')
		{
			$f_elements_id = $_POST['elements_id'];
			$c_elements_id = (int)$f_elements_id;
			$f_minimum_filesize = $_POST['minimum_filesize'];
			$c_minimum_filesize = (double)str_replace(',', '.', $f_minimum_filesize);
			
			if($_SESSION['coo_gprint_backend']->v_surfaces[$_SESSION['coo_gprint_backend']->get_current_surfaces_id()]->v_elements[$c_elements_id]->get_type() == 'file')
			{
				$t_output = $_SESSION['coo_gprint_backend']->v_surfaces[$_SESSION['coo_gprint_backend']->get_current_surfaces_id()]->v_elements[$c_elements_id]->set_element_minimum_filesize($c_minimum_filesize);
			}
			else
			{
				$t_output = 'true';
			}
		}
			
		break;
	case 'set_element_maximum_filesize':
		if($_POST['mode'] == 'backend')
		{
			$f_elements_id = $_POST['elements_id'];
			$c_elements_id = (int)$f_elements_id;
			$f_maximum_filesize = $_POST['maximum_filesize'];
			$c_maximum_filesize = (double)str_replace(',', '.', $f_maximum_filesize);
			
			if($_SESSION['coo_gprint_backend']->v_surfaces[$_SESSION['coo_gprint_backend']->get_current_surfaces_id()]->v_elements[$c_elements_id]->get_type() == 'file')
			{
				$t_output = $_SESSION['coo_gprint_backend']->v_surfaces[$_SESSION['coo_gprint_backend']->get_current_surfaces_id()]->v_elements[$c_elements_id]->set_element_maximum_filesize($c_maximum_filesize);
			}
			else
			{
				$t_output = 'true';
			}
		}
			
		break;
	case 'update_surface_size':
		if($_POST['mode'] == 'backend')
		{
			$f_surfaces_id = $_POST['surfaces_id'];
			$c_surfaces_id = (int)$f_surfaces_id;
			$f_width = $_POST['width'];
			$c_width = (int)$f_width;
			$f_height = $_POST['height'];
			$c_height = (int)$f_height;
			
			$_SESSION['coo_gprint_backend']->v_surfaces[$c_surfaces_id]->set_size($c_width, $c_height, $c_surfaces_id);
		}
			
		break;
	case 'update_surface_names':
		if($_POST['mode'] == 'backend')
		{
			$f_names = $_POST['names'];
			$f_surfaces_id = $_POST['surfaces_id'];
			$c_surfaces_id = (int)$f_surfaces_id;
			
			$t_names = gm_utf8_decode($f_names);
			
			$t_output = $_SESSION['coo_gprint_backend']->v_surfaces[$c_surfaces_id]->update_names($c_surfaces_id, $t_names);
		}
		
		break;
	case 'set_element_names':
		if($_POST['mode'] == 'backend')
		{
			$f_elements_id = $_POST['elements_id'];
			$c_elements_id = (int)$f_elements_id;
			$f_names = $_POST['names'];
			
			$t_names = gm_utf8_decode($f_names);
			
			$t_output = $_SESSION['coo_gprint_backend']->v_surfaces[$_SESSION['coo_gprint_backend']->get_current_surfaces_id()]->v_elements[$c_elements_id]->update_names($c_elements_id, $t_names);
		}
		
		break;
	case 'set_element_values':
		if($_POST['mode'] == 'backend')
		{
			$f_values = $_POST['values'];
			$f_elements_id = $_POST['elements_id'];
			$c_elements_id = (int)$f_elements_id;
			
			$t_values = gm_utf8_decode($f_values);
			
			$t_output = $_SESSION['coo_gprint_backend']->v_surfaces[$_SESSION['coo_gprint_backend']->get_current_surfaces_id()]->v_elements[$c_elements_id]->update_values($c_elements_id, $t_values);	
		}
				
		break;
	case 'delete_element':
		if($_POST['mode'] == 'backend')
		{
			$f_surfaces_id = $_POST['surfaces_id'];
			$c_surfaces_id = (int)$f_surfaces_id;
			$f_elements_id = $_POST['elements_id'];
			$c_elements_id = (int)$f_elements_id;
			
			$t_output = $_SESSION['coo_gprint_backend']->v_surfaces[$c_surfaces_id]->delete_element($c_elements_id);	
		}
			
		break;
	case 'delete_surface':
		if($_POST['mode'] == 'backend')
		{
			$f_surfaces_id = $_POST['surfaces_id'];
			$c_surfaces_id = (int)$f_surfaces_id;
			
			$t_output = $_SESSION['coo_gprint_backend']->delete_surface($c_surfaces_id);	
		}
			
		break;
	case 'delete_surfaces_group':
		if($_POST['mode'] == 'backend')
		{
			$f_surfaces_groups_id = $_POST['surfaces_groups_id'];
			$c_surfaces_groups_id = (int)$f_surfaces_groups_id;
			
			$coo_surfaces_groups_manager = new GMGPrintSurfacesGroupsManager();
			$t_output = $coo_surfaces_groups_manager->delete($c_surfaces_groups_id, $_SESSION['coo_gprint_backend'], $_SESSION['coo_gprint_configuration_backend']);
		}
			
		break;
	case 'load_configuration':
		$f_languages_id = $_POST['languages_id'];
		$c_languages_id = (int)$f_languages_id;
		
		if($c_languages_id == 0)
		{
			$t_languages_id = $_SESSION['languages_id'];
		}
		else
		{
			$t_languages_id = $c_languages_id;
		}
		
		$coo_json = new GMJSON();
		
		if($_POST['mode'] == 'frontend' || $_GET['mode'] == 'frontend')
		{
			$_SESSION['coo_gprint_configuration'] = new GMGPrintConfiguration($t_languages_id);
			$t_output = $coo_json->encode($_SESSION['coo_gprint_configuration']);
		}
		elseif($_POST['mode'] == 'backend' || $_GET['mode'] == 'backend')
		{
			$_SESSION['coo_gprint_configuration_backend'] = new GMGPrintConfiguration($t_languages_id);
			$t_output = $coo_json->encode($_SESSION['coo_gprint_configuration_backend']);
		}	
				
		break;
	case 'set_current_surfaces_id':
		$f_surfaces_id = $_POST['surfaces_id'];
		$c_surfaces_id = (int)$f_surfaces_id;
		
		if($_POST['mode'] == 'frontend' || $_GET['mode'] == 'frontend')
		{
			$_SESSION['coo_gprint']->set_current_surfaces_id($c_surfaces_id);
		}
		elseif($_POST['mode'] == 'backend' || $_GET['mode'] == 'backend')
		{
			$_SESSION['coo_gprint_backend']->set_current_surfaces_id($c_surfaces_id);
		}	
		
		$coo_json = new GMJSON();
		$t_output = $coo_json->encode(true);
		
		break;
}

// set-image upload in backend
if(isset($_GET['action']) && $_GET['action'] == 'upload_element_image' && $_GET['mode'] == 'backend')
{
	$f_upload_field_id = $_GET['upload_field_id'];
	$c_elements_id = 0;
	if(isset($_GET['elements_id']))
	{
		$f_elements_id = $_GET['elements_id'];
		$c_elements_id = (int)$f_elements_id;
	}
	$c_upload_field_id = gm_string_filter($f_upload_field_id, 'a-z0-9_');
	
	
	$coo_file_manager = new GMGPrintFileManager();
	
	if($c_elements_id > 0 && $coo_file_manager->get_error($c_upload_field_id) == 0)
	{
		foreach($_SESSION['coo_gprint_backend']->v_surfaces[$_SESSION['coo_gprint_backend']->get_current_surfaces_id()]->v_elements[$c_elements_id]->v_values AS $t_value)
		{
			$t_pattern = '/^[0-9]*_' . substr(strrchr($c_upload_field_id, '_'), 1) . '_(.*)/';
			if(!empty($t_value[0]) && preg_match($t_pattern, $t_value[0]) == 1)
			{
				$t_delete_file = $coo_file_manager->delete_file(DIR_FS_CATALOG . DIR_WS_IMAGES . 'gm/gprint/' . $t_value[0]);
			}							
		}	
		
		$t_new_filename = $c_elements_id;		
	}	
	else
	{
		$t_new_filename = $coo_file_manager->get_next_filename_id();
	}
	
	$t_new_filename .= '_' . substr(strrchr($c_upload_field_id, '_'), 1) . '_' . preg_replace('/[^0-9a-zA-Z._-]/', '-', $_FILES[$c_upload_field_id]['name']);
	
	$coo_file_manager->upload($c_upload_field_id, DIR_FS_CATALOG . DIR_WS_IMAGES . 'gm/gprint/', array('gif', 'jpg', 'jpeg', 'png'), $t_new_filename);
	
	$t_image_size = $coo_file_manager->get_image_size(DIR_FS_CATALOG . DIR_WS_IMAGES . 'gm/gprint/' . $t_new_filename);
	
	$t_image_data = array();
	if($t_image_size !== false)
	{
		$t_image_data['WIDTH'] = $t_image_size[0];
		$t_image_data['HEIGHT'] = $t_image_size[1];
		$t_image_data['FILENAME'] = $t_new_filename;
		$t_image_data['LANGUAGES_ID'] = substr(strrchr($c_upload_field_id, '_'), 1);
	}
	else
	{
		$t_image_data['WIDTH'] = 100;
		$t_image_data['HEIGHT'] = 100;
		$t_image_data['FILENAME'] = '';
		$t_image_data['LANGUAGES_ID'] = substr(strrchr($c_upload_field_id, '_'), 1);
	}	
	
	$coo_json = new GMJSON();
	$t_output = $coo_json->encode($t_image_data);
}
// file upload frontend
elseif(isset($_GET['action']) && $_GET['action'] == 'upload')
{
	$f_upload_field_id = $_GET['upload_field_id'];
	$f_products_id = $_GET['products_id'];
	$f_target = $_GET['target'];
	$c_upload_field_id = gm_string_filter($f_upload_field_id, 'a-z0-9_');

	$t_products_properties_combis_id = 0;
	$t_products_id = $f_products_id;

	if(isset($_GET['properties_values_ids']))
	{
		$coo_properties_control = MainFactory::create_object('PropertiesControl');
		$t_products_properties_combis_id = $coo_properties_control->get_combis_id_by_value_ids_array(xtc_get_prid($f_products_id), $_GET['properties_values_ids']);
		$t_products_id .= 'x' . $t_products_properties_combis_id;
		if($t_products_properties_combis_id == 0)
		{
			die('combi not available');
		}
	}

	$c_products_id = gm_string_filter($t_products_id, '0-9{}x');
	
	$f_new_filename = $_FILES[$c_upload_field_id]['name'];
	$c_new_filename = basename($f_new_filename);
	
	if(!is_object($_SESSION['coo_gprint_cart']) && $f_target == 'cart')
	{
		$_SESSION['coo_gprint_cart'] = new GMGPrintCartManager();
	}
	elseif(!is_object($_SESSION['coo_gprint_wishlist']) && $f_target == 'wishlist')
	{
		$_SESSION['coo_gprint_wishlist'] = new GMGPrintWishlistManager();
	}
	
	$t_elements_id = str_replace('element_', '', $f_upload_field_id);
	
	if($f_target == 'cart')
	{
		$t_new_products_id = $_SESSION['coo_gprint_cart']->check_cart($c_products_id, 'cart', false);
				
		if($t_new_products_id !== false)
		{
			$c_products_id = $t_new_products_id;
		}
		
		$_SESSION['coo_gprint_cart']->add($c_products_id, $t_elements_id, $c_new_filename);
		$t_new_filename = $_SESSION['coo_gprint_cart']->add_file($c_products_id, $t_elements_id, $c_new_filename);

		if(!empty($_SESSION['customer_id']))
		{
			$_SESSION['coo_gprint_cart']->save();
		}	
		
		$t_allowed_file_extensions = $_SESSION['coo_gprint_cart']->get_allowed_extensions($t_elements_id);
		$t_minimum_filesize = $_SESSION['coo_gprint_cart']->get_minimum_filesize($t_elements_id);
		$t_maximum_filesize = $_SESSION['coo_gprint_cart']->get_maximum_filesize($t_elements_id);
	}
	elseif($f_target == 'wishlist')
	{
		$t_new_products_id = $_SESSION['coo_gprint_wishlist']->check_wishlist($c_products_id, 'wishList', false);
				
		if($t_new_products_id !== false)
		{
			$c_products_id = $t_new_products_id;
		}
		
		$_SESSION['coo_gprint_wishlist']->add($c_products_id, $t_elements_id, $c_new_filename);
		$t_new_filename = $_SESSION['coo_gprint_wishlist']->add_file($c_products_id, $t_elements_id, $c_new_filename);

		if(!empty($_SESSION['customer_id']))
		{
			$_SESSION['coo_gprint_wishlist']->save();
		}	
		
		$t_allowed_file_extensions = $_SESSION['coo_gprint_wishlist']->get_allowed_extensions($t_elements_id);
		$t_minimum_filesize = $_SESSION['coo_gprint_wishlist']->get_minimum_filesize($t_elements_id);
		$t_maximum_filesize = $_SESSION['coo_gprint_wishlist']->get_maximum_filesize($t_elements_id);
	}
	
	$coo_file_manager = new GMGPrintFileManager();
	
	$t_allowed_file_extensions = explode(',', $t_allowed_file_extensions);
	
	$t_upload = $coo_file_manager->upload($c_upload_field_id, DIR_FS_CATALOG . 'gm/customers_uploads/gprint/', $t_allowed_file_extensions, $t_new_filename, 0777, $t_minimum_filesize, $t_maximum_filesize);
		
	$coo_json = new GMJSON();
	
	$t_upload_data = array();
	

	if($t_upload === true)
	{
		$t_upload_data = array('FILENAME' => htmlentities_wrapper($c_new_filename), 
								'UPLOAD_FIELD_ID' => $c_upload_field_id, 
								'ERROR' => false, 
								'ERROR_MESSAGE' => '');
	}
	if($t_upload === 'no_permission_to_save_file' 
		|| $t_upload === 'spam' 
		|| $t_upload === 'wrong_type' 
		|| $t_upload === 'only_partially_uploaded'
		|| $t_upload === 'filesize_below_limit' 
		|| $t_upload === 'filesize_limit_exceeded')
	{
		if($f_target == 'cart')
		{
			$_SESSION['coo_gprint_cart']->remove($c_products_id);
		}
		elseif($f_target == 'wishlist')
		{
			$_SESSION['coo_gprint_wishlist']->remove($c_products_id);
		}
		
		if($t_upload === 'spam')
		{
			$t_error_message = GM_GPRINT_ERROR_SPAM_1 . 
								gm_get_conf('GM_GPRINT_UPLOADS_PER_IP_INTERVAL') . 
								GM_GPRINT_ERROR_SPAM_2 .
								gm_get_conf('GM_GPRINT_UPLOADS_PER_IP') . 
								GM_GPRINT_ERROR_SPAM_3;
								
		}
		elseif($t_upload === 'wrong_type')
		{
			$t_error_message = GM_GPRINT_ERROR_WRONG_FILE_TYPE . implode(', ', $t_allowed_file_extensions);
		}
		elseif($t_upload === 'only_partially_uploaded')
		{
			$t_error_message = GM_GPRINT_ERROR_FILE_UPLOAD_PARTIAL;
		}
		elseif($t_upload === 'filesize_below_limit')
		{
			$t_error_message = GM_GPRINT_ERROR_FILESIZE_BELOW_LIMIT_1 . 
								gm_prepare_string($c_new_filename) . 
								GM_GPRINT_ERROR_FILESIZE_BELOW_LIMIT_2 . 
								$t_minimum_filesize . 
								GM_GPRINT_ERROR_FILESIZE_BELOW_LIMIT_3;
		}
		elseif($t_upload === 'filesize_limit_exceeded')
		{
			$t_error_message = GM_GPRINT_ERROR_FILESIZE_LIMIT_EXCEEDED_1 . 
								gm_prepare_string($c_new_filename) . 
								GM_GPRINT_ERROR_FILESIZE_LIMIT_EXCEEDED_2 . 
								$t_maximum_filesize . 
								GM_GPRINT_ERROR_FILESIZE_LIMIT_EXCEEDED_3;
		}
		else
		{
			$t_error_message = GM_GPRINT_ERROR_FILE_UPLOAD;		
		}
		
		
		$t_upload_data = array('FILENAME' => '', 
								'UPLOAD_FIELD_ID' => $c_upload_field_id, 
								'ERROR' => true, 
								'ERROR_MESSAGE' => $t_error_message);
	}
	elseif($t_upload === 'no_file')
	{
		$t_upload_data = array('FILENAME' => '', 
								'UPLOAD_FIELD_ID' => $c_upload_field_id, 
								'ERROR' => false, 
								'ERROR_MESSAGE' => '');
	}
	
	$t_output = $coo_json->encode($t_upload_data);
}

echo $t_output;

?>