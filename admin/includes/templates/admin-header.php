<?php
ob_start();
session_start();
require_once __DIR__.'/../config/app.php';
require_once __DIR__.'/../config/database.php';

if (isset($_SESSION['user_role']) && $_SESSION['user_role'] != 'admin'){
    die('غير مصرح به');
}

if (!isset($_SESSION['user_name'])){
    die('غير مصرح به');
}

if (!isset($_SESSION['admin']['name'])){
    header("location:$config[app_url]admin/login.php");
    die();
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
    <link rel="stylesheet" href="<?php echo $config['app_url']?>admin/dist/css/adminlte.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo $config['app_url']?>admin/plugins/iCheck/flat/blue.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="<?php echo $config['app_url']?>admin/plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="<?php echo $config['app_url']?>admin/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="<?php echo $config['app_url']?>admin/plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?php echo $config['app_url']?>admin/plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="<?php echo $config['app_url']?>admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <!-- Bootstrap css -->
    <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap.min.css" integrity="sha384-vus3nQHTD+5mpDiZ4rkEPlnkcyTP+49BhJ4wJeJunw06ZAp+wzzeBPUXr42fi8If" crossorigin="anonymous">
    <!-- template rtl version -->
    <link rel="stylesheet" href="<?php echo $config['app_url']?>admin/dist/css/custom-style.css">

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
            </li>
        </ul>


        <!-- Right navbar links -->
        <ul class="navbar-nav mx-0 ml-auto pl-3">
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown profile-dropdown">
                <a class="nav-link dropdown-toggle p-0" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-img" style="height: 40px !important; width: 40px !important;" src="

                    <?php if (isset($_SESSION['avatar']) && !empty($_SESSION['avatar'])){
                        echo  $config['app_url'].$_SESSION['avatar'];
                    }else{
                        echo $config['app_url'].'uploads/avatars/default.png';
                    }
                    ?>" alt="">
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="<?php echo $config['app_url']?>app.php"><i class="fas fa-home fa-fw"></i> مفضلتي</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?php echo $config['app_url']?>profile.php"><i class="fas fa-cog fa-fw"></i> حسابي</a>
                    <a class="dropdown-item" href="<?php echo $config['app_url']?>admin/"><i class="fas fa-cogs fa-fw"></i> إعدادات لوحة التحكم </a>
                    <a class="dropdown-item text-danger" href="<?php echo $config['app_url']?>admin/logout.php"><i class="fa fa-power-off fa-fw"></i> خروج</a>
                </div>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index.php" class="brand-link">
            <img src="<?php echo $config['app_url']?>admin/layout/images/logo-white-croped.png" alt="Logo" class="brand-image img-circle elevation-3">
            <span class="brand-text font-weight-light">لوحة التحكم | مفضلتي</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar" style="direction: ltr">
            <div style="direction: rtl">
                <!-- Sidebar user panel (optional) -->
                <!-- Sidebar Menu -->
                <nav class="mt-5">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                             with font-awesome or any other icon font library -->
                        <li class="nav-item pb-3 pt-4">
                            <a href="<?php echo $config['app_url']?>admin" class="nav-link <?php if ($pageTitle == "| الرئيسية"){ echo 'active'; }else{ echo ''; } ?>">
                                <i class="nav-icon fa fa-th"></i>
                                <p>الرئيسية</p>
                            </a>
                        </li>
                        <li class="nav-item pb-3">
                            <a href="<?php echo $config['app_url']?>admin/users" class="nav-link <?php if ($pageTitle == "| الأعضاء"){ echo 'active'; }else{ echo ''; } ?>">
                                <i class="nav-icon fas fa-users"></i>
                                <p>الأعضاء</p>
                            </a>
                        </li>
                        <li class="nav-item pb-3">
                            <a href="<?php echo $config['app_url']?>admin/urls" class="nav-link <?php if ($pageTitle == "| الروابط"){ echo 'active'; }else{ echo ''; } ?>">
                                <i class="nav-icon fas fa-globe"></i>
                                <p>الروابط</p>
                            </a>
                        </li>
                        <li class="nav-item pb-3">
                            <a href="#" class="nav-link ">
                                <i class="nav-icon fas fa-th-list"></i>
                                <p>القوائم</p>
                            </a>
                        </li>
                        <li class="nav-item pb-3">
                            <a href="<?php echo $config['app_url']?>admin/messages" class="nav-link <?php if ($pageTitle == "| الرسائل"){ echo 'active'; }else{ echo ''; } ?>">
                                <i class="nav-icon fas fa-envelope"></i>
                                <p>الرسائل</p>
                            </a>
                        </li>
                        <li class="nav-item pb-3">
                            <a href="#" class="nav-link ">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>الإعدادات</p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
        </div>
        <!-- /.sidebar -->
    </aside>
<?php
/* ==== notification message ==== */
if (isset($_SESSION['notify_message'])) {?>
    <div class="notify-message">
        <?php echo $_SESSION['notify_message'];?>
    </div>
<?php }
    unset($_SESSION['notify_message']);
/* ==== notification message ==== */
/* ====   error message ==== */
if (isset($_SESSION['error_message'])) { ?>
    <div class="notify-message bg-danger">
        <?php echo $_SESSION['error_message'];?>
    </div>
<?php }
unset($_SESSION['error_message']);
/* ====   error message ==== */
?>