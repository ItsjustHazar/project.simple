<?php
session_start();
include '../config/db.php';

// Aktifkan pelaporan error
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Pastikan koneksi berhasil
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login | Admin</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="../assets/img/LOGO1.png"/>
    <link rel="stylesheet" type="text/css" href="../assets/_login/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/_login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/_login/fonts/iconic/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/_login/vendor/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="../assets/_login/vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/_login/vendor/animsition/css/animsition.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/_login/vendor/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/_login/vendor/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" type="text/css" href="../assets/_login/css/util.css">
    <link rel="stylesheet" type="text/css" href="../assets/_login/css/main.css">
</head>
<body>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form method="post" action="" class="login100-form validate-form">
                    <span class="login100-form-title p-b-48">
                        <img src="../assets/img/lOGO1.png" width="100">
                    </span>
                    <span class="login100-form-title p-b-26">
                    </span>

                    <div class="wrap-input100 validate-input">
                        <input class="input100" type="text" name="username" required>
                        <span class="focus-input100" data-placeholder="Username"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="password">
                        <span class="btn-show-pass">
                            <i class="zmdi zmdi-eye"></i>
                        </span>
                        <input class="input100" type="password" name="password" required>
                        <span class="focus-input100" data-placeholder="Password"></span>
                    </div>

                    <div class="container-login100-form-btn">
                        <div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>
                            <button type="submit" class="login100-form-btn">
                                Login
                            </button>
                        </div>
                    </div>
                </form>

                <?php 
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $username = mysqli_real_escape_string($con, $_POST['username']);
                    $password = sha1($_POST['password']); // Assuming the password in DB is hashed with sha1

                    // Debugging output
                    // echo "Input Username: $username<br>";
                    // echo "Input Password: $password<br>";

                    $sqlCek = mysqli_query($con, "SELECT * FROM tb_admin WHERE username='$username' AND password='$password' AND aktif='Y'");
                    if (!$sqlCek) {
                        if (!$sqlCek) {
                            die("Query failed: " . mysqli_error($con));
                        }
                    }
                    $jml = mysqli_num_rows($sqlCek);
                    $d = mysqli_fetch_array($sqlCek);

                    // Debugging output
                    // echo "Jumlah data yang ditemukan: $jml<br>";

                    if ($jml > 0) {
                        $_SESSION['admin'] = $d['id_admin'];

                        echo "
                        <script type='text/javascript'>
                        setTimeout(function () { 
                            swal({
                                title: 'Login berhasil',
                                text: 'Selamat datang, Administrator!',
                                icon: 'success',
                                buttons: {
                                    confirm: {
                                        className : 'btn btn-success'
                                    }
                                },
                            }).then(function() {
                                window.location.href = './dashboard.php';
                            });
                        }, 10);
                        </script>";
                    } else {
                        echo "
                        <script type='text/javascript'>
                        setTimeout(function () { 
                            swal({
                                title: 'Sorry!',
                                text: 'Username / Password Salah',
                                icon: 'error',
                                buttons: {
                                    confirm: {
                                        className : 'btn btn-danger'
                                    }
                                },
                            }).then(function() {
                                window.location.href = 'index.php';
                            });
                        }, 10);
                        </script>";
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <div id="dropDownSelect1"></div>

    <script src="../assets/_login/vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="../assets/_login/vendor/animsition/js/animsition.min.js"></script>
    <script src="../assets/_login/vendor/bootstrap/js/popper.js"></script>
    <script src="../assets/_login/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/_login/vendor/select2/select2.min.js"></script>
    <script src="../assets/_login/vendor/daterangepicker/moment.min.js"></script>
    <script src="../assets/_login/vendor/daterangepicker/daterangepicker.js"></script>
    <script src="../assets/_login/vendor/countdowntime/countdowntime.js"></script>

    <!-- Sweet Alert -->
    <script src="../assets/js/plugin/sweetalert/sweetalert.min.js"></script>
    <script src="../assets/_login/js/main.js"></script>
</body>
</html>
