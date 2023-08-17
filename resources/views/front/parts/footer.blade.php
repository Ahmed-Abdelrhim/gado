<footer>
{{-- @include('../parts.alert') --}}

@if(empty($div))
  <!-- START:: NEW LETTERS -->

    <!--START HERE -->
        <!-- START:: NEW LETTERS -->
        <div class="new_letters">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-5">
                        <div class="d-flex align-items-center">
                            <div class="big_new_letters">
                                <img src="{{asset('dist/front/assets/images/icons/message-w.svg')}}" alt="" width="" height="">
                            </div>
                            <div class="text_new_letters">
                                <h4>{{ __('messages.Newsletter') }}</h4>
                                <p>{{ __('messages.email_enter') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="subscripe_form">
                            <form  action="" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <input type="email" name="email" required class="form-control subscripe_email_input"
                                           placeholder="{{ __('messages.email') }}">
                                    <button type="button" class="btn-animation-3 save_subscripe_email">
                                        {{ __('messages.subscribe_now') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END:: NEW LETTERS -->

        <!-- START:: MAIN FOOTER -->
        <div class="main_footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-5">
                        <div class="about_footer">
                            <div class="title_footer">
                                <h4>{{ __('messages.about_store') }}</h4>
                            </div>
                            <div class="text_footer">
                                <p>{{ __('messages.about_store_desc') }}</p>
                                <div class="download_links">
                                    <a href="https://play.google.com/store/apps/details?id=com.gadoeg.app">
                                        <img src="{{asset('dist/front/assets/images/icons/google.svg')}}" alt="" width="" height="">
                                    </a>
                                    <a href="https://apps.apple.com/eg/app/gado-store/id1661092603">
                                        <img src="{{asset('dist/front/assets/images/icons/apple.svg')}}" alt="" width="" height="">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="title_footer">
                            <h4>{{ __('messages.my_account') }}</h4>
                        </div>
                        <div class="list_footer">
                            <ul>
                                @if(auth()->guard('customer')->check() || auth()->guard('dealer')->check())
                                    <li><a href="{{ auth()->guard('customer')->check() ? route('customer.profile') : route('dealer.profile') }}">{{ __('messages.my_account') }}</a></li>
                                    <li><a href="{{ route('front_my_orders',['div'=>'1']) }}">{{ __('messages.My_Orders') }}</a></li>
                                    <li><a href="{{ route('front_favourit_list',['div'=>'1']) }}">{{ __('messages.Favorite') }}</a></li>
                                @else
                                    <li><a href="{{ route('front.login') }}">{{ __('messages.my_account') }}</a></li>
                                    <li><a href="{{ route('front.login') }}">{{ __('messages.My_Orders') }}</a></li>
                                    <li><a href="{{ route('front.login') }}">{{ __('messages.Favorite') }}</a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="title_footer">
                            <h4>{{ __('messages.Important_links') }}</h4>
                        </div>
                        <div class="list_footer">
                            <ul>
                                <li><a href="{{ route('front_contuct_us',['div'=>'1']) }}">{{ __('messages.Contact_us') }}</a></li>
                                <li><a href="{{ route('front_about_us',['div'=>'1']) }}">{{ __('messages.who_are_we') }}</a></li>
                                <li><a href="{{ route('front.terms_and_conditions',['div'=>'1']) }}">{{ __('messages.Terms_and_Conditions') }}</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="title_footer">
                            <h4>{{ __('messages.Contact_us') }}</h4>
                        </div>
                        <div class="contact_info">
                            <p>{{ __('messages.Technical_support') }}</p>
                            <a href="tel:01207053333">
                                <img src="{{asset('dist/front/assets/images/icons/phone-red.svg')}}" alt="" height="" width="">
                                01207053333
                            </a>
                        </div>
                        <div class="contact_info">
                            <p>{{ __('messages.Social_Media') }}</p>

                            <ul>
                                @if(request()->segment(count(request()->segments())) == 1 )
                                    <li><a href="https://www.facebook.com/Gado.air.conditioning"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="https://www.instagram.com/gado_cool/"><i class="fab fa-instagram"></i></a></li>

                                    {{--                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>--}}
                                    {{--                                <li><a href="#"><i class="fab fa-google"></i></a></li>--}}
                                    {{--                                <li><a href="https://www.youtube.com/channel/UCp2gY9kdN4-GzKCqqGEyatw" target="_blank"><i class="fab fa-youtube"></i></a></li>--}}
                                @else
                                    <li><a href="https://www.facebook.com/Gado.air.conditioning"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="https://www.instagram.com/gado_cool/"><i class="fab fa-instagram"></i></a></li>
                                    {{--                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>--}}
                                    {{--                                <li><a href="#"><i class="fab fa-google"></i></a></li>--}}
                                    {{--                                <li><a href="https://www.youtube.com/channel/UCp2gY9kdN4-GzKCqqGEyatw" target="_blank"><i class="fab fa-youtube"></i></a></li>--}}
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END:: MAIN FOOTER -->

        <!-- START:: COPYRIGHTS -->
        <div class="copy_rights">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="right_part">
                        <p>
                            {{ __('messages.Rights') }}
                            <a href="#">{{ __('messages.gadoo') }}</a>
                        </p>
                    </div>
                    <div class="right_part">
                        <img src="{{asset('dist/front/assets/images/icons/payments.svg')}}" width="" height="" alt="">
                    </div>
                </div>
            </div>
        </div>
        <!-- END:: COPYRIGHTS -->

        <!-- START:: FOOTER MOBILE -->
        <div class="footer_mobile">
            <ul>
                <li>
                    <a href="{{ route('front_home_cart',['div'=>'2']) }}">

                        <img src="{{asset('dist/front/assets/images/icons/cart.svg')}}" width="" height="" alt="">
                    </a>
                </li>
                <li>
                    @if(auth()->guard('customer')->check() || auth()->guard('dealer')->check())
                        <a href="{{ route('front_favourit_list',['div'=>'1']) }}">
                            <img src="{{asset('dist/front/assets/images/icons/heart.svg')}}" width="" height="" alt="">
                        </a>
                    @else
                        <a href="{{ route('front.login') }}">
                            <img src="{{asset('dist/front/assets/images/icons/heart.svg')}}" width="" height="" alt="">
                        </a>

                    @endif
                </li>
                <li>
                    <button type="button">
                        <img src="{{asset('dist/front/assets/images/icons/search-w.svg')}}" width="" height="" alt="">
                    </button>
                </li>
                <li>
                    @if(auth()->guard('customer')->check() || auth()->guard('dealer')->check())
                        <a href="{{ auth()->guard('customer')->check() ? route('customer.profile') : route('dealer.profile') }}">
                            <img src="{{asset('dist/front/assets/images/icons/user.svg')}}" width="" height="" alt="">
                        </a>
                    @else
                        <a href="{{ route('front.login') }}">
                            <img src="{{asset('dist/front/assets/images/icons/user.svg')}}" width="" height="" alt="">
                        </a>
                    @endif

                </li>
            </ul>
        </div>
        <!-- END:: FOOTER MOBILE -->

        <!-- START:: SEARCH FOOTER -->
        <div class="search_area">
            <form action="{{route('front_nav_search',['div'=>'2'])}}">
                <div class="form-group">
                    <input type="text"  name="search"  class="form-control" id="searchIcon" placeholder="ابحث هنا">
                    <button type="submit"><img src="{{asset('dist/front/assets/images/icons/search-w.svg')}}" alt="" width="" height="" />
                    </button>
                </div>
            </form>
            <div class="searchOverLay"></div>
        </div>
        <!-- END:: SEARCH FOOTER -->
    <!-- END HERE-->




@elseif($div == 1)
    <!-- START:: NEW LETTERS -->
    <div class="new_letters" style="background-color:#0a458b; color:#fff;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <div class="d-flex align-items-center">
                        <div class="big_new_letters">
                            <img src="{{asset('dist/front/assets/images/icons/message-w.svg')}}" alt="" width="" height="">
                        </div>
                        <div class="text_new_letters">
                            <h4>{{ __('messages.Newsletter') }}</h4>
                            <p>{{ __('messages.email_enter') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="subscripe_form">
                    <form  action="" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                            <div class="form-group">
                                <input type="email" name="email" required class="form-control subscripe_email_input"
                                    placeholder="{{ __('messages.email') }}">
                                <button type="button" class="btn-animation-3 save_subscripe_email">
                                    {{ __('messages.subscribe_now') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END:: NEW LETTERS -->

    <!-- START:: MAIN FOOTER -->
    <div class="main_footer" style="background-color:#fff;color:#0a458b;">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="about_footer">
                        <div class="title_footer">
                            <h4>{{ __('messages.about_store') }}</h4>
                        </div>
                        <div class="text_footer">
                            <p>{{ __('messages.about_store_desc_cool') }}</p>
                            <div class="download_links">
                                <a href="https://play.google.com/store/apps/details?id=com.gadoeg.app">
                                    <img src="{{asset('dist/front/assets/images/icons/google.svg')}}" alt="" width="" height="">
                                </a>
                                <a href="https://apps.apple.com/eg/app/gado-store/id1661092603">
                                    <img src="{{asset('dist/front/assets/images/icons/apple.svg')}}" alt="" width="" height="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="title_footer">
                        <h4>{{ __('messages.my_account') }}</h4>
                    </div>
                    <div class="list_footer">
                        <ul>
                        @if(auth()->guard('customer')->check() || auth()->guard('dealer')->check())
                            <li><a href="{{ auth()->guard('customer')->check() ? route('customer.profile') : route('dealer.profile') }}">{{ __('messages.my_account') }}</a></li>
                            <li><a href="{{ route('front_my_orders',['div'=>'1']) }}">{{ __('messages.My_Orders') }}</a></li>
                            <li><a href="{{ route('front_favourit_list',['div'=>'1']) }}">{{ __('messages.Favorite') }}</a></li>
                        @else
                            <li><a href="{{ route('front.login') }}">{{ __('messages.my_account') }}</a></li>
                            <li><a href="{{ route('front.login') }}">{{ __('messages.My_Orders') }}</a></li>
                            <li><a href="{{ route('front.login') }}">{{ __('messages.Favorite') }}</a></li>
                        @endif
                        </ul>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="title_footer">
                        <h4>{{ __('messages.Important_links') }}</h4>
                    </div>
                    <div class="list_footer">
                        <ul>
                            <li><a href="{{ route('front_contuct_us',['div'=>'1']) }}">{{ __('messages.Contact_us') }}</a></li>
                            <li><a href="{{ route('front_about_us',['div'=>'1']) }}">{{ __('messages.who_are_we') }}</a></li>
                            <li><a href="{{ route('front.terms_and_conditions',['div'=>'1']) }}">{{ __('messages.Terms_and_Conditions') }}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="title_footer">
                        <h4>{{ __('messages.Contact_us') }}</h4>
                    </div>
                    <div class="contact_info">
                        <p>{{ __('messages.Technical_support') }}</p>
                        <a href="tel:01207053333">
                            <img src="{{asset('dist/front/assets/images/icons/phone-red.svg')}}" alt="" height="" width="">
                            01207053333
                        </a>
                    </div>
                    <div class="contact_info">
                        <p>{{ __('messages.Social_Media') }}</p>
                        <ul>
                            <li><a href="https://www.facebook.com/Gado.air.conditioning"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="https://www.instagram.com/gado_cool/"><i class="fab fa-instagram"></i></a></li>
{{--                            <li><a href="#"><i class="fab fa-google"></i></a></li>--}}
{{--                            <li><a href="https://www.youtube.com/channel/UCp2gY9kdN4-GzKCqqGEyatw" target="_blank"><i class="fab fa-youtube"></i></a></li>--}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END:: MAIN FOOTER -->

    <!-- START:: COPYRIGHTS -->
    <div class="copy_rights" style="background-color:#0a458b; color:#fff;">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="right_part">
                    <p>
                        {{ __('messages.Rights') }}
                        <a href="#">{{ __('messages.gadoo') }}</a>
                    </p>
                </div>
                <div class="right_part">
                    <img src="{{asset('dist/front/assets/images/icons/payments.svg')}}" width="" height="" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- END:: COPYRIGHTS -->

    <!-- START:: FOOTER MOBILE -->
    <div class="footer_mobile" style="background-color:#0a458b; color:#fff;">
        <ul>
            <li>
                <a href="{{ route('front_home_cart',['div'=>'2']) }}">

                    <img src="{{asset('dist/front/assets/images/icons/cart.svg')}}" width="" height="" alt="">
                </a>
            </li>
            <li>
            @if(auth()->guard('customer')->check() || auth()->guard('dealer')->check())
            <a href="{{ route('front_favourit_list',['div'=>'1']) }}">
                    <img src="{{asset('dist/front/assets/images/icons/heart.svg')}}" width="" height="" alt="">
                </a>
            @else
            <a href="{{ route('front.login') }}">
                    <img src="{{asset('dist/front/assets/images/icons/heart.svg')}}" width="" height="" alt="">
                </a>
              
            @endif
            </li>
            <li>
                <button type="button">
                    <img src="{{asset('dist/front/assets/images/icons/search-w.svg')}}" width="" height="" alt="">
                </button>
            </li>
            <li>
            @if(auth()->guard('customer')->check() || auth()->guard('dealer')->check())
                <a href="{{ auth()->guard('customer')->check() ? route('customer.profile') : route('dealer.profile') }}">
                    <img src="{{asset('dist/front/assets/images/icons/user.svg')}}" width="" height="" alt="">
                </a>
                @else
            <a href="{{ route('front.login') }}">
                    <img src="{{asset('dist/front/assets/images/icons/user.svg')}}" width="" height="" alt="">
                </a>
            @endif

            </li>
        </ul>
    </div>
    <!-- END:: FOOTER MOBILE -->

    <!-- START:: SEARCH FOOTER -->
    <div class="search_area" style="background-color:#0a458b; color:#fff;">
    <form action="{{route('front_nav_search',['div'=>'2'])}}">
                        <div class="form-group">
                            <input type="text"  name="search"  class="form-control" id="searchIcon" placeholder="ابحث هنا">
                <button type="submit"><img src="{{asset('dist/front/assets/images/icons/search-w.svg')}}" alt="" width="" height="" />
                </button>
            </div>
        </form>
        <div class="searchOverLay"></div>
    </div>
    <!-- END:: SEARCH FOOTER -->

@elseif($div == 2)
  <!-- START:: NEW LETTERS -->
  <div class="new_letters">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <div class="d-flex align-items-center">
                        <div class="big_new_letters">
                            <img src="{{asset('dist/front/assets/images/icons/message-w.svg')}}" alt="" width="" height="">
                        </div>
                        <div class="text_new_letters">
                            <h4>{{ __('messages.Newsletter') }}</h4>
                            <p>{{ __('messages.email_enter') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="subscripe_form">
                        <form  action="" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                                <input type="email" name="email" required class="form-control subscripe_email_input"
                                    placeholder="{{ __('messages.email') }}">
                                <button type="button" class="btn-animation-3 save_subscripe_email">
                                    {{ __('messages.subscribe_now') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END:: NEW LETTERS -->

    <!-- START:: MAIN FOOTER -->
    <div class="main_footer">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="about_footer">
                        <div class="title_footer">
                            <h4>{{ __('messages.about_store') }}</h4>
                        </div>
                        <div class="text_footer">
                            <p>{{ __('messages.about_store_desc') }}</p>
                            <div class="download_links">
                                <a href="https://play.google.com/store/apps/details?id=com.gadoeg.app">
                                    <img src="{{asset('dist/front/assets/images/icons/google.svg')}}" alt="" width="" height="">
                                </a>
                                <a href="https://apps.apple.com/eg/app/gado-store/id1661092603">
                                    <img src="{{asset('dist/front/assets/images/icons/apple.svg')}}" alt="" width="" height="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="title_footer">
                        <h4>{{ __('messages.my_account') }}</h4>
                    </div>
                    <div class="list_footer">
                        <ul>
                        @if(auth()->guard('customer')->check() || auth()->guard('dealer')->check())
                            <li><a href="{{ auth()->guard('customer')->check() ? route('customer.profile') : route('dealer.profile') }}">{{ __('messages.my_account') }}</a></li>
                            <li><a href="{{ route('front_my_orders',['div'=>'1']) }}">{{ __('messages.My_Orders') }}</a></li>
                            <li><a href="{{ route('front_favourit_list',['div'=>'1']) }}">{{ __('messages.Favorite') }}</a></li>
                        @else
                            <li><a href="{{ route('front.login') }}">{{ __('messages.my_account') }}</a></li>
                            <li><a href="{{ route('front.login') }}">{{ __('messages.My_Orders') }}</a></li>
                            <li><a href="{{ route('front.login') }}">{{ __('messages.Favorite') }}</a></li>
                        @endif
                        </ul>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="title_footer">
                        <h4>{{ __('messages.Important_links') }}</h4>
                    </div>
                    <div class="list_footer">
                        <ul>
                            <li><a href="{{ route('front_contuct_us',['div'=>'1']) }}">{{ __('messages.Contact_us') }}</a></li>
                            <li><a href="{{ route('front_about_us',['div'=>'1']) }}">{{ __('messages.who_are_we') }}</a></li>
                            <li><a href="{{ route('front.terms_and_conditions',['div'=>'1']) }}">{{ __('messages.Terms_and_Conditions') }}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="title_footer">
                        <h4>{{ __('messages.Contact_us') }}</h4>
                    </div>
                    <div class="contact_info">
                        <p>{{ __('messages.Technical_support') }}</p>
                        <a href="tel:01207053333">
                            <img src="{{asset('dist/front/assets/images/icons/phone-red.svg')}}" alt="" height="" width="">
                            01207053333
                        </a>
                    </div>
                    <div class="contact_info">
                        <p>{{ __('messages.Social_Media') }}</p>
                       
                        <ul>
                            @if(request()->segment(count(request()->segments())) == 1 )
                                <li><a href="https://www.facebook.com/Gado.air.conditioning"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="https://www.instagram.com/gado_cool/"><i class="fab fa-instagram"></i></a></li>

                                {{--                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>--}}
{{--                                <li><a href="#"><i class="fab fa-google"></i></a></li>--}}
{{--                                <li><a href="https://www.youtube.com/channel/UCp2gY9kdN4-GzKCqqGEyatw" target="_blank"><i class="fab fa-youtube"></i></a></li>--}}
                            @else
                                <li><a href="https://www.facebook.com/Gado.air.conditioning"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="https://www.instagram.com/gado_cool/"><i class="fab fa-instagram"></i></a></li>
{{--                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>--}}
{{--                                <li><a href="#"><i class="fab fa-google"></i></a></li>--}}
{{--                                <li><a href="https://www.youtube.com/channel/UCp2gY9kdN4-GzKCqqGEyatw" target="_blank"><i class="fab fa-youtube"></i></a></li>--}}
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END:: MAIN FOOTER -->

    <!-- START:: COPYRIGHTS -->
    <div class="copy_rights">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="right_part">
                    <p>
                        {{ __('messages.Rights') }}
                        <a href="#">{{ __('messages.gadoo') }}</a>
                    </p>
                </div>
                <div class="right_part">
                    <img src="{{asset('dist/front/assets/images/icons/payments.svg')}}" width="" height="" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- END:: COPYRIGHTS -->

    <!-- START:: FOOTER MOBILE -->
    <div class="footer_mobile">
        <ul>
            <li>
                <a href="{{ route('front_home_cart',['div'=>'2']) }}">

                    <img src="{{asset('dist/front/assets/images/icons/cart.svg')}}" width="" height="" alt="">
                </a>
            </li>
            <li>
            @if(auth()->guard('customer')->check() || auth()->guard('dealer')->check())
            <a href="{{ route('front_favourit_list',['div'=>'1']) }}">
                    <img src="{{asset('dist/front/assets/images/icons/heart.svg')}}" width="" height="" alt="">
                </a>
            @else
            <a href="{{ route('front.login') }}">
                    <img src="{{asset('dist/front/assets/images/icons/heart.svg')}}" width="" height="" alt="">
                </a>
              
            @endif
            </li>
            <li>
                <button type="button">
                    <img src="{{asset('dist/front/assets/images/icons/search-w.svg')}}" width="" height="" alt="">
                </button>
            </li>
            <li>
            @if(auth()->guard('customer')->check() || auth()->guard('dealer')->check())
                <a href="{{ auth()->guard('customer')->check() ? route('customer.profile') : route('dealer.profile') }}">
                    <img src="{{asset('dist/front/assets/images/icons/user.svg')}}" width="" height="" alt="">
                </a>
            @else
            <a href="{{ route('front.login') }}">
                    <img src="{{asset('dist/front/assets/images/icons/user.svg')}}" width="" height="" alt="">
                </a>
            @endif

            </li>
        </ul>
    </div>
    <!-- END:: FOOTER MOBILE -->

    <!-- START:: SEARCH FOOTER -->
    <div class="search_area">
    <form action="{{route('front_nav_search',['div'=>'2'])}}">
                        <div class="form-group">
                            <input type="text"  name="search"  class="form-control" id="searchIcon" placeholder="ابحث هنا">
                <button type="submit"><img src="{{asset('dist/front/assets/images/icons/search-w.svg')}}" alt="" width="" height="" />
                </button>
            </div>
        </form>
        <div class="searchOverLay"></div>
    </div>
    <!-- END:: SEARCH FOOTER -->
   
    
@endif


    
</footer>


{{--  <div class="new_letters">--}}
{{--        <div class="container">--}}
{{--            <div class="row align-items-center">--}}
{{--                <div class="col-md-5">--}}
{{--                    <div class="d-flex align-items-center">--}}
{{--                        <div class="big_new_letters">--}}
{{--                            <img src="{{asset('dist/front/assets/images/icons/message-w.svg')}}" alt="" width="" height="">--}}
{{--                        </div>--}}
{{--                        <div class="text_new_letters">--}}
{{--                            <h4>{{ __('messages.Newsletter') }}</h4>--}}
{{--                            <p>{{ __('messages.email_enter') }}</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md-7">--}}
{{--                    <div class="subscripe_form">--}}
{{--                         <form  action="{{route('front_add_email')}}" method="post" enctype="multipart/form-data">--}}
{{--                        {{csrf_field()}}--}}
{{--                            <div class="form-group">--}}
{{--                                <input type="email" name="email" required class="form-control subscripe_email_input"--}}
{{--                                    placeholder="{{ __('messages.email') }}">--}}
{{--                                <button type="button" class="btn-animation-3 save_subscripe_email">--}}
{{--                                    {{ __('messages.subscribe_now') }}--}}
{{--                                </button>--}}
{{--                            </div>--}}
{{--                         </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <!-- END:: NEW LETTERS -->--}}

{{--    <!-- START:: MAIN FOOTER -->--}}
{{--    <div class="main_footer">--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <div class="col-md-5">--}}
{{--                    <div class="about_footer">--}}
{{--                        <div class="title_footer">--}}
{{--                            <h4>{{ __('messages.about_store') }}</h4>--}}
{{--                        </div>--}}
{{--                        <div class="text_footer">--}}
{{--                            <p>{{ __('messages.about_store_desc') }}</p>--}}
{{--                            <div class="download_links">--}}
{{--                                <a href="https://play.google.com/store/apps/details?id=com.gadoeg.app">--}}
{{--                                    <img src="{{asset('dist/front/assets/images/icons/google.svg')}}" alt="" width="" height="">--}}
{{--                                </a>--}}
{{--                                <a href="https://apps.apple.com/eg/app/gado-store/id1661092603">--}}
{{--                                    <img src="{{asset('dist/front/assets/images/icons/apple.svg')}}" alt="" width="" height="">--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md-2">--}}
{{--                    <div class="title_footer">--}}
{{--                        <h4>{{ __('messages.my_account') }}</h4>--}}
{{--                    </div>--}}
{{--                    <div class="list_footer">--}}
{{--                        <ul>--}}
{{--                        @if(auth()->guard('customer')->check() || auth()->guard('dealer')->check())--}}
{{--                            <li><a href="{{ auth()->guard('customer')->check() ? route('customer.profile') : route('dealer.profile') }}">{{ __('messages.my_account') }}</a></li>--}}
{{--                            <li><a href="{{ route('front_my_orders',['div'=>'1']) }}">{{ __('messages.My_Orders') }}</a></li>--}}
{{--                            <li><a href="{{ route('front_favourit_list',['div'=>'1']) }}">{{ __('messages.Favorite') }}</a></li>--}}
{{--                        @else--}}
{{--                            <li><a href="{{ route('front.login') }}">{{ __('messages.my_account') }}</a></li>--}}
{{--                            <li><a href="{{ route('front.login') }}">{{ __('messages.My_Orders') }}</a></li>--}}
{{--                            <li><a href="{{ route('front.login') }}">{{ __('messages.Favorite') }}</a></li>--}}
{{--                        @endif--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md-2">--}}
{{--                    <div class="title_footer">--}}
{{--                        <h4>{{ __('messages.Important_links') }}</h4>--}}
{{--                    </div>--}}
{{--                    <div class="list_footer">--}}
{{--                        <ul>--}}
{{--                            <li><a href="{{ route('front_contuct_us',['div'=>'1']) }}">{{ __('messages.Contact_us') }}</a></li>--}}
{{--                            <li><a href="{{ route('front_about_us',['div'=>'1']) }}">{{ __('messages.who_are_we') }}</a></li>--}}
{{--                            <li><a href="{{ route('front.terms_and_conditions',['div'=>'1']) }}">{{ __('messages.Terms_and_Conditions') }}</a></li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md-3">--}}
{{--                    <div class="title_footer">--}}
{{--                        <h4>{{ __('messages.Contact_us') }}</h4>--}}
{{--                    </div>--}}
{{--                    <div class="contact_info">--}}
{{--                        <p>{{ __('messages.Technical_support') }}</p>--}}
{{--                        <a href="tel:01207053333">--}}
{{--                            <img src="{{asset('dist/front/assets/images/icons/phone-red.svg')}}" alt="" height="" width="">--}}
{{--                            01207053333--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                    <div class="contact_info">--}}
{{--                        <p>{{ __('messages.Social_Media') }}</p>--}}
{{--                        <ul>--}}

{{--                            <li><a href="https://www.facebook.com/Gado.air.conditioning"><i class="fab fa-facebook-f"></i></a></li>--}}
{{--                            <li><a href="https://www.instagram.com/gado_cool/"><i class="fab fa-instagram"></i></a></li>--}}
{{--                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>--}}
{{--                            <li><a href="#"><i class="fab fa-instagram"></i></a></li>--}}
{{--                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>--}}
{{--                            <li><a href="#"><i class="fab fa-google"></i></a></li>--}}
{{--                            <li><a href="https://www.youtube.com/channel/UCp2gY9kdN4-GzKCqqGEyatw" target="_blank"><i class="fab fa-youtube"></i></a></li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <!-- END:: MAIN FOOTER -->--}}

{{--    <!-- START:: COPYRIGHTS -->--}}
{{--    <div class="copy_rights">--}}
{{--        <div class="container">--}}
{{--            <div class="d-flex justify-content-between align-items-center">--}}
{{--                <div class="right_part">--}}
{{--                    <p>--}}
{{--                    {{ __('messages.Rights') }}--}}
{{--                        <a href="#">{{ __('messages.gadoo') }}</a>--}}
{{--                    </p>--}}
{{--                </div>--}}
{{--                <div class="right_part">--}}
{{--                    <img src="{{asset('dist/front/assets/images/icons/payments.svg')}}" width="" height="" alt="">--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <!-- END:: COPYRIGHTS -->--}}

{{--    <!-- START:: FOOTER MOBILE -->--}}
{{--    <div class="footer_mobile">--}}
{{--        <ul>--}}
{{--            <li>--}}
{{--                <a href="{{ route('front_home_cart',['div'=>'2']) }}">--}}

{{--                    <img src="{{asset('dist/front/assets/images/icons/cart.svg')}}" width="" height="" alt="">--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li>--}}
{{--            @if(auth()->guard('customer')->check() || auth()->guard('dealer')->check())--}}
{{--            <a href="{{ route('front_favourit_list',['div'=>'1']) }}">--}}
{{--                    <img src="{{asset('dist/front/assets/images/icons/heart.svg')}}" width="" height="" alt="">--}}
{{--                </a>--}}
{{--            @else--}}
{{--            <a href="{{ route('front.login') }}">--}}
{{--                    <img src="{{asset('dist/front/assets/images/icons/heart.svg')}}" width="" height="" alt="">--}}
{{--                </a>--}}

{{--            @endif--}}

{{--            </li>--}}
{{--            <li>--}}
{{--                <button type="button">--}}
{{--                    <img src="{{asset('dist/front/assets/images/icons/search-w.svg')}}" width="" height="" alt="">--}}
{{--                </button>--}}
{{--            </li>--}}
{{--            <li>--}}
{{--            @if(auth()->guard('customer')->check() || auth()->guard('dealer')->check())--}}
{{--                <a href="{{ auth()->guard('customer')->check() ? route('customer.profile') : route('dealer.profile') }}">--}}
{{--                    <img src="{{asset('dist/front/assets/images/icons/user.svg')}}" width="" height="" alt="">--}}
{{--                </a>--}}
{{--                @else--}}
{{--            <a href="{{ route('front.login') }}">--}}
{{--                    <img src="{{asset('dist/front/assets/images/icons/user.svg')}}" width="" height="" alt="">--}}
{{--                </a>--}}
{{--            @endif--}}

{{--            </li>--}}
{{--        </ul>--}}
{{--    </div>--}}
{{--    <!-- END:: FOOTER MOBILE -->--}}

{{--    <!-- START:: SEARCH FOOTER -->--}}
{{--    <div class="search_area">--}}
{{--    <form action="{{route('front_nav_search',['div'=>'2'])}}">--}}
{{--                        <div class="form-group">--}}
{{--                            <input type="text"  name="search"  class="form-control" id="searchIcon" placeholder="ابحث هنا">--}}
{{--                <button type="submit"><img src="{{asset('dist/front/assets/images/icons/search-w.svg')}}" alt="" width="" height="" />--}}
{{--                </button>--}}
{{--            </div>--}}
{{--        </form>--}}
{{--        <div class="searchOverLay"></div>--}}
{{--    </div>--}}
{{--    <!-- END:: SEARCH FOOTER -->--}}