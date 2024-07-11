<?php
// Periksa koneksi database
$con = mysqli_connect("localhost", "u902956780_db_imas", "Rast@210", "u902956780_db_imas");

if (mysqli_connect_errno()) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// Ambil data mengajar
$kelasMengajar = mysqli_query($con, "SELECT * FROM tb_mengajar 
INNER JOIN tb_master_mapel ON tb_mengajar.id_mapel=tb_master_mapel.id_mapel
INNER JOIN tb_mkelas ON tb_mengajar.id_mkelas=tb_mkelas.id_mkelas
INNER JOIN tb_semester ON tb_mengajar.id_semester=tb_semester.id_semester
INNER JOIN tb_thajaran ON tb_mengajar.id_thajaran=tb_thajaran.id_thajaran
WHERE tb_mengajar.id_guru='$data[id_guru]' AND tb_mengajar.id_mengajar='$_GET[pelajaran]' AND tb_thajaran.status=1");

if (!$kelasMengajar) {
    die("Query error: " . mysqli_error($con));
}

// Tambahkan debug untuk melihat apakah ada data mengajar
if (mysqli_num_rows($kelasMengajar) == 0) {
    echo "<p>Tidak ada data mengajar yang ditemukan.</p>";
} else {
    $d = mysqli_fetch_assoc($kelasMengajar);
?>

<div class="page-inner">
    <div class="page-header">
        <ul class="breadcrumbs" style="font-weight: bold;">
            <li class="nav-home">
                <a href="#">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">KELAS (<?= strtoupper($d['nama_kelas']) ?>)</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#"><?= strtoupper($d['mapel']) ?></a>
            </li>
        </ul>
    </div>

    <div class="row">
        <?php
        $last_pertemuan = mysqli_query($con, "SELECT * FROM _logabsensi WHERE id_mengajar='$_GET[pelajaran]' GROUP BY pertemuan_ke ORDER BY pertemuan_ke DESC LIMIT 1");
        if (!$last_pertemuan) {
            die("Query error: " . mysqli_error($con));
        }

        $cekPertemuan = mysqli_num_rows($last_pertemuan);
        $jml = mysqli_fetch_array($last_pertemuan);

        $pertemuan = ($cekPertemuan > 0) ? $jml['pertemuan_ke'] + 1 : 1;
        ?>

        <div class="card">
            <div class="card-body">
                <form action="" method="post">
                    <p>
                        <span class="badge badge-default" style="padding: 7px;font-size: 14px;"><b>Daftar Hadir Siswa</b></span>
                        <span class="badge badge-primary" style="padding: 7px;font-size: 14px;">Pertemuan Ke : <b><?= $pertemuan; ?></b></span>
                    </p>
                    <div class="form-group">
                        <label for="tgl">Tanggal:</label>
                        <input type="date" name="tgl" class="form-control" value="<?= date('Y-m-d') ?>" style="background-color: #212121;color: #FFEB3B;">
                        <input type="hidden" name="pertemuan" class="form-control" value="<?= $pertemuan; ?>">
                    </div>
                    <div class="card-list">
                        <?php
                        $siswa = mysqli_query($con, "SELECT * FROM tb_siswa WHERE id_mkelas='$d[id_mkelas]' ORDER BY id_siswa ASC");
                        if (!$siswa) {
                            die("Query error: " . mysqli_error($con));
                        }

                        $jumlahSiswa = mysqli_num_rows($siswa);
                        if ($jumlahSiswa == 0) {
                            echo "<p>No students found in this class.</p>";
                        } else {
                            foreach ($siswa as $i => $s) { ?>
                                <div class="item-list">
                                    <div class="info-user">
                                        <div class="username">
                                            <b class="text-success"><?= $s['nama_siswa'] ?></b>
                                            <input type="hidden" name="id_siswa[<?= $i; ?>]" value="<?= $s['id_siswa'] ?>">
                                            <input type="hidden" name="pelajaran" value="<?= $_GET['pelajaran'] ?>">
                                        </div>
                                        <div class="status mt-0">
                                            <div class="form-check">
                                                <?php
                                                $statuses = ['H', 'I', 'S', 'T', 'A', 'C'];
                                                foreach ($statuses as $status) { ?>
                                                    <label class="form-check-label">
                                                        <input name="ket[<?= $i; ?>]" class="form-check-input" type="radio" value="<?= $status; ?>">
                                                        <span class="form-check-sign"><?= $status; ?></span>
                                                    </label>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php }
                        } ?>
                    </div>
                    <center>
                        <button type="submit" name="absen" class="btn btn-success"><i class="fa fa-check"></i> Selesai</button>
                        <a href="?page=absen&act=update&pelajaran=<?= $_GET['pelajaran']; ?>" class="btn btn-warning"><i class="fas fa-edit"></i> Update Absensi</a>
                    </center>
                </form>

                <?php
                if (isset($_POST['absen'])) {
                    if (isset($_POST['id_siswa']) && is_array($_POST['id_siswa'])) {
                        $total = count($_POST['id_siswa']);
                        $today = mysqli_real_escape_string($con, $_POST['tgl']);
                        $pertemuan = mysqli_real_escape_string($con, $_POST['pertemuan']);

                        for ($i = 0; $i < $total; $i++) {
                            $id_siswa = mysqli_real_escape_string($con, $_POST['id_siswa'][$i]);
                            $pelajaran = mysqli_real_escape_string($con, $_POST['pelajaran']);
                            $ket = mysqli_real_escape_string($con, $_POST['ket'][$i]);

                            $cekAbsenHariIni = mysqli_num_rows(mysqli_query($con, "SELECT * FROM _logabsensi WHERE tgl_absen='$today' AND id_mengajar='$pelajaran' AND id_siswa='$id_siswa'"));

                            if ($cekAbsenHariIni > 0) {
                                echo "<script type='text/javascript'>
                                        setTimeout(function () { 
                                            swal('Sorry!', 'Absen Hari ini sudah dilakukan', {
                                                icon: 'error',
                                                buttons: { confirm: { className : 'btn btn-danger' } },
                                            });    
                                        }, 10);  
                                        window.setTimeout(function(){ 
                                            window.location.replace('?page=absen&pelajaran=$_GET[pelajaran]');
                                        }, 3000);   
                                      </script>";
                            } else {
                                $insert = mysqli_query($con, "INSERT INTO _logabsensi (tgl_absen, id_mengajar, id_siswa, ket, pertemuan_ke) VALUES ('$today', '$pelajaran', '$id_siswa', '$ket', '$pertemuan')");

                                if ($insert) {
                                    echo "<script type='text/javascript'>
                                            setTimeout(function () { 
                                                swal('Berhasil', 'Absen hari ini telah diperbarui!', {
                                                    icon: 'success',
                                                    buttons: { confirm: { className : 'btn btn-success' } },
                                                });    
                                            }, 10);  
                                            window.setTimeout(function(){ 
                                                window.location.replace('?page=absen&pelajaran=$_GET[pelajaran]');
                                            }, 3000);   
                                          </script>";
                                } else {
                                    // Debug: Tampilkan error MySQL jika insert gagal
                                    echo "Insert Error: " . mysqli_error($con) . "<br>";
                                }
                            }
                        }
                    } else {
                        echo "<script type='text/javascript'>
                                setTimeout(function () { 
                                    swal('Error!', 'Tidak ada data siswa yang diterima', {
                                        icon: 'error',
                                        buttons: { confirm: { className : 'btn btn-danger' } },
                                    });    
                                }, 10);
                              </script>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php
}
?>
