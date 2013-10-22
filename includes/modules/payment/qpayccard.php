<?php

require_once(dirname(__FILE__).'/qpay.php');

class qpayccard_ORIGIN extends qpay_core {
    var $payment_type = 'CCARD';

    /// @brief initialize qpay module
    function qpayccard_ORIGIN() {
        parent::init();
    }
}


MainFactory::load_origin_class('qpayccard');
?>