<?php
/* --------------------------------------------------------------
   gm_pdf_order.php 2008-08-01 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

gm_pdf_order.php 18.01.2008 pt@gambio
	Gambio OHG
	http://www.gambio.de
	Copyright (c) 2007 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
	--------------------------------------------------------------
*/
?>
<?php

	define('PDF_HEADING_ARTICLE_NAME', 'Product');
	define('PDF_HEADING_MODEL', 'Product No.');
	define('PDF_HEADING_UNIT', 'Qty');
	define('PDF_HEADING_SINGLE_PRICE', 'Unit Price');
	define('PDF_HEADING_PRICE', 'Price');
	define('PDF_HEADING_EXCL', ' (excl.)');
	define('PDF_HEADING_INCL', ' (incl.)');

	define('PDF_TITLE_INVOICE_CODE', 'Invoice ID');
	define('PDF_TITLE_PACKING_CODE', 'Packing Slip ID');
	define('PDF_TITLE_CUSTOMER_CODE', 'Customer ID');
	define('PDF_TITLE_ORDER_CODE', 'Order ID');
	define('PDF_TITLE_ORDER_DATE', 'Order Date');
	define('PDF_TITLE_DATE', 'Date');
	define('PDF_HEADING_NETTO_PRICE', 'Tax');
	define('PDF_TITLE_CANCEL', 'Canceled on ');


	define('PDF_PAGE', 'Page');

	define('PDF_INFO_SHIPPING', 'Shipping Method');
	define('PDF_INFO_PAYMENT', 'Payment Method');
	define('PDF_INFO_CUSTOMER_COMMENTS', 'Comment');
	define('PDF_INFO_ADR_LABEL_SHIPPING', 'Shipping Address');
	define('PDF_INFO_ADR_LABEL_BILLING', 'Billing Address');
	
	/* MAIL */
	define('PDF_ATTACH_NAME', 'Invoice');
	define('PDF_SUBJECT', 'Your Invoice for Order No. ');
	define('PDF_SUBJECT_FROM', ' from ');
	define('PDF_MAIL_SUCCESS', ' Email sent successfully.');
	define('PDF_MAIL_CLOSE', 'Close');

	define('PDF_INVOICING_COMMENT_MAIL', 'E-Mail Invoice sent.');
	define('PDF_INVOICING_COMMENT', 'Invoice created.');

?>