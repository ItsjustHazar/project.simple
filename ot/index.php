<?php
@session_start();
include '../config/db.php';

// Set error reporting to show all errors
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', '../logs/php_errors.log');

// Check if session is set for kepsek
if (!isset($_SESSION['kepsek'])) {
?> 
<script>
    alert('Maaf ! Anda Belum Login !!');
    window.location='../user.php';
</script>
<?php
    exit; // Stop further execution
}

// Get the id_login from session
$id_login = $_SESSION['kepsek'];

// Check connection to the database
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Prepare and execute the SQL query to get kepsek data
$sql = mysqli_query($con, "SELECT * FROM tb_kepsek WHERE id_kepsek = '$id_login'");

if (!$sql) {
    // Log the error and show a user-friendly message
    error_log("Query Error: " . mysqli_error($con));
    die("Error: Unable to fetch data. Please try again later.");
}

$data = mysqli_fetch_array($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Wali Murid | Aplikasi Presensi</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="../assets/img/icon.ico" type="image/x-icon"/>

    <!-- Fonts and icons -->
    <script src="../assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {"families":["Lato:300,400,700,900"]},
            custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['../assets/css/fonts.min.css']},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/atlantis.min.css">

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="../assets/css/demo.css">
</head>
<body>
    <div class="wrapper">
        <div class="main-header">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="blue">
                <a href="index.php" class="logo">
                    <b class="text-white">SIMPLE</b>
                </a>
                <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <i class="icon-menu"></i>
                    </span>
                </button>
                <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
                <div class="nav-toggle">
                    <button class="btn btn-toggle toggle-sidebar">
                        <i class="icon-menu"></i>
                    </button>
                </div>
            </div>
            <!-- End Logo Header -->

            <!-- Navbar Header -->
            <nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">
                <div class="container-fluid">
                    <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                        <li class="nav-item dropdown hidden-caret">
                            <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                                <div class="avatar-sm">
                                    <img src="../assets/img/user/<?=$data['foto'] ?>" alt="..." class="avatar-img rounded-circle">
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-user animated fadeIn">
                                <div class="dropdown-user-scroll scrollbar-outer">
                                    <li>
                                        <div class="user-box">
                                            <div class="avatar-lg"><img src="../assets/img/user/<?=$data['foto'] ?>" alt="image profile" class="avatar-img rounded"></div>
                                            <div class="u-text">
                                                <h4><?=$data['nama_kepsek'] ?></h4>
                                                <p class="text-muted"><?=$data['email'] ?></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="?page=akun">Akun Saya</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="logout.php">Logout</a>
                                    </li>
                                </div>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- End Navbar -->
        </div>

        <!-- Sidebar -->
        <div class="sidebar sidebar-style-2">            
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <div class="user">
                        <div class="avatar-sm float-left mr-2">
                            <img src="../assets/img/user/<?=$data['foto'] ?>" alt="..." class="avatar-img rounded-circle">
                        </div>
                        <div class="info">
                            <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                                <span>
                                    <?=$data['nama_kepsek'] ?>
                                    <span class="user-level"><?=$data['nip'] ?></span>
                                    <span class="caret"></span>
                                </span>
                            </a>
                            <div class="clearfix"></div>

                            <div class="collapse in" id="collapseExample">
                                <ul class="nav">
                                    <li>
                                        <a href="?page=akun">
                                            <span class="link-collapse">Akun Saya</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <ul class="nav nav-primary">
                        <li class="nav-item active">
                            <a href="index.php" class="collapsed">
                                <i class="fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>                            
                        </li>
                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                            <h4 class="text-section">Main Utama</h4>
                        </li>
                        <li class="nav-item">
                            <a href="?page=laporan_presensi">
                                <i class="fas fa-clipboard-check"></i>
                                <p>Laporan Presensi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="?page=pengaduan">
                                <i class="fas fa-clipboard-check"></i>
                                <p>Pengaduan</p>
                            </a>
                        </li>
                        <li class="nav-item active mt-3">
                            <a href="logout.php" class="collapsed">
                                <i class="fas fa-arrow-alt-circle-left"></i>
                                <p>Logout</p>
                            </a>                            
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- End Sidebar -->

        <!-- Main Content -->
        <div class="main-panel">
            <div class="content">
                <div class="container mt-5">
                    <?php
                    // Include the page content based on the 'page' parameter
                    if (isset($_GET['page'])) {
                        $page = $_GET['page'];
                        if ($page == "pengaduan") {
                            include "pengaduan.php";
                        } elseif ($page == "laporan_presensi") {
                            include "laporan_presensi.php";
                        } else {
                            // Default to pengaduan.php if no valid page is specified
                            include "pengaduan.php";
                        }
                    } else {
                        // Default to pengaduan.php if no page is specified
                        include "pengaduan.php";
                    }
                    ?>
                </div>
            </div>

            <!-- Footer -->
            <footer class="footer">
                <div class="container">
                    <div class="copyright ml-auto">
                     </div>              
                </div>
            </footer>
            <!-- End Footer -->
        </div>
        <!-- End Main Content -->
    </div>

    <!--   Core JS Files   -->
    <script src="../assets/js/core/jquery.3.2.1.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery UI -->
    <script src="../assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script src="../assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Atlantis JS -->
    <script src="../assets/js/atlantis.min.js"></script>

    <!-- Atlantis DEMO methods, don't include it in your project! -->
    <script src="../assets/js/setting-demo.js"></script>
    <script src="../assets/js/demo.js"></script>
</body>
</html>
