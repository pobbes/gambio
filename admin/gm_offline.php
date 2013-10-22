<?php
/* --------------------------------------------------------------
   gm_offline.php 2008-08-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
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

if(isset($_POST['go'])) {
	xtc_db_query("UPDATE gm_configuration SET gm_value = '" . xtc_db_input(xtc_db_prepare_input($_POST['shop_offline'])). "' WHERE gm_key = 'GM_SHOP_OFFLINE'");
	xtc_db_query("UPDATE gm_configuration SET gm_value = '" . xtc_db_input(xtc_db_prepare_input($_POST['offline_msg'])) . "' WHERE gm_key = 'GM_SHOP_OFFLINE_MSG'");
}
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>"> 
<?php
if(preg_match('/MSIE [\d]{2}\./i', $_SERVER['HTTP_USER_AGENT']))
{
?>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<?php
}
?>
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script type="text/javascript" src="includes/general.js"></script>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onload="SetFocus();">
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
				<table border="0" width="100%" cellspacing="0" cellpadding="0">
					<tr>
						<td>
							<div class="pageHeading" style="background-image:url(images/gm_icons/gambio.png)"><?php echo HEADING_TITLE; ?></div>
							<br />
							<table border="0" width="100%" cellspacing="0" cellpadding="0">
								<tr>
									<td class="dataTableHeadingContent">
										<?php echo BOX_GM_OFFLINE; ?>												  
									</td>
								</tr>
							</table>
							<table border="0" width="100%" cellspacing="0" cellpadding="0" class="gm_border dataTableRow">
								<tr>
									<td valign="top" class="main">		
										<form name="img_upload" action="gm_offline.php" method="post" enctype="multipart/form-data">
										<input type="checkbox" name="shop_offline" value="checked" <?php echo gm_get_conf('GM_SHOP_OFFLINE'); ?>>
										<?php echo GM_SETTINGS_OFFLINE ?><br><br>

										<?php echo GM_SETTINGS_OFFLINE_MSG ?>:<br />
										<?php
										require_once(DIR_FS_ADMIN . 'gm/fckeditor/fckeditor.php');
										$oFCKeditor = new FCKeditor('offline_msg');
										$oFCKeditor->BasePath	= DIR_WS_ADMIN . 'gm/fckeditor/';
										$oFCKeditor->Height = 150;
										$oFCKeditor->Width = 500;
										$oFCKeditor->Value = gm_get_conf('GM_SHOP_OFFLINE_MSG');
										$oFCKeditor->ToolbarSet = "Small";
										$oFCKeditor->Config["DefaultLanguage"] = $_SESSION['language_code'];
										$oFCKeditor->Create();
										?>

										<br>
										<br>
										<?php echo '<input type="submit" name="go" class="button" onClick="this.blur();" value="' . BUTTON_SAVE . '"/>'; ?>
										</form>

									</td>
								</tr>
							</table>
							<br>
						</td>
					</tr>
				</table>
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