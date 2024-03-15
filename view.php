<?php
session_start();
include 'header.php';
include "connect.php";
//yahs isset karka id ko get karna ha
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $_SESSION['id'] = $_GET['id'];

    // yaha user data from the database
    $sql = "SELECT * FROM logintable WHERE id = ?";
    $stmt = $conn->prepare($sql);
 
    if ($stmt) {
        $stmt->bind_param("i", $_SESSION['id']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $_SESSION['name'] = $row['name'];
            $_SESSION['description'] = $row['description'];
            $_SESSION['image'] = $row['image'];
        } else {

            header('Location: error.php');
            exit;
        }

        $stmt->close();
    } else {

        echo "Error in preparing the SQL statement";
        exit;
    }
} else {

    header('Location: error.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $desc = htmlspecialchars($_POST['description']);
    $avatar = $_SESSION['image']; // yaha image ko session ka sath check kara

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
        $avatar = $targetFile;
    }

    $sql = "UPDATE logintable SET name = ?, description = ?, image = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssi", $name, $desc, $avatar, $_SESSION['id']);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Updated successfully";

            header('Location: table.php');
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error in preparing the SQL statement";
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
                <?php
                // Display existing image if available
                if (isset($_SESSION['image']) && !empty($_SESSION['image']) && file_exists($_SESSION['image'])) {
                    echo "<img src='" . $_SESSION['image'] . "' alt='User Image' width='180px' height='200px'>";
                } else {
                    echo "No image available.";
                }
                ?>

                   
                    <h1 ><?php echo $_SESSION['name']; ?></h1>
                    <br>
                    <p><?php echo $_SESSION['description']; ?></p>
                   
                    
            </div>
        </div>
    </div>
</body>
</html>
