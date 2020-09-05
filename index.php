<?php
$nameError = $emailError = $messageError = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){


$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);

if (!$name) {
    $_SESSION['contact_form']['name'] = '';
    $nameError = 'يجب كتابة اسم' ;
}else{
    $_SESSION['contact_form']['name'] = $name;
}

$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);


if (!$email) {
    $_SESSION['contact_form']['email'] = '';
    $emailError = 'ايميل غير صالح';
}else{
    $_SESSION['contact_form']['email'] = $email;
}

$message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

if (!$message) {
    $_SESSION['contact_form']['message'] = '';
    $messageError = 'يجب كتابة رسالة' ;
}else {
    $_SESSION['contact_form']['message'] = $message;
}

if (!$nameError && !$emailError && !$messageError){

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=UFT-8' . "\r\n";
    $headers .= 'From: '.$email."\r\n".
        'Reply-To: '.$email."\r\n" .
        'X-Mailer: PHP/' . phpversion();

    $messageHtml = '<html><body>';
    $messageHtml .= "<h4 style='color: #1b262c'>$name</h4>";
    $messageHtml .= "<p style='color: darkgreen'>$message</p>";
    $messageHtml .= '</body></html>';

    if (mail('abbas20alzaeem@gmail.com','رسالة من موقع مفضلتي', $messageHtml, $headers )){
        unset($_SESSION['contact_form']);
        echo "<script>alert('شكرا تم ارسال الرسالة')</script>";
    }else{
        echo "<script>alert('حدث خطأ أثناء إرسال الرسالة')</script>";
    }

}

}
?>

<!doctype html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- main CSS -->
    <link rel="stylesheet" href="layout/css/main.css">
    <!-- font awesome -->
    <script src="https://kit.fontawesome.com/6652aa2ce8.js" crossorigin="anonymous"></script>
    <!-- Bootstrap css -->
    <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap.min.css" integrity="sha384-vus3nQHTD+5mpDiZ4rkEPlnkcyTP+49BhJ4wJeJunw06ZAp+wzzeBPUXr42fi8If" crossorigin="anonymous">
    <!-- bootstrap-select CSS -->
<!--    <link rel="stylesheet"-->
<!--          href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">-->
    <title></title>
</head>
<body>

<!-- Start header -->
<section class="header">
    <div class="header-area"></div>
        <div class="navbar-area">
            <div class="container">
                <nav class="navbar navbar-expand-lg">
                    <a class="navbar-brand" href="index.php"><img class="logo" src="layout/images/logo.png" alt=""></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="toggler-icon"></span>
                        <span class="toggler-icon"></span>
                        <span class="toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse py-3" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto ">
                            <li class="nav-item mx-auto">
                                <a class="nav-link font-head" href="#">ماهو مفضلتي؟</a>
                            </li>
                            <li class="nav-item pr-lg-4 mx-auto">
                                <a class="nav-link font-head " href="#">تواصل معنا</a>
                            </li>
                            <li class="nav-item  mx-auto">
                                <button class="nav-link btn font-head " href="#">دخول</button>
                                <button class="nav-link btn btn-success font-head " href="#">تسجيل</button>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div> <!-- container -->
        </div> <!-- navbar area -->

        <div class="hero">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-7 order-1 order-lg-0">
                    <img class="hero-image img-fluid" src="layout/images/hero-img.png" alt="">
                </div>
                <div class="col-10 col-lg-4 mx-auto">
                    <div class="intro text-center order-0 order-lg-1">
                        <h4 class="text-center font-head">إجمع كل ما تفضل من محتوى في مكان واحد</h4>
                        <button class="btn btn-success mt-4 font-head" href="#">تسجيل</button>
                        <button class="btn btn-primary mt-4 font-head" href="#">دخول</button>
                    </div>
                </div>

            </div>
        </div>
        </div>
</section>
<!-- End header -->

<!-- Start about -->
<div id="about" class="section about container text-center col-12 ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-10 col-lg-6 mx-auto px-0">
                <div class="about-us text-center order-0 order-lg-1">
                    <h1 class="font-head">ماهو <span>مفضلتي</span></h1>
                    <p class="pt-5 col-12 col-lg-10 mx-auto px-0">هي خدمة لحفظ وتجميع المحتوى من الانترنت في مكان واحد. يمكن حفظ المقالات و الفيديوهات او اي صفحة. كما يمكن انشاء القوائم الخاصة بك واضافة المحتوى فيها.</p>
                </div>
            </div>
            <div class="col-lg-6 order-1 order-lg-0">
                <img class="img-fluid" src="layout/images/about-us.png" alt="">
            </div>

        </div>
    </div>
</div>
<!-- End about -->

<!-- Start contact -->
<div id="contact" class="section contact">
    <h1 class="pb-1 text-center font-head">تواصل منا</h1>
    <div class="container col-10 col-md-8 col-lg-6 mt-5 mx-auto p-4">
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data" >
            <div class="form-group">
                <label for="name" class="font-head">الإسم</label>
                <input type="text" class="form-control" name="name" value="<?php if (isset($_SESSION['contact_form']['name'])) echo $_SESSION['contact_form']['name']?>" placeholder="إسمك...">
                <span class="text-danger"><?php if(isset($nameError)){echo $nameError;}?></span>
            </div>
            <div class="form-group">
                <label for="email" class="font-head">الإيميل</label>
                <input type="email" class="form-control" name="email" value="<?php if (isset($_SESSION['contact_form']['email'])) echo $_SESSION['contact_form']['email']?>" placeholder="إيميلك...">
                <span class="text-danger"><?php if(isset($emailError)){echo $emailError;}?></span>
            </div>
            <div class="form-group">
                <label for="message" class="font-head">الرسالة</label>
                <textarea class="form-control" name="message" placeholder="رسالتك..."><?php if (isset($_SESSION['contact_form']['message'])) echo $_SESSION['contact_form']['message']?></textarea>
                <span class="text-danger"><?php if(isset($messageError)){echo $messageError;}?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="form-control btn p-0 font-head" id="Send Message" value="إرسال الرسالة">
            </div>
        </form>
    </div>
</div>
<!-- End contact -->


<!-- Start Footer  -->
<div class="footer">
    <div>
        <a href="https://twitter.com/AbbasShDev" target="_blank"><i class="mr-2 p-1 fab fa-twitter"></i></a>
        <a href="https://github.com/AbbasShDev" target="_blank"><i class="mr-2 p-1 fab fa-github "></i></a>
        <a href="https://www.linkedin.com/in/abbas-alshaqaq-7b58221a5/" target="_blank"><i class="mr-2 p-1 fab fa-linkedin"></i></a>  2020 AbbasShDev ©
    </div>
</div>
<!-- End Footer  -->


<!-- jQuery js -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<!-- Popper.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<!-- Bootstrap js -->
<script src="https://cdn.rtlcss.com/bootstrap/v4.2.1/js/bootstrap.min.js" integrity="sha384-a9xOd0rz8w0J8zqj1qJic7GPFfyMfoiuDjC9rqXlVOcGO/dmRqzMn34gZYDTel8k" crossorigin="anonymous"></script>
<!-- bootstrap-select JavaScript -->
<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>-->
<!-- main js -->
<script src="layout/js/main.js"></script>
</body>
</html>