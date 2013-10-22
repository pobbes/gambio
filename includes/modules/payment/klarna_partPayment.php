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
 * @since 1.0 - 31 mar 2011
 */
/* --------------------------------------------------------------
Released under the GNU General Public License (Version 2)
[http://www.gnu.org/licenses/gpl-2.0.html]
--------------------------------------------------------------
*/
include_once(DIR_FS_DOCUMENT_ROOT . 'includes/modules/klarna/class.Klarna_xt.php');
include_once(DIR_KLARNA . 'klarnautils.php');
include_once(DIR_KLARNA . 'checkout/classes/class.KlarnaAPI.php');
include_once(DIR_KLARNA . 'checkout/classes/class.KlarnaHTTPContext.php');

if (isset($i))
    $_i = $i;

/**
 * Dependencies from {@link http://phpxmlrpc.sourceforge.net/}
 *
 * Ungly incude due to problems in XMLRPC lib (external)
 */
include_once(DIR_KLARNA . 'api/transport/xmlrpc-3.0.0.beta/lib/xmlrpc.inc');
include_once(DIR_KLARNA . 'api/transport/xmlrpc-3.0.0.beta/lib/xmlrpc_wrappers.inc');

if (isset($_i))
$i = $_i;

class klarna_partPayment {
        /**
     * The version of this module
     *
     * @var string
     */
    private $version = KLARNA_MODULE_VERSION;

    /**
     * The klarna API 2.0 class object
     *
     * @var Klarna
     */
    private $klarna;

    /**
     * The merchant ID
     *
     * @var int
     */
    private $eid;

    /**
     * The address object for the customer
     *
     * @var KlarnaAddr
     */
    private $addrs;

    /**
     * The customers invoice type
     *
     * @var string
     */
    private $invoiceType;

    /**
     * The secret for merchant
     *
     * @var string
     */
    private $secret;

    /**
     *
     * @var string
     */
    private $web_root;

    /**
     * The Klarna Standard Register API
     *
     * @var KlarnaAPI
     */
    private $KlarnaAPI;

    /**
     * Klarna data as an associative array
     * @var array
     */
    public $klarna_data;

    /**
     * The chosen payment plan
     *
     * @var string
     */
    private $paymentPlan;
    /**
     * Payment code
     */
    public $code;

    public $title;

    public function isDutch() {
        return (strtolower($this->klarna_data['country']) == "nl");
    }

    public function isGerman() {
        return (strtolower($this->klarna_data['country']) == "de");
    }

