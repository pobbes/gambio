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
 * $Id: sofort_sofortlastschrift.php 5725 2012-11-21 11:09:39Z rotsch $
 */

//include language-constants used in all Multipay Projects
require_once 'sofort_general.php';

define('MODULE_PAYMENT_SOFORT_SL_TEXT_DESCRIPTION_EXTRA', 
	MODULE_PAYMENT_SOFORT_MULTIPAY_JS_LIBS.'
	<div id="slExtraDesc">
		<div class="content" style="display:none;"></div>
	</div>
	<script type="text/javascript">
		slOverlay = new sofortOverlay(jQuery("#slExtraDesc"), "'.DIR_WS_CATALOG.'callback/sofort/ressources/scripts/getContent.php", "https://documents.sofort.com/sl/shopinfo/de");
	</script>
');

define('MODULE_PAYMENT_SOFORT_SOFORTLASTSCHRIFT_TEXT_TITLE', 'SOFORT Lastschrift <br /><img src="https://images.sofort.com/de/sl/logo_90x30.png" alt="Logo SOFORT Lastschrift"/>');
define('MODULE_PAYMENT_SOFORT_SL_TEXT_TITLE', 'SOFORT Lastschrift');
define('MODULE_PAYMENT_SOFORT_SL_LOGO_HTML', '<img src="https://images.sofort.com/de/sl/logo_90x30.png" alt="Logo SOFORT Lastschrift"/>');
define('MODULE_PAYMENT_SOFORT_SL_TEXT_ERROR_MESSAGE', 'Die gewählte Zahlart ist leider nicht möglich oder wurde auf Kundenwunsch abgebrochen. Bitte wählen Sie eine andere Zahlweise.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_SL', 'Die gewählte Zahlart ist leider nicht möglich oder wurde auf Kundenwunsch abgebrochen. Bitte wählen Sie eine andere Zahlweise.');
define('MODULE_PAYMENT_SOFORT_SL_CHECKOUT_TEXT', '<ul><li>Zahlungssystem mit TÜV-geprüftem Datenschutz</li><li>Keine Registrierung notwendig</li><li>Ware/Dienstleistung kann SOFORT versendet werden</li><li>Bitte halten Sie Ihre Online-Banking-PIN bereit</li></ul>');
define('MODULE_PAYMENT_SOFORT_SL_SORT_ORDER_TITLE', 'Anzeigereihenfolge');
define('MODULE_PAYMENT_SOFORT_SL_SORT_ORDER_DESC', 'Reihenfolge der Anzeige. Kleinste Ziffer wird zuerst angezeigt.');
define('MODULE_PAYMENT_SOFORT_SL_STATUS_TITLE', 'sofort.de Modul aktivieren');
define('MODULE_PAYMENT_SOFORT_SL_STATUS_DESC', 'Aktiviert/deaktiviert das komplette Modul');
define('MODULE_PAYMENT_SOFORT_SL_TEXT_DESCRIPTION', 'Das sichere Lastschriftverfahren der SOFORT AG.');
define('MODULE_PAYMENT_SOFORT_SL_TEXT_ERROR_HEADING', 'Fehler bei der Bestellung aufgetreten.');

define('MODULE_PAYMENT_SOFORT_SL_TEXT_DESCRIPTION_CHECKOUT_PAYMENT_IMAGE', '<table border="0" cellspacing="0" cellpadding="0"><tr><td valign="bottom">
<a onclick="javascript:window.open(\'https://images.sofort.com/de/sl/landing.php\',\'Kundeninformationen\',\'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1020, height=900\');" style="float:left; width:auto; cursor:pointer;">
{{image}}
</a></td><td rowspan="2" width="30px">&nbsp;</td><td rowspan="2">
</td>      </tr>      <tr> <td class="main">{{text}}</td>      </tr>      </table>');

define('MODULE_PAYMENT_SOFORT_SL_TEXT_DESCRIPTION_CHECKOUT_PAYMENT_IMAGEALT', 'SOFORT Lastschrift');

define('MODULE_PAYMENT_SOFORT_SOFORTLASTSCHRIFT_ALLOWED_TITLE', 'Erlaubte Zonen');
define('MODULE_PAYMENT_SOFORT_SOFORTLASTSCHRIFT_ALLOWED_DESC', 'Geben Sie <b>einzeln</b> die Zonen an, welche für dieses Modul erlaubt sein sollen. (z.B. AT,DE (wenn leer, werden alle Zonen erlaubt))');
define('MODULE_PAYMENT_SOFORT_SL_ZONE_TITLE', MODULE_PAYMENT_SOFORT_MULTIPAY_ZONE_TITLE);
define('MODULE_PAYMENT_SOFORT_SL_ZONE_DESC', MODULE_PAYMENT_SOFORT_MULTIPAY_ZONE_DESC);

define('MODULE_PAYMENT_SOFORT_SL_PEN_NOT_CRE_YET_STATUS_ID_TITLE', 'Bestätigter Bestellstatus');
define('MODULE_PAYMENT_SOFORT_SL_PEN_NOT_CRE_YET_STATUS_ID_DESC', 'Bestätigter Bestellstatus<br />Bestellstatus nach abgeschlossener Transaktion.'); // (pending-not_credited_yet)

define('MODULE_PAYMENT_SOFORT_SL_LOS_REJ_STATUS_ID_TITLE', 'Rücklastschrift');
define('MODULE_PAYMENT_SOFORT_SL_LOS_REJ_STATUS_ID_DESC', 'Status für Bestellungen, bei denen eine Rücklastschrift vorliegt.'); // (loss-rejected)

define('MODULE_PAYMENT_SOFORT_SL_REC_CRE_STATUS_ID_TITLE', 'Geldeingang');
define('MODULE_PAYMENT_SOFORT_SL_REC_CRE_STATUS_ID_DESC', 'Status für Bestellungen, wenn das Geld auf dem Konto der SOFORT Bank angekommen ist.'); // (received-credited)

define('MODULE_PAYMENT_SOFORT_SL_REF_COM_STATUS_ID_TITLE', 'Teilerstattung');
define('MODULE_PAYMENT_SOFORT_SL_REF_COM_STATUS_ID_DESC', 'Status für Bestellungen, bei denen ein Teilbetrag an den Käufer zurückerstattet wurde.');  // (refunded-compensation)

define('MODULE_PAYMENT_SOFORT_SL_REF_REF_STATUS_ID_TITLE', 'Vollständige Erstattung');
define('MODULE_PAYMENT_SOFORT_SL_REF_REF_STATUS_ID_DESC', 'Status für Bestellungen, bei denen der vollständige Betrag an den Käufer zurückerstattet wurde.'); // (refunded-refunded)

define('MODULE_PAYMENT_SOFORT_SL_TMP_COMMENT', 'SOFORT Lastschrift als Zahlungsart gewählt. Transaktion nicht abgeschlossen.');
define('MODULE_PAYMENT_SOFORT_SL_TMP_COMMENT_SELLER', 'Weiterleitung zu SOFORT - Bezahlung noch nicht erfolgt.');

define('MODULE_PAYMENT_SOFORT_SL_RECOMMENDED_PAYMENT_TITLE', 'Empfohlene Zahlungsweise');
define('MODULE_PAYMENT_SOFORT_SL_RECOMMENDED_PAYMENT_DESC', 'Diese Zahlart als "empfohlene Zahlungsart" markieren. Auf der Bezahlseite erfolgt ein Hinweis direkt hinter der Zahlungsart.');
define('MODULE_PAYMENT_SOFORT_SL_RECOMMENDED_PAYMENT_TEXT', '(Empfohlene Zahlungsweise)');

define('MODULE_PAYMENT_SOFORT_SL_PEN_NOT_CRE_YET_SELLER', 'Bestellung erfolgreich abgeschlossen - Lastschrifteinzug wird durchgeführt. Ihre Transaktions-ID: {{tId}}');
define('MODULE_PAYMENT_SOFORT_SL_PEN_NOT_CRE_YET_BUYER', 'Bestellung erfolgreich.');
define('MODULE_PAYMENT_SOFORT_SL_REC_CRE_SELLER', 'Geldeingang auf Konto');
define('MODULE_PAYMENT_SOFORT_SL_REC_CRE_BUYER', '');
define('MODULE_PAYMENT_SOFORT_SL_LOS_REJ_SELLER', '');
define('MODULE_PAYMENT_SOFORT_SL_LOS_REJ_BUYER', 'Zu dieser Transaktion liegt eine Rücklastschrift vor. {{time}}');
define('MODULE_PAYMENT_SOFORT_SL_REF_COM_SELLER', 'Ein Teil des Rechnungsbetrages wird zurückerstattet. Insgesamt zurückgebuchter Betrag: {{refunded_amount}}. {{time}}');
define('MODULE_PAYMENT_SOFORT_SL_REF_COM_BUYER', 'Ein Teil des Betrages wird erstattet.');
define('MODULE_PAYMENT_SOFORT_SL_REF_REF_SELLER', '');
define('MODULE_PAYMENT_SOFORT_SL_REF_REF_BUYER', 'Rechnungsbetrag wird zurückerstattet. {{time}}');
?>