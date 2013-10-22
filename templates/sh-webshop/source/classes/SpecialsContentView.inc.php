<?php
/* --------------------------------------------------------------
   SpecialsContentView.inc.php 2010-09-24 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(specials.php,v 1.30 2003/02/10); www.oscommerce.com
   (c) 2003	 nextcommerce (specials.php,v 1.10 2003/08/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: specials.php 1292 2005-10-07 16:10:55Z mz $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

// include needed functions
require_once(DIR_FS_INC . 'xtc_random_select.inc.php');

class SpecialsContentView extends ContentView
{
	function SpecialsContentView()
	{
		$this->set_content_template('boxes/box_specials.html');
		$this->set_caching_enabled(false);
	}

	function get_html($p_coo_product)
	{
		$t_html_output = '';

		//fsk18 lock
		$t_fsk_lock = '';
		if($_SESSION['customers_status']['customers_fsk18_display'] == '0')
		{
			$t_fsk_lock = ' AND p.products_fsk18 != 1';
		}
		if(GROUP_CHECK == 'true')
		{
			$t_group_check = " AND p.group_permission_".$_SESSION['customers_status']['customers_status_id']." = 1 ";
		}

		$t_result = xtc_random_select("SELECT
											p.products_id,
											pd.products_name,
											pd.gm_alt_text,
											pd.products_meta_description,
											p.products_price,
											p.products_tax_class_id,
											p.products_image,
											s.expires_date,
											p.products_vpe,
											p.products_vpe_status,
											p.products_vpe_value,
											s.specials_new_products_price
										FROM 
											".TABLE_PRODUCTS." p,
											".TABLE_PRODUCTS_DESCRIPTION." pd,
											".TABLE_SPECIALS." s
										WHERE 
											p.products_status = '1' AND
											p.products_id = s.products_id AND
											pd.products_id = s.products_id AND
											pd.language_id = '".$_SESSION['languages_id']."' AND
											s.status = '1'
											".$t_group_check."
											".$t_fsk_lock."                                             
										ORDER BY s.specials_date_added DESC
										LIMIT ".MAX_RANDOM_SELECT_SPECIALS);

		if((isset($t_result["products_id"]) && $t_result["products_id"] != '') || $_SESSION['style_edit_mode'] == 'edit')
		{
			$this->set_content_data('box_content', $p_coo_product->buildDataArray($t_result));
			$this->set_content_data('SPECIALS_LINK', xtc_href_link(FILENAME_SPECIALS));

			$t_html_output = $this->build_html();
		}

		return $t_html_output;
	}
}

?>