    /**
     * The constructor
     *
     * @return void
     */
    public function klarna_partPayment() {
        global $order, $xtPrice;
        
        $currency = $_SESSION['currency'];
        $customer_id = $_SESSION['customer_id'];
        $customer_country_id = $_SESSION['customer_country_id'];
        $currencies = $xtPrice->currencies;

        $this->code = 'klarna_partPayment';
        $this->enabled = true;
        $this->web_root = KlarnaUtils::getWebRoot();

        if(is_array($order->delivery['country'])) {
            KlarnaUtils::addKlarnaData('country',
                                    $order->delivery['country']['iso_code_2']);
        } else {
            $query = xtc_db_query("SELECT countries_iso_code_2 FROM countries ".
                                    "WHERE countries_id = " .
                                    (int)$_SESSION['customer_country_id']);
            $result = xtc_db_fetch_array($query);
            if(is_array($result)) {
                KlarnaUtils::addKlarnaData('country', $result['countries_iso_code_2']);
            }
        }

        $lang = KlarnaLanguage::fromCode($_SESSION['language_code']);
        $this->eid = KlarnaUtils::getEid($this->klarna_data['country'], 'part');
        $this->secret = KlarnaUtils::getSecret($this->klarna_data['country'], 'part');

        if(strpos($_SERVER['SCRIPT_FILENAME'],'admin')) {
            if (strtolower(MODULE_PAYMENT_PCKLARNA_LATESTVERSION) == "true") {
                KlarnaUtils::checkForLatestVersion();
            }
            $this->title = '<img src="'. KlarnaUtils::getWebRoot() .'logo/klarna_tulip.gif" /> '. $this->translate('MODULE_PARTPAY_TEXT_TITLE', $lang);
        }

        $this->description  =  '<img src="' . $this->web_root . 'logo/logo_small.png" border="0" /></br>'.
                                $this->translate('PARTPAY_TEXT_DESCRIPTION', $lang) .
                                '<br/><br/><img src="images/icon_popup.gif" border="0">&nbsp;'.
                                '<a href="https://www.klarna.com" target="_blank" style="text-decoration: underline; font-weight: bold;">Visit Klarna\'s Website</a>';
        if (empty($this->eid) || empty($this->secret) || $this->klarna_data['country'] == null) {
            $this->enabled = false;
            $this->sort_order = null;
        } else {
            $this->sort_order = MODULE_PAYMENT_PCKLARNA_SORT_ORDER;

            $mode = KlarnaUtils::getMode('part');
            $pcURI = KlarnaUtils::getPCUri();

            $this->klarna = new Klarna_xt();
            $this->klarna->config($this->eid, $this->secret,
                                $this->klarna_data['country'], $currency, null,
                                $mode, "mysql", $pcURI, true);

            $totalSum = 0;
            if ($order != null) {
                for ($i = 0; $i < count($order->products); $i++) {
                    $totalSum += $order->products[$i]['final_price'];
                }
            }
            if ( self::isDutch() && $totalSum > 250) {
                $this->enabled = false;
            }

            $this->KlarnaAPI = new KlarnaAPI($this->klarna_data['country'], null,
                                    'part', $totalSum, KlarnaFlags::CHECKOUT_PAGE,
                                    $this->klarna, array(KlarnaPClass::ACCOUNT,
                                                        KlarnaPClass::CAMPAIGN,
                                                        KlarnaPClass::FIXED),
                                    DIR_KLARNA . 'checkout/');
            $this->KlarnaAPI->addSetupValue('eid', $this->eid);
            $this->KlarnaAPI->addSetupValue('web_root', $this->web_root);
            $this->KlarnaAPI->setPaths();

            if ($totalSum > 0 && !strpos($_SERVER['SCRIPT_FILENAME'], 'admin')) {
                $pclasses = $this->KlarnaAPI->aPClasses;
                if (empty($pclasses)) {
                    $this->enabled = false;
                }

                $cheapest = 0;
                $minimum = '';
                foreach ($pclasses as $pclass) {
                    if ( $cheapest == 0 || $pclass['monthlyCost'] < $cheapest) {
                        $cheapest = $pclass['monthlyCost'];
                    }
                    if ($pclass['pclass']->getMinAmount() < $minimum || $minimum === '') {
                        $minimum = $pclass['pclass']->getMinAmount();
                    }
                }

                if ($totalSum < $minimum) {
                    $this->enabled = false;
                }
                $sFee  = $currencies[$currency]['symbol_left'] . number_format((float) $cheapest, 2) . $currencies[$currency]['symbol_right'];
                $this->title = str_replace('xx', $sFee, $this->translate('PARTPAY_TITLE'));
            }

            if ($this->enabled)
                 $this->enabled = (in_array($this->klarna_data['country'], explode(",", MODULE_PAYMENT_KLARNA_PARTPAYMENT_ALLOWED)));

            try {
                $this->klarna->setCurrency($currency);
            } catch (Exception $e) {
                $this->enabled = false;
            }

            // If $order is an object we want to update status instead of doing
            // the other things. This is because xt:commerce has $order as an array
            // until an order is placed, after that it is an object.
            if (is_object($order))
                $this->update_status();

            $this->form_action_url = xtc_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL', false);

            if (!$this->klarna->checkCountryCurrency()) {
                $this->enabled = false;
            }

            if ($this->enabled)
                $this->enabled = ((MODULE_PAYMENT_PCKLARNA_STATUS == 'True') ? true : false);
        }

        if(strpos($_SERVER['SCRIPT_FILENAME'],'admin') && MODULE_PAYMENT_PCKLARNA_STATUS == 'True') {
            $this->description .= '<br/><br/><div align="center"><a href="modules.php?set=payment&module=klarna_partPayment&get_pclasses=true" class="button" >Update pclasses</a></div><br />';
        }
    }

