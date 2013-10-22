<?php
/* --------------------------------------------------------------
   gm_meta.php 2008-06-05 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

gm_meta.php 08.04.2008 pt@gambio
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
	
	if(!empty($_POST['gm_submit'])) 
	{	
		$t_lang_id = $_GET['lang_id'];

		gm_set_content('GM_TRUSTED_SHOPS_WIDGET_USE',		gm_prepare_string($_POST['GM_TRUSTED_SHOPS_WIDGET_USE']),		$t_lang_id);
		gm_set_content('GM_TRUSTED_SHOPS_WIDGET_SHOP_NAME', gm_prepare_string($_POST['GM_TRUSTED_SHOPS_WIDGET_SHOP_NAME']),	$t_lang_id);
		gm_set_content('GM_TRUSTED_SHOPS_WIDGET_SHOP_ID',	gm_prepare_string($_POST['GM_TRUSTED_SHOPS_WIDGET_SHOP_ID']),	$t_lang_id);
		
		if($_POST['GM_TRUSTED_SHOPS_WIDGET_SHOW_CONFIRMATION']	== 1) 
		{
			gm_set_content('GM_TRUSTED_SHOPS_WIDGET_SHOW_CONFIRMATION', 1, $t_lang_id);
		} 
		else
		{ 
			gm_set_content('GM_TRUSTED_SHOPS_WIDGET_SHOW_CONFIRMATION',	0, $t_lang_id);	
		}

		if($_POST['GM_TRUSTED_SHOPS_WIDGET_SHOW_CHECKOUT']	== 1) 
		{
			gm_set_content('GM_TRUSTED_SHOPS_WIDGET_SHOW_CHECKOUT', 1, $t_lang_id);
		} 
		else
		{ 
			gm_set_content('GM_TRUSTED_SHOPS_WIDGET_SHOW_CHECKOUT', 0, $t_lang_id);	
		}
	}
	
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
									<table border="0" width="100%" cellspacing="0" cellpadding="0">
										<tr>
											<td width="250" valign="middle" class="dataTableHeadingContent">
												<a href="<?php echo xtc_href_link('gm_trusted_shops_widget.php', 'action=info'); ?>"><?php echo HEADING_TITLE; ?></a>												  
											</td>
											<td valign="middle" class="dataTableHeadingContent"  style="border-right: 0px;">
												 <a href="<?php echo xtc_href_link('gm_trusted_shops_widget.php', 'action=conf'); ?>"><?php echo HEADING_TITLE_CONF; ?></a>  
											</td>
										</tr>
									</table>
									<table border="0" width="100%" cellspacing="0" cellpadding="0" class="gm_border dataTableRow">
										<tr>
											<td valign="top" class="main">												
												<div id="gm_box_content" style="text-align:justify">
													<?php
														if($_GET['action'] == 'conf')
														{	
													?>
													<!-- BOF TS OPTIONS -->
													<table border="0" width="100%" cellspacing="0" cellpadding="2">
														<tr>
															<td valign="top" align="left" class="main">
																<?php 
																	include(DIR_FS_CATALOG . 'gm/inc/gm_get_language.inc.php');
																	include(DIR_FS_CATALOG . 'gm/inc/gm_get_language_link.inc.php');
																	
																	if(!empty($_GET['lang_id'])) 
																	{																	
																		$lang_id = $_GET['lang_id'];
																	} 
																	else 
																	{
																		$lang_id = $_SESSION['languages_id'];
																	}
																	$gm_trusted_content = gm_get_content(array('GM_TRUSTED_SHOPS_WIDGET_USE', 'GM_TRUSTED_SHOPS_WIDGET_SHOP_NAME', 'GM_TRUSTED_SHOPS_WIDGET_SHOP_ID'),$lang_id);

																?>
																<b><?php echo HEADING_TITLE . ' ' . constant(HEADING_RATING_PROFILE_ . trim($lang_id)); ?></b> 
															</td>
															<td valign="top" align="right" class="main">
																<?php 
																	echo gm_get_lang_link('gm_trusted_shops_widget.php', 'conf', '');
																?>
															</td>
														</tr>
														<tr>
															<td class="main" valign="top" colspan="2">
																&nbsp;
															</td>
														</tr>
													</table>
													<?php echo xtc_draw_form('gm_trusted_shops_widget', 'gm_trusted_shops_widget.php?action=conf&lang_id=' . $lang_id); ?>									
													<table border="0" width="100%" cellspacing="0" cellpadding="2">
														<tr>
															<td width="170" class="main" valign="top">
																<?php echo GM_TRUSTED_SHOPS_WIDGET_USE; ?>
															</td>
															<td class="main" valign="top">
																<?php echo GM_TRUSTED_SHOPS_WIDGET_YES; ?> <input type="radio" value="1" name="GM_TRUSTED_SHOPS_WIDGET_USE" <?php if($gm_trusted_content['GM_TRUSTED_SHOPS_WIDGET_USE'] == '1') echo 'checked'; ?>>
																<?php echo GM_TRUSTED_SHOPS_WIDGET_NO;  ?> <input type="radio" value="0" name="GM_TRUSTED_SHOPS_WIDGET_USE" <?php if($gm_trusted_content['GM_TRUSTED_SHOPS_WIDGET_USE'] == '0') echo 'checked'; ?>>
															</td>
														</tr>

														<tr>
															<td width="170" class="main" valign="top">
																<?php echo GM_TRUSTED_SHOPS_WIDGET_SHOP_NAME; ?>
															</td>
															<td class="main" valign="top">																
																<?php
																	echo xtc_draw_input_field('GM_TRUSTED_SHOPS_WIDGET_SHOP_NAME', gm_get_content('GM_TRUSTED_SHOPS_WIDGET_SHOP_NAME', $lang_id));
																?>
															</td>
														</tr>
														<tr>
															<td width="170" class="main" valign="top">
																<?php echo GM_TRUSTED_SHOPS_WIDGET_SHOP_ID; ?>
															</td>
															<td class="main" valign="top">
																<?php
																	echo xtc_draw_input_field('GM_TRUSTED_SHOPS_WIDGET_SHOP_ID', gm_get_content('GM_TRUSTED_SHOPS_WIDGET_SHOP_ID', $lang_id));
																?>
															</td>
														</tr>
														<tr>
															<td width="170" class="main" valign="top" colspan="2">
																&nbsp;
															</td>
														</tr>
														<tr>
															<td width="170" class="main" valign="top" colspan="2">
																<?php echo GM_TRUSTED_SHOPS_WIDGET_SHOW; ?>
															</td>
														</tr>
														<tr>
															<td class="main" valign="top" colspan="2">
																<input type="checkbox" name="GM_TRUSTED_SHOPS_WIDGET_SHOW_CHECKOUT" value="1" <?php echo (gm_get_content('GM_TRUSTED_SHOPS_WIDGET_SHOW_CHECKOUT', $lang_id) == 1) ? 'checked="checked"' : ''; ?> />
																<?php echo GM_TRUSTED_SHOPS_WIDGET_SHOW_CHECKOUT; ?>
															</td>
														</tr>
														<tr>
															<td class="main" valign="top" colspan="2">
																<input type="checkbox" name="GM_TRUSTED_SHOPS_WIDGET_SHOW_CONFIRMATION" value="1" <?php echo (gm_get_content('GM_TRUSTED_SHOPS_WIDGET_SHOW_CONFIRMATION', $lang_id) == 1) ? 'checked="checked"' : ''; ?> />
																<?php echo GM_TRUSTED_SHOPS_WIDGET_SHOW_CONFIRMATION; ?>
															</td>
														</tr>

														<tr>
															<td width="170" class="main" valign="top" colspan="2">
																&nbsp;
															</td>
														</tr>
														<tr>
															<td colspan="2" class="main" valign="top">
																<input class="button" type="submit" name="gm_submit" value="<?php echo GM_TRUSTED_FORM_SUBMIT; ?>">
															</td>
														</tr>
													</table>									
													<!-- EOF TS OPTIONS -->												

													<?php
														}
														else
														{													
													?>
													<!-- BOF TS INFO -->
													<?php echo GM_TRUSTED_SHOPS_INFO; ?>
													<!-- EOF TS INFO -->
													<?php
														}
													?>
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