<?php

session_start();

include ('includes/db_functions.inc.php');

ob_start();    // startet den Ausgabepuffer
?> 

<?php include ('includes/header.inc.php'); ?>

<?php

$pfad = $_SERVER['PHP_SELF']; // generiert aktueller Pfad zur Datei  

// -------------------------------- Logout --------------------------------------
if (isset($_GET['action']) AND ($_GET['action'] == 'logout')){ 
    session_unset(); 
    session_destroy(); //Session zerstoeren

header("Location: $pfad"); // Weiterleitung 
} 

// ------------------------------------ Login ---------------------------------------
if (!isset($_SESSION['login'])){ // if NOT logged in 
    
    // LoginFormular ausgeben
    include ('includes/login.inc.php');    
}
//------------------------------------- Login ENDE -----------------


if(isset($_SESSION['login'])){ // if logged in
    
    if(isset($_POST['submit'])){ // if submit is pressed
        
        // Pruefen ob input'image' nicht leer ist
        if(empty($_FILES['file']['tmp_name'])) { 
            $message.= 'Bitte eine Datei angeben ... <br />'; $error = "1"; // Fehler
            
        }else
        { 
    
            if(isset($_FILES['file']['tmp_name'])){ $tmp_name = $_FILES['file']['tmp_name']; } 	// Originaler Dateiname 
            if(isset($_FILES['file']['name'])){ $name = $_FILES['file']['name']; }		   		// Originalname 
            if(isset($_FILES['file']['size'])){ $size = $_FILES['file']['size']; }		   		// Groeße der Datei 
            if(isset($_FILES['file']['type'])){ $type = $_FILES['file']['type']; } 		   		// MIME Type der Datei 
    
            echo $_FILES['file']['name'];
        
            $datei_typ = strrchr($_FILES['file']['name'], ".");    // Dateieindung herausfiltern
    
            // Pruefen ob die Datei erlaubt ist 
            if(in_array($datei_typ, $allowed_files)){
        
                // Pruefen ob die Dateigroesse passt / keine leere Datei ist
                if($size <= $maxsize && $size!=0){
                
                    $newname = md5(uniqid(rand())); // Der Datei einen neuen einmaligen Namen verpassen
                
                    // Datei in Verzeichnis kopieren
                    if(move_uploaded_file($tmp_name, $uploaddir.$newname.$datei_typ)){
            
                        echo "<h2>Die Datei wurde erfolgreich hochgeladen...</h2>"; 
                        echo "<p><strong>Dateigroesse:</strong> ".grafixx_size($size)."<br />\n"; 
                        echo "<strong>MIME-Type:</strong>  ".$type." <br /><br />\n";
                        echo "<strong>Datei ansehen =></strong>\n";
                        echo "<a href='".$uploaddir.$newname.$datei_typ."' target=\"_blank\">".$uploaddir.$newname.$datei_typ."</a></p>\n"; 
                        
                        $okay = "yes";  
                    
                    }else{ // Wenn Datei nicht ins angegebene Verzeichnis kopiert werden konnte
                        $message .= 'Datei konnte nicht verschoben werden ... <br />'; 
                        $error = "1"; // Fehler
                    }
            
                }else{ // Wenn Datei zu gross ist
                    $message .= "Die Datei <strong>".$name."</strong> ist größer als die erlaubten ".grafixx_size($maxsize)." ... <br />"; 
                    $error = "1"; // Fehler
                } 
                
            }else{ // Wenn Dateityp nicht erlaubt ist
                $message .= "Der Dateityp der Datei <strong>".$name."</strong> ist nicht gestattet ...<br />"; 
                $error = "1"; 
            }
    
        } // close (empty($_POST['images'])) 
    
        if(isset($error) && ($error == "1")){ // Fehlermeldungen ausgeben
            echo "<div class=\"error\"><h1>Error ...</h1>\n <p>$message</p></div>";
        } 
        
        $title = clean_it($_POST['title']);
        $position = clean_it($_POST['position']);
        $is_active = clean_it($_POST['is_active']);
                
        storeImage("$title",
                   "$uploaddir$newname$datei_typ",
                   "$position",
                   "data_text_id",
                   "data_initial_left",
                   "data_final_left",
                   "data_initial_top",
                   "data_final_top",
                   "data_duration",
                   "data_fade_start",
                   "data_delay",
                   "$is_active");
        
    } // close submit gedrueckt Wenn nicht submit gedrueckt 
    
    if(!isset($okay)){ // wenn nicht okay -> Formular ausgeben
    
    include ('includes/upload.inc.php');

    } // close !okay

}// close eingeloggt 
?>

<?php include ('includes/footer.inc.php'); ?>