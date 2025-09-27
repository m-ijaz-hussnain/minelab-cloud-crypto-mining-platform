(function ($) {
    "use strict";

    // ============== Header Hide Click On Body Js Start ========
    $('.header-button').on('click', function () {
        $('.body-overlay').toggleClass('show')
    });
    $('.body-overlay').on('click', function () {
        $('.header-button').trigger('click')
        $(this).removeClass('show');
    });
    // =============== Header Hide Click On Body Js End =========

    // ==========================================
    //      Start Document Ready function
    // ==========================================
    $(document).ready(function () {

        // ========================== Header Hide Scroll Bar Js Start =====================
        $('.navbar-toggler.header-button').on('click', function () {
            $('body').toggleClass('scroll-hide-sm')
        });
        $('.body-overlay').on('click', function () {
            $('body').removeClass('scroll-hide-sm')
        });
        // ========================== Header Hide Scroll Bar Js End =====================

        // ========================== Small Device Header Menu On Click display Block Js Start =====================
        $('.dropdown-item').on('click', function () {
            $(this).closest(".dropdown-menu").addClass("d-block");
        });
        // ========================== Small Device Header Menu On Click display Block Js End =====================

        // ========================== Add Attribute For Bg Image Js Start =====================
        $(".bg-img").css('background', function () {
            var bg = ('url(' + $(this).data("background-image") + ') no-repeat center center');
            return bg;
        });
        // ========================== Add Attribute For Bg Image Js End =====================

        // ========================= Slick Slider Js Start ==============
        $('.testimonial-slider').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: false,
            autoplaySpeed: 2000,
            speed: 1500,
            dots: true,
            pauseOnHover: true,
            arrows: false,
            prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-long-arrow-alt-left"></i></button>',
            nextArrow: '<button type="button" class="slick-next"><i class="fas fa-long-arrow-alt-right"></i></button>',
            responsive: [
                {
                    breakpoint: 1199,
                    settings: {
                        arrows: false,
                        slidesToShow: 2,
                        dots: true,
                    }
                },
                {
                    breakpoint: 991,
                    settings: {
                        arrows: false,
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 767,
                    settings: {
                        arrows: false,
                        slidesToShow: 1
                    }
                }
            ]
        });
        // ========================= Slick Slider Js End ===================

        // ================== Password Show Hide Js Start ==========
        $(".toggle-password").on('click', function () {
            $(this).toggleClass("icon-eye-off");
            var input = $($(this).attr("id"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        // =============== Password Show Hide Js End =================

        $('#mySelect').change(function () {
            $('#mySelect').css("background", $("select option:selected").css("background-color, red"));
        });

    });
    // ==========================================
    //      End Document Ready function
    // ==========================================

    // ========================= Preloader Js Start =====================
    $(window).on("load", function () {
        $('.preloader').fadeOut();
    })
    // ========================= Preloader Js End=====================

    // ========================= Header Sticky Js Start ==============
    $(window).on('scroll', function () {
        if ($(window).scrollTop() >= 300) {
            $('.header').addClass('fixed-header');
        }
        else {
            $('.header').removeClass('fixed-header');
        }
    });
    // ========================= Header Sticky Js End===================

    //============================ Scroll To Top Icon Js Start =========
    var btn = $('.scroll-top');

    $(window).scroll(function () {
        if ($(window).scrollTop() > 300) {
            btn.addClass('show');
        } else {
            btn.removeClass('show');
        }
    });

    btn.on('click', function (e) {
        e.preventDefault();
        $('html, body').animate({ scrollTop: 0 }, '300');
    });
    //========================= Scroll To Top Icon Js End ======================
    $.each($('input, select, textarea'), function (i, element) {
        if (element.hasAttribute('required')) {
            $(element).closest('.form-group').find('label').not('.register-icon').addClass('required');
        }
    });

    $(document).ready(function () {
        const $mainlangList = $(".langList");
        const $langBtn = $(".language-content");
        const $langListItem = $mainlangList.children();

        $langListItem.each(function () {
            const $innerItem = $(this);
            const $languageText = $innerItem.find(".language_text");
            const $languageFlag = $innerItem.find(".language_flag");

            $innerItem.on("click", function (e) {
                e.preventDefault();
                $langBtn.find(".language_text_select").text($languageText.text());
                $langBtn.find(".language_flag").html($languageFlag.html());
                var location = $innerItem.find('a').attr('href');
                window.location.href = location;
            });
        });
    });

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title], [data-title], [data-bs-title]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

})(jQuery);
