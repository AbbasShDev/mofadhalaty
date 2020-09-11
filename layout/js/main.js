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
})