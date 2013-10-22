<?php
/* --------------------------------------------------------------
   ProductReviewsContentView.inc.php 2010-09-28 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(product_reviews.php,v 1.47 2003/02/13); www.oscommerce.com
   (c) 2003	 nextcommerce (product_reviews.php,v 1.12 2003/08/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: product_reviews.php 1243 2005-09-25 09:33:02Z mz $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

// include needed functions
require_once (DIR_FS_INC.'xtc_row_number_format.inc.php');
require_once (DIR_FS_INC.'xtc_date_short.inc.php');

class ProductReviewsContentView extends ContentView
{
	function ProductReviewsContentView()
	{
		$this->set_content_template('module/products_reviews.html');
		$this->set_flat_assigns(true);
	}
	
	function get_html($p_coo_product)
	{
		$t_html_output = '';

		if($p_coo_product->getReviewsCount() > 0)
		{
			$this->set_content_data('BUTTON_WRITE', '<a href="'.xtc_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, xtc_product_link($p_coo_product->data['products_id'],$p_coo_product->data['products_name'])).'">'.xtc_image_button('button_write_review.gif', IMAGE_BUTTON_WRITE_REVIEW).'</a>');
			$this->set_content_data('BUTTON_LINK', xtc_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, xtc_product_link($p_coo_product->data['products_id'],$p_coo_product->data['products_name'])));
			$this->set_content_data('module_content', $p_coo_product->getReviews(PRODUCT_REVIEWS_VIEW));

			$t_html_output = $this->build_html();
		}

		return $t_html_output;
	}
}

?>