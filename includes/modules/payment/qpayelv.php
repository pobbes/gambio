<?php

require_once(dirname(__FILE__).'/qpay.php');

class qpayelv_ORIGIN extends qpay_core {
    var $payment_type = 'ELV';

    /// @brief initialize qpay module
    function qpayelv_ORIGIN() {
        parent::init();
    }
}


MainFactory::load_origin_class('qpayelv');
?>