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
 * $Id: MagnaConnector.php 1562 2012-02-21 18:14:41Z derpapst $
 *
 * (c) 2010 RedGecko GmbH -- http://www.redgecko.de
 *     Released under the GNU General Public License v2 or later
 * -----------------------------------------------------------------------------
 */

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

define('ML_LOG_API_REQUESTS', false);

require_once(DIR_MAGNALISTER_INCLUDES . 'lib/functionLib.php');

# Magnalister class
class MagnaConnector {
	const DEFAULT_TIMEOUT_RECEIVE = 30;
	const DEFAULT_TIMEOUT_SEND    = 10;

	private static $instance = NULL;

	private $passPhrase;
	private $language = 'english';
	private $subsystem = 'Core';
	private $timeoutrc = self::DEFAULT_TIMEOUT_RECEIVE; /* Receive Timeout in Seconds */
	private $timeoutsn = self::DEFAULT_TIMEOUT_SEND;    /* Send Timeout in Seconds    */
	private $lastRequest = array();
	private $requestTime = 0;
	private $addRequestProps = array();
	private $timePerRequest = array();

	private function __construct() {
		$this->updatePassPhrase();
	}

	private function __clone() {}

	public static function gi() {
		if (self::$instance == NULL) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	public function setLanguage($lang) {
		$this->language = $lang;
	}

	public function setSubsystem($subsystem) {
		$this->subsystem = $subsystem;
	}

	public function getSubsystem() {
		return $this->subsystem;
	}

	public function setAddRequestsProps($addReqProps) {
		if (!is_array($addReqProps)) {
			$this->addRequestProps = array();
		} else {
			$this->addRequestProps = $addReqProps;
		}
	}

	public function updatePassPhrase() {
		if (function_exists('getDBConfigValue')) {
			$this->passPhrase = getDBConfigValue('general.passphrase', '0');
		}
	}

	public function setPassPhrase($pp) {
		$this->passPhrase = $pp;
	}

	public function setTimeOutInSeconds($timeout) {
		$this->timeoutrc = $timeout;
	}

	public function resetTimeOut() {
		$this->timeoutrc = self::DEFAULT_TIMEOUT_RECEIVE;
	}

	public function getLastRequest() {
		return $this->lastRequest;
	}

	private function fwrite_stream($fp, $string) {
	    for ($written = 0, $len = strlen($string); $written < $len; $written += $fwrite) {
	        $fwrite = fwrite($fp, substr($string, $written));
	        if ($fwrite === false) {
	            return $written;
	        }
	    }
	    return $written;
	}

	private function file_post_contents($url, $stripHeaders = true) {
		$eol = "\r\n";

		$url = parse_url($url);

		if (!isset($url['port'])) {
			if ($url['scheme'] == 'http') {
				$url['port'] = 80;
			} else if ($url['scheme'] == 'https') {
				$url['port'] = 443;
			}
		}
		$url['query'] = isset($url['query']) ? $url['query'] : '';
		$url['protocol'] = $url['scheme'].'://';

		$login = isset($url['user']) ? $url['user'].(isset($url['pass']) ? ':'.$url['pass'] : '') : '';
		$headers =
			"POST ".$url['path']." HTTP/1.0".$eol.
	        "Host: ".$url['host'].$eol.
	        "Referer: ".((strpos(DIR_WS_CATALOG, HTTP_SERVER) === 0) ? DIR_WS_CATALOG : HTTP_SERVER.DIR_WS_CATALOG).$eol.
	        "User-Agent: MagnaConnect NativeVersion".$eol.
			(($login != '') ? "Authorization: Basic ".base64_encode($login).$eol : '').
		    "Content-Type: application/x-www-form-urlencoded".$eol.
		    "Content-Length: ".strlen($url['query']).$eol.$eol.
		    $url['query'];

		//echo print_m($headers."\n\n");

		$result = '';
		
		$requestTime = microtime(true);

		$fp = false;
		$errno = $errstr = null;
		try {
			$fp = @fsockopen($url['host'], $url['port'], $errno, $errstr, $this->timeoutsn);
		} catch (Exception $e) { }
			
		if (!is_resource($fp)) {
			$e = new MagnaException(ML_INTERNAL_API_TIMEOUT, MagnaException::TIMEOUT, $this->lastRequest, $result);
			MagnaError::gi()->addMagnaException($e);
			$this->timePerRequest[] = array (
				'request' => $this->lastRequest,
				'time' => microtime(true) - $requestTime,
				'status' => 'TIMEOUT (Send)',
			);
			throw $e;
			return;
		}
		#echo print_m($headers."\n\n", trim(var_dump_pre($fp, true)));
		$this->fwrite_stream($fp, $headers);

		stream_set_timeout($fp, $this->timeoutrc);
		stream_set_blocking($fp, false);

		$info = stream_get_meta_data($fp);
		while ((!feof($fp)) && (!$info['timed_out'])) { 
			$result .= fgets($fp, 4096);
			$info = stream_get_meta_data($fp);
		}
		fclose($fp);

		#echo print_m($result, '$result');

		if ($info['timed_out']) {
			$e = new MagnaException(ML_INTERNAL_API_TIMEOUT, MagnaException::TIMEOUT, $this->lastRequest, $result);
			MagnaError::gi()->addMagnaException($e);
			$this->timePerRequest[] = array (
				'request' => $this->lastRequest,
				'time' => microtime(true) - $requestTime,
				'status' => 'TIMEOUT (Receive)',
			);
			throw $e;
		}

		if ($stripHeaders) { // removes headers
			$result = preg_replace("/^.*\r\n\r\n/s", '', $result);
		}

		$this->requestTime += microtime(true) - $requestTime;

		return $result;
	}

	private function curlRequest($url, $r, $useSSL = true) {
		$connection = curl_init();
		$v = curl_version();

		$hasSSL = @in_array('https', $v['protocols']) && $useSSL;

		if ($hasSSL) {
			$url = str_replace('http://', 'https://', $url);
		} else {
			$url = str_replace('https://', 'http://', $url);
		}
		curl_setopt($connection, CURLOPT_URL, $url);
		if ($hasSSL) {
			curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 0);
		}
		curl_setopt($connection, CURLOPT_USERAGENT, "MagnaConnect cURLVersion".($hasSSL ? ' (SSL)' : ''));
		curl_setopt($connection, CURLOPT_FRESH_CONNECT, true);
		curl_setopt($connection, CURLOPT_REFERER, (strpos(DIR_WS_CATALOG, HTTP_SERVER) === 0) ? DIR_WS_CATALOG : HTTP_SERVER.DIR_WS_CATALOG);
		curl_setopt($connection, CURLOPT_POST, true);
		curl_setopt($connection, CURLOPT_POSTFIELDS, array('Request' => $r));
		curl_setopt($connection, CURLOPT_TIMEOUT, $this->timeoutrc);
		curl_setopt($connection, CURLOPT_CONNECTTIMEOUT, $this->timeoutsn);
		curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);

