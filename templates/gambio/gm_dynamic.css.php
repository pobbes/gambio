<?php
/* --------------------------------------------------------------
   gm_dynamic.css.php 2012-07-24 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/
?><?php

if(defined('E_DEPRECATED'))
{
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
}
else
{
	error_reporting(E_ALL & ~E_NOTICE);
}

define('PAGE_PARSE_START_TIME', microtime());

header('Content-Type: text/css; charset=utf-8');

if (file_exists('../../includes/local/configure.php')) {
	include ('../../includes/local/configure.php');
} else {
	include ('../../includes/configure.php');
}

$t_usermod_files = array();

if(isset($_GET['current_template']) && !empty($_GET['current_template']) && is_dir(DIR_FS_CATALOG . 'templates/' . basename($_GET['current_template']) . '/usermod'))
{
	$t_path_pattern = DIR_FS_CATALOG . 'templates/' . basename($_GET['current_template']) . '/usermod/css/*.css';

	$t_glob_data_array = glob($t_path_pattern);
	if(is_array($t_glob_data_array))
	{
		foreach($t_glob_data_array AS $t_result)
		{
			$t_entry = basename($t_result);

			$t_usermod_files[] = DIR_FS_CATALOG . 'templates/' . basename($_GET['current_template']) . '/usermod/css/' . $t_entry;
		}
	}
}

if((int)$_GET['gm_css_debug'] == 1)
{
	$t_debug = true;
	@unlink(DIR_FS_CATALOG . 'cache/__dynamics.css');
}

$t_renew = false;
if((int)$_GET['renew'] == 1)
{
	$t_renew = true;
}

$cache_file 	= DIR_FS_CATALOG . 'cache/__dynamics.css';
$create_cache = false;

if($_GET['renew_cache'] == '1')
{
	$create_cache = true;
}
elseif(file_exists($cache_file) == false)
{
	$create_cache = true;
}
elseif(filesize($cache_file) < 10)
{
	$create_cache = true;
}

if($create_cache === $t_renew && $_GET['stop_style_edit'] != '1')
{
	$t_last_modified = filemtime($cache_file);

	// Windows time fix
	if(date('I', $t_last_modified) != 1 && date('I') == 1)
	{
		$t_last_modified += 3600;
	}
	elseif(date('I', $t_last_modified) == 1 && date('I') != 1)
	{
		$t_last_modified -= 3600;
	}

	$t_hashes_array = array();
	$t_hashes_array[] = md5_file($cache_file);
	if(file_exists(DIR_FS_CATALOG . 'templates/' . basename($_GET['current_template']) . '/stylesheet.css'))
	{
		$t_hashes_array[] = md5_file(DIR_FS_CATALOG . 'templates/' . basename($_GET['current_template']) . '/stylesheet.css');
	}	
	foreach($t_usermod_files AS $t_file)
	{
		$t_hashes_array[] = md5_file($t_file);
	}

	$t_etag = '"' . md5(implode('', $t_hashes_array)) . '"';

	header('Last-Modified: ' . gmdate("D, d M Y H:i:s", $t_last_modified) . ' GMT');
	header('Etag: ' . $t_etag);
	header('Cache-Control: public');

	if((isset($_SERVER['HTTP_IF_NONE_MATCH']) && trim($_SERVER['HTTP_IF_NONE_MATCH']) == $t_etag)
		|| (!isset($_SERVER['HTTP_IF_NONE_MATCH']) && isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && @strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == $t_last_modified))
	{
		header('HTTP/1.1 304 Not Modified');
		exit;
	}

	// GZip compression
	if(extension_loaded('zlib') && strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'msie 6.') === false)
	{
		@ini_set('zlib.output_compression', 'On');

		if(strtolower((string)ini_get('zlib.output_compression') == 'off') || (string)ini_get('zlib.output_compression') == '0')
		{
			$t_buffer = ob_start("ob_gzhandler");

			if($t_buffer === false)
			{
				ob_start();
			}
		}
		else
		{
			@ini_set('zlib.output_compression_level', 9);
		}
	}

	if(file_exists(DIR_FS_CATALOG . 'templates/' . basename($_GET['current_template']) . '/stylesheet.css'))
	{
		include(DIR_FS_CATALOG . 'templates/' . basename($_GET['current_template']) . '/stylesheet.css');

		// print comment to close unclosed comment in included file
		echo "\n/**/\n";
	}

	include($cache_file);

	foreach($t_usermod_files AS $t_file)
	{
		include($t_file);

		// print comment to close unclosed comment in included file
		echo "\n/**/\n";
	}
}
else
{
	require(DIR_FS_CATALOG . 'gm/classes/csstidy/class.csstidy.php');
	require(DIR_FS_CATALOG . 'gm/classes/GMCSSOptimizer.php');

	if(USE_PCONNECT == 'true' && function_exists('mysql_pconnect'))
	{
		$conn_id = mysql_pconnect(
											DB_SERVER,
											DB_SERVER_USERNAME,
											DB_SERVER_PASSWORD
		);
	}
	else
	{
		$conn_id = mysql_connect(
											DB_SERVER,
											DB_SERVER_USERNAME,
											DB_SERVER_PASSWORD
		);
	}

	mysql_select_db(DB_DATABASE, $conn_id);

	$t_style_edit = false;

	if($_GET['style_edit'] == '1')
	{
		$t_style_edit = true;
		$t_debug = true;
	}

	$coo_css = new GMCSSOptimizer($t_debug, $t_style_edit);

	$coo_css->create_css();

	$coo_css->save_css();

	// GZip compression
	if(extension_loaded('zlib') && strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'msie 6.') === false)
	{
		@ini_set('zlib.output_compression', 'On');

		if(strtolower((string)ini_get('zlib.output_compression') == 'off') || (string)ini_get('zlib.output_compression') == '0')
		{
			$t_buffer = ob_start("ob_gzhandler");

			if($t_buffer === false)
			{
				ob_start();
			}
		}
		else
		{
			@ini_set('zlib.output_compression_level', 9);
		}
	}

	if(file_exists(DIR_FS_CATALOG . 'templates/' . basename($_GET['current_template']) . '/stylesheet.css'))
	{
		include(DIR_FS_CATALOG . 'templates/' . basename($_GET['current_template']) . '/stylesheet.css');

		// print comment to close unclosed comment in included file
		echo "\n/**/\n";
	}

	echo $coo_css->get_css();

	foreach($t_usermod_files AS $t_file)
	{
		include($t_file);

		// print comment to close unclosed comment in included file
		echo "\n/**/\n";
	}

	mysql_close();
}

?>