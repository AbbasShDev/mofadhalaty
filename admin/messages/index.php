<?php
$pageTitle = "| الرسائل";
require_once '../includes/templates/admin-header.php'
?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">الرسائل</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid pb-5">
                <table class="table table-responsive-lg table-bordered table-striped table-hover">
                    <tr>
                        <th style="min-width: 10px !important;">#</th>
                        <th style="min-width:95px !important;">الاسم</th>
                        <th style="min-width:166px !important;">الايميل</th>
                        <th style="min-width:394px !important;">الرسالة</th>
                        <th style="min-width:227px !important;">تاريخ الرسالة</th>
                        <th style="" >رد</th>
                    </tr>
                    <?php
                    $stat = $mysqli->query('SELECT * FROM messages ORDER BY message_id DESC');
                    $messages = $stat->fetch_all(MYSQLI_ASSOC);
                    foreach ($messages as $message):?>
                        <tr>
                            <td><?php echo $message['message_id'] ?></td>
                            <td><?php echo $message['name']?></td>
                            <td><?php echo $message['email']?></td>
                            <td><?php echo $message['message']?></td>
                            <td><?php echo $message['date_time']?></td>
                            <td style="">
                                <div class="d-flex justify-content-center">
                                    <a href="reply.php?message_id=<?php echo $message['message_id']?>"><button class="btn btn-sm btn-primary mx-1"><i class="fas fa-reply"></i></button></a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>

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