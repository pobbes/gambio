/* ButtonCartRefreshHandler.js <?php
#   --------------------------------------------------------------
#   ButtonCartRefreshHandler.js 2013-02-22 gambio
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
eval(function(p,a,c,k,e,r){e=function(c){return c.toString(a)};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('1 8(){$(p).g(1(){0(2)3.4(\'8 g\');q.9()});h.9=1(){0(2)3.4(\'8 9\');$(\'.d\').r(\'e\');$(\'.d\').s(\'e\',1(a){0(2)3.4(\'.d e\');0($(h).t(\'i\')){0(2)3.4(\'-- i u\');v();f 5}j b=k l(),6=b.m();0(6==7){$(\'#n\').w("o",[7])}f 5});$(\'#n\').o(1(a,b){0(x b=="y")b=5;0(b!=7){j c=k l(),6=c.m();0(6!=7){f 5}}})}}',35,35,'if|function|fb|console|log|false|t_result|true|ButtonCartRefreshHandler|init_binds||||button_cart_refresh|click|return|ready|this|wishlist_button|var|new|GMOrderQuantityChecker|check_cart|cart_quantity|submit|document|coo_button_cart_refresh_handler|die|live|hasClass|found|update_wishlist|trigger|typeof|undefined'.split('|'),0,{}));
/*<?php
}
else
{
?>*/
function ButtonCartRefreshHandler()
{
	$(document).ready(
		function()
		{
			if(fb)console.log('ButtonCartRefreshHandler ready');

			coo_button_cart_refresh_handler.init_binds();
		}
	);


	this.init_binds = function()
	{
		if(fb)console.log('ButtonCartRefreshHandler init_binds');


		$('.button_cart_refresh').die('click');
		$('.button_cart_refresh').live('click', function(event)
		{
			if(fb)console.log('.button_cart_refresh click');

			if($(this).hasClass('wishlist_button'))
			{
				if(fb)console.log('-- wishlist_button found');
				update_wishlist();
				return false;
			}

            var coo_quantity_checker = new GMOrderQuantityChecker();
            var t_result = coo_quantity_checker.check_cart();

            if(t_result == true) {
				$('#cart_quantity').trigger( "submit", [true] );
            }

			return false;
		});

		$('#cart_quantity').submit(function( p_event, p_checked )
		{
			if( typeof p_checked == "undefined" ) p_checked = false;
			if( p_checked != true )
			{
				var coo_quantity_checker = new GMOrderQuantityChecker();
				var t_result = coo_quantity_checker.check_cart();
				
				if(t_result != true)
				{
					return false;
				}
			}
		});
	}
}
/*<?php
}
?>*/
