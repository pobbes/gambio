<?php
/* --------------------------------------------------------------
   gm_create_vvcodes.php 2008-08-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/
?><?php

require('includes/application_top.php');
require_once(DIR_FS_INC.'xtc_render_vvcode.inc.php');
$vvimg = vvcode_render_code($_SESSION['vvcode']);
?>