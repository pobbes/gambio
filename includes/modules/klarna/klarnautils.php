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
class KlarnaUtils {

    // not using static keyword allows the function to use $this scope from the calling class.
    public function addKlarnaData($key, $value) {
        $this->klarna_data[$key] = $value;
    }

    // not using static keyword allows the function to use $this scope from the calling class.
    public function setKlarnaData($order) {
        global $customer_id;
        self::addKlarnaData('phone', $order->customer['telephone']);
        self::addKlarnaData('email', $order->customer['email_address']);
        self::addKlarnaData('reference', $order->delivery['firstname'] .
                                        " " . $order->delivery['lastname']);

        if ( $this->isGerman() || $this->isDutch() ) {
            $address = KlarnaAPI::splitAddress($order->delivery['street_address']);
            self::addKlarnaData('street', $address[0]);
            self::addKlarnaData('house_number', $address[1]);
            self::addKlarnaData('house_extension', $address[2]);

            $customer_query = xtc_db_query("select DATE_FORMAT(customers_dob, ".
                        "'%d%m%Y') AS customers_dob, customers_gender from " .
                        TABLE_CUSTOMERS . " where customers_id = '" .
                        (int)$customer_id."'");
            $customer = xtc_db_fetch_array($customer_query);
            $dob = $customer['customers_dob'];
            self::addKlarnaData('birth_year', substr($dob, 4, 4));
            self::addKlarnaData('birth_month', substr($dob, 2, 2));
            self::addKlarnaData('birth_day', substr($dob, 0, 2));
            self::addKlarnaData('gender', $customer['customers_gender']);
        } else {
            $address = $order->delivery['street_address'];
            if (isset($order->delivery['suburb']) && strlen($order->delivery['suburb']) > 0) {
                $address .= " " . $order->delivery['suburb'];
            }
            self::addKlarnaData('street', $address);
        }

        self::addKlarnaData('firstname',    $order->delivery['firstname']);
        self::addKlarnaData('lastname',     $order->delivery['lastname']);
        self::addKlarnaData('city',         $order->delivery['city']);
        self::addKlarnaData('zipcode',      $order->delivery['postcode']);
        self::addKlarnaData('company',      $order->delivery['company']);
    }

    public static function getPCUri() {
        $pcURI = array( 'user' => DB_SERVER_USERNAME,
                        'passwd' => DB_SERVER_PASSWORD,
                        'dsn' => DB_SERVER,
                        'db' => DB_DATABASE,
                        'table' => 'klarna_pclasses'
                    );
        return $pcURI;
    }

    public static function getAGBLink() {
        return "shop_content.php?coID=3";
    }

    public static function clearErrors() {
        unset($_SESSION['klarna_error']);
        unset($_SESSION['klarna_option']);
    }

    public static function setError($errorString, $errorBox) {
        $_SESSION['klarna_error'] = html_entity_decode(addslashes($errorString));
        $_SESSION['klarna_option'] = $errorBox;
    }

    public static function getError() {
        return $_SESSION['klarna_error'];
    }
    public static function getErrorOption() {
        return $_SESSION['klarna_option'];
    }

    public function klarna_output_string($string, $translate = false, $protected = false) {
        if ($protected == true) {
            return htmlspecialchars($string);
        } else {
            if ($translate == false) {
                return xtc_parse_input_field_data($string, array('"' => '&quot;'));
            } else {
                return xtc_parse_input_field_data($string, $translate);
            }
        }
    }

    /**
    * Params for the HTML
    */
    public static function getParams($opt, $country) {
        if ($opt == 'invoice') {
            $opt = "inv";
        }
        $aParams = array();
        // Params specific for:
        // ---- Sweden, Denmark, Norway, Finland
        $c = strtolower($country);
        if ($c == "se" || $c == "dk" || $c == "no" || $c == "fi") {
            $aParams["socialNumber"]    = "klarna_{$opt}_pnum";
        }
        // Params needed for non-swedish customers
        if ($c != "se") {
            $aParams["firstName"]   = "klarna_{$opt}_fname";
            $aParams["lastName"]    = "klarna_{$opt}_lname";
            $aParams["street"]      = "klarna_{$opt}_street";
            $aParams["city"]        = "klarna_{$opt}_city";
            $aParams["zipcode"]     = "klarna_{$opt}_postno";
            $aParams["companyName"] = "klarna_{$opt}_company_name";

            // Specific for Germany and Netherlands
            if ( $c == "de" || $c == "nl") {    // Germany && Netherlands
                $aParams["gender"]          = "klarna_{$opt}_gender";
                $aParams["homenumber"]      = "klarna_{$opt}_house";
                $aParams["birth_year"]      = "klarna_{$opt}_birth_year";
                $aParams["birth_month"]     = "klarna_{$opt}_birth_month";
                $aParams["birth_day"]       = "klarna_{$opt}_birth_day";
            }
            if ( $c == "nl" ) {    // Netherlands only
                $aParams["house_extension"]   = "klarna_{$opt}_houseext";
            }
            if ( $c == "dk" ) {    // Denmark only
                $aParams["year_salary"] = "klarna_{$opt}_ysalary";
            }
        }
        // Params that are the same for all countries
        $aParams["phoneNumber"]             = "klarna_{$opt}_phone";
        $aParams["emailAddress"]            = "klarna_{$opt}_email";
        $aParams["invoiceType"]             = "klarna_invoice_type";
        $aParams["reference"]               = "klarna_{$opt}_reference";
        $aParams["shipmentAddressInput"]    = "klarna_{$opt}_shipment_address";
        $aParams["type"]                    = "klarna_{$opt}_invoice";
        $aParams["paymentPlan"]             = "klarna_{$opt}_paymentPlan";

        return $aParams;
    }

    public static function getLanguage($country) {
        switch (strtolower($country)) {
            case "de":
                return KlarnaLanguage::DE;
            case "dk":
                return KlarnaLanguage::DA;
            case "fi":
                return KlarnaLanguage::FI;
            case "nl":
                return KlarnaLanguage::NL;
            case "no":
                return KlarnaLanguage::NB;
            case "se":
                return KlarnaLanguage::SV;
            default:
                return KlarnaLanguage::EN;
        }
    }

