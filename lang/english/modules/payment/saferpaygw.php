<?php
/* -----------------------------------------------------------------------------------------
   $Id: saferpaygw.php,v 1.0 2005/03/01 14:19:25 atmiral Exp $   

   for XT-Commerce
   http://www.xt-commerce.com

   Copyright (c) 2006 Alexander Federau
   -----------------------------------------------------------------------------------------

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  define('MODULE_PAYMENT_SAFERPAYGW_TEXT_TITLE', 'Credit Card, Direct Debit<br />payment using Saferpay');
  define('MODULE_PAYMENT_SAFERPAYGW_TEXT_DESCRIPTION', '<b>Saferpay-Payment</b><br />'.(defined('MODULE_PAYMENT_SAFERPAYGW_STATUS') && MODULE_PAYMENT_SAFERPAYGW_STATUS=='true' && ($admin_access['saferpay'] == '1')?'(<a style="color:red" href="'.xtc_href_link('saferpay.php').'">Show Transactions</a>)<br />':'').'<br /><b>Saferpay Test account</b><br />ACCOUNTID: 99867-94913159<br />Test card: 9451123100000004<br />valid to: 12/10, CVC 123<br /><br />Test card for 3D-Secure: 9451123100000111<br />Valid to: 12/10, CVC 123<br /><br /><b>Login to Backoffice<br /><a href="http://www.saferpay.com">www.saferpay.com:</a></b><br />User: e99867001<br />Password: XAjc3Kna');
  define('SAFERPAYGW_ERROR_HEADING', 'There has been an error connecting to saferpay server.');
  define('SAFERPAYGW_ERROR_MESSAGE', 'Please check your credit card details!');

  define('TEXT_SAFERPAYGW_CONFIRMATION_ERROR', 'There has been an error confirmation your payment');
  define('TEXT_SAFERPAYGW_CAPTURING_ERROR', 'There has been an error capturing your credit card');
  define('TEXT_SAFERPAYGW_SETUP_ERROR', 'There has been an error creating request! Please check your setings!');
  
  define('MODULE_PAYMENT_SAFERPAYGW_STATUS_TITLE', 'Enable Saferpay Module');
  define('MODULE_PAYMENT_SAFERPAYGW_STATUS_DESC', 'Do you want to accept Saferpay payments?');
  define('MODULE_PAYMENT_SAFERPAYGW_ALLOWED_TITLE', 'Allowed Zones');
  define('MODULE_PAYMENT_SAFERPAYGW_ALLOWED_DESC', 'Please enter the zones <b>separately</b> which should be allowed to use this modul (e. g. AT,DE (leave empty if you want to allow all zones))');
  define('MODULE_PAYMENT_SAFERPAYGW_SORT_ORDER_TITLE', 'Sort order of display');
  define('MODULE_PAYMENT_SAFERPAYGW_SORT_ORDER_DESC', 'Sort order of display. Lowest is displayed first.');
  define('MODULE_PAYMENT_SAFERPAYGW_ZONE_TITLE', '<hr><br />Payment Zone');
  define('MODULE_PAYMENT_SAFERPAYGW_ZONE_DESC', 'If a zone is selected, only enable this payment method for that zone.');
  define('MODULE_PAYMENT_SAFERPAYGW_ORDER_STATUS_ID_TITLE', 'Set Order Status');
  define('MODULE_PAYMENT_SAFERPAYGW_ORDER_STATUS_ID_DESC', 'Set the status of orders made with this payment module to this value');
  define('MODULE_PAYMENT_SAFERPAYGW_CURRENCY_TITLE', 'Transaction Currency');
  define('MODULE_PAYMENT_SAFERPAYGW_CURRENCY_DESC', 'The currency to use for credit card transactions');

  define('MODULE_PAYMENT_SAFERPAYGW_LOGIN_TITLE', 'Account Number');
  define('MODULE_PAYMENT_SAFERPAYGW_LOGIN_DESC', 'The account number used for the saferpay service');
  define('MODULE_PAYMENT_SAFERPAYGW_PASSWORD_TITLE', 'User Password');
  define('MODULE_PAYMENT_SAFERPAYGW_PASSWORD_DESC', 'The user password for the saferpay service');
  define('MODULE_PAYMENT_SAFERPAYGW_ACCOUNT_ID_TITLE', 'User ID');
  define('MODULE_PAYMENT_SAFERPAYGW_ACCOUNT_ID_DESC', 'The user ID for the saferpay service');
  define('MODULE_PAYMENT_SAFERPAYGW_URLREADER_TITLE' , 'Function to read URL');
  define('MODULE_PAYMENT_SAFERPAYGW_URLREADER_DESC' , 'Whisch method should be used to read URLs');
  define('MODULE_PAYMENT_SAFERPAYGW_PAYINIT_URL_TITLE' , 'PayInit URL');
  define('MODULE_PAYMENT_SAFERPAYGW_PAYINIT_URL_DESC' , 'URL für Initialisierung der Zahlung');
  define('MODULE_PAYMENT_SAFERPAYGW_CONFIRM_URL_TITLE' , 'PayConfirm URL');
  define('MODULE_PAYMENT_SAFERPAYGW_CONFIRM_URL_DESC' , 'URL für Bestätigung der Zahlung');
  define('MODULE_PAYMENT_SAFERPAYGW_COMPLETE_URL_TITLE' , 'PayComplete URL');
  define('MODULE_PAYMENT_SAFERPAYGW_COMPLETE_URL_DESC' , 'URL für Abschliesen der Zahlung');

  define('MODULE_PAYMENT_SAFERPAYGW_CCCVC_TITLE', 'CVC Eingabe');
  define('MODULE_PAYMENT_SAFERPAYGW_CCCVC_DESC', 'Ist die CVC Eingabe erforderlich?');
  define('MODULE_PAYMENT_SAFERPAYGW_CCNAME_TITLE', 'Karteninhaber');
  define('MODULE_PAYMENT_SAFERPAYGW_CCNAME_DESC', 'Ist die Eingabe des Karteninhabers erforderlich?');
  
  define('MODULE_PAYMENT_SAFERPAYGW_COMPLETE_TITLE', 'Complete transaction?');
  define('MODULE_PAYMENT_SAFERPAYGW_COMPLETE_DESC', 'Should Saferpay transaction be completed?');
  define('MODULE_PAYMENT_SAFERPAYGW_MENUCOLOR_TITLE', '<hr>Styling params of Saferpay VT (mandatory)&nbsp;<a href="images/saferpaygw_styling.jpg" target=_blank><img src="images/icons/graphics/unknown.jpg" width="15" border="0" alt="Help"></a><br /><br />MENUCOLOR');
  define('MODULE_PAYMENT_SAFERPAYGW_MENUCOLOR_DESC', 'Specifies the color of the VT menu bar background.');
  define('MODULE_PAYMENT_SAFERPAYGW_MENUFONTCOLOR_TITLE', 'MENUFONTCOLOR');
  define('MODULE_PAYMENT_SAFERPAYGW_MENUFONTCOLOR_DESC', 'Specifies the font color of Saferpay VT menu.');
  define('MODULE_PAYMENT_SAFERPAYGW_BODYFONTCOLOR_TITLE', 'BODYFONTCOLOR');
  define('MODULE_PAYMENT_SAFERPAYGW_BODYFONTCOLOR_DESC', 'Specifies the font color of the VT body area.');
  define('MODULE_PAYMENT_SAFERPAYGW_BODYCOLOR_TITLE', 'BODYCOLOR');
  define('MODULE_PAYMENT_SAFERPAYGW_BODYCOLOR_DESC', 'Specifies the color of the VT body in HTML format.');
  define('MODULE_PAYMENT_SAFERPAYGW_HEADFONTCOLOR_TITLE', 'HEADFONTCOLOR');
  define('MODULE_PAYMENT_SAFERPAYGW_HEADFONTCOLOR_DESC', 'Specifies the font color of the VT head.');
  define('MODULE_PAYMENT_SAFERPAYGW_HEADCOLOR_TITLE', 'HEADCOLOR');
  define('MODULE_PAYMENT_SAFERPAYGW_HEADCOLOR_DESC', 'Specifies the color of the header of the VT header.');
  define('MODULE_PAYMENT_SAFERPAYGW_HEADLINECOLOR_TITLE', 'HEADLINECOLOR');
  define('MODULE_PAYMENT_SAFERPAYGW_HEADLINECOLOR_DESC', 'Specifies the color of the head-line.');
  define('MODULE_PAYMENT_SAFERPAYGW_LINKCOLOR_TITLE', 'LINKCOLOR');
  define('MODULE_PAYMENT_SAFERPAYGW_LINKCOLOR_DESC', 'Specifies the font color of the links of the body area.');
?>