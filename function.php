<?php
// Periksa apakah sesi sudah dimulai, jika belum, maka mulai sesi
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Membuat koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "quran");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}


// Ambil data dari tabel juz
$juzList = [];
$query = "SELECT * FROM juz";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $juzList[] = $row;
    }
} else {
    echo "No juz found";
}

// Ambil data dari tabel jabatan
$jabatanList = [];
$query = "SELECT * FROM jabatan";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $jabatanList[] = $row;
    }
} else {
    echo "No jabatan found";
}

// Ambil data dari tabel unit
$unitList = [];
$query = "SELECT * FROM unit";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $unitList[] = $row;
    }
} else {
    echo "No unit found";
}

// Ambil data dari tabel surah
$surahList = [];
$query = "SELECT * FROM surah";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $surahList[] = $row;
    }
} else {
    echo "No surah found";
}

// Menggunakan fungsi prepared statement untuk mencegah SQL injection
if (!function_exists('insertData')) {
    function insertData($conn, $table, $data) {
        $fields = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), '?'));
        $types = str_repeat("s", count($data)); // Asumsikan semua tipe data adalah string

        $sql = "INSERT INTO $table ($fields) VALUES ($placeholders)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...array_values($data));
        
        return $stmt->execute();
    }
}

//-----------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Pastikan bahwa form mengirimkan data dengan metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form dan pastikan tidak ada kesalahan nama kunci
    $nip = isset($_POST['nip']) ? $_POST['nip'] : '';
    $nama = isset($_POST['nama']) ? $_POST['nama'] : '';
    $jabatan = isset($_POST['jabatan']) ? $_POST['jabatan'] : '';
    $unit = isset($_POST['unit']) ? $_POST['unit'] : '';
    $jk = isset($_POST['jk']) ? $_POST['jk'] : '';

    // Validasi data
    if (!empty($nip) && !empty($nama) && !empty($unit) && !empty($jabatan) && !empty($jk)) {
        // Query untuk memasukkan data ke dalam tabel pegawai
        $sql = "INSERT INTO pegawai (nip, nama, id_unit, id_jabatan, jk) VALUES ('$nip', '$nama', '$unit', '$jabatan', '$jk')";

        if ($conn->query($sql) === TRUE) {
            header('Location: index.php');
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } 
}

    //-----------tambah juz-----------
    if (isset($_POST['submit_juz'])) {
        $data = [
            'juz' => $_POST['juz']
        ];
    
        if (insertData($conn, "juz", $data)) {
            header('Location: juz.php');
            exit;
        } else {
            echo 'Gagal menyimpan data juz: ' . mysqli_error($conn);
        }
    }

    //-----------tambah jabatan-----------
    if (isset($_POST['submit_jabatan'])) {
        $data = [
            'stts_jabatan' => $_POST['stts_jabatan']
        ];
    
        if (insertData($conn, "jabatan", $data)) {
            header('Location: jabatan.php');
            exit;
        } else {
            echo 'Gagal menyimpan data jabatan: ' . mysqli_error($conn);
        }
    }

    //-----------tambah unit-----------
    if (isset($_POST['submit_unit'])) {
        $data = [
            'nama_unit' => $_POST['nama_unit']
        ];
    
        if (insertData($conn, "unit", $data)) {
            header('Location: unit.php');
            exit;
        } else {
            echo 'Gagal menyimpan data unit: ' . mysqli_error($conn);
        }
    }

    //-----------tambah surah-----------
    if (isset($_POST['submit_surah'])) {
        $data = [
            'nama_surah' => $_POST['nama_surah']
        ];
    
        if (insertData($conn, "surah", $data)) {
            header('Location: surah.php');
            exit;
        } else {
            echo 'Gagal menyimpan data surah: ' . mysqli_error($conn);
        }
    }

    //-----------tambah pengawas-----------
    if (isset($_POST['submit_ustad'])) {
        $id = $_POST['id'];
        $tanggal = $_POST['tanggal'];
        $nama_ustad = $_POST['nama_ustad'];
        $nip = $_POST['nip'];
        $id_unit = $_POST['unit']; // Perbaiki ini
        $jk = $_POST['jk'];
        $id_jabatan = $_POST['jabatan']; // Perbaiki ini
    
        if ($id) {
            // Update existing data
            $sql = "UPDATE ustad SET tanggal=?, nama_ustad=?, nip=?, id_unit=?, jk=?, id_jabatan=? WHERE id_ustad=?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sssissi", $tanggal, $nama_ustad, $nip, $id_unit, $jk, $id_jabatan, $id);
        } else {
            // Insert new data
            $sql = "INSERT INTO ustad (tanggal, nama_ustad, nip, id_unit, jk, id_jabatan) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sssiss", $tanggal, $nama_ustad, $nip, $id_unit, $jk, $id_jabatan);
        }
    
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header('Location: pengawas.php');
            exit;
        } else {
            echo 'Gagal menyimpan data ustad: ' . mysqli_error($conn);
        }
    }

    
    //-----------tambah tahsin----------
    if (isset($_POST['submit_tahsin'])) {
        // Ambil data dari $_POST
        $tanggal = $_POST['tanggal'];
        $nama = $_POST['nama'];
        $nip = $_POST['nip'];
        $id_pegawai = $_POST['id_pegawai']; // Pastikan ini sesuai dengan nama kolom id di tabel tahsin
        $id_unit = $_POST['id_unit']; // Ambil id_unit dari form
        $id_juz = $_POST['id_juz']; // Pastikan nama input juz sesuai dengan form Anda
        $id_surah = $_POST['id_surah']; // Pastikan nama input surah sesuai dengan form Anda
        $awal_ayat = $_POST['awal_ayat'];
        $akhir_ayat = $_POST['akhir_ayat'];
        $id_ustad = $_POST['pengawas']; // Ambil id_ustad dari form
        $catatan = $_POST['catatan'];

        // Insert data ke dalam tabel tahsin
        $sql = "INSERT INTO tahsin (tanggal, nama, nip, id_pegawai, id_unit, id_juz, id_surah, awal_ayat, akhir_ayat, id_ustad, catatan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssiiiiiiss", $tanggal, $nama, $nip, $id_pegawai, $id_unit, $id_juz, $id_surah, $awal_ayat, $akhir_ayat, $id_ustad, $catatan);
        
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header('Location: tahsin.php');
            exit;
        } else {
            echo 'Gagal menyimpan data tahsin: ' . mysqli_error($conn);
        }
    }

    //-----------tambah tahfiz----------
    if (isset($_POST['submit_tahfiz'])) {
        // Ambil data dari $_POST
        $tanggal = $_POST['tanggal'];
        $nama = $_POST['nama'];
        $nip = $_POST['nip'];
        $id_pegawai = $_POST['id_pegawai']; // Pastikan ini sesuai dengan nama kolom id di tabel tahfiz
        $id_unit = $_POST['id_unit']; // Ambil id_unit dari form
        $id_juz = $_POST['id_juz']; // Pastikan nama input juz sesuai dengan form Anda
        $id_surah = $_POST['id_surah']; // Pastikan nama input surah sesuai dengan form Anda
        $awal_ayat = $_POST['awal_ayat'];
        $akhir_ayat = $_POST['akhir_ayat'];
        $id_ustad = $_POST['id_ustad']; // Ambil id_ustad dari form
        $catatan = $_POST['catatan'];
    
        // Insert data ke dalam tabel tahfiz
        $sql = "INSERT INTO tahfiz (tanggal, nama, nip, id_pegawai, id_unit, id_juz, id_surah, awal_ayat, akhir_ayat, id_ustad, catatan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssiiiiiiss", $tanggal, $nama, $nip, $id_pegawai, $id_unit, $id_juz, $id_surah, $awal_ayat, $akhir_ayat, $id_ustad, $catatan);
        
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header('Location: tahfiz.php');
            exit;
        } else {
            echo 'Gagal menyimpan data tahfiz: ' . mysqli_error($conn);
        }
    }

    

    //-----------tambah iqro-----------
    
    if (isset($_POST['submit_iqro'])) {
        // Ambil data dari $_POST
        $tanggal = $_POST['tanggal'];
        $nip = $_POST['nip'];
        $nama = $_POST['nama'];
        $id_pegawai = $_POST['id']; // Pastikan ini sesuai dengan nama kolom id di tabel iqro
        $id_unit = $_POST['unit']; // Ambil id_unit dari form
        $halaman = $_POST['halaman'];
        $awal_ayat = $_POST['awal_ayat'];
        $akhir_ayat = $_POST['akhir_ayat'];
        $id_ustad = $_POST['pengawas']; // Ambil id_ustad dari form
        $catatan = $_POST['catatan'];
    
        // Buat array data untuk disimpan
        $data = [
            'tanggal' => $tanggal,
            'nip' => $nip,
            'nama' => $nama,
            'id_pegawai' => $id_pegawai,
            'id_unit' => $id_unit,
            'halaman' => $halaman,
            'awal_ayat' => $awal_ayat,
            'akhir_ayat' => $akhir_ayat,
            'id_ustad' => $id_ustad,
            'catatan' => $catatan
        ];
    
        // Insert data ke dalam tabel iqro
        $sql = "INSERT INTO iqro (tanggal, nip, nama, id_pegawai, id_unit, halaman, awal_ayat, akhir_ayat, id_ustad, catatan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssisssiss", $tanggal, $nip, $nama, $id_pegawai, $id_unit, $halaman, $awal_ayat, $akhir_ayat, $id_ustad, $catatan);
        
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header('Location: iqro.php');
            exit;
        } else {
            echo 'Gagal menyimpan data iqro: ' . mysqli_error($conn);
        }
    }
    
    
    //-----------tambah pegawai-----------
    if (isset($_POST['submit_pegawai'])) {
        $id = $_POST['id'];
        $data = [
            'nip' => $_POST['nip'],
            'nama' => $_POST['nama'],
            'unit' => $_POST['unit'],
            'jk' => $_POST['jk'],
            'id_pegawai' => $_POST['id_pegawai']
        ];

        $sql = "UPDATE pegawai SET nip=?, nama=?, unit=?, jk=?, id_pegawai=? WHERE id_pegawai=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $data['nip'], $data['nama'], $data['unit'], $data['jk'], $data['id_pegawai'], $id);

        if ($stmt->execute()) {
            header('Location: index.php');
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }

        $stmt->close();
    }

