<?php
$pageTitle = "| إضافة عضو";
require_once '../includes/templates/admin-header.php';


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

        header('location:index.php');
        die();

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
                        <h1 class="m-0 text-dark">إضافة عضو</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid pb-5">
                <div class="card border-0">
                   <?php  include  '../includes/config/errorsMessages.php'; ?>
                    <!-- form start -->
                    <form role="form" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="username">اسم العرض</label>
                                <input type="text" name="username" value="<?php echo $username?>" class="form-control" id="username" placeholder="اسم العرض (عربي او انجليزي)" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="email">البريد الإلكتروني</label>
                                <input type="email" name="email" value="<?php echo $email?>"  class="form-control" id="email" placeholder="البريد الإلكتروني" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="pass">كلمة المرور</label>
                                <input type="password" name="pass" class="form-control" id="pass" placeholder="كلمة المرور" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="pass_conform">تأكيد كلمة المرور</label>
                                <input type="password" name="pass_conform" class="form-control" id="pass_conform" placeholder="تأكيد كلمة المرور" autocomplete="off">
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer mybg-main">
                            <button type="submit" class="btn btn-light" style="color: var(--main-color)">حفظ</button>
                        </div>
                    </form>
                </div>

            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
<?php require_once '../includes/templates/admin-footer.php'?>