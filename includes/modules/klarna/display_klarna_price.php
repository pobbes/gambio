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
include_once('class.Klarna_xt.php');
include_once('checkout/classes/class.KlarnaAPI.php');
include_once('checkout/classes/class.KlarnaProductPrice.php');
include_once('checkout/classes/class.KlarnaHTTPContext.php');
include_once(DIR_KLARNA . 'klarnautils.php');

if (isset($i))
    $_i = $i;

/**
 * Dependencies from {@link http://phpxmlrpc.sourceforge.net/}
 *
 * Ungly incude due to problems in XMLRPC lib (external)
 */
include_once('api/transport/xmlrpc-3.0.0.beta/lib/xmlrpc.inc');
include_once('api/transport/xmlrpc-3.0.0.beta/lib/xmlrpc_wrappers.inc');

if (isset($_i))
$i    = $_i;

$terms_link = "#"; //replaced by NL to a different document
$lang_wo_tax = '';
$enabled = true;

//If logged in, grab country iso code 2.
$tmp_customer_country = false;
$hasgerman = $hasdutch = $hasfin = false;
$klarna_pzone = $pctable = $cc = false;

$currency = $_SESSION['currency'];
$currencies = $xtPrice->currencies;
$tax = ($xtPrice->TAX[$product->data['products_tax_class_id']]/100)+1;
$totalSum = $product->data['products_price']*$tax*$currencies[$currency]['value'];

$country    = "";
if (!isset($_SESSION['customer_country_id']) || ($_SESSION['customer_country_id'] == 0)) {
    // Get the country specific settings based on currency
    switch(strtolower($currency)) {
        case 'sek':
            $country = "se";
            break;
        case 'nok':
            $country = "no";
            break;
        case 'dkk':
            $country = "dk";
            break;
        case 'eur':
            if($tmp_customer_country === false) {
                $query = xtc_db_query("SELECT countries_iso_code_2 FROM countries WHERE countries_id = " . (int) $_SESSION['customer_country_id']);
                $result = xtc_db_fetch_array($query);
                if (is_array($result)) {
                    $country = $result['countries_iso_code_2'];
                }
            }
            else {
                $country = $tmp_customer_country;
            }
            break;
        default:
            $enabled = false;
            break;
    }

    $country = strtolower($country);
    $countryCode = $country;
    if (strtolower($country) == "" || strtolower($country) == "en") {
        if (STORE_COUNTRY == '81')
            $country = 'de';
        else if (STORE_COUNTRY == '150')
            $country = 'nl';
        else if (STORE_COUNTRY == '57')
            $country = 'dk';
        else if (STORE_COUNTRY == '72')
            $country = 'fi';
        else if (STORE_COUNTRY == '203')
            $country = 'se';
        else if (STORE_COUNTRY == '160')
            $country = 'no';
        else
            $enabled = false;
    }
} else {
    switch ($_SESSION['customer_country_id']) {
        case 81:
            $country = 'de';
            break;
        case 150:
            $country = 'nl';
            break;
        case 57:
            $country = 'dk';
            break;
        case 72:
            $country = 'fi';
            break;
        case 203:
            $country = 'se';
            break;
        case 160:
            $country = 'no';
            break;
        default:
            return false;
    }
}

