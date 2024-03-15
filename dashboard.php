<?php
include 'connect.php';
session_start();
$imagePath = $_SESSION['image'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>dashboard</title>
</head>
<body>
<header class="p-3 mb-3 border-bottom">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
    <li><a href="#hero" class="nav-link px-2 link-secondary">Home</a></li>
    <li><a href="#aboutus" class="nav-link px-2 link-body-emphasis">About</a></li>
    <li><a href="userservice.php" class="nav-link px-2 link-body-emphasis">Services</a></li>
    <li><a href="#some" class="nav-link px-2 link-body-emphasis">Services Table</a></li>
    <li><a href="#table" class="nav-link px-2 link-body-emphasis">Records</a></li>
    <li><a href="product.php" class="nav-link px-2 link-body-emphasis">Product</a></li>
    <?php
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        echo "<li><a href='service.html' class='nav-link px-2 link-body-emphasis'>Add Services</a></li>";
    }
    ?>
</ul>

        <div class="dropdown text-end">
          <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="<?php echo isset($_SESSION['image']) ? $_SESSION['image'] : 'default_image.jpg'; ?>" alt="User Image" width="50px" height="50px" style="border-radius: 100%;">
          </a>
          <ul class="dropdown-menu text-small">
            <li><a class="dropdown-item" href="edit.php">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
            
          </ul>
        </div>
      </div>
  <div id="hero" class="container col-xxl-8 px-4 py-5">
    <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
      <div class="col-10 col-sm-8 col-lg-6">
        <img src="https://getbootstrap.com/docs/5.3/examples/heroes/bootstrap-themes.png" class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes" width="700" height="500" loading="lazy">
      </div>
      <div class="col-lg-6">
        <h1 class="display-5 fw-bold text-body-emphasis lh-1 mb-3">Responsive left-aligned hero with image</h1>
        <p class="lead">Quickly design and customize responsive mobile-first sites with Bootstrap, the world's most popular front-end open source toolkit, featuring Sass variables and mixins, responsive grid system, extensive prebuilt components, and powerful JavaScript plugins.</p>
        <div class="d-grid gap-2 d-md-flex justify-content-md-start">
          <button type="button" class="btn btn-primary btn-lg px-4 me-md-2">Primary</button>
          <button type="button" class="btn btn-outline-secondary btn-lg px-4">Default</button>
        </div>
      </div>
    </div>
  </div>
  <div class="container px-4 py-5" id="aboutus">
    <h2 class="pb-2 border-bottom">About </h2>
    <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
      <div class="col d-flex align-items-start">
        <div class="icon-square text-body-emphasis bg-body-secondary d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
          <svg class="bi" width="1em" height="1em"><use xlink:href="#toggles2"></use></svg>
        </div>
        <div>
          <h3 class="fs-2 text-body-emphasis">Featured title</h3>
          <p>Paragraph of text beneath the heading to explain the heading. We'll add onto it with another sentence and probably just keep going until we run out of words.</p>
          <a href="#" class="btn btn-primary">
            Primary button
          </a>
        </div>
      </div>
      <div class="col d-flex align-items-start">
        <div class="icon-square text-body-emphasis bg-body-secondary d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
          <svg class="bi" width="1em" height="1em"><use xlink:href="#cpu-fill"></use></svg>
        </div>
        <div>
          <h3 class="fs-2 text-body-emphasis">Featured title</h3>
          <p>Paragraph of text beneath the heading to explain the heading. We'll add onto it with another sentence and probably just keep going until we run out of words.</p>
          <a href="#" class="btn btn-primary">
            Primary button
          </a>
        </div>
      </div>
      <div class="col d-flex align-items-start">
        <div class="icon-square text-body-emphasis bg-body-secondary d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
          <svg class="bi" width="1em" height="1em"><use xlink:href="#tools"></use></svg>
        </div>
        <div>
          <h3 class="fs-2 text-body-emphasis">Featured title</h3>
          <p>Paragraph of text beneath the heading to explain the heading. We'll add onto it with another sentence and probably just keep going until we run out of words.</p>
          <a href="#" class="btn btn-primary">
            Primary button
          </a>
        </div>
       
 
   

  </div>
      </div>
    </div>
    <div class="container marketing" id="services">

    <!-- Three columns of text below the carousel -->
    <!-----idhar services ka table ha --->
    <?php
include "connect.php";

