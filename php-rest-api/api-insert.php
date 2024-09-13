<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// Decode incoming JSON data
$data = json_decode(file_get_contents('php://input'), true);
$name = $data['sname'];
$email = $data['semail'];
$phone = $data['sphone'];
$address = $data['saddress'];

include "config.php"; // Include your database connection file

// Prepare the SQL statement for inserting data
$sql = "INSERT INTO `dataes` (name, email, phone,address) VALUES ('{$name}', '{$email}', '{$phone}','{$address}')";

// Execute the query
if (mysqli_query($conn, $sql)) {
    echo json_encode(array('message' => 'Order inserted successfully', 'status' => true));
} else {
    echo json_encode(array('message' => 'Error inserting order: ' . mysqli_error($conn), 'status' => false));
}

?>
