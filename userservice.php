<?php
session_start();
include 'header.php';
include 'connect.php';
$sql = "SELECT id, name, description, image FROM logintable WHERE (name, description, image, id) IN (SELECT name, description, image, MAX(id) FROM logintable GROUP BY name, description, image) ORDER BY id ASC";
$result = $conn->query($sql)
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="main">
        <div class="container">
            <div class="row">
            <?php
            while ($rows = $result->fetch_assoc()) {
            ?> 
<div class="col-md-4 col-sm-12">
                   
                    <img src="<?php echo $rows['image']; ?>" alt="User Image" width="100" height="100">
                    <h2><?php echo $rows['name']; ?></h2>
                    <p><?php echo $rows['description']; ?></p>
                    <a class="btn btn-primary" href='view.php?id=<?php echo $rows['id']; ?>'>View</a>

                   
</div>
            <?php
            }
            ?>
            
        </div>
    </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>