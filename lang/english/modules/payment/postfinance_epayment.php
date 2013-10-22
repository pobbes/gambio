<?php
/* -----------------------------------------------------------------------------------------
   $Id: postfinance_epayment.php,v1.2 2012/02/14 swisswebXperts N�f

   Changelog:
   v1.2
   - Images constants
   
   v1.1
   - Links to postfinance and swisswebxperts

	 Copyright (c) 2009 swisswebXperts N�f www.swisswebxperts.ch
	 Released under the GNU General Public License (Version 2)
	 [http://www.gnu.org/licenses/gpl-2.0.html]
   ---------------------------------------------------------------------------------------*/

define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_TEXT_TITLE', 'Postfinance e-payment');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_TEXT_DESCRIPTION', 'Postfinance e-payment <br />Information: <a href="http://www.postfinance.ch/pf/content/de/seg/biz/product/eserv/epay/seller/offer.html" target="_blank">www.postfinance.ch</a><br />Support: <a href="http://www.swisswebxperts.ch/postfinance.php" target="_blank">www.swisswebXperts.ch</a>');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_TEXT_INFO', '');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_TEXT_ERROR', 'Postfinance e-payment - Transaction failure');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_ERROR', 'The payment has been denied by the postfinance!');	
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_LANGUAGE_TITLE', 'User interface language');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_LANGUAGE_DESC', 'Language in which the postfinance user interface is showing');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_PSPID_TITLE', 'PSPID');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_PSPID_DESC', 'Your postfinance account name');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_ALLOWED_TITLE' , 'Allowed zones');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_ALLOWED_DESC' , 'Enter the zones <b>separately</b> in which this module is allowed (e.x. CH,AT,DE (leave blank for all zones))');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_STATUS_TITLE' , 'Postfinance module activation');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_STATUS_DESC' , 'Do you want accept payments with postfinance?');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_ID_TITLE' , 'e-mail address');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_ID_DESC' , 'e-mail Adresse, used by postfinance');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_PROD_TITLE', 'Test- or productivelink');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_PROD_DESC', 'Choose True, if your shop is in productive use or False if not');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_IMAGES_TITLE', 'Show payment icons');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_IMAGES_DESC', '(ex. postcard,visa,master,amex,diners)');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_CURRENCY_TITLE' , 'Currency');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_CURRENCY_DESC' , 'Used currency by postfinance');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_SORT_ORDER_TITLE' , 'Order show');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_SORT_ORDER_DESC' , 'Oder showing. Deeper is shown first');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_ZONE_TITLE' , 'Paymentzone');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_ZONE_DESC' , 'If a zone is selected then this payment method takes effect');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_ORDER_STATUS_ID_TITLE' , 'Order status');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_ORDER_STATUS_ID_DESC' , 'Set order status to this value');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_SHA1_SIGNATURE_TITLE', 'SHA-1 signature');
define('MODULE_PAYMENT_POSTFINANCE_EPAYMENT_SHA1_SIGNATURE_DESC', 'Your SHA-1 signature for the security check');
	
?>