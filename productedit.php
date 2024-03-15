<?php
session_start();
include 'header.php';
include "connect.php";
// Redirect if user is not logged in as admin
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header('Location: dashboard.php');
    exit();
}

// Function to sanitize input
function sanitize_input($input) {
    return htmlspecialchars(trim($input));
}

// Get user ID from query parameters
$userId = isset($_GET['id']) ? $_GET['id'] : '';

// Fetch user data from database
$userData = [];
if (!empty($userId)) {
    $selectQuery = $conn->prepare("SELECT id, name, description, image FROM logintable WHERE id=?");
    $selectQuery->bind_param("i", $userId);
    $selectQuery->execute();
    $result = $selectQuery->get_result();

    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc();
    } else {
        echo "User not found.";
        exit();
    }

    $selectQuery->close();
}

// Initialize variables
$userName = '';
$userDescription = '';
$userImage = '';

// Populate variables if userData is not empty
if (!empty($userData)) {
    $userName = $userData['name'];
    $userDescription = $userData['description'];
    $userImage = $userData['image'];
}

// Check if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update user data
    $newName = sanitize_input($_POST['name']);
    $description = sanitize_input($_POST['description']);

    // Check if a new image is uploaded
    if ($_FILES['image']['size'] > 0) {
        $imageFileName = $_FILES['image']['name'];
        $imageTmpName = $_FILES['image']['tmp_name'];

        // Move the uploaded image to a directory
        $uploadDir = "uploads/";
        $targetFilePath = $uploadDir . basename($imageFileName);
        if (move_uploaded_file($imageTmpName, $targetFilePath)) {
            // Update user image if image uploaded successfully
            $updateQuery = $conn->prepare("UPDATE logintable SET name=?, description=?, image=? WHERE id=?");
            $updateQuery->bind_param("sssi", $newName, $description, $targetFilePath, $userId);

            if ($updateQuery->execute() === TRUE) {
                $updateQuery->close();
                header('Location: dashboard.php');
                exit();
            } else {
                echo "Error updating user data: " . $conn->error;
            }
        } else {
            echo "Error uploading image.";
        }
    } else {
        // If no new image uploaded, update other user data
        $updateQuery = $conn->prepare("UPDATE logintable SET name=?, description=? WHERE id=?");
        $updateQuery->bind_param("ssi", $newName, $description, $userId);

        if ($updateQuery->execute() === TRUE) {
            $updateQuery->close();
            header('Location: dashboard.php');
            exit();
        } else {
            echo "Error updating user data: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html> 
<html lang="en">
<head>
    <title>Edit User</title>
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body>
    <div class="main">
        <div class="container">
            <div class="akshu">
                <h3>Edit User</h3>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $userId); ?>" enctype="multipart/form-data">
                    <!-- Display user image -->
                    <?php if (!empty($userImage)): ?>
                        <img src="<?php echo $userImage; ?>" alt="User Image" width="180px" height="200px">
                    <?php else: ?>
                        <p>No image available.</p>
                    <?php endif; ?>

                    <input type="file" name="image">
                    <input type="hidden" name="id" value="<?php echo $userId; ?>">
                    <label for="name">User Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($userName); ?>" required><br>

                    <label for="description">Description:</label>
                    <input type="text" id="description" name="description" value="<?php echo htmlspecialchars($userDescription); ?>" required><br>

                    <input type="submit" value="Update">
                </form>
            </div>
        </div>
    </div>
</body>
</html>
