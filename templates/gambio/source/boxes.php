<?php
/* --------------------------------------------------------------
   boxes.php 2011-03-03 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: boxes.php 1298 2005-10-09 13:14:44Z mz $)
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
define('DIR_WS_BOXES',DIR_FS_CATALOG .'templates/'.CURRENT_TEMPLATE. '/source/boxes/');

include(DIR_WS_BOXES . 'gm_logo.php');
include(DIR_WS_BOXES . 'gm_topmenu.php');

if($coo_template_control->get_menubox_status('categories')) include(DIR_WS_BOXES.'categories.php');
if($coo_template_control->get_menubox_status('content'))  include(DIR_WS_BOXES.'content.php');
if($coo_template_control->get_menubox_status('extrabox1')) include(DIR_WS_BOXES.'extrabox1.php');
if($coo_template_control->get_menubox_status('extrabox2')) include(DIR_WS_BOXES.'extrabox2.php');
if($coo_template_control->get_menubox_status('extrabox3')) include(DIR_WS_BOXES.'extrabox3.php');
if($coo_template_control->get_menubox_status('extrabox4')) include(DIR_WS_BOXES.'extrabox4.php');
if($coo_template_control->get_menubox_status('extrabox5')) include(DIR_WS_BOXES.'extrabox5.php');
if($coo_template_control->get_menubox_status('extrabox6')) include(DIR_WS_BOXES.'extrabox6.php');
if($coo_template_control->get_menubox_status('extrabox7')) include(DIR_WS_BOXES.'extrabox7.php');
if($coo_template_control->get_menubox_status('extrabox8')) include(DIR_WS_BOXES.'extrabox8.php');
if($coo_template_control->get_menubox_status('extrabox9')) include(DIR_WS_BOXES.'extrabox9.php');
if($coo_template_control->get_menubox_status('gm_bookmarks')) include(DIR_WS_BOXES.'gm_bookmarks.php');
if($coo_template_control->get_menubox_status('gm_counter')) include(DIR_WS_BOXES.'gm_counter.php');
if($coo_template_control->get_menubox_status('gm_ebay'))  include(DIR_WS_BOXES.'gm_ebay.php');
if($coo_template_control->get_menubox_status('gm_scroller')) include(DIR_WS_BOXES.'gm_scroller.php');
if($coo_template_control->get_menubox_status('gm_trusted_shops_widget')) include(DIR_WS_BOXES.'gm_trusted_shops_widget.php');
if($coo_template_control->get_menubox_status('infobox'))  include(DIR_WS_BOXES.'infobox.php');
if($coo_template_control->get_menubox_status('information')) include(DIR_WS_BOXES.'information.php');
if($coo_template_control->get_menubox_status('languages'))  include(DIR_WS_BOXES.'languages.php');
if($coo_template_control->get_menubox_status('last_viewed')) include(DIR_WS_BOXES.'last_viewed.php');
if($coo_template_control->get_menubox_status('login')) include(DIR_WS_BOXES.'loginbox.php');
if($coo_template_control->get_menubox_status('manufacturers')) include(DIR_WS_BOXES.'manufacturers.php');
if($coo_template_control->get_menubox_status('newsletter')) include(DIR_WS_BOXES.'newsletter.php');
if($coo_template_control->get_menubox_status('paypal')) include(DIR_WS_BOXES.'paypal.php');
if($coo_template_control->get_menubox_status('search'))  include(DIR_WS_BOXES.'search.php');
if($coo_template_control->get_menubox_status('trusted'))  include(DIR_WS_BOXES.'trusted.php');
if($coo_template_control->get_menubox_status('ekomi'))  include(DIR_WS_BOXES.'ekomi.php');

if($_SESSION['style_edit_mode'] == 'edit' || $_SESSION['customers_status']['customers_status_id'] === '0' && (int)$_SESSION['customer_id'] > 0) include(DIR_WS_BOXES.'admin.php');
if($coo_template_control->get_menubox_status('add_quickie')) if($_SESSION['style_edit_mode'] == 'edit' || $_SESSION['customers_status']['customers_status_show_price']!='0') include(DIR_WS_BOXES.'add_a_quickie.php');
if($coo_template_control->get_menubox_status('bestsellers'))   if($_SESSION['style_edit_mode'] == 'edit' || !$product->isProduct()) include(DIR_WS_BOXES.'best_sellers.php');
if($coo_template_control->get_menubox_status('cart'))  if($_SESSION['style_edit_mode'] == 'edit' || $_SESSION['customers_status']['customers_status_show_price'] == 1) include(DIR_WS_BOXES.'shopping_cart.php');
if($coo_template_control->get_menubox_status('currencies')) if($_SESSION['style_edit_mode'] == 'edit' || substr(basename($PHP_SELF), 0, 8) != 'checkout') include(DIR_WS_BOXES.'currencies.php');
if($coo_template_control->get_menubox_status('manufacturers_info')) if($_SESSION['style_edit_mode'] == 'edit' || $product->isProduct()) include(DIR_WS_BOXES.'manufacturer_info.php');
if($coo_template_control->get_menubox_status('order_history')) if($_SESSION['style_edit_mode'] == 'edit' || isset($_SESSION['customer_id'])) include(DIR_WS_BOXES.'order_history.php');
if($coo_template_control->get_menubox_status('reviews'))  if($_SESSION['style_edit_mode'] == 'edit' || $_SESSION['customers_status']['customers_status_read_reviews'] == 1) include(DIR_WS_BOXES.'reviews.php');
if($coo_template_control->get_menubox_status('specials'))   if($_SESSION['style_edit_mode'] == 'edit' || !$product->isProduct()) include(DIR_WS_BOXES.'specials.php');
if($coo_template_control->get_menubox_status('whatsnew')) if($_SESSION['style_edit_mode'] == 'edit' || substr(basename($PHP_SELF), 0, 8) != 'advanced') include(DIR_WS_BOXES.'whats_new.php');

# BOF YOOCHOOSE
if (defined('YOOCHOOSE_ACTIVE') && YOOCHOOSE_ACTIVE) {
	if($coo_template_control->get_menubox_status('yoochoose_also_clicked')) include(DIR_WS_BOXES . 'yoochoose_also_clicked.php');
	if($coo_template_control->get_menubox_status('yoochoose_top_selling'))  include(DIR_WS_BOXES . 'yoochoose_top_selling.php');
}
# EOF YOOCHOOSE

$smarty->assign('gm_topmenu_mode', gm_get_conf('GM_TOPMENU_MODE'));
$smarty->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/');
?>