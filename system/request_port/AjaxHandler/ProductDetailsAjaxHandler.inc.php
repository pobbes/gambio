<?php
/* --------------------------------------------------------------
   ProductDetailsAjaxHandler.inc.php 2012-07-03 mb
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

class ProductDetailsAjaxHandler extends AjaxHandler
{
	function get_permission_status($p_customers_id=NULL)
	{
		return true;
	}

	function proceed()
	{
		$c_products_id = (string)$this->v_data_array['GET']['id'];
		
		$coo_product_details = MainFactory::create_object('ProductDetailsContentView');
		$this->v_output_buffer = $coo_product_details->get_html($c_products_id);

		return true;
	}
}
?>