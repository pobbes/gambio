<?php
/* --------------------------------------------------------------
   ProductAttributesContentView.inc.php 2012-06-14 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(product_info.php,v 1.94 2003/05/04); www.oscommerce.com
   (c) 2003      nextcommerce (product_info.php,v 1.46 2003/08/25); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: product_attributes.php 1255 2005-09-28 15:10:36Z mz $)

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contribution:
   Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist
   New Attribute Manager v4b                            Autor: Mike G | mp3man@internetwork.net | http://downloads.ephing.com
   Cross-Sell (X-Sell) Admin 1                          Autor: Joshua Dechant (dreamscape)
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

// include needed functions
include_once(DIR_FS_CATALOG . 'gm/inc/gm_prepare_number.inc.php');

class ProductAttributesContentView extends ContentView
{
	function ProductAttributesContentView($p_template = 'default')
	{
		$filepath = DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/module/product_options/';

		// get default template
		$c_template = $this->get_default_template($filepath, $p_template);

		$this->set_content_template('module/product_options/' . $c_template);
		$this->set_flat_assigns(true);
	}
	
	function get_html($p_coo_product)
	{
		$t_html_output = '';

		$xtPrice = new xtcPrice($_SESSION['currency'], $_SESSION['customers_status']['customers_status_id']);
		$main = new main();
		
		if ($p_coo_product->getAttributesCount() > 0) {
			$products_options_name_query = xtDBquery("select distinct popt.products_options_id, popt.products_options_name from ".TABLE_PRODUCTS_OPTIONS." popt, ".TABLE_PRODUCTS_ATTRIBUTES." patrib where patrib.products_id='".$p_coo_product->data['products_id']."' and patrib.options_id = popt.products_options_id and popt.language_id = '".(int) $_SESSION['languages_id']."' order by popt.products_options_name");

			$row = 0;
			$col = 0;
			$products_options_data = array ();
			while ($products_options_name = xtc_db_fetch_array($products_options_name_query,true)) {
				$selected = 0;
				$products_options_array = array ();

				$products_options_data[$row] = array ('NAME' => $products_options_name['products_options_name'], 'ID' => $products_options_name['products_options_id'], 'DATA' => '');
				// BOF GM_MOD
				if(GM_SET_OUT_OF_STOCK_ATTRIBUTES == 'true') $gm_hide = "and pa.attributes_stock > 0";
				else $gm_hide = "";
				$products_options_query = xtDBquery("select pov.products_options_values_id,
																 pov.products_options_values_name,
																												 pov.gm_filename,
																 pa.attributes_model,
																 pa.options_values_price,
																 pa.price_prefix,
																 pa.attributes_stock,
																 pa.attributes_model
																 from ".TABLE_PRODUCTS_ATTRIBUTES." pa,
																 ".TABLE_PRODUCTS_OPTIONS_VALUES." pov
																 where pa.products_id = '".$p_coo_product->data['products_id']."'
																 and pa.options_id = '".$products_options_name['products_options_id']."'
																 and pa.options_values_id = pov.products_options_values_id
																 and pov.language_id = '".(int) $_SESSION['languages_id']."'
																 " . $gm_hide . "
																 order by pa.sortorder");
				// EOF GM_MOD
				$col = 0;
				while ($products_options = xtc_db_fetch_array($products_options_query,true)) {
					$price = '';
					// BOF GM_MOD
					if ($_SESSION['customers_status']['customers_status_show_price'] == '0'
							||(	$xtPrice->gm_check_price_status($p_coo_product->data['products_id']) > 0
									&& !($xtPrice->gm_check_price_status($p_coo_product->data['products_id']) == 2 && $xtPrice->getPprice($p_coo_product->data['products_id']) > 0)
								)
							) {
						if(!empty($products_options['gm_filename'])) $gm_attribute_image = 'images/product_images/attribute_images/' . $products_options['gm_filename'];
						$products_options_data[$row]['DATA'][$col] = array ('ID' => $products_options['products_options_values_id'],
																			'TEXT' => $products_options['products_options_values_name'],
																			'MODEL' => $products_options['attributes_model'],
																			'PRICE' => '',
																			'FULL_PRICE' => '',
																			'PREFIX' => $products_options['price_prefix'],
																			'GM_STOCK' => gm_prepare_number($products_options['attributes_stock'], ','),
																			'GM_IMAGE' => $gm_attribute_image);
						unset($gm_attribute_image);
						// EOF GM_MOD
					} else {
						$products_options['options_values_price'];
						if ($products_options['options_values_price'] != '0.00') {
							// BOF GM_MOD
							if($p_coo_product->data['products_tax_class_id'] != 0) $price = $xtPrice->xtcFormat($products_options['options_values_price'], false, $p_coo_product->data['products_tax_class_id']);
							else  $price = $xtPrice->xtcFormat($products_options['options_values_price'], false, $p_coo_product->data['products_tax_class_id'], true);
							// EOF GM_MOD
						}

						$products_price = $xtPrice->xtcGetPrice($p_coo_product->data['products_id'], $format = false, 1, $p_coo_product->data['products_tax_class_id'], $p_coo_product->data['products_price']);
						// BOF GM_MOD
						// special offer?
						$gm_check_special_offer = xtc_db_query("SELECT specials_id FROM specials WHERE products_id = '".$p_coo_product->data['products_id']."' AND status = '1'");
						if(xtc_db_num_rows($gm_check_special_offer) == 0){
							if ($_SESSION['customers_status']['customers_status_discount_attributes'] == 1){
								if($products_options['price_prefix'] == '+') $price -= $price / 100 * $discount;
								elseif($products_options['price_prefix'] == '-') $price += $price / 100 * $discount;
							}
						}
						// EOF GM_MOD

						$attr_price=$price;
						if ($products_options['price_prefix']=="-") $attr_price=$price*(-1);
						$full = $products_price + $attr_price;
						// BOF GM_MOD
						if(!empty($products_options['gm_filename'])) $gm_attribute_image = 'images/product_images/attribute_images/' . $products_options['gm_filename'];
						$price;
						$products_options_data[$row]['DATA'][$col] = array ('ID' => $products_options['products_options_values_id'],
																			'TEXT' => $products_options['products_options_values_name'],
																			'MODEL' => $products_options['attributes_model'],
																			'PRICE' => $xtPrice->xtcFormat($price, true),
																			'FULL_PRICE' => $xtPrice->xtcFormat($full, true),
																			'PREFIX' => $products_options['price_prefix'],
																			'GM_STOCK' => gm_prepare_number($products_options['attributes_stock'], ','),
																			'GM_IMAGE' => $gm_attribute_image);
						unset($gm_attribute_image);
						// EOF GM_MOD

						//if PRICE for option is 0 we don't need to display it
						if ($price == 0) {
							unset ($products_options_data[$row]['DATA'][$col]['PRICE']);
							unset ($products_options_data[$row]['DATA'][$col]['PREFIX']);
						}
					}
					$col ++;
				}
				$row ++;
			}
		}

		$this->set_content_data('PRODUCTS_ID', $p_coo_product->data['products_id']);

		// BOF GM_MOD
		$this->set_content_data('GM_HIDE_OUT_OF_STOCK', GM_SET_OUT_OF_STOCK_ATTRIBUTES);
		$this->set_content_data('GM_SHOW_STOCK', GM_SET_OUT_OF_STOCK_ATTRIBUTES_SHOW);
		$this->set_content_data('GM_STOCK_TEXT_BEFORE', GM_ATTR_STOCK_TEXT_BEFORE);
		$this->set_content_data('GM_STOCK_TEXT_AFTER', GM_ATTR_STOCK_TEXT_AFTER);
		// EOF GM_MOD

		$this->set_content_data('options', $products_options_data);

		$mb_no_attributes = true;
		for($i = 0; $i < count($products_options_data); $i++){
			if(!empty($products_options_data[$i]['DATA'])) $mb_no_attributes = false;
		}
		if(!empty($products_options_data) && !$mb_no_attributes)
		{
			$t_html_output = $this->build_html();
		}

		return $t_html_output;
	}
	
}
?>