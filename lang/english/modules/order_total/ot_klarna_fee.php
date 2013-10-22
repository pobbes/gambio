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

//Translations in installer
define('MODULE_ORDER_TOTAL_KLARNA_FEE_STATUS_TITLE', 'Display the invoice fee');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_STATUS_DESC', 'Do you want to display the invoice fee');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_SORT_ORDER_TITLE', 'Sort order');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_SORT_ORDER_DESC', 'Sort order of display.');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_MODE_TITLE', 'Fixed invoice fee or based on order total?');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_MODE_DESC', 'Invoice fee is fixed or based  on the order total.');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_TAX_CLASS_TITLE', 'Tax class');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_TAX_CLASS_DESC', 'Use the following tax class on the invoice fee.');

define('MODULE_ORDER_TOTAL_KLARNA_FEE_FIXED_SE_TITLE', '(<img src="' . KlarnaUtils::getWebRoot() . 'checkout/flags/sv.png" border="0" /> SE) Fixed invoice fee');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_FIXED_SE_DESC', 'Fixed invoice fee (inc. VAT) in SEK.');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_TABLE_SE_TITLE', '(<img src="' . KlarnaUtils::getWebRoot() . 'checkout/flags/sv.png" border="0" /> SE) Fee Table');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_TABLE_SE_DESC', 'The invoice fee is based on the total cost. Example: 200:20,500:10,1000:5,etc.. Up to 200 charge 20, from there to 500 charge 10, etc');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_FIXED_DK_TITLE', '(<img src="' . KlarnaUtils::getWebRoot() . 'checkout/flags/da.png" border="0" /> DK) Fixed invoice fee');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_FIXED_DK_DESC', 'Fixed invoice fee (inc. VAT) in DKK.');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_TABLE_DK_TITLE', '(<img src="' . KlarnaUtils::getWebRoot() . 'checkout/flags/da.png" border="0" /> DK) Fee Table');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_TABLE_DK_DESC', 'The invoice fee is based on the total cost. Example: 200:20,500:10,1000:5,etc.. Up to 200 charge 20, from there to 500 charge 10, etc');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_FIXED_FI_TITLE', '(<img src="' . KlarnaUtils::getWebRoot() . 'checkout/flags/fi.png" border="0" /> FI) Fixed invoice fee');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_FIXED_FI_DESC', 'Fixed invoice fee (inc. VAT) in EUR.');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_TABLE_FI_TITLE', '(<img src="' . KlarnaUtils::getWebRoot() . 'checkout/flags/fi.png" border="0" /> FI) Fee Table');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_TABLE_FI_DESC', 'The invoice fee is based on the total cost. Example: 200:20,500:10,1000:5,etc.. Up to 200 charge 20, from there to 500 charge 10, etc');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_FIXED_DE_TITLE', '(<img src="' . KlarnaUtils::getWebRoot() . 'checkout/flags/de.png" border="0" /> DE) Fixed invoice fee');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_FIXED_DE_DESC', 'Fixed invoice fee (inc. VAT) in EUR.');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_TABLE_DE_TITLE', '(<img src="' . KlarnaUtils::getWebRoot() . 'checkout/flags/de.png" border="0" /> DE) Fee Table');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_TABLE_DE_DESC', 'The invoice fee is based on the total cost. Example: 200:20,500:10,1000:5,etc.. Up to 200 charge 20, from there to 500 charge 10, etc');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_FIXED_NL_TITLE', '(<img src="' . KlarnaUtils::getWebRoot() . 'checkout/flags/nl.png" border="0" /> NL) Fixed invoice fee');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_FIXED_NL_DESC', 'Fixed invoice fee (inc. VAT) in EUR.');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_TABLE_NL_TITLE', '(<img src="' . KlarnaUtils::getWebRoot() . 'checkout/flags/nl.png" border="0" /> NL) Fee Table');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_TABLE_NL_DESC', 'The invoice fee is based on the total cost. Example: 200:20,500:10,1000:5,etc.. Up to 200 charge 20, from there to 500 charge 10, etc');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_FIXED_NO_TITLE', '(<img src="' . KlarnaUtils::getWebRoot() . 'checkout/flags/nb.png" border="0" /> NO) Fixed invoice fee');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_FIXED_NO_DESC', 'Fixed invoice fee (inc. VAT) in NOK.');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_TABLE_NO_TITLE', '(<img src="' . KlarnaUtils::getWebRoot() . 'checkout/flags/nb.png" border="0" /> NO) Fee Table');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_TABLE_NO_DESC', 'The invoice fee is based on the total cost. Example: 200:20,500:10,1000:5,etc.. Up to 200 charge 20, from there to 500 charge 10, etc');