switch ( strtolower($country) ) {
    case "se":
        $eid         = (int)MODULE_PAYMENT_PCKLARNA_EID_SE;
        $secret    = MODULE_PAYMENT_PCKLARNA_SECRET_SE;
        break;
    case "de":
        $eid         = (int)MODULE_PAYMENT_PCKLARNA_EID_DE;
        $secret    = MODULE_PAYMENT_PCKLARNA_SECRET_DE;
        break;
    case "dk":
        $eid         = (int)MODULE_PAYMENT_PCKLARNA_EID_DK;
        $secret    = MODULE_PAYMENT_PCKLARNA_SECRET_DK;
        break;
    case "nl":
        $eid         = (int)MODULE_PAYMENT_PCKLARNA_EID_NL;
        $secret    = MODULE_PAYMENT_PCKLARNA_SECRET_NL;
        break;
    case "fi":
        $eid         = (int)MODULE_PAYMENT_PCKLARNA_EID_FI;
        $secret    = MODULE_PAYMENT_PCKLARNA_SECRET_FI;
        break;
    case "no":
        $eid         = (int)MODULE_PAYMENT_PCKLARNA_EID_NO;
        $secret    = MODULE_PAYMENT_PCKLARNA_SECRET_NO;
        break;
    case "en":
        if (MODULE_PAYMENT_PCKLARNA_EID_DE > 0 && MODULE_PAYMENT_PCKLARNA_SECRET_DE != "")
        {
            $country    = "de";
            $eid         = (int)MODULE_PAYMENT_PCKLARNA_EID_DE;
            $secret    = MODULE_PAYMENT_PCKLARNA_SECRET_DE;
        }
        else if (MODULE_PAYMENT_PCKLARNA_EID_NL > 0 && MODULE_PAYMENT_PCKLARNA_SECRET_NL != "")
        {
            $country    = "nl";
            $eid         = (int)MODULE_PAYMENT_PCKLARNA_EID_NL;
            $secret    = MODULE_PAYMENT_PCKLARNA_SECRET_NL;
        }
        else if (MODULE_PAYMENT_PCKLARNA_EID_FI > 0 && MODULE_PAYMENT_PCKLARNA_SECRET_FI != "")
        {
            $country    = "fi";
            $eid         = (int)MODULE_PAYMENT_PCKLARNA_EID_FI;
            $secret    = MODULE_PAYMENT_PCKLARNA_SECRET_FI;
        }
        else {
            return false;
        }
        break;
}

$mode = KlarnaUtils::getPCUri();
$types = array(KlarnaPClass::CAMPAIGN,
                KlarnaPClass::ACCOUNT,
                KlarnaPClass::FIXED);
try {
    $klarna = new Klarna_xt();
    $klarna->config($eid, $secret, $country, null, $currency, $mode, "mysql", KlarnaUtils::getPCUri(), true);

    if (!$klarna->checkCountryCurrency($country, $currency)) {
        return false;
    }

    switch ( $countryCode ) {
        case "se":
            $countryCode = "sv";
            break;
        case "dk":
            $countryCode = "da";
            break;
        case "no":
            $countryCode = "nb";
            break;
    }
} catch(Exception $e) {
    return false;
}
// get currency symbol position
global $xtPrice;
$currencies = $xtPrice->currencies;
$currency = $_SESSION['currency'];

if (strlen($currencies[$currency]['symbol_left'])>0) {
    $position = "prefix";
} else {
    $position = "suffix";
}
$dpoint = $currencies[$currency]['decimal_point'];

try {
    $webroot = KlarnaUtils::getWebRoot();
    $kCheckout = new KlarnaAPI ($country, $countryCode, 'part', $totalSum, KlarnaFlags::PRODUCT_PAGE, $klarna, $types, DIR_KLARNA . '/checkout/');
    $kCheckout->addSetupValue ('web_root', $webroot);
    $kCheckout->addSetupValue ('path_img', $webroot);
    $kCheckout->addSetupValue ('path_js', $webroot . "js/");
    $kCheckout->addSetupValue ('path_css', $webroot);

    if ($country  == KlarnaCountry::DE || $country == 'de') {
        $kCheckout->addSetupValue ('asterisk', '*');
    }
    $kCheckout->setCurrency($currency, $position);

    $kpp = new KlarnaProductPrice($klarna, $eid, DIR_KLARNA . '/checkout/', $webroot, $kCheckout);
    $kpp->__setDecimalPoint($dpoint);
    echo $kpp->show($totalSum, $currency, $country);
} catch( Exception $e ) {
    return false;
}
