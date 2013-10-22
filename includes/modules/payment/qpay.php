<?php

define('TABLE_PAYMENT_QPAY', 'payment_qpay');
define('FORM_URL', 'https://www.qenta.com/qpay/init.php');
define('QPAY_PLUGIN_VERSION', '1.2.2');

class qpay_core_ORIGIN {
    var $code, $title, $description, $enabled;

    var $process_cart_id;
    /// @note will be overwritten by child classes
    var $payment_type = 'SELECT';

    /// @brief initialize qpay module
    function init() {
        $this->code        = get_class($this);
        $c = strtoupper($this->code);
        $this->title       = qpay_core::constant("MODULE_PAYMENT_{$c}_TEXT_TITLE");
        $this->description = qpay_core::constant("MODULE_PAYMENT_{$c}_TEXT_DESCRIPTION");
        $this->info        = qpay_core::constant("MODULE_PAYMENT_{$c}_TEXT_INFO");

        $this->min_order   = qpay_core::constant("MODULE_PAYMENT_{$c}_MIN_ORDER");
        $this->sort_order  = qpay_core::constant("MODULE_PAYMENT_{$c}_SORT_ORDER");
        $this->enabled     = ((qpay_core::constant("MODULE_PAYMENT_{$c}_STATUS") == 'True') ? true : false);
    }

    function constant($name) {
      return (defined($name)) ? constant($name) : NULL;
    }

    function priceToFloat($price) {
      return str_replace(',', '.', array_shift(explode(' ',trim($price))));
    }

