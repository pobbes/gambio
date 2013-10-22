<?php
/* --------------------------------------------------------------
   gm_counter.php 2008-07-02 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

gm_counter.php 2007-11-26 pt@gambio
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

	<html <?php echo HTML_PARAMS; ?>>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>"> 
			<title><?php echo TITLE; ?></title>
			<link rel="stylesheet" type="text/css" href="<?php echo HTTP_SERVER . DIR_WS_CATALOG; ?>gm/javascript/jquery/plugins/datepicker/datePicker.css">			
			<link rel="stylesheet" type="text/css" href="<?php echo DIR_WS_ADMIN; ?>includes/stylesheet.css">	
			<link rel="stylesheet" type="text/css" href="<?php echo HTTP_SERVER . DIR_WS_CATALOG; ?>gm/javascript/jquery/ui/datepicker/css/ui-lightness/jquery-ui-1.8.11.custom.css">			
		</head>
		<body topmargin="0" leftmargin="0" bgcolor="#FFFFFF" onload="<?php echo 'gm_get_content(\'' . xtc_href_link('gm_counter_action.php', 'action=gm_counter_visitor&subpage=daily'); ?>', 'gm_counter_visitor', '<?php echo xtc_href_link('gm_counter_action.php', 'action=gm_box_submenu_visitor'); ?>')">

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
									<table border="0" width="100%" cellspacing="0" cellpadding="0" class="pdf_menu border">
										<tr>
											<td width="120" onclick="<?php echo 'gm_get_content(\'' . xtc_href_link('gm_counter_action.php', 'action=gm_counter_visitor&subpage=daily'); ?>', 'gm_counter_visitor', '<?php echo xtc_href_link('gm_counter_action.php', 'action=gm_box_submenu_visitor'); ?>')" valign="middle" class="dataTableHeadingContent">
												 <?php echo GM_COUNTER_TITLE_VISITOR; ?>												  
											</td>
											<td width="120" onclick="gm_get_content('<?php echo xtc_href_link('gm_counter_action.php', 'action=gm_counter_pages&subpage=today'); ?>', 'gm_counter_pages', '<?php echo xtc_href_link('gm_counter_action.php', 'action=gm_box_submenu_pages'); ?>');" valign="middle" class="dataTableHeadingContent">
												 <?php echo GM_COUNTER_TITLE_PAGES; ?>												  
											</td>
											<td width="120" onclick="gm_get_content('<?php echo xtc_href_link('gm_counter_action.php', 'action=gm_counter_user&subpage=1'); ?>', 'gm_counter_user', '<?php echo xtc_href_link('gm_counter_action.php', 'action=gm_box_submenu_user'); ?>');" valign="middle" class="dataTableHeadingContent">
												 <?php echo GM_COUNTER_TITLE_USER_INFO; ?>												  
											</td>
											<td width="120" onclick="gm_get_content('<?php echo xtc_href_link('gm_counter_action.php', 'action=gm_counter_search&subpage=intern'); ?>', 'gm_counter_search', '<?php echo xtc_href_link('gm_counter_action.php', 'action=gm_box_submenu_search'); ?>');" valign="middle" class="dataTableHeadingContent">
												 <?php echo GM_COUNTER_TITLE_SEARCHTERMS; ?>												  
											</td>
											<td onclick="gm_get_content('<?php echo xtc_href_link('gm_counter_action.php', 'action=gm_counter_conf'); ?>', '', '');" valign="middle" class="dataTableHeadingContent" style="border-right: 0px;">
												 <?php echo GM_COUNTER_TITLE_CONF; ?>												  
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