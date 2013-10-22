<?php
/* --------------------------------------------------------------
   table.php 2010-01-19 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(table.php,v 1.6 2003/02/16); www.oscommerce.com
   (c) 2003	 nextcommerce (table.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: table.php 899 2005-04-29 02:40:57Z hhgag $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

define('MODULE_SHIPPING_TABLE_TEXT_TITLE', 'Table Rate');
define('MODULE_SHIPPING_TABLE_TEXT_DESCRIPTION', 'Table rate');
define('MODULE_SHIPPING_TABLE_TEXT_WAY', 'Best way');
define('MODULE_SHIPPING_TABLE_TEXT_WEIGHT', 'Weight');
define('MODULE_SHIPPING_TABLE_TEXT_AMOUNT', 'Quantity');
define('MODULE_SHIPPING_TABLE_UNDEFINED_RATE', 'Shipping costs cannot be calculated for the moment');

define('MODULE_SHIPPING_TABLE_STATUS_TITLE' , 'Enable Table Method');
define('MODULE_SHIPPING_TABLE_STATUS_DESC' , 'Do you want to offer table rate shipping?');
define('MODULE_SHIPPING_TABLE_ALLOWED_TITLE' , 'Allowed Shipping Zones');
define('MODULE_SHIPPING_TABLE_ALLOWED_DESC' , 'Please enter the zones <b>individually</b> that should be allowed to use this module (e.g. US, UK (leave blank to allow all zones))');
define('MODULE_SHIPPING_TABLE_COST_TITLE' , 'Shipping Cost');
define('MODULE_SHIPPING_TABLE_COST_DESC' , 'The shipping tariff is based on the total cost or weight of items. E.g.: 25:5.50,50:8.50,etc.. Up to 25 charge 5.50, 26 to 50 charge 8.50, etc.');
define('MODULE_SHIPPING_TABLE_MODE_TITLE' , 'Table Method');
define('MODULE_SHIPPING_TABLE_MODE_DESC' , 'The shipping cost is based on the order total or the total weight of the items ordered.');
define('MODULE_SHIPPING_TABLE_HANDLING_TITLE' , 'Handling Fee');
define('MODULE_SHIPPING_TABLE_HANDLING_DESC' , 'Handling fee for this shipping method.');
define('MODULE_SHIPPING_TABLE_TAX_CLASS_TITLE' , 'Tax Class');
define('MODULE_SHIPPING_TABLE_TAX_CLASS_DESC' , 'Apply the following tax class to the shipping costs.');
define('MODULE_SHIPPING_TABLE_ZONE_TITLE' , 'Shipping Zone');
define('MODULE_SHIPPING_TABLE_ZONE_DESC' , 'If a zone is selected, this payment method will be enabled for that zone only.');
define('MODULE_SHIPPING_TABLE_SORT_ORDER_TITLE' , 'Sort Order');
define('MODULE_SHIPPING_TABLE_SORT_ORDER_DESC' , 'Display sort order.');
?>