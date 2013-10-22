<?php
/* --------------------------------------------------------------
   AddressBookContentView.inc.php 2010-10-07 gambio
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

// include needed functions
require_once (DIR_FS_INC.'xtc_address_label.inc.php');
require_once (DIR_FS_INC.'xtc_get_country_name.inc.php');
require_once (DIR_FS_INC.'xtc_count_customer_address_book_entries.inc.php');

class AddressBookContentView extends ContentView
{
	function AddressBookContentView()
	{
		$this->set_content_template('module/address_book.html');
		$this->set_flat_assigns(true);
	}
	
	function get_html($p_coo_message_stack)
	{
		if($p_coo_message_stack->size('addressbook') > 0)
		{
			$this->set_content_data('error', $p_coo_message_stack->output('addressbook'));
		}	
		
		$this->set_content_data('ADDRESS_DEFAULT', xtc_address_label($_SESSION['customer_id'], $_SESSION['customer_default_address_id'], true, ' ', '<br />'));

		$addresses_data = array();
		$addresses_query = xtc_db_query("select address_book_id, entry_firstname as firstname, entry_lastname as lastname, entry_company as company, entry_street_address as street_address, entry_suburb as suburb, entry_city as city, entry_postcode as postcode, entry_state as state, entry_zone_id as zone_id, entry_country_id as country_id from ".TABLE_ADDRESS_BOOK." where customers_id = '".(int) $_SESSION['customer_id']."' order by firstname, lastname");
		while ($addresses = xtc_db_fetch_array($addresses_query)) {
			$format_id = xtc_get_address_format_id($addresses['country_id']);
			if ($addresses['address_book_id'] == $_SESSION['customer_default_address_id']) {
				$primary = 1;
			} else {
				$primary = 0;
			}
			
			$addresses_data[] = array ('NAME' => $addresses['firstname'].' '.$addresses['lastname'],
										'BUTTON_EDIT' => '<a href="'.xtc_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'edit='.$addresses['address_book_id'], 'SSL').'">'.xtc_image_button('small_edit.gif', SMALL_IMAGE_BUTTON_EDIT).'</a>',
										'BUTTON_DELETE' => '<a href="'.xtc_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'delete='.$addresses['address_book_id'], 'SSL').'">'.xtc_image_button('small_delete.gif', SMALL_IMAGE_BUTTON_DELETE).'</a>',
										'ADDRESS' => xtc_address_format($format_id, $addresses, true, ' ', '<br />'),
										'PRIMARY' => $primary,
										'BUTTON_EDIT_URL' => xtc_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'edit='.$addresses['address_book_id'], 'SSL'),
										'BUTTON_DELETE_URL' => xtc_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'delete='.$addresses['address_book_id'], 'SSL'));

		}
		$this->set_content_data('addresses_data', $addresses_data);

		$this->set_content_data('BUTTON_BACK', '<a href="'.xtc_href_link(FILENAME_ACCOUNT, '', 'SSL').'">'.xtc_image_button('button_back.gif', IMAGE_BUTTON_BACK).'</a>', 1);
		$this->set_content_data('BUTTON_BACK_LINK', xtc_href_link(FILENAME_ACCOUNT, '', 'SSL'));

		if(xtc_count_customer_address_book_entries() < MAX_ADDRESS_BOOK_ENTRIES)
		{
			$this->set_content_data('BUTTON_NEW', '<a href="'.xtc_href_link(FILENAME_ADDRESS_BOOK_PROCESS, '', 'SSL').'">'.xtc_image_button('button_add_address.gif', IMAGE_BUTTON_ADD_ADDRESS).'</a>', 1);
			$this->set_content_data('BUTTON_NEW_URL',  xtc_href_link(FILENAME_ADDRESS_BOOK_PROCESS, '', 'SSL'));
		}

		$this->set_content_data('ADDRESS_COUNT', sprintf(TEXT_MAXIMUM_ENTRIES, MAX_ADDRESS_BOOK_ENTRIES));

		$t_html_output = $this->build_html();


		return $t_html_output;
	}
}
?>