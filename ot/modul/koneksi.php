<?php
$host = "localhost";
$user = "u902956780_db_imas";
$password = "Rast@210";
$database = "u902956780_db_imas";

$koneksi = mysqli_connect($host, $user, $password, $database);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
