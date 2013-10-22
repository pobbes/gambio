<?php
/* --------------------------------------------------------------
   gm_gprint_configuration.php 2009-12-15 mb
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2009 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/
?><?php 

if(isset($_POST['save']))
{
	/*
	if(isset($_POST['file_extensions']))
	{
		$f_gm_file_extensions = $_POST['file_extensions'];
		$c_gm_file_extensions = preg_replace('/[^a-z0-9,]/', '', strtolower($f_gm_file_extensions));
		gm_set_conf('GM_GPRINT_ALLOWED_FILE_EXTENSIONS', $c_gm_file_extensions);
	}
	*/
	
	if(isset($_POST['auto_width']))
	{
		gm_set_conf('GM_GPRINT_AUTO_WIDTH', 1);
	}
	else
	{
		gm_set_conf('GM_GPRINT_AUTO_WIDTH', 0);
	}
	
	if(isset($_POST['show_tabs']))
	{
		gm_set_conf('GM_GPRINT_SHOW_TABS', 1);
	}
	else
	{
		gm_set_conf('GM_GPRINT_SHOW_TABS', 0);
	}
	
	if(isset($_POST['exclude_spaces']))
	{
		gm_set_conf('GM_GPRINT_EXCLUDE_SPACES', 1);
	}
	else
	{
		gm_set_conf('GM_GPRINT_EXCLUDE_SPACES', 0);
	}
	
	if($_POST['gm_gprint_position'] > 0)
	{
		gm_set_conf('GM_GPRINT_POSITION', (int)$_POST['gm_gprint_position']);
	}
	
	if(isset($_POST['show_products_description']))
	{
		gm_set_conf('GM_GPRINT_SHOW_PRODUCTS_DESCRIPTION', 1);
	}
	else
	{
		gm_set_conf('GM_GPRINT_SHOW_PRODUCTS_DESCRIPTION', 0);
	}
	
	$c_character_length = (int)$_POST['character_length'];
	gm_set_conf('GM_GPRINT_CHARACTER_LENGTH', $c_character_length);
	
	$c_uploads_per_ip = (int)$_POST['uploads_per_ip'];
	gm_set_conf('GM_GPRINT_UPLOADS_PER_IP', $c_uploads_per_ip);
	
	$c_uploads_per_ip_interval = (int)$_POST['uploads_per_ip_interval'];
	gm_set_conf('GM_GPRINT_UPLOADS_PER_IP_INTERVAL', $c_uploads_per_ip_interval);
}

$t_gm_file_extensions = gm_get_conf('GM_GPRINT_ALLOWED_FILE_EXTENSIONS');

$t_gm_auto_width_setting = gm_get_conf('GM_GPRINT_AUTO_WIDTH');
if($t_gm_auto_width_setting == 1)
{
	$t_gm_auto_width = 'checked="checked"';
}
else
{
	$t_gm_auto_width = '';
}

$t_gm_show_tabs_setting = gm_get_conf('GM_GPRINT_SHOW_TABS');
if($t_gm_show_tabs_setting == 1)
{
	$t_gm_show_tabs = 'checked="checked"';
}
else
{
	$t_gm_show_tabs = '';
}


$t_gm_exclude_spaces_setting = gm_get_conf('GM_GPRINT_EXCLUDE_SPACES');
if($t_gm_exclude_spaces_setting == 1)
{
	$t_gm_exclude_spaces = 'checked="checked"';
}
else
{
	$t_gm_exclude_spaces = '';
}


$t_gm_position_1 = '';
$t_gm_position_2 = '';
$t_gm_position_3 = '';

switch(gm_get_conf('GM_GPRINT_POSITION'))
{
	case '1':
		$t_gm_position_1 = 'checked="checked"';
		break;
	case '2':
		$t_gm_position_2 = 'checked="checked"';
		break;
	case '3':
		$t_gm_position_3 = 'checked="checked"';
		break;
}

	
$t_gm_show_products_description_setting = gm_get_conf('GM_GPRINT_SHOW_PRODUCTS_DESCRIPTION');
if($t_gm_show_products_description_setting == 1)
{
	$t_gm_show_products_description = 'checked="checked"';
}
else
{
	$t_gm_show_products_description = '';
}

$t_gm_minimum_upload_size = gm_get_conf('GM_GPRINT_MINIMUM_UPLOAD_SIZE');
$t_gm_maximum_upload_size = gm_get_conf('GM_GPRINT_MAXIMUM_UPLOAD_SIZE');

$t_gm_character_length = gm_get_conf('GM_GPRINT_CHARACTER_LENGTH');

$t_gm_uploads_per_ip = gm_get_conf('GM_GPRINT_UPLOADS_PER_IP');

$t_gm_uploads_per_ip_interval = gm_get_conf('GM_GPRINT_UPLOADS_PER_IP_INTERVAL');
?>

<table style="margin-bottom:5px" border="0" cellpadding="0" cellspacing="0" width="100%" height="25">
	<tr class="dataTableHeadingRow">
		<td class="dataTableHeadingContentText" style="width:1%; padding: 0px 20px 0px 10px; white-space: nowrap"><a href="gm_gprint.php"><?php echo GM_GPRINT_OVERVIEW; ?></a></td>
		<td class="dataTableHeadingContentText" style="border-right: 0px; padding: 0px 20px 0px 10px;"><?php echo GM_GPRINT_CONFIGURATION; ?></td>
	</tr>
