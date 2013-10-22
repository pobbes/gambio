<?php
/* --------------------------------------------------------------
   gm_counter_action.php 2011-04-28 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

*/


	require('includes/application_top.php');
	require_once (DIR_FS_CATALOG . 'gm/inc/gm_navigate_pages.inc.php');
	require(DIR_FS_ADMIN . 'gm/classes/GMStat.php');
	header('Content-Type: text/html; charset=iso-8859-1');

	$GMStat = new GMStat();
		$GMStat->update();

	switch(($_GET['action'])) {
	

		/*
		*	-> get the overview
		*/
		case 'gm_counter_visitor':			
		case 'gm_counter_search':		
		case 'gm_counter_user':		
		case 'gm_counter_pages':	
			$t_success = $GMStat->setGraph();
			if($t_success)
			{
				echo '<img src="' . DIR_WS_CATALOG.'cache/graph-'.FileLog::get_secure_token().'.png'.'?img_id=' . time(). '">';
			}
			
			include(DIR_FS_ADMIN . 'gm/gm_counter/gm_counter_form.php');

		break;
		
		/*
		*	-> start page
		*/
		case 'gm_start':			
			require_once(DIR_FS_ADMIN . 'gm/classes/GMStart.php');			
			$gm_Start = new GMStart();
			echo $gm_Start->getStatistic();
		break;
		
		/*
		*	-> get submenus
		*/
		case 'gm_box_submenu_visitor':
		case 'gm_box_submenu_pages':
		case 'gm_box_submenu_user':
		case 'gm_box_submenu_search':
		case 'gm_box_submenu_conf':
			include(DIR_FS_ADMIN . 'gm/gm_counter/gm_counter_submenu.php');
		break;

		case 'gmc_user_screen':
			// -> save to session
			if((int)$_GET['screen_width'] <= 980) 
			{
				$_SESSION['screen_width'] = 980;		
			} 
			else 
			{
				$_SESSION['screen_width'] = 1236;		
			}
		break;
	}			
	
	unset($GMStat);

?>