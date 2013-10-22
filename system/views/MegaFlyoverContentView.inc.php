<?php
/* --------------------------------------------------------------
   MegaFlyoverContentView.php 2010-11-25 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(create_account.php,v 1.63 2003/05/28); www.oscommerce.com
   (c) 2003  nextcommerce (create_account.php,v 1.27 2003/08/24); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: create_account.php 1311 2005-10-18 12:30:40Z mz $)

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contribution:

   Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
   http://www.oscommerce.com/community/contributions,282
   Copyright (c) Strider | Strider@oscworks.com
   Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
   Copyright (c) Andre ambidex@gmx.net
   Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org


   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

require_once (DIR_FS_INC.'xtc_get_vpe_name.inc.php');
require_once (DIR_FS_INC.'xtc_get_products_mo_images.inc.php');

class MegaFlyoverContentView extends ContentView
{
	function MegaFlyoverContentView()
	{
		$this->set_content_template('module/gm_mega_flyover.html');
		$this->set_flat_assigns(true);
	}
	
	function get_html($p_get_array, $p_post_array)
	{
		$xtPrice = new xtcPrice($_SESSION['currency'], $_SESSION['customers_status']['customers_status_id']);
		$main = new main();

		$t_html_output = '';

		$t_products_id = gm_prepare_string($p_get_array['mf_products_id']);
		if(isset($p_post_array['mf_products_id'])) $t_products_id = gm_prepare_string($p_post_array['mf_products_id']);

		if($t_products_id != '')
		{
			if($t_products_id == '0') {
				$result = xtc_db_query('
					SELECT products_id
					FROM 	products
					WHERE products_status = 1
					ORDER BY products_id DESC
					LIMIT 0,1
				');
				$data = xtc_db_fetch_array($result);
				$t_products_id = $data['products_id'];
			}
			$coo_product = new product($t_products_id);

			$this->set_content_data('PRODUCTS_NAME', $coo_product->data['products_name']);
			$this->set_content_data('PRODUCTS_SHORT_DESCRIPTION', stripslashes($coo_product->data['products_short_description']));

			$products_price = $xtPrice->xtcGetPrice($coo_product->data['products_id'], $format = true, 1, $coo_product->data['products_tax_class_id'], $coo_product->data['products_price'], 1);
			$this->set_content_data('PRODUCTS_PRICE', $products_price['formated']);

			$t_gm_images_data = array();

			$t_image_max_width = PRODUCT_IMAGE_INFO_WIDTH;
			$t_image_max_height = PRODUCT_IMAGE_INFO_HEIGHT;

			$this->set_content_data('BOX_WIDTH', $t_image_max_width);
			$this->set_content_data('BOX_HEIGHT', $t_image_max_height);

			$image = '';
			if($coo_product->data['products_image'] != '') {
				$image = DIR_WS_INFO_IMAGES.$coo_product->data['products_image'];

				$t_info_image_size_array = @getimagesize(DIR_WS_INFO_IMAGES . $coo_product->data['products_image']);

				$t_padding_left = 0;
				$t_padding_top = 0;

				if(isset($t_info_image_size_array[0]) && $t_info_image_size_array[0] < $t_image_max_width)
				{
					$t_padding_left = round(($t_image_max_width - $t_info_image_size_array[0]) / 2);
				}

				if(isset($t_info_image_size_array[1]) && $t_info_image_size_array[1] < $t_image_max_height)
				{
					$t_padding_top = round(($t_image_max_height - $t_info_image_size_array[1]) / 2);
				}

				$t_gm_images_data[] = array('IMAGE' => DIR_WS_INFO_IMAGES . $coo_product->data['products_image'],
												'IMAGE_NR' => 0,
												'PRODUCTS_NAME' => $coo_product->data['products_name'],
												'PADDING_LEFT' => $t_padding_left,
												'PADDING_TOP' => $t_padding_top);
			}
			$this->set_content_data('gm_image_width', $coo_product->data['products_image_w'] + 20);
			$this->set_content_data('PRODUCTS_IMAGE', $image);

			$t_gm_images = xtc_get_products_mo_images($coo_product->data['products_id']);

			if($t_gm_images != false)
			{
				foreach($t_gm_images as $t_gm_image)
				{
					$t_info_image_size_array = @getimagesize(DIR_WS_INFO_IMAGES . $t_gm_image['image_name']);

					$t_padding_left = 0;
					$t_padding_top = 0;

					if(isset($t_info_image_size_array[0]) && $t_info_image_size_array[0] < $t_image_max_width)
					{
						$t_padding_left = round(($t_image_max_width - $t_info_image_size_array[0]) / 2);
					}

					if(isset($t_info_image_size_array[1]) && $t_info_image_size_array[1] < $t_image_max_height)
					{
						$t_padding_top = round(($t_image_max_height - $t_info_image_size_array[1]) / 2);
					}

					$t_gm_images_data[] = array('IMAGE' => DIR_WS_INFO_IMAGES . $t_gm_image['image_name'],
												'IMAGE_NR' => $t_gm_image['image_nr'],
												'PRODUCTS_NAME' => $coo_product->data['products_name'],
												'PADDING_LEFT' => $t_padding_left,
												'PADDING_TOP' => $t_padding_top
											);
				}
			}

			$this->set_content_data('images_data', $t_gm_images_data);

			if ($coo_product->data['products_fsk18'] == '1') {
				$this->set_content_data('PRODUCTS_FSK18', 'true');
			}
			if (ACTIVATE_SHIPPING_STATUS == 'true') {
				$this->set_content_data('SHIPPING_NAME', $main->getShippingStatusName($coo_product->data['products_shippingtime']));
				$this->set_content_data('SHIPPING_IMAGE', $main->getShippingStatusImage($coo_product->data['products_shippingtime']));
			}

			if ($coo_product->data['products_vpe_status'] == 1 && $coo_product->data['products_vpe_value'] != 0.0 && $products_price['plain'] > 0) {
				$this->set_content_data('PRODUCTS_VPE', $xtPrice->xtcFormat($products_price['plain'] * (1 / $coo_product->data['products_vpe_value']), true).TXT_PER.xtc_get_vpe_name($coo_product->data['products_vpe']));
			}
			$this->set_content_data('PRODUCTS_ID', $coo_product->data['products_id']);
			$this->set_content_data('PRODUCTS_NAME', $coo_product->data['products_name']);

			if ($_SESSION['customers_status']['customers_status_show_price'] != 0) {
				// price incl tax
				$tax_rate = $xtPrice->TAX[$coo_product->data['products_tax_class_id']];
				$tax_info = $main->getTaxInfo($tax_rate);
				$this->set_content_data('PRODUCTS_TAX_INFO', $tax_info);
				$this->set_content_data('PRODUCTS_SHIPPING_LINK', $main->getShippingLink(true));
			}

			$this->set_content_data('GM_TRUNCATE', gm_get_conf('TRUNCATE_FLYOVER'));
			$this->set_content_data('GM_TRUNCATE_TEXT', gm_get_conf('TRUNCATE_FLYOVER_TEXT'));

			$t_html_output = $this->build_html();
		}
		

		return $t_html_output;
	}
}
?>