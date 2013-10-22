<?php

require_once(dirname(__FILE__).'/qpay.php');

class qpayeps_ORIGIN extends qpay_core {
    var $payment_type = 'EPS';

    /// @brief initialize qpay module
    function qpayeps_ORIGIN() {
        parent::init();
    }
}


MainFactory::load_origin_class('qpayeps');
?>