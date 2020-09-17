<?php
session_start();
$pageTitle = "| المفضلة";
require_once 'includes/config/database.php';
require_once 'includes/config/app.php';
require_once 'includes/templates/app-header.php';

if (!isset($_SESSION['user_name'])){
    header('location:index.php');
    die();
}
//
//$userId = $_SESSION['user_id'];
//$stat = $mysqli->query("SELECT * FROM urls WHERE user_id=$userId ORDER BY url_id DESC");
//$urls = $stat->fetch_all(MYSQLI_ASSOC);


?>
<!-- Start content -->
<div class="content">
    <div class="container col-11">
        <div class="row justify-content-around justify-content-md-start pb-5">
            <div class="loader-bg">
                <img src="layout/images/preloader.gif" alt="">
            </div>
<!--            --><?php //foreach ($urls as $url): ?>
<!--                <div class="col-12 col-md-6 col-lg-4 mt-5">-->
<!--                    <div class="card border-top-0 border-right-0 border-left-0 mx-auto">-->
<!--                        <img class="card-img-top" src="--><?php //echo $url['url_image'] ?><!--" alt="Card image cap">-->
<!--                        <div class="card-body px-0 pb-3">-->
<!--                            <h5 class="card-title">--><?php //echo $url['url_title'] ?><!--</h5>-->
<!--                            <p class="provider-name mb-2"><a href="--><?php //echo $url['url_providerUrl'] ?><!--" target="_blank">--><?php //echo $url['url_providerName'] ?><!--</a></p>-->
<!--                            <p class="card-text">-->
<!--                                --><?php //echo $url['url_description'] ?>
<!--                            </p>-->
<!--                            <img class="rounded-circle header-profile-img float-right"  src="--><?php //echo $url['url_providerIcon'] ?><!--" alt="">-->
<!--                            <div class="action-btn float-left">-->
<!--                                <i class="far fa-heart">-->
<!--                                    <span class="badge">إضافة الى المفضلة</span>-->
<!--                                </i>-->
<!--                                <i class="fas fa-file-archive pl-1">-->
<!--                                    <span class="badge">إضافة الى الإرشيف</span>-->
<!--                                </i>-->
<!--                                <i class="text-danger fas fa-trash-alt pl-1">-->
<!--                                    <span class="badge badge-pill">حذف</span>-->
<!--                                </i>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            --><?php //endforeach; ?>
        </div>
    </div>
</div>

<!-- End content -->
<?php require_once 'includes/templates/app-footer.php'?>
</html>
