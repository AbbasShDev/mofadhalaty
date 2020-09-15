<?php
ob_start();
session_start();
$pageTitle = 'حسابي';

if (!isset($_SESSION['user_name'])){
header('location:app.php');
die();
}

require_once 'includes/config/database.php';
require_once 'includes/config/app.php';
require_once 'includes/classes/uploader.php';
$errors = [];

?>

<!doctype html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- main CSS -->
    <link rel="stylesheet" href="layout/css/app.css">
    <!-- font awesome -->
    <script src="https://kit.fontawesome.com/6652aa2ce8.js" crossorigin="anonymous"></script>
    <!-- Bootstrap css -->
    <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap.min.css" integrity="sha384-vus3nQHTD+5mpDiZ4rkEPlnkcyTP+49BhJ4wJeJunw06ZAp+wzzeBPUXr42fi8If" crossorigin="anonymous">
    <!-- bootstrap-select CSS -->
    <!--    <link rel="stylesheet"-->
    <!--          href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">-->
    <title><?php echo "$config[app_name] | $pageTitle"?></title>
</head>
<body>
<!--    notification message -->
<?php if (isset($_SESSION['notify_message'])) {?>
    <div class="notify-message">
        <?php echo $_SESSION['notify_message'];?>
    </div>
<?php }
unset($_SESSION['notify_message']); ?>

<!--    notification message -->
<!-- Start navbar-->
<div class="navbar-area">
    <nav class="navbar col-12 mx-auto">
        <div class="container px-0">

            <div class="sidebar-toggler pr-2">
                <span></span>
                <span></span>
                <span></span>
            </div>

            <a class="navbar-brand m-0" href="app.php"><img class="logo" src="layout/images/logo.png" alt=""></a>

            <div class=" row ml-auto ml-sm-0 mr-sm-auto pr-4 pr-sm-0">
                <div class="nav-item mx-auto order-1 order-sm-0">
                    <a class="nav-link p-0 pl-3 add-url-icon" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" stroke-width="1.5" stroke="#3f64b5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z"/>
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                    </a>
                </div>
                <div class="nav-item mx-auto order-0 order-sm-1">
                    <a class="nav-link p-0 pl-2 search-url-icon" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg"  width="32" height="32" viewBox="0 0 24 24" stroke-width="1.5" stroke="#3f64b5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z"/>
                            <circle cx="10" cy="10" r="7" />
                            <line x1="21" y1="21" x2="15" y2="15" />
                        </svg>
                    </a>
                </div>
            </div>

            <div class="nav-item dropdown profile-dropdown">
                <a class="nav-link dropdown-toggle p-0" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-img" style="height: 40px !important; width: 40px !important;" src="
                        <?php if (isset($_SESSION['avatar']) && !empty($_SESSION['avatar'])){
                        echo $_SESSION['avatar'];
                    }else{
                        echo 'uploads/avatars/default.png';
                    }
                    ?>"
                         alt="">
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="app.php"><i class="fas fa-user-circle fa-fw"></i> <?php echo $_SESSION['user_name'] ?></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="profile.php"><i class="fas fa-cog fa-fw"></i> حسابي</a>
                    <a class="dropdown-item text-danger" href="logout.php"><i class="fa fa-power-off fa-fw"></i> خروج</a>
                </div>
            </div>

        </div>
    </nav>
</div>
<!-- End navbar -->
<div class="sidebar" data-image="../assets/img/sidebar-5.jpg">
    <div class="sidebar-wrapper">
        <div class="hide-sidebar">
            <i class="fas fa-chevron-right"></i>
        </div>

        <div class="container nav">
            <img class="rounded-circle img-thumbnail img d-flex mx-auto" style="height: 100px !important; width: 100px !important;" src="<?php
            if (isset($_SESSION['avatar']) && !empty($_SESSION['avatar'])){
                echo $_SESSION['avatar'];
            }else{
                echo 'uploads/avatars/default.png';
            }
            ?>" alt="">
            <p class="text-center pt-4">مرحباً <?php echo $_SESSION['user_name'] ?></p>
            <hr>

            <ul class="left-nav mt-5">
                <li class="pr-3 pr-lg-0 d-flex justify-content-center justify-content-lg-start">
                    <a class="nav-link my-2
                            <?php if(isset($_GET['do']) && $_GET['do'] == 'export'){
                        echo '';
                    }else{
                        echo 'active';
                    } ?>"
                       href="profile.php">
                        <i class="fas fa-user-circle pr-1"></i>
                        ملفي الشخصي
                    </a>
                </li>
                <li class="pr-3 pr-lg-0 d-flex justify-content-center justify-content-lg-start">
                    <a class="nav-link my-2
                            <?php if(isset($_GET['do']) && $_GET['do'] == 'export'){
                        echo 'active';
                    } ?>"
                       href="profile.php?do=export">
                        <i class="fas fa-cloud-download-alt pr-1"></i>
                        تصدير
                    </a>
                </li>
                <li class="pr-3 pr-lg-0 d-flex justify-content-center justify-content-lg-start">
                    <a class="nav-link text-danger my-2" href="logout.php">
                        <i class="fa fa-power-off pr-1"></i>
                        خروج
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>

<!-- Start content -->
<div class="content-profile">
    <div class="container col-11">
