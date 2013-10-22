<?php
/* --------------------------------------------------------------
   ot_payment.php 2008-08-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

$Id: ot_payment.php,v 1.2.2 2005/10/21 09:59:36 Anotherone Exp $

  André Estel / Estelco http://www.estelco.de

  Copyright (C) 2005 Estelco

  based on:
  Andreas Zimmermann / IT eSolutions http://www.it-esolutions.de

  Copyright (C) 2004 IT eSolutions
  -----------------------------------------------------------------------------------------

  (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com 

  Released under the GNU General Public License

  ---------------------------------------------------------------------------------------*/

  define('MODULE_ORDER_TOTAL_PAYMENT_TITLE', 'Payment Type Discount');
  define('MODULE_ORDER_TOTAL_PAYMENT_DESCRIPTION', 'Payment type discount');
  define('DISC_SHIPPING_NOT_INCLUDED', ' [Shipping not included]');
  define('DISC_TAX_NOT_INCLUDED', ' [Tax not included]');
 
  define('MODULE_ORDER_TOTAL_PAYMENT_SHIPPING_NOT_INCLUDED', ' [Shipping not included]');
  define('MODULE_ORDER_TOTAL_PAYMENT_TAX_NOT_INCLUDED', ' [Tax not included]');

  define('MODULE_ORDER_TOTAL_PAYMENT_STATUS_TITLE', 'Display Discount');
  define('MODULE_ORDER_TOTAL_PAYMENT_STATUS_DESC', 'Do you want to enable the order discount?');

  define('MODULE_ORDER_TOTAL_PAYMENT_SORT_ORDER_TITLE', 'Sort Order');
  define('MODULE_ORDER_TOTAL_PAYMENT_SORT_ORDER_DESC', 'Display sort order');

  define('MODULE_ORDER_TOTAL_PAYMENT_PERCENTAGE_TITLE', 'First Discount Percentage');
  define('MODULE_ORDER_TOTAL_PAYMENT_PERCENTAGE_DESC', 'Amount of discount (value:percentage)');

  define('MODULE_ORDER_TOTAL_PAYMENT_PERCENTAGE2_TITLE', 'Second Discount Percentage');
  define('MODULE_ORDER_TOTAL_PAYMENT_PERCENTAGE2_DESC', 'Amount of discount (value:percentage)');

  define('MODULE_ORDER_TOTAL_PAYMENT_TYPE_TITLE', 'First Payment Type');
  define('MODULE_ORDER_TOTAL_PAYMENT_TYPE_DESC', 'Payment type to receive discount');

  define('MODULE_ORDER_TOTAL_PAYMENT_TYPE_TITLE', 'Second Payment Type');
  define('MODULE_ORDER_TOTAL_PAYMENT_TYPE_DESC', 'Payment type to receive discount');
  
  define('MODULE_ORDER_TOTAL_PAYMENT_TYPE2_TITLE', 'Second Payment Type');
  define('MODULE_ORDER_TOTAL_PAYMENT_TYPE2_DESC', 'Payment type to receive discount');

  define('MODULE_ORDER_TOTAL_PAYMENT_INC_SHIPPING_TITLE', 'Include Shipping');
  define('MODULE_ORDER_TOTAL_PAYMENT_INC_SHIPPING_DESC', 'Include shipping in the calculation');

  define('MODULE_ORDER_TOTAL_PAYMENT_INC_TAX_TITLE', 'Include Sales Tax');
  define('MODULE_ORDER_TOTAL_PAYMENT_INC_TAX_DESC', 'Include sales tax in the calculation');

  define('MODULE_ORDER_TOTAL_PAYMENT_CALC_TAX_TITLE', 'Calculate Sales Tax');
  define('MODULE_ORDER_TOTAL_PAYMENT_CALC_TAX_DESC', 'Recalculate sales tax on discounted amount');

  define('MODULE_ORDER_TOTAL_PAYMENT_ALLOWED_TITLE', 'Allowed Zones');
  define('MODULE_ORDER_TOTAL_PAYMENT_ALLOWED_DESC' , 'Please enter the zones <b>individually</b> that should be allowed to use this module ((e.g. US, UK) leave blank to allow all zones))');

  define('MODULE_ORDER_TOTAL_PAYMENT_TITLE', 'Discount');
  define('MODULE_ORDER_TOTAL_PAYMENT_DESCRIPTION', 'Discount for payment');

  define('MODULE_ORDER_TOTAL_PAYMENT_AMOUNT1', 'Money Order Discount');
  define('MODULE_ORDER_TOTAL_PAYMENT_AMOUNT2', 'COD Discount');

  define('MODULE_ORDER_TOTAL_PAYMENT_TAX_CLASS_TITLE','Tax Class');
  define('MODULE_ORDER_TOTAL_PAYMENT_TAX_CLASS_DESC','Apply the following tax class to the low order fee.');
  
  ?>