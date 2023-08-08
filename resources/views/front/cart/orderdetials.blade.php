@extends('front.layout.app')

@section('content')

    @include('front.parts.header')
    <!-- START:: SLIDER HERO SECTION -->

    <!-- START:: INFO SITE SECTION -->



    <main>
        <!-- START:: BREADCRUMBS -->
        <div class="breadcrumbs">
            <div class="container">
                <h1>   {{ __('messages.Order_details') }}</h1>
                <ul>
                    <li>
                        <a href="{{ url('/') }}">
                            <img src="{{asset('dist/front/assets/images/icons/home.svg')}}" alt="" height="" width=""/>
                            {{ __('messages.Home') }}
                        </a>
                    </li>
                    <li>/</li>
                    <li class="active"> {{ __('messages.Order_details') }}</li>
                </ul>
            </div>
        </div>
        <!-- END:: BREADCRUMBS -->

        <!-- START:: CONTENT PAGE -->
        <div class="content_single_page">
            <div class="container mt-5">
                <div class="row">

                    <div class="col-md-8">

                        <div class="content_page_shop mb-3 p-0">
                            <div class="title_page">
                                <h4>{{ __('messages.delivery_number') }}: #{{$ord->id}}
                                    <span> {{Date::parse($ord->created_at)->format('Y-m-d')}} </span></h4>
                            </div>
                            <div class="order_tracking_bar">
                                <ul>
                                    @if($ord->status == 2)
                                        <li class="active">
                                            <img src="{{asset('dist/front/assets/images/icons/check-or.svg')}}" width=""
                                                 height="" alt=""/>
                                            {{ __('messages.Processing') }}
                                        </li>
                                        <li>
                                            <img src="{{asset('dist/front/assets/images/icons/check_radio.svg')}}"
                                                 width="" height="" alt=""/>
                                            {{ __('messages.on_way') }}
                                        </li>
                                        <li>
                                            <img src="{{asset('dist/front/assets/images/icons/check_radio.svg')}}"
                                                 width="" height="" alt=""/>
                                            {{ __('messages.received') }}
                                        </li>
                                    @endif
                                    @if($ord->status == 3)
                                        <li class="active">
                                            <img src="{{asset('dist/front/assets/images/icons/check-or.svg')}}" width=""
                                                 height="" alt=""/>
                                            {{ __('messages.Processing') }}
                                        </li>
                                        <li class="active">
                                            <img src="{{asset('dist/front/assets/images/icons/check-or.svg')}}" width=""
                                                 height="" alt=""/>
                                            {{ __('messages.on_way') }}
                                        </li>
                                        <li>
                                            <img src="{{asset('dist/front/assets/images/icons/check_radio.svg')}}"
                                                 width="" height="" alt=""/>
                                            {{ __('messages.received') }}
                                        </li>
                                    @endif
                                    @if($ord->status == 4)
                                        <li class="active">
                                            <img src="{{asset('dist/front/assets/images/icons/check-or.svg')}}" width=""
                                                 height="" alt=""/>
                                            {{ __('messages.Processing') }}
                                        </li>
                                        <li class="active">
                                            <img src="{{asset('dist/front/assets/images/icons/check-or.svg')}}" width=""
                                                 height="" alt=""/>
                                            {{ __('messages.on_way') }}
                                        </li>
                                        <li class="active">
                                            <img src="{{asset('dist/front/assets/images/icons/check-or.svg')}}" width=""
                                                 height="" alt=""/>
                                            {{ __('messages.received') }}
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="product_details_section content_page_shop p-0">
                            <div class="title_page">
                                <h4>{{ __('messages.Order_details') }}</h4>
                            </div>
                            @foreach($ord->OrderProducts as $val)
                                <form action="#">
                                    <!-- START:: SINGLE ITEM -->
                                    <div class="single_item_shop">

                                        <div class="itemFlex">
                                            <div class="image_item">
                                                <img src="{{ $val->Product->card_image }}" alt="" width="" height="">
                                            </div>
                                            <div class="content_item">
                                                <!-- START:: HEAD  -->
                                                <div class="head_details">

                                                    <h4><a href="#">
                                                            @if(session()->get('locale') == "en")
                                                                {{$val->Product->name_en}}
                                                            @else
                                                                {{ $val->Product->name_ar }}
                                                            @endif</a>
                                                    </h4>
                                                    <div class="rate_part">
                                                        <ul>
                                                            @if($val->Product->rate == 0)
                                                                <li><i class="fas fa-star color-non"></i></li>
                                                                <li><i class="fas fa-star color-none"></i></li>
                                                                <li><i class="fas fa-star color-none"></i></li>
                                                                <li><i class="fas fa-star color-none"></i></li>
                                                                <li><i class="fas fa-star color-none"></i></li>
                                                            @endif
                                                            @if($val->Product->rate >= 1 && $val->Product->rate < 2)
                                                                <li><i class="fas fa-star"></i></li>
                                                                <li><i class="fas fa-star color-none"></i></li>
                                                                <li><i class="fas fa-star color-none"></i></li>
                                                                <li><i class="fas fa-star color-none"></i></li>
                                                                <li><i class="fas fa-star color-none"></i></li>
                                                            @endif
                                                            @if($val->Product->rate > 1 && $val->Product->rate <= 2 && $val->Product->rate < 3)
                                                                <li><i class="fas fa-star"></i></li>
                                                                <li><i class="fas fa-star"></i></li>
                                                                <li><i class="fas fa-star color-none"></i></li>
                                                                <li><i class="fas fa-star color-none"></i></li>
                                                                <li><i class="fas fa-star color-none"></i></li>
                                                            @endif
                                                            @if($val->Product->rate > 2 && $val->Product->rate <= 3 && $val->Product->rate < 4)
                                                                <li><i class="fas fa-star"></i></li>
                                                                <li><i class="fas fa-star"></i></li>
                                                                <li><i class="fas fa-star"></i></li>
                                                                <li><i class="fas fa-star color-none"></i></li>
                                                                <li><i class="fas fa-star color-none"></i></li>
                                                            @endif
                                                            @if($val->Product->rate > 3 && $val->Product->rate <= 4 && $val->Product->rate < 5)
                                                                <li><i class="fas fa-star"></i></li>
                                                                <li><i class="fas fa-star"></i></li>
                                                                <li><i class="fas fa-star"></i></li>
                                                                <li><i class="fas fa-star"></i></li>
                                                                <li><i class="fas fa-star color-none"></i></li>
                                                            @endif
                                                            @if($val->Product->rate > 4 && $val->Product->rate <= 5)
                                                                <li><i class="fas fa-star"></i></li>
                                                                <li><i class="fas fa-star"></i></li>
                                                                <li><i class="fas fa-star"></i></li>
                                                                <li><i class="fas fa-star"></i></li>
                                                                <li><i class="fas fa-star"></i></li>
                                                            @endif
                                                        </ul>
                                                        <span></span>
                                                    </div>
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="price">
                                                            @if(auth()->guard('dealer')->check())
                                                                <span class="new_price">{{ $val->Product->dealer_price }} EGP</span>
                                                            @else
                                                                <span class="new_price">{{ $val->Product->price_discount }} EGP</span>
                                                                <span class="old_price">{{ $val->Product->price }} EGP</span>
                                                            @endif

                                                        </div>
                                                        <!-- START:: BTNS ( ADD CART & FAV ) QUANTITY -->
                                                        <div class="btn_quantity_cart_fav d-flex align-items-center">
                                                            <div class="title_content m-0">
                                                                <span>{{ __('messages.Quantity') }} : </span>
                                                            </div>
                                                            <div class="btn_min_max">

                                                                <input type="number" id="count" readonly
                                                                       data-price="{{ $val->price }}"
                                                                       data-id="{{ $val->id }}" name="count"
                                                                       class="quantity{{$val->id}} form-control text-center"
                                                                       value="{{ $val->count }}"/>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- END:: SINGLE ITEM -->

                                </form>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-md-4">
                        <!-- START:: ORDER DETAILS -->
                        <div class="order_details">
                            <div class="title_page">
                                <h4> {{ __('messages.Order_Summary') }}</h4>
                            </div>
                            <div class="content_order_side">
                                <ul>
                                    <li>
                                        <span>{{ __('messages.Total') }}</span>
                                        <p class="toot">{{ isset($result) ? $result : ''}} جنيه </p>
                                    </li>
                                    <li>
                                        <span>{{ __('messages.Shipping') }}</span>
                                        {{$ord->shipping  ?: $setting->dilivary }} جنيه
                                    </li>
                                    <li>
                                        <span>{{ __('messages.Discount') }}</span>
                                        {{ isset($capp) ? $capp : ''}} جنيه
                                    </li>
                                </ul>
                                <h6>
                                    <span>  {{ __('messages.grand_total') }}</span>


                                    <p class="resc">{{ ($ord->total + $setting->dilivary) - $setting->tax_rate}}
                                        جنيه </p>
                                </h6>

                            </div>
                        </div>
                        <!-- END:: ORDER DETAILS -->
                    </div>
                </div>

            </div>
        </div>
        <!-- END:: CONTENT PAGE -->
    </main>

    <!-- START:: SECTION PRODUCTS -->
@endsection


@section('scripts')

    <script>

    </script>
@endsection