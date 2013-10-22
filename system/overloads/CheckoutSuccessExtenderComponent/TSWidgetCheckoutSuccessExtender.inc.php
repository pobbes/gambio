<?php
/* --------------------------------------------------------------
   TSWidgetCheckoutSuccessExtender.inc.php 2012-12-14 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

class TSWidgetCheckoutSuccessExtender extends TSWidgetCheckoutSuccessExtender_parent
{
	function proceed()
	{
		parent::proceed();
		
		if(isset($this->v_data_array['orders_id']) && !empty($this->v_data_array['orders_id']))
		{
			$obj_widget = MainFactory::create_object('GMTSWidget', array($_SESSION['languages_id']));
			$this->v_output_buffer['TS_RATING'] = $obj_widget->get_rating_link($this->v_data_array['orders_id'], 'GM_TRUSTED_SHOPS_WIDGET_SHOW_CHECKOUT');
			unset($obj_widget);	
		}
			
	}
}