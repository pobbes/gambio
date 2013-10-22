<?php

/* -----------------------------------------------------------------------------------------
   $Id: skrill_cgb.php 38 2009-01-22 14:46:06Z mzanier $

   xt:Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2009 xt:Commerce GmbH

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

define('MODULE_PAYMENT_SKRILL_CGB_TEXT_TITLE', 'carte bleue');
$_var = 'carte bleue via Skrill';
if (_PAYMENT_SKRILL_EMAILID=='') {
	$_var.='<br /><br /><b><font color="red">Please setup skrill.com configuration first! (Configuration -> Interfaces -> Skrill.com)!</font></b>';
}
$_var .= '<br><br>Please use <a href="'.DIR_WS_ADMIN.'configuration.php?gID=32">Configuration -> Interfaces -> Skrill.com</a> for basic setup of Skrill payment modules.';
define('MODULE_PAYMENT_SKRILL_CGB_TEXT_DESCRIPTION', $_var);
define('MODULE_PAYMENT_SKRILL_CGB_NOCURRENCY_ERROR', 'There\'s no Skrill accepted currency installed!');
define('MODULE_PAYMENT_SKRILL_CGB_ERRORTEXT1', 'payment_error=');
define('MODULE_PAYMENT_SKRILL_CGB_TEXT_INFO','');
define('MODULE_PAYMENT_SKRILL_CGB_ERRORTEXT2', '&error=There was an error during your payment at Skrill!');
define('MODULE_PAYMENT_SKRILL_CGB_ORDER_TEXT', 'Date of the order: ');
define('MODULE_PAYMENT_SKRILL_CGB_TEXT_ERROR', 'Payment error!');
define('MODULE_PAYMENT_SKRILL_CGB_CONFIRMATION_TEXT', 'Thank you for your order!');
define('MODULE_PAYMENT_SKRILL_CGB_TRANSACTION_FAILED_TEXT', 'Your payment transaction at Skrill has failed. Please try again, or select an other payment option!');



define('MODULE_PAYMENT_SKRILL_CGB_STATUS_TITLE', 'Enable Skrill');
define('MODULE_PAYMENT_SKRILL_CGB_STATUS_DESC', 'Do you want to accept payments through Skrill?<br /><br /><img src="images/icon_arrow_right.gif"> <b><a href="http://www.xt-commerce.com/index.php?option=com_content&task=view&id=76&lang=en" target="_blank">Help / Explanation</a></b>');
define('MODULE_PAYMENT_SKRILL_CGB_SORT_ORDER_TITLE', 'Sort order of display.');
define('MODULE_PAYMENT_SKRILL_CGB_SORT_ORDER_DESC', 'Sort order of display. Lowest is displayed first.');
define('MODULE_PAYMENT_SKRILL_CGB_ZONE_TITLE', 'Payment Zone');
define('MODULE_PAYMENT_SKRILL_CGB_ZONE_DESC', 'If a zone is selected, only enable this payment method for that zone.');
define('MODULE_PAYMENT_SKRILL_CGB_ALLOWED_TITLE' , 'Allowed Zones');
define('MODULE_PAYMENT_SKRILL_CGB_ALLOWED_DESC' , 'Please enter the zones <b>separately</b> which should be allowed to use this modul (e. g. AT,DE (leave empty if you want to allow all zones))');
?>
