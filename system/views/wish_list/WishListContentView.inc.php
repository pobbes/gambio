<?php
/* --------------------------------------------------------------
   WishListContentView.inc.php 2012-06-26 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(best_sellers.php,v 1.20 2003/02/10); www.oscommerce.com 
   (c) 2003	 nextcommerce (best_sellers.php,v 1.10 2003/08/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: best_sellers.php 1292 2005-10-07 16:10:55Z mz $)

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   Enable_Disable_Categories 1.3        	Autor: Mikel Williams | mikel@ladykatcostumes.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

// include needed functions
require_once (DIR_FS_INC.'xtc_array_to_string.inc.php');
require_once (DIR_FS_INC.'xtc_image_submit.inc.php');
require_once (DIR_FS_INC.'xtc_recalculate_price.inc.php');


class WishListContentView extends ContentView
{
	function WishListContentView()
	{
		$this->set_content_template('module/wish_list.html');
		$this->set_flat_assigns(true);
	}
	
	function get_html()
	{
		if($_SESSION['wishList']->count_contents() > 0)
		{
			$this->set_content_data('FORM_ACTION', xtc_draw_form('cart_quantity', xtc_href_link('wish_list.php', 'action=update_product', 'NONSSL', true, true, true),'post', 'name="cart_quantity"'));
			$this->set_content_data('FORM_END', '</form>');
			$hidden_options='';
			$_SESSION['any_out_of_stock']=0;

			$products = $_SESSION['wishList']->get_products();
			for($i = 0; $i < count($products); $i++)
			{
				// Push all attributes information in an array
				if(isset($products[$i]['attributes']))
				{
					while(list($option, $value) = each($products[$i]['attributes']))
					{
						$hidden_options.= xtc_draw_hidden_field('id[' . $products[$i]['id'] . '][' . $option . ']', $value);
						$attributes = xtc_db_query("select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix,pa.attributes_stock,pa.products_attributes_id,pa.attributes_model
													  from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa
													  where pa.products_id = '" . (int)$products[$i]['id'] . "'
													   and pa.options_id = '" . (int)$option . "'
													   and pa.options_id = popt.products_options_id
													   and pa.options_values_id = '" . (int)$value . "'
													   and pa.options_values_id = poval.products_options_values_id
													   and popt.language_id = '" . (int)$_SESSION['languages_id'] . "'
													   and poval.language_id = '" . (int)$_SESSION['languages_id'] . "'");
						$attributes_values = xtc_db_fetch_array($attributes);

						$products[$i][$option]['products_options_name'] = $attributes_values['products_options_name'];
						$products[$i][$option]['options_values_id'] = $value;
						$products[$i][$option]['products_options_values_name'] = $attributes_values['products_options_values_name'];
						$products[$i][$option]['options_values_price'] = $attributes_values['options_values_price'];
						$products[$i][$option]['price_prefix'] = $attributes_values['price_prefix'];
						$products[$i][$option]['weight_prefix'] = $attributes_values['weight_prefix'];
						$products[$i][$option]['options_values_weight'] = $attributes_values['options_values_weight'];
						$products[$i][$option]['attributes_stock'] = $attributes_values['attributes_stock'];
						$products[$i][$option]['products_attributes_id'] = $attributes_values['products_attributes_id'];
						$products[$i][$option]['products_attributes_model'] = $attributes_values['products_attributes_model'];
					}
				}
			}

			$this->set_content_data('HIDDEN_OPTIONS', $hidden_options);

			# order details
			$coo_order_details_wish_list = MainFactory::create_object('OrderDetailsWishListContentView');
			$t_view_html = $coo_order_details_wish_list->get_html($products);
			$this->set_content_data('MODULE_order_details', $t_view_html);

			if(STOCK_CHECK == 'true')
			{
				if ($_SESSION['any_out_of_stock']== 1)
				{
					if (STOCK_ALLOW_CHECKOUT == 'true')
					{
						// write permission in session
						$_SESSION['allow_checkout'] = 'true';
						$this->set_content_data('info_message', OUT_OF_STOCK_CAN_CHECKOUT);
					}
					else
					{
						$_SESSION['allow_checkout'] = 'false';
						$this->set_content_data('info_message', OUT_OF_STOCK_CANT_CHECKOUT);
					}
				}
				else
				{
					$_SESSION['allow_checkout'] = 'true';
				}
			}


			if ($_GET['info_message'])
			{
				$this->set_content_data('info_message',str_replace('+', ' ', htmlentities_wrapper($_GET['info_message'])));
			}
			// BOF GM_MOD GX-Customizer:
			$this->set_content_data('BUTTON_RELOAD', '<a id="gm_update_wishlist" href="JavaScript:submit_to_wishlist()">'.xtc_image_button('button_delete.gif', NC_WISHLIST).'</a>');
			$this->set_content_data('BUTTON_CART', '<a id="gm_wishlist_to_cart" href="JavaScript:submit_wishlist_to_cart()">'.xtc_image_button('button_buy_now.gif', IMAGE_BUTTON_CHECKOUT).'</a>');
			// EOF GM_MOD GX-Customizer
			$this->set_content_data('BUTTON_UPDATE', '<a href="JavaScript:update_wishlist()">'.xtc_image_button('button_update_cart.gif', NC_WISHLIST).'</a>');
			$this->set_content_data('BUTTON_CHECKOUT', '<a href="'.xtc_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL').'">'.xtc_image_button('button_checkout.gif', IMAGE_BUTTON_CHECKOUT).'</a>');

		}
		else
		{
			// empty cart
			$cart_empty=true;
			if ($_GET['info_message'])
			{
				$this->set_content_data('info_message', str_replace('+',' ',htmlentities_wrapper($_GET['info_message'])));
			}
			$this->set_content_data('cart_empty', $cart_empty);
			$this->set_content_data('BUTTON_CONTINUE', '<a href="'.xtc_href_link(FILENAME_DEFAULT).'">'. xtc_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE).'</a>');
		}

		$this->set_content_data('BUTTON_BACK_URL', $_SESSION['gm_history'][count($_SESSION['gm_history'])-1]['CLOSE']);
		
		$t_html_output = $this->build_html();

		return $t_html_output;
	}	
}
?>