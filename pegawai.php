<?php
require 'function.php';
require 'cek.php';

$tahsinData = [];
$tahfizData = [];
$iqroData = [];

if (isset($_POST['search'])) {
    $nip = mysqli_real_escape_string($conn, $_POST['nip']);

    // Query untuk mencari data di tabel tahsin
    $query_tahsin = "SELECT * FROM tahsin WHERE nip = '$nip'";
    $result_tahsin = mysqli_query($conn, $query_tahsin);
    while ($row = mysqli_fetch_assoc($result_tahsin)) {
        $tahsinData[] = $row;
    }

    // Query untuk mencari data di tabel tahfiz
    $query_tahfiz = "SELECT * FROM tahfiz WHERE nip = '$nip'";
    $result_tahfiz = mysqli_query($conn, $query_tahfiz);
    while ($row = mysqli_fetch_assoc($result_tahfiz)) {
        $tahfizData[] = $row;
    }

    // Query untuk mencari data di tabel iqro
    $query_iqro = "SELECT * FROM iqro WHERE nip = '$nip'";
    $result_iqro = mysqli_query($conn, $query_iqro);
    while ($row = mysqli_fetch_assoc($result_iqro)) {
        $iqroData[] = $row;
    }
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
    <title>Pencarian NIP</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        .result-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .result-table th, .result-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .result-table th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body style="background-image: url('1-P2044471-scaled.jpg'); background-size: cover;">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
            <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="card shadow-lg border-0 rounded-lg mt-5 bg-white"> <!-- Added bg-white class -->
                                <div class="card-header text-center">
                                    <h2 class="text-center font-weight-light my-4">EQur'an</h2>
                                    <h10 class="text-center font-weight-light my-4">Masukkan NIP untuk melihat data EQur'an</h10>
                                </div>
                                <div class="card-body">
                                    <?php
                                    if (!empty($tahsinData) || !empty($tahfizData) || !empty($iqroData)) {
                                        echo '<div class="alert alert-success">Data ditemukan!</div>';
                                    } elseif (isset($_POST['search'])) {
                                        echo '<div class="alert alert-danger">Data tidak ditemukan.</div>';
                                    }
                                    ?>
                                    <form method="post" action="">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputNip">NIP</label>
                                            <input class="form-control py-4" name="nip" id="inputNip" type="text" placeholder="Masukkan NIP" required />
                                        </div>
                                        <div class="d-flex align-items-center justify-content-end mt-4 mb-0">
                                            <button class="btn btn-primary" name="search">Cari</button>
                                        </div>
                                    </form>

                                    <!-- Tabel Tahsin -->
                                    <?php if (!empty($tahsinData)): ?>
                                    <table class="result-table">
                                        <thead>
                                            <tr>
                                                <th>Tabel</th>
                                                <th>Tanggal</th>
                                                <th>NIP</th>
                                                <th>Juz</th>
                                                <th>Surah</th>
                                                <th>Awal Ayat</th>
                                                <th>Akhir Ayat</th>
                                                <th>Catatan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($tahsinData as $data): ?>
                                            <tr>
                                                <td>Tahsin</td>
                                                <td><?= htmlspecialchars($data['tanggal']); ?></td>
                                                <td><?= htmlspecialchars($data['nip']); ?></td>
                                                <td><?= htmlspecialchars($data['id_juz']); ?></td>
                                                <td><?= htmlspecialchars($data['id_surah']); ?></td>
                                                <td><?= htmlspecialchars($data['awal_ayat']); ?></td>
                                                <td><?= htmlspecialchars($data['akhir_ayat']); ?></td>
                                                <td><?= htmlspecialchars($data['catatan']); ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <?php endif; ?>

                                    <!-- Tabel Tahfiz -->
                                    <?php if (!empty($tahfizData)): ?>
                                    <table class="result-table">
                                        <thead>
                                            <tr>
                                                <th>Tabel</th>
                                                <th>Tanggal</th>
                                                <th>NIP</th>
                                                <th>Juz</th>
                                                <th>Surah</th>
                                                <th>Awal Ayat</th>
                                                <th>Akhir Ayat</th>
                                                <th>Catatan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($tahfizData as $data): ?>
                                            <tr>
                                                <td>Tahfiz</td>
                                                <td><?= htmlspecialchars($data['tanggal']); ?></td>
                                                <td><?= htmlspecialchars($data['nip']); ?></td>
                                                <td><?= htmlspecialchars($data['id_juz']); ?></td>
                                                <td><?= htmlspecialchars($data['id_surah']); ?></td>
                                                <td><?= htmlspecialchars($data['awal_ayat']); ?></td>
                                                <td><?= htmlspecialchars($data['akhir_ayat']); ?></td>
                                                <td><?= htmlspecialchars($data['catatan']); ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <?php endif; ?>

                                    <!-- Tabel Iqro -->
                                    <?php if (!empty($iqroData)): ?>
                                    <table class="result-table">
                                        <thead>
                                            <tr>
                                                <th>Tabel</th>
                                                <th>Tanggal</th>
                                                <th>NIP</th>
                                                <th>Halaman</th>
                                                <th>Awal Ayat</th>
                                                <th>Akhir Ayat</th>
                                                <th>Catatan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($iqroData as $data): ?>
                                            <tr>
                                                <td>Iqro</td>
                                                <td><?= htmlspecialchars($data['tanggal']); ?></td>
                                                <td><?= htmlspecialchars($data['nip']); ?></td>
                                                <td><?= htmlspecialchars($data['halaman']); ?></td>
                                                <td><?= htmlspecialchars($data['awal_ayat']); ?></td>
                                                <td><?= htmlspecialchars($data['akhir_ayat']); ?></td>
                                                <td><?= htmlspecialchars($data['catatan']); ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>
</html>
