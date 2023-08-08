// START:: LOADER
(function ($) {
    "use strict";
    //Preloader
    // window.addEventListener( 'load', function () {
    //       var preloadpage = document.getElementById( "page_loader" );
    //       preloadpage.style.display = "none";
    // });
  $(document).ready(function(){
    var preloadpage = document.getElementById( "page_loader" );
    preloadpage.style.display = "none";
  })
  })(jQuery);
// END:: LOADER

// START:: HEADER FIXED
$(function () {
    var pageScroll = 100;
    $(window).scroll(function () {
        var scroll = getCurrentScroll();
        if (scroll >= pageScroll) {
            $('header .center_header').addClass('scroll-effect');
            $('.mobile_header').addClass('scroll-effect');
            $('.footer_mobile').addClass('scroll-effect-footer');
        }
        else {
            $('header .center_header').removeClass('scroll-effect');
            $('.mobile_header').removeClass('scroll-effect');
            $('.footer_mobile').removeClass('scroll-effect-footer');
        }
    });

    function getCurrentScroll() {
        return window.pageYOffset || document.documentElement.scrollTop;
    }
});
// END:: HEADER FIXED

// START:: SIDE MENU
$(".mobile_header .btn_menu button").click(function () {
    $(".side_menu_mobile.main_menu").toggleClass("showSideMenu");
    $(".overLay_side_menu").addClass("showSideMenuOverLay");
    $("body").css("overflow", "hidden");
});
$(".overLay_side_menu").click(function () {
    $(this).removeClass("showSideMenuOverLay");
    $(".side_menu_mobile.main_menu").removeClass("showSideMenu");
    $("body").css("overflow-y", "scroll");
});
$(".footer_mobile ul li button").click(function () {
    $(this).addClass("active");
    $(".search_area").addClass("showSearch");
    $(".searchOverLay").addClass("showSearchOverLay");
    $("body").css("overflow", "hidden");
});
$(".footer_mobile ul li button.active").click(function () {
    $("body").css("overflow-y", "scroll");
});
$(".searchOverLay").click(function () {
    $(this).removeClass("showSearchOverLay");
    $(".footer_mobile ul li button").removeClass("active");
    $(".search_area").removeClass("showSearch");
    $("body").css("overflow-y", "scroll");
});
$(".filter_icon").click(function () {
    $(".sidebar_filter").addClass("sidebar_filter_show");
    $(".overLay_filter").addClass("overLay_filter_show");
});
$(".overLay_filter").click(function () {
    $(".sidebar_filter").removeClass("sidebar_filter_show");
    $(".overLay_filter").removeClass("overLay_filter_show");
});
// END:: SIDE MENU

// START:: SHOW AND HIDE PASSWORD
function password_show_hide() {
    var x = document.getElementById("old_password");
    var show_eye = document.getElementById("show_eye");
    var hide_eye = document.getElementById("hide_eye");
    hide_eye.classList.remove("d-none");
    if (x.type === "password") {
        x.type = "text";
        show_eye.style.display = "none";
        hide_eye.style.display = "block";
    } else {
        x.type = "password";
        show_eye.style.display = "block";
        hide_eye.style.display = "none";
    }
}
function password_show_hide_2() {
    var x = document.getElementById("new_password");
    var show_eye = document.getElementById("show_eye1");
    var hide_eye = document.getElementById("hide_eye1");
    hide_eye.classList.remove("d-none");
    if (x.type === "password") {
        x.type = "text";
        show_eye.style.display = "none";
        hide_eye.style.display = "block";
    } else {
        x.type = "password";
        show_eye.style.display = "block";
        hide_eye.style.display = "none";
    }
}
function password_show_hide_confirm() {
    var x = document.getElementById("confirm_password");
    var show_eye = document.getElementById("show_eye2");
    var hide_eye = document.getElementById("hide_eye2");
    hide_eye.classList.remove("d-none");
    if (x.type === "password") {
        x.type = "text";
        show_eye.style.display = "none";
        hide_eye.style.display = "block";
    } else {
        x.type = "password";
        show_eye.style.display = "block";
        hide_eye.style.display = "none";
    }
}
// END:: SHOW AND HIDE PASSWORD


