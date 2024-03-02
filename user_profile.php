<?php
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header('Location: login.html');
    exit();
}

// Display user information
$username = $_SESSION['username'];
?>

<!-- Similar to the previous example -->
