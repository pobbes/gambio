<?php

/* -----------------------------------------------------------------------------------------
   $Id: cash.php 1102 2005-07-24 15:05:38Z mz $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(cod.php,v 1.28 2003/02/14); www.oscommerce.com
   (c) 2003	 nextcommerce (invoice.php,v 1.4 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

define('MODULE_PAYMENT_CASH_TEXT_DESCRIPTION', 'Cash');
define('MODULE_PAYMENT_CASH_TEXT_TITLE', 'Cash');
define('MODULE_PAYMENT_CASH_TEXT_INFO', '');
define('MODULE_PAYMENT_CASH_STATUS_TITLE', 'Enable Cash Module');
define('MODULE_PAYMENT_CASH_STATUS_DESC', 'Do you want to accept payments in cash?');
define('MODULE_PAYMENT_CASH_ORDER_STATUS_ID_TITLE', 'Set Order Status');
define('MODULE_PAYMENT_CASH_ORDER_STATUS_ID_DESC', 'Set the status of orders made using this payment module to this value');
define('MODULE_PAYMENT_CASH_SORT_ORDER_TITLE', 'Display Sort Order');
define('MODULE_PAYMENT_CASH_SORT_ORDER_DESC', 'Display sort order; the lowest value is displayed first.');
define('MODULE_PAYMENT_CASH_ZONE_TITLE', 'Payment Zone');
define('MODULE_PAYMENT_CASH_ZONE_DESC', 'When a zone is selected, this payment method will be enabled for that zone only.');
define('MODULE_PAYMENT_CASH_ALLOWED_TITLE', 'Allowed Zones');
define('MODULE_PAYMENT_CASH_ALLOWED_DESC', 'Please enter the zones <b>individually</b> that should be allowed to use this module (e.g. US, UK (leave blank to allow all zones))');
?>