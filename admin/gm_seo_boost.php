<?php
/* --------------------------------------------------------------
   gm_seo_boost.php 2009-01-29 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(configuration.php,v 1.40 2002/12/29); www.oscommerce.com
   (c) 2003	 nextcommerce (configuration.php,v 1.16 2003/08/19); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: configuration.php 1125 2005-07-28 09:59:44Z novalis $)

   Released under the GNU General Public License
   --------------------------------------------------------------*/

  require('includes/application_top.php');
	require_once('gm/classes/GMLangFileImport.php');
	
	if(isset($_POST['go_save']))
	{
		gm_set_conf('GM_SEO_BOOST_PRODUCTS', $_POST['GM_SEO_BOOST_PRODUCTS']);
		gm_set_conf('GM_SEO_BOOST_CATEGORIES', $_POST['GM_SEO_BOOST_CATEGORIES']);
		gm_set_conf('GM_SEO_BOOST_CONTENT', $_POST['GM_SEO_BOOST_CONTENT']);
		
		if($_POST['GM_SEO_BOOST_PRODUCTS'] == 'true' || $_POST['GM_SEO_BOOST_CATEGORIES'] == 'true' || $_POST['GM_SEO_BOOST_CONTENT'] == 'true'){
			xtc_db_query("UPDATE configuration SET configuration_value = 'false' WHERE configuration_key = 'SEARCH_ENGINE_FRIENDLY_URLS'");
		}
	}
	elseif(isset($_POST['repair']))
	{
		$coo_seo_boost = MainFactory::create_object('GMSEOBoost');
		$coo_seo_boost->repair('all');
	}

if(!file_exists(DIR_FS_CATALOG.'.htaccess')) $htaccess_disabled='DISABLED';

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
<table border="0" width="100%" cellspacing="0" cellpadding="2">
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
			<!-- gm_module //-->
			<div class="pageHeading" style="background-image:url(images/gm_icons/gambio.png)"><?php echo HEADING_TITLE; ?></div>
			<br />
			<form name="gm_style_edit" action="<?php echo xtc_href_link('gm_seo_boost.php'); ?>" method="post">
				<table border="0" width="100%" cellspacing="0" cellpadding="0" class="pdf_menu">
					<tr>
						<td class="dataTableHeadingContent" style="border-right: 0px;">
							<a href="<?php echo xtc_href_link('gm_seo_boost.php'); ?>">
								<?php echo GM_BOX_TITLE; ?>
							</a>
						</td>
					</tr>
				</table>
				<table border="0" width="100%" cellspacing="0" cellpadding="2" class="gm_border dataTableRow">
					<tr>
						<td class="main" valign="top" align="left" colspan="2">
							<?php echo GM_SEO_BOOST_TEXT; ?><br /><br />
						</td>
					</tr>
					<tr>
						<td width="30" class="main" valign="top" align="left">
							<?php if(gm_get_conf('GM_SEO_BOOST_PRODUCTS') == 'true') $gm_checked = 'checked="checked"'; else $gm_checked = '';	?>
							<input type="checkbox" name="GM_SEO_BOOST_PRODUCTS" value="true"<?php echo $gm_checked; echo $htaccess_disabled; ?> />
						</td>
						<td class="main" valign="top">
							<?php echo GM_TEXT_PRODUCTS; ?>
						</td>
					</tr>

					<tr>
						<td width="30" class="main" valign="top" align="left">
							<?php if(gm_get_conf('GM_SEO_BOOST_CATEGORIES') == 'true') $gm_checked = 'checked="checked"'; else $gm_checked = '';	?>
							<input type="checkbox" name="GM_SEO_BOOST_CATEGORIES" value="true"<?php echo $gm_checked; echo $htaccess_disabled; ?> />
						</td>
						<td class="main" valign="top">
							<?php echo GM_TEXT_CATEGORIES; ?>
						</td>
					</tr>
					<tr>
						<td width="30" class="main" valign="top" align="left">
							<?php if(gm_get_conf('GM_SEO_BOOST_CONTENT') == 'true') $gm_checked = 'checked="checked"'; else $gm_checked = '';	?>
							<input type="checkbox" name="GM_SEO_BOOST_CONTENT" value="true"<?php echo $gm_checked; echo $htaccess_disabled; ?> />
						</td>
						<td class="main" valign="top">
							<?php echo GM_TEXT_CONTENT; ?>
						</td>
					</tr>


					<tr>
						<td width="30" class="main" valign="top" align="left">
							&nbsp;
						</td>
						<td class="main" valign="top">
							&nbsp;
						</td>
					</tr>

					<tr>
						<td colspan="2" class="main" valign="top">
							<input type="submit" class="button" name="go_save" value="<?php echo GM_FORM_SUBMIT; ?>" />
						</td>
					</tr>
					<tr>
						<td colspan="2" class="main" valign="top">
							<br />
							<input type="submit" class="button" style="display:inline;" name="repair" value="<?php echo GM_FORM_REPAIR; ?>" />
							<?php
							if(isset($_POST['repair']))
							{
								echo GM_FORM_REPAIR_SUCCESS;
							}
							?>
						</td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
</table>
<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br />
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>