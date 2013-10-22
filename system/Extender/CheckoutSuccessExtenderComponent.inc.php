<?php

/* --------------------------------------------------------------
  CheckoutSuccessExtenderComponent.inc.php 2012-01-16 gm
  Gambio GmbH
  http://www.gambio.de
  Copyright (c) 2012 Gambio GmbH
  Released under the GNU General Public License (Version 2)
  [http://www.gnu.org/licenses/gpl-2.0.html]
  --------------------------------------------------------------
 */

MainFactory::load_class('ExtenderComponent');

class CheckoutSuccessExtenderComponent extends ExtenderComponent
{
	function get_order()
	{
		if(isset($this->v_data_array['orders_id']) && !empty($this->v_data_array['orders_id']))
		{
			$coo_order = new order($this->v_data_array['orders_id']);

			$this->set_data('coo_order', $coo_order);
		}
	}

	function proceed()
	{
		parent::proceed();
		
		$this->get_order();		
	}
}
?>