/* ButtonGVSendBackHandler.js <?php
#   --------------------------------------------------------------
#   ButtonGVSendBackHandler.js 2011-01-24 gambio
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
function ButtonGVSendBackHandler(){if(fb)console.log('ButtonGVSendBackHandler ready');this.init_binds=function(){if(fb)console.log('ButtonGVSendBackHandler init_binds');$('.button_gv_send_back').die('click');$('.button_gv_send_back').live('click',function(){if(fb)console.log('.button_gv_send_back click');if($('input[name="back_x"]').length==0){$(this).closest('form').append('<input type="hidden" name="back_x" value="1" />');}$(this).closest('form').submit();return false;});};this.init_binds();}
/*<?php
}
else
{
?>*/
function ButtonGVSendBackHandler()
{
	if(fb)console.log('ButtonGVSendBackHandler ready');

	this.init_binds = function()
	{
		if(fb)console.log('ButtonGVSendBackHandler init_binds');

		$('.button_gv_send_back').die('click');
		$('.button_gv_send_back').live('click', function()
		{
			if(fb)console.log('.button_gv_send_back click');

			if($('input[name="back_x"]').length == 0)
			{
				$(this).closest('form').append('<input type="hidden" name="back_x" value="1" />');
			}
			$(this).closest('form').submit();

			return false;
		});
	}

	this.init_binds();
}
/*<?php
}
?>*/
