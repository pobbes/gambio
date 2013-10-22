<?php
/* --------------------------------------------------------------
   gm_pdf_action.php 2008-08-07 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

gm_pdf_action.php 2007-11-26 pt@gambio
	Gambio OHG
	http://www.gambio.de
	Copyright (c) 2007 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
	--------------------------------------------------------------
*/
?>
<?php
	
	/*
	* -> Menu Titles
	*/
	define('MENU_TITLE_CONF',			'Konfiguration');
	define('MENU_TITLE_FONTS',			'Schriften');
	define('MENU_TITLE_CONTENT',		'Inhalt');
	define('MENU_TITLE_PREVIEW',		'Vorschau');
	define('MENU_TITLE_ORDER_INFO',		'Hinweistexte');
	define('MENU_TITLE_HEADER',			'Kopfteil');
	define('MENU_TITLE_FOOTER',			'Fussteil');
	define('MENU_TITLE_CONDITIONS',		'Agb/Widerruf');
	define('MENU_TITLE_LAYOUT',			'Layout');
	define('MENU_TITLE_DISPLAY',		'Anzeige');
	define('MENU_TITLE_LOGO',			'Logo');
	define('MENU_TITLE_EMAIL_TEXT',		'E-Mail Rechnung');
	define('MENU_TITLE_PROTECTION',		'Sicherheit');
	define('MENU_TITLE_INVOICING',		'Bestellstatus und Rechnungsdatum');


	/*
	* -> default messages
	*/
	define('BUTTON_SAVE',				'Speichern');
	define('PROCEED',					'Aktualisiert');
	define('ERROR_NOT_NUMERIC',			' muss numerisch sein!');
	
	/*
	* -> default select option yes/no
	*/
	define('SELECT_USE_1',				'ja');
	define('SELECT_USE_0',				'nein');

	
	/*
	* -> section layout
	*/
	define('GM_PDF_TITLE_TOP_MARGIN',				'Einzug oben');
	define('GM_PDF_TITLE_LEFT_MARGIN',				'Einzug links');
	define('GM_PDF_TITLE_RIGHT_MARGIN',				'Einzug rechts');
	define('GM_PDF_TITLE_BOTTOM_MARGIN',			'Einzug unten');
	define('GM_PDF_TITLE_HEADING_MARGIN_TOP',		'Einzug der &Uuml;berschrift nach oben');
	define('GM_PDF_TITLE_HEADING_MARGIN_BOTTOM',	'Einzug der &Uuml;berschrift nach unten');
	define('GM_PDF_TITLE_ORDER_INFO_MARGIN_TOP',	'Einzug des Hinweises nach oben');
	define('GM_PDF_TITLE_CELL_HEIGHT',				'H&ouml;he der Zellen');
	define('GM_PDF_TITLE_CUSTOMER_ADR_POS',			'mm Einzug der Kunden Adresse nach oben');
	define('GM_PDF_TITLE_DISPLAY_ZOOM',				'Zoomfaktor der PDF im Reader');
	define('GM_PDF_TITLE_DISPLAY_LAYOUT',			'Seitenlayout der PDF im Reader');
	
	define('SELECT_DISPLAY_ZOOM_FULLPAGE',			'volle Seite');
	define('SELECT_DISPLAY_ZOOM_FULLWIDTH',			'volle Breite');
	define('SELECT_DISPLAY_ZOOM_REAL',				'100%');
	define('SELECT_DISPLAY_ZOOM_DEFAULT',			'Einstellung des Readers');
	define('SELECT_DISPLAY_LAYOUT_SINGLE',			'Seite f&uuml;r Seite');
	define('SELECT_DISPLAY_LAYOUT_CONTINUOUS',		'fortlaufend');
	define('SELECT_DISPLAY_LAYOUT_TWO',				'Zwei Seiten nebeneinander');
	define('SELECT_DISPLAY_LAYOUT_DEFAULT',			'Einstellung des Readers');
	define('SELECT_DISPLAY_OUTPUT',					'Ausgabemodus');
	define('SELECT_DISPLAY_OUTPUT_D',				'PDF hinunterladen');
	define('SELECT_DISPLAY_OUTPUT_I',				'PDF im Browser ausgeben');
	
	/*
	* -> section display
	*/
	define('GM_LOGO_PDF_USE',						'Logo verwenden?');
	define('GM_PDF_TITLE_USE_CONDITIONS',			'Agbs verwenden?');
	define('GM_PDF_TITLE_USE_WITHDRAWAL',			'Widerruf verwenden?');
	define('GM_PDF_TITLE_FIX_HEADER',				'Kopfteil fixieren?');
	define('GM_PDF_TITLE_USE_HEADER',				'Kopfteil verwenden?');
	define('GM_PDF_TITLE_USE_FOOTER',				'Fussteil verwenden?');
	define('GM_PDF_TITLE_USE_INFO',					'Hinweis verwenden?');
	define('GM_PDF_TITLE_USE_INFO_TEXT',			'Hinweistext verwenden?');
	define('GM_PDF_TITLE_USE_DATE',					'aktuelles Datum verwenden?');
	define('GM_PDF_TITLE_USE_ORDER_DATE',			'Bestelldatum verwenden?');
	define('GM_PDF_TITLE_USE_INVOICE_CODE',			'Rechnungsummer verwenden?');
	define('GM_PDF_TITLE_USE_PACKING_CODE',			'Liefernummer verwenden?');
	define('GM_PDF_TITLE_USE_ORDER_CODE',			'Bestellnummer verwenden?');
	define('GM_PDF_TITLE_USE_CUSTOMER_CODE',		'Kundennummer verwenden?');
	define('GM_PDF_TITLE_USE_CUSTOMER_COMMENT',		'Kundenkommentar verwenden?');
	define('GM_PDF_TITLE_USE_PRODUCTS_MODEL',		'Spalte "Artikel Nr" Verwenden?');

	/*
	* -> Section Fonts
	*/
	define('GM_PDF_TITLE_DEFAULT_FONT_FACE',			'Standardschrift');
	define('GM_PDF_TITLE_CUSTOMER_FONT_FACE',			'Kundenadresse');
	define('GM_PDF_TITLE_COMPANY_LEFT_FONT_FACE',		'Firmenadresse links');
	define('GM_PDF_TITLE_COMPANY_RIGHT_FONT_FACE',		'Firmenadresse rechts');
	define('GM_PDF_TITLE_HEADING_FONT_FACE',			'&Uuml;berschrift');
	define('GM_PDF_TITLE_HEADING_ORDER_FONT_FACE',		'Bestell-Tabellenkopf');
	define('GM_PDF_TITLE_ORDER_FONT_FACE',				'Bestell-Tabelle');
	define('GM_PDF_TITLE_ORDER_TOTAL_FONT_FACE',		'Bestell-Zusammenfassung');
	define('GM_PDF_TITLE_HEADING_ORDER_INFO_FONT_FACE',	'&Uuml;berschrift Hinweis');
	define('GM_PDF_TITLE_ORDER_INFO_FONT_FACE',			'Hinweistext');
	define('GM_PDF_TITLE_FOOTER_FONT_FACE',				'Fussteil');
	define('GM_PDF_TITLE_HEADING_CONDITIONS_FONT_FACE', '&Uuml;berschrift Agb/Widerruf');
	define('GM_PDF_TITLE_CONDITIONS_FONT_FACE',			'Agb/Widerruf');
	define('GM_PDF_TITLE_CANCEL_FONT_FACE',				'Storno-Hinweis');
	define('GM_PDF_TITLE_DRAW_COLOR',					'Farbe f&uuml;r Linien');

	define('SELECT_FONT_STYLE_',						'kein Stil');
	define('SELECT_FONT_STYLE_B',						'fett');
	define('SELECT_FONT_STYLE_I',						'kursiv');
	define('SELECT_FONT_STYLE_U',						'unterstrichen');
	
	/*
	* -> Section Content
	*/
	define('GM_PDF_TITLE_COMPANY_ADRESS_LEFT',					'Firmenadresse links'); 
	define('GM_PDF_TITLE_COMPANY_ADRESS_RIGHT',					'Firmenadresse rechts');
	define('GM_PDF_TITLE_HEADING_INVOICE',						'&Uuml;berschrift Rechnung');
	define('GM_PDF_TITLE_HEADING_PACKINGSLIP',					'&Uuml;berschrift Lieferschein');
	define('GM_PDF_TITLE_HEADING_INFO_TEXT_INVOICE',			'&Uuml;berschrift Rechnungshinweis');
	define('GM_PDF_TITLE_HEADING_INFO_TEXT_PACKINGSLIP',		'&Uuml;berschrift Lieferhinweis');
	define('GM_PDF_TITLE_INFO_TEXT_INVOICE',					'Hinweistext Rechnung');
	define('GM_PDF_TITLE_INFO_TEXT_PACKINGSLIP',				'Hinweistext Lieferschein');
	define('GM_PDF_TITLE_INFO_TITLE_INVOICE',					'Hinweistitel Rechnung');
	define('GM_PDF_TITLE_INFO_TITLE_PACKINGSLIP',				'Hinweistitel Lieferschein');
	define('GM_PDF_TITLE_FOOTER_CELL_1',						'Fussteil erste Spalte');
	define('GM_PDF_TITLE_FOOTER_CELL_2',						'Fussteil zweite Spalte');
	define('GM_PDF_TITLE_FOOTER_CELL_3',						'Fussteil dritte Spalte');
	define('GM_PDF_TITLE_FOOTER_CELL_4',						'Fussteil vierte Spalte');
	define('GM_PDF_TITLE_HEADING_CONDITIONS',					'&Uuml;berschrift Agb');
	define('GM_PDF_TITLE_HEADING_WITHDRAWAL',					'&Uuml;berschrift Widerruf');
	define('GM_PDF_TITLE_CONDITIONS',							'Agb');
	define('GM_PDF_TITLE_WITHDRAWAL',							'Widerruf');
	define('GM_PDF_TITLE_CHOOSE_LOGO',							'Logo ausw&auml;hlen');
	define('GM_PDF_TITLE_EMAIL_TEXT',							'Nachricht');
	define('GM_PDF_TITLE_EMAIL_TEXT_INFO',						'<small>Platzhalter: Kundenname: {CUSTOMER}  Rechnungsnr: {INVOICE_ID} Bestellnr: {ORDER_ID} Bestelldatum: {DATE}</small>');
	define('GM_PDF_TITLE_EMAIL_SUBJECT',						'E-Mail Betreff');
	define('GM_PDF_TITLE_EMAIL_SUBJECT_INFO',					'<small>Platzhalter: Rechnungsnr: {INVOICE_ID} Bestellnr: {ORDER_ID} Bestelldatum: {DATE}</small>');
	
	/*
	* -> Section Protection
	*/
	define('GM_PDF_TITLE_USE_PROTECTION',		'PDF Dokument sch&uuml;tzen?');
	define('GM_PDF_TITLE_ALLOW_PRINTING',		'Drucken des PDF-Dokumentes erlauben');
	define('GM_PDF_TITLE_ALLOW_MODIFYING',		'Modifizieren des PDF-Dokumentes erlauben');
	define('GM_PDF_TITLE_ALLOW_NOTIFYING',		'Kommentieren des PDF-Dokumentes erlauben');
	define('GM_PDF_TITLE_ALLOW_COPYING',		'Kopieren der internen Texte und Grafiken erlauben');

	
	/*
	* -> Section Preview
	*/
	define('TITLE_INVOICE',		'Rechnung');
	define('TITLE_PACKINGSLIP',	'Lieferschein');
	define('SELECT_CHOOSE',		'W&auml;hlen');
	define('SELECT_ORDERS',		'Bestellnr.: ');
	define('SELECT_CUSTOMER',	'Kunde: ');
	define('NOTE_PREVIEW',		'Bitte beachten Sie, dass in der Vorschau die Rechnungs- bzw. die Lieferscheinnummer nicht generiert werden.<br />Dies geschieht nur unter "Bestellungen". Angezeigt wird jeweils die bereits generierte bzw. vorl&auml;ufige Nummer.');
	
	define('GM_PDF_ORDER_STATUS_INVOICE', 'Bestellstatus nach Rechnungserstellung');
	define('GM_PDF_ORDER_STATUS_INVOICE_MAIL', 'Bestellstatus nach E-Mail Rechnungsversand');
	define('GM_PDF_ORDER_STATUS_NOT', 'nicht &auml;ndern');
	define('GM_PDF_ORDER_STATUS_INVOICE_DATE', 'Bestellstatus, der zur Ermittlung des Rechnungsdatum verwendet werden soll');
	define('USE_DATE_INVOICE', 'Rechnungserstellung');
	define('USE_DATE_INVOICE_MAIL', 'E-Mail Rechnungsversand ');

	
?>