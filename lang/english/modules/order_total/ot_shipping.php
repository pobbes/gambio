<?php
/* --------------------------------------------------------------
   ot_shipping.php 2008-08-01 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------



   based on: 

   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)

   (c) 2002-2003 osCommerce(ot_shipping.php,v 1.4 2003/02/16); www.oscommerce.com 

   (c) 2003	 nextcommerce (ot_shipping.php,v 1.4 2003/08/13); www.nextcommerce.org

   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: ot_shipping.php 899 2005-04-29 02:40:57Z hhgag $)



   Released under the GNU General Public License 

   ---------------------------------------------------------------------------------------*/



 define('MODULE_ORDER_TOTAL_SHIPPING_TITLE', 'Shipping');

  define('MODULE_ORDER_TOTAL_SHIPPING_DESCRIPTION', 'Order shipping cost');



  define('FREE_SHIPPING_TITLE', 'Free Shipping');

  define('FREE_SHIPPING_DESCRIPTION', 'Free shipping for orders over %s');



  define('MODULE_ORDER_TOTAL_SHIPPING_STATUS_TITLE','Display Shipping');

  define('MODULE_ORDER_TOTAL_SHIPPING_STATUS_DESC','Do you want to display the order shipping cost?');



  define('MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER_TITLE','Sort Order');

  define('MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER_DESC', 'Display sort order.');



  define('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_TITLE','Allow Free Shipping');

  define('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_DESC','Do you want to allow free shipping?');



  define('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER_TITLE','Free Shipping for Orders Over');

  define('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER_DESC','Provide free shipping for orders over the set amount.');
// BOF GM_MOD Versandkostenfrei ins Ausland

   define('GM_MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER_TITLE','Free Shipping for Orders Over');

  define('GM_MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER_DESC','Provide free shipping for orders over the set amount.');

// EOF GM_MOD Versandkostenfrei ins Ausland


  define('MODULE_ORDER_TOTAL_SHIPPING_DESTINATION_TITLE','Provide Free Shipping For Orders');

  define('MODULE_ORDER_TOTAL_SHIPPING_DESTINATION_DESC','Provide free shipping for orders sent to this destination.');

  
  define('MODULE_ORDER_TOTAL_SHIPPING_TAX_CLASS_TITLE','Tax Class');

  define('MODULE_ORDER_TOTAL_SHIPPING_TAX_CLASS_DESC','Select tax class (order edit only)');   

?>