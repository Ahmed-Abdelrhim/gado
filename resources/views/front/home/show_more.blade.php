@extends('front.layout.app')
@section('style')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.11/vue.min.js"></script>

    <style>
        .range-slider {
            width: 100%;
            margin: auto;
            text-align: center;
            position: relative;
            height: 6em;
            display: flex;
            align-items: end;
            justify-content: space-between;
        }

        .range-slider input[type=range] {
            position: absolute;
            left: 0;
            top: 50%;
        }


        input[type=range] {
            -webkit-appearance: none;
            width: 100%;
        }

        input[type=range]:focus {
            outline: none;
        }


        input[type=range]::-webkit-slider-runnable-track {
            width: 100%;
            height: 5px;
            cursor: pointer;
            animate: 0.2s;
            background: #eee;
            border-radius: none;
            box-shadow: none;
            border: 0;
        }

        input[type=range]::-webkit-slider-thumb {
            z-index: 2;
            position: relative;
            box-shadow: none;
            border: none;
            height: 16px;
            width: 16px;
            border-radius: 25px;
            background: #007179;
            cursor: pointer;
            -webkit-appearance: none;
            margin-top: -5px;
        }

        .range-slider input[type=number] {
            font-family: var(--medium-font-ar);
            font-size: 1rem;
            margin-inline-end: 5px;
            border: 0;
            width: max-content;
        }

        .range-slider input[type=number] + span {
            font-family: var(--medium-font-ar);
            font-size: 1rem;
        }

        .range-slider input[type=range]::-moz-focus-outer {
            border: 0;
        }

        .range-slider input[type=range]::-webkit-slider-runnable-track {
            width: 100%;
            height: 6px;
            cursor: pointer;
            background-color: #EBEBEB;
        }

        .range-slider input[type=range]::-webkit-slider-thumb {
            width: 20px;
            height: 20px;
            margin-top: -8px;
            border: 3px solid var(--secondary-color);
            box-shadow: none;
            border-radius: 50%;
            background: #fff;
            cursor: pointer;
            -webkit-appearance: none;
            appearance: none;
        }

        .range-slider input[type=range]::-moz-range-track {
            width: 100%;
            height: 2px;
            cursor: pointer;
        }

        .range-slider input[type=range]::-moz-range-thumb {
            width: 46px;
            height: 46px;
            margin-top: -22px;
            border: 17px solid white;
            box-shadow: 0 0 0 1px black;
            border-radius: 50%;
            background: var(--secondary-color);
            cursor: pointer;
            -moz-appearance: none;
            appearance: none;
            box-sizing: border-box;
        }

        .range-slider input[type=range]::-ms-track {
            width: 100%;
            height: 2px;
            border-color: transparent;
            border-width: 2px 0;
            background: transparent;
            color: transparent;
            cursor: pointer;
            box-sizing: border-box;
        }

        .range-slider input[type=range]::-ms-fill-lower {
            background: #666;
            border-radius: 0;
            height: 6px;
            box-sizing: border-box;
        }

        .range-slider input[type=range]::-ms-fill-upper {
            background: red;
            border-radius: 0;
            height: 6px;
            box-sizing: border-box;
        }

        .range-slider input[type=range]::-ms-thumb {
            width: 44px;
            height: 44px;
            margin-top: 0;
            border: 17px solid white;
            box-shadow: 0 0 0 1px black;
            border-radius: 50%;
            background: var(--secondary-color);
            cursor: pointer;
            appearance: none;
            box-sizing: border-box;
        }


        .wishlist_icon img, .cart_icon img {
            filter: invert(67%) sepia(0%) saturate(8%) hue-rotate(162deg) brightness(87%) contrast(91%) !important;
        }

    </style>
@endsection

