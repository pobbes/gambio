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
 * $Id: sofort_sofortrechnung.php 5725 2012-11-21 11:09:39Z rotsch $
 */

//include language-constants used in all Multipay Projects
require_once 'sofort_general.php';

define('MODULE_PAYMENT_SOFORT_SR_CHECKOUT_CONDITIONS_WITH_LIGHTBOX', '<a href="https://documents.sofort.com/de/sr/privacy_de" target="_blank">Ich habe die Datenschutzhinweise gelesen.</a>');
define('MODULE_PAYMENT_SOFORT_SR_CHECKOUT_CONDITIONS', '
	<script type="text/javascript">
		function showSrConditions() {
			srOverlay = new sofortOverlay(jQuery(".srOverlay"), "callback/sofort/ressources/scripts/getContent.php", "https://documents.sofort.com/de/sr/privacy_de");
			srOverlay.trigger();
		}
	</script>
	<noscript>
		<a href="https://documents.sofort.com/de/sr/privacy_de" target="_blank">Ich habe die Datenschutzhinweise gelesen.</a>
	</noscript>
	<!-- comSeo-Ajax-Checkout-Bugfix: show also div, when buyer doesnt use JS -->
	<div>
		<a id="srNotice" href="javascript:void(0)" onclick="showSrConditions();">Ich habe die Datenschutzhinweise gelesen.</a>
	</div>
	<div style="display:none; z-index: 1001;filter: alpha(opacity=92);filter: progid :DXImageTransform.Microsoft.Alpha(opacity=92);-moz-opacity: .92;-khtml-opacity: 0.92;opacity: 0.92;background-color: black;position: fixed;top: 0px;left: 0px;width: 100%;height: 100%;text-align: center;vertical-align: middle;" class="srOverlay">
		<div class="loader" style="z-index: 1002;position: relative;background-color: #fff;top: 40px;overflow: scroll;padding: 4px;border-radius: 7px;-moz-border-radius: 7px;-webkit-border-radius: 7px;margin: auto;width: 620px;height: 400px;overflow: scroll; overflow-x: hidden;">
			<div class="closeButton" style="position: fixed; top: 54px; background: url(callback/sofort/ressources/images/close.png) right top no-repeat;cursor:pointer;height: 30px;width: 30px;"></div>
			<div class="content"></div>
		</div>
	</div>
');

define('MODULE_PAYMENT_SOFORT_SR_TEXT_DESCRIPTION_EXTRA', 
	MODULE_PAYMENT_SOFORT_MULTIPAY_JS_LIBS.'
	<div id="srExtraDesc">
		<div class="content" style="display:none;"></div>
	</div>
	<script type="text/javascript">
		srOverlay = new sofortOverlay(jQuery("#srExtraDesc"), "'.DIR_WS_CATALOG.'callback/sofort/ressources/scripts/getContent.php", "https://documents.sofort.com/rbs/shopinfo/de");
	</script>
');

define('MODULE_PAYMENT_SOFORT_SOFORTRECHNUNG_TEXT_TITLE', 'Rechnung by SOFORT <br /><img src="https://images.sofort.com/de/sr/logo_90x30.png"  alt="Logo Rechnung by SOFORT"/>');
define('MODULE_PAYMENT_SOFORT_SR_TEXT_TITLE', 'Kauf auf Rechnung');
define('MODULE_PAYMENT_SOFORT_SR_LOGO_HTML', '<img src="https://images.sofort.com/de/sr/logo_90x30.png"  alt="Logo Rechnung by SOFORT"/>');
define('MODULE_PAYMENT_SOFORT_SR_TEXT_ERROR_MESSAGE', 'Die gew�hlte Zahlart ist leider nicht m�glich oder wurde auf Kundenwunsch abgebrochen. Bitte w�hlen Sie eine andere Zahlweise.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_SR', 'Die gew�hlte Zahlart ist leider nicht m�glich oder wurde auf Kundenwunsch abgebrochen. Bitte w�hlen Sie eine andere Zahlweise.');

define('MODULE_PAYMENT_SOFORT_MULTIPAY_SR_CHECKOUT_TEXT', '');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_CONFIRM_SR', 'Rechnung hier best�tigen:');
define('MODULE_PAYMENT_SOFORT_SR_SORT_ORDER_TITLE', 'Anzeigereihenfolge');
define('MODULE_PAYMENT_SOFORT_SR_SORT_ORDER_DESC', 'Reihenfolge der Anzeige. Kleinste Ziffer wird zuerst angezeigt.');
define('MODULE_PAYMENT_SOFORT_SR_STATUS_TITLE', 'sofort.de Modul aktivieren');
define('MODULE_PAYMENT_SOFORT_SR_STATUS_DESC', 'Aktiviert/deaktiviert das komplette Modul');
define('MODULE_PAYMENT_SOFORT_SR_TEXT_DESCRIPTION', 'Kauf auf Rechnung mit Zahlungsgarantie.');
define('MODULE_PAYMENT_SOFORT_SOFORTRECHNUNG_ALLOWED_TITLE', 'Erlaubte Zonen');
define('MODULE_PAYMENT_SOFORT_SOFORTRECHNUNG_ALLOWED_DESC', 'Geben Sie <b>einzeln</b> die Zonen an, welche f�r dieses Modul erlaubt sein sollen. (z.B. AT,DE (wenn leer, werden alle Zonen erlaubt))');
define('MODULE_PAYMENT_SOFORT_SR_ZONE_TITLE', MODULE_PAYMENT_SOFORT_MULTIPAY_ZONE_TITLE);
define('MODULE_PAYMENT_SOFORT_SR_ZONE_DESC', MODULE_PAYMENT_SOFORT_MULTIPAY_ZONE_DESC);

define('MODULE_PAYMENT_SOFORT_SR_PEN_CON_INV_STATUS_ID_TITLE', 'Unbest�tigter Bestellstatus');
define('MODULE_PAYMENT_SOFORT_SR_PEN_CON_INV_STATUS_ID_DESC', 'Bestellstatus nach erfolgreicher Zahlung. Die Rechnung wurde noch nicht durch den H�ndler freigegeben.'); // (pending-confirm_invoice)

define('MODULE_PAYMENT_SOFORT_SR_LOS_CAN_STATUS_ID_TITLE', 'Bestellstatus bei kompletter Stornierung');
define('MODULE_PAYMENT_SOFORT_SR_LOS_CAN_STATUS_ID_DESC', 'Stornierter Bestellstatus<br />Bestellstatus nach einer vollen Stornierung der Rechnung.');  //(loss-canceled, loss-confirmation_period_expired)

define('MODULE_PAYMENT_SOFORT_SR_PEN_NOT_CRE_YET_STATUS_ID_TITLE', 'Best�tigter Bestellstatus');
define('MODULE_PAYMENT_SOFORT_SR_PEN_NOT_CRE_YET_STATUS_ID_DESC', 'Bestellstatus nach erfolgreicher und best�tigter Transaktion und Freigabe der Rechnung durch den H�ndler.'); //(pending-not_credited_yet)

define('MODULE_PAYMENT_SOFORT_SR_REF_REF_STATUS_ID_TITLE', 'Stornierung nach Best�tigung (Gutschrift)');
define('MODULE_PAYMENT_SOFORT_SR_REF_REF_STATUS_ID_DESC', 'Status f�r Bestellungen, die nach der Best�tigung vollst�ndig storniert wurden (Gutschrift).'); // (refunded_refunded)

define('MODULE_PAYMENT_SOFORT_SR_TMP_COMMENT', 'Kauf auf Rechnung als Zahlungsart gew�hlt. Transaktion nicht abgeschlossen.');
define('MODULE_PAYMENT_SOFORT_SR_TMP_COMMENT_SELLER', 'Weiterleitung zu SOFORT - Bezahlung noch nicht erfolgt.');

define('MODULE_PAYMENT_SOFORT_SR_RECOMMENDED_PAYMENT_TITLE', 'Empfohlene Zahlungsweise');
define('MODULE_PAYMENT_SOFORT_SR_RECOMMENDED_PAYMENT_DESC', 'Diese Zahlart als "empfohlene Zahlungsart" markieren. Auf der Bezahlseite erfolgt ein Hinweis direkt hinter der Zahlungsart.');
define('MODULE_PAYMENT_SOFORT_SR_RECOMMENDED_PAYMENT_TEXT', '(Empfohlene Zahlungsweise)');

define('MODULE_PAYMENT_SOFORT_SR_INVOICE_CONFIRMED_HISTORY', 'Auftrag zur Best�tigung der Rechnung wurde an SOFORT gesendet. Best�tigung seitens SOFORT ausstehend.');
define('MODULE_PAYMENT_SOFORT_SR_INVOICE_CANCELED_HISTORY', 'Auftrag zur Stornierung der Rechnung wurde an SOFORT gesendet. Best�tigung seitens SOFORT ausstehend.');
define('MODULE_PAYMENT_SOFORT_SR_INVOICE_REFUNDED_HISTORY', 'Auftrag zur Gutschrift der Rechnung wurde an SOFORT gesendet. Best�tigung seitens SOFORT ausstehend.');

/////////////////////////////////////////////////
//////// Seller-Backend and callback.php ////////
/////////////////////////////////////////////////

define('MODULE_PAYMENT_SOFORT_SR_CONFIRM_INVOICE', 'Rechnung best�tigen');
define('MODULE_PAYMENT_SOFORT_SR_CANCEL_INVOICE', 'Rechnung stornieren');
define('MODULE_PAYMENT_SOFORT_SR_CANCEL_CONFIRMED_INVOICE', 'Rechnung gutschreiben');
define('MODULE_PAYMENT_SOFORT_SR_CANCEL_INVOICE_QUESTION', 'Sind Sie sicher, dass Sie die Rechnung wirklich stornieren wollen? Dieser Vorgang kann nicht r�ckg�ngig gemacht werden.');
define('MODULE_PAYMENT_SOFORT_SR_CANCEL_CONFIRMED_INVOICE_QUESTION', 'Sind Sie sicher, dass Sie die Rechnung wirklich gutschreiben wollen? Dieser Vorgang kann nicht r�ckg�ngig gemacht werden.');
define('MODULE_PAYMENT_SOFORT_SR_TRANSLATE_INVOICE_CANCELED_REFUNDED', 'Die Rechnung wurde storniert. Gutschrift erstellt.');
define('MODULE_PAYMENT_SOFORT_SR_TRANSLATE_INVOICE_CANCELED', 'Die Rechnung wurde storniert.');

define('MODULE_PAYMENT_SOFORT_SR_DOWNLOAD_INVOICE', 'Rechnung herunterladen');
define('MODULE_PAYMENT_SOFORT_SR_DOWNLOAD_INVOICE_HINT', 'Laden Sie hier das entsprechende Dokument (Rechnungsvorschau, Rechnung, Gutschrift) herunter.');
define('MODULE_PAYMENT_SOFORT_SR_DOWNLOAD_CREDIT_MEMO', 'Gutschrift herunterladen');
define('MODULE_PAYMENT_SOFORT_SR_DOWNLOAD_INVOICE_PREVIEW', 'Rechnungsvorschau herunterladen');

define('MODULE_PAYMENT_SOFORT_SR_EDIT_CART', 'Warenkorb anpassen');
define('MODULE_PAYMENT_SOFORT_SR_UPDATE_CART', 'Warenkorb speichern');
define('MODULE_PAYMENT_SOFORT_SR_UPDATE_CART_QUESTION', 'Wollen Sie den Warenkorb wirklich anpassen?');
define('MODULE_PAYMENT_SOFORT_SR_UPDATE_CART_HINT', 'Speichern Sie hier Ihre �nderungen am Warenkorb. Bei bereits best�tigten Rechnung f�hrt ein mengenm��ig reduzierter sowie ein von der Rechnung gel�schter Artikel zu einer Gutschrift.');
define('MODULE_PAYMENT_SOFORT_SR_UPDATE_DISCOUNTS_HINT', 'Sie k�nnen Rabatte oder Aufschl�ge anpassen. Aufschl�ge d�rfen nicht erh�ht werden und Rabatte keine Betr�ge gr��er Null erhalten. Der Gesamtbetrag der Rechnung darf durch die Anpassung nicht erh�ht werden.');
define('MODULE_PAYMENT_SOFORT_SR_UPDATE_DISCOUNTS_GTZERO_HINT', 'Rabatte d�rfen keinen Betrag gr��er Null erhalten.');
define('MODULE_PAYMENT_SOFORT_SR_UPDATE_QUANTITY', 'Menge anpassen');
define('MODULE_PAYMENT_SOFORT_SR_UPDATE_QUANTITY_HINT', 'Sie k�nnen die Anzahl der Artikel pro Position anpassen. Es d�rfen lediglich Mengen reduziert, nicht jedoch hinzugef�gt werden.');
define('MODULE_PAYMENT_SOFORT_SR_UPDATE_QUANTITY_TOTAL_GTZERO', 'Die Anzahl des Artikels kann nicht reduziert werden, da die Gesamtsumme der Rechnung nicht negativ sein darf.');
define('MODULE_PAYMENT_SOFORT_SR_UPDATE_QUANTITY_ZERO_HINT', 'Anzahl muss gr��er 0 sein. Zum L�schen markieren Sie den Artikel bitte am Ende der Zeile.');
define('MODULE_PAYMENT_SOFORT_SR_UPDATE_PRICE', 'Preis anpassen');
define('MODULE_PAYMENT_SOFORT_SR_UPDATE_PRICE_HINT', 'Sie k�nnen den Preis der einzelnen Artikel pro Position anpassen. Preise k�nnen lediglich reduziert, nicht erh�ht werden.');
define('MODULE_PAYMENT_SOFORT_SR_UPDATE_PRICE_TOTAL_GTZERO', 'Der Preis kann nicht reduziert werden, da die Gesamtsumme der Rechnung nicht negativ sein darf.');
define('MODULE_PAYMENT_SOFORT_SR_UPDATE_PRICE_AND_QUANTITY_HINT', 'Es k�nnen nicht gleichzeitig Preis und Menge angepasst werden.');
define('MODULE_PAYMENT_SOFORT_SR_UPDATE_PRICE_AND_QUANTITY_NAN', 'Sie haben ung�ltige Zeichen eingegeben. Bei diesen Anpassungen sind nur Zahlen zul�ssig.');
define('MODULE_PAYMENT_SOFORT_SR_UPDATE_VALUE_LTZERO_HINT', 'Wert darf nicht kleiner 0 sein.');

define('MODULE_PAYMENT_SOFORT_SR_UPDATE_CONFIRMED_INVOICE', 'Bitte Kommentar eingeben');
define('MODULE_PAYMENT_SOFORT_SR_UPDATE_CONFIRMED_INVOICE_HINT', 'Bei Anpassung einer bereits best�tigten Rechnung muss eine entsprechende Begr�ndung hinterlegt werden. Diese erscheint sp�ter auf der Gutschrift als Kommentar zum entsprechenden Artikel.');
define('MODULE_PAYMENT_SOFORT_SR_UPDATE_SHIPPING_HINT', 'Sie k�nnen den Preis der Versandkosten anpassen. Der Preis kann lediglich reduziert, nicht erh�ht werden.');
define('MODULE_PAYMENT_SOFORT_SR_UPDATE_SHIPPING_TOTAL_GTZERO', 'Die Versandkosten k�nnen nicht reduziert werden, da die Gesamtsumme der Rechnung nicht negativ sein darf.');

define('MODULE_PAYMENT_SOFORT_SR_RECALCULATION', 'wird neu berechnet');

define('MODULE_PAYMENT_SOFORT_SR_REMOVE_FROM_INVOICE_TOTAL_GTZERO','Dieser Artikel kann nicht gel�scht werden, da die Gesamtsumme der Rechnung nicht negativ sein darf.');
define('MODULE_PAYMENT_SOFORT_SR_REMOVE_ARTICLE_FROM_INVOICE', 'Artikel entfernen');
define('MODULE_PAYMENT_SOFORT_SR_REMOVE_FROM_INVOICE', 'Position l�schen');
define('MODULE_PAYMENT_SOFORT_SR_REMOVE_FROM_INVOICE_QUESTION', 'Sie m�chten folgende Artikel wirklich l�schen: %s ?');
define('MODULE_PAYMENT_SOFORT_SR_REMOVE_FROM_INVOICE_HINT', 'Markieren Sie Artikel um sie zu l�schen. Bei einer bereits best�tigten Rechnung f�hrt das L�schen eines Artikels zu einer Gutschrift.');
define('MODULE_PAYMENT_SOFORT_SR_REMOVE_LAST_ARTICLE_HINT', 'Durch das Reduzieren der Anzahl aller bzw. durch Entfernen des letzten Artikels wird die Rechnung komplett storniert.');

define('MODULE_PAYMENT_SOFORT_SR_PEN_CON_INV_BUYER', 'Bestellung erfolgreich �bermittelt. Best�tigung noch nicht erfolgt.');
define('MODULE_PAYMENT_SOFORT_SR_PEN_CON_INV_SELLER', 'Bestellung erfolgreich abgeschlossen - Rechnung kann best�tigt werden - Ihre Transactions-ID:');
define('MODULE_PAYMENT_SOFORT_SR_LOS_CAN_BUYER', 'Bestellung storniert.');
define('MODULE_PAYMENT_SOFORT_SR_LOS_CAN_SELLER', '');
define('MODULE_PAYMENT_SOFORT_SR_PEN_NOT_CRE_YET_BUYER', 'Bestellung best�tigt und in Bearbeitung.');
define('MODULE_PAYMENT_SOFORT_SR_PEN_NOT_CRE_YET_SELLER', 'Die Rechnung wurde best�tigt und erstellt.');
define('MODULE_PAYMENT_SOFORT_SR_REF_REF_BUYER', 'Die Rechnung wurde gutgeschrieben.');
define('MODULE_PAYMENT_SOFORT_SR_REF_REF_SELLER', 'Die Rechnung wurde gutgeschrieben. Gutschrift wurde erstellt.');
define('MODULE_PAYMENT_SOFORT_SR_TRANSLATE_INVOICE_REANIMATED', 'Die Stornierung der Rechnung wurde r�ckg�ngig gemacht.');
define('MODULE_PAYMENT_SOFORT_SR_LOS_CON_PER_EXP_BUYER', 'Bestellung storniert.');
define('MODULE_PAYMENT_SOFORT_SR_LOS_CON_PER_EXP_SELLER', 'Die Bestellung wurde storniert. Best�tigungszeitraum abgelaufen.');

define('MODULE_PAYMENT_SOFORT_SR_TRANSLATE_CURRENT_TOTAL', 'Aktueller Rechnungsbetrag:');

define('MODULE_PAYMENT_SOFORT_SR_INVOICE_CONFIRMED', 'Rechnung wurde best�tigt');
define('MODULE_PAYMENT_SOFORT_SR_TRANSLATE_TRANSACTION_ID', 'Transaktions-ID');
define('MODULE_PAYMENT_SOFORT_SR_TRANSLATE_CANCELED_REFUNDED', 'Die Rechnung wurde storniert. Gutschrift erstellt. {{time}}');
define('MODULE_PAYMENT_SOFORT_SR_TRANSLATE_CART_EDITED', 'Der Warenkorb wurde angepasst.');
define('MODULE_PAYMENT_SOFORT_SR_TRANSLATE_CART_RESET', 'Der Warenkorb wurde zur�ckgesetzt.');

define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_9000', 'Keine Rechnungs-Transaktion gefunden.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_9001', 'Die Rechnung konnte nicht best�tigt werden.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_9002', 'Die �bergebene Rechnungssumme �bersteigt das Kreditlimit.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_9003', 'Die Rechnung konnte nicht storniert werden.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_9004', 'Die Anfrage enthielt ung�ltige Warenkorbpositionen.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_9005', 'Der Warenkorb konnte nicht angepasst werden.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_9006', 'Der Zugriff zur Schnittstelle ist 30 Tage nach Zahlungseingang nicht mehr m�glich.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_9007', 'Die Rechnung wurde bereits storniert.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_9008', 'Der Betrag der �bergebenen Mehrwertsteuer ist zu hoch.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_9009', 'Die Betr�ge der �bergeben Mehrwertsteuers�tze der Artikel stehen in Konflikt zueinander.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_9010', 'Die Anpassung des Warenkorbs ist nicht m�glich.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_9011', 'Es wurde kein Kommentar f�r die Anpassung des Warenkorbs �bergeben.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_9012', 'Es k�nnen keine Positionen zum Warenkorb hinzugef�gt werden. Ebenso kann die Menge pro Rechnungsposition nicht heraufgesetzt werden. Betr�ge einzelner Positionen d�rfen den Ursprungsbetrag nicht �berschreiten.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_9013', 'Es befinden sich ausschlie�lich nichtfakturierbare Artikel im Warenkorb.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_9014', 'Die �bergebene Rechnungsnummer wird bereits verwendet.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_9015', 'Die �bergebene Nummer der Gutschrift wird bereits verwendet.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_9016', 'Die �bergebene Bestellnummer wird bereits verwendet.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_9017', 'Die Rechnung wurde bereits best�tigt.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_9018', 'Es wurden keine Daten der Rechnung angepasst.');