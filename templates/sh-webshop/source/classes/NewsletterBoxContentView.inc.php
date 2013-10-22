<?php
/* --------------------------------------------------------------
   NewsletterContentView.inc.php 2012-06-26 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

$Id: newsletter.php,v 1.0

   XTC-NEWSLETTER_RECIPIENTS RC1 - Contribution for XT-Commerce http://www.xt-commerce.com
   by Matthias Hinsche http://www.gamesempire.de

   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com 
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce www.oscommerce.com
   (c) 2003	 nextcommerce www.nextcommerce.org

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

require_once(DIR_FS_INC . 'xtc_image_submit.inc.php');
require_once(DIR_FS_INC . 'xtc_draw_password_field.inc.php');

class NewsletterBoxContentView extends ContentView
{
	function NewsletterBoxContentView()
	{
		$this->set_content_template('boxes/box_newsletter.html');
	}

	function get_html()
	{
		$this->set_content_data('FORM_ACTION', xtc_draw_form('sign_in', xtc_href_link(FILENAME_NEWSLETTER, '', 'NONSSL', true, true, true)), 1);
		$this->set_content_data('FORM_ID', 'sign_in');
		$this->set_content_data('FORM_METHOD', 'post');
		$this->set_content_data('FORM_ACTION_URL', xtc_href_link(FILENAME_NEWSLETTER, '', 'NONSSL', true, true, true));
		$this->set_content_data('FIELD_EMAIL', xtc_draw_input_field('email', '', 'size="14" maxlength="50"'), 1);
		$this->set_content_data('INPUT_NAME', 'email');
		$this->set_content_data('BUTTON', xtc_image_submit('button_login_small.gif', IMAGE_BUTTON_LOGIN), 1);
		$this->set_content_data('FORM_END', '</form>', 1);

		$t_html_output = $this->build_html();

		return $t_html_output;
	}
}

?>