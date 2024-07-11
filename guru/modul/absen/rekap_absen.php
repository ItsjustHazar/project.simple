<?php
include 'modul/koneksi.php';

$id_guru = 1; // Contoh ID guru

$rekap = mysqli_query($koneksi, "SELECT * FROM tb_presensi INNER JOIN tb_siswa ON tb_presensi.id_siswa = tb_siswa.id WHERE tb_presensi.id_guru = $id_guru");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Absensi</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h3>Rekap Absensi</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Presensi</th>
                <th>ID Kelas</th>
                <th>ID Mapel</th>
                <th>ID Siswa</th>
                <th>Nama Siswa</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Pertemuan Ke</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($rekap)) { ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['id_kelas'] ?></td>
                    <td><?= $row['id_mapel'] ?></td>
                    <td><?= $row['id_siswa'] ?></td>
                    <td><?= $row['nama'] ?></td>
                    <td><?= $row['tanggal'] ?></td>
                    <td><?= $row['status'] ?></td>
                    <td><?= $row['pertemuan_ke'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>
