<?php
/* --------------------------------------------------------------
   OrderHistoryContentView.inc.php 2010-09-24 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(order_history.php,v 1.4 2003/02/10); www.oscommerce.com
   (c) 2003	 nextcommerce (order_history.php,v 1.9 2003/08/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: order_history.php 1262 2005-09-30 10:00:32Z mz $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

// include needed functions
require_once(DIR_FS_INC . 'xtc_get_all_get_params.inc.php');

class OrderHistoryContentView extends ContentView
{
	function OrderHistoryContentView()
	{
		$this->set_content_template('boxes/box_order_history.html');
		$this->set_caching_enabled(false);
	}

	function truncate($p_string, $t_limit = 24) {
		if(strlen($p_string) <= $t_limit)
		{
			return $p_string;
		}
		else
		{
			return substr_replace($p_string, '...', $t_limit);
		}
	}

	function get_html()
	{
		$coo_seo_boost = MainFactory::create_object('GMSEOBoost');

		if(isset($_SESSION['customer_id']) || $_SESSION['style_edit_mode'] == 'edit')
		{
			// retreive the last x products purchased
			$t_result = xtc_db_query("SELECT DISTINCT
											op.products_id
										FROM
											" . TABLE_ORDERS . " o,
											" . TABLE_ORDERS_PRODUCTS . " op,
											" . TABLE_PRODUCTS . " p
										WHERE
											o.customers_id = '" . (int)$_SESSION['customer_id'] . "' AND
											o.orders_id = op.orders_id AND
											op.products_id = p.products_id AND
											p.products_status = '1'
										GROUP BY products_id
										ORDER BY o.date_purchased DESC
										LIMIT " . MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX);
			if(xtc_db_num_rows($t_result))
			{
				$t_product_ids = '';
				while($t_orders_array = xtc_db_fetch_array($t_result))
				{
					$t_product_ids .= $t_orders_array['products_id'] . ',';
				}
				$t_product_ids = substr($t_product_ids, 0, -1);

				$t_result = xtc_db_query("SELECT
												products_id,
												products_name,
												products_meta_description
											FROM " . TABLE_PRODUCTS_DESCRIPTION . "
											WHERE
												products_id in (" . $t_product_ids . ") AND
												language_id = '" . (int)$_SESSION['languages_id'] . "'
											ORDER BY products_name");
				while($t_products_array = xtc_db_fetch_array($t_result))
				{
					if($coo_seo_boost->boost_products)
					{
						$t_product_link = xtc_href_link($coo_seo_boost->get_boosted_product_url($t_products_array['products_id'], $t_products_array['products_name']));
					}
					else
					{
						$t_product_link = xtc_href_link(FILENAME_PRODUCT_INFO, xtc_product_link($t_products_array['products_id'], $t_products_array['products_name']));
					}
					$t_title = '';
					if($t_products_array['products_meta_description'] != '')
					{
						if(strlen($t_products_array['products_meta_description']) > 80)
						{
							$t_title = ' title="' . htmlspecialchars_wrapper(substr($t_products_array['products_meta_description'], 0, 80)) . '"';
						}
						else
						{
							$t_title = ' title="' . htmlspecialchars_wrapper($t_products_array['products_meta_description']) . '"';
						}
					}
					$t_customer_orders_string .= '<a href="' . $t_product_link . '"' . $t_title . '>' . $this->truncate($t_products_array['products_name'], gm_get_conf('TRUNCATE_PRODUCTS_HISTORY')) . '</a><br />';
				}
			}
		}
		
		if($_SESSION['style_edit_mode'] == 'edit' && empty($t_customer_orders_string))
		{
			$t_customer_orders_string = ' ';
		}

		$this->set_content_data('CONTENT',	$t_customer_orders_string);
		$t_html_output = $this->build_html();
		
		return $t_html_output;
	}
}

?>