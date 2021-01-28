<?php
include('../../controllers/UserFunctions.php');
include ('../../modals/Database.php');
session_start();
unset($_SESSION["token_login"]);
unset($_SESSION["user_id"]);
unset($_COOKIE["token_login"]);
unset($_COOKIE["user_id"]);

if(!isset($_GET["id"]) || !isset($_GET["token_pass"]) || !checkTokenPass($_GET["id"],$_GET["token_pass"])){
    header("location: ./login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Eshop</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../botiga_view/images/favicon.png">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>
<body >
<div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6 p-0">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Canvia la contrasenya!</h1>
                                </div>
                                <form class="user" action="../../controllers/UserController.php" method="post">
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" name="recover_password" placeholder="Contrasenya" value="<?php echo $_SESSION["recover_password"]?>">
                                        <?php if(isset($_SESSION["recover_errors"]) && in_array("error_password_recover",$_SESSION["recover_errors"])):?>
                                            <label class="ml-3 text-danger" style="font-size: 14px;"><i class="fas fa-exclamation-circle mr-1"></i>La contrasenya ha de tenir 5 caràcters com a mínim</label>
                                        <?php endif;?>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" name="recover_password_confirm" placeholder="Repeteix la Contrasenya">
                                        <?php if(isset($_SESSION["recover_errors"]) && in_array("error_password_confirm_recover",$_SESSION["recover_errors"])):?>
                                        <label class="ml-3 text-danger" style="font-size: 14px;"><i class="fas fa-exclamation-circle mr-1"></i>Les contrasenyes no concideixen</label>
                                        <?php endif;?>
                                    </div>
                                    <input type="text" name="recover_id" style="display: none" value="<?php echo $_GET["id"]?>">
                                    <input type="text"  name="recover_token_pass"  style="display: none" value="<?php echo $_GET["token_pass"]?>">

                                    <button type="submit" class="btn btn-primary btn-user btn-block">Canviar contrasenya</button>

                                </form>
                            </div>
                            <div class=" p-0 m-0">
                                <a href="../botiga_view/index.php" class="btn btn-dark btn-user btn-block" style="color: white;background-color: #201F1E;border-radius: 0px;"><i class="fas fa-chevron-left" style="float: left;margin-top: 1%;margin-left: 10px"></i>Tornar a la botiga</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>

</body>

</html>
<?php
unset($_SESSION["recover_password"]);
unset($_SESSION["recover_errors"]);
?>