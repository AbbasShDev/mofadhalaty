<?php
$pageTitle = "| القوائم";
require_once '../includes/templates/admin-header.php'
?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">القوائم</h1>
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

                <div class="card m-0">
                    <!-- Loading (remove the following to stop the loading)-->
                    <div class="overlay">
                        <i style="top: 10%; !important;" class="fa fa-sync-alt fa-spin"></i>
                    </div>
                    <!-- end loading -->
                    <table class="my-table table table-striped table-hover text-center mb-0">

                        <tr>
                            <th>#</th>
                            <th>اسم المستخدم</th>
                            <th>اسم القائمة</th>
                            <th style="text-align: center;" >حذف</th>
                        </tr>
                        <?php
                        $stat = $mysqli->query('SELECT sections.*, users.user_name FROM sections INNER JOIN users ON sections.user_id = users.user_id ORDER BY section_id DESC');
                        $sections = $stat->fetch_all(MYSQLI_ASSOC);
                        foreach ($sections as $section):?>
                            <tr>
                                <td><? echo $section['section_id']?></td>
                                <td><u><a class="text-info text-" href="user_sections.php?userId=<? echo $section['user_id']?>"><? echo $section['user_name']?></a></u></td>
                                <td><? echo $section['section_name']?></td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <form style="display: inline-block" action="" method="post" class="mx-1">
                                            <input type="hidden" name="section_id" value="<? echo $section['section_id']?>">
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل تريد الحذف؟')"><i class="fas fa-backspace fa-fw"></i></button>
                                        </form>
                                    </div>
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

}
require_once '../includes/templates/admin-footer.php';
?>

<script>
    $(document).ready(function(){

        $('.table_search').keyup( function () {
            let searchValue = $(this).val();

                $.ajax({
                    method: 'POST',
                    url:'search-sections.php',
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
