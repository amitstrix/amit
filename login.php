<?php 
include 'connect.php';

$email = $_POST['email'];  
$password = $_POST['password'];  

$sql = "SELECT * FROM logins WHERE email = '$email'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$count = mysqli_num_rows($result);

if ($count == 1) {
    $hashedPassword = $row['password'];

    if (password_verify($password, $hashedPassword)) {
        echo "Login successfully.";  
    } else {
        echo "Login failed. Invalid username or password.";
    }
} else {
    echo "Login failed. Invalid username or password.";  
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Your Data</h2>  
    <button><a href="user_profile.php">your data</a></button>
</body>
</html>