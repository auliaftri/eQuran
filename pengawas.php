<?php
require 'function.php';
require 'cek.php';

// Query untuk mengambil data dari tabel ustad
$query = "SELECT ustad.*, unit.nama_unit, jabatan.stts_jabatan
          FROM ustad
          INNER JOIN unit ON ustad.id_unit = unit.id_unit
          LEFT JOIN jabatan ON ustad.id_jabatan = jabatan.id_jabatan";

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
                        <a class="nav-link" href="tindakan.php"><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>Tindakan</a>
                        <a class="nav-link" href="tahsin.php"><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>Tahsin</a>
                        <a class="nav-link" href="tahfiz.php"><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>Tahfiz</a>
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
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                Tambah Pengawas
                            </button>
                        <div class="card-body table-responsive">
                            <form method="post" action="pengawas.php">
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
                                                <td><?= htmlspecialchars($data['nip']); ?></td>
                                                <td><?= htmlspecialchars($data['nama_ustad']); ?></td>
                                                <td><?= htmlspecialchars($data['nama_unit']); ?></td>
                                                <td><?= htmlspecialchars($data['jk']); ?></td>
                                                <td><?= htmlspecialchars($data['stts_jabatan']); ?></td>
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
                <form method="post" action="pengawas.php">
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($data['id_ustad']); ?>">
                        <div class="form-group row">
                            <label for="tanggal" class="col-sm-4 col-form-label">Tanggal:</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="tanggal" value="<?= htmlspecialchars($data['tanggal']); ?>" required>
                            </div>
                        </div><br>
                        <div class="form-group row">
                            <label for="nama_ustad" class="col-sm-4 col-form-label">Nama:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="nama_ustad" value="<?= htmlspecialchars($data['nama_ustad']); ?>" required>
                            </div>
                        </div><br>
                        <div class="form-group row">
                            <label for="nip" class="col-sm-4 col-form-label">NIP:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="nip" value="<?= htmlspecialchars($data['nip']); ?>" required>
                            </div>
                        </div><br>
                        <div class="form-group row">
                            <label for="unit" class="col-sm-4 col-form-label">Unit:</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="unit" required>
                                    <?php
                                    $query = "SELECT * FROM unit";
                                    $result = mysqli_query($conn, $query);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $selected = ($row['id_unit'] == $data['id_unit']) ? 'selected' : '';
                                        echo "<option value='" . htmlspecialchars($row['id_unit']) . "' $selected>" . htmlspecialchars($row['nama_unit']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div><br>
                        <div class="form-group row">
                            <label for="jk" class="col-sm-4 col-form-label">Jenis Kelamin:</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="jk" required>
                                    <option value="Laki-laki" <?= ($data['jk'] == 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
                                    <option value="Perempuan" <?= ($data['jk'] == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                                </select>
                            </div>
                        </div><br>
                        <div class="form-group row">
                            <label for="jabatan" class="col-sm-4 col-form-label">Status Jabatan:</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="jabatan" required>
                                    <?php
                                    $query = "SELECT * FROM jabatan";
                                    $result = mysqli_query($conn, $query);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $selected = ($row['id_jabatan'] == $data['id_jabatan']) ? 'selected' : '';
                                        echo "<option value='" . htmlspecialchars($row['id_jabatan']) . "' $selected>" . htmlspecialchars($row['stts_jabatan']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="submit_ustad">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <!------------------------ Add ------------------------>
    <!------------------------------------------------------>
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Ustad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div><br>
                <form method="post" action="pengawas.php">
                    <div class="modal-body">
                        <input type="hidden" name="id">
                        <div class="form-group row">
                            <label for="tanggal" class="col-sm-4 col-form-label">Tanggal:</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="tanggal" required>
                            </div>
                        </div><br>
                        <div class="form-group row">
                            <label for="nip" class="col-sm-4 col-form-label">NIP:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="nip" required>
                            </div>
                        </div><br>
                        <div class="form-group row">
                            <label for="nama_ustad" class="col-sm-4 col-form-label">Nama:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="nama_ustad" required>
                            </div>
                        </div><br>
                        <div class="form-group row">
                            <label for="unit" class="col-sm-4 col-form-label">Unit:</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="unit" required>
                                    <?php
                                    $query = "SELECT * FROM unit";
                                    $result = mysqli_query($conn, $query);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<option value='" . htmlspecialchars($row['id_unit']) . "'>" . htmlspecialchars($row['nama_unit']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div><br>
                        <div class="form-group row">
                            <label for="jk" class="col-sm-4 col-form-label">Jenis Kelamin:</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="jk" required>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div><br>
                        <div class="form-group row">
                            <label for="jabatan" class="col-sm-4 col-form-label">Status Jabatan:</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="jabatan" required>
                                    <?php
                                    $query = "SELECT * FROM jabatan";
                                    $result = mysqli_query($conn, $query);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<option value='" . htmlspecialchars($row['id_jabatan']) . "'>" . htmlspecialchars($row['stts_jabatan']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="submit_ustad">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!------------------------ Delete ------------------------>
    <!------------------------------------------------------>
    <?php foreach ($ustadData as $data): ?>
    <div class="modal fade" id="DeleteModal<?= $data['id_ustad']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $data['id_ustad']; ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel<?= $data['id_ustad']; ?>">Hapus Data ustad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="pengawas.php">
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($data['id_ustad']); ?>">
                        <p>Anda yakin ingin menghapus data ini?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger" name="delete_pengawas">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>
</html>
