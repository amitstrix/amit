<?php
session_start();
include 'connect.php';
$sql = "SELECT  name, description, image FROM logintable WHERE (name, description, image) IN (SELECT name, description, image FROM logintable GROUP BY name, description, image) ORDER BY name ASC";
$result = $conn->query($sql)
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="main">
        <div class="container">
            <div class="services">
            <tr>
            <th>Image</th>
                <th>Title</th>
                <th>Description</th>
            </tr>
            <?php
            while ($rows = $result->fetch_assoc()) {
            ?> 
<tr>
                    <td><img src="<?php echo $rows['image']; ?>" alt="User Image" width="50"></td>
                    <td><?php echo $rows['name']; ?></td>
                    <td><?php echo $rows['description']; ?></td>
                    <td>
            <?php
            }
            ?>
            </div>
        </div>
    </div>
</body>
</html>