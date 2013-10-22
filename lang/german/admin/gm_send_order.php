<?php
/* --------------------------------------------------------------
   gm_send_order.php 2008-08-01 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

gm_send_order.php 09.04.2008 pt@gambio
	Gambio OHG
	http://www.gambio.de
	Copyright (c) 2007 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
	--------------------------------------------------------------
*/
?><?php

	define('TITLE_ORDER',			'Bestellbestätigung');
	define('MAIL_CLOSE',			'Schliessen');
	define('MAIL_SUCCESS',			'Die E-Mail wurde erfolgreich verschickt.');
	define('MAIL_UNSUCCESS',		'Die E-Mail konnte nicht verschickt werden.');

	define('UPDATE_SUCCESS',		'Die Bestellung wurde storniert.');
	define('UPDATE_MAIL_SUCCESS',	'Die Bestellung wurde storniert und der Kunde benachrichtigt.');
	define('UPDATE_UNSUCCESS',		'Die Bestellung konnte nicht storniert werden.');
	define('CANCEL_UNSUCCESS',		'Diese Bestellung wurde bereits storniert.');


?>