    public function update_status() {
        global $order;

        if ($this->enabled == true && (int)MODULE_PAYMENT_PCKLARNA_ZONE > 0) {
            $check_flag = false;
            $check_query = xtc_db_query("select zone_id from " .
            TABLE_ZONES_TO_GEO_ZONES .
                " where geo_zone_id <= '" .
            MODULE_PAYMENT_PCKLARNA_ZONE .
                "' and zone_country_id = '" .
            $order->delivery['country']['id'] .
            "' order by zone_id");

            while ($check = xtc_db_fetch_array($check_query)) {
                if ($check['zone_id'] < 1) {
                    $check_flag = true;
                    break;
                } elseif ($check['zone_id'] == $order->delivery['zone_id']) {
                    $check_flag = true;
                    break;
                }
            }

            if ($check_flag == false)
            $this->enabled = false;

            if (!$this->klarna->checkCountryCurrency()) {
                $this->enabled = false;
            }
        }
    }

    public function javascript_validation() {
        return false;
    }

    /**
     * This function outputs the payment method title/text and if required, the input fields.
     *
     * @return array Data to present in page
     *
     */
    public function selection() {
        global $order, $customer_id, $xtPrice;

        $currency = $_SESSION['currency'];
        $customer_id = $_SESSION['customer_id'];
        $customer_country_id = $_SESSION['customer_country_id'];
        $currencies = $xtPrice->currencies;

        // No invoice fee for part payment.
        $klarna_fee = 0;

        $totalSum   = 0;
        if ($order != null) {
            foreach($order->products as $product) {
                $totalSum += $product['final_price'];
            }
        }

        if (KlarnaUtils::getErrorOption() == 'part') {
            $error = KlarnaUtils::getError();
            $option = KlarnaUtils::getErrorOption();
            KlarnaUtils::clearErrors();
        }

        if (!isset($_SESSION['klarna_data']['klarna_addr']) && (isset($order)))
        {
         KlarnaUtils::setKlarnaData($order);
        }

        if (!isset($_SESSION['klarna_order_part']))
        {
            KlarnaUtils::setKlarnaData($order);
            }

        if (isset($option) && $option == 'part') {
            KlarnaUtils::addKlarnaData('paymentPlan', $_SESSION['klarna_paymentPlan']);
        }

        $aParams = KlarnaUtils::getParams('part', $this->klarna_data['country']);
        $aValues = KlarnaUtils::getValues($this->klarna_data);

        if ( self::isGerman() ) {
            // Set the AGB link
            $this->KlarnaAPI->addSetupValue('agb_link', KlarnaUtils::getAGBLink());
            // Open in a new window.
            $this->KlarnaAPI->addSetupValue('agb_target', "_blank");
        }

        if (isset($error)) {
            $this->KlarnaAPI->addSetupValue('red_baloon_content', $error);
            $this->KlarnaAPI->addSetupValue('red_baloon_paymentBox', 'klarna_box_'.$option);
        }

        $fields = array();
        $fields[] = array('title' => "", 'field' => $this->KlarnaAPI->retrieveHTML($aParams, $aValues));
        $_SESSION['klarna_order_part'] = "ja";
        return array('id' => $this->code, 'module' => $this->title, 'fields' => $fields);
    }

