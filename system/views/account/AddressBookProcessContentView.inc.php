<?php
/* --------------------------------------------------------------
   AddressBookProcessContentView.inc.php 2010-10-07 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(address_book.php,v 1.57 2003/05/29); www.oscommerce.com
   (c) 2003	 nextcommerce (address_book.php,v 1.14 2003/08/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: address_book.php 867 2005-04-21 18:35:29Z mz $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class AddressBookProcessContentView extends ContentView
{
	function AddressBookProcessContentView()
	{
		$this->set_content_template('module/address_book_process.html');
		$this->set_flat_assigns(true);
	}
	
	function get_html($p_coo_message_stack)
	{
		// DUMMY
		$this->set_content_data('1', 1);

		$t_html_output = $this->build_html();


		return $t_html_output;
	}
}
?>