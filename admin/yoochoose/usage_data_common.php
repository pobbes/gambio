<?php
/* --------------------------------------------------------------
   Yoochoose GmbH
   http://www.yoochoose.com
   Copyright (c) 2011 Yoochoose GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   -------------------------------------------------------------- */

    defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

    $dateFormatHuman = 'dd.mm.yyyy';
    $dateFormatJs    = 'dd.MM.yyyy';
    $dateFormatPhp   = 'd.m.Y';
    
    
    $dateFormatPhpForSql   = 'Y-m-d';
    $dateTimeFormatPhpForSql   = 'Y-m-d H:i:s';
    
    
    $averageBytesPerPosition = 54.5;
    $dataThresholdMb = 100;

    
    /** Thrown, if the date checked by some logic is illegal, wrong formated,
     *  out of range etc. 
     *  
     *  @see DateFormatException */
    class DateException extends Exception {
        public function __construct($message, Exception $previous = null) {
            parent::__construct($message, 0);
        }
    }
    
    
   /** Thrown, if the date cannot be parsed. 
     *  
     *  @see DateFormatException */
    class DateFormatException extends DateException {
    	
    	private $dateToParse;
    	private $lastErrors; 

    	/**
    	 * @param $dateToParse
    	 *     A string, which could not be parsed as a date.
    	 * @param unknown_type $lastErrors
    	 *     An array returned by DateTime::getLastErrors 
    	 */
        public function __construct($dateToParse, $lastErrors) {
        	
        	global $dateFormatHuman;
        	
        	$message = sprintf(YOOCHOOSE_UNABLE_PARSE_AS_DATE, $dateToParse, $dateFormatHuman); 
            parent::__construct($message);
            $this->dateToParse = $dateToParse;
            $this->lastErrors = $lastErrors;
        }
        
        public function getParsedDate() {
        	return $this->dateToParse;
        }
        
        public function getLastErrors() {
            return $this->lastErrors;
        }        
    }
    
    
    /** Parses a date using $dateFormatPhp and returns a date array.
     *  Throws exception if errors. Warnings are ignored.
     *  
     *  @return
     *      Date formated as in date_parse. 
     *      
     *  @throws DateFormatException
     *      If an error accured. An infomation about the error
     *      will be set into the exception object. See
     *      DateTime::getLastErrors() for more information
     */
    function parseDate($dateToParse)  {
    	global $dateFormatPhp;
    	
    	if ($dateToParse == '') {
    		$errorMessage = sprintf(YOOCHOOSE_UNABLE_PARSE_EMPTY_AS_DATE);
    		$errors = array('error_count'=>1, 'errors'=>array($errorMessage)); 
    		throw new DateFormatException($dateToParse, $errors);
    	}
   	
    	// PHP 5.3 and up
    	if (method_exists(new DateTime(), 'createFromFormat')) {
    	   $result = DateTime::createFromFormat($dateFormatPhp, $dateToParse);
    	   $errors = DateTime::getLastErrors();
    	} else {
        	try {
                $result = new DateTime($dateToParse);
        	} catch (Exception $e) {
        	   $result = new DateTime();
    	       $errors = array('error_count'=>1, 'errors'=>array($e->getMessage()));	
    	    }
    	}
        
        $result->setTime(0,0,0);
        
        if (@$errors['error_count'] > 0) {
            throw new DateFormatException($dateToParse, $errors);
        }
        return $result;
    }
    
    
    function getPost($name, $default) {
        if (isset($_POST[$name])) {
            return $_POST[$name];
        } else {
            return $default;
        }
    }
    
    function getGet($name, $default) {
        if (isset($_GET[$name])) {
            return $_GET[$name];
        } else {
            return $default;
        }
    }    
    
   
    function initLanguage() {
        // set the language
        if (!isset($_SESSION['language']) || isset($_GET['language'])) {
    
            include(DIR_FS_ADMIN . DIR_WS_CLASSES . 'language.php');
            
            $code = isset($_GET['language']) ? $_GET['language'] : DEFAULT_LANGUAGE;
            
            $lng = new language($code);

            // BOF GM_MOD
            if(!isset($_GET['language']) && gm_get_conf('GM_CHECK_BROWSER_LANGUAGE') === '1') {
                $lng->get_browser_language();
            }
            // EOF GM_MOD

            $_SESSION['language'] = $lng->language['directory'];
            $_SESSION['languages_id'] = $lng->language['id'];
            // BOF GM_MOD
            $_SESSION['language_charset'] = $lng->language['language_charset'];
            $_SESSION['language_code'] = $code;
            // EOF GM_MOD
        }
        // include the language translations
        require_once(DIR_FS_LANGUAGES . $_SESSION['language'] . '/admin/'.$_SESSION['language'] . '.php');
    }
    
     
     /** Checks in the user has an access to the configuration page of the 
     *  administration console. Cause a redirect to login page, if he hasn't.
     *  
     *  Database connection, HTTP Sessions and Configuration constants must
     *  be initializated before calling this method.
     */
    function checkConfigurationPermissions() {
        $pagename = 'configuration';
    
        if (xtc_check_permission($pagename) == '0') {
            xtc_redirect(xtc_href_link(FILENAME_LOGIN));
        }
    }
    

    /** Loads the table TABLE_CONFIGURATION into the global scope
     *  as constants.
     *   
     *  IT WAS COPY-PASTED from application_top.php.
     *  
     *  mySQL connection must be opened before calling this function.
     */
    function loadConfigurationIntoGlobal() {
        $configuration_query = xtc_db_query('select configuration_key as cfgKey, configuration_value as cfgValue from '.TABLE_CONFIGURATION);
        while ($configuration = xtc_db_fetch_array($configuration_query)) {
            @define($configuration['cfgKey'], $configuration['cfgValue']);
        }
    } 
    

    /** Inits HTTP sessions and does some magic(?) checks.
     *   
     *  IT WAS COPY-PASTED from application_top.php.
     */ 
    function magicSessionInitialization() {
    	
    	global $request_type;
    	global $current_domain;
    	
    	
      // set the session name and save path
  session_name('XTCsid');
    if (STORE_SESSIONS != 'mysql') session_save_path(SESSION_WRITE_DIRECTORY);

  // set the session cookie parameters
  if (function_exists('session_set_cookie_params')) {
    session_set_cookie_params(0, '/', (xtc_not_null($current_domain) ? '.' . $current_domain : ''));
  } elseif (function_exists('ini_set')) {
    ini_set('session.cookie_lifetime', '0');
    ini_set('session.cookie_path', '/');
    ini_set('session.cookie_domain', (xtc_not_null($current_domain) ? '.' . $current_domain : ''));
  }

  // set the session ID if it exists
  if (isset($_POST[session_name()])) {
    session_id($_POST[session_name()]);
  } elseif ( ($request_type == 'SSL') && isset($_GET[session_name()]) ) {
    session_id($_GET[session_name()]);
  }

  // start the session
  $session_started = false;
  if (SESSION_FORCE_COOKIE_USE == 'True') {
    xtc_setcookie('cookie_test', 'please_accept_for_session', time()+60*60*24*30, '/', $current_domain);

    if (isset($HTTP_COOKIE_VARS['cookie_test'])) {
      session_start();
      $session_started = true;
    }
  } elseif (CHECK_CLIENT_AGENT == 'True') {
    $user_agent = strtolower(getenv('HTTP_USER_AGENT'));
    $spider_flag = false;

    if ($spider_flag == false) {
      session_start();
      $session_started = true;
    }
  } else {
    session_start();
    $session_started = true;
  }

  // verify the ssl_session_id if the feature is enabled
  if ( ($request_type == 'SSL') && (SESSION_CHECK_SSL_SESSION_ID == 'True') && (ENABLE_SSL == true) && ($session_started == true) ) {
    $ssl_session_id = getenv('SSL_SESSION_ID');
    if (!isset($_SESSION['SESSION_SSL_ID'])) {
      $_SESSION['SESSION_SSL_ID'] = $ssl_session_id;
    }

    if ($_SESSION['SESSION_SSL_ID'] != $ssl_session_id) {
      session_destroy();
      xtc_redirect(xtc_href_link(FILENAME_SSL_CHECK));
    }
  }

  // verify the browser user agent if the feature is enabled
if (SESSION_CHECK_USER_AGENT == 'True') {
    $http_user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
    $http_user_agent2 = strtolower(getenv("HTTP_USER_AGENT"));
    $http_user_agent = ($http_user_agent == $http_user_agent2) ? $http_user_agent : $http_user_agent.';'.$http_user_agent2;
    if (!isset($_SESSION['SESSION_USER_AGENT'])) {
        $_SESSION['SESSION_USER_AGENT'] = $http_user_agent;
    }

    if ($_SESSION['SESSION_USER_AGENT'] != $http_user_agent) {
        session_destroy();
        xtc_redirect(xtc_href_link(FILENAME_LOGIN));
    }
}


  // verify the IP address if the feature is enabled
  if (SESSION_CHECK_IP_ADDRESS == 'True') {
    $ip_address = xtc_get_ip_address();
    if (!xtc_session_is_registered('SESSION_IP_ADDRESS')) {
      $_SESSION['SESSION_IP_ADDRESS'] = $ip_address;
    }

    if ($_SESSION['SESSION_IP_ADDRESS'] != $ip_address) {
      session_destroy();
      xtc_redirect(xtc_href_link(FILENAME_LOGIN));
    }
  }

  // set the language
  if (!isset($_SESSION['language']) || isset($_GET['language'])) {

    include(DIR_WS_CATALOG . DIR_WS_CLASSES . 'language.php');
    $lng = new language($_GET['language']);

    // BOF GM_MOD
    if(!isset($_GET['language']) && gm_get_conf('GM_CHECK_BROWSER_LANGUAGE') === '1')
    {
        $lng->get_browser_language();
    }
    // EOF GM_MOD

    $_SESSION['language'] = $lng->language['directory'];
    $_SESSION['languages_id'] = $lng->language['id'];
    // BOF GM_MOD
    $_SESSION['language_charset'] = $lng->language['language_charset'];
    $_SESSION['language_code'] = $lng->language['code'];
    // EOF GM_MOD
  }
    
    }
    
?>