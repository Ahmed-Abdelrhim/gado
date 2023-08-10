@extends('front.layout.app')


@section('style')

<style type="text/css">
.content_single_page .active {
  border-color: #28a745 !important;
  background-color: #f2f2f2;
  box-shadow: 0 3px 6px rgba(0, 0, 0, 0.18), 0 3px 6px rgba(0, 0, 0, 0.23);
}

.card {
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15), 0 2px 5px rgba(0, 0, 0, 0.2);
  -webkit-transition: all 0.5s ease;
  -moz-transition: all 0.5s ease;
  -o-transition: all 0.5s ease;
  transition: all 0.5s ease;
}

</style>
@endsection

@section('content')


    <!-- START:: INFO SITE SECTION -->



    <main>
        <!-- START:: BREADCRUMBS -->
        <div class="breadcrumbs">
            <div class="container">
            <h1>{{ __('messages.Complete_the_order') }}</h1>
                <ul>
                    <li>
                        <a href="{{ url('/') }}">
                            <img src="{{asset('dist/front/assets/images/icons/home.svg')}}" alt="" height="" width="" />
                            {{ __('messages.Home') }}
                        </a>
                    </li>
                    <li>/</li>
                    <li class="active">{{ __('messages.Complete_the_order') }}</li>
                </ul>
            </div>
        </div>
        <!-- END:: BREADCRUMBS -->

        <!-- START:: CONTENT PAGE -->
        <div class="content_single_page">
            <div class="container mt-5">
                <div class="row">

                    <div class="col-md-8">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                            {{-- أدخل بيانات جديدة --}}
                            <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">{{ __('messages.enter_data') }}</button>

                            </li>
                            {{-- إختار من بياناتك القديمة --}}
                            <li class="nav-item" role="presentation">

                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">{{ __('messages.enter_data_old') }}</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="myTabContent">

                            <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                                <div class="content_page_shop mb-3 p-0">
                                    <div class="title_page">
                                        <h4>{{ __('messages.Order_details') }}</h4>
                                    </div>
                                    <form class="form-group-custom row" action="{{route('front_store_info')}}" method="post" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <input type="hidden" name="id" value="{{$order->id}}">
                                    <input type="hidden" name="inf_id" value="">
                                        <div class="col-md-6 mb-3">
                                            <label for="name_first" class="form-label">{{ __('messages.First_Name') }}<span>*</span></label>
                                            <input type="text" required name="name_first"  value="" class="form-control" id="name_first"
                                                placeholder="{{ __('messages.First_Name') }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="name_last"  class="form-label"> {{ __('messages.last_Name') }} <span>*</span></label>
                                            <input type="text" required name="name_last" value="" class="form-control" id="name_last"
                                                placeholder="{{ __('messages.last_Name') }}">
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="address"  class="form-label"> {{ __('messages.address') }} <span>*</span></label>
                                            <input type="text" value="" required name="address" class="form-control" id="address"
                                                placeholder=" {{ __('messages.address') }}">

                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="email_code" class="form-label"> {{ __('messages.Postal_code') }}</label>
                                            <input type="text"  name="email_code" value="" class="form-control" id="email_code"
                                                placeholder=" {{ __('messages.Postal_code') }}">
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="phone" class="form-label"> {{ __('messages.Mobile_number') }} <span>*</span></label>
                                            <input type="tel" required name="phone"  value="" class="form-control" id="phone" minlength="11" maxlength="11"
                                                placeholder="{{ __('messages.Mobile_number') }}">
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="email" class="form-label"> {{ __('messages.email') }} </label>
                                            <input type="email"  name="email"   value="" class="form-control" id="email" value=""
                                                placeholder="{{ __('messages.email') }}">
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label for="desc" class="form-label"> {{ __('messages.other_info') }}</label>
                                            <textarea class="form-control" name="desc" id="desc" rows="5"
                                                placeholder="{{ __('messages.other_info') }}"></textarea>
                                        </div>
                                          <div class="col-md-12 mb-3">
                                            <label for="desc" class="form-label"> المحافظه <span>*</span></label>
                                            <select name="governorate_id" class="form-control" id="governorate" required="true">
                                                <option value="">اختر </option>
                                                @foreach($governorates as $governorate)
                                                <option value="{{$governorate->id}}" data-shipping="{{$governorate->shipping_fee}}">{{$governorate->name_ar}} </option>
                                                @endforeach

                                            </select>

                                        </div>
                                        <div class="col-md-12">
                                            <button class="btn-animation-2"  type="submit">


                                          {{ __('messages.Confirm_data') }}
                                            </button>
                                        </div>

                                    </form>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                                <div class="content_page_shop mb-3 p-0">
                                    <div class="row mt-2">
                                        <div class="col-12">
                                        <form class="form-group-custom row" action="{{route('front_store_info')}}" method="post" enctype="multipart/form-data">
                                            {{csrf_field()}}
                                            <input type="hidden" name="ord_id" value="{{$order->id}}">
                                            <div class="form-group row">
                                                <div class="col-12">
                                                    <div class="card-deck">
                                                        @if(isset($infords))
                                                            @foreach($infords as $inv)
                                                                <div id="{{$inv->id}}-card" class="card mb-4">
                                                                    <div class="card-body" role="button">
                                                                    <h5 class="card-title"><input id="{{$inv->id}}" name="adddd" value ="{{$inv->id}}" type="radio" checked=""> <label for="{{$inv->id}}">{{$inv->name_first}} - {{$inv->name_last}}</label></h5>
                                                                    <p class="card-text">{{ __('messages.address') }} : {{$inv->address}}</p>
                                                                        <p class="card-text">{{ __('messages.Postal_code') }} : {{$inv->email_code}}</p>
                                                                        <p class="card-text">{{ __('messages.Mobile_number') }} : {{$inv->phone}}</p>
                                                                        <p class="card-text">{{ __('messages.email') }} : {{$inv->email}}</p>
                                                                        <p class="card-text">{{ __('messages.other_info') }} : {{$inv->desc}}</p>
                                                                        <p class="card-text">المحافظه : {{$inv->governorate_id}}</p>
                                                                        <button type="button"
                                                                        class="btn btn-info btn-sm edit"

                                                                        data-id    = "{{$inv->id}}"
                                                                        data-name_first= "{{$inv->name_first}}"
                                                                        data-name_last = "{{$inv->name_last}}"
                                                                        data-address   = "{{$inv->address}}"
                                                                        data-email_code= "{{$inv->email_code}}"
                                                                        data-phone     = "{{$inv->phone}}"
                                                                        data-email     = "{{$inv->email}}"
                                                                        data-desc      = "{{$inv->desc}}"
                                                                         data-governorate_id      = "{{$inv->governorate_id}}"
                                                                        data-bs-toggle="modal" data-bs-target="#exampleModal">   <i class="fas fa-edit"></i></button>
                                                                        <button type="button" data-id = "{{$inv->id}}" class="btn btn-danger btn-sm delet"> <i class="fas fa-trash"></i></button>
                                                                    </div>
                                                                </div>

                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                 @if(!empty($infords) && count($infords) != 0)
                                                <button class="btn-animation-2"  type="submit">

                                                {{ __('messages.Confirm_data') }}
                                                </button>
                                                @else
                                                 <p class="btn-animation-2"  >
                                                    لا يوجد بيانات
                                                <!--{{ __('messages.Confirm_data') }}-->
                                                </p>
                                                @endif
                                            </div>
                                        </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- edit area modal --}}
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h4 class="modal-title">تعديل بيانات : <span class="item_name"></span></h4>


                                </div>
                                <div class="modal-body">
                                <form class="form-group-custom row" action="{{route('front_store_info')}}" method="post" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <input type="hidden" name="ord_id" value="{{$order->id}}">
                                    <input type="hidden" name="inf_id">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12">
                                                    <label for="name_first" class="form-label"  style="margin-top: 10px">{{ __('messages.First_Name') }}<span>*</span></label>
                                                    <input type="text" required name="name_first"  class="form-control" id="name_first"
                                                        placeholder="{{ __('messages.First_Name') }}">
                                                </div>
                                                <div class="col-sm-12">
                                                    <label for="name_last"  class="form-label"  style="margin-top: 10px"> {{ __('messages.last_Name') }} <span>*</span></label>
                                                    <input type="text" required name="name_last" class="form-control" id="name_last"
                                                        placeholder="{{ __('messages.last_Name') }}">
                                                </div>
                                                <div class="col-sm-12">
                                                    <label for="address"  class="form-label"  style="margin-top: 10px"> {{ __('messages.address') }} <span>*</span></label>
                                                    <input type="text" required name="address" class="form-control" id="address"
                                                        placeholder=" {{ __('messages.address') }}">

                                                </div>
                                                <div class="col-sm-12">
                                                    <label for="email_code" class="form-label"  style="margin-top: 10px"> {{ __('messages.Postal_code') }} <span>*</span></label>
                                                    <input type="text" required name="email_code" class="form-control" id="email_code"
                                                        placeholder=" {{ __('messages.Postal_code') }}">
                                                </div>
                                                <div class="col-sm-12">
                                                    <label for="phone" class="form-label"  style="margin-top: 10px"> {{ __('messages.Mobile_number') }} <span>*</span></label>
                                                    <input type="tel" required name="phone"  class="form-control" id="phone"
                                                        placeholder="{{ __('messages.Mobile_number') }}">
                                                </div>
                                                <div class="col-sm-12">
                                                    <label for="email" class="form-label"  style="margin-top: 10px"> {{ __('messages.email') }} <span>*</span></label>
                                                    <input type="email" required name="email"   class="form-control" id="email" value=""
                                                        placeholder="{{ __('messages.email') }}">
                                                </div>
                                                <div class="col-sm-12">
                                                    <label for="desc" class="form-label"  style="margin-top: 10px"> {{ __('messages.other_info') }}</label>
                                                    <textarea class="form-control" name="desc" id="desc" rows="5"
                                                        placeholder="{{ __('messages.other_info') }}"></textarea>
                                                </div>
                                                <div  class="col-sm-12">
                                                    <label for="desc" class="form-label"> المحافظه <span>*</span></label>
                                                    <select name="governorate_id" class="form-control" id="governorate" required="true">
                                                        <option value="">اختر </option>
                                                        @foreach($governorates as $governorate)
                                                        <option value="{{$governorate->id}}" data-shipping="{{$governorate->shipping_fee}}">{{$governorate->name_ar}} </option>
                                                        @endforeach

                                                    </select>

                                                </div>

                                            </div>
                                        </div>

                                        <button type="submit" id="update" style="display: none;"></button>
                                </form>
                                </div>
                                <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-outline-light update" style="background : #b2dcee;">تحديث</button>
                                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal" style="background : #b2dcee;">إغلاق</button>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="product_details_section content_page_shop p-0">
                            <div class="title_page">
                                <h4> {{ __('messages.Order_details') }}</h4>
                            </div>
                            @foreach($order->Carts as $val)
                            <form action="#">
                                <!-- START:: SINGLE ITEM -->
                                <div class="single_item_shop">
                                    <button type="button"  data-id="{{$val->id}}"  class="del"><img src="{{asset('dist/front/assets/images/icons/trash.png')}}"
                                            width="" height="" alt=""></button>
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

                                                            <input type="number" id="count"  data-price="{{ $val->price }}" data-id="{{ $val->id }}" name="count" class="quantity{{$val->id}} form-control text-center" value="{{ $val->count }}" />

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
                                <h4>{{ __('messages.Order_Summary') }}</h4>
                            </div>
                            <div class="content_order_side">
                                <ul>
                                    <li>
                                        <span>{{ __('messages.Total') }}</span>
                                        <p class="toot">{{ $order->total }} @lang('messages.currency') </p>
                                    </li>
                                    <li>
                                        <span>{{ __('messages.Shipping') }}</span>
                                       <p class="ship"> -- @lang('messages.currency')

                                    </p>
                                        <input type="hidden" name="shippingValue" />
                                    </li>
                                    <li>
                                    <span>{{ __('messages.Discount') }}  </span>
                                        <span class="rattt">  </span>
                                    </li>
                                </ul>
                                <h6>
                                    <span> {{ __('messages.grand_total') }}</span>
                                    <p class="resc">
                                        {{ $order->total - $setting->tax_rate}} @lang('messages.currency')
                                    </p>
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


