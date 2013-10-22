<?php
/* 
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


	if(isset($_POST['gm_submit'])) 
	{
		if(gm_is_valid_trusted_shop_id($_POST['trusted_shop_id']) == false) 
		{
			$msg = '<font color=red><strong>Die eingegebene Shop-ID ist ung�ltig.</strong></font>';
		} 
		else
		{
			$msg = '
				<font color=#008000><strong>Wir gratulieren!</strong></font><br>
				Folgende Elemente wurden in Ihrem Shop freigeschaltet:<br><br>
				- die Seite "Trusted Shops" im Content Manager<br>
				- das Trusted Shops G�tesiegels in der Men�box "Trusted Shops"<br>
				- die Anmeldung zur Geld-zur�ck-Garantie in der Bestellbest�tigungsseite
			';
			mysql_query('
				UPDATE content_manager
				SET content_status = "1"
				WHERE content_group = "15"
			');
		}
		mysql_query('UPDATE gm_configuration SET gm_value="'.$_POST['trusted_shop_id'] .'" WHERE gm_key="TRUSTED_SHOP_ID"');
		echo mysql_error();
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
												<a href="<?php echo xtc_href_link('gm_trusted_shop_id.php', ''); ?>"><?php echo HEADING_TITLE; ?></a>												  
											</td>
											<td valign="middle" class="dataTableHeadingContent"  style="border-right: 0px;">
												 <a href="<?php echo xtc_href_link('gm_trusted_shop_id.php', 'action=conf'); ?>"><?php echo HEADING_TITLE_CONF; ?></a>  
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
																<b><?php echo HEADING_TITLE; ?></b> 
															</td>
															<td valign="top" align="right" class="main">
																&nbsp;
															</td>
														</tr>
														<tr>
															<td class="main" valign="top" colspan="2">
																&nbsp;
															</td>
														</tr>
													</table>
													<?php echo xtc_draw_form('gm_trusted_shop_id', 'gm_trusted_shop_id.php?action=conf'); ?>									
													<table border="0" width="100%" cellspacing="0" cellpadding="2">
														<tr>
															<td width="170" class="main" valign="top">
																<?php echo GM_TRUSTED_SHOPS_ID; ?>
															</td>
															<td class="main" valign="top">																
																<?php
																	echo xtc_draw_input_field('trusted_shop_id', gm_get_conf('TRUSTED_SHOP_ID'), 'size=40');
																?>
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
														<tr>
															<td width="170" class="main" valign="top" colspan="2">
																&nbsp;
															</td>
														</tr>
														<tr>
															<td colspan="2" class="main" valign="top">
																<?php 
																	if($msg != '')
																	{
																		echo $msg; 
																	}
																	?>
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