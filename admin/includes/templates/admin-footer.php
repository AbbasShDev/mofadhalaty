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

<!-- jQuery -->
<script src="<?php echo $config['app_url']?>admin/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<!-- Bootstrap js -->
<script src="https://cdn.rtlcss.com/bootstrap/v4.2.1/js/bootstrap.min.js" integrity="sha384-a9xOd0rz8w0J8zqj1qJic7GPFfyMfoiuDjC9rqXlVOcGO/dmRqzMn34gZYDTel8k" crossorigin="anonymous"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="<?php echo $config['app_url']?>admin/plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo $config['app_url']?>admin/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?php echo $config['app_url']?>admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo $config['app_url']?>admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo $config['app_url']?>admin/plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="<?php echo $config['app_url']?>admin/https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="<?php echo $config['app_url']?>admin/plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?php echo $config['app_url']?>admin/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo $config['app_url']?>admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?php echo $config['app_url']?>admin/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo $config['app_url']?>admin/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $config['app_url']?>admin/dist/js/adminlte.js"></script>
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