<?php
/* --------------------------------------------------------------
   shipping_status.php 2013-02-28 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2013 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(orders_status.php,v 1.7 2002/01/30); www.oscommerce.com 
   (c) 2003	 nextcommerce (orders_status.php,v 1.4 2003/08/14); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: shipping_status.php 899 2005-04-29 02:40:57Z hhgag $)

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'Shipping Status');

define('TABLE_HEADING_SHIPPING_STATUS', 'Shipping Status');
define('TABLE_HEADING_ACTION', 'Action');

define('TABLE_HEADING_SHIPPING_TIME', 'Shipping Time');

define('TEXT_INFO_EDIT_INTRO', 'Please make any necessary changes');
define('TEXT_INFO_SHIPPING_STATUS_NAME', 'Shipping Status:');
define('TEXT_INFO_INSERT_INTRO', 'Please enter the new shipping status with its related data');
define('TEXT_INFO_DELETE_INTRO', 'Are you sure you want to delete this shipping status?');
define('TEXT_INFO_HEADING_NEW_SHIPPING_STATUS', 'New Shipping Status');
define('TEXT_INFO_HEADING_EDIT_SHIPPING_STATUS', 'Edit Shipping Status');
define('TEXT_INFO_SHIPPING_STATUS_IMAGE', 'Image:');
define('TEXT_INFO_HEADING_DELETE_SHIPPING_STATUS', 'Delete Shipping Status');

define('ERROR_REMOVE_DEFAULT_SHIPPING_STATUS', 'Error: The default shipping status cannot be removed. Please set another shipping status as the default and try again.');
define('ERROR_STATUS_USED_IN_ORDERS', 'Error: This shipping status is currently being used for products.');
define('ERROR_STATUS_USED_IN_HISTORY', 'Error: This shipping status is currently being used for products.');

// BOF GM_MOD:
define('TEXT_INFO_SHIPPING_STATUS_DAYS', 'Number of days:');
define('TEXT_INPUT_SHIPPING_STATUS_QUANTITY', 'Insert the upper threshold (stock quantity) for automatically applying this delivery status. The delivery status is updated automatically only through orders submitted by the shop front end.<br /><br />Set the upper threshold for the delivery status with the shortest shipping time (highest stock quantity) to 999999.');
define('TEXT_INFO_SHIPPING_STATUS_QUANTITY', 'Upper threshold:');
define('BUTTON_INSERT_SHIPPING', 'Insert delivery status');
define('BUTTON_CONFIG_SHIPPING', 'Config delivery status');
define('HEADING_CONFIG_SHIPPING', 'Config delivery status');
define('TEXT_CONFIG_SHIPPING', 'Delivery status update automatically:');
define('TEXT_INFO_SHIPPING_STATUS_GOOGLE_AVAILABILITY', 'Link this shipping status to the following Google-Shopping availability:');
