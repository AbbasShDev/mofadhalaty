$(document).ready(function () {

    'use strict'

    //toggler sidebar class
    $('.sidebar-toggler').on('click', function () {
        $('.sidebar').addClass('active');
    })

    $('.sidebar-wrapper .fa-chevron-right').on('click', function () {
        $('.sidebar').removeClass('active');
    })

    //adding form
    showHideForm('.add-url-icon', '.add-url', '.close-search-add-form');

    //searching form
    showHideForm('.search-url-icon', '.search-url', '.close-search-add-form');


    //show and hide form function
    function showHideForm(showForm, form, closeForm) {

        //showing form
        $(showForm).on('click', function (e) {
            e.preventDefault()
            $('.navbar-area .row, .navbar-area .profile-dropdown').fadeOut(10);
            $(form).fadeIn();
        })

        //hiding  form
        $(closeForm).on('click', function (e) {
            e.preventDefault()
            $(form).fadeOut(5);
            $('.navbar-area .row, .navbar-area .profile-dropdown').fadeIn();
        })
    }

    //showing notification message
    $('.notify-message').each(function () {

        $(this).animate({
                left:'10px'
            },1000,
            function () {
                $(this).delay(2000).fadeOut();
            })


    })

    //display action btn description
    // $('.content .card-body .action-btn').on('hover','i', function () {
    //
    //     $(this).find('span').show();
    //
    // }, function () {
    //     $(this).find('span').hide();
    // })

    $(document).on({
        mouseenter: function () {
            $(this).find('span').show();
        },
        mouseleave: function () {
            $(this).find('span').hide();
        }
    }, ".content .card-body .action-btn i");
})