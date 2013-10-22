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
 * $Id: sofort_sofortvorkasse.php 5725 2012-11-21 11:09:39Z rotsch $
 */
//include language-constants used in all Multipay Projects
require_once 'sofort_general.php';

define('MODULE_PAYMENT_SOFORT_SV_CHECKOUT_CONDITIONS_WITH_LIGHTBOX', '<a href="https://documents.sofort.com/de/sv/privacy_de" target="_blank">I have read the Privacy Policy.</a>');
define('MODULE_PAYMENT_SOFORT_SV_CHECKOUT_CONDITIONS', '
	<script type="text/javascript">
		function showSvConditions() {
			svOverlay = new sofortOverlay(jQuery(".svOverlay"), "callback/sofort/ressources/scripts/getContent.php", "https://documents.sofort.com/de/sv/privacy_de");
			svOverlay.trigger();
		}
	</script>
	<noscript>
		<a href="https://documents.sofort.com/de/sv/privacy_de" target="_blank">I have read the Privacy Policy.</a>
	</noscript>
	<!-- comSeo-Ajax-Checkout-Bugfix: show also div, when buyer doesnt use JS -->
	<div>
		<a id="svNotice" href="javascript:void(0)" onclick="showSvConditions()">I have read the Privacy Policy.</a>
	</div>
	<div style="display:none; z-index: 1001;filter: alpha(opacity=92);filter: progid :DXImageTransform.Microsoft.Alpha(opacity=92);-moz-opacity: .92;-khtml-opacity: 0.92;opacity: 0.92;background-color: black;position: fixed;top: 0px;left: 0px;width: 100%;height: 100%;text-align: center;vertical-align: middle;" class="svOverlay">
		<div class="loader" style="z-index: 1002;position: relative;background-color: #fff;border: 5px solid #C0C0C0;top: 40px;overflow: scroll;padding: 4px;border-radius: 7px;-moz-border-radius: 7px;-webkit-border-radius: 7px;margin: auto;width: 620px;height: 400px;overflow: scroll; overflow-x: hidden;">
			<div class="closeButton" style="position: fixed; top: 54px; background: url(callback/sofort/ressources/images/close.png) right top no-repeat;cursor:pointer;height: 30px;width: 30px;"></div>
			<div class="content"></div>
		</div>
	</div>
');

define('MODULE_PAYMENT_SOFORT_SV_TEXT_DESCRIPTION_EXTRA', 
	MODULE_PAYMENT_SOFORT_MULTIPAY_JS_LIBS.'
	<div id="svExtraDesc">
		<div class="content" style="display:none;"></div>
	</div>
	<script type="text/javascript">
		svOverlay = new sofortOverlay(jQuery("#svExtraDesc"), "'.DIR_WS_CATALOG.'callback/sofort/ressources/scripts/getContent.php", "https://documents.sofort.com/vbs/shopinfo/en");
	</script>
');

define('MODULE_PAYMENT_SOFORT_SOFORTVORKASSE_TEXT_TITLE', 'Vorkasse by SOFORT <br /> <img src="https://images.sofort.com/en/sv/logo_90x30.png" alt="Logo Vorkasse by SOFORT"/>');
define('MODULE_PAYMENT_SOFORT_SV_TEXT_TITLE', 'Vorkasse (pay in advance)');
define('MODULE_PAYMENT_SOFORT_SV_KS_TEXT_TITLE', 'Payment in advance with consumer protection');
define('MODULE_PAYMENT_SOFORT_SV_LOGO_HTML', '<img src="https://images.sofort.com/en/sv/logo_90x30.png" alt="Logo Vorkasse by SOFORT"/>');
define('MODULE_PAYMENT_SOFORT_SV_TEXT_ERROR_MESSAGE', 'Payment is unfortunately not possible or has been cancelled by the customer. Please select another payment method.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_SV', 'Payment is unfortunately not possible or has been cancelled by the customer. Please select another payment method.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_SV_CHECKOUT_TEXT', '');
define('MODULE_PAYMENT_SOFORT_SV_TEXT_DESCRIPTION', 'Payment in advance with automatic reconcilement.');
define('MODULE_PAYMENT_SOFORT_SOFORTVORKASSE_ALLOWED_TITLE', 'Allowed zones');
define('MODULE_PAYMENT_SOFORT_SOFORTVORKASSE_ALLOWED_DESC', 'Please enter <b>einzeln</b> the zones, which should be allowed for this module. (eg allow AT, DE (if empty, all zones))');
define('MODULE_PAYMENT_SOFORT_SV_ZONE_TITLE', MODULE_PAYMENT_SOFORT_MULTIPAY_ZONE_TITLE);
define('MODULE_PAYMENT_SOFORT_SV_ZONE_DESC', MODULE_PAYMENT_SOFORT_MULTIPAY_ZONE_DESC);
define('MODULE_PAYMENT_SOFORT_SV_SORT_ORDER_TITLE', 'sort sequence');
define('MODULE_PAYMENT_SOFORT_SV_SORT_ORDER_DESC', 'Order of display. Smallest number will show first.');
define('MODULE_PAYMENT_SOFORT_SV_STATUS_TITLE', 'Activate sofort.de module');
define('MODULE_PAYMENT_SOFORT_SV_STATUS_DESC', 'Activates/deactivates the complete module');
define('MODULE_PAYMENT_SOFORT_SV_TMP_COMMENT', 'Payment method Vorkasse by SOFORT chosen. Transaction not finished yet.');
define('MODULE_PAYMENT_SOFORT_SV_TMP_COMMENT_SELLER', 'Redirection to SOFORT - payment has not yet occurred.');
define('MODULE_PAYMENT_SOFORT_SV_REASON_2_TITLE','Reason 2');
define('MODULE_PAYMENT_SOFORT_SV_REASON_2_DESC','Following placeholders will be replaced inside the reason (max 27 characters):<br />{{transaction_id}}<br />{{order_date}}<br />{{customer_id}}<br />{{customer_name}}<br />{{customer_company}}<br />{{customer_email}}');

define('MODULE_PAYMENT_SOFORT_SV_PEN_WAI_FOR_MON_STATUS_ID_TITLE', 'No payment received so far');
define('MODULE_PAYMENT_SOFORT_SV_PEN_WAI_FOR_MON_STATUS_ID_DESC', 'Order status for completed orders with Vorkasse by SOFORT. The payment has not been received so far.');  // (pending-wait_for_money)

define('MODULE_PAYMENT_SOFORT_SV_REC_CRE_STATUS_ID_TITLE', 'Confirmed order status');
define('MODULE_PAYMENT_SOFORT_SV_REC_CRE_STATUS_ID_DESC', 'Confirmed Order <br /> Order after payment.'); // (received-credited)

define('MODULE_PAYMENT_SOFORT_SV_LOS_NOT_CRE_STATUS_ID_TITLE', 'No payment received');
define('MODULE_PAYMENT_SOFORT_SV_LOS_NOT_CRE_STATUS_ID_DESC', 'Status of orders where the payment could not be confirmed. This period can be set in the project SOFORT.'); // (loss-not_credited)

define('MODULE_PAYMENT_SOFORT_SV_WRONG_AMOUNT_STATUS_ID_TITLE', 'Incorrect payment amount');
define('MODULE_PAYMENT_SOFORT_SV_WRONG_AMOUNT_STATUS_ID_DESC', 'Status for orders in which the amount received differs from the required amount.'); // (received-overpayment, received-partially_credited)

define('MODULE_PAYMENT_SOFORT_SV_REF_COM_STATUS_ID_TITLE', 'Partial refund');
define('MODULE_PAYMENT_SOFORT_SV_REF_COM_STATUS_ID_DESC', 'Status of orders where a partial amount was refunded to the buyer.'); // (refunded-compensation)

define('MODULE_PAYMENT_SOFORT_SV_REF_REF_STATUS_ID_TITLE', 'Full refund');
define('MODULE_PAYMENT_SOFORT_SV_REF_REF_STATUS_ID_DESC', 'Status of orders where the full amount was refunded to the buyer.');  // (refunded-refunded)

define('MODULE_PAYMENT_SOFORT_SV_RECOMMENDED_PAYMENT_TITLE', 'recommend payment method');
define('MODULE_PAYMENT_SOFORT_SV_RECOMMENDED_PAYMENT_DESC', '"Mark this payment method as "recommended payment method". On the payment selection page a note will be displayed right behind the payment method."');
define('MODULE_PAYMENT_SOFORT_SV_RECOMMENDED_PAYMENT_TEXT', '(recommend payment method)');

define('MODULE_PAYMENT_SOFORT_SV_KS_STATUS_TITLE', 'Customer protection activated');
define('MODULE_PAYMENT_SOFORT_SV_KS_STATUS_DESC', 'Activate customer protection for  Vorkasse by SOFORT');
define('MODULE_PAYMENT_SOFORT_SV_KS_STATUS_TEXT', 'Customer protection activated');

define('MODULE_PAYMENT_SOFORT_SV_CHECKOUT_HEADING_TEXT', 'bank account');
define('MODULE_PAYMENT_SOFORT_SV_CHECKOUT_TEXT', 'Please use the following account data.:');
define('MODULE_PAYMENT_SOFORT_SV_CHECKOUT_HOLDER_TEXT', 'account holder:');
define('MODULE_PAYMENT_SOFORT_SV_CHECKOUT_ACCOUNT_NUMBER_TEXT', 'account number:');
define('MODULE_PAYMENT_SOFORT_SV_CHECKOUT_BANK_CODE_TEXT', 'Bank code number:');
define('MODULE_PAYMENT_SOFORT_SV_CHECKOUT_IBAN_TEXT', 'IBAN:');
define('MODULE_PAYMENT_SOFORT_SV_CHECKOUT_BIC_TEXT', 'BIC:');
define('MODULE_PAYMENT_SOFORT_SV_CHECKOUT_AMOUNT_TEXT', 'Amount:');
define('MODULE_PAYMENT_SOFORT_SV_CHECKOUT_REASON_1_TEXT', 'reason:');
define('MODULE_PAYMENT_SOFORT_SV_CHECKOUT_REASON_2_TEXT', '');
define('MODULE_PAYMENT_SOFORT_SV_CHECKOUT_REASON_HINT','Please be sure to use the stated purpose when transfering the money, so that we can match your payment properly.');

define('MODULE_PAYMENT_SOFORT_SV_PEN_WAI_FOR_MON_SELLER', 'Waiting for payment. Transaction ID: {{tId}} {{time}}');
define('MODULE_PAYMENT_SOFORT_SV_PEN_WAI_FOR_MON_BUYER', 'Order successfull. Wait for receipt of money');
define('MODULE_PAYMENT_SOFORT_SV_REC_CRE_SELLER', 'Receipt of money on account');
define('MODULE_PAYMENT_SOFORT_SV_REC_CRE_BUYER', 'Receipt of money');
define('MODULE_PAYMENT_SOFORT_SV_REC_CON_PRO_SELLER', 'Receipt of money on account');
define('MODULE_PAYMENT_SOFORT_SV_REC_CON_PRO_BUYER', '');
define('MODULE_PAYMENT_SOFORT_SV_REC_OVE_SELLER', '');
define('MODULE_PAYMENT_SOFORT_SV_REC_OVE_BUYER', 'The amount received differs from the requested amount.');
define('MODULE_PAYMENT_SOFORT_SV_REC_PAR_CRE_SELLER', '');
define('MODULE_PAYMENT_SOFORT_SV_REC_PAR_CRE_BUYER', 'The amount received differs from the requested amount.');
define('MODULE_PAYMENT_SOFORT_SV_REF_COM_SELLER', 'The invoice amount will be partially refunded. Total amount being refunded: {{refunded_amount}}. {{time}}');
define('MODULE_PAYMENT_SOFORT_SV_REF_COM_BUYER', 'A potion of the amount will be refunded.');
define('MODULE_PAYMENT_SOFORT_SV_REF_REF_SELLER', '');
define('MODULE_PAYMENT_SOFORT_SV_REF_REF_BUYER', 'Invoice amount will be refunded {{time}}');
define('MODULE_PAYMENT_SOFORT_SV_LOS_NOT_CRE_SELLER', '');
define('MODULE_PAYMENT_SOFORT_SV_LOS_NOT_CRE_BUYER', 'Up till now the payment could not be confirmed. {{time}}');
?>