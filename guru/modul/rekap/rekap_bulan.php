<?php 
include '../../../config/db.php';

$bulan = mysqli_real_escape_string($con, $_GET['bulan']);
$pelajaran = mysqli_real_escape_string($con, $_GET['pelajaran']);
$kelas = mysqli_real_escape_string($con, $_GET['kelas']);

// Function to fetch associative array safely
function fetch_assoc_safe($query) {
    global $con;
    $result = mysqli_query($con, $query);
    return $result ? mysqli_fetch_assoc($result) : null;
}

// Tampilkan data mengajar
$kelasMengajarQuery = "SELECT * FROM tb_mengajar 
    INNER JOIN tb_guru ON tb_mengajar.id_guru=tb_guru.id_guru
    INNER JOIN tb_master_mapel ON tb_mengajar.id_mapel=tb_master_mapel.id_mapel
    INNER JOIN tb_mkelas ON tb_mengajar.id_mkelas=tb_mkelas.id_mkelas
    INNER JOIN tb_semester ON tb_mengajar.id_semester=tb_semester.id_semester
    INNER JOIN tb_thajaran ON tb_mengajar.id_thajaran=tb_thajaran.id_thajaran
    WHERE tb_mengajar.id_mengajar='$pelajaran' AND tb_mengajar.id_mkelas='$kelas' AND tb_thajaran.status=1 AND tb_semester.status=1";

$d = fetch_assoc_safe($kelasMengajarQuery);

if (!$d) {
    echo "Data mengajar tidak ditemukan.";
    exit;
}

// Tampilkan data absen
$absenQuery = "SELECT * FROM _logabsensi 
    INNER JOIN tb_siswa ON _logabsensi.id_siswa=tb_siswa.id_siswa
    INNER JOIN tb_mengajar ON _logabsensi.id_mengajar=tb_mengajar.id_mengajar
    INNER JOIN tb_semester ON tb_mengajar.id_semester=tb_semester.id_semester
    INNER JOIN tb_thajaran ON tb_mengajar.id_thajaran=tb_thajaran.id_thajaran
    WHERE MONTH(tgl_absen)='$bulan' AND tb_mengajar.id_mkelas='$kelas' AND tb_thajaran.status=1 AND tb_semester.status=1
    GROUP BY _logabsensi.id_siswa ORDER BY _logabsensi.id_siswa ASC";

$qry = mysqli_query($con, $absenQuery);

// Tampilkan data walikelas
$walikelasQuery = "SELECT * FROM tb_walikelas 
    INNER JOIN tb_guru ON tb_walikelas.id_guru=tb_guru.id_guru 
    WHERE tb_walikelas.id_mkelas='$kelas'";

$walas = fetch_assoc_safe($walikelasQuery);

// Get tgl_absen safely
$tglBulan = fetch_assoc_safe($absenQuery)['tgl_absen'];
$tglTerakhir = $tglBulan ? date('t', strtotime($tglBulan)) : 0;

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

<style>
    body {
        font-family: arial;
    }
</style>
<table width="100%">
    <tr>
        <td>
            <img src="../../../assets/img/LOGO1.png" width="130">
        </td>
        <td>
            <center>
                <h1>
                    PRESENSI SISWA <br>
                    <small>Aplikasi Presensi Berbasis Web</small>
                </h1>
                <hr>
                <em>
                    Jl. Jayaabadi - Pucakwangi Km 12 Kec. Bujung Kab. Bekasi Kode Pos 17330
                    <br>Simple@gmail.com Telp.081222333440</b>
                </em>
            </center>
        </td>
        <td>
            <table width="100%">
                <tr>
                    <td colspan="2"><b style="border: 2px solid; padding: 7px;">KELAS ( <?= strtoupper($d['nama_kelas']) ?> )</b></td>
                    <td><b style="border: 2px solid; padding: 7px;"><?= $d['semester'] ?> | <?= $d['tahun_ajaran'] ?></b></td>
                    <td rowspan="5">
                        <ul>
                            <li>H = Hadir</li>
                            <li>S = Sakit</li>
                            <li>I = Izin</li>
                            <li>T = Terlambat</li>
                            <li>A = Absen</li>
                            <li>C = Cabut</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>Nama Guru</td>
                    <td>:</td>
                    <td><?= $d['nama_guru'] ?></td>
                </tr>
                <tr>
                    <td>Bidang Studi</td>
                    <td>:</td>
                    <td><?= $d['mapel'] ?></td>
                </tr>
                <tr>
                    <td>Wali Kelas</td>
                    <td>:</td>
                    <td><?= $walas['nama_guru'] ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<hr style="height: 3px; border: 1px solid;">

