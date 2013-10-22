<?php
/**
 * @version SOFORT Gateway 5.2.0 - $Date: 2012-11-30 15:49:06 +0100 (Fri, 30 Nov 2012) $
 * @author SOFORT AG (integration@sofort.com)
 * @link http://www.sofort.com/
 *
 * Copyright (c) 2012 SOFORT AG
 * 
 * Released under the GNU General Public License (Version 2)
 * [http://www.gnu.org/licenses/gpl-2.0.html]
 *
 * $Id: sofort_ideal.php 5815 2012-11-30 14:49:06Z rotsch $
 */

//include language-constants for used in all Multipay Projects - NOTICE: iDEAL is not Multipay
require_once 'sofort_general.php';

define('MODULE_PAYMENT_SOFORT_IDEAL_TEXT_TITLE', 'iDEAL'); //needed by core
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_TEXT_TITLE', 'iDEAL <br /><img src="https://images.sofort.com/de/ideal/logo_90x30.png" alt="Logo iDEAL"/>');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_RECOMMENDED_PAYMENT_TEXT', '(Empfohlene Zahlungsweise)');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_TEXT_DESCRIPTION', '<b>iDEAL</b><br />Sobald der Kunde diese Zahlungsart und seine Bank ausgew�hlt hat, wird er durch die SOFORT AG auf seine Bank weitergeleitet. Dort t�tigt er seine Zahlung und wird danach wieder auf das Shopsystem zur�ckgeleitet. Bei erfolgreicher Zahlungsbest�tigung findet durch die SOFORT AG ein sog. Callback auf das Shopsystem statt, der den Zahlungsstatus der Bestellung entsprechend �ndert.<br />Bereitgestellt durch die SOFORT AG');

//all shopsystem-params
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_STATUS_TITLE', 'iDEAL - sofort.de Modul aktivieren');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_RECOMMENDED_PAYMENT_TITLE', 'Empfohlene Zahlungsweise');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_AUTH_TITLE', 'Konfigurationsschl�ssel/API-Key testen');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_AUTH_DESC', "<script>function t(){k = document.getElementsByName(\"configuration[MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_CONFIGURATION_KEY]\")[0].value;window.open(\"../callback/sofort/testAuth.php?k=\"+k);}</script><input type=\"button\" onclick=\"t()\" value=\"Test\" />");  //max 255 signs
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_ZONE_TITLE' , MODULE_PAYMENT_SOFORT_MULTIPAY_ZONE_TITLE);
define('MODULE_PAYMENT_SOFORT_IDEAL_ALLOWED_TITLE' , 'Zahlungszone');
define('MODULE_PAYMENT_SOFORT_IDEAL_ALLOWED_DESC' , 'Geben Sie <b>einzeln</b> die Zonen an, welche f�r dieses Modul erlaubt sein sollen. (z.B. AT,DE (wenn leer, werden alle Zonen erlaubt))');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_TMP_STATUS_ID_TITLE' , 'Tempor�rer Bestellstatus');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_ORDER_STATUS_ID_TITLE', 'Best�tigter Bestellstatus');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_LAT_SUC_AUT_STATUS_ID_TITLE', 'Automatische Stornierung mit R�ckbuchung');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_REF_COM_STATUS_ID_TITLE', 'Teilerstattung');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_REF_REF_STATUS_ID_TITLE', 'Vollst�ndige Erstattung');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_CANCELED_ORDER_STATUS_ID_TITLE', 'Bestellstatus bei abgebrochener Zahlung');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_LOS_NOT_CRE_STATUS_ID_TITLE', 'Bestellstatus bei kompletter Stornierung');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_SORT_ORDER_TITLE', 'Anzeigereihenfolge');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_CONFIGURATION_KEY_TITLE', 'Von SOFORT AG zugewiesener Konfigurationsschl�ssel');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_PROJECT_PASSWORD_TITLE', 'Projekt-Passwort');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_NOTIFICATION_PASSWORD_TITLE', 'Benachrichtigungs-Passwort');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_REASON_1_TITLE', 'Verwendungszweck 1');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_REASON_2_TITLE', 'Verwendungszweck 2');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_IMAGE_TITLE', 'Logo+Text');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_STATUS_DESC', 'Aktiviert/deaktiviert das komplette Modul');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_RECOMMENDED_PAYMENT_DESC', 'iDEAL zur empfohlenen Zahlungsmethode machen');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_ZONE_DESC', 'Wenn eine Zone ausgew�hlt ist, gilt die Zahlungsmethode nur f�r diese Zone.');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_TMP_STATUS_ID_DESC', 'Bestellstatus f�r nicht abgeschlossene Transaktionen. Die Bestellung wurde erstellt aber die Transaktion von der SOFORT AG noch nicht best�tigt.');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_ORDER_STATUS_ID_DESC', 'Best�tigter Bestellstatus<br />Bestellstatus nach abgeschlossener Transaktion.');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_LOS_NOT_CRE_STATUS_ID_DESC', 'Bestellstatus bei kompletter Stornierung.');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_CANCELED_ORDER_STATUS_ID_DESC', 'Bestellstatus bei Bestellungen, die w�hrend des Bezahlvorgangs abgebrochen wurden.');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_LAT_SUC_AUT_STATUS_ID_DESC', 'Status f�r Bestellungen, bei denen der Geldeingang nach Ablauf des im SOFORT-Projekt festgelegten Timeouts festgestellt wurde und die aus diesem Grund automatisch storniert wurden. Die R�ckbuchung auf das K�uferkonto wird ebenfalls automatisch angewiesen.');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_REF_COM_STATUS_ID_DESC', 'Status f�r Bestellungen, bei denen ein Teilbetrag an den K�ufer zur�ckerstattet wurde.');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_REF_REF_STATUS_ID_DESC', 'Status f�r Bestellungen, bei denen der vollst�ndige Betrag an den K�ufer zur�ckerstattet wurde.');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_SORT_ORDER_DESC', 'Reihenfolge der Anzeige. Kleinste Ziffer wird zuerst angezeigt.');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_CONFIGURATION_KEY_DESC', 'Von SOFORT AG zugewiesener Konfigurationsschl�ssel');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_PROJECT_PASSWORD_DESC', 'Von SOFORT AG zugewiesenes Projekt-Passwort');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_NOTIFICATION_PASSWORD_DESC', 'Von SOFORT AG zugewiesenes Benachrichtigungs-Passwort');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_REASON_1_DESC', 'Verwendungszweck 1');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_REASON_2_DESC', 'Verwendungszweck 2');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_IMAGE_DESC', 'Banner oder Text bei der Auswahl der Zahlungsoptionen');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_CHECKOUT_TEXT', 'iDEAL.nl - Online-�berweisungen f�r den elektronischen Handel in den Niederlanden. F�r die Bezahlung mit iDEAL ben�tigen Sie ein Konto bei einer der genannten Banken. Sie nehmen die �berweisung direkt bei Ihrer Bank vor. Dienstleistungen/Waren werden bei Verf�gbarkeit SOFORT geliefert bzw. versendet!');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_TEXT_DESCRIPTION_CHECKOUT_PAYMENT_IMAGEALT', 'iDEAL.nl - Online-�berweisungen f�r den elektronischen Handel in den Niederlanden. F�r die Bezahlung mit iDEAL ben�tigen Sie ein Konto bei einer der genannten Banken. Sie nehmen die �berweisung direkt bei Ihrer Bank vor. Dienstleistungen/Waren werden bei Verf�gbarkeit SOFORT geliefert bzw. versendet!');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_TMP_COMMENT', 'iDEAL als Zahlungsart gew�hlt. Transaktion nicht abgeschlossen.');

