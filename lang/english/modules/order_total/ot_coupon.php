<?php
/* -----------------------------------------------------------------------------------------
   $Id: ot_coupon.php 899 2005-04-29 02:40:57Z hhgag $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(t_coupon.php,v 1.1.2.2 2003/05/15); www.oscommerce.com

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

  define('MODULE_ORDER_TOTAL_COUPON_TITLE', 'Discount Coupons');
  define('MODULE_ORDER_TOTAL_COUPON_HEADER', 'Gift Vouchers/Discount Coupons');
  define('MODULE_ORDER_TOTAL_COUPON_DESCRIPTION', 'Discount coupon');
  define('SHIPPING_NOT_INCLUDED', ' [Shipping not included]');
  define('TAX_NOT_INCLUDED', ' [Tax not included]');
  define('MODULE_ORDER_TOTAL_COUPON_USER_PROMPT', '');
  define('ERROR_NO_INVALID_REDEEM_COUPON', 'Invalid coupon code');
  define('ERROR_INVALID_STARTDATE_COUPON', 'This coupon is not available yet');
  define('ERROR_INVALID_FINISDATE_COUPON', 'This coupon has expired');
  define('ERROR_INVALID_USES_COUPON', 'This coupon can only be used ');  
  define('TIMES', ' times.');
  define('ERROR_INVALID_USES_USER_COUPON', 'You have used the coupon the maximum number of times allowed per customer.'); 
  define('REDEEMED_COUPON', 'a coupon worth ');  
  define('REDEEMED_MIN_ORDER', 'on orders over ');  
  define('REDEEMED_RESTRICTIONS', ' [Product category restrictions apply]');  
  define('TEXT_ENTER_COUPON_CODE', 'Enter redeem code&nbsp;&nbsp;');
  
  define('MODULE_ORDER_TOTAL_COUPON_STATUS_TITLE', 'Display Total');
  define('MODULE_ORDER_TOTAL_COUPON_STATUS_DESC', 'Do you want to display the discount coupon value?');
  define('MODULE_ORDER_TOTAL_COUPON_SORT_ORDER_TITLE', 'Sort Order');
  define('MODULE_ORDER_TOTAL_COUPON_SORT_ORDER_DESC', 'Display sort order.');
  define('MODULE_ORDER_TOTAL_COUPON_INC_SHIPPING_TITLE', 'Include Shipping');
  define('MODULE_ORDER_TOTAL_COUPON_INC_SHIPPING_DESC', 'Include shipping in the calculation.');
  define('MODULE_ORDER_TOTAL_COUPON_INC_TAX_TITLE', 'Include Sales Tax');
  define('MODULE_ORDER_TOTAL_COUPON_INC_TAX_DESC', 'Include sales tax in the calculation.');
  define('MODULE_ORDER_TOTAL_COUPON_CALC_TAX_TITLE', 'Recalculate Sales Tax');
  define('MODULE_ORDER_TOTAL_COUPON_CALC_TAX_DESC', 'Recalculate sales tax');
  define('MODULE_ORDER_TOTAL_COUPON_TAX_CLASS_TITLE', 'Sales Tax');
  define('MODULE_ORDER_TOTAL_COUPON_TAX_CLASS_DESC', 'Apply the following sales tax rate when processing a discount coupon as a credit note.');

?>