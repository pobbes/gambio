<?php 
include("includes/connect.php");

$array	= $_POST['arrayorder'];
if ($_POST['update'] == "update"){
		
	$count = 1;
	foreach ($array as $idval) {
		$query = "UPDATE sliderimages SET position = " . $count . " WHERE id = " . $idval;
		mysql_query($query) or die('Error, insert query failed');
		$count ++;	
	}
	echo 'All saved! refresh the page to see the changes';
}
?>