$('.save').on('click',function(){
        $('#submit').click();
    })




    //edit section
    $('.edit').on('click',function(){
        var inf_id        = $(this).data('id')
        var name_first    = $(this).data('name_first')
        var name_last     = $(this).data('name_last')
        var address       = $(this).data('address')
        var email_code    = $(this).data('email_code')
        var phone         = $(this).data('phone')
        var email         = $(this).data('email')
        var desc          = $(this).data('desc')


        $("input[name='inf_id']").val(inf_id)
        $("input[name='name_first']").val(name_first)
        $("input[name='name_last']").val(name_last)
        $("input[name='address']").val(address)
        $("input[name='email_code']").val(email_code)
        $("input[name='phone']").val(phone)
        $("input[name='email']").val(email)
        $("textarea[name='desc']").html(desc)




    });

    // update section
    $('.update').on('click',function(){
        $('#update').click();
    })

$(document).ready(function () {

    //change shipping

    $('#governorate').on('change', function() {
        var shipping = $(this).find(':selected').data('shipping');
        var order_total = "{{$order->total}}";
        var tax = "{{$setting->tax_rate}}";
        $('.ship').text(shipping+ "{{ trans('messages.currency') }}");
        $("input[name=shippingValue]").val(shipping);
        $('.resc').text(parseInt(order_total) + parseInt(shipping) - parseInt(tax) + "{{ trans('messages.currency') }}");

    });
    $('input:radio').change(function () {//Clicking input radio
        var radioClicked = $(this).attr('id');
        unclickRadio();
        removeActive();
        clickRadio(radioClicked);
        makeActive(radioClicked);
    });
    $(".card").click(function () {//Clicking the card
        var inputElement = $(this).find('input[type=radio]').attr('id');
        unclickRadio();
        removeActive();
        makeActive(inputElement);
        clickRadio(inputElement);
    });
});


function unclickRadio() {
    $("input:radio").prop("checked", false);
}

function clickRadio(inputElement) {
    $("#" + inputElement).prop("checked", true);
}

function removeActive() {
    $(".card").removeClass("active");
}

function makeActive(element) {
    $("#" + element + "-card").addClass("active");
}

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

    $(".infos").change(function(){

            $("input[name='address']").val($(this).val());
        });


    $(".delet").click(function(){
    var id = $(this).data("id");
    var $ele = $(this).parent().parent();
    $.ajax(
    {
        url: "{{route('front_Delete_inforders')}}",
        type: 'post',
        data: {
          _token: '{{ csrf_token() }}',
            "id": id,
        },
        success: function (){
          $ele.fadeOut().remove();
        }
    });

});

</script>
@endsection