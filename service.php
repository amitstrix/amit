<?php
session_start();
include 'header.php';
include "connect.php";
$name = $_POST['name']; 
$desc = $_POST['description'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($name) && !empty($desc)) {
            $avatar = 'uploads/' . uniqid() . '_' . $_FILES['image']['name'];
            if ($_FILES['image']['error'] == 0) {
                move_uploaded_file($_FILES['image']['tmp_name'], $avatar);
            }

            $sql = "INSERT INTO logintable (name, description, image)
                    VALUES ('$name', '$desc', '$avatar')";

            if ($conn->query($sql) === TRUE) {
                echo "Registered successfully";
                $_SESSION['name'] = $name;
                $_SESSION['description'] = $desc;
                $_SESSION['image'] = $avatar;

                header('location:table.php');
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
    } else {
        echo "Name and description are required fields.";
    }
} else {
    echo "Form not submitted.";
}

$conn->close();
?>