    /**
     * This function implements any checks of any conditions after payment method has been selected.
     *
     * @return void
     */
    public function pre_confirmation_check() {
        global $order;
        KlarnaUtils::cleanPost();

        $_SESSION['klarna_paymentPlan'] = $_POST['klarna_part_paymentPlan'];

        $this->addrs        = KlarnaUtils::handlePost($this->klarna_data['country'], 'part', $this->klarna);
        $this->paymentPlan  = (int)$_POST['klarna_part_paymentPlan'];
        $order->delivery    = array_merge($order->delivery, KlarnaUtils::buildDelivery($this->addrs, 'part'));

        if( self::isGerman() || self::isDutch() ) {
            $order->billing = $order->delivery;
        }

        $_SESSION['klarna_data']['klarna_addr'] = serialize($this->addrs);
    }

    /**
     * Implements any checks or processing on the order information before proceeding to payment confirmation.
     *
     * @return array
     */
    public function confirmation() {
        $html .= '<a href="http://www.klarna.com"><img src="' . $this->web_root . 'logo/' . strtolower($this->klarna_data['country']) . '/klarna_account.png" /></a>';
        return array('title' => $html);
    }

    /**
     * Outputs the html form hidden elements sent as POST data to the payment gateway.
     *
     * @return string
     */
    public function process_button() {
        global $order, $klarna_ot, $order_total_modules;

        $invoiceType = $_POST['invoiceType'];

        $process_button_string = KlarnaUtils::hiddenFieldString($this->addrs,
                    $invoiceType, $this->paymentPlan,
                    $order->customer['email_address'], $this->klarna_data['reference']);

        if ($this->addrs->isCompany) {
            $process_button_string .= xtc_draw_hidden_field('klarna_fname', $order->delivery['firstname']).
            xtc_draw_hidden_field('klarna_lname', $order->delivery['lastname']);
        } else {
            $process_button_string .= xtc_draw_hidden_field('klarna_fname', $this->addrs->getFirstName()).
            xtc_draw_hidden_field('klarna_lname', $this->addrs->getLastName());
        }

        // This is a bit of a hack. The problem is that we need access to
        // all additional charges, ie the order_totals list, later in
        // before_process(), but at that point order_totals->process hasn't
        // been run in that process. We cannot run it ourselves since
        // checkout_process.php will run it after running before_process.
        // Running it twice causes an error message since the classes
        // will be redefined.
        //
        // An alternative to this ugly code is to modify checkout_process.php
        // or order_total.php but we want to avoid that.

        $order_totals = $order_total_modules->modules;

        if (is_array($order_totals)) {
            reset($order_totals);
            $j = 0;
            $table = preg_split("/[,]/", MODULE_PAYMENT_PCKLARNA_ORDER_TOTAL_IGNORE);

            while (list(, $value) = each($order_totals)) {
                $class = substr($value, 0, strrpos($value, '.'));

                if (!$GLOBALS[$class]->enabled) {
                    continue;
                }
                $code = $GLOBALS[$class]->code;
                $ignore = false;

                for ($i = 0; $i < sizeof($table) && $ignore == false; $i++) {
                    if ($table[$i] == $code) {
                        $ignore = true;
                    }
                }

                $size = sizeof($GLOBALS[$class]->output);

                if ($ignore == false && $size > 0) {
                    $klarna_ot['code_size_' . $j] = $size;
                    for ($i = 0; $i < $size; $i++) {
                        $klarna_ot['title_' . $j . '_' . $i] = html_entity_decode($GLOBALS[$class]->output[$i]['title']);
                        $klarna_ot['text_' . $j . '_' . $i] = $GLOBALS[$class]->output[$i]['text'];
                        if (is_numeric($GLOBALS[$class]->deduction) && $GLOBALS[$class]->deduction > 0) {
                            $klarna_ot['value_' . $j . '_' . $i] = -$GLOBALS[$class]->deduction;
                        } else {
                            $klarna_ot['value_' . $j . '_' . $i] = $GLOBALS[$class]->output[$i]['value'];

                            // Add tax rate for shipping address and invoice fee
                            if ($class == 'ot_shipping') {
                                //Set Shipping VAT
                                $shipping_id = @explode('_', $_SESSION['shipping']['id']);
                                $tax_class = @$GLOBALS[$shipping_id[0]]->tax_class;
                                $tax_rate = 0;
                                if ($tax_class > 0) {
                                    $tax_rate = xtc_get_tax_rate($tax_class, $order->delivery['country']['id'], ($order->delivery['zone_id'] > 0) ? $order->delivery['zone_id'] : null);
                                }
                                $klarna_ot['tax_rate_' . $j . '_' . $i] = $tax_rate;
                            } else {
                                $klarna_ot['tax_rate_' . $j . '_' . $i] = $GLOBALS[$class]->output[$i]['tax_rate'];
                            }
                        }

                        $klarna_ot['code_' . $j . '_' . $i] = $GLOBALS[$class]->code;
                    }
                    $j += 1;
                }
            }
            $klarna_ot['code_entries'] = $j;
        }
        $_SESSION['klarna_ot'] = $klarna_ot;

        $process_button_string .= xtc_draw_hidden_field(xtc_session_name(), xtc_session_id());
        return $process_button_string;
    }

