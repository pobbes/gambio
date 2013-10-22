/* LiveSearchHandler.js <?php
#   --------------------------------------------------------------
#   LiveSearchHandler.js 2012-02-08 gm
#   Gambio GmbH
#   http://www.gambio.de
#   Copyright (c) 2012 Gambio GmbH
#   Released under the GNU General Public License (Version 2)
#   [http://www.gnu.org/licenses/gpl-2.0.html]
#   --------------------------------------------------------------
?>*/
/*<?php
if($GLOBALS['coo_debugger']->is_enabled('uncompressed_js') == false)
{
?>*/
eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('8 w(){4(x)y.z(\'w 14\');9 j=7,r=15();7.A=8(){4(x)y.z(\'w A\');4($(\'#3\').B>0){$(\'.C\').16(\'<L 17="5" D="M:N"></L>\');9 d=o($(\'#3\').O().n),E=0;4(s($(\'#3\').1(\'P\'))!=\'t\'){E=o($(\'#3\').1(\'P\').u(\'p\',\'\'))}9 e=0;4(s($(\'#3\').1(\'k-n-v\'))!=\'t\'){e=o($(\'#3\').1(\'k-n-v\').u(\'p\',\'\'))}9 f=0;4(s($(\'#3\').1(\'l-n\'))!=\'t\'){f=o($(\'#3\').1(\'l-n\').u(\'p\',\'\'))}9 g=0;4(s($(\'#3\').1(\'l-Q\'))!=\'t\'){g=o($(\'#3\').1(\'l-Q\').u(\'p\',\'\'))}9 h=d+E+e+f+g;$(\'#5\').1({m:$(\'#3\').O().m,n:h+\'p\'});$(\'#5\').1(\'k-R\',$(\'#3\').1(\'k-m-R\'));$(\'#5\').1(\'k-D\',$(\'#3\').1(\'k-m-D\'));$(\'#5\').1(\'k-v\',$(\'#3\').1(\'k-m-v\'));$(\'#5\').1(\'l-m\',$(\'#3\').1(\'l-m\'));$(\'#5\').1(\'l-S\',$(\'#3\').1(\'l-S\'));$(\'#5 18 19\').F(\'G\',8(){1a.1b.T=$(7).1c(\'a\').U(\'T\');1d V});$(\'#3\').F(\'W\',8(b){4(x)y.z(\'3 W\');9 c=1e($(\'#3\').U(\'1f\'));4(c.B>2){1g.1h({1i:\'\',1j:\'1k.1l?1m=1n&1o=\'+c+\'&1p=\'+1q,1r:"1s",1t:X,1u:8(a){4(a!=\'\'){j.Y(a)}H{j.q()}}}).I}H{j.q()}});$(\'.C\').1v(\'G\',j.q);$(\'.C\').F(\'G\',j.q)}};7.q=8(){$(\'#5\').I(\'\');$(\'#5\').1w();4(Z.10.11(/12 [0-6]\\./)){j.J(V)}};7.Y=8(a){4(Z.10.11(/12 [0-6]\\./)){j.J(X)}$(\'#5\').I(a);$(\'#5\').1x()};7.J=8(a){4(a){$(\'1y\').1z(8(){4($(7).1(\'K\')!=\'13\'&&$(7).1(\'M\')!=\'N\'){r.1A(7);$(7).1({K:\'13\'})}})}H{1B(9 i=0;i<r.B;i++){$(r[i]).1({K:\'1C\'})}}};7.A()}',62,101,'|css||search_field|if|live_search_container||this|function|var|||||||||||border|padding|left|top|Number|px|hide_result|t_ie6_elements_array|typeof|undefined|replace|width|LiveSearchHandler|fb|console|log|init_binds|length|wrap_shop|style|t_height|live|click|else|html|ie6_fix|visibility|div|display|none|offset|height|bottom|color|right|href|attr|false|keyup|true|show_result|navigator|appVersion|match|MSIE|hidden|ready|Array|prepend|id|ul|li|window|location|find|return|encodeURIComponent|value|jQuery|ajax|data|url|request_port|php|module|live_search|needle|XTCsid|gm_session_id|type|POST|async|success|die|hide|show|select|each|push|for|visible'.split('|'),0,{}));
/*<?php
}
else
{
?>*/
function LiveSearchHandler()
{
	if(fb)console.log('LiveSearchHandler ready');

	var coo_this = this;
	var t_ie6_elements_array = Array();

	this.init_binds = function()
	{
		if(fb)console.log('LiveSearchHandler init_binds');

		if($('#search_field').length > 0)
		{
			$('.wrap_shop').prepend('<div id="live_search_container" style="display:none"></div>');

			var t_offset_top = Number($('#search_field').offset().top);
			var t_height = 0;
			if(typeof($('#search_field').css('height')) != 'undefined')
			{
				t_height = Number($('#search_field').css('height').replace('px', ''));
			}
			var t_border_top_width = 0;
			if(typeof($('#search_field').css('border-top-width')) != 'undefined')
			{
				t_border_top_width = Number($('#search_field').css('border-top-width').replace('px', ''));
			}
			var t_padding_top = 0;
			if(typeof($('#search_field').css('padding-top')) != 'undefined')
			{
				t_padding_top = Number($('#search_field').css('padding-top').replace('px', ''));
			}
			var t_padding_bottom = 0;
			if(typeof($('#search_field').css('padding-bottom')) != 'undefined')
			{
				t_padding_bottom = Number($('#search_field').css('padding-bottom').replace('px', ''));
			}

			var t_top = t_offset_top +
						t_height +
						t_border_top_width +
						t_padding_top +
						t_padding_bottom;

			$('#live_search_container').css(
			{
				left:			$('#search_field').offset().left,
				top:			t_top + 'px'
			});

			$('#live_search_container').css('border-color', $('#search_field').css('border-left-color'));
			$('#live_search_container').css('border-style', $('#search_field').css('border-left-style'));
			$('#live_search_container').css('border-width', $('#search_field').css('border-left-width'));
			$('#live_search_container').css('padding-left', $('#search_field').css('padding-left'));
			$('#live_search_container').css('padding-right', $('#search_field').css('padding-right'));

			// IE-Fix:
			$('#live_search_container ul li').live('click', function()
			{
				window.location.href = $(this).find('a').attr('href');

				return false;
			});

			$('#search_field').live('keyup', function(event)
			{
				if(fb)console.log('search_field keyup');

				var t_needle = encodeURIComponent( $('#search_field').attr('value') );

				if(t_needle.length > 2)
				{
					jQuery.ajax(
					{
						data:		'',
						url: 		'request_port.php?module=live_search&needle=' + t_needle + '&XTCsid=' + gm_session_id,
						type: 		"POST",
						async:		true,
						success:	function(t_search_result_html)
						{
							if(t_search_result_html != '')
							{
								coo_this.show_result(t_search_result_html);
							}
							else
							{
								coo_this.hide_result();
							}
						}
					}).html;
				}
				else
				{
					coo_this.hide_result();
				}
			});

			$('.wrap_shop').die('click', coo_this.hide_result);
			$('.wrap_shop').live('click', coo_this.hide_result);

		}
	}

	this.hide_result = function()
	{
		$('#live_search_container').html('');
		$('#live_search_container').hide();
		if(navigator.appVersion.match(/MSIE [0-6]\./))
		{
			coo_this.ie6_fix(false);
		}
	}

	this.show_result = function(p_html_content)
	{
		if(navigator.appVersion.match(/MSIE [0-6]\./))
		{
			coo_this.ie6_fix(true);
		}

		$('#live_search_container').html(p_html_content);
		$('#live_search_container').show();		
	}

	this.ie6_fix = function(p_hide)
	{
		if(p_hide)
		{
			$('select').each(function()
			{
				if($(this).css('visibility') != 'hidden' && $(this).css('display') != 'none')
				{
					t_ie6_elements_array.push(this);
					$(this).css(
					{
						visibility: 'hidden'
					});
				}
			});
		}
		else
		{
			for(var i = 0; i < t_ie6_elements_array.length; i++)
			{
				$(t_ie6_elements_array[i]).css(
				{
					visibility: 'visible'
				});
			}
		}
	}

	this.init_binds();
}
/*<?php
}
?>*/

