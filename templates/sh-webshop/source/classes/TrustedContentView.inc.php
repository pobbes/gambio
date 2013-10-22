<?php
/* --------------------------------------------------------------
   TrustedContentView.inc.php 2010-09-24 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(add_a_quickie.php,v 1.10 2001/12/19); www.oscommerce.com
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: add_a_quickie.php,v 1.1 2004/04/26 20:26:42 fanta2k Exp $)

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contribution:
   Add A Quickie v1.0 Autor  Harald Ponce de Leon

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class TrustedContentView extends ContentView
{
	function TrustedContentView()
	{
		$this->set_content_template('boxes/box_trusted.html');
	}

	function get_html()
	{
		$t_html_output = '';

		if(gm_get_conf('TRUSTED_SHOP_ID') != '' || $_SESSION['style_edit_mode'] == 'edit')
		{
			$t_html_output = $this->build_html();
		}
		
		return $t_html_output;
	}
}

?>