<?php
$pageTitle = "| إضافة عضو";
require_once '../includes/templates/admin-header.php';
require_once '../includes/classes/uploader.php';

if (!isset($_GET['userId']) || empty($_GET['userId']) || !is_numeric($_GET['userId'])){
    header('location:index.php');
    die();
}

$stat = $mysqli->prepare("SELECT * FROM users WHERE user_id=? LIMIT 1");
$stat->bind_param('i', $userId);
$userId = intval($_GET['userId']);
$stat->execute();
$result = $stat->get_result();

if ($result->num_rows > 0){
    $user = $result->fetch_assoc();

    $avatar = $user['user_avatar'];
}else{
    header('location:index.php');
    die();
}

$errors     = [];

    if (isset($_POST['edit-img'])) {

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

            if (!count($errors) && isset($filePath)){

                $query = "UPDATE users SET user_avatar='$filePath' WHERE user_id=$userId";


                if ($mysqli->query($query)){

                    $_SESSION['notify_message'] = 'تم تحديث الصورة الشخصية بنجاح';

                    header("location:$_SERVER[REQUEST_URI]");
                    die();
                }

            }
        }



    }elseif (isset($_POST['edit-profile'])){


        $userId         = mysqli_real_escape_string($mysqli, $_POST['userId']);
        $username       = mysqli_real_escape_string($mysqli, $_POST['username']);
        $pass           = mysqli_real_escape_string($mysqli, $_POST['pass']);
        $passConform    = mysqli_real_escape_string($mysqli, $_POST['pass_conform']);

        if (empty($username)){array_push($errors, 'يجب ادخال اسم مستخدم');}
        if (!empty($pass) && strlen($pass) < 6 ){array_push($errors, 'يجب أن يكون طول كلمة السر على الأقل 6 حروفٍ/حرفًا');}
        if ($passConform != $pass){array_push($errors, 'حقل التأكيد غير مُطابق للحقل كلمة السر');}

        if (empty($_POST['email'])){array_push($errors, 'يجب ادخال بريد الكتروني');}



        if ($_POST['email'] != $user['user_email']){

            $email          = mysqli_real_escape_string($mysqli, $_POST['email']);

            $query = "SELECT user_email FROM users WHERE user_email = '$email'";

            $userExist = $mysqli->query($query);

            if ($userExist->num_rows){
                array_push($errors, 'البريد الإلكتروني مسجل');
            }else{
                $email          = mysqli_real_escape_string($mysqli, $_POST['email']);
            }

        }elseif($_POST['email'] == $user['user_email']){
            $email          = mysqli_real_escape_string($mysqli, $_POST['email']);
        }


        if (!count($errors) && !empty($pass)){

            $passHash = password_hash($pass, PASSWORD_DEFAULT);

            $query = "UPDATE users SET user_name='$username' , user_email='$email', user_password='$passHash' WHERE user_id=$userId";
            $mysqli->query($query);

            if ($mysqli->error){
                array_push($errors, $mysqli->error);
            }else{
                $_SESSION['notify_message'] = 'تم التعديل';
                header('location:index.php');
                die();
            }


        }
        if (!count($errors) && empty($pass)){

            $query = "UPDATE users SET user_name='$username' , user_email='$email' WHERE user_id=$userId";
            $mysqli->query($query);

            if ($mysqli->error){
                array_push($errors, $mysqli->error);
            }else{
                $_SESSION['notify_message'] = 'تم التعديل';
                header('location:index.php');
                die();
            }


        }
    }

?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">تعديل عضو</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid pb-5">

                <div class="row">

                    <div class="col-12 col-lg-5 order-1 order-lg-0">

                        <!-- Widget: user widget style 1 -->
                        <div class="card card-widget widget-user border-0 change-profile-img">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-info-active">
                                <div class="widget-user-image">
                                    <img style="width: 90px !important; height: 90px !important;" class="img-circle elevation-2" src="
                                    <?php if (!empty($avatar)){
                                        echo $config['app_url'].$avatar;
                                    }else{
                                        echo $config['app_url'].'uploads/avatars/default.png';
                                    } ?>
                                    " alt="User Avatar">
                                </div>
                            </div>

                            <form action="" method="post" class="mt-3" enctype="multipart/form-data">
                                <div class="form-group px-3">
                                    <label for="avatar">صورة الملف الشخصي:</label>
                                    <input type="file" name="avatar" class="form-control" id="avatar">
                                </div>

                            <div class="card-footer mybg-main p-0 py-2 px-3">
                                <button type="submit" name="edit-img" class="btn btn-light" style="color: var(--main-color)">حفظ</button>
                            </div>
                            </form>
                        </div>

                    </div>

                    <div class="col-12 col-lg-7 order-0 order-lg-1">
                        <div class="card border-0">
                            <?php  include  '../includes/config/errorsMessages.php'; ?>
                            <!-- form start -->
                            <form action="" method="post">
                                <input type="hidden" name="userId" value="<?php echo intval($_GET['userId']) ?>">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="username">اسم العرض</label>
                                        <input type="text" name="username" value="<?php echo $user['user_name']?>" class="form-control" id="username" placeholder="اسم العرض (عربي او انجليزي)" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">البريد الإلكتروني</label>
                                        <input type="email" name="email" value="<?php echo $user['user_email']?>"  class="form-control" id="email" placeholder="البريد الإلكتروني" autocomplete="off" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="pass">كلمة المرور</label>
                                        <input type="password" name="pass" class="form-control" id="pass" placeholder="اذا اردت عدم تغيره اتركه  فارغ" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="pass_conform">تأكيد كلمة المرور</label>
                                        <input type="password" name="pass_conform" class="form-control" id="pass_conform" placeholder="اذا اردت عدم تغيره اتركه  فارغ" autocomplete="off">
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer mybg-main">
                                    <button type="submit" name="edit-profile" class="btn btn-light" style="color: var(--main-color)">حفظ</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
<?php
require_once '../includes/templates/admin-footer.php';
?>

<script>
    //CUSTOM upload file filed
    $('.change-profile-img form  input[type="file"]').wrap('<div class="custom-file"></div>')

    $('.custom-file').prepend('<span>تحميل الملف (jpeg, jpg, png) </span>')
    $('.custom-file').append('<i class="fas fa-upload fa-lg skin-color"></i>')

    $('.change-profile-img form input[type="file"]').change(function () {

        $(this).prev('span').text($(this).val().substring(12))
    })
</script>
