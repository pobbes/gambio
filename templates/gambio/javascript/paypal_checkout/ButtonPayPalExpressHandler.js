/* ButtonPayPalExpressHandler.js <?php
#   --------------------------------------------------------------
#   ButtonPayPalExpressHandler.js 2012-06-21 gm
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
function ButtonPayPalExpressHandler(){if(fb)console.log('ButtonPayPalExpressHandler ready');var coo_this=this;this.init_binds=function(){if(fb)console.log('ButtonPayPalExpressHandler init_binds');$('.paypal_action_submit').die('click');$('.paypal_action_submit').live('click',function(){if(fb)console.log('.paypal_action_submit click');var t_error='',t_check=true;$('.accept_box_checkbox').each(function(){if($(this).attr('type')=='checkbox'){if($(this).attr('checked')!=true){if($(this).attr('name')=='withdrawal'){t_error=t_error+'<?php echo JS_ERROR_CONDITIONS_NOT_ACCEPTED_AGB; ?>'}else if($(this).attr('name')=='conditions'){t_error=t_error+'<?php echo JS_ERROR_CONDITIONS_NOT_ACCEPTED_WITHDRAWAL; ?>'}t_check=false}}});if(t_check==false){alert(t_error);return false}if($('#checkout_confirmation').length>0){if($(this).hasClass('replace_form_action')){if(fb)console.log('replace_form_action found!');var t_new_action_url=$(this).attr('href');if($('#checkout_confirmation').length>0){$('#checkout_confirmation').attr('action',t_new_action_url)}}if(typeof($('#checkout_confirmation').attr('onsubmit'))=='string'){if(fb)console.log('found onsubmit in form-tag!');var t_onsubmit=$('#checkout_confirmation').attr('onsubmit').replace('return ',''),t_onsubmit_return=eval(t_onsubmit);if(fb)console.log('onsubmit evaluated');if(t_onsubmit_return==false){if(fb)console.log('onsubmit returns: false');return false}else if(t_onsubmit_return==true){if(fb)console.log('onsubmit returns: true')}}$('#checkout_confirmation').submit()}else{if(fb)console.log('no form found!')}return false});if($('.checkout_paypal').length>0){$('.button_checkout_module').die('click',coo_this.submit_form);$('.button_checkout_module').live('click',coo_this.submit_form)}};this.submit_form=function(){if(fb)console.log('.button_checkout_module click to submit');$('.button_checkout_module').removeClass('module_option_checked');$('.button_checkout_module input[type=radio]:checked').attr('checked',false);$(this).find('input[type=radio]').attr('checked',true);$(this).addClass('module_option_checked');$(this).closest('form').submit();return false};this.init_binds()}
/*<?php
}
else
{
?>*/
function ButtonPayPalExpressHandler()
{
	if(fb)console.log('ButtonPayPalExpressHandler ready');

	var coo_this = this;

	this.init_binds = function()
	{
		if(fb)console.log('ButtonPayPalExpressHandler init_binds');

		$('.paypal_action_submit').die('click');
		$('.paypal_action_submit').live('click', function()
		{
			if(fb)console.log('.paypal_action_submit click');

			var t_error = '';
			var t_check = true;
			$('.accept_box_checkbox').each(function()
			{
				if($(this).attr('type') == 'checkbox')
				{
					if($(this).attr('checked') != true)
					{
						if($(this).attr('name') == 'withdrawal')
						{
							t_error = t_error + '<?php echo JS_ERROR_CONDITIONS_NOT_ACCEPTED_AGB; ?>';
						}
						else if($(this).attr('name') == 'conditions')
						{
							t_error = t_error + '<?php echo JS_ERROR_CONDITIONS_NOT_ACCEPTED_WITHDRAWAL; ?>';
						}

						t_check = false;
					}
				}
			});

			if(t_check == false)
			{
				alert(t_error);
				return false;
			}

			if($('#checkout_confirmation').length > 0)
			{
				if($(this).hasClass('replace_form_action'))
				{
					if(fb)console.log('replace_form_action found!');
					// submit button needs own action url
					var t_new_action_url = $(this).attr('href');
					if($('#checkout_confirmation').length > 0)
					{
						$('#checkout_confirmation').attr('action', t_new_action_url);
					}
				}

				// TODO: better solution for executing onsubmit functions
				//       and regarding return value -> stop submit in false-case
				if(typeof($('#checkout_confirmation').attr('onsubmit')) == 'string')
				{
					if(fb)console.log('found onsubmit in form-tag!');

					var t_onsubmit = $('#checkout_confirmation').attr('onsubmit').replace('return ', '');
					var t_onsubmit_return = eval(t_onsubmit);

					if(fb)console.log('onsubmit evaluated');

					if(t_onsubmit_return == false)
					{
						if(fb)console.log('onsubmit returns: false');

						return false;
					}
					else if(t_onsubmit_return == true)
					{
						if(fb)console.log('onsubmit returns: true');
					}

				}

				// submit form
				$('#checkout_confirmation').submit();
			}
			else
			{
				if(fb)console.log('no form found!');
			}

			return false;
		});

		if($('.checkout_paypal').length > 0)
		{
			$('.button_checkout_module').die('click', coo_this.submit_form);
			$('.button_checkout_module').live('click', coo_this.submit_form);
		}
	}

	this.submit_form = function()
	{
		if(fb)console.log('.button_checkout_module click to submit');

		$('.button_checkout_module').removeClass('module_option_checked');
		$('.button_checkout_module input[type=radio]:checked').attr('checked', false);
		$(this).find('input[type=radio]').attr('checked', true);
		$(this).addClass('module_option_checked');

		$(this).closest('form').submit();

		return false;
	}

	this.init_binds();
}
/*<?php
}
?>*/
$(document).ready(function()
{
	var coo_button_paypal_express_handler = new ButtonPayPalExpressHandler();
});

