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
    <link rel="shortcut icon" type="image/svg" href="{{asset('dist/front/assets/images/logo/favicon.svg')}}">
    <!-- START:: STYLE LIBRARIES -->

    <!-- START:: BOOTSTRAP -->
    <link rel="stylesheet" href="{{asset('dist/front/assets/css/bootstrap/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('dist/front/assets/css/bootstrap/bootstrap-range.css')}}">
    <!-- START:: FANCY BOX -->
    <link rel="stylesheet" href="{{asset('dist/front/assets/css/fancyBox/fancy.css')}}">
    <!-- START:: OWL CAROUSEL -->
    <link rel="stylesheet" href="{{asset('dist/front/assets/css/owl-carousel/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('dist/front/assets/css/owl-carousel/owl.theme.default.min.css')}}">
    <!-- START:: ANIMATE -->
    <link rel="stylesheet" href="{{asset('dist/front/assets/css/animate/animate.css')}}">
    <!-- START:: FONT AWSOME -->
    <link rel="stylesheet" href="{{asset('dist/front/assets/css/font-awsome/all.css')}}">

    <link rel="stylesheet" href="{{asset('dist/css/Toast.min.css')}}">
    <!-- START:: CUSTOM STYLE -->
    
    <link rel="stylesheet" href="{{asset('dist/front/assets/css/iziToast/iziToast.min.css')}}"  />
    <link rel="stylesheet" href="{{asset('dist/front/assets/css/custom/social-share.css')}}"  />
    <link rel="stylesheet" href="{{asset('dist/front/assets/css/custom/style.css')}}"  />
    <script src="{{asset('dist/ckeditor/ckeditor.js')}}"></script>
    @yield('style')
    <!-- END:: STYLE LIBRARIES -->
</head>
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
    <meta name="description" content="Lorem ipsum dolor sit amet, consectetur adipisicing elit">
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
    <link rel="shortcut icon" type="image/svg" href="{{asset('dist/front/assets/images/logo/favicon.svg')}}">
    <!-- START:: STYLE LIBRARIES -->

    <!-- START:: BOOTSTRAP -->
    <link rel="stylesheet" href="{{asset('dist/front/assets/css/bootstrap/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('dist/front/assets/css/bootstrap/bootstrap-range.css')}}">
    <!-- START:: FANCY BOX -->
    <link rel="stylesheet" href="{{asset('dist/front/assets/css/fancyBox/fancy.css')}}">
    <!-- START:: OWL CAROUSEL -->
    <link rel="stylesheet" href="{{asset('dist/front/assets/css/owl-carousel/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('dist/front/assets/css/owl-carousel/owl.theme.default.min.css')}}">
    <!-- START:: ANIMATE -->
    <link rel="stylesheet" href="{{asset('dist/front/assets/css/animate/animate.css')}}">
    <!-- START:: FONT AWSOME -->
    <link rel="stylesheet" href="{{asset('dist/front/assets/css/font-awsome/all.css')}}">

    <link rel="stylesheet" href="{{asset('dist/css/Toast.min.css')}}">
    <!-- START:: CUSTOM STYLE -->
    
    <link rel="stylesheet" href="{{asset('dist/front/assets/css/iziToast/iziToast.min.css')}}"  />
    <link rel="stylesheet" href="{{asset('dist/front/assets/css/custom/social-share.css')}}"  />
    <link rel="stylesheet" href="{{asset('dist/front/assets/css/custom/style.css')}}"  />
    <script src="{{asset('dist/ckeditor/ckeditor.js')}}"></script>
    @yield('style')
    <!-- END:: STYLE LIBRARIES -->
</head>
<body class="
@if(request()->segment(count(request()->segments())) == 1 || request()->segment(count(request()->segments()) -1 ) == 1)
home_one
@endif
">
@include('front.parts.loader')
    
    <main>

        <!-- START:: CONTENT PAGE -->
        <div class="success_message">
            <img src="{{asset('dist/front/assets/images/icons/checkS.svg')}}" width="" height="" alt="" />
            <h2>{{ __('messages.finish') }}</h2>
            <p>{{ __('messages.finish_desc') }}</p>
            <div class="btns_options">
                <a href="{{ url('/') }}" class="btn-animation-2">  {{ __('messages.Home') }}</a>
                <a href="{{ route('front_my_orders',['div'=>'2']) }}" class="btn-animation-4">   {{ __('messages.Follow_up_order') }}</a>

            </div>
        </div>
        <!-- END:: CONTENT PAGE -->
    </main>


    <!-- START:: JQUERY -->
    <script src="{{asset('dist/front/assets/js/jquery/jquery-3.4.1.min.js')}}"></script>
    <!-- START:: BOOTSTRAP -->
    <script src="{{asset('dist/front/assets/js/bootstrap/popper.min.js')}}"></script>
    <script src="{{asset('dist/front/assets/js/bootstrap/bootstrap.min.js')}}"></script>
    <script src="{{asset('dist/front/assets/js/bootstrap/bootstrap-range.js')}}"></script>
    <!-- START:: FANCY BOX -->
    <script src="{{asset('dist/front/assets/js/fancybox/fancy.js')}}"></script>
    <!-- START:: OWL CAROUSEL -->
    <script src="{{asset('dist/front/assets/js/owl-carousel/owl.carousel.min.js')}}"></script>
    <!-- START:: FONT AWSOME -->
    <script src="{{asset('dist/front/assets/js/font-awsome/all.js')}}"></script>
    <!-- START:: ANIMATE -->
    <script src="{{asset('dist/front/assets/js/animate/wow.min.js')}}"></script>
    <!-- START:: CUSTOM JS -->
    <script src="{{asset('dist/front/assets/js/iziToast/iziToast.min.js')}}"></script>
    <script src="{{asset('dist/front/assets/js/custom/social-share.js')}}"></script>

    <script src="{{asset('dist/js/Toast.min.js')}}"></script>
    <script src="{{asset('dist/front/assets/js/custom/main.js')}}"></script>

    <script src="{{asset('dist/selectize/selectize.min.js')}}"></script>
<script src="{{asset('dist/js/demo.js')}}"></script>
<!-- my code -->
{{--  <script src="{{asset('dist/front/user/assets/js/selectize/selectize.min.js')}}"></script>  --}}


<script src="{{asset('dist/js/my_code.js')}}"></script>