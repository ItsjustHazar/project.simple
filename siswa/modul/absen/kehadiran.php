<?php
@session_start();
include_once '../config/db.php';  // Gunakan include_once atau require_once

if (!isset($_SESSION['siswa'])) {
?>
<script>
    alert('Maaf! Anda Belum Login!');
    window.location='../user.php';
</script>
<?php
    exit();
}

$id_siswa = $_SESSION['siswa'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tanggal = date('Y-m-d');
    $status_kehadiran = $_POST['status_kehadiran'];

    $query = "INSERT INTO tb_absen (id_siswa, tanggal, status_kehadiran) VALUES ('$id_siswa', '$tanggal', '$status_kehadiran')";
    mysqli_query($con, $query) or die(mysqli_error($con));

    echo "<script>alert('Data berhasil disimpan');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Presensi | Aplikasi Presensi</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="../assets/img/icon.ico" type="image/x-icon"/>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/atlantis.min.css">
    <style>
        * {
            font-family: Arial, sans-serif;
        }
        form {
            margin: 15px 5px;
            width: 500px;
            font-size: 16px;
        }
        form h1 {
            text-align: center;
        }
        form label {
            display: block;
            margin-bottom: 5px;
        }
        form input, form select {
            width: 100%;
            padding: 5px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }
        form button {
            background: #4CAF50;
            color: white;
            padding: 10px 15px;
            margin-top: 5px;
            border: none;
            cursor: pointer;
        }
        form button:hover {
            background: green;
        }
    </style>
</head>
<body>
    <div class="container">
        <form method="POST">
            <h1>Presensi Harian</h1>
            <label for="status_kehadiran">Status Kehadiran</label>
            <select name="status_kehadiran" required>
                <option value="Hadir">Hadir</option>
                <option value="Sakit">Sakit</option>
                <option value="Izin">Izin</option>
                <option value="Alpa">Alpa</option>
            </select>
            <button type="submit">Simpan Kehadiran</button>
        </form>
    </div>

    <!-- Core JS Files -->
    <script src="../assets/js/core/jquery.3.2.1.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script src="../assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>
    <script src="../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <script src="../assets/js/plugin/datatables/datatables.min.js"></script>
    <script src="../assets/js/plugin/sweetalert/sweetalert.min.js"></script>
    <script src="../assets/js/atlantis.min.js"></script>
    <script src="../assets/js/setting-demo.js"></script>
</body>
</html>
