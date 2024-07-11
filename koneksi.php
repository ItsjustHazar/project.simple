<?php
$con = mysqli_connect("localhost", "u902956780_db_imas", "Rast@210", "u902956780_db_imas");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Test connection
echo "Connected successfully";
?>
