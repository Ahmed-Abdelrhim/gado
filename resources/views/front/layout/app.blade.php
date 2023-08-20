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

    <link rel="stylesheet" href="{{asset('dist/front/assets/css/iziToast/iziToast.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('dist/front/assets/css/custom/social-share.css')}}"/>
    <link rel="stylesheet" href="{{asset('dist/front/assets/css/custom/style.css')}}"/>
    <script src="{{asset('dist/ckeditor/ckeditor.js')}}"></script>

@yield('style')


    <style>
        .changeLang{
            color: white;
        }

        img.flag-icon {
            margin-right: 5px;
            width: 25px;
            height: 25px;
        }
        /* Here Is Dropdown */
        .custom-dropdown {
            position: relative;
            display: inline-block;
        }

        .custom-dropdown select {
            display: none;
        }

        .custom-dropdown .dropdown-display {
            display: flex;
            align-items: center;
            padding: 5px;
            // border: 1px solid #ccc;
            cursor: pointer;
            border-style: none;
        }

        .custom-dropdown .dropdown-display img {
            max-width: 20px;
            max-height: 20px;
            margin-right: 5px;
        }

        .custom-dropdown .dropdown-options {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            border: 1px solid #ccc;
            background-color: #fff;
            z-index: 1;
        }

        .custom-dropdown .dropdown-options option {
            display: flex;
            align-items: center;
            padding: 5px;
        }

            /*.custom-dropdown .dropdown-options a img:hover {*/
            /*    color: white;*/
            /*}*/

        .custom-dropdown .dropdown-options a span:hover {
            color: white;
        }

        .languageSpan {
            color: white;
        }

        .languageSpan:hover {
            color: white;
        }

    </style>

    <!-- END:: STYLE LIBRARIES -->
</head>


<body class="
@if(request()->segment(count(request()->segments())) == 1 || request()->segment(count(request()->segments()) -1 ) == 1)
        home_one
@endif
        ">

{{csrf_field()}}
<!-- START:: LOADER -->
@include('front.parts.loader')
<!-- END:: LOADER -->

<!-- START:: HEADER -->

<!-- END:: HEADER -->

@include('parts.alert')

@yield('content')

<!-- START:: FOOTER -->
@include('front.parts.footer')
<!-- END:: FOOTER -->


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body body_modal">
{{--                <button type="button" class="btn btn-danger btn-round"  id="xmodal" style="position: absolute;top: 5px; left: 5px; border-radius: 50%; ">--}}
{{--                    X--}}
{{--                </button>--}}
                <div class="icon">
                    <svg viewBox="0 0 26 26" xmlns="http://www.w3.org/2000/svg">
                        <g stroke="currentColor" stroke-width="1.5" fill="none"
                           fill-rule="evenodd"
                           stroke-linecap="round" stroke-linejoin="round">
                            <path class="circle"
                                  d="M13 1C6.372583 1 1 6.372583 1 13s5.372583 12 12 12 12-5.372583 12-12S19.627417 1 13 1z"/>
                            <path class="tick" d="M6.5 13.5L10 17 l8.808621-8.308621"/>
                        </g>
                    </svg>
                </div>
                <h3>
                    {{ __('messages.Product_added_to_cart') }}
                </h3>
                <div class="btns_cart_fav d-flex">
                    <a href="{{ route('front_home_cart',['div'=>1]) }}"
                       class="btn-animation-2">
                        إتمام عملية الشراء
                    </a>

                    <a href="javascript:;" class="btn-animation-4" id="xmodal">
                        منتجات اخري
                    </a>


                </div>
            </div>
        </div>
    </div>
</div>