//-----------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------

    // -----------edit juz-----------
    if (isset($_POST['update_juz'])) {
        $id = $_POST['id'];
        $juz = $_POST['juz'];

        $sql = "UPDATE juz SET juz=? WHERE id_juz=?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            echo "Error preparing statement: " . $conn->error;
        } else {
            $stmt->bind_param("si", $juz, $id);

            if ($stmt->execute()) {
                header('Location: juz.php');
                exit();
            } else {
                echo "Error updating record: " . $stmt->error;
            }

            $stmt->close();
        }
    }

    // -----------edit jabatan-----------
    if (isset($_POST['update_jabatan'])) {
        $id = $_POST['id'];
        $stts_jabatan = $_POST['stts_jabatan'];

        $sql = "UPDATE jabatan SET stts_jabatan=? WHERE id_jabatan=?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            echo "Error preparing statement: " . $conn->error;
        } else {
            $stmt->bind_param("si", $stts_jabatan, $id);

            if ($stmt->execute()) {
                header('Location: jabatan.php');
                exit();
            } else {
                echo "Error updating record: " . $stmt->error;
            }

            $stmt->close();
        }
    }

    // -----------edit unit-----------
    if (isset($_POST['update_unit'])) {
        $id = $_POST['id'];
        $nama_unit = $_POST['nama_unit'];

        $sql = "UPDATE unit SET nama_unit=? WHERE id_unit=?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            echo "Error preparing statement: " . $conn->error;
        } else {
            $stmt->bind_param("si", $nama_unit, $id);

            if ($stmt->execute()) {
                header('Location: unit.php');
                exit();
            } else {
                echo "Error updating record: " . $stmt->error;
            }

            $stmt->close();
        }
    }

    // -----------edit surah-----------
    if (isset($_POST['update_surah'])) {
        $id = $_POST['id'];
        $nama_surah = $_POST['nama_surah'];

        $sql = "UPDATE surah SET nama_surah=? WHERE id_surah=?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            echo "Error preparing statement: " . $conn->error;
        } else {
            $stmt->bind_param("si", $nama_surah, $id);

            if ($stmt->execute()) {
                header('Location: surah.php');
                exit();
            } else {
                echo "Error updating record: " . $stmt->error;
            }

            $stmt->close();
        }
    }

