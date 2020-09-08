<?php
include_once 'includes/templates/main-header.php';
?>
    <!-- Start header -->
    <div class="navbar-area" style="background-color: #3f64b5">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand" href="index.php"><img class="logo" src="layout/images/logo-dark.png" alt=""></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="toggler-icon"></span>
                    <span class="toggler-icon"></span>
                    <span class="toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse py-3" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto ">
                        <li class="nav-item mx-auto">
                            <a class="nav-link font-head" href="index.php">ماهو مفضلتي؟</a>
                        </li>
                        <li class="nav-item pr-lg-4 mx-auto">
                            <a class="nav-link font-head " href="index.php">تواصل معنا</a>
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

    <div class="login-register">

<!--            <div class="alert alert-danger col-10 col-lg-4 mx-auto"></div>-->

        <!-- login-register -->
        <div class="container col-10 col-lg-4 login-page">
            <img class="mx-auto d-block my-3" src="layout/images/logo.png" alt="">
            <p class="text-center font-head ">تسجيل دخول</p>

            <form class="sign" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                <div class="input-container"><input type="email" name="email" class="form-control mb-3" placeholder="البريد الإلكتروني" required="required"></div>
                <div class="input-container"><input type="password" name="pass" class="form-control mb-3" autocomplete="new-password" placeholder="كلمة المرور" required="required"></div>
                <input type="submit" class="btn btn-block" name="login" value="دخول">

            </form>

            <p class="pt-3"><a class="font-head" href="#">هل نسيت كلمة المرور؟</a></p>

        </div>
    </div>


<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $email          = $_POST['email'];
    $pass           = $_POST['pass'];

    echo $email;
    echo $pass;


}

include_once 'includes/templates/main-footer.php'; ?>