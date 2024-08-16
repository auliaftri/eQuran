<?php
require 'function.php';

//cek login, terdaftar atau tidak
if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    //mencocokkan dengan database
    $cekdatabase = mysqli_query ($conn, "SELECT * FROM login where email='$email' and password='$password'");

    //hitung data
    $hitung = mysqli_num_rows($cekdatabase);

    if($hitung > 0){
        $_SESSION['log'] = 'True';
        header('location:index.php');
    } else {
        header('location:login.php');
    };
};

if(!isset($_SESSION['log'])){

} else {
    header('location:index.php');
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
        <title>Login</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body style="background-image: url('1-P2044471-scaled.jpg'); background-size: cover;">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="image-container">
                                    <div class="card-header text-center">
                                        <h2 class="text-center font-weight-light my-4">eQur'an</h2>
                                        <h20 class="text-center font-weight-light my-4">Masukkan Email dan Password untuk login EQur'an</h20>
                                </div>
                                <div class="card-body">
                                    <form method="post">
                                            <div class="form-group">
                                                <label class="small mb-1"for="inputEmailAddress">Email</label>
                                                <input class="form-control py-4" name="email" id="inputEmailAddress" type="email" placeholder="Email" />
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputPassword">Password</label>
                                                <input class="form-control" name="password" id="inputPassword" type="password" placeholder="Password" />
                                            </div><div class="d-flex align-items-center justify-content-end mt-4 mb-0">
                                                <button class="btn btn-primary" name="login">Login</button>
                                            </div>
                                        </form>
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
