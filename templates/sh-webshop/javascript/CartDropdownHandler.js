/* CartDropdownHandler.js <?php
#   --------------------------------------------------------------
#   CartDropdownHandler.js 2011-05-18 gambio
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
function CartDropdownHandler(){if(fb)console.log('CartDropdownHandler ready');this.init_binds=function(){if(fb)console.log('CartDropdownHandler init_binds');$('#head_shopping_cart').die('click');$('#head_shopping_cart').live('click',function(){if(fb)console.log('#head_shopping_cart click');if($(this).hasClass('active')==false){coo_cart_control.position_dropdown();coo_cart_control.open_dropdown();setTimeout(coo_cart_control.close_dropdown,10000);}else{coo_cart_control.close_dropdown();}return true;});};this.init_binds();}
/*<?php
}
else
{
?>*/
function CartDropdownHandler()
{
	if(fb)console.log('CartDropdownHandler ready');

	this.init_binds = function()
	{
		if(fb)console.log('CartDropdownHandler init_binds');

		//var coo_this = this;

		$('#head_shopping_cart').die('click');
		$('#head_shopping_cart').live('click', function()
		{
			if(fb)console.log('#head_shopping_cart click');

			if($(this).hasClass('active') == false)
			{
				coo_cart_control.position_dropdown();
				coo_cart_control.open_dropdown();
				setTimeout(coo_cart_control.close_dropdown, 10000);
			}
			else
			{
				coo_cart_control.close_dropdown()
			}
			return true;
		});

	}

	this.init_binds();
}
/*<?php
}
?>*/

