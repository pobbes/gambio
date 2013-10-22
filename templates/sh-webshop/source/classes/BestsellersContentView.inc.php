<?php
/* --------------------------------------------------------------
   BestsellersContentView.inc.php 2010-09-20 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
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
require_once (DIR_FS_INC.'xtc_row_number_format.inc.php');


class BestsellersContentView extends ContentView
{
	function BestsellersContentView() 
	{
		$this->set_content_template('boxes/box_best_sellers.html');
		$this->set_caching_enabled(true);
	}
	
	function get_html($p_current_category_id)
	{
		$this->add_cache_id_elements(array(
										$p_current_category_id,
										$_SESSION['customers_status']['customers_fsk18_display']
									));

		if($this->is_cached() == false)
		{
			if(is_object($GLOBALS['coo_debugger'])) $GLOBALS['coo_debugger']->log('BestsellersContentView get_html NO_CACHE', 'SmartyCache');

			$t_content_array = array();

			$t_fsk_lock_part = '';
			if($_SESSION['customers_status']['customers_fsk18_display'] == '0') {
				$t_fsk_lock_part = ' and p.products_fsk18!=1';
			}

			$t_group_check_part = '';
			if(GROUP_CHECK == 'true') {
				$t_group_check_part = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
			}

			if(isset($p_current_category_id) && ($p_current_category_id > 0)) {
				$t_sql = "
					select distinct
						p.products_id,
						p.products_price,
						p.products_tax_class_id,
						p.products_image,
						p.products_vpe,
						p.products_vpe_status,
						p.products_vpe_value,
						pd.products_name,
						pd.products_meta_description
					from
						".TABLE_PRODUCTS." p,
						".TABLE_PRODUCTS_DESCRIPTION." pd,
						".TABLE_PRODUCTS_TO_CATEGORIES." p2c,
						".TABLE_CATEGORIES." c
					where p.products_status = '1'
						and c.categories_status = '1'
						and p.products_ordered > 0
						and p.products_id = pd.products_id
						and pd.language_id = '".(int) $_SESSION['languages_id']."'
						and p.products_id = p2c.products_id
						".$t_fsk_lock_part."
						".$t_group_check_part."
						and p2c.categories_id = c.categories_id and '".(int)$p_current_category_id."'
						in (c.categories_id, c.parent_id)
					order by
						p.products_ordered desc limit ".MAX_DISPLAY_BESTSELLERS
				;
			} else {
				$t_sql = "
					select distinct
						p.products_id,
						p.products_image,
						p.products_price,
						p.products_vpe,
						p.products_vpe_status,
						p.products_vpe_value,
						p.products_tax_class_id,
						pd.products_name,
						pd.products_meta_description
					from
						".TABLE_PRODUCTS." p,
						".TABLE_PRODUCTS_DESCRIPTION." pd
					where p.products_status = '1'
						".$t_fsk_lock_part."
						".$t_group_check_part."
						and p.products_ordered > 0
						and p.products_id = pd.products_id
						and pd.language_id = '".(int) $_SESSION['languages_id']."'
					order by
						p.products_ordered desc limit ".MAX_DISPLAY_BESTSELLERS
				;
			}
			$t_result = xtc_db_query($t_sql);

			$coo_product = new product();
			$t_products_array = array();

			if(xtc_db_num_rows($t_result, true) >= MIN_DISPLAY_BESTSELLERS || $_SESSION['style_edit_mode'] == 'edit')
			{
				$t_rows_cnt = 0;
				while ($t_row = xtc_db_fetch_array($t_result, true)) {
					$t_rows_cnt++;

					$t_row = array_merge($t_row, array('ID' => xtc_row_number_format((double)$t_rows_cnt)));
					$t_products_array[] = $coo_product->buildDataArray($t_row);

				}
			}
			if(sizeof($t_products_array) > 0)
			{
				$this->set_content_data('PRODUCTS_DATA', $t_products_array);
			}
		}
		else {
			if(is_object($GLOBALS['coo_debugger'])) $GLOBALS['coo_debugger']->log('BestsellersContentView get_html USE_CACHE', 'SmartyCache');
		}
		
		$t_html_output = $this->build_html();
		return $t_html_output;
	}
	
}
?>