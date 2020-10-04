<?php
$pageTitle = "| قوائم عضو";
require_once '../includes/templates/admin-header.php';

if (!isset($_GET['userId']) || empty($_GET['userId']) || !is_numeric($_GET['userId'])){
    header('location:index.php');
    die();
}

$stat = $mysqli->prepare("SELECT sections.*, users.user_name FROM sections INNER JOIN users ON sections.user_id = users.user_id WHERE sections.user_id=? ORDER BY section_id DESC");
$stat->bind_param('i', $userId);
$userId = intval($_GET['userId']);
$stat->execute();
$result = $stat->get_result();

if ($result->num_rows > 0){
    $sections = $result->fetch_all(MYSQLI_ASSOC);


?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">القوائم المضافة من قبل <span style="color: var(--main-color)"><?php echo $sections[0]['user_name']?></span></h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid pb-5">

                <div class="card card-danger card-outline">
                    <div style="padding: .75rem !important;" class="card-header">
                        <form style="display: inline-block" action="" method="post" class="mx-1">
                            <input type="hidden" name="user_id" value="<? echo $sections[0]['user_id']?>">
                            <button type="submit" name="delete-all" class="btn btn-danger card-title" onclick="return confirm('هل تريد الحذف؟')">حذف الكل</button>
                        </form>
                    </div>
                    <table class="table table-striped table-hover text-center mb-0">

                        <tr>
                            <th>#</th>
                            <th>اسم المستخدم</th>
                            <th>اسم القائمة</th>
                            <th style="text-align: center;" >حذف</th>
                        </tr>
                        <?php
                        foreach ($sections as $section):?>
                            <tr>
                                <td><? echo $section['section_id']?></td>
                                <td><? echo $section['user_name']?></td>
                                <td><? echo $section['section_name']?></td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <form style="display: inline-block" action="" method="post" class="mx-1">
                                            <input type="hidden" name="section_id" value="<? echo $section['section_id']?>">
                                            <button type="submit" name="delete-section" class="btn btn-sm btn-danger" onclick="return confirm('هل تريد الحذف؟')"><i class="fas fa-backspace fa-fw"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table
                </div>

            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
<?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if (isset($_POST['delete-section'])){

            $sectionId = mysqli_real_escape_string($mysqli, $_POST['section_id']);

            $query = "DELETE FROM sections WHERE section_id=$sectionId";
            $mysqli->query($query);

            if ($mysqli->error){
                echo "<script>alert('".$mysqli->error."')</script>";
            }else{
                $_SESSION['error_message'] = 'تم الحذف';
                header('location:index.php');
                die();
            }

        }else{

            $userId = mysqli_real_escape_string($mysqli, $_POST['user_id']);

            $query = "DELETE FROM sections WHERE user_id=$userId";
            $mysqli->query($query);

            if ($mysqli->error){
                echo "<script>alert('".$mysqli->error."')</script>";
            }else{
                $_SESSION['error_message'] = 'تم الحذف';
                header("Refresh:0");
                die();
            }
        }
    }

}else{ ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="error-page">
                <div class="error-content text-center m-0">
                    <h1 class="headline text-danger"><i class="fas fa-ban"></i></h1>
                    <h3 class="">لم يتم اضافة قوائم من قبل هذا العضو</h3>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
<?php }
require_once '../includes/templates/admin-footer.php';
?>