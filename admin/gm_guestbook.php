<?php
/* --------------------------------------------------------------
   gm_guestbook.php 2008-08-10 gambio
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
	
	if(isset($_POST['go'])){
		
		if(isset($_POST['gm_guestbook_blacklist'])) gm_set_conf('GM_GUESTBOOK_BLACKLIST', gm_prepare_string(gm_clear_string($_POST['gm_guestbook_blacklist'])));
		
		if(isset($_POST['gm_customers_status'])){
			$gm_customers_status_ids = $_POST['gm_customers_status'];
			mysql_query("TRUNCATE gm_guestbook_customers_status");
			for($i = 0; $i < count($gm_customers_status_ids); $i++){
				mysql_query("INSERT INTO gm_guestbook_customers_status
											SET customers_status_id = '" . $gm_customers_status_ids[$i] . "'");
			}
		}
		
		if(isset($_POST['gm_guestbook_waiting_time'])) {
			if($_POST['gm_guestbook_vvcode'] == '1') gm_set_conf('GM_GUESTBOOK_VVCODE', 'true');
			else gm_set_conf('GM_GUESTBOOK_VVCODE', 'false');
			
			if(is_numeric($_POST['gm_guestbook_waiting_time']) && $_POST['gm_guestbook_waiting_time'] >= 0){
				gm_set_conf('GM_GUESTBOOK_WAITING_TIME', (int)$_POST['gm_guestbook_waiting_time']);
			}
		}
		
		if(isset($_POST['gm_guestbook_more'])) {
			
			if(is_numeric($_POST['gm_guestbook_entries_limit']) && $_POST['gm_guestbook_entries_limit'] > 0){
				gm_set_conf('GM_GUESTBOOK_ENTRIES_LIMIT', (int)$_POST['gm_guestbook_entries_limit']);
			}
			
			if($_POST['gm_guestbook_activate_entries'] == '1') gm_set_conf('GM_GUESTBOOK_ACTIVATE_ENTRIES', 'true');
			else gm_set_conf('GM_GUESTBOOK_ACTIVATE_ENTRIES', 'false');
			
			if($_POST['gm_guestbook_send_mail'] == '1') gm_set_conf('GM_GUESTBOOK_SEND_MAIL', 1);
			else gm_set_conf('GM_GUESTBOOK_SEND_MAIL', 0);
		}
		$gm_success = GM_GUESTBOOK_SUCCESS;		
	}
	
	$gm_customers_status = array();
	$gm_get_customers_status = mysql_query("SELECT
																							cs.customers_status_id AS id,
																							cs.customers_status_name AS name,
																							gcs.customers_status_id AS id2
																						FROM customers_status cs
																						LEFT JOIN gm_guestbook_customers_status gcs ON (cs.customers_status_id = gcs.customers_status_id)
																						WHERE cs.language_id = '" . $_SESSION['languages_id'] . "'");
	while($row = mysql_fetch_array($gm_get_customers_status)){
		if($row['id2'] != '') $checked = ' checked="checked"';
		else $checked = '';
		$gm_customers_status[] = array('ID' => $row['id'], 'NAME' => $row['name'], 'CHECKED' => $checked);
	}
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script type="text/javascript">
function gm_guestbook_check(){
	var gm_no_errors = true;
	if((!Number(document.getElementById('gm_guestbook_waiting_time').value) && document.getElementById('gm_guestbook_waiting_time').value != '0')|| Number(document.getElementById('gm_guestbook_waiting_time').value < 0)){
		alert('<?php echo GM_GUESTBOOK_WAITING_TIME_ERROR; ?>');
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

<?php
if(gm_get_env_info('TEMPLATE_VERSION') >= FIRST_GX2_TEMPLATE_VERSION)
{
	echo '<img src="images/gm_icons/warning.png" height="16" width="16" class="template_warning" /> <span style="font-weight: bold;">' . TEMPLATE_ADVICE . '</span><br /><br />';
}
?>

<table style="margin-bottom:5px" border="0" cellpadding="0" cellspacing="0" width="100%">
 <tr class="dataTableHeadingRow">
 	<td class="dataTableHeadingContentText" style="width:1%; padding-right:20px; white-space: nowrap"><a href="gm_guestbook.php?content=blacklist"><?php echo GM_GUESTBOOK_BLACKLIST; ?></a></td>
	<td class="dataTableHeadingContentText" style="width:1%; padding-right:20px; white-space: nowrap"><a href="gm_guestbook.php?content=status"><?php echo GM_GUESTBOOK_CUSTOMERS_STATUS; ?></a></td>
	<td class="dataTableHeadingContentText" style="width:1%; padding-right:20px; white-space: nowrap"><a href="gm_guestbook.php?content=vvcode"><?php echo GM_GUESTBOOK_VVCODE_TITLE; ?></a></td>
	<td class="dataTableHeadingContentText" style="border-right: 0px"><a href="gm_guestbook.php?content=more"><?php echo GM_GUESTBOOK_MORE; ?></a></td>
 </tr>
</table>

<table style="border: 1px solid #dddddd" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr class="dataTableRow">
		<td style="font-size: 12px; padding: 0px 10px 12px 10px; text-align: justify">

			<?php if(isset($gm_success)) echo '<br />' . $gm_success . '<br /><br />'; ?>
			<br />
			<form name="gm_guestbook_form" action="<?php echo xtc_href_link('gm_guestbook.php', 'content='.$_GET['content']); ?>" method="post" onsubmit="return gm_guestbook_check();">
			<?php if(empty($_GET['content']) || $_GET['content'] == 'blacklist'){ ?>
			<strong><?php echo GM_GUESTBOOK_BLACKLIST; ?></strong>
			<br />
			<br />
			<?php echo GM_GUESTBOOK_BLACKLIST_TEXT; ?>
			<br />
			<br />
			<textarea name="gm_guestbook_blacklist" cols="80" rows="8"><?php echo gm_get_conf('GM_GUESTBOOK_BLACKLIST'); ?></textarea>
			<br />
			<br />
			<?php } elseif($_GET['content'] == 'status'){ ?>
			<strong><?php echo GM_GUESTBOOK_CUSTOMERS_STATUS; ?></strong>
			<br />
			<br />
			<?php echo GM_GUESTBOOK_CUSTOMERS_STATUS_TEXT; ?>
			<br />
			<br />
			<?php
			for($i = 0; $i < count($gm_customers_status); $i++){
				echo '<input type="checkbox" name="gm_customers_status[]" value="' . $gm_customers_status[$i]['ID'] . '"' . $gm_customers_status[$i]['CHECKED'] . ' /> ' . $gm_customers_status[$i]['NAME'] . '<br />';
			}
			?>
			<br />
			<?php } elseif($_GET['content'] == 'vvcode'){ ?>
			<strong><?php echo GM_GUESTBOOK_VVCODE_TITLE; ?></strong>
			<br />
			<br />
			<?php echo GM_GUESTBOOK_VVCODE_TEXT; ?>
			<br />
			<br />
			<input type="checkbox" name="gm_guestbook_vvcode" value="1"<?php if(gm_get_conf('GM_GUESTBOOK_VVCODE') == 'true') echo ' checked="checked"'; ?> /> <?php echo GM_GUESTBOOK_VVCODE; ?>
			<br />
			<br />
			<?php echo GM_GUESTBOOK_WAITING_TIME; ?> 
			<input type="text" name="gm_guestbook_waiting_time" id="gm_guestbook_waiting_time" value="<?php echo gm_get_conf('GM_GUESTBOOK_WAITING_TIME'); ?>" size="2" />
			<br />
			<br />
			<?php } elseif($_GET['content'] == 'more'){ ?>
			<strong><?php echo GM_GUESTBOOK_ENTRIES_LIMIT; ?></strong>
			<br />
			<br />
			<input type="text" name="gm_guestbook_entries_limit" id="gm_guestbook_entries_limit" value="<?php echo gm_get_conf('GM_GUESTBOOK_ENTRIES_LIMIT'); ?>" size="2" />
			<br />
			<br />
			<br />
			<strong><?php echo GM_GUESTBOOK_ACTIVATE_ENTRIES; ?></strong>
			<br />
			<br />
			<input type="checkbox" name="gm_guestbook_activate_entries" id="gm_guestbook_activate_entries" value="1"<?php if(gm_get_conf('GM_GUESTBOOK_ACTIVATE_ENTRIES') == 'true') echo ' checked="checked"'; ?> /> <?php echo GM_GUESTBOOK_ACTIVATE_ENTRIES_TEXT; ?>
			<br />
			<br />
			<br />
			<strong><?php echo GM_GUESTBOOK_SEND_MAIL; ?></strong>
			<br />
			<br />
			<input type="checkbox" name="gm_guestbook_send_mail" id="gm_guestbook_send_mail" value="1"<?php if(gm_get_conf('GM_GUESTBOOK_SEND_MAIL') == 1) echo ' checked="checked"'; ?> /> <?php echo GM_GUESTBOOK_SEND_MAIL_TEXT; ?>
			<br />
			<br />
			<br />
			<input type="hidden" name="gm_guestbook_more" value="1" />
			<?php } ?>
			<input type="submit" name="go" class="button" onClick="this.blur();" value="<?php echo GM_GUESTBOOK_BUTTON_UPDATE; ?>"/> 
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