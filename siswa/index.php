<?php
@session_start();
 include '../config/db.php';

if (!isset($_SESSION['siswa'])) {
?> <script>
    alert('Maaf ! Anda Belum Login !!');
    window.location='../user.php';
 </script>
<?php
}
 ?>


   <?php
$id_login = @$_SESSION['siswa'];
$sql = mysqli_query($con,"SELECT * FROM tb_siswa
 WHERE id_siswa = '$id_login'") or die(mysqli_error($con));
$data = mysqli_fetch_array($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Siswa | Aplikasi Presensi</title>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="../assets/css/demo.css">
</head>
<body>
    <div class="wrapper">
        <div class="main-header">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="blue">
                <a href="index.php" class="logo">
                    <b class="text-white">ABSENSIKU</b>
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
                                    <img src="../assets/img/user/<?= isset($data['foto']) ? $data['foto'] : 'default.png' ?>" alt="..." class="avatar-img rounded-circle">
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-user animated fadeIn">
                                <div class="dropdown-user-scroll scrollbar-outer">
                                    <li>
                                        <div class="user-box">
                                            <div class="avatar-lg"><img src="../assets/img/user/<?= isset($data['foto']) ? $data['foto'] : 'default.png' ?>" alt="image profile" class="avatar-img rounded"></div>
                                            <div class="u-text">
                                                <h4><?= isset($data['nama_siswa']) ? $data['nama_siswa'] : 'Nama Siswa' ?></h4>
                                                <p class="text-muted"><?= isset($data['nis']) ? $data['nis'] : '' ?></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="?page=change">Ganti Password</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="logout.php">Logout</a>
                                    </li>
                                </div>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        <!-- Sidebar -->
        <div class="sidebar sidebar-style-2">            
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <div class="user">
                        <div class="avatar-sm float-left mr-2">
                            <img src="../assets/img/user/<?= isset($data['foto']) ? $data['foto'] : 'default.png' ?>" alt="..." class="avatar-img rounded-circle">
                        </div>
                        <div class="info">
                            <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                                <span>
                                    <?= isset($data['nama_siswa']) ? $data['nama_siswa'] : 'Nama Siswa' ?>
                                    <span class="user-level"><?= isset($data['nis']) ? $data['nis'] : '' ?></span>
                                    <span class="caret"></span>
                                </span>
                            </a>
                            <div class="clearfix"></div>
                            <div class="collapse in" id="collapseExample">
                                <ul class="nav">
                                    <li>
                                        <a href="?page=change">
                                            <span class="link-collapse">Ganti Password</span>
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
                            <a href="?page=kehadiran&act=presensi">
                                <i class="fas fa-user-check"></i>
                                <p>Presensi Sekarang</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="?page=izin&act=ajukan_izin">
                                <i class="fas fa-user-check"></i>
                                <p>Ajukan Izin</p>
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

        <div class="main-panel">
            <div class="content">
                <!-- Halaman dinamis -->
                <?php
            error_reporting(E_ALL);
            $page = isset($_GET['page']) ? $_GET['page'] : '';
            $act = isset($_GET['act']) ? $_GET['act'] : '';

            if ($page == 'kehadiran') {
                if ($act == '') {
                    include 'modul/absen/kehadiran.php';
                } elseif ($act == 'presensi') {
                    include 'modul/absen/presensi.php';
                }  
            } elseif ($page == 'izin') {
                if ($act == '') {
                    include 'modul/izin/ajukan_izin.php';
                } elseif ($act == 'ajukan_izin') {
                    include 'modul/izin/ajukan_izin.php';
                } elseif ($act == 'surat_view') {
                    include 'modul/izin/view_surat_izin.php';
                }                      
            } elseif ($page == 'change') {
                include 'modul/user/ganti_password.php';
            } elseif ($page == '') {
                include 'modul/home.php';
            } else {
                echo "<b>Tidak ada Halaman</b>";
            }
            ?>
                <!-- end -->
            </div>
            <footer class="footer">
                <div class="container">
                    <div class="copyright ml-auto">
                    </div>                
                </div>
            </footer>
        </div>
    </div>
    <!-- Core JS Files -->
    <script src="../assets/js/core/jquery.3.2.1.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <!-- jQuery UI -->
    <script src="../assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script src="../assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>
    <!-- jQuery Scrollbar -->
    <script src="../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <!-- Datatables -->
    <script src="../assets/js/plugin/datatables/datatables.min.js"></script>
    <!-- Sweet Alert -->
    <script src="../assets/js/plugin/sweetalert/sweetalert.min.js"></script>
    <!-- Atlantis JS -->
    <script src="../assets/js/atlantis.min.js"></script>
    <!-- Atlantis DEMO methods, don't include it in your project! -->
    <script src="../assets/js/setting-demo.js"></script>
</body>
</html>
