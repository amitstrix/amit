<?php
session_start(); // Start session to manage user authentication

include 'connect.php';

// Check if user is authenticated
if (!isset($_SESSION['name'])) {
    header("Location: dashboard.php"); // Redirect to login page if not authenticated
    exit();
}

// Check if the authenticated user is an admin
if ($_SESSION['role'] !== 'admin') {
    echo "You don't have permission to access this page."; // Display error message if not an admin
    exit();
}

include 'connect.php';

// Delete user if ID is provided
if (isset($_GET['id'])) {
    $userIdToDelete = $_GET['id'];

    // Use prepared statement to prevent SQL injection
    $sql = "DELETE FROM logintable WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt === false) {
        die('Error preparing delete statement: ' . mysqli_error($conn)); // Check for query preparation error
    }

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "i", $userIdToDelete);

    // Execute the statement
    $success = mysqli_stmt_execute($stmt);

    // Check for errors
    if ($success === false) {
        die('Could not delete user: ' . mysqli_error($conn)); // Display deletion error
    } else {
        echo "<h2>User deleted successfully</h2>";
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    echo "No user ID provided for deletion.";
}

// Fetch users from database
$sql = "SELECT * FROM logintable";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error fetching users: " . mysqli_error($conn));
}

mysqli_close($conn); // Close database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <button><a href="dashboard.php">Check Dashboard</a></button>
</body>
</html>
