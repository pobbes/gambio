<?php

require_once(dirname(__FILE__).'/qpay.php');

class qpaymaestro_ORIGIN extends qpay_core {
    var $payment_type = 'MAESTRO';

    /// @brief initialize qpay module
    function qpaymaestro_ORIGIN() {
        parent::init();
    }
}


MainFactory::load_origin_class('qpaymaestro');
?>