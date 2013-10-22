<?php
error_reporting(E_ALL ^ E_NOTICE);
 
require_once 'db_connect.inc.php';

//-----------------------------------------------------------------------------------------------
// Configuration                                                                            
//-----------------------------------------------------------------------------------------------
	 	 
$maxsize = "1048576"; 						        // Maximale Uploadgroesse (1 MB) 
$uploaddir = "images/"; 					        // Upload Ordner
$allowed_files = array(".jpg", ".gif", ".png"); 	// Erlaubte Dateien

//-----------------------------------------------------------------------------------------------
// Check DB-Entrys => SQL Injektions
//-----------------------------------------------------------------------------------------------

function clean_it($dirty){
         
    // Auswirkungen von magic_quotes_gpc zuruecksetzen, wenn ON
    if (get_magic_quotes_gpc()) {
        $clean = mysql_real_escape_string(stripslashes(htmlspecialchars($dirty)));
    }
    
    else{
        $clean = mysql_real_escape_string(htmlspecialchars($dirty));
    }
    return $clean;
}
    
//-----------------------------------------------------------------------------------------------
// Functions to handle errors/okays
//-----------------------------------------------------------------------------------------------
    
function get_error($var){
    
    $fehler = "<div class=\"error\"><h2>Error ...</h2>\n<p>".$var."</p>\n</div>\n";
    return $fehler;
}
	 
function get_okay($var){
    
    $fehler = "<div class=\"no_error\"><h2>Prima ...</h2>\n<p>".$var."</p>\n</div>\n";
    return $fehler;
}

//-----------------------------------------------------------------------------------------------
// Login
//-----------------------------------------------------------------------------------------------

function login($log_email, $log_pass){  
    
    session_start();
    
    $hostname = $_SERVER['HTTP_HOST'];
    $path = dirname($_SERVER['PHP_SELF']);
    
    $login_email = clean_it($log_email);
    $login_pass = md5(clean_it($log_pass));
        
    $login = mysql_query("SELECT customers_id FROM customers WHERE customers_email_address='$login_email' AND customers_password='$login_pass'");
	     
    // if login SUCCESSFUL
	if(mysql_num_rows($login) == "1"){   
        
        $_SESSION['login'] = true;    
        header('Location: http://'.$hostname.($path == '/' ? '' : $path).'/index.php');
        exit;      
    }
    
    else{       
        
        $message = 'Zugriff verweigert ... <br />';
        $error = "1"; // Fehler        
    }
    
    if($error != "1"){ // Wenn kein Fehler    
        
        $_SESSION['login'] = $_SERVER['REMOTE_ADDR'];    
        header('Location: http://'.$hostname.($path == '/' ? '' : $path).'/index.php');
        exit;
    }    
    
    if($error == "1"){ // error
        
        echo "<div class=\"error\"><h1>Error ...</h1>\n <p>$message</p></div>";
    }
}

//-----------------------------------------------------------------------------------------------
// Logout
//-----------------------------------------------------------------------------------------------

function logout(){   
    
    // if logged in
    if(isset($_SESSION['login'])){
        
        echo "<div class=\"btn btn-red small right clearfix\"><a href=\"$pfad?action=logout\">logout</a></div>";
    }
}

//-----------------------------------------------------------------------------------------------
// STORE image data in mysql
//-----------------------------------------------------------------------------------------------

function storeImage(
$title,
$path,
$position,
$data_text_id,
$data_initial_left,
$data_final_left,
$data_initial_top,
$data_final_top,
$data_duration,
$data_fade_start,
$data_delay,
$is_active) {
        
    $result = mysql_query(
    "INSERT INTO sliderimages(
    title,
    path, 
    position,
    data_text_id,
    data_initial_left, 
    data_final_left,
    data_initial_top,
    data_final_top,
    data_duration, 
    data_fade_start, 
    data_delay, 
    is_active, 
    datum
    ) VALUES(
    '$title',
    '$path', 
    '$position', 
    '$data_text_id', 
    '$data_initial_left', 
    '$data_final_left', 
    '$data_initial_top', 
    '$data_final_top', 
    '$data_duration', 
    '$data_fade_start', 
    '$data_delay', 
    '$is_active', 
    NOW())");
    		
    // check for successful store
    if ($result) 
	{
        
        $id = mysql_insert_id(); // last inserted id
        $result = mysql_query("SELECT * FROM sliderimages WHERE id = '$id' ");
		        
        print_r(mysql_fetch_array($result));
        
    } 
    
	else 
	{    
    	return false;
    }
}

