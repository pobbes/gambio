<?php
/* --------------------------------------------------------------
   gm_gprint.php 2009-11-11 mb
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2009 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(configuration.php,v 1.40 2002/12/29); www.oscommerce.com
   (c) 2003	 nextcommerce (configuration.php,v 1.16 2003/08/19); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: configuration.php 1125 2005-07-28 09:59:44Z novalis $)

   Released under the GNU General Public License
   --------------------------------------------------------------*/

require('includes/application_top.php');
	
require_once('../gm/modules/gm_gprint_tables.php');
require_once('../gm/classes/GMGPrintProductManager.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php echo HTML_PARAMS; ?>>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>">
		<title><?php echo TITLE; ?></title>
		<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
		<link type="text/css" rel="stylesheet" href="gm/css/gm_gprint.css" />
	</head>
	
	<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
		<!-- header //-->
		<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
		
		<script type="text/javascript" src="<?php echo DIR_WS_ADMIN; ?>gm/javascript/gm_gprint.js.php?language=<?php echo $_SESSION['language']; ?>"></script>
		<script type="text/javascript" src="<?php echo DIR_WS_CATALOG; ?>gm_gprint.js.php?mode=backend&XTCsid=<?php echo xtc_session_id(); ?>&languages_id=<?php echo (int)$_GET['languages_id']; ?>&id=<?php echo (int)$_GET['id']; ?>"></script>
		
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
					<div class="pageHeading" style="background-image:url(images/gm_icons/gambio.png)"><?php echo GM_GPRINT_HEADING_TITLE; ?></div>
					<br />
					<span class="main">
				
						<?php
						if($_GET['action'] == 'edit' && !empty($_GET['id']))
						{
							include_once("gm_gprint_edit.php");
						}
						elseif($_GET['action'] == 'categories')
						{
							include_once("gm_gprint_categories.php");
						}
						elseif($_GET['action'] == 'configuration')
						{
							include_once("gm_gprint_configuration.php");
						}
						else
						{
							include_once("gm_gprint_overview.php");
						}
						?>
						
					</span>	
				</td>
				<!-- body_text_eof //-->
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