<table width="100%" border="1" cellpadding="2" style="border-collapse: collapse;">
    <tr>
        <td rowspan="2" bgcolor="#EFEBE9" align="center">NO</td>
        <td rowspan="2" bgcolor="#EFEBE9">NAMA SISWA</td>
        <td rowspan="2" bgcolor="#EFEBE9" align="center">L/P</td>
        <td colspan="<?= $tglTerakhir; ?>" style="padding: 8px;">PERTEMUAN BULAN: <b style="text-transform: uppercase;"><?php echo namaBulan($bulan); ?> <?= date('Y', strtotime($tglBulan)); ?></b></td>
        <td colspan="5" align="center" bgcolor="#EFEBE9">JUMLAH</td>
    </tr>
    <tr>
        <?php 
        for ($i = 1; $i <= $tglTerakhir; $i++) {
            echo "<td bgcolor='#EFEBE9' align='center'>$i</td>";
        }
        ?>
        <td bgcolor="#FFC107" align="center">S</td>
        <td bgcolor="#4CAF50" align="center">I</td>
        <td bgcolor="#D50000" align="center">A</td>
        <td bgcolor="#76FF03" align="center">T</td>
        <td bgcolor="#9C27B0" align="center">C</td>
    </tr>
    <?php 
    $no = 1;
    while ($ds = mysqli_fetch_assoc($qry)) {
        $warna = ($no % 2 == 1) ? "#ffffff" : "#f0f0f0";
    ?>
    <tr bgcolor="<?= $warna; ?>">
        <td align="center"><?= $no++; ?></td>
        <td><?= $ds['nama_siswa']; ?></td>
        <td align="center"><?= $ds['jk']; ?></td>
        <?php 
        for ($i = 1; $i <= $tglTerakhir; $i++) {
            $ketQuery = "SELECT * FROM _logabsensi
                INNER JOIN tb_mengajar ON _logabsensi.id_mengajar=tb_mengajar.id_mengajar
                INNER JOIN tb_semester ON tb_mengajar.id_semester=tb_semester.id_semester
                INNER JOIN tb_thajaran ON tb_mengajar.id_thajaran=tb_thajaran.id_thajaran
                WHERE DAY(tgl_absen)='$i' AND id_siswa='{$ds['id_siswa']}' AND _logabsensi.id_mengajar='$pelajaran' AND MONTH(tgl_absen)='$bulan' AND tb_mengajar.id_mkelas='$kelas' AND tb_thajaran.status=1 AND tb_semester.status=1 GROUP BY DAY(tgl_absen)";
            $h = fetch_assoc_safe($ketQuery);
            echo "<td align='center' bgcolor='white'>";
            if ($h) {
                switch ($h['ket']) {
                    case 'H':
                        echo "<b style='color:#2196F3;'>H</b>";
                        break;
                    case 'I':
                        echo "<b style='color:#4CAF50;'>I</b>";
                        break;
                    case 'S':
                        echo "<b style='color:#FFC107;'>S</b>";
                        break;
                    case 'A':
                        echo "<b style='color:#D50000;'>A</b>";
                        break;
                    case 'T':
                        echo "<b style='color:#76FF03;'>T</b>";
                        break;
                    default:
                        echo "<b style='color:#9C27B0;'>C</b>";
                }
            } else {
                echo "-";
            }
            echo "</td>";
        }
        ?>
        <td align="center" style="font-weight: bold;">
            <?php 
            $sakit = fetch_assoc_safe("SELECT COUNT(ket) AS sakit FROM _logabsensi
                INNER JOIN tb_mengajar ON _logabsensi.id_mengajar=tb_mengajar.id_mengajar
                INNER JOIN tb_semester ON tb_mengajar.id_semester=tb_semester.id_semester
                INNER JOIN tb_thajaran ON tb_mengajar.id_thajaran=tb_thajaran.id_thajaran
                WHERE _logabsensi.id_siswa='{$ds['id_siswa']}' AND _logabsensi.ket='S' AND MONTH(tgl_absen)='$bulan' AND _logabsensi.id_mengajar='$pelajaran' AND tb_mengajar.id_mkelas='$kelas' AND tb_thajaran.status=1 AND tb_semester.status=1");
            echo $sakit['sakit'] ?? 0;
            ?>
        </td>
        <td align="center" style="font-weight: bold;">
            <?php 
            $izin = fetch_assoc_safe("SELECT COUNT(ket) AS izin FROM _logabsensi
                INNER JOIN tb_mengajar ON _logabsensi.id_mengajar=tb_mengajar.id_mengajar
                INNER JOIN tb_semester ON tb_mengajar.id_semester=tb_semester.id_semester
                INNER JOIN tb_thajaran ON tb_mengajar.id_thajaran=tb_thajaran.id_thajaran
                WHERE _logabsensi.id_siswa='{$ds['id_siswa']}' AND _logabsensi.ket='I' AND MONTH(tgl_absen)='$bulan' AND _logabsensi.id_mengajar='$pelajaran' AND tb_mengajar.id_mkelas='$kelas' AND tb_thajaran.status=1 AND tb_semester.status=1");
            echo $izin['izin'] ?? 0;
            ?>
        </td>
        <td align="center" style="font-weight: bold;">
            <?php 
            $alfa = fetch_assoc_safe("SELECT COUNT(ket) AS alfa FROM _logabsensi
                INNER JOIN tb_mengajar ON _logabsensi.id_mengajar=tb_mengajar.id_mengajar
                INNER JOIN tb_semester ON tb_mengajar.id_semester=tb_semester.id_semester
                INNER JOIN tb_thajaran ON tb_mengajar.id_thajaran=tb_thajaran.id_thajaran
                WHERE _logabsensi.id_siswa='{$ds['id_siswa']}' AND _logabsensi.ket='A' AND MONTH(tgl_absen)='$bulan' AND _logabsensi.id_mengajar='$pelajaran' AND tb_mengajar.id_mkelas='$kelas' AND tb_thajaran.status=1 AND tb_semester.status=1");
            echo $alfa['alfa'] ?? 0;
            ?>
        </td>
        <td align="center" style="font-weight: bold;">
            <?php 
            $tlambat = fetch_assoc_safe("SELECT COUNT(ket) AS tlambat FROM _logabsensi
                INNER JOIN tb_mengajar ON _logabsensi.id_mengajar=tb_mengajar.id_mengajar
                INNER JOIN tb_semester ON tb_mengajar.id_semester=tb_semester.id_semester
                INNER JOIN tb_thajaran ON tb_mengajar.id_thajaran=tb_thajaran.id_thajaran
                WHERE _logabsensi.id_siswa='{$ds['id_siswa']}' AND _logabsensi.ket='T' AND MONTH(tgl_absen)='$bulan' AND _logabsensi.id_mengajar='$pelajaran' AND tb_mengajar.id_mkelas='$kelas' AND tb_thajaran.status=1 AND tb_semester.status=1");
            echo $tlambat['tlambat'] ?? 0;
            ?>
        </td>
        <td align="center" style="font-weight: bold;">
            <?php 
            $cabut = fetch_assoc_safe("SELECT COUNT(ket) AS cabut FROM _logabsensi
                INNER JOIN tb_mengajar ON _logabsensi.id_mengajar=tb_mengajar.id_mengajar
                INNER JOIN tb_semester ON tb_mengajar.id_semester=tb_semester.id_semester
                INNER JOIN tb_thajaran ON tb_mengajar.id_thajaran=tb_thajaran.id_thajaran
                WHERE _logabsensi.id_siswa='{$ds['id_siswa']}' AND _logabsensi.ket='C' AND MONTH(tgl_absen)='$bulan' AND _logabsensi.id_mengajar='$pelajaran' AND tb_mengajar.id_mkelas='$kelas' AND tb_thajaran.status=1 AND tb_semester.status=1");
            echo $cabut['cabut'] ?? 0;
            ?>
        </td>
    </tr>
    <?php } ?>
</table>

<p></p>
<table width="100%">
    <tr>
        <td align="right">
            <p>Agam, <?php echo date('d-F-Y'); ?></p>
            <p>
                Kepala Sekolah
                <br><br><br><br><br>
                NURMIZA, MA <br>
                ----------------------<br>
                NIP.197411092002102003
            </p>
        </td>
    </tr>
</table>

<script>
    window.print();
</script>
