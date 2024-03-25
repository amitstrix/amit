<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'connect.php';

if (!isset($_SESSION['email'])) {
    header('Location: login.html');
    exit();
}

$email = $_SESSION['email'];
$password = $_SESSION['password'];

// Fetch user data from the database
$sql = "SELECT fname, lname, email, image FROM logins WHERE email = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $name = $row['fname'];
    $imagePath = $row['image'];
} else {
    // Handle database query error
    die('Error fetching user data: ' . mysqli_error($conn));
}

// Handle form submission to update first, last name, email, and profile picture
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newFname = $_POST['fname'];
    $newLname = $_POST['lname'];
    $newEmail = $_POST['email'];

    // Update the user's first, last name, and email in the database
    $updateSql = "UPDATE logins SET fname = ?, lname = ?, email = ? WHERE email = ?";
    $stmt = mysqli_prepare($conn, $updateSql);
    mysqli_stmt_bind_param($stmt, "ssss", $newFname, $newLname, $newEmail, $email);
    mysqli_stmt_execute($stmt);

    if (!$stmt) {
        // Handle update error
        die('Error updating user data: ' . mysqli_error($conn));
    }

    // Handle image upload
    if (!empty($_FILES['profileImage']['name'])) {
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($_FILES['profileImage']['name']);

        if (move_uploaded_file($_FILES['profileImage']['tmp_name'], $uploadFile)) {
            // Update the user's image path in the database
            $updateImageSql = "UPDATE logins SET image = ? WHERE email = ?";
            $stmt = mysqli_prepare($conn, $updateImageSql);
            mysqli_stmt_bind_param($stmt, "ss", $uploadFile, $newEmail);
            mysqli_stmt_execute($stmt);

            if (!$stmt) {
                // Handle update error
                die('Error updating image path in the database: ' . mysqli_error($conn));
            }

            // Update the session variable for the image
            $_SESSION['image'] = $uploadFile;
        } else {
            // Handle image upload error
            echo "Error uploading image.";
        }
    }

    // Update the email in the session as well
    $_SESSION['email'] = $newEmail;
    $_SESSION['fname'] = $newFname;
    $_SESSION['lname'] = $newLname;

    // Redirect to dashboard.php
    header('Location: dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body>
    <div class="container">
        <div class="profile-container">
            <?php
            if (!empty($imagePath)) {
                echo "<img src='$imagePath' alt='User Image' width='180px' height ='200px'>";
            } else {
                echo "No image available.";
            }
            ?>
            <h1>Welcome: <?php echo $name; ?></h1>
            <h2>Email: <?php echo $email; ?></h2>

            <form action="" method="post" enctype="multipart/form-data">
                <label for="profileImage">Change Profile Picture:</label>
                <input type="file" name="profileImage" id="profileImage">
                <label for="fname">Change First Name:</label>
                <input type="text" name="fname" id="fname" value="<?php echo isset($name) ? $name : ''; ?>">
                <label for="lname">Change Last Name:</label>
                <input type="text" name="lname" id="lname" value="<?php echo isset($row['lname']) ? $row['lname'] : ''; ?>">
                <label for="email">Change Email:</label>
                <input type="email" name="email" id="email" value="<?php echo $email; ?>">
                <input type="submit" value="Update">
            </form>
        </div>
    </div>
</body>
</html>
