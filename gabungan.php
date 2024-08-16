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
        .btn-large {
            width: 45%;
            height: 100px;
            font-size: 30px;
            margin: 5px;
        }

        .btn-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            height: 50vh;
        }

        .btn-group {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: center;
            width: 100%;
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-4" href="index.php">
            <img src="images1.png" alt="Logo" style="height: 50px; width: auto; margin-center: 0px;">
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
                    <h1 class="mt-4 text-center">Data Lainnya</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <!-- Buttons to Open the Modals -->
                            <div class="btn-container">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-secondary btn-large" data-toggle="modal" data-target="#myModalUnit" onclick="window.location.href='unit.php';">
                                        Unit
                                    </button>
                                    <button type="button" class="btn btn-warning btn-large" data-toggle="modal" data-target="#myModalUnit" onclick="window.location.href='jabatan.php';">
                                        Jabatan
                                    </button>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success btn-large" data-toggle="modal" data-target="#myModalUnit" onclick="window.location.href='surah.php';">
                                        Surah
                                    </button>
                                    <button type="button" class="btn btn-info btn-large" data-toggle="modal" data-target="#myModalUnit" onclick="window.location.href='juz.php';">
                                        Juz
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>


    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script>
        $(document).ready(function() {
            $('#datatablesSimple').DataTable();
        });
    </script>
</body>


</html>
