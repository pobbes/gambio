<?php
/* --------------------------------------------------------------
   admin_javascript.js.php 2012-09-17 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
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

include_once(DIR_FS_ADMIN . 'gm/javascript/admin_info_box.js.php');

?>