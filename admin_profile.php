<?php
session_start();

// yaha check karna ha agar user na admin role select kiya ha
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header('Location: dashboard.php');
    exit();
}

include "connect.php";

// Fetch user data based on ID or email
$userId = isset($_GET['id']) ? $_GET['id'] : '';
$userData = [];

if ($_SERVER['REQUEST_METHOD'] !== 'POST' && !empty($userId)) {
    // Check if the provided ID is numeric
    if (is_numeric($userId)) {
        $selectQuery = "SELECT * FROM logins WHERE id='$userId'";
    } else {
        $selectQuery = "SELECT * FROM logins WHERE email='$userId'";
    }

    $result = $conn->query($selectQuery);

    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc();
    } else {
        echo "User not found.";
    }
}

// Check if the form is submitted for updating user data // yaha pr check karna ha ki user ka  data update hoga
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the image upload
    $uploadDir = 'uploads/';
    $uploadFile = $uploadDir . basename($_FILES['profileImage']['name']);

    if (move_uploaded_file($_FILES['profileImage']['tmp_name'], $uploadFile)) {
        // Update the user's data with the new image path
        $updateImageQuery = "UPDATE logins SET image='$uploadFile' WHERE id='$userId' OR email='$userId'";
        if ($conn->query($updateImageQuery) !== TRUE) {
            echo "Error updating image path in the database: " . $conn->error;
        }

        // Update the user's other data (fname, lname, password)
        $newFname = $_POST['fname'];
        $newLname = $_POST['lname'];
        $newPassword = $_POST['password'];

        // Check if the password field is not empty before updating
        $passwordUpdate = !empty($newPassword) ? ", password='" . password_hash($newPassword, PASSWORD_DEFAULT) . "'" : "";

        // Update user data in the database based on ID or email
        $updateQuery = "UPDATE logins SET fname='$newFname', lname='$newLname' $passwordUpdate WHERE id='$userId' OR email='$userId'";

        if ($conn->query($updateQuery) === TRUE) {
            echo "User data updated successfully";
            header('Location: dashboard.php');
            exit();  // Make sure to exit after the header to prevent further execution
        } else {
            echo "Error updating user data: " . $conn->error;
        }
    } else {
        echo "Error uploading image.";
    }
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
                <input type="file" name="profileImage" id="profileImage" accept="image/*">
                <label for="fname">First Name:</label>
                <input type="text" id="fname" name="fname" value="<?php echo isset($userData['fname']) ? $userData['fname'] : ''; ?>" required><br>

                <label for="lname">Last Name:</label>
                <input type="text" id="lname" name="lname" value="<?php echo isset($userData['lname']) ? $userData['lname'] : ''; ?>" required><br>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter new password"><br>

                <input type="submit" value="Update">
            </form>
        </div>
    </div>
</div>

</body>
</html>
