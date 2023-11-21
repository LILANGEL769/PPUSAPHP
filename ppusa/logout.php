<?php
session_start(); // Start the session

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the login page or any other appropriate page after logout
header("Location: login.php");
exit();
?>
