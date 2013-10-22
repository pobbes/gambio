<?php
/* --------------------------------------------------------------
   gm_lightbox.php 2008-08-10 gambio
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
	
	$gm_lightbox_success = false;
	
	if(isset($_POST['go']))
	{
		if($_POST['lightbox_create_account'] == 1) gm_set_conf('GM_LIGHTBOX_CREATE_ACCOUNT', 'true'); else gm_set_conf('GM_LIGHTBOX_CREATE_ACCOUNT', 'false');
		if($_POST['lightbox_cart'] == 1) 	gm_set_conf('GM_LIGHTBOX_CART', 'true'); 		else gm_set_conf('GM_LIGHTBOX_CART', 'false');
		if($_POST['lightbox_checkout'] == 1) 	gm_set_conf('GM_LIGHTBOX_CHECKOUT', 'true'); 		else gm_set_conf('GM_LIGHTBOX_CHECKOUT', 'false');
		$gm_lightbox_success = true;
	}
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
		
			<div class="pageHeading" style="background-image:url(images/gm_icons/gambio.png)"><?php echo HEADING_TITLE; ?></div>
			<br />
			
			<span class="main">
			<table style="margin-bottom:5px" border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr class="dataTableHeadingRow">
				 	<td class="dataTableHeadingContentText" style="border-right: 0px"><?php echo HEADING_TITLE; ?></td>
				</tr>
			</table>
			
			<table style="border: 1px solid #dddddd" border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr class="dataTableRow">
					<td style="font-size: 12px; padding: 0px 10px 11px 10px; text-align: justify">
						<br />
						<?php 
						echo GM_LIGHTBOX_TEXT;
						?>
						<br />
						<br />
						<form name="gm_lightbox_form" action="<?php xtc_href_link('gm_lightbox.php'); ?>" method="post">
						<?php if(gm_get_conf('GM_LIGHTBOX_CREATE_ACCOUNT') == 'true') $gm_checked = ' checked="checked"'; else $gm_checked = '';	?>
						<input type="checkbox" name="lightbox_create_account" value="1"<?php echo $gm_checked; ?> /> <?php echo GM_LIGHTBOX_CREATE_ACCOUNT; ?>
						<br />
						<br />
						<?php if(gm_get_conf('GM_LIGHTBOX_CART') == 'true') $gm_checked = ' checked="checked"'; else $gm_checked = '';	?>
						<input type="checkbox" name="lightbox_cart" value="1"<?php echo $gm_checked; ?> /> <?php echo GM_LIGHTBOX_CART; ?>
						<br />
						<br />
						<?php if(gm_get_conf('GM_LIGHTBOX_CHECKOUT') == 'true') $gm_checked = ' checked="checked"'; else $gm_checked = '';	?>
						<input type="checkbox" name="lightbox_checkout" value="1"<?php echo $gm_checked; ?> /> <?php echo GM_LIGHTBOX_CHECKOUT; ?>
						<br />
						<br />
						<?php 
						echo '<input style="margin-left:1px" type="submit" name="go" class="button" onClick="this.blur();" value="' . BUTTON_SAVE . '"/> '; 
						if($gm_lightbox_success) echo '<br /><strong>' . GM_LIGHTBOX_SUCCESS . '</strong>';	
						?>
						</form>
					
					</td>
				</tr>
			</table>
			</span>	

    </td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br />
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>