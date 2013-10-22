<?php
/* --------------------------------------------------------------
   JSAccountExtender.inc.php 2012-01-19 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

class JSAccountExtender extends JSAccountExtender_parent
{
	function proceed()
	{
		parent::proceed();
		
		if(gm_get_env_info('TEMPLATE_VERSION') >= FIRST_GX2_TEMPLATE_VERSION)
		{
			include_once(get_usermod(DIR_FS_CATALOG . 'templates/'.CURRENT_TEMPLATE.'/javascript/FormHighlighterHandler.js'));

			if(gm_get_conf('GM_LIGHTBOX_CREATE_ACCOUNT') == 'true')
			{
				include_once(get_usermod(DIR_FS_CATALOG . 'templates/'.CURRENT_TEMPLATE.'/javascript/ShowLightBox.js'));
			}
		}
		elseif(gm_get_conf('GM_LIGHTBOX_CREATE_ACCOUNT') == 'true')
		{
			include_once(get_usermod(DIR_FS_CATALOG . 'gm/javascript/GMShowLightBox.js'));
		}		
	}
}
?>