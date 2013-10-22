<?php
/* --------------------------------------------------------------
   gm_lang_edit.php 2008-07-28 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

gm_ebay.php 2007-11-26 pt@gambio
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
			<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
		</head>
		<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
			<?php require(DIR_WS_INCLUDES . 'header.php'); ?>

			<script type="text/javascript" src="gm/javascript/GMLangEdit.js"></script>
			<script type="text/javascript">
			<!--
				var gmLangEdit = new GMLangEdit();
			//-->
			</script>

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
								
										<div class="main">
											<?php echo TITLE_INFO; ?>
										</div>
										<!-- SEARCH BOX -->
										<br />
										<table border="0" width="100%" cellspacing="0" cellpadding="0">
											<tr>
												<td width="120" class="dataTableHeadingContent" style="border-right: 0px;">
													<?php echo TITLE_KEYWORDS; ?>
												</td>
											</tr>
										</table>
										<table border="0" width="100%" cellspacing="0" cellpadding="0" class="gm_border dataTableRow">
											<tr>
												<td valign="middle" class="main">												
													<input style="font-size:14;height:25px;float:left;margin-right:5px;" id="constant_edit_needle" type="text" name="needle" value="" size="50" />
													<input onclick="gmLangEdit.send_form();" style="float:left;margin:0px;" class="button" id="go_search" type="button" name="go_search" value="<?php echo TITLE_SEARCH; ?>" />
												</td>
											</tr>
										</table>
										<br />

										<!-- RESULT BOX -->
										<div id="gm_status"> 
											<table border="0" width="100%" cellspacing="0" cellpadding="0">
												<tr>
													<td width="120" class="dataTableHeadingContent" style="border-right: 0px;">
														<?php echo TITLE_RESULTS; ?>
													</td>
												</tr>
											</table>
											<div id="results_box"> 
											</div>
										</div>
										<br />								
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