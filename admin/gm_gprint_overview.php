<?php
/* --------------------------------------------------------------
   gm_gprint_overview.php 2009-12-15 mb
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
	<?php echo GM_GPRINT_OVERVIEW_ADVICE; ?>
</div>
<br />

<div id="gm_gprint_save_sucsess" class="gm_gprint_success" style="display: none;"><?php echo GM_GPRINT_SET_NAME_CHANGE_SUCCESS; ?></div>

<table border="0" cellpadding="0" cellspacing="0" width="100%" height="25">
	<tr class="dataTableHeadingRow">
		<td class="dataTableHeadingContentText" style="width:1%; padding: 0px 20px 0px 10px; white-space: nowrap"><?php echo GM_GPRINT_OVERVIEW; ?></td>
		<td class="dataTableHeadingContentText" style="border-right: 0px; padding: 0px 20px 0px 10px;"><a href="gm_gprint.php?action=configuration"><?php echo GM_GPRINT_CONFIGURATION; ?></a></td>
	</tr>
</table>

<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td valign="top">
			<?php 
			$t_found_surfaces_groups = false;
			
			$coo_gm_gprint_product_manager = new GMGPrintProductManager();
			
			$t_gm_gprint_surfaces_groups = $coo_gm_gprint_product_manager->get_surfaces_groups();
			
			for($i = 0; $i < count($t_gm_gprint_surfaces_groups); $i++)
			{
				$t_found_surfaces_groups = true;
				echo '<div class="sets_overview" id="set_' . $t_gm_gprint_surfaces_groups[$i]['ID'] . '" style="border-bottom: 1px dotted #000000; background-color: #f7f7f7; height: 18px; padding: 3px 10px 5px 10px; cursor: pointer">';
				echo '<a href="gm_gprint.php?action=edit&id=' . $t_gm_gprint_surfaces_groups[$i]['ID'] . '&languages_id=' . $_SESSION['languages_id'] . '"><img style="float: left" src="' . DIR_WS_IMAGES . 'icons/preview.gif" border="0" alt="' . GM_GPRINT_BUTTON_EDIT . '" title="' . GM_GPRINT_BUTTON_EDIT . '"></a><span id="set_name_' . $t_gm_gprint_surfaces_groups[$i]['ID'] . '" style="padding: 4px 0px 0px 20px; display: block; font-family: Verdana,Arial,sans-serif; font-size: 12px">' . $t_gm_gprint_surfaces_groups[$i]['NAME'] . '</span>';
				echo '</div>';
			}
			?>			
		</td>
		<td width="200" valign="top">
			<div class="gm_gprint_menu" align="center">
				
				<div id="gm_gprint_selected_options">
				
				<div class="gm_gprint_menu_heading"><?php echo GM_GPRINT_TEXT_SELECTED_SET; ?></div>
				<form action="gm_gprint.php" method="get">
					<input class="button" type="submit"  value="<?php echo GM_GPRINT_BUTTON_EDIT; ?>" />
					<input type="hidden" class="set_id" name="id" value="" />
					<input type="hidden" name="action" value="edit" />
					<input type="hidden" name="languages_id" value="<?php echo $_SESSION['languages_id']; ?>" />
				</form>
				<form>
					<input class="button" type="button" id="delete_set" value="<?php echo GM_GPRINT_BUTTON_DELETE; ?>" />
					<input type="hidden" class="set_id" id="delete_set_id" name="id" value="" />
				</form>
				<br />
				<form action="gm_gprint.php" method="get">
					<span class="gm_gprint_menu_text"><?php echo GM_GPRINT_TEXT_COPY_NAME; ?></span><br /><input type="text" name="surfaces_group_name_copy" id="surfaces_group_name_copy" value="" />
					<input class="button" type="button" id="copy_surfaces_group" value="<?php echo GM_GPRINT_BUTTON_COPY; ?>" />
					<input type="hidden" class="set_id" id="copy_surfaces_groups_id" name="id" value="" />
				</form>					
				<br />
				<form action="gm_gprint.php" method="get">
					<span class="gm_gprint_menu_text"><?php echo GM_GPRINT_TEXT_RENAME_NAME; ?></span><br /><input type="text" name="surfaces_group_name_rename" id="surfaces_group_name_rename" value="" />
					<input class="button" type="button" id="rename_surfaces_group" value="<?php echo GM_GPRINT_BUTTON_RENAME; ?>" />
					<input type="hidden" class="set_id" id="rename_surfaces_groups_id" name="id" value="" />
				</form>	
				<!--
				<hr />
				<a href="gm_gprint.php?action=categories"><input type="button" class="button" style="display: inline; width: auto;" value="<?php echo GM_GPRINT_BUTTON_ASSIGN_SET; ?>" /></a>
				-->	
				</div>
				<hr />
				<div class="gm_gprint_menu_heading"><?php echo GM_GPRINT_TEXT_NEW_SET; ?></div>
				<form>
					<span class="gm_gprint_menu_text"><?php echo GM_GPRINT_TEXT_NAME; ?></span><br /><input type="text" name="surfaces_group_name" id="surfaces_group_name" value="" />
					<input class="button" type="button" id="create_surfaces_group" value="<?php echo GM_GPRINT_BUTTON_CREATE; ?>" />					
				</form>
			</div>
		</td>
	</tr>
</table>
				