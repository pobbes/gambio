/* TopNavigationHandler.js <?php
#   --------------------------------------------------------------
#   TopNavigationHandler.js 2011-03-09 gambio
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
function TopNavigationHandler(){if(fb)console.log('TopNavigationHandler ready');this.init_binds=function(){if(fb)console.log('TopNavigationHandler init_binds');var t_background_color_hover='transparent';$('#top_navi_inner ul li a').die('hover');$('#top_navi_inner ul li a').live('hover',function(){if($(this).css('background-color')!='transparent'){t_background_color_hover=$(this).css('background-color');}});$('#top_navi_inner ul li').die('mouseleave');$('#top_navi_inner ul li').live('mouseleave',function(){$('#top_navi_inner ul li a').removeAttr('style');});$('#top_navi_inner ul li div').die('mouseenter');$('#top_navi_inner ul li div').live('mouseenter',function(){if(t_background_color_hover!=''){$(this).next('a').css('background-color',t_background_color_hover);}});$('#top_navi_inner ul li div').die('click');$('#top_navi_inner ul li div').live('click',function(){if(typeof($(this).next('a').attr('rel'))=='undefined'||$(this).next('a').attr('rel').length==0){document.location.href=$(this).next('a').attr('href');return false;}else{$(this).next('a').trigger('click');}});};this.init_binds();}
/*<?php
}
else
{
?>*/
function TopNavigationHandler()
{
	if(fb)console.log('TopNavigationHandler ready');

	this.init_binds = function()
	{
		if(fb)console.log('TopNavigationHandler init_binds');

		var t_background_color_hover = 'transparent';

		$('#top_navi_inner ul li a').die('hover');
		$('#top_navi_inner ul li a').live('hover', function()
		{
			if($(this).css('background-color') != 'transparent')
			{
				t_background_color_hover = $(this).css('background-color');
			}
		});

		$('#top_navi_inner ul li').die('mouseleave');
		$('#top_navi_inner ul li').live('mouseleave', function()
		{
			$('#top_navi_inner ul li a').removeAttr('style');
		});

		$('#top_navi_inner ul li div').die('mouseenter');
		$('#top_navi_inner ul li div').live('mouseenter', function()
		{
			if(t_background_color_hover != '')
			{
				$(this).next('a').css('background-color', t_background_color_hover);
			}
		});

		$('#top_navi_inner ul li div').die('click');
		$('#top_navi_inner ul li div').live('click', function()
		{
			if(typeof($(this).next('a').attr('rel')) == 'undefined' || $(this).next('a').attr('rel').length == 0)
			{
				document.location.href = $(this).next('a').attr('href');
				return false;
			}
			else
			{
				// open pull down menu
				$(this).next('a').trigger('click');
			}
		});
	}

	this.init_binds();
}
/*<?php
}
?>*/