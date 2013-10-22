<?php
/* --------------------------------------------------------------
   gm_gprint_order_ajax.php 2009-10-22 mb
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2009 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/
?><?php

include_once('gm/classes/GMJSON.php');
include_once('gm/classes/GMGPrintConfiguration.php');
include_once('gm/classes/GMGPrintFileManager.php');
include_once('gm/classes/GMGPrintSurfacesManager.php');
include_once('gm/classes/GMGPrintSurfaces.php');
include_once('gm/classes/GMGPrintElements.php');
include_once('gm/classes/GMGPrintSurfacesGroupsManager.php');
include_once('gm/classes/GMGPrintCartManager.php');
include_once('gm/classes/GMGPrintWishlistManager.php');

include_once('gm/inc/gm_utf8_decode.inc.php');

include_once('includes/application_top.php');

include_once('gm/modules/gm_gprint_tables.php');

if(isset($_POST['surfaces_groups_id']))
{
	$f_surfaces_groups_id = $_POST['surfaces_groups_id'];
	$c_surfaces_groups_id = (int)$f_surfaces_groups_id;
}


$t_output = '';
$f_action = $_POST['action'];

switch($f_action)
{
	case 'load_surfaces_group':
		$coo_gprint_order_surfaces_manager = new GMGPrintOrderSurfacesManager($c_surfaces_groups_id);
		$t_output = $coo_gprint_order_surfaces_manager->load_surfaces_group($c_surfaces_groups_id);

		break;
}

echo $t_output;
?>