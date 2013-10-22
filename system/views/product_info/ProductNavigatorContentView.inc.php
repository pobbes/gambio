<?php
/* --------------------------------------------------------------
   ProductNavigatorContentView.inc.php 2010-09-28 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

(c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: product_navigator.php 1292 2005-10-07 16:10:55Z mz $) 

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class ProductNavigatorContentView extends ContentView
{
	function ProductNavigatorContentView()
	{
		$this->set_content_template('module/product_navigator.html');
		$this->set_flat_assigns(true);
	}
	
	function get_html($p_coo_product, $p_current_category_id)
	{
		$c_current_category_id = (int)$p_current_category_id;
		$coo_seo_boost = MainFactory::create_object('GMSEOBoost');

		if(isset($_SESSION['last_listing_sql']) == true)
		{
			# use last product listing query saved in product_listing.php
			$products_query = xtDBquery($_SESSION['last_listing_sql']);
		}
		else
		{
			// select products
			//fsk18 lock
			$fsk_lock = '';
			if ($_SESSION['customers_status']['customers_fsk18_display'] == '0') {
				$fsk_lock = ' and p.products_fsk18!=1';
			}
			$group_check = "";
			if (GROUP_CHECK == 'true') {
				$group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
			}

			//BOF_GM_MOD
			$gm_category_sort_query = xtc_db_query("SELECT
									products_sorting,
									products_sorting2
								FROM categories
								WHERE categories_id = '" . $c_current_category_id . "'");
			if(xtc_db_num_rows($gm_category_sort_query) == 1)
			{
				$gm_category_sort_data = xtc_db_fetch_array($gm_category_sort_query);
				if(!empty($gm_category_sort_data['products_sorting']))
				{
					$gm_navigator_sort = ' ORDER BY ' . $gm_category_sort_data['products_sorting'] . ' ' . $gm_category_sort_data['products_sorting2'];
				}
				else
				{
					$gm_navigator_sort =' ORDER BY p.products_price ASC';
				}
			}
			else
			{
				$gm_navigator_sort =' ORDER BY p.products_price ASC';
			}

			$products_query = xtDBquery("SELECT
											pc.products_id,
											pd.products_name
											FROM ".TABLE_PRODUCTS_TO_CATEGORIES." pc,
											".TABLE_PRODUCTS." p,
											".TABLE_PRODUCTS_DESCRIPTION." pd

											WHERE categories_id='".$c_current_category_id."'
											and p.products_id=pc.products_id
											and p.products_id = pd.products_id
											and pd.language_id = '".(int) $_SESSION['languages_id']."'
											and p.products_status=1
											".$fsk_lock.$group_check.$gm_navigator_sort);
			// EOF GM_MOD
		}
		
		$i = 0;
		while ($products_data = xtc_db_fetch_array($products_query, true)) {
			$p_data[$i] = array ('pID' => $products_data['products_id'], 'pName' => $products_data['products_name']);
			if ($products_data['products_id'] == $p_coo_product->data['products_id'])
				$actual_key = $i;
			$i ++;

		}

		// check if array key = first
		if ($actual_key == 0) {
			// aktuel key = first product
		} else {
			$prev_id = $actual_key -1;
			// BOF GM_MOD
			if($coo_seo_boost->boost_products) {
				$prev_link = $coo_seo_boost->get_boosted_product_url((int) $p_data[$prev_id]['pID']);
			}
			else
			{
				$prev_link = xtc_href_link(FILENAME_PRODUCT_INFO, xtc_product_link($p_data[$prev_id]['pID'], $p_data[$prev_id]['pName']));
			}
			// check if prev id = first
			if($prev_id != 0)
			{
				if($coo_seo_boost->boost_products) {
					$first_link = $coo_seo_boost->get_boosted_product_url((int) $p_data[0]['pID']);
				}
				else
				{
					$first_link = xtc_href_link(FILENAME_PRODUCT_INFO, xtc_product_link($p_data[0]['pID'], $p_data[0]['pName']));
				}
			}
			// EOF GM_MOD
		}

		// check if key = last
		if ($actual_key == (sizeof($p_data) - 1)) {
			// actual key is last
		} else {
			$next_id = $actual_key +1;
			// BOF GM_MOD
			if($coo_seo_boost->boost_products) {
				$next_link = $coo_seo_boost->get_boosted_product_url((int) $p_data[$next_id]['pID']);
			}
			else
			{
				$next_link = xtc_href_link(FILENAME_PRODUCT_INFO, xtc_product_link($p_data[$next_id]['pID'], $p_data[$next_id]['pName']));
			}
			// check if next id = last
			if($next_id != (sizeof($p_data) - 1))
			{
				if($coo_seo_boost->boost_products) {
					$last_link = $coo_seo_boost->get_boosted_product_url((int) $p_data[(sizeof($p_data) - 1)]['pID']);
				}
				else
				{
					$last_link = xtc_href_link(FILENAME_PRODUCT_INFO, xtc_product_link($p_data[(sizeof($p_data) - 1)]['pID'], $p_data[(sizeof($p_data) - 1)]['pName']));
				}
			}
			// EOF GM_MOD
		}
		$this->set_content_data('FIRST', $first_link);
		$this->set_content_data('PREVIOUS', $prev_link);
		$this->set_content_data('NEXT', $next_link);
		$this->set_content_data('LAST', $last_link);
		$this->set_content_data('PRODUCTS_COUNT', count($p_data));

		$t_html_output = $this->build_html();		

		return $t_html_output;
	}
}
?>