<?php
include "connect.php";
    // rest of your code...
   
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
    $username = $_POST['email'];
    $role = $_POST['role'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Handle file upload for avatar
    $avatar = 'image';
    if ($_FILES['image']['error'] == 0) {
        $avatar = 'uploads/' . uniqid() . '_' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], $avatar);
    }

    $sql = "INSERT INTO logins (fname, lname, email,password,image,role)
    VALUES ('$fname', '$lname', '$username','$password','$avatar','$role')";
    
    if ($conn->query($sql) === TRUE) {
      echo "Registed  successfully";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();

      ?>
      <!DOCTYPE html>
      <html lang="en">
      <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
      </head>
      <body>
        <h1>Please login</h1>
        <button> <a href="login.html">Login</button></a>
      </body>
      </html>