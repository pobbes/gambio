<?php
/* --------------------------------------------------------------
   gv_sent.php 2008-08-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(gv_sent.php,v 1.1 2003/02/18); www.oscommerce.com
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: gv_sent.php 899 2005-04-29 02:40:57Z hhgag $)

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

define('HEADING_TITLE', 'Versandte Gutscheine');

// BOF GM_MOD
define('HEADING_SUB_TITLE', 'Hilfsprogramme');
// EOF GM_MOD

define('TABLE_HEADING_SENDERS_NAME', 'Absender');
define('TABLE_HEADING_VOUCHER_VALUE', 'Gutscheinwert');
define('TABLE_HEADING_VOUCHER_CODE', 'Gutschein-Code');
define('TABLE_HEADING_DATE_SENT', 'Versanddatum');
define('TABLE_HEADING_ACTION', 'Aktion');

define('TEXT_INFO_SENDERS_ID', 'Absender-Nr.:');
define('TEXT_INFO_AMOUNT_SENT', 'Betrag versandt:');
define('TEXT_INFO_DATE_SENT', 'Datum:');
define('TEXT_INFO_VOUCHER_CODE', 'Gutschein-Code:');
define('TEXT_INFO_EMAIL_ADDRESS', 'E-Mail-Adresse:');
define('TEXT_INFO_DATE_REDEEMED', 'Einl&ouml;sedatum:');
define('TEXT_INFO_IP_ADDRESS', 'IP-Adresse:');
define('TEXT_INFO_CUSTOMERS_ID', 'Kunden-Nr.:');
define('TEXT_INFO_NOT_REDEEMED', 'Nicht eingel&ouml;st');
?>