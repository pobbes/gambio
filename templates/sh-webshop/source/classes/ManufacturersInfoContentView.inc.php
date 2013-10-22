<?php
/* --------------------------------------------------------------
   ManufacturersInfoContentView.inc.php 2010-09-22 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(manufacturer_info.php,v 1.10 2003/02/12); www.oscommerce.com
   (c) 2003	 nextcommerce (manufacturer_info.php,v 1.6 2003/08/13); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: manufacturer_info.php 1262 2005-09-30 10:00:32Z mz $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class ManufacturersInfoContentView extends ContentView
{
	function ManufacturersInfoContentView()
	{
		$this->set_content_template('boxes/box_manufacturers_info.html');
	}
	
	function get_html($p_coo_product)
	{
		$t_html_output = '';

		$t_result = xtDBquery("SELECT
									m.manufacturers_id,
									m.manufacturers_name,
									m.manufacturers_image,
									mi.manufacturers_url
								FROM
									" . TABLE_MANUFACTURERS . " m
									LEFT JOIN " . TABLE_MANUFACTURERS_INFO . " mi ON (m.manufacturers_id = mi.manufacturers_id AND mi.languages_id = '" . (int)$_SESSION['languages_id'] . "'),
									" . TABLE_PRODUCTS . " p
								WHERE
									p.products_id = '" . (int)$p_coo_product->data['products_id'] . "' AND
									p.manufacturers_id = m.manufacturers_id");
		if(xtc_db_num_rows($t_result,true))
		{
			$t_result_array = xtc_db_fetch_array($t_result,true);

			$t_image = '';
			if(xtc_not_null($t_result_array['manufacturers_image']))
			{
				$t_image=DIR_WS_IMAGES . $t_result_array['manufacturers_image'];
			}

			$this->set_content_data('IMAGE', $t_image);
			$this->set_content_data('NAME', $t_result_array['manufacturers_name']);

			if($t_result_array['manufacturers_url']!='')
			{
				$this->set_content_data('URL', '<a href="' . xtc_href_link(FILENAME_REDIRECT, 'action=manufacturer&' . xtc_manufacturer_link($t_result_array['manufacturers_id'], $t_result_array['manufacturers_name'])) . '" onclick="window.open(this.href); return false;">' . sprintf(BOX_MANUFACTURER_INFO_HOMEPAGE, $t_result_array['manufacturers_name']) . '</a>');
			}

			$this->set_content_data('LINK_MORE', '<a href="' . xtc_href_link(FILENAME_DEFAULT, xtc_manufacturer_link($t_result_array['manufacturers_id'], $t_result_array['manufacturers_name'])) . '">' . BOX_MANUFACTURER_INFO_OTHER_PRODUCTS . '</a>');


		}

		$t_html_output = $this->build_html();
		return $t_html_output;
	}
}
?>