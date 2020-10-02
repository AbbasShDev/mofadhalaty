<?php
$pageTitle = "| إضافة عضو";
require_once '../includes/templates/admin-header.php';

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
}else{
    header('location:index.php');
    die();
}

$errors     = [];

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){


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
                            <button type="submit" class="btn btn-light" style="color: var(--main-color)">حفظ</button>
                        </div>
                    </form>
                </div>

            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
<?php
require_once '../includes/templates/admin-footer.php';
?>