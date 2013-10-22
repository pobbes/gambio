<?php
/* --------------------------------------------------------------
   ClickandbuyCheckoutSuccessExtender.inc.php 2012-01-16 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

class ClickandbuyCheckoutSuccessExtender extends ClickandbuyCheckoutSuccessExtender_parent
{
	function proceed()
	{
		parent::proceed();
		
		//zmb clickandbuy
		// ClickandBuy: Second Confirmation check
		if(MODULE_PAYMENT_CLICKANDBUY_V2_SECONDCONFIRMATION_STATUS == 'true'
			&& isset($this->v_data_array['orders_id'])
			&& !empty($this->v_data_array['orders_id'])
			&& isset($this->v_data_array['coo_order'])
			&& is_object($this->v_data_array['coo_order'])
			&& $this->v_data_array['coo_order']->info['payment_method'] == 'clickandbuy_v2')
		{
			include_once('ext/clickandbuy/second_confirmation.php');

			list($cbsc_status, $cbsc_result) = clickandbuy_second_confirmation($this->v_data_array['orders_id']);
			$this->v_output_buffer['cbsc_status'] = $cbsc_status;
			$this->v_output_buffer['cbsc_result'] = $cbsc_result;
		}
		// /ClickandBuy
		//zmb clickandbuy end		
	}
}
?>