<?php if(isset($_GET['do']) && $_GET['do'] == 'export'){ ?>

<div class="profile">
        <div class="container my-5">

            <h4 class="text-center pb-3">تصدير البيانات</h4>

        </div>
</div>
<?php }else{
    $userId = $_SESSION['user_id'];

    $stat = $mysqli->query("SELECT * FROM users WHERE user_id='$userId'");
    $userInfo = $stat->fetch_assoc();

    $avatar = $userInfo['user_avatar'];


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {


        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0){

            $allowedTypes = [
                'jpg' =>'image/jpeg',
                'png' =>'image/png',
                'gif' =>'image/gif'
            ];

            $upload = new Uploader('uploads/avatars', $allowedTypes);
            $upload->file = $_FILES['avatar'];
            $errors = $upload->upload();

            $filePath = $upload->filePath;
            if (!count($errors)){
                unlink($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'my-favoraite-app/'.$avatar);
                $avatar = $filePath;
            }
        }

        $username       = mysqli_real_escape_string($mysqli, $_POST['username']);
        $email          = mysqli_real_escape_string($mysqli, $_POST['email']);
        $pass           = mysqli_real_escape_string($mysqli, $_POST['pass']);
        $passConform    = mysqli_real_escape_string($mysqli, $_POST['pass_confirm']);


        if (empty($username)) {
            array_push($errors, 'يجب ادخال اسم مستخدم');
        }
        if (empty($email)) {
            array_push($errors, 'يجب ادخال بريد الكتروني');
        }

        if (!empty($pass)){
            if (strlen($pass) < 6) {
                array_push($errors, 'يجب أن يكون طول كلمة السر على الأقل 6 حروفٍ/حرفًا');
            }
            if ($passConform != $pass) {
                array_push($errors, 'حقل التأكيد غير مُطابق للحقل كلمة السر');
            }

        }

        if (!count($errors) && !empty($pass)) {

            if (isset($filePath)){
                $saveFilePath =", user_avatar='$filePath'";
            }else{
                $saveFilePath= '';
            }

            $passHash = password_hash($pass, PASSWORD_DEFAULT);
            $query = "UPDATE users SET user_name='$username' ,user_email='$email', user_password='$passHash' $saveFilePath WHERE user_id=$userId";


            if ($mysqli->query($query)){

                $_SESSION['user_name'] = $username;
                $_SESSION['avatar'] = $avatar;
                $_SESSION['notify_message'] = 'تم تحديث بياناتك بنجاح';

                header("location:profile.php");
                die();
            }
        }

        if (!count($errors) && empty($pass)) {

            if (isset($filePath)){
                $saveFilePath =", user_avatar='$filePath'";
            }else{
                $saveFilePath= '';
            }

            $query = "UPDATE users SET user_name='$username' ,user_email='$email' $saveFilePath WHERE user_id=$userId";


            if ($mysqli->query($query)){

                $_SESSION['user_name'] = $username;
                $_SESSION['avatar'] = $avatar;
                $_SESSION['notify_message'] = 'تم تحديث بياناتك بنجاح';

                header("location:profile.php");
                die();
            }


        }
    } ?>
    <div class="profile">
        <div class="container my-5">
            <h4 class="text-center pb-3">تحديث المعلومات الشخصية</h4>

            <form action="?do=edit_profile" method="post" enctype="multipart/form-data">

                <?php
                if (count($errors)){ ?>
                    <div class="alert alert-danger mx-auto">
                        <?php foreach ($errors as $error) :?>
                            <p class="m-0">- <?php echo $error ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php } ?>

                <div class="form-group">
                    <label for="username">اسم العرض (عربي او انجليزي):</label>
                    <input type="username" name="username" class="form-control" placeholder="اسم العرض" id="username" value="<?php echo $userInfo['user_name']?>" required>
                </div>

                <div class="form-group">
                    <label for="email">البريد الإلكتروني:</label>
                    <input type="email" name="email" class="form-control" placeholder="البريد الإلكتروني" id="email" value="<?php echo $userInfo['user_email']?>" required>
                </div>

                <div class="form-group">
                    <label for="pass">كلمة المرور:</label>
                    <input type="password" name="pass" class="form-control" placeholder="اترك فارغ اذا كنت لاتريد تغيره" id="password">
                </div>

                <div class="form-group">
                    <label for="pass_conform">تأكيد كلمة المرور:</label>
                    <input type="password" name="pass_confirm" class="form-control" placeholder="اترك فارغ اذا كنت لاتريد تغيره" id="password">
                </div>

                <div class="form-group">
                    <label for="avatar">صورة الملف الشخصي:</label>
                    <input type="file" name="avatar" class="form-control" id="avatar">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn d-flex mx-auto px-5">تحديث</button>
                </div>

            </form>
        </div>
    </div>


<?php }?>
    </div>
</div>
<!-- Start footer -->
<footer class="footer">

</footer>
<!-- End footer -->
</body>
<!-- font awesome -->
<script src="https://kit.fontawesome.com/6652aa2ce8.js" crossorigin="anonymous"></script>
<!-- jQuery js -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<!-- Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<!-- Bootstrap js -->
<script src="https://cdn.rtlcss.com/bootstrap/v4.2.1/js/bootstrap.min.js" integrity="sha384-a9xOd0rz8w0J8zqj1qJic7GPFfyMfoiuDjC9rqXlVOcGO/dmRqzMn34gZYDTel8k" crossorigin="anonymous"></script>
<!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
<script src="layout/js/app.js" type="text/javascript"></script>

</html>
<?php

ob_end_flush();
?>
