<?php

require_once(dirname(__FILE__).'/qpay.php');

class qpayccardmoto_ORIGIN extends qpay_core {
    var $payment_type = 'CCARD-MOTO';

    /// @brief initialize qpay module
    function qpayccardmoto_ORIGIN() {
        parent::init();
    }
}


MainFactory::load_origin_class('qpayccardmoto');
?>