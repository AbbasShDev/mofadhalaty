$('document').ready(function () {

    'use strict'

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
})