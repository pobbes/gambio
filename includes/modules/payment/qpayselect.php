<?php

require_once(dirname(__FILE__).'/qpay.php');

class qpayselect_ORIGIN extends qpay_core {
    var $payment_type = 'SELECT';

    /// @brief initialize qpay module
    function qpayselect_ORIGIN() {
        parent::init();
    }
}


MainFactory::load_origin_class('qpayselect');
?>