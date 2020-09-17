<?php
session_start();
$pageTitle = "| الرئيسية";
require_once 'includes/config/database.php';
require_once 'includes/config/app.php';
require_once 'includes/templates/app-header.php';

if (!isset($_SESSION['user_name'])){
    header('location:index.php');
    die();
}

    $userId = $_SESSION['user_id'];
    $stat = $mysqli->query("SELECT * FROM urls WHERE user_id=$userId ORDER BY url_id DESC");
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
                            <!-- 59-->
                            <h5 class="card-title"><?php echo $url['url_title'] ?></h5>
<!--                                35-->
                            <p class="provider-name mb-2"><a href="<?php echo $url['url_providerUrl'] ?>" target="_blank"><?php echo $url['url_providerName'] ?></a></p>
                            <!-- 100-->
                            <p class="card-text">
                                <?php echo $url['url_description'] ?>
                            </p>
                            <img class="rounded-circle header-profile-img float-right"  src="<?php echo $url['url_providerIcon'] ?>" alt="">
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
        <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- End content -->
<?php require_once 'includes/templates/app-footer.php'?>
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

                        $('.alert-ajax').delay(500).fadeIn().delay(3000).fadeOut(10, function () {
                            $(this).remove();
                        });
                    },
                    error:function (xhr, status, error) {
                        $('.content .container .row .loader-bg').hide();
                        $('.alert-normal p').html(error);
                        $('.alert-normal').fadeIn().delay(3000).fadeOut();
                    }
                })
            }else {
                $('.alert-normal p').html('حقل ادخال الرابط فارغ');
                $('.alert-normal').fadeIn().delay(3000).fadeOut();
            }

        })

        $('.search-url').on('submit', function (e) {
            e.preventDefault();
            let contentBeforeSearch = $('.content .container .row').html();
            let searchValue = $(this).find('input').val()
            if (searchValue != ''){
                $.ajax({
                    method: 'POST',
                    url:'search-url.php',
                    data:{search: searchValue},
                    beforeSend: function () {
                         $('.content .container .row .loader-bg').show();
                    },
                    success:function (data) {
                        $('.search-url input').val('');
                         $('.content .container .row .loader-bg').hide();
                        $('.content .container .row').html('');
                        $('.content .container .row').prepend(data);

                    },
                    error:function (xhr, status, error) {
                        $('.content .container .row .loader-bg').hide();
                        $('.alert-normal p').html(error);
                        $('.alert-normal').fadeIn().delay(3000).fadeOut();
                    }
                })
            }else {
                $('.alert-normal p').html('حقل البحث فارغ');
                $('.alert-normal').fadeIn().delay(3000).fadeOut();
            }

            $(this).find('.close-search').on('click', function () {

                $('.content .container .row').html(contentBeforeSearch);

            })
        })

    })
</script>
</html>
