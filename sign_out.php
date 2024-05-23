<?php
// Start the session
session_start();

// Clear all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect the user to the sign_in.html page
header("Location: sign_in.html");

// Exit the script to prevent further execution
exit();
?>