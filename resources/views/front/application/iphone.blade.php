<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <!-- START:: UTF8 -->
    <meta charset="UTF-8">
    <!-- START::  AUTHOR -->
    <meta name="author" content="AhMeD EL-AwaDy">
    <!-- START:: ROBOTS -->
    <meta name="robots" content="index/follow">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- START:: VIEWPORT -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- START:: HANDHELFRIENDLY -->
    <meta name="HandheldFriendly" content="true">
    <!-- START:: DESCRIPTION -->

    <!-- START:: KEYWORD -->
    <meta name="keyword"
          content="agency, business, corporate, creative, freelancer, minimal, modern, personal, portfolio, responsive, simple, cartoon">
    <!-- START:: THEME COLOR -->
    <meta name="theme-color" content="#212121">
    <!-- START:: THEME COLOR IN MOBILE -->
    <meta name="msapplication-navbutton-color" content="#15264B">
    <!-- START:: THEME COLOR IN MOBILE -->
    <meta name="apple-mobile-web-app-status-bar-style" content="#15264B">
    <!-- START:: TITLE -->
    <title>Gado Eg Store</title>
    <!-- START:: FAVICON -->
    <link rel="icon" type="image/svg" href="{{asset('dist/front/assets/images/logo/w-logo.svg')}}">
    <!-- START:: STYLE LIBRARIES -->

    <!-- START:: BOOTSTRAP -->
    <link rel="stylesheet" href="{{asset('dist/front/assets/css/bootstrap/bootstrap.min.css')}}">
    <!-- START:: FANCY BOX -->
    <link rel="stylesheet" href="{{asset('dist/front/assets/css/fancyBox/fancy.css')}}">
    <!-- START:: OWL CAROUSEL -->
    <link rel="stylesheet" href="{{asset('dist/front/assets/css/owl-carousel/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('dist/front/assets/css/owl-carousel/owl.theme.default.min.css')}}">
    <!-- START:: ANIMATE -->
    <link rel="stylesheet" href="{{asset('dist/front/assets/css/animate/animate.css')}}">
    <!-- START:: FONT AWSOME -->
    <link rel="stylesheet" href="{{asset('dist/front/assets/css/font-awsome/all.css')}}">
    <!-- START:: CUSTOM STYLE -->
    <link rel="stylesheet" href="{{asset('dist/front/assets/css/custom/style.css')}}"  />

    <!-- END:: STYLE LIBRARIES -->
</head>

<body>

<section class="page_intro_2 page_intro_blue">
    <div class="head_page_intro_2">
        <img style="margin-top: 5em;" src="{{asset('dist/front/assets/images/logo/w-logo.svg')}}" alt="" height="" width="">
        <h2 style="line-height: 1.5; margin-top: 2em">لتجربه تسوق افضل <br/>حمل التطبيق</h2>
    </div>
    <div class="container">
        <div class="body_page_intro_2">
            <div class="right_page">
                <a href="https://play.google.com/store/apps/details?id=com.gadoeg.app">
                    <img  src="https://play.google.com/intl/en_us/badges/static/images/badges/en_badge_web_generic.png" alt="" height="" style="width: 100%; height: auto;">
                    {{--                    <h3>العدد والأدوات اليدوية</h3>--}}
                </a>
            </div>
            <div class="left_page">
                <a href="https://apps.apple.com/eg/app/gado-store/id1661092603">
                    <img src="https://icon-library.com/images/app-store-icon-png/app-store-icon-png-14.jpg" alt="" height="" width="" style="width: 100%; height: auto;">
                    {{--                    <h3>متجر التكييفات</h3>--}}
                </a>
            </div>
        </div>
    </div>

    <div class="footer_page_intro_2">
        <p>
            جميع الحقوق محفوظة لـ
            <a href="#">gado group</a>
        </p>
    </div>
</section>


<script src="{{asset('dist/front/assets/js/jquery/jquery-3.4.1.min.js')}}"></script>
<!-- START:: BOOTSTRAP -->
<script src="{{asset('dist/front/assets/js/bootstrap/popper.min.js')}}"></script>
<script src="{{asset('dist/front/assets/js/bootstrap/bootstrap.min.js')}}"></script>
<!-- START:: FANCY BOX -->
<script src="{{asset('dist/front/assets/js/fancybox/fancy.js')}}"></script>
<!-- START:: OWL CAROUSEL -->
<script src="{{asset('dist/front/assets/js/owl-carousel/owl.carousel.min.js')}}"></script>
<!-- START:: FONT AWSOME -->
<script src="{{asset('dist/front/assets/js/font-awsome/all.js')}}"></script>
<!-- START:: ANIMATE -->
<script src="{{asset('dist/front/assets/js/animate/wow.min.js')}}"></script>
<!-- START:: CUSTOM JS -->
<script src="{{asset('dist/front/assets/js/custom/main.js')}}"></script>
<!-- START::  -->

<script>

    // START:: SLIDERS
    var right_arrow = "{{ asset('dist/front/assets/images/icons/arrowRight.svg') }}"
    var left_arrow  = "{{ asset('dist/front/assets/images/icons/ArrowLeft.svg') }}"
    $('#heroSectionSlider').owlCarousel({
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        lazyLoad: true,
        autoplay: true,
        autoplayTimeout: 8000,
        loop: true,
        margin: 15,
        rtl: true,
        items: 1,
        dots: true,
        nav: true,
        navText: [`<img src='${right_arrow}' alt='ArrowLeft' width='45' height='22' />`, `<img src='${left_arrow}' width='45' height='22' alt='ArrowRight' />`],
    });

    // modal submit
    $(document).on('click','.modal_submit',function(){
        $('.real_submit').click()
    })
</script>
</body>

</html>