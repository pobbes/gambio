<?php
/* --------------------------------------------------------------
   gm_security.php 2008-08-07 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

gm_security.php 09.04.2008 pt@gambio
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

	if(!empty($_POST['gm_submit'])) {	
		
		unset($_POST['gm_submit']);	
			
			if($_POST['GM_LOGIN_TRYOUT'] > 1) {
				gm_set_conf('GM_LOGIN_TRYOUT', $_POST['GM_LOGIN_TRYOUT']);	
			}
		
		gm_set_conf('GM_LOGIN_TIMELINE',  $_POST['GM_LOGIN_TIMELINE']);
		gm_set_conf('GM_LOGIN_TIMEOUT',  $_POST['GM_LOGIN_TIMEOUT']);
		
		gm_set_conf('GM_SEARCH_TRYOUT', $_POST['GM_SEARCH_TRYOUT']);	
		gm_set_conf('GM_SEARCH_TIMELINE',  $_POST['GM_SEARCH_TIMELINE']);
		gm_set_conf('GM_SEARCH_TIMEOUT',  $_POST['GM_SEARCH_TIMEOUT']);
		
		if($_POST['price_offer_vvcode'] == 1) gm_set_conf('GM_PRICE_OFFER_VVCODE', 'true'); else gm_set_conf('GM_PRICE_OFFER_VVCODE', 'false');
		if($_POST['tell_a_friend_vvcode'] == 1) gm_set_conf('GM_TELL_A_FRIEND_VVCODE', 'true'); else gm_set_conf('GM_TELL_A_FRIEND_VVCODE', 'false');
		if($_POST['reviews_vvcode'] == 1) gm_set_conf('GM_REVIEWS_VVCODE', 'true'); else gm_set_conf('GM_REVIEWS_VVCODE', 'false');
		if($_POST['callback_service_vvcode'] == 1) gm_set_conf('GM_CALLBACK_SERVICE_VVCODE', 'true'); else gm_set_conf('GM_CALLBACK_SERVICE_VVCODE', 'false');
		if($_POST['contact_vvcode'] == 1) gm_set_conf('GM_CONTACT_VVCODE', 'true'); else gm_set_conf('GM_CONTACT_VVCODE', 'false');
		if($_POST['guestbook_vvcode'] == 1) gm_set_conf('GM_GUESTBOOK_VVCODE', 'true'); else gm_set_conf('GM_GUESTBOOK_VVCODE', 'false');
	}
	
	$gm_sec_conf = gm_get_conf(array('GM_LOGIN_TRYOUT', 'GM_LOGIN_TIMEOUT', 'GM_LOGIN_TIMELINE'));
	$gm_search_conf = gm_get_conf(array('GM_SEARCH_TRYOUT', 'GM_SEARCH_TIMEOUT', 'GM_SEARCH_TIMELINE'));
	

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
									<br />
									<table border="0" width="100%" cellspacing="0" cellpadding="0">
										<tr>
											<td width="120" class="dataTableHeadingContent" style="border-right: 0px;">
												<?php echo HEADING_TITLE; ?>					
											</td>
										</tr>
									</table>
									<table border="0" width="100%" cellspacing="0" cellpadding="2" class="gm_border dataTableRow">
										<tr>
											<td valign="top" class="main">										
												<?php echo xtc_draw_form('security', 'gm_security.php'); ?>									
													<table border="0" width="100%" cellspacing="0" cellpadding="2">
														<tr>
															<td colspan="2" class="main gm_strong" valign="top">
																<?php echo GM_TITLE_LOGIN; ?>
															</td>
														</tr>
														<tr>
															<td width="160" class="main" valign="top">
																<?php echo GM_SEC_TRYOUT; ?>
															</td>
															<td class="main" valign="top">
																<input type="text" name="GM_LOGIN_TRYOUT" value="<?php echo $gm_sec_conf['GM_LOGIN_TRYOUT']; ?>">
															</td>
														</tr>
														<tr>
															<td width="100" class="main" valign="top">
																<?php echo GM_LOGIN_TIMELINE; ?>
															</td>
															<td class="main" valign="top">
																<input type="text" name="GM_LOGIN_TIMELINE" value="<?php echo $gm_sec_conf['GM_LOGIN_TIMELINE']; ?>">
															</td>
														</tr>
														<tr>
															<td width="100" class="main" valign="top">
																<?php echo GM_SEC_TIMEOUT; ?>
															</td>
															<td class="main" valign="top">
																<input type="text" name="GM_LOGIN_TIMEOUT" value="<?php echo $gm_sec_conf['GM_LOGIN_TIMEOUT']; ?>">
															</td>
														</tr>
														<tr>
															<td colspan="2">
																&nbsp;
															</td>
														</tr>
													</table>
													<table border="0" width="100%" cellspacing="0" cellpadding="2">
														<tr>
															<td colspan="2" class="main gm_strong" valign="top">
																<?php echo GM_TITLE_SEARCH; ?>
															</td>
														</tr>
														<tr>
															<td width="160" class="main" valign="top">
																<?php echo GM_SEARCH_TRYOUT; ?>
															</td>
															<td class="main" valign="top">
																<input type="text" name="GM_SEARCH_TRYOUT" value="<?php echo $gm_search_conf['GM_SEARCH_TRYOUT']; ?>">
															</td>
														</tr>
														<tr>
															<td width="100" class="main" valign="top">
																<?php echo GM_SEARCH_TIMELINE; ?>
															</td>
															<td class="main" valign="top">
																<input type="text" name="GM_SEARCH_TIMELINE" value="<?php echo $gm_search_conf['GM_SEARCH_TIMELINE']; ?>">
															</td>
														</tr>
														<tr>
															<td width="100" class="main" valign="top">
																<?php echo GM_SEARCH_TIMEOUT; ?>
															</td>
															<td class="main" valign="top">
																<input type="text" name="GM_SEARCH_TIMEOUT" value="<?php echo $gm_search_conf['GM_SEARCH_TIMEOUT']; ?>">
															</td>
														</tr>
														<tr>
															<td colspan="2">
																&nbsp;
															</td>
														</tr>
													</table>
													<table border="0" width="100%" cellspacing="0" cellpadding="2">
														<tr>
															<td colspan="2" class="main gm_strong" valign="top">
																<?php echo GM_TITLE_VVCODE; ?>
															</td>
														</tr>
														<tr>
															<td class="main" valign="top">
																<?php if(gm_get_conf('GM_PRICE_OFFER_VVCODE') == 'true') $gm_checked = 'checked="checked"'; else $gm_checked = '';	?>
																<input type="checkbox" name="price_offer_vvcode" value="1"<?php echo $gm_checked; ?> />
																<?php echo GM_PRICE_OFFER_VVCODE; ?>
															</td>
														</tr>

														<tr>
															<td class="main" valign="top">
																<?php if(gm_get_conf('GM_TELL_A_FRIEND_VVCODE') == 'true') $gm_checked = 'checked="checked"'; else $gm_checked = '';	?>
																<input type="checkbox" name="tell_a_friend_vvcode" value="1"<?php echo $gm_checked; ?> />															
																<?php echo GM_TELL_A_FRIEND_VVCODE; ?>
															</td>
														</tr>

														<tr>
															<td class="main" valign="top">
																<?php if(gm_get_conf('GM_REVIEWS_VVCODE') == 'true') $gm_checked = 'checked="checked"'; else $gm_checked = '';	?>
																<input type="checkbox" name="reviews_vvcode" value="1"<?php echo $gm_checked; ?> />															
																<?php echo GM_REVIEWS_VVCODE; ?>
															</td>
														</tr>
														<tr>
															<td class="main" valign="top">
																<?php if(gm_get_conf('GM_CALLBACK_SERVICE_VVCODE') == 'true') $gm_checked = 'checked="checked"'; else $gm_checked = '';	?>
																<input type="checkbox" name="callback_service_vvcode" value="1"<?php echo $gm_checked; ?> />															
																<?php echo GM_CALLBACK_SERVICE_VVCODE; ?>
															</td>
														</tr>
														<tr>
															<td class="main" valign="top">
																<?php if(gm_get_conf('GM_GUESTBOOK_VVCODE') == 'true') $gm_checked = 'checked="checked"'; else $gm_checked = '';	?>
																<input type="checkbox" name="guestbook_vvcode" value="1"<?php echo $gm_checked; ?> />															
																<?php echo GM_GUESTBOOK_VVCODE; ?>
															</td>
														</tr>
														<tr>
															<td class="main" valign="top">
																<?php if(gm_get_conf('GM_CONTACT_VVCODE') == 'true') $gm_checked = 'checked="checked"'; else $gm_checked = '';	?>
																<input type="checkbox" name="contact_vvcode" value="1"<?php echo $gm_checked; ?> />															
																<?php echo GM_CONTACT_VVCODE; ?>
															</td>
														</tr>
														<tr>
															<td valign="middle" align="left" class="main">		
																&nbsp;
															</td>
														</tr>
														<tr>
															<td class="main" valign="top">
																<input class="button" type="submit" name="gm_submit" value="<?php echo GM_EBAY_FORM_SUBMIT; ?>">
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