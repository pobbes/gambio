<?php
/* --------------------------------------------------------------
   gm_emails.php 2010-08-17 mb
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
include(DIR_FS_CATALOG . 'gm/inc/gm_save_template_file.inc.php');

$c_id		= (int)$_GET['id'];
$c_lang_id	= (int)$_GET['lang'];

if(isset($c_id)){
	require_once(DIR_FS_ADMIN . 'gm/fckeditor/fckeditor.php');
}

if(empty($c_lang_id)) $gm_lang = $_SESSION['language'];
else{
	$gm_get_language = xtc_db_query("SELECT directory FROM languages WHERE languages_id = '" . $c_lang_id . "' ORDER BY name");
	if(xtc_db_num_rows($gm_get_language) == 1){
		$row = xtc_db_fetch_array($gm_get_language);
		$gm_lang = $row['directory'];
	}
	else $gm_lang = $_SESSION['language'];
}

if(isset($_GET['gm_type']) && $_GET['gm_type'] == 'txt') $c_gm_type = 'txt';
else $c_gm_type = 'html';


if(isset($_POST['go']) )
{
	switch($_POST['backup_action']) {
		case 'save':
			if(!gm_save_template_file($c_id, gm_correct_config_tag($_POST['gm_emails_content']), $gm_lang, $c_gm_type))
                $messageStack->add(GM_ERROR_PERMISSION, 'error');
			break;

		case 'save_backup':
			xtc_db_query("UPDATE gm_emails
										SET backup_user_" . $c_gm_type . " = '" . xtc_db_input(gm_correct_config_tag($_POST['gm_emails_content'])) . "'
										WHERE
											gm_email_id = '" . $c_id . "'
											AND languages_id = '" . $c_lang_id . "'");
			gm_save_template_file($c_id, gm_correct_config_tag($_POST['gm_emails_content']), $gm_lang, $c_gm_type);
			break;

		case 'restore_backup':
			$gm_get_backup = xtc_db_query("SELECT backup_user_" . $c_gm_type . "
																			FROM gm_emails
																			WHERE
																				gm_email_id = '" . $c_id . "'
																				AND languages_id = '" . $c_lang_id . "'");
			$data = xtc_db_fetch_array($gm_get_backup);
			gm_save_template_file($c_id, $data['backup_user_' . $c_gm_type], $gm_lang, $c_gm_type);
			break;

		case 'restore_original':
			$gm_get_original = xtc_db_query("SELECT backup_original_" . $c_gm_type . "
																				FROM gm_emails
																				WHERE
																					gm_email_id = '" . $c_id . "'
																					AND languages_id = '" . $c_lang_id . "'");
			$data = xtc_db_fetch_array($gm_get_original);
			gm_save_template_file($c_id, $data['backup_original_' . $c_gm_type], $gm_lang, $c_gm_type);
			break;
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
<?php
if(!empty($c_id)){
?>
<script type="text/javascript" language="JavaScript">
	var t_gm_preview = false;
	
	function gm_emails_preview(gm_type){
		window.open('', 'gm_emails_preview', 'toolbar=0, width=800, height=600, scrollbars=yes');
		if(gm_type == 'txt') document.gm_emails_form.action = '<?php echo xtc_href_link('gm_emails_preview.php', 'id='.$c_id.'&type=txt'); ?>';
		else document.gm_emails_form.action = '<?php echo xtc_href_link('gm_emails_preview.php', 'id='.$c_id.'&type=html'); ?>';
		document.gm_emails_form.target = 'gm_emails_preview';
		document.gm_emails_form.submit();
		t_gm_preview = true;
	}

	function gm_emails_submit(){
		if((t_gm_preview && document.getElementById('backup_action').checked) || document.getElementById('backup_action').checked == false)
		{
			document.gm_emails_form.action = '<?php echo xtc_href_link('gm_emails.php', 'id='.$c_id.'&lang='.$c_lang_id.'&gm_type='.$c_gm_type); ?>';
			document.gm_emails_form.target = '';
			return true;
		}
		else
		{
			alert('<?php echo str_replace("'", "\'", GM_EMAILS_PREVIEW); ?>');
			return false;
		}
	}

</script>
<?php
}
?>
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
				 	<td class="dataTableHeadingContentText" style="border-right:0px"><?php echo GM_EMAILS_TITLE; ?></td>
				</tr>
			</table>

			<table style="border: 1px solid #dddddd" border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr class="dataTableRow">
					<td style="font-size: 12px; padding: 0px 10px 11px 10px; text-align: justify">
						<br />

						<ul type="square">
						<?php
						//LOAD template list from database
						if(empty($c_lang_id)) $languages_id = (int)$_SESSION['languages_id'];
						else $languages_id = $c_lang_id;
						$gm_get_email_templates = xtc_db_query("SELECT
																												languages_id,
																												gm_email_id
																										FROM gm_emails
																										WHERE languages_id = '" . $languages_id . "'
																										ORDER BY gm_email_id");
						while(($row = xtc_db_fetch_array($gm_get_email_templates) )) {
							if($c_id == $row['gm_email_id']) $gm_template_name = constant('GM_EMAILS_TEMPLATE_' . $row['gm_email_id']);
							?>
							<li><a href="<?php echo xtc_href_link('gm_emails.php', 'id='.$row['gm_email_id'].'&lang='.$row['languages_id']); ?>"><?php echo constant('GM_EMAILS_TEMPLATE_' . $row['gm_email_id']); ?></a><br />
							<?php
						}
						?>
						</ul>

					</td>
				</tr>
			</table>

			<?php
			if(!empty($c_id)){

				$gm_get_templates = xtc_db_query("SELECT
																						filename,
																						folder
																					FROM gm_emails
																					WHERE gm_email_id = '" . $c_id . "'");
				$templates = xtc_db_fetch_array($gm_get_templates);
			?>

				<br />
				<br />

				<table style="margin-bottom:5px" border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr class="dataTableHeadingRow">
					 	<td class="dataTableHeadingContentText" style="width:1%; padding-right:20px; white-space: nowrap"><?php echo '<a href="' . $_SERVER['PHP_SELF'] . '?id=' . $c_id . '&lang=' . $c_lang_id . '&gm_type=html">HTML</a> '; ?></td>
						<td class="dataTableHeadingContentText" style="width:1%; padding-right:20px; white-space: nowrap"><?php echo '<a href="' . xtc_href_link('gm_emails.php', 'id='.$c_id.'&lang='.$c_lang_id.'&gm_type=txt') . '">TEXT</a> '; ?></td>
						<td class="dataTableHeadingContentText" style="border-right:0px; text-align: right; padding-top: 6px; white-space: nowrap">
							<?php
							$gm_get_languages = xtc_db_query("SELECT languages_id, name, image, directory FROM languages ORDER BY name");
							while($row = xtc_db_fetch_array($gm_get_languages)){
								echo '&nbsp;&nbsp;<a style="a:hover { font-weight:bold; color:green; text-decoration:none; }" href="' . $_SERVER['PHP_SELF'] . '?id=' . $c_id . '&lang=' . $row['languages_id'] . '&gm_type=' . $c_gm_type . '"><img src="'.DIR_WS_LANGUAGES.$row['directory'].'/admin/images/'.$row['image'].'" border="0" alt="' . $row['name'] . '" title="' . $row['name'] . '" /></a>';
								if($row['languages_id'] == $languages_id) $lang_headline = $row['name'];
							}
							?>
						</td>
					</tr>
				</table>

				<table style="border: 1px solid #dddddd" border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr class="dataTableRow">
						<td style="font-size: 12px; padding: 0px 10px 11px 10px; text-align: justify">

							<form action="<?php echo xtc_href_link('gm_emails.php', 'id='.$c_id.'&lang='.$c_lang_id.'&gm_type='.$c_gm_type); ?>" name="gm_emails_form" method="post">
							<?php if($c_gm_type == 'html'){
							?>
							<br />
							<strong>HTML (<?php echo $gm_template_name . ' - ' . $lang_headline; ?>)</strong>
							<br /><br />
							<?php
								@clearstatcache();
								$fp = fopen(DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/' . $templates['folder'] . 'mail/' . $gm_lang . '/' . $templates['filename'] . '.html', "r");
								$content = fread($fp, filesize(DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/' . $templates['folder'] . '/mail/' . $gm_lang . '/' . $templates['filename'] . '.html'));
								fclose($fp);

								if(USE_WYSIWYG == 'true'){
									$oFCKeditor = new FCKeditor('gm_emails_content');
									$oFCKeditor->BasePath	= DIR_WS_ADMIN . 'gm/fckeditor/';
									$oFCKeditor->Height = 400;
									$oFCKeditor->Value = $content;
									$oFCKeditor->ToolbarSet = "Content";
									$oFCKeditor->Config["CustomConfigurationsPath"] = DIR_WS_ADMIN . "gm/fckeditor/gm_config.js";
									$oFCKeditor->Config["DefaultLanguage"] = $_SESSION['language_code'];
									$oFCKeditor->Create();
								}
								else{
									echo '<textarea id="gm_emails_content" name="gm_emails_content" wrap="" style="width:100%; height:320px">';
									echo htmlspecialchars_wrapper($content);
									echo '</textarea>';
								}
							?>
							<br />
							<br />
							<?php } else{
							?>
							<br />
							<strong>TEXT (<?php echo $gm_template_name . ' - ' . $lang_headline; ?>)</strong>
							<br /><br />
							<textarea id="gm_emails_content" name="gm_emails_content" wrap="" style="width:100%; height:320px"><?php
							@clearstatcache();
							$fp = fopen(DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/' . $templates['folder'] . '/mail/' . $gm_lang . '/' . $templates['filename'] . '.txt', "r");
							echo $content = fread($fp, filesize(DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/' . $templates['folder'] . '/mail/' . $gm_lang . '/' . $templates['filename'] . '.txt'));
							fclose($fp);
							?></textarea>
							<br />
							<br />
							<?php } ?>

						<input type="radio" id="backup_action" name="backup_action" value="save" checked="checked"> 			<?php echo GM_EMAILS_SAVE ?><br>
						<input type="radio" name="backup_action" value="save_backup"> 			<?php echo GM_EMAILS_SAVE_BACKUP ?><br>
						<input type="radio" name="backup_action" value="restore_backup"> 		<?php echo GM_EMAILS_RESTORE_BACKUP ?><br>
						<input type="radio" name="backup_action" value="restore_original"> 	<?php echo GM_EMAILS_RESTORE_ORIGINAL ?><br />
						<br />
						<input style="float:left; margin-left:1px" type="button" class="button" name="html" value="<?php echo GM_PREVIEW; ?>" onclick="gm_emails_preview('<?php echo $c_gm_type; ?>')" />
						<input type="submit" class="button" name="go" value="OK" onclick="return gm_emails_submit()" />
					</form>

						</td>
					</tr>
				</table>

			<?php
			}
			?>

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