    /**
     * Values for the HTML
     */
    public static function getValues($klarna_data) {
        global $order;
        $aValues = array();

        $c = strtolower($klarna_data['country']);
        // We've returned to the checkout after an error.
        // Refill with what we entered before.
        if (isset($_SESSION['klarna_data'])) {
            $aData = $_SESSION['klarna_data'];
            $klarna_data['firstname']   = $aData['klarna_fname'];
            $klarna_data['lastname']    = $aData['klarna_lname'];
            $klarna_data['street']      = $aData['klarna_street'];
            $klarna_data['city']        = $aData['klarna_city'];
            $klarna_data['zipcode']     = $aData['klarna_postno'];
            $klarna_data['phone']       = $aData['klarna_phone'];
            $klarna_data['year_salary'] = $aData['klarna_ysalary'];
            $klarna_data['company']     = $aData['klarna_company'];
            $klarna_data['reference']   = $aData['klarna_reference'];
            $klarna_data['email']       = $aData["klarna_email"];

            if ($c == 'de' || $c == 'nl') {
                $klarna_data['house_number']    = $aData['klarna_house'];
                $klarna_data['gender']          = $aData['klarna_gender'];
                $dob                            = $aData['klarna_pnum'];
                $klarna_data['birth_year']      = substr($dob, 4, 4);
                $klarna_data['birth_month']     = substr($dob, 2, 2);
                $klarna_data['birth_day']       = substr($dob, 0, 2);
                if ($c == 'nl') {
                    $klarna_data['house_extension'] = $aData['klarna_houseext'];
                } 
            }
        }

        // Values for non-swedish customers.
        if ($c != "se") {
            $aValues["firstName"]   = $klarna_data['firstname'];
            $aValues["lastName"]    = $klarna_data['lastname'];
            $aValues["street"]      = $klarna_data['street'];
            $aValues["city"]        = $klarna_data['city'];
            $aValues["zipcode"]     = $klarna_data['zipcode'];
            $aValues["companyName"] = $klarna_data['company'];

            if ( $c == "de" || $c == "nl") {    // Germany && Netherlands
                $aValues["gender"]          = $klarna_data['gender'];
                $aValues["homenumber"]      = $klarna_data['house_number'];
                $aValues["birth_year"]      = $klarna_data['birth_year'];
                $aValues["birth_month"]     = $klarna_data['birth_month'];
                $aValues["birth_day"]       = $klarna_data['birth_day'];
            }
            if ( $c == "nl" ) {    // Netherlands only
                $aValues["house_extension"] = $klarna_data['house_extension'];
            }
            if ( $c == "dk" ) {
                $aValues["year_salary"]     = $klarna_data['year_salary'];
            }
        }
        // Values that are the same for all countries
        $aValues["phoneNumber"]             = $klarna_data['phone'];
        $aValues["emailAddress"]            = $klarna_data['email'];
        $aValues["reference"]               = $klarna_data['reference'];
        if (isset($klarna_data['paymentPlan']) && strlen($klarna_data['paymentPlan']) >= 2) {
            $aValues["paymentPlan"]         = $klarna_data['paymentPlan'];
        }
        return $aValues;
    }

    private function cleanSpecificPost($opt) {
        unset($_POST["klarna_{$opt}_fname"]);
        unset($_POST["klarna_{$opt}_lname"]);
        unset($_POST["klarna_{$opt}_gender"]);
        unset($_POST["klarna_{$opt}_pnum"]);
        unset($_POST["klarna_{$opt}_street"]);
        unset($_POST["klarna_{$opt}_house"]);
        unset($_POST["klarna_{$opt}_postno"]);
        unset($_POST["klarna_{$opt}_city"]);
        unset($_POST["klarna_{$opt}_phone"]);
        unset($_POST["klarna_{$opt}_email"]);
        unset($_POST["klarna_{$opt}_paymentPlan"]);
        unset($_POST["klarna_{$opt}_reference"]);
        unset($_POST["klarna_{$opt}_shipment_address"]);
        unset($_POST["klarna_{$opt}_houseext"]);
    }
    /*
     * Remove unwanted data from the POST variable
     */
    public function cleanPost() {
        if ($_POST['payment'] != 'klarna_invoice') {
            self::cleanSpecificPost('inv');
        }
        if ($_POST['payment'] != 'klarna_SpecCamp') {
            self::cleanSpecificPost('spec');
        }
        if ($_POST['payment'] != 'klarna_partPayment') {
            self::cleanSpecificPost('part');
        }
    }

    public static function getEid($sCountry, $option) {
        $sCountry = strtoupper($sCountry);
        switch(strtolower($option)) {
            case 'part':
                if (defined("MODULE_PAYMENT_PCKLARNA_EID_{$sCountry}"))
                    return constant("MODULE_PAYMENT_PCKLARNA_EID_{$sCountry}");
                return null;
            case 'spec':
                if (defined("MODULE_PAYMENT_SPECKLARNA_EID_{$sCountry}"))
                    return constant("MODULE_PAYMENT_SPECKLARNA_EID_{$sCountry}");
                return null;
            case 'invoice':
            case 'inv':
                if (defined("MODULE_PAYMENT_KLARNA_EID_{$sCountry}"))
                    return constant("MODULE_PAYMENT_KLARNA_EID_{$sCountry}");
                return null;
            default:
                return null;
        }
    }

    public static function getSecret($sCountry, $option) {
        $sCountry = strtoupper($sCountry);
        switch(strtolower($option)) {
            case 'part':
                if (defined("MODULE_PAYMENT_PCKLARNA_SECRET_{$sCountry}"))
                    return constant("MODULE_PAYMENT_PCKLARNA_SECRET_{$sCountry}");
                return null;
            case 'spec':
                if (defined("MODULE_PAYMENT_SPECKLARNA_SECRET_{$sCountry}"))
                    return constant("MODULE_PAYMENT_SPECKLARNA_SECRET_{$sCountry}");
                return null;
            case 'invoice':
            case 'inv':
                if (defined("MODULE_PAYMENT_KLARNA_SECRET_{$sCountry}"))
                    return constant("MODULE_PAYMENT_KLARNA_SECRET_{$sCountry}");
                return null;
            default:
                return null;
        }    return null;
    }

    /**
     * Get the mode settings. BETA or LIVE
     */
    public static function getMode($opt) {
        if ($opt == 'part') {
            return (strtolower(MODULE_PAYMENT_PCKLARNA_LIVEMODE) == "true") ? Klarna::LIVE : Klarna::BETA;
        } else if ($opt == 'spec') {
            return (MODULE_PAYMENT_SPECKLARNA_LIVEMODE == "True") ? Klarna::LIVE : Klarna::BETA;
        } else {
            return (strtolower(MODULE_PAYMENT_KLARNA_LIVEMODE) == "true") ? Klarna::LIVE : Klarna::BETA;
        }
    }

    public static function getWebRoot() {
               $request_type = HTTP_SERVER;
               if(defined('ENABLE_SSL') && ENABLE_SSL == true) {
                       $request_type = HTTPS_SERVER;
               }
      return $request_type . DIR_WS_CATALOG . 'includes/modules/klarna/checkout/';
     }
    /**
     * Checking for newer version at klarnas website
     *
     * @param boolean $return_html TRUE to return HTML, FALSE for printing text
     */
    public static function checkForLatestVersion () {
        $sURL = 'http://static.klarna.com:80/external/msbo/xtc304.latestversion.txt';
        $sLatest = @file_get_contents($sURL);
        $version = KLARNA_MODULE_VERSION;
        if( version_compare($sLatest, $version, '>') ) {
            $sHTML  = '<div style="border: 1px solid #389FD3; background-color: #BADDF0; padding: 10px; font-family: Arial, Verdana; font-size: 11px; margin: 10px">'.
                    '<img src="' . self::getWebRoot() . 'logo/logo_small.png" border="0" /><br/>A newer version of your current module is available. Please visit'.
                    '<a href="http://integration.klarna.com/" target="_blank" style="text-decoration: underline; font-weight: bold">http://integration.klarna.com/</a>'.
                    'for more details.<br/><br/><b>Your version:</b> ' . $version . '<br/><b>Latest version:</b> ' . $sLatest . '</div>';

            echo $sHTML;
            return null;
        } else {
            return false;
        }
    }

