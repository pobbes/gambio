<?php
/* --------------------------------------------------------------
   request_port.inc.php 2012-08-08 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/
require('includes/application_top.php');

require_once(DIR_FS_DOCUMENT_ROOT.'gm/properties/data/PropertiesDataAgent.php');
require_once(DIR_FS_DOCUMENT_ROOT.'gm/properties/data/PropertiesStructSupplier.php');
require_once(DIR_FS_DOCUMENT_ROOT.'gm/properties/data/PropertiesCombisStructSupplier.php');

require_once(DIR_FS_DOCUMENT_ROOT.'gm/properties/page_modules/PropertiesAdminView.php');
require_once(DIR_FS_DOCUMENT_ROOT.'gm/properties/controls/PropertiesAdminControl.php');

require_once(DIR_FS_DOCUMENT_ROOT.'gm/properties/page_modules/PropertiesCombisAdminView.php');
require_once(DIR_FS_DOCUMENT_ROOT.'gm/properties/controls/PropertiesCombisAdminControl.php');

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

	case 'megadropdown':
		$c_categories_id = (int)$_GET['categories_id'];

		$coo_categories_dropdown = MainFactory::create_object('CategoriesContentView');
		$coo_categories_dropdown->set_content_template('module/megadropdown.html');
		$coo_categories_dropdown->set_tree_depth(1);
		$t_categories_html = $coo_categories_dropdown->get_html($c_categories_id);

		$t_output_content = $t_categories_html;
		break;

	case 'reset_combis_sort_order':
		$coo_properties_combis_admin_control = MainFactory::create_object('PropertiesCombisAdminControl');
		$coo_properties_combis_admin_control->reset_combis_sort_order((int)$_GET['products_id']);
		$t_output_content = 'success';
		break;

	case 'properties_save_dropdown_mode':
		$coo_properties_combis_admin_control = new PropertiesCombisAdminControl();
		$t_output_content = $coo_properties_combis_admin_control->save_properties_dropdown_mode($_POST['products_id'], $_POST['dropdown_mode_value']);
		break;
	
	case 'properties_save_price_show':
		$coo_properties_combis_admin_control = new PropertiesCombisAdminControl();
		$t_output_content = $coo_properties_combis_admin_control->save_properties_price_show($_POST['products_id'], $_POST['price_show_value']);
		break;
	
	case 'use_properties_combis_weight':
		$coo_properties_combis_admin_control = new PropertiesCombisAdminControl();
		$t_output_content = $coo_properties_combis_admin_control->save_use_properties_combis_weight($_POST['products_id'], $_POST['use_properties_combis_weight']);
		break;
	
	case 'use_properties_combis_quantity':
		$coo_properties_combis_admin_control = new PropertiesCombisAdminControl();
		$t_output_content = $coo_properties_combis_admin_control->save_use_properties_combis_quantity($_POST['products_id'], $_POST['use_properties_combis_quantity']);
		break;
	
	case 'use_properties_combis_shipping_time':
		$coo_properties_combis_admin_control = new PropertiesCombisAdminControl();
		$t_output_content = $coo_properties_combis_admin_control->save_use_properties_combis_shipping_time($_POST['products_id'], $_POST['use_properties_combis_shipping_time']);
		break;

	case 'properties_admin':
		$coo_properties_admin_view = new PropertiesAdminView($_GET, $_POST);
		$t_output_content = $coo_properties_admin_view->proceed();
		break;

	case 'properties_combis_status':
		$coo_properties_view = MainFactory::create_object('PropertiesView');
		$t_output_content = $coo_properties_view->get_combis_status_json($_GET['products_id'], $_GET['properties_values_ids']);
		break;
		
	case 'properties_combis_admin':
		$coo_properties_combis_admin_view = new PropertiesCombisAdminView($_GET, $_POST);
		$t_output_content = $coo_properties_combis_admin_view->proceed();
		break;

	case 'properties_combis_image_upload':
		$c_combis_id	= (int)$_GET['combis_id'];
		$t_target_path	= DIR_FS_CATALOG_IMAGES.'product_images/properties_combis_images/';
		$t_filename		= '';

		#copy upload file to target dir
		$t_upload_file =& xtc_try_upload('combi_image', $t_target_path);

		if($t_upload_file)
		{
			#rename uploaded file
			$t_old_file = $t_upload_file->filename;
			$t_new_file = $c_combis_id .'_'. $t_old_file;

			rename(
				$t_target_path . $t_old_file,
				$t_target_path . $t_new_file
			);

			#get combi data object
			$coo_combis = new GMDataObject('products_properties_combis', array('products_properties_combis_id' => $c_combis_id));

			#delete old combi_image if ixists
			$t_old_image = $coo_combis->get_data_value('combi_image');
			if(empty($t_old_image) == false) unlink($t_target_path.$t_old_image);

			#save new filename to combi
			$coo_combis->set_data_value('combi_image', $t_new_file);
			$coo_combis->save_body_data();
			
			#return value
			$t_output_content = 'success';
		}
		else
		{
			$t_output_content = 'upload_error';
		}
		break;

	case 'properties_autobuild_combis':
		$coo_control = MainFactory::create_object('PropertiesCombisAdminControl');
		$t_properties_value_ids_array = $coo_control->get_admin_select($_GET['products_id']);

		if(sizeof($t_properties_value_ids_array) > 0) {
			$coo_control->autobuild_combis($_GET['products_id'], $t_properties_value_ids_array);
		}
		break;

	case 'reset_combis_sort_order':
		$coo_control = MainFactory::create_object('PropertiesCombisAdminControl');
		$t_properties_value_ids_array = $coo_control->reset_combis_sort_order($_GET['products_id']);
                
		break;

	case 'properties_save_admin_select':
		# save admin select
		$coo_control = MainFactory::create_object('PropertiesCombisAdminControl');

		$f_products_id = 0;
		$f_properties_value_ids_array = array();
		
		if(isset($_GET['products_id'])) $f_products_id = $_GET['products_id'];
		if(isset($_POST['products_id'])) $f_products_id = $_POST['products_id'];

		if(isset($_GET['properties_value_ids_array'])) $f_properties_value_ids_array = $_GET['properties_value_ids_array'];
		if(isset($_POST['properties_value_ids_array'])) $f_properties_value_ids_array = $_POST['properties_value_ids_array'];

		$coo_control->save_admin_select($f_products_id, $f_properties_value_ids_array);

		# run combi auto_build
		$t_built_combis_id_array = array();
		if(isset($_GET['run_autobuild']) || isset($_POST['run_autobuild']))
		{
			$t_built_combis_id_array = $coo_control->autobuild_combis($f_products_id, $f_properties_value_ids_array);
		}

		# get combi table html
		if(isset($_GET['run_get_html']) || isset($_POST['run_get_html']))
		{
			$coo_view = MainFactory::create_object('PropertiesCombisAdminView', array($_GET, $_POST));
			foreach($t_built_combis_id_array as $t_combis_id)
			{
				$t_output_content .= $coo_view->get_properties_combis_table($t_combis_id, $_SESSION['languages_id']);
			}
		}
		break;

	case 'properties_get_admin_select':
		if($_GET['detailed'] == '1')
		{
			$coo_control = MainFactory::create_object('PropertiesCombisAdminControl');
			$t_values_array = $coo_control->get_admin_select_detailed($_GET['products_id']);
		}
		else {
			$coo_control = MainFactory::create_object('PropertiesCombisAdminControl');
			$t_values_array = $coo_control->get_admin_select($_GET['products_id']);
		}
		$coo_json = MainFactory::create_object('GMJSON', array(false));
		$t_output_content = $coo_json->encode($t_values_array);
		break;

	case 'show_logs':
		require(DIR_FS_ADMIN.'gm/classes/ShowLogs.php');
		$coo_show_logs = new ShowLogs();
		$t_output_content = nl2br($coo_show_logs->get_log($_POST['file'],  $_POST['page']));
		break;

	case 'clear_log':
		require(DIR_FS_ADMIN.'gm/classes/ShowLogs.php');
		$coo_show_logs = new ShowLogs();
		$t_output_content = $coo_show_logs->clear_log($_POST['file']);
		break;

	case 'delete_log':
		require(DIR_FS_ADMIN.'gm/classes/ShowLogs.php');
		$coo_show_logs = new ShowLogs();
		$t_output_content = $coo_show_logs->delete_log($_POST['file']);
		break;

	case 'paypal_api_check':
		$t_output_content = '';
		if (isset($_POST['module']) && ($_POST['module'] == 'paypal' || $_POST['module'] == 'paypalexpress')) {
			require_once(DIR_FS_CATALOG.DIR_WS_CLASSES.'paypal_checkout.php');
			$paypal = new paypal_checkout();
			$t_api_result = $paypal->check_api();
			$t_output_content = $t_api_result;
		}
		break;

	case 'load_paypal_admin_notifikation':
		$t_output_content = '';
		define('TABLE_PAYPAL','paypal');
		define('FILENAME_PAYPAL','paypal.php');
		require_once(DIR_FS_CATALOG.DIR_WS_CLASSES.'paypal_checkout.php');
		require_once(DIR_FS_ADMIN.DIR_WS_CLASSES.'class.paypal.php');
		$paypal = new paypal_admin();
		$t_api_result = $paypal->admin_notification($_GET['oID']);
		$t_output_content = $t_api_result;
		break;
	
	case 'load_content':
		$coo_load_url = MainFactory::create_object('LoadUrl');
		
		$t_header_data_array = array();
		if(isset($_GET['header_data_array']) && is_array($_GET['header_data_array']))
		{
			$t_header_data_array = $_GET['header_data_array'];
		}
		$t_iframe_style = '';
		if(isset($_GET['iframe_style']))
		{
			$t_iframe_style = (string)$_GET['iframe_style'];
		}
		
		$result = $coo_load_url->load_url($_GET['link'], $t_header_data_array, $t_iframe_style);
		
		$t_output_content = TEXT_NO_CONTENT;
		if($result) {
			$t_output_content = $result;
		}
		break;
		
	default:
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