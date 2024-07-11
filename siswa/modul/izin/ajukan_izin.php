FORM PENGAJUAN IZIN
<?php
@session_start();
include '../config/db.php';

if (!isset($_SESSION['siswa'])) {
?> 
    <script>
        alert('Maaf! Anda Belum Login!!');
        window.location='../../user.php';
    </script>
<?php
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_siswa = $_SESSION['siswa'];
    $tanggal_izin = $_POST['tanggal_izin'];
    $keterangan = $_POST['keterangan'];

    $query = "INSERT INTO tb_izin (id_siswa, tanggal_izin, keterangan) VALUES ('$id_siswa', '$tanggal_izin', '$keterangan')";
    if (mysqli_query($con, $query)) {
        echo "<script>
            alert('Izin berhasil diajukan!');
            window.location='../../index.php?page=izin&act=ajukan_izin';
        </script>";
    } else {
        echo "<script>
            alert('Gagal mengajukan izin!');
        </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Izin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
        }
        .main-panel {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 500px;
            text-align: center;
        }
        .form-container h2 {
            background-color: yellow;
            display: inline-block;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 24px;
        }
        .form-group {
            text-align: left;
            margin-bottom: 20px;
        }
        .form-group label {
            font-size: 18px;
        }
        .form-control {
            height: 50px;
            font-size: 18px;
        }
        .form-control textarea {
            height: 150px;
        }
        .btn-primary {
            width: 100%;
            margin-top: 20px;
            font-size: 20px;
            padding: 15px;
        }
        .footer {
            text-align: center;
            padding: 10px;
            background-color: #f8f9fa;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>
    <div class="main-panel">
        <div class="form-container">
            <h2>Form Pengajuan Izin</h2>
            <form method="post">
                <div class="form-group">
                    <label for="tanggal_izin">Tanggal Izin:</label>
                    <input type="date" class="form-control" id="tanggal_izin" name="tanggal_izin" required>
                </div>
                <div class="form-group">
                    <label for="keterangan">Keterangan:</label>
                    <textarea class="form-control" id="keterangan" name="keterangan" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Ajukan Izin</button>
            </form>
        </div>
    </div>
    <footer class="footer">
        <div class="container">
            <div class="copyright ml-auto">
                &copy; <?php echo date('Y');?> Absensi SMP NEGERI 1 MUHAMMADIYAH (<a href="index.php">Husein</a> | 2024)
            </div>
        </div>
    </footer>
</body>
</html>
