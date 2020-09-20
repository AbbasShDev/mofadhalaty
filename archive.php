<?php
session_start();
$pageTitle = "| الإرشيف";
require_once 'includes/config/database.php';
require_once 'includes/config/app.php';
require_once 'includes/templates/app-header.php';

if (!isset($_SESSION['user_name'])){
    header('location:index.php');
    die();
}

$userId = $_SESSION['user_id'];
$stat = $mysqli->query("SELECT * FROM urls WHERE user_id=$userId AND url_archive=1 ORDER BY url_id DESC");
$urls = $stat->fetch_all(MYSQLI_ASSOC);


?>
<!-- Start content -->
<div class="content">
    <div class="container col-11">
        <div class="row justify-content-around justify-content-md-start pb-5">
            <div class="loader-bg">
                <img src="layout/images/preloader.gif" alt="">
            </div>
            <?php foreach ($urls as $url): ?>
                <div class="col-12 col-md-6 col-lg-4 mt-5">
                    <div class="card border-top-0 border-right-0 border-left-0 mx-auto">
                        <img class="card-img-top" src="<?php echo $url['url_image'] ?>" alt="Card image cap">
                        <div class="card-body px-0 pb-3">
                            <h5 class="card-title"><?php echo $url['url_title'] ?></h5>
                            <p class="provider-name mb-2"><a href="<?php echo $url['url_providerUrl'] ?>" target="_blank"><?php echo $url['url_providerName'] ?></a></p>
                            <p class="card-text">
                                <?php echo $url['url_description'] ?>
                            </p>
                            <img class="rounded-circle header-profile-img float-right"  src="<?php echo $url['url_providerIcon'] ?>" alt="">
                            <div class="action-btn float-left">
                                <form action="" class="favourite" method="post" data-fav="<?php echo $url['url_favourite']?>" data-urlid="<?php echo $url['url_id']?>" >
                                    <button>
                                        <?php if ($url['url_favourite'] == 0){ ?>
                                            <i class="far fa-star"><span class="badge">إضافة الى المفضلة</span></i>
                                        <?php }else{?>
                                            <i class="fas fa-star"><span class="badge">حذف من المفضلة</span></i>
                                        <?php } ?>
                                    </button>
                                </form>
                                <form action="" class="archive" method="post" data-archive="<?php echo $url['url_archive']?>" data-urlid="<?php echo $url['url_id']?>" >
                                    <button>
                                        <?php if ($url['url_archive'] == 0){ ?>
                                            <i class="fas fa-minus-circle pl-1"><span class="badge">إضافة الى الإرشيف</span></i>
                                        <?php }else{?>
                                            <i class="fas fa-plus-circle pl-1"><span class="badge">حذف من الإرشيف</span></i>
                                        <?php } ?>
                                    </button>
                                </form>
                                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" class="" method="post" data-fav="<?php echo $url['url_favourite']?>" data-urlid="<?php echo $url['url_id']?>" >
                                    <input type="hidden" name="urlid" value="<?php echo $url['url_id']?>">
                                    <button type="submit" name="delete_url" onclick="return confirm('هل تريد الحذف؟')">
                                        <i class="text-danger fas fa-trash-alt pl-1">
                                            <span class="badge badge-pill">حذف</span>
                                        </i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- End content -->
<?php require_once 'includes/templates/app-footer.php'?>
</html>
