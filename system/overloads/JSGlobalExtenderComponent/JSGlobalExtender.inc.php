<?php
/* --------------------------------------------------------------
   JSGlobalExtender.inc.php 2012-04-19 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

class JSGlobalExtender extends JSGlobalExtender_parent
{
	function proceed()
	{
		parent::proceed();
		
		// IE6
		if(gm_get_env_info('TEMPLATE_VERSION') >= FIRST_GX2_TEMPLATE_VERSION)
		{
			include_once(get_usermod(DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/javascript/IE6Handler.js'));
		}

		include_once(get_usermod(DIR_FS_CATALOG.'gm/javascript/gm_shop_scripts.js'));
		include_once(get_usermod(DIR_FS_CATALOG.'gm/javascript/jquery/plugins/hoverIntent/hoverIntent.js'));
		include_once(get_usermod(DIR_FS_CATALOG.'gm/javascript/jquery/plugins/jquery.form.js'));
		include_once(get_usermod(DIR_FS_CATALOG.'gm/javascript/functions.js'));
		include_once(get_usermod(DIR_FS_CATALOG.'gm/javascript/gm_start.js.php'));
		include_once(get_usermod(DIR_FS_CATALOG.'gm/javascript/GMLightBox.js'));
		include_once(get_usermod(DIR_FS_CATALOG.'gm/javascript/GMScroller.js.php'));
		include_once(get_usermod(DIR_FS_CATALOG.'gm/javascript/gm_shopping_cart.js'));		

		if(gm_get_env_info('TEMPLATE_VERSION') >= FIRST_GX2_TEMPLATE_VERSION)
		{			
			include_once(get_usermod(DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/javascript/ActionSubmitHandler.js'));
			include_once(get_usermod(DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/javascript/ButtonCurrencyChangeHandler.js'));
			include_once(get_usermod(DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/javascript/ButtonOpenSearchHandler.js'));
			include_once(get_usermod(DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/javascript/CartControl.js'));
			include_once(get_usermod(DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/javascript/CartDropdownHandler.js'));
			include_once(get_usermod(DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/javascript/InputEnterKeyHandler.js'));
			include_once(get_usermod(DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/javascript/PullDownLinkHandler.js'));
			include_once(get_usermod(DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/javascript/ResetFormHandler.js'));
			include_once(get_usermod(DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/javascript/slider_plugin.js'));
			include_once(get_usermod(DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/javascript/TopNavigationHandler.js'));
            include_once(get_usermod(DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/javascript/social_share_plugin.js'));

			if(gm_get_conf('GM_QUICK_SEARCH') == 'true')
			{
				include_once(get_usermod(DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/javascript/InputDefaultValueHandler.js'));
				include_once(get_usermod(DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/javascript/LiveSearchHandler.js'));
			}

			if(gm_get_conf('CAT_MENU_TOP') == 'true')
			{
				include_once(get_usermod(DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/javascript/MegadropdownHandler.js'));
			}

			if(gm_get_conf('CAT_MENU_LEFT') == 'true')
			{
				include_once(get_usermod(DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/javascript/SubmenuHandler.js'));
			}
		}
		else
		{
			include_once(get_usermod(DIR_FS_CATALOG.'gm/javascript/GMLiveSearch.js'));
			include_once(get_usermod(DIR_FS_CATALOG.'gm/javascript/GMProductImages.js'));
			include_once(get_usermod(DIR_FS_CATALOG.'gm/javascript/gm_form_styles.js'));
		}

		if(gm_get_conf('GM_OPENSEARCH_BOX') == '1' || gm_get_conf('GM_OPENSEARCH_SEARCH') == '1')
		{
			include_once(get_usermod(DIR_FS_CATALOG.'gm/javascript/GMAskOpensearch.js'));
		}

		if(gm_get_conf('GM_SHOW_FLYOVER') == '1')
		{
			include_once(get_usermod(DIR_FS_CATALOG.'gm/javascript/GMMegaFlyOver.js'));
		}

		if(gm_get_conf('GM_STATUSBAR_ACTIVE') == 'true')
		{
			include_once(get_usermod(DIR_FS_CATALOG.'gm/javascript/gm_statusbar.js.php'));
		}		
	}
}
?>