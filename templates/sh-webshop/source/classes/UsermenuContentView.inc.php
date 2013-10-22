<?php
/* --------------------------------------------------------------
   UsermenuContentView.inc.php 2013-04-14
   --------------------------------------------------------------
*/

require_once(DIR_FS_CATALOG . 'gm/inc/gm_prepare_number.inc.php');

class UsermenuContentView extends ContentView
{
	function UsermenuContentView()
	{
		$this->set_content_template('boxes/box_usermenu.html');
		$this->set_caching_enabled(false);
	}
	
	function get_html()
	{
		$t_show_arrow = 0;

		$coo_xtc_price = new xtcPrice($_SESSION['currency'], $_SESSION['customers_status']['customers_status_id']);

		$this->set_content_data('HOME_URL', xtc_href_link(FILENAME_DEFAULT, '', 'NONSSL'));

		if(!isset($_SESSION['customer_id']))
		{
			$this->set_content_data('LOGIN_URL', xtc_href_link(FILENAME_LOGIN, '', 'NONSSL'));
		}
		else
		{
			$this->set_content_data('LOGOFF_URL', xtc_href_link(FILENAME_LOGOFF, '', 'NONSSL'));
			$this->set_content_data('ACCOUNT_URL', xtc_href_link(FILENAME_ACCOUNT, '', 'NONSSL'));
		}

		$t_gm_show_wishlist = gm_get_conf('GM_SHOW_WISHLIST');
		if($t_gm_show_wishlist == 'true')
		{
			$this->set_content_data('WISHLIST_URL', xtc_href_link(FILENAME_WISHLIST, '', 'NONSSL'));
		}

		$this->set_content_data('CART_URL', xtc_href_link(FILENAME_SHOPPING_CART, '', 'NONSSL'));
		$this->set_content_data('CHECKOUT_URL', xtc_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));

		if(count($coo_xtc_price->currencies) > 1 
			&& gm_get_conf('SHOW_TOP_CURRENCY_SELECTION') == 'true'
			&& strpos(gm_get_env_info('SCRIPT_NAME'), 'checkout') === false)
		{
			$this->set_content_data('CURRENT_CURRENCY', $_SESSION['currency']);
		}

		$t_customers_data_array = array();

		$t_customers_data_array['FIRST_NAME'] = '';
		if(isset($_SESSION['customer_first_name']))
		{
			$t_customers_data_array['FIRST_NAME'] = $_SESSION['customer_first_name'];
		}

		$t_customers_data_array['LAST_NAME'] = '';
		if(isset($_SESSION['customer_last_name']))
		{
			$t_customers_data_array['LAST_NAME'] = $_SESSION['customer_last_name'];
		}

		$t_customers_data_array['PRODUCTS_DISCOUNT'] = '';
		if((double)$_SESSION['customers_status']['customers_status_discount'] > 0)
		{
			$t_show_arrow = 1;
			$t_customers_data_array['PRODUCTS_DISCOUNT'] = gm_prepare_number($_SESSION['customers_status']['customers_status_discount'], ',');
		}

		$t_customers_data_array['ORDER_DISCOUNT'] = '';
		if((double)$_SESSION['customers_status']['customers_status_ot_discount'] > 0 && $_SESSION['customers_status']['customers_status_ot_discount_flag'] == '1')
		{
			$t_show_arrow = 1;
			$t_customers_data_array['ORDER_DISCOUNT'] = gm_prepare_number($_SESSION['customers_status']['customers_status_ot_discount'], ',');
		}

		$t_customers_data_array['PUBLIC'] = $_SESSION['customers_status']['customers_status_public'];

		$t_customers_data_array['MIN_ORDER'] = '';
		if((double)$_SESSION['customers_status']['customers_status_min_order'] > 0)
		{
			$t_show_arrow = 1;
			$t_min_order = $coo_xtc_price->xtcFormat($_SESSION['customers_status']['customers_status_min_order'], true);
			$t_customers_data_array['MIN_ORDER'] = $t_min_order;
		}

		$t_customers_data_array['MAX_ORDER'] = '';
		if((double)$_SESSION['customers_status']['customers_status_max_order'] > 0)
		{
			$t_show_arrow = 1;
			$t_max_order = $coo_xtc_price->xtcFormat($_SESSION['customers_status']['customers_status_max_order'], true);
			$t_customers_data_array['MAX_ORDER'] = $t_max_order;
		}

		$t_customers_data_array['GENDER'] = $_SESSION['customer_gender'];

		$t_customers_data_array['GROUP'] = $_SESSION['customers_status']['customers_status_name'];

		$t_customers_data_array['ICON'] = '';
		if(file_exists('admin/images/icons/' . basename($_SESSION['customers_status']['customers_status_image'])));
		{
			$t_customers_data_array['ICON'] = 'admin/images/icons/' . basename($_SESSION['customers_status']['customers_status_image']);
		}

		$t_customers_data_array['SHOW_ARROW'] = $t_show_arrow;

		$this->set_content_data('customers_data', $t_customers_data_array);

		if(gm_get_conf('SHOW_TOP_LANGUAGE_SELECTION') == 'true')
		{
			$t_language_code = $_SESSION['language_code'];
			
			# workaround if session language data is incomplete
			if(!empty($_SESSION['language']) && empty($t_language_code))
			{
				$c_directory = gm_prepare_string($_SESSION['language']);

				$t_sql = "SELECT code
							FROM " . TABLE_LANGUAGES . "
							WHERE directory = '" . $c_directory . "'
							LIMIT 1";
				$t_result = xtc_db_query($t_sql);
				if(xtc_db_num_rows($t_result) == 1)
				{
					$t_language_data_array = xtc_db_fetch_array($t_result);
					$t_language_code = $t_language_data_array['code'];
				}
			}
			
			$this->set_content_data('LANGUAGE_ICON', 'lang/' . basename($_SESSION['language']) . '/' . basename($t_language_code) . '.png');
		}

		# topmenu content
		$coo_content = MainFactory::create_object('ContentContentView');
		$coo_content->get_html('topmenu_corner'); #init internal variables. do nothing with return value
		$t_content_array = $coo_content->get_content_array();

		if(is_array($t_content_array['CONTENT_LINKS_DATA'])) {
			$this->set_content_data('CONTENT_LINKS_DATA', $t_content_array['CONTENT_LINKS_DATA']);
		}

		$t_html_output = $this->build_html();
		return $t_html_output;
	}
}
?>