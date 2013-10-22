<?php
/* --------------------------------------------------------------
   LogoffContentView.inc.php 2012-04-02 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(logoff.php,v 1.12 2003/02/13); www.oscommerce.com
   (c) 2003	 nextcommerce (logoff.php,v 1.16 2003/08/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: logoff.php 1071 2005-07-22 16:36:53Z mz $)

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contribution:

   Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
   http://www.oscommerce.com/community/contributions,282
   Copyright (c) Strider | Strider@oscworks.com
   Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
   Copyright (c) Andre ambidex@gmx.net
   Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org


   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class LogoffContentView extends ContentView
{
	function LogoffContentView()
	{
		$this->set_content_template('module/logoff.html');
		$this->set_flat_assigns(true);
	}
	
	function get_html()
	{
		//delete Guests from Database

		if (($_SESSION['account_type'] == 1) && (DELETE_GUEST_ACCOUNT == 'true')) {
			xtc_db_query("delete from ".TABLE_CUSTOMERS." where customers_id = '".$_SESSION['customer_id']."'");
			xtc_db_query("delete from ".TABLE_ADDRESS_BOOK." where customers_id = '".$_SESSION['customer_id']."'");
			xtc_db_query("delete from ".TABLE_CUSTOMERS_INFO." where customers_info_id = '".$_SESSION['customer_id']."'");
			// BOF GM_MOD
			xtc_db_query("delete from customers_basket where customers_id = '".$_SESSION['customer_id']."'");
			xtc_db_query("delete from customers_basket_attributes   where customers_id = '".$_SESSION['customer_id']."'");
			xtc_db_query("delete from customers_ip   where customers_id = '".$_SESSION['customer_id']."'");
			xtc_db_query("delete from customers_wishlist   where customers_id = '".$_SESSION['customer_id']."'");
			xtc_db_query("delete from customers_wishlist_attributes   where customers_id = '".$_SESSION['customer_id']."'");
			xtc_db_query("delete from customers_status_history   where customers_id = '".$_SESSION['customer_id']."'");
			xtc_db_query("delete from coupon_gv_customer   where customer_id = '".$_SESSION['customer_id']."'");
			xtc_db_query("delete from coupon_gv_queue   where customer_id = '".$_SESSION['customer_id']."'");
			xtc_db_query("delete from coupon_redeem_track   where customer_id = '".$_SESSION['customer_id']."'");
			xtc_db_query("delete from whos_online   where customer_id = '".$_SESSION['customer_id']."'");
			xtc_db_query("DELETE FROM gm_gprint_cart_elements WHERE customers_id = '".$_SESSION['customer_id']."'");
			xtc_db_query("DELETE FROM gm_gprint_wishlist_elements WHERE customers_id = '".$_SESSION['customer_id']."'");			
			// EOF GM_MOD
			
			xtc_db_query("UPDATE " . TABLE_ORDERS . " SET customers_id = 0 WHERE customers_id = '" . (int)$_SESSION['customer_id'] . "'");
		}

		// BOF GM_MOD:
		if($_SESSION['style_edit_mode'] != 'edit') xtc_session_destroy();

		unset ($_SESSION['customer_id']);
		unset ($_SESSION['customer_default_address_id']);
		unset ($_SESSION['customer_first_name']);
		unset ($_SESSION['customer_country_id']);
		unset ($_SESSION['customer_zone_id']);
		unset ($_SESSION['comments']);
		unset ($_SESSION['user_info']);
		unset ($_SESSION['customers_status']);
		unset ($_SESSION['selected_box']);
		unset ($_SESSION['navigation']);
		unset ($_SESSION['shipping']);
		unset ($_SESSION['payment']);
		unset ($_SESSION['ccard']);
		// GV Code Start
		unset ($_SESSION['gv_id']);
		unset ($_SESSION['cc_id']);
		// GV Code End
		$_SESSION['cart']->reset();
		// write customers status guest in session again
		require (DIR_WS_INCLUDES.'write_customers_status.php');

		$this->set_content_data('BUTTON_CONTINUE', '<a href="'.xtc_href_link(FILENAME_DEFAULT).'">'.xtc_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE).'</a>');
		$this->set_content_data('CONTINUE_LINK', xtc_href_link(FILENAME_DEFAULT));

		$t_html_output = $this->build_html();		

		return $t_html_output;
	}
}
?>