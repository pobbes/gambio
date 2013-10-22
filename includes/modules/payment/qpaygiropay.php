<?php

require_once(dirname(__FILE__).'/qpay.php');

class qpaygiropay_ORIGIN extends qpay_core {
    var $payment_type = 'GIROPAY';

    /// @brief initialize qpay module
    function qpaygiropay_ORIGIN() {
        parent::init();
    }
}


MainFactory::load_origin_class('qpaygiropay');
?>