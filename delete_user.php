<?php
include 'connect.php';

if (isset($_GET['id'])) {
    $userIdToDelete = $_GET['id'];

    // Use prepared statement to prevent SQL injection
    $sql = "DELETE FROM login WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
 
    // Bind parameters
    mysqli_stmt_bind_param($stmt, "i", $userIdToDelete);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Check for errors
    if (mysqli_stmt_errno($stmt)) {
        die('Could not delete user: ' . mysqli_stmt_error($stmt));
    }

    echo "<h2>User deleted successfully</h2>";

    // Close the statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    echo "Invalid request";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>delete</title>
</head>
<body>
    <button><a href="dashboard.php">Check Dashboard</a></button>
</body>
</html>
