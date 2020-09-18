<?php
ob_start();

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title><?php echo "$config[app_name] $pageTitle"?></title>
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
                <a class="nav-link text-left my-3 <?php if ($pageTitle == "| الرئيسية") { echo 'active';}else{ echo '';}?>" href="<?php echo $config['app_url']?>app.php">
                    <i class="fas fa-home fa-fw"></i>
                    قوائمي
                </a>
            </li>
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
                <a class="nav-link text-left my-3  <?php if ($pageTitle == "| اخرى") { echo 'active';}else{ echo '';}?>" href="<?php echo $config['app_url']?>other_url.php">
                    <i class="fas fa-file-alt  fa-fw"></i>
                    اخرى
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