<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// Decode incoming JSON data
$data = json_decode(file_get_contents('php://input'), true);

$id = $data['sid'];
$name = $data['sname'];
$email = $data['semail'];
$phone = $data['sphone'];
$address = $data['saddress'];

include "config.php"; // Include your database connection file
// Prepare the SQL statement for updating data
$sql = "UPDATE `dataes` SET 
        name = '$name', 
        email = '$email', 
        phone = '$phone', 
        address = '$address' 
        WHERE id = '$id'";

// Execute the query
if (mysqli_query($conn, $sql)) {
    echo json_encode(array('message' => 'Data updated successfully', 'status' => true));
} else {
    echo json_encode(array('message' => 'Data not updated: ' . mysqli_error($conn), 'status' => false));
}

?>
