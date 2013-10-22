<?php
/**
 *  Copyright 2010 KLARNA AB. All rights reserved.
 *
 *  Redistribution and use in source and binary forms, with or without modification, are
 *  permitted provided that the following conditions are met:
 *
 *     1. Redistributions of source code must retain the above copyright notice, this list of
 *        conditions and the following disclaimer.
 *
 *     2. Redistributions in binary form must reproduce the above copyright notice, this list
 *        of conditions and the following disclaimer in the documentation and/or other materials
 *        provided with the distribution.
 *
 *  THIS SOFTWARE IS PROVIDED BY KLARNA AB "AS IS" AND ANY EXPRESS OR IMPLIED
 *  WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND
 *  FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL KLARNA AB OR
 *  CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 *  CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
 *  SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
 *  ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 *  NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF
 *  ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 *  The views and conclusions contained in the software and documentation are those of the
 *  authors and should not be interpreted as representing official policies, either expressed
 *  or implied, of KLARNA AB.
 *
 */
 /* --------------------------------------------------------------
Released under the GNU General Public License (Version 2)
[http://www.gnu.org/licenses/gpl-2.0.html]
--------------------------------------------------------------
*/
include_once(DIR_FS_DOCUMENT_ROOT . 'includes/modules/klarna/klarnautils.php');
  // Translations in installer
  define('MODULE_PAYMENT_KLARNA_ALLOWED_TITLE', 'Allowed Zones');
  define('MODULE_PAYMENT_KLARNA_ALLOWED_DESC', 'Please enter the zones separately which should be allowed to use this modul (e. g. AT,DE (leave empty if you want to allow all zones))');
  define('MODULE_PAYMENT_KLARNA_STATUS_TITLE', 'Enable Klarna module');
  define('MODULE_PAYMENT_KLARNA_STATUS_DESC', 'Do you want to accept Klarna payments?');
  define('MODULE_PAYMENT_KLARNA_ORDER_STATUS_ID_TITLE', 'Set Order Status');
  define('MODULE_PAYMENT_KLARNA_ORDER_STATUS_ID_DESC', 'Set the status of orders made with this payment module to this value');
  define('MODULE_PAYMENT_KLARNA_ARTNO_TITLE', 'Product artno attribute (id or model)');
  define('MODULE_PAYMENT_KLARNA_ARTNO_DESC', 'Use the following product attribute for ArtNo.');
  define('MODULE_PAYMENT_KLARNA_AUTO_ACTIVATE_TITLE', 'Enable Auto Activate');
  define('MODULE_PAYMENT_KLARNA_AUTO_ACTIVATE_DESC', 'Do you want to enable invoice auto activate?');
  define('MODULE_PAYMENT_KLARNA_AUTO_ACTIVATE_SEND_DELAY_TITLE', 'Activate delay (days)');
  define('MODULE_PAYMENT_KLARNA_AUTO_ACTIVATE_SEND_DELAY_DESC', 'When auto activating delay sending the invoice for x days.');

  define('MODULE_PAYMENT_KLARNA_ZONE_TITLE', 'Payment Zone');
  define('MODULE_PAYMENT_KLARNA_ZONE_DESC', 'If a zone is selected, only enable this payment method for that zone.');

  define('MODULE_PAYMENT_KLARNA_SORT_ORDER_TITLE', 'Sort order of display.');
  define('MODULE_PAYMENT_KLARNA_SORT_ORDER_DESC', 'Sort order of display. Lowest is displayed first.');
  define('MODULE_PAYMENT_KLARNA_LIVEMODE_TITLE', 'Live Server');
  define('MODULE_PAYMENT_KLARNA_LIVEMODE_DESC', 'Do you want to use Klarna LIVE server (true) or BETA server (false)?');
  define('MODULE_PAYMENT_KLARNA_TESTMODE_TITLE', 'Testmode');
  define('MODULE_PAYMENT_KLARNA_TESTMODE_DESC', 'Do you want to activate the Testmode? We will not pay for the invoices created with the test persons nor companies and we will not collect any fees as well.');

  define('MODULE_PAYMENT_KLARNA_INVOICE_TEXT_TITLE', 'Klarna Invoice');

  define('MODULE_PAYMENT_KLARNA_TEXT_TITLE', 'Klarna Invoice');
  define('MODULE_PAYMENT_KLARNA_TEXT_DESCRIPTION', 'Invoice from Klarna');
  define('MODULE_PAYMENT_KLARNA_TEXT_CONFIRM_DESCRIPTION', 'Invoice from Klarna (<a href=\"http://www.klarna.com\">www.klarna.com</a>)');

  define('MODULE_PAYMENT_KLARNA_LATESTVERSION_TITLE', 'Check for latest version');
  define('MODULE_PAYMENT_KLARNA_LATESTVERSION_DESC', 'Do you want show an notification message on the module page when a newer version of this module is available?');

  define('MODULE_PAYMENT_KLARNA_INVOICE_ALLOWED_TITLE', 'Activated countries');
  define('MODULE_PAYMENT_KLARNA_INVOICE_ALLOWED_DESC', 'For which countries do you wish to offer Klarnas Invoice services? (sepperated by comma)');

  define('MODULE_PAYMENT_KLARNA_ORDER_STATUS_PENDING_ID_TITLE', 'Set Pending Order Status');
  define('MODULE_PAYMENT_KLARNA_ORDER_STATUS_PENDING_ID_DESC', 'Set the status of orders made with this payment module (with PENDING result) to this value');
  define('MODULE_PAYMENT_KLARNA_PC_URI_TITLE', 'PClass URI');
  define('MODULE_PAYMENT_KLARNA_PC_URI_DESC', 'Where do you wish to save the comunication file? (The klarna module needs to be able to write to this location, CHMOD 0700 required)');

  define('MODULE_PAYMENT_KLARNA_EID_SE_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/sv.png\" border=\'0\' /> SE Merchant ID');
  define('MODULE_PAYMENT_KLARNA_EID_SE_DESC', 'Swedish Merchant ID (estore id) to use for the Klarna service (provided by Klarna)');
  define('MODULE_PAYMENT_KLARNA_SECRET_SE_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/sv.png\" border=\'0\' /> SE Shared secret');
  define('MODULE_PAYMENT_KLARNA_SECRET_SE_DESC', 'Swedish shared secret to use with the Klarna service for (provided by Klarna)');
  define('MODULE_PAYMENT_KLARNA_ORDER_LIMIT_SE_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/sv.png\" border=\'0\' /> Credit limit');
  define('MODULE_PAYMENT_KLARNA_ORDER_LIMIT_SE_DESC', 'Only show this payment alternative for orders less than the value below.');

  define('MODULE_PAYMENT_KLARNA_EID_NO_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/nb.png\" border=\'0\' /> NO Merchant ID');
  define('MODULE_PAYMENT_KLARNA_EID_NO_DESC', 'Norwegian Merchant ID (estore id) to use for the Klarna service (provided by Klarna)');
  define('MODULE_PAYMENT_KLARNA_SECRET_NO_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/nb.png\" border=\'0\' /> NO Shared secret');
  define('MODULE_PAYMENT_KLARNA_SECRET_NO_DESC', 'Norwegian shared secret to use with the Klarna service for (provided by Klarna)');
  define('MODULE_PAYMENT_KLARNA_ORDER_LIMIT_NO_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/nb.png\" border=\'0\' /> Credit limit');
  define('MODULE_PAYMENT_KLARNA_ORDER_LIMIT_NO_DESC', 'Only show this payment alternative for orders less than the value below.');

  define('MODULE_PAYMENT_KLARNA_EID_DK_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/da.png\" border=\'0\' /> DK Merchant ID');
  define('MODULE_PAYMENT_KLARNA_EID_DK_DESC', 'Danish Merchant ID (estore id) to use for the Klarna service (provided by Klarna)');
  define('MODULE_PAYMENT_KLARNA_SECRET_DK_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/da.png\" border=\'0\' /> DK Shared secret');
  define('MODULE_PAYMENT_KLARNA_SECRET_DK_DESC', 'Danish shared secret to use with the Klarna service for (provided by Klarna)');
  define('MODULE_PAYMENT_KLARNA_ORDER_LIMIT_DK_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/da.png\" border=\'0\' /> Credit limit');
  define('MODULE_PAYMENT_KLARNA_ORDER_LIMIT_DK_DESC', 'Only show this payment alternative for orders less than the value below.');

  define('MODULE_PAYMENT_KLARNA_EID_FI_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/fi.png\" border=\'0\' /> FI Merchant ID');
  define('MODULE_PAYMENT_KLARNA_EID_FI_DESC', 'Finnish Merchant ID (estore id) to use for the Klarna service (provided by Klarna)');
  define('MODULE_PAYMENT_KLARNA_SECRET_FI_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/fi.png\" border=\'0\' /> FI Shared secret');
  define('MODULE_PAYMENT_KLARNA_SECRET_FI_DESC', 'Finnish shared secret to use with the Klarna service for (provided by Klarna)');
  define('MODULE_PAYMENT_KLARNA_ORDER_LIMIT_FI_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/fi.png\" border=\'0\' /> Credit limit');
  define('MODULE_PAYMENT_KLARNA_ORDER_LIMIT_FI_DESC', 'Only show this payment alternative for orders less than the value below.');

  define('MODULE_PAYMENT_KLARNA_EID_DE_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/de.png\" border=\'0\' /> DE Merchant ID');
  define('MODULE_PAYMENT_KLARNA_EID_DE_DESC', 'German Merchant ID (estore id) to use for the Klarna service (provided by Klarna)');
  define('MODULE_PAYMENT_KLARNA_SECRET_DE_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/de.png\" border=\'0\' /> DE Shared secret');
  define('MODULE_PAYMENT_KLARNA_SECRET_DE_DESC', 'German shared secret to use with the Klarna service for (provided by Klarna)');
  define('MODULE_PAYMENT_KLARNA_ORDER_LIMIT_DE_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/de.png\" border=\'0\' /> Credit limit');
  define('MODULE_PAYMENT_KLARNA_ORDER_LIMIT_DE_DESC', 'Only show this payment alternative for orders less than the value below.');

  define('MODULE_PAYMENT_KLARNA_EID_NL_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/nl.png\" border=\'0\' /> NL Merchant ID');
  define('MODULE_PAYMENT_KLARNA_EID_NL_DESC', 'Dutch Merchant ID (estore id) to use for the Klarna service (provided by Klarna)');
  define('MODULE_PAYMENT_KLARNA_SECRET_NL_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/nl.png\" border=\'0\' /> NL Shared secret');
  define('MODULE_PAYMENT_KLARNA_SECRET_NL_DESC', 'Dutch shared secret to use with the Klarna service for (provided by Klarna)');
  define('MODULE_PAYMENT_KLARNA_ORDER_LIMIT_NL_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/nl.png\" border=\'0\' /> Credit limit');
  define('MODULE_PAYMENT_KLARNA_ORDER_LIMIT_NL_DESC', 'Only show this payment alternative for orders less than the value below.');