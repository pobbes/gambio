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
include_once(DIR_FS_DOCUMENT_ROOT . 'includes/modules/klarna/class.Klarna_xt.php');
include_once(DIR_KLARNA . 'klarnautils.php');
include_once(DIR_KLARNA . 'checkout/classes/class.KlarnaAPI.php');
include_once(DIR_KLARNA . 'checkout/classes/class.KlarnaHTTPContext.php');

class ot_klarna_fee {

    var $title, $output;

    function ot_klarna_fee() {
        global $order;
        $this->code = 'ot_klarna_fee';
        $country = strtolower($order->customer['country']['iso_code_2']);

        $lang = KlarnaUtils::getLanguage($country);

        if (strpos($_SERVER['SCRIPT_FILENAME'], 'admin')) {
            $lang = KlarnaLanguage::fromCode($_SESSION['language_code']);
            $this->title = "Klarna " . $this->translate("INVOICE_FEE_TITLE", $lang);
        } else {
            $this->title = $this->translate("INVOICE_FEE_TITLE", $lang);
        }
        $this->description = $this->translate("INVOICE_FEE_TITLE", $lang);
        $this->enabled = MODULE_ORDER_TOTAL_KLARNA_FEE_STATUS;
        $this->sort_order = MODULE_ORDER_TOTAL_KLARNA_FEE_SORT_ORDER;
        $this->tax_class = MODULE_ORDER_TOTAL_KLARNA_FEE_TAX_CLASS;
        $this->output = array();
    }

    function process() {
        global $order, $ot_subtotal, $xtPrice;

        $currency = $order->info['currency'];
        $currencies = $xtPrice->currencies;
        $od_amount = $this->calculate_credit($this->get_order_total());

        //Disable module when $od_amount is <= 0
        if ($od_amount <= 0)
            $this->enabled = false;

        if ($od_amount != 0) {
            $tax_rate = xtc_get_tax_rate(MODULE_ORDER_TOTAL_KLARNA_FEE_TAX_CLASS);

            $this->output[] = array('title' => $this->title . ':',
                'text' => $currencies[$currency]['symbol_left'] . " " .
                            number_format((float) $od_amount, 2) . " " .
                            $currencies[$currency]['symbol_right'],
                'value' => $od_amount,
                'tax_rate' => $tax_rate);
            $order->info['total'] = $order->info['total'] + $od_amount;
        }
    }

