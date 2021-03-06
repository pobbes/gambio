<?php
/* --------------------------------------------------------------
   properties.php 2008-06-27 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project 
   (c) 2002-2003 osCommerce coding standards (a typical file) www.oscommerce.com
   (c) 2003      nextcommerce (start.php,1.5 2004/03/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: start.php 1235 2005-09-21 19:11:43Z mz $)

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

	require('includes/application_top.php');
	?>

	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html <?php echo HTML_PARAMS; ?>>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>" /> 
			<title><?php echo TITLE; ?></title>
			<link rel="stylesheet" type="text/css" href="includes/stylesheet.css" />
		</head>
		<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
			<!-- header //-->
			<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
			<!-- header_eof //-->

			<!-- body //-->
			<table border="0" width="100%" cellspacing="2" cellpadding="2">
				<tr>
					<td class="columnLeft2" width="<?php echo BOX_WIDTH; ?>" valign="top">
						<table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
							<!-- left_navigation //-->
							<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
							<!-- left_navigation_eof //-->
						</table>
					</td>
					<!-- body_text //-->
					<td class="boxCenter" width="100%" valign="top">

<?php
$t_using_error_reporting_value = error_reporting();
error_reporting(E_ALL);


require_once(DIR_FS_DOCUMENT_ROOT.'gm/properties/data/PropertiesDataAgent.php');
require_once(DIR_FS_DOCUMENT_ROOT.'gm/properties/data/PropertiesStructSupplier.php');

require_once(DIR_FS_DOCUMENT_ROOT.'gm/properties/page_modules/PropertiesAdminView.php');
require_once(DIR_FS_DOCUMENT_ROOT.'gm/properties/controls/PropertiesAdminControl.php');


$coo_properties_admin_view = new PropertiesAdminView($_GET, $_POST);

$t_html = $coo_properties_admin_view->get_properties_main();
echo $t_html;

error_reporting($t_using_error_reporting_value);
?>


					</td>
					<!-- body_text_eof //-->
				</tr>
			</table>
			<!-- body_eof //-->

			<!-- footer //-->
			<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
			<!-- footer_eof //-->
		</body>
	</html>
	<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>