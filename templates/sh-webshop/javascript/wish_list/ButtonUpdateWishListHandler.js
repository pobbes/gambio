/* ButtonUpdateWishListHandler.js <?php
#   --------------------------------------------------------------
#   ButtonUpdateWishListHandler.js 2011-01-24 gambio
#   Gambio GmbH
#   http://www.gambio.de
#   Copyright (c) 2011 Gambio GmbH
#   Released under the GNU General Public License (Version 2)
#   [http://www.gnu.org/licenses/gpl-2.0.html]
#   --------------------------------------------------------------
?>*/
/*<?php
if($GLOBALS['coo_debugger']->is_enabled('uncompressed_js') == false)
{
?>*/
function ButtonUpdateWishListHandler(){this.init_binds=function(){if(fb)console.log('ButtonUpdateWishListHandler init_binds');$('.button_update_wish_list').die('click');$('.button_update_wish_list').live('click',function(){if(fb)console.log('.button_update_wish_list click');document.cart_quantity.submit_target.value="wishlist";var t_target=document.cart_quantity.action;t_target=t_target.replace(/update_product/,"update_wishlist");document.cart_quantity.action=t_target;document.cart_quantity.submit();return false;});};this.init_binds();}
/*<?php
}
else
{
?>*/
function ButtonUpdateWishListHandler()
{
	this.init_binds = function()
	{
		if(fb)console.log('ButtonUpdateWishListHandler init_binds');

		$('.button_update_wish_list').die('click');
		$('.button_update_wish_list').live('click', function()
		{
			if(fb)console.log('.button_update_wish_list click');

			document.cart_quantity.submit_target.value = "wishlist";
			var t_target = document.cart_quantity.action;
			t_target = t_target.replace(/update_product/, "update_wishlist");
			document.cart_quantity.action = t_target;
			document.cart_quantity.submit();

			return false;
		});
	}

	this.init_binds();
}
/*<?php
}
?>*/
