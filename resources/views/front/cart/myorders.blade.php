@extends('front.layout.app')

@section('content')

@include('front.parts.header')
    <!-- START:: SLIDER HERO SECTION -->
   
    <!-- START:: INFO SITE SECTION -->
    

    
    <main>

    <div class="breadcrumbs">
            <div class="container">
                <h1>{{ __('messages.Profile') }}</h1>
                <ul>
                    <li>
                    <a href="{{ url('/') }}">
                            <img src="{{asset('dist/front/assets/images/icons/home.svg')}}" alt="" height="" width="" />
                            {{ __('messages.Home') }}
                        </a>
                    </li>
                    <li>/</li>
                    <li><a href="{{ auth()->guard('customer')->check() ? route('customer.profile') : route('dealer.profile') }}">الملف الشخصى</a> </li>
                    <li>/</li>
                    <li class="active">{{ __('messages.My_Orders') }}</li>
                </ul>
            </div>
        </div>
        <div class="content_single_page">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-3">
                        <div class="profile_list">
                            <ul>
                                <li>
                                    <a href="{{ auth()->guard('customer')->check() ? route('customer.profile') : route('dealer.profile') }}">
                                        <img src="{{asset('dist/front/assets/images/icons/setting.svg')}}" alt="" width="" height="" />
                                        {{ __('messages.Profile') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="active" href="{{ route('front_my_orders',['div'=>$div]) }}">
                                        <img src="{{asset('dist/front/assets/images/icons/cart_p.svg')}}" alt="" width="" height="" />
                                        {{ __('messages.My_Orders') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ auth()->guard('customer')->check() ? route('customer.logout') : route('dealer.logout') }}">
                                        <img src="{{asset('dist/front/assets/images/icons/logout.svg')}}" alt="" width="" height="" />
                                        {{ __('messages.log_out') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="product_details_section content_page_shop   mb-3 p-0">
                            <div class="title_page">
                                <h4> {{ __('messages.all_orders') }}</h4>
                            </div>
                            @if(count($orders) > 0)
                                @foreach($orders as $val)
                                    <!-- START:: SINGLE ITEM -->
                                    <div class="single_item_shop single_item_shop_other">
                                        <div class="itemFlex">
                                            <div class="image_item">
                                                <a href="{{route('front_order_detial',['div'=>$div,'id'=>$val])}}">
                                                    <img src="{{ isset($val->OrderProducts[0]) ? $val->OrderProducts[0]->Product->card_image : '' }}" alt="" width="" height="">
                                                </a>
                                            </div>
                                            <div class="content_item">
                                                <!-- START:: HEAD  -->
                                                <div class="head_details">
                                                    <h5>           <small>{{Date::parse($val->created_at)->format('Y-m-d')}}</small></h5>
                             
                                                
                                                    <a href="{{route('front_order_detial',['div'=>$div,'id'=>$val])}}"><h4 class="span">  {{ __('messages.delivery_number') }} : <span># {{ $val->id }}</span></h5></a>
                                                </div>
                                                <!-- START:: STATUS -->
                                                <div class="status_part">
                                                    <p>
                                                        <img src="{{asset('dist/front/assets/images/icons/status.svg')}}" width="" height="" alt="">
                                                        {{ __('messages.status') }} :
                                                        @if($val->status == 1)
                                                        <span class="orange">{{ __('messages.Complete_the_order') }}</span>
                                                        @endif
                                                        @if($val->status == 2)
                                                        <span class="orange"> {{ __('messages.Processing') }}</span>
                                                        @endif
                                                        @if($val->status == 3)
                                                        <span class="orange">  {{ __('messages.on_way') }}</span>
                                                        @endif
                                                        @if($val->status == 4)
                                                        <span class="orange">  {{ __('messages.received') }}</span>
                                                        @endif
                                                    </p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- END:: SINGLE ITEM -->
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- START:: SECTION PRODUCTS -->
@endsection


@section('scripts')
    

@endsection