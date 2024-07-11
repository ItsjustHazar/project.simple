<?php
@session_start();
include '../config/db.php';

// Check if the user is logged in
if (!isset($_SESSION['kepsek'])) {
    header('Location: ../user.php');
    exit;
}

// Get the id_login from session
$id_login = @$_SESSION['kepsek'];

// Check connection to the database
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch data for the logged-in user
$sql = mysqli_query($con, "SELECT * FROM tb_kepsek WHERE id_kepsek = '$id_login'");

if (!$sql) {
    // Log the error and show a user-friendly message
    error_log("Query Error: " . mysqli_error($con));
    die("Error: Unable to fetch data. Please try again later.");
}

$data = mysqli_fetch_array($sql);
?>

<h3> Laporan Presensi Siswa </h3>

<table border="1">
    <tr>
        <th>id_presensi</th>
        <th>id_mengajar</th>            
        <th>id_siswa</th>
        <th>tgl_absen</th>
        <th>ket</th>               
        <th>pertemuan_ke</th>
        <th colspan="2">Aksi</th>
    </tr>

    <?php
    include "koneksi.php";

    $no=1;
    $ambildata = mysqli_query($koneksi,"select * _logabsensi");
    while($tampil = mysqli_fetch_array($ambildata)){
        echo "
        <tr>
            <td>$no</td>
            <td>$tampil[id_mengajar]</td>
            <td>$tampil[id_siswa]</td>
            <td>$tampil[tgl_absen]</td>
            <td>$tampil[ket]</td>
            <td>$tampil[pertemuan_ke]</td>
            <td><a href='?kode=$tampil[_logabsensi]'> Hapus </a></td>
            <td><a href='modul.php?kode=$tampil[_logabsensi]'> Ubah </a></td>
        <tr>";
        $no++;
    }
    ?>
    </table>

    <?php
    include "koneksi.php";

    if(isset($_GET['kode'])){
    mysqli_query($koneksi,"delete  from barang where _logabsensi='$_GET[kode]'");
    
    echo "Data berhasil dihapus";
    echo "<meta http-equiv=refresh content=2;URL='modul.php'>";

    }
    ?>