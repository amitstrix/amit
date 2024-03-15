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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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

<h1><?php echo $_SESSION['name']; ?></h1>
<br>
<p><?php echo $_SESSION['description']; ?></p>
<?php 
$prize = rand(500, 1500);

echo "Prize $" . $prize . "<br><br>";
?>
                    <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Buy Now
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Send Messege</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
<form action="email.php" method="POST" enctype="multipart/form-data">
    <label>Name</label>
<input type="name" name="name"><br> 
<label>Email</label>
<input type="email" name="email"><br>
<label>Product Name</label>
<input type="pname" name="pname" value="<?php echo $_SESSION['name']; ?>">
<label>Prize</label>
<input type="text" name="prize" value="<?php echo "$".$prize; ?>">
<label>Messege</label>
<textarea name="messege"></textarea><br>
<label>Subject</label>
<textarea name="subject"></textarea><br>
<label>Phone no.</label>
<input type="tel" name="phone"><br>
<input type="submit" value="submit" name="submit">
</form>
    </div>
   
    </div>
  </div>
</div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>