//-----------------------------------------------------------------------------------------------
// GET image by ID
//-----------------------------------------------------------------------------------------------

function getImage($id) {
    
    $result = mysql_query("SELECT * FROM sliderimages WHERE id = '$id' ");
        
    // check for empty result
	if (mysql_num_rows($result) > 0)
	{    
        
        $row = mysql_fetch_array($result) or die(mysql_error());
        
        return $row;        
        
    } 
	else 
	{
        return false;
    }
} 

//-----------------------------------------------------------------------------------------------
// GET all images
//-----------------------------------------------------------------------------------------------

function getAllImages() {
    		
    $result = mysql_query("SELECT id, path, title, position,is_active FROM sliderimages ORDER BY position, is_active ASC");
    
    return $result;
} 

//-----------------------------------------------------------------------------------------------
// SET how much slides should be shown
//-----------------------------------------------------------------------------------------------

function setSlides($id) {
    		
    mysql_query("UPDATE slideradmin SET is_active = '0' WHERE is_active = '1' ");
    mysql_query("UPDATE slideradmin SET is_active = '1' WHERE id = '$id' ");

} 

//-----------------------------------------------------------------------------------------------
// GET how much slides should be shown
//-----------------------------------------------------------------------------------------------

function getSlides() {
    		
    $result = mysql_query("SELECT id, slides, is_active FROM slideradmin ");
        	
    return $result;
} 

//-----------------------------------------------------------------------------------------------
// ACTIVATE image by ID
//-----------------------------------------------------------------------------------------------

function activateImage($id) {
        		
    $result = mysql_query("UPDATE sliderimages SET is_active = '1' WHERE id = '$id' ");
    
    echo "ID: $id aktiviert";
        	
    //return $result;
} 

//-----------------------------------------------------------------------------------------------
// DEACTIVATE image by ID
//-----------------------------------------------------------------------------------------------

function deactivateImage($id) {
    	    
    $result = mysql_query("UPDATE sliderimages SET is_active = '0' WHERE id = '$id' ");
    
    echo "ID: $id deaktiviert";
    
    //return $result;
} 

//-----------------------------------------------------------------------------------------------
// DELETE image by ID
//-----------------------------------------------------------------------------------------------

function deleteImage($id) {
    
    $result = mysql_query("SELECT path FROM sliderimages WHERE id = '$id' ");
    
    $path = mysql_fetch_result($result);
    
    // delete file on server
    unlink('$path');
    		
    // delete image in mysql
    $result = mysql_query("DELETE FROM sliderimages WHERE id = '$id' ");    
    
    return $result;
} 

//-----------------------------------------------------------------------------------------------
// COUNT all images
//-----------------------------------------------------------------------------------------------

function countImages() {
    
    $result = mysql_query("SELECT * FROM sliderimages ");
    $num_rows = mysql_num_rows($result, 0);
    
    return $num_rows;
}

//-----------------------------------------------------------------------------------------------
// GET active images => Final Slides
//-----------------------------------------------------------------------------------------------

function getFinalSlides() {
    
    $result = mysql_query("SELECT id, title, path FROM sliderimages WHERE is_active = '1' ORDER BY position ASC ");
        
    return $result;
}

//-----------------------------------------------------------------------------------------------
// Funktion um die Maximale Dateigroesse uebersichtlich in KB/MB/GM darzustellen
//-----------------------------------------------------------------------------------------------

function upload_size($datei_size, $nachkommastellen = 0) {
    $d_size = $datei_size;
    
    if($d_size >= 1073741824){ // wenn groeser als 1073741824 Byte - GB ausgeben
        return round($d_size/(1073741824), $nachkommastellen)." GB";
    }
    
    if($d_size >= 1048576){ // wenn groesser als 1048576 Byte - MG ausgeben
        return round($d_size/(1048576), $nachkommastellen)." MB";
    }
    
    if($d_size >= 1024){ // wenn groesser als 1024 Byte - KB ausgeben
        return round($d_size/(1024), $nachkommastellen)." KB";
    }
    
    return $d_size." Byte";
}
?>