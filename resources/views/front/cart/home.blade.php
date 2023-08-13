@extends('front.layout.app')

@section('style')
    <style>
        * {
            box-sizing: border-box;
        }

        .input-number {
            width: 80px;
            padding: 0 12px;
            vertical-align: top;
            text-align: center;
            outline: none;
        }

        .input-number,
        .input-number-decrement,
        .input-number-increment {
            border: 1px solid #ccc;
            height: 50px;
            user-select: none;
        }

        .input-number-decrement,
        .input-number-increment {
            display: inline-block;
            width: 30px;
            line-height: 38px;
            background: #f1f1f1;
            color: #444;
            text-align: center;
            font-weight: bold;
            cursor: pointer;
        }

        .input-number-decrement:active,
        .input-number-increment:active {
            background: #ddd;
        }

        .input-number-decrement {
            border-right: none;
            border-radius: 4px 0 0 4px;
        }

        .input-number-increment {
            border-left: none;
            border-radius: 0 4px 4px 0;
        }

        .p-error-msg {
            color: #F44336;
            font-size: 14px;
        }
    </style>
@endsection

@section('content')

    @include('front.parts.header')



    <!-- START:: SLIDER HERO SECTION -->

    <!-- START:: INFO SITE SECTION -->



    <main>
        <!-- START:: BREADCRUMBS -->
        <div class="breadcrumbs">
            <div class="container">
                <h1>{{ __('messages.shopping_cart') }}</h1>
                <ul>
                    <li>
                        <a href="{{ url('/') }}">
                            <img src="{{asset('dist/front/assets/images/icons/home.svg')}}" alt="" height="" width=""/>
                            {{ __('messages.Home') }}
                        </a>
                    </li>
                    <li>/</li>
                    <li class="active">{{ __('messages.shopping_cart') }}</li>
                </ul>
            </div>
        </div>
        <!-- END:: BREADCRUMBS -->

        <!-- START:: CONTENT PAGE -->
        <div class="content_single_page">
            <div class="container mt-5">
                <div class="row">
                    @if( Session::has( 'msg' ))
                        <div class="alert alert-danger">
                            {{ Session::get( 'msg' ) }}
                        </div>
                    @endif
                    <div class="col-md-8">
                        <div class="product_details_section content_page_shop p-0">
                            <div class="title_page">
                                <h4>{{ __('messages.shopping_cart') }}</h4>
                            </div>

                            @if($order)
                                @foreach($order->Carts as $val)
                                    <form action="#">
                                        <!-- START:: SINGLE ITEM -->
                                        <div class="single_item_shop">
                                            <button type="button" data-id="{{$val->id}}" class="del"><img
                                                        src="{{asset('dist/front/assets/images/icons/trash.png')}}"
                                                        width="" height="" alt=""></button>
                                            <div class="itemFlex">
                                                <div class="image_item">
                                                    <img src="{{ $val->Product->card_image }}" alt="" width=""
                                                         height="">
                                                </div>
                                                <div class="content_item">
                                                    <!-- START:: HEAD  -->
                                                    <div class="head_details">
                                                        <span style="color:red;font-size: 13px;"> متوفر : {{$val->Product->stock}} قطع  </span>
                                                        <h4><a href="#"> @if(session()->get('locale') == "en")
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
                                                                    <span class="input-number-decrement quantity"
                                                                          data-id="{{ $val->id }}">–</span>
                                                                    <input type="number" id="count"
                                                                           data-price="{{ $val->price }}"
                                                                           data-id="{{ $val->id }}" name="count"
                                                                           class="quantity{{ $val->id }} form-control text-center input-number"
                                                                           value="{{ $val->count }}" min="1" step="1"/>
                                                                    <span class="input-number-increment quantity"
                                                                          data-id="{{ $val->id }}">+</span>
                                                                </div>
                                                            </div>


                                                        </div>
                                                        <p id="error-quantity-not-found{{ $val->id }}"
                                                           class="p-error-msg"></p>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- END:: SINGLE ITEM -->

                                    </form>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    @if($order)
                        <div class="col-md-4">
                            <!-- START:: ORDER DETAILS -->
                            <div class="order_details">
                                <div class="title_page">
                                    <h4>{{ __('messages.Order_Summary') }}</h4>
                                </div>
                                <div class="content_order_side">
                                    <ul>
                                        <li>
                                            <span>{{ __('messages.Total') }}</span>
                                            <p class="toot">{{ $order->total }}  @lang('messages.currency')</p>
                                        </li>
                                        <!--<li>-->
                                        <!--    <span>{{ __('messages.Shipping') }}</span>-->
                                        <!--    {{ $setting->dilivary }} جنيه-->
                                        <!--</li>-->

                                        <li>
                                            <span>{{ __('messages.Discount') }}  </span>
                                            <span class="rattt">  </span>
                                        </li>
                                    </ul>
                                    <h6>
                                        <span>  {{ __('messages.grand_total') }}</span>
                                        <!--<p class="resc">{{ ($order->total + $setting->dilivary) - $setting->tax_rate}} جنيه </p>-->
                                        <p class="resc">{{ $order->total  - $setting->tax_rate}} @lang('messages.currency') </p>

                                    </h6>
                                    @if(auth()->guard('customer')->check() || auth()->guard('dealer')->check())
                                        <a href="{{route('front_order_info',['div'=>$div,'id'=>$order])}}"
                                           class="btn-animation-2 mt-3">
                                            {{ __('messages.Checkout') }}
                                        </a>
                                    @else
                                        <a href="{{route('front.login')}}" class="btn-animation-2 mt-3">
                                            {{ __('messages.Checkout') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <!-- END:: ORDER DETAILS -->
                        </div>
                    @endif
                </div>

            </div>
        </div>
        <!-- END:: CONTENT PAGE -->
    </main>

    <!-- START:: SECTION PRODUCTS -->
@endsection


@section('scripts')

    <script>
        $(document).on('click', '.del', function () {
            var $ele = $(this).parent();
            var data = {
                id: $(this).data("id"),

                _token: $("input[name='_token']").val()
            }


            $.ajax(
                {
                    url: "{{route('front_delete_cart')}}",
                    type: 'post',
                    data: data,
                    success: function (s, result) {
                        $ele.fadeOut().remove();
                        $(".toot").html(s.datas + "جنيه");
                        $(".resc").html(s.total + "جنيه");
                        $(".cart_tot").html(s.total + "جنيه");
                        $(".cart_num").html(s.cat_count);


                        if (s.datas == '0') {
                            window.location.href = "{{ url('/') }}";
                        }
                    }
                });

        });
        @if($order)
        @foreach($order->Carts as $cart)
        //  $(".quantity").click(updateCart);
        @endforeach
        function updateCart() {

            var $ele = $(".quantity{{$cart->id}}").parent();

            var data = {
                id: $(".quantity{{$cart->id}}").data("id"),
                count: $(".quantity{{$cart->id}}").val(),

                _token: $("input[name='_token']").val()
            }

            console.log(data);
            $.ajax(
                {
                    url: "{{route('front_count_cart')}}",
                    type: 'post',
                    data: data,
                    success: function (s, result) {
                        $(".toot").html(s.datas + "جنيه");
                        $(".resc").html(s.total + "جنيه");
                        $(".cart_tot").html(s.total + "جنيه");
                        $(".cart_num").html(s.cat_count);
                        if (s.datas == '0') {
                            window.location.href = "{{ url('/') }}";
                        }
                    }
                });

        };
        @endif



        //qty
        (function () {

            window.inputNumber = function (el) {

                var min = el.attr('min') || false;
                var max = el.attr('max') || false;


                var els = {};

                els.dec = el.prev();
                els.inc = el.next();

                el.each(function () {
                    init($(this));
                });

                function init(el) {

                    $('.input-number-decrement').on('click', decrement);
                    $('.input-number-increment').on('click', increment);

                    function decrement() {
                        //  var value = el[0].value;
                        var id = $(this).data("id");
                        var value = $(".quantity" + id).val();

                        --value;
                        // if(!min || value >= min) {
                        //   $(".quantity"+id).val(-- value)
                        // }

                        var data = {
                            id: id,
                            count: value,

                            _token: $("input[name='_token']").val()
                        }


                        $.ajax(
                            {
                                url: "{{route('front_count_cart')}}",
                                type: 'post',
                                data: data,
                                success: function (s, result) {
                                    $(".toot").html(s.datas + "جنيه");
                                    $(".resc").html(s.total + "جنيه");
                                    $(".cart_tot").html(s.total + "جنيه");
                                    $(".cart_num").html(s.cat_count);
                                    $(".quantity" + id).val(value);
                                    if (s.datas == '0') {
                                        {{--  @php $url = \Illuminate\Support\Facades\Request::url(); @endphp   --}}
                                        {{--if ({{ $url }} === 'cart-home/1') {--}}
                                        {{--    window.location.href = "{{ url('/home/1') }}";--}}
                                        {{--}--}}
                                        window.location.href = "{{  url('/')}}";
                                    }
                                }
                            });
                    }

                    function increment() {
                        // var value = el[0].value;
                        // ++value;
                        // if(!max || value <= max) {
                        //   el[0].value = value;
                        // }
                        var id = $(this).data("id");
                        var value = $(".quantity" + id).val();

                        ++value;
                        var data = {
                            //         id : $(".input-number").data("id"),
                            //         count : $(".input-number").val(),

                            //  _token     : $("input[name='_token']").val()
                            id: id,
                            count: value,

                            _token: $("input[name='_token']").val()
                        }


                        $.ajax(
                            {
                                url: "{{route('front_count_cart')}}",
                                type: 'post',
                                data: data,
                                success: function (s, result) {
                                    if (!s.error) {
                                        $(".toot").html(s.datas + "جنيه");
                                        $(".resc").html(s.total + "جنيه");
                                        $(".cart_tot").html(s.total + "جنيه");
                                        $(".cart_num").html(s.cat_count);

                                        $(".quantity" + id).val(value);
                                        if (s.datas == '0') {
                                            window.location.href = "{{ url('/') }}";
                                        }
                                    } else {

                                        var count = s.count;
                                        $("#error-quantity-not-found" + id).text("العدد المتوفر لهذا المنتج فقط " + count + " قطعة");
                                    }

                                }
                            });
                    }
                }
            }
        })();

        inputNumber($('.input-number'));

    </script>
@endsection