<?php
/**
 *  Copyright 2010 KLARNA AB. All rights reserved.
 *
 *  Redistribution and use in source and binary forms, with or without modification, are
 *  permitted provided that the following conditions are met:
 *
 *     1. Redistributions of source code must retain the above copyright notice, this list of
 *        conditions and the following disclaimer.
 *
 *     2. Redistributions in binary form must reproduce the above copyright notice, this list
 *        of conditions and the following disclaimer in the documentation and/or other materials
 *        provided with the distribution.
 *
 *  THIS SOFTWARE IS PROVIDED BY KLARNA AB "AS IS" AND ANY EXPRESS OR IMPLIED
 *  WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND
 *  FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL KLARNA AB OR
 *  CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 *  CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
 *  SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
 *  ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 *  NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF
 *  ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 *  The views and conclusions contained in the software and documentation are those of the
 *  authors and should not be interpreted as representing official policies, either expressed
 *  or implied, of KLARNA AB.
 *
 */
 /* --------------------------------------------------------------
Released under the GNU General Public License (Version 2)
[http://www.gnu.org/licenses/gpl-2.0.html]
--------------------------------------------------------------
*/
include_once(DIR_FS_DOCUMENT_ROOT . 'includes/modules/klarna/klarnautils.php');
  // Translations in installer
  define('MODULE_PAYMENT_PCKLARNA_ALLOWED_TITLE', 'Erlaubt Zones');
  define('MODULE_PAYMENT_PCKLARNA_ALLOWED_DESC', 'Bitte geben Sie die Zonen getrennt, die erlaubt, dieses Modul verwenden sollten (zB AT, DE (wenn leer, bis alle Zonen erlauben wollen))');
  define('MODULE_PAYMENT_PCKLARNA_STATUS_TITLE', 'Aktivieren Klarna module');
  define('MODULE_PAYMENT_PCKLARNA_STATUS_DESC', 'Wollen Sie Klarna Zahlungen akzeptieren?');
  define('MODULE_PAYMENT_PCKLARNA_ORDER_STATUS_ID_TITLE', 'Setzen Bestell-Status');
  define('MODULE_PAYMENT_PCKLARNA_ORDER_STATUS_ID_DESC', 'Setzen Sie den Status von Bestellungen mit diesem Zahlungsmodul auf diesen Wert aus');
  define('MODULE_PAYMENT_PCKLARNA_ARTNO_TITLE', 'Produkt artno Attribut (id oder Modell)');
  define('MODULE_PAYMENT_PCKLARNA_ARTNO_DESC', 'Verwenden Sie die folgenden Produkt-Attribut für ArtNr.');

  define('MODULE_PAYMENT_PCKLARNA_ZONE_TITLE', 'Zahlung Zonen');
  define('MODULE_PAYMENT_PCKLARNA_ZONE_DESC', 'Wenn eine Zone ausgewählt ist, nur damit diese Zahlungsmethode für diese Zone.');

  define('MODULE_PAYMENT_PCKLARNA_SORT_ORDER_TITLE', 'Sortierung der Anzeige.');
  define('MODULE_PAYMENT_PCKLARNA_SORT_ORDER_DESC', 'Sortierung der Anzeige. Niedrigste wird zuerst angezeigt.');
  define('MODULE_PAYMENT_PCKLARNA_LIVEMODE_TITLE', 'Live Server');
  define('MODULE_PAYMENT_PCKLARNA_LIVEMODE_DESC', 'Wollen Sie Klarna LIVE-Server (true) oder BETA-Server (false) verwenden?');

  define('MODULE_PAYMENT_PCKLARNA_TEXT_TITLE', 'Klarna Ratenkauf');
  define('MODULE_PAYMENT_PCKLARNA_PARTPAYMENT_TEXT_TITLE', 'Klarna Ratenkauf');
  define('MODULE_PAYMENT_KLARNA_PARTPAYMENT_TEXT_TITLE', 'Klarna Ratenkauf');

  define('MODULE_PAYMENT_PCKLARNA_TEXT_DESCRIPTION', 'Ratenkauf von Klarna');
  define('MODULE_PAYMENT_PCKLARNA_TEXT_CONFIRM_DESCRIPTION', 'Ratenkauf von Klarna (<a href=\"http://www.klarna.de\">www.klarna.de</a>)');

  define('MODULE_PAYMENT_PCKLARNA_LATESTVERSION_TITLE', 'Überprüfen Sie für die neueste Version');
  define('MODULE_PAYMENT_PCKLARNA_LATESTVERSION_DESC', 'Wollen Sie zeigen eine Meldung auf dem Modul-Seite, wenn eine neuere Version dieses Moduls steht zur Verfügung?');
  define('MODULE_PAYMENT_KLARNA_PARTPAYMENT_ALLOWED_TITLE', 'Aktiviert Ländern');
  define('MODULE_PAYMENT_KLARNA_PARTPAYMENT_ALLOWED_DESC', 'Für welche Länder möchten Sie Klarna Ratenkauf anbieten? (getrennt mit Komma)');
  define('MODULE_PAYMENT_PCKLARNA_ORDER_STATUS_PENDING_ID_TITLE', 'Setzen Pending Bestellstatus');
  define('MODULE_PAYMENT_PCKLARNA_ORDER_STATUS_PENDING_ID_DESC', 'Setzen Sie den Status von Aufträgen mit dieser Zahlung Modul (mit PENDING result) gemacht, um diesen Wert');

  define('MODULE_PAYMENT_SPECKLARNA_PC_URI_TITLE', 'PClass URI');
  define('MODULE_PAYMENT_SPECKLARNA_PC_URI_DESC', 'Wo möchten Sie die Komunikation Datei zu speichern? Wird nur für JSON und XML verwendet. (Die Klarna Modul muss in der Lage sein, um diesen Ort zu schreiben, chmod 0700 erforderlich)');
  define('MODULE_PAYMENT_PCKLARNA_PC_TYPE_TITLE', 'PClass Storage');
  define('MODULE_PAYMENT_PCKLARNA_PC_TYPE_DESC', 'Welchen Protokolltyp möchten Sie zur Kommunikation mit Klarna nutzen?');

