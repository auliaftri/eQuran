<?php
require 'function.php';
require 'cek.php';

// Inisialisasi variabel tanggal
$start_date = '';
$end_date = '';

// Cek apakah form pencarian tanggal sudah di-submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Query untuk mengambil data dari tabel tahfiz berdasarkan rentang tanggal
    $query = "SELECT tahfiz.*, 
                     unit.nama_unit, 
                     surah.nama_surah, 
                     juz.juz,
                     pegawai.nip,
                     ustad.nama_ustad
              FROM tahfiz
              INNER JOIN unit ON tahfiz.id_unit = unit.id_unit
              LEFT JOIN surah ON tahfiz.id_surah = surah.id_surah
              LEFT JOIN juz ON tahfiz.id_juz = juz.id_juz
              LEFT JOIN pegawai ON tahfiz.id_pegawai = pegawai.id_pegawai
              LEFT JOIN ustad ON tahfiz.id_ustad = ustad.id_ustad
              WHERE tahfiz.tanggal BETWEEN '$start_date' AND '$end_date'";
} else {
    // Query untuk mengambil semua data dari tabel tahfiz
    $query = "SELECT tahfiz.*, 
                     unit.nama_unit, 
                     surah.nama_surah, 
                     juz.juz,
                     pegawai.nip,
                     ustad.nama_ustad
              FROM tahfiz
              INNER JOIN unit ON tahfiz.id_unit = unit.id_unit
              LEFT JOIN surah ON tahfiz.id_surah = surah.id_surah
              LEFT JOIN juz ON tahfiz.id_juz = juz.id_juz
              LEFT JOIN pegawai ON tahfiz.id_pegawai = pegawai.id_pegawai
              LEFT JOIN ustad ON tahfiz.id_ustad = ustad.id_ustad";
}

$result = mysqli_query($conn, $query);

// Inisialisasi array untuk menyimpan data
$tahfizData = array();

// Jika query berhasil dieksekusi
if ($result) {
    // Ambil data satu per satu dan simpan ke dalam array $tahfizData
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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data tahfiz</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
</head>

<body>
<div class="container">
  <h2>Print Data tahfiz</h2>
  <h4>..........</h4>

  <!-- Form untuk pencarian berdasarkan tanggal -->
  <form method="post" action="">
    <div class="form-row align-items-center">
      <div class="col-auto">
        <input type="date" id="start_date" name="start_date" class="form-control mb-2" value="<?= htmlspecialchars($start_date) ?>">
      </div> s/d
      <div class="col-auto">
        <input type="date" id="end_date" name="end_date" class="form-control mb-2" value="<?= htmlspecialchars($end_date) ?>">
      </div>
      <div class="col-auto">
        <button type="submit" class="btn btn-primary mb-2">Cari</button>
      </div>
    </div>
  </form>

  <div class="data-tables datatable-dark">
    <table id="datatablesSimple" class="table table-bordered">
      <thead>
        <tr>
          <th>Tanggal</th>
          <th>NIP</th>
          <th>Nama</th>
          <th>Unit</th>
          <th>Juz</th>
          <th>Surah</th>
          <th>Awal Ayat</th>
          <th>Akhir Ayat</th>
          <th>Pengawas</th>
          <th>Catatan</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($tahfizData as $data): ?>
        <tr>
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
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<script>
$(document).ready(function() {
    $('#datatablesSimple').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf', 'print'
        ]
    });
});
</script>

</body>
</html>
