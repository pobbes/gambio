<?php
/* --------------------------------------------------------------
   reviews.php 2008-08-09 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(reviews.php,v 1.36 2003/02/12); www.oscommerce.com 
   (c) 2003	 nextcommerce (reviews.php,v 1.9 2003/08/17 22:40:08); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: reviews.php 1262 2005-09-30 10:00:32Z mz $)

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

$coo_reviews = MainFactory::create_object('ReviewsContentView');
$t_box_html = $coo_reviews->get_html($product);

$gm_box_pos = $coo_template_control->get_menubox_position('reviews');
$smarty->assign($gm_box_pos, $t_box_html);

?>