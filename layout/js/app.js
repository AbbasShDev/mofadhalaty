$(document).ready(function () {

    'use strict'

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
        if ($(window).scrollTop() >= 1000) {
            scrollUp.slideDown(200);
        } else {
            scrollUp.slideUp(200);
        }
    });


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

    $(document).on('click','.content .card-body .action-btn .add-section-toggler', function () {

        $('.add-url-to-section .modal-content input').val($(this).data('urlid'));

    })

    $(document).on('click', '.sidebar .my-list .sections .dropright .dropdown-menu .rename-section', function (e) {

        e.preventDefault();
        $('.rename-section .modal-content input:first-child').val($(this).data('sectionid'));
        $('.rename-section .modal-content .modal-title').html(`إعادة تسمية القائمة (<strong>${$(this).data('sectionname')}</strong>)`);
    })

})