//-----------edit tahsin-----------
if (isset($_POST['update_tahsin'])) {
    $id = $_POST['id'];
    $tanggal = $_POST['tanggal'];
    $id_pegawai = $_POST['id_pegawai'];
    $nip = $_POST['nip'];
    $nama = $_POST['nama'];
    $id_unit = $_POST['id_unit'];
    $id_juz = $_POST['id_juz'];
    $id_surah = $_POST['id_surah'];
    $awal_ayat = $_POST['awal_ayat'];
    $akhir_ayat = $_POST['akhir_ayat'];
    $id_ustad = $_POST['pengawas'];
    $catatan = $_POST['catatan'];

    // Update data ke dalam tabel tahsin
    
    $sql = "UPDATE tahsin SET tanggal=?, id_pegawai=?, nip=?, nama=?, id_unit=?, id_juz=?, id_surah=?, awal_ayat=?, akhir_ayat=?, id_ustad=?, catatan=? WHERE id_tahsin=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssi", $tanggal, $id_pegawai, $nip, $nama, $id_unit, $id_juz, $id_surah, $awal_ayat, $akhir_ayat, $id_ustad, $catatan, $id);

    if ($stmt->execute()) {
        header('Location: tahsin.php');
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
   

    //-----------edit iqro-----------
    if (isset($_POST['update_iqro'])) {
        $id = $_POST['id'];
        $tanggal = $_POST['tanggal'];
        $id_pegawai = $_POST['id_pegawai'];
        $nip = $_POST['nip'];
        $id_pegawai = $_POST['id_pegawai'];
        $id_unit = $_POST['id_unit'];
        $halaman = $_POST['halaman'];
        $awal_ayat = $_POST['awal_ayat'];
        $akhir_ayat = $_POST['akhir_ayat'];
        $pengawas = $_POST['pengawas'];
        $catatan = $_POST['catatan'];
    
        $sql = "UPDATE iqro SET tanggal=?, id_pegawai=?, nip=?, id_pegawai=?, id_unit=?, halaman=?, awal_ayat=?, akhir_ayat=?, id_ustad=?, catatan=? WHERE id_iqro=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssssi", $tanggal, $id_pegawai, $nip, $id_pegawai, $id_unit, $halaman, $awal_ayat, $akhir_ayat, $pengawas, $catatan, $id);
    
        if ($stmt->execute()) {
            header('Location: iqro.php');
            exit;
        } else {
            echo "Error updating record: " . $conn->error;
        }
    
        $stmt->close();
    }

    //-----------edit tahfiz-----------
    if (isset($_POST['update_tahfiz'])) {
        $id = $_POST['id'];
        $tanggal = $_POST['tanggal'];
        $id_pegawai = $_POST['id_pegawai'];
        $nip = $_POST['nip'];
        $nama = $_POST['nama'];
        $id_unit = $_POST['id_unit'];
        $id_juz = $_POST['id_juz'];
        $id_surah = $_POST['id_surah'];
        $awal_ayat = $_POST['awal_ayat'];
        $akhir_ayat = $_POST['akhir_ayat'];
        $id_ustad = $_POST['pengawas'];
        $catatan = $_POST['catatan'];

        $sql = "UPDATE tahfiz SET tanggal=?, id_pegawai=?, nip=?, nama=?, id_unit=?, id_juz=?, id_surah=?, awal_ayat=?, akhir_ayat=?, id_ustad=?, catatan=? WHERE id_tahfiz=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sisssiiiissi", $tanggal, $id_pegawai, $nip, $nama, $id_unit, $id_juz, $id_surah, $awal_ayat, $akhir_ayat, $id_ustad, $catatan, $id);
    
        if ($stmt->execute()) {
            header('Location: tahfiz.php');
            exit;
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }

    //-----------edit ustad-----------
    if (isset($_POST['update_pengawas'])) {
        $id = $_POST['id'];
        $data = [
            'tanggal' => $_POST['tanggal'],
            'nip' => $_POST['nip'],
            'nama_ustad' => $_POST['nama_ustad'],
            'id_unit' => $_POST['id_unit'],
            'jk' => $_POST['jk'],
            'id_jabatan' => $_POST['id_jabatan']
        ];

        $sql = "UPDATE ustad SET tanggal=?, nip=?, nama_ustad=?, id_unit=?, jk=?, id_jabatan=? WHERE id_ustad=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssi", $data['tanggal'], $data['nip'], $data['nama_ustad'], $data['id_unit'], $data['jk'], $data['id_jabatan'], $id);

        if ($stmt->execute()) {
            header('Location: pengawas.php');
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }

        $stmt->close();
    }

