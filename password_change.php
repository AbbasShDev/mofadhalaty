<?php
session_start();
$pageTitle = 'تغير كلمة المرور';
require_once 'includes/config/database.php';
require_once 'includes/config/app.php';
require_once 'includes/templates/main-header.php';

if (isset($_SESSION['user_name'])){
    header('location:app.php');
    die();
}

if (!isset($_GET['token']) || !$_GET['token']){
    die('رابط تغير كلمة المرور غير صالح');
}

$nowDate = date('Y-m-d H-i-s');

$stat = $mysqli->prepare("SELECT * FROM password_reset WHERE token=? AND expiry_at >'$nowDate'");
$stat->bind_param('s', $token);
$token = $_GET['token'];

$stat->execute();

$result = $stat->get_result();

if (!$result->num_rows){
    die('رابط تغير كلمة المرور غير صالح');
}

$errors     = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $pass           = mysqli_real_escape_string($mysqli, $_POST['pass']);
    $passConform    = mysqli_real_escape_string($mysqli, $_POST['pass_conform']);

    if (empty($pass)){array_push($errors, 'يجب ادخال كلمة سر');}
    if (empty($passConform)){array_push($errors, 'يجب ادخال تأكيد كلمة السر');}
    if (strlen($pass) < 6 ){array_push($errors, 'يجب أن يكون طول كلمة السر على الأقل 6 حروفٍ/حرفًا');}
    if ($passConform != $pass){array_push($errors, 'حقل التأكيد غير مُطابق للحقل كلمة السر');}

    if (!count($errors)){

        $user_id = $result->fetch_assoc()['user_id'];
        $pass_hash = password_hash($pass, PASSWORD_DEFAULT);


        if ($mysqli->query("UPDATE users SET user_password='$pass_hash' WHERE user_id=$user_id")){

            $mysqli->query("DELETE FROM password_reset WHERE user_id='$user_id'");

            $_SESSION['notify_message'] = 'تم تغير كلمة المرور بنجاح';
            header('location: login.php');
            die();
        }

    }

}


?>
    <!-- Start header -->
    <div class="navbar-area" style="background-color: #3f64b5">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand" href="index.php"><img class="logo" src="layout/images/logo-dark.png" alt=""></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="toggler-icon"></span>
                    <span class="toggler-icon"></span>
                    <span class="toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse py-3" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto ">
                        <li class="nav-item mx-auto">
                            <a class="nav-link font-head" href="index.php">ماهو مفضلتي؟</a>
                        </li>
                        <li class="nav-item pr-lg-4 mx-auto">
                            <a class="nav-link font-head " href="index.php">تواصل معنا</a>
                        </li>
                        <li class="nav-item  mx-auto">
                            <a href="login.php"><button class="nav-link btn font-head login-btn">دخول</button></a>
                            <a href="register.php"><button class="nav-link btn btn-success font-head ">تسجيل</button></a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div> <!-- container -->
    </div> <!-- navbar area -->

    <div class="login-register">
        <!-- login-register -->
        <?php include 'includes/config/errorsMessages.php'?>
        <div class="container col-10 col-lg-4 login-page">
            <img class="mx-auto d-block my-3" src="layout/images/logo.png" alt="">
            <p class="text-center font-head ">تغير كيمة المرور</p>

            <form class="sign" action="" method="post">
                <div class="input-container"><input type="password" name="pass" class="form-control mb-3" autocomplete="new-password" placeholder="كلمة المرور الجديدة" required="required"></div>
                <div class="input-container"><input type="password" name="pass_conform" class="form-control mb-3" autocomplete="new-password" placeholder="تأكيد كلمة المرور" required="required"></div>
                <input type="submit" class="btn btn-block" name="submit" value="تغير كلمة المرور">

            </form>

        </div>
    </div>


<?php include_once 'includes/templates/main-footer.php'; ?>