<?php
ob_start();
session_start();

require_once 'includes/config/database.php';
require_once 'includes/config/app.php';
include __DIR__.'/includes/libraries/vendor/autoload.php';

if (!isset($_SESSION['user_name'])){
    header('location:index.php');
    die();
}

if (isset($_GET['url_id']) && !empty($_GET['url_id']) && is_numeric($_GET['url_id'])){


    $stat = $mysqli->prepare("SELECT * FROM urls WHERE user_id=? AND url_id=?");
    $stat->bind_param('ii',$userId, $urlId);
    $userId = $_SESSION['user_id'];
    $urlId = intval($_GET['url_id']);
    $stat->execute();
    $result = $stat->get_result();

    if ($result->num_rows == 1){
        $url = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <meta name="author" content="AbbasShDev @AbbasShDev">
    <link rel="icon" type="image/png" href="<?php echo $config['app_url']?>layout/images/favicon.svg">
    <title><?php echo $url['url_title'] ?></title>
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
    <!-- Bootstrap css -->
    <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap.min.css" integrity="sha384-vus3nQHTD+5mpDiZ4rkEPlnkcyTP+49BhJ4wJeJunw06ZAp+wzzeBPUXr42fi8If" crossorigin="anonymous">
    <!-- app css -->
    <link href="<?php echo $config['app_url']?>layout/css/app.css" rel="stylesheet" />
</head>
<script>

</script>
<body>
<!-- Start messages -->
<?php if (isset($_SESSION['notify_message'])) {?>
    <div class="notify-message">
        <?php echo $_SESSION['notify_message'];?>
    </div>
<?php }
unset($_SESSION['notify_message']); ?>
<?php if (isset($_SESSION['error_message'])) {?>
    <div class="notify-message bg-danger">
        <?php echo $_SESSION['error_message'];?>
    </div>
<?php }
unset($_SESSION['error_message']); ?>
<div class="alert alert-danger alert-normal">
    <p class="m-0"></p>
</div>
<div class="alert alert-success alert-normal py-2 px-3">
    <p class="m-0"></p>
</div>
<!-- End messages -->
<!-- Start navbar-->
<div class="navbar-area read-page">
    <nav class="navbar col-12 mx-auto">
        <div class="container px-0">

               <a class="navbar-brand m-0" href="app.php"><img class="logo" src="<?php echo $config['app_url']?>layout/images/favicon.svg" alt=""></a>

               <div class="container action-buttons mx-auto">
                   <form action="" class="favourite" method="post" data-fav="<?php echo $url['url_favourite']?>" data-urlid="<?php echo $url['url_id']?>" >
                       <button>
                           <?php if ($url['url_favourite'] == 0){ ?>
                               <i class="far fa-star fa-lg fa-fw mx-2"></i>
                               <span class="">إضافة الى المفضلة</span>
                           <?php }else{?>
                               <i class="fas fa-star fa-lg fa-fw mx-2"></i>
                               <span class="">حذف من المفضلة</span>
                           <?php } ?>
                       </button>
                   </form>
                   <form action="" class="archive" method="post" data-archive="<?php echo $url['url_archive']?>" data-urlid="<?php echo $url['url_id']?>" >
                       <button>
                           <?php if ($url['url_archive'] == 0){ ?>
                               <i class="fas fa-archive fa-lg fa-fw mx-2"></i>
                               <span class="">إضافة الى الإرشيف</span>
                           <?php }else{?>
                               <i class="fas fa-plus-square fa-lg fa-fw mx-2"></i>
                               <span class="">حذف من الإرشيف</span>
                           <?php } ?>
                       </button>
                   </form>
                   <form action="" class="delete" method="post" data-urlid="<?php echo $url['url_id']?>">
                       <button type="submit" onclick="return confirm('هل تريد الحذف؟')">
                           <i class="fas fa-trash-alt fa-lg fa-fw mx-2"></i><span class="">حذف</span>
                       </button>
                   </form>
                   <div class="add-section-toggler" data-toggle="modal" data-target="#add-url-to-section" data-urlid="<?php echo $url['url_id']?>">
                       <i class="fas fa-th-list fa-lg fa-fw mx-2"></i>
                       <span class="">إضافة الى قائمة</span>
                   </div>
               </div>

               <a class="go-back" href="<?php echo $_SERVER['HTTP_REFERER']?>"><i class="fas fa-arrow-left"></i></a>


        </div>
    </nav>
</div>
<!-- End navbar -->

<!-- Start add-url-to-section -->
<div class="modal add-url-to-section" id="add-url-to-section" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="" method="post" class="modal-content add-url-to-section">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenteredLabel">إضافة الرابط الى قائمة</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="urlid" value="<?php echo $url['url_id'] ?>">
                <select class="custom-select" name="selected-section">

                    <?php
                    $st = $mysqli->query("SELECT * FROM sections WHERE user_id=$userId");
                    $sections = $st->fetch_all(MYSQLI_ASSOC);
                    if (!empty($sections)){ ?>
                        <option selected disabled>اختر قائمة</option>

                        <?php foreach ($sections as $section):?>
                            <option value="<?php echo $section['section_id']?>" <?php if (!empty($url['section_id']) && $url['section_id'] == $section['section_id']){echo 'selected'; } ?> ><?php echo $section['section_name']?></option>
                        <?php endforeach;

                    }else{ ?>
                        <option selected disabled>لاتوجد قائمة</option>
                    <?php } ?>
                </select>
            </div>
            <div class="modal-footer">
                <button type="submit" name="add_to_section" class="btn btn-primary">حفظ التغيرات</button>
                <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">إلغاء</button>
            </div>
        </form>
    </div>
</div>
<!-- End add-url-to-section -->
    <!-- Start content -->
    <?php
    try {

        $info = Embed\Embed::create($url['url_name']);
    }catch (Embed\Exceptions\InvalidUrlException $exception) {
        $response = $exception->getResponse();
        $statusCode = $response->getStatusCode();

        echo "<div class='alert alert-danger alert-ajax'>
                <p class='m-0'>$response $statusCode</p>
              </div>";

    }
    ?>
<div class="container-fluid my-5 d-f justify-content-center text-center read-content">
        <div class="col-12 col-lg-10 mx-auto">
            <a class="col-10 mx-auto text-center title mt-3 mb-4 font-head"><?php if (filter_var($info->title, FILTER_VALIDATE_URL)){ echo $info->authorName;} else{ echo $info->title; } ?></a>
            <div class="my-3">
                <p class="m-0">بواسطة</p>
                <p class="m-0"><?php echo "<strong>$info->authorName</strong>"?></p>
                <p class="m-0"> - </p>
                <p class="m-0"> <?php echo $info->providerName?> </p>
            </div>
            <h5 class="mt-1 mb-4"><a href="<?php echo $url['url_name']?>" target="_blank">زيارة الصفحة</a></h5>
            <?php if (!empty($info->code)){ ?>
            <div class="col-11 col-lg-8 <?php if ($info->providerName == 'YouTube'){ echo 'embed-responsive embed-responsive-16by9'; } ?> d-flex justify-content-center my-3 mx-auto">
                <?php echo $info->code ?>
            </div>
            <?php } ?>
            <?php if (empty($info->code) && !empty($info->description)){ ?>
            <div class="desc col-11 col-lg-8 mx-auto">
                <?php echo $info->description ?>
            </div>
            <?php } ?>
        </div>

</div>
    <!-- End content -->
<!-- Start Footer  -->
<!--<div class="footer">-->
<!--    <div>-->
<!--        <a href="https://twitter.com/AbbasShDev" target="_blank"><i class="mr-2 p-1 fab fa-twitter"></i></a>-->
<!--        <a href="https://github.com/AbbasShDev" target="_blank"><i class="mr-2 p-1 fab fa-github "></i></a>-->
<!--        <a href="https://www.linkedin.com/in/abbas-alshaqaq-7b58221a5/" target="_blank"><i class="mr-2 p-1 fab fa-linkedin"></i></a>-->
<!--        Coded by AbbasShDev <span>2020 ©</span>-->
<!--    </div>-->
<!--</div>-->
<!-- End Footer  -->
</body>

<!-- jQuery js -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<!-- Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<!-- Bootstrap js -->
<script src="https://cdn.rtlcss.com/bootstrap/v4.2.1/js/bootstrap.min.js" integrity="sha384-a9xOd0rz8w0J8zqj1qJic7GPFfyMfoiuDjC9rqXlVOcGO/dmRqzMn34gZYDTel8k" crossorigin="anonymous"></script>
<!-- app js -->
<script src="<?php echo $config['app_url']?>layout/js/app.js" type="text/javascript"></script>
<script>

    $(document).ready(function () {

        //add to favourite
        $(document).on('submit', '.navbar-area.read-page .action-buttons .favourite', function (e) {
            e.preventDefault();

            let favBtn = $(this).find('button'),
                form   = $(this)

            let data = {favStatus:form.data('fav'), urlId: form.data('urlid')};
            $.post('fav_not_fav.php',{data:JSON.stringify(data)}).done(function (data) {
                if (data == 1){
                    form.data('fav', '1');
                    favBtn.html('');
                    favBtn.html('<i class="fas fa-star fa-lg fa-fw mx-2"></i><span class="">حذف من المفضلة</span>');
                    favBtn.find('i').addClass('iScale');
                    setTimeout(function () {
                        favBtn.find('i').removeClass('iScale');
                    },100)


                }else {
                    form.data('fav', '0')
                    favBtn.html('')
                    favBtn.html('<i class="far fa-star fa-lg fa-fw mx-2"></i><span class="">إضافة الى المفضلة</span>')
                    favBtn.find('i').addClass('iScale');
                    setTimeout(function () {
                        favBtn.find('i').removeClass('iScale');
                    },100)
                }

            }).fail(function () {
                $('.alert-normal p').html('حدث خطأ');
                $('.alert-normal').fadeIn().delay(3000).fadeOut();
            })
        });

        //add to archive
        $(document).on('submit', '.navbar-area.read-page .action-buttons .archive',  function (e) {
            e.preventDefault();

            let archiveBtn = $(this).find('button'),
                form   = $(this);

            let data = {archiveStatus:form.data('archive'), urlId: form.data('urlid')};
            $.post('add_archive.php',{data:JSON.stringify(data)}).done(function (data) {
                if (data == 1){
                    form.data('archive', '1');
                    archiveBtn.html('');
                    archiveBtn.html('<i class="fas fa-plus-square fa-lg fa-fw mx-2"></i><span class="">حذف من الإرشيف</span>');
                    archiveBtn.find('i').addClass('iScale');
                    setTimeout(function () {
                        archiveBtn.find('i').removeClass('iScale');
                    },100)

                }else {
                    form.data('archive', '0')
                    archiveBtn.html('')
                    archiveBtn.html('<i class="fas fa-archive fa-lg fa-fw mx-2"></i><span class="">إضافة الى الإرشيف</span>')
                    archiveBtn.find('i').addClass('iScale');
                    setTimeout(function () {
                        archiveBtn.find('i').removeClass('iScale');
                    },100)
                }

            }).fail(function () {
                $('.alert-normal p').html('حدث خطأ');
                $('.alert-normal').fadeIn().delay(3000).fadeOut();
            })
        })

        //remove
        $(document).on('submit', '.navbar-area.read-page .action-buttons .delete',  function (e) {
            e.preventDefault();
            $.post('read-actions.php',{urlId: $(this).data('urlid')}).done(function (data) {
                $('body').append(data);
                window.location.replace('<?php echo $_SERVER["HTTP_REFERER"]?>');
            }).fail(function () {
                $('.alert-normal p').html('حدث خطأ');
                $('.alert-normal').fadeIn().delay(3000).fadeOut();
            })
        })

        //add to section
        $(document).on('submit', '.modal .add-url-to-section',  function (e) {
            e.preventDefault();
            let data = {urlid:$(this).find('input').val(), 'selected-section': $(this).find('select').val()};
            $.post('read-actions.php',{data:JSON.stringify(data)}).done(function (data) {
                $('.modal .modal-footer .btn-secondary').click();
                $('.alert-success.alert-normal p').html(data);
                $('.alert-success.alert-normal').animate({
                        left:'10px'
                    },1000).delay(2000).animate({
                        left:'-300px'
                    },1000);
            }).fail(function () {
                $('.alert-normal p').html('حدث خطأ');
                $('.alert-normal').fadeIn().delay(3000).fadeOut();
            })
        })

    });


</script>
<?php

    }else{
        header("location:app.php");
        die();
    }
    }else{
    header("location:app.php");
    die();
}

ob_end_flush();
?>
