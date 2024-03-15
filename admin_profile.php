<?php
session_start();
include 'header.php';
include "connect.php";
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header('Location: dashboard.php');
    exit();
}

$userId = isset($_GET['id']) ? $_GET['id'] : '';
$userData = [];

if ($_SERVER['REQUEST_METHOD'] !== 'POST' && !empty($userId)) {
    if (is_numeric($userId)) {
        $selectQuery = $conn->prepare("SELECT * FROM logins WHERE id=?");
    } else {
        $selectQuery = $conn->prepare("SELECT * FROM logins WHERE email=?");
    }

    $selectQuery->bind_param("s", $userId);
    $selectQuery->execute();
    $result = $selectQuery->get_result();

    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc();
    } else {
        echo "User not found.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newFname = $_POST['fname'];
    $newLname = $_POST['lname'];
    $newPassword = $_POST['password'];
    $newEmail = $_POST['email']; 

    // Handle image upload separately
    $image = '';

    if ($_FILES['profileImage']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($_FILES['profileImage']['name']);
        if (move_uploaded_file($_FILES['profileImage']['tmp_name'], $uploadFile)) {
            $image = $uploadFile;
        } else {
            echo "Error uploading image.";
        }
    }

    $passwordUpdate = !empty($newPassword) ? ", password='" . password_hash($newPassword, PASSWORD_DEFAULT) . "'" : "";

    $updateQuery = $conn->prepare("UPDATE logins SET image=?, fname=?, lname=?, email=? $passwordUpdate WHERE id=? OR email=?");
    $updateQuery->bind_param("ssssss", $image, $newFname, $newLname, $newEmail, $userId, $userId);

    if ($updateQuery->execute() === TRUE) {
        echo "User data updated successfully";
        header('Location: dashboard.php');
        exit();
    } else {
        echo "Error updating user data: " . $conn->error;
    }

    $updateQuery->close();
}

$conn->close();
?>

<!DOCTYPE html> 
<html lang="en">
<head>
    <title>Edit user data</title>
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body>
<div class="main">
    <div class="container">
        <div class="akshu">
            <h3>Edit User Data</h3>
            <?php
                // Check if an image path is available
                if (!empty($userData['image'])) {
                    echo "<img src='" . $userData['image'] . "' alt='User Image' width='180px' height='200px'>";
                } else {
                    echo "No image available.";
                }
            ?>
            <form method="post" action="" enctype="multipart/form-data">
                <label for="profileImage">Change Profile Picture:</label>
                <input type="file" name="profileImage" id="profileImage" accept="image/*"><br>
                <label for="fname">First Name:</label>
                <input type="text" id="fname" name="fname" value="<?php echo isset($userData['fname']) ? $userData['fname'] : ''; ?>" required><br>

                <label for="lname">Last Name:</label>
                <input type="text" id="lname" name="lname" value="<?php echo isset($userData['lname']) ? $userData['lname'] : ''; ?>" required><br>
               
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo isset($userData['email']) ? $userData['email'] : ''; ?>" required><br>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter new password"><br>

                <input type="submit" value="Update">
            </form>
        </div>
    </div>
</div>
</body>
</html>
