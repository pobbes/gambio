<?php
/* --------------------------------------------------------------
   AddAQuickieContentView.inc.php 2012-06-26 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(add_a_quickie.php,v 1.10 2001/12/19); www.oscommerce.com
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: add_a_quickie.php 1262 2005-09-30 10:00:32Z mz $)

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contribution:
   Add A Quickie v1.0 Autor  Harald Ponce de Leon

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class AddAQuickieContentView extends ContentView
{
	function AddAQuickieContentView()
	{
		$this->set_content_template('boxes/box_add_a_quickie.html');
		$this->set_caching_enabled(false);
	}

	function get_html()
	{
		$this->set_content_data('FORM_ACTION', '<form id="quick_add" method="post" action="' . xtc_href_link(basename(gm_get_env_info('PHP_SELF')), xtc_get_all_get_params(array('action')) . 'action=add_a_quickie', 'NONSSL', true, true, true) . '">', 1);
		$this->set_content_data('FORM_ID', 'quick_add');
		$this->set_content_data('FORM_METHOD', 'post');
		$this->set_content_data('FORM_ACTION_URL', xtc_href_link(basename(gm_get_env_info('PHP_SELF')), xtc_get_all_get_params(array('action')) . 'action=add_a_quickie', 'NONSSL', true, true, true));
		$this->set_content_data('FIELD_EMAIL', xtc_draw_input_field('quickie','','size="20"'), 1);
		$this->set_content_data('INPUT_NAME', 'quickie');
		$this->set_content_data('BUTTON', xtc_image_submit('button_add_quick.gif', BOX_HEADING_ADD_PRODUCT_ID), 1);
		$this->set_content_data('FORM_END', '</form>');

		$t_html_output = $this->build_html();

		return $t_html_output;
	}
}

?>