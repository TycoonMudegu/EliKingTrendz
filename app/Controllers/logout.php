<?php
session_start();


// Unset the user token and destroy the session
unset($_SESSION);
session_destroy();

// Redirect to the logged out page
header("Location: Loggedout");



// Redirect to the homepage or login page
header('Location: Home?You are logged out'); // Change this to your desired redirect location
exit();
