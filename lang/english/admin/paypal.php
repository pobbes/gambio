<?php
/* --------------------------------------------------------------
   paypal.php 2011-07-20 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

$Id

   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com 
   --------------------------------------------------------------
   Released under the GNU General Public License
   --------------------------------------------------------------*/


   define('HEADING_TITLE','PayPal transactions');
   define('TABLE_HEADING_PAYPAL_ID','transaction ID');
   define('TABLE_HEADING_NAME','name');
   define('TABLE_HEADING_TXN_TYPE','transaction type');
   define('TABLE_HEADING_PAYMENT_TYPE','payment method');
   define('TABLE_HEADING_PAYMENT_STATUS','payment status');
   define('TABLE_HEADING_PAYMENT_AMOUNT','sum');
   define('TABLE_HEADING_ORDERS_ID','order ID');
   define('TABLE_HEADING_ORDERS_STATUS','order status');
   define('TABLE_HEADING_ACTION','action');
   define('TEXT_PAYPAL_TRANSACTION_HISTORY','transaction history');
   define('TEXT_PAYPAL_PENDING_REASON','reason');
   define('TEXT_PAYPAL_CAPTURE_TRANSACTION','Capture amount');
   define('TEXT_PAYPAL_VOID_AUTHORIZATION','Void Authorization');
   define('TEXT_PAYPAL_BUTTON_VOID_AUTHORIZATION','Void');
   define('TEXT_PAYPAL_BUTTON_CAPTURE','Capture');
   define('TEXT_PAYPAL_CAPTURE_TRANSACTION','make capture');
   define('TEXT_PAYPAL_TRANSACTION_DETAIL','transaction details');
   define('TEXT_PAYPAL_TXN_ID','payment method/code:');
   define('TEXT_PAYPAL_COMPANY','company');
   define('TEXT_PAYPAL_PAYER_EMAIL','email:');
   define('TEXT_PAYPAL_RECEIVER_EMAIL','payment receiver');
   define('TEXT_PAYPAL_TOTAL','total');
   define('TEXT_PAYPAL_FEE','fee');
   define('TEXT_PAYPAL_ORDER_ID','order ID');
   define('TEXT_PAYPAL_PAYMENT_STATUS','status');
   define('TEXT_PAYPAL_PAYMENT_DATE','date');
   define('TEXT_PAYPAL_PAYMENT_TIME','time');
   define('TEXT_PAYPAL_ADRESS','address:');
   define('TEXT_PAYPAL_PAYMENT_TYPE','payment method');
   define('TEXT_PAYPAL_ADRESS_STATUS','address status');
   define('TEXT_PAYPAL_PAYER_EMAIL_STATUS','payer status');
   define('TEXT_PAYPAL_NETTO','net');
   define('TEXT_PAYPAL_DETAIL','details');
   define('TEXT_PAYPAL_TYPE','type');
   define('TEXT_PAYPAL_PAYMENT_REASON','reason');
   define('TEXT_PAYPAL_TRANSACTION_TOTAL','original payment:');
   define('TEXT_PAYPAL_TRANSACTION_LEFT','remaining amount:');
   define('TEXT_PAYPAL_AMOUNT','amount repayable:');
   define('TEXT_PAYPAL_REFUND_TRANSACTION','refund transaction');
   define('TEXT_PAYPAL_REFUND_NOTE','note to the customer <br />(optional):');
   define('TEXT_PAYPAL_OPTIONS','payment options');
   define('TEXT_PAYPAL_TRANSACTION_AUTH_TOTAL','reserved sum:');
   define('TEXT_PAYPAL_TRANSACTION_AMOUNT','capture amount:');
   define('TEXT_PAYPAL_TRANSACTION_AUTH_CAPTURED','total capture:');
   define('TEXT_PAYPAL_TRANSACTION_AUTH_OPEN','open capture:');

   define('TEXT_PAYPAL_ACTION_REFUND','refund payment (up to 60 days after transaction)');
   define('TEXT_PAYPAL_ACTION_CAPTURE','capture amount');
   define('TEXT_PAYPAL_ACTION_AUTHORIZATION','Void authorization');
