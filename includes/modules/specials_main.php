<?php
/* --------------------------------------------------------------
   specials_main.php 2012-02-20 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(specials.php,v 1.47 2003/05/27); www.oscommerce.com 
   (c) 2003	 nextcommerce (specials.php,v 1.12 2003/08/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: specials.php 1292 2005-10-07 16:10:55Z mz $)


   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

if((int)gm_get_conf("GM_SPECIALS_STARTPAGE") > 0)
{
	$specials_smarty = new Smarty;
	
	require_once(DIR_FS_INC.'xtc_get_short_description.inc.php');

	//fsk18 lock
	$fsk_lock = '';
	if($_SESSION['customers_status']['customers_fsk18_display'] == '0')
	{
		$fsk_lock = ' and p.products_fsk18!=1';
	}
	if(GROUP_CHECK == 'true')
	{
		$group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
	}

	$specials_query_raw = "SELECT
								p.products_id,
								pd.products_name,
								pd.gm_alt_text,
								pd.products_meta_description,
								p.products_price,
								p.products_image_w,
								p.products_image_h,
								p.products_price,
								p.products_tax_class_id,p.products_shippingtime,
								p.products_image,p.products_vpe_status,p.products_vpe_value,p.products_vpe,p.products_fsk18,
								s.specials_new_products_price
							FROM
								(	SELECT
										s.products_id,
										s.specials_new_products_price
									FROM
										" . TABLE_SPECIALS . " s
									WHERE
										s.status = '1'
									LIMIT " . (int)MAX_RANDOM_SELECT_SPECIALS . ") AS s,
								".TABLE_PRODUCTS." p,
								".TABLE_PRODUCTS_DESCRIPTION." pd
							WHERE
								p.products_id = s.products_id
								and p.products_status = '1'
								and p.products_id = pd.products_id
								".$group_check."
								".$fsk_lock."
								and pd.language_id = '".(int) $_SESSION['languages_id']."'
							ORDER BY RAND()
							LIMIT " . (int)gm_get_conf('GM_SPECIALS_STARTPAGE');

	if(version_compare(gm_get_env_info('MYSQL_VERSION'), '4.1') < 0)
	{
		$specials_query_raw = "SELECT
								p.products_id,
								pd.products_name,
								pd.gm_alt_text,
								pd.products_meta_description,
								p.products_price,
								p.products_image_w,
								p.products_image_h,
								p.products_price,
								p.products_tax_class_id,p.products_shippingtime,
								p.products_image,p.products_vpe_status,p.products_vpe_value,p.products_vpe,p.products_fsk18,
								s.specials_new_products_price
							FROM
								".TABLE_SPECIALS." s,
								".TABLE_PRODUCTS." p,
								".TABLE_PRODUCTS_DESCRIPTION." pd
							WHERE
								s.status = '1'
								and p.products_id = s.products_id
								and p.products_status = '1'
								and p.products_id = pd.products_id
								".$group_check."
								".$fsk_lock."
								and pd.language_id = '".(int) $_SESSION['languages_id']."'
								and s.status = '1'
							ORDER BY RAND()
							LIMIT " . (int)gm_get_conf('GM_SPECIALS_STARTPAGE');
	}

	$module_content = '';
	$row = 0;

	$t_result = xtc_db_query($specials_query_raw);
	
	if(xtc_db_num_rows($t_result) > 0)
	{
		while($specials = xtc_db_fetch_array($t_result))
		{
			$module_content[] = $product->buildDataArray($specials);
		}

		$gm_image_len = PRODUCT_IMAGE_THUMBNAIL_HEIGHT;
		if($gm_image_len < PRODUCT_IMAGE_THUMBNAIL_WIDTH)
		{
			$gm_image_len = PRODUCT_IMAGE_THUMBNAIL_WIDTH;
		}
		
		$specials_smarty->assign('gm_thumbnail_heigth', $gm_image_len + 8);
		$specials_smarty->assign('gm_thumbnail_width', $gm_image_len + 8);
		
		$specials_smarty->assign('thumbnail_heigth', PRODUCT_IMAGE_THUMBNAIL_HEIGHT + 40);
	}

	$specials_smarty->assign('TEXT_ADD_TO_CART', TEXT_ADD_TO_CART);
	$specials_smarty->assign('TRUNCATE_PRODUCTS_NAME', gm_get_conf('TRUNCATE_PRODUCTS_NAME'));
	$specials_smarty->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
	$specials_smarty->assign('language', $_SESSION['language']);
	$specials_smarty->assign('module_content', $module_content);
	$specials_smarty->caching = 0;

	$specials_content = $specials_smarty->fetch(CURRENT_TEMPLATE.'/module/specials_main.html');

	$default_smarty->assign('specials_main', $specials_content);
}

?>