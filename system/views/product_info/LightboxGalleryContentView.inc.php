<?php
/* --------------------------------------------------------------
   LightboxGalleryContentView.inc.php 2010-11-26 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/
?><?php

require_once (DIR_FS_INC.'xtc_get_products_mo_images.inc.php');

class LightboxGalleryContentView extends ContentView
{
	function LightboxGalleryContentView()
	{
		$this->set_content_template('module/lightbox_gallery.html');
	}
	
	function get_html($p_products_id, $p_image_nr = 0)
	{
		$coo_product = new product($p_products_id);

		$t_images_array = array();

		$t_image_max_width = PRODUCT_IMAGE_POPUP_WIDTH;
		$t_image_max_height = PRODUCT_IMAGE_POPUP_HEIGHT;
		$t_thumbnail_max_width = 86;
		$t_thumbnail_max_height = 86;

		if($coo_product->data['products_image'] != '') {
			$t_image_url = DIR_WS_POPUP_IMAGES . $coo_product->data['products_image'];

			$t_info_image_size_array = @getimagesize(DIR_WS_POPUP_IMAGES . $coo_product->data['products_image']);

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

			$t_info_thumbnail_size_array = @getimagesize(DIR_WS_IMAGES . 'product_images/gallery_images/' . $coo_product->data['products_image']);

			$t_thumbnail_padding_left = 0;
			$t_thumbnail_padding_top = 0;

			if(isset($t_info_thumbnail_size_array[0]) && $t_info_thumbnail_size_array[0] < $t_thumbnail_max_width)
			{
				$t_thumbnail_padding_left = round(($t_thumbnail_max_width - $t_info_thumbnail_size_array[0]) / 2);
			}

			if(isset($t_info_thumbnail_size_array[1]) && $t_info_thumbnail_size_array[1] < $t_thumbnail_max_height)
			{
				$t_thumbnail_padding_top = round(($t_thumbnail_max_height - $t_info_thumbnail_size_array[1]) / 2);
			}

			$t_images_array[] = array('IMAGE' => DIR_WS_POPUP_IMAGES . $coo_product->data['products_image'],
										'THUMBNAIL' => DIR_WS_IMAGES . 'product_images/gallery_images/' . $coo_product->data['products_image'],
										'IMAGE_NR' => 0,
										'PRODUCTS_NAME' => $coo_product->data['products_name'],
										'PADDING_LEFT' => $t_padding_left,
										'PADDING_TOP' => $t_padding_top,
										'THUMBNAIL_PADDING_LEFT' => $t_thumbnail_padding_left,
										'THUMBNAIL_PADDING_TOP' => $t_thumbnail_padding_top);
		}

		$t_more_images = xtc_get_products_mo_images($coo_product->data['products_id']);

		if($t_more_images != false)
		{
			$coo_alt_text = MainFactory::create_object('GMAltText');

			foreach($t_more_images as $t_image_array)
			{
				$t_image_url = DIR_WS_POPUP_IMAGES . $t_image_array['image_name'];

				$t_info_image_size_array = @getimagesize(DIR_WS_POPUP_IMAGES . $t_image_array['image_name']);

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

				$t_info_thumbnail_size_array = @getimagesize(DIR_WS_IMAGES . 'product_images/gallery_images/' . $t_image_array['image_name']);

				$t_thumbnail_padding_left = 0;
				$t_thumbnail_padding_top = 0;

				if(isset($t_info_thumbnail_size_array[0]) && $t_info_thumbnail_size_array[0] < $t_thumbnail_max_width)
				{
					$t_thumbnail_padding_left = round(($t_thumbnail_max_width - $t_info_thumbnail_size_array[0]) / 2);
				}

				if(isset($t_info_thumbnail_size_array[1]) && $t_info_thumbnail_size_array[1] < $t_thumbnail_max_height)
				{
					$t_thumbnail_padding_top = round(($t_thumbnail_max_height - $t_info_thumbnail_size_array[1]) / 2);
				}

				$t_images_array[] = array('IMAGE' => DIR_WS_POPUP_IMAGES . $t_image_array['image_name'],
											'THUMBNAIL' => DIR_WS_IMAGES . 'product_images/gallery_images/' . $t_image_array['image_name'],
											'IMAGE_NR' => $t_image_array['image_nr'],
											'PRODUCTS_NAME' => $coo_product->data['products_name'],
											'PADDING_LEFT' => $t_padding_left,
											'PADDING_TOP' => $t_padding_top,
											'THUMBNAIL_PADDING_LEFT' => $t_thumbnail_padding_left,
											'THUMBNAIL_PADDING_TOP' => $t_thumbnail_padding_top);
			}
		}

		$this->set_content_data('images_data', $t_images_array);

		$this->set_content_data('IMAGE_MAX_WIDTH', PRODUCT_IMAGE_POPUP_WIDTH);
		$this->set_content_data('IMAGE_MAX_HEIGHT', PRODUCT_IMAGE_POPUP_HEIGHT);

		$t_gallery_width = (int)PRODUCT_IMAGE_POPUP_WIDTH + 200;
		$this->set_content_data('GALLERY_WIDTH', $t_gallery_width);

		$t_html_output = $this->build_html();

		return $t_html_output;
	}
}

?>