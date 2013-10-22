<?php
/* --------------------------------------------------------------
   Yoochoose GmbH
   http://www.yoochoose.com
   Copyright (c) 2011 Yoochoose GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   -------------------------------------------------------------- */
   defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');
   
   ///
   /// Check frame for Yoochoose configuration module.
   /// It is included to /admin/yoochoose.php  
   ///

   
    echo '<div style="padding: 20px 40px 30px 40px;" class="yoo-image6-large">';

    define('AVAILABLE', '<span style="color:green; font-weight:bold;">available</span>');
    define('SUCCESSFUL', '<span style="color:green; font-weight:bold;">successful</span>');
    define('UNAVAILABLE', '<span style="color:red; font-weight:bold;">unavailable</span>');
    define('FAILED', '<span style="color:red; font-weight:bold;">failed</span>');

    echo '<h2>YOOCHOOSE REQUIREMENTS CHECKING</h2>';
    
    echo '<h3>PHP Configuration</h3>';
    echo '<p>';

    echo 'Your PHP Version (5.1 required, 5.2 or higher recommended): <b>'.phpversion().'</b><br>';
    
    echo 'Function json_decode: '.(function_exists('json_decode') ? AVAILABLE : UNAVAILABLE).'<br>';
    
    echo 'Module curl: '.(in_array('curl', get_loaded_extensions()) ? AVAILABLE : UNAVAILABLE).'<br>';
    
    echo 'Object DateTime: '.(class_exists('DateTime') ? AVAILABLE : UNAVAILABLE).'<br>';
    
    echo '<h3>Connectivity</h3>';
    echo '<p>';
    
    $url = getMeUrl();
    curlSomeAdress("Requesting myself as [$url]", $url);
        
    $url = 'http://google.com';
    curlSomeAdress("Requesting Google as [$url]", $url);    
    
    $url = 'http://config.yoochoose.net';
    curlSomeAdress("Requesting YOOCHOOSE registration server [$url]", $url);    
         
    $url = 'https://config.yoochoose.net';
    curlSomeAdress("Requesting YOOCHOOSE registration server over SSL [$url]", $url);    
    
    echo '<h3>Authentication</h3>';
    echo '<p>';
    
    if (!isset($_POST["id"])) {
    	echo '<form method="POST" action="yoochoose.php?page=check">';
        echo 'Enter your customer ID <input name="id" value="'.htmlentities(@$_POST["id"]).'"> ';
        echo ' and license key <input name="key" value="'.htmlentities(@$_POST["key"]).'">.';
        echo ' <input type="submit" value="&gt;&gt;">';
        echo '</form>';
    } else {
    	
        $url = 'http://reco.yoochoose.net/ebl/recommendation/'.$_POST["id"].'/also_purchased.json';
        curlSomeAdress("Requesting YOOCHOOSE recommendations [$url]", $url);     	
    	
        $url = 'https://config.yoochoose.net/rest/'.$_POST["id"].'/license.json';
        curlSomeAdress("Requesting YOOCHOOSE license [$url]", $url, $_POST["id"], $_POST["key"]);
        
        $url = 'https://config.yoochoose.net/rest/'.$_POST["id"].'/counter/summary.json';
        curlSomeAdress("Requesting YOOCHOOSE statistic [$url]", $url, $_POST["id"], $_POST["key"]);        
    }

    
    echo '</div>';
    
    
    /////////////////////////////// SOME FUNCTIONS
    
    function getMeUrl() {
    	$httpsStr = @$_SERVER['HTTPS'];
    	
    	$a = (@$httpsStr && $httpsStr != 'off') ? 'https' : 'http';
    	$b = $_SERVER['SERVER_NAME'];
    	$c = $_SERVER['SERVER_PORT']; 
    	return $a."://".$b.":".$c;
    }
    
    function curlSomeAdress($name, $url, $user='', $password='') {
    	$options = array(
	        CURLOPT_URL => $url,
	        CURLOPT_HEADER => TRUE,
	        CURLOPT_RETURNTRANSFER => TRUE,
	        CURLOPT_TIMEOUT => 4,
	        CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
	        CURLOPT_SSL_VERIFYPEER => FALSE,
	        CURLOPT_FAILONERROR => TRUE
	    );
	    
	    if ($user) {
	    	$options[CURLOPT_USERPWD] = "$user:$password";
	    }
	
	    $ch = curl_init();
	    
        if (!$ch) {
            echo '<b>failed</b>. Unable to initialize curl. Error code: '.$n.' Error Message: '.$m;
        }
	    
	    curl_setopt_array($ch, $options);
	
	    echo $name.': ';
	    
	    $scs = curl_exec($ch);
	    $n = curl_errno($ch);
	    $m = curl_error($ch);
	    
	    if ($scs) {
	        echo SUCCESSFUL;
	    } else {
	        echo FAILED." $n: $m";
	    }
	    
	    echo '</br>';
	
	    curl_close($ch);
    } 

?>