$sql = "SELECT id, name, description, image FROM logintable WHERE (name, description, image, id) IN (SELECT name, description, image, MAX(id) FROM logintable GROUP BY name, description, image) ORDER BY id ASC";
$result = $conn->query($sql);
?>
    <div class="main" id="some">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>
                          <h1>Services Data</h1>
                            <tr>
                            <th>Id</th>
                                <th>Image</th>
                                <th>Services name</th>
                                <th>Description</th>
                                <th>View</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($rows = $result->fetch_assoc()) { ?>
                                <tr>
                                <td><h2><?php echo $rows['id']; ?></h2></td>
                                    <td><img src="<?php echo $rows['image']; ?>" alt="User Image" width="100" height="100"></td>
                                    <td><h2><?php echo $rows['name']; ?></h2></td>
                                    <td><p><?php echo $rows['description']; ?></p></td>
                                    <td><a class="btn btn-primary" href='view.php?id=<?php echo $rows['id']; ?>&name=<?php echo urlencode($rows['name']); ?>&description=<?php echo urlencode($rows['description']); ?>&image=<?php echo urlencode($rows['image']); ?>'>View</a></td>
                                    <td><a class="btn btn-primary" href='editservices.php?id=<?php echo $rows['id']; ?>&name=<?php echo urlencode($rows['name']); ?>&description=<?php echo urlencode($rows['description']); ?>&image=<?php echo urlencode($rows['image']); ?>'>Edit</a></td>
                                    <td><a class="btn btn-primary" href='deleteservices.php?id=<?php echo $rows['id']; ?>&name=<?php echo urlencode($rows['name']); ?>&description=<?php echo urlencode($rows['description']); ?>&image=<?php echo urlencode($rows['image']); ?>'>delete</a></td>
                                    
                                  </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



    <!---idhar product ka table ha--->
    <?php
include 'connect.php';
$sql = "SELECT id, name, description, image FROM logintable WHERE (name, description, image, id) IN (SELECT name, description, image, MAX(id) FROM logintable GROUP BY name, description, image) ORDER BY id ASC";
$result = $conn->query($sql)
?>

<table class="table   style=width: 100%; table-bordered">

<h1>Product Data</h1>
    <thead>
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Product Name</th>
            <th>Description</th>
            <th>View</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($rows = $result->fetch_assoc()) {
        ?> 
        <tr>
            <td><?php echo $rows['id']; ?></td>
            <td><img src="<?php echo $rows['image']; ?>" alt="User Image" width="100" height="100"></td>
            <td><?php echo $rows['name']; ?></td>
            <td><?php echo $rows['description']; ?></td>
            <td><a class="btn btn-primary" href='productview.php?id=<?php echo $rows['id']; ?>'>View</a></td>
            <td><a class="btn btn-primary" href='productedit.php?id=<?php echo $rows['id']; ?>&name=<?php echo urlencode($rows['name']); ?>&description=<?php echo urlencode($rows['description']); ?>&image=<?php echo urlencode($rows['image']); ?>'>Edit</a></td>
            <td><a class="btn btn-primary" href='productdelete.php?id=<?php echo $rows['id']; ?>&name=<?php echo urlencode($rows['name']); ?>&description=<?php echo urlencode($rows['description']); ?>&image=<?php echo urlencode($rows['image']); ?>'>Delete</a></td>
        </tr>
        <?php
        }
        ?>
    </tbody>
      </table>




<!-----idhar database table ha--->

    <?php
// idhar check karna user  logged in ho gya ha 
if (!isset($_SESSION['email'])) {
    header("Location: login.html"); //idhar login.html location deni ha
    exit();
}

// idhar check hona ya agar user na admin role select lkiya ha to ussa table show hona chaiya
if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    // yaha database ka sara record fetch karna ha
    $userRecordsQuery = "SELECT id, fname, email FROM logins";
    $userRecordsResult = $conn->query($userRecordsQuery);

    echo "<div id='table' class='table'>
            <h2>Records</h2>
            <table class='table'>
                <thead>
                    <tr>
                        <th scope='col'>ID</th>
                        <th scope='col'>Name</th>
                        <th scope='col'>Email</th>
                        <th scope='col'>Actions</th>
                    </tr>
                </thead>";

    if ($userRecordsResult->num_rows > 0) {
        while ($row = $userRecordsResult->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['fname']}</td>
                    <td>{$row['email']}</td>
                    <td>
                        <a href='admin_profile.php?id={$row['id']}'>Edit</a>
                        <a href='delete_user.php?id={$row['id']}' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                    </td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No records found.</td></tr>";
    }

    echo "</table></div>";
} else {
    echo "You don't have permission to view this page.";
}

$conn->close();
?>

  </div>
  <div class="container">
  <footer class="row row-cols-1 row-cols-sm-2 row-cols-md-5 py-5 my-5 border-top">
    <div class="col mb-3">
      <a href="/" class="d-flex align-items-center mb-3 link-body-emphasis text-decoration-none">
        <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
      </a>
      <p class="text-body-secondary">© 2024</p>
    </div>

    <div class="col mb-3">

    </div>

    <div class="col mb-3">
      <h5>Section</h5>
      <ul class="nav flex-column">
        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Home</a></li>
        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Features</a></li>
        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Pricing</a></li>
        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">FAQs</a></li>
        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">About</a></li>
      </ul>
    </div>
    <div class="col mb-3">
      <h5>Section</h5>
      <ul class="nav flex-column">
        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Home</a></li>
        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Features</a></li>
        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Pricing</a></li>
        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">FAQs</a></li>
        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">About</a></li>
      </ul>
    </div>

    <div class="col mb-3">
      <h5>Section</h5>
      <ul class="nav flex-column">
        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Home</a></li>
        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Features</a></li>
        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Pricing</a></li>
        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">FAQs</a></li>
        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">About</a></li>
      </ul>
    </div>
  </footer>
</div>
  </div>
    </div>
  </header>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>