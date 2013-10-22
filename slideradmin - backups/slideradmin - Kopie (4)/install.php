<?php
	 
include ('../includes/configure.php');
	 
$connection = mysql_connect(DB_SERVER , DB_SERVER_USERNAME , DB_SERVER_PASSWORD) OR DIE ("Keine Verbindung zu der Datenbank moeglich.");
$db = mysql_select_db(DB_DATABASE , $connection) or die ("Auswahl der Datenbank nicht moeglich."); 
//---------------------------------------------------

mysql_query("DROP TABLE IF EXISTS sliderimages") or die ("Could not delete table 'sliderimages'!"); 

mysql_query("DROP TABLE IF EXISTS slideradmin") or die ("Could not delete table 'slideradmin'!"); 
    
mysql_query("CREATE TABLE IF NOT EXISTS sliderimages ( 
            id INT(255) NOT NULL auto_increment,
            title varchar(100) NOT NULL,
            path varchar(255) NOT NULL,
            position INT(255) NOT NULL,
            data_text_id varchar(255) NOT NULL,
            data_initial_left INT(255) NOT NULL,
            data_final_left INT(255) NOT NULL,
            data_initial_top INT(255) NOT NULL,
            data_final_top INT(255) NOT NULL,
            data_duration INT(255) NOT NULL,
            data_fade_start INT(255) NOT NULL,
            data_delay INT(255) NOT NULL,            
            is_active bool NOT NULL default '0',
            datum datetime NOT NULL default '0000-00-00 00:00:00',
            PRIMARY KEY (id) ); 
            ") or die ("Could not create table 'sliderimages'!"); 

mysql_query("CREATE TABLE IF NOT EXISTS slideradmin ( 
            id INT(255) NOT NULL auto_increment,
            slides INT(255) NOT NULL,
            is_active bool NOT NULL default '0',
            PRIMARY KEY (id) ); 
            ") or die ("Could not create table 'slideradmin'!"); 

mysql_query("INSERT INTO slideradmin (slides, is_active) VALUES ('3', '0'); ") or die ("Could not insert slides #1!"); 
mysql_query("INSERT INTO slideradmin (slides, is_active) VALUES ('5', '1'); ") or die ("Could not insert slides #2!"); 
mysql_query("INSERT INTO slideradmin (slides, is_active) VALUES ('7', '0'); ") or die ("Could not insert slides #3!"); 

 
mysql_close(); // beendet die DB-Verbindung

echo "Success !";
echo "<br />";
echo "<a href=\"index.php\">Go to Login</a>";
    
?>