<?php
/* --------------------------------------------------------------
   AdminContentView.inc.php 2011-04-27 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommercebased on original files FROM OSCommerce CVS 2.2 2002/08/28 02:14:35 www.oscommerce.com
   (c) 2003	 nextcommerce (admin.php,v 1.12 2003/08/13); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: admin.php 1262 2005-09-30 10:00:32Z mz $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

// include needed functions
require_once(DIR_FS_INC . 'xtc_image_button.inc.php');

class AdminContentView extends ContentView
{
	function AdminContentView()
	{
		$this->set_content_template('boxes/box_admin.html');
		$this->set_caching_enabled(false);
	}

	function get_html($p_coo_product)
	{
		global $cPath;
		$t_orders_contents = '';

		$t_orders_status_validating = xtc_db_num_rows(xtc_db_query("SELECT orders_status FROM " . TABLE_ORDERS ." where orders_status ='0'"));
		$t_url = "'".xtc_href_link_admin(FILENAME_ORDERS, 'SELECTed_box=customers&status=0', 'NONSSL')."'";
		if($_SESSION['style_edit_mode'] == 'edit')
		{
			$t_orders_contents .= '<a href="#" onclick="if(confirm(\'' . ADMIN_LINK_INFO_TEXT . '\')){window.location.href='.$t_url.'; return false;} return false;">' . TEXT_VALIDATING . '</a>: ' . $t_orders_status_validating . '<br />';
		}
		else
		{
			$t_orders_contents .= '<a href="#" onclick="window.location.href='.$t_url.'; return false;">' . TEXT_VALIDATING . '</a>: ' . $t_orders_status_validating . '<br />';
		}

		$t_result = xtc_db_query("SELECT
										orders_status_name,
										orders_status_id
									FROM " . TABLE_ORDERS_STATUS . "
									WHERE language_id = '" . (int)$_SESSION['languages_id'] . "'");
		while($t_orders_status_array = xtc_db_fetch_array($t_result))
		{
			$t_result2 = xtc_db_query("SELECT count(*) AS count
													FROM " . TABLE_ORDERS . "
													WHERE orders_status = '" . $t_orders_status_array['orders_status_id'] . "'");
			$t_orders_pending_array = xtc_db_fetch_array($t_result2);
			$t_url = "'".xtc_href_link_admin(FILENAME_ORDERS, 'selected_box=customers&status=' . $t_orders_status_array['orders_status_id'], 'NONSSL')."'";
			if($_SESSION['style_edit_mode'] == 'edit')
			{
				$t_orders_contents .= '<a href="#" onclick="if(confirm(\'' . ADMIN_LINK_INFO_TEXT . '\')){window.location.href='.$t_url.'; return false;} return false;">' . $t_orders_status_array['orders_status_name'] . '</a>: ' . $t_orders_pending_array['count'] . '<br />';
			}
			else
			{
				$t_orders_contents .= '<a href="#" onclick="window.location.href='.$t_url.'; return false;">' . $t_orders_status_array['orders_status_name'] . '</a>: ' . $t_orders_pending_array['count'] . '<br />';
			}
		}

		$t_orders_contents = substr($t_orders_contents, 0, -6);

		$t_result3 = xtc_db_query("SELECT count(*) AS count FROM " . TABLE_CUSTOMERS);
		$t_customers_array = xtc_db_fetch_array($t_result3);

		$t_result4 = xtc_db_query("SELECT count(*) AS count FROM " . TABLE_PRODUCTS . " where products_status = '1'");
		$t_products_array = xtc_db_fetch_array($t_result4);

		$t_result5 = xtc_db_query("SELECT count(*) AS count FROM " . TABLE_REVIEWS);
		$t_reviews_array = xtc_db_fetch_array($t_result5);

		$t_admin_image = '<a href="' . xtc_href_link_admin(FILENAME_START,'', 'NONSSL').'">'.xtc_image_button('button_admin.gif', IMAGE_BUTTON_ADMIN).'</a>';
		$this->set_content_data('BUTTON_ADMIN_URL', xtc_href_link_admin(FILENAME_START,'', 'NONSSL'));

		if($p_coo_product->isProduct())
		{
			if($_SESSION['style_edit_mode'] == 'edit')
			{
				$t_admin_link='<a href="' . xtc_href_link_admin(FILENAME_EDIT_PRODUCTS, 'cPath=' . $cPath . '&pID=' . $p_coo_product->data['products_id'], 'NONSSL') . '&action=new_product' . '" onclick="if(confirm(\'' . ADMIN_LINK_INFO_TEXT . '\')){window.open(this.href); return false;} return false;">' . xtc_image_button('edit_product.gif', IMAGE_BUTTON_PRODUCT_EDIT, 'style="margin-top:4px"') . '</a>';
			}
			else
			{
				$t_admin_link='<a href="' . xtc_href_link_admin(FILENAME_EDIT_PRODUCTS, 'cPath=' . $cPath . '&pID=' . $p_coo_product->data['products_id'], 'NONSSL') . '&action=new_product' . '" onclick="window.open(this.href); return false;">' . xtc_image_button('edit_product.gif', IMAGE_BUTTON_PRODUCT_EDIT, 'style="margin-top:4px"') . '</a>';
			}
			$this->set_content_data('BUTTON_EDIT_PRODUCT_URL', xtc_href_link_admin(FILENAME_EDIT_PRODUCTS, 'cPath=' . $cPath . '&pID=' . $p_coo_product->data['products_id'] . '&action=new_product', 'NONSSL'));
		}

		$t_content= '<strong>' . BOX_TITLE_STATISTICS . '</strong><br />' . $t_orders_contents . '<br />' .
						 BOX_ENTRY_CUSTOMERS . ' ' . $t_customers_array['count'] . '<br />' .
						 BOX_ENTRY_PRODUCTS . ' ' . $t_products_array['count'] . '<br />' .
						 BOX_ENTRY_REVIEWS . ' ' . $t_reviews_array['count'] .'<br />';

		if($_SESSION['style_edit_mode'] == 'edit')
		{
			$this->set_content_data('ADMIN_LINK_INFO', ADMIN_LINK_INFO_TEXT);
		}
		
		$this->set_content_data('CONTENT',	$t_content);


		$t_html_output = $this->build_html();
		
		return $t_html_output;
	}
}

?>