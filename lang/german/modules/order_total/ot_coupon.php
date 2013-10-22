<?php
/* --------------------------------------------------------------
   ot_coupon.php 2008-08-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(t_coupon.php,v 1.1.2.2 2003/05/15); www.oscommerce.com
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: ot_coupon.php 899 2005-04-29 02:40:57Z hhgag $)

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
global $gmLangFileMaster;
$gmLangFileMaster->define_lang_file_content('lang/german/modules/order_total/ot_coupon.php');
/*


  define('MODULE_ORDER_TOTAL_COUPON_TITLE', 'Rabatt Kupons');
  define('MODULE_ORDER_TOTAL_COUPON_HEADER', 'Gutscheine / Rabatt Kupons');
  define('MODULE_ORDER_TOTAL_COUPON_DESCRIPTION', 'Rabatt Kupon');
  define('SHIPPING_NOT_INCLUDED', ' [Versand nicht enthalten]');
  define('TAX_NOT_INCLUDED', ' [MwSt. nicht enthalten]');
  define('MODULE_ORDER_TOTAL_COUPON_USER_PROMPT', '');
  define('ERROR_NO_INVALID_REDEEM_COUPON', 'Ung&uuml;ltiger Gutscheincode');
  define('ERROR_INVALID_STARTDATE_COUPON', 'Dieser Gutschein ist noch nicht verf&uuml;gbar');
  define('ERROR_INVALID_FINISDATE_COUPON', 'Dieser Gutschein ist nicht mehr g&uuml;ltig');
  define('ERROR_INVALID_USES_COUPON', 'Dieser Gutschein kann nur ');
  define('TIMES', ' mal benutzt werden.');
  define('ERROR_INVALID_USES_USER_COUPON', 'Die maximale Nutzung dieses Gutscheines wurde erreicht.');
  define('REDEEMED_COUPON', 'ein Gutschein &uuml;ber ');
  define('REDEEMED_MIN_ORDER', 'f&uuml;r Waren &uuml;ber ');
  define('REDEEMED_RESTRICTIONS', ' [Artikel / Kategorie Einschr&auml;nkungen]');
  define('TEXT_ENTER_COUPON_CODE', 'Geben Sie hier Ihren Gutscheincode ein &nbsp;&nbsp;');
  
  define('MODULE_ORDER_TOTAL_COUPON_STATUS_TITLE', 'Wert anzeigen');
  define('MODULE_ORDER_TOTAL_COUPON_STATUS_DESC', 'M&ouml;chten Sie den Wert des Rabatt Kupons anzeigen?');
  define('MODULE_ORDER_TOTAL_COUPON_SORT_ORDER_TITLE', 'Sortierreihenfolge');
  define('MODULE_ORDER_TOTAL_COUPON_SORT_ORDER_DESC', 'Anzeigereihenfolge.');
  define('MODULE_ORDER_TOTAL_COUPON_INC_SHIPPING_TITLE', 'Inklusive Versandkosten');
  define('MODULE_ORDER_TOTAL_COUPON_INC_SHIPPING_DESC', 'Versandkosten an den Warenwert anrechnen');
  define('MODULE_ORDER_TOTAL_COUPON_INC_TAX_TITLE', 'Inklusive MwSt');
  define('MODULE_ORDER_TOTAL_COUPON_INC_TAX_DESC', 'MwSt. an den Warenwert anrechnen');
  define('MODULE_ORDER_TOTAL_COUPON_CALC_TAX_TITLE', 'MwSt. neu berechnen');
  define('MODULE_ORDER_TOTAL_COUPON_CALC_TAX_DESC', 'MwSt. neu berechnen');
  define('MODULE_ORDER_TOTAL_COUPON_TAX_CLASS_TITLE', 'MwSt.-Satz');
  define('MODULE_ORDER_TOTAL_COUPON_TAX_CLASS_DESC', 'Folgenden MwSt. Satz benutzen, wenn Sie den Rabatt Kupon als Gutschrift verwenden.');
	
*/
?>