<!-- START:: INCLUDING SCRIPTS -->

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
<!-- START::  -->
@yield('scripts')
<script>
    var url = "{{ route('changeLang') }}";

    $(".changeLang").change(function () {
        window.location.href = url + "?lang=" + $(this).val();
    });

    $(document).on('click', '.adcart', function () {
        var data = {
            id: $(this).data("id"),
            count: 1,
            _token: $("input[name='_token']").val()
        }


        $.ajax(
            {
                url: "{{route('front_add_order')}}",
                type: 'post',
                data: data,
                success: function (s, result) {

                    $("#exampleModal").modal('show');

                    $(".cart_num").css('display', 'flex');
                    $(".cart_num").html(s.datas);
                    $(".cart_tot").html(s.total + "جنيه");
                }
            });

    });


    $("#resendCode").on('click', function () {

        var data = {
            phone: $(this).attr('data-phone'),
            _token: $("input[name='_token']").val()
        }
        $.ajax(
            {
                url: "{{ route('customer.verify_phone') }}",
                type: 'post',
                data: data,
                success: function (s, result) {
                }
            });
    });


    $(document).on('click', '.wishde', function () {
        var id = $(this).data("id");
        var data = {
            id: $(this).data("id"),
            _token: $("input[name='_token']").val()
        }


        $.ajax(
            {
                url: "{{route('front_add_fav')}}",
                type: 'post',
                data: data,
                success: function (s, result) {
                    $(".favvv").html(' ');
                    $(".favvv").html(s.datas);
                    $(".wishlist_btn_" + id).css({"background-color": "#F5F5F5"}).removeClass("wishde").addClass("wish").removeClass("isFav");

                }
            });

    });


    $(document).on('click', '.wish', function () {
        var id = $(this).data("id");
        var data = {
            id: $(this).data("id"),
            _token: $("input[name='_token']").val()
        }


        $.ajax(
            {
                url: "{{route('front_add_fav')}}",
                type: 'post',
                data: data,
                success: function (s, result) {
                    $(".favvv").html(' ');
                    $(".favvv").html(s.datas);
                    $(".wishlist_btn_" + id).css({"background-color": "#FF4747"}).removeClass("wish").addClass("wishde").addClass("isFav");

                }
            });

    });
    // START:: SLIDERS
    var right_arrow = "{{ asset('dist/front/assets/images/icons/arrowRight.svg') }}"
    var left_arrow = "{{ asset('dist/front/assets/images/icons/arrowLeft.svg') }}"
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
    $(document).on('click', '.modal_submit', function () {
        $('.real_submit').click()
    })
</script>

{{-- footer script --}}
<script>

    // subscripe email
    $(document).on('click', '.save_subscripe_email', function (e) {
        var email = $('.subscripe_email_input').val()

        if (email == '' || email == null || email == undefined) {
            e.preventDefault()
            new Toast({
                message: 'يجب إدخال بريد إلكتروني !',
                type: 'danger'
            });
        } else {

            var data = {
                email: email,
                _token: $("input[name='_token']").val()
            }
            $.ajax(
                {
                    url: "{{url('add-emails')}}",
                    type: 'post',
                    data: data,
                    success: function (s, result) {
                        console.log(s);
                        if (s.status === '1') {

                            new Toast({
                                message: s.message,
                                type: 'success'
                            });
                            $('.subscripe_email_input').val(" ");
                        } else {

                            new Toast({
                                message: s.message,
                                type: 'danger'
                            });
                        }
                    }
                });

        }

    })
    $(document).on('keypress', (e) => {
        if (e.keyCode === 13)
            // alert('enter clicked')

            //  $('.searchSubmit').click();
            // return false;
            })

    $(document).on('keydown', '.subscripe_email_input', function (e) {
        var key = e.which;
        if (key == 13) {

            $('.save_subscripe_email').click();
            return false;
        }
    });

</script>

<script>

    $('#xmodal').on('click', function (){
        $("#exampleModal").modal('hide');
    });

</script>



{{-- Here Js Languages --}}
<script>
    $(document).ready(function () {
        const dropdownDisplay = document.querySelector('.custom-dropdown .dropdown-display');
        const dropdownOptions = document.querySelector('.custom-dropdown .dropdown-options');
        const options = document.querySelectorAll('.custom-dropdown .dropdown-options option');

        dropdownDisplay.addEventListener('click', () => {
            console.log('ssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss');
            dropdownOptions.style.display = 'block';
            dropdownOptions.classList.toggle('show');
        });

        options.forEach(option => {
            option.addEventListener('click', () => {
                dropdownDisplay.innerHTML = option.innerHTML;
                dropdownOptions.style.display = 'none';
                dropdownOptions.classList.remove('show');
            });
        });
    });
</script>



</body>

</html>