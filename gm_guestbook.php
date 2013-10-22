<?php
/* --------------------------------------------------------------
   gm_guestbook.php 2008-08-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(conditions.php,v 1.21 2003/02/13); www.oscommerce.com 
   (c) 2003	 nextcommerce (shop_content.php,v 1.1 2003/08/19); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: shop_content.php 1303 2005-10-12 16:47:31Z mz $)

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

require ('includes/application_top.php');
require_once (DIR_FS_INC.'xtc_random_charcode.inc.php');

$breadcrumb->add(GM_GUESTBOOK, xtc_href_link('gm_guestbook.php'));

// create smarty elements
$smarty = new Smarty;
// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');

$visual_verify_code = xtc_random_charcode(6);
$_SESSION['vvcode'] = $visual_verify_code;

$smarty->assign('GUESTBOOK', GM_GUESTBOOK);

$gm_check_customers_status = xtc_db_query("SELECT 
																							count(customers_status_id) AS cnt
																							FROM gm_guestbook_customers_status
																							WHERE customers_status_id = '" . $_SESSION['customers_status']['customers_status_id'] . "'");
$gm_check_status = xtc_db_fetch_array($gm_check_customers_status);
$smarty->assign('GUESTBOOK_FORM', $gm_check_status['cnt']);

$smarty->assign('NAME', GM_GUESTBOOK_NAME);
$smarty->assign('EMAIL', GM_GUESTBOOK_EMAIL);
$smarty->assign('HOMEPAGE', GM_GUESTBOOK_HOMEPAGE);
$smarty->assign('MESSAGE', GM_GUESTBOOK_MESSAGE);
$smarty->assign('VALIDATION_ACTIVE', gm_get_conf('GM_GUESTBOOK_VVCODE'));
$smarty->assign('VALIDATION', GM_GUESTBOOK_VALIDATION);
$smarty->assign('SEND', GM_GUESTBOOK_BUTTON_SEND);

$smarty->assign('IMG_DIR', DIR_WS_IMAGES);

require (DIR_WS_INCLUDES.'header.php');

$smarty->assign('language', $_SESSION['language']);
$smarty->assign('main_content', $smarty->fetch(CURRENT_TEMPLATE.'/module/gm_guestbook.html'));
$smarty->caching = 0;
if (!defined(RM))
	$smarty->load_filter('output', 'note');
$smarty->display(CURRENT_TEMPLATE.'/index.html');
include ('includes/application_bottom.php');
?>