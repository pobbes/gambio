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
 * $Id: magnaCallback.php 1537 2012-02-02 14:41:02Z derpapst $
 *
 * (c) 2010 RedGecko GmbH -- http://www.redgecko.de
 *     Released under the GNU General Public License v2 or later
 * -----------------------------------------------------------------------------
 */

define('MAGNA_DEBUG', false);
define('MAGNA_SHOW_WARNINGS', false);
define('MAGNA_SERVICE_URL', 'http://api.magnalister.com/');
define('MAGNA_API_SCRIPT', 'API/');
define('MAGNA_PLUGIN_DIR', 'magnalister/');
define('MAGNA_UPDATE_PATH', 'update/oscommerce/');
define('MAGNA_UPDATE_FILEURL', MAGNA_SERVICE_URL.MAGNA_UPDATE_PATH);

$_magnacallbacktimer = $_executionTime = microtime(true);


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

if (isset($_GET['MLDEBUG']) && ($_GET['MLDEBUG'] == 'true')) {
	function ml_debug_out($m) {
		echo $m;
		flush();
	}
}

/**
 * Kodiert Ergebnisse die Funktionen liefern die API-artig aufgerufen wurden. 
 */
function magnaEncodeResult($res) {
	return '{#'.base64_encode(serialize($res)).'#}';
}

define('MAGNA_WITHOUT_DB_INSTALL', 0x00000002);
define('MAGNA_WITHOUT_AUTH',       0x00000004);
define('MAGNA_WITHOUT_ACTIVATION', 0x00000008);

/**
 * Diese Funktion ruft andere hier hinterlegte Funktionnen auf. Sinn ist den zu
 * aendernden Code in Shop eigenen Scripten so gering wie moeglich zu halten.
 *
 * @param $functionName	Name der auszufuehrenden Funktion oder Aktion
 * @param $arguments	Assoziatives Array mit Parametern
 */
function magnaExecute($functionName, $arguments = array(), $includes = array(), $opts = 0) {
	if (!magnaInstalled(($opts & MAGNA_WITHOUT_DB_INSTALL) == MAGNA_WITHOUT_DB_INSTALL)
		|| !(
			(($opts & MAGNA_WITHOUT_ACTIVATION) == MAGNA_WITHOUT_ACTIVATION) || magnaActivated()
		)
		|| !(
			(($opts & MAGNA_WITHOUT_AUTH) == MAGNA_WITHOUT_AUTH) || magnaAuthed()
		)
	) {
		return false;
	}
	if (!empty($includes)) {
		foreach ($includes as $incl) {
			require_once(DIR_MAGNALISTER_INCLUDES.'callback/'.$incl);
		}
	}

	if (function_exists($functionName)) {
		return $functionName($arguments);
	}
	return false;
}

function magnaEchoDiePage($title, $content, $style = '') {
	header('Content-Type: text/html; charset=utf-8');
	echo '<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>magnalister :: ' . $title . '</title>
		<style>
body { font: 12px sans-serif; }
' . $style . '
		</style>
	</head>
	<body>
		' . $content . '
		<a href="' . $_SERVER['HTTP_REFERER'] . '" title="Back / Zur&uuml;ck">Back / Zur&uuml;ck</a>
	</body>
</html>';
	exit();
}

/**
 * Testet ob alle notwendigen und hinreichenden Kriterien zum Betrieb des magnalisters erfuellt werden.
 */
