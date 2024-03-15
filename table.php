<?php
session_start();
include 'header.php';
include 'connect.php';
$sql = "SELECT id, name, description, image FROM logintable WHERE (name, description, image, id) IN (SELECT name, description, image, MAX(id) FROM logintable GROUP BY name, description, image) ORDER BY id ASC";
$result = $conn->query($sql);
?>
 
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" type="text/css" href="stylesheet.css" />
</head>

<body>
    <section>
        <h1>Your Form Data</h1>
        <table>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Description</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
            <?php
            while ($rows = $result->fetch_assoc()) {
            ?> 
                <tr>
                    <td><?php echo $rows['id']; ?></td>
                    <td><?php echo $rows['name']; ?></td>
                    <td><?php echo $rows['description']; ?></td>
                    <td><img src="<?php echo $rows['image']; ?>" alt="User Image" width="50"></td>
                    <td>
                        <a href='admin.php?id=<?php echo $rows['id']; ?>'>Edit</a>
                        <a href='delete.php?id=<?php echo $rows['id']; ?>'>Delete</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </table>
    </section>
</body>

</html>

<?php
$conn->close();
?>
