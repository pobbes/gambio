<?php
/* --------------------------------------------------------------
   gm_logo.php 2008-07-29 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

gm_logo.php 08.04.2008 pt@gambio
	Gambio OHG
	http://www.gambio.de
	Copyright (c) 2007 Gambio OHG
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
	
	include(DIR_FS_CATALOG . 'gm/inc/gm_check_upload.inc.php');
?>

	<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
	<html <?php echo HTML_PARAMS; ?>>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>"> 
			<title><?php echo TITLE; ?></title>
			<link rel="stylesheet" type="text/css" href="<?php echo DIR_WS_ADMIN; ?>includes/stylesheet.css">	
			
		</head>
		<body topmargin="0" leftmargin="0" bgcolor="#FFFFFF">

			<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
			<script type="text/javascript" src="<?php echo DIR_WS_CATALOG; ?>gm/javascript/jquery/plugins/jquery.dimensions.js"></script>
			<script type="text/javascript" src="<?php echo DIR_WS_ADMIN; ?>gm/javascript/gm_logo.js"></script>

			<table border="0" width="100%" cellspacing="2" cellpadding="2">
				<tr>
					<td class="columnLeft2" width="<?php echo BOX_WIDTH; ?>" valign="top">
						<table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
							<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
						</table>
					</td>
					<td class="boxCenter" width="100%" valign="top">
						<table border="0" width="100%" cellspacing="0" cellpadding="0">
							<tr>
								<td>
									<div class="pageHeading" style="background-image:url(images/gm_icons/gambio.png)"><?php echo HEADING_TITLE; ?></div>
									<br>
									<table border="0" width="100%" cellspacing="0" cellpadding="0" class="pdf_menu">
										<tr>
											<td valign="middle" class="dataTableHeadingContent">
												<a href="<?php echo xtc_href_link('gm_logo.php', 'gm_logo=gm_logo_shop'); ?>"><?php echo MENU_TITLE_GM_LOGO_SHOP; ?></a>												  
											</td>
											<td valign="middle" class="dataTableHeadingContent">
												 <a href="<?php echo xtc_href_link('gm_logo.php', 'gm_logo=gm_logo_flash'); ?>"><?php echo MENU_TITLE_GM_LOGO_FLASH; ?></a>											  
											</td>
											<td valign="middle" class="dataTableHeadingContent">
												 <a href="<?php echo xtc_href_link('gm_logo.php', 'gm_logo=gm_logo_mail'); ?>"><?php echo MENU_TITLE_GM_LOGO_MAIL; ?></a>												  
											</td>
											<td valign="middle" class="dataTableHeadingContent">
												 <a href="<?php echo xtc_href_link('gm_logo.php', 'gm_logo=gm_logo_pdf'); ?>"><?php echo MENU_TITLE_GM_LOGO_PDF; ?></a>											  
											</td>
											<td valign="middle" class="dataTableHeadingContent">
												 <a href="<?php echo xtc_href_link('gm_logo.php', 'gm_logo=gm_logo_overlay'); ?>"><?php echo MENU_TITLE_GM_LOGO_OVERLAY; ?></a>											  
											</td>
											<td valign="middle" class="dataTableHeadingContent">
												 <a href="<?php echo xtc_href_link('gm_logo.php', 'gm_logo=gm_logo_ebay'); ?>"><?php echo MENU_TITLE_GM_LOGO_EBAY; ?></a>												  
											</td>
											<td valign="middle" class="dataTableHeadingContent">
												 <a href="<?php echo xtc_href_link('gm_logo.php', 'gm_logo=gm_logo_favicon'); ?>"><?php echo MENU_TITLE_GM_LOGO_FAVICON; ?></a>												  
											</td>
											<td valign="middle" class="dataTableHeadingContent" style="border-right: 0px;">
												 <a href="<?php echo xtc_href_link('gm_logo.php', 'gm_logo=gm_logo_cat'); ?>"><?php echo MENU_TITLE_GM_LOGO_CAT; ?></a>												  
											</td>
										</tr>
									</table>
									<form enctype="multipart/form-data" method="post" action="<?php echo xtc_href_link('gm_logo.php', 'gm_logo=' . $_GET['gm_logo'] . ''); ?>">
									<table border="0" width="100%" cellspacing="0" cellpadding="0" class="gm_border dataTableRow">
										<tr>
											<td valign="top" class="main">												
												<div id="gm_box_content">
												<?php include(DIR_FS_ADMIN . 'gm_logo_action.php'); ?>
												</div>
											</td>
										</tr>
									</table>
									</form>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<div id="imageviewer"></div>
			<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
		</body>
	</html>
	<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>