    /**
     * Build a xtCommerce address Array
     */
    public static function buildDelivery($address, $option) {
        if ($option == "invoice") {
            $option = 'inv';
        }
        global $order;
        $delivery = array();
        $delivery['firstname']       = $address->getFirstName();
        $delivery['lastname']        = $address->getLastName();
        $delivery['street_address']  = $address->getStreet() .
                                        ' ' . $address->getHouseNumber() .
                                        ' ' . $address->getHouseExt();
        $delivery['postcode']        = $address->getZipCode();
        $delivery['city']            = $address->getCity();
        $delivery['telephone']       = $_POST["klarna_{$option}_phone"];
        $delivery['email_address']   = $_POST["klarna_{$option}_email"];
        $delivery['company']         = $address->getCompanyName();

        //Set same country information to delivery
        $delivery['state'] = $order->delivery['state'];
        $delivery['zone_id'] = $order->delivery['zone_id'];
        $delivery['country_id'] = $order->delivery['country_id'];
        $delivery['country']['id'] = $order->delivery['country']['id'];
        $delivery['country']['title'] = $order->delivery['country']['title'];
        $delivery['country']['iso_code_2'] = $order->delivery['country']['iso_code_2'];
        $delivery['country']['iso_code_3'] = $order->delivery['country']['iso_code_3'];

        return $delivery;
    }

    /**
     * Build xtCommerce's hidden fields that are required for it to keep it's _POST variable
     */
    public static function hiddenFieldString($addr, $invoiceType, $paymentPlan, $email_address, $reference) {
        global $order;
        $pnum = $_SESSION['klarna_data']['klarna_pnum'];
        $ysal = $_SESSION['klarna_data']['klarna_ysalary'];
        $gender = $_SESSION['klarna_data']['klarna_gender'];

        $process_button_string =
            xtc_draw_hidden_field('addr_num', 1, true, '').
            xtc_draw_hidden_field("klarna_pnum", $pnum).
            xtc_draw_hidden_field("klarna_ysalary", $ysal).
            xtc_draw_hidden_field("klarna_street", $addr->getStreet()).
            xtc_draw_hidden_field("klarna_postno", $addr->getZipCode()).
            xtc_draw_hidden_field("klarna_city", $addr->getCity()).
            xtc_draw_hidden_field("klarna_phone", $addr->getTelno()).
            xtc_draw_hidden_field("klarna_phone2", $addr->getCellno()).
            xtc_draw_hidden_field("klarna_email", $addr->getEmail()).
            xtc_draw_hidden_field("klarna_invoice_type", $invoiceType).
            xtc_draw_hidden_field("klarna_house", $addr->getHouseNumber()) .
            xtc_draw_hidden_field("klarna_houseext", $addr->getHouseExt()) .
            xtc_draw_hidden_field("klarna_reference", $reference) .
            xtc_draw_hidden_field("klarna_gender", $gender).
            xtc_draw_hidden_field("klarna_paymentPlan", $paymentPlan);
        return $process_button_string;

    }

    /**
     * Show the PClasses
     */
    public function showPClasses($eid_array, $option) {
        if ($option == 'part') {
            $active = explode(',', MODULE_PAYMENT_KLARNA_PARTPAYMENT_ALLOWED);
        } else if ($option == 'spec') {
            $active = explode(',', MODULE_PAYMENT_KLARNA_SPECCAMP_ALLOWED);
        }
        foreach ($eid_array as $country => $eid_data) {
            if( !in_array(strtoupper($country), $active)) {
                continue;
            } else {
                try {
                    $pcURI = KlarnaUtils::getPCUri();
                    $mode = KlarnaUtils::getMode($option);
                    $klarna = new Klarna_xt();
                    $klarna->config($eid_data['eid'], $eid_data['secret'], null, null, null, $mode, "mysql", $pcURI, true);
                    $klarna->setCountry($country);

                    if ($_GET['get_pclasses'] == TRUE) {
                        $klarna->fetchPClasses($country);
                    }

                    echo '<div style="border: 1px solid #8CC63F; background-color: #D7EBBC; padding: 10px; font-family: Arial, Verdana; font-size: 11px; margin: 10px">';
                    echo '<pre>';
                    echo "<b> id      | months | interest rate | handling fee | start fee | min amount | description</b><br /><hr size='1' style='border-top: 1px solid #8CC63F;'/>";

                    foreach($klarna->getPClasses() as $pclass) {
                        printf(" %-7s", "<img src='" . KlarnaUtils::getWebRoot() . "checkout/flags/".$klarna->getLanguageCode().".png' border='0' title='".$pclass->getCountry()."' /> ");
                        printf(" %-4s|", $pclass->getId());
                        printf(" %-7s|", $pclass->getMonths());
                        printf(" %-14s|", $pclass->getInterestRate());
                        printf(" %-13s|", $pclass->getInvoiceFee());
                        printf(" %-10s|", $pclass->getStartFee());
                        printf(" %-11s|", $pclass->getMinAmount());
                        printf(" %-14s", $pclass->getDescription());
                        echo "<br />";

                    }
                    echo "</pre></div>";

                    // Remove class
                    $klarna->__destruct();
                                    }
                catch( Exception $e ) {
                    echo '<div style="border: 1px solid #CC0000; background-color: #F5CCCC; padding: 10px; font-family: Arial, Verdana; font-size: 11px; margin: 10px">'.
                        "<img src='" . self::getWebRoot() . "checkout/flags/" . $klarna->getLanguageCode() . ".png' border='0' title='" . $klarna->getCountry() . "' /> ".
                        '<b>Error:</b><br/>' . $e->getMessage() . '<br/><br/><b>Code:</b><br/>' . $e->getCode() . '</div>';
                }
            }
        }
    }

