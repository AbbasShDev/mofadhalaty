<?php
session_start();
$pageTitle = '| التسجيل';

if (isset($_SESSION['user_name'])){
    header('location:app.php');
    die();
}

require_once 'includes/config/database.php';
require_once 'includes/config/app.php';
require_once 'includes/templates/main-header.php';

$errors     = [];
$username   = '';
$email      = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $username       = mysqli_real_escape_string($mysqli, $_POST['username']);
    $email          = mysqli_real_escape_string($mysqli, $_POST['email']);
    $pass           = mysqli_real_escape_string($mysqli, $_POST['pass']);
    $passConform    = mysqli_real_escape_string($mysqli, $_POST['pass_conform']);

    if (empty($username)){array_push($errors, 'يجب ادخال اسم مستخدم');}
    if (empty($email)){array_push($errors, 'يجب ادخال بريد الكتروني');}
    if (empty($pass)){array_push($errors, 'يجب ادخال كلمة سر');}
    if (empty($passConform)){array_push($errors, 'يجب ادخال تأكيد كلمة السر');}
    if (strlen($pass) < 6 ){array_push($errors, 'يجب أن يكون طول كلمة السر على الأقل 6 حروفٍ/حرفًا');}
    if ($passConform != $pass){array_push($errors, 'حقل التأكيد غير مُطابق للحقل كلمة السر');}

    if (!count($errors)){

        $query = "SELECT user_email FROM users WHERE user_email = '$email'";

        $userExist = $mysqli->query($query);

        if ($userExist->num_rows){
            array_push($errors, 'البريد الإلكتروني مسجل');
        }

    }

    if (!count($errors)){

        $passHash =password_hash($pass, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (user_name, user_email, user_password)  VALUES('$username', '$email', '$passHash')";

        $mysqli->query($query);

        $_SESSION['user_name'] = $username;
        $_SESSION['user_id'] = $mysqli->insert_id;
        $_SESSION['notify_message'] = "مرحبا $username ، نتمنا لك وقتاً ممتعاً";

        header('location:app.php');
        die();

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
                            <li class="nav-item mx-auto">
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
        <p class="text-center font-head ">تسجيل حساب جديد</p>

        <form class="sign" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
            <div><input type="text" name="username" class="form-control mb-3" placeholder="اسم العرض (عربي او انجليزي)" required="required" value="<?php echo $username?>" > </div>
            <div><input type="email" name="email" class="form-control mb-3" placeholder="البريد الإلكتروني" required="required" value="<?php echo $email?>" ></div>
            <div><input type="password" name="pass" class="form-control mb-3" autocomplete="new-password" placeholder="كلمة المرور" required="required"></div>
            <div><input type="password" name="pass_conform" class="form-control mb-3" autocomplete="new-password" placeholder="تأكيد كلمة المرور" required="required"></div>
            <input type="submit" class="btn btn-block" name="signup" value="تسجيل">

        </form>

        <p class="pt-3"><a class="font-head" href="login.php">لديك حساب؟ سجل دخول من هنا</a></p>

    </div>
</div>

<?php require_once'includes/templates/main-footer.php'; ?>