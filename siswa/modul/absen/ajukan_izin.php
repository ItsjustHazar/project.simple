<?php
@session_start();
include '../config/db.php';

if (!isset($_SESSION['siswa'])) {
    echo "<script>
            alert('Maaf! Anda Belum Login!!');
            window.location='../user.php';
          </script>";
    exit();
}

$id_login = $_SESSION['siswa'];

if (isset($_POST['ajukan'])) {
    $tgl_izin = $_POST['tgl_izin'];
    $alasan = $_POST['alasan'];
    $pj = $_POST['pj'];
    $nama_pj = $_POST['nama_pj'];
    $hp_pj = $_POST['hp_pj'];
    $file_bukti = $_FILES['file_bukti']['name'];
    $tmp_bukti = $_FILES['file_bukti']['tmp_name'];
    $path = "../assets/img/bukti_izin/";

    // Pindahkan file bukti ke folder bukti_izin
    if (move_uploaded_file($tmp_bukti, $path.$file_bukti)) {
        $query = "INSERT INTO tb_izin (id_siswa, tgl_izin, alasan_izin, pj, nama_pj, hp_pj, file_bukti, ket_izin, persetujuan)
                  VALUES ('$id_login', '$tgl_izin', '$alasan', '$pj', '$nama_pj', '$hp_pj', '$file_bukti', '0', 'Menunggu')";
        $result = mysqli_query($con, $query);

        if ($result) {
            echo "<script>
                    alert('Pengajuan izin berhasil!');
                    window.location='index.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Pengajuan izin gagal!'.mysqli_error($con));
                  </script>";
        }
    } else {
        echo "<script>
                alert('Gagal mengupload bukti izin!');
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ajukan Izin</title>
    <!-- Include necessary CSS and JS files here -->
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="tgl_izin">Tanggal Izin</label>
        <input type="date" name="tgl_izin" required><br>
        
        <label for="alasan">Alasan</label>
        <textarea name="alasan" required></textarea><br>
        
        <label for="pj">Penanggung Jawab</label>
        <input type="text" name="pj" required><br>
        
        <label for="nama_pj">Nama Penanggung Jawab</label>
        <input type="text" name="nama_pj" required><br>
        
        <label for="hp_pj">Kontak Penanggung Jawab</label>
        <input type="text" name="hp_pj" required><br>
        
        <label for="file_bukti">Bukti Izin</label>
        <input type="file" name="file_bukti" required><br>
        
        <button type="submit" name="ajukan">Ajukan Izin</button>
    </form>
</body>
</html>
