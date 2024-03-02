<?php
include "connect.php";

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$role = $_POST['role'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Check if email already exists
$checkEmailQuery = "SELECT * FROM logins WHERE email = '$email'";
$result = $conn->query($checkEmailQuery);

if ($result->num_rows > 0) {
    echo "Error: Email already registered. Please choose a different email.";
} else {
    $avatar = 'image';
    if ($_FILES['image']['error'] == 0) {
        $avatar = 'uploads/' . uniqid() . '_' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], $avatar);
    }

    $sql = "INSERT INTO logins (fname, lname, email, password, image, role)
            VALUES ('$fname', '$lname', '$email', '$password', '$avatar', '$role')";

    if ($conn->query($sql) === TRUE) {
        echo "Registered successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
</head>
<body>
    <h1>Please login</h1>
    <button><a href="login.html">Login</a></button>
</body>
</html>
