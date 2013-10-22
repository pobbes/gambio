<?php
/* --------------------------------------------------------------
   Yoochoose GmbH
   http://www.yoochoose.com
   Copyright (c) 2011 Yoochoose GmbH
   Released under the GNU General Public License (Version 2) 
   [http://www.gnu.org/licenses/gpl-2.0.html]
   -------------------------------------------------------------- */


define('YOOCHOOSE_VERSION', '1.0.0');

define('YOOCHOOSE_PHP_REQUIRED', '5.2.0');


define('YOOCHOOSE_EVENT_SERVER_DEFAULT', 'http://event.yoochoose.net');
define('YOOCHOOSE_RECO_SERVER_DEFAULT', 'http://reco.yoochoose.net');
define('YOOCHOOSE_REG_SERVER_DEFAULT', 'https://config.yoochoose.net');

/** Box names in the table gm_boxes. */
define('YOOCHOOSE_BOX_TOP_SELLING_NAME', "yoochoose_top_selling");
define('YOOCHOOSE_BOX_ALSO_CLICKED_NAME', "yoochoose_also_clicked");

/** Box positions and CSS classes.
 *  ATTENTION!!! Check the file yoochoose_top_selling.php, 
 *  if you change it! */
define('YOOCHOOSE_BOX_TOP_SELLING_POSITION',  "gm_box_pos_48");
define('YOOCHOOSE_BOX_ALSO_CLICKED_POSITION', "gm_box_pos_46");

define('YOOCHOOSE_BOX_TOP_SELLING_STRATEGY_DEFAULT',    "ultimately_purchased");
define('YOOCHOOSE_BOX_ALSO_PURCHASED_STRATEGY_DEFAULT', "also_purchased");
define('YOOCHOOSE_BOX_ALSO_CLICKED_STRATEGY_DEFAULT',   "also_clicked");

define('YOOCHOOSE_BOX_TOP_SELLING_MAX_DISPLAY_DEFAULT', 2);
define('MAX_DISPLAY_ALSO_PURCHASED_DEFAULT', 3);
define('YOOCHOOSE_BOX_ALSO_CLICKED_MAX_DISPLAY_DEFAULT', 2);
 


function getTopSellingStrategy() {
	if (defined('YOOCHOOSE_BOX_TOP_SELLING_STRATEGY')) {
		return YOOCHOOSE_BOX_TOP_SELLING_STRATEGY;
	} else {
		return YOOCHOOSE_BOX_TOP_SELLING_STRATEGY_DEFAULT;
	}
}


function getAlsoClickedStrategy() {
    if (defined('YOOCHOOSE_BOX_ALSO_CLICKED_STRATEGY')) {
        return YOOCHOOSE_BOX_ALSO_CLICKED_STRATEGY;
    } else {
        return YOOCHOOSE_BOX_ALSO_CLICKED_STRATEGY_DEFAULT;
    }
}


/** Strategy for Also Purchased box. Returns the default value, if no strategy set. */
function getAlsoPurchasedStrategy() {
    if (defined('YOOCHOOSE_BOX_ALSO_PURCHASED_STRATEGY')) {
        return YOOCHOOSE_BOX_ALSO_PURCHASED_STRATEGY;
    } else {
        return YOOCHOOSE_BOX_ALSO_PURCHASED_STRATEGY_DEFAULT;
    }
}


/** Returns an amount of items to show in Top Selling box. */
function getBoxTopSellingMaxDisplay() {
    $srvEvent;
    if (defined('YOOCHOOSE_BOX_TOP_SELLING_MAX_DISPLAY')) {
       $srvEvent = YOOCHOOSE_BOX_TOP_SELLING_MAX_DISPLAY;
    } else {
       $srvEvent = YOOCHOOSE_BOX_TOP_SELLING_MAX_DISPLAY_DEFAULT;
    }
    return trimSlash($srvEvent);
}


/** Returns an amount of items to show in Also Purchased box. */
function getBoxAlsoPurchasedMaxDisplay() {
    $srvEvent;
    if (defined('MAX_DISPLAY_ALSO_PURCHASED')) {
       $srvEvent = MAX_DISPLAY_ALSO_PURCHASED;
    } else {
       $srvEvent = MAX_DISPLAY_ALSO_PURCHASED_DEFAULT;
    }
    return trimSlash($srvEvent);
}


/** Returns an amount of items to show in Also Clicked box. */
function getBoxAlsoClickedMaxDisplay() {
    $srvEvent;
    if (defined('YOOCHOOSE_BOX_ALSO_CLICKED_MAX_DISPLAY')) {
       $srvEvent = YOOCHOOSE_BOX_ALSO_CLICKED_MAX_DISPLAY;
    } else {
       $srvEvent = YOOCHOOSE_BOX_ALSO_CLICKED_MAX_DISPLAY_DEFAULT;
    }
    return trimSlash($srvEvent);
}




function phpVersionAsInt($phpVersion) {
    $version = explode('.', $phpVersion);
    return $version[0] * 10000 + @$version[1] * 100 + @$version[2];
}


    
/** Loads URL as JSON object. 
 *  Throws IOException or JSONException, if problems. */
