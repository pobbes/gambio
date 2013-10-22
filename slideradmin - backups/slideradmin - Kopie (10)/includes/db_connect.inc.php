<?php

require_once '../includes/configure.php';
        		
// connecting to mysql
$connection = mysql_connect(DB_SERVER , DB_SERVER_USERNAME , DB_SERVER_PASSWORD) OR DIE ("Keine Verbindung zu der Datenbank moeglich.");
		
// selecting database
$db = mysql_select_db(DB_DATABASE , $connection) or die ("Auswahl der Datenbank nicht moeglich."); 
  
?>