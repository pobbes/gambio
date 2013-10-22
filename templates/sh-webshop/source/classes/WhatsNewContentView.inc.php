<?php
/* --------------------------------------------------------------
   WhatsNewContentView.inc.php 2012-02-20 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(whats_new.php,v 1.31 2003/02/10); www.oscommerce.com
   (c) 2003	 nextcommerce (whats_new.php,v 1.12 2003/08/21); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: whats_new.php 1292 2005-10-07 16:10:55Z mz $)

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   Enable_Disable_Categories 1.3        	Autor: Mikel Williams | mikel@ladykatcostumes.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

require_once (DIR_FS_INC.'xtc_random_select.inc.php');
require_once (DIR_FS_INC.'xtc_rand.inc.php');
require_once (DIR_FS_INC.'xtc_get_products_name.inc.php');

class WhatsNewContentView extends ContentView
{
	function WhatsNewContentView()
	{
		$this->set_content_template('boxes/box_whatsnew.html');
		$this->set_caching_enabled(false);
	}

	function get_html($p_coo_product, $p_coo_xtc_price, $p_products_id = false)
	{
		$c_products_id = (int)$p_products_id;
		$t_html_output = '';

		//fsk18 lock
		$t_fsk_lock = '';
		if($_SESSION['customers_status']['customers_fsk18_display'] == '0')
		{
			$t_fsk_lock = ' AND p.products_fsk18 != 1';
		}

		if(GROUP_CHECK == 'true')
		{
			$t_group_check = " AND p.group_permission_".$_SESSION['customers_status']['customers_status_id']." = 1 ";
		}
		
		if (MAX_DISPLAY_NEW_PRODUCTS_DAYS != '0')
		{
			$t_date_new_products = date("Y.m.d", mktime(1, 1, 1, date(m), date(d) - MAX_DISPLAY_NEW_PRODUCTS_DAYS, date(Y)));
			$t_days = " AND p.products_date_added > '" . $t_date_new_products . "' ";
		}
		
		$t_products_sql = "SELECT DISTINCT
						p.products_id,
						pd.products_name,
						pd.gm_alt_text,
						pd.products_meta_description,
						p.products_image,
						p.products_tax_class_id,
						p.products_vpe,
						p.products_vpe_status,
						p.products_vpe_value,
						p.products_price
					FROM
						(   SELECT
								p.products_id,
								p.products_image,
								p.products_tax_class_id,
								p.products_vpe,
								p.products_vpe_status,
								p.products_vpe_value,
								p.products_price,
								p.products_status,
								p.products_date_added
							FROM " .TABLE_PRODUCTS . " p
							WHERE
								p.products_status = 1
								"  .$t_days . "
								" . $t_group_check . "
								" . $t_fsk_lock . "
							ORDER BY p.products_date_added DESC
						) AS p,
						" .TABLE_PRODUCTS_TO_CATEGORIES . " p2c,
						" . TABLE_PRODUCTS_DESCRIPTION . " pd,
						" .TABLE_CATEGORIES . " c
					WHERE
																					p.products_id = pd.products_id
						AND pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
						AND p.products_id = p2c.products_id
						AND p.products_id != '" . $c_products_id . "'
						AND c.categories_id = p2c.categories_id
						AND c.categories_status = 1
					LIMIT " . MAX_RANDOM_SELECT_NEW;

		if(version_compare(gm_get_env_info('MYSQL_VERSION'), '4.1') < 0)
		{
			$t_products_sql = "SELECT DISTINCT
							p.products_id,
							pd.products_name,
							pd.gm_alt_text,
							pd.products_meta_description,
							p.products_image,
							p.products_tax_class_id,
							p.products_vpe,
							p.products_vpe_status,
							p.products_vpe_value,
							p.products_price
						FROM
							" .TABLE_PRODUCTS . " p,
							" .TABLE_PRODUCTS_TO_CATEGORIES . " p2c,
							" . TABLE_PRODUCTS_DESCRIPTION . " pd,
							" .TABLE_CATEGORIES . " c
						WHERE
							p.products_status = 1
							AND p.products_id = pd.products_id
							AND pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
							AND p.products_id = p2c.products_id
							AND p.products_id != '" . $c_products_id . "'
							AND c.categories_id = p2c.categories_id
							" . $t_group_check . "
							" . $t_fsk_lock . "
							"  .$t_days . "
							AND c.categories_status = 1
						ORDER BY p.products_date_added DESC
						LIMIT " . MAX_RANDOM_SELECT_NEW;
		}

		if(($t_random_product_array = xtc_random_select($t_products_sql)))
		{
			$t_whats_new_price = $p_coo_xtc_price->xtcGetPrice($t_random_product_array['products_id'], $format = true, 1, $t_random_product_array['products_tax_class_id'], $t_random_product_array['products_price']);
		}

		if((isset($t_random_product_array['products_name']) && $t_random_product_array['products_name'] != '') || $_SESSION['style_edit_mode'] == 'edit')
		{
			$this->set_content_data('box_content', $p_coo_product->buildDataArray($t_random_product_array));
			$this->set_content_data('LINK_NEW_PRODUCTS', xtc_href_link(FILENAME_PRODUCTS_NEW));
			$t_html_output = $this->build_html();
		}

		return $t_html_output;
	}
}

?>