<?php
session_start();
include 'header.php';
include 'connect.php';
// Check if a file was uploaded
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES['image']['name']);

    // Move uploaded file to target directory
    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
        $_SESSION['image'] = $targetFile; // Store image path in session
    } else {
        echo "Error uploading image.";
    }
}

// Display existing image if available
echo "<h1>Your Product</h1>";
if (isset($_SESSION['image']) && !empty($_SESSION['image']) && file_exists($_SESSION['image'])) {
    echo "<img src='" . $_SESSION['image'] . "' alt='Uploaded Image' width='180px' height='200px'>";
} else {
    echo "No image available.";
}


// Display other form data
echo "<br>";
echo "Your Name: " . $_POST['name'] . "<br>";
echo "Your email: " . $_POST['email'] . "<br>";
echo "Your Product Name: " . $_POST['product_name'] . "<br>";
echo "Your Product Price: " . $_POST['prize'] . "<br>";
echo "Your Message: " . $_POST['message'] . "<br>";
echo "Your Subject: " . $_POST['subject'] . "<br>";
echo "Your Phone number: " . $_POST['phone'] . "<br>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <button><a href="product.php">Go back to product page</a></button>
</body>
</html>