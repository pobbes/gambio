<?php
/* --------------------------------------------------------------
   application_bottom.php 2012-01-13 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
  (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(application_bottom.php,v 1.8 2002/03/15); www.oscommerce.com
   (c) 2003	 nextcommerce (application_bottom.php,v 1.6 2003/08/1); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: application_bottom.php 899 2005-04-29 02:40:57Z hhgag $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/


  if (STORE_PAGE_PARSE_TIME == 'true') {
    if (!is_object($logger)) $logger = new logger;
    //echo $logger->timer_stop(DISPLAY_PAGE_PARSE_TIME);
  }

foreach($GLOBALS['coo_stop_watch_array'] as $t_key => $t_item)
{
	$t_item->log_total_time('TOTAL '. $t_key);
}

$coo_application_bottom_extender_component = MainFactory::create_object('AdminApplicationBottomExtenderComponent');
$coo_application_bottom_extender_component->set_data('GET', $_GET);
$coo_application_bottom_extender_component->set_data('POST', $_POST);
$coo_application_bottom_extender_component->proceed();

mysql_close();
?>