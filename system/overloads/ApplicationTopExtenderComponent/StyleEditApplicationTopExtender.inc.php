<?php
/* --------------------------------------------------------------
   StyleEditApplicationTopExtender.inc.php 2012-01-16 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

class StyleEditApplicationTopExtender extends StyleEditApplicationTopExtender_parent
{
	function proceed()
	{
		parent::proceed();
		
		if(isset($this->v_data_array['GET']['style_edit_mode']))
		{
			if($this->v_data_array['GET']['style_edit_mode'] == 'edit' && $_SESSION['customers_status']['customers_status_id'] == 0)
			{
				$_SESSION['style_edit_mode'] = 'edit';
				$coo_sec = new GMSESecurity();
				$coo_sec->delete_sec_token(xtc_session_id());
				$coo_sec->set_sec_token(xtc_session_id());
				unset($coo_sec);
			}
			elseif($this->v_data_array['GET']['style_edit_mode'] == 'sos' && $_SESSION['customers_status']['customers_status_id'] == 0)
			{
				$_SESSION['style_edit_mode'] = 'sos';
				$coo_sec = new GMSESecurity();
				$coo_sec->delete_sec_token(xtc_session_id());
				$coo_sec->set_sec_token(xtc_session_id());
				unset($coo_sec);
			}
			elseif($this->v_data_array['GET']['style_edit_mode'] == 'stop')
			{
				unset($_SESSION['style_edit_mode']);
				@unlink(DIR_FS_CATALOG . 'cache/__dynamics.css');
				@unlink(DIR_FS_CATALOG . DIR_WS_IMAGES . 'logos/gm_corner.gif');
				if((int)gm_get_conf('GM_GAMBIO_CORNER') == 1) gm_create_corner();
			}
		}		
	}
}
?>