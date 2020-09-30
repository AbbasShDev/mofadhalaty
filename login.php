<?php
session_start();
$pageTitle = '| تسجيل الدخول';

if (isset($_SESSION['user_name'])){
    header('location:app.php');
    die();
}

require_once 'includes/config/database.php';
require_once 'includes/config/app.php';
require_once 'includes/templates/main-header.php';

$errors     = [];
$email      = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $email          = mysqli_real_escape_string($mysqli, $_POST['email']);
    $pass           = mysqli_real_escape_string($mysqli, $_POST['pass']);

    if (empty($email)){array_push($errors, 'يجب ادخال بريد الكتروني');}
    if (empty($pass)){array_push($errors, 'يجب ادخال كلمة سر');}
    if (strlen($pass) < 6 ){array_push($errors, 'يجب أن يكون طول كلمة السر على الأقل 6 حروفٍ/حرفًا');}

    if (!count($errors)){

        $query = "SELECT * FROM users WHERE user_email = '$email'";

        $userExist = $mysqli->query($query);

        if (!$userExist->num_rows){
            array_push($errors, 'البيانات المدخلة غير متطابقة مع البيانات المسجلة لدينا');
        }else{

            $user_found = $userExist->fetch_assoc();

            if (password_verify($pass, $user_found['user_password'])){


                $_SESSION['user_name']  = $user_found['user_name'];
                $_SESSION['user_id']    = $user_found['user_id'];
                $_SESSION['avatar']     = $user_found['user_avatar'];
                $_SESSION['user_role']  = $user_found['user_role'];
                $_SESSION['notify_message'] = "مرحبا $user_found[user_name] ، نتمنى لك وقتاً ممتعاً";

                header('location:app.php');
                die();



            }else{
                array_push($errors, 'البيانات المدخلة غير متطابقة مع البيانات المسجلة لدينا');
            }

        }

    }

}


?>

<!-- ==== notification message ==== -->
<?php if (isset($_SESSION['notify_message'])) {?>
    <div class="notify-message">
        <?php echo $_SESSION['notify_message'];?>
    </div>
<?php }
    unset($_SESSION['notify_message']);
?>
<!-- ==== notification message ==== -->
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
                            <a class="nav-link font-head" href="index.php#about-us">ماهو مفضلتي؟</a>
                        </li>
                        <li class="nav-item pr-lg-4 mx-auto">
                            <a class="nav-link font-head " href="index.php#contact">تواصل معنا</a>
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
            <p class="text-center font-head ">تسجيل دخول</p>

            <form class="sign" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                <div class="input-container"><input type="email" name="email" class="form-control mb-3" placeholder="البريد الإلكتروني" required="required"  value="<?php echo $email?>" ></div>
                <div class="input-container"><input type="password" name="pass" class="form-control mb-3" autocomplete="new-password" placeholder="كلمة المرور" required="required"></div>
                <input type="submit" class="btn btn-block" name="login" value="دخول">

            </form>

            <p class="pt-3"><a class="font-head" href="password_reset.php">هل نسيت كلمة المرور؟</a></p>

        </div>
    </div>


<?php include_once 'includes/templates/main-footer.php'; ?>