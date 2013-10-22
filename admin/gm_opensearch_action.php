<?php
/* 
	--------------------------------------------------------------
	gm_opensearch_action.php 08.04.2008 pt@gambio
	Gambio OHG
	http://www.gambio.de
	Copyright (c) 2007 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
	--------------------------------------------------------------
*/

	include(DIR_FS_CATALOG . 'gm/inc/gm_get_language.inc.php');
	include(DIR_FS_CATALOG . 'gm/inc/gm_get_language_link.inc.php');	
	include(DIR_FS_CATALOG . 'gm/inc/gm_get_meta.inc.php');	
	
	
	if(!empty($_GET['lang_id'])) {
		$lang_id = $_GET['lang_id'];
	} else {
		$lang_id = $_SESSION['languages_id'];
	}


	if(isset($_POST['go_opensearch'])) 	{	

		if($_POST['GM_OPENSEARCH_BOX']	== 1) {
			gm_set_conf('GM_OPENSEARCH_BOX', 1);				
		} else { 
			gm_set_conf('GM_OPENSEARCH_BOX', 0);		
		}	
		
		if($_POST['GM_OPENSEARCH_SEARCH']	== 1) {
			gm_set_conf('GM_OPENSEARCH_SEARCH', 1);				
		} else { 
			gm_set_conf('GM_OPENSEARCH_SEARCH', 0);		
		}				
	}	

	if(isset($_POST['go_save'])) 	{	
		gm_set_conf('GM_OPENSEARCH_CHANGED', '1');
		gm_set_content('GM_OPENSEARCH_TEXT',		trim($_POST['GM_OPENSEARCH_TEXT']),			trim($_POST['gm_lang']));
		gm_set_content('GM_OPENSEARCH_LINK',		trim($_POST['GM_OPENSEARCH_LINK']),			trim($_POST['gm_lang']));
		gm_set_content('GM_OPENSEARCH_SHORTNAME',	trim($_POST['GM_OPENSEARCH_SHORTNAME']),	trim($_POST['gm_lang']));
		gm_set_content('GM_OPENSEARCH_LONGNAME',	trim($_POST['GM_OPENSEARCH_LONGNAME']),		trim($_POST['gm_lang']));
		gm_set_content('GM_OPENSEARCH_DESCRIPTION', trim($_POST['GM_OPENSEARCH_DESCRIPTION']),	trim($_POST['gm_lang']));
		gm_set_content('GM_OPENSEARCH_TAGS',		trim($_POST['GM_OPENSEARCH_TAGS']),			trim($_POST['gm_lang']));
		gm_set_content('GM_OPENSEARCH_CONTACT',		trim($_POST['GM_OPENSEARCH_CONTACT']),		trim($_POST['gm_lang']));

		
	}	


	switch(($_GET['action'])) {
	
		case 'gm_opensearch_conf':
			include(DIR_FS_ADMIN . 'gm/gm_opensearch/gm_opensearch_conf.php');
		break;			

		default:			
			$gm_values = gm_get_meta($lang_id);
			include(DIR_FS_ADMIN . 'gm/gm_opensearch/gm_opensearch.php');
		break;
	}

?>