    public static function buildCart(&$klarna, $estoreUser, $order, $option, $code, $paymentPlan) {
        global $klarna_ot;

        if ($option == "part") {
            $artno = MODULE_PAYMENT_PCKLARNA_ARTNO;
        } else if ($option == "spec") {
            $artno = MODULE_PAYMENT_SPECKLARNA_ARTNO;
        } else {
            $artno = MODULE_PAYMENT_KLARNA_ARTNO;
        }
        // Add all the articles to the goodslist
        for ($i = 0 ; $i < count($order->products) ; $i++) {
            $price_with_tax = $order->products[$i]['price'];
            $price_without_tax = $order->products[$i]['price'] - ($order->products[$i]['price'] / ((100/$order->products[$i]['tax'])+1));

            $attributes = "";

            if(isset($order->products[$i]['attributes'])) {
                foreach($order->products[$i]['attributes'] as $attr) {
                    $attributes = $attributes . ", " . $attr['option'] . ": " .
                    $attr['value'];
                }
            }

            if ($artno == 'id' || $artno == '') {
                $klarna->addArticle($order->products[$i]['qty'],
                    utf8_decode(xtc_get_prid($order->products[$i]['id'])),
                    strip_tags($order->products[$i]['name'] . $attributes),
                    $price_with_tax,
                    number_format($order->products[$i]['tax'], 2),
                    0,
                    KlarnaFlags::INC_VAT);
            } else {
                    $klarna->addArticle($order->products[$i]['qty'],
                    utf8_decode($order->products[$i][$artno]),
                    strip_tags($order->products[$i]['name'] . $attributes),
                    $price_with_tax,
                    number_format($order->products[$i]['tax'], 2),
                    0,
                    KlarnaFlags::INC_VAT);
            }
        }

        // Then the extra charges like shipping and invoicefee and
        // discount.
        $extra = $klarna_ot['code_entries'];

        // If someone tries to set a pclass value to -1 using firebug, force an invoice fee on them.
        if ($paymentPlan < 0) {
            $code = "klarna";
        }

        // Go over all the order total modules that are active for this order and add them.
        for ($j=0 ; $j<$extra ; $j++) {
            $size = $klarna_ot["code_size_".$j];
            for ($i=0 ; $i<$size ; $i++) {
                $value = $klarna_ot["value_".$j."_".$i];
                $name = $klarna_ot["title_".$j."_".$i];
                $tax = $klarna_ot["tax_rate_".$j."_".$i];
                $name = rtrim($name, ":");
                $pcode = $klarna_ot["code_".$j."_".$i];
                $flags = KlarnaFlags::INC_VAT;

                if($pcode == 'ot_shipping') {
                    $flags += KlarnaFlags::IS_SHIPMENT;
                }
                else if($pcode == 'ot_'.$code.'_fee') {
                    $flags += KlarnaFlags::IS_HANDLING;
                }

                if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 1) {
                    $price_with_tax = $value;
                } else {
                    $price_with_tax = $value * (($tax / 100) + 1);
                }

                if ($value != "" && $value != 0 && $pcode != "ot_total_netto") {
                    $klarna->addArticle(1, "", $name, $price_with_tax, number_format($tax, 2), 0, $flags);
                }
            }
        }
    }

    /**
    * Build a KlarnaAddr from an xtCommerce order array.
    */
    private static function buildAddress($xtAddr) {
        $country = strtolower($xtAddr['country']['iso_code_2']);
        if ( $country == "de" || $country == "nl") {
            $splitAddr = KlarnaAPI::splitAddress($xtAddr["street_address"]);
            $street = $splitAddr[0];
            $houseno = $splitAddr[1];
            $hosuext = $splitAddr[2];
        } else {
            $street = $xtAddr["street_address"];
            $houseno = "";
            $housext = "";
        }
        $address = new KlarnaAddr(
                            $_POST["klarna_email"],
                            $_POST["klarna_phone2"],
                            $_POST["klarna_phone"],
                            $xtAddr["firstname"],
                            $xtAddr["lastname"],
                            "",
                            $street,
                            $xtAddr["postcode"],
                            $xtAddr["city"],
                            $country,
                            $houseno,
                            $housext
                        );
        return $address;
    }

    /**
    * addTransaction call
    */
    public static function addTransaction(&$klarna, $paymentPlan, $addrs, $option, $country) {
        global $order;

        // Fixes potential security problem.
        $order->delivery    = array_merge($order->delivery, KlarnaUtils::buildDelivery($addrs, $option));
        // $_POST doesn't have phone number anymore, so it won't be properly set by buildDelivery
        $order->delivery['telephone']       = $addrs->getTelno();

        $order->customer['telephone']       = $addrs->getTelno();

        $comment = $order->info['comments'];

        $pno = $_POST['klarna_pnum'];
        $reference = $_POST['klarna_reference'];
        $gender = $_POST['klarna_gender'];

        if( $option == "part" ) {
            $pendingStatusId = (int) MODULE_PAYMENT_PCKLARNA_ORDER_STATUS_PENDING_ID;
        } else if( $option == "spec" ) {
            $pendingStatusId = (int) MODULE_PAYMENT_SPECKLARNA_ORDER_STATUS_PENDING_ID;
        } else {
            $pendingStatusId = (int) MODULE_PAYMENT_KLARNA_ORDER_STATUS_PENDING_ID;
        }

        if ($_POST['klarna_invoice_type'] == 'company') {
            $order->delivery['firstname'] = $reference;
            $comment .= "\nRef:" . $reference;
            $name = explode(' ', $reference, 2);
            $addrs->setFirstName($name[0]);
            if (strlen($name[1]) > 0)
                $addrs->setLastName($name[1]);
            else
                $addrs->setLastName(" ");

            //Set Company to order
            $order->delivery['company'] = $addrs->getCompanyName();
        } else {
            $order->delivery['company'] = '';
        }

        $klarna->setComment($comment);
        $klarna->setReference($reference, "");

        $shipping = $addrs;
        if (strtolower($country) == 'de' || strtolower($country) == 'nl') {
            $billing = $shipping;
        } else {
            $billing = self::buildAddress($order->billing);
        }

        try {
            $klarna->setAddress(KlarnaFlags::IS_SHIPPING, $shipping);
            $klarna->setAddress(KlarnaFlags::IS_BILLING, $billing);

            if (strtolower($country) == "dk" && $option == "part") {
                $ysalary = intval($_POST['klarna_ysalary']);
                $klarna->setExtraInfo("yearly_salary", $ysalary);
            }
            $order->billing = $order->delivery;
            $result = $klarna->addTransaction($pno, ($klarna->getCountry() == KlarnaCountry::DE || $klarna->getCountry() == KlarnaCountry::NL) ? $gender : null, KlarnaFlags::RETURN_OCR, $paymentPlan);
            if ($result[2] == KlarnaFlags::PENDING && $pendingStatusId > 0) {
                $q = "SELECT orders_status_name FROM " . TABLE_ORDERS_STATUS . " WHERE orders_status_id = ". $pendingStatusId;
                $osq = xtc_db_query($q);
                $os = xtc_db_fetch_array($osq);
                $_SESSION['klarna_orderstatus'] = $os['orders_status_name'];
            }

            // insert address in address book to get correct address in
            // confirmation mail (or fetch correct address from address book
            // if it exists)

            $q = "select countries_id from " . TABLE_COUNTRIES . " where countries_iso_code_2 = '".$country."'";

            $check_country_query = xtc_db_query($q);
            $check_country = xtc_db_fetch_array($check_country_query);

            $cid = $check_country['countries_id'];

            $q = "select address_book_id from " . TABLE_ADDRESS_BOOK .
                " where customers_id = '" . (int)$customer_id .
                "' and entry_firstname = '" . mysql_real_escape_string($order->delivery['firstname']) .
                "' and entry_lastname = '" . mysql_real_escape_string($order->delivery['lastname']) .
                "' and entry_street_address = '" . mysql_real_escape_string($order->delivery['street_address']) .
                "' and entry_postcode = '" . mysql_real_escape_string($order->delivery['postcode']) .
                "' and entry_city = '" . mysql_real_escape_string($order->delivery['city']) .
                "' and entry_company = '" . mysql_real_escape_string($order->delivery['company']) . "'";
            $check_address_query = xtc_db_query($q);
            $check_address = xtc_db_fetch_array($check_address_query);
            if(is_array($check_address) && count($check_address) > 0) {
                $sendto = $billto = $check_address['address_book_id'];
            }else {
                $sql_data_array =
                array('customers_id' => $customer_id,
                        'entry_firstname' => $order->delivery['firstname'],
                        'entry_lastname' => $order->delivery['lastname'],
                        'entry_company' => $order->delivery['company'],
                        'entry_street_address' => $order->delivery['street_address'],
                        'entry_postcode' => $order->delivery['postcode'],
                        'entry_city' => $order->delivery['city'],
                        'entry_country_id' => $cid);

                xtc_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array);
                $sendto = $billto = xtc_db_insert_id();
            }
            $_SESSION['klarna_invno'] = $result[1];
        }
        catch(Exception $e) {
            KlarnaUtils::setError(htmlentities($e->getMessage()) . " (#" . $e->getCode() . ")", $option);
            xtc_redirect(KlarnaUtils::error_link(FILENAME_CHECKOUT_PAYMENT,
                '', 'SSL', true, false));
        }

    }

    private static function swedishAddress(&$errors, &$kLang, $lang, &$klarna, $option) {
        $addrs = array();

        $pno = $_POST["klarna_{$option}_pnum"];
        $_SESSION['klarna_data']['klarna_pnum'] = $pno;
        $_SESSION['klarna_data']['klarna_phone'] = $_POST["klarna_{$option}_phone"];

        try {
            $tmpaddrs = $klarna->getAddresses($pno, null, KlarnaFlags::GA_GIVEN);
            if (count($tmpaddrs) == 0) {
                $errors[] = $kLang->fetch("error_no_address", $lang);
            } else if (count($tmpaddrs) == 1) {
                $address = $tmpaddrs[0];
            } else {
                //This example only works for GA_GIVEN.
                foreach($tmpaddrs as $index => $addr) {
                    $addr_string = "";
                    if($addr->isCompany) {
                        $addr_string  = $addr->getCompanyName();
                        $addr_string .= "|" . $addr->getStreet();
                        $addr_string .= "|" . $addr->getZipCode();
                        $addr_string .= "|" . $addr->getCity();
                        $addr_string .= "|" . $addr->getCountryCode();
                    } else {
                        $addr_string  = $addr->getFirstName();
                        $addr_string .= "|" . $addr->getLastName();
                        $addr_string .= "|" . $addr->getStreet();
                        $addr_string .= "|" . $addr->getZipCode();
                        $addr_string .= "|" . $addr->getCity();
                        $addr_string .= "|" . $addr->getCountryCode();
                    }
                    if ($addr_string == trim($_POST["klarna_${option}_shipment_address"])) {
                        $address = $addr;
                    }
                }
            }
        }
        catch( Exception $e ) {
            if ($e->getCode() != "50077") {
                $errors[] = "Error: [".$e->getCode()."]: " . $e->getMessage();
            }
        }

        if ($address == null) {
            $errors[] = $kLang->fetch("error_no_address", $lang);
        }

        if (!empty($errors)) {
            $error_message = $kLang->fetch("error_title_1", $lang)." ".implode(", ", $errors).". ".$kLang->fetch("error_title_2", $lang);
            if ($option == 'inv') {
                $option = "invoice";
            }
            KlarnaUtils::setError($error_message, $option);
            xtc_redirect(KlarnaUtils::error_link(FILENAME_CHECKOUT_PAYMENT, "", "SSL"));
        }

        try {
            $address->setTelno($_POST["klarna_${option}_phone"]);
            $address->setEmail($_POST["klarna_${option}_email"]);
        }
        catch( Exception $e ) {
                // Do nothing, ignore it.
        }
        return $address;
    }

    /**
    *   Handle the $_POST variable and return a KlarnaAddr object
    *   @return KlarnaAddr object
    */
    public static function handlePost($country, $option, &$klarna) {
        global $order;
        unset($_SESSION['klarna_data']);
        $kLang = new KlarnaLanguagePack(DIR_KLARNA . 'checkout/data/language.xml');
        $errors = array();
        $lang = $klarna->getLanguageForCountry(KlarnaCountry::fromCode($country));

        if ($option == "invoice") {
            $option = "inv";
        }
        if( $option == 'part' && strtolower($country) == 'dk' ) {
            if( strlen($_POST["klarna_{$option}_ysalary"]) == 0 ) {
                $errors[] = $kLang->fetch("year_salary", $lang);
            }
        }
        //Validation for Company fields else Private fields
        if ($_POST["klarna_invoice_type"] == "company" && strlen(trim((string)$_POST["klarna_{$option}_reference"])) == 0) {
            $errors[] = $kLang->fetch("reference", $lang);
        }
        if (strlen(trim((string)$_POST["klarna_{$option}_phone"])) == 0) {
            $errors[] = $kLang->fetch("phone_number", $lang);
        }

        if (strlen(trim((string)$_POST["klarna_{$option}_email"])) == 0) {
            $errors[] = $kLang->fetch("klarna_email", $lang);
        }
        $address = new KlarnaAddr();
        if( strtolower($country) == 'se' ) {
            $address = self::swedishAddress($errors, $kLang, $lang, $klarna, $option);
        }

        if (strtolower($country) != "se") {
            $aKlarnaAddress = array();
            //Fill user array with billing details
            $aKlarnaAddress["klarna_gender"] = $_POST["klarna_{$option}_gender"];
            $aKlarnaAddress["klarna_pnum"] = $_POST["klarna_{$option}_pnum"];
            $aKlarnaAddress["klarna_fname"] = $_POST["klarna_{$option}_fname"];
            $aKlarnaAddress["klarna_lname"] = $_POST["klarna_{$option}_lname"];
            $aKlarnaAddress["klarna_street"] = $_POST["klarna_{$option}_street"];
            $aKlarnaAddress["klarna_house"] = $_POST["klarna_{$option}_house"];
            $aKlarnaAddress["klarna_postno"] = $_POST["klarna_{$option}_postno"];
            $aKlarnaAddress["klarna_houseext"] = $_POST["klarna_{$option}_house_ext"];
            $aKlarnaAddress["klarna_reference"] = $_POST["klarna_{$option}_reference"];
            $aKlarnaAddress["klarna_city"] = $_POST["klarna_{$option}_city"];
            $aKlarnaAddress["klarna_phone"] = $_POST["klarna_{$option}_phone"];
            $aKlarnaAddress["klarna_email"] = $_POST["klarna_{$option}_email"];
            $aKlarnaAddress["klarna_ysalary"] = $_POST["klarna_{$option}_ysalary"];
            $aKlarnaAddress["klarna_company"] = $_POST["klarna_{$option}_company_name"];
            
            $_SESSION['klarna_data'] = $aKlarnaAddress;

            if( strtolower($country) == "de" || strtolower($country) == "nl") {

                $aKlarnaAddress["klarna_pnum"] = $_POST["klarna_{$option}_birth_day"] . $_POST["klarna_{$option}_birth_month"] . $_POST["klarna_{$option}_birth_year"];
                $_SESSION['klarna_data']["klarna_pnum"] = $aKlarnaAddress["klarna_pnum"];
                if( strlen($_POST["klarna_{$option}_gender"]) == 0 ) {
                    $errors[] = $kLang->fetch("sex", $lang);
                }
                if( strlen($_POST["klarna_{$option}_birth_day"]) == 0 ||
                    strlen($_POST["klarna_{$option}_birth_month"]) == 0 ||
                    strlen($_POST["klarna_{$option}_birth_year"]) == 0) {
                    $errors[] = $kLang->fetch("birthday", $lang);
                }
                if( strlen($_POST["klarna_{$option}_house"]) == 0 ) {
                    $errors[] = $kLang->fetch("address_homenumber", $lang);
                }
            } else {
                if( strlen($_POST["klarna_{$option}_pnum"]) == 0 ) {
                    $errors[] = $kLang->fetch("klarna_personalOrOrganisatio_number", $lang);
                }
            }
            if( strlen($_POST["klarna_{$option}_fname"]) == 0 ) {
                $errors[] = $kLang->fetch("first_name", $lang);
            }

            if( strlen($_POST["klarna_{$option}_lname"]) == 0 ) {
                $errors[] = $kLang->fetch("last_name", $lang);
            }

            if( strlen($_POST["klarna_{$option}_street"]) == 0 ) {
                $errors[] = $kLang->fetch("street_adress", $lang);
            }

            if( strtolower($country) == "de" && $_POST["consent"] != "on") {
                $errors[] = $kLang->fetch("no_consent", $lang);
            }

            if( strlen($_POST["klarna_{$option}_postno"]) == 0 ) {
                $errors[] = $kLang->fetch("address_zip", $lang);
            }

            if( strlen($_POST["klarna_{$option}_city"]) == 0 ) {
                $errors[] = $kLang->fetch("address_city", $lang);
            }

            if( strlen($_POST["klarna_{$option}_email"]) == 0 ) {
                $errors[] = $kLang->fetch("klarna_email", $lang);
            }

            if($order->delivery['company'] != "" || $order->delivery != $order->billing) {
                if ($order->delivery['company'] != "")
                {
                $error = $kLang->fetch("company_not_allowed_all", $lang);
                }
                else
                {
                $error = $kLang->fetch("error_shipping_must_match_billing", $lang);
                }

            if (!empty($errors)) {
                $error_message = $error;
                if ($option == 'inv') {
                    $option = "invoice";
                }
                unset($_SESSION['klarna_order_invoice']);
                unset($_SESSION['klarna_order_part']);
                KlarnaUtils::setError($error_message, $option);
                xtc_redirect(KlarnaUtils::error_link(FILENAME_CHECKOUT_PAYMENT, "", "SSL"));
            }
            }
            else
            {
            if (!empty($errors)) {
                $error_message = $kLang->fetch("error_title_1", $lang)." ".implode(", ", $errors).". ".$kLang->fetch("error_title_2", $lang);
                if ($option == 'inv') {
                    $option = "invoice";
                }
                unset($_SESSION['klarna_order_invoice']);
                unset($_SESSION['klarna_order_part']);
                KlarnaUtils::setError($error_message, $option);
                xtc_redirect(KlarnaUtils::error_link(FILENAME_CHECKOUT_PAYMENT, "", "SSL"));
            }
            }
            $address = new KlarnaAddr($_POST["klarna_{$option}_email"],
                            $_POST["klarna_{$option}_phone2"],
                            $_POST["klarna_{$option}_phone"],
                            $_POST["klarna_{$option}_fname"],
                            $_POST["klarna_{$option}_lname"], "",
                            $_POST["klarna_{$option}_street"],
                            $_POST["klarna_{$option}_postno"],
                            $_POST["klarna_{$option}_city"],
                            $country,
                            $_POST["klarna_{$option}_house"],
                            $_POST["klarna_{$option}_houseext"]
                        );
            if ($_POST["klarna_invoice_type"] == "company") {
                $address->isCompany = true;
                $address->setCompanyName($_POST["klarna_{$option}_company_name"]);
                $name = explode(' ', $aKlarnaAddress["klarna_reference"], 2);
                $address->setFirstName($name[0]);
                if (strlen($name[1]) > 0)
                    $address->setLastName($name[1]);
                else
                    $address->setLastName(" ");
            }
            $_SESSION['klarna_data'] = $aKlarnaAddress;
        }

        return $address;
    }

    public function klarna_output_string_protected($string) {
        return klarna_output_string($string, false, true);
    }
    /**
     * Creates a SEO safe error link.
     *
     * @param string $page
     * @param string $parameters
     * @param string $connection
     * @param bool   $add_session_id
     * @param bool   $search_engine_safe
     * @return string
     */

    function error_link($page = '', $parameters = '', $connection = 'NONSSL', $add_session_id = true, $search_engine_safe = true) {
        global $request_type, $session_started, $SID;

        if (!xtc_not_null($page)) {
            die('<br><br><font color="#f3014d"><b>Error!</b></font><br><br><b>Unable to determine the page link!<br><br>');
        }

        if ($connection == 'NONSSL') {
            $link = HTTP_SERVER . DIR_WS_HTTP_CATALOG;
        }
        else if ($connection == 'SSL') {
            if (ENABLE_SSL == true) {
                $link = HTTPS_SERVER . DIR_WS_CATALOG;
            }
            else {
                $link = HTTP_SERVER . DIR_WS_CATALOG;
            }
        }
        else {
            die('<br><br><font color="#f3014d"><b>Error!</b></font><br><br><b>Unable to determine connection method on a link!<br><br>Known methods: NONSSL SSL</b><br><br>');
        }

        if (xtc_not_null($parameters)) {
            $link .= $page . '?' . KlarnaUtils::klarna_output_string($parameters);
//            $link .= $page . '?' . $parameters;
            $separator = '&';
        }
        else {
            $link .= $page;
            $separator = '?';
        }
        while ( (substr($link, -1) == '&') || (substr($link, -1) == '?') ) {
            $link = substr($link, 0, -1);
        }

        // Add the session ID when moving from different HTTP and HTTPS servers, or when SID is defined
        if ( ($add_session_id == true) && ($session_started == true) && (SESSION_FORCE_COOKIE_USE == 'False') ) {
            if (xtc_not_null($SID)) {
                $_sid = $SID;
            }
            else if ( ( ($request_type == 'NONSSL') && ($connection == 'SSL') && (ENABLE_SSL == true) ) || ( ($request_type == 'SSL') && ($connection == 'NONSSL') ) ) {
                if (HTTP_COOKIE_DOMAIN != HTTPS_COOKIE_DOMAIN) {
                    $_sid = xtc_session_name() . '=' . xtc_session_id();
                }
            }
        }

        if ( (SEARCH_ENGINE_FRIENDLY_URLS == 'true') && ($search_engine_safe == true) ) {
            while (strstr($link, '&&')) {
                $link = str_replace('&&', '&', $link);
            }

            $link = str_replace('?', '/', $link);
            $link = str_replace('&', '/', $link);
            $link = str_replace('=', '/', $link);

            $separator = '?';
        }

        if (isset($_sid)) {
            $link .= $separator . $_sid;
        }
        return $link;
    }

    public static function xmlToArray($obj, $level=0) {
        $aResult = array();

        if (!is_object($obj))
        return $aResult;

        $aChild = (array) $obj;

        if (sizeof($aChild) > 1) {
            foreach ($aChild as $sName => $mValue) {
                if ($sName == "@attributes") {
                    $sName = "_attributes";
                }

                if (is_array($mValue)) {
                    foreach ($mValue as $ee => $ff) {
                        if (!is_object($ff)) {
                            $aResult[$sName][$ee] = $ff;
                        } else if (get_class($ff) == 'SimpleXMLElement') {
                            $aResult[$sName][$ee] = self::xmlToArray($ff, $level + 1);
                        }
                    }
                } else if (!is_object($mValue)) {
                    $aResult[$sName] = $mValue;
                } else if (get_class($mValue) == 'SimpleXMLElement') {
                    $aResult[$sName] = self::xmlToArray($mValue, $level + 1);
                }
            }
        } else if (sizeof($aChild) > 0) {
            foreach ($aChild as $sName => $mValue) {
                if ($sName == "@attributes") {
                    $sName = "_attributes";
                }

                if (!is_array($mValue) && !is_object($mValue)) {
                    $aResult[$sName] = $mValue;
                } else if (is_object($mValue)) {
                    $aResult[$sName] = self::xmlToArray($mValue, $level + 1);
                } else {
                    foreach ($mValue as $sNameTwo => $sValueTwo) {
                        if (!is_object($sValueTwo)) {
                            $aResult[$obj->getName()][$sNameTwo] = $sValueTwo;
                        } else if (get_class($sValueTwo) == 'SimpleXMLElement') {
                            $aResult[$obj->getName()][$sNameTwo] = self::xmlToArray($sValueTwo, $level + 1);
                        }
                    }
                }
            }
        }
        return $aResult;
    }

    public static function showTemplateOptions() {
        $sURL = 'http://static.klarna.com:81/external/msbo/templateList.xml';
        $sLatest = @file_get_contents($sURL);
        $aLocal = self::getLocalTemplates();
        $iShown = 0;

        echo '<form action="" method="POST">';

        if ($sLatest != "") {
            $oXml = simplexml_load_string($sLatest, 'SimpleXMLElement', LIBXML_NOCDATA);
            $aXml = self::xmlToArray($oXml, 0);

            echo '<input type="hidden" name="xml" value="' . addslashes(htmlentities($sLatest)) . '" />';

            if (!empty($aXml['error'])) {
                echo '<div style="border: 1px solid #CC0000; background-color: #F5CCCC; padding: 10px; font-family: Arial, Verdana; font-size: 11px; margin: 10px">' . '<b>Error: </b><br/>An error occured while trying to fetch your templates.<br/><br/><b>Message:</b><br/>' . $aXml['error'] . '</div>';
            } else {
                if (array_key_exists("0", $aXml['template'])) {
                    foreach ($aXml['template'] as $aTemplate) {
                        $bInstalled = false;
                        $bNewerAvailable = false;

                        if (array_key_exists($aTemplate['name'], $aLocal)) {
                            $aLocal[$aTemplate['name']]['shown'] = true;
                            $bInstalled = true;

                            $sCurrentVersion = $aLocal[$aTemplate['name']]['version'];

                            $aExplode = explode(".", $aTemplate['version']);
                            $aCurrentVersion = explode(".", $sCurrentVersion);
                            $bNewerAvailable = false;

                            if (is_array($aExplode) && is_array($aCurrentVersion)) {
                                $bNewerAvailable = ($aExplode[0] > $aCurrentVersion[0] ||
                                ($aExplode[0] == $aCurrentVersion[0] && $aExplode[1] > $aCurrentVersion[1]) ||
                                ($aExplode[0] == $aCurrentVersion[0] && $aExplode[1] == $aCurrentVersion[1] && $aExplode[2] > $aCurrentVersion[2]));
                            }
                        }

                        $sHTML = '<div style="border: 1px solid #8CC63F; background-color: #D7EBBC; height: 90px; padding: 10px; font-family: Arial, Verdana; font-size: 11px; margin: 10px">';
                        $sHTML .= '<div style="position: relative; width: 140px; text-align: right; height: 70px; float: right">';

                        if ($bInstalled)
                        $sHTML .= '<img src="' . self::getWebRoot() . 'admin/installed.png" border="0"/>';

                        if ($bNewerAvailable)
                        $sHTML .= '<img src="' . self::getWebRoot() . 'admin/update.png" border="0" style="padding-top: 3px" title="In order to update this template, you will have to select it and save your choice."/>';

                        $sHTML .= '</div>';
                        $sHTML .= '<input type="radio" ' . (@$aLocal[@$aTemplate['name']]['active'] ? "checked" : "") . ' name="activeTemplate" value="' . $aTemplate['name'] . '" style="float: left; margin-top: 40px; margin-right: 10px;">';
                        $sHTML .= '<img src="' . $aTemplate['thumb'] . '" border="0" style="position: relative; z-index: 1; float: left; margin: 0 10px 0 0"><h3>' . $aTemplate['title'] . '</h3><br/>' . $aTemplate['description'];
                        $sHTML .= '</div>';

                        echo $sHTML;

                        $iShown++;
                    }
                }
                else {
                    $bInstalled = false;
                    $bNewerAvailable = false;

                    if (array_key_exists($aXml['template']['name'], $aLocal)) {
                        $aLocal[$aXml['template']['name']]['shown'] = true;
                        $bInstalled = true;

                        $sCurrentVersion = $aLocal[$aXml['template']['name']]['version'];

                        $aExplode = explode(".", $aXml['template']['version']);
                        $aCurrentVersion = explode(".", $sCurrentVersion);
                        $bNewerAvailable = false;

                        if (is_array($aExplode) && is_array($aCurrentVersion)) {
                            $bNewerAvailable = ($aExplode[0] > $aCurrentVersion[0] ||
                            ($aExplode[0] == $aCurrentVersion[0] && $aExplode[1] > $aCurrentVersion[1]) ||
                            ($aExplode[0] == $aCurrentVersion[0] && $aExplode[1] == $aCurrentVersion[1] && $aExplode[2] > $aCurrentVersion[2]));
                        }
                    }

                    $sHTML = '<div style="border: 1px solid #8CC63F; background-color: #D7EBBC; height: 90px; padding: 10px; font-family: Arial, Verdana; font-size: 11px; margin: 10px">';
                    $sHTML .= '<div style="position: relative; width: 140px; text-align: right; height: 70px; float: right">';

                    if ($bInstalled)
                    $sHTML .= '<img src="' . self::getWebRoot() . 'admin/installed.png" border="0"/>';

                    if ($bNewerAvailable)
                    $sHTML .= '<img src="' . self::getWebRoot() . 'admin/update.png" border="0" style="padding-top: 3px" title="In order to update this template, you will have to select it and save your choice."/>';

                    $sHTML .= '</div>';
                    $sHTML .= '<input type="radio" ' . (@$aLocal[@$aXml['template']['name']]['active'] ? "checked" : "") . ' name="activeTemplate" value="' . $aXml['template']['name'] . '" style="float: left; margin-top: 40px; margin-right: 10px;">';
                    $sHTML .= '<img src="' . $aXml['template']['thumb'] . '" border="0" style="position: relative; z-index: 1; float: left; margin: 0 10px 0 0"><h3>' . $aXml['template']['title'] . '</h3><br/>' . $aXml['template']['description'];
                    $sHTML .= '</div>';

                    echo $sHTML;

                    $iShown++;
                }
            }
        }

        foreach ($aLocal as $aTemplate) {
            if ($aTemplate['shown'] == false) {
                $sHTML = '<div style="border: 1px solid #999999; background-color: #EAEAeA; height: 90px; padding: 10px; font-family: Arial, Verdana; font-size: 11px; margin: 10px">';
                $sHTML .= '<div style="position: relative; width: 90px; text-align: right; height: 70px; float: right">';
                $sHTML .= '<img src="' . self::getWebRoot() . 'admin/local.png" border="0" />';

                $sHTML .= '</div>';
                $sHTML .= '<input type="radio" ' . ($aTemplate['active'] ? "checked" : "") . ' name="activeTemplate" value="' . $aTemplate['name'] . '" style="float: left; margin-top: 40px; margin-right: 10px;">';
                $sHTML .= '<img src="' . self::getWebRoot() . 'admin/campaign/' . $aTemplate['name'] . "/" . $aTemplate['thumb'] . '" border="0" style="position: relative; z-index: 1; float: left; margin: 0 10px 0 0"><h3>' . $aTemplate['title'] . '</h3><br/>' . $aTemplate['description'];
                $sHTML .= '</div>';

                echo $sHTML;
                $iShown++;
            }
        }

        if ($iShown > 0)
        echo '<input type="submit" value=" Save choice " style="margin: 10px; float: right"/>';

        echo '</form>';
    }

    public function downloadFile($url, $targetFile) {
        try {
            $urlData = parse_url($url);
            $port = isset($urlData['port']) ? $urlData['port'] : 80;

            $fp = fsockopen($urlData['host'], $port);

            $query = 'GET ' . $urlData['path'] . " HTTP/1.0\n";
            $query .= 'Host: ' . $urlData['host'];
            $query .= "\n\n";

            fwrite($fp, $query);

            while ($line = fread($fp, 1024)) {
                $buffer .= $line;
            }

            preg_match('/Content-Length: ([0-9]+)/', $buffer, $parts);
            $result = substr($buffer, - $parts[1]);

            $resultFile = fopen($targetFile, "w+");
            fwrite($resultFile, $result);
            fclose($resultFile);

            return $targetFile;
        } catch (Exception $e) {
            echo '<div style="border: 1px solid #CC0000; background-color: #F5CCCC; padding: 10px; font-family: Arial, Verdana; font-size: 11px; margin: 10px">' . "<img src='" . $this->web_root . "flags/" . $country . ".png' border='0' title='" . $pclass->getCountry() . "' /> " . '<b>Error:</b><br/>' . $e->getMessage() . '<br/><br/><b>Code:</b><br/>' . $e->getCode() . '</div>';
        }
    }

    public static function getLocalTemplates() {
        $sLocation =  DIR_KLARNA . 'checkout/html/campaigns/';
        $aTemplates = scandir($sLocation);

        $aResult = array();

        foreach ($aTemplates as $sDir) {
            if (($sDir != "." || $sDir != "..") && file_exists($sLocation . "/" . $sDir . "/campaign.xml")) {
                $oXml = simplexml_load_file($sLocation . "/" . $sDir . "/campaign.xml", 'SimpleXMLElement', LIBXML_NOCDATA);
                $aXml = self::xmlToArray($oXml, 0);

                $aResult[$aXml['name']] = $aXml;
                $aResult[$aXml['name']]['shown'] = false;
                $aResult[$aXml['name']]['name'] = $sDir;
                $aResult[$aXml['name']]['active'] = (MODULE_PAYMENT_SPECKLARNA_ACTIVE_TEMPLATE == $aXml['name']);
            }
        }

        return $aResult;
    }

    public static function getLocalTemplate($sTemplateName) {
        $sLocation =  DIR_KLARNA . 'checkout/html/campaigns/';
        $aTemplates = scandir($sLocation);

        $aResult = array();

        foreach ($aTemplates as $sDir) {
            if ($sDir == $sTemplateName) {
                $oXml = simplexml_load_file($sLocation . "/" . $sDir . "/campaign.xml", 'SimpleXMLElement', LIBXML_NOCDATA);

                $aResult = self::xmlToArray($oXml, 0);
                $aResult['shown'] = false;
                $aResult['name'] = $sDir;
                $aResult['active'] = (MODULE_PAYMENT_SPECKLARNA_ACTIVE_TEMPLATE == $aXml['name']);
            }
        }

        return $aResult;
    }

    public static function getKlarnaFee() {
        global $order, $xtPrice;
        $cart = $_SESSION['cart'];
        $order_total = $order->info['total'];
        $currency = $order->info['currency'];
        $currencies = $xtPrice->currencies;
        $customer_id = $_SESSION['customer_id'];
        $customer_country_id = $_SESSION['customer_country_id'];
        $amount = $order->info['total'];

        $od_amount = 0;

        $payment = $_SESSION['payment'];

        if (MODULE_ORDER_TOTAL_KLARNA_FEE_MODE == 'fixed') {
            switch (strtolower($order->customer['country']['iso_code_2'])) {
                case "se":
                    $od_amount = MODULE_ORDER_TOTAL_KLARNA_FEE_FIXED_SE;
                    break;
                case "dk":
                    $od_amount = MODULE_ORDER_TOTAL_KLARNA_FEE_FIXED_DK;
                    break;
                case "fi":
                    $od_amount = MODULE_ORDER_TOTAL_KLARNA_FEE_FIXED_FI;
                    break;
                case "no":
                    $od_amount = MODULE_ORDER_TOTAL_KLARNA_FEE_FIXED_NO;
                    break;
                case "de":
                    $od_amount = MODULE_ORDER_TOTAL_KLARNA_FEE_FIXED_DE;
                    break;
                case "nl":
                    $od_amount = MODULE_ORDER_TOTAL_KLARNA_FEE_FIXED_NL;
                    break;
                default:
                    break;
            }
        } else {
            $fee_table = "";

            switch (strtolower($order->customer['country']['iso_code_2'])) {
                case "se":
                    $fee_table = MODULE_ORDER_TOTAL_KLARNA_FEE_TABLE_SE;
                    break;
                case "dk":
                    $fee_table = MODULE_ORDER_TOTAL_KLARNA_FEE_TABLE_DK;
                    break;
                case "fi":
                    $fee_table = MODULE_ORDER_TOTAL_KLARNA_FEE_TABLE_FI;
                    break;
                case "no":
                    $fee_table = MODULE_ORDER_TOTAL_KLARNA_FEE_TABLE_NO;
                    break;
                case "de":
                    $fee_table = MODULE_ORDER_TOTAL_KLARNA_FEE_TABLE_DE;
                    break;
                case "nl":
                    $fee_table = MODULE_ORDER_TOTAL_KLARNA_FEE_TABLE_NL;
                    break;
                default:
                    break;
            }

            $table = preg_split("/[:,]/", $fee_table);
            $size = sizeof($table);
            for ($i = 0, $n = $size; $i < $n; $i+=2) {
                if ($amount <= $table[$i]) {
                    $od_amount = $table[$i + 1];
                    break;
                }
            }
        }

        if ($od_amount == 0)
            return $od_amount;

        if (MODULE_ORDER_TOTAL_KLARNA_FEE_TAX_CLASS > 0) {
            $tod_rate = xtc_get_tax_rate(MODULE_ORDER_TOTAL_KLARNA_FEE_TAX_CLASS);
            $tod_amount = $od_amount - $od_amount / ($tod_rate / 100 + 1);
            $order->info['tax'] += $tod_amount;
            $tax_desc = xtc_get_tax_description( MODULE_ORDER_TOTAL_KLARNA_FEE_TAX_CLASS,
                                $customer_country_id, $customer_zone_id);
            $order->info['tax_groups']["$tax_desc"] += $tod_amount;
        }

        $showTax = $GLOBALS['customers_status_value']['customers_status_show_price_tax'];
        if ($showTax == 1) {
            $od_amount = $od_amount;
        } else {
            $od_amount = $od_amount - $tod_amount;
            $order->info['total'] += $tod_amount;
        }

        return ($od_amount);
    }
}
