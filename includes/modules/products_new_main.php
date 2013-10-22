<?php
/* --------------------------------------------------------------
   products_new_main.php 2012-02-20 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(products_new.php,v 1.25 2003/05/27); www.oscommerce.com
   (c) 2003	 nextcommerce (products_new.php,v 1.16 2003/08/18); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: products_new.php 1292 2005-10-07 16:10:55Z mz $)

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   Enable_Disable_Categories 1.3        	Autor: Mikel Williams | mikel@ladykatcostumes.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

if((int)gm_get_conf('GM_NEW_PRODUCTS_STARTPAGE') > 0) {
	// create smarty elements
	$new_main_smarty = new Smarty;
	// include needed function
	require_once (DIR_FS_INC.'xtc_date_long.inc.php');
	require_once (DIR_FS_INC.'xtc_get_vpe_name.inc.php');


	$products_new_array = array ();
	$fsk_lock = '';
	if ($_SESSION['customers_status']['customers_fsk18_display'] == '0') {
		$fsk_lock = ' and p.products_fsk18!=1';
	}
	if (GROUP_CHECK == 'true') {
		$group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
	}
	if (MAX_DISPLAY_NEW_PRODUCTS_DAYS != '0') {
		$date_new_products = date("Y.m.d", mktime(1, 1, 1, date(m), date(d) - MAX_DISPLAY_NEW_PRODUCTS_DAYS, date(Y)));
		$days = " and p.products_date_added > '".$date_new_products."' ";
	}
	
	$products_new_query_raw = "SELECT
									p.products_id,
									p.products_fsk18,
									p.products_image,
									p.products_image_w,
									p.products_image_h,
									p.products_price,
									p.products_vpe,
									p.products_vpe_status,
									p.products_vpe_value,
									p.products_tax_class_id,
									p.products_date_added,
									p.gm_price_status,
									pd.products_name,
									pd.products_meta_description,
									pd.gm_alt_text
								FROM
									(SELECT
										p.products_id,
										p.products_fsk18,
										p.products_image,
										p.products_image_w,
										p.products_image_h,
										p.products_price,
										p.products_vpe,
										p.products_vpe_status,
										p.products_vpe_value,
										p.products_tax_class_id,
										p.products_date_added,
										p.gm_price_status
									FROM
										" . TABLE_PRODUCTS . " p
									WHERE
										p.products_status = '1'
										" . $group_check . "
										" . $fsk_lock . "
										" . $days . "
									LIMIT " . (int)MAX_RANDOM_SELECT_NEW . ") AS p,
									" . TABLE_PRODUCTS_DESCRIPTION . " pd
								WHERE
									p.products_id = pd.products_id
									AND pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
								ORDER BY RAND()
								LIMIT " . (int)gm_get_conf('GM_NEW_PRODUCTS_STARTPAGE');

	if(version_compare(gm_get_env_info('MYSQL_VERSION'), '4.1') < 0)
	{
		$products_new_query_raw = "SELECT DISTINCT
											p.products_id,
											p.products_fsk18,
											p.products_image,
											p.products_image_w,
											p.products_image_h,
											p.products_price,
											p.products_vpe,
											p.products_vpe_status,
											p.products_vpe_value,
											p.products_tax_class_id,
											p.products_date_added,
											p.gm_price_status,
											pd.products_name,
											pd.products_meta_description,
											pd.gm_alt_text
										FROM
											" . TABLE_PRODUCTS . " p,
											" . TABLE_PRODUCTS_DESCRIPTION . " pd
										WHERE
											p.products_status = '1'
											AND p.products_id = pd.products_id
											AND pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
											" . $group_check . "
											" . $fsk_lock . "
											" . $days . "
										ORDER BY RAND()
										LIMIT " . (int)gm_get_conf('GM_NEW_PRODUCTS_STARTPAGE');
	}

$t_result = xtc_db_query($products_new_query_raw);

	$gm_buy_now_url = '';
	$module_content = '';
	if (xtc_db_num_rows($t_result) > 0) {
		while ($products_new = xtc_db_fetch_array($t_result)) {
			$products_price = $xtPrice->xtcGetPrice($products_new['products_id'], $format = true, 1, $products_new['products_tax_class_id'], $products_new['products_price'], 1);
			$vpePrice = '';
			if ($products_new['products_vpe_status'] == 1 && $products_new['products_vpe_value'] != 0.0)
				$vpePrice = $xtPrice->xtcFormat($products_price['plain'] * (1 / $products_new['products_vpe_value']), true).TXT_PER.xtc_get_vpe_name($products_new['products_vpe']);
			$buy_now = '';
			// BOF GM_MOD
			if($products_new['gm_price_status'] == 0 && $_SESSION['customers_status']['customers_status_show_price'] != '0'){
				if ($_SESSION['customers_status']['customers_fsk18'] == '1') {
					if ($products_new['products_fsk18'] == '0'){
						$gm_buy_now_url = xtc_href_link(basename($PHP_SELF), 'action=buy_now&BUYproducts_id='.$products_new['products_id'].'&'.xtc_get_all_get_params(array ('action')), 'NONSSL');
						$buy_now = '<a href="'.xtc_href_link(basename($PHP_SELF), xtc_get_all_get_params(array ('action')).'action=buy_now&BUYproducts_id='.$products_new['products_id'], 'NONSSL').'">'.xtc_image_button('button_buy_now.gif', TEXT_BUY.$products_new['products_name'].TEXT_NOW).'</a>';
					}
				} else {
					$gm_buy_now_url = xtc_href_link(basename($PHP_SELF), 'action=buy_now&BUYproducts_id='.$products_new['products_id'].'&'.xtc_get_all_get_params(array ('action')), 'NONSSL');
					$buy_now = '<a href="'.xtc_href_link(basename($PHP_SELF), xtc_get_all_get_params(array ('action')).'action=buy_now&BUYproducts_id='.$products_new['products_id'], 'NONSSL').'">'.xtc_image_button('button_buy_now.gif', TEXT_BUY.$products_new['products_name'].TEXT_NOW).'</a>';
				}
			}
			// EOF GM_MOD
			if ($products_new['products_image'] != '') {
				$products_image = DIR_WS_THUMBNAIL_IMAGES.$products_new['products_image'];
			} else {
				$products_image = '';
			}


			// BOF GM_MOD:
			if ($_SESSION['customers_status']['customers_status_show_price'] != 0 && ($products_new['gm_price_status'] == 0 || ($products_new['gm_price_status'] == 2 && $products_new['products_price'] > 0)) ) {
				$tax_rate = $xtPrice->TAX[$products_new['products_tax_class_id']];
				// price incl tax

				//GM_MOD:
				$tax_info = $main->getTaxInfo($tax_rate);				
			}
			$ship_info="";
			// BOF GM_MOD:
			if (SHOW_SHIPPING=='true' && $products_new['gm_price_status'] == 0) {
				//$ship_info=' '.SHIPPING_EXCL.'<a href="javascript:newWin=void(window.open(\''.xtc_href_link(FILENAME_POPUP_CONTENT, 'coID='.SHIPPING_INFOS).'\', \'popup\', \'toolbar=0, width=640, height=600\'))"> '.SHIPPING_COSTS.'</a>';
				$ship_info = $main->getShippingLink(true);
			}

			// bof gm
			if($gmSEOBoost->boost_products) {
				$gm_product_link = xtc_href_link($gmSEOBoost->get_boosted_product_url($products_new['products_id'], $products_new['products_name']));
			} else {
				$gm_product_link = xtc_href_link(FILENAME_PRODUCT_INFO, xtc_product_link($products_new['products_id'], $products_new['products_name']));
			}
			// eof gm

			// set image size once a time if !exist
			if(empty($products_new['products_image_w'])  && xtc_not_null($products_new['products_image'])) {
				$gm_imagesize = @getimagesize($products_image);
				$gm_query = xtc_db_query("
										UPDATE " .
											TABLE_PRODUCTS . "
										SET
											products_image_w = '" . $gm_imagesize[0] . "',
											products_image_h = '" . $gm_imagesize[1] . "'
										WHERE
											products_id = '" . $products_new['products_id'] . "'
										");
				$products_new['products_image_w'] = $gm_imagesize[0];
				$products_new['products_image_h'] = $gm_imagesize[1];
			}

			$module_content[] = array (
				'PRODUCTS_ID' => $products_new['products_id'],
				'GM_PRODUCTS_BUTTON_BUY_NOW_URL' => $gm_buy_now_url,
				'PRODUCTS_IMAGE_ALT' => $products_new['gm_alt_text'],
				'PRODUCTS_NAME' => $products_new['products_name'],
				'PRODUCTS_SHIPPING_LINK' => $ship_info,
				'PRODUCTS_TAX_INFO' => $tax_info,
				'PRODUCTS_DESCRIPTION' => $products_new['products_short_description'],
				'PRODUCTS_PRICE' => $products_price['formated'],
				'PRODUCTS_VPE' => $vpePrice,
				'PRODUCTS_LINK' => $gm_product_link,
				'PRODUCTS_IMAGE' => $products_image,
				'PRODUCTS_IMAGE_W'	=> $products_new['products_image_w'],
				'PRODUCTS_IMAGE_H'	=> $products_new['products_image_h'],
				'PRODUCTS_IMAGE_PADDING' => ((PRODUCT_IMAGE_THUMBNAIL_HEIGHT + 8) - $products_new['products_image_h'])/2,
				'BUTTON_BUY_NOW' => $buy_now,
				'PRODUCTS_META_DESCRIPTION' => $products_new['products_meta_description']
			);
			// BOF GM_MOD
			$new_main_smarty->assign('thumbnail_heigth', PRODUCT_IMAGE_THUMBNAIL_HEIGHT + 30);
			// EOF GM_MOD

		}
	} else {

		$new_main_smarty->assign('ERROR', TEXT_NO_NEW_PRODUCTS);

	}
	$new_main_smarty->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');

	// bof gm
		$gm_image_len = PRODUCT_IMAGE_THUMBNAIL_HEIGHT;
		if($gm_image_len < PRODUCT_IMAGE_THUMBNAIL_WIDTH) $gm_image_len = PRODUCT_IMAGE_THUMBNAIL_WIDTH;

		$new_main_smarty->assign('gm_thumbnail_heigth', $gm_image_len + 8);
		$new_main_smarty->assign('gm_thumbnail_width', $gm_image_len + 8);

	$new_main_smarty->assign('thumbnail_heigth', PRODUCT_IMAGE_THUMBNAIL_HEIGHT + 40);

	$new_main_smarty->assign('TEXT_ADD_TO_CART', TEXT_ADD_TO_CART);
	$new_main_smarty->assign('TRUNCATE_PRODUCTS_NAME', gm_get_conf('TRUNCATE_PRODUCTS_NAME'));

	// eof gm
	$new_main_smarty->assign('language', $_SESSION['language']);
	$new_main_smarty->caching = 0;
	$new_main_smarty->assign('module_content', $module_content);

	$new_main_content = $new_main_smarty->fetch(CURRENT_TEMPLATE.'/module/products_new_main.html');

	$default_smarty->assign('products_new_main', $new_main_content);
}
?>