<?php
include 'connect.php';
session_start();

if (!isset($_SESSION['email'])) {
    header('Location: login.html');
    exit();
}

$email = $_SESSION['email'];
$password = $_SESSION['password'];
$name = $_SESSION['fname'];
$imagePath = $_SESSION['image'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body>
<?php
    if (!empty($imagePath)) {
        echo "<img src='$imagePath' alt='User Image' width='180px' height ='200px'>";
    } else {
        echo "No image available.";
    }
?>
    <h1>Welcome: <?php echo $name; ?></h1>
    <h2>Email: <?php echo $email; ?></h2>

    <form action="upload.php" method="post" enctype="multipart/form-data">
        <label for="profileImage">Change Profile Picture:</label>
        <input type="file" name="profileImage" id="profileImage" accept="image/*">
        <label for="fname">Change First Name:</label>
        <input type="text" name="fname" id="fname">
        <label for="lname">Change Last Name:</label>
        <input type="text" name="lname" id="lname">
        <input type="submit" value="Upload">
    </form>

</body>
</html>
