<?php
/* --------------------------------------------------------------
   orders_status.php 2008-07-31 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(orders_status.php,v 1.7 2002/01/30); www.oscommerce.com 
   (c) 2003	 nextcommerce (orders_status.php,v 1.4 2003/08/14); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: orders_status.php 899 2005-04-29 02:40:57Z hhgag $)

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'Order Status');

define('TABLE_HEADING_ORDERS_STATUS', 'Order Status');
define('TABLE_HEADING_ACTION', 'Action');
define('TEXT_STORNO', 'fixed');

define('TEXT_INFO_EDIT_INTRO', 'Please make any necessary changes');
define('TEXT_INFO_ORDERS_STATUS_NAME', 'Order Status:');
define('TEXT_INFO_INSERT_INTRO', 'Please enter the new order status with its related data');
define('TEXT_INFO_DELETE_INTRO', 'Are you sure you want to delete this order status?');
define('TEXT_INFO_HEADING_NEW_ORDERS_STATUS', 'New Order Status');
define('TEXT_INFO_HEADING_EDIT_ORDERS_STATUS', 'Edit Order Status');
define('TEXT_INFO_HEADING_DELETE_ORDERS_STATUS', 'Delete Order Status');

define('ERROR_REMOVE_DEFAULT_ORDER_STATUS', 'Error: The default order status cannot be removed. Please set another order status as the default and try again.');
define('ERROR_STATUS_USED_IN_ORDERS', 'Error: This order status is currently being used in orders.');
define('ERROR_STATUS_USED_IN_HISTORY', 'Error: This order status is currently being used in the order status history.');
?>