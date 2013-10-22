<?php
/* --------------------------------------------------------------
   gm_ebay.php 2008-06-27 gambio
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
		
	$gmebay = MainFactory::create_object('GMEbay', array($gm_ebay_conf));

	$gm_ebay_conf = $gmebay->gmEbay_admin();

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
									<!-- gm_module //-->
									<div class="pageHeading" style="background-image:url(images/gm_icons/gambio.png)"><?php echo HEADING_TITLE; ?></div>
									<br>
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
									<?php
										
										/* check what to use - curl or fsockopen */
										if (function_exists('curl_init')) {
											$gm_ebay_use = 'curl';
										} elseif(function_exists('fsockopen')) {
											$gm_ebay_use = 'fsockopen';
										} else {
											$gm_ebay_use = false;
										}
										
										// case curl or fsockopen not available
										if(!$gm_ebay_use) {
									?>
									<table   border="0" width="100%" cellspacing="" cellpadding="2">
										<tr>
											<td class="main" valign="top">
												<?php echo GM_EBAY_NOT_READY; ?>
											</td>
										</tr>
									</table>
									<?php
										
										} else {									

									?>
									<?php echo xtc_draw_form(GM_EBAY_FORM_NAME, 'gm_ebay.php'); ?>									
									<table border="0" width="100%" cellspacing="2" cellpadding="2">
										<tr>
											<td width="200" class="main" valign="top">
												<?php echo GM_EBAY_TYP; ?>
											</td>
											<td class="main" valign="top">
																								<?php 
													echo 
														xtc_draw_pull_down_menu(
																				'GM_EBAY_TYP', 
																				array(
																						array('id' => '1',		'text' => GM_EBAY_STORE_EXISTS) ,
																						array('id' => '0',		'text' => GM_EBAY_STORE_NOT_EXISTS) ,
																				
																					), 
																				$gm_ebay_conf['GM_EBAY_TYP'], 'id="GM_EBAY_TYP" style="width:200px"');
											?>

											</td>
										</tr>
										<tr>
											<td width="200" class="main" valign="top">
												<div id="gm_store"	style="display:none;"><?php echo GM_EBAY_STORE_TEXT; ?></div>
												<div id="gm_user"	style="display:none;"><?php echo GM_EBAY_NAME_TEXT; ?></div>
											</td>
											<td class="main" valign="top">
												<input type="text" name="GM_EBAY_NAME" value="<?php echo $gm_ebay_conf['GM_EBAY_NAME']; ?>"  style="width:200px">
												<input type="hidden" id ="GM_EBAY_HIDDEN_TYP" name="GM_EBAY_HIDDEN_TYP" value="<?php echo $gm_ebay_conf['GM_EBAY_TYP']; ?>">
											</td>
										</tr>
										<tr>
											<td width="200" class="main" valign="top">
												<?php echo GM_EBAY_COUNT_TEXT; ?>
											</td>
											<td class="main" valign="top">
												<input type="text" name="GM_EBAY_COUNT" value="<?php echo $gm_ebay_conf['GM_EBAY_COUNT']; ?>" style="width:200px">
											</td>
										</tr>
										<tr>
											<td width="200" class="main" valign="top">
												<?php echo GM_EBAY_COUNTRY_TEXT; ?>
											</td>
											<td class="main" valign="top">
												<?php 
													echo 
														xtc_draw_pull_down_menu(
																				'GM_EBAY_SITE_ID', 
																				array(
																						array('id' => '15',		'text' => 'AU') ,
																						array('id' => '16',		'text' => 'AT') ,
																						array('id' => '123',	'text' => 'BENL'),
																						array('id' => '23',		'text' => 'BEFR'),
																						array('id' => '2',		'text' => 'CA'),
																						array('id' => '71',		'text' => 'FR'),
																						array('id' => '77',		'text' => 'DE'),
																						array('id' => '201',	'text' => 'HK'),
																						array('id' => '205',	'text' => 'IE'),
																						array('id' => '203',	'text' => 'IN'),
																						array('id' => '201',	'text' => 'IT'),
																						array('id' => '207',	'text' => 'MY'),
																						array('id' => '146',	'text' => 'NL'),
																						array('id' => '211',	'text' => 'PH'),
																						array('id' => '212',	'text' => 'PL'),
																						array('id' => '216',	'text' => 'SG'),
																						array('id' => '186',	'text' => 'ES'),
																						array('id' => '218',	'text' => 'SE'),
																						array('id' => '193',	'text' => 'CH'),
																						array('id' => '3',		'text' => 'UK'),
																						array('id' => '0',		'text' => 'US')
																				
																					), 
																				$default = $gm_ebay_conf['GM_EBAY_SITE_ID'],  'style="width:200px"');
											?>
 											</td>
										</tr>
										<tr>
											<td width="200" class="main" valign="top">
												<?php echo GM_EBAY_STATUS_TEXT; ?>
											</td>
											<td class="main" valign="top">
												<input type="radio" name="GM_EBAY_ACTIVE" value="true" <?php if($gm_ebay_conf['GM_EBAY_ACTIVE'] == 'true') echo 'checked'; ?>> <?php echo GM_EBAY_STATUS_TRUE; ?>
												<input type="radio" name="GM_EBAY_ACTIVE" value="false" <?php if($gm_ebay_conf['GM_EBAY_ACTIVE'] == 'false') echo 'checked'; ?>> <?php echo GM_EBAY_STATUS_FALSE; ?>
											</td>
										</tr>
										<tr>
											<td width="200" class="main" valign="top">
												&nbsp;
											</td>
											<td class="main" valign="top">
												&nbsp;
											</td>
										</tr>
										<tr>
											<td width="200" class="main" valign="top">
												<input type="hidden" name="GM_EBAY_USE" value="<?php echo $gm_ebay_use; ?>">
												<input class="button" type="submit" name="gm_submit" value="<?php echo GM_EBAY_FORM_SUBMIT; ?>">
											</td>
											<td class="main" valign="top">
												&nbsp;
											</td>
										</tr>
									</table>									
									</form>
									<?php } ?>
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