    /// @brief collect data and create a array with qpay infos
    function get_order_post_variables_array() {
        global $order, $xtPrice, $insert_id;
        $c = strtoupper($this->code);
        $pluginVersion = base64_encode('GambioGX; '.PROJECT_VERSION.'; ; webteam/gambio; '.QPAY_PLUGIN_VERSION);
        // check language
        $result = xtc_db_query("SELECT code FROM languages WHERE languages_id = '".$_SESSION['languages_id']."'");
        list($lang_code) = mysql_fetch_row($result);

        // set total price
        $total = round($order->info['pp_total'], 2);

        $consumerID = $_SESSION['customer_id'];
        $deliveryInformation = $order->delivery;
        if($deliveryInformation['country_iso_2'] == 'US' || $deliveryInformation['country_iso_2'] == 'CA')
        {
            $deliveryState = $this->_getZoneCodeByName($deliveryInformation['state']);
        }
        else
        {
            $deliveryState = $deliveryInformation['state'];
        }

        $billingInformation  = $order->billing;
        if($billingInformation['country_iso_2'] == 'US' || $billingInformation['country_iso_2'] == 'CA')
        {
            $billingState = $this->_getZoneCodeByName($billingInformation['state']);
        }
        else
        {
            $billingState = $billingInformation['state'];
        }

        $sql = 'SELECT customers_dob, customers_fax FROM ' . TABLE_CUSTOMERS .' WHERE customers_id="'.$consumerID.'" LIMIT 1;';
        $result = xtc_db_query($sql);
        $consumerInformation = mysql_fetch_assoc($result);
        if($consumerInformation['customers_dob'] != '0000-00-00 00:00:00')
        {
            $consumerBirthDateTimestamp = strtotime($consumerInformation['customers_dob']);
            $consumerBirthDate = date('Y-m-d', $consumerBirthDateTimestamp);
        }
        else
        {
            $consumerBirthDate = '';
        }
        $post_variables = array(
            'customerId'            => qpay_core::constant("MODULE_PAYMENT_{$c}_CUSTOMER_ID"),
            'order_id'              => $insert_id,
            'amount'                => round($total,       $xtPrice->get_decimal_places($_SESSION['currency'])),
            'currency'              => $_SESSION['currency'],
            'paymentType'           => $this->payment_type,
            'initPaymentType'		=> $this->payment_type,
            'language'              => $lang_code,
            'orderDescription'      => qpay_core::constant("MODULE_PAYMENT_{$c}_ORDER_DESCRIPTION").'-'.$_SESSION['cart']->cartID,
            'customerStatement'     => qpay_core::constant("MODULE_PAYMENT_{$c}_CUSTOMER_STATEMENT"),
            'displayText'           => qpay_core::constant("MODULE_PAYMENT_{$c}_DISPLAY_TEXT"),

            'successURL'            => xtc_href_link('callback/qenta/qpay_callback.php', '', 'SSL'),
            'cancelURL'             => xtc_href_link('callback/qenta/qpay_callback.php', 'cancel=1', 'SSL'),
            'failureURL'            => xtc_href_link('callback/qenta/qpay_callback.php', 'failure=1', 'SSL'),
            'serviceURL'            => qpay_core::constant("MODULE_PAYMENT_{$c}_SERVICE_URL"),
            'confirmURL'            => xtc_href_link('callback/qenta/qpay_confirm_callback.php', '', 'SSL', false),
            'windowName'			=> 'ShopWindow',
            'pluginVersion'			=> $pluginVersion,

            'consumerShippingFirstName'    => $deliveryInformation['firstname'],
            'consumerShippingLastName'	   => $deliveryInformation['lastname'],
            'consumerShippingAddress1'	   => $deliveryInformation['street_address'],
            'consumerShippingAddress2'	   => $deliveryInformation['suburb'],
            'consumerShippingCity'		   => $deliveryInformation['city'],
            'consumerShippingZipCode'	   => $deliveryInformation['postcode'],
            'consumerShippingState'		   => $deliveryState,
            'consumerShippingCountry'	   => $deliveryInformation['country_iso_2'],
            'consumerShippingPhone'		   => $order->customer['telephone'],
            'consumerBillingFirstName'     => $billingInformation['firstname'],
            'consumerBillingLastName'	   => $billingInformation['lastname'],
            'consumerBillingAddress1'	   => $billingInformation['street_address'],
            'consumerBillingAddress2'	   => $billingInformation['suburb'],
            'consumerBillingCity'		   => $billingInformation['city'],
            'consumerBillingZipCode'	   => $billingInformation['postcode'],
            'consumerBillingState'		   => $billingState,
            'consumerBillingCountry'	   => $billingInformation['country_iso_2'],
            'consumerBillingPhone'		   => $order->customer['telephone'],
        	'consumerEmail'    			   => $order->customer['email_address'],
            'duplicateRequestCheck'        => 'Yes',
        );
        if($consumerBirthDate != '')
        {
            $post_variables['consumerBirthDate'] = $consumerBirthDate;
        }
        if($consumerInformation['customers_fax'] != '' && $consumerInformation['customers_fax'] != null)
        {
            $post_variables['consumerShippingFax'] = $consumerInformation['customers_fax'];
            $post_variables['consumerBillingFax'] = $consumerInformation['customers_fax'];
        }

        // set shop id if isset
        if(constant("MODULE_PAYMENT_{$c}_SHOP_ID"))
            $post_variables['shopId'] = qpay_core::constant("MODULE_PAYMENT_{$c}_SHOP_ID");

        // set shop logo if desired
        if(constant("MODULE_PAYMENT_{$c}_STORE_LOGO_INCLUDE") == 'True') {
          $gm_logo = MainFactory::create_object('GMLogoManager', array("gm_logo_shop"));
          $post_variables['imageURL'] = $gm_logo->logo_path . $gm_logo->logo_file;
        }

        // create fingerprint
        $requestFingerprintOrder = 'secret,';
        $requestFingerprintSeed  = qpay_core::constant("MODULE_PAYMENT_{$c}_PRESHARED_KEY");
        foreach($post_variables as $key => $value) {
            $requestFingerprintOrder .= $key . ',';
            $requestFingerprintSeed  .= trim($value);
        }
        $requestFingerprintOrder .= 'requestFingerprintOrder';
        $requestFingerprintSeed .= $requestFingerprintOrder;
        $requestfingerprint = md5($requestFingerprintSeed);
        $post_variables['requestFingerprintOrder'] = $requestFingerprintOrder;
        $post_variables['requestFingerprint']      = $requestfingerprint;

        return $post_variables;
    }

