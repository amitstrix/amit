<?php
session_start();
include 'connect.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $sql = "SELECT id, fname, email, password, role, image FROM logins WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $count = $result->num_rows;

    if ($count == 1) {
        $hashedPassword = $row['password'];
        if (password_verify($password, $hashedPassword)) {
            $_SESSION['email'] = $email;
            $_SESSION['fname'] = $row['fname'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['image'] = $row['image'];
            $_SESSION['password'] = $row['password']; // Include password in session if needed

            if ($_SESSION['role'] === 'admin') {
                //yaha r check mhoga agar user na admin ka role select kiya ha to ussa dashboard ma records show hoga
                header("Location: dashboard.php");
                exit();
            } else {
                                header("Location: dashboard.php");
                exit();
            }
        } else {
            echo "<h3>Login failed. Invalid Password.</h3>";
        }
    } else {
        echo  "<h3>Login failed. Invalid Username and password</h3>";
        
    }
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <button><a href="login.html">Go Back</a></button>
</body>
</html>
