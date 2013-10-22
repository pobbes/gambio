<?php
/* --------------------------------------------------------------
   gm_backup_files_zip.php 2009-04-01 jh
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/
?><?php

require('includes/application_top.php');

require_once('includes/classes/pclzip.lib.php');

function bytestostring($size, $precision = 0) {
	$sizes = array('GB', 'MB', 'kB', 'B');
	$total = count($sizes);

	while($total-- && $size > 1024) $size /= 1024;
		return round($size, $precision).$sizes[$total];
}

$gm_backup_files_zip_success = false;

if ($_GET['action']) {
	switch ($_GET['action']) {
		case 'backup':
			$start_time = time();
			$exclude = array('gif','jpg','png','ico','htaccess');

			if (file_exists("filelist.txt") && is_readable("filelist.txt")) {
				$filelist = fopen("filelist.txt","r");
				$zip_filename = DIR_FS_BACKUP.date("Ymd_His").'.zip';
				$zip = new PclZip($zip_filename);
				$ziplist='';
				while (!feof($filelist)) {
					$filename = trim(fgets($filelist));
					$fileinfo = pathinfo($filename);
					if (!in_array($fileinfo['extension'],$exclude)) {
						if (file_exists(DIR_FS_DOCUMENT_ROOT.$filename))
							$ziplist = $ziplist.','.DIR_FS_DOCUMENT_ROOT.$filename;
					}
				}
				fclose($filelist);
				$result=$zip->add(substr($ziplist,1),PCLZIP_OPT_REMOVE_PATH,DIR_FS_DOCUMENT_ROOT);
				if ($result==0) {
					$messageStack->add_session($zip->errorInfo(), 'error');
				} else
					$messageStack->add_session(SUCCESS_BACKUP_CREATED.' '.$zip_filename.GM_BACKUP_FILES_ZIP_FILES_CREATED.' '.GM_BACKUP_FILES_DURATION.date("i:s",time()-$start_time).' Min', 'success');
				xtc_redirect(xtc_href_link(FILENAME_GM_BACKUP_FILES_ZIP));
			} else {
				$messageStack->add_session(GM_BACKUP_FILES_ZIP_FILELIST_ERROR, 'error');
				xtc_redirect(xtc_href_link(FILENAME_GM_BACKUP_FILES_ZIP));
			}
			break;
		case 'download':
			$file=$_GET['file'];
			$extension = substr($file, -3);
			if ($extension == 'zip') {
				header('Content-type: application/x-octet-stream');
				header('Content-disposition: attachment; filename=' . $file);
				readfile(DIR_FS_BACKUP . $file);
			} else {
				$messageStack->add(ERROR_DOWNLOAD_LINK_NOT_ACCEPTABLE, 'error');
			}
			break;
		case 'deleteconfirm':
			if (strstr($_GET['file'], '..')) xtc_redirect(xtc_href_link(FILENAME_GM_BACKUP_FILES_ZIP));
				xtc_remove(DIR_FS_BACKUP . '/' . $_GET['file']);
			if (!$xtc_remove_error)
				$messageStack->add_session(SUCCESS_BACKUP_DELETED, 'success');
			else
				$messageStack->add_session(ERROR_BACKUP_DELETED, 'success');
			break;
		case 'images':
			$start_time = time();
			$zip_filename = DIR_FS_BACKUP.'images_'.date("Ymd_His").'.zip';
			$zip = new PclZip($zip_filename);
			$result=$zip->create(DIR_FS_DOCUMENT_ROOT.'images',PCLZIP_OPT_REMOVE_PATH,DIR_FS_DOCUMENT_ROOT);
			if ($result==0)
				$messageStack->add_session($zip->errorInfo(), 'error');
			else
				$messageStack->add_session(SUCCESS_BACKUP_CREATED.' '.$zip_filename.GM_BACKUP_FILES_ZIP_FILES_CREATED.' '.GM_BACKUP_FILES_DURATION .date("i:s",time()-$start_time).' Min', 'success');
			xtc_redirect(xtc_href_link(FILENAME_GM_BACKUP_FILES_ZIP));
			break;
	}
}

// check if the backup directory exists
$dir_ok = false;
if (is_dir(DIR_FS_BACKUP)) {
	$dir_ok = true;
	if (!is_writeable(DIR_FS_BACKUP))
		$messageStack->add(ERROR_BACKUP_DIRECTORY_NOT_WRITEABLE, 'error');
	} else {
		$messageStack->add(ERROR_BACKUP_DIRECTORY_DOES_NOT_EXIST, 'error');
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
			<td class="columnLeft2" width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
				<!-- left_navigation //-->
					<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
				<!-- left_navigation_eof //-->
				</table>
			</td>
			<!-- body_text //-->
			<td class="boxCenter" width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
		<tr>
			<td width="100%">
				<div class="pageHeading" style="background-image:url(images/gm_icons/hilfsprogr1.png)"><?php echo HEADING_TITLE; ?></div>
				<br />
				<div class="main">
					<?php echo GM_BACKUP_FILES_DESCRIPTION; ?>
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<table border="0" width="100%" cellspacing="0" cellpadding="0">
					<tr>
						<td valign="top">
							<table border="0" width="100%" cellspacing="0" cellpadding="2">
								<tr class="dataTableHeadingRow">
									<td class="dataTableHeadingContent"><?php echo TABLE_HEADING_TITLE; ?></td>
									<td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_FILE_DATE; ?></td>
									<td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_FILE_SIZE; ?></td>
									<td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
								</tr>
<?php
if ($dir_ok) {
	$dir = dir(DIR_FS_BACKUP);
	$contents = array();
	$exts = array("zip");
	while ($file = $dir->read()) {
		if (!is_dir(DIR_FS_BACKUP . $file)) {
			foreach ($exts as $value) {
				if (xtc_CheckExt($file, $value)) {
					$contents[] = $file;
				}
			}
		}
	}

	sort($contents);

	for ($files = 0, $count = sizeof($contents); $files < $count; $files++) {
		$entry = $contents[$files];

		$check = 0;

		if (((!$_GET['file']) || ($_GET['file'] == $entry)) && (!$buInfo) && ($_GET['action'] != 'backup') && ($_GET['action'] != 'restorelocal')) {
			$file_array['file'] = $entry;
			$file_array['date'] = date(PHP_DATE_TIME_FORMAT, filemtime(DIR_FS_BACKUP . $entry));
			$file_array['size'] = bytestostring(filesize(DIR_FS_BACKUP . $entry),1);
			switch (substr($entry, -3)) {
				case 'zip': $file_array['compression'] = 'ZIP'; break;
				case '.gz': $file_array['compression'] = 'GZIP'; break;
				default: $file_array['compression'] = TEXT_NO_EXTENSION; break;
			}

			$buInfo = new objectInfo($file_array);
		}

		if (is_object($buInfo) && ($entry == $buInfo->file)) {
			echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'">' . "\n";
			$onclick_link = 'file=' . $buInfo->file . '&action=download';
		} else {
			echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'">' . "\n";
			$onclick_link = 'file=' . $entry;
		}
?>
		<td class="dataTableContent" onclick="document.location.href='<?php echo xtc_href_link(FILENAME_GM_BACKUP_FILES_ZIP, $onclick_link); ?>'"><?php echo '<a href="' . xtc_href_link(FILENAME_GM_BACKUP_FILES_ZIP, 'action=download&file=' . $entry) . '">' . xtc_image(DIR_WS_ICONS . 'file_download.gif', ICON_FILE_DOWNLOAD) . '</a>&nbsp;' . $entry; ?></td>
		<td class="dataTableContent" align="center" onclick="document.location.href='<?php echo xtc_href_link(FILENAME_GM_BACKUP_FILES_ZIP, $onclick_link); ?>'"><?php echo date(PHP_DATE_TIME_FORMAT, filemtime(DIR_FS_BACKUP . $entry)); ?></td>
		<td class="dataTableContent" align="right" onclick="document.location.href='<?php echo xtc_href_link(FILENAME_GM_BACKUP_FILES_ZIP, $onclick_link); ?>'"><?php echo bytestostring(filesize(DIR_FS_BACKUP . $entry),1); ?></td>
		<td class="dataTableContent" align="right"><?php if ( (is_object($buInfo)) && ($entry == $buInfo->file) ) { echo xtc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . xtc_href_link(FILENAME_GM_BACKUP_FILES_ZIP, 'file=' . $entry) . '">' . xtc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
</tr>
<?php
	}
	$dir->close();
}
?>
<tr>
	<td align="right" colspan="4" class="smallText" colspan="3"><?php echo TEXT_BACKUP_DIRECTORY . ' ' . DIR_FS_BACKUP; ?></td>
</tr>
<tr>
	<td colspan="4" align="right" class="smallText">
	<?php
		echo '<a style="float:right" class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_GM_BACKUP_FILES_ZIP, 'action=images') . '">' . BUTTON_BACKUP_IMAGES . '</a>';
		echo '<a style="float:right" class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_GM_BACKUP_FILES_ZIP, 'action=backup') . '">' . BUTTON_BACKUP . '</a>';
	?>
	</td>
</tr>
</table></td>
<?php
	$heading = array();
	$contents = array();

	switch ($_GET['action']) {
		case 'delete':

			$heading[] = array('text' => '<b>' . $buInfo->date . '</b>');


			$contents = array('form' => xtc_draw_form('delete', FILENAME_GM_BACKUP_FILES_ZIP, 'file=' . $buInfo->file . '&action=deleteconfirm'));
			$contents[] = array('text' => TEXT_DELETE_INTRO);
			$contents[] = array('text' => '<br /><b>' . $buInfo->file . '</b>');
			$contents[] = array('align' => 'center', 'text' => '<br /><div align="center"><input type="submit" class="button" onClick="this.blur();" value="' . BUTTON_DELETE . '"/><a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_GM_BACKUP_FILES_ZIP, 'file=' . $buInfo->file) . '">' . BUTTON_CANCEL . '</a></div>');
			break;
		default:
			if (is_object($buInfo)) {
				$heading[] = array('text' => '<b>' . $buInfo->date . '</b>');
				$contents[] = array ('align' => 'center', 'text' => '<div style="padding-top: 5px; font-weight: bold; ">' . TEXT_MARKED_ELEMENTS . '</div><br />');
				$contents[] = array('align' => 'center', 'text' => '<div align="center"><a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_GM_BACKUP_FILES_ZIP, 'file=' . $buInfo->file . '&action=download') . '">' . BUTTON_DOWNLOAD . '</a> <a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_GM_BACKUP_FILES_ZIP, 'file=' . $buInfo->file . '&action=delete') . '">' . BUTTON_DELETE . '</a></div>');
				$contents[] = array('text' => '<br />' . TEXT_INFO_DATE . ' ' . $buInfo->date);
				$contents[] = array('text' => TEXT_INFO_SIZE . ' ' . $buInfo->size);
				$contents[] = array('text' => '<br />' . TEXT_INFO_COMPRESSION . ' ' . $buInfo->compression);
			}
			break;
	}

	if ( (xtc_not_null($heading)) && (xtc_not_null($contents)) ) {
		echo '            <td width="25%" valign="top">' . "\n";

		$box = new box;
		echo $box->infoBox($heading, $contents);

		echo '            </td>' . "\n";
	}
?>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td>
									<div class="main">
										<?php echo GM_BACKUP_FILES_RESTORE_INFO; ?>
									</div>
								</td>
							</tr>
						</table>
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