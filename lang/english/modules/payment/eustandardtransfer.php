<?php
/* -----------------------------------------------------------------------------------------
   $Id: eustandardtransfer.php 998 2005-07-07 14:18:20Z mz $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(ptebanktransfer.php,v 1.4.1 2003/09/25 19:57:14); www.oscommerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

define('MODULE_PAYMENT_EUTRANSFER_TEXT_TITLE', 'EU Standard Bank Transfer');
define('MODULE_PAYMENT_EUSTANDARDTRANSFER_TEXT_TITLE', 'EU standard bank transfer');
define('MODULE_PAYMENT_EUTRANSFER_TEXT_DESCRIPTION', 
'<br />Please use the following details to transfer your total order value:<br />' .
'<br />Bank Name: ' . MODULE_PAYMENT_EUTRANSFER_BANKNAM .
'<br />Branch: ' . MODULE_PAYMENT_EUTRANSFER_BRANCH .
'<br />Account Name: ' . MODULE_PAYMENT_EUTRANSFER_ACCNAM .
'<br />Account No.: ' . MODULE_PAYMENT_EUTRANSFER_ACCNUM .
'<br />IBAN: ' . MODULE_PAYMENT_EUTRANSFER_ACCIBAN .
'<br />BIC/SWIFT: ' . MODULE_PAYMENT_EUTRANSFER_BANKBIC .
//'<br />Sort Code: ' . MODULE_PAYMENT_EUTRANSFER_SORTCODE .
'<br /><br />Your order will not ship until we receive payment into the above account.<br />');

define('MODULE_PAYMENT_EUTRANSFER_TEXT_EMAIL_FOOTER', str_replace('<br />','\n',MODULE_PAYMENT_EUTRANSFER_TEXT_DESCRIPTION));

define('MODULE_PAYMENT_EUTRANSFER_STATUS_TITLE','Allow Bank Transfer Payment');
define('MODULE_PAYMENT_EUTRANSFER_STATUS_DESC','Do you want to accept order payments via bank transfer?');
define('MODULE_PAYMENT_EUTRANSFER_TEXT_INFO','');
define('MODULE_PAYMENT_EUTRANSFER_BRANCH_TITLE','Location of Branch');
define('MODULE_PAYMENT_EUTRANSFER_BRANCH_DESC','The branch where your account is held.');

define('MODULE_PAYMENT_EUTRANSFER_BANKNAM_TITLE','Bank Name');
define('MODULE_PAYMENT_EUTRANSFER_BANKNAM_DESC','Full bank name');

define('MODULE_PAYMENT_EUTRANSFER_ACCNAM_TITLE','Bank Account Name');
define('MODULE_PAYMENT_EUTRANSFER_ACCNAM_DESC','The name in which the account is held.');

define('MODULE_PAYMENT_EUTRANSFER_ACCNUM_TITLE','Bank Account No.');
define('MODULE_PAYMENT_EUTRANSFER_ACCNUM_DESC','Your account number.');

define('MODULE_PAYMENT_EUTRANSFER_ACCIBAN_TITLE','Bank Account IBAN');
define('MODULE_PAYMENT_EUTRANSFER_ACCIBAN_DESC','International account ID.<br />(You can request this info from your bank)');

define('MODULE_PAYMENT_EUTRANSFER_BANKBIC_TITLE','Bank BIC');
define('MODULE_PAYMENT_EUTRANSFER_BANKBIC_DESC','International bank ID.<br />(You can request this info from your bank)');

define('MODULE_PAYMENT_EUTRANSFER_SORT_ORDER_TITLE','Display Sort Order');
define('MODULE_PAYMENT_EUTRANSFER_SORT_ORDER_DESC','Display sort order; the lowest value is displayed first.');

define('MODULE_PAYMENT_EUSTANDARDTRANSFER_ALLOWED_TITLE' , 'Allowed Zones');
define('MODULE_PAYMENT_EUSTANDARDTRANSFER_ALLOWED_DESC' , 'Please enter the zones <b>individually</b> that should be allowed to use this module (e.g. US, UK (leave blank to allow all zones))');

?>