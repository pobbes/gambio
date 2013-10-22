
<?php
/* --------------------------------------------------------------
   JSProductInfoExtender.inc.php 2012-01-19 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

class JSProductInfoExtender extends JSProductInfoExtender_parent
{
	function proceed()
	{
		parent::proceed();
		
		include_once(get_usermod(DIR_FS_CATALOG . 'gm/javascript/jquery/ui/jquery-ui-1.8.11.custom.min.js'));
		include_once(get_usermod(DIR_FS_CATALOG . 'gm/javascript/GMOrderQuantityChecker.js'));
		include_once(get_usermod(DIR_FS_CATALOG . 'gm/javascript/GMAttributesCalculator.js'));
		include_once(get_usermod(DIR_FS_CATALOG . 'gm/javascript/GMAttributeImages.js'));
		include_once(get_usermod(DIR_FS_CATALOG . 'gm/javascript/gm_product_details.js'));

		if(gm_get_env_info('TEMPLATE_VERSION') >= FIRST_GX2_TEMPLATE_VERSION)
		{
			include_once(get_usermod(DIR_FS_CATALOG . 'templates/'.CURRENT_TEMPLATE.'/javascript/attributes_dropdown_mode.js'));
			include_once(get_usermod(DIR_FS_CATALOG . 'templates/'.CURRENT_TEMPLATE.'/javascript/product_info/ButtonProductImagesHandler.js'));
			include_once(get_usermod(DIR_FS_CATALOG . 'templates/'.CURRENT_TEMPLATE.'/javascript/product_info/ButtonDetailsAddCartHandler.js'));
			include_once(get_usermod(DIR_FS_CATALOG . 'templates/'.CURRENT_TEMPLATE.'/javascript/QuantityInputResizeHandler.js'));
			include_once(get_usermod(DIR_FS_CATALOG . 'gm/properties/javascript/Properties/CombiStatusCheck.js'));
			include_once(get_usermod(DIR_FS_CATALOG . 'gm/properties/javascript/SelectionFormListener/DropdownsListener.js'));

			$coo_gm_gmotion = MainFactory::create_object('GMGMotion');
			if($coo_gm_gmotion->check_status($this->v_data_array['GET']['products_id']) == 1)
			{
				include_once(get_usermod(DIR_FS_CATALOG . 'gm/javascript/jquery/plugins/jquery.cross-slide.js'));
				include_once(get_usermod(DIR_FS_CATALOG . 'gm/javascript/GMGMotion.js'));
			}

			if(gm_get_conf('SHOW_ZOOM') == 'true')
			{
				include_once(get_usermod(DIR_FS_CATALOG . 'templates/'.CURRENT_TEMPLATE.'/javascript/zoom_plugin.js'));
			}

			if(gm_get_conf('GM_SHOW_WISHLIST') == 'true')
			{
				include_once(get_usermod(DIR_FS_CATALOG . 'templates/'.CURRENT_TEMPLATE.'/javascript/product_info/ButtonDetailsAddWishlistHandler.js'));
			}

			if(gm_get_conf('GM_TELL_A_FRIEND') == 'true')
			{
				include_once(get_usermod(DIR_FS_CATALOG . 'templates/'.CURRENT_TEMPLATE.'/javascript/product_info/ButtonTellAFriendHandler.js'));
				include_once(get_usermod(DIR_FS_CATALOG . 'templates/'.CURRENT_TEMPLATE.'/javascript/product_info/ButtonSendTellAFriendHandler.js'));
			}

			if(gm_get_conf('SHOW_BOOKMARKING') == 'true')
			{
				include_once(get_usermod(DIR_FS_CATALOG . 'templates/'.CURRENT_TEMPLATE.'/javascript/product_info/ButtonBookmarkHandler.js'));
			}
		}
		else
		{
			include_once(get_usermod(DIR_FS_CATALOG . 'gm/javascript/GMTellAFriend.js'));
		}

		$coo_product = MainFactory::create_object('product', array($this->v_data_array['GET']['products_id']));
		if(isset($coo_product->data['gm_show_price_offer']) && $coo_product->data['gm_show_price_offer'] > 0)
		{
			include_once(get_usermod(DIR_FS_CATALOG . 'gm/javascript/price_offer.js.php'));
		}		
	}
}
?>