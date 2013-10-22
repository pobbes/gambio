<?php
/* --------------------------------------------------------------
   JSCheckoutExtender.inc.php 2012-06-19 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

class JSCheckoutExtender extends JSCheckoutExtender_parent
{
	function proceed()
	{
		parent::proceed();
		
		include_once(get_usermod(DIR_FS_CATALOG . 'gm/javascript/PreserveSessionHandler.js'));

		if(gm_get_env_info('TEMPLATE_VERSION') >= FIRST_GX2_TEMPLATE_VERSION)
		{
			include_once(get_usermod(DIR_FS_CATALOG . 'templates/'.CURRENT_TEMPLATE.'/javascript/checkout/ButtonCheckoutModuleHandler.js'));
			include_once(get_usermod(DIR_FS_CATALOG . 'templates/'.CURRENT_TEMPLATE.'/javascript/order/ButtonPrintOrderHandler.js'));
			include_once(get_usermod(DIR_FS_CATALOG . 'templates/'.CURRENT_TEMPLATE.'/javascript/FormHighlighterHandler.js'));

			if(MODULE_PAYMENT_PAYPALEXPRESS_STATUS == 'True')
			{
				include_once(get_usermod(DIR_FS_CATALOG . 'templates/'.CURRENT_TEMPLATE.'/javascript/paypal_checkout/ButtonPayPalExpressHandler.js'));
			}
			
			if(gm_get_conf('GM_LIGHTBOX_CHECKOUT') == 'true')
			{
				include_once(get_usermod(DIR_FS_CATALOG . 'templates/'.CURRENT_TEMPLATE.'/javascript/checkout/ButtonCloseLightboxHandler.js'));
				include_once(get_usermod(DIR_FS_CATALOG . 'templates/'.CURRENT_TEMPLATE.'/javascript/ShowLightBox.js'));
			}
		}
		elseif(gm_get_conf('GM_LIGHTBOX_CHECKOUT') == 'true')
		{
			include_once(get_usermod(DIR_FS_CATALOG . 'gm/javascript/GMShowLightBox.js'));
		}		
		
		if(gm_get_env_info('TEMPLATE_VERSION') < FIRST_GX2_TEMPLATE_VERSION && MODULE_PAYMENT_PAYPALEXPRESS_STATUS == 'True')
		{
			include_once(get_usermod(DIR_FS_CATALOG . 'templates/'.CURRENT_TEMPLATE.'/javascript/paypal_checkout/ButtonPayPalExpressHandler.js'));
		}
	}
}
?>