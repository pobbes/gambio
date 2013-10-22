<?php
/* --------------------------------------------------------------
   ResetTokenAdminApplicationTopExtender.inc.php 2012-02-15 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

class ResetTokenAdminApplicationTopExtender extends ResetTokenAdminApplicationTopExtender_parent
{
	function proceed()
	{
		parent::proceed();

		$coo_cache_control = MainFactory::create_object('CacheControl');
		if(sizeof($this->v_data_array['POST']) > 0 || (
				isset($this->v_data_array['GET']['action']) &&
				(
					$this->v_data_array['GET']['action'] == 'setcflag' ||
					$this->v_data_array['GET']['action'] == 'setpflag' ||
					$this->v_data_array['GET']['action'] == 'setflag'
				)
			))
		{
			$coo_cache_control->set_reset_token();
		}
	}
}
?>