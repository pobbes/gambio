<?php
/* --------------------------------------------------------------
   GraduatedPricesContentView.inc.php 2010-11-18 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommercebased on original files from OSCommerce CVS 2.2 2002/08/28 02:14:35 www.oscommerce.com
   (c) 2003	 nextcommerce (graduated_prices.php,v 1.11 2003/08/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: graduated_prices.php 1243 2005-09-25 09:33:02Z mz $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class GraduatedPricesContentView extends ContentView
{
	function GraduatedPricesContentView()
	{
		$this->set_content_template('module/graduated_price.html');
		$this->set_flat_assigns(true);
	}
	
	function get_html($p_coo_product)
	{
		$t_html_output = '';
		$t_graduated_prices_array = array();

		$t_graduated_prices_array = $p_coo_product->getGraduated();

		if(count($t_graduated_prices_array) > 1 && $_SESSION['customers_status']['customers_status_graduated_prices'] == 1)
		{
			if(PRODUCT_IMAGE_INFO_WIDTH < (190 - 16))
			{
				$this->set_content_data('GRADUATED_BOX_WIDTH', 190+16, 1);
			}
			else
			{
				$this->set_content_data('GRADUATED_BOX_WIDTH', PRODUCT_IMAGE_INFO_WIDTH+16+2, 1);
			}

			$this->set_content_data('module_content', $t_graduated_prices_array);

			$t_html_output = $this->build_html();
		}
		
		return $t_html_output;
	}
	
}
?>