    /// @brief nothing to do for update_status
    function update_status() {
        return true;
    }

    /// @brief decorate process button
    function process_button() {
    }

    /// @brief nothing to do for before_process
    function before_process() {
        return true;
    }

    /// @brief nothing to do for update_status
    function payment_action() {
        return true;
    }

    /// @brief finalize payment after order is created
    function after_process() {
        $c = strtoupper($this->code);
        $useIFrame = qpay_core::constant("MODULE_PAYMENT_{$c}_USE_IFRAME");
        $timeout = qpay_core::constant("MODULE_PAYMENT_{$c}_REDIRECT_TIMEOUT_SECOUNDS")*1000;
        // redirect
        $process_form = '<form name="qpay_process_form" method="POST" action="'.(FORM_URL).'" >';
        foreach($this->get_order_post_variables_array() as $key => $value)
          $process_form .= xtc_draw_hidden_field($key, $value);
        $process_js = '<script type="text/javascript">setTimeout("document.qpay_process_form.submit();",'.$timeout.');</script>';
        $translation_qpay = array(
            'title'   => qpay_core::constant("MODULE_PAYMENT_{$c}_CHECKOUT_TITLE"),
            'header'  => qpay_core::constant("MODULE_PAYMENT_{$c}_CHECKOUT_HEADER"),
            'content' => qpay_core::constant("MODULE_PAYMENT_{$c}_CHECKOUT_CONTENT")
          );
        $_SESSION['qpay']['useIFrame'] = $useIFrame;
        $_SESSION['qpay']['process_form'] = $process_form;
        $_SESSION['qpay']['process_js'] = $process_js;
        $_SESSION['qpay']['translation'] = $translation_qpay;
        include('checkout_qpay.php');
        // reset cart - no further action necessary
        $_SESSION['cart']->reset(true);
        die(session_close());
    }

    /// @brief set info for order-payment-module selection
    function selection() {
        return array ('id' => $this->code, 'module' => $this->title, 'description' => $this->info);
    }
    function javascript_validation() {
        return false;
    }
    function pre_confirmation_check() {
        return false;
    }
    function confirmation() {
        return false;
    }
    function get_error() {
        return false;
    }

    /// @brief check module status
    function check() {
        if (!isset ($this->_check)) {
            $c = strtoupper($this->code);
            $check_query = xtc_db_query("SELECT configuration_value FROM ".TABLE_CONFIGURATION." WHERE configuration_key='MODULE_PAYMENT_{$c}_STATUS'");
            $this->_check = xtc_db_num_rows($check_query);
        }
        return $this->_check;
    }

