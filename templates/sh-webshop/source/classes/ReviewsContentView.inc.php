<?php
/* --------------------------------------------------------------
   ReviewsContentView.inc.php 2010-09-22 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(reviews.php,v 1.36 2003/02/12); www.oscommerce.com
   (c) 2003	 nextcommerce (reviews.php,v 1.9 2003/08/17 22:40:08); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: reviews.php 1262 2005-09-30 10:00:32Z mz $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

// include needed functions
require_once(DIR_FS_INC . 'xtc_random_select.inc.php');
require_once(DIR_FS_INC . 'xtc_break_string.inc.php');

class ReviewsContentView extends ContentView
{
	function ReviewsContentView()
	{
		$this->set_content_template('boxes/box_reviews.html');
	}

	function get_html($p_coo_product)
	{
		$t_html_output = '';

		//fsk18 lock
		$t_fsk_lock = '';
		if($_SESSION['customers_status']['customers_fsk18_display'] == '0')
		{
			$t_fsk_lock = ' AND p.products_fsk18 != 1';
		}
		$t_sql = "SELECT 
						r.reviews_id, 
						r.reviews_rating, 
						p.products_id, 
						p.products_image, 
						pd.products_name 
					FROM 
						" . TABLE_REVIEWS . " r, 
						" . TABLE_REVIEWS_DESCRIPTION . " rd, 
						" . TABLE_PRODUCTS . " p, 
						" . TABLE_PRODUCTS_DESCRIPTION . " pd 
					WHERE
						p.products_status = '1' AND 
						p.products_id = r.products_id 
						" . $t_fsk_lock . " AND 
						r.reviews_id = rd.reviews_id AND
						rd.languages_id = '" . (int)$_SESSION['languages_id'] . "' AND
						p.products_id = pd.products_id AND
						pd.language_id = '" . (int)$_SESSION['languages_id'] . "'";
		if($p_coo_product->isProduct())
		{
			$t_sql .= " AND p.products_id = '" . $p_coo_product->data['products_id'] . "'";
		}
		$t_sql .= " ORDER BY r.reviews_id DESC LIMIT " . MAX_RANDOM_SELECT_REVIEWS;
		$t_result = xtc_random_select($t_sql);

		if($t_result) 
		{
			
			// display random review box
			$t_sql2 = "SELECT reviews_text 
						FROM " . TABLE_REVIEWS_DESCRIPTION . " 
						WHERE 
							reviews_id = '" . $t_result['reviews_id'] . "' AND 
							languages_id = '" . $_SESSION['languages_id'] . "'";
			$t_sql2 = xtDBquery($t_sql2);
			$t_result2 = xtc_db_fetch_array($t_sql2, true);

			$t_result2 = strip_tags($t_result2['reviews_text']);

			$t_content = '<div align="center">
				<a href="' . xtc_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id=' . $t_result['products_id'] . '&amp;reviews_id=' . $t_result['reviews_id']) . '">' . xtc_image(DIR_WS_THUMBNAIL_IMAGES . $t_result['products_image'], $t_result['products_name']) . '</a></div><a href="' . xtc_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id=' . $t_result['products_id'] . '&amp;reviews_id=' . $t_result['reviews_id']) . '">' . $t_result2 . ' ..</a><br /><div align="center">' . xtc_image('templates/' . CURRENT_TEMPLATE . '/images/stars_' . $t_result['reviews_rating'] . '.gif' , sprintf(BOX_REVIEWS_TEXT_OF_5_STARS, $t_result['reviews_rating'])) . '</div>';
		
			$this->set_content_data('WRITE', '', 1);
		}
		elseif($p_coo_product->isProduct()){
			// display 'write a review' box
			$t_content = '<a href="' . xtc_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, xtc_product_link($p_coo_product->data['products_id'],$p_coo_product->data['products_name'])) . '">' . xtc_image('templates/' . CURRENT_TEMPLATE . '/images/box_write_review.gif', IMAGE_BUTTON_WRITE_REVIEW) . '</a><br />
						<a href="' . xtc_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, xtc_product_link($p_coo_product->data['products_id'],$p_coo_product->data['products_name'])) . '">' . BOX_REVIEWS_WRITE_REVIEW .'</a>';

			$this->set_content_data('WRITE_IMG', 'images/box_write_review.gif');
			$this->set_content_data('WRITE_IMG_ALT', IMAGE_BUTTON_WRITE_REVIEW);
			$this->set_content_data('WRITE_URL', xtc_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, xtc_product_link($p_coo_product->data['products_id'],$p_coo_product->data['products_name'])));
			$this->set_content_data('WRITE_LINK_TEXT', BOX_REVIEWS_WRITE_REVIEW);

			$this->set_content_data('WRITE', $t_content, 1);
		}

		if($t_content != '' || $_SESSION['style_edit_mode'] == 'edit')
		{
			if(!isset($t_result['reviews_rating']))
			{
				$t_result['reviews_rating'] = 0;
			}

			$this->set_content_data('REVIEWS_LINK', xtc_href_link(FILENAME_REVIEWS));
			$this->set_content_data('REVIEW_LINK', xtc_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id=' . $t_result['products_id'] . '&amp;reviews_id=' . $t_result['reviews_id']));
			$this->set_content_data('IMAGE', xtc_image(DIR_WS_THUMBNAIL_IMAGES . $t_result['products_image'], $t_result['products_name']));
			$this->set_content_data('TEXT', $t_result2);
			$this->set_content_data('STARS', xtc_image('templates/' . CURRENT_TEMPLATE . '/images/stars_' . $t_result['reviews_rating'] . '.gif' , sprintf(BOX_REVIEWS_TEXT_OF_5_STARS, $t_result['reviews_rating'])));

			$t_html_output = $this->build_html();
		}

		return $t_html_output;
	}
}

?>