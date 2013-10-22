<?php
/* --------------------------------------------------------------
   xtc_db_connect.inc.php 2012-01-10 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(database.php,v 1.19 2003/03/22); www.oscommerce.com 
   (c) 2003	 nextcommerce (xtc_db_connect.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: xtc_db_connect.inc.php 1248 2005-09-27 10:27:23Z gwinger $)

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
 //  include(DIR_WS_CLASSES.'/adodb/adodb.inc.php');
  function xtc_db_connect($server = DB_SERVER, $username = DB_SERVER_USERNAME, $password = DB_SERVER_PASSWORD, $database = DB_DATABASE, $link = 'db_link') {
    global $$link;

    if (USE_PCONNECT == 'true') {
     	$$link = mysql_pconnect($server, $username, $password);
    } else {
		$$link = mysql_connect($server, $username, $password);
	}
	
	// BOF GM_MOD
    $vers = @mysql_get_server_info();
    if(substr($vers,0,1) > 4) @mysql_query("SET SESSION sql_mode=''");
	// EOF GM_MOD

	@mysql_query("SET SQL_BIG_SELECTS=1");
	
    if ($$link) mysql_select_db($database);

    return $$link;
  }
 ?>