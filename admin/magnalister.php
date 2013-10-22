<?php
/**
 * 888888ba                 dP  .88888.                    dP                
 * 88    `8b                88 d8'   `88                   88                
 * 88aaaa8P' .d8888b. .d888b88 88        .d8888b. .d8888b. 88  .dP  .d8888b. 
 * 88   `8b. 88ooood8 88'  `88 88   YP88 88ooood8 88'  `"" 88888"   88'  `88 
 * 88     88 88.  ... 88.  .88 Y8.   .88 88.  ... 88.  ... 88  `8b. 88.  .88 
 * dP     dP `88888P' `88888P8  `88888'  `88888P' `88888P' dP   `YP `88888P' 
 *
 *                          m a g n a l i s t e r
 *                                      boost your Online-Shop
 *
 * -----------------------------------------------------------------------------
 * $Id: magnalister.php 1336 2011-10-28 21:26:05Z derpapst $
 *
 * (c) 2010 RedGecko GmbH -- http://www.redgecko.de
 *     Released under the GNU General Public License v2 or later
 * -----------------------------------------------------------------------------
 */

/**
 * Defines
 */
define('MAGNA_DEBUG', false);
define('MAGNA_SHOW_WARNINGS', false);
define('MAGNALISTER_PLUGIN', true);

if (!defined('E_RECOVERABLE_ERROR')) define('E_RECOVERABLE_ERROR', 0x1000);
if (!defined('E_DEPRECATED'))        define('E_DEPRECATED',        0x2000);
if (!defined('E_USER_DEPRECATED'))   define('E_USER_DEPRECATED',   0x4000);

if (ini_get('safe_mode')) {
	define('MAGNA_SAFE_MODE', true);
} else {
	define('MAGNA_SAFE_MODE', false);
}

function magnaHandleFatalError() {
	$errorOccured = false;
	if (version_compare(PHP_VERSION, '5.2.0', '>=')) {
		$le = error_get_last();
		if (empty($le)) return;
		if (((E_NOTICE | E_USER_NOTICE | E_WARNING | E_USER_WARNING | 
		      E_DEPRECATED | E_USER_DEPRECATED | E_STRICT) & $le['type']) == 0
		) {
			echo '<pre>'.print_r(error_get_last(), true).'</pre>';
			$errorOccured = true;
		}
	} else {
		global $php_errormsg;
		if (empty($php_errormsg)) return;
		echo '<pre>'.$php_errormsg.'</pre>';
		$errorOccured = true;
	}
	if ($errorOccured) {
		if (version_compare(PHP_VERSION, '5.2.5', '>=')) {
			echo '<pre>'.print_r(debug_backtrace(false), true).'</pre>';
		} else {
			echo '<pre>'.print_r(debug_backtrace(), true).'</pre>';
		}
	}
}

if (MAGNA_DEBUG && MAGNA_SHOW_WARNINGS) {
	ini_set("display_errors", 1);
	register_shutdown_function('magnaHandleFatalError');
	if (version_compare(PHP_VERSION, '5.2.0', '<')) {
		ini_set('track_errors', 1);
	}
}

define('MAGNA_CALLBACK_MODE', 'UTILITY');
define('MAGNA_IN_ADMIN', true);

$_backup = array (
	'REQUEST' => $_REQUEST,
	'GET'     => $_GET,
	'POST'    => $_POST,
	'COOKIE'  => $_COOKIE
);

require_once('includes/application_top.php');

/* Kein MagicQuotes mist mitmachen... */
$_REQUEST = $_backup['REQUEST'];
$_GET     = $_backup['GET'];
$_POST    = $_backup['POST'];
$_COOKIE  = $_backup['COOKIE'];

unset($_backup);

/* Allow setting a different Update-Paths */
if (isset($_GET['UPDATE_PATH'])) {
	$_SESSION['magna_UPDATE_PATH'] = ltrim(rtrim($_GET['UPDATE_PATH'], '/'), '/').'/';
} else if (!isset($_SESSION['magna_UPDATE_PATH'])) {
	$_SESSION['magna_UPDATE_PATH'] = 'update/';
}

