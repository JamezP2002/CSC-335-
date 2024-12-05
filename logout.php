<?php
session_start(); // Start the session

// Destroy the session to log the user out
session_destroy();

// Redirect to the homepage
header("Location: index.php");
exit();
?>
