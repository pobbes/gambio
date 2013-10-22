<?php
/* --------------------------------------------------------------
   LoginContentView.inc.php 2010-09-23 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommercebased on original files from OSCommerce CVS 2.2 2002/08/28 02:14:35 www.oscommerce.com
   (c) 2003	 nextcommerce (loginbox.php,v 1.10 2003/08/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: loginbox.php 1262 2005-09-30 10:00:32Z mz $)

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   Loginbox V1.0        	Aubrey Kilian <aubrey@mycon.co.za>

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class LoginboxContentView extends ContentView
{
	function LoginboxContentView()
	{
		$this->set_content_template('boxes/box_login.html');
	}

	function get_html()
	{
		$t_html_output = '';

		if(!xtc_session_is_registered('customer_id') || $_SESSION['style_edit_mode'] == 'edit')
		{
			$this->set_content_data('FORM_ACTION', '<form id="loginbox" method="post" action="' . xtc_href_link(FILENAME_LOGIN, 'action=process', 'SSL').'">', 1);
			$this->set_content_data('FORM_ID', 'loginbox');
			$this->set_content_data('FORM_METHOD', 'post');
			$this->set_content_data('FORM_ACTION_URL', xtc_href_link(FILENAME_LOGIN, 'action=process', 'SSL'));
			$this->set_content_data('FIELD_EMAIL', xtc_draw_input_field('email_address', '', 'size="14" maxlength="50"'));
			$this->set_content_data('FIELD_EMAIL_NAME', 'email_address');
			$this->set_content_data('FIELD_PWD', xtc_draw_password_field('password', '', 'size="14" maxlength="30"'), 1);
			$this->set_content_data('FIELD_PWD_NAME', 'password');
			$this->set_content_data('BUTTON', xtc_image_submit('button_login_small.gif', IMAGE_BUTTON_LOGIN), 1);
			$this->set_content_data('LINK_CREATE_ACCOUNT', xtc_href_link(FILENAME_LOGIN, '', 'SSL'));
			$this->set_content_data('LINK_LOST_PASSWORD', xtc_href_link(FILENAME_PASSWORD_DOUBLE_OPT, '', 'SSL'));
			$this->set_content_data('FORM_END', '</form>', 1);

			$t_html_output = $this->build_html();
		}

		return $t_html_output;
	}
}

?>