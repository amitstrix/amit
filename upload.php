<?php
session_start();
include 'connect.php'; // Make sure to include your database connection file

if (!isset($_SESSION['email'])) {
    header('Location: login.html'); 
    exit();
}

$email = $_SESSION['email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle name update
    $newFirstName = $_POST['fname'];
    $newLastName = $_POST['lname'];
    
    $stmt = $conn->prepare("UPDATE logins SET fname=?, lname=? WHERE email=?");
    $stmt->bind_param("sss", $newFirstName, $newLastName, $email);

    if ($stmt->execute()) {
        // Update session information with the new name
        $_SESSION['fname'] = $newFirstName;
        $_SESSION['lname'] = $newLastName;
    } else {
        echo "Error updating name in the database: " . $stmt->error;
    }

    $stmt->close();

    // Handle image upload
    $uploadDir = 'uploads/';
    $uploadFile = $uploadDir . basename($_FILES['profileImage']['name']);

    if (move_uploaded_file($_FILES['profileImage']['tmp_name'], $uploadFile)) {
        // Update session information with the new image path
        $_SESSION['image'] = $uploadFile;

        // Update the database with the new image path
        $stmt = $conn->prepare("UPDATE logins SET image=? WHERE email=?");
        $stmt->bind_param("ss", $uploadFile, $email);

        if ($stmt->execute()) {
            // Redirect to the dashboard after successful update
            header('Location: dashboard.php');
            exit();
        } else {
            echo "Error updating image in the database: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error uploading image.";
    }
}

// Close the database connection
$conn->close();
?>
