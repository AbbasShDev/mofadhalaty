<?php
session_start();
$pageTitle = '| طلب تغير كلمة المرور';

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

    $email = mysqli_real_escape_string($mysqli, $_POST['email']);

    if (empty($email)){array_push($errors, 'يجب ادخال بريد الكتروني');}

    if (!count($errors)){

        $query = "SELECT * FROM users WHERE user_email = '$email'";

        $userExist = $mysqli->query($query);

        if ($userExist->num_rows){

            $userId = $userExist->fetch_assoc()['user_id'];

            //delete token if the user has requested token before
            $mysqli->query("DELETE FROM password_reset WHERE user_id='$userId'");

            $pass_token = bin2hex(random_bytes(16));
            $expiry_at = date('Y-m-d H-i-s', strtotime('+1 day'));

            $query = "INSERT INTO  password_reset (user_id, token, expiry_at) VALUES('$userId', '$pass_token', '$expiry_at')";


            if ($mysqli->query($query)){

                $passResetURL = $config['app_url'].'password_change.php?token='.$pass_token;


                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=UFT-8' . "\r\n";
                $headers .= 'From: '.$config['admin_email']."\r\n".
                    'Reply-To: '.$config['admin_email']."\r\n" .
                    'X-Mailer: PHP/' . phpversion();

                $messageHtml = '<html><body></body></html>';
                $messageHtml .= "<h3>Your link to reset password is: </h3>";
                $messageHtml .= "<p style='color: darkgreen'>$passResetURL</p>";
                $messageHtml .= '</body></html>';


                mail($email, 'Password reset link', $messageHtml, $headers);

                $_SESSION['notify_message'] = 'تم ارسال رابط استعادة كلمة المرور الى بريدك الإلكتروني';
                header('location: password_reset.php');
                die();
            }

        }else{
            array_push($errors, 'البيانات المدخلة غير متطابقة مع البيانات المسجلة لدينا');
        }

    }

}


?>
    <!--    notification message -->
<?php if (isset($_SESSION['notify_message'])) {?>
    <div class="notify-message">
        <?php echo $_SESSION['notify_message'];?>
    </div>
<?php }
unset($_SESSION['notify_message']); ?>
    <!--    notification message -->
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
            <p class="text-center font-head ">طلب تغير كلمة المرور</p>

            <form class="sign" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                <div class="input-container"><input type="email" name="email" class="form-control mb-3" placeholder="البريد الإلكتروني" required="required"  value="<?php echo $email?>" ></div>
                <input type="submit" class="btn btn-block" name="login" value="طلب رابط تغير كلمة المرور">

            </form>

        </div>
    </div>


<?php include_once 'includes/templates/main-footer.php'; ?>