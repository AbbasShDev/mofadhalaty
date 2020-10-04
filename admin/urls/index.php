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

                <div class="input-group mb-3" style="width: 150px;">
                    <input type="text" name="table_search" class="table_search form-control float-right" placeholder="بحث باسم المستخدم">
                </div>

                <div class="card">
                    <!-- Loading (remove the following to stop the loading)-->
                    <div class="overlay">
                        <i style="top: 10%; !important;" class="fa fa-sync-alt fa-spin"></i>
                    </div>
                    <!--                     end loading -->
                    <table class=" table table-responsive table-hover">

                        <tr>
                            <th style="text-align: center;" >حذف</th>
                            <th>#</th>
                            <th style="min-width: 95px;" >اسم المستخدم</th>
                            <th style="min-width: 95px;" >العنوان</th>
                            <th >الرابط</th>
                        </tr>
                        <?php
                        $stat = $mysqli->query('SELECT urls.*, users.user_name FROM urls INNER JOIN users ON urls.user_id = users.user_id ORDER BY url_id DESC');
                        $urls = $stat->fetch_all(MYSQLI_ASSOC);
                        foreach ($urls as $url):?>
                            <tr>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <form style="display: inline-block" action="" method="post" class="mx-1">
                                            <input type="hidden" name="url_id" value="<? echo $url['url_id']?>">
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل تريد الحذف؟')"><i class="fas fa-backspace fa-fw"></i></button>
                                        </form>
                                    </div>
                                </td>
                                <td><? echo $url['url_id']?></td>
                                <td><u><a class="text-info text-" href="user_urls.php?userId=<? echo $url['user_id']?>"><? echo $url['user_name']?></a></u></td>
                                <td><? echo $url['url_title']?></td>
                                <td><a style="    text-decoration: underline;color: var(--darker-main-color);" href="<? echo $url['url_name']?>" target="_blank">
                                        <? echo $url['url_name']?>
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

    $urlId = mysqli_real_escape_string($mysqli, $_POST['url_id']);

    $query = "DELETE FROM urls WHERE url_id=$urlId";
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

<script>
    $(document).ready(function(){

        $('.table_search').keyup( function () {
            let searchValue = $(this).val();

                $.ajax({
                    method: 'POST',
                    url:'search-urls.php',
                    data:{search: searchValue},
                    beforeSend: function () {
                        $('.card .overlay').css('display', 'block');
                    },
                    success:function (data) {
                        $('.card .overlay').css('display', 'none');
                        $('.card .table').html(data);
                    },
                    error:function (xhr, status, error) {
                        console.log(error);
                    }
                })

        });
        console.log($('.table_search').val())
    });
</script>
