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
    <link rel="stylesheet" href="layout/css/main.css">
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

<!-- Start header -->
<div class="navbar-area">
    <div class="container">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="index.php"><img class="logo" src="layout/images/logo.png" alt=""></a>

            <div class="nav-item dropdown profile-dropdown ml-auto">
                <a class="nav-link dropdown-toggle p-0" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-img" width="40" height="40" src="https://upay.upayments.com/assets/global/img/user.png" alt="">
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="app.php"><i class="fas fa-user-circle fa-fw"></i> <?php echo $_SESSION['user_name'] ?></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="profile.php?do=edit_profile"><i class="fas fa-cog fa-fw"></i> حسابي</a>
                    <a class="dropdown-item text-danger" href="logout.php"><i class="fa fa-power-off fa-fw"></i> خروج</a>
                </div>
            </div>
        </nav>
    </div> <!-- container -->
</div> <!-- navbar area -->

    <div class="container profile">
        <div class="row justify-content-around ">
            <div class="col-11 col-lg-3 order-0 order-md-0 profile-left mt-3 mb-5">
                <div class="container">
                    <img class="rounded-circle img-thumbnail img d-flex mx-auto" width="100" height="100" src="https://upay.upayments.com/assets/global/img/user.png" alt="">
                    <p class="text-center pt-4">مرحباً <?php echo $_SESSION['user_name'] ?></p>
                    <hr>
                    <ul class="left-nav mt-5">
                        <li class="pr-3 pr-lg-0 d-flex justify-content-center justify-content-lg-start">
                            <a class="nav-link my-2
                            <?php if(isset($_GET['do']) && $_GET['do'] == 'edit_profile'){
                                echo 'active';
                            } ?>"
                             href="profile.php?do=edit_profile">
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
<?php if(isset($_GET['do']) && $_GET['do'] == 'edit_profile'){

            $userId = $_SESSION['user_id'];

            $stat = $mysqli->query("SELECT * FROM users WHERE user_id='$userId'");
            $userInfo = $stat->fetch_assoc();


            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

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

                    $passHash = password_hash($pass, PASSWORD_DEFAULT);
                    $query = "UPDATE users SET user_name='$username' ,user_email='$email', user_password='$passHash' WHERE user_id=$userId";


                    if ($mysqli->query($query)){
                        
                        $_SESSION['user_name'] = $username;
                        $_SESSION['notify_message'] = 'تم تحديث بياناتك بنجاح';

                        header("refresh: 0;");
                        die();
                    }
                }

                if (!count($errors) && empty($pass)) {

                    $query = "UPDATE users SET user_name='$username' ,user_email='$email' WHERE user_id=$userId";



                    if ($mysqli->query($query)){

                        $_SESSION['user_name'] = $username;
                        $_SESSION['notify_message'] = 'تم تحديث بياناتك بنجاح';

                        header("refresh: 0;");
                        die();
                    }


                }
            }
            ?>
            <div class="col-11 col-lg-7 order-1 order-md-1 profile-right my-5">
                <div class="container">
                <h4 class="text-center pb-3">تحديث المعلومات الشخصية</h4>

                    <form action="?do=edit_profile" method="post">

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
                            <input type="file" name="avatar[]" class="form-control" id="avatar">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn d-flex mx-auto px-5">تحديث</button>
                        </div>

                    </form>

                </div>
            </div>


    <?php }elseif(isset($_GET['do']) && $_GET['do'] == 'export'){ ?>

    <div class="col-11 col-lg-7 order-1 order-md-1 profile-right my-5">
        <div class="container">

            <h4 class="text-center pb-3">تصدير البيانات</h4>

        </div>
    </div>
    <?php }else{
        header('location:app.php');
        die();
    }?>
        </div>
    </div>

<?php
include_once 'includes/templates/main-footer.php';
ob_end_flush();
?>