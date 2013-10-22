<?php

require_once(dirname(__FILE__).'/qpay.php');

class qpayidl_ORIGIN extends qpay_core {
    var $payment_type = 'IDL';

    /// @brief initialize qpay module
    function qpayidl_ORIGIN() {
        parent::init();
    }
}


MainFactory::load_origin_class('qpayidl');
?>