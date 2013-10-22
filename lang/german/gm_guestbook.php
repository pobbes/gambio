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
?><?php

define('GM_GUESTBOOK_NECCESSARY_INFO', '* notwendige Informationen');

define('GM_GUESTBOOK_NAME', 'Name');
define('GM_GUESTBOOK_EMAIL', 'E-Mail');
define('GM_GUESTBOOK_HOMEPAGE', 'Homepage');
define('GM_GUESTBOOK_MESSAGE', 'Nachricht');

define('GM_GUESTBOOK_BLACKLIST_ERROR', 'Ihre Nachricht enth&auml;lt unerlaubte W&ouml;rter.');

define('GM_GUESTBOOK_CUSTOMER_STATUS_ERROR', 'Sie haben keine Schreibrechte!');

define('GM_GUESTBOOK_DELETE', 'l&ouml;schen');
//JS -> keine HTML-Umlaute!
define('GM_GUESTBOOK_DELETE_QUESTION', 'Wollen Sie den Gästebucheintrag wirklich löschen?');

define('GM_GUESTBOOK_ERROR', 'Bitte geben Sie Ihren Namen und eine Nachricht an.');
define('GM_GUESTBOOK_WRONG_CODE', 'Inkorrekter Code!');

define('GM_GUESTBOOK_BUTTON_SEND', 'absenden');

define('GM_GUESTBOOK_VALIDATION', 'Sicherheitscode');

define('GM_GUESTBOOK_WAITING_TIME_ERROR', 'Sie d&uuml;rfen nicht in einem so kurzen Zeitraum erneut einen Eintrag schreiben.');

define('GM_GUESTBOOK_ACTIVATE','Eintrag freischalten');
define('GM_GUESTBOOK_DEACTIVATE','Eintrag sperren');

define('GM_GUESTBOOK_DEACTIVATED_ENTRY','nicht freigeschaltet!');

define('GM_GUESTBOOK_ENTRIES', 'Eintr&auml;ge ');
define('GM_GUESTBOOK_TO', ' bis ');
define('GM_GUESTBOOK_OF', ' von ingesamt ');

define('GM_GUESTBOOK_SUCCESS_1', 'Der Eintrag wurde erfolgreich versendet und wird in K&uuml;rze freigeschaltet.<br /><br />');
define('GM_GUESTBOOK_SUCCESS_2', 'Der Eintrag wurde erfolgreich in das G&auml;stebuch aufgenommen.<br /><br />');

define('GM_GUESTBOOK_NEW_ENTRY', 'Neuer Eintrag');


//Mail -> keine HTML-Umlaute!
define('GM_GUESTBOOK_NEW_ENTRY_MAIL_SUBJECT', STORE_NAME . ': neuer Gästebucheintrag');
define('GM_GUESTBOOK_NEW_ENTRY_MAIL', " hat einen neuen Eintrag in Ihr Gästebuch geschrieben: " . HTTP_SERVER . DIR_WS_CATALOG . "shop_content.php?coID=13");
?>