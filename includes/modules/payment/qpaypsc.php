<?php

require_once(dirname(__FILE__).'/qpay.php');

class qpaypsc_ORIGIN extends qpay_core {
    var $payment_type = 'PSC';

    /// @brief initialize qpay module
    function qpaypsc_ORIGIN() {
        parent::init();
    }
}


MainFactory::load_origin_class('qpaypsc');
?>