/// ----------- edit pegawai -----------
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_pegawai'])) {
    // Sambungkan ke database
    include 'koneksi.php';

    // Ambil data dari form
    $id = $_POST['id_pegawai'];
    $nip = $_POST['nip'];
    $nama = $_POST['nama'];
    $id_unit = $_POST['id_unit'];
    $id_jabatan = $_POST['id_jabatan'];
    $jk = $_POST['jk'];

    // Validasi data
    if (!empty($nip) && !empty($nama) && !empty($id_unit) && !empty($id_jabatan) && !empty($jk)) {
        // Query untuk update data pegawai
        $sql = "UPDATE pegawai SET nip=?, nama=?, id_unit=?, id_jabatan=?, jk=? WHERE id_pegawai=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $nip, $nama, $id_unit, $id_jabatan, $jk, $id);

        // Eksekusi statement
        if ($stmt->execute()) {
            // Redirect kembali ke halaman index.php setelah update berhasil
            header('Location: index.php');
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "Lengkapi semua data.";
    }
}




//-----------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------

    // -----------hapus jabatan-----------
    if (isset($_POST['delete_jabatan'])) {
        $id = $_POST['id'];
        $sql = "DELETE FROM jabatan WHERE id_jabatan=?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            echo "Error preparing statement: " . $conn->error;
        } else {
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                header('Location: jabatan.php');
                exit();
            } else {
                echo 'Gagal menghapus data jabatan: ' . $stmt->error;
            }

            $stmt->close();
        }
    }

    // -----------hapus unit-----------
    if (isset($_POST['delete_unit'])) {
        $id = $_POST['id'];
        $sql = "DELETE FROM unit WHERE id_unit=?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            echo "Error preparing statement: " . $conn->error;
        } else {
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                header('Location: unit.php');
                exit();
            } else {
                echo 'Gagal menghapus data unit: ' . $stmt->error;
            }

            $stmt->close();
        }
    }

    // -----------hapus surah-----------
    if (isset($_POST['delete_surah'])) {
        $id = $_POST['id'];
        $sql = "DELETE FROM surah WHERE id_surah=?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            echo "Error preparing statement: " . $conn->error;
        } else {
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                header('Location: surah.php');
                exit();
            } else {
                echo 'Gagal menghapus data surah: ' . $stmt->error;
            }

            $stmt->close();
        }
    }

    //-----------hapus pegawai-----------
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deletepegawai'])) {
        // Sambungkan ke database
        include 'koneksi.php';
    
        // Ambil ID dari form
        $id = $_POST['id'];
    
        // Query untuk delete data pegawai
        $sql = "DELETE FROM pegawai WHERE id_pegawai=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
    
        // Eksekusi statement
        if ($stmt->execute()) {
            // Redirect kembali ke halaman index.php setelah delete berhasil
            header('Location: index.php');
            exit();
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    
        $stmt->close();
    }
    

    //-----------hapus tahsin-----------
    if (isset($_POST['delete_tahsin'])) {
        $ids_to_delete = $_POST['selected_ids'];
        if (!empty($ids_to_delete)) {
            $ids_to_delete_str = implode(",", array_map('intval', $ids_to_delete));
            $delete_query = "DELETE FROM tahsin WHERE id_tahsin IN ($ids_to_delete_str)";
            if (mysqli_query($conn, $delete_query)) {
                header('Location: tahsin.php');
                exit;
            } else {
                echo 'Gagal menghapus data tahsin: ' . mysqli_error($conn);
            }
        }
    }

    //---------------- hapus satuan tahsin ---------------->
    //-----------------------------------  ---------------->
    if (isset($_POST['deletetahsin'])) {
        $id = $_POST['id'];
        $delete = mysqli_query($conn, "DELETE FROM tahsin WHERE id_tahsin='$id'");

        if ($delete) {
            header('Location: tahsin.php');
            exit;
        } else {
            echo 'Gagal menghapus data tahsin: ' . mysqli_error($conn);
        }
    }

    //-----------hapus tahfiz-----------
    if (isset($_POST['delete_tahfiz'])) {
        $ids_to_delete = $_POST['selected_ids'];
        if (!empty($ids_to_delete)) {
            $ids_to_delete_str = implode(",", array_map('intval', $ids_to_delete));
            $delete_query = "DELETE FROM tahfiz WHERE id_tahfiz IN ($ids_to_delete_str)";
            if (mysqli_query($conn, $delete_query)) {
                header('Location: tahfiz.php');
                exit;
            } else {
                echo 'Gagal menghapus data tahfiz: ' . mysqli_error($conn);
            }
        }
    }
    //---------------- hapus satuan tahfiz ---------------->
    //-----------------------------------  ---------------->
    if (isset($_POST['deletetahfiz'])) {
        $id = $_POST['id'];
        $delete = mysqli_query($conn, "DELETE FROM tahfiz WHERE id_tahfiz='$id'");

        if ($delete) {
            header('Location: tahfiz.php');
            exit;
        } else {
            echo 'Gagal menghapus data tahfiz: ' . mysqli_error($conn);
        }
    }
    
    //-----------hapus iqro-----------
    if (isset($_POST['delete_iqro'])) {
        $ids_to_delete = $_POST['selected_ids'];
        if (!empty($ids_to_delete)) {
            $ids_to_delete_str = implode(",", array_map('intval', $ids_to_delete));
            $delete_query = "DELETE FROM iqro WHERE id_iqro IN ($ids_to_delete_str)";
            if (mysqli_query($conn, $delete_query)) {
                header('Location: iqro.php');
                exit;
            } else {
                echo 'Gagal menghapus data iqro: ' . mysqli_error($conn);
            }
        }
    }
    //---------------- hapus satuan iqro ---------------->
    //-----------------------------------  ---------------->
    if (isset($_POST['deleteiqro'])) {
        $id = $_POST['id'];
        $delete = mysqli_query($conn, "DELETE FROM iqro WHERE id_iqro='$id'");

        if ($delete) {
            header('Location: iqro.php');
            exit;
        } else {
            echo 'Gagal menghapus data iqro: ' . mysqli_error($conn);
        }
    }

    //-----------hapus pengawas-----------
    if (isset($_POST['delete_pengawas'])) {
        $id = $_POST['id'];
        $delete = mysqli_query($conn, "DELETE FROM ustad WHERE id_ustad='$id'");

        if ($delete) {
            header('Location: pengawas.php');
            exit;
        } else {
            echo 'Gagal menghapus data pengawas: ' . mysqli_error($conn);
        }
    }  

?>
