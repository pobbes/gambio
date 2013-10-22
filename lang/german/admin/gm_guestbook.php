<?php
/* --------------------------------------------------------------
   gm_guestbook.php 2008-08-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/
?>
<?php
define('HEADING_TITLE', 'G&auml;stebuch');
define('HEADING_SUB_TITLE', 'Gambio');

define('GM_GUESTBOOK_BLACKLIST', 'Blacklist');
define('GM_GUESTBOOK_BLACKLIST_TEXT', 'Tragen Sie hier kommagetrennt Begriffe ein, die nicht in einem Eintrag vorkommen dürfen. Möchte jemand einen Eintrag schreiben, der einen oder mehrere Begriffe dieser Blacklist enthält, wird eine Meldung ausgegeben und der Beitrag nicht gespeichert.');

define('GM_GUESTBOOK_BUTTON_UPDATE', 'Speichern');

define('GM_GUESTBOOK_CUSTOMERS_STATUS', 'Schreibrechte');
define('GM_GUESTBOOK_CUSTOMERS_STATUS_TEXT', 'Hier können Sie auswählen, welche Kundengruppen Einträge in das Gästebuch schreiben dürfen.');

define('GM_GUESTBOOK_VVCODE_TITLE', 'Anti-Spam Funktionen');
define('GM_GUESTBOOK_VVCODE_TEXT', 'Hier können Sie eine Sicherheitscodeabfrage für das Gästebuch aktivieren, die erfordert, dass vor dem Abschicken des Eintrages ein Sicherheitscode eingegeben werden muss. Dies verhindert automatische Einträge von Spam-Bots im Gästebuch.');
define('GM_GUESTBOOK_VVCODE', 'Sicherheitscodeabfrage');

define('GM_GUESTBOOK_WAITING_TIME', 'Zeit in Minuten, die vergehen muss, bevor ein neuer Eintrag von derselben Person geschrieben werden darf:');

define('GM_GUESTBOOK_MORE', 'Weitere Optionen');

define('GM_GUESTBOOK_ENTRIES_LIMIT', 'Eintr&auml;ge pro Seite');

define('GM_GUESTBOOK_ACTIVATE_ENTRIES', 'Freischaltfunktion');
define('GM_GUESTBOOK_ACTIVATE_ENTRIES_TEXT', 'Jeder Eintrag muss erst vom Shopbetreiber freigeschaltet werden, bevor der Shopbesucher diesen sehen kann.');

define('GM_GUESTBOOK_SEND_MAIL', 'E-Mail Benachrichtigung');
define('GM_GUESTBOOK_SEND_MAIL_TEXT', 'E-Mail Benachrichtigung an den Shopbetreiber senden, wenn ein neuer Eintrag geschrieben wurde.');

define('GM_GUESTBOOK_SUCCESS', 'Aktualisierung erfolgreich durchgef&uuml;hrt.');

// javascript error message
define('GM_GUESTBOOK_WAITING_TIME_ERROR', 'Die Wartezeit muss ein positiver numerischer Wert sein!');

?>