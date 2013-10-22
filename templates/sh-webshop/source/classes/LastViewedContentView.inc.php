<?php
/* --------------------------------------------------------------
   LastViewedContentView.inc.php 2010-09-24 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: last_viewed.php 1292 2005-10-07 16:10:55Z mz $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

// include needed functions
require_once(DIR_FS_INC . 'xtc_rand.inc.php');
require_once(DIR_FS_INC . 'xtc_get_path.inc.php');
require_once(DIR_FS_INC . 'xtc_get_products_name.inc.php');

class LastViewedContentView extends ContentView
{
	function LastViewedContentView()
	{
		$this->set_content_template('boxes/box_last_viewed.html');
		$this->set_caching_enabled(false);
	}

	function get_html($p_coo_product, $p_coo_xtcprice)
	{
		$t_html_output = '';

		if(isset ($_SESSION[tracking][products_history][0]) || $_SESSION['style_edit_mode'] == 'edit')
		{
			$t_max = count($_SESSION[tracking][products_history]);
			$t_max--;
			$t_random_last_viewed = xtc_rand(0, $t_max);

			//fsk18 lock
			$t_fsk_lock='';
			if($_SESSION['customers_status']['customers_fsk18_display'] == '0')
			{
				$t_fsk_lock=' AND p.products_fsk18!=1';
			}
			if(GROUP_CHECK == 'true')
			{
				$t_group_check=" AND p.group_permission_".$_SESSION['customers_status']['customers_status_id']." = 1 ";

			}

			$t_sql = "SELECT p.products_id,
							pd.products_name,
							pd.gm_alt_text,
							pd.products_meta_description,
							p.products_price,
							p.products_tax_class_id,
							p.products_image,
							p2c.categories_id,
							p.products_vpe,
							p.products_vpe_status,
							p.products_vpe_value,
							cd.categories_name
						FROM
							" . TABLE_PRODUCTS . " p,
							" . TABLE_PRODUCTS_DESCRIPTION . " pd,
							" . TABLE_PRODUCTS_TO_CATEGORIES . " p2c,
							" . TABLE_CATEGORIES_DESCRIPTION . " cd
						WHERE
							p.products_status = '1'
							AND p.products_id = '".(int)$_SESSION[tracking][products_history][$t_random_last_viewed]."'
							AND pd.products_id = '".(int)$_SESSION[tracking][products_history][$t_random_last_viewed]."'
							AND p2c.products_id = '".(int)$_SESSION[tracking][products_history][$t_random_last_viewed]."'
							AND pd.language_id = '" . $_SESSION['languages_id'] . "'
							AND cd.categories_id = p2c.categories_id
							".$t_group_check."
							".$t_fsk_lock."
							AND cd.language_id = '" . $_SESSION['languages_id'] . "'";

			$t_result = xtDBquery($t_sql);
			$t_random_product_array = xtc_db_fetch_array($t_result,true);

			$t_random_product_arrays_price = $p_coo_xtcprice->xtcGetPrice($t_random_product_array['products_id'], $format = true, 1, $t_random_product_array['products_tax_class_id'], $t_random_product_array['products_price']);

			$t_category_path = xtc_get_path($t_random_product_array['categories_id']);

			if($t_random_product_array['products_name'] != '' || $_SESSION['style_edit_mode'] == 'edit')
			{
				$this->set_content_data('box_content', $p_coo_product->buildDataArray($t_random_product_array));
				$this->set_content_data('MY_PAGE', 'TEXT_MY_PAGE');
				$this->set_content_data('WATCH_CATGORY', 'TEXT_WATCH_CATEGORY');
				$this->set_content_data('MY_PERSONAL_PAGE', xtc_href_link(FILENAME_ACCOUNT));
				$this->set_content_data('CATEGORY_LINK', xtc_href_link(FILENAME_DEFAULT, xtc_category_link($t_random_product_array['categories_id'], $t_random_product_array['categories_name'])));
				$this->set_content_data('CATEGORY_NAME', $t_random_product_array['categories_name']);

				$t_html_output = $this->build_html();
			}
		}
		
		return $t_html_output;
	}
}

?>