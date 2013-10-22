<?php
/* --------------------------------------------------------------
   ShopOfflineApplicationTopExtender.inc.php 2012-01-16 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

class ShopOfflineApplicationTopExtender extends ShopOfflineApplicationTopExtender_parent
{
	function proceed()
	{
		parent::proceed();
		
		if(gm_get_conf('GM_SHOP_OFFLINE') != 'checked' || $_SESSION['customers_status']['customers_status_id'] == 0)
		{
			define('SHOP_OFFLINE', false);
		}
		else
		{
			define('SHOP_OFFLINE', true);
		}
	}
}
?>