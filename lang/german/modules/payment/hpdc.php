<?php
/*
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
*/

define('MODULE_PAYMENT_HPDC_TEXT_TITLE', 'Debitkarte');
define('MODULE_PAYMENT_HPDC_TEXT_DESC', 'Debitkarte &uuml;ber Heidelberger Payment GmbH');

define('MODULE_PAYMENT_HPDC_SECURITY_SENDER_TITLE', 'Sender ID');
define('MODULE_PAYMENT_HPDC_SECURITY_SENDER_DESC', 'Ihre Heidelpay Sender ID');

define('MODULE_PAYMENT_HPDC_USER_LOGIN_TITLE', 'User Login');
define('MODULE_PAYMENT_HPDC_USER_LOGIN_DESC', 'Ihr Heidelpay User Login');

define('MODULE_PAYMENT_HPDC_USER_PWD_TITLE', 'User Passwort');
define('MODULE_PAYMENT_HPDC_USER_PWD_DESC', 'Ihr Heidelpay User Passwort');

define('MODULE_PAYMENT_HPDC_TRANSACTION_CHANNEL_TITLE', 'Channel ID');
define('MODULE_PAYMENT_HPDC_TRANSACTION_CHANNEL_DESC', 'Ihre Heidelpay Channel ID');

define('MODULE_PAYMENT_HPDC_TRANSACTION_MODE_TITLE', 'Transaction Mode');
define('MODULE_PAYMENT_HPDC_TRANSACTION_MODE_DESC', 'W&auml;hlen Sie hier den Transaktionsmodus.');

define('MODULE_PAYMENT_HPDC_MODULE_MODE_TITLE', 'Modul Mode');
define('MODULE_PAYMENT_HPDC_MODULE_MODE_DESC', 'DIRECT: Die Zahldaten werden auf der Zahlverfahrenauswahl mit REGISTER Funktion erfasst (zzgl. Registrierungsgebuehr). <br>AFTER: Die Zahldaten werden nachgelagert mit DEBIT Funktion erfasst.');

define('MODULE_PAYMENT_HPDC_SAVE_REGISTER_TITLE', 'Registrierung speichern');
define('MODULE_PAYMENT_HPDC_SAVE_REGISTER_DESC', 'Wenn Sie m&ouml;chten das die Registrierungsdaten der letzten Buchung eines Kunden im Shop gespeichert werden, setzen Sie "True" und der Kunde braucht bei der zweiten Bestellung keine Zahlungsdaten mehr angeben.');

define('MODULE_PAYMENT_HPDC_DIRECT_MODE_TITLE', 'Direct Mode');
define('MODULE_PAYMENT_HPDC_DIRECT_MODE_DESC', 'Wenn Modul Mode auf DIRECT dann w&auml;hlen Sie hier ob die Zahldaten auf einer Extraseite oder in einer Lightbox eingegeben werden sollen.');

define('MODULE_PAYMENT_HPDC_PAY_MODE_TITLE', 'Payment Mode');
define('MODULE_PAYMENT_HPDC_PAY_MODE_DESC', 'W&auml;hlen Sie zwischen Debit (DB) und Preauthorisation (PA).');

define('MODULE_PAYMENT_HPDC_TEST_ACCOUNT_TITLE', 'Test Account');
define('MODULE_PAYMENT_HPDC_TEST_ACCOUNT_DESC', 'Wenn Transaction Mode nicht LIVE, sollen folgende Accounts (EMail) testen k&ouml;nnen. (Komma getrennt)');

define('MODULE_PAYMENT_HPDC_PROCESSED_STATUS_ID_TITLE', 'Bestellstatus - Erfolgreich');
define('MODULE_PAYMENT_HPDC_PROCESSED_STATUS_ID_DESC', 'Dieser Status wird gesetzt wenn die Bezahlung erfolgreich war.');

define('MODULE_PAYMENT_HPDC_PENDING_STATUS_ID_TITLE', 'Bestellstatus - Wartend');
define('MODULE_PAYMENT_HPDC_PENDING_STATUS_ID_DESC', 'Dieser Status wird gesetzt wenn die Bezahlung noch nicht komplett durchlaufen ist.');

define('MODULE_PAYMENT_HPDC_CANCELED_STATUS_ID_TITLE', 'Bestellstatus - Abbruch');
define('MODULE_PAYMENT_HPDC_CANCELED_STATUS_ID_DESC', 'Dieser Status wird gesetzt wenn die Bezahlung abgebrochen wurde.');

define('MODULE_PAYMENT_HPDC_NEWORDER_STATUS_ID_TITLE', 'Bestellstatus - Neue Bestellung');
define('MODULE_PAYMENT_HPDC_NEWORDER_STATUS_ID_DESC', 'Dieser Status wird zu Beginn der Bezahlung gesetzt.');

define('MODULE_PAYMENT_HPDC_STATUS_TITLE', 'Modul aktivieren');
define('MODULE_PAYMENT_HPDC_STATUS_DESC', 'M&ouml;chten Sie das Modul aktivieren?');

define('MODULE_PAYMENT_HPDC_SORT_ORDER_TITLE', 'Anzeigereihenfolge');
define('MODULE_PAYMENT_HPDC_SORT_ORDER_DESC', 'Reihenfolge der Anzeige. Kleinste Ziffer wird zuerst angezeigt.');

define('MODULE_PAYMENT_HPDC_ZONE_TITLE', 'Zahlungszone');
define('MODULE_PAYMENT_HPDC_ZONE_DESC', 'Wenn eine Zone ausgew&auml;hlt ist, gilt die Zahlungsmethode nur f&uuml;r diese Zone.');

define('MODULE_PAYMENT_HPDC_ALLOWED_TITLE', 'Erlaubte Zonen');
define('MODULE_PAYMENT_HPDC_ALLOWED_DESC', 'Geben Sie <b>einzeln</b> die Zonen an, welche f&uuml;r dieses Modul erlaubt sein sollen. (z.B. AT,DE (wenn leer, werden alle Zonen erlaubt))');

define('MODULE_PAYMENT_HPDC_TEXT_INFO', '');
define('MODULE_PAYMENT_HPDC_DEBUGTEXT', 'Das Zahlverfahren wird gerade gewartet. Bitte w&auml;hlen Sie ein anderes Zahlverfahren oder versuchen Sie es zu einem sp&auml;teren Zeitpunkt.');
define('MODULE_PAYMENT_HPDC_REUSE_DCARD', 'm&ouml;chten Sie folgende Debitkarte wieder verwenden?<br>KartenNr: ');
define('MODULE_PAYMENT_HPDC_WILLUSE_DCARD', 'folgende Debitkarte wird wieder verwendet.<br>KartenNr: ');
?>
