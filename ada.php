<?php
require 'function.php';
require 'cek.php';

// Fetch Data
$query = "SELECT tahfiz.*, 
                 unit.nama_unit, 
                 surah.nama_surah, 
                 juz.juz,
                 ustad.nama_ustad,
                 pegawai.nip
          FROM tahfiz
          INNER JOIN unit ON tahfiz.id_unit = unit.id_unit
          LEFT JOIN surah ON tahfiz.id_surah = surah.id_surah
          LEFT JOIN juz ON tahfiz.id_juz = juz.id_juz
          LEFT JOIN ustad ON tahfiz.id_ustad = ustad.id_ustad
          LEFT JOIN pegawai ON tahfiz.id_pegawai = pegawai.id_pegawai";

$result = mysqli_query($conn, $query);

$tahfizData = array();

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $tahfizData[] = $row;
    }
} else {
    echo "Gagal mengambil data dari database.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Tahfiz</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-4" href="index.php">
            <img src="images1.png" alt="Logo" style="height: 50px; width: auto;">
        </a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i class="fas fa-bars"></i></button>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Data Pegawai
                        </a>
                        <a class="nav-link" href="tahfiz.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Tahfiz
                        </a>
                        <a class="nav-link" href="tahsin.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Tahsin
                        </a>
                        <a class="nav-link" href="iqro.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Iqro
                        </a>
                        <a class="nav-link" href="gabungan.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Lainnya
                        </a>
                        <a class="nav-link" href="logout.php">
                            logout
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Tahfiz</h1>
                <div class="card mb-4">
                    <div class="card-header">
                        <a href="exporttahfiz.php" class="btn btn-info">Export data</a>
                    </div>
                    <div class="card-body">
                        <form method="post" action="tahfiz.php">
                            <table id="datatablesSimple" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="select_all"></th>
                                        <th>Tanggal</th>
                                        <th>NIP</th>
                                        <th>Nama Pegawai</th>
                                        <th>Unit</th>
                                        <th>Juz</th>
                                        <th>Surah</th>
                                        <th>Awal Ayat</th>
                                        <th>Akhir Ayat</th>
                                        <th>Pengawas</th>
                                        <th>Catatan</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($tahfizData as $data): ?>
                                        <tr>
                                            <td><input type="checkbox" name="selected_ids[]" value="<?= htmlspecialchars($data['id_tahfiz']); ?>"></td>
                                            <td><?php echo htmlspecialchars($data['tanggal']); ?></td>
                                            <td><?php echo htmlspecialchars($data['nip']); ?></td>
                                            <td><?php echo htmlspecialchars($data['nama']); ?></td>
                                            <td><?php echo htmlspecialchars($data['nama_unit']); ?></td>
                                            <td><?php echo htmlspecialchars($data['juz']); ?></td>
                                            <td><?php echo htmlspecialchars($data['nama_surah']); ?></td>
                                            <td><?php echo htmlspecialchars($data['awal_ayat']); ?></td>
                                            <td><?php echo htmlspecialchars($data['akhir_ayat']); ?></td>
                                            <td><?php echo htmlspecialchars($data['nama_ustad']); ?></td>
                                            <td><?php echo htmlspecialchars($data['catatan']); ?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $data['id_tahfiz']; ?>">
                                                    Edit
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-danger" name="delete_tahfiz">Delete Selected</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modals for Edit and Delete -->
    <?php foreach ($tahfizData as $data): ?>
    <div class="modal fade" id="editModal<?= $data['id_tahfiz']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $data['id_tahfiz']; ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel<?= $data['id_tahfiz']; ?>">Edit Data tahfiz</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="tahfiz.php">
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($data['id_tahfiz']); ?>">
                        <div class="form-group row">
                            <label for="tanggal" class="col-sm-4 col-form-label">Tanggal:</label>
                            <div class="col-sm-8">
                                <input type="date" id="tanggal" name="tanggal" value="<?= htmlspecialchars($data['tanggal']); ?>" class="form-control" required>
                            </div>
                        </div><br>
                        <div class="form-group row">
                            <label for="nip" class="col-sm-4 col-form-label">NIP:</label>
                            <div class="col-sm-8">
                                <input type="text" id="nip" name="nip" class="form-control" value="<?= htmlspecialchars($data['nip']); ?>" readonly>
                            </div>
                        </div><br>
                        <div class="form-group row">
                            <label for="nama" class="col-sm-4 col-form-label">Nama Pegawai:</label>
                            <div class="col-sm-8">
                                <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($data['nama']); ?>" class="form-control" required readonly>
                            </div>
                        </div><br>
                        <div class="form-group row">
                            <label for="id_unit" class="col-sm-4 col-form-label">Unit:</label>
                            <div class="col-sm-8">
                                <input type="text" id="id_unit" name="id_unit" class="form-control" value="<?= htmlspecialchars($data['nama_unit']); ?>" readonly>
                            </div>
                        </div><br>
                        <div class="form-group row">
                            <label for="id_juz" class="col-sm-4 col-form-label">Juz:</label>
                            <div class="col-sm-8">
                                <select id="id_juz" name="id_juz" class="form-control" required>
                                    <?php
                                    // Fetch Juz data for the dropdown
                                    $sql_juz = "SELECT * FROM juz";
                                    $result_juz = mysqli_query($conn, $sql_juz);

                                    if ($result_juz) {
                                        while ($row_juz = mysqli_fetch_assoc($result_juz)) {
                                            $selected = ($row_juz['id_juz'] == $data['id_juz']) ? 'selected' : '';
                                            echo '<option value="' . htmlspecialchars($row_juz['id_juz']) . '" ' . $selected . '>' . htmlspecialchars($row_juz['juz']) . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div><br>
                        <div class="form-group row">
                            <label for="id_surah" class="col-sm-4 col-form-label">Surah:</label>
                            <div class="col-sm-8">
                                <select id="id_surah" name="id_surah" class="form-control" required>
                                    <?php
                                    // Fetch Surah data for the dropdown
                                    $sql_surah = "SELECT * FROM surah";
                                    $result_surah = mysqli_query($conn, $sql_surah);

                                    if ($result_surah) {
                                        while ($row_surah = mysqli_fetch_assoc($result_surah)) {
                                            $selected = ($row_surah['id_surah'] == $data['id_surah']) ? 'selected' : '';
                                            echo '<option value="' . htmlspecialchars($row_surah['id_surah']) . '" ' . $selected . '>' . htmlspecialchars($row_surah['nama_surah']) . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div><br>
                        <div class="form-group row">
                            <label for="awal_ayat" class="col-sm-4 col-form-label">Awal Ayat:</label>
                            <div class="col-sm-8">
                                <input type="text" id="awal_ayat" name="awal_ayat" value="<?= htmlspecialchars($data['awal_ayat']); ?>" class="form-control" required>
                            </div>
                        </div><br>
                        <div class="form-group row">
                            <label for="akhir_ayat" class="col-sm-4 col-form-label">Akhir Ayat:</label>
                            <div class="col-sm-8">
                                <input type="text" id="akhir_ayat" name="akhir_ayat" value="<?= htmlspecialchars($data['akhir_ayat']); ?>" class="form-control" required>
                            </div>
                        </div><br>
                        <div class="form-group row">
                            <label for="id_ustad" class="col-sm-4 col-form-label">Pengawas:</label>
                            <div class="col-sm-8">
                                <select id="id_ustad" name="pengawas" class="form-control" required>
                                    <?php
                                    // Fetch Ustad data for the dropdown
                                    $sql_ustad = "SELECT id_ustad, nama_ustad FROM ustad";
                                    $result_ustad = mysqli_query($conn, $sql_ustad);

                                    if ($result_ustad) {
                                        while ($row_ustad = mysqli_fetch_assoc($result_ustad)) {
                                            $selected = ($row_ustad['id_ustad'] == $data['id_ustad']) ? 'selected' : '';
                                            echo '<option value="' . htmlspecialchars($row_ustad['id_ustad']) . '" ' . $selected . '>' . htmlspecialchars($row_ustad['nama_ustad']) . '</option>';
                                        }
                                    } else {
                                        echo '<option value="">Data pengawas tidak tersedia</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div><br>
                        <div class="form-group row">
                            <label for="catatan" class="col-sm-4 col-form-label">Catatan:</label>
                            <div class="col-sm-8">
                                <textarea id="catatan" name="catatan" class="form-control" required><?= htmlspecialchars($data['catatan']); ?></textarea>
                            </div>
                        </div><br>
                        <button type="submit" class="btn btn-primary" name="update_tahfiz">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
        <div class="modal fade" id="deleteModal<?= $data['id_tahfiz']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $data['id_tahfiz']; ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel<?= $data['id_tahfiz']; ?>">Konfirmasi Hapus Data tahfiz</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post" action="tahfiz.php">
                        <div class="modal-body">
                            Apakah Anda yakin ingin menghapus <?= htmlspecialchars($data['nama_pegawai']); ?>?
                            <input type="hidden" name="id" value="<?= htmlspecialchars($data['id_tahfiz']); ?>">
                            <br><br>
                            <button type="submit" class="btn btn-danger" name="delete_tahfiz">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script>
        document.getElementById('select_all').onclick = function() {
            var checkboxes = document.getElementsByName('selected_ids[]');
            for (var checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        }
    </script>
</body>
</html>


<!---------------- hapus keseluruhan ---------------->
    <!--------------------------------------------------->
    <div class="modal fade" id="deleteModal<?= $data['id_tahfiz']; ?>" tabindex="-1" aria-labelledby="DeleteModalLabel<?= $data['id_tahfiz']; ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="DeleteModalLabel<?= $data['id_tahfiz']; ?>">Delete Data tahfiz</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Apakah Anda yakin ingin menghapus data ini?</div>
                <div class="modal-footer">
                    <form method="post" action="tahfiz.php">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($data['id_tahfiz']); ?>">
                        <button type="submit" class="btn btn-danger" name="delete_tahfiz">Delete</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!---------------- hapus satuan ---------------->
    <!---------------------------------------------->
    <div class="modal fade" id="DeleteModal<?= $data['id_tahfiz']; ?>" tabindex="-1" aria-labelledby="DeleteModalLabel<?= $data['id_tahfiz']; ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="DeleteModalLabel<?= $data['id_tahfiz']; ?>">Hapus Data tahfiz</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="tahfiz.php">
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus <?= $data['nama']; ?>?
                    <input type="hidden" name="id" value="<?= $data['id_tahfiz']; ?>">
                </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger" name="deletetahfiz">Hapus</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


---------------------------------------------------------------------------------------------------
---------------------------------------------------------------------------------------------------

    <?php
require 'function.php';
require 'cek.php';

// Query untuk mengambil data dari tabel ustad
$query = "SELECT ustad.*, unit.nama_unit, jabatan.stts_jabatan
          FROM ustad
          INNER JOIN unit ON ustad.id_unit = unit.id_unit
          LEFT JOIN jabatan ON ustad.id_jabatan = jabatan.id_jabatan"; // perbaikan di sini

$result = mysqli_query($conn, $query);

$ustadData = array();
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $ustadData[] = $row;
    }
} else {
    echo "Gagal mengambil data dari database.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Pengawas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        .table-responsive {
            overflow-x: auto;
        }
        .table td, .table th {
            white-space: nowrap;
            font-size: 0.8rem;
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
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i class="fas fa-bars"></i></button>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link" href="index.php"><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>Data Pegawai</a>
                        <a class="nav-link" href="tahfiz.php"><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>Tahfiz</a>
                        <a class="nav-link" href="tahsin.php"><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>Tahsin</a>
                        <a class="nav-link" href="iqro.php"><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>Iqro</a>
                        <a class="nav-link" href="gabungan.php"><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>Lainnya</a>
                        <a class="nav-link" href="logout.php">logout</a>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Pengawas</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <a href="exportiqro.php" class="btn btn-info">Export data</a>
                        </div>
                        <div class="card-body table-responsive">
                            <form method="post" action="ustad.php">
                                <table id="datatablesSimple" class="table table-bordered">
                                    <thead>
                                            <tr>
                                                <th><input type="checkbox" id="select_all"></th>
                                                <th>Tanggal</th>
                                                <th>NIP</th>
                                                <th>Nama</th>
                                                <th>Unit</th>
                                                <th>Jk</th>
                                                <th>Stts Pegawai</th>
                                                <th>Tindakan</th>
                                            </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($ustadData as $data): ?>
                                            <tr>
                                                <td><input type="checkbox" name="selected_ids[]" value="<?= htmlspecialchars($data['id_ustad']); ?>"></td>
                                                <td><?= htmlspecialchars($data['tanggal']); ?></td>
                                                <td><?php echo isset($data['nip']) ? htmlspecialchars($data['nip']) : ''; ?></td>
                                                <td><?php echo isset($data['nama_ustad']) ? htmlspecialchars($data['nama_ustad']) : ''; ?></td>
                                                <td><?php echo isset($data['nama_unit']) ? htmlspecialchars($data['nama_unit']) : ''; ?></td>
                                                <td><?php echo isset($data['jk']) ? htmlspecialchars($data['jk']) : ''; ?></td>
                                                <td><?php echo isset($data['stts_jabatan']) ? htmlspecialchars($data['stts_jabatan']) : ''; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $data['id_ustad']; ?>">Edit</button>
                                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#DeleteModal<?= $data['id_ustad']; ?>">Hapus</button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!------------------------ Edit ------------------------>
    <!------------------------------------------------------>
    <?php foreach ($ustadData as $data): ?>
    <div class="modal fade" id="editModal<?= $data['id_ustad']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $data['id_ustad']; ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel<?= $data['id_ustad']; ?>">Edit Data ustad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="ustad.php">
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($data['id_ustad']); ?>">
                        <div class="form-group row">
                            <label for="tanggal" class="col-sm-4 col-form-label">Tanggal:</label>
                            <div class="col-sm-8">
                                <input type="date" id="tanggal" name="tanggal" value="<?= htmlspecialchars($data['tanggal']); ?>" class="form-control" required>
                            </div>
                        </div><br>
                        <div class="form-group row">
                            <label for="nip" class="col-sm-4 col-form-label">NIP:</label>
                            <div class="col-sm-8">
                                <input type="text" id="nip" name="nip" class="form-control" value="<?= htmlspecialchars($data['nip']); ?>" required>
                            </div>
                        </div><br>
                        <div class="form-group row">
                            <label for="nama_ustad" class="col-sm-4 col-form-label">Nama:</label>
                            <div class="col-sm-8">
                                <input type="text" id="nama_ustad" name="nama_ustad" class="form-control" value="<?= htmlspecialchars($data['nama_ustad']); ?>" required>
                            </div>
                        </div><br> 
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
                        </div><br>
                        <div class="form-group row">
                            <label for="jk" class="col-sm-4 col-form-label">Jenis Kelamin:</label>
                            <div class="col-sm-8">
                                <input type="text" id="jk" name="jk" class="form-control" value="<?= htmlspecialchars($data['jk']); ?>" required>
                            </div>
                        </div><br>
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
                        </div><br>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="submit_ustad">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!------------------------ Hapus satuan ------------------------>
    <!-------------------------------------------------------------->
    <div class="modal fade" id="DeleteModal<?= $data['id_ustad']; ?>" tabindex="-1" aria-labelledby="DeleteModalLabel<?= $data['id_ustad']; ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="DeleteModalLabel<?= $data['id_ustad']; ?>">Hapus Data ustad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Anda yakin ingin menghapus data ini?</div>
                <div class="modal-footer">
                    <form method="post" action="ustad.php">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($data['id_ustad']); ?>">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger" name="delete_ustad">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="js/scripts.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var table = new DataTable('#datatablesSimple', {
                paging: true,
                searching: true
            });
        });

        document.getElementById('select_all').addEventListener('click', function() {
            var checkboxes = document.querySelectorAll('input[type="checkbox"][name="selected_ids[]"]');
            for (var checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        });
    </script>
</body>
</html>
