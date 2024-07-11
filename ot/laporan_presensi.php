<div class="container mt-5">
    <h3>Laporan Presensi Siswa</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Presensi</th>
                <th>ID Mengajar</th>
                <th>ID Siswa</th>
                <th>Tanggal Absen</th>
                <th>Keterangan</th>
                <th>Pertemuan Ke</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include_once "modul/koneksi.php";  // Gunakan include_once dan pastikan path benar

            if ($koneksi) {  // Pastikan koneksi berhasil
                $no = 1;
                $ambildata = mysqli_query($koneksi, "SELECT * FROM _logabsensi");
                while ($tampil = mysqli_fetch_array($ambildata)) {
                    echo "
                    <tr>
                        <td>{$tampil['id_presensi']}</td>
                        <td>{$tampil['id_mengajar']}</td>
                        <td>{$tampil['id_siswa']}</td>
                        <td>{$tampil['tgl_absen']}</td>
                        <td>{$tampil['ket']}</td>
                        <td>{$tampil['pertemuan_ke']}</td>
                    </tr>";
                    $no++;
                }
            } else {
                echo "Koneksi database gagal.";
            }
            ?>
        </tbody>
    </table>

    <?php
    if (isset($_GET['kode'])) {
        $kode = $_GET['kode'];
        if ($koneksi) {
            mysqli_query($koneksi, "DELETE FROM _logabsensi WHERE id_presensi='$kode'");
            echo "Data berhasil dihapus";
            echo "<meta http-equiv=refresh content='2;URL=index.php'>";
        } else {
            echo "Gagal menghapus data karena koneksi database gagal.";
        }
    }
    ?>
</div>
