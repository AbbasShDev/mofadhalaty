<?php
ob_start();
session_start();
$pageTitle = '| حسابي';

if (!isset($_SESSION['user_name'])){
    header('location:index.php');
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
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <meta name="author" content="AbbasShDev @AbbasShDev">
    <link rel="icon" type="image/png" href="layout/images/favicon.svg">
    <!-- main CSS -->
    <link rel="stylesheet" href="layout/css/main.css">
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
    <!-- Bootstrap css -->
    <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap.min.css" integrity="sha384-vus3nQHTD+5mpDiZ4rkEPlnkcyTP+49BhJ4wJeJunw06ZAp+wzzeBPUXr42fi8If" crossorigin="anonymous">
    <!-- bootstrap-select CSS -->
    <!--    <link rel="stylesheet"-->
    <!--          href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">-->
    <title><?php echo "$config[app_name] $pageTitle"?></title>
</head>
<body>
<!-- Start notification message -->
<?php if (isset($_SESSION['notify_message'])) {?>
    <div class="notify-message">
        <?php echo $_SESSION['notify_message'];?>
    </div>
<?php }
unset($_SESSION['notify_message']); ?>

<!-- End notification message -->

<!-- Start navbar -->
<div class="navbar-area">
    <div class="container">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="index.php"><img class="logo" src="layout/images/logo.png" alt=""></a>

            <div class="nav-item dropdown profile-dropdown ml-auto">
                <a class="nav-link dropdown-toggle p-0" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-img" style="height: 40px !important; width: 40px !important;" src="
                    <?php
                    if (isset($_SESSION['avatar']) && !empty($_SESSION['avatar'])){
                        echo $_SESSION['avatar'];
                    }else{
                        echo 'uploads/avatars/default.png';
                    }
                    ?>" alt="">
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="app.php"><i class="fas fa-user-circle fa-fw"></i> <?php echo $_SESSION['user_name'] ?></a>
                    <div class="dropdown-divider"></div>
                    <?php if ($_SESSION['user_role'] == 'admin'){ ?>
                        <a class="dropdown-item" href="<?php echo $config['app_url']?>admin/login.php"><i class="fas fa-tachometer-alt fa-fw"></i> لوحة التحكم</a>
                    <?php } ?>
                    <a class="dropdown-item" href="profile.php"><i class="fas fa-cog fa-fw"></i> حسابي</a>
                    <a class="dropdown-item text-danger" href="logout.php"><i class="fa fa-power-off fa-fw"></i> خروج</a>
                </div>
            </div>
        </nav>
    </div>
</div>
<!-- Start navbar -->

<!-- Start profile -->
<div class="container profile">
    <div class="row justify-content-around ">
            <div class="col-11 col-lg-3 order-1 order-lg-0 profile-left mt-3 mb-5">
                <div class="container">
                    <img class="rounded-circle img-thumbnail img d-flex mx-auto" style="height: 100px !important; width: 100px !important;" src="<?php
                    if (isset($_SESSION['avatar']) && !empty($_SESSION['avatar'])){
                        echo $_SESSION['avatar'];
                    }else{
                        echo 'uploads/avatars/default.png';
                    }
                    ?>" alt="">
                    <p class="text-center pt-4">مرحباً <?php echo $_SESSION['user_name'] ?></p>
                    <hr>

                    <ul class="left-nav mt-3">
                        <li class="pr-3 pr-lg-0 d-flex justify-content-center">
                            <a class="nav-link my-2
                            <?php if(isset($_GET['do']) && $_GET['do'] == 'export'){
                                echo '';
                            }elseif (isset($_GET['do']) && $_GET['do'] == 'change_password'){
                                echo '';
                            }else{
                                echo 'active';
                            } ?>"
                             href="profile.php">
                                <i class="fas fa-user-circle pr-1"></i>
                                ملفي الشخصي
                            </a>
                        </li>
                        <li class="pr-3 pr-lg-0 d-flex justify-content-center">
                            <a class="nav-link my-2
                            <?php if(isset($_GET['do']) && $_GET['do'] == 'change_password'){
                                echo 'active';
                            } ?>"
                            href="profile.php?do=change_password">
                                <i class="fas fa-key pr-1"></i>
                                تغير كلمة السر
                            </a>
                        </li>
                        <li class="pr-3 pr-lg-0 d-flex justify-content-center">
                            <a class="nav-link my-2
                            <?php if(isset($_GET['do']) && $_GET['do'] == 'export'){
                                echo 'active';
                            } ?>"
                            href="profile.php?do=export">
                                <i class="fas fa-cloud-download-alt pr-1"></i>
                                تصدير
                            </a>
                        </li>
                        <li class="pr-3 pr-lg-0 d-flex justify-content-center">
                            <a class="nav-link text-danger my-2" href="logout.php">
                                <i class="fa fa-power-off pr-1"></i>
                                خروج
                            </a>
                        </li>

                    </ul>
                </div>
            </div>

    <?php if(isset($_GET['do']) && $_GET['do'] == 'export'){//export data (urls)?>

    <div class="col-11 col-lg-7 order-0 order-lg-1 profile-right my-5">
        <div class="container export">

            <h4 class="text-center font-head pb-5">تصدير البيانات</h4>
            <div class="p-5 mt-5">
                <p class="text-center text-md-left">يمكنك تحميل ملف نصي (txt) يحتوي على جميع الروابط المحفوظة في <strong>مفضلتي</strong></p>
                <p class="text-center text-md-left"><a href="<?php echo $config['app_url']?>export_data.php">تحميل بياناتي</a></p>
            </div>
        </div>
    </div>
    <?php }elseif (isset($_GET['do']) && $_GET['do'] == 'change_password'){

        if ($_SERVER['REQUEST_METHOD'] == 'POST'){

            $oldPass          = mysqli_real_escape_string($mysqli, $_POST['pass_old']);
            $newPass          = mysqli_real_escape_string($mysqli, $_POST['pass_new']);
            $conformPass    = mysqli_real_escape_string($mysqli, $_POST['pass_confirm']);



                if (empty($oldPass)) {
                    array_push($errors, 'يجب إدخال كلمة السر القديمة');
                }
                if (empty($newPass)) {
                    array_push($errors, 'يجب إدخال كلمة السر الجديدة');
                }
                if (empty($conformPass)) {
                    array_push($errors, 'يجب إدخال تأكيد كلمة السر الجديدة');
                }

                if (!empty($oldPass) && !empty($newPass) && !empty($conformPass)){
                    if (strlen($oldPass) < 6 || strlen($newPass) < 6) {
                        array_push($errors, 'يجب أن يكون طول كلمة السر على الأقل 6 حروفٍ/حرفًا');
                    }
                    if ($conformPass != $newPass) {
                        array_push($errors, 'حقل التأكيد غير مُطابق للحقل كلمة السر');
                    }
                }



            if (!count($errors)){

                $userId = $_SESSION['user_id'];
                $query = "SELECT user_password FROM users WHERE user_id = '$userId'";

                $userExist = $mysqli->query($query);

                if (!$userExist->num_rows){
                    array_push($errors, 'البيانات المدخلة غير متطابقة مع البيانات المسجلة لدينا');
                }else{

                    $user_found = $userExist->fetch_assoc();

                    if (password_verify($oldPass, $user_found['user_password'])){

                        $hashNewPass = password_hash($newPass, PASSWORD_DEFAULT);
                        $query = "UPDATE users SET user_password='$hashNewPass' WHERE user_id=$userId";


                        if ($mysqli->query($query)){

                            $_SESSION['notify_message'] = 'تم تحديث بياناتك بنجاح';

                            header("location:profile.php?do=change_password");
                            die();
                        }

                    }else{
                        array_push($errors, 'البيانات المدخلة غير متطابقة مع البيانات المسجلة لدينا');
                    }

                }

            }
        }

        ?>
        <div class="col-11 col-lg-7 order-0 order-lg-1 profile-right my-5">
            <div class="container">
                <h4 class="text-center font-head pb-3">تغير كلمة السر</h4>
                <form action="?do=change_password" method="post" enctype="multipart/form-data">

                    <?php
                    if (count($errors)){ ?>
                        <div class="alert alert-danger mx-auto">
                            <?php foreach ($errors as $error) :?>
                                <p class="m-0">- <?php echo $error ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php } ?>

                    <div class="form-group">
                        <label for="pass_old">كلمة المرور القديمة:</label>
                        <input type="password" name="pass_old" class="form-control" placeholder="كلمة المرور القديمة" id="pass_old">
                    </div>

                    <div class="form-group">
                        <label for="pass_new">كلمة المرور الجديدة:</label>
                        <input type="password" name="pass_new" class="form-control" placeholder="كلمة المرور الجديدة" id="pass_new">
                    </div>

                    <div class="form-group">
                        <label for="pass_conform">تأكيد كلمة المرور الجديدة:</label>
                        <input type="password" name="pass_confirm" class="form-control" placeholder="تأكيد كلمة المرور الجديدة" id="password">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn d-flex mx-auto px-5">تحديث</button>
                    </div>

                </form>
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

            $upload = new Uploader('uploads/avatars', $allowedTypes, $config['root_dir']);
            $upload->file = $_FILES['avatar'];
            $errors = $upload->upload();

            $filePath = $upload->filePath;
            if (!count($errors) && !empty($avatar)){
                unlink($config['root_dir'].$avatar);
                $avatar = $filePath;
            }elseif (!count($errors) && empty($avatar)){
                $avatar = $filePath;
            }
        }

        $username       = mysqli_real_escape_string($mysqli, $_POST['username']);
        $email          = mysqli_real_escape_string($mysqli, $_POST['email']);

        if (empty($username)) {
            array_push($errors, 'يجب ادخال اسم مستخدم');
        }
        if (empty($email)) {
            array_push($errors, 'يجب ادخال بريد الكتروني');
        }

        if (!count($errors)) {

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
    <div class="col-11 col-lg-7 order-0 order-lg-1 profile-right my-5">

<!--        <div class="loader-bg d-none justify-content-center"><span class="spinner-grow" role="status"></span></div>-->
        <div class="container">
            <h4 class="text-center font-head pb-3">تحديث المعلومات الشخصية</h4>

            <form action="" method="post" enctype="multipart/form-data">

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
<!-- End profile -->
<?php
include_once 'includes/templates/main-footer.php';

ob_end_flush();
?>