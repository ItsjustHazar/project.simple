<?php
include($_SERVER['DOCUMENT_ROOT'].'/Absen/config/db.php');

// Ambil data dari URL
$bulan = $_GET['bulan'] ?? date('m');
$kelas = $_GET['kelas'] ?? '';

// Query untuk mendapatkan data mengajar
$kelasMengajar = mysqli_query($con, "SELECT tb_mengajar.*, tb_master_mapel.mapel, tb_mkelas.nama_kelas, tb_guru.nama_guru, tb_semester.semester, tb_thajaran.tahun_ajaran 
    FROM tb_mengajar 
    INNER JOIN tb_master_mapel ON tb_mengajar.id_mapel = tb_master_mapel.id_mapel
    INNER JOIN tb_mkelas ON tb_mengajar.id_mkelas = tb_mkelas.id_mkelas
    INNER JOIN tb_guru ON tb_mengajar.id_guru = tb_guru.id_guru
    INNER JOIN tb_semester ON tb_mengajar.id_semester = tb_semester.id_semester
    INNER JOIN tb_thajaran ON tb_mengajar.id_thajaran = tb_thajaran.id_thajaran
    WHERE tb_mengajar.id_mkelas = '$kelas' AND tb_thajaran.status = 1 AND tb_semester.status = 1");

// Inisialisasi nama kelas
$kelasName = "";

// Ambil hasil pertama untuk mendapatkan nama kelas
if ($d = mysqli_fetch_assoc($kelasMengajar)) {
    $kelasName = strtoupper($d['nama_kelas'] ?? '');
}

// Reset pointer ke awal result set
mysqli_data_seek($kelasMengajar, 0);
?>

<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Rekap Presensi</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="#">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">KELAS (<?= $kelasName ?>)</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-head-bg-danger table-xs">
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th>Mata Pelajaran</th>
                                <th scope="col">Absensi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            while ($mp = mysqli_fetch_assoc($kelasMengajar)) { ?>
                                <tr>
                                    <td><?= $no++; ?>.</td>
                                    <td>
                                        <b><?= $mp['mapel']; ?></b><br>
                                        <code><?= $mp['nama_guru']; ?></code>
                                    </td>
                                    <td>
                                        <a href="?page=rekap&act=rekap-perbulan&pelajaran=<?= $mp['id_mengajar'] ?>&kelas=<?= $kelas ?>&bulan=<?= $bulan ?>" class="btn btn-default">
                                            <span class="btn-label">
                                                <i class="fas fa-clipboard"></i>
                                            </span>
                                            Rekap Absen
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
if (isset($_GET['pelajaran'])) {
    $pelajaran = $_GET['pelajaran'];

    // Query untuk mendapatkan data absen
    $qry = mysqli_query($con, "SELECT _logabsensi.*, tb_siswa.nama_siswa, tb_siswa.jk 
        FROM _logabsensi 
        INNER JOIN tb_siswa ON _logabsensi.id_siswa = tb_siswa.id_siswa
        WHERE MONTH(tgl_absen) = '$bulan' AND _logabsensi.id_mengajar = '$pelajaran'
        GROUP BY _logabsensi.id_siswa 
        ORDER BY _logabsensi.id_siswa ASC");

    $tglTerakhir = date('t', strtotime("$bulan-01"));

    function namaBulan($bulan) {
        $namaBulan = array(
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        );
        return $namaBulan[(int)$bulan];
    }
?>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th rowspan="2" class="text-center">No</th>
                    <th rowspan="2">Nama Siswa</th>
                    <th rowspan="2" class="text-center">L/P</th>
                    <th colspan="<?= $tglTerakhir; ?>" class="text-center">Pertemuan Bulan: <?= namaBulan($bulan) ?> <?= date('Y'); ?></th>
                    <th colspan="5" class="text-center">Jumlah</th>
                </tr>
                <tr>
                    <?php 
                    for ($i = 1; $i <= $tglTerakhir; $i++) {
                        echo "<th class='text-center'>$i</th>";
                    }
                    ?>
                    <th class="text-center bg-warning">S</th>
                    <th class="text-center bg-success">I</th>
                    <th class="text-center bg-danger">A</th>
                    <th class="text-center bg-info">T</th>
                    <th class="text-center bg-secondary">C</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                while ($ds = mysqli_fetch_assoc($qry)) { ?>
                <tr>
                    <td class="text-center"><?= $no++; ?></td>
                    <td><?= $ds['nama_siswa']; ?></td>
                    <td class="text-center"><?= $ds['jk']; ?></td>
                    <?php 
                    for ($i = 1; $i <= $tglTerakhir; $i++) {
                        $ket = mysqli_query($con, "SELECT ket FROM _logabsensi 
                            WHERE DAY(tgl_absen) = '$i' AND id_siswa = '$ds[id_siswa]' AND id_mengajar = '$pelajaran' AND MONTH(tgl_absen) = '$bulan'");
                        $h = mysqli_fetch_assoc($ket);
                        echo "<td class='text-center'>";
                        if ($h) {
                            echo $h['ket'];
                        } else {
                            echo "-";
                        }
                        echo "</td>";
                    }
                    ?>
                    <td class="text-center bg-warning"><?= mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(ket) AS sakit FROM _logabsensi WHERE id_siswa = '$ds[id_siswa]' AND ket = 'S' AND MONTH(tgl_absen) = '$bulan' AND id_mengajar = '$pelajaran'"))['sakit']; ?></td>
                    <td class="text-center bg-success"><?= mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(ket) AS izin FROM _logabsensi WHERE id_siswa = '$ds[id_siswa]' AND ket = 'I' AND MONTH(tgl_absen) = '$bulan' AND id_mengajar = '$pelajaran'"))['izin']; ?></td>
                    <td class="text-center bg-danger"><?= mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(ket) AS alfa FROM _logabsensi WHERE id_siswa = '$ds[id_siswa]' AND ket = 'A' AND MONTH(tgl_absen) = '$bulan' AND id_mengajar = '$pelajaran'"))['alfa']; ?></td>
                    <td class="text-center bg-info"><?= mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(ket) AS tlambat FROM _logabsensi WHERE id_siswa = '$ds[id_siswa]' AND ket = 'T' AND MONTH(tgl_absen) = '$bulan' AND id_mengajar = '$pelajaran'"))['tlambat']; ?></td>
                    <td class="text-center bg-secondary"><?= mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(ket) AS cabut FROM _logabsensi WHERE id_siswa = '$ds[id_siswa]' AND ket = 'C' AND MONTH(tgl_absen) = '$bulan' AND id_mengajar = '$pelajaran'"))['cabut']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php } ?>
