<?php
$con = mysqli_connect("localhost", "u902956780_db_imas", "Rast@210", "u902956780_db_imas");

if (!function_exists('namaBulan')) {
    function namaBulan($bulan) {
        $bulanArray = array(
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        );
        return $bulanArray[$bulan];
    }
}

if (!function_exists('tglIndonesia')) {
    function tglIndonesia($tgl) {
        $tanggal = substr($tgl, 8, 2);
        $bulan = namaBulan(substr($tgl, 5, 2));
        $tahun = substr($tgl, 0, 4);
        return $tanggal . ' ' . $bulan . ' ' . $tahun;
    }
}

if (!function_exists('hari_ini')) {
    function hari_ini() {
        $hari = date("D");
        $hari_ini = "";
        switch ($hari) {
            case 'Sun': $hari_ini = "Minggu"; break;
            case 'Mon': $hari_ini = "Senin"; break;
            case 'Tue': $hari_ini = "Selasa"; break;
            case 'Wed': $hari_ini = "Rabu"; break;
            case 'Thu': $hari_ini = "Kamis"; break;
            case 'Fri': $hari_ini = "Jumat"; break;
            case 'Sat': $hari_ini = "Sabtu"; break;
            default: $hari_ini = "Tidak di ketahui"; break;
        }
        return "<b>" . $hari_ini . "</b>";
    }
}

if (!function_exists('namahari')) {
    function namahari($tanggalnya) {
        $tgl = substr($tanggalnya, 8, 2);
        $bln = substr($tanggalnya, 5, 2);
        $thn = substr($tanggalnya, 0, 4);
        $info = date('w', mktime(0, 0, 0, $bln, $tgl, $thn));
        switch ($info) {
            case '0': return "Minggu"; break;
            case '1': return "Senin"; break;
            case '2': return "Selasa"; break;
            case '3': return "Rabu"; break;
            case '4': return "Kamis"; break;
            case '5': return "Jumat"; break;
            case '6': return "Sabtu"; break;
        }
    }
}
?>
