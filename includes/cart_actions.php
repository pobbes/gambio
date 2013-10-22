<?php
/* --------------------------------------------------------------
   cart_actions.php 2011-11-07 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(application_top.php,v 1.273 2003/05/19); www.oscommerce.com
   (c) 2003         nextcommerce (application_top.php,v 1.54 2003/08/25); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: cart_actions.php 1298 2005-10-09 13:14:44Z mz $)

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contribution:
   Add A Quickie v1.0 Autor  Harald Ponce de Leon

   Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
   http://www.oscommerce.com/community/contributions,282
   Copyright (c) Strider | Strider@oscworks.com
   Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
   Copyright (c) Andre ambidex@gmx.net
   Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org


   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

// Shopping cart actions
if (isset ($_GET['action'])) {
	// redirect the customer to a friendly cookie-must-be-enabled page if cookies are disabled
	if ($session_started == false) {
		xtc_redirect(xtc_href_link(FILENAME_COOKIE_USAGE));
	}

	if (DISPLAY_CART == 'true') {
		$t_show_cart = true;
		$goto = FILENAME_SHOPPING_CART;
		$parameters = array (
			'action',
			'cPath',
			'products_id',
			'pid'
		);
	} else {
		$goto = basename($PHP_SELF);

		// BOF GM_MOD
		if(isset($_GET['keywords']))
		{
			$goto = FILENAME_ADVANCED_SEARCH_RESULT;
		}
		// EOF GM_MOD

		if ($_GET['action'] == 'buy_now') {
			$parameters = array (
				'action',
				'pid',
				'products_id',
				'BUYproducts_id'
			);
		} else {
			$parameters = array (
				'action',
				'pid',
				'BUYproducts_id',
				'info'
			);
		}
	}

	// BOF GM_MOD GX-Customizer:
	require_once('gm/modules/gm_gprint_cart_actions.php');

	switch ($_GET['action']) {
		// customer wants to update the product quantity in their shopping cart
		case 'update_product' :

			if (is_object($econda))
				$econda->_emptyCart();

			for ($i = 0, $n = sizeof($_POST['products_id']); $i < $n; $i++)
			{
				//GM_MOD WISHLIST BOF ############
				if($_POST['submit_target'] == 'wishlist') //WISHLIST ############
				{
					if (in_array($_POST['products_id'][$i], (is_array($_POST['cart_delete']) ? $_POST['cart_delete'] : array ()))) {
						$_SESSION['wishList']->remove($_POST['products_id'][$i]);
						// BOF GM_MOD GX-Customizer
						if(isset($_SESSION['coo_gprint_wishlist']->v_elements[$_POST['products_id'][$i]]))
						{
							$_SESSION['coo_gprint_wishlist']->remove($_POST['products_id'][$i]);
						}
						// EOF GM_MOD GX-Customizer
					} else {

						if ($_SESSION['wishList']->get_quantity($_POST['products_id'][$i]) > MAX_PRODUCTS_QTY)
						{
							$t_gm_wishlist_products_qty = MAX_PRODUCTS_QTY;
						}
						else
						{
							$t_gm_wishlist_products_qty = xtc_remove_non_numeric(gm_convert_qty($_POST['cart_quantity'][$i]));
						}

						$attributes = ($_POST['id'][$_POST['products_id'][$i]]) ? $_POST['id'][$_POST['products_id'][$i]] : '';
						$_SESSION['wishList']->add_cart($_POST['products_id'][$i], $t_gm_wishlist_products_qty, $attributes, false);
					}
					$goto = 'wish_list.php';
				}
				else //CART ############
				{
					if (xtc_remove_non_numeric(gm_convert_qty($_POST['cart_quantity'][$i])) > MAX_PRODUCTS_QTY)
					{
						$t_gm_cart_products_qty = MAX_PRODUCTS_QTY;
					}
					else
					{
						$t_gm_cart_products_qty = xtc_remove_non_numeric(gm_convert_qty($_POST['cart_quantity'][$i]));
					}

					if (in_array($_POST['products_id'][$i], (is_array($_POST['cart_delete']) ? $_POST['cart_delete'] : array ()))) {
						$_SESSION['cart']->remove($_POST['products_id'][$i]);
						if (is_object($econda))
							$econda->_delArticle($_POST['products_id'][$i], $t_gm_cart_products_qty, gm_convert_qty($_POST['old_qty'][$i]));
						// BOF GM_MOD GX-Customizer
						if(isset($_SESSION['coo_gprint_cart']->v_elements[$_POST['products_id'][$i]]))
						{
							$_SESSION['coo_gprint_cart']->remove($_POST['products_id'][$i]);
						}
						// EOF GM_MOD GX-Customizer
					} else {
						$attributes = ($_POST['id'][$_POST['products_id'][$i]]) ? $_POST['id'][$_POST['products_id'][$i]] : '';

						if (is_object($econda)) {
							$old_quantity = $_SESSION['cart']->get_quantity(xtc_get_uprid($_POST['products_id'][$i], $_POST['id'][$i]));
							$econda->_updateProduct($_POST['products_id'][$i], $t_gm_cart_products_qty, $old_quantity);
						}
						$_SESSION['cart']->add_cart($_POST['products_id'][$i], $t_gm_cart_products_qty, $attributes, false);
					}
				}
				//GM_MOD WISHLIST EOF ############

			}
			xtc_redirect(xtc_href_link($goto, xtc_get_all_get_params($parameters)));
			break;
			// customer adds a product from the products page
		// BOF GM_MOD
		case 'update_wishlist' ;
			for($i = 0; $i < count($_POST['products_id']); $i++){
				$index = $_POST['products_id'][$i];
				// BOF GM_MOD
				if(gm_convert_qty($_POST['cart_quantity'][$i]) > MAX_PRODUCTS_QTY)
				{
					$t_gm_wishlist_products_qty = MAX_PRODUCTS_QTY;
				}
				else
				{
					$t_gm_wishlist_products_qty = gm_convert_qty($_POST['cart_quantity'][$i]);
				}

				$_SESSION['wishList']->contents[$index]['qty'] = $t_gm_wishlist_products_qty;
				// EOF GM_MOD
				if(!empty($_SESSION['customer_id'])){
					xtc_db_query("UPDATE customers_wishlist
												SET customers_basket_quantity = '" . gm_convert_qty($_POST['cart_quantity'][$i]) . "'
												WHERE
													customers_id = '" . $_SESSION['customer_id'] . "'
													AND products_id = '" . xtc_db_input($index) . "'");
				}
			}
			break;
		// EOF GM_MOD
		case 'add_product' :

			$t_products_properties_combis_id = 0;

			if(isset($_POST['properties_values_ids']))
			{
				$coo_properties_control = MainFactory::create_object('PropertiesControl');
				$t_products_properties_combis_id = $coo_properties_control->get_combis_id_by_value_ids_array($_POST['products_id'], $_POST['properties_values_ids']);
				if($t_products_properties_combis_id == 0)
				{
					die('combi not available');
				}
			}

			if (isset ($_POST['products_id']) && is_numeric($_POST['products_id'])) {

				if(!is_numeric(gm_convert_qty($_POST['products_qty']))){
					$_POST['products_qty'] = 1;
				}

				if (xtc_remove_non_numeric(gm_convert_qty($_POST['products_qty'])) + $_SESSION['cart']->get_quantity(xtc_get_uprid($_POST['products_id'], $_POST['id'])) > MAX_PRODUCTS_QTY)
				{
					$t_gm_cart_products_qty = MAX_PRODUCTS_QTY;
				}
				else
				{
					$t_gm_cart_products_qty = $_SESSION['cart']->get_quantity(xtc_get_uprid($_POST['products_id'], $_POST['id'])) + xtc_remove_non_numeric(gm_convert_qty($_POST['products_qty']));
				}

				if (xtc_remove_non_numeric(gm_convert_qty($_POST['products_qty'])) + $_SESSION['wishList']->get_quantity(xtc_get_uprid($_POST['products_id'], $_POST['id'])) > MAX_PRODUCTS_QTY)
				{
					$t_gm_wishlist_products_qty = MAX_PRODUCTS_QTY;
				}
				else
				{
					$t_gm_wishlist_products_qty = $_SESSION['wishList']->get_quantity(xtc_get_uprid($_POST['products_id'], $_POST['id'])) + xtc_remove_non_numeric(gm_convert_qty($_POST['products_qty']));
				}

				if (is_object($econda)) {
					$econda->_emptyCart();
					$old_quantity = $_SESSION['cart']->get_quantity(xtc_get_uprid($_POST['products_id'], $_POST['id'], (int)$t_products_properties_combis_id));
					$econda->_addProduct($_POST['products_id'], $t_gm_cart_products_qty, $old_quantity);
				}

				if($_POST['submit_target'] == 'wishlist') {
					$_SESSION['wishList']->add_cart(
												(int) $_POST['products_id'],
												$t_gm_wishlist_products_qty,
												$_POST['id'],
												true,
												(int)$t_products_properties_combis_id
											);
					$goto = 'wish_list.php';
				} else {
					$_SESSION['cart']->add_cart(
											(int) $_POST['products_id'],
											$t_gm_cart_products_qty,
											$_POST['id'],
											true,
											(int)$t_products_properties_combis_id
										);
				}
			}
			// BOF GM_MOD
			$parameters[] = 'products_id';
			$gm_get_params = xtc_get_all_get_params($parameters);
			if(!empty($gm_get_params)) $gm_get_params = '&' . $gm_get_params;

			// GX-Customizer product
			if(isset($_POST['id']) && in_array('0', $_POST['id']) && $goto != 'shopping_cart.php' && $goto != 'wish_list.php')
			{
				xtc_redirect(xtc_href_link($goto, 'products_id=' . (int) $_POST['products_id'] . '&open_cart_dropdown=1' . $gm_get_params));
			}

			if($gmSEOBoost->boost_products && $goto != 'shopping_cart.php' && $goto != 'wish_list.php') {
				$gm_product_link = $gmSEOBoost->get_boosted_product_url((int) $_POST['products_id'], $_GET['gm_boosted_product']);
		  	xtc_redirect(xtc_href_link($gm_product_link));
			}
			elseif($goto != 'shopping_cart.php' && $goto != 'wish_list.php') {
				xtc_redirect(xtc_href_link($goto, 'products_id=' . (int) $_POST['products_id'] . $gm_get_params));
			}
			else{
				$parameters[] = 'info';
				$gm_get_params = xtc_get_all_get_params($parameters);
				xtc_redirect(xtc_href_link($goto, $gm_get_params));
			}
			// EOF GM_MOD
			break;
		// BOF GM_MOD
		case 'wishlist_to_cart' :
			if(!empty($_POST['cart_delete'])){
				$products_to_cart = $_POST['cart_delete'];
				for($i = 0; $i < count($products_to_cart); $i++){
					$pos = strpos($products_to_cart[$i], '{');

					$coo_properties_control = MainFactory::create_object('PropertiesControl');
					$t_combis_id = (int)$coo_properties_control->extract_combis_id($products_to_cart[$i]);

					if($pos !== false){
						$gm_ids = array();
						$index = $products_to_cart[$i];
						$gm_ids = $_POST['id'][$index];
						$gm_products_id = substr($products_to_cart[$i], 0, $pos);
						// BOF GM_MOD
						if((double)$_SESSION['cart']->contents[$index]['qty'] + gm_convert_qty($_POST['cart_quantity'][array_search($products_to_cart[$i], $_POST['products_id'], true)]) > MAX_PRODUCTS_QTY)
						{
							$t_gm_cart_products_qty = MAX_PRODUCTS_QTY;
						}
						else
						{
							$t_gm_cart_products_qty = (double)$_SESSION['cart']->contents[$index]['qty'] + gm_convert_qty($_POST['cart_quantity'][array_search($products_to_cart[$i], $_POST['products_id'], true)]);
						}

						$_SESSION['cart']->add_cart((int) $gm_products_id, $t_gm_cart_products_qty, $gm_ids, true, $t_combis_id);
						// EOF GM_MOD
					}
					else{
						// BOF GM_MOD
						if($_SESSION['cart']->get_quantity(xtc_get_uprid($products_to_cart[$i], null)) + gm_convert_qty($_POST['cart_quantity'][array_search($products_to_cart[$i], $_POST['products_id'], true)]) > MAX_PRODUCTS_QTY)
						{
							$t_gm_cart_products_qty = MAX_PRODUCTS_QTY;
						}
						else
						{
							$t_gm_cart_products_qty = $_SESSION['cart']->get_quantity(xtc_get_uprid($products_to_cart[$i], null)) + gm_convert_qty($_POST['cart_quantity'][array_search($products_to_cart[$i], $_POST['products_id'], true)]);
						}

						$_SESSION['cart']->add_cart((int) $products_to_cart[$i], $t_gm_cart_products_qty, null, true, $t_combis_id);
						// EOF GM_MOD
					}
				}
			}

			xtc_redirect(xtc_href_link($goto, 'open_cart_dropdown=1' . xtc_get_all_get_params($parameters)));
			break;
		// EOF GM_MOD
		case 'check_gift' :
			require_once (DIR_FS_INC . 'xtc_collect_posts.inc.php');
			xtc_collect_posts();
			break;

			// customer wants to add a quickie to the cart (called from a box)
		case 'add_a_quickie' :
			$quicky = addslashes($_POST['quickie']);
			if (GROUP_CHECK == 'true') {
				$group_check = "and group_permission_" . $_SESSION['customers_status']['customers_status_id'] . "=1 ";
			}

			$quickie_query = xtc_db_query("select
						                                        products_fsk18,
						                                        products_id from " . TABLE_PRODUCTS . "
						                                        where products_model = '" . $quicky . "' " . "AND products_status = '1' AND gm_price_status = 0 " . $group_check);

			if (!xtc_db_num_rows($quickie_query)) {
				if (GROUP_CHECK == 'true') {
					$group_check = "and group_permission_" . $_SESSION['customers_status']['customers_status_id'] . "=1 ";
				}
				$quickie_query = xtc_db_query("select
								                                                 products_fsk18,
								                                                 products_id from " . TABLE_PRODUCTS . "
								                                                 where products_model LIKE '%" . $quicky . "%' " . "AND products_status = '1' AND gm_price_status = 0 " . $group_check);
			}
			if (xtc_db_num_rows($quickie_query) != 1) {
				xtc_redirect(xtc_href_link(FILENAME_ADVANCED_SEARCH_RESULT, 'keywords=' . $quicky, 'NONSSL'));
			}
			$quickie = xtc_db_fetch_array($quickie_query);
			if (xtc_has_product_attributes($quickie['products_id'])) {
				// BOF GM_MOD
				if($gmSEOBoost->boost_products) {
					$gm_product_link = $gmSEOBoost->get_boosted_product_url((int) $quickie['products_id'], $_GET['gm_boosted_product']);
					xtc_redirect(xtc_href_link($gm_product_link));
				}
				else xtc_redirect(xtc_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $quickie['products_id'], 'NONSSL'));
				// EOF GM_MOD
			} else {
				if ($quickie['products_fsk18'] == '1' && $_SESSION['customers_status']['customers_fsk18'] == '1') {
					// BOF GM_MOD
					if($gmSEOBoost->boost_products) {
						$gm_product_link = $gmSEOBoost->get_boosted_product_url((int) $quickie['products_id'], $_GET['gm_boosted_product']);
						xtc_redirect(xtc_href_link($gm_product_link));
					}
					else xtc_redirect(xtc_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $quickie['products_id'], 'NONSSL'));
					// EOF GM_MOD
				}
				if ($_SESSION['customers_status']['customers_fsk18_display'] == '0' && $quickie['products_fsk18'] == '1') {
					// BOF GM_MOD
					if($gmSEOBoost->boost_products) {
						$gm_product_link = $gmSEOBoost->get_boosted_product_url((int) $quickie['products_id'], $_GET['gm_boosted_product']);
						xtc_redirect(xtc_href_link($gm_product_link));
					}
					else xtc_redirect(xtc_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $quickie['products_id'], 'NONSSL'));
					// EOF GM_MOD
				}
				if ($_POST['quickie'] != '') {
					// BOF GM_MOD
					if($_SESSION['cart']->get_quantity(xtc_get_uprid($quickie['products_id'], 1)) + 1 > MAX_PRODUCTS_QTY)
					{
						$t_gm_cart_products_qty = MAX_PRODUCTS_QTY;
					}
					else
					{
						$t_gm_cart_products_qty = $_SESSION['cart']->get_quantity(xtc_get_uprid($quickie['products_id'], 1)) + 1;
					}

					$_SESSION['cart']->add_cart($quickie['products_id'], $t_gm_cart_products_qty, 1);
					// EOF GM_MOD
					xtc_redirect(xtc_href_link($goto, xtc_get_all_get_params(array (
						'action'
					)), 'NONSSL'));
				} else {
					xtc_redirect(xtc_href_link(FILENAME_ADVANCED_SEARCH_RESULT, 'keywords=' . $quicky, 'NONSSL'));
				}
			}
			break;

			// performed by the 'buy now' button in product listings and review page
		case 'buy_now' :
			// BOF GM_MOD
			if(!isset($_POST['products_qty']))
			{
				$_POST['products_qty'] = 1;
			}

			$t_products_properties_combis_id = 0;

			if(isset($_POST['properties_values_ids']))
			{
				$coo_properties_control = MainFactory::create_object('PropertiesControl');
				$t_products_properties_combis_id = $coo_properties_control->get_combis_id_by_value_ids_array($_POST['products_id'], $_POST['properties_values_ids']);
				if($t_products_properties_combis_id == 0)
				{
					die('combi not available');
				}
			}
			// EOF GM_MOD



			if (isset ($_GET['BUYproducts_id'])) {
				// check permission to view product

				$permission_query = xtc_db_query("SELECT group_permission_" . $_SESSION['customers_status']['customers_status_id'] . " as customer_group, products_fsk18 from " . TABLE_PRODUCTS . " where products_id='" . (int) $_GET['BUYproducts_id'] . "'");
				$permission = xtc_db_fetch_array($permission_query);

				// check for FSK18
				if ($permission['products_fsk18'] == '1' && $_SESSION['customers_status']['customers_fsk18'] == '1') {
					if(isset($t_turbo_buy_now) && $t_turbo_buy_now == true)
					{
						$t_show_details = true;
						break;
					}
					// BOF GM_MOD
					if($gmSEOBoost->boost_products) {
						$gm_product_link = $gmSEOBoost->get_boosted_product_url((int) $_GET['BUYproducts_id'], $_GET['gm_boosted_product']);
						xtc_redirect(xtc_href_link($gm_product_link));
					}
					else xtc_redirect(xtc_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int) $_GET['BUYproducts_id'], 'NONSSL'));
					// EOF GM_MOD
				}

				if ($_SESSION['customers_status']['customers_fsk18_display'] == '0' && $permission['products_fsk18'] == '1') {
					if(isset($t_turbo_buy_now) && $t_turbo_buy_now == true)
					{
						$t_show_details = true;
						break;
					}
					// BOF GM_MOD
					if($gmSEOBoost->boost_products) {
						$gm_product_link = $gmSEOBoost->get_boosted_product_url((int) $_GET['BUYproducts_id'], $_GET['gm_boosted_product']);
						xtc_redirect(xtc_href_link($gm_product_link));
					}
					else xtc_redirect(xtc_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int) $_GET['BUYproducts_id'], 'NONSSL'));
					// EOF GM_MOD
				}

				if (GROUP_CHECK == 'true') {
					if ($permission['customer_group'] != '1') {
						if(isset($t_turbo_buy_now) && $t_turbo_buy_now == true)
						{
							$t_show_details = true;
							break;
						}
						// BOF GM_MOD
						if($gmSEOBoost->boost_products) {
							$gm_product_link = $gmSEOBoost->get_boosted_product_url((int) $_GET['BUYproducts_id'], $_GET['gm_boosted_product']);
							xtc_redirect(xtc_href_link($gm_product_link));
						}
						else xtc_redirect(xtc_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int) $_GET['BUYproducts_id']));
						// EOF GM_MOD
					}
				}

				// BOF GM_MOD
				$gm_qty_check = false;
				if(!isset($_POST['id'])){
					$gm_get_order_qty = xtc_db_query("SELECT gm_min_order, gm_graduated_qty
																						FROM products
																						WHERE products_id = '" . (int)$_GET['BUYproducts_id'] . "'");
					if(xtc_db_num_rows($gm_get_order_qty) == 1){
						$row = xtc_db_fetch_array($gm_get_order_qty);
						$gm_qty = gm_convert_qty($_POST['products_qty']);
						if($gm_qty < $row['gm_min_order']) $gm_qty_check = true;
						if(!$gm_qty_check){
							$gm_result = $gm_qty / $row['gm_graduated_qty'];
							$gm_result = round($gm_result, 4); // workaround for next if-case to avoid calculating failure
							if((int)$gm_result != $gm_result) $gm_qty_check = true;
						}
					}
				}
				// EOF GM_MOD

				// BOF GM_MOD
				if (xtc_remove_non_numeric(gm_convert_qty($_POST['products_qty'])) + $_SESSION['cart']->get_quantity(xtc_get_uprid((int) $_GET['BUYproducts_id'], $_POST['id'], $t_products_properties_combis_id)) > MAX_PRODUCTS_QTY)
				{
					$t_gm_cart_products_qty = MAX_PRODUCTS_QTY;
				}
				else
				{
					$t_gm_cart_products_qty = $_SESSION['cart']->get_quantity(xtc_get_uprid((int) $_GET['BUYproducts_id'], $_POST['id'], $t_products_properties_combis_id)) + xtc_remove_non_numeric(gm_convert_qty($_POST['products_qty']));
				}

				/*
				if(isset($t_turbo_buy_now) && $t_turbo_buy_now == true)
				{
					$t_show_details = true;
					break;
				}
				#GM_MOD: properties patch
				xtc_redirect(xtc_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int) $_GET['BUYproducts_id']));
				*/

				if (xtc_has_product_attributes($_GET['BUYproducts_id']) || $gm_qty_check) {
					if(!empty($_POST['products_id']) && (isset($_POST['id']) || $_POST['properties_values_ids']))
					{
						$_SESSION['cart']->add_cart((int) $_POST['products_id'], $t_gm_cart_products_qty, $_POST['id'], true, (int)$t_products_properties_combis_id);
						if(isset($t_turbo_buy_now) && $t_turbo_buy_now == true)
						{
							# all done. back to request_port
							break;
						}
					}
					else{
						if(isset($t_turbo_buy_now) && $t_turbo_buy_now == true)
						{
							$t_show_details = true;
							break;
						}
						if($gmSEOBoost->boost_products) {
							$gm_product_link = $gmSEOBoost->get_boosted_product_url((int) $_GET['BUYproducts_id'], $_GET['gm_boosted_product']);
					  		xtc_redirect(xtc_href_link($gm_product_link));
						}
						else xtc_redirect(xtc_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int) $_GET['BUYproducts_id']));
					}
					// EOF GM_MOD
				} else {
					if (isset ($_SESSION['cart'])) {
						if (is_object($econda)) {
							$econda->_emptyCart();
							$old_quantity = $_SESSION['cart']->get_quantity((int) $_GET['BUYproducts_id']);
							$econda->_addProduct((int)$_GET['BUYproducts_id'], $t_gm_cart_products_qty, $old_quantity);
						}
						// BOF GM_MOD
						if(empty($_POST['products_qty'])) $_POST['products_qty'] = 1;
						$_SESSION['cart']->add_cart((int) $_GET['BUYproducts_id'], $t_gm_cart_products_qty, null, true, (int)$t_products_properties_combis_id);
						if(isset($t_turbo_buy_now) && $t_turbo_buy_now == true)
						{
							# all done
							break;
						}
						// EOF GM_MOD
					} else {
						if(isset($t_turbo_buy_now) && $t_turbo_buy_now == true)
						{
							$t_show_details = true;
							break;
						}
						xtc_redirect(xtc_href_link(FILENAME_DEFAULT));
					}
				}
			}
			// BOF GM_MOD
			$gm_get_params = xtc_get_all_get_params(array (
				'action',
				'BUYproducts_id'
			));

			if(substr($gm_get_params,-1) == '&') $gm_get_params = substr($gm_get_params,0,-1);

			if($gmSEOBoost->boost_categories && $goto != 'shopping_cart.php' && $goto != 'wish_list.php') {
				if(isset ($_GET['keywords'])){
					$goto = 'advanced_search_result.php';
					xtc_redirect(xtc_href_link($goto, $gm_get_params));
				}
				elseif (isset ($_GET['cat'])) {
					$cID = substr($_GET['cat'], 1, strlen($_GET['cat'])-1);
					$gm_category_link = $gmSEOBoost->get_boosted_category_url($cID);

		  			xtc_redirect($gm_category_link);
				}
				else xtc_redirect(xtc_href_link($goto, $gm_get_params));
		  	}
			else {
				if (DISPLAY_CART == 'true') {
					$gm_get_params = xtc_get_all_get_params(array (
																	'action',
																	'BUYproducts_id',
																	'cat',
																	'keywords',
																	'page'
															));
				}

				xtc_redirect(xtc_href_link($goto, $gm_get_params));
		  	}
			// EOF GM_MOD
			break;

		case 'cust_order' :
			// BOF GM_MOD
			$gm_qty_check = false;
			if(!isset($_POST['id'])){
				$gm_get_order_qty = xtc_db_query("SELECT gm_min_order, gm_graduated_qty
																					FROM products
																					WHERE products_id = '" . (int)$_GET['pid'] . "'");
				if(xtc_db_num_rows($gm_get_order_qty) == 1){
					$row = xtc_db_fetch_array($gm_get_order_qty);
					$gm_qty = gm_convert_qty($_POST['products_qty']);
					if($gm_qty < $row['gm_min_order']) $gm_qty_check = true;
					if(!$gm_qty_check){
						$gm_result = $gm_qty / $row['gm_graduated_qty'];
						$gm_result = round($gm_result, 4); // workaround for next if-case to avoid calculating failure
						if((int)$gm_result != $gm_result) $gm_qty_check = true;
					}
				}
			}
			// EOF GM_MOD

			if (isset ($_SESSION['customer_id']) && isset ($_GET['pid'])) {
				// BOF GM_MOD:
				if (xtc_has_product_attributes((int) $_GET['pid']) || $gm_qty_check) {
					// BOF GM_MOD
					if($gmSEOBoost->boost_products) {
						$gm_product_link = $gmSEOBoost->get_boosted_product_url((int) $_GET['pid'], $_GET['gm_boosted_product']);
						xtc_redirect(xtc_href_link($gm_product_link));
					}
					else xtc_redirect(xtc_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int) $_GET['pid']));
					// EOF GM_MOD
				} else {
					// BOF GM_MOD
					if ($_SESSION['cart']->get_quantity((int) $_GET['pid']) + 1 > MAX_PRODUCTS_QTY)
					{
						$t_gm_cart_products_qty = MAX_PRODUCTS_QTY;
					}
					else
					{
						$t_gm_cart_products_qty = $_SESSION['cart']->get_quantity((int) $_GET['pid']) + 1;
					}

					$_SESSION['cart']->add_cart((int) $_GET['pid'], $t_gm_cart_products_qty);
					// EOF GM_MOD
				}
			}
			xtc_redirect(xtc_href_link($goto, xtc_get_all_get_params($parameters)));
			break;
		case 'paypal_express_checkout' :
			$o_paypal->paypal_auth_call();
			xtc_redirect($o_paypal->payPalURL);
			break;

	}
}
?>