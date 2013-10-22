<?php
/* --------------------------------------------------------------
   gm_gprint.js.php 2011-03-16 mb
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/
?><?php

require_once('includes/application_top.php');
if(isset($_SESSION['language_charset']))
{
	header('Content-Type: text/javascript; charset=' . $_SESSION['language_charset']);
}
else
{
	header('Content-Type: text/javascript; charset=iso-8859-15');
}

require_once(DIR_FS_CATALOG . 'lang/' . $_SESSION['language'] . '/gm_gprint.php');


switch($_GET['mode'])
{
	case 'order':
		include_once(get_usermod(DIR_FS_CATALOG . 'gm/javascript/gm_gprint_order.js'));
		break;
	default:
		include_once(get_usermod(DIR_FS_CATALOG . 'gm/javascript/gm_gprint.js'));
}

if(!isset($_GET['page']))
{
	mysql_close();
}
?>