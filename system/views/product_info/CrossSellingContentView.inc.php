<?php
/* --------------------------------------------------------------
   CrossSellingContentView.inc.php 2010-10-01 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

(c) 2005 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: cross_selling.php 1243 2005-09-25 09:33:02Z mz $) 

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(also_purchased_products.php,v 1.21 2003/02/12); www.oscommerce.com
   (c) 2003	 nextcommerce (also_purchased_products.php,v 1.9 2003/08/17); www.nextcommerce.org
   ---------------------------------------------------------------------------------------*/

class CrossSellingContentView extends ContentView
{
	var $v_type = 'cross_selling';
	
	function CrossSellingContentView($p_type = 'cross_selling')
	{
		$this->set_type($p_type);

		switch($this->get_type())
		{
			case 'cross_selling':
				$this->set_content_template('module/cross_selling.html');

				break;
			case 'reverse_cross_selling':
				$this->set_content_template('module/reverse_cross_selling.html');

				break;
		}
		
		$this->set_flat_assigns(true);
	}
	
	function get_html($p_coo_product)
	{
		$t_html_output = '';

		switch($this->get_type())
		{
			case 'cross_selling':
				$t_data_array = $p_coo_product->getCrossSells();
				$this->set_content_data('GM_THUMBNAIL_WIDTH', PRODUCT_IMAGE_THUMBNAIL_WIDTH + 10);
				if(count($t_data_array) > 0)
				{
					$this->set_content_data('thumbnail_heigth', PRODUCT_IMAGE_THUMBNAIL_HEIGHT + 40);
					$this->set_content_data('TRUNCATE_PRODUCTS_NAME', gm_get_conf('TRUNCATE_PRODUCTS_NAME'));
					$this->set_content_data('module_content', $t_data_array);
					
					$t_html_output = $this->build_html();
				}

				break;
			case 'reverse_cross_selling':
				// reverse cross selling
				if(ACTIVATE_REVERSE_CROSS_SELLING=='true')
				{
					$this->set_content_data('GM_THUMBNAIL_WIDTH', PRODUCT_IMAGE_THUMBNAIL_WIDTH + 10);
					$t_data_array = $p_coo_product->getReverseCrossSells();

					if(count($t_data_array) > 0)
					{
						$this->set_content_data('TRUNCATE_PRODUCTS_NAME', gm_get_conf('TRUNCATE_PRODUCTS_NAME'));
						$this->set_content_data('module_content', $t_data_array);
						
						$t_html_output = $this->build_html();
					}
				}

				break;
		}

		return $t_html_output;
	}

	function set_type($p_type)
	{
		$this->v_type = $p_type;
	}

	function get_type()
	{
		return $this->v_type;
	}
}
?>