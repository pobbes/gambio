<?php
/* --------------------------------------------------------------
   application_bottom.php 2012-03-19 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(application_bottom.php,v 1.14 2003/02/10); www.oscommerce.com
   (c) 2003	 nextcommerce (application_bottom.php,v 1.6 2003/08/13); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: application_bottom.php 1239 2005-09-24 20:09:56Z mz $)

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

# $coo_stop_watch_array defined in application_top
foreach($GLOBALS['coo_stop_watch_array'] as $t_key => $t_item) {
	$t_item->log_total_time('TOTAL '. $t_key);
}

if (STORE_PAGE_PARSE_TIME == 'true') {
	$time_start = explode(' ', PAGE_PARSE_START_TIME);
	$time_end = explode(' ', microtime());
	$parse_time = number_format(($time_end[1] + $time_end[0] - ($time_start[1] + $time_start[0])), 3);
	error_log(strftime(STORE_PARSE_DATE_TIME_FORMAT) . ' - ' . getenv('REQUEST_URI') . ' (' . $parse_time . 's)' . "\n", 3, STORE_PAGE_PARSE_TIME_LOG);

}

if (DISPLAY_PAGE_PARSE_TIME == 'true') {
	$time_start = explode(' ', PAGE_PARSE_START_TIME);
	$time_end = explode(' ', microtime());
	$parse_time = number_format(($time_end[1] + $time_end[0] - ($time_start[1] + $time_start[0])), 3);
	echo '<div class="parseTime">Parse Time: ' . $parse_time . 's</div>';
	if(is_object($GLOBALS['coo_debugger'])) $GLOBALS['coo_debugger']->log($parse_time, 'PageParseTime');
}

if (TRACKING_ECONDA_ACTIVE == 'true') {
	require_once (DIR_WS_INCLUDES . 'econda/econda.php');
}

/* BOF YOOCHOOSE */
if (defined('YOOCHOOSE_ACTIVE') && YOOCHOOSE_ACTIVE) {
    require_once (DIR_WS_INCLUDES . 'yoochoose/tracking.php');
}
/* EOF YOOCHOOSE */

$t_products_id = 0;
if(isset($product) && $product->data['products_id'] > 0)
{
	$t_products_id = $product->data['products_id'];
}
$coo_application_bottom_extender_component = MainFactory::create_object('ApplicationBottomExtenderComponent');
$coo_application_bottom_extender_component->set_data('GET', $_GET);
$coo_application_bottom_extender_component->set_data('POST', $_POST);
$coo_application_bottom_extender_component->set_data('cPath', $cPath);
$coo_application_bottom_extender_component->set_data('products_id', $t_products_id);
$coo_application_bottom_extender_component->init_page();
$coo_application_bottom_extender_component->init_js();
$coo_application_bottom_extender_component->proceed();
$t_dispatcher_result_array = $coo_application_bottom_extender_component->get_response();

if(is_array($t_dispatcher_result_array))
{
	foreach($t_dispatcher_result_array AS $t_key => $t_value)
	{
		echo $t_value;
	}
}

/* EOF GM_MOD GOOGLE ANALYTICS */
?>

<script type="text/javascript" src="<?php echo 'templates/'.CURRENT_TEMPLATE; ?>/js/js.php?<?php echo filemtime('templates/'.CURRENT_TEMPLATE.'/js/js.php') ?>"></script>
</body>
</html>
<?php
unset($_SESSION['gm_info_message']);

mysql_close();

?>