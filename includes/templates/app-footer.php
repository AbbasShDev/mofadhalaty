<!-- Start Footer  -->
<!--<div class="footer">-->
<!--    <div>-->
<!--        <a href="https://twitter.com/AbbasShDev" target="_blank"><i class="mr-2 p-1 fab fa-twitter"></i></a>-->
<!--        <a href="https://github.com/AbbasShDev" target="_blank"><i class="mr-2 p-1 fab fa-github "></i></a>-->
<!--        <a href="https://www.linkedin.com/in/abbas-alshaqaq-7b58221a5/" target="_blank"><i class="mr-2 p-1 fab fa-linkedin"></i></a>-->
<!--        Coded by AbbasShDev <span>2020 ©</span>-->
<!--    </div>-->
<!--</div>-->
<!-- End Footer  -->
</body>

<!-- font awesomeawesomeawesome -->
<script src="https://kit.fontawesome.com/6652aa2ce8.js" crossorigin="anonymous"></script>
<!-- jQuery js -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<!-- Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<!-- Bootstrap js -->
<script src="https://cdn.rtlcss.com/bootstrap/v4.2.1/js/bootstrap.min.js" integrity="sha384-a9xOd0rz8w0J8zqj1qJic7GPFfyMfoiuDjC9rqXlVOcGO/dmRqzMn34gZYDTel8k" crossorigin="anonymous"></script>
<!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
<script src="layout/js/app.js" type="text/javascript"></script>
<script>

    $(document).ready(function () {

        $(document).on('submit', '.content .card-body .action-btn .favourite', function (e) {
            e.preventDefault();

            let favBtn = $(this).find('button'),
                form   = $(this)

            let data = {favStatus:form.data('fav'), urlId: form.data('urlid')};
            $.post('fav_not_fav.php',{data:JSON.stringify(data)}).done(function (data) {
                if (data == 1){
                    form.data('fav', '1');
                    favBtn.html('');
                    favBtn.html('<i class="fas fa-star"><span class="badge">حذف من المفضلة</span></i>');
                    favBtn.find('i').addClass('iScale');
                    setTimeout(function () {
                        favBtn.find('i').removeClass('iScale');
                    },100)


                }else {
                    form.data('fav', '0')
                    favBtn.html('')
                    favBtn.html('<i class="far fa-star"><span class="badge">إضافة الى المفضلة</span></i>')
                    favBtn.find('i').addClass('iScale');
                    setTimeout(function () {
                        favBtn.find('i').removeClass('iScale');
                    },100)
                    <?php if ($pageTitle == "| المفضلة"){ ?>
                    form.parents('.card').parent().remove();
                    <?php } ?>
                }

            }).fail(function () {
                $('.alert-normal p').html('حدث خطأ');
                $('.alert-normal').fadeIn().delay(3000).fadeOut();
            })
        });

        $(document).on('submit', '.content .card-body .action-btn .archive',  function (e) {
            e.preventDefault();

            let archiveBtn = $(this).find('button'),
                form   = $(this)

            let data = {archiveStatus:form.data('archive'), urlId: form.data('urlid')};
            $.post('add_archive.php',{data:JSON.stringify(data)}).done(function (data) {
                if (data == 1){
                    form.data('archive', '1');
                    archiveBtn.html('');
                    archiveBtn.html('<i class="fas fa-plus-circle pl-1"><span class="badge">حذف من الإرشيف</span></i>');
                    archiveBtn.find('i').addClass('iScale');
                    setTimeout(function () {
                        archiveBtn.find('i').removeClass('iScale');
                    },100)

                    form.parents('.card').parent().remove();
                }else {
                    form.data('archive', '0')
                    archiveBtn.html('')
                    archiveBtn.html('<i class="fas fa-minus-circle pl-1"><span class="badge">إضافة الى الإرشيف</span></i>')
                    archiveBtn.find('i').addClass('iScale');
                    setTimeout(function () {
                        archiveBtn.find('i').removeClass('iScale');
                    },100)
                    form.parents('.card').parent().remove();
                }

            }).fail(function () {
                $('.alert-normal p').html('حدث خطأ');
                $('.alert-normal').fadeIn().delay(3000).fadeOut();
            })
        })

        $('.sidebar .my-list form').on('submit', function (e) {
            e.preventDefault();

            let sectionValue = $(this).find('input').val()
            if (sectionValue != ''){
                $.ajax({
                    method: 'POST',
                    url:'add-section.php',
                    data:{addSection: sectionValue},
                    beforeSend: function () {
                        $('.sidebar .my-list form button i.fa-plus-circle').hide();
                        $('.sidebar .my-list form button i.fa-spinner').show();
                    },
                    success:function (data) {
                        $('.sidebar .my-list form input').val('');
                        $('.sidebar .my-list form button i.fa-spinner').hide();
                        $('.sidebar .my-list form button i.fa-plus-circle').show();

                         $('.sidebar .my-list').append(data);

                        $('.alert-ajax').delay(500).show().delay(3000).fadeOut(10, function () {
                            $(this).remove();
                        });

                    },
                    error:function (xhr, status, error) {
                        $('.sidebar .my-list form button i.fa-spinner').hide();
                        $('.alert-normal p').html(error);
                        $('.alert-normal').fadeIn().delay(3000).fadeOut();
                    }
                })
            }else {
                $('.alert-normal p').html('حقل اضافة القائمة فارغ');
                $('.alert-normal').fadeIn().delay(3000).fadeOut();
            }

        })



    });


</script>
<?php ob_end_flush(); ?>