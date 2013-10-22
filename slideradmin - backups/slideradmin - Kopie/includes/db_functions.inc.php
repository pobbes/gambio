<?php
error_reporting(E_ALL ^ E_NOTICE);
 
require_once 'db_connect.inc.php';

//-----------------------------------------------------------------------------------------------
// Konfiguration                                                                            
//-----------------------------------------------------------------------------------------------
	 	 
$maxsize = "1048576"; 						        // Maximale Uploadgroesse (1 MB) 
$uploaddir = "images/"; 					        // Upload Ordner
$allowed_files = array(".jpg", ".gif", ".png"); 	// Erlaubte Dateien

//-----------------------------------------------------------------------------------------------
// Funktion um die DB-Eintraege zu pruefen => SQL Injektions
//-----------------------------------------------------------------------------------------------

function clean_it($dirty){
         
    // Auswirkungen von magic_quotes_gpc zuruecksetzen, wenn ON
    if (get_magic_quotes_gpc()) {
        $clean = mysql_real_escape_string(stripslashes(htmlspecialchars($dirty)));
    }else{
        $clean = mysql_real_escape_string(htmlspecialchars($dirty));
    }
    return $clean;
}
    
//-----------------------------------------------------------------------------------------------
// Funktion um Fehler zu behandeln
//-----------------------------------------------------------------------------------------------
    
// Funktion zum Fehler ausgeben
function get_error($var){
    $fehler = "<div class=\"error\"><h2>Error ...</h2>\n<p>".$var."</p>\n</div>\n";
    return $fehler;
}
	 
// Funktion um no error ausgeben
function get_okay($var){
    $fehler = "<div class=\"no_error\"><h2>Prima ...</h2>\n<p>".$var."</p>\n</div>\n";
    return $fehler;
}

//-----------------------------------------------------------------------------------------------
// Funktion für den Login
//-----------------------------------------------------------------------------------------------
function login($log_email, $log_pass){  
    
    $login_email = clean_it($log_email);
    $login_pass = md5(clean_it($log_pass));
        
    $login = mysql_query("SELECT customers_id FROM customers WHERE customers_email_address='$login_email' AND customers_password='$login_pass'");
	     
	if(mysql_num_rows($login) == "1"){ // korrekt eingeloggt
	     
        $_SESSION['login'] = true;    
        header("Location: $pfad"); // Weiterleitung => Eingeloggt

    }else{
        $message = 'Zugriff verweigert ... <br />';
        $error = "1"; // Fehler
    }
        
    if($error != "1"){ // Wenn kein Fehler
            
        $_SESSION['login'] = $_SERVER['REMOTE_ADDR'];    
        header("Location: $pfad"); // Weiterleitung => Eingeloggt
    }
        
    if($error == "1"){ // Fehlermeldung ausgeben
        echo "<div class=\"error\"><h1>Error ...</h1>\n <p>$message</p></div>";
    }
}

//-----------------------------------------------------------------------------------------------
// Funktion für Logout
//-----------------------------------------------------------------------------------------------

function logout(){       
    
    if(isset($_SESSION['login'])){ // Wenn eingeloggt
        echo "| <a href=\"$pfad?action=logout\">logout</a>";
    }
}

//-----------------------------------------------------------------------------------------------
// Insert image data in mysql
//-----------------------------------------------------------------------------------------------

function storeImage($title,
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
                    $is_active) 
{
        
    $result = mysql_query("INSERT INTO sliderimages(
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
    
        // get user details
        $id = mysql_insert_id(); // last inserted id
        $result = mysql_query("SELECT * FROM sliderimages WHERE id = $id");
		        
        // return user details
        print_r(mysql_fetch_array($result));
        
    } 
	else 
	{    
    	return false;
    }
}

//-----------------------------------------------------------------------------------------------
// Get image
//-----------------------------------------------------------------------------------------------

function getImage($id) {
    
    $result = mysql_query("SELECT * FROM sliderimages WHERE id = $id");
        
    // check for empty result
	if (mysql_num_rows($result) > 0)
	{    
        // return user details
        //print_r (mysql_fetch_array($result));  
        $row = mysql_fetch_array($result) or die(mysql_error());
        
        return $row;        
        
    } 
	else 
	{
        return false;
    }
} 

//-----------------------------------------------------------------------------------------------
// Get images
//-----------------------------------------------------------------------------------------------

function getAllImages() {
    		
    $result = mysql_query("SELECT id, path, title, position,is_active FROM sliderimages ORDER BY position, is_active ASC");
    
    return $result;
} 

//-----------------------------------------------------------------------------------------------
// Set slides
//-----------------------------------------------------------------------------------------------

function setSlides($id) {
    		
    $result = mysql_query("SELECT slides FROM slideradmin WHERE id = '1' ");
        
    // check for empty result
	if (mysql_num_rows($result) > 0)
	{			
        return mysql_fetch_assoc($result);
    } 
	else 
	{
        return false;
    }
} 

//-----------------------------------------------------------------------------------------------
// Get slides
//-----------------------------------------------------------------------------------------------

function getSlides() {
    		
    $result = mysql_query("SELECT id, slides, is_active FROM slideradmin ");
        	
    return $result;

} 

//-----------------------------------------------------------------------------------------------
// Funktion um die Anzahl der Bilder zu ermitteln
//-----------------------------------------------------------------------------------------------

function countImages() {
    
    $result = mysql_query("SELECT * FROM sliderimages");
    $num_rows = mysql_num_rows($result, 0);
    
    return $num_rows;
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