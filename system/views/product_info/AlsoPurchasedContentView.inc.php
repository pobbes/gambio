<?php
/* --------------------------------------------------------------
   AlsoPurchasedContentView.inc.php 2010-10-01 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(also_purchased_products.php,v 1.21 2003/02/12); www.oscommerce.com
   (c) 2003	 nextcommerce (also_purchased_products.php,v 1.9 2003/08/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: also_purchased_products.php 1243 2005-09-25 09:33:02Z mz $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class AlsoPurchasedContentView extends ContentView
{
	function AlsoPurchasedContentView()
	{
		$this->set_content_template('module/also_purchased.html');
		$this->set_flat_assigns(true);
	}
	
	function get_html($p_coo_product)
	{
		$t_html_output = '';

		$t_data_array = $p_coo_product->getAlsoPurchased();
		if(count($t_data_array) >= MIN_DISPLAY_ALSO_PURCHASED && count($t_data_array) > 0)
		{
			$this->set_content_data('TRUNCATE_PRODUCTS_NAME', gm_get_conf('TRUNCATE_PRODUCTS_NAME'));
			$this->set_content_data('GM_THUMBNAIL_WIDTH', PRODUCT_IMAGE_THUMBNAIL_WIDTH + 10);
			$this->set_content_data('module_content', $t_data_array);

			$t_html_output = $this->build_html();
		}
		
		return $t_html_output;
	}
}
?>