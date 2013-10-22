<?php
/* 
	--------------------------------------------------------------
	gm_id_starts.php 2008-03-28 mb
	Gambio OHG
	http://www.gambio.de
	Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
	--------------------------------------------------------------
*/
?>
<?php

	define('HEADING_TITLE', 'Nummernkreise');
	define('HEADING_SUB_TITLE', 'Gambio');
	define('GM_ID_STARTS_TEXT', 'Hier k&ouml;nnen Sie die Nummernkreise f&uuml;r Bestellungen und Kunden anpassen. Beachten Sie, dass nur numerische Werte erlaubt sind.');
	define('GM_ID_STARTS_NEXT_ORDER_ID', 'N&auml;chste Bestellnummer: ');
	define('GM_ID_STARTS_NEXT_CUSTOMER_ID', 'N&auml;chste Kundennummer: ');
	define('GM_ID_STARTS_SUCCESS', 'Die &Auml;nderungen wurden erfolgreich durchgef&uuml;hrt.');
	define('GM_ID_STARTS_NO_SUCCESS', 'Die &Auml;nderungen konnten nicht erfolgreich durchgef&uuml;hrt werden.');
	define('GM_ID_STARTS_ORDERS_ERROR', 'Die Bestellnummer ist kleiner als der Minimumwert oder enth&auml;lt Zeichen.');
	define('GM_ID_STARTS_CUSTOMERS_ERROR', 'Die Kundennummer ist kleiner als der Minimumwert oder enth&auml;lt Zeichen.');

	define('GM_NEXT_ID_TEXT', 'Hier k&ouml;nnen Sie die Nummernkreise f&uuml;r Rechnungs- und Lieferscheinnummer anpassen. Beachten Sie, das diese beiden Nummern fortlaufend sind und jeweils erst bei der Erstellung bzw. Versand von Rechnung und Lieferschein generiert werden. Sollten Sie das Format nachtr&auml;glich anpassen, so wird das neue Format auch erst in neu generierten Rechnungen und Lieferscheinen angewendet.');

	define('GM_TITLE_ID', 'Bestell- und Kundennummer');	
	define('GM_TITLE_NEXT_ID', 'Rechnungs- und Lieferscheinnummer');
	define('GM_NEXT_INVOICE_ID', 'N&auml;chste Rechnungsnummer: ');
	define('GM_INVOICE_ID', 'Format Rechnungsnummer: ');
	define('GM_INVOICE_ID_PLACEMENT', 'Platzhalter Rechnungsnummer {INVOICE_ID}');
	define('GM_NEXT_INVOICE_ID_ERROR', 'Die Rechnungsnummer ist kleiner als der Minimumwert oder enth&auml;lt Zeichen.');
	define('GM_NEXT_INVOICE_ID_SUCCESS', 'Die Rechnungsnummer wurde &uuml;bernommen.');
 
	
	define('GM_NEXT_PACKINGS_ID', 'N&auml;chste Lieferscheinnummer: ');
	define('GM_PACKINGS_ID', 'Format Lieferscheinnummer: ');
	define('GM_PACKING_ID_PLACEMENT', 'Platzhalter Lieferscheinnummer {DELIVERY_ID}');
	define('GM_NEXT_PACKING_ID_ERROR', 'Die Lieferscheinnummer ist kleiner als der Minimumwert oder enth&auml;lt Zeichen.');
	define('GM_NEXT_PACKING_ID_SUCCESS', 'Die Lieferscheinnummer wurde &uuml;bernommen.');


?>