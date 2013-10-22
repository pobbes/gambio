<?php
/* --------------------------------------------------------------
   gm_tell_a_friend.php 2008-08-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/
?>
<?php
define('GM_TELL_A_FRIEND_TITLE','Recommend');
define('GM_TELL_A_FRIEND_SENDER','Sender name');
define('GM_TELL_A_FRIEND_EMAIL','Receiver email ');
define('GM_TELL_A_FRIEND_MESSAGE','Comment');
define('GM_TELL_A_FRIEND_MESSAGE_INPUT','I found this product and would like to recommend it.');

define('GM_TELL_A_FRIEND_MAIL_OUT', 'Thank you! Your mail has been sent successfully.');
define('GM_TELL_A_FRIEND_ERROR', 'Your mail could not be delivered because the email address was missing.');

define('GM_TELL_A_FRIEND_SEND', 'send');
define('GM_TELL_A_FRIEND_WRONG_CODE', 'Incorrect code!');
define('GM_TELL_A_FRIEND_VALIDATION', 'Verification code');

// kein HTML-Umlaute, da Mailtext!
define('GM_TELL_A_FRIEND_SUBJECT_1', 'Found an interesting product in the ');
define('GM_TELL_A_FRIEND_SUBJECT_2', ' store');
define('GM_TELL_A_FRIEND_RECOMMENDS_1', ' has found an interesting product in the ');
define('GM_TELL_A_FRIEND_RECOMMENDS_2', ' store, which they would like to recommend:');
?>