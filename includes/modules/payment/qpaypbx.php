<?php

require_once(dirname(__FILE__).'/qpay.php');

class qpaypbx_ORIGIN extends qpay_core {
    var $payment_type = 'PBX';

    /// @brief initialize qpay module
    function qpaypbx_ORIGIN() {
        parent::init();
    }
}


MainFactory::load_origin_class('qpaypbx');
?>