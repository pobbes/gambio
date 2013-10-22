<?php
/* -----------------------------------------------------------------------------------------
   $Id: cod.php 998 2005-07-07 14:18:20Z mz $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(cod.php,v 1.7 2002/04/17); www.oscommerce.com 
   (c) 2003	 nextcommerce (cod.php,v 1.5 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
define('MODULE_PAYMENT_TYPE_PERMISSION', 'COD');
define('MODULE_PAYMENT_COD_TEXT_TITLE', 'Cash on Delivery');
define('MODULE_PAYMENT_COD_TEXT_DESCRIPTION', 'Cash on delivery');
define('MODULE_PAYMENT_COD_TEXT_INFO','');
define('MODULE_PAYMENT_COD_ZONE_TITLE' , 'Payment Zone');
define('MODULE_PAYMENT_COD_ZONE_DESC' , 'When a zone is selected, this payment method will be enabled for that zone only.');
define('MODULE_PAYMENT_COD_ALLOWED_TITLE' , 'Allowed Zones');
define('MODULE_PAYMENT_COD_ALLOWED_DESC' , 'Please enter the zones <b>individually</b> that should be allowed to use this module (e.g. US, UK (leave blank to allow all zones))');
define('MODULE_PAYMENT_COD_STATUS_TITLE' , 'Enable Cash On Delivery Module');
define('MODULE_PAYMENT_COD_STATUS_DESC' , 'Do you want to accept cash on delivery payments?');
define('MODULE_PAYMENT_COD_SORT_ORDER_TITLE' , 'Display Sort Order');
define('MODULE_PAYMENT_COD_SORT_ORDER_DESC' , 'Display sort order; the lowest value is displayed first.');
define('MODULE_PAYMENT_COD_ORDER_STATUS_ID_TITLE' , 'Set Order Status');
define('MODULE_PAYMENT_COD_ORDER_STATUS_ID_DESC' , 'Set the status of orders made with this payment module to this value');
?>