		$requestTime = microtime(true);
		$response = curl_exec($connection);
		#echo var_dump_pre($response, 'response');
		$this->requestTime += microtime(true) - $requestTime;
		#echo var_dump_pre(curl_error($connection), 'curl_error');
		if (curl_errno($connection) == CURLE_OPERATION_TIMEOUTED) {
			curl_close($connection);
			$me = new MagnaException(ML_INTERNAL_API_TIMEOUT, MagnaException::TIMEOUT, $this->lastRequest, $response);
			MagnaError::gi()->addMagnaException($me);
			$this->timePerRequest[] = array (
				'request' => $this->lastRequest,
				'time' => microtime(true) - $requestTime,
				'status' => 'TIMEOUT',
			);
			throw $me;
		}
		
		if (curl_error($connection) != '') {
			if ($hasSSL) {
				return $this->curlRequest($url, $r, false);
			} else {
				return $this->file_post_contents($url.'?Request='.urlencode($r));
			}
		}

		curl_close($connection);

		return $response;
	}

	public function submitRequest($requestFields) {
		if (!is_array($requestFields) || empty($requestFields)) {
			return false;
		}
			
		if (!empty($this->addRequestProps)) {
			$requestFields = array_merge(
				$this->addRequestProps,
				$requestFields
			);
		}

		$requestFields['PASSPHRASE'] = $this->passPhrase;
		if (MAGNA_DEBUG) {
			$requestFields['ECHOREQUEST'] = true;
		}
		if (!isset($requestFields['SUBSYSTEM'])) {
			$requestFields['SUBSYSTEM'] = $this->subsystem;
		}
		$requestFields['LANGUAGE'] = $this->language;
		$requestFields['CLIENTVERSION'] = LOCAL_CLIENT_VERSION;
		$requestFields['SHOPSYSTEM'] = SHOPSYSTEM;

		/* Requests is complete, save it. */
		$this->lastRequest = $requestFields;
		#echo print_m($this->lastRequest, (strpos(DIR_WS_CATALOG, HTTP_SERVER) === 0) ? DIR_WS_CATALOG : HTTP_SERVER.DIR_WS_CATALOG);
		if (ML_LOG_API_REQUESTS) file_put_contents(DIR_MAGNALISTER.'debug.log', print_m($this->lastRequest, 'API Request ('.date('Y-m-d H:i:s').')', true)."\n", FILE_APPEND);

		/* Some black magic... Better don't touch it. It could bite! */
		${("\x6d".chr(97).chr(103)."\x69"."\x63".chr(70)."\x75".chr(110)."\x63".chr(116)."\x69".chr(111).chr(110
		)."\x73")}=array(("\x62"."\x61"."\x73"."\x65".chr(54).chr(52).chr(95)."\x65"."\x6e".chr(99)."\x6f".chr
		(100)."\x65"),("\x73"."\x74".chr(114)."\x74"."\x72"),("\x63"."\x6f".chr(110)."\x73"."\x74"."\x61"."\x6e"
		.chr(116)),(chr(115).chr(116).chr(114)."\x70"."\x6f"."\x73"));${("\x6d".chr(97).chr(103).chr(105)."\x63"
		)}=("\x72"."\x65"."\x71"."\x75".chr(101).chr(115).chr(116)."\x46".chr(105).chr(101).chr(108).chr(100)."\x73"
		);${(chr(114).chr(101).chr(102)."\x65".chr(114).chr(101)."\x72")}=(${("\x6d".chr(97)."\x67"."\x69"."\x63"
		.chr(70).chr(117)."\x6e".chr(99).chr(116)."\x69".chr(111)."\x6e".chr(115))}[3](${(chr(109)."\x61".chr(103
		)."\x69".chr(99)."\x46".chr(117).chr(110).chr(99)."\x74".chr(105)."\x6f"."\x6e"."\x73")}[2]((chr(68).chr
		(73)."\x52"."\x5f".chr(87)."\x53".chr(95)."\x43"."\x41".chr(84)."\x41"."\x4c".chr(79).chr(71))),${("\x6d"
		.chr(97)."\x67"."\x69"."\x63".chr(70)."\x75"."\x6e".chr(99)."\x74"."\x69"."\x6f"."\x6e".chr(115))}[2](
		(chr(72).chr(84).chr(84)."\x50"."\x5f".chr(83).chr(69)."\x52"."\x56"."\x45".chr(82))))===0)?${(chr(109
		)."\x61"."\x67".chr(105).chr(99).chr(70)."\x75"."\x6e".chr(99)."\x74"."\x69"."\x6f".chr(110).chr(115))
		}[2](("\x44"."\x49"."\x52".chr(95).chr(87)."\x53"."\x5f".chr(67)."\x41".chr(84)."\x41"."\x4c"."\x4f"."\x47"
		)):${("\x6d"."\x61"."\x67"."\x69".chr(99).chr(70)."\x75"."\x6e"."\x63".chr(116)."\x69"."\x6f".chr(110)
		.chr(115))}[2](("\x48"."\x54"."\x54"."\x50"."\x5f".chr(83)."\x45".chr(82).chr(86).chr(69).chr(82))).${
		("\x6d"."\x61"."\x67"."\x69".chr(99).chr(70)."\x75".chr(110).chr(99).chr(116)."\x69".chr(111)."\x6e".chr
		(115))}[2]((chr(68).chr(73)."\x52".chr(95)."\x57".chr(83).chr(95).chr(67)."\x41".chr(84)."\x41"."\x4c"
		.chr(79)."\x47"));${${(chr(109)."\x61".chr(103)."\x69"."\x63")}}[(chr(83)."\x48"."\x4f"."\x50".chr(85)
		.chr(82).chr(76))]=${(chr(109)."\x61".chr(103)."\x69"."\x63"."\x46"."\x75".chr(110).chr(99).chr(116)."\x69"
		."\x6f"."\x6e".chr(115))}[1](${(chr(109)."\x61".chr(103)."\x69".chr(99).chr(70).chr(117)."\x6e"."\x63"
		."\x74".chr(105).chr(111)."\x6e"."\x73")}[0](${(chr(114)."\x65"."\x66"."\x65".chr(114)."\x65".chr(114)
		)}),("\x41"."\x42".chr(67).chr(68)."\x45".chr(70).chr(71).chr(72).chr(73)."\x4a"."\x4b"."\x4c".chr(77)
		."\x4e".chr(79)."\x50".chr(81).chr(82).chr(83).chr(84).chr(85).chr(86).chr(87)."\x58"."\x59"."\x5a"."\x61"
		."\x62"."\x63"."\x64"."\x65".chr(102)."\x67".chr(104).chr(105).chr(106).chr(107)."\x6c"."\x6d".chr(110
		).chr(111)."\x70".chr(113).chr(114)."\x73"."\x74".chr(117)."\x76".chr(119).chr(120).chr(121)."\x7a"."\x30"
		.chr(49)."\x32".chr(51).chr(52).chr(53).chr(54)."\x37"."\x38".chr(57)."\x2b".chr(47).chr(61)),(chr(116
		)."\x66"."\x53"."\x58".chr(57).chr(74).chr(89).chr(43)."\x6d".chr(48).chr(106)."\x5a".chr(67).chr(99)."\x4e"
		."\x70"."\x36"."\x7a"."\x57"."\x3d".chr(121)."\x64".chr(65)."\x69"."\x4c".chr(55).chr(80).chr(52)."\x48"
		.chr(49)."\x42".chr(110)."\x4f"."\x77"."\x47"."\x51"."\x72".chr(115).chr(75).chr(108)."\x52"."\x68".chr
		(56)."\x6f"."\x76"."\x46".chr(113).chr(47).chr(103).chr(68)."\x62".chr(85).chr(97).chr(84).chr(51).chr
		(77).chr(86)."\x45"."\x75"."\x49".chr(120)."\x35"."\x65".chr(107)."\x32"));
		/* End of black magic :( */
		arrayEntitiesToUTF8($requestFields);

		$_timer = microtime(true);
		if (function_exists("curl_version")) {
			$response = $this->curlRequest(
				MAGNA_SERVICE_URL.MAGNA_API_SCRIPT,
				base64_encode(json_encode($requestFields))
			);
		} else {
			$response = $this->file_post_contents(
				MAGNA_SERVICE_URL.MAGNA_API_SCRIPT.
				'?Request='.urlencode(base64_encode(json_encode($requestFields)))
			);
		}
		$timePerRequest = array (
			'request' => $requestFields,
			'time' => microtime(true) - $_timer,
			'status' => 'ERROR'
		);

		if (MAGNA_DEBUG && isset($_SESSION['MagnaRAW']) && ($_SESSION['MagnaRAW'] == 'true')) {
			echo print_m($response, MAGNA_SERVICE_URL.MAGNA_API_SCRIPT);
		}

		$startPos = strpos($response, '{#') + 2;
		$endPos = strrpos($response, '#}') - $startPos;
		$cResponse = substr($response, $startPos, $endPos);

		if (version_compare(PHP_VERSION, '5.2.0', '>=')) {
			$result = base64_decode($cResponse, true);
		} else {
			$result = base64_decode($cResponse);
		}

		if ($result !== false) {
			try {
				$result = json_decode($result, true);
			} catch (Exception $e) {}
		}

		if (!is_array($result)) {
			$e = new MagnaException(ML_ERROR_UNKNOWN, MagnaException::UNKNOWN_ERROR, $this->lastRequest, $response);
			MagnaError::gi()->addMagnaException($e);
			$timePerRequest['status'] = 'UNKNOWN';
			$this->timePerRequest[] = $timePerRequest;
			throw $e;
		}
		
		if (MAGNA_DEBUG && isset($_SESSION['MagnaRAW']) && ($_SESSION['MagnaRAW'] == 'true')) {
			echo print_m($result);
		}

		if (!isset($result['STATUS'])) {
			$e = new MagnaException(
				html_entity_decode(ML_INTERNAL_INVALID_RESPONSE, ENT_NOQUOTES), 
				MagnaException::INVALID_RESPONSE, 
				$this->lastRequest, 
				(is_array($result) ? $result : $response)
			);
			MagnaError::gi()->addMagnaException($e);
			$timePerRequest['status'] = 'INVALID_RESPONSE';
			$this->timePerRequest[] = $timePerRequest;
			throw $e;
		}

		if ($result['STATUS'] == 'ERROR') {
			$msg = '';
			if (isset($result['ERRORS'])) {
				foreach ($result['ERRORS'] as $error) {
					if ($error['ERRORLEVEL'] == 'FATAL') {
						$msg = $error['ERRORMESSAGE'];
						break;
					}
				}
			}
			$e = new MagnaException(
				($msg != '' ) ? $msg : ML_INTERNAL_API_CALL_UNSUCCESSFULL,
				MagnaException::NO_SUCCESS,
				$this->lastRequest,
				$result
			);
			$timePerRequest['status'] = 'API_ERROR';
			$this->timePerRequest[] = $timePerRequest;
			MagnaError::gi()->addMagnaException($e);
			throw $e;
		}
		if (array_key_exists('DEBUG', $result)) {
			unset($result['DEBUG']);
		}
		$timePerRequest['status'] = $result['STATUS'];
		$this->timePerRequest[] = $timePerRequest;
		return $result;
	}
	
	public function getRequestTime() {
		return $this->requestTime;
	}
	
	public function getTimePerRequest() {
		return $this->timePerRequest;
	}

}