define('MODULE_PAYMENT_SOFORT_IDEAL_PEN_NOT_CRE_YET_BUYER', 'Bestellung erfolgreich �bermittelt. {{time}}');
define('MODULE_PAYMENT_SOFORT_IDEAL_REC_CRE_BUYER', '{{paymentMethodStr}} - Geld ist eingegangen. {{time}}');
define('MODULE_PAYMENT_SOFORT_IDEAL_LOS_NOT_CRE_YET_BUYER', 'Die Bezahlung wurde storniert.');
define('MODULE_PAYMENT_SOFORT_IDEAL_LAT_SUC_AUT_BUYER', 'Transaktion wurde automatisch storniert. R�ckbuchung auf K�uferkonto wurde angewiesen.');
define('MODULE_PAYMENT_SOFORT_IDEAL_REF_COM_BUYER', 'Ein Teil des Betrages wird erstattet.');
define('MODULE_PAYMENT_SOFORT_IDEAL_REF_REF_BUYER', 'Rechnungsbetrag wird zur�ckerstattet. {{time}}');

//////////////////////////////////////////////////////////////////////////////////////////////

define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_TEXT_DESCRIPTION_CHECKOUT_PAYMENT_TEXT', 'iDEAL.nl - Online-�berweisungen f�r den elektronischen Handel in den Niederlanden. F�r die Bezahlung mit iDEAL ben�tigen Sie ein Konto bei einer der genannten Banken. Sie nehmen die �berweisung direkt bei Ihrer Bank vor. Dienstleistungen/Waren werden bei Verf�gbarkeit SOFORT geliefert bzw. versendet!');

define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_TEXT_ERROR_HEADING', 'Folgender Fehler wurde w�hrend des Prozesses gemeldet:');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_10000', 'Bitte w�hlen Sie vor dem Absenden eine Bank aus!');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_ERROR_ALL_CODES', 'Fehler bei der Daten�bertragung, w�hlen Sie eine andere Zahlart oder kontaktieren Sie den Shopbetreiber.');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_ERROR_DEFAULT', 'Fehler bei der Daten�bertragung, w�hlen Sie eine andere Zahlart oder kontaktieren Sie den Shopbetreiber.');

define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_IDEALSELECTED_PENDING' , 'iDEAL als Zahlungsart gew�hlt. Transaktion nicht abgeschlossen.');

define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_TEXT_DESCRIPTION_CHECKOUT_PAYMENT_SELECTBOX_TITLE', 'Bitte w�hlen Sie Ihre Bank aus');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_TEXT_DESCRIPTION_CHECKOUT_PAYMENT_IMAGE', '
    <table border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="top"><a href="http://www.ideal.nl" target="_blank">{{image}}</a></td>
        <td style="padding-left: 20px;">{{text}}</td>
      </tr>
    </table>');

define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_CHECKOUT_CONFIRMATION', '
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="main">
      	<p>Nach Best�tigung der Bestellung werden Sie zum Zahlungssytem Ihrer gew�hlten Bank weitergeleitet und k�nnen dort die Online-�berweisung duchf�hren.</p><p>Hierf�r ben�tigen Sie Ihre eBanking Zugangsdaten, d.h. Bankverbindung, Kontonummer, PIN und TAN. Mehr Informationen finden Sie hier: <a href=http://www.ideal.nl" target="_blank">iDEAL.nl</a></p>"
      </td>
    </tr>
  </table>');