<?php
ob_start();

if (!isset($_SESSION['user_name'])){
    header('location:index.php');
    die();
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <meta name="author" content="AbbasShDev @AbbasShDev">
    <link rel="icon" type="image/png" href="<?php echo $config['app_url']?>layout/images/favicon.svg">
    <title><?php echo "$config[app_name] $pageTitle" ?></title>
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
    <!-- Bootstrap css -->
    <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap.min.css" integrity="sha384-vus3nQHTD+5mpDiZ4rkEPlnkcyTP+49BhJ4wJeJunw06ZAp+wzzeBPUXr42fi8If" crossorigin="anonymous">
    <!-- app css -->
    <link href="<?php echo $config['app_url']?>layout/css/app.css" rel="stylesheet" />
</head>

<body>
<!-- start scroll-up -->
<div class="scroll-up">
    <i class="fas fa-chevron-up fa-fw"></i>
</div>
<!-- End scroll-up -->
<!-- Start messages -->
<!-- Start notification message -->
<?php if (isset($_SESSION['notify_message'])) {?>
    <div class="notify-message">
        <?php echo $_SESSION['notify_message'];?>
    </div>
<?php }
unset($_SESSION['notify_message']); ?>
<!-- End notification message -->
<!-- Start error message -->
<?php if (isset($_SESSION['error_message'])) {?>
    <div class="notify-message bg-danger">
        <?php echo $_SESSION['error_message'];?>
    </div>
<?php }
unset($_SESSION['error_message']); ?>
<!-- End error message -->
<div class="alert alert-danger alert-normal">
    <p class="m-0"></p>
</div>
<!-- End messages -->
<!-- Start sidebar -->
<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="hide-sidebar">
            <i class="fas fa-chevron-right"></i>
        </div>

        <ul class="nav all">
            <?php if ($_SESSION['user_role'] == 'admin'){ ?>
            <li class="pr-3 pr-lg-0">
                <a class="nav-link text-left my-3 dashboard" href="<?php echo $config['app_url']?>admin/login.php">
                    <i class="fas fa-tachometer-alt fa-fw"></i>
                    لوحة التحكم
                </a>
            </li>
            <?php } ?>
            <li class="pr-3 pr-lg-0">
                <a class="nav-link text-left my-3 <?php if ($pageTitle == "| الرئيسية") { echo 'active';}else{ echo '';}?>" href="<?php echo $config['app_url']?>app.php">
                    <i class="fas fa-home fa-fw"></i>
                    الكل
                </a>
            </li>
        </ul>
        <h4 class="font-head mt-4">قوائمي</h4>
        <ul class="nav my-list">
                <form class="add-section" action="">
                    <input type="text" name="add-section" placeholder="اضافة قائمة جديدة">
                    <button type="submit">
                        <i class="fas fa-plus-circle"></i>
                        <i class="fas fa-spinner fa-spin"></i>
                    </button>
                </form>

            <?php
            $userId = $_SESSION['user_id'];
            $stat = $mysqli->query("SELECT * FROM sections WHERE user_id=$userId");
            $sections = $stat->fetch_all(MYSQLI_ASSOC);

            foreach ($sections as $section){?>
            <li class="sections pr-3 pr-lg-0" data-sectionId="<?php echo $section['section_id']?>" data-sectionname="<?php echo $section['section_name']?>">
                <a class="nav-link text-left my-3 <?php if ($pageTitle == "| $section[section_name]") { echo 'active';}else{ echo '';}?> " href="section.php?section_id=<?php echo $section['section_id']?>">
                    <i class="fas fa-th-list fa-fw pr-1"></i>
                    <?php echo $section['section_name']?>
                    <div class="dropright float-right">
                        <div class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v float-right"></i>
                        </div>
                        <div class="dropdown-menu">
                            <div class="dropdown-item px-0">
                                <div class="rename-section" data-toggle="modal" data-target="#rename-section" data-sectionid="<?php echo $section['section_id']?>" data-sectionname="<?php echo $section['section_name']?>">
                                    <i class="fas fa-edit fa-lg fa-fw mx-2"></i><span class="">إعادة تسمية</span>
                                </div>
                            </div>
                            <div class="dropdown-item px-0">
                                <form action="<?php echo $_SERVER['REQUEST_URI'] ?>" class="" method="post">
                                    <input type="hidden" name="sectionId" value="<?php echo $section['section_id']?>">
                                    <button type="submit" name="delete-section" onclick="return confirm('هل تريد حذف القائمة؟')">
                                        <i class="fas fa-trash-alt fa-lg fa-fw mx-2"></i><span class="">حذف القائمة</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </a>
            </li>
           <?php } ?>

        </ul>


        <h4 class="font-head mt-4">تصفية</h4>
        <ul class="nav">
            <li class="pr-3 pr-lg-0">
                <a class="nav-link text-left my-3 <?php if ($pageTitle == "| المفضلة") { echo 'active';}else{ echo '';}?>" href="<?php echo $config['app_url']?>favorite.php">
                    <i class="fas fa-star fa-fw"></i>
                    المفضلة
                </a>
            </li>
            <li class="pr-3 pr-lg-0">
                <a class="nav-link text-left my-3 <?php if ($pageTitle == "| الفيديوهات") { echo 'active';}else{ echo '';}?>" href="<?php echo $config['app_url']?>videos.php">
                    <i class="fas fa-video fa-fw"></i>
                    الفيديوهات
                </a>
            </li>
            <li class="pr-3 pr-lg-0">
                <a class="nav-link text-left my-3 <?php if ($pageTitle == "| الإرشيف") { echo 'active';}else{ echo '';}?>" href="<?php echo $config['app_url']?>archive.php">
                    <i class="fas fa-archive fa-fw"></i>
                    الإرشيف
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- End sidebar -->

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

            <?php if ($pageTitle == "| الرئيسية") {?>
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
            <?php }?>

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
                    <a class="dropdown-item" href="<?php echo $config['app_url']?>app.php"><i class="fas fa-user-circle fa-fw"></i> <?php echo $_SESSION['user_name'] ?></a>
                    <div class="dropdown-divider"></div>
                    <?php if ($_SESSION['user_role'] == 'admin'){ ?>
                    <a class="dropdown-item" href="<?php echo $config['app_url']?>admin/login.php"><i class="fas fa-tachometer-alt fa-fw"></i> لوحة التحكم</a>
                    <?php } ?>
                    <a class="dropdown-item" href="<?php echo $config['app_url']?>profile.php"><i class="fas fa-cog fa-fw"></i> حسابي</a>
                    <a class="dropdown-item text-danger" href="<?php echo $config['app_url']?>logout.php"><i class="fa fa-power-off fa-fw"></i> خروج</a>
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
                <button class="btn btn-primary ml-1" type="submit">بحث</button>
                <button class="close-search-add-form close-search btn btn-outline-secondary ml-3">إلغاء</button>
                <svg xmlns="http://www.w3.org/2000/svg" class="close-search-add-form close-search icon icon-tabler icon-tabler-x" width="32" height="32" viewBox="0 0 24 24" stroke-width="1.5" stroke="#3f64b5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z"/>
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>

            </form>
        </div>
    </nav>
</div>
<!-- End navbar -->

<!-- Start add-url-to-section -->
<div class="modal add-url-to-section" id="add-url-to-section" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="<?php echo $_SERVER['REQUEST_URI']?>" method="post" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenteredLabel">إضافة الرابط الى قائمة</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="urlid" value="">
                <select class="custom-select" name="selected-section">

                    <?php
                    $st = $mysqli->query("SELECT * FROM sections WHERE user_id=$userId");
                    $sections = $st->fetch_all(MYSQLI_ASSOC);
                    if (!empty($sections)){ ?>
                        <option selected disabled>اختر قائمة</option>

                        <?php foreach ($sections as $section):?>
                            <option value="<?php echo $section['section_id']?>"><?php echo $section['section_name']?></option>
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

<!-- Start rename-section -->
<div class="modal rename-section" id="rename-section" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" class="modal-content rename-section">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenteredLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="sectionid" value="">
                <input type="text" name="newSectionName" placeholder="الاسم الجديد">
            </div>
            <div class="modal-footer">
                <button type="submit" name="rename-section" class="btn btn-primary">حفظ التغيرات</button>
                <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">إلغاء</button>
            </div>
        </form>
    </div>
</div>
<!-- End rename-section -->

<?php

if (isset($_POST['delete_url'])){

    $urlId  = mysqli_real_escape_string($mysqli, $_POST['urlid']);
    $userId = mysqli_real_escape_string($mysqli, $_SESSION['user_id']);

    $query = "DELETE FROM urls WHERE url_id='$urlId' AND user_id='$userId'";
    if ($mysqli->query($query)){

        $_SESSION['error_message'] = "تم الحذف";
        header("location:$_SERVER[REQUEST_URI]");
        die();

    }
}

if (isset($_POST['add_to_section'])){


    $foundSection = $mysqli->prepare('SELECT * FROM urls WHERE section_id=? AND url_id =?');
    $foundSection->bind_param('ii',$sectionId, $urlId );
    $urlId      = $_POST['urlid'];
    $sectionId  = $_POST['selected-section'];
    $foundSection->execute();
    $result = $foundSection->get_result();


    if ($result->num_rows == 0){

        $upSection = $mysqli->prepare("UPDATE urls SET section_id=? WHERE url_id =?");
        $upSection->bind_param('ii',$sectionId, $urlId );
        $urlId      = $_POST['urlid'];
        $sectionId  = $_POST['selected-section'];

        if ($upSection->execute()){
            $_SESSION['notify_message'] = "تمت الاضافة في القائمة";
            header("location:$_SERVER[REQUEST_URI]");
            die();
        }
    }else{
        $_SESSION['error_message'] = "مضاف في نفس القائمة مسباقاً";
        header("location:$_SERVER[REQUEST_URI]");
        die();
    }


}


if (isset($_POST['delete-url-section'])){


    $stat = $mysqli->prepare("UPDATE urls SET section_id = NULL WHERE url_id=? AND user_id=?");
    $stat->bind_param('ii', $url_id, $user_id);
    $url_id  = $_POST['urlId'];
    $user_id = $_SESSION['user_id'];
    if ($stat->execute()){

        $_SESSION['error_message'] = "تم الحذف من القائمة";
        header("location:$_SERVER[REQUEST_URI]");
        die();

    }
}

if (isset($_POST['delete-section'])){


    $stat = $mysqli->prepare("DELETE FROM sections WHERE section_id=?");
    $stat->bind_param('i', $sectionId);
    $sectionId  = $_POST['sectionId'];

    if ($stat->execute()){

        $_SESSION['error_message'] = "تم حذف القائمة";
        header("location:$_SERVER[HTTP_REFERER]");
        die();

    }
}

if (isset($_POST['rename-section'])){

    $foundSection = $mysqli->prepare('SELECT * FROM sections WHERE section_name=? AND user_id=?');
    $foundSection->bind_param('si', $sectionNewName, $user_id );
    $sectionNewName     = $_POST['newSectionName'];
    $user_id            = $_SESSION['user_id'];
    $foundSection->execute();
    $result = $foundSection->get_result();


    if ($result->num_rows == 0){

        $stat = $mysqli->prepare("UPDATE sections SET section_name=? WHERE section_id=?");
        $stat->bind_param('si', $sectionNewName,$sectionId );
        $sectionNewName     = $_POST['newSectionName'];
        $sectionId          = $_POST['sectionid'];

        if ($stat->execute()){

            $_SESSION['notify_message'] = "تم إعادة تسمية القائمة";
            header("location:$_SERVER[HTTP_REFERER]");
            die();

        }
    }else{
        $_SESSION['error_message'] = "الاسم موجود مسبقاُ";
        header("location:$_SERVER[HTTP_REFERER]");
        die();
    }

}
?>