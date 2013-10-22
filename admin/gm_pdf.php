<?php
/* --------------------------------------------------------------
   gm_pdf.php 2008-07-30 gambio
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

	?>

	<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
	<html <?php echo HTML_PARAMS; ?>>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>"> 
			<title><?php echo TITLE; ?></title>
			<link rel="stylesheet" href="<?php echo DIR_WS_CATALOG; ?>gm/javascript/jquery/plugins/farbtastic/farbtastic.css" type="text/css" />
			<link rel="stylesheet" type="text/css" href="<?php echo DIR_WS_ADMIN; ?>includes/stylesheet.css">		
		</head>
		<body topmargin="0" leftmargin="0" bgcolor="#FFFFFF" onload="<?php 
				if($_GET['action'] == 'logo') { 
					
					echo 'gm_get_content(\'' . xtc_href_link('gm_pdf_action.php', 'action=gm_pdf_content&subpage=logo&result=' . urlencode($result) . '') . '\', \'gm_pdf_content\', \'' . xtc_href_link('gm_pdf_action.php', 'action=gm_box_submenu_content') . '\')';
				
				} else { 

					echo 'gm_get_content(\'' . xtc_href_link('gm_pdf_action.php', 'action=gm_pdf_content') . '\', \'gm_pdf_content\', \'' . xtc_href_link('gm_pdf_action.php', 'action=gm_box_submenu_content') . '\')'; } 
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
									<br>
									<?php if(gm_pdf_is_installed()) { ?>
									<table border="0" width="100%" cellspacing="0" cellpadding="0" class="pdf_menu">
										<tr>
											<td width="120" onclick="gm_get_content('<?php echo xtc_href_link('gm_pdf_action.php', 'action=gm_pdf_content'); ?>', 'gm_pdf_content', '<?php echo xtc_href_link('gm_pdf_action.php', 'action=gm_box_submenu_content'); ?>')" valign="middle" class="dataTableHeadingContent">
												 <?php echo MENU_TITLE_CONTENT; ?>												  
											</td>
											<td width="120" onclick="gm_get_content('<?php echo xtc_href_link('gm_pdf_action.php', 'action=gm_pdf_fonts'); ?>', 'gm_pdf_fonts', '');" valign="middle" class="dataTableHeadingContent">
												 <?php echo MENU_TITLE_FONTS; ?>												  
											</td>
											<td width="120" onclick="gm_get_content('<?php echo xtc_href_link('gm_pdf_action.php', 'action=gm_pdf_conf'); ?>', 'gm_pdf_conf', '<?php echo xtc_href_link('gm_pdf_action.php', 'action=gm_box_submenu_conf'); ?>');" valign="middle" class="dataTableHeadingContent">
												 <?php echo MENU_TITLE_CONF; ?>												  
											</td>
											<td onclick="gm_get_content('<?php echo xtc_href_link('gm_pdf_action.php', 'action=gm_pdf_preview'); ?>', '', '');" valign="middle" class="dataTableHeadingContent" style="border-right: 0px;">
												 <?php echo MENU_TITLE_PREVIEW; ?>
											</td>
										</tr>
									</table>
									<div id="gm_box_submenu">
									</div>
									<table border="0" width="100%" cellspacing="0" cellpadding="2" class="gm_border dataTableRow">
										<tr>
											<td valign="top" class="main">												
												<div id="gm_box_content">
												</div>
											</td>
										</tr>
									</table>
									<?php	
										} else { 
									?>
									<table border="0" width="100%" cellspacing="0" cellpadding="0">
										<tr>
											<td width="120" class="dataTableHeadingContent" style="border-right: 0px;">
												<?php echo HEADING_TITLE; ?>
											</td>
										</tr>
									</table>
									<table border="0" width="100%" cellspacing="0" cellpadding="0" class="gm_border dataTableRow">
										<tr>
											<td valign="top" class="main">
											<?php echo TITLE_NOT_INSTALLED; ?>
											</td>											
										</tr>
									</table>
									<?php
										}
									?>
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
	<div id="gm_color_box">
		<div id="colorpicker"></div><br>
		<div align="center">
			<input type="text" id="color" name="color" value="#123456" />				
			<input type="hidden" id="actual" value="" /><br /><br />
			<input type="button" class="save button" style="cursor:pointer;width:90px;float:left" value="<?php echo BUTTON_SAVE; ?>">
			<input type="button" class="close button" style="cursor:pointer;width:90px;float:right" value="<?php echo BUTTON_CLOSE; ?>">
		</div>
	</div>