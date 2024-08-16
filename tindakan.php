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
    <title>Tindakan</title>
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
                            Data Pegawai
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
                    <h1 class="mt-4">Tindakan</h1>
                    <div class="card mb-4">
                        <div class="card-body">
                            <table id="datatablesSimple" class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIP</th>
                                        <th>Nama Pegawai</th>
                                        <th>Unit</th>
                                        <th>JK</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; foreach ($pegawaiData as $data) : ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= htmlspecialchars($data['nip']); ?></td>
                                        <td><?= htmlspecialchars($data['nama']); ?></td>
                                        <td><?= htmlspecialchars($data['nama_unit']); ?></td>
                                        <td><?= htmlspecialchars($data['jk']); ?></td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#Tahsin<?= $data['id_pegawai'] ?>">Tahsin</button>
                                            <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#Tahfiz<?= $data['id_pegawai'] ?>">Tahfiz</button>
                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#Iqro<?= $data['id_pegawai'] ?>">Iqro</button>
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

    <!-- Modal tahsin -->
    <?php foreach ($pegawaiData as $data) : ?>
    <div class="modal fade" id="Tahsin<?= $data['id_pegawai'] ?>" tabindex="-1" role="dialog" aria-labelledby="TahsinLabel<?= $data['id_pegawai'] ?>" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="TahsinLabel<?= $data['id_pegawai'] ?>">Tahsin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Modal Body -->
                <form method="post" action="tahsin.php">
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($data['id_pegawai']); ?>">
                        <div class="form-group row">
                            <label for="tanggal" class="col-sm-4 col-form-label">Tanggal:</label>
                            <div class="col-sm-8">
                                <input type="date" id="tanggal" name="tanggal" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="id_pegawai" class="col-sm-4 col-form-label">id_pegawai:</label>
                            <div class="col-sm-8">
                                <input type="text" id="id_pegawai" name="id_pegawai" value="<?= htmlspecialchars($data['id_pegawai']); ?>" class="form-control" required readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nip" class="col-sm-4 col-form-label">NIP:</label>
                            <div class="col-sm-8">
                                <input type="text" id="nip" name="nip" value="<?= htmlspecialchars($data['nip']); ?>" class="form-control" required readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nama" class="col-sm-4 col-form-label">Nama Pegawai:</label>
                            <div class="col-sm-8">
                                <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($data['nama']); ?>" class="form-control" required readonly>
                            </div>
                        </div> 
                        <div class="form-group row">
                            <label for="id_unit" class="col-sm-4 col-form-label">Unit:</label>
                            <div class="col-sm-8">
                                <select id="id_unit" name="id_unit" class="form-control" required readonly>
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
                            <label for="juz" class="col-sm-4 col-form-label">Juz:</label>
                            <div class="col-sm-8">
                                <select id="juz" name="id_juz" class="form-control" required>
                                    <?php foreach ($juzList as $juz) : ?>
                                    <option value="<?= htmlspecialchars($juz['id_juz']); ?>">
                                        <?= htmlspecialchars($juz['juz']); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="surah" class="col-sm-4 col-form-label">Surah:</label>
                            <div class="col-sm-8">
                                <select id="surah" name="id_surah" class="form-control" required>
                                    <?php foreach ($surahList as $surah) : ?>
                                    <option value="<?= htmlspecialchars($surah['id_surah']); ?>">
                                        <?= htmlspecialchars($surah['nama_surah']); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="awal_ayat" class="col-sm-4 col-form-label">Awal Ayat:</label>
                            <div class="col-sm-8">
                                <input type="text" id="awal_ayat" name="awal_ayat" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="akhir_ayat" class="col-sm-4 col-form-label">Akhir Ayat:</label>
                            <div class="col-sm-8">
                                <input type="text" id="akhir_ayat" name="akhir_ayat" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pengawas" class="col-sm-4 col-form-label">Pengawas:</label>
                            <div class="col-sm-8">
                                <select id="pengawas" name="pengawas" class="form-control" required>
                                    <?php foreach ($ustadList as $ustad) : ?>
                                    <option value="<?= htmlspecialchars($ustad['id_ustad']); ?>">
                                        <?= htmlspecialchars($ustad['nama_ustad']); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="catatan" class="col-sm-4 col-form-label">Catatan:</label>
                            <div class="col-sm-8">
                                <textarea id="catatan" name="catatan" class="form-control" rows="4" required></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="submit_tahsin">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- Modal tahfiz -->
