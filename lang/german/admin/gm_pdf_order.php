<?php
/* --------------------------------------------------------------
   gm_pdf_order.php 2008-08-07 gambio
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

	define('PDF_HEADING_ARTICLE_NAME', 'Artikel');
	define('PDF_HEADING_MODEL', 'Artikel Nr');
	define('PDF_HEADING_UNIT', 'Menge');
	define('PDF_HEADING_SINGLE_PRICE', 'Einzelpreis');
	define('PDF_HEADING_PRICE', 'Preis');
	define('PDF_HEADING_NETTO_PRICE', 'MwSt.');
	define('PDF_HEADING_EXCL', ' (exkl. MwSt.)');
	define('PDF_HEADING_INCL', ' (inkl. MwSt.)');


	define('PDF_TITLE_INVOICE_CODE', 'Rechnungsnummer');
	define('PDF_TITLE_PACKING_CODE', 'Lieferscheinnummer');
	define('PDF_TITLE_CUSTOMER_CODE', 'Kundennummer');
	define('PDF_TITLE_ORDER_CODE', 'Bestellnummer');
	define('PDF_TITLE_ORDER_DATE', 'Bestelldatum');
	define('PDF_TITLE_DATE', 'Datum');
	define('PDF_TITLE_CANCEL', 'Storniert am ');


	define('PDF_PAGE', 'Seite');

	define('PDF_INFO_SHIPPING', 'Versandart');
	define('PDF_INFO_PAYMENT', 'Zahlmethode');
	define('PDF_INFO_CUSTOMER_COMMENTS', 'Kommentar');
	define('PDF_INFO_ADR_LABEL_SHIPPING', 'Versandadresse');
	define('PDF_INFO_ADR_LABEL_BILLING', 'Rechnungsadresse');
	
	/* MAIL */
	define('PDF_ATTACH_NAME', 'rechnung');
	define('PDF_SUBJECT', 'Ihre Rechnung der Bestellung Nr. ');
	define('PDF_SUBJECT_FROM', ' vom ');
	define('PDF_MAIL_SUCCESS', ' Die E-Mail wurde erfolgreich verschickt.');
	define('PDF_MAIL_CLOSE', 'Schliessen');

	define('PDF_INVOICING_COMMENT_MAIL', 'E-Mail Rechnung verschickt.');
	define('PDF_INVOICING_COMMENT', 'Rechnung erstellt.');
	 
?>