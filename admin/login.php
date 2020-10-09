<?php
session_start();
$pageTitle = "| دخول";

require_once __DIR__.'/includes/config/database.php';
require_once __DIR__.'/includes/config/app.php';

if (isset($_SESSION['user_role']) && $_SESSION['user_role'] != 'admin'){
    die('غير مصرح به');
}

if (isset($_SESSION['admin']['name'])){
    header("location:index.php");
    die();
}

$errors     = [];
$email      = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $email          = mysqli_real_escape_string($mysqli, $_POST['email']);
    $pass           = mysqli_real_escape_string($mysqli, $_POST['pass']);

    if (empty($email)){array_push($errors, 'يجب ادخال بريد الكتروني');}
    if (empty($pass)){array_push($errors, 'يجب ادخال كلمة سر');}
    if (strlen($pass) < 6 ){array_push($errors, 'يجب أن يكون طول كلمة السر على الأقل 6 حروفٍ/حرفًا');}

    if (!count($errors)){

        $query = "SELECT * FROM users WHERE user_email = '$email' AND user_role='admin'";

        $userExist = $mysqli->query($query);

        if (!$userExist->num_rows){
            array_push($errors, 'البيانات المدخلة غير متطابقة مع البيانات المسجلة لدينا');
        }else{

            $user_found = $userExist->fetch_assoc();

            if (password_verify($pass, $user_found['user_password'])){


                $_SESSION['admin']['name']       = $user_found['user_name'];
                $_SESSION['admin']['avatar']     = $user_found['user_avatar'];
                $_SESSION['admin']['role']       = $user_found['user_role'];

                header('location:index.php');
                die();

            }else{
                array_push($errors, 'البيانات المدخلة غير متطابقة مع البيانات المسجلة لدينا');
            }

        }

    }

}


?>
<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo "$config[app_name] $pageTitle" ?></title>
    <link rel="icon" type="image/png" href="<?php echo $config['app_url']?>layout/images/favicon.svg">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo $config['app_url']?>admin/layout/css/adminlte.min.css">
    <!-- Bootstrap css -->
    <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap.min.css" integrity="sha384-vus3nQHTD+5mpDiZ4rkEPlnkcyTP+49BhJ4wJeJunw06ZAp+wzzeBPUXr42fi8If" crossorigin="anonymous">
    <!-- custom style css -->
    <link rel="stylesheet" href="<?php echo $config['app_url']?>admin/layout/css/custom-style.css">

</head>
<body class="hold-transition login-page">
<?php include __DIR__.'/includes/config/errorsMessages.php'?>
<div class="login-box">
  <div class="login-logo">
    <a href="<?php echo $config['app_url']?>index.php"><img width="200" src="<?php echo $config['app_url']?>admin/layout/images/logo.png" alt=""></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">تسجيل دخول | لوحة التحكم</p>

      <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="الإيميل" required autocomplete="off">
          <div class="input-group-append">
            <i class="far fa-envelope input-group-text"></i>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="pass" class="form-control" placeholder="كلمة المرور" required autocomplete="off">
          <div class="input-group-append">
              <i  style="font-weight: 600 !important;" class="fas fa-lock input-group-text"></i>

          </div>
        </div>
            <button style="background-color: var(--main-color); border-color: var(--main-color);" type="submit" class="btn btn-primary btn-block btn-flat">دخول</button>
      </form>

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery js -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<!-- Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<!-- Bootstrap js -->
<script src="https://cdn.rtlcss.com/bootstrap/v4.2.1/js/bootstrap.min.js" integrity="sha384-a9xOd0rz8w0J8zqj1qJic7GPFfyMfoiuDjC9rqXlVOcGO/dmRqzMn34gZYDTel8k" crossorigin="anonymous"></script>
<!-- Theme js -->
<script src="<?php echo $config['app_url']?>admin/layout/js/adminlte.js"></script>

</body>
</html>