</table>

<table style="border: 1px solid #dddddd" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr class="dataTableRow">
		<td style="font-size: 12px; padding: 10px 10px 12px 10px;">
			
			<div style="font-family: Verdana,Arial,sans-serif; font-size: 12px; font-weight: bold; text-transform:uppercase"><?php echo GM_GPRINT_CONFIGURATION_TEXT; ?></div>
			<br />
			<?php 
			if(isset($_POST['save']))
			{
				echo '<div class="gm_gprint_success">' . GM_GPRINT_SUCCESS . '</div><br class="gm_gprint_success" />';
				echo '<script type="text/javascript">setTimeout("$(\'.gm_gprint_success\').fadeOut(\'slow\')", 10000);</script>';
			}
			?>
				
			<form action="gm_gprint.php?action=configuration" method="post">
				<!-- 
				<strong><?php echo GM_GPRINT_ALLOWED_FILE_EXTENSIONS_TEXT; ?></strong><br />
				<input type="text" style="width: 120px;" name="file_extensions" value="<?php echo $t_gm_file_extensions; ?>" />
				<br />
				<br />
				-->				
				<strong><?php echo GM_GPRINT_EXCLUDE_SPACES_TEXT; ?></strong><br />
				<input type="checkbox" name="exclude_spaces" value="1" style="display: inline" <?php echo $t_gm_exclude_spaces; ?>/> <?php echo GM_GPRINT_EXCLUDE_SPACES_ACTIVATE_TEXT; ?>
				<br />
				<br />
				<strong><?php echo GM_GPRINT_SHOW_TABS_TEXT; ?></strong><br />
				<input type="checkbox" name="show_tabs" value="1" style="display: inline" <?php echo $t_gm_show_tabs; ?>/> <?php echo GM_GPRINT_SHOW_TABS_ACTIVATE_TEXT; ?>
				<br />
				<br />	
				<strong><?php echo GM_GPRINT_AUTO_WIDTH_TEXT; ?></strong><br />
				<input type="checkbox" name="auto_width" value="1" style="display: inline" <?php echo $t_gm_auto_width; ?>/> <?php echo GM_GPRINT_AUTO_WIDTH_ACTIVATE_TEXT; ?>
				<br />
				<br />
				
				<?php
				if( CURRENT_TEMPLATE == 'gambio' )
				{
				?>
				
				<strong><?php echo GM_GPRINT_POSITION_TEXT; ?></strong><br />
				<input type="radio" name="gm_gprint_position" value="1" style="display: inline" <?php echo $t_gm_position_1; ?>/><?php echo GM_GPRINT_POSITION_1_TEXT; ?><br />				
				<input type="radio" name="gm_gprint_position" value="2" style="display: inline" <?php echo $t_gm_position_2; ?>/><?php echo GM_GPRINT_POSITION_2_TEXT; ?><br />
				<input type="radio" name="gm_gprint_position" value="3" style="display: inline" <?php echo $t_gm_position_3; ?>/><?php echo GM_GPRINT_POSITION_3_TEXT; ?>
				<br />
				<br />
				<strong><?php echo GM_GPRINT_SHOW_PRODUCTS_DESCRIPTION_TEXT; ?></strong><br />
				<?php echo GM_GPRINT_SHOW_PRODUCTS_DESCRIPTION_ACTIVATE_TEXT; ?>
				<input type="checkbox" name="show_products_description" value="1" style="display: inline" <?php echo $t_gm_show_products_description; ?>/>
				<br />
				<br />
				
				<?php
				}
				?>
				
				<strong><?php echo GM_GPRINT_CHARACTER_LENGTH; ?></strong><br />
				<input type="text" name="character_length" style="margin: 5px 0px;" size="4" value="<?php echo $t_gm_character_length; ?>" /> <?php echo GM_GPRINT_CHARACTER_LENGTH_UNIT; ?>
				<br /><?php echo GM_GPRINT_CHARACTER_LENGTH_TEXT; ?>
				<br />
				<br />
				<strong><?php echo GM_GPRINT_ANTI_SPAM; ?></strong><br />
				<input type="text" name="uploads_per_ip" style="margin: 5px 0px;" size="4" value="<?php echo $t_gm_uploads_per_ip; ?>" /> <?php echo GM_GPRINT_UPLOADS_PER_IP_TEXT; ?><br />
				<input type="text" name="uploads_per_ip_interval" style="margin: 5px 0px;" size="4" value="<?php echo $t_gm_uploads_per_ip_interval; ?>" /> <?php echo GM_GPRINT_UPLOADS_PER_IP_INTERVAL_TEXT; ?><br />
				<br />
				<br />
				<input class="button" style="float: left; margin-right: 10px;" type="submit" name="save" value="<?php echo GM_GPRINT_BUTTON_UPDATE; ?>" />
				<a href="gm_gprint.php"><input class="button" style="width: auto;" type="button" value="<?php echo GM_GPRINT_BUTTON_BACK_TO_OVERVIEW; ?>" /></a>
			</form>
		</td>
	</tr>
</table>