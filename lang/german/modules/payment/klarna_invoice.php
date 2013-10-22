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
  define('MODULE_PAYMENT_KLARNA_ALLOWED_TITLE', 'Erlaubt Zones');
  define('MODULE_PAYMENT_KLARNA_ALLOWED_DESC', 'Bitte geben Sie die Zonen getrennt, die erlaubt, dieses Modul verwenden sollten (zB AT, DE (wenn leer, bis alle Zonen erlauben wollen))');
  define('MODULE_PAYMENT_KLARNA_STATUS_TITLE', 'Aktivieren Klarna module');
  define('MODULE_PAYMENT_KLARNA_STATUS_DESC', 'Wollen Sie Klarna Zahlungen akzeptieren?');
  define('MODULE_PAYMENT_KLARNA_ORDER_STATUS_ID_TITLE', 'Setzen Bestell-Status');
  define('MODULE_PAYMENT_KLARNA_ORDER_STATUS_ID_DESC', 'Setzen Sie den Status von Bestellungen mit diesem Zahlungsmodul auf diesen Wert aus');
  define('MODULE_PAYMENT_KLARNA_ARTNO_TITLE', 'Produkt artno Attribut (id oder Modell)');
  define('MODULE_PAYMENT_KLARNA_ARTNO_DESC', 'Verwenden Sie die folgenden Produkt-Attribut f�r ArtNr.');

  define('MODULE_PAYMENT_KLARNA_ZONE_TITLE', 'Zahlung Zonen');
  define('MODULE_PAYMENT_KLARNA_ZONE_DESC', 'Wenn eine Zone ausgew�hlt ist, nur damit diese Zahlungsmethode f�r diese Zone.');

  define('MODULE_PAYMENT_KLARNA_SORT_ORDER_TITLE', 'Sortierung der Anzeige.');
  define('MODULE_PAYMENT_KLARNA_SORT_ORDER_DESC', 'Sortierung der Anzeige. Niedrigste wird zuerst angezeigt.');
  define('MODULE_PAYMENT_KLARNA_LIVEMODE_TITLE', 'Live Server');
  define('MODULE_PAYMENT_KLARNA_LIVEMODE_DESC', 'Wollen Sie Klarna LIVE-Server (true) oder BETA-Server (false) verwenden?');

  define('MODULE_PAYMENT_KLARNA_INVOICE_TEXT_TITLE', 'Klarna Rechnung');

  define('MODULE_PAYMENT_KLARNA_TEXT_TITLE', 'Klarna Rechnung');
  define('MODULE_PAYMENT_KLARNA_TEXT_DESCRIPTION', 'Rechnung von Klarna');
  define('MODULE_PAYMENT_KLARNA_TEXT_CONFIRM_DESCRIPTION', 'Rechnung von Klarna (<a href=\"http://www.klarna.de\">www.klarna.de</a>)');

  define('MODULE_PAYMENT_KLARNA_LATESTVERSION_TITLE', '�berpr�fen Sie f�r die neueste Version');
  define('MODULE_PAYMENT_KLARNA_LATESTVERSION_DESC', 'Wollen Sie zeigen eine Meldung auf dem Modul-Seite, wenn eine neuere Version dieses Moduls steht zur Verf�gung?');
  define('MODULE_PAYMENT_KLARNA_INVOICE_ALLOWED_TITLE', 'Aktiviert L�ndern');
  define('MODULE_PAYMENT_KLARNA_INVOICE_ALLOWED_DESC', 'F�r welche L�nder m�chten Sie Klarna Rechnung anbieten? (getrennt mit Komma)');
  define('MODULE_PAYMENT_KLARNA_ORDER_STATUS_PENDING_ID_TITLE', 'Setzen Pending Bestellstatus');
  define('MODULE_PAYMENT_KLARNA_ORDER_STATUS_PENDING_ID_DESC', 'Setzen Sie den Status von Auftr�gen mit dieser Zahlung Modul (mit PENDING result) gemacht, um diesen Wert');
  define('MODULE_PAYMENT_KLARNA_PC_URI_TITLE', 'PClass URI');
  define('MODULE_PAYMENT_KLARNA_PC_URI_DESC', 'Wo m�chten Sie die Komunikation Datei zu speichern? (Die Klarna Modul muss in der Lage sein, um diesen Ort zu schreiben, chmod 0700 erforderlich)');

  define('MODULE_PAYMENT_KLARNA_EID_SE_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/sv.png\" border=\'0\' /> SE H�ndler-ID');
  define('MODULE_PAYMENT_KLARNA_EID_SE_DESC', 'Schwedische H�ndler-ID (estore id) f�r die Klarna Service nutzen (von Klarna)');
  define('MODULE_PAYMENT_KLARNA_SECRET_SE_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/sv.png\" border=\'0\' /> SE shared secret');
  define('MODULE_PAYMENT_KLARNA_SECRET_SE_DESC', 'Schwedisch gemeinsames Geheimnis mit dem Klarna Service f�r den Einsatz (von Klarna)');
  define('MODULE_PAYMENT_KLARNA_ORDER_LIMIT_SE_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/sv.png\" border=\'0\' /> Kreditlimit');
  define('MODULE_PAYMENT_KLARNA_ORDER_LIMIT_SE_DESC', 'Nur zeigen diese Zahlung Alternative f�r Auftr�ge kleiner als der Wert unten.');

  define('MODULE_PAYMENT_KLARNA_EID_NO_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/nb.png\" border=\'0\' /> NO H�ndler-ID');
  define('MODULE_PAYMENT_KLARNA_EID_NO_DESC', 'Norwegischen H�ndler-ID (estore id) f�r die Klarna Service nutzen (von Klarna)');
  define('MODULE_PAYMENT_KLARNA_SECRET_NO_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/nb.png\" border=\'0\' /> NO shared secret');
  define('MODULE_PAYMENT_KLARNA_SECRET_NO_DESC', 'Norwegischen gemeinsames Geheimnis mit dem Klarna Service f�r den Einsatz (von Klarna)');
  define('MODULE_PAYMENT_KLARNA_ORDER_LIMIT_NO_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/nb.png\" border=\'0\' /> Kreditlimit');
  define('MODULE_PAYMENT_KLARNA_ORDER_LIMIT_NO_DESC', 'Nur zeigen diese Zahlung Alternative f�r Auftr�ge kleiner als der Wert unten.');

  define('MODULE_PAYMENT_KLARNA_EID_DK_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/da.png\" border=\'0\' /> DK H�ndler-ID');
  define('MODULE_PAYMENT_KLARNA_EID_DK_DESC', 'D�nischen H�ndler-ID (estore id) f�r die Klarna Service nutzen (von Klarna)');
  define('MODULE_PAYMENT_KLARNA_SECRET_DK_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/da.png\" border=\'0\' /> DK shared secret');
  define('MODULE_PAYMENT_KLARNA_SECRET_DK_DESC', 'D�nischen gemeinsames Geheimnis mit dem Klarna Service f�r den Einsatz (von Klarna)');
  define('MODULE_PAYMENT_KLARNA_ORDER_LIMIT_DK_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/da.png\" border=\'0\' /> Kreditlimit');
  define('MODULE_PAYMENT_KLARNA_ORDER_LIMIT_DK_DESC', 'Nur zeigen diese Zahlung Alternative f�r Auftr�ge kleiner als der Wert unten.');

  define('MODULE_PAYMENT_KLARNA_EID_FI_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/fi.png\" border=\'0\' /> FI H�ndler-ID');
  define('MODULE_PAYMENT_KLARNA_EID_FI_DESC', 'Finnische H�ndler-ID (estore id) f�r die Klarna Service nutzen (von Klarna)');
  define('MODULE_PAYMENT_KLARNA_SECRET_FI_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/fi.png\" border=\'0\' /> FI shared secret');
  define('MODULE_PAYMENT_KLARNA_SECRET_FI_DESC', 'Finnische gemeinsames Geheimnis mit dem Klarna Service f�r den Einsatz (von Klarna)');
  define('MODULE_PAYMENT_KLARNA_ORDER_LIMIT_FI_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/fi.png\" border=\'0\' /> Kreditlimit');
  define('MODULE_PAYMENT_KLARNA_ORDER_LIMIT_FI_DESC', 'Nur zeigen diese Zahlung Alternative f�r Auftr�ge kleiner als der Wert unten.');

  define('MODULE_PAYMENT_KLARNA_EID_DE_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/de.png\" border=\'0\' /> DE H�ndler-ID');
  define('MODULE_PAYMENT_KLARNA_EID_DE_DESC', 'Deutsch H�ndler-ID (estore id) f�r die Klarna Service nutzen (von Klarna)');
  define('MODULE_PAYMENT_KLARNA_SECRET_DE_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/de.png\" border=\'0\' /> DE shared secret');
  define('MODULE_PAYMENT_KLARNA_SECRET_DE_DESC', 'Deutsch gemeinsames Geheimnis mit dem Klarna Service f�r den Einsatz (von Klarna)');
  define('MODULE_PAYMENT_KLARNA_ORDER_LIMIT_DE_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/de.png\" border=\'0\' /> Kreditlimit');
  define('MODULE_PAYMENT_KLARNA_ORDER_LIMIT_DE_DESC', 'Nur zeigen diese Zahlung Alternative f�r Auftr�ge kleiner als der Wert unten.');

  define('MODULE_PAYMENT_KLARNA_EID_NL_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/nl.png\" border=\'0\' /> NL H�ndler-ID');
  define('MODULE_PAYMENT_KLARNA_EID_NL_DESC', 'Niederl�ndische H�ndler-ID (estore id) f�r die Klarna Service nutzen (von Klarna)');
  define('MODULE_PAYMENT_KLARNA_SECRET_NL_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/nl.png\" border=\'0\' /> NL shared secret');
  define('MODULE_PAYMENT_KLARNA_SECRET_NL_DESC', 'Niederl�ndischen gemeinsames Geheimnis mit dem Klarna Service f�r den Einsatz (von Klarna)');
  define('MODULE_PAYMENT_KLARNA_ORDER_LIMIT_NL_TITLE', '<img src=\"' . KlarnaUtils::getWebRoot() . 'checkout/flags/nl.png\" border=\'0\' /> Kreditlimit');
  define('MODULE_PAYMENT_KLARNA_ORDER_LIMIT_NL_DESC', 'Nur zeigen diese Zahlung Alternative f�r Auftr�ge kleiner als der Wert unten.');

