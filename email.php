<?php
include 'header.php';
include 'connect.php';
session_start();
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
    $avatar = $targetFile;
}
// Display existing image if available
echo"<h1>Your Product<h1>";
if (isset($_SESSION['image']) && !empty($_SESSION['image']) && file_exists($_SESSION['image'])) {
    echo "<img src='" . $_SESSION['image'] . "' alt='User Image' width='180px' height='200px'>";
} else {
    echo "No image available.";
}
echo"<br>";
echo "Your Name :".$name = $_POST['name'];
echo"<br>";
echo "Your email :". $email = $_POST['email'];
echo"<br>";
echo"Your Product Name :". $product= $_POST['pname'];
echo"<br>";
echo"Your Product prize :". $product= $_POST['prize'];
echo "<br>";
echo "Your Message :".$messege = $_POST['messege'];
echo"<br>";
echo "Your Subject :".$subject = $_POST['subject'];
echo"<br>";
echo"Your Phone number :". $phone = $_POST['phone'];
echo"<br>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <button><a href="product.php">GO back product page</button>
</body>
</html>
