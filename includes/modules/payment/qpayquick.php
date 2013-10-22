<?php

require_once(dirname(__FILE__).'/qpay.php');

class qpayquick_ORIGIN extends qpay_core {
    var $payment_type = 'QUICK';

    /// @brief initialize qpay module
    function qpayquick_ORIGIN() {
        parent::init();
    }
}


MainFactory::load_origin_class('qpayquick');
?>