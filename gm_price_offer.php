<?php
/* --------------------------------------------------------------
   gm_price_offer.php 2010-10-06 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

(c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com 
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(configuration.php,v 1.40 2002/12/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (configuration.php,v 1.16 2003/08/19); www.nextcommerce.org

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

require('includes/application_top.php');

$breadcrumb->add(GM_PRICE_OFFER_NAVBAR_TITLE, xtc_href_link('gm_price_offer.php'));

$smarty = new Smarty;

// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');
require (DIR_WS_INCLUDES.'header.php');

$coo_price_offer = MainFactory::create_object('PriceOfferContentView');
$t_view_html = $coo_price_offer->get_html();

$smarty->assign('language', $_SESSION['language']);
$smarty->assign('main_content', $t_view_html);

$smarty->caching = 0;

if(!defined(RM))
{
	$smarty->load_filter('output', 'note');
}

$smarty->display(CURRENT_TEMPLATE . '/index.html');

require('includes/application_bottom.php');
?>