<?php
require 'function.php'; // Assuming this file contains necessary functions
require 'cek.php'; // Assuming this file checks authentication

// Assuming $conn is your database connection object

$query = "SELECT pegawai.*, 
                 unit.nama_unit, 
                 jabatan.stts_jabatan
          FROM pegawai
          INNER JOIN unit ON pegawai.id_unit = unit.id_unit
          LEFT JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan";

$result = mysqli_query($conn, $query);

// Inisialisasi array untuk menyimpan data
$pegawaiData = array();

// Jika query berhasil dieksekusi
if ($result) {
    // Ambil data satu per satu dan simpan ke dalam array $pegawaiData
    while ($row = mysqli_fetch_assoc($result)) {
        $pegawaiData[] = $row;
    }
} else {
    echo "Gagal mengambil data dari database.";
}

$juzList = []; // Inisialisasi array juzList
$surahList = []; // Inisialisasi array surahList
$ustadList = []; // Inisialisasi array ustadList


// Ambil data juz
$sql_juz = "SELECT id_juz, juz FROM juz";
$result_juz = mysqli_query($conn, $sql_juz);
while ($row_juz = mysqli_fetch_assoc($result_juz)) {
    $juzList[] = $row_juz;
}

// Ambil data surah
$sql_surah = "SELECT id_surah, nama_surah FROM surah";
$result_surah = mysqli_query($conn, $sql_surah);
while ($row_surah = mysqli_fetch_assoc($result_surah)) {
    $surahList[] = $row_surah;
}

