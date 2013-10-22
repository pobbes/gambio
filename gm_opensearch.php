<?php
/* --------------------------------------------------------------
   gm_opensearch.php 2008-08-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/
	require ('includes/application_top.php');
	

	$smarty = new Smarty;
	$smarty->assign('language', $_SESSION['language']);
	$smarty->assign('gm_image', '<image src="' . HTTP_SERVER . DIR_WS_CATALOG . 'gm/images/ie_search.gif" alt="" title="" />');
	$smarty->caching = 0;
	$smarty->display(CURRENT_TEMPLATE.'/module/gm_opensearch.html');


?>