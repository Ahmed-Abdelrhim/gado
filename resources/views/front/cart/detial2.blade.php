@extends('front.layout.app')
@section('style')
@endsection




@section('content')
    <!-- START:: INFO SITE SECTION -->
    <main>
        <!-- START:: BREADCRUMBS -->
        <div class="breadcrumbs">
            <div class="container">
            <h1>{{ __('messages.Complete_request_2') }}</h1>
                <ul>
                    <li>
                        <a href="{{ url('/') }}">
                            <img src="{{asset('dist/front/assets/images/icons/home.svg')}}" alt="" height="" width="" />
                            {{ __('messages.Home') }}
                        </a>
                    </li>
                    <li>/</li>
                    <li class="active">{{ __('messages.Complete_request_2') }}</li>
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
                                <h4> {{ __('messages.Order_details') }}</h4>
                            </div>
                            <form class="form-group-custom row" action="{{route('front_finish_store_info')}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
							<input type="hidden" name="id" value="{{$order->id}}">
                                <div class="col-md-12">
                                    <label class="form-check">
                                        <input class="form-check-input payk" value="2" type="radio" name="type">
                                        <img src="{{asset('dist/front/assets/images/icons/cards.svg')}}" width="" height="" />
                                        <div class="text_check">
                                            <p> {{ __('messages.credit_card') }}</p>
                                            <span>{{ __('messages.credit_card_desc') }}</span>
                                        </div>
                                    </label>

                                </div>

                                <div class="col-md-12">
                                    <label class="form-check">
                                        <input class="form-check-input" value="1" type="radio" name="type">
                                        <img src="{{asset('dist/front/assets/images/icons/money.svg')}}" width="" height="" />
                                        <div class="text_check">
                                            <p>{{ __('messages.Cash_on_Delivery') }}</p>
                                            <span>{{ __('messages.Cash_on_Delivery_desc') }}</span>
                                        </div>
                                    </label>
                                </div>


                                <div class="col-md-12">
                                    <button type="submit" class="btn-animation-2 bttttt">
                                    {{ __('messages.send_order') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="product_details_section content_page_shop p-0">
                            <div class="title_page">
                                <h4> {{ __('messages.Order_details') }}</h4>
                            </div>
                            @foreach($order->Carts as $val)
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

                                                <h4><a href="#">{{ $val->Product->name_ar }}</a>
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

                                                            <input type="number" id="count" readonly  data-price="{{ $val->price }}" data-id="{{ $val->id }}" name="count" class="quantity{{$val->id}} form-control text-center" value="{{ $val->count }}" />

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
                                        <p class="toot">{{ $order->total }} @lang('messages.currency') </p>
                                    </li>
                                    <li>
                                        <span>{{ __('messages.Shipping') }}</span>
                                        {{ \App\Governorate::find($order->Order_info()->first()->governorate_id)->shipping_fee}} @lang('messages.currency')

                                    </li>
                                    <li >
                                        <span>{{ __('messages.Discount') }}  </span>
                                        <span class="rattt">  </span>
                                    </li>
                                    <li>
                                    <span>الكبون</span>
                                    <p class="coop"></p>

                                    <input style="width: 50%; margin-right: 20px; " type="text" name="copon" class="form-control" id="copon"
                                        placeholder="برجاء ادخال الكبون ">
                                        <button style="width: 20%; margin-right: 0;height: 40px; "  data-id="{{$order->id}}" type="submit" class="btn-animation-2 copon">
                                        <i class="fas fa-check"></i>  </button>


                                    </li>
                                    <span class="brf"></span>
                                    <span class="capp"></span>
                                    <li>

                                    <p class="coop"></p>

                                    </li>
                                </ul>
                                <h6>
                                    <span> {{ __('messages.grand_total') }}</span>
                                    <p class="resc">{{ ($order->total + ( \App\Governorate::find($order->Order_info()->first()->governorate_id)->shipping_fee)) - $setting->tax_rate}}  @lang('messages.currency') </p>

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
      $(document).on('click','.payk', function(){
        window.location.href="{{url('create-checkout-session?id='. $order->id)}}";

        $('.bttttt').fadeOut().remove();
	});

    $(document).on('click','.copon', function(){
        var $ele = $(this).parent();
        var data = {
            id : $(this).data("id"),
            copon : $("input[name='copon']").val(),

		    _token     : $("input[name='_token']").val()
	    }


		$.ajax(
		{
			url: "{{route('front_copon_cart')}}",
			type: 'post',
			data: data,
			success: function (s,result){
                console.log(s.copons)
                // $ele.fadeOut().remove();
                $(".brf").html(' ');
                $(".brf").html(s.copons );
                $(".rattt").html(s.capp);

                $(".resc").html(s.total + "{{ trans('messages.currency') }}");
			}
		});

	});

    $(document).on('click','.del', function(){
        var $ele = $(this).parent();
        var data = {
            id : $(this).data("id"),

		    _token     : $("input[name='_token']").val()
	    }


		$.ajax(
		{
			url: "{{route('front_delete_cart')}}",
			type: 'post',
			data: data,
			success: function (s,result){
                $ele.fadeOut().remove();
                $(".toot").html(s.datas + "{{ trans('messages.currency') }}");
                $(".resc").html(s.total + "{{ trans('messages.currency') }}");
			}
		});

	});

    @foreach($order->Carts as $cart)
            $(".quantity{{$cart->id}}").change(updateCart);
    @endforeach

        function updateCart(){
        var $ele = $(this).parent();
        var data = {
            id : $(this).data("id"),
            count : $(this).val(),

		    _token     : $("input[name='_token']").val()
	    }


		$.ajax(
		{
			url: "{{route('front_count_cart')}}",
			type: 'post',
			data: data,
			success: function (s,result){
                $(".toot").html(s.datas + "{{ trans('messages.currency') }}");
                $(".resc").html(s.total + "{{ trans('messages.currency') }}");
			}
		});

	};


</script>
@endsection