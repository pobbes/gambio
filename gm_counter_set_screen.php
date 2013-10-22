<?php
/* --------------------------------------------------------------
   gm_counter_set_screen.php 2008-03-17 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

gmc.php 2007-09-22 pt@gambio
	Gambio OHG
	http://www.gambio.de
	Copyright (c) 2007 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
	--------------------------------------------------------------
*/

	require('includes/application_top.php');
	
	// -> set user screen	
	if($_GET['gm_action'] == 'gmc_user_screen') {
		
		$gmc_updater = new gmc();		
		
		// -> set defaults
		if(empty($_GET['screen_resolution'])) {
			$_GET['screen_resolution'] = 'UNKNOWN';
		}
		if(empty($_GET['color_depth'])) {
			$_GET['color_depth'] = 'UNKNOWN';
		}

		// -> save
		$gmc_updater->gmc_set_info_value($_GET['screen_resolution'], 'resolution');
		
		$gmc_updater->gmc_set_info_value($_GET['color_depth'], 'color_depth');

	}

?>