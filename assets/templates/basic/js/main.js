! function (s) {
    (s(document).ready((function () {
        s(".preloader-area").delay(500).animate({
            "opacity": "0"
        }, 500, function () {
            s(".preloader-area").css("display", "none");
        }), s(".nic-select").niceSelect(), s(".bg_img").css("background-image", (function () {
            return "url(" + s(this).data("background") + ")"
        }))
    })), s(window).on("load", (function () { })), s(".wow").length) && new WOW({
        boxClass: "wow",
        animateClass: "animated",
        offset: 0,
        mobile: !1,
        live: !0
    }).init();



    // ========================= Header Hide Click On Body Js Start =====================
    $('.navbar-toggler.header-button').on('click', function () {
        if ($('.body-overlay').hasClass('show')) {
            $('.body-overlay').removeClass('show');
        } else {
            $('.body-overlay').addClass('show');
        }
    });
    $('.body-overlay').on('click', function () {
        $('.header-button').trigger('click');
    });
    // ========================= Header Hide Click On Body Js End =====================



    var i = s(".scrollToTop");
    s(window).on("scroll", (function () {
        s(this).scrollTop() < 500 ? i.removeClass("active") : i.addClass("active")
    })), s(".faq-wrapper .faq-title").on("click", (function (e) {
        var i = s(this).parent(".faq-item");
        i.hasClass("open") ? (i.removeClass("open"), i.find(".faq-content").removeClass("open"), i.find(".faq-content").slideUp(300, "swing")) : (i.addClass("open"), i.children(".faq-content").slideDown(300, "swing"), i.siblings(".faq-item").children(".faq-content").slideUp(300, "swing"), i.siblings(".faq-item").removeClass("open"), i.siblings(".faq-item").find(".faq-title").removeClass("open"), i.siblings(".taq-item").find(".faq-content").slideUp(300, "swing"))
    }))

    Array.from(document.querySelectorAll('table')).forEach(table => {
        let heading = table.querySelectorAll('thead tr th');
        Array.from(table.querySelectorAll('tbody tr')).forEach((row) => {
            Array.from(row.querySelectorAll('td')).forEach((colum, i) => {
                colum.setAttribute('data-label', heading[i].innerText)
            });
        });
    });

    // ============================ Dashboard Sidebar Toggle Js ====================
    $('.dashboard-menu-bar').on('click', function () {
        $('.dash-user-area').addClass('show_sidebar');
        $('.sidebar-overlay').addClass('show_overlay');
    });
    $('.sidebar-cross__icon').on('click', function () {
        $('.dash-user-area').removeClass('show_sidebar');
        $('.sidebar-overlay').removeClass('show_overlay');

    });

    // ========================= Header Sticky Js Start =====================
    $(window).scroll(function () {
        if ($(window).scrollTop() >= 300) {
            $('.header-bottom-area').addClass('fixed-header');
        }
        else {
            $('.header-bottom-area').removeClass('fixed-header');
        }
    });
    // ========================= Header Sticky Js End=====================

    $('.showFilterBtn').on('click', function () {
        if ($('.responsive-filter-card').css('display') === 'block') {
            $('.responsive-filter-card').css({ display: 'none', transition: "0.3s linear" });
        } else {
            $('.responsive-filter-card').css({ display: 'block', transition: "0.3s linear" });
        }
    });

    $.each($('input, select, textarea'), function (i, element) {
        if (element.hasAttribute('required')) {
            $(element).siblings('label').not('.register-icon').addClass('required');
        }
    });

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title], [data-title], [data-bs-title]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    $('#confirmationModal').find('.btn--primary').addClass('btn--base').removeClass('btn--primary');




    // ============================ Dashboard Sidebar Menu List Slide Toggle Js ====================
    $('.menu_has_children').on('click', function () {
        $(this).find('.sub-menu').slideToggle()
    });

    $('.menu_has_children').on('focusout', function () {
        $(this).find('.sub-menu').slideToggle()
    });
    // ============================ Dashboard Sidebar Menu List Slide Toggle Js ====================
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

}(jQuery);
