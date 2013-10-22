<?php
/* --------------------------------------------------------------
   gm_statusbar.php 2010-08-18 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
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
	
	if(empty($_GET['lang_id'])) $lang_id = $_SESSION['languages_id'];
	else $lang_id = $_GET['lang_id'];
	
	if(isset($_POST['go'])){
		if($_POST['gm_statusbar_active'] == 'true') gm_set_conf(GM_STATUSBAR_ACTIVE, 'true');
		else gm_set_conf(GM_STATUSBAR_ACTIVE, 'false');
		
		gm_set_content('GM_STATUSBAR_TEXT', gm_prepare_string($_POST['gm_statusbar_text']), $lang_id);
		
		if(is_numeric($_POST['gm_statusbar_speed']) && $_POST['gm_statusbar_speed'] > 0){
			gm_set_conf(GM_STATUSBAR_SPEED, (int)$_POST['gm_statusbar_speed']);
		}
		if(is_numeric($_POST['gm_statusbar_width']) && $_POST['gm_statusbar_width'] > 0){
			gm_set_conf(GM_STATUSBAR_WIDTH, (int)$_POST['gm_statusbar_width']);
		}
	}
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script type="text/javascript">
function gm_statusbar_check(){
	var gm_no_errors = true;
	if(!Number(document.getElementById('gm_statusbar_speed').value) || Number(document.getElementById('gm_statusbar_speed').value) < 1){
		alert('<?php echo GM_STATUSBAR_SPEED_ERROR; ?>');
		gm_no_errors = false;
	}
	if(!Number(document.getElementById('gm_statusbar_width').value) || Number(document.getElementById('gm_statusbar_width').value) < 1){
		alert('<?php echo GM_STATUSBAR_WIDTH_ERROR; ?>');
		gm_no_errors = false;
	}
	return gm_no_errors;
}
</script>
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
				 	<td class="dataTableHeadingContentText" style="border-right:0px; width:1%; padding-right:20px; white-space: nowrap"><?php echo HEADING_TITLE; ?></td> 
					<td class="dataTableHeadingContentText" style="padding-top: 6px; border-right:0px; text-align: right; white-space: nowrap">
						<?php
						$gm_get_languages = xtc_db_query("SELECT languages_id, name, image, directory FROM languages ORDER BY name");
						while($row = xtc_db_fetch_array($gm_get_languages)){
							echo '&nbsp;&nbsp;<a href="' . $_SERVER['PHP_SELF'] . '?lang_id=' . $row['languages_id'] . '"><img src="'.DIR_WS_LANGUAGES.$row['directory'].'/admin/images/'.$row['image'].'" border="0" alt="' . $row['name'] . '" title="' . $row['name'] . '" /></a>';
							if($row['languages_id'] == $lang_id) $lang_headline = $row['name'];
						}
						?>	
					</td>	
				</tr>
			</table>
			
			<table style="border: 1px solid #dddddd" border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr class="dataTableRow">
					<td style="font-size: 12px; padding: 0px 10px 11px 10px; text-align: justify">
						<br />
						<?php 
						echo '<strong>' . $lang_headline . '</strong>';
						?>
						<br />
						<br />
						<?php 
						echo GM_STATUSBAR_DESCRIPTION;
						?>
						<br />
						<br />
						<form name="gm_statusbar_form" action="<?php echo xtc_href_link('gm_statusbar.php', 'lang_id=' . $lang_id); ?>" method="post"  onsubmit="return gm_statusbar_check();">
						<input type="checkbox" name="gm_statusbar_active" value="true"<?php if(gm_get_conf('GM_STATUSBAR_ACTIVE') == 'true') echo ' checked'; ?> /> <?php echo GM_STATUSBAR_ACTIVATE_TEXT; ?>
						<br />
						<br />
						<?php echo GM_STATUSBAR_TEXT_TEXT; ?><input type="text" name="gm_statusbar_text" value="<?php $t_gm_statusbar_text = gm_get_content('GM_STATUSBAR_TEXT', $lang_id); echo htmlspecialchars_wrapper($t_gm_statusbar_text); ?>" size="100" />
						<br />
						<br />
						<?php echo GM_STATUSBAR_SPEED_TEXT; ?><input type="text" id="gm_statusbar_speed" name="gm_statusbar_speed" value="<?php echo gm_get_conf('GM_STATUSBAR_SPEED'); ?>" size="3" />
						<br />
						<br />
						<?php echo GM_STATUSBAR_WIDTH_TEXT; ?><input type="text" id="gm_statusbar_width" name="gm_statusbar_width" value="<?php echo gm_get_conf('GM_STATUSBAR_WIDTH'); ?>" size="3" />
						<br />
						<br />
						<?php 
						echo '<input style="margin-left:1px" type="submit" name="go" class="button" onClick="this.blur();" value="' . BUTTON_SAVE . '"/> '; 
						if(isset($gm_id_starts_success) && $gm_id_starts_success && $gm_id_starts_success2) echo GM_ID_STARTS_SUCCESS;
						elseif(isset($gm_id_starts_success)) echo GM_ID_STARTS_NO_SUCCESS;
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