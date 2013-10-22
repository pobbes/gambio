<?php
error_reporting(E_ALL ^ E_NOTICE);
 
require_once 'db_connect.inc.php';

//-----------------------------------------------------------------------------------------------
// Configuration                                                                            
//-----------------------------------------------------------------------------------------------
	 	 
$maxsize = "1048576"; 						        // Maximale Uploadgroesse (1 MB) 
$uploaddir = "images/"; 					        // Upload Ordner
$allowed_files = array(".jpg", ".png"); 	// Erlaubte Dateien

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
    
    $login_email = clean_it($log_email);
    $login_pass = md5(clean_it($log_pass));
        
    $login = mysql_query("SELECT customers_id FROM customers WHERE customers_email_address='$login_email' AND customers_password='$login_pass'");
	     
    // if login SUCCESSFUL
	if(mysql_num_rows($login) == "1"){   
        
        $_SESSION['login'] = true;    
        
        header("Location: $pfad"); // => Logged in    
    }
    
    else{       
        
        $message = 'Zugriff verweigert ... <br />';
        $error = "1"; // Fehler        
    }
    
    if($error != "1"){ // Wenn kein Fehler    
        
        $_SESSION['login'] = $_SERVER['REMOTE_ADDR'];    
        header("Location: $pfad"); // => Logged in  
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
    		
    $result = mysql_query("SELECT id, path, title, position, is_active FROM sliderimages ORDER BY position, is_active ASC");
    
    return $result;
} 

//-----------------------------------------------------------------------------------------------
// SET how much slides should be shown
//-----------------------------------------------------------------------------------------------

function setSlides($id) {
    		
    mysql_query("UPDATE slideradmin SET is_active = '0' WHERE is_active = '1' ");
    mysql_query("UPDATE slideradmin SET is_active = '1' WHERE id = '$id' ");
    
    echo "<div class=\"response\">Einstellungen gespeichert</div>";
    
    header("refresh:1; index.php"); 
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
    
    $msg = "<div class=\"response\">Bild aktiviert</div>";
    
    echo $msg;
    
    header("refresh:1; index.php"); 
        	
} 

//-----------------------------------------------------------------------------------------------
// DEACTIVATE image by ID
//-----------------------------------------------------------------------------------------------

function deactivateImage($id) {
    	    
    $result = mysql_query("UPDATE sliderimages SET is_active = '0' WHERE id = '$id' ");
    
    echo "<div class=\"response\">Bild deaktiviert</div>";
    
    header("refresh:1; index.php"); 
} 

//-----------------------------------------------------------------------------------------------
// DELETE image by ID
//-----------------------------------------------------------------------------------------------

function deleteImage($id) {
    
    $result = mysql_query("SELECT path FROM sliderimages WHERE id = '$id' ");
    
    $array = mysql_fetch_array($result);
    
    $path = getcwd();
    $pathToImage = $array['path'];       
    
    // delete file on server    
    if (!unlink($path."/".$pathToImage)) {      
        
        echo ("Error deleting image!");
        
        echo getcwd();
        
        echo $path;
        
        //header("refresh:2; index.php");     
        
    }
    else {
        // delete image in mysql
        $result = mysql_query("DELETE FROM sliderimages WHERE id = '$id' ");
    
        echo "<div class=\"response\">Bild Gel&ouml;scht</div>";
        
        header("refresh:1; index.php");     
    
    }
} 

//-----------------------------------------------------------------------------------------------
// COUNT all images
//-----------------------------------------------------------------------------------------------

function countImages() {
    
    $result = mysql_query("SELECT * FROM sliderimages ");
    $num_rows = mysql_num_rows($result);
    
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
// SHOW final slides
//-----------------------------------------------------------------------------------------------

function showFinalSlides() {
    
    $final_slides = mysql_query("SELECT id, title, path FROM sliderimages WHERE is_active = '1' ORDER BY position ASC ");
    
    // number of slides where is_active=1
	$num_rows = mysql_num_rows($final_slides);
    
    // get how much slides should be shown in slider
    $slides_to_show = mysql_query("SELECT slides FROM slideradmin WHERE is_active = '1' ");
    
    // initialize counter
    $counter = "0";
    
    $row = mysql_fetch_array($slides_to_show);
	
	if($num_rows > "0") {
	
		while($final_slides_row = mysql_fetch_array($final_slides, MYSQL_ASSOC))
		{
            // stop when number of slides to show is reached
            if ($counter == $row["slides"]) {
                break;
            }            
    
			$final_slides_id    =   stripslashes($final_slides_row['id']);
			$final_slides_title =   stripslashes($final_slides_row['title']);                             
			$final_slides_path  =   stripslashes($final_slides_row['path']);
            
            $counter++;                    
		?>
                                    
		<img src="<?php echo $final_slides_path ?>" alt="<?php echo $final_slides_title ?>" width="530" height="240" />

		<?php
		}    
	}
	else {
		?>
		<br />
		<span>Keine Bilder zum Anzeigen verfügbar !</span>

	<?php
	}
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