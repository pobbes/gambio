<?php
/* --------------------------------------------------------------
   BrowserExtensionControl.inc.php 2011-11-03 tb@gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

class BrowserExtensionControl
{
	function get_data_array( $p_action_request, $p_token_request, $p_language_request, $p_data_array_request )
	{
		$gm_array = array();
		$gm_query = xtc_db_query("SELECT languages_id FROM languages WHERE code = '" . $p_language_request . "'");
		$gm_array = xtc_db_fetch_array($gm_query);
		
		$coo_data_source = MainFactory::create_object('BrowserExtensionSource', array(false));
		
		$coo_text_mgr = MainFactory::create_object('LanguageTextManager', array('browser_extension', $gm_array['languages_id']), false);
		$t_section_array = $coo_text_mgr->get_section_array();
		
		$t_data_array = array();

		$t_action_request = (string) $p_action_request;
		
		$t_token_request = (string) $p_token_request;
		
		$t_extension_active = $coo_data_source->get_extension_status();
		
		$t_valid_customers = $coo_data_source->get_customers_status();

		switch($t_action_request){
			case 'get_data':
				$t_valid_token = $coo_data_source->check_auth_token($t_token_request);
				
				if($t_valid_token && $t_extension_active)
				{
					$coo_data_source->get_cache_file_data();
					$t_cache_data_array = $coo_data_source->get_cache_data_array();
					
					foreach($p_data_array_request AS $t_key => $t_data_value)
					{	
						// CHECK ORDERS
						if(strpos($t_data_value,"ORDERS_")!==false)
						{
							$t_order_date_array = explode('_', $t_data_value);
							$t_orders = $coo_data_source->get_order_totals($t_order_date_array[1], $t_order_date_array[2]);

							$t_class = '';
							if($t_orders != $t_cache_data_array['ORDERS'])
							{
								if((int)$t_orders > (int)$t_cache_data_array['ORDERS'])
								{
									$t_class = 'changePositive';
								}else{
									$t_class = 'changeNegative';
								}
							}
							
							$t_data_array[] = array("content" => $t_section_array['ORDERS'] . ' ' . $t_orders, "class" => $t_class);
							$t_cache_data_array['ORDERS'] = $t_orders;	
						}
						
						// CHECK AMOUNT
						if(strpos($t_data_value,"AMOUNT_")!==false)
						{
							$t_amount_date_array = explode('_', $t_data_value);
							$t_amount = $coo_data_source->get_amount($t_amount_date_array[1], $t_amount_date_array[2]);

							$t_class = '';
							if($t_amount != $t_cache_data_array['AMOUNT'])
							{
								if((int)$t_amount > (int)$t_cache_data_array['AMOUNT'])
								{
									$t_class = 'changePositive';
								}else{
									$t_class = 'changeNegative';
								}
							}
							
							$gm_array = array();
							$gm_query = xtc_db_query("SELECT configuration_value AS CURRENCY FROM configuration WHERE configuration_key = 'DEFAULT_CURRENCY'");
							$gm_array = xtc_db_fetch_array($gm_query);					
							$t_currency = $gm_array['CURRENCY'];
							
							$t_data_array[] = array("content" => $t_section_array['AMOUNT'] . ' ' . $t_amount . " " . $t_currency, "class" => $t_class);
							$t_cache_data_array['AMOUNT'] = $t_amount;	
						}
						
						// CHECK LOW PRODUCTS QUANTITY COUNT
						if($t_data_value == 'LOW_PRODUCTS_QUANTITY_COUNT')
						{
							$t_low_products_quantity_count = $coo_data_source->get_low_products_quantity_count();

							$t_class = '';
							if($t_low_products_quantity_count != $t_cache_data_array['LOW_PRODUCTS_QUANTITY_COUNT'])
							{
								if($t_low_products_quantity_count > $t_cache_data_array['LOW_PRODUCTS_QUANTITY_COUNT'])
								{
									$t_class = 'changeNegative';
								}else{
									$t_class = 'changePositive';
								}
							}
							
							$t_data_array[] = array("content" => $t_section_array['LOW_PRODUCTS_QUANTITY_1'] . ' ' . $t_low_products_quantity_count . ' ' . $t_section_array['LOW_PRODUCTS_QUANTITY_2'], "class" => $t_class);
							$t_cache_data_array['LOW_PRODUCTS_QUANTITY_COUNT'] = $t_low_products_quantity_count;
						}
						
						// CHECK USER ONLINE COUNT
						if($t_data_value == 'USER_ONLINE')
						{
							$t_user_online_count_guests = $coo_data_source->get_user_online_count(false);
							$t_user_online_count_customers = $coo_data_source->get_user_online_count(true);

							$t_data_array[] = array("content" => $t_section_array['USER_ONLINE'] . ' ' . $t_user_online_count_guests . ' / ' . $t_user_online_count_customers, "class" => "");
						}
					}
					
					$coo_data_source->set_cache_data_array($t_cache_data_array);
					$coo_data_source->save_cache_file_data();
					
					return $t_data_array;
				}else if($t_valid_token){
					echo 'error4';
				}else{
					echo 'error6';
				}
				break;
		
			case 'sync':
				if($t_valid_customers && $t_extension_active)
				{
					$t_data_array['shop_title'] = $coo_data_source->get_shop_title();
					$t_data_array['shop_token'] = $coo_data_source->get_auth_token();
					return $t_data_array;
				}else if($t_valid_customers){
					echo 'extension not active';
				}else{
					echo 'no access - login incorrect';
				}
				break;
			
			default:
				trigger_error('t_action_request not found: '. htmlentities_wrapper($t_action_request));
				return false;
		}

	} 
}
?>