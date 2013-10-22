<?php
/* --------------------------------------------------------------
 gm_product_export_cron.php 2011-04-23 gm
 Gambio GmbH
 http://www.gambio.de
 Copyright (c) 2010 Gambio GmbH
 Released under the GNU General Public License

 --------------------------------------------------------------
 */
?><?php
/* --------------------------------------------------------------
 $Id: gm_product_export_cron.php 1179 2010-09-22 11:22:13Z mz $

 XT-Commerce - community made shopping
 http://www.xt-commerce.com

 Copyright (c) 2003 XT-Commerce
 --------------------------------------------------------------
 based on:
 (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
 (c) 2002-2003 osCommerce(modules.php,v 1.45 2003/05/28); www.oscommerce.com
 (c) 2003	 nextcommerce (modules.php,v 1.23 2003/08/19); www.nextcommerce.org

 Released under the GNU General Public License
 --------------------------------------------------------------*/
?>
<?php
// always needed
require_once('includes/application_top.php');

// no token, no go
$t_result = FileLog::get_secure_token();
if(empty($t_result) || $t_result != strip_tags($_GET['token'])) {
  die();
}

// clear $_GET param (list of NON-CRONJOB modules for export)
$t_module_list = strip_tags($_GET['modules']);

// needed function as COPY from original
function gm_xtc_href_link($page = '', $parameters = '', $connection = 'NONSSL', $add_session_id = false, $search_engine_safe = true) {
  global $request_type, $session_started, $http_domain, $https_domain,$truncate_session_id;
  if (!xtc_not_null($page)) {
    die('Unable to determine the page link!');
  }
  if ($connection == 'NONSSL') {
    $link = HTTP_SERVER . DIR_WS_CATALOG;
  } elseif ($connection == 'SSL') {
    if (ENABLE_SSL == true) {
      $link = HTTPS_SERVER . DIR_WS_CATALOG;
    } else {
      $link = HTTP_SERVER . DIR_WS_CATALOG;
    }
  } else {
    die('Unable to determine connection method on a link! / Known methods: NONSSL SSL');
  }
  if (xtc_not_null($parameters)) {
    $link .= $page . '?' . $parameters;
    $separator = '&';
  } else {
    $link .= $page;
    $separator = '?';
  }
  while ( (substr($link, -1) == '&') || (substr($link, -1) == '?') ) $link = substr($link, 0, -1);
  if ( ($add_session_id == true) && ($session_started == true) && (SESSION_FORCE_COOKIE_USE == 'False') ) {
    if (defined('SID') && xtc_not_null(SID)) {
      $sid = SID;
    } elseif ( ( ($request_type == 'NONSSL') && ($connection == 'SSL') && (ENABLE_SSL == true) ) || ( ($request_type == 'SSL') && ($connection == 'NONSSL') ) ) {
      if ($http_domain != $https_domain) {
        $sid = session_name() . '=' . session_id();
      }
    }
  }
  if ($truncate_session_id) $sid=NULL;
  if (isset($sid)) {
    $link .= $separator . $sid;
  }
  if ( (SEARCH_ENGINE_FRIENDLY_URLS == 'true') && ($search_engine_safe == true) ) {
    while (strstr($link, '&&')) $link = str_replace('&&', '&', $link);
    $link = str_replace('?', '/', $link);
    $link = str_replace('&', '/', $link);
    $link = str_replace('=', '/', $link);
    $separator = '?';
  }
  return $link;
}

// set EXPORT Object
require_once(DIR_FS_CATALOG.'admin/gm/classes/GMProductExport.php');
$coo_product_export = new GMProductExport();

// all cronjob-enabled? or just a list via $_GET?
// 1) the list via $_GET (no cronjob flag)
// 2) the list from cronjob enabled (only with flag)
$t_cronmodules_array = array();
if ( !empty($t_module_list) ) {
  $t_modules_array = explode(",", $t_module_list);
  foreach ($t_modules_array as $t_module) {
    if ($coo_product_export->module_installed($t_module) && !$coo_product_export->has_cronjob_flag($t_module)) {
      $t_cronmodules_array[] = $t_module.'.php';
    }
  }
} else {
  $t_all_modules_array = $coo_product_export->get_modules();
  foreach ($t_all_modules_array as $t_module) {
    if ($coo_product_export->module_installed($t_module) && $coo_product_export->has_cronjob_flag($t_module)) {
      $t_cronmodules_array[] = $t_module;
    }
  }
}

// kill not needed object
$coo_product_export = false;

// export all CROBJOB modules
foreach ($t_cronmodules_array as $t_module) {
  $coo_export = new GMProductExport();
  $coo_export->set_seo_boost();
  $coo_export->set_selected_module($t_module);
  $coo_export->set_module($t_module);
  $coo_export->set_module_data($t_module);
  $coo_export->do_export();
  $coo_export = false;
}
?>