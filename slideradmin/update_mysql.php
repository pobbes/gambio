<?php
	 
include ('../includes/configure.php');
	 
$connection = mysql_connect(DB_SERVER , DB_SERVER_USERNAME , DB_SERVER_PASSWORD) OR DIE ("Keine Verbindung zu der Datenbank moeglich.");
$db = mysql_select_db(DB_DATABASE , $connection) or die ("Auswahl der Datenbank nicht moeglich."); 
//---------------------------------------------------
    
mysql_query("ALTER TABLE sliderimages ADD link_to_offer VARCHAR(255)") or die(mysql_error());  

mysql_query("INSERT INTO slideradmin (slides, is_active) VALUES ('3', '0'); ") or die ("Could not insert slides #1!"); 
mysql_query("INSERT INTO slideradmin (slides, is_active) VALUES ('5', '1'); ") or die ("Could not insert slides #2!"); 
mysql_query("INSERT INTO slideradmin (slides, is_active) VALUES ('7', '0'); ") or die ("Could not insert slides #3!"); 

 
mysql_close(); // beendet die DB-Verbindung

echo "Success !";
echo "<br />";
echo "<a href=\"index.php\">Go to Login</a>";
    
?>