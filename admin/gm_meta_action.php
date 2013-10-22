<?php
/* --------------------------------------------------------------
   gm_meta_action.php 2010-08-19 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/
?><?php

	include(DIR_FS_CATALOG . 'gm/inc/gm_get_language.inc.php');
	include(DIR_FS_CATALOG . 'gm/inc/gm_get_language_link.inc.php');	
	include(DIR_FS_CATALOG . 'gm/inc/gm_get_meta.inc.php');	
	if(!empty($_GET['lang_id'])) {
		$lang_id = $_GET['lang_id'];
	} else {
		$lang_id = $_SESSION['languages_id'];
	}

	if($_GET['gm_new'] == '1') {
		if(!empty($_POST['gm_lang']) && !empty($_POST['gm_new_value']) && (!empty($_POST['gm_meta']) || !empty($_POST['gm_new_key']))) {
			for($i=0; $i < count($_POST['gm_lang']); $i++) {
				$gm_value_1 = gm_get_content($_POST['gm_new_key'], $lang_id);
				$gm_value_2 = gm_get_content($_POST['gm_meta'], $lang_id);
				
				if(empty($gm_value_1) && empty($gm_value_2)) {
					if(!empty($_POST['gm_new_key'])) {						
						gm_set_content($_POST['gm_new_key'], $_POST['gm_new_value'], $_POST['gm_lang'][$i], 1);
					} else {
						if($_POST['gm_meta'] != "1") {
							gm_set_content($_POST['gm_meta'], $_POST['gm_new_value'], $_POST['gm_lang'][$i], 1);
						}
					}
				} else {
					// meta exists
					$gm_status = GM_META_EXISTS;		
				}	
			}
		// language empty
		} else {
			$gm_status = GM_META_LANG_EMPTY;
		}
	
	} else if($_GET['gm_options'] == '1') {
		
		if(isset($_POST))
		{
			gm_set_conf('GM_TITLE_USE_STANDARD_META_TITLE',				$_POST['GM_TITLE_USE_STANDARD_META_TITLE']);
			gm_set_conf('GM_TITLE_SHOW_STANDARD_META_TITLE',			$_POST['GM_TITLE_SHOW_STANDARD_META_TITLE']);
			gm_set_content('GM_TITLE_STANDARD_META_TITLE_SEPARATOR',	$_POST['GM_TITLE_STANDARD_META_TITLE_SEPARATOR'],	$_POST['gm_lang']);
			gm_set_content('GM_TITLE_STANDARD_META_TITLE',				$_POST['GM_TITLE_STANDARD_META_TITLE'],				$_POST['gm_lang']);
		}
	} else {

		if(!empty($_POST['gm_submit'])) {			
			foreach($_POST as $gm_key => $gm_value) {			
				if($gm_key != 'gm_delete' && $gm_key != 'gm_lang' && $gm_key != 'gm_submit') {
					gm_set_content($gm_key, $gm_value, $lang_id, 1);
				}	
			}			

			if(!empty($_POST['gm_delete'])) {
				foreach($_POST['gm_delete'] as $gm_id) {	
					xtc_db_query("
								DELETE
								FROM
									gm_contents								
								WHERE
									gm_contents_id = '" . $gm_id . "'
								");					
				}
			}		
		}
	}


	switch(($_GET['action'])) {
	
		case 'gm_meta_new':
			include(DIR_FS_ADMIN . 'gm/gm_meta/gm_meta_new.php');
		break;			

		case 'gm_meta_options':
			include(DIR_FS_ADMIN . 'gm/gm_meta/gm_meta_options.php');
		break;			

		default:			
			$gm_values = gm_get_meta($lang_id);
			include(DIR_FS_ADMIN . 'gm/gm_meta/gm_meta.php');
		break;
	}

?>
