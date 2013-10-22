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

define('MODULE_PAYMENT_SOFORT_SV_CHECKOUT_CONDITIONS_WITH_LIGHTBOX', '<a href="https://documents.sofort.com/de/sv/privacy_de" target="_blank">Ich habe die Datenschutzhinweise gelesen.</a>');
define('MODULE_PAYMENT_SOFORT_SV_CHECKOUT_CONDITIONS', '
	<script type="text/javascript">
		function showSvConditions() {
			svOverlay = new sofortOverlay(jQuery(".svOverlay"), "callback/sofort/ressources/scripts/getContent.php", "https://documents.sofort.com/de/sv/privacy_de");
			svOverlay.trigger();
		}
	</script>
	<noscript>
		<a href="https://documents.sofort.com/de/sv/privacy_de" target="_blank">Ich habe die Datenschutzhinweise gelesen.</a>
	</noscript>
	<!-- comSeo-Ajax-Checkout-Bugfix: show also div, when buyer doesnt use JS -->
	<div>
		<a id="svNotice" href="javascript:void(0)" onclick="showSvConditions()">Ich habe die Datenschutzhinweise gelesen.</a>
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
		svOverlay = new sofortOverlay(jQuery("#svExtraDesc"), "'.DIR_WS_CATALOG.'callback/sofort/ressources/scripts/getContent.php", "https://documents.sofort.com/vbs/shopinfo/de");
	</script>
');

define('MODULE_PAYMENT_SOFORT_SOFORTVORKASSE_TEXT_TITLE', 'Vorkasse by SOFORT <br /> <img src="https://images.sofort.com/de/sv/logo_90x30.png" alt="Logo Vorkasse by SOFORT"/>');
define('MODULE_PAYMENT_SOFORT_SV_TEXT_TITLE', 'Vorkasse');
define('MODULE_PAYMENT_SOFORT_SV_KS_TEXT_TITLE', 'Vorkasse mit Käuferschutz');
define('MODULE_PAYMENT_SOFORT_SV_LOGO_HTML', '<img src="https://images.sofort.com/de/sv/logo_90x30.png" alt="Logo Vorkasse by SOFORT"/>');
define('MODULE_PAYMENT_SOFORT_SV_TEXT_ERROR_MESSAGE', 'Die gewählte Zahlart ist leider nicht möglich oder wurde auf Kundenwunsch abgebrochen. Bitte wählen Sie eine andere Zahlweise.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_SV', 'Die gewählte Zahlart ist leider nicht möglich oder wurde auf Kundenwunsch abgebrochen. Bitte wählen Sie eine andere Zahlweise.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_SV_CHECKOUT_TEXT', '');
define('MODULE_PAYMENT_SOFORT_SV_TEXT_DESCRIPTION', 'Vorkasse mit automatisiertem Zahlungsabgleich.');
define('MODULE_PAYMENT_SOFORT_SOFORTVORKASSE_ALLOWED_TITLE', 'Erlaubte Zonen');
define('MODULE_PAYMENT_SOFORT_SOFORTVORKASSE_ALLOWED_DESC', 'Geben Sie <b>einzeln</b> die Zonen an, welche für dieses Modul erlaubt sein sollen. (z.B. AT,DE (wenn leer, werden alle Zonen erlaubt))');
define('MODULE_PAYMENT_SOFORT_SV_ZONE_TITLE', MODULE_PAYMENT_SOFORT_MULTIPAY_ZONE_TITLE);
define('MODULE_PAYMENT_SOFORT_SV_ZONE_DESC', MODULE_PAYMENT_SOFORT_MULTIPAY_ZONE_DESC);
define('MODULE_PAYMENT_SOFORT_SV_SORT_ORDER_TITLE', 'Anzeigereihenfolge');
define('MODULE_PAYMENT_SOFORT_SV_SORT_ORDER_DESC', 'Reihenfolge der Anzeige. Kleinste Ziffer wird zuerst angezeigt.');
define('MODULE_PAYMENT_SOFORT_SV_STATUS_TITLE', 'sofort.de Modul aktivieren');
define('MODULE_PAYMENT_SOFORT_SV_STATUS_DESC', 'Aktiviert/deaktiviert das komplette Modul');
define('MODULE_PAYMENT_SOFORT_SV_TMP_COMMENT', 'Vorkasse by SOFORT als Zahlungsart gewählt. Transaktion nicht abgeschlossen.');
define('MODULE_PAYMENT_SOFORT_SV_TMP_COMMENT_SELLER', 'Weiterleitung zu SOFORT - Bezahlung noch nicht erfolgt.');
define('MODULE_PAYMENT_SOFORT_SV_REASON_2_TITLE','Verwendungszweck 2');
define('MODULE_PAYMENT_SOFORT_SV_REASON_2_DESC','Im Verwendungszweck (maximal 27 Zeichen) werden folgende Platzhalter ersetzt:<br />{{transaction_id}}<br />{{order_date}}<br />{{customer_id}}<br />{{customer_name}}<br />{{customer_company}}<br />{{customer_email}}');

define('MODULE_PAYMENT_SOFORT_SV_PEN_WAI_FOR_MON_STATUS_ID_TITLE', 'Bisher kein Geldeingang');
define('MODULE_PAYMENT_SOFORT_SV_PEN_WAI_FOR_MON_STATUS_ID_DESC', 'Bestellstatus für abgeschlossene Bestellungen mit Vorkasse by SOFORT. Der Geldeingang ist bisher nicht erfolgt.');  // (pending-wait_for_money)

define('MODULE_PAYMENT_SOFORT_SV_REC_CRE_STATUS_ID_TITLE', 'Bestätigter Bestellstatus');
define('MODULE_PAYMENT_SOFORT_SV_REC_CRE_STATUS_ID_DESC', 'Bestätigter Bestellstatus<br />Bestellstatus nach Geldeingang.'); // (received-credited)

define('MODULE_PAYMENT_SOFORT_SV_LOS_NOT_CRE_STATUS_ID_TITLE', 'Kein Geldeingang');
define('MODULE_PAYMENT_SOFORT_SV_LOS_NOT_CRE_STATUS_ID_DESC', 'Status für Bestellungen, wo kein Geldeingang festgestellt werden konnte. Diese Zeitspanne kann im SOFORT-Projekt eingestellt werden.'); // (loss-not_credited)

define('MODULE_PAYMENT_SOFORT_SV_WRONG_AMOUNT_STATUS_ID_TITLE', 'Fehlerhafter Zahlbetrag');
define('MODULE_PAYMENT_SOFORT_SV_WRONG_AMOUNT_STATUS_ID_DESC', 'Status für Bestellungen bei denen der eingegangene Betrag von dem geforderten Betrag abweicht.'); // (received-overpayment, received-partially_credited)

define('MODULE_PAYMENT_SOFORT_SV_REF_COM_STATUS_ID_TITLE', 'Teilerstattung');
define('MODULE_PAYMENT_SOFORT_SV_REF_COM_STATUS_ID_DESC', 'Status für Bestellungen, bei denen ein Teilbetrag an den Käufer zurückerstattet wurde.'); // (refunded-compensation)

define('MODULE_PAYMENT_SOFORT_SV_REF_REF_STATUS_ID_TITLE', 'Vollständige Erstattung');
define('MODULE_PAYMENT_SOFORT_SV_REF_REF_STATUS_ID_DESC', 'Status für Bestellungen, bei denen der vollständige Betrag an den Käufer zurückerstattet wurde.');  // (refunded-refunded)

define('MODULE_PAYMENT_SOFORT_SV_RECOMMENDED_PAYMENT_TITLE', 'Empfohlene Zahlungsweise');
define('MODULE_PAYMENT_SOFORT_SV_RECOMMENDED_PAYMENT_DESC', 'Diese Zahlart als "empfohlene Zahlungsart" markieren. Auf der Bezahlseite erfolgt ein Hinweis direkt hinter der Zahlungsart.');
define('MODULE_PAYMENT_SOFORT_SV_RECOMMENDED_PAYMENT_TEXT', '(Empfohlene Zahlungsweise)');

define('MODULE_PAYMENT_SOFORT_SV_KS_STATUS_TITLE', 'Käuferschutz aktiviert');
define('MODULE_PAYMENT_SOFORT_SV_KS_STATUS_DESC', 'Käuferschutz für Vorkasse by SOFORT aktivieren');
define('MODULE_PAYMENT_SOFORT_SV_KS_STATUS_TEXT', 'Käuferschutz aktiviert');

define('MODULE_PAYMENT_SOFORT_SV_CHECKOUT_HEADING_TEXT', 'Kontoverbindung');
define('MODULE_PAYMENT_SOFORT_SV_CHECKOUT_TEXT', 'Bitte benutzen Sie folgende Überweisungdaten:');
define('MODULE_PAYMENT_SOFORT_SV_CHECKOUT_HOLDER_TEXT', 'Kontoinhaber:');
define('MODULE_PAYMENT_SOFORT_SV_CHECKOUT_ACCOUNT_NUMBER_TEXT', 'Kontonummer:');
define('MODULE_PAYMENT_SOFORT_SV_CHECKOUT_BANK_CODE_TEXT', 'BLZ:');
define('MODULE_PAYMENT_SOFORT_SV_CHECKOUT_IBAN_TEXT', 'IBAN:');
define('MODULE_PAYMENT_SOFORT_SV_CHECKOUT_BIC_TEXT', 'BIC:');
define('MODULE_PAYMENT_SOFORT_SV_CHECKOUT_AMOUNT_TEXT', 'Betrag:');
define('MODULE_PAYMENT_SOFORT_SV_CHECKOUT_REASON_1_TEXT', 'Verwendungszweck:');
define('MODULE_PAYMENT_SOFORT_SV_CHECKOUT_REASON_2_TEXT', '');
define('MODULE_PAYMENT_SOFORT_SV_CHECKOUT_REASON_HINT','Bitte achten Sie darauf, bei der Überweisung den hier angegebenen Verwendungszweck zu übernehmen, damit wir Ihre Zahlung zuordnen können.');

define('MODULE_PAYMENT_SOFORT_SV_PEN_WAI_FOR_MON_SELLER', 'Warte auf Geldeingang. Transaktions-ID: {{tId}} {{time}}');
define('MODULE_PAYMENT_SOFORT_SV_PEN_WAI_FOR_MON_BUYER', 'Bestellung erfolgreich. Warte auf Geldeingang');
define('MODULE_PAYMENT_SOFORT_SV_REC_CRE_SELLER', 'Geldeingang auf Konto');
define('MODULE_PAYMENT_SOFORT_SV_REC_CRE_BUYER', 'Geldeingang');
define('MODULE_PAYMENT_SOFORT_SV_REC_CON_PRO_SELLER', 'Geldeingang auf Konto');
define('MODULE_PAYMENT_SOFORT_SV_REC_CON_PRO_BUYER', '');
define('MODULE_PAYMENT_SOFORT_SV_REC_OVE_SELLER', '');
define('MODULE_PAYMENT_SOFORT_SV_REC_OVE_BUYER', 'Der eingegangene Betrag weicht von dem geforderten Betrag ab.');
define('MODULE_PAYMENT_SOFORT_SV_REC_PAR_CRE_SELLER', '');
define('MODULE_PAYMENT_SOFORT_SV_REC_PAR_CRE_BUYER', 'Der eingegangene Betrag weicht von dem geforderten Betrag ab.');
define('MODULE_PAYMENT_SOFORT_SV_REF_COM_SELLER', 'Ein Teil des Rechnungsbetrages wird zurückerstattet. Insgesamt zurückgebuchter Betrag: {{refunded_amount}}. {{time}}');
define('MODULE_PAYMENT_SOFORT_SV_REF_COM_BUYER', 'Ein Teil des Betrages wird erstattet.');
define('MODULE_PAYMENT_SOFORT_SV_REF_REF_SELLER', '');
define('MODULE_PAYMENT_SOFORT_SV_REF_REF_BUYER', 'Rechnungsbetrag wird zurückerstattet. {{time}}');
define('MODULE_PAYMENT_SOFORT_SV_LOS_NOT_CRE_SELLER', '');
define('MODULE_PAYMENT_SOFORT_SV_LOS_NOT_CRE_BUYER', 'Der Zahlungseingang konnte bis dato noch nicht festgestellt werden. {{time}}');
?>