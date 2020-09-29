<?php
session_start();
require_once 'includes/config/database.php';
$pageTitle = '';


/* ==== notification message ==== */
if (isset($_SESSION['notify_message'])) {?>
    <div class="notify-message">
        <?php echo $_SESSION['notify_message'];?>
    </div>
<?php }
    unset($_SESSION['notify_message']);
/* ==== notification message ==== */
/* ====   error message ==== */
if (isset($_SESSION['error_message'])) { ?>
    <div class="notify-message bg-danger">
        <?php echo $_SESSION['error_message'];?>
    </div>
<?php }
unset($_SESSION['error_message']);
/* ====   error message ==== */


require_once 'includes/config/app.php';
include_once 'includes/templates/main-header.php';


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




    $st = $mysqli->prepare('INSERT INTO messages (name, email, message) VALUES (?,?,?)');

    $st->bind_param('sss', $dbName, $dbEmail, $dbMessage);
    $dbName = $name;
    $dbEmail = $email;
    $dbMessage = $message;



    if ($st->execute()){
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
            $_SESSION['notify_message'] = 'شكرا تم ارسال الرسالة';
            header('location:index.php');
            die();
        }else{
            $_SESSION['error_message'] = 'حدث خطأ أثناء إرسال الرسالة';
            header('location:index.php');
            die();
        }
    }else{
        $_SESSION['error_message'] = 'حدث خطأ أثناء إرسال الرسالة';
        header('location:index.php');
        die();
    }

}

}

if (!isset($_SESSION['user_name'])) {
?>

    <!-- Start header -->
    <section class="header">

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
                                <a class="nav-link scroll font-head" href="" data-scroll="about-us">ماهو مفضلتي؟</a>
                            </li>
                            <li class="nav-item pr-lg-4 mx-auto">
                                <a class="nav-link scroll font-head " href="" data-scroll="contact">تواصل معنا</a>
                            </li>
                            <li class="nav-item  mx-auto">
                                <a href="login.php"><button class="nav-link btn font-head login-btn">دخول</button></a>
                                <a href="register.php"><button class="nav-link btn btn-success font-head ">تسجيل</button></a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div> <!-- container -->
        </div> <!-- navbar area -->
    <div class="header-area"></div>

        <div class="hero">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-7 order-1 order-lg-0 animate__animated wow animate__fadeInRight" data-wow-duration="1s" >
                    <img class="hero-image img-fluid" src="layout/images/hero-img.png" alt="">
                </div>
                <div class="col-10 col-lg-4 mx-auto animate__animated wow animate__fadeInLeft" data-wow-duration="2s">
                    <div class="intro text-center order-0 order-lg-1">
                        <h4 class="text-center font-head">إجمع كل ما تفضل من محتوى في مكان واحد</h4>
                        <a href="register.php"><button class="btn btn-success mt-4 font-head" href="#">تسجيل</button></a>
                        <a href="login.php"><button class="btn btn-primary mt-4 font-head" href="#">دخول</button></a>
                    </div>
                </div>

            </div>
        </div>
        </div>
</section>
<!-- End header -->

<!-- Start about -->
<div id="about-us" class="section about container text-center col-12 ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-10 col-lg-6 mx-auto px-0 animate__animated wow animate__rotateIn" data-wow-duration="1s" data-wow-delay="0.3s">
                <div class="about-us text-center order-0 order-lg-1">
                    <h1 class="font-head">ماهو <span>مفضلتي</span></h1>
                    <p class="pt-5 col-12 col-lg-10 mx-auto px-0">هي خدمة لحفظ وتجميع المحتوى من الانترنت في مكان واحد. يمكن حفظ المقالات و الفيديوهات او اي صفحة. كما يمكن انشاء القوائم الخاصة بك واضافة المحتوى اليها. اضاف اي محتوى من الانترنت وتمتع به في اي وقت، في مكان واحد.</p>
                </div>
            </div>
            <div class="col-lg-6 order-1 order-lg-0 animate__animated wow animate__fadeInUp" data-wow-duration="1s" data-wow-delay="0.3s">
                <img class="img-fluid" src="layout/images/about-us.png" alt="">
            </div>

        </div>
    </div>
</div>
<!-- End about -->

<!-- Start contact -->
<div id="contact" class="section contact">
    <h1 class="pb-1 text-center font-head animate__animated wow animate__fadeInLeftBig" data-wow-duration="1s" data-wow-delay="0.3s">تواصل منا</h1>
    <div class="container col-10 col-md-8 col-lg-6 mt-5 mx-auto p-4 animate__animated wow animate__fadeInRightBig" data-wow-duration="1s" data-wow-delay="0.3s">
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" >
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
    <script src="layout/js/wow.min.js"></script>
    <script>
        new WOW().init();
    </script>

<?php
} else {
    header('location:app.php');
    die();
}
    include_once 'includes/templates/main-footer.php';


?>