<?php
/* --------------------------------------------------------------
   xtc_db_error.inc.php 2011-09-06 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(database.php,v 1.19 2003/03/22); www.oscommerce.com 
   (c) 2003	 nextcommerce (xtc_db_error.inc.php,v 1.4 2003/08/19); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: xtc_db_error.inc.php 899 2005-04-29 02:40:57Z hhgag $) 

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
function xtc_db_error($query, $errno, $error) 
{
    if(is_object($GLOBALS['coo_debugger']) == true && $GLOBALS['coo_debugger']->is_enabled('print_sql_on_error') == true) {
		echo('<font color="#000000"><b>'.$errno.' - '.$error.'<br /><br />'.$query.'<br /><br /><small><font color="#ff0000">[XT SQL Error]</font></small><br /><br /></b></font>');
	}

	$t_error_string  = "================================================================================\n================================================================================\n\n";
  	$t_error_string .= 'Query: '. $query ."\n\n";
  	$t_error_string .= 'Error: '. $error .' (error '.$errno.')'."\n\n";
  	
  	$coo_error_log = new FileLog('errors');
	$coo_error_log->write($t_error_string);
	
  	trigger_error('SQL Error', E_USER_WARNING);
	die();
}
?>