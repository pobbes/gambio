<?php
/* --------------------------------------------------------------
   Yoochoose GmbH
   http://www.yoochoose.com
   Copyright (c) 2011 Yoochoose GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   -------------------------------------------------------------- */

    // This file may be (and must be) accessed directly

    require_once('../includes/configure.php');
    require_once('yooinit.php');

    loadConfigurationIntoGlobal();
    
    
    // set the type of request (secure or not)
    $request_type = (getenv('HTTPS') == '1' || getenv('HTTPS') == 'on') ? 'SSL' : 'NONSSL';    
    
    // set the top level domains
    $http_domain = @xtc_get_top_level_domain(HTTP_SERVER);
    $https_domain = @xtc_get_top_level_domain(HTTPS_SERVER);
    $current_domain = (($request_type == 'NONSSL') ? $http_domain : $https_domain);    
    
    magicSessionInitialization();
    checkConfigurationPermissions();

    
    @initLanguage(); // mysql connection and HTTP session must exist here.
    
    //////////////////////////////////////////////////////////////////////////////////////////
    /// Implementation starts here. 
    ///
    /// This is a collection of AXAX functions, called from tht usage_data_upload.php
    /// Used for exporting usage data for the recomendation engine and quering 
    /// statistical information to usage data.
    ///
    /// @author rodion.alukhanov
    
    require_once(DIR_FS_CATALOG.'gm/classes/FileLog.php');
    
    define('DATA_FILE_PREFIX', 'usage_data_export');
    define('DATE_FORMAT_FOR_FILENAME', 'Ymd');
    

    if (!defined('DIR_FS_EXPORT')) {
        define('DIR_FS_EXPORT', trimSlash(DIR_FS_CATALOG) . '/' . 'export/');
    }

    if (!defined('DIR_WS_EXPORT')) {
        define('DIR_WS_EXPORT', trimSlash(DIR_WS_CATALOG) . '/' . 'export/');
    }    
    

    $response = array();

    
    try {
    	if (!isset($_GET["method"])) {
    	    throw new Exception("Paramether 'method' is not defined.");	
        } else if ($_GET["method"] == 'check') {
            $response['success'] = true;
            $response['value'] = array_map('utf8_encode', doCheck());
    	} elseif ($_GET["method"] == 'append') {
            $response['success'] = true;
            $response['value'] = array_map('utf8_encode', doAppend());
        } elseif ($_GET["method"] == 'upload') {
            $response['success'] = true;
            $response['value'] = array_map('utf8_encode', doUpload());
	    } else {
	        $response['success'] = false;
	        $response['error'] = 'Unexpected error. Unsupported method '.$_GET['method'].'.';
	        $response['value'] = utf8_encode($response['error']); 
	    }
    } catch (DateException $e) {
    	// No error logging here (only a Notice). It is just a date validation problem.
    	just_log_recommendation(E_NOTICE, "Date validation failed. ".$e->getMessage());
    	$response['success'] = false;
        $response['error'] = utf8_encode($e->getMessage());
        $response['value'] = @array_map('utf8_encode', (array)$e); 
    } catch (IOException $e) {
    	just_log_recommendation(E_ERROR, "Usage data tools I/O error. ".$e->getMessage());
        $response['success'] = false;
        $response['error'] = utf8_encode($e->getMessage());
        $response['value'] = @array_map('utf8_encode', (array)$e); 
    }
    
    $json = json_encode($response);
    echo $json;
    
    
    /** Is called after the file export is finished 
     *  to generate MD5 hash and start upload to RE.
     */
    function doUpload() {
    	
    	just_log_recommendation(E_NOTICE, "Generating MD5 for export file for ".YOOCHOOSE_ID.".");
    	
        $salt = getGet('salt', '');
        $session = getExportSession($salt);
            
        if (!isset($session['finishedStepOfTen'])) {
            throw new Exception("Unexpected. Last export step not found in the session.", 0);
        }
        if ($session['finishedStepOfTen'] != 10) {
            throw new Exception("Unexpected. Unable to generate MD5 hash, if the export was not finished.", 0);
        }
        $dateFrom = new DateTime($session['dateFrom']);
        $dateTo = new DateTime($session['dateTo']);
        
        $origDateFrom = new DateTime($dateFrom->format('Y-M-d'));
        $origDateTo   = new DateTime($dateTo->format('Y-M-d'));
        
        $file = exportFilename($origDateFrom, $origDateTo, false, $salt);
        $fullfile = exportFullFilename($file);
        
        $fileMd5 = exportFilename($origDateFrom, $origDateTo, false, $salt, "md5");
        $fullfileMd5 = exportFullFilename($fileMd5);
        
        $md5 = md5_file($fullfile);
        
        $handle = fopen($fullfileMd5, 'w');
        if (!$handle) { 
            throwIO("I/O error. Unable to open file '$filename'.");
        }                
        
        fwrite($handle, $md5)
                || throwIO("I/O error. Unable to write to '$fullfileMd5'.");
                
        fclose($handle);
        
        $f = $origDateFrom->format(DATE_FORMAT_FOR_FILENAME);
        $t = $origDateTo->format(DATE_FORMAT_FOR_FILENAME);
        
        $baseUrl = trimSlash(HTTP_CATALOG_SERVER).DIR_WS_EXPORT;
        
        $queryString = "startDate=$f&endDate=$t&salt=$salt&baseUrl=".urlencode($baseUrl);
        
        $url =  getRegServerUrl()."/rest/".YOOCHOOSE_ID."/shopusagedata/upload.json?".$queryString;
        try {
        	just_log_recommendation(E_NOTICE, "Initiating shop usage data upload for user ".YOOCHOOSE_ID.". REST Command: ".$url);
        	$options = array(CURLOPT_TIMEOUT => 10); // 10 sec.
            load_url_ex($url, $options);
        } catch (IOException $e) {
        	just_log_recommendation(E_ERROR, "Initiating shop usage data upload for user ".YOOCHOOSE_ID." failed. REST Command: ".$url);
        	throw new IOException(sprintf(YOOCHOOSE_UPLOAD_FAILED, $e->getMessage()));
        }
        
        dropExportSession($salt);
        
        return array(
            'url' => trimSlash(DIR_WS_EXPORT).'/'.$file, 
            'md5url' => trimSlash(DIR_WS_EXPORT).'/'.$fileMd5);
    }
    

    
    /** Must be called 10 times to generate an export file.
     *  First call returns a salt, last call returns the full URL of the file, 
     *  which contains usage data. 
     */
    function doAppend() {
    	
    	global $dateFormatPhp;

        $stepOfTen = (int)getGet('stepOfTen', 0);

        if ($stepOfTen < 1 || $stepOfTen > 11) {
        	throw new Exception("'stepOfTen' must be between 1 and 10.", 0);
        }
        
        just_log_recommendation(E_NOTICE, "Appending export file for ".YOOCHOOSE_ID.". Step: ".$stepOfTen);
        
        if ($stepOfTen == 1) {
        	$salt = generateSalt(10); // 10 symbol long salt.
        	
        	$regFrom = getGet('from', date($dateFormatPhp));
            $regTo   = getGet('to',   date($dateFormatPhp));
            $dateFrom = parseDate($regFrom);
            $dateTo = parseDate($regTo);
            
        } 
        
        if ($stepOfTen > 1) {
        	$salt = getGet('salt', '');
            $session = getExportSession($salt);
            
            if (!isset($session['finishedStepOfTen'])) {
            	throw new Exception("Unexpected. Step not found in the session.", 0);
            }
            if ($session['finishedStepOfTen'] != $stepOfTen - 1) {
            	throw new Exception("Unexpected. Unable to start step $stepOfTen after step {$session['step']}.", 0);
            }
            $dateFrom = new DateTime($session['dateFrom']);
            $dateTo = new DateTime($session['dateTo']);
        }

        
        $origDateFrom = new DateTime($dateFrom->format('Y-M-d'));
        $origDateTo   = new DateTime($dateTo->format('Y-M-d'));
        
        $dateTo->modify('+1 day'); // 0:00 of the next Day
        
        $inSeconds = diffSeconds($dateTo, $dateFrom);
        
        $part = floor($inSeconds / 10);
        
        if ($stepOfTen > 1) {
        	$s = $part * ($stepOfTen-1);
            $dateFrom->modify("+{$s} second");
        }
        if ($stepOfTen < 10) {
            $s = $part * (10 - $stepOfTen);        	
            $dateTo->modify("-{$s} second");
        }

        $file = exportFilename($origDateFrom, $origDateTo, true, $salt);
        
        $fullfile = exportFullFilename($file);
        
        dateExport($dateFrom, $dateTo, $fullfile, $stepOfTen != 1);
        
        setExportSession($salt, $stepOfTen, $origDateFrom, $origDateTo);
        if ($stepOfTen != 10) {
        	return array('salt'=>$salt);
        } else {
        	$fileTarget = exportFilename($origDateFrom, $origDateTo, false, $salt);
        	$fullfileTarget = exportFullFilename($fileTarget);
        	rename($fullfile, $fullfileTarget) || throwIO("Unexpected. Unable to rename export file '{$fullfile}'");
        	return array('url'=> trimSlash(DIR_WS_EXPORT).'/'.$fileTarget, 'salt'=>$salt);
        }
        
    }
    
    
    
    /** Collect usage data statistic.
     *  Used to show to user before stating the data export. 
     */
    function doCheck() {
    	global $dateFormatPhp;
    	global $dataThresholdMb;
    	global $averageBytesPerPosition;
    	
    	$regFrom = getGet('from', date($dateFormatPhp));
    	$regTo   = getGet('to',   date($dateFormatPhp));

    	$dateFrom = parseDate($regFrom);
    	$dateTo = parseDate($regTo);
    	
    	$inDays = diffDays($dateTo, $dateFrom);
    	
    	if ($inDays < 0) {
    		throw new DateException(YOOCHOOSE_INTERVAL_NEGATIVE_ERR);
    	}
    	
    	if ($inDays > 7) { 
    	   $dateFromWeek = clone $dateTo;
    	   $dateFromWeek->modify("-7 day");
    	   
    	   $perWeek = dateCount($dateFromWeek, $dateTo);
    	   
    	   $estimateMb = (int)($perWeek / 7 * $inDays) * $averageBytesPerPosition;
    	   $sizeMb = formatFileSize($estimateMb);
    	   
    	   if ( $estimateMb > $dataThresholdMb * (1024 * 1024) ) {
    	   	   throw new DateException(sprintf(YOOCHOOSE_ESTIMATED_OVERSIZE , $sizeMb, $dataThresholdMb));
    	   }
    	}
    	
    	$perInterval = dateCount($dateFrom, $dateTo);
    	$estimateMb = (int)$perInterval * $averageBytesPerPosition;
    	$sizeMb = formatFileSize($estimateMb);
    	
        if ( $estimateMb > $dataThresholdMb * (1024 * 1024) ) {
            throw new DateException(sprintf(YOOCHOOSE_ESTIMATED_OVERSIZE , $sizeMb, $dataThresholdMb));
        }
        
        $message = sprintf(YOOCHOOSE_PRODUCTS_TO_UPLOAD, $perInterval, $sizeMb);
        $result = array( 'message' => $message,
                         'productCount' => $perInterval,
                         'estimatedSizeMb' => $estimateMb);
        
        return $result;
    }

    
    /** Returns a random string contains of latin letters and digits
     *  like 'dskfL8a934raasASDfe'. It has a specified length. */
    function generateSalt($length) {
    	$result = '';
    	for ($i=0; $i < $length; $i++) {
    	   $r = rand(1, 26*2 + 10); // a..z, A..Z, 0..9
    	   if ($r <= 26) {
    	   	   $result .= chr(ord('a') - 1 + $r);
    	   } elseif ($r <= (26*2)) {
    	   	   $result .= chr(ord('A') - 1 + $r - 26);
    	   } else {
    	   	   $result .= chr(ord('0') - 1 + $r - 26*2);
    	   }
    	}
    	return $result;
    }
    
    
    /** Generates a full filename in the backup folder. This function
     *  adds the backup path to the simple filename specified.
     *  
     *  @throws IOException
     *      If the simple filename contains illegal symbols like '/'.
     *      
     *  @see DIR_FS_BACKUP 
     * */   
    function exportFullFilename($simpleFilename) {
    	
    	if (preg_match('/['.preg_quote('<>/\\*?:|', '/').']/', $simpleFilename)) {
    		throw new IOException("Illegal filename '".$simpleFilename."'. Some symbols like '/', ':', '?' etc. are not allowed in filenames.");
    	}
    	
    	$result = rtrim(DIR_FS_EXPORT,'/\\') . '/' . $simpleFilename;
    	return $result;
    }

    
    /** Generates a simple file name (without path) for a data usage file.
     */
    function exportFilename(DateTime $from, DateTime $to, $tmp, $salt, $ext = 'csv') {
    	
    	$f = $from->format(DATE_FORMAT_FOR_FILENAME);
    	$t = $to->format(DATE_FORMAT_FOR_FILENAME);
    	
    	$filename = DATA_FILE_PREFIX.'_'.$f.'_'.$t.'_['.$salt.']'.($tmp?'.tmp':'').'.'.$ext;
    	return $filename;
    }
    
    
    /** Difference in seconds. If $b is later than $a returns
     *  a positive value.
     */
    function diffSeconds(DateTime $b, DateTime $a) {
        return $b->format('U') - $a->format('U');
    }
    
    
    /** Returns a differens in days between to timestamps.
     *  Result can be a floating point value.
     */
    function diffDays(DateTime $b, DateTime $a) {
    	
    	$bb = $b->format('U'); // UNIX TimeStamp
    	$aa = $a->format('U'); // UNIX TimeStamp
    	
    	return ($bb - $aa) / (3600 * 24);
    }
    

    /** Returns a user friendly text for the specified amount of bytes.
     *  For example 1512 -> '1.50 kB'. The numeric value returded is 
     *  usually between 1 and 1023.
     *  
     *  Uses presision 1 for values greater than 2 and presision 2 
     *  for values between 1 and 2. For example '23.1 MB', '2.34 MB' 
     *  but '1.23 MB'.
     */
    function formatFileSize($input, $decimalSeparator = '.') {
    	
    	$pow = 4;
    	
    	for (; $pow >= 0; $pow--) {
    		$rest = $input / (($pow==0) ? 1 : pow(1024, $pow));
    		if ($rest > 1) {
    			break;
    		}
    	} 
    	
    	$precision = (abs($input) < 2) ? 2 : 1; 
    	$result = sprintf("%.{$precision}f", $rest);
    	
    	if ($pow == 4) {
    		$result .= " TB";
    	} elseif ($pow == 3) {
    		$result .= " GB";
    	} elseif ($pow == 2) {
    		$result .= " MB";
    	} elseif ($pow == 1) {
    		$result .= " kB";
    	} else {
    		$result .= " B";
    	}
    	
    	return $result;
    }
    
    
    /** Returns a table engine like "MyISAM", "InnoDB" etc. for 
     *  the specified table, or null, if the table doesn't exist. 
     */
    function getTableEngine($tableName) {
    	
        $query = sprintf("show table status like '%s'", mysql_real_escape_string($tableName));
        
        $resultset = xtc_db_query($query);
        
        if ($result = xtc_db_fetch_fields($resultset)) {
        	return $resultset->Engine;
        } else {
        	return null;
        }
    }
    
    
    /** Exports usage data to file. Appends file, if specified, creates otherwise.
     *  
     *  Attention: Do not checks, if overwriting the file can be dangerous.
     *  Check it before calling the function!
     *  
     *  @param  
     *      If the file must be appended or created. Throws an exception, 
     *      if the append mode was specified and the file does not exists.      
     *  
     *  @throws IOException
     *      if something goes wrong with the output file.
     */
    function dateExport(DateTime $dateFrom, DateTime $dateTo, $filename, $append) {
        
        global $dateFormatPhpForSql; 
        global $dateTimeFormatPhpForSql;
        
        $mysqlFrom = $dateFrom->format($dateTimeFormatPhpForSql);
        $mysqlTo   = $dateTo->format($dateTimeFormatPhpForSql);
        
        if ($append) {
        	if (!file_exists($filename)) {
        		throw new IOException("Cannot append usage statistic. File '$filename' does not exist.");
            }
            if (!is_writable($filename)) {
                throw new IOException("Cannot append usage statistic. File '$filename' is not writable.");
            }
        }
        
        $sql = "SELECT o.orders_id, o.date_purchased, o.customers_id, ".
                    " op.products_id, op.products_quantity, op.products_price,o.currency ". 
                    " FROM orders_products op JOIN orders o ON op.orders_id = o.orders_id ".  
                    " WHERE o.date_purchased >= '$mysqlFrom' AND o.date_purchased < '$mysqlTo'";
        
        $resultset = xtc_db_query($sql);
        
        $handle = fopen($filename, $append ? 'a' : 'w');
        if (!$handle) { 
            throwIO("I/O error. Unable to open file '$filename'.");
        }
        
        if (! $append) {
        	$header = array('order_id', 'date_purchased', 'customer_id', 
        	       'product_id', 'product_quantity', 'product_price', 'product_currency');
        	       
            fputcsv($handle, $header, ';') 
                || throwIO("I/O error. Unable to write to '$filename'.");
        }
        
        while ($result = xtc_db_fetch_array($resultset)) {
            fputcsv($handle, $result, ';')
                || throwIO("I/O error. Unable to write to '$filename'.");
        }
        
        fclose($handle);
    }
    
    
    /** Returns an amount of order positions for the specified time interval. 
     *  Both dates of the interval are inclusive (time part is being ignored).
     */
    function dateCount(DateTime $dateFrom, DateTime $dateTo) {
    	
    	global $dateFormatPhpForSql; 
    	
    	$mysqlFrom = $dateFrom->format($dateFormatPhpForSql)." 00:00:00.00";
        $mysqlTo   = $dateTo->format($dateFormatPhpForSql)." 00:00:00.00";
        
        $sql = "SELECT count(*) c FROM orders_products op JOIN orders o ON op.orders_id = o.orders_id ".  
            " WHERE o.date_purchased BETWEEN '$mysqlFrom' AND DATE_ADD('$mysqlTo', INTERVAL 1 DAY)";
    	
        $resultset = xtc_db_query($sql);

        $result = xtc_db_fetch_array($resultset);
        return (int)$result['c'];
    }
    
        
    /** Gets an export session for the salt specified.
     *  Throws Exception, if the export session doen't exists. 
     *  */
    function getExportSession($salt) {
        if (!isset($_SESSION['usage_date_export'])) {
            throw new Exception("Your export session not exists. Expired?", 0);
        }
            
        if (!isset($_SESSION['usage_date_export'][$salt])) {
            throw new Exception("Step 1 for your export session was never finished [salt: $salt]. Timeout?", 0);
        }
        $session = $_SESSION['usage_date_export'][$salt];
        return $session;
    }
    

    /** Sets an export session.
     *  It saves the data needed for the next step.  
     */
    function setExportSession($salt, $finishedStepOfTen, $origDateFrom, $origDateTo) {
        $mySession = array(
           "salt" => $salt, 
           "finishedStepOfTen" => $finishedStepOfTen,
           "dateFrom" => $origDateFrom->format('Y-M-d'),
           "dateTo" => $origDateTo->format('Y-M-d') );
         
        if (!isset($_SESSION['usage_date_export'])) {
            $_SESSION['usage_date_export'] = array();
        }
        
        $_SESSION['usage_date_export'][$salt] = $mySession;
    }
    
    
    /** Resets the export session. Used after step 10 completed. */
    function dropExportSession($salt) {
        if (!isset($_SESSION['usage_date_export'])) {
            return;
        }
        unset($_SESSION['usage_date_export'][$salt]);
    }
    
    


    
?>