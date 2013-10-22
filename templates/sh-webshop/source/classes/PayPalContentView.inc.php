<?php
/* --------------------------------------------------------------
   PayPalContentView.inc.php 2010-09-24 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
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


class PayPalContentView extends ContentView
{
	function PayPalContentView()
	{
		$this->set_content_template('boxes/box_paypal.html');
	}

	function get_html()
	{
		$t_html_output = '';

		$t_get_paypal_status = xtc_db_query("SELECT configuration_value
												FROM " . TABLE_CONFIGURATION . "
												WHERE
													(configuration_key = 'MODULE_PAYMENT_PAYPALEXPRESS_STATUS'
													OR
													configuration_key = 'MODULE_PAYMENT_PAYPAL_STATUS')
													AND configuration_value = 'true'");
		if(xtc_db_num_rows($t_get_paypal_status) > 0 || $_SESSION['style_edit_mode'] == 'edit')
		{
			$this->set_content_data('PAYPAL_URL', 'https://www.paypal-deutschland.de/privatkunden/los-geht-es-mit-paypal.html');

			$t_html_output = $this->build_html();
		}

		return $t_html_output;
	}
}

?>