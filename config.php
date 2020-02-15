<?php

// Set Database Connection.
global $conn;
$conn = new mysqli("localhost","shopify_syte_ai","shopify_syte_ai@123","shopify_syte_ai");

// Check connection
if ($conn -> connect_errno) {
  echo "Failed to connect to MySQL: " . $conn -> connect_error;
  exit();
}


?>