<?php
/* --------------------------------------------------------------
 gm_product_export.php 2011-06-24 gm
 Gambio GmbH
 http://www.gambio.de
 Copyright (c) 2011 Gambio GmbH
 Released under the GNU General Public License

 --------------------------------------------------------------
 */
?><?php
/* --------------------------------------------------------------
 $Id: module_export.php 1179 2005-08-25 12:37:13Z mz $

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
$csv_fields_array=array();
require('includes/application_top.php');

require_once(DIR_FS_CATALOG . 'gm/inc/gm_xtc_href_link.inc.php');

require_once(DIR_FS_CATALOG . 'gm/classes/GMSEOBoost.php');
$coo_gm_seo_boost = new GMSEOBoost();

require_once(DIR_WS_FUNCTIONS . 'export_functions.php');

if (!is_writeable(DIR_FS_CATALOG . 'export/')) {
	$messageStack->add(ERROR_EXPORT_FOLDER_NOT_WRITEABLE, 'error');
}
$module_type = 'export';
$module_directory = DIR_WS_MODULES . 'export/';
$module_key = 'MODULE_EXPORT_INSTALLED';
$file_extension = '.php';
define('HEADING_TITLE', HEADING_TITLE_MODULES_EXPORT);
if (isset($_GET['error'])) {
	$map='error';
	if ($_GET['kind']=='success') $map='success';
	$messageStack->add($_GET['error'], $map);
}
// include needed functions (for modules)
require(DIR_FS_ADMIN . 'gm/classes/GMProductExport.php');
$coo_gm_product_export = new GMProductExport();
$coo_gm_product_export->set_seo_boost();

// set data for selected module
if (!empty($_GET['module'])) {
  $coo_gm_product_export->set_selected_module($_GET['module']);
  $coo_gm_product_export->set_module($_GET['module']);
}

// actions: install / remove
if (!empty($_GET['action'])) {
  switch ($_GET['action']) {
    case 'install':
      $coo_gm_product_export->module_install();
      $f_module = $_GET['module'];
      xtc_redirect(xtc_href_link(FILENAME_GM_PRODUCT_EXPORT, 'module=' . $f_module));
      break;
    case 'remove':
      $coo_gm_product_export->module_remove();
      xtc_redirect(xtc_href_link(FILENAME_GM_PRODUCT_EXPORT));
      break;
    default:
      break;
  }
}

// save configuration (on SAVE and EXPORT)
if (!empty($_POST['do_save']) || !empty($_POST['do_export'])) {
  $coo_gm_product_export->save_configuration();
}

// create export
if (!empty($_POST['do_export'])) {
  $coo_gm_product_export->set_module_data($_GET['module']);
  $coo_gm_product_export->do_export();
}
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type"
	content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0"
	leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
	<tr>
		<td class="columnLeft2" width="<?php echo BOX_WIDTH; ?>" valign="top">
		<table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1"
			cellpadding="1" class="columnLeft">
			<!-- left_navigation //-->
			<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
			<!-- left_navigation_eof //-->
		</table>
		</td>
		<!-- body_text //-->
		<td class="boxCenter" width="100%" valign="top">
		<div class="pageHeading" style="float: left; background-image: url(images/gm_icons/gambio.png);"><?php echo HEADING_TITLE; ?>
		</div>
		<div style="clear: both" class="main"><?php
		$coo_gm_product_export->get_modules();
		$coo_gm_product_export->module_picker();
		$coo_gm_product_export->display_options();
		$t_display_export = $coo_gm_product_export->v_module_content;
		echo $t_display_export;
		?></div>
		<!-- body_text_eof //--></td>
	</tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
		<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br />
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>