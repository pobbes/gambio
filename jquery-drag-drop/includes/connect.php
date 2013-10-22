<?php
include( '../includes/configure.php');

echo "connect.php";

$conn = mysql_connect(DB_SERVER , DB_SERVER_USERNAME , DB_SERVER_PASSWORD) OR DIE ("Keine Verbindung zu der Datenbank moeglich.");
mysql_select_db("gambio2");
?>