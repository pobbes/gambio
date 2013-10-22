<?php
/**
 * @version SOFORT Gateway 5.2.0 - $Date: 2012-11-21 12:09:39 +0100 (Wed, 21 Nov 2012) $
 * @author SOFORT AG (integration@sofort.com)
 * @link http://www.sofort.com/
 *
 * Copyright (c) 2012 SOFORT AG
 * 
 * Released under the GNU General Public License (Version 2)
 * [http://www.gnu.org/licenses/gpl-2.0.html]
 *
 * $Id: sofort_sofortlastschrift.php 5725 2012-11-21 11:09:39Z rotsch $
 */

//include language-constants used in all Multipay Projects
require_once 'sofort_general.php';

define('MODULE_PAYMENT_SOFORT_SL_TEXT_DESCRIPTION_EXTRA', 
	MODULE_PAYMENT_SOFORT_MULTIPAY_JS_LIBS.'
	<div id="slExtraDesc">
		<div class="content" style="display:none;"></div>
	</div>
	<script type="text/javascript">
		slOverlay = new sofortOverlay(jQuery("#slExtraDesc"), "'.DIR_WS_CATALOG.'callback/sofort/ressources/scripts/getContent.php", "https://documents.sofort.com/sl/shopinfo/en");
	</script>
');

define('MODULE_PAYMENT_SOFORT_SOFORTLASTSCHRIFT_TEXT_TITLE', 'SOFORT Lastschrift <br /><img src="https://images.sofort.com/en/sl/logo_90x30.png" alt="logo SOFORT Lastschrift"/>');
define('MODULE_PAYMENT_SOFORT_SL_TEXT_TITLE', 'SOFORT Lastschrift (direct debit + online banking precheck)');
define('MODULE_PAYMENT_SOFORT_SL_LOGO_HTML', '<img src="https://images.sofort.com/en/sl/logo_90x30.png" alt="logo SOFORT Lastschrift"/>');
define('MODULE_PAYMENT_SOFORT_SL_TEXT_ERROR_MESSAGE', 'Payment is unfortunately not possible or has been cancelled by the customer. Please select another payment method.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_SL', 'Payment is unfortunately not possible or has been cancelled by the customer. Please select another payment method.');
define('MODULE_PAYMENT_SOFORT_SL_CHECKOUT_TEXT', '<ul><li>Payment system with TÜV-certified Privacy Policy</li><li>No registration required</li><li>Goods / services can be dispatched IMMEDIATELY</li><li>Please have your online banking PIN ready</li></ul>');
define('MODULE_PAYMENT_SOFORT_SL_SORT_ORDER_TITLE', 'sort sequence');
define('MODULE_PAYMENT_SOFORT_SL_SORT_ORDER_DESC', 'Order of display. Smallest number will show first.');
define('MODULE_PAYMENT_SOFORT_SL_STATUS_TITLE', 'Activate sofort.de module');
define('MODULE_PAYMENT_SOFORT_SL_STATUS_DESC', 'Activates/deactivates the complete module');
define('MODULE_PAYMENT_SOFORT_SL_TEXT_DESCRIPTION', 'SOFORT Lastschrift is an advanced payment system based on one of the most popular German payment methods, ELV.');
define('MODULE_PAYMENT_SOFORT_SL_TEXT_ERROR_HEADING', 'Error while processing the order.');

define('MODULE_PAYMENT_SOFORT_SL_TEXT_DESCRIPTION_CHECKOUT_PAYMENT_IMAGE', '<table border="0" cellspacing="0" cellpadding="0"><tr><td valign="bottom">
<a onclick="javascript:window.open(\'https://images.sofort.com/en/sl/landing.php\',\'customer information\',\'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1020, height=900\');" style="float:left; width:auto; cursor:pointer;">
{{image}}
</a></td><td rowspan="2" width="30px">&nbsp;</td><td rowspan="2">
</td>      </tr>      <tr> <td class="main">{{text}}</td>      </tr>      </table>');

define('MODULE_PAYMENT_SOFORT_SL_TEXT_DESCRIPTION_CHECKOUT_PAYMENT_IMAGEALT', 'SOFORT Lastschrift');

define('MODULE_PAYMENT_SOFORT_SOFORTLASTSCHRIFT_ALLOWED_TITLE', 'Allowed zones');
define('MODULE_PAYMENT_SOFORT_SOFORTLASTSCHRIFT_ALLOWED_DESC', 'Please enter <b>einzeln</b> the zones, which should be allowed for this module. (eg allow AT, DE (if empty, all zones))');
define('MODULE_PAYMENT_SOFORT_SL_ZONE_TITLE', MODULE_PAYMENT_SOFORT_MULTIPAY_ZONE_TITLE);
define('MODULE_PAYMENT_SOFORT_SL_ZONE_DESC', MODULE_PAYMENT_SOFORT_MULTIPAY_ZONE_DESC);

define('MODULE_PAYMENT_SOFORT_SL_PEN_NOT_CRE_YET_STATUS_ID_TITLE', 'Confirmed order status');
define('MODULE_PAYMENT_SOFORT_SL_PEN_NOT_CRE_YET_STATUS_ID_DESC', 'Confirmed order status<br />Order status after successfully completing a transaction.'); // (pending-not_credited_yet)

define('MODULE_PAYMENT_SOFORT_SL_LOS_REJ_STATUS_ID_TITLE', 'Chargeback');
define('MODULE_PAYMENT_SOFORT_SL_LOS_REJ_STATUS_ID_DESC', 'Status for orders when there is a charge back.'); // (loss-rejected)

define('MODULE_PAYMENT_SOFORT_SL_REC_CRE_STATUS_ID_TITLE', 'Receipt of money');
define('MODULE_PAYMENT_SOFORT_SL_REC_CRE_STATUS_ID_DESC', 'Status of orders when the money has been received on the account of SOFORT Bank.'); // (received-credited)

define('MODULE_PAYMENT_SOFORT_SL_REF_COM_STATUS_ID_TITLE', 'Partial refund');
define('MODULE_PAYMENT_SOFORT_SL_REF_COM_STATUS_ID_DESC', 'Status of orders where a partial amount was refunded to the buyer.');  // (refunded-compensation)

define('MODULE_PAYMENT_SOFORT_SL_REF_REF_STATUS_ID_TITLE', 'Full refund');
define('MODULE_PAYMENT_SOFORT_SL_REF_REF_STATUS_ID_DESC', 'Status of orders where the full amount was refunded to the buyer.'); // (refunded-refunded)

define('MODULE_PAYMENT_SOFORT_SL_TMP_COMMENT', 'Payment method SOFORT Lastschrift chosen. Transaction not finished.');
define('MODULE_PAYMENT_SOFORT_SL_TMP_COMMENT_SELLER', 'Redirection to SOFORT - payment has not yet occurred.');

define('MODULE_PAYMENT_SOFORT_SL_RECOMMENDED_PAYMENT_TITLE', 'recommend payment method');
define('MODULE_PAYMENT_SOFORT_SL_RECOMMENDED_PAYMENT_DESC', '"Mark this payment method as "recommended payment method". On the payment selection page a note will be displayed right behind the payment method."');
define('MODULE_PAYMENT_SOFORT_SL_RECOMMENDED_PAYMENT_TEXT', '(recommend payment method)');

define('MODULE_PAYMENT_SOFORT_SL_PEN_NOT_CRE_YET_SELLER', 'Order successfully completed - Direct debit is performed. Your transaction ID: {{tId}}');
define('MODULE_PAYMENT_SOFORT_SL_PEN_NOT_CRE_YET_BUYER', 'Order successfull.');
define('MODULE_PAYMENT_SOFORT_SL_REC_CRE_SELLER', 'Receipt of money on account');
define('MODULE_PAYMENT_SOFORT_SL_REC_CRE_BUYER', '');
define('MODULE_PAYMENT_SOFORT_SL_LOS_REJ_SELLER', '');
define('MODULE_PAYMENT_SOFORT_SL_LOS_REJ_BUYER', 'There is a chargeback linked to this transaction. {{time}}');
define('MODULE_PAYMENT_SOFORT_SL_REF_COM_SELLER', 'The invoice amount will be partially refunded. Total amount being refunded: {{refunded_amount}}. {{time}}');
define('MODULE_PAYMENT_SOFORT_SL_REF_COM_BUYER', 'A potion of the amount will be refunded.');
define('MODULE_PAYMENT_SOFORT_SL_REF_REF_SELLER', '');
define('MODULE_PAYMENT_SOFORT_SL_REF_REF_BUYER', 'Invoice amount will be refunded {{time}}');
?>