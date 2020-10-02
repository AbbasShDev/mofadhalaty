<?php
$pageTitle = "| الروابط";
require_once '../includes/templates/admin-header.php'
?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">الروابط</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid pb-5">

            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $userId = mysqli_real_escape_string($mysqli, $_POST['userId']);

    $query = "DELETE FROM users WHERE user_id=$userId";
    $mysqli->query($query);

    if ($mysqli->error){
        echo "<script>alert('".$mysqli->error."')</script>";
    }else{
        $_SESSION['error_message'] = 'تم الحذف';
        header('location:index.php');
        die();
    }

}
require_once '../includes/templates/admin-footer.php';
?>