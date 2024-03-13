<?php
session_start();
include 'connect.php';

if (isset($_GET['id'])) {
    $userIdToDelete = $_GET['id'];

//yaha id delete kara
    $sql = "DELETE FROM logintable WHERE id = ?";
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
} else {
    echo "Invalid request";
}

$sql = "SELECT id, name, description, image FROM logintable WHERE (name, description, image, id) IN (SELECT name, description, image, MAX(id) FROM logintable GROUP BY name, description, image) ORDER BY id ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>delete</title>
</head>
<body>
    <button><a href="table.php">Check Table</a></button>
</body>
</html>
