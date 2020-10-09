<!doctype html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="هي خدمة لحفظ وتجميع المحتوى من الانترنت في مكان واحد. يمكن حفظ المقالات و الفيديوهات او اي صفحة. كما يمكن انشاء القوائم الخاصة بك واضافة المحتوى اليها. اضاف اي محتوى من الانترنت وتمتع به في اي وقت، في مكان واحد.">
    <meta name="author" content="AbbasShDev @AbbasShDev">
    <link rel="icon" type="image/png" href="<?php echo $config['app_url']?>layout/images/favicon.svg">
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
    <!-- Bootstrap css -->
    <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap.min.css" integrity="sha384-vus3nQHTD+5mpDiZ4rkEPlnkcyTP+49BhJ4wJeJunw06ZAp+wzzeBPUXr42fi8If" crossorigin="anonymous">
    <!-- animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <!-- main CSS -->
    <link rel="stylesheet" href="<?php echo $config['app_url']?>layout/css/main.css">
    <title><?php echo "$config[app_name] $pageTitle"?></title>
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
<!-- End messages -->
