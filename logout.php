<?php
// Initialize the session
session_start();
 
session_destroy();
 
// Redirect to login page
header("location: index.php");
exit;
?>