//define('FILENAME_MAGNALISTER', basename($_SERVER['SCRIPT_NAME']));
define('MAGNA_SERVICE_URL', 'http://api.magnalister.com/');
define('MAGNA_PUBLIC_SERVER', 'http://magnalister.com/');
define('MAGNA_PLUGIN_DIR', 'magnalister/');
define('DIR_MAGNALISTER_ABSOLUTE', dirname(__FILE__).'/');
define('DIR_MAGNALISTER', 'includes/'.MAGNA_PLUGIN_DIR);
define('MAGNA_UPDATE_PATH', $_SESSION['magna_UPDATE_PATH'].'oscommerce/');
define('MAGNA_UPDATE_FILEURL', MAGNA_SERVICE_URL.MAGNA_UPDATE_PATH);
define('MAGNA_SUPPORT_URL', '<a href="'.MAGNA_PUBLIC_SERVER.'" title="'.MAGNA_PUBLIC_SERVER.'">'.MAGNA_PUBLIC_SERVER.'</a>');

if (MAGNA_SHOW_WARNINGS) {
	error_reporting(E_ALL | E_STRICT);
}

if (defined('PROJECT_VERSION') && !defined('_VALID_XTC')) {
	define('_VALID_XTC', true);
}

function fileGetContents($path, &$warnings = null, $timeout = 10) {
	$timeout_ts = time() + $timeout;
	$next_try = false;
	if (function_exists('curl_init') && (strpos($path, 'http') !== false)) {
		$warnings = '';
	    $ch = curl_init();

	    curl_setopt($ch, CURLOPT_URL, $path);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    if ($timeout > 0) {
			curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		}
	    do {
		if ($next_try) usleep(rand(500000, 1500000));
	    	$return = curl_exec($ch);
		$next_try = true;
	    } while (curl_errno($ch) && time() < $timeout_ts);
	    if (curl_errno($ch) == CURLE_OPERATION_TIMEOUTED) {
	    	$return = false;
	    }
	   	$warning = curl_error($ch);
	    curl_close($ch);

	    return $return;
	}

	if ($timeout > 0) {
		$context = stream_context_create(array(
			'http' => array('timeout' => $timeout)
		));
	} else {
		$context = null;
	}
	ob_start();
	do {
		if ($next_try) usleep(rand(500000, 1500000));
		$return = file_get_contents($path, false, $context);
		$warnings = ob_get_contents();
		$next_try = true;
	} while ((false === $return) && time() < $timeout_ts);
	ob_end_clean();

	return $return;
}

function echoDiePage($title, $content, $style = '', $showbacklink = true) {
	echo '<!doctype html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>magnalister :: '.$title.'</title>
    <style>
    	body { font: 12px sans-serif; }
    	h1   { font-size: 130%; }
    	'.$style.'
    </style>
  </head>
  <body>
    <h1>'.$title.'</h1>
    <p>'.$content.'</p>
	'.(($showbacklink && isset($_SERVER['HTTP_REFERER']))
		? (($_SESSION['language'] == 'german') 
			? '<a href="'.$_SERVER['HTTP_REFERER'].'" title="Zur&uuml;ck">Zur&uuml;ck</a>'
			: '<a href="'.$_SERVER['HTTP_REFERER'].'" title="Back">Back</a>'
    	)
    	: ''
    ).'
  </body>
</html>';
	include_once(DIR_WS_INCLUDES . 'application_bottom.php');
	exit();	
}

if (version_compare(PHP_VERSION, '5.0.0', '<')) {
	echoDiePage(
		(($_SESSION['language'] == 'german') ? 'PHP Version zu alt' : 'PHP version too old'),
		(($_SESSION['language'] == 'german') ?
	    	'Ihre PHP-Version ('.PHP_VERSION.') ist zu alt. Sie ben&ouml;tigen mindestens PHP Version 5.0 oder h&ouml;her.' :
	    	'Your PHP version ('.PHP_VERSION.') is too old. You need at least PHP version 5.0 or higher.'
	    )
	);
}

