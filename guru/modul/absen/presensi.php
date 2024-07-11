<?php
include 'modul/koneksi.php';
$id_kelas = 1; // Contoh ID kelas
$id_mapel = 1; // Contoh ID mata pelajaran
$pertemuan_ke = 1; // Contoh pertemuan ke
$tanggal = date('Y-m-d');

$siswa = mysqli_query($koneksi, "SELECT * FROM tb_siswa WHERE id_kelas = $id_kelas");

if (isset($_POST['submit_presensi'])) {
    foreach ($_POST['presensi'] as $id_siswa => $status) {
        mysqli_query($koneksi, "INSERT INTO tb_presensi (id_kelas, id_mapel, id_siswa, tanggal, status, pertemuan_ke) VALUES ($id_kelas, $id_mapel, $id_siswa, '$tanggal', '$status', $pertemuan_ke)");
    }
    echo "Presensi berhasil disimpan.";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Presensi</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h3>Presensi untuk Kelas <?= $id_kelas ?>, Mata Pelajaran <?= $id_mapel ?></h3>
    <form method="POST">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Siswa</th>
                    <th>Nama Siswa</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($siswa)) { ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['nama'] ?></td>
                        <td>
                            <select name="presensi[<?= $row['id'] ?>]" class="form-control">
                                <option value="hadir">Hadir</option>
                                <option value="tidak hadir">Tidak Hadir</option>
                                <option value="terlambat">Terlambat</option>
                                <option value="izin">Izin</option>
                            </select>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <button type="submit" name="submit_presensi" class="btn btn-primary">Simpan Presensi</button>
    </form>
</div>
</body>
</html>