@section('content')

    @include('front.parts.header')
    <!-- START:: SLIDER HERO SECTION -->

    <!-- START:: INFO SITE SECTION -->



    <main>

        <div class="breadcrumbs">
            <div class="container">
                <h1> {{ __('messages.Products') }}</h1>
                <ul>
                    <li>
                        <a href="{{ url('/') }}">
                            <img src="{{asset('dist/front/assets/images/icons/home.svg')}}" alt="" height="" width=""/>
                            {{ __('messages.Home') }}
                        </a>
                    </li>
                    <li>/</li>
                    <li class="active"> {{ __('messages.Products') }}</li>
                </ul>
            </div>
        </div>
        <div class="container mt-5">
            <form class="row" id="addform" action="{{route('front_add_comment')}}" method="post"
                  enctype="multipart/form-data">
                {{csrf_field()}}
                <input type="hidden" name="count" value="{{$limit}}">
                <div class="col-md-3">
                    <button type="button" class="filter_icon btn-animation-2">
                        <i class="fas fa-filter"></i>
                        {{ __('messages.filtering') }}
                    </button>
                    <div class="sidebar_filter">
                        <div class="accordion" id="accordionBrands">

                            <!-- START:: SINGLE -->
                            <div class="accordion-item">
                                <div class="accordion-header" id="brands">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseBrands" aria-expanded="true"
                                            aria-controls="collapseBrands">
                                        {{ __('messages.sections') }}
                                    </button>
                                </div>
                                <div id="collapseBrands" class="accordion-collapse collapse show"
                                     aria-labelledby="brands" data-bs-parent="#accordionBrands">
                                    <div class="accordion-body">
                                        @if(count($catss) != 0)
                                            @foreach($catss as $keyyy => $vaa)
                                                <div class="form-check">
                                                    <div class="checkbox_container">
                                                        <input name="sections[]" class="form-check-input sections"
                                                               @if($id == $vaa->id) checked @endif type="checkbox"
                                                               value="{{ $vaa->id }}" id="brand-{{$keyyy}}">
                                                        <label class="form-check-label" for="brand-{{$keyyy}}">
                                                            {{ $vaa->name_ar }}
                                                        </label>
                                                    </div>
                                                    <span>( {{ count($vaa->ProductCategories) }})</span>
                                                </div>

                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- START:: SINGLE -->
                            <div class="accordion-item">
                                <div class="accordion-header" id="price">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapsePrice" aria-expanded="true"
                                            aria-controls="collapsePrice">
                                        {{ __('messages.price') }}
                                    </button>
                                </div>
                                <div id="collapsePrice" class="accordion-collapse collapse show" aria-labelledby="price"
                                     data-bs-parent="#accordionPrice">
                                    <div class="accordion-body">
                                        <div class="mt-3 mb-3">
                                            <div id="app">
                                                <div class='range-slider'>
                                                    <input type="range" min="0" max="100000" value="1" step="1"
                                                           v-model="sliderMin">
                                                    <input type="range" min="0" max="100000" value="100000" step="1"
                                                           v-model="sliderMax">
                                                    <div class="">
                                                        <input type="number" name="min" min="0" max="100000" step="1"
                                                               v-model="sliderMin">
                                                        <span>ج.م</span>
                                                    </div>
                                                    <div class="">
                                                        <input type="number" name="max" min="0" max="100000" step="1"
                                                               v-model="sliderMax">
                                                        <span>ج.م</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- START:: SINGLE -->
                            <div class="accordion-item">
                                <div class="accordion-header" id="rate">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapserate" aria-expanded="true"
                                            aria-controls="collapserate">
                                        {{ __('messages.rates') }}
                                    </button>
                                </div>
                                <div id="collapserate" class="accordion-collapse collapse show" aria-labelledby="rate"
                                     data-bs-parent="#accordionrate">
                                    <div class="accordion-body">

                                        <div class="form-check">
                                            <div class="checkbox_container">
                                                <input class="form-check-input" type="radio" name="rate" value="5.00"
                                                       id="rate-5">
                                                <label class="form-check-label label-rate" for="rate-5">
                                                    <ul>
                                                        <li><i class="fas fa-star"></i></li>
                                                        <li><i class="fas fa-star"></i></li>
                                                        <li><i class="fas fa-star"></i></li>
                                                        <li><i class="fas fa-star"></i></li>
                                                        <li><i class="fas fa-star"></i></li>
                                                    </ul>
                                                </label>
                                            </div>
                                            <span>(5)</span>
                                        </div>

                                        <div class="form-check">
                                            <div class="checkbox_container">
                                                <input class="form-check-input" type="radio" name="rate" value="4.00"
                                                       id="rate-4">
                                                <label class="form-check-label label-rate" for="rate-4">
                                                    <ul>
                                                        <li><i class="fas fa-star"></i></li>
                                                        <li><i class="fas fa-star"></i></li>
                                                        <li><i class="fas fa-star"></i></li>
                                                        <li><i class="fas fa-star"></i></li>
                                                        <li><i class="fas fa-star color-none"></i></li>
                                                    </ul>
                                                </label>
                                            </div>
                                            <span>(4)</span>
                                        </div>

                                        <div class="form-check">
                                            <div class="checkbox_container">
                                                <input class="form-check-input" type="radio" name="rate" value="3.00"
                                                       id="rate-3">
                                                <label class="form-check-label label-rate" for="rate-3">
                                                    <ul>
                                                        <li><i class="fas fa-star"></i></li>
                                                        <li><i class="fas fa-star"></i></li>
                                                        <li><i class="fas fa-star"></i></li>
                                                        <li><i class="fas fa-star color-none"></i></li>
                                                        <li><i class="fas fa-star color-none"></i></li>
                                                    </ul>
                                                </label>
                                            </div>
                                            <span>(3)</span>
                                        </div>

                                        <div class="form-check">
                                            <div class="checkbox_container">
                                                <input class="form-check-input" type="radio" name="rate" value="2.00"
                                                       id="rate-2">
                                                <label class="form-check-label label-rate" for="rate-2">
                                                    <ul>
                                                        <li><i class="fas fa-star"></i></li>
                                                        <li><i class="fas fa-star"></i></li>
                                                        <li><i class="fas fa-star color-none"></i></li>
                                                        <li><i class="fas fa-star color-none"></i></li>
                                                        <li><i class="fas fa-star color-none"></i></li>
                                                    </ul>
                                                </label>
                                            </div>
                                            <span>(2)</span>
                                        </div>

                                        <div class="form-check">
                                            <div class="checkbox_container">
                                                <input class="form-check-input" type="radio" name="rate" value="1.00"
                                                       id="rate-1">
                                                <label class="form-check-label label-rate" for="rate-1">
                                                    <ul>
                                                        <li><i class="fas fa-star"></i></li>
                                                        <li><i class="fas fa-star color-none"></i></li>
                                                        <li><i class="fas fa-star color-none"></i></li>
                                                        <li><i class="fas fa-star color-none"></i></li>
                                                        <li><i class="fas fa-star color-none"></i></li>
                                                    </ul>
                                                </label>
                                            </div>
                                            <span>(1)</span>
                                        </div>
                                        <button type="button" class="btn-animation-2 filter">
                                            {{ __('messages.Implementation') }}
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="overLay_filter"></div>
                </div>
                <div class="col-md-9">
                    <div class="filter_header">
                        <div class="title_filter">
                            <h3>
                                @if($kind == null)
                                    {{ __('messages.all') }}
                                @elseif($kind == '1')
                                    {{ __('messages.newly_added') }}
                                @elseif($kind == '2')
                                    {{ __('messages.best_seller') }}
                                @else
                                    {{$kind}}
                                @endif</h3>
                        </div>
                        @if($id != 'panner')
                            <div class="form_filter">
                                <div class="form-group">
                                    <label for="orderBy">{{ __('messages.Sort_by') }}: </label>
                                    <select class="form-select kind" id="orderBy">
                                        <option @if($kind == null) selected @endif>{{ __('messages.all') }}</option>
                                        <option value="1"
                                                @if($kind == '1') selected @endif> {{ __('messages.newly_added') }}</option>
                                        <option value="2"
                                                @if($kind == '2') selected @endif>  {{ __('messages.best_seller') }}</option>
                                    </select>
                                </div>


                            </div>
                        @endif
                    </div>
                    <!-- START:: SECTION PRODUCTS -->
                    <section class="products_section p-0">
                        <div class="row new__cards">
                            <!-- START:: SINGLE PRODUCT -->
                            @if(count($latest) != 0)
                                @foreach($latest as $vauu)
                                    <div class="col-md-4 wow animate fadeInUp">
                                        @include('front.parts.single_product',[$vauu])
                                    </div>
                                @endforeach
                            @endif


                            <div class="col-12 d-flex justify-content-center pt-4" class="li: { list-style: none; }">
                                @if (isset($latest) )

                                    {!! $latest->links() !!}

                                @endif
                            </div>

                        </div>


                </div>
            </form>

        </div>
    </main>

    <!-- START:: SECTION PRODUCTS -->
