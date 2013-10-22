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
define('HEADING_TITLE', 'Guestbook');
define('HEADING_SUB_TITLE', 'Gambio');

define('GM_GUESTBOOK_BLACKLIST', 'Blacklist');
define('GM_GUESTBOOK_BLACKLIST_TEXT', 'Please enter the words (comma separated) that should not be contained in an entry. If a user writes an entry containing one or more words on the blacklist, a warning message will appear and the entry will not be published.');

define('GM_GUESTBOOK_BUTTON_UPDATE', 'save');

define('GM_GUESTBOOK_CUSTOMERS_STATUS', 'posting rights');
define('GM_GUESTBOOK_CUSTOMERS_STATUS_TEXT', 'Here you can choose which customer group is allowed to write entries.');

define('GM_GUESTBOOK_VVCODE_TITLE', 'Anti-spam functions');
define('GM_GUESTBOOK_VVCODE_TEXT', 'Here you can activate a security code for the guestbook to avoid spam. A user must enter a security code before posting an entry.');
define('GM_GUESTBOOK_VVCODE', 'security code');

define('GM_GUESTBOOK_WAITING_TIME', 'Waiting time in minutes before a new entry from the same user can be posted:');

define('GM_GUESTBOOK_MORE', 'more options');

define('GM_GUESTBOOK_ENTRIES_LIMIT', 'Entries per page');

define('GM_GUESTBOOK_ACTIVATE_ENTRIES', 'Activate function');
define('GM_GUESTBOOK_ACTIVATE_ENTRIES_TEXT', 'Each entry must be activated by the store operator before it can be viewed by visitors.');

define('GM_GUESTBOOK_SEND_MAIL', 'email notification');
define('GM_GUESTBOOK_SEND_MAIL_TEXT', 'Send an email notification to the store administrator when a new entry has been posted.');

define('GM_GUESTBOOK_SUCCESS', 'Update successful.');

// javascript error message
define('GM_GUESTBOOK_WAITING_TIME_ERROR', 'The waiting time has to be a positive numeric value!');

?>