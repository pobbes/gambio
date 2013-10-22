<?php
/* --------------------------------------------------------------
   paypalexpress.php 2008-05-04 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(paypal.php,v 1.7 2002/04/17); www.oscommerce.com
   (c) 2003	 nextcommerce (paypal.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: paypal.php 192 2007-02-24 16:24:52Z mzanier $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

define('MODULE_PAYMENT_PAYPALEXPRESS_TEXT_TITLE', 'PayPal');
define('MODULE_PAYMENT_PAYPALEXPRESS_TEXT_DESCRIPTION', 'PayPal');
define('MODULE_PAYMENT_PAYPALEXPRESS_TEXT_INFO', '');
define('MODULE_PAYMENT_PAYPALEXPRESS_STATUS_TITLE', 'Activate PayPal Express');
define('MODULE_PAYMENT_PAYPALEXPRESS_STATUS_DESC', 'Would you like to accept payments via PayPal Express?');
define('MODULE_PAYMENT_PAYPALEXPRESS_SORT_ORDER_TITLE' , 'Display Sort Order');
define('MODULE_PAYMENT_PAYPALEXPRESS_SORT_ORDER_DESC' , 'Display sort order; the lowest value is displayed first');
define('MODULE_PAYMENT_PAYPALEXPRESS_ALLOWED_TITLE' , 'Allowed Zones');
define('MODULE_PAYMENT_PAYPALEXPRESS_ALLOWED_DESC' , 'Enter the zones <b>individually</b> that should be allowed for this module. (e.g. US, UK (leave blank to allow all zones))');
define('MODULE_PAYMENT_PAYPALEXPRESS_ZONE_TITLE' , 'Payment Zone');
define('MODULE_PAYMENT_PAYPALEXPRESS_ZONE_DESC' , 'When a zone is selected, this payment method will be enabled for that zone only.');

?>