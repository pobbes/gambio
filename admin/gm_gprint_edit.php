<?php
/* --------------------------------------------------------------
   gm_gprint_edit.php 2009-12-15 mb
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2009 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/
?><?php 

$t_gm_languages = xtc_get_languages();

?>

<div class="gm_gprint_advice">
	<?php echo GM_GPRINT_ADVICES; ?>
</div>
				
<br />

<table style="margin-bottom:5px" border="0" cellpadding="0" cellspacing="0" width="100%" height="25">
	<tr class="dataTableHeadingRow">
		<td class="dataTableHeadingContentText" style="border-right: 0px; padding: 0px 20px 0px 10px;" id="surfaces_group_name_title"></td>
		<td class="dataTableHeadingContentText" style="border-right: 0px; text-align: right;  padding: 0px 10px; white-space: nowrap">
			<?php
			foreach($t_gm_languages AS $t_gm_language)
			{
				echo '&nbsp;&nbsp;<a href="' . $_SERVER['PHP_SELF'] . '?' . xtc_get_all_get_params(array('languages_id')) . 'languages_id=' . $t_gm_language['id'] . '"><img src="'.DIR_WS_LANGUAGES.$t_gm_language['directory'].'/admin/images/'.$t_gm_language['image'].'" border="0" alt="' . $t_gm_language['name'] . '" title="' . $t_gm_language['name'] . '" style="padding-top: 2px" /></a>';
			}
			?>	
		</td>	
	</tr>
</table>

<table style="border: 1px solid #dddddd" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr class="dataTableRow">
		<td style="font-size: 12px; padding: 0px 10px 11px 10px; text-align: justify;">
			<br />
			<div id="toolbar">
			
				<table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>
							<input class="button" type="button" name="show_create_surface_flyover" id="show_create_surface_flyover" value="<?php echo GM_GPRINT_BUTTON_CREATE_SURFACE; ?>" />
						</td>
						<td style="padding-left:5px">
							<input style="display: none;" class="button" type="button" name="show_create_element_flyover" id="show_create_element_flyover" value="<?php echo GM_GPRINT_BUTTON_CREATE_ELEMENT; ?>" />
						</td>
					</tr>
				</table>

				<div class="gm_gprint_flyover">
					<form id="create_surface_div">
						<div style="float: left;"><strong><?php echo GM_GPRINT_TEXT_NEW_SURFACE; ?></strong></div><div style="width: 100%; text-align: right;"><span style="cursor: pointer;" id="hide_create_surface_flyover">[X]</span></div><br />
						<table border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td><?php echo GM_GPRINT_TEXT_SIZE; ?> </td>
								<td><input type="text" class="input_number" id="surface_width" name="surface_width" value="350" />px <input type="text" class="input_number" id="surface_height" name="surface_height" value="200" />px (<?php echo GM_GPRINT_TEXT_WIDTH . ' x ' . GM_GPRINT_TEXT_HEIGHT; ?>)</td>
							</tr>	
							<?php			
							foreach($t_gm_languages AS $t_gm_language){
							?>
							<tr>
								<td style="padding-top: 12px;" valign="top" width="104"><?php echo GM_GPRINT_TEXT_NAME; ?> <span style="float: right;"><?php echo '<img src="'.DIR_WS_LANGUAGES.$t_gm_language['directory'].'/admin/images/'.$t_gm_language['image'].'" border="0" alt="' . $t_gm_language['name'] . '" title="' . $t_gm_language['name'] . '" />'; ?></span></td>
								<td>
								<input type="text" class="surface_name" id="surface_language_<?php echo $t_gm_language['id']; ?>" name="surface_language_<?php echo $t_gm_language['id']; ?>" value="" />
								</td>
							</tr>
							<?php
							}
							?> 		
						</table>
						<input style="margin: 17px 5px 0px 0px; float: left;" class="button" type="button" name="create_surface" id="create_surface" value="<?php echo GM_GPRINT_BUTTON_CREATE; ?>" />
						<img class="gm_gprint_wait" src="../gm/images/gprint/wait.gif" />
					</form>		

					<form id="create_element_div" name="create_element_form" action="" method="post" enctype="multipart/form-data">
						<div style="float: left;"><strong><?php echo GM_GPRINT_TEXT_NEW_ELEMENT; ?></strong></div><div style="width: 100%; text-align: right;"><span style="cursor: pointer;" id="hide_create_element_flyover">[X]</span></div><br />
						<table border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td><?php echo GM_GPRINT_TEXT_TYPE; ?> </td>
								<td>
									<select id="element_type" name="element_type" size="1">
										<option name="text" value="text" selected="selected"><?php echo GM_GPRINT_DIV_TEXT; ?></option>
										<option name="text_input" value="text_input"><?php echo GM_GPRINT_INPUT_TEXT; ?></option>
										<option name="text_input" value="textarea"><?php echo GM_GPRINT_TEXTAREA; ?></option>
										<option name="text_input" value="file"><?php echo GM_GPRINT_INPUT_FILE; ?></option>
										<option name="text_input" value="dropdown"><?php echo GM_GPRINT_DROPDOWN; ?></option>
										<option name="text_input" value="image"><?php echo GM_GPRINT_IMAGE; ?></option>
									</select>
								</td>
							</tr>	
							<tr class="create_element_size">
								<td><?php echo GM_GPRINT_TEXT_SIZE; ?> </td>
								<td><input type="text" class="input_number" id="element_width" name="element_width" value="330" />px <input type="text" class="input_number" id="element_height" name="element_height" value="100" />px (<?php echo GM_GPRINT_TEXT_WIDTH . ' x ' . GM_GPRINT_TEXT_HEIGHT; ?>)</td>
							</tr>
							<tr>
								<td><?php echo GM_GPRINT_TEXT_TOP; ?> </td>
								<td><input type="text" class="input_number" id="element_position_y" name="element_position_y" value="10" />px</td>
							</tr>
							<tr>
								<td><?php echo GM_GPRINT_TEXT_LEFT; ?> </td>
								<td><input type="text" class="input_number" id="element_position_x" name="element_position_x" value="10" />px</td>
							</tr>
							<tr>
								<td><?php echo GM_GPRINT_TEXT_Z_INDEX; ?> </td>
								<td><input type="text" class="input_number" id="element_z_index" name="element_z_index" value="0" /></td>
							</tr>
							<tr class="create_element_max_characters" style="display: none;">
								<td><?php echo GM_GPRINT_TEXT_MAX_CHARACTERS; ?> </td>
								<td><input type="text" class="input_number" id="element_max_characters" name="element_max_characters" value="0" /> <?php echo GM_GPRINT_TEXT_MAX_CHARACTERS_INFO; ?></td>
							</tr>
							<tr class="create_element_show_name" style="display: none;">
								<td><?php echo GM_GPRINT_TEXT_SHOW_NAME; ?> </td>
								<td><input type="checkbox" id="element_show_name" name="element_show_name" value="1" /></td>
							</tr>
							<?php
							reset($t_gm_languages);
							foreach($t_gm_languages AS $t_gm_language){
							?>
							<tr class="create_element_name">
								<td style="padding-top: 12px;" valign="top"><?php echo GM_GPRINT_TEXT_NAME; ?> <span style="float: right;"><?php echo '<img src="'.DIR_WS_LANGUAGES.$t_gm_language['directory'].'/admin/images/'.$t_gm_language['image'].'" border="0" alt="' . $t_gm_language['name'] . '" title="' . $t_gm_language['name'] . '" />'; ?></span></td>
								<td>
									<input type="text" id="element_name_<?php echo $t_gm_language['id']; ?>" name="element_name" class="element_name" value="" />
								</td>
							</tr>
							<?php
							}
							reset($t_gm_languages);
							foreach($t_gm_languages AS $t_gm_language){
							?>
							<tr class="create_element_value">
								<td style="padding-top: 12px;" valign="top"><?php echo GM_GPRINT_TEXT_VALUE; ?> <span class="add_field" style="cursor: pointer; font-weight: bold; line-height: 12px; font-size: 14px; display: none;">+</span> <span class="remove_field" style="cursor: pointer; font-weight: bold; line-height: 12px; font-size: 18px; display: none;">-</span><span style="float: right;"><?php echo '<img src="'.DIR_WS_LANGUAGES.$t_gm_language['directory'].'/admin/images/'.$t_gm_language['image'].'" border="0" alt="' . $t_gm_language['name'] . '" title="' . $t_gm_language['name'] . '" />'; ?></span></td>
								<td class="create_element_value_fields" id="create_element_value_fields_<?php echo $t_gm_language['id']; ?>">
									<textarea class="element_value" name="element_language_<?php echo $t_gm_language['id']; ?>"></textarea>
								</td>
							</tr>
							<?php
							}
							?>
							<tr class="create_element_allowed_extensions" style="display: none;">
								<td><?php echo GM_GPRINT_TEXT_ALLOWED_EXTENSIONS; ?> </td>
								<td>
									<input type="text" id="element_allowed_extensions" name="element_allowed_extensions" class="element_allowed_extensions" value="" /> <?php echo GM_GPRINT_TEXT_ALLOWED_EXTENSIONS_2; ?>
								</td>
							</tr>	
							<tr class="create_element_minimum_filesize" style="display: none;">
								<td><?php echo GM_GPRINT_TEXT_MINIMUM_FILESIZE; ?> </td>
								<td>
									<input type="text" id="element_minimum_filesize" name="element_minimum_filesize" class="input_number" value="0" /><?php echo GM_GPRINT_TEXT_MINIMUM_FILESIZE_2; ?>
								</td>
							</tr>
							<tr class="create_element_maximum_filesize" style="display: none;">
								<td><?php echo GM_GPRINT_TEXT_MAXIMUM_FILESIZE; ?> </td>
								<td>
									<input type="text" id="element_maximum_filesize" name="element_maximum_filesize" class="input_number" value="0" /><?php echo GM_GPRINT_TEXT_MAXIMUM_FILESIZE_2; ?>
								</td>
							</tr>							
							<?php 
							reset($t_gm_languages);
							foreach($t_gm_languages AS $t_gm_language){
							?>
							<tr class="create_element_image" style="display: none;">
								<td style="padding-top: 14px;" valign="top"><?php echo GM_GPRINT_TEXT_IMAGE; ?> <span style="float: right;"><?php echo '<img src="'.DIR_WS_LANGUAGES.$t_gm_language['directory'].'/admin/images/'.$t_gm_language['image'].'" border="0" alt="' . $t_gm_language['name'] . '" title="' . $t_gm_language['name'] . '" />'; ?></span></td>
								<td>
									<input type="file" id="element_image_<?php echo $t_gm_language['id']; ?>" name="element_image_<?php echo $t_gm_language['id']; ?>" class="input" value="" />
								</td>
							</tr>
							<?php
							}
							?>
						</table>

						<input style="margin: 17px 5px 0px 0px; float: left;" class="button" type="button" name="create_element" id="create_element" value="<?php echo GM_GPRINT_BUTTON_ADD; ?>" />
						<img class="gm_gprint_wait" src="../gm/images/gprint/wait.gif" />
					</form>	

					<form id="edit_surface_div">
						<div style="float: left;"><strong><?php echo GM_GPRINT_TEXT_SURFACE; ?>: <span id="surface_name_title"></span></strong></div><div style="width: 100%; text-align: right;"><span style="cursor: pointer;" id="hide_edit_surface_flyover">[X]</span></div><br />
						<table border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td><?php echo GM_GPRINT_TEXT_SIZE; ?> </td>
								<td><input type="text" class="input_number" id="current_surface_width" name="current_surface_width" value="" />px <input type="text" class="input_number" id="current_surface_height" name="current_surface_height" value="" />px (<?php echo GM_GPRINT_TEXT_WIDTH . ' x ' . GM_GPRINT_TEXT_HEIGHT; ?>)</td>
							</tr>	
							<?php
							reset($t_gm_languages);
							foreach($t_gm_languages AS $t_gm_language){
							?>
							<tr>
								<td style="padding-top: 12px;" valign="top" width="104"><?php echo GM_GPRINT_TEXT_NAME; ?> <span style="float: right"><?php echo '<img src="'.DIR_WS_LANGUAGES.$t_gm_language['directory'].'/admin/images/'.$t_gm_language['image'].'" border="0" alt="' . $t_gm_language['name'] . '" title="' . $t_gm_language['name'] . '" />'; ?></span></td>
								<td>
									<input type="text" class="current_surface_name" id="current_surface_language_<?php echo $t_gm_language['id']; ?>" name="current_surface_language_<?php echo $t_gm_language['id']; ?>" value="" />
								</td>
							</tr>
							<?php
							}
							?> 		
						</table>
						<input style="margin: 17px 4px 0px 1px; float: left;" class="button" type="button" name="update_current_surface" id="update_current_surface" value="<?php echo GM_GPRINT_BUTTON_UPDATE; ?>" />
						<input style="margin: 17px 0px 0px 1px; float: left;" class="button" type="button" name="delete_current_surface" id="delete_current_surface" value="<?php echo GM_GPRINT_BUTTON_DELETE; ?>" /> 
						<img class="gm_gprint_wait" src="../gm/images/gprint/wait.gif" />
					</form>

					<form id="edit_element_div">
						<div style="float: left;"><strong><?php echo GM_GPRINT_TEXT_ELEMENT; ?>: <span id="element_name_title"></span></strong></div><div style="width: 100%; text-align: right;"><span style="cursor: pointer;" id="hide_edit_element_flyover">[X]</span></div><br />
						<table border="0" cellpadding="0" cellspacing="0">
							<tr class="edit_element_size">
								<td><?php echo GM_GPRINT_TEXT_SIZE; ?> </td>
								<td><input type="text" class="input_number" id="current_element_width" name="current_element_width" value="" />px <input type="text" class="input_number" id="current_element_height" name="current_element_height" value="" />px (<?php echo GM_GPRINT_TEXT_WIDTH . ' x ' . GM_GPRINT_TEXT_HEIGHT; ?>)</td>
							</tr>
							<tr>
								<td><?php echo GM_GPRINT_TEXT_TOP; ?> </td>
								<td><input type="text" class="input_number" id="current_element_position_y" name="current_element_position_y" value="" />px</td>
							</tr>
							<tr>
								<td><?php echo GM_GPRINT_TEXT_LEFT; ?> </td>
								<td><input type="text" class="input_number" id="current_element_position_x" name="current_element_position_x" value="" />px</td>
							</tr>
							<tr>
								<td><?php echo GM_GPRINT_TEXT_Z_INDEX; ?> </td>
								<td><input type="text" class="input_number" id="current_element_z_index" name="current_element_z_index" value="" /></td>
							</tr>
							<tr class="edit_element_max_characters" style="display: none;">
								<td><?php echo GM_GPRINT_TEXT_MAX_CHARACTERS; ?> </td>
								<td><input type="text" class="input_number" id="current_element_max_characters" name="current_element_max_characters" value="" /> <?php echo GM_GPRINT_TEXT_MAX_CHARACTERS_INFO; ?></td>
							</tr>
							<tr class="edit_element_show_name" style="display: none;">
								<td><?php echo GM_GPRINT_TEXT_SHOW_NAME; ?> </td>
								<td><input type="checkbox" id="current_element_show_name" name="current_element_show_name" value="1" /></td>
							</tr>
							<?php
							reset($t_gm_languages);
							foreach($t_gm_languages AS $t_gm_language){
							?>
							<tr class="edit_element_name_value">
								<td style="padding-top: 12px;" valign="top"><?php echo GM_GPRINT_TEXT_NAME; ?> <span style="float: right"><?php echo '<img src="'.DIR_WS_LANGUAGES.$t_gm_language['directory'].'/admin/images/'.$t_gm_language['image'].'" border="0" alt="' . $t_gm_language['name'] . '" title="' . $t_gm_language['name'] . '" />'; ?></span></td>
								<td>
									<input type="text" class="current_element_name" id="current_element_name_<?php echo $t_gm_language['id']; ?>" name="current_element_name" value="" />
								</td>
							</tr>
							<?php
							}
							reset($t_gm_languages);
							foreach($t_gm_languages AS $t_gm_language){
							?>
							<tr class="edit_element_value">
								<td style="padding-top: 12px;" valign="top"><?php echo GM_GPRINT_TEXT_VALUE; ?> <span class="add_field" style="cursor: pointer; font-weight: bold; line-height: 12px; font-size: 14px; display: none;">+</span> <span class="remove_field" style="cursor: pointer; font-weight: bold; line-height: 12px; font-size: 18px; display: none;">-</span><span style="float: right"><?php echo '<img src="'.DIR_WS_LANGUAGES.$t_gm_language['directory'].'/admin/images/'.$t_gm_language['image'].'" border="0" alt="' . $t_gm_language['name'] . '" title="' . $t_gm_language['name'] . '" />'; ?></span></td>
								<td class="edit_element_value_fields" id="edit_element_value_fields_<?php echo $t_gm_language['id']; ?>">
								<textarea class="current_element_value" name="current_element_language_<?php echo $t_gm_language['id']; ?>"></textarea>
								</td>
							</tr>
							<?php
							}
							?>
							<tr class="edit_element_allowed_extensions" style="display: none;">
								<td><?php echo GM_GPRINT_TEXT_ALLOWED_EXTENSIONS; ?> </td>
								<td>
									<input type="text" id="current_element_allowed_extensions" name="current_element_allowed_extensions" class="current_element_allowed_extensions" value="" /> <?php echo GM_GPRINT_TEXT_ALLOWED_EXTENSIONS_2; ?>
								</td>
							</tr>
							<tr class="edit_element_minimum_filesize" style="display: none;">
								<td><?php echo GM_GPRINT_TEXT_MINIMUM_FILESIZE; ?> </td>
								<td>
									<input type="text" id="current_element_minimum_filesize" name="current_element_minimum_filesize" class="input_number" value="" /><?php echo GM_GPRINT_TEXT_MINIMUM_FILESIZE_2; ?>
								</td>
							</tr>
							<tr class="edit_element_maximum_filesize" style="display: none;">
								<td><?php echo GM_GPRINT_TEXT_MAXIMUM_FILESIZE; ?> </td>
								<td>
									<input type="text" id="current_element_maximum_filesize" name="current_element_maximum_filesize" class="input_number" value="" /><?php echo GM_GPRINT_TEXT_MAXIMUM_FILESIZE_2; ?>
								</td>
							</tr>
							<?php 
							reset($t_gm_languages);
							foreach($t_gm_languages AS $t_gm_language){
							?>
							<tr class="edit_element_image" style="display: none;">
								<td style="padding-top: 14px" valign="top"><?php echo GM_GPRINT_TEXT_IMAGE; ?> <span style="float: right"><?php echo '<img src="'.DIR_WS_LANGUAGES.$t_gm_language['directory'].'/admin/images/'.$t_gm_language['image'].'" border="0" alt="' . $t_gm_language['name'] . '" title="' . $t_gm_language['name'] . '" />'; ?></span></td>
								<td>
									<input type="file" id="edit_element_image_<?php echo $t_gm_language['id']; ?>" name="edit_element_image_<?php echo $t_gm_language['id']; ?>" class="input" value="" />
								</td>
							</tr>
							<?php
							}
							?> 		
						</table>
						<input style="margin: 17px 4px 0px 1px; float: left;" class="button" type="button" name="update_current_element" id="update_current_element" value="<?php echo GM_GPRINT_BUTTON_UPDATE; ?>" />
						<input style="margin: 17px 0px 0px 1px; float: left;" class="button" type="button" name="delete_current_element" id="delete_current_element" value="<?php echo GM_GPRINT_BUTTON_DELETE; ?>" /> 
						<img class="gm_gprint_wait" src="../gm/images/gprint/wait.gif" />
					</form>
				</div>
<br />	
				<table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>
							<input style="display: none;" class="button" type="button" name="show_edit_surface_flyover" id="show_edit_surface_flyover" value="<?php echo GM_GPRINT_BUTTON_EDIT_SURFACE; ?>" />
						</td>
						<td style="padding-left: 5px">
							<input style="display: none;" class="button" type="button" name="show_edit_element_flyover" id="show_edit_element_flyover" value="<?php echo GM_GPRINT_BUTTON_EDIT_ELEMENT; ?>" />
						</td>
					</tr>
				</table>
				<br />	
				<ul id="gm_gprint_tabs"></ul>
				<div id="gm_gprint_content"></div>
				
				
				<br />
				<br />
				
				<a href="gm_gprint.php"><input class="button" style="margin-right: 8px; display: inline; float: left" type="button" value="<?php echo GM_GPRINT_BUTTON_BACK_TO_OVERVIEW; ?>" /></a>
				<input class="button" type="button" onclick="$('#gm_gprint_help').toggle();" value="<?php echo GM_GPRINT_BUTTON_HELP; ?>" />
				
				<table border="0" cellpadding="0" cellspacing="0" id="gm_gprint_help">
					<tr>
						<td>
						<br />
						<br />
						<?php 
						echo GM_GPRINT_DESCRIPTION;
						?>
						</td>
					</tr>
				</table>
				
			</div>
			
		</td>
	</tr>
</table>