function load_json_url_ex(
        $url, 
        array $options = array()) {

    $loaded = load_url_ex($url, $options);
    $result = json_decode($loaded);
    if ($result == null) {
    	$errorMessage = "Unable to decode JSON decode the text [".trimLoaded($loaded)."].";
    	if (function_exists("json_last_error")) {
    		$errorMessage .= " Cause: ".JSONException::decodeJSONMessage(json_last_error());
    		throw new JSONException($errorMessage, json_last_error());
    	} else {
    		$errorMessage .= " Cause is unavaliable.";
    		throw new JSONException($errorMessage, 0);
    	}
    }
    return $result;
}


/** Trims and cuts first 20 symbols from the specified string.
 *  Adds trailing "...", if the trimmed string was longer. 
 */
function trimLoaded($loaded) {
	
	$resultLength = 20;
	$trimmed = trim($loaded);
	$result = substr($trimmed, 0, $resultLength);
	
	return strlen($trimmed) > $resultLength ? $result.'...' : $result; 
}



/**
 * Send a GET requst using cURL
 * Throws IOException, if something goes worng 
 * 
 * @param string $url to request
 * @param array $options for cURL
 */
function load_url_ex($url, array $options = array()) {
    $def_user = YOOCHOOSE_ID;
    $def_pw   = YOOCHOOSE_SECRET;	
    $defaults = array(
        CURLOPT_URL => $url,
        CURLOPT_HEADER => 0,
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_TIMEOUT => 4,
        CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
        CURLOPT_USERPWD => "$def_user:$def_pw",
        CURLOPT_SSL_VERIFYPEER => FALSE,
        CURLOPT_FAILONERROR => TRUE
    );
    
    $ch = curl_init();
    $options = $options + $defaults; // numeric arrays. Do not use merge_arrays!
    curl_setopt_array($ch, $options);  
    if (!$result = curl_exec($ch)) {
        throwIO(curl_error($ch), curl_errno($ch));
    }
    curl_close($ch);

    return $result;
}


/**
 * Creates a string containing the category path to the current product.
 * It relies on the current status of $breadcrumb.
 * 
 * The path is already URL-encoded.
 */
function getCurrentPath(breadcrumb $breadcrumb, $separator='/') {
    $raw_path = $breadcrumb->_trail;
    if (count($raw_path)<2) return "";
    $result = '';
    for ($i=1 ; $i<=count($raw_path)-1 ; $i++) {
        $result .= '/'.$raw_path[$i]['title'];
    }
    return urlencode($result);
}




/** Returns an URL to event server (without a trailing slash).
 *  Returns a property from the database or a default value. */
function getEventServerUrl() {
	$srvEvent;
	if (defined('YOOCHOOSE_EVENT_SERVER')) {
	   $srvEvent = YOOCHOOSE_EVENT_SERVER;
	} else {
	   $srvEvent = YOOCHOOSE_EVENT_SERVER_DEFAULT;
	}
	return trimSlash($srvEvent);
}


/** Returns an URL to reco server (without a trailing slash).
 *  Returns a property from the database or a default value. */
function getRecoServerUrl() {
    $srvEvent;
    if (defined('YOOCHOOSE_RECO_SERVER')) {
       $srvEvent = YOOCHOOSE_RECO_SERVER;
    } else {
       $srvEvent = YOOCHOOSE_RECO_SERVER_DEFAULT;
    }
    return trimSlash($srvEvent);
}


/** Returns an URL to reg server (without a trailing slash). 
 *  Returns a property from the database or a default value. */
function getRegServerUrl() {
    $srvEvent;
    if (defined('YOOCHOOSE_REG_SERVER')) {
       $srvEvent = YOOCHOOSE_REG_SERVER;
    } else {
       $srvEvent = YOOCHOOSE_REG_SERVER_DEFAULT;
    }
    return trimSlash($srvEvent);
}


define('YOOCHOOSE_LOG_LEVEL_DEFAULT', E_ERROR + E_WARNING);


/** Returns a bit mask defines the messages to log.<br>
 *  There is thee types: E_ERROR, E_WARNING, E_NOTICE<br>
 *  By default returns: E_ERROR + E_WARNING<br>
 *  */
function getYooLogLevel() {
    $result;
    if (defined('YOOCHOOSE_LOG_LEVEL')) {
       $result = YOOCHOOSE_LOG_LEVEL;
    } else {
       $result = YOOCHOOSE_LOG_LEVEL_DEFAULT;
    }
    return $result;
}




/** Returns true, if the admin mode was activated. To activate the database
 *  set the property YOOCHOOSE_ADMIN_MODE to true.
 */  
function isAdminMode() {
    if (defined('YOOCHOOSE_ADMIN_MODE')) {
        return YOOCHOOSE_ADMIN_MODE ? true : false;
    } else {
        return false;
    }
}


    
/** Trims all the traling slashes (both back and forward slashes).
 *  Useful, if you have a path and do not know, if if ends with a slash or not. */
