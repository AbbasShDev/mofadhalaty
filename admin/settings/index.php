<?php
$pageTitle = "| الإعدادات";
require_once '../includes/templates/admin-header.php';

$settings = $mysqli->query('SELECT * FROM settings')->fetch_assoc();

$errors     = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $app_name              = mysqli_real_escape_string($mysqli, $_POST['app_name']);
    $app_url               = mysqli_real_escape_string($mysqli, $_POST['app_url']);
    $admin_email           = mysqli_real_escape_string($mysqli, $_POST['admin_email']);

    if (empty($app_name)){array_push($errors, 'يجب ادخال اسم الموقع');}
    if (empty($app_url)){array_push($errors, 'يجب ادخال رابط الموقع');}
    if (empty($admin_email)){array_push($errors, 'يجب ادخال إيميل الأدمن');}

    if (!count($errors)){
        $query = "UPDATE settings SET app_name='$app_name', app_url='$app_url', admin_email='$admin_email'";

        if ($mysqli->query($query)){
            $_SESSION['notify_message'] = 'تم تغيير الإعدادات';
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
                        <h1 class="m-0 text-dark">الإعدادات</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <section class="content">
            <div class="col-12 col-md-8 col-lg-6 container-fluid pb-5">

                <!-- Horizontal Form -->
                <div class="card">
                    <div class="card-header mybg-main">
                        <h3 class="card-title text-light">إعدادات الموقع</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form class="form-horizontal" method="post">
                        <div class="card-body px-4">
                            <?php  include  '../includes/config/errorsMessages.php'; ?>
                            <div class="form-group">
                                <label for="app_name" class="font-head">اسم الموقع</label>
                                    <input type="text" class="form-control" name="app_name" id="app_name" value="<?php echo $settings['app_name'] ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="app_url" class="font-head">رابط الموقع</label>
                                    <input type="text" class="form-control" name="app_url" id="app_url" dir="ltr"  value="<?php echo $settings['app_url'] ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="admin_email" class="font-head">إيميل الأدمن</label>
                                    <input type="email" class="form-control" name="admin_email" id="admin_email"  value="<?php echo $settings['admin_email'] ?>" required>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer px-4">
                            <button type="submit" class="btn my-btn-main">حفظ</button>
                        </div>
                        <!-- /.card-footer -->
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