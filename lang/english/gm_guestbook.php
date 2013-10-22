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

define('GM_GUESTBOOK_NECCESSARY_INFO', '* necessary information');

define('GM_GUESTBOOK_NAME', 'Name');
define('GM_GUESTBOOK_EMAIL', 'Email');
define('GM_GUESTBOOK_HOMEPAGE', 'Homepage');
define('GM_GUESTBOOK_MESSAGE', 'Message');

define('GM_GUESTBOOK_BLACKLIST_ERROR', 'Your message contains disallowed words.');

define('GM_GUESTBOOK_CUSTOMER_STATUS_ERROR', 'You do not have permission to write an entry!');

define('GM_GUESTBOOK_DELETE', 'delete');
//JS -> keine HTML-Umlaute!
define('GM_GUESTBOOK_DELETE_QUESTION', 'Do you really want to delete this guestbook entry?');

define('GM_GUESTBOOK_ERROR', 'Please enter your name and a message.');
define('GM_GUESTBOOK_WRONG_CODE', 'Incorrect code!');

define('GM_GUESTBOOK_BUTTON_SEND', 'send');

define('GM_GUESTBOOK_VALIDATION', 'Verification code');

define('GM_GUESTBOOK_WAITING_TIME_ERROR', 'You are not allowed to write a second entry within such a short period of time.');

define('GM_GUESTBOOK_ACTIVATE','activate entry');
define('GM_GUESTBOOK_DEACTIVATE','deactivate entry');

define('GM_GUESTBOOK_DEACTIVATED_ENTRY','not activated!');

define('GM_GUESTBOOK_ENTRIES', 'Entries ');
define('GM_GUESTBOOK_TO', ' to ');
define('GM_GUESTBOOK_OF', ' of ');

define('GM_GUESTBOOK_SUCCESS_1', 'The entry has been successfully sent and will be activated shortly.<br /><br />');
define('GM_GUESTBOOK_SUCCESS_2', 'The entry has been successfully sent.<br /><br />');

define('GM_GUESTBOOK_NEW_ENTRY', 'New entry');


//Mail -> keine HTML-Umlaute!
define('GM_GUESTBOOK_NEW_ENTRY_MAIL_SUBJECT', STORE_NAME . ': new guestbook entry');
define('GM_GUESTBOOK_NEW_ENTRY_MAIL', " has written a new entry in your guestbook: " . HTTP_SERVER . DIR_WS_CATALOG . "shop_content.php?coID=13");
?>