define('MODULE_PAYMENT_PCKLARNA_EID_SE_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/sv.png\" border=\'0\' /> SE Händler-ID');
  define('MODULE_PAYMENT_PCKLARNA_EID_SE_DESC', 'Schwedisch Händler-ID (estore id) für die Klarna Service nutzen (von Klarna)');
  define('MODULE_PAYMENT_PCKLARNA_SECRET_SE_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/sv.png\" border=\'0\' /> SE gemeinsamen geheimen');
  define('MODULE_PAYMENT_PCKLARNA_SECRET_SE_DESC', 'Schwedisch gemeinsames Geheimnis mit dem Klarna Service für den Einsatz (von Klarna)');
  define('MODULE_PAYMENT_PCKLARNA_ORDER_LIMIT_SE_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/sv.png\" border=\'0\' /> Kreditlimit');
  define('MODULE_PAYMENT_PCKLARNA_ORDER_LIMIT_SE_DESC', 'Nur zeigen diese Zahlung Alternative für Aufträge kleiner als der Wert unten.');

  define('MODULE_PAYMENT_PCKLARNA_EID_NO_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/nb.png\" border=\'0\' /> NO Händler-ID');
  define('MODULE_PAYMENT_PCKLARNA_EID_NO_DESC', 'Norwegischen Händler-ID (estore id) für die Klarna Service nutzen (von Klarna)');
  define('MODULE_PAYMENT_PCKLARNA_SECRET_NO_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/nb.png\" border=\'0\' /> NO gemeinsamen geheimen');
  define('MODULE_PAYMENT_PCKLARNA_SECRET_NO_DESC', 'Norwegischen gemeinsames Geheimnis mit dem Klarna Service für den Einsatz (von Klarna)');
  define('MODULE_PAYMENT_PCKLARNA_ORDER_LIMIT_NO_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/nb.png\" border=\'0\' /> Kreditlimit');
  define('MODULE_PAYMENT_PCKLARNA_ORDER_LIMIT_NO_DESC', 'Nur zeigen diese Zahlung Alternative für Aufträge kleiner als der Wert unten.');

  define('MODULE_PAYMENT_PCKLARNA_EID_DK_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/da.png\" border=\'0\' /> DK Händler-ID');
  define('MODULE_PAYMENT_PCKLARNA_EID_DK_DESC', 'Dänischen Händler-ID (estore id) für die Klarna Service nutzen (von Klarna)');
  define('MODULE_PAYMENT_PCKLARNA_SECRET_DK_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/da.png\" border=\'0\' /> DK gemeinsamen geheimen');
  define('MODULE_PAYMENT_PCKLARNA_SECRET_DK_DESC', 'Dänischen gemeinsames Geheimnis mit dem Klarna Service für den Einsatz (von Klarna)');
  define('MODULE_PAYMENT_PCKLARNA_ORDER_LIMIT_DK_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/da.png\" border=\'0\' /> Kreditlimit');
  define('MODULE_PAYMENT_PCKLARNA_ORDER_LIMIT_DK_DESC', 'Nur zeigen diese Zahlung Alternative für Aufträge kleiner als der Wert unten.');

  define('MODULE_PAYMENT_PCKLARNA_EID_FI_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/fi.png\" border=\'0\' /> FI Händler-ID');
  define('MODULE_PAYMENT_PCKLARNA_EID_FI_DESC', 'Finnische Händler-ID (estore id) für die Klarna Service nutzen (von Klarna)');
  define('MODULE_PAYMENT_PCKLARNA_SECRET_FI_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/fi.png\" border=\'0\' /> FI gemeinsamen geheimen');
  define('MODULE_PAYMENT_PCKLARNA_SECRET_FI_DESC', 'Finnische gemeinsames Geheimnis mit dem Klarna Service für den Einsatz (von Klarna)');
  define('MODULE_PAYMENT_PCKLARNA_ORDER_LIMIT_FI_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/fi.png\" border=\'0\' /> Kreditlimit');
  define('MODULE_PAYMENT_PCKLARNA_ORDER_LIMIT_FI_DESC', 'Nur zeigen diese Zahlung Alternative für Aufträge kleiner als der Wert unten.');

  define('MODULE_PAYMENT_PCKLARNA_EID_DE_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/de.png\" border=\'0\' /> DE Händler-ID');
  define('MODULE_PAYMENT_PCKLARNA_EID_DE_DESC', 'Deutsch Händler-ID (estore id) für die Klarna Service nutzen (von Klarna)');
  define('MODULE_PAYMENT_PCKLARNA_SECRET_DE_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/de.png\" border=\'0\' /> DE gemeinsamen geheimen');
  define('MODULE_PAYMENT_PCKLARNA_SECRET_DE_DESC', 'Deutsch gemeinsames Geheimnis mit dem Klarna Service für den Einsatz (von Klarna)');
  define('MODULE_PAYMENT_PCKLARNA_ORDER_LIMIT_DE_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/de.png\" border=\'0\' /> Kreditlimit');
  define('MODULE_PAYMENT_PCKLARNA_ORDER_LIMIT_DE_DESC', 'Nur zeigen diese Zahlung Alternative für Aufträge kleiner als der Wert unten.');

  define('MODULE_PAYMENT_PCKLARNA_EID_NL_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/nl.png\" border=\'0\' /> NL Händler-ID');
  define('MODULE_PAYMENT_PCKLARNA_EID_NL_DESC', 'Niederländische Händler-ID (estore id) für die Klarna Service nutzen (von Klarna)');
  define('MODULE_PAYMENT_PCKLARNA_SECRET_NL_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/nl.png\" border=\'0\' /> NL gemeinsamen geheimen');
  define('MODULE_PAYMENT_PCKLARNA_SECRET_NL_DESC', 'Niederländischen gemeinsames Geheimnis mit dem Klarna Service für den Einsatz (von Klarna)');
  define('MODULE_PAYMENT_PCKLARNA_ORDER_LIMIT_NL_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/nl.png\" border=\'0\' /> Kreditlimit');
  define('MODULE_PAYMENT_PCKLARNA_ORDER_LIMIT_NL_DESC', 'Nur zeigen diese Zahlung Alternative für Aufträge kleiner als der Wert unten.');