<?php foreach ($pegawaiData as $data) : ?>
    <div class="modal fade" id="Tahfiz<?= $data['id_pegawai'] ?>" tabindex="-1" role="dialog" aria-labelledby="TahfizLabel<?= $data['id_pegawai'] ?>" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="tahfizLabel<?= htmlspecialchars($data['id_pegawai']); ?>">Tahfiz</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Modal Body -->
                <form method="post" action="tahfiz.php">
                    <div class="modal-body">
                        <input type="hidden" name="id_pegawai" value="<?= htmlspecialchars($data['id_pegawai']); ?>">
                        <div class="form-group row">
                            <label for="tanggal" class="col-sm-4 col-form-label">Tanggal:</label>
                            <div class="col-sm-8">
                                <input type="date" id="tanggal" name="tanggal" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="id_pegawai" class="col-sm-4 col-form-label">id_pegawai:</label>
                            <div class="col-sm-8">
                                <input type="text" id="id_pegawai" name="id_pegawai" value="<?= htmlspecialchars($data['id_pegawai']); ?>" class="form-control" required readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nip" class="col-sm-4 col-form-label">NIP:</label>
                            <div class="col-sm-8">
                                <input type="text" id="nip" name="nip" value="<?= htmlspecialchars($data['nip']); ?>" class="form-control" required readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nama" class="col-sm-4 col-form-label">Nama Pegawai:</label>
                            <div class="col-sm-8">
                                <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($data['nama']); ?>" class="form-control" required readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="id_unit" class="col-sm-4 col-form-label">Unit:</label>
                            <div class="col-sm-8">
                                <select id="id_unit" name="id_unit" class="form-control" required readonly>
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
                            <label for="juz" class="col-sm-4 col-form-label">Juz:</label>
                            <div class="col-sm-8">
                                <select id="juz" name="id_juz" class="form-control" required>
                                    <?php foreach ($juzList as $juz) : ?>
                                    <option value="<?= htmlspecialchars($juz['id_juz']); ?>">
                                        <?= htmlspecialchars($juz['juz']); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="surah" class="col-sm-4 col-form-label">Surah:</label>
                            <div class="col-sm-8">
                                <select id="surah" name="id_surah" class="form-control" required>
                                    <?php foreach ($surahList as $surah) : ?>
                                    <option value="<?= htmlspecialchars($surah['id_surah']); ?>">
                                        <?= htmlspecialchars($surah['nama_surah']); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="awal_ayat" class="col-sm-4 col-form-label">Awal Ayat:</label>
                            <div class="col-sm-8">
                                <input type="text" id="awal_ayat" name="awal_ayat" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="akhir_ayat" class="col-sm-4 col-form-label">Akhir Ayat:</label>
                            <div class="col-sm-8">
                                <input type="text" id="akhir_ayat" name="akhir_ayat" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pengawas" class="col-sm-4 col-form-label">Pengawas:</label>
                            <div class="col-sm-8">
                                <select id="pengawas" name="id_ustad" class="form-control" required>
                                    <?php foreach ($ustadList as $ustad) : ?>
                                    <option value="<?= htmlspecialchars($ustad['id_ustad']); ?>">
                                        <?= htmlspecialchars($ustad['nama_ustad']); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="catatan" class="col-sm-4 col-form-label">Catatan:</label>
                            <div class="col-sm-8">
                                <textarea id="catatan" name="catatan" class="form-control" rows="4" required></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="submit_tahfiz">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

    
    <!----------------------tambah iqro----------------->
    
    <?php foreach ($pegawaiData as $data) : ?>
    <!-- Modal Iqro -->
    <div class="modal fade" id="Iqro<?= $data['id_pegawai'] ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Iqro</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <form method="post" action="iqro.php">
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?= $data['id_pegawai']; ?>">
                        <div class="form-group row">
                            <label for="tanggal" class="col-sm-4 col-form-label">Tanggal:</label>
                            <div class="col-sm-8">
                                <input type="date" id="tanggal" name="tanggal" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nip" class="col-sm-4 col-form-label">NIP:</label>
                            <div class="col-sm-8">
                                <input type="text" id="nip" name="nip" value="<?= htmlspecialchars($data['nip']); ?>" class="form-control" required readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nama" class="col-sm-4 col-form-label">Nama Pegawai:</label>
                            <div class="col-sm-8">
                                <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($data['nama']); ?>" class="form-control" required readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="id_pegawai" class="col-sm-4 col-form-label">ID Pegawai:</label>
                            <div class="col-sm-8">
                                <input type="text" id="id_pegawai" name="id_pegawai" value="<?= htmlspecialchars($data['id_pegawai']); ?>" class="form-control" required readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="unit" class="col-sm-4 col-form-label">Unit:</label>
                            <div class="col-sm-8">
                                <select id="unit" name="unit" class="form-control" required readonly>
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
                            <label for="halaman" class="col-sm-4 col-form-label">Halaman:</label>
                            <div class="col-sm-8">
                                <input type="text" id="halaman" name="halaman" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="awal_ayat" class="col-sm-4 col-form-label">Awal Ayat:</label>
                            <div class="col-sm-8">
                                <input type="text" id="awal_ayat" name="awal_ayat" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="akhir_ayat" class="col-sm-4 col-form-label">Akhir Ayat:</label>
                            <div class="col-sm-8">
                                <input type="text" id="akhir_ayat" name="akhir_ayat" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pengawas" class="col-sm-4 col-form-label">Pengawas:</label>
                            <div class="col-sm-8">
                                <select id="pengawas" name="pengawas" class="form-control" required>
                                    <?php foreach ($ustadList as $ustad) : ?>
                                        <option value="<?= htmlspecialchars($ustad['id_ustad']); ?>"><?= htmlspecialchars($ustad['nama_ustad']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="catatan" class="col-sm-4 col-form-label">Catatan:</label>
                            <div class="col-sm-8">
                                <textarea id="catatan" name="catatan" class="form-control" rows="4" required></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="submit_iqro">Simpan</button>
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

</html> 