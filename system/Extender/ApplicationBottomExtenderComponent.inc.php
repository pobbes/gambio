<?php

/* --------------------------------------------------------------
  ApplicationBottomExtenderComponent.inc.php 2012-09-21 gm
  Gambio GmbH
  http://www.gambio.de
  Copyright (c) 2012 Gambio GmbH
  Released under the GNU General Public License (Version 2)
  [http://www.gnu.org/licenses/gpl-2.0.html]
  --------------------------------------------------------------
 */

MainFactory::load_class('ExtenderComponent');

class ApplicationBottomExtenderComponent extends ExtenderComponent
{
	var $v_page = false;

	function init_page()
	{
		// BOF GM_MOD
		$t_script_name = '';

		if(strpos($_SERVER['SCRIPT_NAME'], '.php') !== false && strpos($_SERVER['SCRIPT_NAME'], DIR_WS_CATALOG) !== false)
		{
			$t_script_name = $_SERVER['SCRIPT_NAME'];
		}
		elseif(strpos($_SERVER["PHP_SELF"], '.php') !== false && strpos($_SERVER['PHP_SELF'], DIR_WS_CATALOG) !== false)
		{
			$t_script_name = $_SERVER["PHP_SELF"];
		}
		elseif(strpos($_SERVER["SCRIPT_FILENAME"], '.php') !== false && strpos($_SERVER['SCRIPT_FILENAME'], DIR_WS_CATALOG) !== false)
		{
			$t_script_name = $_SERVER['SCRIPT_FILENAME'];
		}
		else
		{
			$t_script_name = $PHP_SELF;
		}

		$t_page = '';
		if    ($this->v_data_array['GET']['coID'] == 13) $t_page = 'Guestbook';
		elseif($this->v_data_array['GET']['coID'] == 14) $t_page = 'CallbackService';
		elseif(!empty($this->v_data_array['GET']['manufacturers_id']) && substr_count($t_script_name, 'index.php') 	> 0) $t_page = 'Manufacturers';
		elseif(!empty($this->v_data_array['GET']['cat']) || substr_count($_SERVER["QUERY_STRING"], 'cat=') > 0 || substr_count($_SERVER["REQUEST_URI"], 'cat/') > 0 || substr_count($t_script_name, 'advanced_search_result.php') > 0 || isset($this->v_data_array['GET']['filter_fv_id']) || isset($this->v_data_array['GET']['filter_price_min']) || isset($this->v_data_array['GET']['filter_price_max']) || isset($this->v_data_array['GET']['filter_id'])) $t_page = 'Cat';
		elseif(substr_count($t_script_name, 'product_info.php') 		> 0) $t_page = 'ProductInfo';
		elseif(substr_count($t_script_name, 'gm_price_offer.php') 	> 0) $t_page = 'PriceOffer';
		elseif(substr_count($t_script_name, 'shopping_cart.php') 	> 0) $t_page = 'Cart';
		elseif(substr_count($t_script_name, 'wish_list.php') 	> 0) $t_page = 'Wishlist';
		elseif(substr_count($t_script_name, 'gv_send.php') 	> 0) $t_page = 'GVSend';
		elseif(substr_count($t_script_name, 'checkout_') 	> 0 || substr_count($t_script_name, 'paypal_checkout') 	> 0) $t_page = 'Checkout';
		elseif(substr_count($t_script_name, 'account_history_info.php') 	> 0) $t_page = 'AccountHistory';
		elseif(substr_count($t_script_name, 'create_account.php') 	> 0 || substr_count($t_script_name, 'create_guest_account.php') 	> 0) {
			$t_page = 'Account';
		}
		elseif(substr_count(strtolower($t_script_name), 'index.php') > 0)
		{
			$t_page = 'Index';
		}

		$this->v_page = $t_page;
	}


	function get_page()
	{
		return $this->v_page;
	}
	
	
	function init_js()
	{
		if(gm_get_conf('GM_SHOP_OFFLINE') != 'checked' || $_SESSION['customers_status']['customers_status_id'] == 0) {
			$t_get_data_array = array();
			$t_page = $this->get_page();

			if(gm_get_conf('GM_STATUSBAR_ACTIVE') == 'true' || $t_page == 'ProductInfo') {
				$t_get_data_array[] = 'cPath=' . $this->v_data_array['cPath'];
				$t_get_data_array[] = 'products_id=' . $this->v_data_array['products_id'];
			}
			elseif($t_page == 'Cat')
			{
				$t_get_data_array[] = 'cPath=' . $this->v_data_array['cPath'];
			}

			$t_session_id	= xtc_session_id();
			$t_session_name = xtc_session_name();
			if(!empty($t_session_id) && xtc_check_agent() == 0)
			{
				$t_get_data_array[] = 'XTCsid='			. $t_session_id;
				$t_get_data_array[] = 'XTCsid_name='	. $t_session_name;
			}

			if(!empty($t_page))
			{
				$t_get_data_array[] = 'page=' . $t_page;
			}

			// open the MiniWK with this param
			if(isset($_GET['open_cart_dropdown']) && $_GET['open_cart_dropdown'] == 1)
			{
				$t_get_data_array[] = 'open_cart_dropdown=1';
			}

			$t_get_data_array[] = 'current_template=' . CURRENT_TEMPLATE;

			$this->v_output_buffer['GM_JAVASCRIPT_CODE'] = '<script type="text/javascript" src="gm_javascript.js.php?' . implode('&amp;', $t_get_data_array) . '"></script>';
		}
	}
	
	
	function proceed()
	{
		$t_page = $this->get_page();
		if($t_page === false) trigger_error('need call of init_page() method before proceed', E_USER_ERROR);
		
		parent::proceed();
	}
}
?>