function trimSlash($path) {
    return rtrim($path,'/\\'); 
}



/**
 * Creates the tracking URL based on given parameters
 */
function getTrackingURL($userid, $event_type, $item_id, $category_path, $item_type=1) {
    return getEventServerUrl() . 
            '/ebl/' . YOOCHOOSE_ID . '/'.$event_type.'/' . $userid . '/'.$item_type.'/'.$item_id.
            '?categorypath='.$category_path;
}


/**
 * Creates the tracking URL for connecting anonymous and logged user
 */
function getTransferURL($anonymousid, $userid) {
    return getEventServerUrl() . 
            '/ebl/' . YOOCHOOSE_ID . '/transfer/' . $anonymousid . '/'. $userid . '/';
}

/**
 *  return the ID of the logged user, or empty string
 */
function getLoggedUserId() {
    if (array_key_exists('customer_id', $_SESSION)) {
		return $_SESSION['customer_id'];
    } else {
	    return "";
	}
}

/**
 *  return the ID of the anonymous user (as defined in cookie 'XTCsid' or 'PHPSESSID'), or empty string
 */
function getAnonymousUserId() {
    $id = $_COOKIE['XTCsid'];
   if (!empty($id)) {return $id;}
    return $_COOKIE['PHPSESSID'];
}

/**
 *  return the ID of the logged user, or the anonymous user as a fallback
 */
function getCurrentUserId() {
   $id = getLoggedUserId();
   if (!empty($id)) {return $id;}
   return getAnonymousUserId();
}


/** Logs an error using FileLog('error') class. 
 *  Does nothing except that (so screen output, no mails).
 *  
 *  Uses <code>ErrorHandler::HandleBacktrace</code> for backtrace generation.
 */
function just_log_error($message, Exception $e) {
    $coo_log = new FileLog('errors');
    $coo_log->write("================================================================================\n");
    $coo_log->write(date('Y-m-j H-i-s')."\n");        
    $coo_log->write("ERROR: ".$message."\n");
    $coo_log->write("Backtrace:\n");
    $coo_log->write(ErrorHandler::HandleBacktrace(debug_backtrace())."\n");
    $coo_log->write("\n");
    if ($e) {
        $coo_log->write("Cause:" . $e->getMessage() . " (" . $e->getFile() . ":" . $e->getFile() . ")\n");
        $coo_log->write("Backtrace:\n");    	
        $coo_log->write("Cause:" . $e->getMessage() . " (" . $e->getFile() . ":" . $e->getFile() . ")\n");
        $coo_log->write("Backtrace:\n");
        $coo_log->write(ErrorHandler::HandleBacktrace($e->getTrace())."\n");
        $coo_log->write("\n");
    }    
}




/** Logs an recommendation event using FileLog('recommendations') class. 
 *  Does nothing except that (so screen output, no mails).
 *  
 *  Uses <code>ErrorHandler::HandleBacktrace</code> for backtrace generation.
 *  
 *  @param $log_level
 *      E_ERROR, E_WARNING or E_NOTICE
 */
function just_log_recommendation($log_level, $message, Exception $e = null) {
	if (getYooLogLevel() & $log_level) {
	    $coo_log = new FileLog('recommendations');
	    $coo_log->write(date('Y-m-j H-i-s')." LEVEL $log_level: ".$message."\n");
	    
	    if ($e) {
		    $coo_log->write("Cause:" . $e->getMessage() . " (" . $e->getFile() . ":" . $e->getFile() . ")\n");
		    $coo_log->write("Backtrace:\n");
		    $coo_log->write(ErrorHandler::HandleBacktrace($e->getTrace())."\n");
		    $coo_log->write("\n");
	    }
	}
}
    


    
    
    /** An I/O Exception. */
    class IOException extends Exception {
        public function __construct($message, $errorno = 0, Exception $previous = null) {
            parent::__construct($message, $errorno);
        }
    }
    
        /** An I/O Exception. */
    class JSONException extends Exception {
        public function __construct($message, $json_code, Exception $previous = null) {
            parent::__construct($message, $json_code);
        }
        public static function decodeJSONMessage($json_code) {
        	switch ($json_code) {
        		case JSON_ERROR_NONE: 
        			return "No error has occurred.";    
                case JSON_ERROR_DEPTH: 
                	return "The maximum stack depth has been exceeded.";    
                case JSON_ERROR_CTRL_CHAR:    
                	return "Control character error, possibly incorrectly encoded.";    
                case JSON_ERROR_STATE_MISMATCH:   
                    return "Invalid or malformed JSON.";
                case JSON_ERROR_SYNTAX:   
                	return "Syntax error.";
                case JSON_ERROR_UTF8:     
                	return "Malformed UTF-8 characters, possibly incorrectly encoded.";
                default:
                	return "Unknown JSON code [$json_code]";
        	}
        }
    }    
    
    
    /** Throws an IOException with the message specified. */
    function throwIO($message, $errorno = 0) {
        throw new IOException($message, $errorno);
    }

?>