    /// @brief install module
    function install() {
        $cg_id = 6; // represents Modul Configuration by default
        $q = "INSERT INTO ".TABLE_CONFIGURATION."
                (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added)
              VALUES ";
        $s = 1; // represents sort-order at displayed configuration
        $selection = "'gm_cfg_select_option(array(\'True\', \'False\'), '";
        $c = strtoupper($this->code);
        $q .= "
            ('MODULE_PAYMENT_{$c}_STATUS',                  'True',       '$cg_id', '".$s++."', $selection, now()),
            ('MODULE_PAYMENT_{$c}_PRESHARED_KEY',           '',           '$cg_id', '".$s++."', '',         now()),
            ('MODULE_PAYMENT_{$c}_CUSTOMER_ID',             '',           '$cg_id', '".$s++."', '',         now()),
            ('MODULE_PAYMENT_{$c}_STORE_LOGO_INCLUDE',      'True',       '$cg_id', '".$s++."', $selection, now()),
            ('MODULE_PAYMENT_{$c}_SHOP_ID',                 '',           '$cg_id', '".$s++."', '',         now()),
            ('MODULE_PAYMENT_{$c}_SERVICE_URL',             '',           '$cg_id', '".$s++."', '',         now()),
            ('MODULE_PAYMENT_{$c}_CUSTOMER_STATEMENT',      '',           '$cg_id', '".$s++."', '',         now()),
            ('MODULE_PAYMENT_{$c}_ORDER_DESCRIPTION',       '',           '$cg_id', '".$s++."', '',         now()),
            ('MODULE_PAYMENT_{$c}_DISPLAY_TEXT',            '',           '$cg_id', '".$s++."', '',         now()),
            ('MODULE_PAYMENT_{$c}_SORT_ORDER',              '0',          '$cg_id', '".$s++."', '',         now()),
            ('MODULE_PAYMENT_{$c}_ALLOWED',                 '',           '$cg_id', '".$s++."', '',         now()),
            ('MODULE_PAYMENT_{$c}_USE_IFRAME',              'FALSE',      '$cg_id', '".$s++."', $selection, now()) ";
        xtc_db_query($q);

        /// @TODO use for logging
        // create table for saving transaction data and logging
        $q = "CREATE TABLE IF NOT EXISTS ".TABLE_PAYMENT_QPAY."
          (id INT(11) NOT NULL AUTO_INCREMENT,
           orders_id INT(11) NOT NULL,
           qpay_response TEXT NOT NULL,
           created_at TIMESTAMP NOT NULL DEFAULT now(),
           PRIMARY KEY (id))";
        xtc_db_query($q);
    }

    function remove() {
        xtc_db_query("DELETE FROM ".TABLE_CONFIGURATION." WHERE configuration_key IN ('".implode("', '", $this->keys())."')");
    }

    /**
      * @brief define module configuration keys
      * MODULE_PAYMENT_MODULENAME_STATUS ... activated true/false
      * MODULE_PAYMENT_MODULENAME_PRESHARED_KEY ... secret key
      * MODULE_PAYMENT_MODULENAME_CUSTOMER_ID ... qenta customer id
      * MODULE_PAYMENT_MODULENAME_STORE_LOGO_INCLUDE ... use shop logo
      * MODULE_PAYMENT_MODULENAME_SHOP_ID ... qenta shop id
      * MODULE_PAYMENT_MODULENAME_SERVICE_URL ... shop support-page url
      * MODULE_PAYMENT_MODULENAME_CUSTOMER_STATEMENT ... shop info statment
      * MODULE_PAYMENT_MODULENAME_ORDER_DESCRIPTION ... order description
      * MODULE_PAYMENT_MODULENAME_DISPLAY_TEXT ... shop info text
      *
      * following are Gambio-Defaults:
      * MODULE_PAYMENT_MODULENAME_SORT_ORDER ... sort order at payment types selection
      * MODULE_PAYMENT_MODULENAME_ALLOWED ... allowed for which zones
      **/
    function keys() {
        $c = strtoupper($this->code);
        return array("MODULE_PAYMENT_{$c}_STATUS", "MODULE_PAYMENT_{$c}_PRESHARED_KEY", "MODULE_PAYMENT_{$c}_CUSTOMER_ID",
                    "MODULE_PAYMENT_{$c}_STORE_LOGO_INCLUDE", "MODULE_PAYMENT_{$c}_SHOP_ID", "MODULE_PAYMENT_{$c}_SERVICE_URL",
                    "MODULE_PAYMENT_{$c}_CUSTOMER_STATEMENT", "MODULE_PAYMENT_{$c}_DISPLAY_TEXT",
                    "MODULE_PAYMENT_{$c}_ORDER_DESCRIPTION", "MODULE_PAYMENT_{$c}_SORT_ORDER", "MODULE_PAYMENT_{$c}_USE_IFRAME");
    }

    function _getZoneCodeByName($zoneName)
    {
        $sql = 'SELECT zone_code FROM ' . TABLE_ZONES . ' WHERE zone_name=\'' .$zoneName .'\' LIMIT 1;';
        $result = xtc_db_query($sql);
        $resultRow = mysql_fetch_row($result);
        return $resultRow[0];
    }
}


MainFactory::load_origin_class('qpay_core');
?>