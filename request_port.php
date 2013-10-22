<?php
/* --------------------------------------------------------------
   request_port.inc.php 2012-01-01 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/
require('includes/application_top.php');

#error_reporting(E_ALL);
$t_output_content = '';

switch($_GET['module'])
{
	case 'browser_extension':
		$coo_browser_extension_ajax_handler = MainFactory::create_object('BrowserExtensionAjaxHandler');
		$coo_browser_extension_ajax_handler->set_data('GET', $_GET);
		$coo_browser_extension_ajax_handler->set_data('POST', $_POST);
		$coo_browser_extension_ajax_handler->proceed();
		$t_output_content = $coo_browser_extension_ajax_handler->get_response();
		break;
	
	case 'slider':
		$coo_slider_ajax_handler = MainFactory::create_object('SliderAjaxHandler');
		$coo_slider_ajax_handler->set_data('GET', $_GET);
		$coo_slider_ajax_handler->set_data('POST', $_POST);
		$coo_slider_ajax_handler->proceed();
		$t_output_content = $coo_slider_ajax_handler->get_response();
		break;
  
	case 'cart_dropdown':
		switch($_GET['part'])
		{
			case 'header':
				$coo_content_view = MainFactory::create_object('ShoppingCartDropdown');
				$coo_content_view->set_content_template('boxes/box_cart_head.html');
				$t_output_content = $coo_content_view->get_html();
				break;

			case 'dropdown':
				$coo_content_view = MainFactory::create_object('ShoppingCartDropdown');
				$t_output_content = $coo_content_view->get_html();
				break;

			case 'fixed':
				$coo_content_view = MainFactory::create_object('ShoppingCartDropdown');
				$coo_content_view->set_content_template('boxes/box_cart_dropdown_fixed.html');
				$t_output_content = $coo_content_view->get_html();
				break;

		}
		break;

	case 'buy_now': #TODO: move to coo_handler
		# fake environment
		$_GET['action'] = 'buy_now';
		$_GET['BUYproducts_id'] = (int)$_POST['products_id'];

		$t_turbo_buy_now = true;	# flag used in cart_actions
		$t_show_cart = false;		# will be changed in cart_actions
		$t_show_details = false;	# will be changed in cart_actions

		# run cart_actions
		require(DIR_WS_INCLUDES.FILENAME_CART_ACTIONS);
		
		$t_output_array = array
		(
			'show_cart' => $t_show_cart,
			'show_details' => $t_show_details,
			'products_details_url' => xtc_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int)$_GET['BUYproducts_id'])
		);
		$coo_json = new GMJSON(false);
		$t_output_json = $coo_json->encode($t_output_array);

		$t_output_content = $t_output_json;
		break;

	case 'properties_combis_status':
		$coo_properties_view = MainFactory::create_object('PropertiesView');
		$t_output_content = $coo_properties_view->get_combis_status_json($_GET['products_id'], $_GET['properties_values_ids'], $_GET['need_qty']);
		break;

	case 'properties_combis_exists':
		$coo_properties_view = MainFactory::create_object('PropertiesView');
		$t_output_content = $coo_properties_view->get_combis_exists($_GET['products_id'], $_GET['properties_values_ids']);
		break;

	case 'properties_combis_status_by_combis_id':
		$coo_properties_view = MainFactory::create_object('PropertiesView');
		$t_output_content = $coo_properties_view->get_combis_status_by_combis_id_json($_GET['combis_id'], $_GET['need_qty']);
		break;
		
	case 'properties_combis_admin':
		$coo_properties_combis_admin_view = new PropertiesCombisAdminView($_GET, $_POST);
		$t_output_content = $coo_properties_combis_admin_view->proceed();
		break;
		
	case 'lightbox_gallery':
		$c_products_id = (int)$_GET['id'];

		$coo_lightbox_gallery = MainFactory::create_object('LightboxGalleryContentView');
		$t_lightbox_html = $coo_lightbox_gallery->get_html($c_products_id);

		$t_output_content = $t_lightbox_html;
		break;

	case 'mega_flyover':
		$f_get_array = $_GET;
		$f_post_array = $_POST;

		$coo_mega_flyover = MainFactory::create_object('MegaFlyoverContentView');
		$t_view_html = $coo_mega_flyover->get_html($f_get_array, $f_post_array);

		$t_output_content = $t_view_html;
		break;

	case 'live_search':
		include(DIR_FS_CATALOG . 'gm/ajax/live_search.php');
		break;

	case 'submenus':
		$f_get_array = $_GET;
		$c_parent_categories_id = (int)$f_get_array['id'];

		# Categories Submenus
		$coo_categories_content_view = MainFactory::create_object('CategoriesSubmenusContentView');
		$t_output_content = $coo_categories_content_view->get_html(false, $c_parent_categories_id);
		break;
	
	default:
		# plugin requests
		$f_module_name = $_GET['module'];

		$t_system_class_dir = DIR_FS_CATALOG . 'system/request_port/AjaxHandler/';
		$t_user_class_dir = DIR_FS_CATALOG . 'user_classes/AjaxHandler/';
		$t_class_name_suffix = 'AjaxHandler';
		$coo_request_router = MainFactory::create_object('RequestRouter', array($t_system_class_dir,
																				$t_user_class_dir,
																				$t_class_name_suffix));

		$coo_request_router->set_data('GET', $_GET);
		$coo_request_router->set_data('POST', $_POST);

		$t_proceed_status = $coo_request_router->proceed($f_module_name);
		if($t_proceed_status == true) {
			$t_output_content = $coo_request_router->get_response();
		} else {
			trigger_error('could not proceed module ['.htmlentities_wrapper($f_module_name).']', E_USER_ERROR);
		}
}	

echo $t_output_content;
mysql_close();
?>