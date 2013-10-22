<?php
/* --------------------------------------------------------------
   gm_gprint_download.php 2009-11-30 mb
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2009 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/
?><?php

require('includes/application_top.php');

require_once(DIR_FS_CATALOG . 'gm/modules/gm_gprint_tables.php');

$f_download_key = $_GET['key'];
$c_download_key = gm_prepare_string($f_download_key);

$t_get_file_data = xtc_db_query("SELECT 
									filename,
									encrypted_filename
								FROM " . TABLE_GM_GPRINT_UPLOADS . "
								WHERE download_key = '" . $c_download_key . "'");	
if(xtc_db_num_rows($t_get_file_data) == 1)
{
	$t_file_data = xtc_db_fetch_array($t_get_file_data);
	
	$t_decrypted_filename = basename($t_file_data['filename']);
	$t_encrypted_filename = basename($t_file_data['encrypted_filename']);
	
	$t_filename = DIR_FS_CATALOG . 'gm/customers_uploads/gprint/' . $t_encrypted_filename;
	
	
	if(file_exists($t_filename)){
		header('Content-Description: File Transfer');
		header("Content-Type: application/octet-stream");
		header('Content-Disposition: attachment; filename="' . $t_decrypted_filename . '"');
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($t_filename));
		ob_clean();
   		flush();
	
		readfile($t_filename);
	}	
	else
	{
		echo "Error: File does not exist!";
	}
}
else
{
	echo "Error: File does not exist!";
}

require(DIR_WS_INCLUDES . 'application_bottom.php'); 
?>