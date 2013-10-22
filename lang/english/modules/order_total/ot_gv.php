<?php
/* -----------------------------------------------------------------------------------------
   $Id: ot_gv.php 899 2005-04-29 02:40:57Z hhgag $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(ot_gv.php,v 1.1.2.1 2003/05/15); www.oscommerce.com

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contributions:

   Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
   http://www.oscommerce.com/community/contributions,282
   Copyright (c) Strider | Strider@oscworks.com
   Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
   Copyright (c) Andre ambidex@gmx.net
   Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

  define('MODULE_ORDER_TOTAL_GV_TITLE', 'Gift Vouchers');
  define('MODULE_ORDER_TOTAL_GV_HEADER', 'Gift Vouchers');
  define('MODULE_ORDER_TOTAL_GV_DESCRIPTION', 'Gift vouchers');
  define('SHIPPING_NOT_INCLUDED', ' [Shipping not included]');
  define('TAX_NOT_INCLUDED', ' [Tax not included]');
  define('MODULE_ORDER_TOTAL_GV_USER_PROMPT', 'Tick to use gift voucher account balance ->&nbsp;');
  define('TEXT_ENTER_GV_CODE', 'Enter redeem code&nbsp;&nbsp;');
  
  define('MODULE_ORDER_TOTAL_GV_STATUS_TITLE', 'Display Total');
  define('MODULE_ORDER_TOTAL_GV_STATUS_DESC', 'Do you want to display the gift voucher value?');
  define('MODULE_ORDER_TOTAL_GV_SORT_ORDER_TITLE', 'Sort Order');
  define('MODULE_ORDER_TOTAL_GV_SORT_ORDER_DESC', 'Display sort order');
  define('MODULE_ORDER_TOTAL_GV_QUEUE_TITLE', 'Queue Purchases');
  define('MODULE_ORDER_TOTAL_GV_QUEUE_DESC', 'Do you want to queue gift voucher purchases?');
  define('MODULE_ORDER_TOTAL_GV_INC_SHIPPING_TITLE', 'Include Shipping');
  define('MODULE_ORDER_TOTAL_GV_INC_SHIPPING_DESC', 'Include shipping in the calculation');
  define('MODULE_ORDER_TOTAL_GV_INC_TAX_TITLE', 'Incl. Sales Tax');
  define('MODULE_ORDER_TOTAL_GV_INC_TAX_DESC', 'Include sales tax in the calculation.');
  define('MODULE_ORDER_TOTAL_GV_CALC_TAX_TITLE', 'Recalculate Sales Tax');
  define('MODULE_ORDER_TOTAL_GV_CALC_TAX_DESC', 'Recalculate sales tax');
  define('MODULE_ORDER_TOTAL_GV_TAX_CLASS_TITLE', 'Sales Tax Rate');
  define('MODULE_ORDER_TOTAL_GV_TAX_CLASS_DESC', 'Apply the following sales tax rate when processing a gift voucher as a credit note.');
  define('MODULE_ORDER_TOTAL_GV_CREDIT_TAX_TITLE', 'Credit Includes Sales Tax');
  define('MODULE_ORDER_TOTAL_GV_CREDIT_TAX_DESC', 'Add sales tax to gift voucher value when crediting to account');

?>