    function calculate_credit($amount) {
        global $order, $xtPrice;
        $cart = $_SESSION['cart'];
        $order_total = $order->info['total'];
        $currency = $order->info['currency'];
        $currencies = $xtPrice->currencies;
        $customer_id = $_SESSION['customer_id'];
        $customer_country_id = $_SESSION['customer_country_id'];


        $od_amount = 0;

        $payment = $_SESSION['payment'];

        if ($payment != "klarna_invoice")
            return $od_amount;

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
                    $od_amount = null;
                    $this->enabled = false;
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
                    $fee_table = null;
                    $this->enabled = false;
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
            $order->info['tax_groups'][TAX_ADD_TAX. "$tax_desc"] += $tod_amount;
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

    function get_order_total() {
        global $order, $xtPrice;
        $cart = $_SESSION['cart'];
        $order_total = $order->info['total'];
        $currency = $order->info['currency'];
        $customer_id = $_SESSION['customer_id'];
        $customer_country_id = $_SESSION['customer_country_id'];
        $currencies = $xtPrice->currencies;
        // Check if gift voucher is in cart and adjust total
        $products = $cart->get_products();
        for ($i = 0; $i < sizeof($products); $i++) {
            $t_prid = xtc_get_prid($products[$i]['id']);

            $gv_query = xtc_db_query(
                "select products_price, products_tax_class_id, " .
                "products_model from " . TABLE_PRODUCTS .
                " where products_id = '" . $t_prid . "'");

            $gv_result = xtc_db_fetch_array($gv_query);

            if (preg_match('/^GIFT/', addslashes($gv_result['products_model']))) {
                $qty = $cart->get_quantity($t_prid);
                $products_tax =
                    xtc_get_tax_rate($gv_result['products_tax_class_id']);

                if ($this->include_tax == 'false') {
                    $gv_amount = $gv_result['products_price'] * $qty;
                } else {
                    $gv_amount = ($gv_result['products_price'] +
                        xtc_calculate_tax(
                        $gv_result['products_price'], $products_tax)) * $qty;
                }
                $order_total = $order_total - $gv_amount;
            }
        }

        if ($this->include_tax == 'false')
            $order_total = $order_total - $order->info['tax'];

        if ($this->include_shipping == 'false')
            $order_total = $order_total - $order->info['shipping_cost'];

        return $order_total * $currencies[$currency]['value'];
    }

    function check() {
        if (!isset($this->check)) {
            $check_query = xtc_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_ORDER_TOTAL_KLARNA_FEE_STATUS'");
            $this->check = xtc_db_num_rows($check_query);
        }

        return $this->check;
    }

    function install() {
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (sort_order, configuration_key, configuration_value, configuration_group_id, set_function, date_added)
            values ('0', 'MODULE_ORDER_TOTAL_KLARNA_FEE_STATUS', 'true', '6', 'xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (sort_order, configuration_key, configuration_value, configuration_group_id, set_function, date_added)
            values ('1', 'MODULE_ORDER_TOTAL_KLARNA_FEE_MODE', 'fixed', '6', 'xtc_cfg_select_option(array(\'fixed\', \'price\'), ', now())");


        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (sort_order, configuration_key, configuration_value, configuration_group_id, date_added)
            values ('2', 'MODULE_ORDER_TOTAL_KLARNA_FEE_FIXED_SE', '20', '6', now())");

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (sort_order, configuration_key, configuration_value, configuration_group_id, date_added)
            values ('3', 'MODULE_ORDER_TOTAL_KLARNA_FEE_TABLE_SE', '200:20,500:10,10000:5', '6', now())");


        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (sort_order, configuration_key, configuration_value, configuration_group_id, date_added)
            values ('4', 'MODULE_ORDER_TOTAL_KLARNA_FEE_FIXED_DK', '20', '6', now())");

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (sort_order, configuration_key, configuration_value, configuration_group_id, date_added)
            values ('5', 'MODULE_ORDER_TOTAL_KLARNA_FEE_TABLE_DK', '200:20,500:10,10000:5', '6', now())");


        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (sort_order, configuration_key, configuration_value, configuration_group_id, date_added)
            values ('6', 'MODULE_ORDER_TOTAL_KLARNA_FEE_FIXED_FI', '20', '6', now())");

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (sort_order, configuration_key, configuration_value, configuration_group_id, date_added)
            values ('7', 'MODULE_ORDER_TOTAL_KLARNA_FEE_TABLE_FI', '200:20,500:10,10000:5', '6', now())");


        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (sort_order, configuration_key, configuration_value, configuration_group_id, date_added)
            values ('8', 'MODULE_ORDER_TOTAL_KLARNA_FEE_FIXED_DE', '20', '6', now())");

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (sort_order, configuration_key, configuration_value, configuration_group_id, date_added)
            values ('9', 'MODULE_ORDER_TOTAL_KLARNA_FEE_TABLE_DE', '200:20,500:10,10000:5', '6', now())");


        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (sort_order, configuration_key, configuration_value, configuration_group_id, date_added)
            values ('10','MODULE_ORDER_TOTAL_KLARNA_FEE_FIXED_NL', '20', '6', now())");

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (sort_order, configuration_key, configuration_value, configuration_group_id, date_added)
            values ('11', 'MODULE_ORDER_TOTAL_KLARNA_FEE_TABLE_NL', '200:20,500:10,10000:5', '6', now())");


        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (sort_order, configuration_key, configuration_value, configuration_group_id, date_added)
            values ('12', 'MODULE_ORDER_TOTAL_KLARNA_FEE_FIXED_NO', '20', '6', now())");

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (sort_order, configuration_key, configuration_value, configuration_group_id, date_added)
            values ('13', 'MODULE_ORDER_TOTAL_KLARNA_FEE_TABLE_NO', '200:20,500:10,10000:5', '6', now())");


        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (sort_order, configuration_key, configuration_value, configuration_group_id, use_function, set_function, date_added)
            values ('4', 'MODULE_ORDER_TOTAL_KLARNA_FEE_TAX_CLASS', '0', '6', 'xtc_get_tax_class_title', 'xtc_cfg_pull_down_tax_classes(', now())");

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (sort_order, configuration_key, configuration_value, configuration_group_id, date_added)
            values ('5', 'MODULE_ORDER_TOTAL_KLARNA_FEE_SORT_ORDER', '45', '6', now())");
    }

    function remove() {
        $keys = '';
        $keys_array = $this->keys();
        for ($i = 0; $i < sizeof($keys_array); $i++) {
            $keys .= "'" . $keys_array[$i] . "',";
        }
        $keys = substr($keys, 0, -1);

        xtc_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in (" . $keys . ")");
    }

    function keys() {
        return array('MODULE_ORDER_TOTAL_KLARNA_FEE_STATUS',
            'MODULE_ORDER_TOTAL_KLARNA_FEE_MODE',
            'MODULE_ORDER_TOTAL_KLARNA_FEE_FIXED_SE',
            'MODULE_ORDER_TOTAL_KLARNA_FEE_TABLE_SE',
            'MODULE_ORDER_TOTAL_KLARNA_FEE_FIXED_DK',
            'MODULE_ORDER_TOTAL_KLARNA_FEE_TABLE_DK',
            'MODULE_ORDER_TOTAL_KLARNA_FEE_FIXED_FI',
            'MODULE_ORDER_TOTAL_KLARNA_FEE_TABLE_FI',
            'MODULE_ORDER_TOTAL_KLARNA_FEE_FIXED_DE',
            'MODULE_ORDER_TOTAL_KLARNA_FEE_TABLE_DE',
            'MODULE_ORDER_TOTAL_KLARNA_FEE_FIXED_NL',
            'MODULE_ORDER_TOTAL_KLARNA_FEE_TABLE_NL',
            'MODULE_ORDER_TOTAL_KLARNA_FEE_FIXED_NO',
            'MODULE_ORDER_TOTAL_KLARNA_FEE_TABLE_NO',
            'MODULE_ORDER_TOTAL_KLARNA_FEE_TAX_CLASS',
            'MODULE_ORDER_TOTAL_KLARNA_FEE_SORT_ORDER'
        );
    }

    private function translate($sTitle, $lang) {
        $kLang = new KlarnaLanguagePack(DIR_KLARNA . 'checkout/data/language.xml');
        return $kLang->fetch($sTitle, $lang);
    }
}
