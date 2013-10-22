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
  define('MODULE_ORDER_TOTAL_KLARNA_FEE_STATUS_TITLE', 'Rechnungsgebühren anzeigen');
  define('MODULE_ORDER_TOTAL_KLARNA_FEE_STATUS_DESC', 'Sollen die Rechnungsgebühren angezeigt werden?');
  define('MODULE_ORDER_TOTAL_KLARNA_FEE_SORT_ORDER_TITLE', 'Reihenfolge sortieren');
  define('MODULE_ORDER_TOTAL_KLARNA_FEE_SORT_ORDER_DESC', 'Anzeige  sortieren');
  define('MODULE_ORDER_TOTAL_KLARNA_FEE_MODE_TITLE', 'Feste Rechnungsgebühr oder an die Gesamtsumme angepasst?');
  define('MODULE_ORDER_TOTAL_KLARNA_FEE_MODE_DESC', 'Rechnungsgebühr ist fest oder an die Gesamtsumme angepasst.');
  define('MODULE_ORDER_TOTAL_KLARNA_FEE_TAX_CLASS_TITLE', 'Steuerklasse');
  define('MODULE_ORDER_TOTAL_KLARNA_FEE_TAX_CLASS_DESC', 'Verwenden Sie die folgende Steuerklasse für die Rechnungsgebühr.');

define('MODULE_ORDER_TOTAL_KLARNA_FEE_FIXED_SE_TITLE', '(<img src="' . KlarnaUtils::getWebRoot() . 'checkout/flags/sv.png" border="0" /> SE) Feste Rechnungsgebühr');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_FIXED_SE_DESC', 'Feste Rechnungsgebühr (inkl. MwSt.) SEK.');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_TABLE_SE_TITLE', '(<img src="' . KlarnaUtils::getWebRoot() . 'checkout/flags/sv.png" border="0" /> SE) Gebührentabelle');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_TABLE_SE_DESC', 'Die Rechnungsgebühr ist an die Gesamtsumme angepasst. Beispiel: 200:20,500:10,1000:5, etc.. Bis zu 200 Gebühr 20, von dort bis zu 500 Gebühr 10, etc');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_FIXED_DK_TITLE', '(<img src="' . KlarnaUtils::getWebRoot() . 'checkout/flags/da.png" border="0" /> DK) Feste Rechnungsgebühr');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_FIXED_DK_DESC', 'Feste Rechnungsgebühr (inkl. MwSt.) DKK.');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_TABLE_DK_TITLE', '(<img src="' . KlarnaUtils::getWebRoot() . 'checkout/flags/da.png" border="0" /> DK) Gebührentabelle');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_TABLE_DK_DESC', 'Die Rechnungsgebühr ist an die Gesamtsumme angepasst. Beispiel: 200:20,500:10,1000:5, etc.. Bis zu 200 Gebühr 20, von dort bis zu 500 Gebühr 10, etc');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_FIXED_FI_TITLE', '(<img src="' . KlarnaUtils::getWebRoot() . 'checkout/flags/fi.png" border="0" /> FI) Feste Rechnungsgebühr');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_FIXED_FI_DESC', 'Feste Rechnungsgebühr (inkl. MwSt.) EUR.');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_TABLE_FI_TITLE', '(<img src="' . KlarnaUtils::getWebRoot() . 'checkout/flags/fi.png" border="0" /> FI) Gebührentabelle');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_TABLE_FI_DESC', 'Die Rechnungsgebühr ist an die Gesamtsumme angepasst. Beispiel: 200:20,500:10,1000:5, etc.. Bis zu 200 Gebühr 20, von dort bis zu 500 Gebühr 10, etc');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_FIXED_DE_TITLE', '(<img src="' . KlarnaUtils::getWebRoot() . 'checkout/flags/de.png" border="0" /> DE) Feste Rechnungsgebühr');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_FIXED_DE_DESC', 'Feste Rechnungsgebühr (inkl. MwSt.) EUR.');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_TABLE_DE_TITLE', '(<img src="' . KlarnaUtils::getWebRoot() . 'checkout/flags/de.png" border="0" /> DE) Gebührentabelle');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_TABLE_DE_DESC', 'Die Rechnungsgebühr ist an die Gesamtsumme angepasst. Beispiel: 200:20,500:10,1000:5, etc.. Bis zu 200 Gebühr 20, von dort bis zu 500 Gebühr 10, etc');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_FIXED_NL_TITLE', '(<img src="' . KlarnaUtils::getWebRoot() . 'checkout/flags/nl.png" border="0" /> NL) Feste Rechnungsgebühr');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_FIXED_NL_DESC', 'Feste Rechnungsgebühr (inkl. MwSt.) EUR.');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_TABLE_NL_TITLE', '(<img src="' . KlarnaUtils::getWebRoot() . 'checkout/flags/nl.png" border="0" /> NL) Gebührentabelle');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_TABLE_NL_DESC', 'Die Rechnungsgebühr ist an die Gesamtsumme angepasst. Beispiel: 200:20,500:10,1000:5, etc.. Bis zu 200 Gebühr 20, von dort bis zu 500 Gebühr 10, etc');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_FIXED_NO_TITLE', '(<img src="' . KlarnaUtils::getWebRoot() . 'checkout/flags/nb.png" border="0" /> NO) Feste Rechnungsgebühr');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_FIXED_NO_DESC', 'Feste Rechnungsgebühr (inkl. MwSt.) NOK.');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_TABLE_NO_TITLE', '(<img src="' . KlarnaUtils::getWebRoot() . 'checkout/flags/nb.png" border="0" /> NO) Gebührentabelle');
define('MODULE_ORDER_TOTAL_KLARNA_FEE_TABLE_NO_DESC', 'Die Rechnungsgebühr ist an die Gesamtsumme angepasst. Beispiel: 200:20,500:10,1000:5, etc.. Bis zu 200 Gebühr 20, von dort bis zu 500 Gebühr 10, etc');