    public function before_process() {
        global $order, $customer_id, $currency, $currencies, $sendto, $billto, $klarna_ot, $xtPrice;
        $currency = $_SESSION['currency'];
        $customer_id = $_SESSION['customer_id'];
        $customer_country_id = $_SESSION['customer_country_id'];
        $currencies = $xtPrice->currencies;
        $klarna_ot = $_SESSION['klarna_ot'];

        try {
            $this->klarna->setCurrency($currency);
        }
        catch( Exception $e ) {
            KlarnaUtils::setError($this->translate('error_currency'), "part");
            xtc_redirect(KlarnaUtils::error_link(FILENAME_CHECKOUT_PAYMENT,
                '', 'SSL', true, false));
            return;
        }

        $paymentPlan = $_POST['klarna_paymentPlan'];
        KlarnaUtils::buildCart($this->klarna, $customer_id, $order, 'part', $this->code, $paymentPlan);

        $this->addrs = unserialize($_SESSION['klarna_data']['klarna_addr']);
        unset($_SESSION['klarna_order_part']);
        unset($_SESSION['klarna_order_invoice']);
        KlarnaUtils::addTransaction($this->klarna, $paymentPlan,
                        $this->addrs, "part", $this->klarna_data['country']);
    }

    public function after_process() {
        global $insert_id, $order;
        xtc_db_query('UPDATE ' . TABLE_ORDERS_STATUS_HISTORY . ' SET comments="Accepted by Klarna ' . date("Y-m-d G:i:s") .  ' Invoice #: ' . $_SESSION['klarna_invno'] .'" WHERE orders_id='.$insert_id);
        if (isset($_SESSION['klarna_orderstatus'])) {
            $sql_data_arr = array('orders_id' => $insert_id,
                                'orders_status_id' => "-1",
                                'comments' => "Klarna Orderstatus = " . $_SESSION['klarna_orderstatus'],
                                'customer_notified' => 0,
                                'date_added' => date("Y-m-d H:i:s"));
            xtc_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_arr);
        }
        $this->klarna->updateOrderNo($_SESSION['klarna_invno'], utf8_decode($insert_id));