/* Alles ueber diesem Kommentar muss PHP 4 kompatibel sein! */
if (MAGNA_SAFE_MODE && !file_exists(DIR_MAGNALISTER.'ClientVersion')) {
	echoDiePage(
		'Safe Mode '.(($_SESSION['language'] == 'german') ? 'Beschr&auml;nkung aktiv' : 'Restriction active'),
		(($_SESSION['language'] == 'german') ?
	    	'Die PHP Safe-Mode Beschr&auml;nkung auf Ihrem Server ist aktiv. Daher ist es nicht m&ouml;glich, automatische Updates zu machen. Um den magnalister manuell zu 
			 aktualisieren, laden Sie sich bitte die aktuelle Version aus dem
	    	 <a href="'.MAGNA_PUBLIC_SERVER.'" title="magnalister Seite">magnalister Download-Bereich</a> herunter, und entpacken den Ordner "files" aus dem ZIP-Archiv in das
 			 Wurzelverzeichnis Ihres Shops. Kontaktieren Sie alternativ Ihren Server-Administrator und bitten Sie ihn, den Safe-Mode dauerhaft abzuschalten, um das Update per 	
			 Knopfdruck ausf&uuml;hren zu k&ouml;nnen. <br /><br />Gerne installieren wir Ihnen das manuelle Update auch gegen eine geringe Update-Pauschale (siehe http://www.magnalister.com/frontend/installation_pricing.php).' :
	    	'The PHP Save Mode restriction is active. That\'s why it is not possible to make automatic upgrades. To upgrade the magnalister manually, please
	    	 download the current version from <a href="'.MAGNA_PUBLIC_SERVER.'" title="magnalister.com">magnalister.com</a> and extract the contents
	    	 of the zip archive into the root directory of your shop or contact your server administrator and ask if the Safe Mode Restriction can be 
	    	 switched off permanently.'
	    )
	);	
}

if (!MAGNA_SAFE_MODE && !is_writable(DIR_MAGNALISTER)) {
	echoDiePage(
		substr(DIR_WS_ADMIN.DIR_MAGNALISTER, 1).' '.(($_SESSION['language'] == 'german') ? 'kann nicht geschrieben werden' : 'is not writable'),
		(($_SESSION['language'] == 'german') ?
	    	'Das Verzeichnis <tt>'.substr(DIR_WS_ADMIN.DIR_MAGNALISTER, 1).'</tt> kann nicht vom Webserver geschrieben werden.<br/>
	    	 Dies ist allerdings zwingend notwendig um den magnalister verwenden zu k&ouml;nnen.' :
	    	'The directory <tt>'.substr(DIR_WS_ADMIN.DIR_MAGNALISTER, 1).'</tt> is not writable by the webserver.<br/>
	    	 This is however required to use the magnalister.'
	    )
	);
}

$requiredFiles = array (
	'init.php',
	'ftp.php',
	'MagnaUpdater.php'
);

if (!MAGNA_SAFE_MODE && MAGNA_DEBUG && isset($_GET['PurgeFiles'])) {
	$_SESSION['MagnaPurge'] = ($_GET['PurgeFiles'] == 'true') ? true : false;
} else {
	if (MAGNA_SAFE_MODE || !MAGNA_DEBUG || !isset($_SESSION['MagnaPurge'])) {
		$_SESSION['MagnaPurge'] = false;
	}
}

if (!MAGNA_SAFE_MODE) {
	foreach ($requiredFiles as $file) {
		$doDownload = (isset($_GET['update']) && ($_GET['update'] == 'true')) || ($_SESSION['MagnaPurge'] === true);
		$scriptPath = MAGNA_UPDATE_FILEURL.'magnalister/'.$file;
		if ($doDownload || !file_exists(DIR_MAGNALISTER.$file)) {
			$scriptContent = fileGetContents($scriptPath, $foo, -1);
			if ($scriptContent === false) {
				echoDiePage(
					$scriptPath.' '.(
						($_SESSION['language'] == 'german') ? 
							'kann nicht geladen werden' : 
							'can\'t be loaded'
					),
					(($_SESSION['language'] == 'german') ?
				    	'Die Datei <tt>'.$scriptPath.'</tt> kann nicht heruntergeladen werden.' :
				    	'The File <tt>'.$scriptPath.'</tt> can not be downloaded.'
				    )
				);
			}
		
			if (@file_put_contents(DIR_MAGNALISTER.$file, $scriptContent) === false) {
				echoDiePage(
					DIR_MAGNALISTER.$file.' '.(
						($_SESSION['language'] == 'german') ? 
							'kann nicht gespeichert werden' : 
							'can\'t be loaded'
					),
					(($_SESSION['language'] == 'german') ?
				    	'Die Datei <tt>'.DIR_MAGNALISTER.$file.'</tt> kann nicht gespeichert werden.' :
				    	'The File <tt>'.DIR_MAGNALISTER.$file.'</tt> can not be saved.'
				    )
				);
			}
		}
	}
}

/**
 * Magnalister Core
 */
include_once(DIR_MAGNALISTER.'init.php');

include_once(DIR_WS_INCLUDES.'application_bottom.php');
