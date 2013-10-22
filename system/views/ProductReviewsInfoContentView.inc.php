<?php
/* --------------------------------------------------------------
   ProductReviewsContentView.inc.php 2010-10-25 gambio
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
require_once (DIR_FS_INC.'xtc_break_string.inc.php');
require_once (DIR_FS_INC.'xtc_date_long.inc.php');

class ProductReviewsInfoContentView extends ContentView
{
	function ProductReviewsInfoContentView()
	{
		$this->set_content_template('module/products_reviews_info.html');
		$this->set_flat_assigns(true);
	}
	
	function get_html($p_coo_product)
	{
		$t_html_output = '';

		$reviews_query = "SELECT
								rd.reviews_text,
								r.reviews_rating,
								r.reviews_id,
								r.products_id,
								r.customers_name,
								r.date_added,
								r.last_modified,
								r.reviews_read,
								p.products_id,
								pd.products_name,
								p.products_image
							FROM
								".TABLE_REVIEWS." r
								LEFT JOIN " . TABLE_PRODUCTS . " p ON (r.products_id = p.products_id)
								LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " pd
										ON (p.products_id = pd.products_id AND
											pd.language_id = '" . (int) $_SESSION['languages_id'] . "'),
								" . TABLE_REVIEWS_DESCRIPTION . " rd
							WHERE
								r.reviews_id = '" . (int)$_GET['reviews_id'] . "' AND
								r.reviews_id = rd.reviews_id AND
								p.products_status = '1'";
$reviews_query = xtc_db_query($reviews_query);

if (!xtc_db_num_rows($reviews_query))
	xtc_redirect(xtc_href_link(FILENAME_REVIEWS));
$reviews = xtc_db_fetch_array($reviews_query);

xtc_db_query("update ".TABLE_REVIEWS." set reviews_read = reviews_read+1 where reviews_id = '".$reviews['reviews_id']."'");

$reviews_text = xtc_break_string(htmlspecialchars_wrapper($reviews['reviews_text']), 60, '-<br />');


$smarty->assign('PRODUCTS_NAME', $reviews['products_name']);
$smarty->assign('AUTHOR', $reviews['customers_name']);
$smarty->assign('DATE', xtc_date_long($reviews['date_added']));
$smarty->assign('REVIEWS_TEXT', nl2br($reviews_text));
$smarty->assign('RATING', xtc_image('templates/'.CURRENT_TEMPLATE.'/img/stars_'.$reviews['reviews_rating'].'.gif', sprintf(TEXT_OF_5_STARS, $reviews['reviews_rating'])));
/* bof gm seo */
if($gmSEOBoost->boost_products) {
	$gm_seo_product_link = xtc_href_link($gmSEOBoost->get_boosted_product_url($reviews['products_id'], $reviews['products_name']) );
} else {
	$gm_seo_product_link = xtc_href_link(FILENAME_PRODUCT_INFO, xtc_product_link($reviews['products_id'], $reviews['products_name']));
}
/* eof gm seo */
$smarty->assign('PRODUCTS_LINK', $gm_seo_product_link);
$smarty->assign('BUTTON_BACK', '<a href="'.xtc_href_link(FILENAME_PRODUCT_REVIEWS, $get_params).'">'.xtc_image_button('button_back.gif', IMAGE_BUTTON_BACK).'</a>');
$smarty->assign('BUTTON_BUY_NOW', '<a href="'.xtc_href_link(FILENAME_DEFAULT, 'action=buy_now&BUYproducts_id='.$reviews['products_id']).'">'.xtc_image_button('button_in_cart.gif', IMAGE_BUTTON_IN_CART).'</a>');
$smarty->assign('IMAGE', xtc_image(DIR_WS_THUMBNAIL_IMAGES.$reviews['products_image'], $reviews['products_name'], '', '', 'hspace="5" vspace="5"'));



		return $t_html_output;
	}
}

?>