//   define('TEXT_PAYPAL_ACTION_REFUND','refund payment (up to 60 days after transaction)');
	define('REFUND','refund');

   define('TEXT_PAYPAL_PAYMENT','PayPal payment status');

   define('TEXT_PAYPAL_TRANSACTION_CONNECTED','associated transactions');
   define('TEXT_PAYPAL_TRANSACTION_ORIGINAL','original transaction');
   define('TEXT_PAYPAL_SEARCH_TRANSACTION','search for transactions');
   define('TEXT_PAYPAL_FOUND_TRANSACTION','transactions found');

   define('STATUS_COMPLETED','completed');
   define('STATUS_VERIFIED','verified');
   define('STATUS_UNVERIFIED','not verified');
   define('STATUS_PENDING','pending');
   define('STATUS_REFUNDED','refunded');
   define('STATUS_PARTIALLYREFUNDED','partially refunded');
   define('STATUS_REVERSED','reversed');
   define('STATUS_DENIED','canceled');
   define('STATUS_CASE','customer conflict');
   define('STATUS_CANCELED_REVERSAL','return debit note');
   define('STATUS_OPENCAPTURE','reserved');
   define('STATUS_VOIDED', 'Void authorized');
   define('STATUS_NONE', 'none');
   define('STATUS_', 'status unknown');

   define('TYPE_INSTANT','immediately');
   define('TYPE_ECHECK','transfer');
   define('REASON_NOT_AS_DESCRIBE','product not as described');
   define('REASON_NON_RECEIPT','product not received');

   define('TYPE_REFUNDED','Refund');
   define('TYPE_REVERSED','-Payment sent');

   define('TEXT_DISPLAY_NUMBER_OF_PAYPAL_TRANSACTIONS','displayed <b>%d</b> to <b>%d</b> (of <b>%d</b> transactions)');

   // define NOTES
   define('TEXT_PAYPAL_NOTE_REFUND_INFO','You can request a complete or partial refund up to 60 days after sending your original payment. If you request a refund, you will receive a reimbursement of charges from PayPal, including partial fees for partial refunds. <br /><br />To arrange a refund, please enter the amount in the refund amount field and click "Next". ');

   define('TEXT_PAYPAL_NOTE_CAPTURE_INFO','');

   // errors
   define('REFUND_SUCCESS','Refund successful');
   define('CAPTURE_SUCCESS','Capture successful');
   define('VOID_SUCCESS','Authorization is voided');

   define('ERROR_10009','The partial refund amount must be less than or equal to the remaining amount');

   // capture
   define('ERROR_10610','Amount specified exceeds allowable limit');
   define('ERROR_10602','Authorization has already been completed');
   define('ERROR_81251','Internal service error');


	// bof gm
	define('TEXT_PAYPAL_SEARCH_FOR',				'search for:');
	define('TEXT_PAYPAL_SEARCH_IN',					'search in:');
	define('TEXT_PAYPAL_SEARCH_TIME',				'period:');
	define('TEXT_PAYPAL_SEARCH_TIME_FROM',			'from:');
	define('TEXT_PAYPAL_SEARCH_TIME_TO',			'to:');

	define('TEXT_PAYPAL_SEARCH_SELECT_MAIL',		'email');
	define('TEXT_PAYPAL_SEARCH_SELECT_ID',			'transaction ID');
	define('TEXT_PAYPAL_SEARCH_SELECT_NAME',		'last name');
	define('TEXT_PAYPAL_SEARCH_SELECT_FULLNAME',	'last name, first name');
	define('TEXT_PAYPAL_SEARCH_SELECT_INVOICE_NO',	'invoice number');

	define('TEXT_PAYPAL_SEARCH_SELECT_LASTDAY',		'last day');
	define('TEXT_PAYPAL_SEARCH_SELECT_LASTWEEK',	'last week');
	define('TEXT_PAYPAL_SEARCH_SELECT_LASTMONTH',	'last month');
	define('TEXT_PAYPAL_SEARCH_SELECT_LASTYEAR',	'last year');

	define('TEXT_PAYPAL_SEARCH_FORMAT_DAY',			'dd');
	define('TEXT_PAYPAL_SEARCH_FORMAT_MONTH',		'mm');
	define('TEXT_PAYPAL_SEARCH_FORMAT_YEAR',		'yyyy');

	define('TEXT_PAYPAL_SEARCH_EMPTY_RESULT',		'- no transactions found -');
	define('TYPE_NONE',								'- none -');

	// eof gm

	// NEW
	define('STATUS_CREATED', 'Created');

?>