// Ambil data ustad
$sql_ustad = "SELECT id_ustad, nama_ustad FROM ustad";
$result_ustad = mysqli_query($conn, $sql_ustad);
while ($row_ustad = mysqli_fetch_assoc($result_ustad)) {
    $ustadList[] = $row_ustad;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css">
    <link href="css/styles.css" rel="stylesheet">
    <title>eQuran</title>
    <style>
        .table-responsive {
            overflow-x: auto;
        }
        .table td, .table th {
            white-space: nowrap;
            font-size: 0.9rem;
        }
        .table td.catatan-cell {
            white-space: normal;
            word-wrap: break-word;
        }
    </style>
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-4" href="index.php">
            <img src="images1.png" alt="Logo" style="height: 50px; width: auto;">
        </a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Halaman Utama
                        </a>
                        <a class="nav-link" href="tindakan.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Tindakan
                        </a>
                        <a class="nav-link" href="tahsin.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Tahsin
                        </a>
                        <a class="nav-link" href="tahfiz.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Tahfiz
                        </a>
                        <a class="nav-link" href="iqro.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Iqro
                        </a>
                        <a class="nav-link" href="gabungan.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Lainnya
                        </a>
                        <a class="nav-link" href="logout.php">Logout</a>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Halaman Utama</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <!-- Button to Open the Modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                Tambah Data
                            </button>
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple" class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIP</th>
                                        <th>Nama Pegawai</th>
                                        <th>Unit</th>
                                        <th>Status Pegawai</th>
                                        <th>JK</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; foreach ($pegawaiData as $data) : ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= htmlspecialchars($data['nip']); ?></td>
                                        <td><?= htmlspecialchars($data['nama']); ?></td>
                                        <td><?= htmlspecialchars($data['nama_unit']); ?></td>
                                        <td><?= htmlspecialchars($data['stts_jabatan']); ?></td>
                                        <td><?= htmlspecialchars($data['jk']); ?></td>
                                        <td>
                                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit<?= $data['id_pegawai'] ?>">Edit</button>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete<?= $data['id_pegawai'] ?>">Delete</button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!----------------------edit pegawai----------------->

    <?php foreach ($pegawaiData as $data) : ?>
    <div class="modal fade" id="edit<?= $data['id_pegawai'] ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Edit Pegawai</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <form method="post" action="function.php">
                <div class="modal-body">
                    <input type="hidden" name="id_pegawai" value="<?= htmlspecialchars($data['id_pegawai']); ?>">
                    <div class="form-group row">
                        <label for="nip" class="col-sm-4 col-form-label">NIP:</label>
                        <div class="col-sm-8">
                            <input type="text" id="nip" name="nip" value="<?= htmlspecialchars($data['nip']); ?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama" class="col-sm-4 col-form-label">Nama Pegawai:</label>
                        <div class="col-sm-8">
                            <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($data['nama']); ?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="unit" class="col-sm-4 col-form-label">Unit:</label>
                        <div class="col-sm-8">
                            <select id="unit" name="id_unit" class="form-control" required>
                                <?php
                                // Ambil data unit dari database
                                $sql_unit = "SELECT id_unit, nama_unit FROM unit";
                                $result_unit = mysqli_query($conn, $sql_unit);

                                if (mysqli_num_rows($result_unit) > 0) {
                                    while ($row_unit = mysqli_fetch_assoc($result_unit)) {
                                        $selected = ($row_unit['id_unit'] == $data['id_unit']) ? 'selected' : '';
                                        echo '<option value="' . htmlspecialchars($row_unit['id_unit']) . '" ' . $selected . '>' . htmlspecialchars($row_unit['nama_unit']) . '</option>';
                                    }
                                } else {
                                    echo '<option value="">Data unit tidak tersedia</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jabatan" class="col-sm-4 col-form-label">Jabatan:</label>
                        <div class="col-sm-8">
                            <select id="jabatan" name="id_jabatan" class="form-control" required>
                                <?php
                                // Ambil data jabatan dari database
                                $sql_jabatan = "SELECT id_jabatan, stts_jabatan FROM jabatan";
                                $result_jabatan = mysqli_query($conn, $sql_jabatan);

                                if (mysqli_num_rows($result_jabatan) > 0) {
                                    while ($row_jabatan = mysqli_fetch_assoc($result_jabatan)) {
                                        $selected = ($row_jabatan['id_jabatan'] == $data['id_jabatan']) ? 'selected' : '';
                                        echo '<option value="' . htmlspecialchars($row_jabatan['id_jabatan']) . '" ' . $selected . '>' . htmlspecialchars($row_jabatan['stts_jabatan']) . '</option>';
                                    }
                                } else {
                                    echo '<option value="">Data jabatan tidak tersedia</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jk" class="col-sm-4 col-form-label">Jenis Kelamin:</label>
                        <div class="col-sm-8">
                            <input type="text" id="jk" name="jk" value="<?= htmlspecialchars($data['jk']); ?>" class="form-control" required>
                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="update_pegawai">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-------hapus data pegawai-------->
<div class="modal fade" id="delete<?= $data['id_pegawai'] ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete Pegawai</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form method="post" action="function.php">
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus <?= htmlspecialchars($data['nama']); ?>?
                    <input type="hidden" name="id" value="<?= htmlspecialchars($data['id_pegawai']); ?>">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" name="deletepegawai">Delete</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>
                                
                                       
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script>
        function fillPengawas() {
            var ustadSelect = document.getElementById('ustad');
            var selectedOption = ustadSelect.options[ustadSelect.selectedIndex];
            var pengawasInput = document.getElementById('pengawas');
            pengawasInput.value = selectedOption.getAttribute('data-name');
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    function fillPengawas() {
        var ustadSelect = document.getElementById('ustad');
        var selectedOption = ustadSelect.options[ustadSelect.selectedIndex];
        var pengawasInput = document.getElementById('pengawas');
        pengawasInput.value = selectedOption.getAttribute('data-name');
    }
    </script>
    <script>
    $(document).ready(function() {
        $('#datatablesSimple').DataTable();
    });
    </script>

    <!-- The Modal -->
    <body>
    <!-- Modal Tambah Pegawai -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Pegawai</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <form method="post" action="function.php">
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="nip" class="col-sm-4 col-form-label">NIP:</label>
                            <div class="col-sm-8">
                                <input type="text" id="nip" name="nip" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nama" class="col-sm-4 col-form-label">Nama Pegawai:</label>
                            <div class="col-sm-8">
                                <input type="text" id="nama" name="nama" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="unit" class="col-sm-4 col-form-label">Unit:</label>
                            <div class="col-sm-8">
                                <select id="unit" name="unit" class="form-control" required>
                                    <?php
                                    $unitList = mysqli_query($conn, "SELECT * FROM unit");
                                    while ($unit = mysqli_fetch_array($unitList)) {
                                        echo "<option value='" . htmlspecialchars($unit['id_unit']) . "'>" . htmlspecialchars($unit['nama_unit']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="jabatan" class="col-sm-4 col-form-label">Jabatan:</label>
                            <div class="col-sm-8">
                                <select id="jabatan" name="jabatan" class="form-control" required>
                                    <?php
                                    $jabatanList = mysqli_query($conn, "SELECT * FROM jabatan");
                                    while ($jabatan = mysqli_fetch_array($jabatanList)) {
                                        echo "<option value='" . htmlspecialchars($jabatan['id_jabatan']) . "'>" . htmlspecialchars($jabatan['stts_jabatan']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">JK:</label>
                            <div class="col-sm-8">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jk" id="jk_laki" value="Laki-laki" required>
                                    <label class="form-check-label" for="jk_laki">Laki-laki</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jk" id="jk_perempuan" value="Perempuan">
                                    <label class="form-check-label" for="jk_perempuan">Perempuan</label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </body>
</html> 