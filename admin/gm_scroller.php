<?php
/* --------------------------------------------------------------
   gm_scroller.php 2008-08-10 gambio
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
	
	if(empty($_GET['lang_id'])) $lang_id = $_SESSION['languages_id'];
	else $lang_id = $_GET['lang_id'];
	
	if(isset($_POST['go'])){
		
		gm_set_content('GM_SCROLLER_CONTENT', gm_prepare_string($_POST['gm_scroller']), $lang_id);
		
		if(is_numeric($_POST['gm_scroller_height']) && $_POST['gm_scroller_height'] > 0){
			xtc_db_query("UPDATE gm_configuration SET gm_value = '" . (int)$_POST['gm_scroller_height'] . "' WHERE gm_key = 'GM_SCROLLER_HEIGHT'");
		}
		if(is_numeric($_POST['gm_scroller_speed']) && $_POST['gm_scroller_speed'] > 0){
			xtc_db_query("UPDATE gm_configuration SET gm_value = '" . (int)$_POST['gm_scroller_speed'] . "' WHERE gm_key = 'GM_SCROLLER_SPEED'");
		}
	}
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>">
<?php
if(preg_match('/MSIE [\d]{2}\./i', $_SERVER['HTTP_USER_AGENT']))
{
?>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<?php
}
?>
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script type="text/javascript" src="includes/general.js"></script>
<script type="text/javascript">
function gm_scroller_check(){
	var gm_no_errors = true;
	if(!Number(document.getElementById('gm_scroller_height').value) || Number(document.getElementById('gm_scroller_height').value) < 1){
		alert('<?php echo GM_SCROLLER_HEIGHT_ERROR; ?>');
		gm_no_errors = false;
	}
	if(!Number(document.getElementById('gm_scroller_speed').value) || Number(document.getElementById('gm_scroller_speed').value) < 1){
		alert('<?php echo GM_SCROLLER_SPEED_ERROR; ?>');
		gm_no_errors = false;
	}	
	return gm_no_errors;
}
</script>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onload="SetFocus();">
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
			echo GM_SCROLLER_TEXT;
			?>
			<br />
			<br />
			<form name="gm_scroller_form" action="<?php echo xtc_href_link('gm_scroller.php', 'lang_id='.$lang_id); ?>" method="post" enctype="multipart/form-data" onsubmit="return gm_scroller_check();">
				<?php
				if(USE_WYSIWYG == 'true'){
					require_once(DIR_FS_ADMIN . 'gm/fckeditor/fckeditor.php');
					$oFCKeditor = new FCKeditor('gm_scroller');
					$oFCKeditor->BasePath	= DIR_WS_ADMIN . 'gm/fckeditor/';
					$oFCKeditor->Height = 500;
					$oFCKeditor->Width = 245;
					$oFCKeditor->Value = gm_get_content('GM_SCROLLER_CONTENT', $lang_id); 
					$oFCKeditor->ToolbarSet = "Small";
					$oFCKeditor->Config["DefaultLanguage"] = $_SESSION['language_code'];
					$oFCKeditor->Create();
				}
				else{
					echo '<textarea id="gm_scroller" name="gm_scroller" wrap="" style="width:245px; height:320px">';
					echo htmlspecialchars_wrapper(gm_get_content('GM_SCROLLER_CONTENT', $lang_id));
					echo '</textarea>';
				}
				?>
				<br />
				<br />
				<?php 
				echo GM_SCROLLER_HEIGHT_TEXT;
				?>
				<input type="text" id="gm_scroller_height" name="gm_scroller_height" value="<?php echo gm_get_conf('GM_SCROLLER_HEIGHT'); ?>" size="2" />
				<br />
				<br />
				<?php 
				echo GM_SCROLLER_SPEED_TEXT;
				?>
				<input type="text" id="gm_scroller_speed" name="gm_scroller_speed" value="<?php echo gm_get_conf('GM_SCROLLER_SPEED'); ?>" size="2" />
				<br />
				<br />
				<?php echo '<input style="margin-left:1px" type="submit" name="go" class="button" onClick="this.blur();" value="' . BUTTON_SAVE . '"/>'; ?>
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