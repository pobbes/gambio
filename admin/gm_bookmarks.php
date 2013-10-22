<?php
/* --------------------------------------------------------------
   gm_bookmarks.php 2008-08-06 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

gm_pdf.php 2007-11-26 pt@gambio
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
	include(DIR_FS_CATALOG . 'gm/inc/gm_get_bookmarks.inc.php');	
	include(DIR_FS_CATALOG . 'gm/inc/gm_edit_bookmarks.inc.php');	
	
	if($_GET['action'] == 'gm_edit_bookmarks') {
		$gm_result = gm_edit_bookmarks();
	}
?>

	<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
	<html <?php echo HTML_PARAMS; ?>>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>"> 
			<title><?php echo TITLE; ?></title>
			<link rel="stylesheet" type="text/css" href="<?php echo DIR_WS_ADMIN; ?>includes/stylesheet.css">		
		</head>
		<body topmargin="0" leftmargin="0" bgcolor="#FFFFFF" onload="
			<?php 
				echo 'gm_get_content(\'' . xtc_href_link('gm_bookmarks_action.php', 'action=gm_bookmarks&gm_result=' . $gm_result . '') . '\')';
			?>">

			<?php require(DIR_WS_INCLUDES . 'header.php'); ?>

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
									<br />
									<table border="0" width="100%" cellspacing="0" cellpadding="0" class="pdf_menu">
										<tr>
											<td width="120" onclick="gm_get_content('<?php echo xtc_href_link('gm_bookmarks_action.php', 'action=gm_bookmarks'); ?>', 'gm_box_content', '')" valign="middle" class="dataTableHeadingContent">
												 <?php echo MENU_TITLE_BOOKMARKS; ?>												  
											</td>
											<td width="120" onclick="gm_get_content('<?php echo xtc_href_link('gm_bookmarks_action.php', 'action=gm_edit_bookmarks'); ?>', 'gm_box_content', '');" valign="middle" class="dataTableHeadingContent">
												 <?php echo MENU_TITLE_NEW_BOOKMARKS; ?>												  
											</td>
											<td onclick="gm_get_content('<?php echo xtc_href_link('gm_bookmarks_action.php', 'action=gm_bookmarks_options'); ?>', 'gm_box_content', '');" valign="middle" class="dataTableHeadingContent"  style="border-right: 0px;">
												 <?php echo MENU_TITLE_BOOKMARKS_OPTIONS; ?>												  
											</td>
										</tr>
									</table>
									<div id="gm_box_submenu">
									</div>
									<table border="0" width="100%" cellspacing="0" cellpadding="0" class="gm_border dataTableRow">
										<tr>
											<td valign="top" class="main">												
												<div id="gm_box_content">
												</div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
		</body>
	</html>
	<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>