@endsection


@section('scripts')

    <script>
        var vm = new Vue({
            el: '#app',
            data: {
                minAngle: 1,
                maxAngle: 100000
            },
            computed: {
                sliderMin: {
                    get: function () {
                        var val = parseInt(this.minAngle);
                        return val;
                    },
                    set: function (val) {
                        val = parseInt(val);
                        if (val > this.maxAngle) {
                            this.maxAngle = val;
                        }
                        this.minAngle = val;
                    }
                },
                sliderMax: {
                    get: function () {
                        var val = parseInt(this.maxAngle);
                        return val;
                    },
                    set: function (val) {
                        val = parseInt(val);
                        if (val < this.minAngle) {
                            this.minAngle = val;
                        }
                        this.maxAngle = val;
                    }
                }
            }
        });


        $(document).on('click', '.ods', function () {
            
            var data = {
                id: $(this).data("id"),
                count: $('.count').val(),
                _token: $("input[name='_token']").val()
            }


            $.ajax(
                {
                    url: "{{route('front_add_order')}}",
                    type: 'post',
                    data: data,
                    success: function (s, result) {
                        $(".cart_num").html(s.datas);
                        $(".cart_tot").html(s.total + "جنيه");
                    }
                });

        });


        $(document).on('click', '.fav', function () {
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

                    }
                });

        });


        $(document).on('change', '.kind', function () {

            var link = "{{url()->current()}}" + "?kind=" + $(this).val()
            window.location.href = link

        });


        $(document).on('click', '.filter', function () {


            $.ajax({
                url: "{{ route('front_filter') }}",
                method: 'post',
                data: $('#addform').serialize(),
                success: function (s, result) {
                    $('.new__cards').html('')

                    $("input[name='count']").val(s.limit)
                    $.each(s.datas, function (k, v) {

                        $('.new__cards').append(`
            <div class="col-md-4 wow animate fadeInUp">
                    <div class="single_product">
                       
                            <!-- START:: WISHLIST BTN -->
                            <div class="wishlist_and_badge">
                            

                                @if(auth()->guard('customer')->check() || auth()->guard('dealer')->check())
                        <button type="button" data-id ="${v.id}" class="wishlist_btn  wish wishlist_btn_${v.id}" id="wishlist_btn_${v.id}">
                                </button>
                                @else

                        <a href="{{ route('front.login') }}" class="wishlist_btn" id="wishlist_btn_1"  style=""> <button type="button" class="wishlist_btn " id="wishlist_btn_1"  style="">
                                        </button> </a>
                                

                                @endif


                        <small class="red_badge">${Math.round((1 - (v.price_discount / v.price)) * 100)}%</small>
                            </div>
                            <!-- START:: IMAGE PRODUCT -->
                            <div class="image_product">
                            <a href="{{url('product-detial')}}/{{$div}}/${v.id}"> <img src="${v.card_image}" alt="" width="" height=""> </a>
                            </div>
                            <!-- START:: PRODUCT INFO -->
                            <div class="product_informations">
                    
                                <h5>${v.name_ar}</h5>
                              
                                <div class="price">
                                @if(auth()->guard('dealer')->check())
                        <span class="new_price">${v.dealer_price} EGP</span>
                                @else
                        <span class="new_price">${v.price_discount} EGP</span>
                                    <span class="old_price">${v.price} EGP</span>
                                @endif

                        </div>
                    </div>

                <div class="add_to_cart">
                    <form action="#">
@if(auth()->guard('customer')->check() || auth()->guard('dealer')->check())
                        <button type="button"  data-id="${v.id}"  class="btn-animation-2 adcart">
                                    <img src="{{asset('dist/front/assets/images/icons/cart-2.svg')}}" alt="" width="" height="">
                                    {{ __('messages.Add_to_cart') }}
                        </button>
@else

                        <a href="{{ route('front.login') }}" class="btn-animation-2">
                                    <img src="{{asset('dist/front/assets/images/icons/cart-2.svg')}}" alt="" width="" height="">
                                    {{ __('messages.Add_to_cart') }}
                        </a>
@endif

                        </form>
                    </div>
                </div>
                </div>
`);

                    });
                    if (s.datas.length > 0) {
                        $('.new__cards').append(`
                    <button type="button"  data-count="${s.limit}" data-id="${s.id}"  class="btn-animation-2 more__details">
                    {{ __('messages.show_more') }}
                        </button>
`);
                    }
                }
            });
        });


        $(document).on('click', '.more__details', function () {
            var $ele = $(this);
            var data = {
                count: $(this).data('count'),
                _token: $("input[name='_token']").val()
            }

            $.ajax({
                url: "{{ route('front_filter') }}",
                method: 'post',
                data: $('#addform').serialize(),
                success: function (s, result) {
                    console.log(s);
                    $ele.fadeOut().remove();
                    $("input[name='count']").val(s.limit)
                    $.each(s.datas, function (k, v) {

                        $('.new__cards').append(`
        <div class="col-md-4 wow animate fadeInUp">
                    <div class="single_product">
                       
                            <!-- START:: WISHLIST BTN -->
                            <div class="wishlist_and_badge">
                            @if(auth()->guard('customer')->check() || auth()->guard('dealer')->check())
                        <button type="button" data-id ="${v.id}" class="wishlist_btn  wish wishlist_btn_${v.id}" id="wishlist_btn_${v.id}">
                                </button>
                                @else

                        <a href="{{ route('front.login') }}" class="wishlist_btn" id="wishlist_btn_1"  style=""> <button type="button"  class="wishlist_btn " id="wishlist_btn_1"  style="">
                                        </button> </a>
                                

                                @endif

                        <small class="red_badge">${Math.round((1 - (v.price_discount / v.price)) * 100)}%</small>
                            </div>
                            <!-- START:: IMAGE PRODUCT -->
                            <div class="image_product">
                            <a href="{{url('product-detial')}}/{{$div}}/${v.id}"><img src="${v.card_image}" alt="" width="" height=""> </a>
                            </div>
                            <!-- START:: PRODUCT INFO -->
                            <div class="product_informations">
                    
                                <h5>${v.name_ar}</h5>
                              
                                <div class="price">
                                @if(auth()->guard('dealer')->check())
                        <span class="new_price">${v.dealer_price} EGP</span>
                                @else
                        <span class="new_price">${v.price_discount} EGP</span>
                                    <span class="old_price">${v.price} EGP</span>
                                @endif

                        </div>
                    </div>

                <div class="add_to_cart">
                    <form action="#">
@if(auth()->guard('customer')->check() || auth()->guard('dealer')->check())
                        <button type="button"  data-id="${v.id}"  class="btn-animation-2 adcart">
                                    <img src="{{asset('dist/front/assets/images/icons/cart-2.svg')}}" alt="" width="" height="">
                                      {{ __('messages.Add_to_cart') }}
                        </button>
@else

                        <a href="{{ route('front.login') }}" class="btn-animation-2">
                                    <img src="{{asset('dist/front/assets/images/icons/cart-2.svg')}}" alt="" width="" height="">
                                      {{ __('messages.Add_to_cart') }}
                        </a>
@endif

                        </form>
                    </div>
                </div>
                </div>
`);
                    })
                    if (s.datas.length > 0) {
                        $('.new__cards').append(`
                    <button type="button"  data-count="${s.limit}" data-id="${s.id}"  class="btn-animation-2 more__details">
                    {{ __('messages.show_more') }}
                        </button>
`);
                        document.documentElement.scrollTop
                    }

                }
            });
        })

    </script>
@endsection