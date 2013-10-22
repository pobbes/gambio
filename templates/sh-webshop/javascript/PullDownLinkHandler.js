/* PullDownLinkHandler.js <?php
#   --------------------------------------------------------------
#   PullDownLinkHandler.js 2011-02-09 gambio
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
eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('3 r(){1(8)9.h(\'r O\');5 d=s();5 e=s();5 f=2;5 g=k;2.w=3(){1(8)9.h(\'r w\');$(\'.x\').i(\'4\');$(\'.x\').l(\'4\',3(){1(8)9.h(\'.x 4\');f.E(2);P t})};2.E=3(a){5 b=$(a).6(\'m\');1($(b).n(\'Q\')==\'R\'){1($(a).F(\'G[u]\').6(\'u\').y>0){$(\'#\'+$(a).F(\'G[u]\').6(\'u\')+\' a\').S(3(){1($(2).6(\'m\').y>0){1(7(d[$(2).6(\'m\')])==\'o\'){j(d[$(2).6(\'m\')])}$($(2).6(\'m\')).p()}})}5 c=v($(a).H().z)+v($(a).T())+v($(a).n(\'I-z\').J(\'A\',\'\'))+v($(a).n(\'I-U\').J(\'A\',\'\'));$(b).n(\'K\',$(a).H().K).n(\'z\',c+\'A\').V();1($(a).W(\'X\')==t&&7(Y)==\'L\'){d[b]=M("$(\'"+b+"\').p()",N)}}Z{1(7(d[b])==\'o\'){j(d[b])}$(b).p()}$(b).i(\'4\');$(b).l(\'4\',3(){g=t;e[b]=k;1(7(d[b])==\'o\'){j(d[b])}});$(b).i(\'B\');$(b).l(\'B\',3(){1(8)9.h(b+\': B\');g=t;1(7(d[b])==\'o\'){j(d[b])}});$(b).i(\'C\');$(b).l(\'C\',3(){1(8)9.h(b+\': C\');g=k;1(7(d[b])==\'o\'&&7(e[b])==\'L\'){j(d[b]);d[b]=M("$(\'"+b+"\').p()",N)}});$(\'.D\').i(\'4\',f.q);$(\'.D\').l(\'4\',f.q)};2.q=3(){1(8)9.h(\'r q 10: \'+g);5 a=\'\';11(a 12 d){j(d[a]);1($(a).y>0&&g==k){$(a).p()}}1(g==k){d=s();e=s();$(\'.D\').i(\'4\',2.q)}};2.w()}',62,65,'|if|this|function|click|var|attr|typeof|fb|console||||||||log|die|clearTimeout|true|live|rel|css|number|slideUp|close_all|PullDownLinkHandler|Object|false|id|Number|init_binds|pulldown_link|length|top|px|mouseenter|mouseleave|wrap_shop|start|closest|div|offset|padding|replace|left|undefined|setTimeout|3000|ready|return|display|none|each|height|bottom|slideDown|hasClass|pulldown_link_no_auto_close|gm_style_edit_mode_running|else|allowed|for|in'.split('|'),0,{}));
/*<?php
}
else
{
?>*/
function PullDownLinkHandler()
{
	if(fb)console.log('PullDownLinkHandler ready');

	var coo_clicked_ids = Object();
	var coo_clicked_elements = Object();
	var coo_this = this;
	var t_allow_close_all = true;

	this.init_binds = function()
	{
		if(fb)console.log('PullDownLinkHandler init_binds');

		$('.pulldown_link').die('click');
		$('.pulldown_link').live('click', function()
		{
			if(fb)console.log('.pulldown_link click');

			coo_this.start(this);

			return false;
		});
	}

	this.start = function(p_element)
	{
		var t_container = $(p_element).attr('rel');

		// open menu
		if($(t_container).css('display') == 'none'){
			// hide opened dropdowns belonging to the div-container where the clicked link is placed in
			if($(p_element).closest('div[id]').attr('id').length > 0)
			{
				$('#' + $(p_element).closest('div[id]').attr('id') + ' a').each(function()
				{
					if($(this).attr('rel').length > 0)
					{
						if(typeof(coo_clicked_ids[$(this).attr('rel')]) == 'number')
						{
							clearTimeout(coo_clicked_ids[$(this).attr('rel')]);
						}
						$($(this).attr('rel')).slideUp();
					}
				});
			}

			var t_top = Number($(p_element).offset().top) +
						Number($(p_element).height()) +
						Number($(p_element).css('padding-top').replace('px', '')) +
						Number($(p_element).css('padding-bottom').replace('px', ''));
			$(t_container).css('left', $(p_element).offset().left).css('top', t_top + 'px').slideDown();

			if($(p_element).hasClass('pulldown_link_no_auto_close') == false && typeof(gm_style_edit_mode_running) == 'undefined')
			{
				coo_clicked_ids[t_container] = setTimeout("$('" + t_container + "').slideUp()", 3000);
			}
		}
		// close menu
		else
		{
			if(typeof(coo_clicked_ids[t_container]) == 'number')
			{
				clearTimeout(coo_clicked_ids[t_container]);
			}
			$(t_container).slideUp();
		}

		// stop menu sliding up by clicking into it
		$(t_container).die('click');
		$(t_container).live('click', function()
		{
			t_allow_close_all = false;

			coo_clicked_elements[t_container] = true;

			if(typeof(coo_clicked_ids[t_container]) == 'number')
			{
				clearTimeout(coo_clicked_ids[t_container]);
			}
		});

		// stop menu sliding up on mouseenter
		$(t_container).die('mouseenter');
		$(t_container).live('mouseenter', function()
		{
			if(fb)console.log(t_container + ': mouseenter');

			t_allow_close_all = false;

			if(typeof(coo_clicked_ids[t_container]) == 'number')
			{
				clearTimeout(coo_clicked_ids[t_container]);
			}
		});

		// start timeout for sliding up menu
		$(t_container).die('mouseleave');
		$(t_container).live('mouseleave', function()
		{
			if(fb)console.log(t_container + ': mouseleave');

			t_allow_close_all = true;

			if(typeof(coo_clicked_ids[t_container]) == 'number' && typeof(coo_clicked_elements[t_container]) == 'undefined')
			{
				clearTimeout(coo_clicked_ids[t_container]);
				coo_clicked_ids[t_container] = setTimeout("$('" + t_container + "').slideUp()", 3000);
			}
		});

		$('.wrap_shop').die('click', coo_this.close_all);
		$('.wrap_shop').live('click', coo_this.close_all);
	}

	this.close_all = function()
	{
		if(fb)console.log('PullDownLinkHandler close_all allowed: ' + t_allow_close_all);

		var t_element = '';

		for(t_element in coo_clicked_ids)
		{
			clearTimeout(coo_clicked_ids[t_element]);
			if($(t_element).length > 0 && t_allow_close_all == true)
			{
				$(t_element).slideUp();
			}
		}

		// reset
		if(t_allow_close_all == true)
		{
			coo_clicked_ids = Object();
			coo_clicked_elements = Object();
			$('.wrap_shop').die('click', this.close_all);
		}
	}

	this.init_binds();
}
/*<?php
}
?>*/