        //Delete Session with user details
        unset($_SESSION['klarna_data']);
        unset($_SESSION['klarna_invno']);
        unset($_SESSION['klarna_orderstatus']);
        unset($_SESSION['klarna_order_part']);
        unset($_SESSION['klarna_order_invoice']);
        return false;
    }

    public function get_error() {
        $error = KlarnaUtils::getError();
        return array('title' => html_entity_decode($this->translate('error_klarna_title')), 'error' => $error);
    }

    public function check() {
        if (!isset($this->_check)) {
            $check_query = xtc_db_query("select configuration_value from " .
                    TABLE_CONFIGURATION .
                    " where configuration_key = " .
                "'MODULE_PAYMENT_PCKLARNA_STATUS'");
                $this->_check = xtc_db_num_rows($check_query);
        }
        return $this->_check;
    }

    public function install() {
        $sql = xtc_db_query("select orders_status_id from " . TABLE_ORDERS_STATUS . " ORDER BY orders_status_id DESC LIMIT 1");
        $result = xtc_db_fetch_array($sql);

        $newId    = (int)$result['orders_status_id']+1;
        xtc_db_query("insert into " . TABLE_ORDERS_STATUS . " (orders_status_id, orders_status_name) VALUES ('$newId', 'Klarna Pending [Part Payment]')");
        $newId += 1;
        xtc_db_query("insert into " . TABLE_ORDERS_STATUS . " (orders_status_id, orders_status_name) VALUES ('$newId', 'Klarna Denied [Part Payment]')");
        $newId += 1;
        xtc_db_query("insert into " . TABLE_ORDERS_STATUS . " (orders_status_id, orders_status_name) VALUES ('$newId', 'Klarna Approved [Part Payment]')");

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_PCKLARNA_STATUS', 'True', '6', '0', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_PCKLARNA_LATESTVERSION', 'True', '6', '0', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_PAYMENT_PCKLARNA_ZONE', '0', '6', '2', 'xtc_get_zone_class_title', 'xtc_cfg_pull_down_zone_classes(', now())");

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_PCKLARNA_EID_NL', '0', '6', '1', now())");

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_PCKLARNA_SECRET_NL', '', '6', '3', now())");

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_PCKLARNA_EID_SE', '0', '6', '2', now())");

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_PCKLARNA_SECRET_SE', '', '6', '4', now())");

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_PCKLARNA_EID_NO', '0', '6', '1', now())");

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_PCKLARNA_SECRET_NO', '', '6', '3', now())");

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_PCKLARNA_EID_DE', '0', '6', '2', now())");

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_PCKLARNA_SECRET_DE', '', '6', '4', now())");

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_PCKLARNA_EID_FI', '0', '6', '1', now())");

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_PCKLARNA_SECRET_FI', '', '6', '3', now())");

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_PCKLARNA_EID_DK', '0', '6', '2', now())");

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_PCKLARNA_SECRET_DK', '', '6', '4', now())");

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_PCKLARNA_ARTNO', 'id', '6', '8', 'xtc_cfg_select_option(array(\'id\', \'model\'),', now())");

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_PCKLARNA_ORDER_TOTAL_IGNORE', 'ot_tax,ot_total,ot_subtotal', '6', '9', now())");

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_PCKLARNA_SORT_ORDER', '0', '6', '20', now())");

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, use_function, date_added) values ('MODULE_PAYMENT_PCKLARNA_ORDER_STATUS_ID', '0', '6', '10', 'xtc_cfg_pull_down_order_statuses(', 'xtc_get_order_status_name', now())");

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, use_function, date_added) values ('MODULE_PAYMENT_PCKLARNA_ORDER_STATUS_PENDING_ID', '$newId', '6', '11', 'xtc_cfg_pull_down_order_statuses(', 'xtc_get_order_status_name', now())");

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_PCKLARNA_LIVEMODE', 'True', '6', '21', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_KLARNA_PARTPAYMENT_ALLOWED', 'SE,DK,NO,FI,NL,DE', '6', '14', now())");

    }

    public function remove() {
        xtc_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");

        xtc_db_query("delete from " . TABLE_ORDERS_STATUS . " where orders_status_name = 'Klarna Pending [Part Payment]'");
        xtc_db_query("delete from " . TABLE_ORDERS_STATUS . " where orders_status_name = 'Klarna Approved [Part Payment]'");
        xtc_db_query("delete from " . TABLE_ORDERS_STATUS . " where orders_status_name = 'Klarna Denied [Part Payment]'");
        xtc_db_query("DELETE FROM klarna_pclasses WHERE type <> 2");
    }

    public function keys() {
        // Fetching the pclasses
        $filename = explode('?', basename($_SERVER['REQUEST_URI'], 0));
        if ($filename[0] == "modules.php") {
            // Set the array
            $eid_array    = array();
            $aCountry = array('se','no','de','nl','dk','fi');

            foreach($aCountry as $country) {
            if(KlarnaUtils::getEid($country, 'part') > 0)
                {
                $eid_array[$country]['secret']      = KlarnaUtils::getSecret($country, 'part');
                $eid_array[$country]['eid']         = KlarnaUtils::getEid($country, 'part');
                }
            }

            $mode = KlarnaUtils::getMode("part");

            $pcstorage = new MySQLStorage;
            $pcstorage->load(KlarnaUtils::getPCUri());

            $count = xtc_db_num_rows(xtc_db_query("SELECT type FROM klarna_pclasses WHERE type <>2"));
            if ($count == 0 && !isset($_GET['get_pclasses'])) { 
               $this->description .= '<div style="border: 1px solid #8CC63F; background-color: #EED7BC; padding: 10px; font-family: Arial, Verdana; font-size: 11px; margin: 10px">';
                $this->description .= '<img src="' . $this->web_root . 'logo/logo_small.png" border="0" /> <b>(Part Payment module):</b><br/>';
                $this->description .= 'No pclasses in database, don\'t forget to fetch pclasses after configuring <strong>eid</strong> and <strong>Shared Secrets</strong>!';
                $this->description .= '</div>'; 
            }

            if ($_GET['view_pclasses'] == TRUE || $_GET['get_pclasses'] == TRUE) {
                KlarnaUtils::showPClasses($eid_array, 'part');
            }
        }

        // Return config fields
        return array('MODULE_PAYMENT_PCKLARNA_STATUS',
            'MODULE_PAYMENT_PCKLARNA_LATESTVERSION',
            'MODULE_PAYMENT_PCKLARNA_LIVEMODE',
            'MODULE_PAYMENT_PCKLARNA_EID_SE',
            'MODULE_PAYMENT_PCKLARNA_SECRET_SE',
            'MODULE_PAYMENT_PCKLARNA_EID_NO',
            'MODULE_PAYMENT_PCKLARNA_SECRET_NO',
            'MODULE_PAYMENT_PCKLARNA_EID_DE',
            'MODULE_PAYMENT_PCKLARNA_SECRET_DE',
            'MODULE_PAYMENT_PCKLARNA_EID_NL',
            'MODULE_PAYMENT_PCKLARNA_SECRET_NL',
            'MODULE_PAYMENT_PCKLARNA_EID_DK',
            'MODULE_PAYMENT_PCKLARNA_SECRET_DK',
            'MODULE_PAYMENT_PCKLARNA_EID_FI',
            'MODULE_PAYMENT_PCKLARNA_SECRET_FI',
            'MODULE_PAYMENT_KLARNA_PARTPAYMENT_ALLOWED',
            'MODULE_PAYMENT_PCKLARNA_ORDER_STATUS_ID',
            'MODULE_PAYMENT_PCKLARNA_ORDER_STATUS_PENDING_ID',
            'MODULE_PAYMENT_PCKLARNA_SORT_ORDER',
            'MODULE_PAYMENT_PCKLARNA_ZONE',
            'MODULE_PAYMENT_PCKLARNA_ARTNO');
    }

    private function translate($sTitle, $lang = null) {
        $kLang = new KlarnaLanguagePack(DIR_KLARNA .
                                            'checkout/data/language.xml');
        if ($lang == null) {
            $lang = $this->klarna->getLanguageForCountry(
                                            KlarnaCountry::fromCode(
                                                $this->klarna_data['country']));
        }
        return $kLang->fetch($sTitle, $lang);
    }
}
