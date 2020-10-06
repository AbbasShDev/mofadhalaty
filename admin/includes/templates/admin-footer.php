<footer class="main-footer p-0">
    <div class="float-right p-2">
        <a href="https://twitter.com/AbbasShDev" target="_blank"><i class="text-dark p-1 fab fa-twitter"></i></a>
        <a href="https://github.com/AbbasShDev" target="_blank"><i class="text-dark p-1 fab fa-github "></i></a>
        <a href="https://www.linkedin.com/in/abbas-alshaqaq-7b58221a5/" target="_blank"><i class="text-dark p-1 fab fa-linkedin"></i></a>
        Coded by AbbasShDev <span>2020 ©</span>
    </div>
</footer>

</div>
<!-- ./wrapper -->

<!-- jQuery js -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<!-- Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<!-- Bootstrap js -->
<script src="https://cdn.rtlcss.com/bootstrap/v4.2.1/js/bootstrap.min.js" integrity="sha384-a9xOd0rz8w0J8zqj1qJic7GPFfyMfoiuDjC9rqXlVOcGO/dmRqzMn34gZYDTel8k" crossorigin="anonymous"></script>
<!-- Theme js -->
<script src="<?php echo $config['app_url']?>admin/layout/js/adminlte.js"></script>
<script>

    $(document).ready(function () {
        //showing notification message
        $('.notify-message').each(function () {

            $(this).animate({
                    left:'10px'
                },1000,
                function () {
                    $(this).delay(2000).fadeOut();
                })


        })

    })
</script>
</body>
</html>
<?php ob_end_flush(); ?>