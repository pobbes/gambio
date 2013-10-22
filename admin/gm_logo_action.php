<?php
/* --------------------------------------------------------------
   gm_logo_action.php 2008-05-13 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

gm_logo_action.php 08.04.2008 pt@gambio
	Gambio OHG
	http://www.gambio.de
	Copyright (c) 2007 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
	--------------------------------------------------------------
*/

	require(DIR_FS_CATALOG . 'gm/inc/gm_prepare_filename.inc.php');

	
	// set start = shop logo
	if(empty($_GET['gm_logo'])) {
		$_GET['gm_logo'] = 'gm_logo_shop';
	}
	
	$gm_logo = MainFactory::create_object('GMLogoManager', array($_GET['gm_logo']));

	if(!empty($_POST['gm_upload'])) {
		$gm_message =  $gm_logo->upload();
	}	

	switch(($_GET['action'])) {	

		default:			
			include(DIR_FS_ADMIN . 'gm/gm_logo/gm_logo.php');
		break;
	}

	unset($gm_logo);
?>
