<?php
$pageTitle = "| الأعضاء";
require_once '../includes/templates/admin-header.php'
?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">الأعضاء</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid pb-5">

                <a href="add_user.php"><button type="button" class="btn my-btn-main  float-left mb-3"><i class="fa fa-plus"></i> إضافة عضو</button></a>

                <table class="my-table table table-responsive-lg table-bordered table-striped table-hover">
                    <tr>
                        <th style="min-width: 10px !important;">#</th>
                        <th style="min-width: 40px !important;">الصورة</th>
                        <th style="min-width: 185px !important;">الاسم</th>
                        <th style="min-width: 275px !important;">الايميل</th>
                        <th style="min-width: 40px !important;">دور</th>
                        <th style="min-width: 40px !important;">الروابط</th>
                        <th style="min-width: 40px !important;">القوائم</th>
                        <th style="min-width: 120px !important;">تاريخ التسجيل</th>
                        <th style="text-align: center; min-width: 120px !important;" >تعديل | حذف</th>
                    </tr>
                    <?php
                    $stat = $mysqli->query('SELECT * FROM users ORDER BY user_id DESC');
                    $users= $stat->fetch_all(MYSQLI_ASSOC);
                    foreach ($users as $user):?>
                        <tr>
                            <td><?php echo $user['user_id'] ?></td>
                            <td><img style="width: 40px !important; height: 40px !important; border-radius: 50% !important;"
                                     src="
                                        <?php if (!empty($user['user_avatar'])){
                                         echo $config['app_url'].$user['user_avatar'];
                                     }else{
                                         echo $config['app_url'].'uploads/avatars/default.png';
                                     }
                                     ?>
                                    " alt=""></td>
                            <td><?php echo $user['user_name']?></td>
                            <td><?php echo $user['user_email']?></td>
                            <td><?php echo $user['user_role']?></td>
                            <td><div class="d-flex justify-content-center"><a class="text-center text-info" href="<?php echo $config['app_url']?>admin/urls/user_urls.php?userId=<?php echo $user['user_id']?>"><i class="fas fa-link"></i></a></div></td>
                            <td><div class="d-flex justify-content-center"><a class="text-center text-warning" href="<?php echo $config['app_url']?>admin/sections/user_sections.php?userId=<?php echo $user['user_id']?>"><i class="fas fa-link"></i></a></div></td>
                            <td><?php echo $user['user_created_at']?></td>
                            <td style="">
                                <div class="d-flex justify-content-center">
                                    <a href="edit.php?userId=<?php echo $user['user_id']?>"><button class="btn btn-sm btn-primary mx-1"><i class="fas fa-edit fa-fw"></i></button></a>
                                    <form style="display: inline-block" action="" method="post" class="mx-1">
                                        <input type="hidden" name="userId" value="<?php echo $user['user_id']?>">
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

    $userId = mysqli_real_escape_string($mysqli, $_POST['userId']);

    $query = "DELETE FROM users WHERE user_id=$userId";
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