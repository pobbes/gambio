<?php
/* --------------------------------------------------------------
   NewsletterContentView.inc.php 2010-10-07 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

$Id: newsletter.php,v 1.0

   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com 
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce www.oscommerce.com
   (c) 2003	 nextcommerce www.nextcommerce.org

   XTC-NEWSLETTER_RECIPIENTS RC1 - Contribution for XT-Commerce http://www.xt-commerce.com
   by Matthias Hinsche http://www.gamesempire.de

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class NewsletterContentView extends ContentView
{
	function NewsletterContentView()
	{
		$this->set_content_template('module/newsletter.html');
		$this->set_flat_assigns(true);
	}
	
	function get_html()
	{


		$this->set_content_data('1', 1);

		$t_html_output = $this->build_html();		

		return $t_html_output;
	}
}
?>