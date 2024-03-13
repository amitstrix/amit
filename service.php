<?php
session_start();
include "connect.php";

$name = $_POST['name']; 
$desc = $_POST['description'];

if ($result->num_rows > 0) {
} else {
    $avatar = 'uploads/' . uniqid() . '_' . $_FILES['image']['name'];
    if ($_FILES['image']['error'] == 0) {
        move_uploaded_file($_FILES['image']['tmp_name'], $avatar);
    }

    $sql = "INSERT INTO logintable (id, name, description, image)
            VALUES ('$name', '$desc', '$avatar')";

    if ($conn->query($sql) === TRUE) {
        echo "Registered successfully";
        $_SESSION['id'] = $id;
        $_SESSION['name'] = $name;
        $_SESSION['description'] = $desc;
        $_SESSION['image'] = $avatar;

        header('location:table.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