function magnaCompartCheck() {
	/* TimeOut Check */
	$maxExecutionTime = ini_get('max_execution_time');
	if ($maxExecutionTime != '0') {
		@set_time_limit($maxExecutionTime+5);
		$newMaxExecutionTime = ini_get('max_execution_time');
	}
	
	/* RAM Check */
	$maxRam = ini_get('memory_limit');
	ini_set('memory_limit', '247M');
	$newMaxRam = ini_get('memory_limit');
	ini_set('memory_limit', $maxRam);

	$currentClientURL = MAGNA_SERVICE_URL.MAGNA_UPDATE_PATH.'ClientVersion';
	/* cURL Check */
	if (function_exists('curl_version')) {
		$url = $currentClientURL;
	
		$cURLVersion = curl_version();
	
	    $ch = curl_init();
		$hasSSL = @in_array('https', $cURLVersion['protocols']);
		if ($hasSSL) {
			$url = str_replace('http://', 'https://', $url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		}
		curl_setopt($ch, CURLOPT_URL, $url);
	
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	
	    $localClientVersionCURL = curl_exec($ch);
	    if (curl_errno($ch) == CURLE_OPERATION_TIMEOUTED) {
	    	$localClientVersionCURL = false;
	    }
	    curl_close($ch);
	
	} else {
		$cURLVersion = array();
		$cURLVersion['version'] = false;
		$localClientVersionCURL = false;
		$hasSSL = false;
	}

	return array(
		'timeout' => array (
			'changeable' => (($maxExecutionTime == '0') || ($maxExecutionTime != $newMaxExecutionTime)),
			'default' => $maxExecutionTime
		),
		'ram' => array (
			'changeable' => ($maxRam != $newMaxRam),
			'default' => $maxRam
		),
		'safemode' => ini_get('safe_mode'),
		'magicquotes' => (get_magic_quotes_gpc() != 0),
		'phpversion' => PHP_VERSION,
		'mysqlversion' => class_exists('MagnaDB') ? MagnaDB::gi()->fetchOne('SELECT VERSION()') : mysql_result(mysql_query('SELECT VERSION()'), 0),
		'curl' => array (
			'version' => $cURLVersion['version'],
			'hasSSL' => $hasSSL,
			'connects' => ($localClientVersionCURL != 0)
		),
		'file_get_contents' => (@file_get_contents($currentClientURL) !== false),
		'ml_installed' => magnaInstalled(),
		'ml_activated' => magnaActivated(),
		'ml_authed' => magnaAuthed(),
	);
}

function fileGetContents($path, &$warnings = null, $timeout = 10) {
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
    	$return = curl_exec($ch);
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
	$return = file_get_contents($path, false, $context);
	$warnings = ob_get_contents();
	ob_end_clean();

	return $return;
}

function magnaConfigureForFrontendMode() {
	/* Let's hope there is a admin dir :) */
	if (!defined('DIR_FS_ADMIN') && is_dir(dirname(__FILE__) . '/admin/') && is_dir(dirname(__FILE__) . '/admin/includes/')) {
		define('DIR_FS_ADMIN', dirname(__FILE__) . '/admin/');
	} else if (!defined('DIR_FS_ADMIN')) {
		magnaEchoDiePage(
			'Shop Admin directory not found / Shop Admin Verzeichnis nicht gefunden.', 
			'<p>The Shop Admin directory can not be found. To fix this open the file 
			<tt>' . dirname(__FILE__) . '/includes/configure.php</tt> and add the following line:</p>
			<pre>define(\'DIR_FS_ADMIN\', \'/absolute/path/to/your/shop/admin/\');</pre>
			<p>Please use the absolute path to your shop admin directory.</p><br/>
			<p>Das Shop Admin Verzeichnis konnte nicht gefunden werden. Um dies zu
			korrigieren &ouml;ffnen Sie die Datei <tt>' . dirname(__FILE__) . '/includes/configure.php</tt>
			und f&uuml;gen Sie folgende Zeile hinzu:</p>
			<pre>define(\'DIR_FS_ADMIN\', \'/absoluter/pfad/zum/shop/admin/\');</pre>
			<p>Bitte benutzen Sie den absoluten Pfad zum Shop Admin Verzeichnis.</p>
		');
	}
	define('DIR_MAGNALISTER', DIR_FS_ADMIN . 'includes/magnalister/');
}

function magnaInstalled($woDBCheck = false) {
	global $_magnaIsInstalled, $_magnaFilesInstalled;

	if ($woDBCheck) {
		if (isset($_SESSION['magnaFilesInstalled']) && ($_SESSION['magnaFilesInstalled'] === true)) {
			$_magnaFilesInstalled = $_SESSION['magnaFilesInstalled'];
		}
		if (isset($_magnaFilesInstalled) && is_bool($_magnaFilesInstalled)) {
			return $_magnaFilesInstalled;
		}
	} else {
		if (isset($_SESSION['magnaIsInstalled']) && ($_SESSION['magnaIsInstalled'] === true)) {
			$_magnaIsInstalled = $_SESSION['magnaIsInstalled'];
		}
		if (isset($_magnaIsInstalled) && is_bool($_magnaIsInstalled)) {
			return $_magnaIsInstalled;
		}
	}

	$_magnaFilesInstalled = file_exists(DIR_MAGNALISTER_INCLUDES.'lib/MagnaDB.php') 
		&& file_exists(DIR_MAGNALISTER_INCLUDES.'modules.php')
		&& file_exists(DIR_MAGNALISTER_INCLUDES.'lib/functionLib.php')
		&& file_exists(DIR_MAGNALISTER_CALLBACK.'callbackFunctions.php')
		&& is_dir(DIR_MAGNALISTER.'db/');
	if (!$_magnaFilesInstalled) return $_magnaFilesInstalled;
	if ($woDBCheck) {
		return $_magnaFilesInstalled;
	}
	require_once(DIR_MAGNALISTER_INCLUDES . 'lib/MagnaDB.php');
	$_magnaIsInstalled = MagnaDB::gi()->tableExists(TABLE_MAGNA_CONFIG);
	if (!$_magnaIsInstalled) return $_magnaIsInstalled;
	
	$dbV = (int)MagnaDB::gi()->fetchOne('SELECT `value` FROM `'.TABLE_MAGNA_CONFIG.'` WHERE `mkey`=\'CurrentDBVersion\'');
	if ($dbV <= 0) {
		$_magnaIsInstalled = false;
		return $_magnaIsInstalled;
	}

	$dbDir = DIR_MAGNALISTER.'db/';
    if (!$dirhandle = @opendir($dbDir)) {
    	$_magnaIsInstalled = false;
		return $_magnaIsInstalled;
    }
	$sqlFiles = array();
    while (false !== ($filename = readdir($dirhandle))) {
    	if (!preg_match('/^[0-9]*\.sql\.php$/', $filename)) continue;
    	$sqlFiles[] = $filename;
    }
	sort($sqlFiles);
	$nDBV = (int)array_pop($sqlFiles);
	#var_dump($dbV, $nDBV, $dbV < $nDBV);
	if ($dbV < $nDBV) {
		$_magnaIsInstalled = false;
	}
	$_SESSION['magnaIsInstalled'] = $_magnaIsInstalled = true;
	return $_magnaIsInstalled;
}

function magnaActivated() {
	global $_magnaIsActivated;
	if (isset($_magnaIsActivated) && is_bool($_magnaIsActivated)) {
		return $_magnaIsActivated;
	}
	if (!class_exists('MagnaDB')) {
		$_magnaIsActivated = false;
		return $_magnaIsActivated;
	}
	if (MagnaDB::gi()->tableExists(TABLE_ADMIN_ACCESS)) {
		$adminAccess = MagnaDB::gi()->fetchRow('SELECT * FROM '.TABLE_ADMIN_ACCESS.' LIMIT 1');
		$_magnaIsActivated = isset($adminAccess['magnalister']) && MagnaDB::gi()->tableExists(TABLE_MAGNA_CONFIG);
	} else {
		$_magnaIsActivated = MagnaDB::gi()->tableExists(TABLE_MAGNA_CONFIG);
	}
	return $_magnaIsActivated;
}

function magnaAuthed() {
	global $_magnaIsAuthed, $magnaConfig;
	if (isset($_magnaIsAuthed) && is_bool($_magnaIsAuthed)) {
		return $_magnaIsAuthed;
	}
	if (isset($magnaConfig['maranon']) && is_array($magnaConfig['maranon']) && !empty($magnaConfig['maranon'])) {
		$_magnaIsAuthed = true;
	} else {
		$_magnaIsAuthed = false;
	}
	return $_magnaIsAuthed;
}

function refreshCurrentClientVersion() {
	if (($currentClientVersion = fileGetContents(
			MAGNA_UPDATE_FILEURL.'ClientVersion/'.LOCAL_CLIENT_VERSION.'/',
			$foo,
			(MAGNA_CALLBACK_MODE == 'UTILITY') ? 1 : 5
		)) !== false
	) {
		$currentClientVersion = @json_decode($currentClientVersion, true);
	}
	if (!is_array($currentClientVersion) || !array_key_exists('CLIENT_VERSION', $currentClientVersion)) {
		$currentClientVersion = array (
			'CLIENT_VERSION' => 0,
			'MIN_CLIENT_VERSION' => 0,
			'CLIENT_BUILD_VERSION' => 0,
			/* only 10 minutes */
			'DATETIME' => time() - 60 * 60 * 24 + 10 * 60
		);
	} else {
		$currentClientVersion['DATETIME'] = time();
	}
	#echo print_m($currentClientVersion, 'nu cache');
	MagnaDB::gi()->insert(TABLE_MAGNA_CONFIG, array (
		'mpID' => 0,
		'mkey' => 'CurrentClientVersion',
		'value' => serialize($currentClientVersion)
	), true);
	return $currentClientVersion;
}

function magnaDetermineCurrentClientVersion() {
	#$_t = microtime(true);
	$cCVDB = MagnaDB::gi()->fetchOne('SELECT value FROM '.TABLE_MAGNA_CONFIG.' WHERE mpID=0 AND mkey=\'CurrentClientVersion\'');
	$cCVDB = @unserialize($cCVDB);
	$cCV = array();
	do {
		if (!is_array($cCVDB) || !array_key_exists('DATETIME', $cCVDB)) break;
		$lastPulled = @strtotime($cCVDB['DATETIME']);
		/* Cached for 24h, but only in magnaCallback */
		if ($cCVDB['DATETIME'] < (time() - 60 * 60 * 24)) break;
		$cCV = $cCVDB;
		#echo 'Cache! :-D '.(microtime(true) - $_t)."\n";
	} while (false);
	if (empty($cCV)) {
		$cCV = refreshCurrentClientVersion();
	}
	#flush();
	define('CURRENT_CLIENT_VERSION', $cCV['CLIENT_VERSION']);
	define('MINIMUM_CLIENT_VERSION', $cCV['MIN_CLIENT_VERSION']);
	define('CURRENT_BUILD_VERSION', $cCV['CLIENT_BUILD_VERSION']);
	if (CURRENT_CLIENT_VERSION != 0) {
		define(
			'MAGNA_VERSION_TOO_OLD', 
			version_compare(CURRENT_CLIENT_VERSION, LOCAL_CLIENT_VERSION, '>') && version_compare(MINIMUM_CLIENT_VERSION, LOCAL_CLIENT_VERSION, '>')
		);
	} else {
		define('MAGNA_VERSION_TOO_OLD', false);
	}
}

function magnaCallbackRun() {
	/* These variables are used among the mangalister. So they have to be declared as global. */
	global $magnaConfig, $_magnaLanguage, $_MagnaSession, $_MagnaShopSession, $_modules,
	       $_magnaIsInstalled, $_magnaIsActivated, $_magnaIsAuthed;

	date_default_timezone_set(@date_default_timezone_get());
	
	if (!defined('_VALID_XTC')) {
		define('_VALID_XTC', true);
	}
	
	if (!defined('DIR_MAGNALISTER')) { /* included in admin area, everything works out of the box */
		if (is_dir('includes/magnalister/'))
			define('DIR_MAGNALISTER', 'includes/magnalister/');
		else if (is_dir(dirname(__FILE__) . '/admin/includes/magnalister/'))
			define('DIR_MAGNALISTER', dirname(__FILE__) . '/admin/includes/magnalister/');
		else define('DIR_MAGNALISTER', false);
	}
	
	if (!defined('DIR_FS_DOCUMENT_ROOT')) {
		define('DIR_FS_DOCUMENT_ROOT', dirname(__FILE__).'/');
	}
	
	define('DIR_MAGNALISTER_INCLUDES',   DIR_MAGNALISTER.'php/');
	define('DIR_MAGNALISTER_MODULES',    DIR_MAGNALISTER_INCLUDES.'modules/');
	define('DIR_MAGNALISTER_CALLBACK',   DIR_MAGNALISTER_INCLUDES.'callback/');
	define('DIR_MAGNALISTER_CACHE',      DIR_MAGNALISTER.'cache/');
	define('DIR_MAGNALISTER_IMAGECACHE', DIR_MAGNALISTER_CACHE.'images/');
	define('DIR_MAGNALISTER_RESOURCE',   DIR_MAGNALISTER.'resource/');
	define('DIR_MAGNALISTER_IMAGES',     DIR_MAGNALISTER.'images/');
	define('DIR_MAGNALISTER_CONTRIBS',   DIR_MAGNALISTER.'contribs/');
	define('DIR_MAGNALISTER_LOGS',       DIR_MAGNALISTER.'logs/');

	/* Issued a compart check (eiter get or post)? */
	if ((MAGNA_CALLBACK_MODE == 'STANDALONE') && array_key_exists('function', $_REQUEST) && ($_REQUEST['function'] == 'magnaCompartCheck')) {
		echo magnaEncodeResult(magnaCompartCheck());
		return;
	}

	/* Wenn Dateien noch nicht installiert, nix machen */
	if (!magnaInstalled(true)) return;

	include_once(DIR_MAGNALISTER_INCLUDES . 'identifyShop.php');
	require_once(DIR_MAGNALISTER_INCLUDES . 'lib/json_wrapper.php');
	require_once(DIR_MAGNALISTER_INCLUDES . 'lib/functionLib.php');
	/* Language-Foo */
	$_magnaAvailableLanguages = magnaGetAvailableLanguages();
	if (in_array($_SESSION['language'], $_magnaAvailableLanguages)) {
		$_magnaLanguage = $_SESSION['language'];
	} else {
		$_magnaLanguage = array_first($_magnaAvailableLanguages);
	}
	
	include_once(DIR_MAGNALISTER.'lang/'.$_magnaLanguage.'.php');
	/* Description of Modules */
	require_once(DIR_MAGNALISTER_INCLUDES.'modules.php');
	/* Must be loaded after loading the language definitions. */
	require_once(DIR_MAGNALISTER_INCLUDES . 'lib/magnaFunctionLib.php');
	require_once(DIR_MAGNALISTER_INCLUDES . 'lib/MagnaDB.php');
	require_once(DIR_MAGNALISTER_INCLUDES . 'config.php');
	require_once(DIR_MAGNALISTER_INCLUDES . 'lib/MagnaException.php');
	require_once(DIR_MAGNALISTER_INCLUDES . 'lib/MagnaError.php');
	require_once(DIR_MAGNALISTER_INCLUDES . 'lib/MagnaConnector.php');
	
	require_once(DIR_MAGNALISTER_CALLBACK . 'callbackFunctions.php');
	
	if (!defined('TABLE_ADMIN_ACCESS')) {
		define('TABLE_ADMIN_ACCESS', 'admin_access');
	}
	
	if (($localClientVersion = @file_get_contents(DIR_MAGNALISTER.'ClientVersion')) !== false) {
		$localClientVersion = @json_decode($localClientVersion, true);
	}
	if (is_array($localClientVersion) && array_key_exists('CLIENT_VERSION', $localClientVersion)) {
		define('LOCAL_CLIENT_VERSION', $localClientVersion['CLIENT_VERSION']);
		define('CLIENT_BUILD_VERSION', $localClientVersion['CLIENT_BUILD_VERSION']);
	} else {
		define('LOCAL_CLIENT_VERSION', 0);
		define('CLIENT_BUILD_VERSION', 0);
	}

	/* Wenn DB noch nicht installiert, nix machen */
	if (!magnaInstalled(false)) return;

	/* Wenn Modul nicht aktiviert, dann auch nix machen. */
	if (!magnaActivated()) return;

	loadDBConfig();

	/* The plugin noticed that it has no access to the service layer for multiple times.
	   Don't do any requests that are going to fail anyway. */
	if ((bool)getDBConfigValue('CallbackAccessDenied', 0, false)) {
		#echo 'AccessDenied';
		return;
	}

	magnaDetermineCurrentClientVersion();
	/* Do nothing if magnalister server is currently not available. */
	if (CURRENT_CLIENT_VERSION == 0) return;

	/* Check ob's kritisches Update gibt. Falls ja, nichts machen, Meldung ausgeben. */
	if (MAGNA_VERSION_TOO_OLD) {
		if (MAGNA_CALLBACK_MODE == 'STANDALONE') {
			echo 'magnalister version is too old. Please update.';
		}
		return;
	}

	loadJSONConfig();
	loadJSONConfig($_magnaLanguage);
	
	if ((MAGNA_CALLBACK_MODE == 'UTILITY') && !MAGNA_IN_ADMIN) {
		MagnaConnector::gi()->setTimeOutInSeconds(2);
	}

	if (!loadMaranonCacheConfig()) return;

	/* Wenn noch kein oder fehlerhafter PassPhrase hinterlegt: auch nix machen. */
	if (!magnaAuthed()) return;

	# verhindern dass sich die Datenbank mit Fehler 2006 verabschiedet
	if (class_exists('MagnaDB') && method_exists('MagnaDB','mysqlSetHigherTimeout')) {
		MagnaDB::gi()->mysqlSetHigherTimeout((MAGNA_CALLBACK_MODE == 'UTILITY') ? 60 * 60 : 60 * 60 * 2);
	}

	/* API-Artige Funktionalitaet */
	if ((MAGNA_CALLBACK_MODE == 'STANDALONE') &&
		array_key_exists('passphrase', $_POST) && 
	    ($_POST['passphrase'] == getDBConfigValue('general.passphrase', 0)) &&
	    array_key_exists('function', $_POST)
	) {
		$arguments = array_key_exists('arguments', $_POST) ? unserialize($_POST['arguments']) : array();
		$arguments = is_array($arguments) ? $arguments : array();
		
		$includes = array_key_exists('includes', $_POST) ? unserialize($_POST['includes']) : array();
		$includes = is_array($includes) ? $includes : array();
		
		MagnaDB::gi()->setShowDebugOutput(false);
		
		echo magnaEncodeResult(magnaExecute($_POST['function'], $arguments, $includes));

		ob_start(); /* Kein Output, nur ordendliches Beenden */
		require_once('includes/application_bottom.php');
		ob_end_clean();
		return;
	}

	/* Nur im Standalone-Modus zeitintensive Prozesse verarbeiten. */
	if (MAGNA_CALLBACK_MODE == 'STANDALONE') {
		if (!defined('MAGNA_EXECUTE_INSTEAD')) {
			require_once(DIR_MAGNALISTER_CALLBACK.'callbackProcessor.php');
			magnaProcessCallbackRequest();
		} else {
			$magnaFunc = MAGNA_EXECUTE_INSTEAD;
			$magnaFunc();
		}
		ob_start(); /* Kein Output, nur ordendliches Beenden */
		require_once('includes/application_bottom.php');
		ob_end_clean();
	}

}

# Modus festlegen
if (!defined('MAGNA_CALLBACK_MODE')) {
	if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
		define('MAGNA_CALLBACK_MODE', 'STANDALONE');
		header('Content-Type: text/plain; charset=utf-8');
	} else {
		define('MAGNA_CALLBACK_MODE', 'UTILITY');
	}
}

if (MAGNA_CALLBACK_MODE == 'STANDALONE') {
	define('MAGNA_IN_ADMIN', false);
	if (!in_array('application_top.php', preg_replace("/\/.*\//", "", get_included_files()))) {
		include('includes/application_top.php');		
	}
	magnaConfigureForFrontendMode();
	header('Content-Type: text/plain; charset=utf-8');
} else {
	/* Where have we been called? Frontend or backend?! */
	if (dirname($_SERVER['SCRIPT_FILENAME']).'/' == DIR_FS_DOCUMENT_ROOT) {
		/* Frontend */
		magnaConfigureForFrontendMode();
		define('MAGNA_IN_ADMIN', false);
	} else {
		define('MAGNA_IN_ADMIN', true);
	}
}

magnaCallbackRun();

$_magnacallbacktimer = microtime(true)  - $_magnacallbacktimer;
