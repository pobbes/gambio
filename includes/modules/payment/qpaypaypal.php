<?php

require_once(dirname(__FILE__).'/qpay.php');

class qpaypaypal_ORIGIN extends qpay_core {
    var $payment_type = 'PAYPAL';

    /// @brief initialize qpay module
    function qpaypaypal_ORIGIN() {
        parent::init();
    }
}


MainFactory::load_origin_class('qpaypaypal');
?>