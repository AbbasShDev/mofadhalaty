<?php
session_start();
$pageTitle = "| الفيديوهات";
require_once 'includes/config/database.php';
require_once 'includes/config/app.php';
require_once 'includes/templates/app-header.php';

if (!isset($_SESSION['user_name'])){
    header('location:index.php');
    die();
}

$userId = $_SESSION['user_id'];
$stat = $mysqli->query("SELECT urls.*, sections.section_name  FROM urls LEFT OUTER JOIN sections ON sections.section_id=urls.section_id WHERE urls.user_id=$userId AND urls.url_type='video' AND urls.url_archive=0 ORDER BY urls.url_id DESC");
$urls = $stat->fetch_all(MYSQLI_ASSOC);

if (!empty($urls)){
?>
<!-- Start content -->
<div class="content">
    <div class="container col-11">

        <h5 class="list-title mt-5 mb-4 text-center text-lg-left">الفيديوهات<span></span></h5>
        <div class="row justify-content-around justify-content-md-start pb-5">
            <div class="loader-bg">
                <img src="layout/images/preloader.gif" alt="">
            </div>
            <?php foreach ($urls as $url): ?>
                <div class="col-12 col-md-6 col-lg-4 mb-5">
                    <div class="card border-top-0 border-right-0 border-left-0 mx-auto">
                        <a href="read.php?url_id=<?php echo $url['url_id']?>"><img class="card-img-top" src="<?php echo $url['url_image'] ?>" alt="url_image"></a>
                        <div class="card-body px-0 pb-3">
                            <a href="read.php?url_id=<?php echo $url['url_id']?>"><h5 class="card-title font-head"><?php echo $url['url_title'] ?></h5></a>
                            <p class="provider-name mb-2"><a href="<?php echo $url['url_providerUrl'] ?>" target="_blank"><?php echo $url['url_providerName'] ?></a></p>
                            <p class="card-text">
                                <?php echo $url['url_description'] ?>
                            </p>

                            <img class="rounded-circle header-profile-img float-right"  src="<?php echo $url['url_providerIcon'] ?>" alt="">

                            <div class="fav-icon mr-2 float-right">
                                <?php if ($url['url_favourite'] == 1){ ?>
                                    <i class="fas fa-star fa-lg fa-fw"></i>
                                <?php }?>
                            </div>


                            <?php if (!empty($url['section_id'])){ ?>
                                <div class="list-badge float-right mx-2">
                                    <form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
                                        <input type="hidden" name="urlId" value="<?php echo $url['url_id'] ?>">
                                        <button type="submit" name="delete-url-section" onclick="return confirm('هل تريد الحذف من القائمة؟')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                    <span><?php echo $url['section_name'] ?></span>
                                </div>
                            <?php } ?>
                            <div class="action-btn float-left">
                                <div class="dropup">
                                    <div class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-h fa-lg"></i>
                                    </div>
                                    <div class="dropdown-menu">
                                        <div class="dropdown-item px-0">
                                            <form action="" class="favourite" method="post" data-fav="<?php echo $url['url_favourite']?>" data-urlid="<?php echo $url['url_id']?>" >
                                                <button>
                                                    <?php if ($url['url_favourite'] == 0){ ?>
                                                        <i class="far fa-star fa-lg fa-fw mx-2"></i><span class="">إضافة الى المفضلة</span>
                                                    <?php }else{?>
                                                        <i class="fas fa-star fa-lg fa-fw mx-2"></i><span class="">حذف من المفضلة</span>
                                                    <?php } ?>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="dropdown-item px-0">
                                            <form action="" class="archive" method="post" data-archive="<?php echo $url['url_archive']?>" data-urlid="<?php echo $url['url_id']?>" >
                                                <button>
                                                    <?php if ($url['url_archive'] == 0){ ?>
                                                        <i class="fas fa-archive fa-lg fa-fw mx-2"></i><span class="">إضافة الى الإرشيف</span>
                                                    <?php }else{?>
                                                        <i class="fas fa-plus-square fa-lg fa-fw mx-2"></i><span class="">حذف من الإرشيف</span>
                                                    <?php } ?>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="dropdown-item px-0">
                                            <form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
                                                <button type="submit" name="delete_url" onclick="return confirm('هل تريد الحذف؟')">
                                                    <i class="fas fa-trash-alt fa-lg fa-fw mx-2"></i><span class="">حذف</span>
                                                </button>
                                                <input type="hidden" name="urlid" value="<?php echo $url['url_id']?>">
                                            </form>
                                        </div>
                                        <div class="dropdown-item px-0">
                                            <div class="add-section-toggler" data-toggle="modal" data-target="#add-url-to-section" data-urlid="<?php echo $url['url_id']?>">
                                                <i class="fas fa-th-list fa-lg fa-fw mx-2"></i><span class="">إضافة الى قائمة</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- End content -->
<?php }else{ ?>
<!-- Start content -->
<div class="content">
    <div class="container col-11">
        <h5 class="list-title mt-5 mb-4 text-center text-lg-left">الفيديوهات<span></span></h5>
        <div class="row justify-content-around justify-content-md-start pb-5">
            <div class="empty-result mx-auto">
                <div>
                <i class="fas fa-video fa-lg"></i>
                <p class="font-head">لم يتم اضافة اي عناوين في هذا القسم</p>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- End content -->
<?php }
require_once 'includes/templates/app-footer.php'; ?>
</html>
