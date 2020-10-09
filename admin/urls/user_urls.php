<?php
$pageTitle = "| روابط عضو";
require_once '../includes/templates/admin-header.php';

if (!isset($_GET['userId']) || empty($_GET['userId']) || !is_numeric($_GET['userId'])){
    header('location:index.php');
    die();
}

$stat = $mysqli->prepare("SELECT urls.*, users.user_name FROM urls INNER JOIN users ON urls.user_id = users.user_id WHERE urls.user_id=? ORDER BY url_id DESC");
$stat->bind_param('i', $userId);
$userId = intval($_GET['userId']);
$stat->execute();
$result = $stat->get_result();

if ($result->num_rows > 0){
    $urls = $result->fetch_all(MYSQLI_ASSOC);


?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">الروابط المضافة من قبل <span style="color: var(--main-color)"><?php echo $urls[0]['user_name']?></span></h1>
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
                            <input type="hidden" name="user_id" value="<?php echo $urls[0]['user_id']?>">
                            <button type="submit" name="delete-all" class="btn btn-danger card-title" onclick="return confirm('هل تريد الحذف؟')">حذف الكل</button>
                        </form>
                    </div>
                    <table class=" table table-responsive table-hover">

                        <tr>
                            <th style="text-align: center;" >حذف</th>
                            <th>#</th>
                            <th style="" >النوع</th>
                            <th style="" >الموقع</th>
                            <th style="min-width: 95px;" >العنوان</th>
                            <th >الرابط</th>
                        </tr>
                        <?php foreach ($urls as $url):?>
                            <tr>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <form style="display: inline-block" action="" method="post" class="mx-1">
                                            <input type="hidden" name="url_id" value="<?php echo $url['url_id']?>">
                                            <button type="submit" name="delete-url" class="btn btn-sm btn-danger" onclick="return confirm('هل تريد الحذف؟')"><i class="fas fa-backspace fa-fw"></i></button>
                                        </form>
                                    </div>
                                </td>
                                <td><?php echo $url['url_id']?></td>
                                <td><?php echo $url['url_type']?></td>
                                <td style="font-size: 14px"><?php echo $url['url_providerName']?></td>
                                <td style="font-size: 12px"><?php echo $url['url_title']?></td>
                                <td><a style="text-decoration: underline;color: var(--darker-main-color); font-size: 10px" href="<?php echo $url['url_name']?>" target="_blank">
                                        <?php echo $url['url_name']?>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>

            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
<?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if (isset($_POST['delete-url'])){

            $urlId = mysqli_real_escape_string($mysqli, $_POST['url_id']);

            $query = "DELETE FROM urls WHERE url_id=$urlId";
            $mysqli->query($query);

            if ($mysqli->error){
                echo "<script>alert('".$mysqli->error."')</script>";
            }else{
                $_SESSION['error_message'] = 'تم الحذف';
                header("Refresh:0");
                die();
            }

        }else{

            $userId = mysqli_real_escape_string($mysqli, $_POST['user_id']);

            $query = "DELETE FROM urls WHERE user_id=$userId";
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
                    <h3 class="">لم يتم اضافة روابط من قبل هذا العضو</h3>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
<?php }
require_once '../includes/templates/admin-footer.php';
?>