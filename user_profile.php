<?php
include 'connect.php';
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'email') {
   // header('Location: login.html');
    exit();
}

// Dislay user information
$email = $_SESSION['email'];
$name = $_SESSION['name']; 
$imagePath = $_SESSION['image_path'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
</head>
<body>

    <h1>Welcome, <?php echo $name; ?>!</h1>
    <p>Email: <?php echo $email; ?></p>

    <?php
    if (!empty($imagePath)) {
        echo "<img src='$imagePath' alt='User Image' width='100'>";
    } else {
        echo "No image available.";
    }
    ?>


</body>
</html>
