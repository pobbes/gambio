<?php
/* --------------------------------------------------------------
   gm_backup_files_zip.php 2009-03-31 jh
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/
?>
<?php

	define('HEADING_TITLE', 'Backup files');
	define('HEADING_SUB_TITLE', 'Gambio');

	define('GM_BACKUP_FILES_ZIP_TEXT', 'Here you can backup the most important files for your store install.');

	define('SUCCESS_BACKUP_CREATED', 'Success: Backup has been saved.');
	define('SUCCESS_BACKUP_DELETED','Success: Backup has been deleted.');
	define('ERROR_BACKUP_DELETED','Error: Backup could not be deleted.');
	define('GM_BACKUP_FILES_ZIP_FILELIST_ERROR','The file containing the list of the important files could not be found. ');	
	define('GM_BACKUP_FILES_ZIP_FILES_CREATED', 'has been created.');
	
	define('GM_BACKUP_FILES_DURATION','Duration: ');
	define('GM_BACKUP_FILES_DESCRIPTION','This function allows you to backup all the images (articles, categories, banners, logos, icons, etc.) and the most important files for your store. The backups are stored in zip format.<br />');
	define('GM_BACKUP_FILES_RESTORE_INFO','<b>NOTICE:</b><br />To restore a backup, please download the file and extract the content to your local computer. You can now upload the files to the root dir of your store using the ftp client.');
	
	define('TABLE_HEADING_TITLE', 'Filename');
	define('TABLE_HEADING_FILE_DATE', 'Date');
	define('TABLE_HEADING_FILE_SIZE', 'File Size');
	define('TABLE_HEADING_ACTION', 'Action');
	define('TEXT_MARKED_ELEMENTS','Selected Element');

	define('TEXT_INFO_DATE', 'Date:');
	define('TEXT_INFO_SIZE', 'File size:');
	define('TEXT_INFO_COMPRESSION', 'Compression:');

	define('TEXT_BACKUP_DIRECTORY', 'Backup directory:');
	define('TEXT_DELETE_INTRO', 'Do you really want to delete this backup?');
?>