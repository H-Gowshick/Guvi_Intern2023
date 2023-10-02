<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION["user_id"])) {
    // Unset all session variables
    session_unset();

    // Destroy the session
    session_destroy();

    // Redirect the user to the login page (you can change the URL as needed)
    header("Location: login.html");
    exit();
} else {
    // If the user is not logged in, simply redirect them to the login page
    header("Location: login.html");
    exit();
}
?>
