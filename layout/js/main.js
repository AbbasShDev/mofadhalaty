$('document').ready(function () {


    'use strict'

    //scroll to section on clicking navbar link
    $('.nav-link.scroll').on('click', function(e) {
        e.preventDefault();

        $('html, body').animate(
            {
                scrollTop: $('#' + $(this).data('scroll')).offset().top
            },
            1000
        );
    });

    //scroll to section by url
    if (window.location.hash) {
        let hash = window.location.hash;

        if ($(hash).length) {
            $('html, body').animate({
                scrollTop: $(hash).offset().top
            }, 900, 'swing');
        }
    }

    //scroll top btn
    $('.scroll-up').click(function() {
        $('html, body').animate(
            {
                scrollTop: 0
            },
            1000
        );
    });
    $(window).scroll(function() {
        let scrollUp = $('.scroll-up');
        if ($(window).scrollTop() >= 200) {
            scrollUp.slideDown(200);
        } else {
            scrollUp.slideUp(200);
        }
    });

    //toggler acttive class

    $('.navbar-area .navbar-toggler').on('click', function () {

        $(this).toggleClass('active');

    })

    //showing notification message
    $('.notify-message').each(function () {

        $(this).animate({
                left:'10px'
            },1000,
            function () {
                $(this).delay(3000).fadeOut();
            })
    })

    //CUSTOM upload file filed
    $('.profile .profile-right form  input[type="file"]').wrap('<div class="custom-file"></div>')

    $('.custom-file').prepend('<span>تحميل الملف (jpeg, jpg, png) </span>')
    $('.custom-file').append('<i class="fas fa-upload fa-lg skin-color"></i>')

    $('.profile .profile-right form input[type="file"]').change(function () {

        $(this).prev('span').text($(this).val().substring(12))
    })

    //change logo bg on small devices
    function logoGg() {
        let logoSrc = $('.navbar-area .navbar-brand img');
        if ($(window).width() < 992){
            logoSrc.attr('src', 'layout/images/logo-dark.png');
        }

        $(window).resize(function () {
            if ($(this).width() < 992){
                logoSrc.attr('src', 'layout/images/logo-dark.png');
            }else{
                logoSrc.attr('src', 'layout/images/logo.png');
            }
        })
    }
    logoGg();

})