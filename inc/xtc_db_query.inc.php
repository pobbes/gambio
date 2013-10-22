<?php
/* --------------------------------------------------------------
   xtc_db_query.inc.php 2011-09-08 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(database.php,v 1.19 2003/03/22); www.oscommerce.com
   (c) 2003	 nextcommerce (xtc_db_query.inc.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: xtc_db_query.inc.php 1195 2005-08-28 21:10:52Z mz $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

//include needed functions
include_once(DIR_FS_INC . 'xtc_db_error.inc.php');
include_once(DIR_FS_CATALOG . 'gm/inc/write_sql_log.inc.php');

function xtc_db_query($query, $link = 'db_link', $p_enable_data_cache=true)
{
	global $$link;

	if(STORE_DB_TRANSACTIONS == 'true') {
		error_log('QUERY ' . $query . "\n", 3, STORE_PAGE_PARSE_TIME_LOG);
	}

	# log sql queries except SELECTs
	$t_sql_log = write_sql_log($query);

	# use result cache in frontend queries
	#
	if(defined('APPLICATION_RUN_MODE') && APPLICATION_RUN_MODE == 'frontend' && $p_enable_data_cache == true)
	{
		if(is_object($GLOBALS['coo_debugger']) == true && $GLOBALS['coo_debugger']->is_enabled('log_sql_queries') == true) {
			$coo_error_log = new FileLog('sql_'. md5(gm_get_env_info('SCRIPT_NAME')));
			$coo_error_log->write($query . "\n");
		}
		
		$coo_cache =& DataCache::get_instance();
		$t_use_cache = true;
		$t_cache_key = '';
		
		if(strtoupper(substr(ltrim($query), 0, 6)) != 'SELECT')
		{
			# cache selects only
			$t_use_cache = false;
		}
		else {
			# use cache, build key
			$t_use_cache = true;
			$t_cache_key = $coo_cache->build_key($query);
		}
		
		if($t_use_cache && $coo_cache->key_exists($t_cache_key))
		{
			# use cached result
			$result = $coo_cache->get_data($t_cache_key);
			@mysql_data_seek($result, 0);
		}
		else
		{
			# execute query
			$result = mysql_query($query, $$link) or xtc_db_error($query, mysql_errno(), mysql_error());

			# save result to cache
			$coo_cache->set_data($t_cache_key, $result);
		}
	}
	else {
		# ALL OTHER RUN MODES
		# execute query
		$result = mysql_query($query, $$link) or xtc_db_error($query, mysql_errno(), mysql_error());		
	}
	
	if(STORE_DB_TRANSACTIONS == 'true') {
		$result_error = mysql_error();
		error_log('RESULT ' . $result . ' ' . $result_error . "\n", 3, STORE_PAGE_PARSE_TIME_LOG);
	}
	return $result;
}
?>