<header>
    @if($div == 1)
        <!-- START:: TOP HEADER -->
        <div class="top_header" style="background-color:#0a458b; color:#fff;">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="phone_number">
                        <a href="tel:01207053333">
                            <img src="{{asset('dist/front/assets/images/icons/phone.svg')}}" alt="" height="" width="">
                            01207053333
                        </a>
                    </div>
                    <div class="login_lang">

                        <div class="lang">
                            <!--<strong>{{ __('messages.Choose_Language') }} </strong>-->

                            {{--                            <select class="changeLang" --}}
                            {{--                                    style=" background: rgba(250, 250, 250, 0.0);border:none">--}}
                            {{--                                <option value="ar"--}}
                            {{--                                        {{ session()->get('locale') == 'ar' ? 'selected' : '' }} data-img-src="{{asset('egypt.png')}}">--}}
                            {{--                                    <img src="{{asset('egypt.png')}}" alt="not-found"--}}
                            {{--                                         style="width: 20px; height: 20px;"/>--}}
                            {{--                                    <i class="fa-solid fa-flag-usa"></i>--}}
                            {{--                                    🇪🇬 العربية--}}
                            {{--                                </option>--}}

                            {{--                                <option value="en"--}}
                            {{--                                        {{ session()->get('locale') == 'en' ? 'selected' : '' }} data-img-src="{{asset('united-states.png')}}">--}}
                            {{--                                    <img src="{{asset('united-states.png')}}" alt="not-found"--}}
                            {{--                                         style="width: 20px; height: 20px;"/>--}}
                            {{--                                    English 🇬🇧--}}
                            {{--                                </option>--}}
                            {{--                            </select>--}}


                            <div class="custom-dropdown">
                                <div class="dropdown-display">
                                    @if(app()->getLocale() == 'en' )
                                        <a href="{{ route('newLangChange','ar')}}">
                                            <img src="{{asset('egypt.png')}}" alt="Image 1"
                                                 style="margin-left: 10px;margin-top: 4px;">
                                            <span class="languageSpan">  العربية</span>
                                        </a>
                                    @else
                                        <a href="{{route('newLangChange','en')}}">
                                            <img src="{{asset('united-states.png')}}" alt="Image 2"
                                                 style="margin-left: 10px;margin-top: 4px;"/>
                                            <span class="languageSpan">  English  </span>
                                        </a>
                                    @endif
                                </div>
                            </div>

                        </div>
                        @if(auth()->guard('customer')->check() || auth()->guard('dealer')->check())
                            <div class="dropdown login_btns_with_auth">
                                <button class="dropdown-toggle" type="button" id="dropdownMenuButton1"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{asset('dist/front/assets/images/icons/user.svg')}}" alt="" height=""
                                         width=""/>

                                    @if(auth()->guard('customer')->check())
                                        <span> {{ auth()->guard('customer')->user()->name }}</span>
                                    @elseif( auth()->guard('dealer')->check())
                                        <span> {{ auth()->guard('dealer')->user()->name }}</span>
                                    @endif

                                    <i class="fas fa-chevron-down"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li>
                                        <a class="dropdown-item"
                                           href="{{ auth()->guard('customer')->check() ? route('customer.profile') : route('dealer.profile') }}">
                                            <img src="{{asset('dist/front/assets/images/icons/setting.svg')}}" alt=""
                                                 height="" width=""/>
                                            {{ __('messages.Profile') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('front_my_orders',['div'=>$div]) }}">
                                            <img src="{{asset('dist/front/assets/images/icons/cart_p.svg')}}" alt=""
                                                 height="" width=""/>
                                            {{ __('messages.My_Orders') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item"
                                           href="{{ auth()->guard('customer')->check() ? route('customer.logout') : route('dealer.logout') }}">
                                            <img src="{{asset('dist/front/assets/images/icons/logout.svg')}}" alt=""
                                                 height="" width=""/>
                                            {{ __('messages.log_out') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        @endif
                        @if(!auth()->guard('customer')->check() && !auth()->guard('dealer')->check())
                            <div class="login_btns">
                                <img src="{{asset('dist/front/assets/images/icons/user.svg')}}" alt="" height=""
                                     width=""/>
                                <ul>
                                    <li><a href="{{ route('front.login') }}">{{ __('messages.Login') }}</a></li>
                                    <li>/</li>
                                    <li>
                                        <a href="{{ route('front.verify_phone') }}">{{ __('messages.Create_account') }} </a>
                                    </li>
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- END:: TOP HEADER -->

        <!-- START:: CENTER HEADER -->
        <div class="center_header" style="background-color:#fff; color:#0a458b;">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">

                    <div class="logo_site">
                        <a href="{{route('front.home','1')}}"> <img
                                    src="{{asset('dist/front/assets/images/logo/logo2.png')}}" alt="" height=""
                                    width=""></a>
                    </div>

                    <div class="search_site">
                        <form action="{{route('front_nav_search',['div'=>$div])}}">
                            <div class="form-group">
                                <input type="text" name="search" class="form-control" id="searchIcon"
                                       placeholder="ابحث هنا">
                                <button type="submit" class="searchSubmit"><img
                                            src="{{asset('dist/front/assets/images/icons/search.svg')}}" alt="" width=""
                                            height=""/></button>
                            </div>
                        </form>
                    </div>

                    <div class="wishlist_cart">
                        <div class="wishlist_icon">
                            @if(auth()->guard('customer')->check() || auth()->guard('dealer')->check())

                                <a style="background-color:#fff; color:#0a458b;"
                                   href="{{ route('front_favourit_list',['div'=>$div]) }}">
                                    @else
                                        <a style="background-color:#fff; color:#0a458b;"
                                           href="{{ route('front.login') }}">
                                            @endif
                                            <img src="{{asset('dist/front/assets/images/icons/heart.svg')}}"
                                                 style="filter: grayscale(100%);" alt="" width="" height=""/>
                                            @if(auth()->guard('customer')->check() || auth()->guard('dealer')->check())
                                                @if(auth()->guard('dealer')->check())
                                                    <small class="favvv">{{count(auth()->guard('dealer')->user()->ProLikes)}}</small>
                                                @else
                                                    <small class="favvv">{{count(auth()->guard('customer')->user()->ProLikes)}}</small>
                                                @endif
                                            @endif
                                        </a>
                        </div>
                        <div class="cart_icon" style="background-color:#fff; color:#0a458b;">

                            <a href="{{ route('front_home_cart',['div'=>$div]) }}">
                                <div>
                                    <img src="{{asset('dist/front/assets/images/icons/cart.svg')}}" alt="" width=""
                                         height=""/>


                                    @if(!is_null( GetCarts()) && count( GetCarts()->Carts) > 0)
                                        <small class="cart_num">
                                            {{count( GetCarts()->Carts)}}
                                        </small>
                                    @else
                                        <small class="cart_num" style="display: contents;"></small>
                                    @endif


                                </div>
                                <div>
                                    <h6 style="color: black"> {{ __('messages.shopping_cart') }}</h6>
                                    @if(!is_null( GetCarts()) && count( GetCarts()->Carts) > 0)
                                        <p class="cart_tot" style="color: black">


                                            {{ GetCarts()->total}}


                                            جنيه</p>
                                    @else
                                        <p class="cart_tot">


                                        </p>
                                    @endif
                                </div>
                            </a>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- END:: CENTER HEADER -->

        <!-- START:: BOTTOM HEADER -->
        <div class="bottom_header" style="background-color:#0a458b; color:#fff;">
            <div class="container">
                <nav class="main_menu">
                    <ul>
                        <li><a href="{{ url('/') }}" class="active">{{ __('messages.Home') }}</a></li>
                        <li>
                            <a href="{{ route('front_show_more',['div'=>$div]) }}"> {{ __('messages.Todays_Offers') }}</a>
                        </li>
                        <li><a href="{{ route('front_about_us',['div'=>$div]) }}"> {{ __('messages.about_us') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('front_show_more', ['div'=>$div,'kind'=>'1']) }}">
                                {{ __('messages.newly_added') }}
                                <small> {{ __('messages.new') }}</small>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('front_show_more', ['div'=>$div,'kind'=>'2']) }}">  {{ __('messages.best_seller') }}</a>
                        </li>
                        <li>
                            <div class="login_lang">
                                <div class="dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton1"
                                            data-bs-toggle="dropdown" aria-expanded="false">

                                        {{ __('messages.sections') }}
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        @if(isset($data))
                                            @if(isset($data->Categories))
                                                @foreach($data->Categories as $value)
                                                    <li>
                                                        <a class="dropdown-item"
                                                           href="{{ route('front_show_more', ['div'=>$div,'id'=>$value->id]) }}">
                                                            @if(session()->get('locale') == "en")

                                                                {{$value->name_en}}
                                                            @else
                                                                {{$value->name_ar}}
                                                            @endif

                                                        </a>
                                                    </li>
                                                @endforeach
                                            @else
                                                @foreach($data as $value)
                                                    <li>
                                                        <a class="dropdown-item"
                                                           href="{{ route('front_show_more', ['div'=>$div,'id'=>$value->id]) }}">
                                                            @if(session()->get('locale') == "en")

                                                                {{$value->name_en}}
                                                            @else
                                                                {{$value->name_ar}}
                                                            @endif
                                                        </a>
                                                    </li>
                                                @endforeach
                                            @endif
                                        @else
                                            @foreach(\App\Division::get() as $value)
                                                <li>
                                                    <a class="dropdown-item"
                                                       href="{{ route('front_show_more', ['div'=>$div,'id'=>$value->id]) }}">
                                                        @if(session()->get('locale') == "en")

                                                            {{$value->name_en}}
                                                        @else
                                                            {{$value->name_ar}}
                                                        @endif
                                                    </a>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li>
                            <a href="{{ route('front_contuct_us',['div'=>$div]) }}">  {{ __('messages.Contact_us') }}</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- END:: BOTTOM HEADER -->

        <!-- START:: HEADER MOBILE -->
        <div class="mobile_header" style="background-color:#0a458b; color:#fff;">
            <div class="logo_mobile">
                <img src="{{asset('dist/front/assets/images/logo/logo2.png')}}" width="" height="" alt="">
            </div>
            <div class="btn_menu">
                <button type="button" class="toggleClassBtn">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>
        <nav class="side_menu_mobile main_menu">
            <ul>
                <li><a href="{{ url('/') }}" class="active">{{ __('messages.Home') }}</a></li>
                <li><a href="{{ route('front_show_more',['div'=>$div]) }}"> {{ __('messages.Todays_Offers') }}</a></li>
                <li><a href="{{ route('front_about_us',['div'=>$div]) }}">  {{ __('messages.about_us') }}</a></li>
                <li>
                    <a href="{{ route('front_show_more', ['div'=>$div,'kind'=>'1']) }}">
                        {{ __('messages.newly_added') }}
                        <small> {{ __('messages.new') }}</small>
                    </a>
                </li>
                <li>
                    <a href="{{ route('front_show_more', ['div'=>$div,'kind'=>'2']) }}"> {{ __('messages.best_seller') }} </a>
                </li>
                @if(isset($data))
                    @if(isset($data->Categories))
                        @foreach($data->Categories as $value)
                            <li>
                                <a class="dropdown-item"
                                   href="{{ route('front_show_more', ['div'=>$div,'id'=>$value->id]) }}">
                                    {{$value->name_ar}}
                                </a>
                            </li>
                        @endforeach
                    @else
                        @foreach($data as $value)
                            <li>
                                <a class="dropdown-item"
                                   href="{{ route('front_show_more', ['div'=>$div,'id'=>$value->id]) }}">
                                    @if(session()->get('locale') == "en")

                                        {{$value->name_en}}
                                    @else
                                        {{$value->name_ar}}
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    @endif
                @else
                    @foreach(\App\Division::get() as $value)
                        <li>
                            <a class="dropdown-item"
                               href="{{ route('front_show_more', ['div'=>$div,'id'=>$value->id]) }}">
                                @if(session()->get('locale') == "en")

                                    {{$value->name_en}}
                                @else
                                    {{$value->name_ar}}
                                @endif
                            </a>
                        </li>
                    @endforeach
                @endif
                <li><a href="{{ route('front_contuct_us',['div'=>$div]) }}">   {{ __('messages.Contact_us') }}</a></li>
            </ul>
        </nav>
        <div class="overLay_side_menu"></div>
    @endif
    @if($div == 2)
        <!-- START:: TOP HEADER -->
        <div class="top_header">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="phone_number">
                        <a href="tel:01207053333">
                            <img src="{{asset('dist/front/assets/images/icons/phone.svg')}}" alt="" height="" width="">
                            01207053333
                        </a>
                    </div>

                    <div class="login_lang">
                        <div class="lang">
                            <!--<strong>{{ __('messages.Choose_Language') }} </strong>-->

                            {{--                            <select class="changeLang" style=" background: rgba(250, 250, 250, 0.0);border:none">--}}
                            {{--                                <option value="ar" {{ session()->get('locale') == 'ar' ? 'selected' : '' }}>🇪🇬&emsp;العربية</option>--}}

                            {{--                                <option value="en" {{ session()->get('locale') == 'en' ? 'selected' : '' }}>English 🇬🇧&emsp;</option>--}}

                            {{--                            </select>--}}


                            <div class="custom-dropdown">
                                <div class="dropdown-display">
                                    @if(app()->getLocale() == 'en' )
                                        <a href="{{ route('newLangChange','ar')}}" >
                                            <img src="{{asset('egypt.png')}}" alt="Image 1"
                                                 style="margin-left: 10px;margin-top: 4px;">
                                            <span style="color: white" class="languageSpan">  العربية</span>
                                        </a>
                                    @else
                                        <a href="{{route('newLangChange','en')}}">
                                            <img src="{{asset('united-states.png')}}" alt="Image 2"
                                                 style="margin-left: 10px;margin-top: 4px;"/>
                                            <span  style="color: white;" class="languageSpan">  English </span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if(auth()->guard('customer')->check() || auth()->guard('dealer')->check())
                            <div class="dropdown login_btns_with_auth">
                                <button class="dropdown-toggle" type="button" id="dropdownMenuButton1"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{asset('dist/front/assets/images/icons/user.svg')}}" alt="" height=""
                                         width=""/>

                                    @if(auth()->guard('customer')->check())
                                        <span> {{ auth()->guard('customer')->user()->name }}</span>
                                    @elseif( auth()->guard('dealer')->check())
                                        <span> {{ auth()->guard('dealer')->user()->name }}</span>
                                    @endif

                                    <i class="fas fa-chevron-down"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li>
                                        <a class="dropdown-item"
                                           href="{{ auth()->guard('customer')->check() ? route('customer.profile') : route('dealer.profile') }}">
                                            <img src="{{asset('dist/front/assets/images/icons/setting.svg')}}" alt=""
                                                 height="" width=""/>
                                            {{ __('messages.Profile') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('front_my_orders',['div'=>$div]) }}">
                                            <img src="{{asset('dist/front/assets/images/icons/cart_p.svg')}}" alt=""
                                                 height="" width=""/>
                                            {{ __('messages.My_Orders') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item"
                                           href="{{ auth()->guard('customer')->check() ? route('customer.logout') : route('dealer.logout') }}">
                                            <img src="{{asset('dist/front/assets/images/icons/logout.svg')}}" alt=""
                                                 height="" width=""/>
                                            {{ __('messages.log_out') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        @endif

                        @if(!auth()->guard('customer')->check() && !auth()->guard('dealer')->check())
                            <div class="login_btns">
                                <img src="{{asset('dist/front/assets/images/icons/user.svg')}}" alt="" height=""
                                     width=""/>
                                <ul>
                                    <li><a href="{{ route('front.login') }}">{{ __('messages.Login') }}</a></li>
                                    <li>/</li>
                                    <li>
                                        <a href="{{ route('front.verify_phone') }}">{{ __('messages.Create_account') }}</a>
                                    </li>
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- END:: TOP HEADER -->

        <!-- START:: CENTER HEADER -->
        <div class="center_header">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="logo_site">
                        <a href="{{route('front.home','2')}}"> <img
                                    src="{{asset('dist/front/assets/images/logo/logo.png')}}" alt="" height="" width=""></a>
                    </div>


                    <div class="search_site">
                        <form action="{{route('front_nav_search',['div'=>$div])}}">
                            <div class="form-group">
                                <input type="text" name="search" class="form-control" id="searchIcon"
                                       placeholder="ابحث هنا">
                                <button type="submit" class="searchSubmit"><img
                                            src="{{asset('dist/front/assets/images/icons/search.svg')}}" alt="" width=""
                                            height=""/></button>
                            </div>
                        </form>
                    </div>

                    <div class="wishlist_cart">
                        <div class="wishlist_icon">
                            @if(auth()->guard('customer')->check() || auth()->guard('dealer')->check())

                                <a href="{{ route('front_favourit_list',['div'=>$div]) }}">
                                    @else
                                        <a href="{{ route('front.login') }}">
                                            @endif
                                            <img src="{{asset('dist/front/assets/images/icons/heart.svg')}}" alt=""
                                                 width="" height=""/>
                                            @if(auth()->guard('customer')->check() || auth()->guard('dealer')->check())
                                                @if(auth()->guard('dealer')->check())
                                                    <small class="favvv">{{count(auth()->guard('dealer')->user()->ProLikes)}}</small>
                                                @else
                                                    <small class="favvv">{{count(auth()->guard('customer')->user()->ProLikes)}}</small>
                                                @endif
                                            @endif
                                        </a>
                        </div>
                        <div class="cart_icon">

                            <a href="{{ route('front_home_cart',['div'=>$div]) }}">
                                <div>
                                    <img src="{{asset('dist/front/assets/images/icons/cart.svg')}}" alt="" width=""
                                         height=""/>


                                    @if(!is_null( GetCarts()) && count( GetCarts()->Carts) > 0)
                                        <small class="cart_num">
                                            {{count( GetCarts()->Carts)}}
                                        </small>
                                    @else
                                        <small class="cart_num" style="display: contents;"></small>
                                    @endif


                                </div>
                                <div>
                                    <h6>{{ __('messages.shopping_cart') }}</h6>
                                    @if(!is_null( GetCarts()) && count( GetCarts()->Carts) > 0)
                                        <p class="cart_tot">


                                            {{ GetCarts()->total}}


                                            جنيه</p>
                                    @else
                                        <p class="cart_tot">


                                        </p>
                                    @endif
                                </div>
                            </a>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- END:: CENTER HEADER -->

        <!-- START:: BOTTOM HEADER -->
        <div class="bottom_header">
            <div class="container">
                <nav class="main_menu">
                    <ul>
                        <li><a href="{{ url('/') }}" class="active">{{ __('messages.Home') }}</a></li>
                        <li>
                            <a href="{{ route('front_show_more',['div'=>$div]) }}"> {{ __('messages.Todays_Offers') }}</a>
                        </li>
                        <li><a href="{{ route('front_about_us',['div'=>$div]) }}">{{ __('messages.about_us') }}</a></li>
                        <li>
                            <a href="{{ route('front_show_more', ['div'=>$div,'kind'=>'1']) }}">
                                {{ __('messages.newly_added') }}
                                <small>{{ __('messages.new') }}</small>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('front_show_more', ['div'=>$div,'kind'=>'2']) }}"> {{ __('messages.best_seller') }}</a>
                        </li>
                        <li>
                            <div class="login_lang">
                                <div class="dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton1"
                                            data-bs-toggle="dropdown" aria-expanded="false">

                                        {{ __('messages.sections') }}
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        @if(isset($data))
                                            @if(isset($data->Categories))
                                                @foreach($data->Categories as $value)
                                                    <li>
                                                        <a class="dropdown-item"
                                                           href="{{ route('front_show_more', ['div'=>$div,'id'=>$value->id]) }}">
                                                            @if(session()->get('locale') == "en")

                                                                {{$value->name_en}}
                                                            @else
                                                                {{$value->name_ar}}
                                                            @endif
                                                        </a>
                                                    </li>
                                                @endforeach
                                            @else
                                                @foreach($data as $value)
                                                    <li>
                                                        <a class="dropdown-item"
                                                           href="{{ route('front_show_more', ['div'=>$div,'id'=>$value->id]) }}">
                                                            @if(session()->get('locale') == "en")

                                                                {{$value->name_en}}
                                                            @else
                                                                {{$value->name_ar}}
                                                            @endif
                                                        </a>
                                                    </li>
                                                @endforeach
                                            @endif
                                        @else
                                            @foreach(\App\Division::get() as $value)
                                                <li>
                                                    <a class="dropdown-item"
                                                       href="{{ route('front_show_more', ['div'=>$div,'id'=>$value->id]) }}">
                                                        @if(session()->get('locale') == "en")

                                                            {{$value->name_en}}
                                                        @else
                                                            {{$value->name_ar}}
                                                        @endif
                                                    </a>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li><a href="{{ route('front_contuct_us',['div'=>$div]) }}">{{ __('messages.Contact_us') }}</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- END:: BOTTOM HEADER -->

        <!-- START:: HEADER MOBILE -->
        <div class="mobile_header">
            <div class="logo_mobile">
                <img src="{{asset('dist/front/assets/images/logo/logo.png')}}" width="" height="" alt="">
            </div>
            <div class="btn_menu">
                <button type="button" class="toggleClassBtn">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>
        <nav class="side_menu_mobile main_menu">
            <ul>
                <li><a href="{{ url('/') }}" class="active">{{ __('messages.Home') }}</a></li>
                <li><a href="{{ route('front_show_more',['div'=>$div]) }}"> {{ __('messages.Todays_Offers') }}</a></li>
                <li><a href="{{ route('front_about_us',['div'=>$div]) }}">{{ __('messages.about_us') }}</a></li>
                <li>
                    <a href="{{ route('front_show_more', ['div'=>$div,'kind'=>'1']) }}">
                        {{ __('messages.newly_added') }}
                        <small>{{ __('messages.new') }}</small>
                    </a>
                </li>
                <li>
                    <a href="{{ route('front_show_more', ['div'=>$div,'kind'=>'2']) }}"> {{ __('messages.best_seller') }}</a>
                </li>
                @if(isset($data))
                    @if(isset($data->Categories))
                        @foreach($data->Categories as $value)
                            <li>
                                <a class="dropdown-item"
                                   href="{{ route('front_show_more', ['div'=>$div,'id'=>$value->id]) }}">
                                    {{$value->name_ar}}
                                </a>
                            </li>
                        @endforeach
                    @else
                        @foreach($data as $value)
                            <li>
                                <a class="dropdown-item"
                                   href="{{ route('front_show_more', ['div'=>$div,'id'=>$value->id]) }}">
                                    @if(session()->get('locale') == "en")

                                        {{$value->name_en}}
                                    @else
                                        {{$value->name_ar}}
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    @endif
                @else
                    @foreach(\App\Division::get() as $value)
                        <li>
                            <a class="dropdown-item"
                               href="{{ route('front_show_more', ['div'=>$div,'id'=>$value->id]) }}">
                                @if(session()->get('locale') == "en")

                                    {{$value->name_en}}
                                @else
                                    {{$value->name_ar}}
                                @endif
                            </a>
                        </li>
                    @endforeach
                @endif
                <li><a href="{{ route('front_contuct_us',['div'=>$div]) }}">{{ __('messages.Contact_us') }}</a></li>
            </ul>
        </nav>
        <div class="overLay_side_menu"></div>
    @endif
    <!-- END:: HEADER MOBILE -->
</header>