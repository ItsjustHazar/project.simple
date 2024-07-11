<?php
if (!isset($_SESSION['siswa'])) {
    echo "<script>window.location='../user.php';</script>";
}

$id_siswa = $_SESSION['siswa'];
$query = mysqli_query($con, "SELECT * FROM tb_absen WHERE id_siswa = '$id_siswa'") or die(mysqli_error($con));
?>

<h2>Data Kehadiran</h2>
<table class="table table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Status Kehadiran</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        while ($row = mysqli_fetch_array($query)) {
            echo "<tr>";
            echo "<td>" . $no++ . "</td>";
            echo "<td>" . $row['tanggal'] . "</td>";
            echo "<td>" . $row['status_kehadiran'] . "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
