<?php
/* --------------------------------------------------------------
   popup_coupon_help.php 2010-01-18 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(popup_coupon_help.php,v 1.1.2.5 2003/05/02); www.oscommerce.com
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: popup_coupon_help.php 1313 2005-10-18 15:49:15Z mz $)


   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

require ('includes/application_top.php');
require_once (DIR_FS_INC.'xtc_date_short.inc.php');
require_once(DIR_FS_INC . 'xtc_get_currencies_values.inc.php');
$smarty = new Smarty;

require_once (DIR_FS_CATALOG . 'gm/modules/gm_popup_header.php');


$coupon_query = xtc_db_query("select * from ".TABLE_COUPONS." where coupon_id = '".(int)$_GET['cID']."'");
$coupon = xtc_db_fetch_array($coupon_query);
$coupon_desc_query = xtc_db_query("select * from ".TABLE_COUPONS_DESCRIPTION." where coupon_id = '".(int)$_GET['cID']."' and language_id = '".$_SESSION['languages_id']."'");
$coupon_desc = xtc_db_fetch_array($coupon_desc_query);
$text_coupon_help = TEXT_COUPON_HELP_HEADER;
$text_coupon_help .= sprintf(TEXT_COUPON_HELP_NAME, $coupon_desc['coupon_name']);
if (xtc_not_null($coupon_desc['coupon_description']))
	$text_coupon_help .= sprintf(TEXT_COUPON_HELP_DESC, $coupon_desc['coupon_description']);
$coupon_amount = $coupon['coupon_amount'];
switch ($coupon['coupon_type']) {
	case 'F' :
		$t_gm_currency_array = array();
		
		$t_gm_currency_array = xtc_get_currencies_values($_SESSION['currency']);
		
		if(!empty($t_gm_currency_array['value']))
		
		{
			$coupon['coupon_amount'] = (double)$coupon['coupon_amount'] * (double)$t_gm_currency_array['value'];
			
			$coupon['coupon_amount'] = round($coupon['coupon_amount'], 2);
		
		}
		
		$text_coupon_help .= sprintf(TEXT_COUPON_HELP_FIXED, $xtPrice->xtcFormat($coupon['coupon_amount'], true));
		break;
	case 'P' :
		$text_coupon_help .= sprintf(TEXT_COUPON_HELP_FIXED, number_format((double)$coupon['coupon_amount'], 2).'%');
		break;
	case 'S' :
		$text_coupon_help .= TEXT_COUPON_HELP_FREESHIP;
		break;
	default :
		}

if ($coupon['coupon_minimum_order'] > 0)
	$t_gm_currency_array = array();
		
	$t_gm_currency_array = xtc_get_currencies_values($_SESSION['currency']);
		
	if(!empty($t_gm_currency_array['value']))
	
	{
		$coupon['coupon_minimum_order'] = (double)$coupon['coupon_minimum_order'] * (double)$t_gm_currency_array['value'];
		
		$coupon['coupon_minimum_order'] = round($coupon['coupon_minimum_order'], 2);
	
	}
	$text_coupon_help .= sprintf(TEXT_COUPON_HELP_MINORDER, $xtPrice->xtcFormat($coupon['coupon_minimum_order'], true));
$text_coupon_help .= sprintf(TEXT_COUPON_HELP_DATE, xtc_date_short($coupon['coupon_start_date']), xtc_date_short($coupon['coupon_expire_date']));

$coupon_get = xtc_db_query("select restrict_to_categories from ".TABLE_COUPONS." where coupon_id='".(int)$_GET['cID']."'");
$get_result = xtc_db_fetch_array($coupon_get);

$cat_ids = explode(',', $get_result['restrict_to_categories']);
for ($i = 0; $i < count($cat_ids); $i ++) {
	$result = xtc_db_query("SELECT * FROM ".TABLE_CATEGORIES." c, ".TABLE_CATEGORIES_DESCRIPTION." cd WHERE c.categories_id = cd.categories_id and cd.language_id = '".$_SESSION['languages_id']."' and c.categories_id='".$cat_ids[$i]."'");
	if ($row = xtc_db_fetch_array($result)) {
		$cats .= '<br />'.$row["categories_name"];
	}
}

$coupon_get = xtc_db_query("select restrict_to_products from ".TABLE_COUPONS."  where coupon_id='".(int)$_GET['cID']."'");
$get_result = xtc_db_fetch_array($coupon_get);

$pr_ids = explode(',', $get_result['restrict_to_products']);
for ($i = 0; $i < count($pr_ids); $i ++) {
	$result = xtc_db_query("SELECT * FROM ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_DESCRIPTION." pd WHERE p.products_id = pd.products_id and pd.language_id = '".$_SESSION['languages_id']."'and p.products_id = '".$pr_ids[$i]."'");
	if ($row = xtc_db_fetch_array($result)) {
		$prods .= '<br />'.$row["products_name"];
	}
}

// BOF GM_MOD
if($cats != '' || $prods != '')
{
	$text_coupon_help .= '<b>'.TEXT_COUPON_HELP_RESTRICT.'</b>';
	
	if($cats != '')
	{
		$text_coupon_help .= '<br /><br />'.TEXT_COUPON_HELP_CATEGORIES.':';
		$text_coupon_help .= $cats;
	}
	
	if($prods != '')
	{
		$text_coupon_help .= '<br /><br />'.TEXT_COUPON_HELP_PRODUCTS.':';
		$text_coupon_help .= $prods;
	}
}
// EOF GM_MOD

$smarty->assign('TEXT_HELP', $text_coupon_help);
$smarty->assign('link_close', 'javascript:window.close()');
$smarty->assign('language', $_SESSION['language']);

$smarty->caching = 0;
$smarty->display(CURRENT_TEMPLATE.'/module/popup_coupon_help.html');
// BOF GM_MOD:
mysql_close();

//include ('includes/application_bottom.php');
?>