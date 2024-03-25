<?php
$servername = "localhost";
$username = "strix8ds_aksuuser";
$password = "Dare2devil1@";
$dbname = "strix8ds_aksu";

// Create connection 
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
