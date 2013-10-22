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
	define('MENU_TITLE_CONF',			'Configuration');
	define('MENU_TITLE_FONTS',			'Fonts');
	define('MENU_TITLE_CONTENT',		'Content');
	define('MENU_TITLE_PREVIEW',		'Preview');
	define('MENU_TITLE_ORDER_INFO',		'Info Text');
	define('MENU_TITLE_HEADER',			'Header');
	define('MENU_TITLE_FOOTER',			'Footer');
	define('MENU_TITLE_CONDITIONS',		'Conditions/Right of Withdrawal');
	define('MENU_TITLE_LAYOUT',			'Layout');
	define('MENU_TITLE_DISPLAY',		'Display');
	define('MENU_TITLE_LOGO',			'Logo');
	define('MENU_TITLE_EMAIL_TEXT',		'Email Invoice');
	define('MENU_TITLE_PROTECTION',		'Security');
	define('MENU_TITLE_INVOICING',		'Order Status and Invoice Date');

	/*
	* -> default messages
	*/
	define('BUTTON_SAVE',				'Save');
	define('PROCEED',					'Updated');
	define('ERROR_NOT_NUMERIC',			' must be numeric!');

	/*
	* -> default select option yes/no
	*/
	define('SELECT_USE_1',				'Yes');
	define('SELECT_USE_0',				'No');
	define('SELECT_USE_2',				'only in invoice');
	define('SELECT_USE_3',				'only in packingslip');

	/*
	* -> section layout
	*/
	define('GM_PDF_TITLE_TOP_MARGIN',				'Margin Top');
	define('GM_PDF_TITLE_LEFT_MARGIN',				'Margin Left');
	define('GM_PDF_TITLE_RIGHT_MARGIN',				'Margin Right');
	define('GM_PDF_TITLE_BOTTOM_MARGIN',			'Margin Bottom');
	define('GM_PDF_TITLE_HEADING_MARGIN_TOP',		'Margin Heading Top');
	define('GM_PDF_TITLE_HEADING_MARGIN_BOTTOM',	'Margin Heading Bottom');
	define('GM_PDF_TITLE_ORDER_INFO_MARGIN_TOP',	'Margin Info Top');
	define('GM_PDF_TITLE_CELL_HEIGHT',				'Cell Height');
	define('GM_PDF_TITLE_CUSTOMER_ADR_POS',			'MM Margin Customer Address Top');
	define('GM_PDF_TITLE_DISPLAY_ZOOM',				'PDF Document Zoom Factor');
	define('GM_PDF_TITLE_DISPLAY_LAYOUT',			'PDF Document Layout');

	define('SELECT_DISPLAY_ZOOM_FULLPAGE',			'Full Page');
	define('SELECT_DISPLAY_ZOOM_FULLWIDTH',			'Full Width');
	define('SELECT_DISPLAY_ZOOM_REAL',				'100%');
	define('SELECT_DISPLAY_ZOOM_DEFAULT',			'PDF Reader Default');
	define('SELECT_DISPLAY_LAYOUT_SINGLE',			'Single Page');
	define('SELECT_DISPLAY_LAYOUT_CONTINUOUS',		'Continuous');
	define('SELECT_DISPLAY_LAYOUT_TWO',				'Two Pages');
	define('SELECT_DISPLAY_LAYOUT_DEFAULT',			'PDF Reader Default');
	define('SELECT_DISPLAY_OUTPUT_D',				'Output a new file');
	define('SELECT_DISPLAY_OUTPUT_I',				'Output to browser');
	/*
	* -> section display
	*/
	define('GM_LOGO_PDF_USE',						'Show Logo');
	define('GM_PDF_TITLE_USE_CONDITIONS',			'Show Conditions');
	define('GM_PDF_TITLE_USE_WITHDRAWAL',			'Show Right of Withdrawal');
	define('GM_PDF_TITLE_FIX_HEADER',				'Fix Header');
	define('GM_PDF_TITLE_USE_HEADER',				'Show Header');
	define('GM_PDF_TITLE_USE_FOOTER',				'Show Footer');
	define('GM_PDF_TITLE_USE_INFO',					'Show Info');
	define('GM_PDF_TITLE_USE_INFO_TEXT',			'Show Infotext');
	define('GM_PDF_TITLE_USE_DATE',					'Show Current Date');
	define('GM_PDF_TITLE_USE_ORDER_DATE',			'Show Order Date');
	define('GM_PDF_TITLE_USE_INVOICE_CODE',			'Show Invoice ID');
	define('GM_PDF_TITLE_USE_PACKING_CODE',			'Show Packing ID');
	define('GM_PDF_TITLE_USE_ORDER_CODE',			'Show Order ID');
	define('GM_PDF_TITLE_USE_CUSTOMER_CODE',		'Show Customer ID');
	define('GM_PDF_TITLE_USE_CUSTOMER_COMMENT',		'Show Customer Comment');
	define('GM_PDF_TITLE_USE_PRODUCTS_MODEL',		'Show Column "Product No."');

	/*
	* -> Section Fonts
	*/
	define('GM_PDF_TITLE_DEFAULT_FONT_FACE',			'Default Font');
	define('GM_PDF_TITLE_CUSTOMER_FONT_FACE',			'Customer Address');
	define('GM_PDF_TITLE_COMPANY_LEFT_FONT_FACE',		'Company Address Left');
	define('GM_PDF_TITLE_COMPANY_RIGHT_FONT_FACE',		'Company Address Right');
	define('GM_PDF_TITLE_HEADING_FONT_FACE',			'Heading');
	define('GM_PDF_TITLE_HEADING_ORDER_FONT_FACE',		'Order Table Heading');
	define('GM_PDF_TITLE_ORDER_FONT_FACE',				'Order Table');
	define('GM_PDF_TITLE_ORDER_TOTAL_FONT_FACE',		'Order Total');
	define('GM_PDF_TITLE_HEADING_ORDER_INFO_FONT_FACE',	'Heading Info');
	define('GM_PDF_TITLE_ORDER_INFO_FONT_FACE',			'Infotext');
	define('GM_PDF_TITLE_FOOTER_FONT_FACE',				'Footer');
	define('GM_PDF_TITLE_HEADING_CONDITIONS_FONT_FACE', 'Heading Conditions/Right of Withdrawal');
	define('GM_PDF_TITLE_CONDITIONS_FONT_FACE',			'Conditions/Right of Withdrawal');
	define('GM_PDF_TITLE_DRAW_COLOR',					'Line Color');
	define('GM_PDF_TITLE_CANCEL_FONT_FACE',				'Cancel Info');

	define('SELECT_FONT_STYLE_',						'No Style');
	define('SELECT_FONT_STYLE_B',						'Bold');
	define('SELECT_FONT_STYLE_I',						'Italic');
	define('SELECT_FONT_STYLE_U',						'Underline');

	/*
	* -> Section Content
	*/
	define('GM_PDF_TITLE_COMPANY_ADRESS_LEFT',					'Company Address Left');
	define('GM_PDF_TITLE_COMPANY_ADRESS_RIGHT',					'Company Address Right');
	define('GM_PDF_TITLE_HEADING_INVOICE',						'Heading Invoice');
	define('GM_PDF_TITLE_HEADING_PACKINGSLIP',					'Heading Packing Slip');
	define('GM_PDF_TITLE_HEADING_INFO_TEXT_INVOICE',			'Heading Invoice Info');
	define('GM_PDF_TITLE_HEADING_INFO_TEXT_PACKINGSLIP',		'Heading Packing Slip Info');
	define('GM_PDF_TITLE_INFO_TEXT_INVOICE',					'Invoice Infotext');
	define('GM_PDF_TITLE_INFO_TEXT_PACKINGSLIP',				'Packing Slip Infotext');
	define('GM_PDF_TITLE_INFO_TITLE_INVOICE',					'Title Invoice Info');
	define('GM_PDF_TITLE_INFO_TITLE_PACKINGSLIP',				'Title Packing Slip Info');
	define('GM_PDF_TITLE_FOOTER_CELL_1',						'Footer Column 1');
	define('GM_PDF_TITLE_FOOTER_CELL_2',						'Footer Column 2');
	define('GM_PDF_TITLE_FOOTER_CELL_3',						'Footer Column 3');
	define('GM_PDF_TITLE_FOOTER_CELL_4',						'Footer Column 4');
	define('GM_PDF_TITLE_HEADING_CONDITIONS',					'Heading Conditions');
	define('GM_PDF_TITLE_HEADING_WITHDRAWAL',					'Heading Right of Withdrawal');
	define('GM_PDF_TITLE_CONDITIONS',							'Conditions');
	define('GM_PDF_TITLE_WITHDRAWAL',							'Right of Withdrawal');
	define('GM_PDF_TITLE_CHOOSE_LOGO',							'Choose a Logo');
	define('GM_PDF_TITLE_EMAIL_TEXT',							'Email Message');
	define('GM_PDF_TITLE_EMAIL_TEXT_INFO',						'<small>placeholder: customer: {CUSTOMER} invoice ID: {INVOICE_ID} order ID: {ORDER_ID} date: {DATE}</small>');
	define('GM_PDF_TITLE_EMAIL_SUBJECT',						'Subject');
	define('GM_PDF_TITLE_EMAIL_SUBJECT_INFO',					'<small>placeholder: invoice ID: {INVOICE_ID} order ID: {ORDER_ID} date: {DATE}</small>');
	define('GM_PDF_FILE_NAME_INVOICE',							'invoice.pdf');
	define('GM_PDF_FILE_NAME_PACKINGSLIP',						'packingslip.pdf');

	define('GM_PDF_TITLE_FILE_NAME_INVOICE',					'Filename Invoice');
	define('GM_PDF_TITLE_FILE_NAME_PACKINGSLIP',				'Filename Packingslip');

	define('GM_PDF_INFO_FILE_NAME_INVOICE',						'<small>placeholder: customer: {CUSTOMER} invoice id: {INVOICE_ID} order id: {ORDER_ID}</small>');
	define('GM_PDF_INFO_FILE_NAME_PACKINGSLIP',					'<small>placeholder: customer: {CUSTOMER} packingslip id: {PACKINGSLIP_ID} order id: {ORDER_ID}</small>');

	/*
	* -> Section Protection
	*/
	define('GM_PDF_TITLE_USE_PROTECTION',		'Protect PDF');
	define('GM_PDF_TITLE_ALLOW_PRINTING',		'Allow Printing');
	define('GM_PDF_TITLE_ALLOW_MODIFYING',		'Allow Modifying');
	define('GM_PDF_TITLE_ALLOW_NOTIFYING',		'Allow Notifying');
	define('GM_PDF_TITLE_ALLOW_COPYING',		'Allow Copying');


	/*
	* -> Section Preview
	*/
	define('TITLE_INVOICE',		'Invoice');
	define('TITLE_PACKINGSLIP',	'Packing Slip');
	define('SELECT_CHOOSE',		'Choose');
	define('SELECT_ORDERS',		'Order No.: ');
	define('SELECT_CUSTOMER',	'Customer: ');
	define('NOTE_PREVIEW',		'Note that in the preview of the invoice and packing slip, the number is not generated in the same way as in "orders".');

	// NEW
	define('SELECT_DISPLAY_OUTPUT', 'Output mode');
	define('GM_PDF_ORDER_STATUS_INVOICE', 'Order Status Invoice');
	define('GM_PDF_ORDER_STATUS_INVOICE_MAIL', 'Order Status Invoice Mail');
	define('GM_PDF_ORDER_STATUS_NOT', 'do not change');
	define('GM_PDF_ORDER_STATUS_INVOICE_DATE', 'order status to be used to determine the date of invoice');
	define('USE_DATE_INVOICE', 'Invoicing');
	define('USE_DATE_INVOICE_MAIL', 'E-Mail Invoicing');
?>