<?php
/* --------------------------------------------------------------
   paypal.php 2010-08-18 gm
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
   
   
   define('HEADING_TITLE','PayPal Transaktionen');
   
   define('TABLE_HEADING_PAYPAL_ID','Transaktions-<br />Id');
   define('TABLE_HEADING_NAME','Name');
   define('TABLE_HEADING_TXN_TYPE','Transaktion-<br />Typ');
   define('TABLE_HEADING_PAYMENT_TYPE','Zahlungs-<br />weise');
   define('TABLE_HEADING_PAYMENT_STATUS','Zahlungs-<br />status');
   define('TABLE_HEADING_PAYMENT_AMOUNT','Summe');

   define('TABLE_HEADING_ORDERS_ID','Bestell-<br />nummer');
   define('TABLE_HEADING_ORDERS_STATUS','Bestell-<br />status');
   define('TABLE_HEADING_ACTION','Aktion');
   
   
   define('TEXT_PAYPAL_TRANSACTION_HISTORY','Transaktionsverlauf');
   define('TEXT_PAYPAL_PENDING_REASON','Grund');
   define('TEXT_PAYPAL_CAPTURE_TRANSACTION','Betrag anfordern');
   define('TEXT_PAYPAL_VOID_AUTHORIZATION','Anforderung ablehnen');
   define('TEXT_PAYPAL_BUTTON_VOID_AUTHORIZATION','Ablehnen');
   define('TEXT_PAYPAL_BUTTON_CAPTURE','Anfordern');
   
   
   
   define('TEXT_PAYPAL_TRANSACTION_DETAIL','Transaktionsdetails');
   define('TEXT_PAYPAL_TXN_ID','Zahlungsart/Code:');
   define('TEXT_PAYPAL_COMPANY','Firma');
   define('TEXT_PAYPAL_PAYER_EMAIL','E-Mail:');
   define('TEXT_PAYPAL_RECEIVER_EMAIL','Zahlungsempf&auml;nger');
   define('TEXT_PAYPAL_TOTAL','Brutto');
   define('TEXT_PAYPAL_FEE','Geb&uuml;hr');
   define('TEXT_PAYPAL_ORDER_ID','Bestellnummer');
   define('TEXT_PAYPAL_PAYMENT_STATUS','Status');
   define('TEXT_PAYPAL_PAYMENT_DATE','Datum');
   define('TEXT_PAYPAL_PAYMENT_TIME','Uhrzeit');
   define('TEXT_PAYPAL_ADRESS','Adresse:');
   define('TEXT_PAYPAL_PAYMENT_TYPE','Zahlungsweise');
   define('TEXT_PAYPAL_ADRESS_STATUS','Status der Adresse');
   define('TEXT_PAYPAL_PAYER_EMAIL_STATUS','Status des Absenders');
   define('TEXT_PAYPAL_NETTO','Netto');
   define('TEXT_PAYPAL_DETAIL','Details');
   define('TEXT_PAYPAL_TYPE','Art');
   define('TEXT_PAYPAL_PAYMENT_REASON','Grund');
   define('TEXT_PAYPAL_TRANSACTION_TOTAL','Urspr&uuml;ngliche Zahlung:');
   define('TEXT_PAYPAL_TRANSACTION_LEFT','Restbetrag:');
   define('TEXT_PAYPAL_AMOUNT','R&uuml;ckzahlungsbetrag:');
   define('TEXT_PAYPAL_REFUND_TRANSACTION','R&uuml;ckzahlung veranlassen');
   define('TEXT_PAYPAL_REFUND_NOTE','Hinweis f&uuml;r den K&auml;ufer:<br />(optional)');
   define('TEXT_PAYPAL_OPTIONS','Zahlungsoptionen');
   define('TEXT_PAYPAL_TRANSACTION_AUTH_TOTAL','Reservierte Summe:');
   define('TEXT_PAYPAL_TRANSACTION_AMOUNT','Betrag anfordern:');
   define('TEXT_PAYPAL_TRANSACTION_AUTH_CAPTURED','Bereits angefordert:');
   define('TEXT_PAYPAL_TRANSACTION_AUTH_OPEN','Offener Betrag:');
   
   define('TEXT_PAYPAL_ACTION_REFUND','Zahlung erstatten (bis 60 Tage nach Transaktion)');
   define('TEXT_PAYPAL_ACTION_CAPTURE','Betrag abbuchen');
   define('TEXT_PAYPAL_ACTION_AUTHORIZATION','Anforderung ablehnen');

   define('REFUND','Erstatten');
   
   define('TEXT_PAYPAL_PAYMENT','PayPal-Zahlungsstatus');
   
   define('TEXT_PAYPAL_TRANSACTION_CONNECTED','Dazugeh&ouml;rige Transaktionen');
   define('TEXT_PAYPAL_TRANSACTION_ORIGINAL','Urspr&uuml;ngliche Transaktion');
   define('TEXT_PAYPAL_SEARCH_TRANSACTION','Suche nach Transaktionen');
   define('TEXT_PAYPAL_FOUND_TRANSACTION','Gefundene Transaktionen');
   
   define('STATUS_COMPLETED','Abgeschlossen');
   define('STATUS_VERIFIED','verifiziert');
   define('STATUS_UNVERIFIED','Nicht Verifiziert');
   define('STATUS_PENDING','Unerledigt');
   define('STATUS_REFUNDED','Zur&uuml;ckgezahlt');
   define('STATUS_PARTIALLYREFUNDED','Teilweise zur&uuml;ckgezahlt');
   define('STATUS_REVERSED','Reversed');
   define('STATUS_DENIED','Storniert');
   define('STATUS_CASE','K&auml;uferkonflikt');
   define('STATUS_CANCELED_REVERSAL','R&uuml;cklastschrift');
   define('STATUS_OPENCAPTURE','Reserviert');
   define('STATUS_CREATED', 'Erstellt');
   define('STATUS_VOIDED', 'Anforderung abgelehnt');
   define('STATUS_NONE', 'ohne');
   define('STATUS_', 'Status unbekannt');
   
   define('TYPE_INSTANT','Sofort');
   define('TYPE_ECHECK','&Uuml;berweisung');
   define('REASON_NOT_AS_DESCRIBE','Produkt nicht wie beschrieben!');
   define('REASON_NON_RECEIPT','Produkt nicht erhalten!');
   
   define('TYPE_REFUNDED','R&uuml;ckzahlung');
   define('TYPE_REVERSED','-Zahlung gesendet');
   
   define('TEXT_DISPLAY_NUMBER_OF_PAYPAL_TRANSACTIONS','Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> Transaktionen)');
   
   // define NOTES
   define('TEXT_PAYPAL_NOTE_REFUND_INFO','Bis 60 Tage nach dem Senden der urspr&uuml;nglichen Zahlung k&ouml;nnen Sie eine vollst&auml;ndige oder eine Teilr&uuml;ckzahlung leisten. Wenn Sie eine R&uuml;ckzahlung veranlassen, erhalten Sie von PayPal eine Geb&uuml;hrenr&uuml;ckerstattung, einschlie&szlig;lich der Teilgeb&uuml;hren f&uuml;r Teilr&uuml;ckzahlungen.

<br /><br />Um eine R&uuml;ckzahlung zu veranlassen, geben Sie den Betrag in das Feld R&uuml;ckzahlungsbetrag ein, und klicken Sie auf Weiter. ');
   
   define('TEXT_PAYPAL_NOTE_CAPTURE_INFO','');
   
   // errors
   define('REFUND_SUCCESS','Refund erfolgreich');
   define('CAPTURE_SUCCESS','Betrag erfolgreich gebucht');
   define('VOID_SUCCESS','Anforderung erfolgreich abgelehnt');
   
   define('ERROR_10009','The partial refund amount must be less than or equal to the remaining amount');
   
   // capture
   define('ERROR_10610','Amount specified exceeds allowable limit');
   define('ERROR_10602','Authorization has already been completed');
   define('ERROR_81251','Internal Service Error');

	// bof gm
	define('TEXT_PAYPAL_SEARCH_FOR',				'Suchen nach:');
	define('TEXT_PAYPAL_SEARCH_IN',					'Suchen in:');
	define('TEXT_PAYPAL_SEARCH_TIME',				'Zeitraum:');
	define('TEXT_PAYPAL_SEARCH_TIME_FROM',			'Von:');
	define('TEXT_PAYPAL_SEARCH_TIME_TO',			'Bis:');
	
	define('TEXT_PAYPAL_SEARCH_SELECT_MAIL',		'E-Mail');
	define('TEXT_PAYPAL_SEARCH_SELECT_ID',			'Transaktionscode');
	define('TEXT_PAYPAL_SEARCH_SELECT_NAME',		'Nachname');
	define('TEXT_PAYPAL_SEARCH_SELECT_FULLNAME',	'Nachname, Vorname');
	define('TEXT_PAYPAL_SEARCH_SELECT_INVOICE_NO',	'Rechnungsnummer');
	
	define('TEXT_PAYPAL_SEARCH_SELECT_LASTDAY',		'Letzter Tag');
	define('TEXT_PAYPAL_SEARCH_SELECT_LASTWEEK',	'Letzte Woche');
	define('TEXT_PAYPAL_SEARCH_SELECT_LASTMONTH',	'Letzter Monat');
	define('TEXT_PAYPAL_SEARCH_SELECT_LASTYEAR',	'Letztes Jahr');
	
	define('TEXT_PAYPAL_SEARCH_FORMAT_DAY',			'tt');
	define('TEXT_PAYPAL_SEARCH_FORMAT_MONTH',		'mm');
	define('TEXT_PAYPAL_SEARCH_FORMAT_YEAR',		'jjjjj');

	define('TEXT_PAYPAL_SEARCH_EMPTY_RESULT',		'- Keine Transaktionen gefunden -');
	define('TYPE_NONE',								'- Keine -');

	// eof gm
   
?>