$(document).ready(function () {

    var sync1 = $("#slider_product1");
    var sync2 = $("#slider_product2");
    var slidesPerPage = 4; //globaly define number of elements per page
    var syncedSecondary = true;

    sync1.owlCarousel({
        items: 1,
        slideSpeed: 2000,
        nav: false,
        autoplay: false,
        dots: false,
        loop: true,
        rtl: true,
        responsiveRefreshRate: 200,

    }).on('changed.owl.carousel', syncPosition);

    sync2
        .on('initialized.owl.carousel', function () {
            sync2.find(".owl-item").eq(0).addClass("current");
        })
        .owlCarousel({
            items: slidesPerPage,
            dots: false,
            nav: false,
            rtl: true,
            smartSpeed: 200,
            slideSpeed: 500,
            slideBy: slidesPerPage, //alternatively you can slide by 1, this way the active slide will stick to the first item in the second carousel
            responsiveRefreshRate: 100
        }).on('changed.owl.carousel', syncPosition2);

    function syncPosition(el) {
        //if you set loop to false, you have to restore this next line
        //var current = el.item.index;

        //if you disable loop you have to comment this block
        var count = el.item.count - 1;
        var current = Math.round(el.item.index - (el.item.count / 2) - .5);

        if (current < 0) {
            current = count;
        }
        if (current > count) {
            current = 0;
        }

        //end block

        sync2
            .find(".owl-item")
            .removeClass("current")
            .eq(current)
            .addClass("current");
        var onscreen = sync2.find('.owl-item.active').length - 1;
        var start = sync2.find('.owl-item.active').first().index();
        var end = sync2.find('.owl-item.active').last().index();

        if (current > end) {
            sync2.data('owl.carousel').to(current, 100, true);
        }
        if (current < start) {
            sync2.data('owl.carousel').to(current - onscreen, 100, true);
        }
    }

    function syncPosition2(el) {
        if (syncedSecondary) {
            var number = el.item.index;
            sync1.data('owl.carousel').to(number, 100, true);
        }
    }

    sync2.on("click", ".owl-item", function (e) {
        e.preventDefault();
        var number = $(this).index();
        sync1.data('owl.carousel').to(number, 300, true);
    });
});

// START:: INPUT COUNT
$(".max").click(function () {
    document.getElementsByClassName('inputCount')[0].value++
});
$(".min").click(function () {
    if (document.getElementsByClassName('inputCount')[0].value < 0) {
        document.getElementsByClassName('inputCount')[0].value
    } else {
        document.getElementsByClassName('inputCount')[0].value--
    }
});


// START:: SELECT BOOTSTRAP

// START:: TOGGLE CLASS ADD TO WISH LIST

// START:: VERIFICATION CODE 

const inputElements = [...document.querySelectorAll('input.code-input')]

inputElements.forEach((ele, index) => {
    ele.addEventListener('keydown', (e) => {
        if (e.keyCode === 8 && e.target.value === '') inputElements[Math.max(0, index - 1)].focus()
    })
    ele.addEventListener('input', (e) => {
        const [first, ...rest] = e.target.value
        e.target.value = first ?? ''
        const lastInputBox = index === inputElements.length - 1
        const insertedContent = first !== undefined
        if (insertedContent && !lastInputBox) {
            inputElements[index + 1].focus()
            inputElements[index + 1].value = rest.join('')
            inputElements[index + 1].dispatchEvent(new Event('input'))
        }
    })
})



// function toggleBtnWishList(id) {
//     var index = 0;
//     console.log(++index);
//     var element = document.getElementById(`wishlist_btn_${index++}`);
//     element.classList.toggle("mystyle");
// }
// END:: TOGGLE CLASS ADD TO WISH LIST

// START:: SOCIAL SHARE
// Init Social Share Kit
var titleElement = document.getElementsByTagName("title")[0];
SocialShareKit.init({
    // url: 'http://socialsharekit.com',
    url: `${window.location.href}`,
    twitter: {
        title: `${titleElement.innerHTML}`,
        via: 'GadoEgStore'
    },

});



// END:: SOCIAL SHARE

// START:: COMPLETE ORDER FUNCTION
function completeOrder() {
    location.href = "complete-order.html";
}
// START:: WOW ANIMATION
new WOW().init();
// END:: WOW ANIMATION
