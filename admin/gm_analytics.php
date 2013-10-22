<?php
/* --------------------------------------------------------------
   gm_analytics.php 2008-07-28 gambio
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

	if(!empty($_POST['gm_submit'])) {		
		unset($_POST['gm_submit']);		
		foreach($_POST as $key => $value) {
			gm_set_conf($key, gm_prepare_string($value));
		}
	}
	
	$gm_ana_conf = gm_get_conf(array('GM_ANALYTICS_CODE', 'GM_ANALYTICS_CODE_USE'));
	

	?>

	<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
	<html <?php echo HTML_PARAMS; ?>>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>"> 
			<title><?php echo TITLE; ?></title>
			<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
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
						<table border="0" width="100%" cellspacing="0" cellpadding="0">
							<tr>
								<td>
									<div class="pageHeading" style="background-image:url(images/gm_icons/gambio.png)"><?php echo HEADING_TITLE; ?></div>
									<br />
									<table border="0" width="100%" cellspacing="0" cellpadding="0">
										<tr>
											<td width="120" class="dataTableHeadingContent">
												<?php echo HEADING_TITLE; ?>												  
											</td>
										</tr>
									</table>
									<table border="0" width="100%" cellspacing="0" cellpadding="0" class="gm_border dataTableRow">
										<tr>
											<td valign="top" class="main">										
												<?php echo xtc_draw_form('analytics', 'gm_analytics.php'); ?>									
													<table border="0" width="100%" cellspacing="0" cellpadding="2">
														<tr>
															<td width="160" class="main" valign="top">
																<?php echo GM_ANALYTICS_CODE; ?>
															</td>
															<td class="main" valign="top">
																<textarea style="width:300px;" name="GM_ANALYTICS_CODE" rows="10"><?php echo $gm_ana_conf['GM_ANALYTICS_CODE']; ?></textarea>
															</td>
														</tr>
														<tr>
															<td width="160" class="main" valign="top">
																<?php echo GM_ANALYTICS_CODE_USE; ?>
															</td>
															<td class="main" valign="top">
																<?php echo GM_ANALYTICS_YES; ?> <input type="radio" value="1" name="GM_ANALYTICS_CODE_USE" <?php if($gm_ana_conf['GM_ANALYTICS_CODE_USE'] == '1') echo 'checked'; ?>>
																<?php echo GM_ANALYTICS_NO;  ?> <input type="radio" value="0" name="GM_ANALYTICS_CODE_USE" <?php if($gm_ana_conf['GM_ANALYTICS_CODE_USE'] == '0') echo 'checked'; ?>>
															</td>
														</tr>
														<tr>
															<td width="160" class="main" valign="top">
																&nbsp;
															</td>
															<td class="main" valign="top">
																&nbsp;
															</td>
														</tr>
														<tr>
															<td colspan="2" class="main" valign="top">
																<input class="button" type="submit" name="gm_submit" value="<?php echo GM_ANALYTICS_FORM_SUBMIT; ?>">
															</td>
														</tr>
													</table>									
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