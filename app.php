<?php
session_start();
require_once 'includes/config/database.php';


if (isset($_SESSION['user_name'])){
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title></title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!-- Bootstrap css -->
    <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap.min.css" integrity="sha384-vus3nQHTD+5mpDiZ4rkEPlnkcyTP+49BhJ4wJeJunw06ZAp+wzzeBPUXr42fi8If" crossorigin="anonymous">
    <link href="layout/css/app.css" rel="stylesheet" />
</head>

<body>
<!--    notification message -->
<?php if (isset($_SESSION['notify_message'])) {?>
    <div class="notify-message">
        <?php echo $_SESSION['notify_message'];?>
    </div>
<?php }
    unset($_SESSION['notify_message']); ?>
<!--    notification message -->
<div class="alert alert-danger alert-normal">
    <p class="m-0"></p>
</div>
    <div class="sidebar" data-image="../assets/img/sidebar-5.jpg">
        <div class="sidebar-wrapper">
            <div class="hide-sidebar">
                <i class="fas fa-chevron-right"></i>
            </div>
            <ul class="nav">
                <li class="pr-3 pr-lg-0">
                    <a class="nav-link text-left my-3 active" href="#">
                        <i class="fas fa-home fa-fw"></i>
                        قوائمي
                    </a>
                </li>
                <li class="pr-3 pr-lg-0">
                    <a class="nav-link text-left my-3 " href="#">
                        <i class="fas fa-star fa-fw"></i>
                        المفضلة
                    </a>
                </li>
                <li class="pr-3 pr-lg-0">
                    <a class="nav-link text-left my-3" href="#">
                        <i class="fas fa-video fa-fw"></i>
                        الفيديوهات
                    </a>
                </li>
                <li class="pr-3 pr-lg-0">
                    <a class="nav-link text-left my-3" href="#">
                        <i class="fas fa-file-alt  fa-fw"></i>
                        المقالات
                    </a>
                </li>
                <li class="pr-3 pr-lg-0">
                    <a class="nav-link text-left my-3" href="#">
                        <i class="fas fa-file-archive fa-fw"></i>
                        الإرشيف
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <!-- Start navbar-->
    <div class="navbar-area">
        <nav class="navbar col-12 mx-auto">
            <div class="container px-0">

                <div class="sidebar-toggler pr-2">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>

                <a class="navbar-brand m-0" href="app.php"><img class="logo" src="layout/images/logo.png" alt=""></a>

                <div class=" row ml-auto ml-sm-0 mr-sm-auto pr-4 pr-sm-0">
                    <div class="nav-item mx-auto order-1 order-sm-0">
                        <a class="nav-link p-0 pl-3 add-url-icon" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" stroke-width="1.5" stroke="#3f64b5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z"/>
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <line x1="5" y1="12" x2="19" y2="12" />
                            </svg>
                        </a>
                    </div>
                    <div class="nav-item mx-auto order-0 order-sm-1">
                        <a class="nav-link p-0 pl-2 search-url-icon" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg"  width="32" height="32" viewBox="0 0 24 24" stroke-width="1.5" stroke="#3f64b5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z"/>
                                <circle cx="10" cy="10" r="7" />
                                <line x1="21" y1="21" x2="15" y2="15" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="nav-item dropdown profile-dropdown">
                    <a class="nav-link dropdown-toggle p-0" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="rounded-circle header-profile-img" style="height: 40px !important; width: 40px !important;" src="
                        <?php if (isset($_SESSION['avatar']) && !empty($_SESSION['avatar'])){
                            echo $_SESSION['avatar'];
                        }else{
                            echo 'uploads/avatars/default.png';
                        }
                        ?>"
                        alt="">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="app.php"><i class="fas fa-user-circle fa-fw"></i> <?php echo $_SESSION['user_name'] ?></a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="profile.php"><i class="fas fa-cog fa-fw"></i> حسابي</a>
                        <a class="dropdown-item text-danger" href="logout.php"><i class="fa fa-power-off fa-fw"></i> خروج</a>
                    </div>
                </div>
                    <form class="add-url nav-item ml-auto" action="">

                        <input type="text" class="" placeholder="حفظ رابط (URL) ...">
                        <button class="btn btn-primary ml-1 save-btn">حفظ</button>
                        <button class="close-search-add-form btn btn-outline-secondary ml-3">إلغاء</button>

                            <svg xmlns="http://www.w3.org/2000/svg" class="close-search-add-form" width="32" height="32" viewBox="0 0 24 24" stroke-width="1.5" stroke="#3f64b5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z"/>
                                <line x1="18" y1="6" x2="6" y2="18" />
                                <line x1="6" y1="6" x2="18" y2="18" />
                            </svg>

                </form>

                <form class="search-url nav-item ml-auto" action="">

                        <input type="text" class="" placeholder="بحث ...">
                        <button class="btn btn-primary ml-1" type="submit">حفظ</button>
                        <button class="close-search-add-form btn btn-outline-secondary ml-3">إلغاء</button>
                        <svg xmlns="http://www.w3.org/2000/svg" class="close-search-add-form icon icon-tabler icon-tabler-x" width="32" height="32" viewBox="0 0 24 24" stroke-width="1.5" stroke="#3f64b5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z"/>
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>

                    </form>
            </div>
        </nav>
</div>
    <!-- End navbar -->

        <!-- Start content -->
        <div class="content">
            <div class="container col-11">
                <div class="row justify-content-around justify-content-md-start pb-5">
                    <div class="loader-bg">
                        <img src="layout/images/preloader.gif" alt="">
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 mt-5">
                        <div class="card border-top-0 border-right-0 border-left-0 mx-auto">
                            <img class="card-img-top" src="https://res.cloudinary.com/practicaldev/image/fetch/s--6AFlf9Ki--/c_imagga_scale,f_auto,fl_progressive,h_500,q_auto,w_1000/https:/dev-to-uploads.s3.amazonaws.com/i/ol50x6e5im0w9aou9lsl.png" alt="Card image cap">
                            <div class="card-body px-0 pb-3">
                                <!-- 59-->
                                <h5 class="card-title">Parse Url And Get Components Practical Example on Parse You...</h5>
<!--                                35-->
                                <p class="provider-name mb-2"><a href="https://www.youtube.com" target="_blank">youtube</a></p>
                                <!-- 100-->
                                <p class="card-text">
                                    Parse Url And Get Compqwertyuioplkjhgonents Practical Example on Parse Youtube Url and Get
                                    The Video ID and Embed Vi...
                                </p>
                                <img class="rounded-circle header-profile-img float-right"  src="https://abs.twimg.com/responsive-web/client-web-legacy/icon-ios.8ea219d5.png" alt="">
                                <div class="action-btn float-left">
                                    <i class="far fa-heart">
                                        <span class="badge">إضافة الى المفضلة</span>
                                    </i>
                                    <i class="fas fa-file-archive pl-1">
                                        <span class="badge">إضافة الى الإرشيف</span>
                                    </i>
                                    <i class="text-danger fas fa-trash-alt pl-1">
                                        <span class="badge badge-pill">حذف</span>
                                    </i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 mt-5 mx-auto mx-lg-0">
                        <div class="card border-top-0 border-right-0 border-left-0 mx-auto">
                            <img class="card-img-top" src="layout/images/default-url-img.png" alt="">
                            <div class="card-body px-0 pb-3">
                                <!-- 50-->
                                <h5 class="card-title">حادث تصادم عنيف بين يونايتد إكسبريس 5925 وطائرة خاصة صغييرة...</h5>
                                <p class="provider-name">youtube</p>
                                <!-- 100-->
                                <p class="card-text">
                                    حادث تصادم عنيف بين يونايتد إكسبريس 5925 وطائرة خاصة صغيالبيسشضصثقفغعهخرة تُوقِع المحققين في حالةٍ من الارتباك حتى يعل...
                                </p>
                                <img class="rounded-circle header-profile-img float-right" src="https://abs.twimg.com/responsive-web/client-web-legacy/icon-ios.8ea219d5.png" alt="">
                                <div class="action-btn float-left">
                                    <i class="far fa-heart">
                                        <span class="badge">إضافة الى المفضلة</span>
                                    </i>
                                    <i class="fas fa-file-archive pl-1">
                                        <span class="badge">إضافة الى الإرشيف</span>
                                    </i>
                                    <i class="text-danger fas fa-trash-alt pl-1">
                                        <span class="badge badge-pill">حذف</span>
                                    </i>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- End content -->

        <!-- Start footer -->
        <footer class="footer">

        </footer>
        <!-- End footer -->
</body>

<!-- font awesome -->
<script src="https://kit.fontawesome.com/6652aa2ce8.js" crossorigin="anonymous"></script>
<!-- jQuery js -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<!-- Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<!-- Bootstrap js -->
<script src="https://cdn.rtlcss.com/bootstrap/v4.2.1/js/bootstrap.min.js" integrity="sha384-a9xOd0rz8w0J8zqj1qJic7GPFfyMfoiuDjC9rqXlVOcGO/dmRqzMn34gZYDTel8k" crossorigin="anonymous"></script>
<!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
<script src="layout/js/app.js" type="text/javascript"></script>
<script>
    $(document).ready(function () {

        $('.add-url').on('submit', function (e) {
            e.preventDefault();
            let addValue = $(this).find('input').val()
            if (addValue != ''){
                $.ajax({
                    method: 'POST',
                    url:'add-url.php',
                    data:{url: addValue},
                    beforeSend: function () {
                        $('.content .container .row .loader-bg').fadeIn();
                    },
                    success:function (data) {
                        $('.add-url input').val('');
                        $('.content .container .row .loader-bg').fadeOut();
                        $('.content .container .row').prepend(data);

                        $('.alert-ajax').show().delay(3000).remove();
                    },
                    error:function (xhr, status, error) {
                        $('.alert-normal p').html(error);
                        $('.alert-normal').fadeIn().delay(3000).fadeOut();
                    }
                })
            }else {
                $('.alert-normal p').html('حقل ادخال الرابط فارغ');
                $('.alert-normal').fadeIn().delay(3000).fadeOut();
            }

        })

    })
</script>
</html>
<?php }else{
    echo 'You can not access this page';
} ?>