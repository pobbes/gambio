<?php
/* --------------------------------------------------------------
   ProductDetailsContentView.inc.php 2012-07-23 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------*/

require_once(DIR_FS_INC . 'get_products_vpe_array.inc.php');
require_once(DIR_FS_INC . 'xtc_get_products_mo_images.inc.php');
require_once(DIR_WS_CLASSES . 'order.php'); // needed for old shop versions

class ProductDetailsContentView extends ContentView
{
	function ProductDetailsContentView()
	{
		$this->set_content_template('module/product_details.html');
		$this->set_flat_assigns(true);
	}

	function get_html($p_products_id)
	{
		$c_products_id = (string)$p_products_id;
		
		$coo_properties_control = MainFactory::create_object('PropertiesControl');
		$coo_properties_view = MainFactory::create_object('PropertiesView');
		$xtPrice = new xtcPrice($_SESSION['currency'], $_SESSION['customers_status']['customers_status_id']);
		$order = new order();
		$main = new main();
		
		$t_products_array = array();
		
		// search matching key $i in products array of order object
		for($i = 0, $n = count($order->products); $i < $n; $i++)
		{
			if($order->products[$i]['id'] == $c_products_id)
			{
				break;
			}
		}
				
		$coo_product = new product(xtc_get_prid($c_products_id));
	
		// attributes options/values array needed for vpe data
		$t_options_values_array = array();
		$t_attr_weight = 0;
		$t_attr_model_array = array();
		if(isset($order->products[$i]['attributes']) && is_array($order->products[$i]['attributes']))
		{
			foreach($order->products[$i]['attributes'] AS $t_attributes_data_array)
			{
				$t_options_values_array[$t_attributes_data_array['option_id']] = $t_attributes_data_array['value_id'];
			}
			
			// calculate attributes weight and get attributes model
			foreach($t_options_values_array AS $t_option_id => $t_value_id)
			{
				$t_attr_sql = "SELECT
									options_values_weight AS weight,
									weight_prefix AS prefix,
									attributes_model
								FROM
									products_attributes
								WHERE
									products_id				= '" . (int)xtc_get_prid($order->products[$i]['id']) . "' AND
									options_id				= '" . (int)$t_option_id . "' AND
									options_values_id		= '" . (int)$t_value_id	 . "'
								LIMIT 1";
				$t_attr_result = xtc_db_query($t_attr_sql);
				if(xtc_db_num_rows($t_attr_result) == 1)
				{
					$t_attr_result_array = xtc_db_fetch_array($t_attr_result);

					if(trim($t_attr_result_array['attributes_model']) != '')
					{
						$t_attr_model_array[] = $t_attr_result_array['attributes_model'];
					}

					if($t_attr_result_array['prefix'] == '-')
					{
						$t_attr_weight -= (double)$t_attr_result_array['weight'];
					} 
					else
					{
						$t_attr_weight += (double)$t_attr_result_array['weight'];
					}
				}			
			}
		}

		$t_shipping_time = '';
		if(ACTIVATE_SHIPPING_STATUS == 'true')
		{
			$t_shipping_time = $order->products[$i]['shipping_time'];
		}

		$t_products_weight = '';	
		if(!empty($coo_product->data['gm_show_weight']))
		{
			// already contains products properties weight
			$t_products_weight = gm_prepare_number($order->products[$i]['weight'] + $t_attr_weight, $xtPrice->currencies[$xtPrice->actualCurr]['decimal_point']);
		}

		$t_products_model = $order->products[$i]['model'];
		if($t_products_model != '' && isset($t_attr_model_array[0]))
		{
			$t_products_model .= '-' . implode('-', $t_attr_model_array);
		}
		else
		{
			$t_products_model .= implode('-', $t_attr_model_array);
		}
		$t_quantity = $coo_product->data['products_quantity'];
		
		#properties
		$t_properties = '';
		$t_properties_array = array();
		$t_combis_id = $coo_properties_control->extract_combis_id($order->products[$i]['id']);
		if($t_combis_id != '')
		{
			$t_properties = $coo_properties_view->get_order_details_by_combis_id($t_combis_id, 'cart');
			
			$t_properties_array = $coo_properties_view->v_coo_properties_control->get_properties_combis_details($t_combis_id, $_SESSION['languages_id']);			

			if(method_exists($coo_properties_control, 'get_properties_combis_model'))
			{
				$t_combi_model = $coo_properties_control->get_properties_combis_model($t_combis_id);

				if(APPEND_PROPERTIES_MODEL == "true") {
					// Artikelnummer (Kombi) an Artikelnummer (Artikel) anhängen
					if($t_products_model != '' && $t_combi_model != ''){
						$t_products_model = $t_products_model .'-'. $t_combi_model;
					}else if($t_combi_model != ''){
						$t_products_model = $t_combi_model;
					}
				}else{
					// Artikelnummer (Artikel) durch Artikelnummer (Kombi) ersetzen
					if($t_combi_model != ''){
						$t_products_model = $t_combi_model;
					}
				}

				if($coo_product->data['use_properties_combis_shipping_time'] == 1 && ACTIVATE_SHIPPING_STATUS == 'true'){
					$t_shipping_time = $coo_properties_control->get_properties_combis_shipping_time($t_combis_id);
				}
			}
			
			$t_use_combis_quantity = $coo_properties_control->get_use_properties_combis_quantity($order->products[$i]['id']);
		
			if(($t_use_combis_quantity == 0 && STOCK_CHECK == 'true' && ATTRIBUTE_STOCK_CHECK == 'true') || $t_use_combis_quantity == 2){
				$t_quantity = $coo_properties_control->get_properties_combis_quantity($t_combis_id);
			}
		}
		
		$t_products_attributes = array();

		if ((isset ($order->products[$i]['attributes'])) && (sizeof($order->products[$i]['attributes']) > 0)) {
			for ($j = 0, $n2 = sizeof($order->products[$i]['attributes']); $j < $n2; $j++) 
			{
				$t_products_attributes_item = array(
													'option' => $order->products[$i]['attributes'][$j]['option'],
													'value'  => $order->products[$i]['attributes'][$j]['value']
												);
				
				$t_products_attributes[] = $t_products_attributes_item;
			}
			// GX-Customizer:
			include(DIR_FS_CATALOG . 'gm/modules/gm_gprint_checkout_confirmation.php');
		}		
		
		
		if($coo_product->data['products_image'] != '' && $coo_product->data['gm_show_image'] == '1')
		{
			$t_images_array[] = array('IMAGE' => DIR_WS_THUMBNAIL_IMAGES . $coo_product->data['products_image'],
										'IMAGE_ALT' => $coo_product->data['gm_alt_text']
									);
		}

		$t_mo_images_array = xtc_get_products_mo_images($coo_product->data['products_id']);

		if($t_mo_images_array != false)
		{
			$coo_gm_alt_form = MainFactory::create_object('GMAltText');

			foreach($t_mo_images_array as $t_image_array)
			{
				$t_images_array[] = array('IMAGE' => DIR_WS_THUMBNAIL_IMAGES . $t_image_array['image_name'],
											'IMAGE_ALT' => $coo_gm_alt_form->get_alt($t_image_array["image_id"], $t_image_array['image_nr'], $coo_product->data['products_id'])
										);
			}		
		}			
		
		$this->set_content_data('PRODUCTS_TAX_INFO', $main->getTaxInfo($xtPrice->TAX[$coo_product->data['products_tax_class_id']]));
		$this->set_content_data('PRODUCTS_SHIPPING_LINK', str_replace(' target="_blank"', '', $main->getShippingLink(true)));
		
		
		$this->set_content_data('HTML_PARAMS', HTML_PARAMS);
		$this->set_content_data('CHARSET', $_SESSION['language_charset']);
		$this->set_content_data('BASE_URL', GM_HTTP_SERVER . DIR_WS_CATALOG);
		
		$coo_tab_tokenizer = MainFactory::create_object('GMTabTokenizer', array(stripslashes($coo_product->data['products_description'])));
		$this->set_content_data('DESCRIPTION', $coo_tab_tokenizer->get_prepared_output());
		$this->set_content_data('NAME', $order->products[$i]['name']);		
		$this->set_content_data('PRICE', $xtPrice->xtcFormat($order->products[$i]['price'], true));
		$this->set_content_data('PROPERTIES', $t_properties);
		$this->set_content_data('PROPERTIES_ARRAY', $t_properties_array);
		$this->set_content_data('VPE_ARRAY', get_products_vpe_array($order->products[$i]['id'], $order->products[$i]['price'], $t_options_values_array));
		$this->set_content_data('MODEL', $t_products_model);
		$this->set_content_data('WEIGHT', $t_products_weight);
		$this->set_content_data('SHIPPING_TIME', $t_shipping_time);		
		$this->set_content_data('UNIT', $order->products[$i]['unit_name']);
		$this->set_content_data('ATTRIBUTES_ARRAY', $t_products_attributes);
		$this->set_content_data('IMAGES_ARRAY', $t_images_array);
		$this->set_content_data('SHOW_PRODUCTS_QUANTITY', $coo_product->data['gm_show_qty_info']);	
		$this->set_content_data('PRODUCTS_QUANTITY', gm_prepare_number($t_quantity, $xtPrice->currencies[$xtPrice->actualCurr]['decimal_point']));
		
		$t_html_output = $this->build_html();

		return $t_html_output;
	}
}
?>