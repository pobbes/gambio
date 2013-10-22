<?php
if (isset($_GET['action']) AND ($_GET['action'] == 'logout')){ 
    session_unset(); 
    session_destroy(); //Session zerstoeren

    header("Location: $pfad"); // Weiterleitung 
} 
?>
