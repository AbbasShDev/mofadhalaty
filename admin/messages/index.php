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
                <table class="my-table table table-responsive-lg table-bordered table-striped table-hover">
                    <tr>
                        <th style="min-width: 10px !important;">#</th>
                        <th style="min-width:95px !important;">الاسم</th>
                        <th style="min-width:166px !important;">الايميل</th>
                        <th style="min-width:394px !important;">الرسالة</th>
                        <th style="min-width:187px !important;">تاريخ الرسالة</th>
                        <th style="text-align: center;" >رد | حذف</th>
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
                                    <form style="display: inline-block" action="" method="post" class="mx-1">
                                        <input type="hidden" name="message_id" value="<?php echo $message['message_id']?>">
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل تريد الحذف؟')"><i class="fas fa-backspace fa-fw"></i></button>
                                    </form>
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

    $messageId = mysqli_real_escape_string($mysqli, $_POST['message_id']);

    $query = "DELETE FROM messages WHERE message_id=$messageId";
    $mysqli->query($query);

    if ($mysqli->error){
        $_SESSION['error_message'] = $mysqli->error;
        header('location:index.php');
        die();
    }else{
        $_SESSION['error_message'] = 'تم الحذف';
        header('location:index.php');
        die();
    }

}
require_once '../includes/templates/admin-footer.php';
?>