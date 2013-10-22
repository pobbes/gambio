<?php
/* --------------------------------------------------------------
   gm_sitemap.php 2008-06-25 gambio
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
	
	require_once(DIR_FS_CATALOG . 'gm/inc/gm_get_google_changefreq.inc.php');
	require_once(DIR_FS_CATALOG . 'gm/inc/gm_get_language.inc.php');
	require_once(DIR_FS_CATALOG . 'gm/inc/gm_get_language_link.inc.php');	
	
	if($_GET['update'] == '1') {
		foreach($_POST as $key => $value) {
			gm_set_conf($key, $value);
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
											<td width="150" valign="middle" class="dataTableHeadingContent">
												<a href="<?php echo xtc_href_link('gm_sitemap.php', 'action=gm_sitemap'); ?>"><?php echo MENU_TITLE_GM_SITEMAP; ?></a>												  
											</td>
											<td valign="middle" class="dataTableHeadingContent"  style="border-right: 0px;">
												 <a href="<?php echo xtc_href_link('gm_sitemap.php', 'action=gm_sitemap_conf'); ?>"><?php	echo MENU_TITLE_GM_SITEMAP_CONF; ?></a>  
											</td>
										</tr>
									</table>
									<table border="0" width="100%" cellspacing="0" cellpadding="0" class="gm_border dataTableRow">
										<tr>
											<td valign="top" class="main">												
												<div id="gm_box_content">
												<?php 

													switch(($_GET['action'])) {

														case 'gm_sitemap_conf':
															$gm_conf = gm_get_conf(array('GM_SITEMAP_GOOGLE_CHANGEFREQ', 'GM_SITEMAP_GOOGLE_PRIORITY', 'GM_SITEMAP_GOOGLE_LANGUAGE_ID'));
															include(DIR_FS_ADMIN . 'gm/gm_sitemap/gm_sitemap_conf.php');
														break;			

														default:
															include(DIR_FS_ADMIN . 'gm/gm_sitemap/gm_sitemap.php');
														break;
													}
												?>
												</div>
											</td>
										</tr>
									</table>
									<table id="gm_box_sitemap" border="0" width="100%" cellspacing="0" cellpadding="0" style="display:none;" class="gm_border dataTableRow">
										<tr>
											<td valign="top" class="main">												
												<div id="gm_box_google">
												</div>
											</td>
										</tr>
									</table>
									<table id="gm_box_sitemap_request" style="display:none;" border="0" width="100%" cellspacing="0" cellpadding="0" style="" class="gm_border dataTableRow">
										<tr>
											<td valign="top" class="main">												
												<div id="gm_box_request">
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