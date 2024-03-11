<?php
include 'connect.php';
session_start();

if (!isset($_SESSION['email'])) {
    header('Location: login.html');
    exit();
}

$email = $_SESSION['email'];
$password = $_SESSION['password'];

// Fetch user data from the database
$sql = "SELECT fname, lname, image FROM logins WHERE email = '$email'";
$result = mysqli_query($conn, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $name = $row['fname'];
    $imagePath = $row['image'];
} else {
    // Handle database query error
    die('Error fetching user data: ' . mysqli_error($conn));
}

// Handle form submission to update first and last name
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newFname = $_POST['fname'];
    $newLname = $_POST['lname'];

    // Update the user's first and last name in the database
    $updateSql = "UPDATE logins SET fname = '$newFname', lname = '$newLname' WHERE email = '$email'";
    $updateResult = mysqli_query($conn, $updateSql);

    if (!$updateResult) {
        // Handle update error
        die('Error updating user data: ' . mysqli_error($conn));
    }

    // Fetch updated data
    $sql = "SELECT fname, lname, image FROM logins WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['fname'];
    } else {
        // Handle database query error
        die('Error fetching updated user data: ' . mysqli_error($conn));
    }
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
<?php
if (!empty($imagePath)) {
    echo "<img src='$imagePath' alt='User Image' width='180px' height ='200px'>";
} else {
    echo "No image available.";
}
?>
<h1>Welcome: <?php echo $name; ?></h1>
<h2>Email: <?php echo $email; ?></h2>

<form action="upload.php" method="post" enctype="multipart/form-data">
    <label for="profileImage">Change Profile Picture:</label>
    <input type="file" name="profileImage" id="profileImage" accept="image/*">
    <label for="fname">Change First Name:</label>
    <input type="text" name="fname" id="fname" value="<?php echo $name; ?>">
    <label for="lname">Change Last Name:</label>
    <input type="text" name="lname" id="lname" value="<?php echo $row['lname']; ?>">
    <input type="submit" value="Upload">
</form>

</body>
</html>
