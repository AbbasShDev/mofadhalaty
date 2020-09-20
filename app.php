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
    $stat = $mysqli->query("SELECT * FROM urls WHERE user_id=$userId AND url_archive=0 ORDER BY url_id DESC");
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
                        <a href="url.php?url_id=<?php echo $url['url_id']?>"><img class="card-img-top" src="<?php echo $url['url_image'] ?>" alt="url_image"></a>
                        <div class="card-body px-0 pb-3">
                            <a href="url.php?url_id=<?php echo $url['url_id']?>"><h5 class="card-title font-head"><?php echo $url['url_title'] ?></h5></a>
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
                                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" class="" method="post">
                                    <input type="hidden" name="urlid" value="<?php echo $url['url_id']?>">
                                    <button type="submit" name="delete_url" onclick="return confirm('هل تريد الحذف؟')">
                                        <i class="text-danger fas fa-trash-alt pl-1"><span class="badge badge-pill">حذف</span></i>
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
