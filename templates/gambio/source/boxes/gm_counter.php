<?php
/* --------------------------------------------------------------
   gm_counter.php 2008-08-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(languages.php,v 1.14 2003/02/12); www.oscommerce.com
   (c) 2003	 nextcommerce (languages.php,v 1.8 2003/08/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: languages.php 1262 2005-09-30 10:00:32Z mz $) 

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

	// include needed functions
			
	require_once(DIR_FS_INC . 'xtc_date_short.inc.php');

	$box_smarty = new smarty;
	$box_smarty->assign('tpl_path', 'templates/' . CURRENT_TEMPLATE . '/');
	
	$gm_hits_query = xtc_db_query("
							SELECT
								sum(gm_counter_visits_total) AS hits
							FROM
								gm_counter_visits
							");

	if(xtc_db_num_rows($gm_hits_query) > 0) {
		$gm_hits = xtc_db_fetch_array($gm_hits_query);		
	}
	
	$gm_date_query = xtc_db_query("
							SELECT
								gm_counter_date	AS date
							FROM
								gm_counter_visits
							WHERE
								gm_counter_id = '1'											
							");

	if((int)xtc_db_num_rows($gm_date_query) > 0) 
	{
		$gm_date = xtc_db_fetch_array($gm_date_query);		
	}
	else
	{
		$gm_dates_query = xtc_db_query("
								SELECT
									gm_counter_date	AS date
								FROM
									gm_counter_visits
								ORDER BY
									gm_counter_date ASC
								LIMIT 1
								");
		if((int)xtc_db_num_rows($gm_dates_query) > 0) 
		{
			$gm_date = xtc_db_fetch_array($gm_dates_query);		
		}
	}
	
	$gm_online_query = xtc_db_query("
							SELECT
								count(customer_id) AS online
							FROM
								whos_online
							");

	if(xtc_db_num_rows($gm_online_query) > 0) {
		$gm_online = xtc_db_fetch_array($gm_online_query);		
	}
	

	$box_smarty->assign('GM_HITS',		$gm_hits['hits']);
	$box_smarty->assign('GM_DATE',		xtc_date_short($gm_date['date']));
	$box_smarty->assign('GM_ONLINE',	$gm_online['online']);

	// set cache ID
	$box_smarty->caching = 0;
	$box_smarty->assign('language', $_SESSION['language']);
	$box_gm_ebay = $box_smarty->fetch(CURRENT_TEMPLATE . '/boxes/box_gm_counter.html');

		$gm_box_pos = $coo_template_control->get_menubox_position('gm_counter');
					
	$smarty->assign($gm_box_pos,$box_gm_ebay);
?>