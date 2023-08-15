@extends('front.layout.app')

@section('content')

    @include('front.parts.header')
    <!-- START:: SLIDER HERO SECTION -->

    <!-- START:: INFO SITE SECTION -->



    <main>

        <div class="breadcrumbs">
            <div class="container">
                <h1>{{ __('messages.Product_details') }}</h1>
                <ul>
                    <li>
                        <a href="{{ url('/') }}">
                            <img src="{{asset('dist/front/assets/images/icons/home.svg')}}" alt="" height="" width=""/>
                            {{ __('messages.Home') }}
                        </a>
                    </li>
                    <li>/</li>

                    <li class="active">{{ __('messages.Product_details') }}</li>
                </ul>
            </div>
        </div>
        <section class="product_details_section mt-5">
            <div class="container">
                <div class="row">
                    <!-- START:: PRODUCT SLIDER  -->

                    <div class="col-md-6">

                        <div id="slider_product1" class="owl-carousel owl-theme">
                            @foreach($pro->Images as $value)
                                <div class="item">
                                    <img src="{{asset('uploads/products_images/'.$value->image)}}" alt="">
                                </div>
                            @endforeach
                        </div>


                        <div id="slider_product2" class="owl-carousel owl-theme">
                            @foreach($pro->Images as $value)
                                <div class="item">
                                    <img src="{{asset('uploads/products_images/'.$value->image)}}" alt="">
                                </div>
                            @endforeach
                        </div>

                    </div>
                    <!-- END:: PRODUCT SLIDER  -->

                    <!-- START:: PRODUCT DETAILS -->
                    <div class="col-md-6">
                        <!-- START:: HEAD  -->
                        <div class="head_details">
                            <h4>
                                @if(session()->get('locale') == "en")
                                    {{$pro->name_en}}
                                @else
                                    {{ $pro->name_ar }}
                                @endif</h4>
                            <div class="rate_part">
                                <ul>
                                    @if($pro->rate == 0)
                                        <li><i class="fas fa-star color-non"></i></li>
                                        <li><i class="fas fa-star color-none"></i></li>
                                        <li><i class="fas fa-star color-none"></i></li>
                                        <li><i class="fas fa-star color-none"></i></li>
                                        <li><i class="fas fa-star color-none"></i></li>
                                    @endif
                                    @if($pro->rate >= 1 && $pro->rate < 2)
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star color-none"></i></li>
                                        <li><i class="fas fa-star color-none"></i></li>
                                        <li><i class="fas fa-star color-none"></i></li>
                                        <li><i class="fas fa-star color-none"></i></li>
                                    @endif
                                    @if($pro->rate > 1 && $pro->rate <= 2 && $pro->rate < 3)
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star color-none"></i></li>
                                        <li><i class="fas fa-star color-none"></i></li>
                                        <li><i class="fas fa-star color-none"></i></li>
                                    @endif
                                    @if($pro->rate > 2 && $pro->rate <= 3 && $pro->rate < 4)
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star color-none"></i></li>
                                        <li><i class="fas fa-star color-none"></i></li>
                                    @endif
                                    @if($pro->rate > 3 && $pro->rate <= 4 && $pro->rate < 5)
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star color-none"></i></li>
                                    @endif
                                    @if($pro->rate > 4 && $pro->rate <= 5)
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                    @endif
                                </ul>
                                <span>{{count($pro->ProComments)}} تقييم</span>
                            </div>

                            <div class="available_in_stock" style="margin-bottom: 8px;">
                                @if($pro->stock != 0)
                                    <span style="color:red;font-size: 13px;"> متوفر : {{$pro->stock}} قطع  </span>
                                @else
                                    <span style="color:red;font-size: 13px;">  غير متوفر حالياً  </span>
                                @endif
                            </div>

                            <div class="price">
                                @if(auth()->guard('dealer')->check())
                                    <span class="new_price">{{ $pro->dealer_price }} EGP</span>
                                @else
                                    <span class="new_price">{{ $pro->price_discount }} EGP</span>
                                    <span class="old_price">{{ $pro->price }} EGP</span>
                                @endif
                            </div>
                        </div>
                        <!-- START:: SHORT DESC -->
                        <div class="content_short_description">
                            <div class="title_content">
                                <span>{{ __('messages.Product_details') }} : </span>
                            </div>
                            <p>
                                @if(session()->get('locale') == "en")

                                    {!! $pro->des_en !!}
                                @else
                                    {!! $pro->des_ar !!}
                                @endif

                            </p>
                        </div>
                        <!-- START:: BTNS ( ADD CART & FAV ) QUANTITY -->
                        <form action="#" class="btn_quantity_cart_fav">
                            <div class="d-flex align-items-center">
                                <div class="title_content m-0">
                                    <span>{{ __('messages.Quantity') }} : </span>
                                </div>
                                <div class="btn_min_max">
                                    <button type="button" class="min"><i class="fas fa-minus"></i></button>
                                    <input disabled type="number" value="1" class="inputCount count"/>
                                    <button type="button" class="max"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="btns_cart_fav">
                                <button type="button" data-id="{{$pro->id}}" class="btn-animation-2 ods">
                                    <img src="{{asset('dist/front/assets/images/icons/cart-2.svg')}}" alt="" width=""
                                         height="">
                                    {{ __('messages.Add_to_cart') }}
                                </button>
                                @if(!is_null($pro->ProLis()))

                                    <button type="button" data-id="{{$pro->id}}"
                                            class="wishde btn-animation-4 fav wishlist_btn_{{$pro->id}}"
                                            style="background-color : #FF4747;color : #FFF">
                                        <img src="{{asset('dist/front/assets/images/icons/wishlist_icon.svg')}}" alt=""
                                             width="" height="">
                                        {{ __('messages.Add_favorites') }}
                                    </button>
                                @else
                                    <button type="button" data-id="{{$pro->id}}" class="wish btn-animation-4 fav">
                                        <img src="{{asset('dist/front/assets/images/icons/wishlist_icon.svg')}}" alt=""
                                             width="" height="">
                                        {{ __('messages.Add_favorites') }}
                                    </button>
                                @endif

                            </div>
                        </form>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">


                                    {{--                                    <div class="modal-header">--}}


                                    {{--                                      --}}

                                    {{--                                        <button type="button" class="close" data-dismiss="modal">&times;</button>--}}
                                    {{--                                        <h4 class="modal-title">Modal Header</h4>--}}
                                    {{--                                    </div>--}}
                                    <div class="modal-body body_modal">
                                        {{--                                        <button type="button" class="btn btn-danger btn-round"  id="xmodal" style="position: absolute;top: 5px; left: 5px; border-radius: 50%; ">--}}
                                        {{--                                            X--}}
                                        {{--                                        </button>--}}
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
                                            <a href="{{ route('front_home_cart',['div'=>$div]) }}"
                                               class="btn-animation-2">
                                                إتمام عملية الشراء
                                            </a>
                                            <a href="javascript:;" id="xmodal" class="btn-animation-4">
                                                منتجات اخري
                                            </a>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="modal fade" id="exampleModalError" tabindex="-1"
                             aria-labelledby="exampleModalErrorLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body body_modal">
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
                                        <h3 id="errorMsg">

                                        </h3>
                                        <div class>
                                            <a href="javascript:;" id="closeErrorBtn" data-dismiss="modal"
                                               aria-label="Close" class="btn-animation-2">
                                                إغلاق
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- START:: PART SHARE SOCIAL -->
                        <div class="title_content">
                            <span>{{ __('messages.share') }} : </span>
                        </div>
                        <div class="ssk-block">
                            <a href="" class="ssk ssk-text ssk-facebook">
                                <i class="fab fa-facebook-f"></i>
                                {{ __('messages.Facebook') }}
                            </a>
                            <a href="" class="ssk ssk-text ssk-twitter">
                                <i class="fab fa-twitter"></i>
                                {{ __('messages.Twitter') }}
                            </a>
                            <a href="" class="ssk ssk-text ssk-google-plus">
                                <i class="fab fa-google-plus"></i>
                                {{ __('messages.Google') }}
                            </a>
                        </div>
                    </div>
                    <!-- END:: PRODUCT DETAILS -->
                </div>
            </div>
        </section>
        <!-- END:: CONTENT PAGE -->

        <!-- START:: TABS DETAILS -->
        <section class="section_tabs">
            <div class="container">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">

                        <button class="nav-link active" id="nav_details_tab" data-bs-toggle="tab"
                                data-bs-target="#nav_details"
                                type="button" role="tab" aria-controls="nav_details" aria-selected="false">
                            {{ __('messages.Product_Features') }}</button>
                        <button class="nav-link" id="nav_reviews_tab" data-bs-toggle="tab" data-bs-target="#nav_reviews"
                                type="button" role="tab" aria-controls="nav_reviews"
                                aria-selected="false">{{ __('messages.comments') }}</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">


                    <div class="tab-pane  show active" id="nav_details" role="tabpanel"
                         aria-labelledby="nav_details_tab">
                        <div class="tabel_details">
                            <table class="table table-striped">

                                <tbody>

                                @foreach($pro->ProTypes as $key => $va)
                                    <tr>
                                        <th scope="row">
                                            @if(session()->get('locale') == "en")

                                                {{$va->name_en}}
                                            @else
                                                {{ $va->name_ar }}
                                            @endif

                                        </th>
                                        <td>
                                            @if(session()->get('locale') == "en")

                                                {{$va->value_en}}
                                            @else
                                                {{ $va->value_ar }}
                                            @endif</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav_reviews" role="tabpanel" aria-labelledby="nav_reviews_tab">
                        <div class="all_reviews">
                            @foreach($pro->ProComments as $key => $val)
                                <!-- START:: SINGLE REVIEW -->
                                <div class="single_review">

                                    <div class="name_rate">
                                        <h4>
                                            @if($val->customer_id != null)
                                                {{ $val->Customer->name ?? '' }}
                                            @else
                                                {{ $val->Dealer->name ?? '' }}
                                            @endif
                                        </h4>
                                        <div class="rate_part">
                                            <ul>
                                                @if($val->rate == 0)
                                                    <li><i class="fas fa-star color-non"></i></li>
                                                    <li><i class="fas fa-star color-none"></i></li>
                                                    <li><i class="fas fa-star color-none"></i></li>
                                                    <li><i class="fas fa-star color-none"></i></li>
                                                    <li><i class="fas fa-star color-none"></i></li>
                                                @endif
                                                @if($val->rate >= 1 && $val->rate < 2)
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><i class="fas fa-star color-none"></i></li>
                                                    <li><i class="fas fa-star color-none"></i></li>
                                                    <li><i class="fas fa-star color-none"></i></li>
                                                    <li><i class="fas fa-star color-none"></i></li>
                                                @endif
                                                @if($val->rate > 1 && $val->rate <= 2 && $val->rate < 3)
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><i class="fas fa-star color-none"></i></li>
                                                    <li><i class="fas fa-star color-none"></i></li>
                                                    <li><i class="fas fa-star color-none"></i></li>
                                                @endif
                                                @if($val->rate > 2 && $val->rate <= 3 && $val->rate < 4)
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><i class="fas fa-star color-none"></i></li>
                                                    <li><i class="fas fa-star color-none"></i></li>
                                                @endif
                                                @if($val->rate > 3 && $val->rate <= 4 && $val->rate < 5)
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><i class="fas fa-star color-none"></i></li>
                                                @endif
                                                @if($val->rate > 4 && $val->rate <= 5)
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><i class="fas fa-star"></i></li>
                                                    <li><i class="fas fa-star"></i></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="content_review">
                                        <p>
                                            {!! $val->comment !!}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="form_review">
                            <form action="{{route('front_add_comment')}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <input type="hidden" name="id" value="{{$pro->id}}">
                                <h3> {{ __('messages.add_comment') }}</h3>{{ __('messages.add_comment_star') }}
                                <p>{{ __('messages.add_comment_star') }}</p>
                                <div class="rate_box">
                                    <input id="rate_5" type="radio" name="rate" value="5"/>
                                    <label for="rate_5">
                                        <i class="fas fa-star"></i>
                                    </label>
                                    <input id="rate_4" type="radio" name="rate" value="4"/>
                                    <label for="rate_4">
                                        <i class="fas fa-star"></i>
                                    </label>
                                    <input id="rate_3" type="radio" name="rate" value="3"/>
                                    <label for="rate_3">
                                        <i class="fas fa-star"></i>
                                    </label>
                                    <input id="rate_2" type="radio" name="rate" value="2"/>
                                    <label for="rate_2">
                                        <i class="fas fa-star"></i>
                                    </label>
                                    <input id="rate_1" type="radio" name="rate" value="1"/>
                                    <label for="rate_1">
                                        <i class="fas fa-star"></i>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label for="review">{{ __('messages.your_comment') }}</label>
                                    <textarea id="review" class="comment" required name="comment" cols="30" rows="10"
                                              placeholder="{{ __('messages.your_comment') }}"></textarea>
                                </div>
                                @if(auth()->guard('customer')->check() || auth()->guard('dealer')->check())
                                    <button type="supmit"
                                            class="btn-animation-2">  {{ __('messages.add_comment') }}</button>
                                @else
                                    <a href="{{route('front.login')}}" class="btn-animation-2">
                                        {{ __('messages.add_comment') }}
                                    </a>
                                @endif

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- END:: TABS DETAILS -->

        <!-- START:: RELATED PRODUCTS -->
        <!-- START:: SECTION PRODUCTS -->
        @include('front.parts.products_section',[$data = $copies ,$title =  __('messages.Similar_Products')])
    </main>

    <!-- START:: SECTION PRODUCTS -->
@endsection


@section('scripts')

    <script>

        var option = {
            language: 'ar',
            uiColor: '#9AB8F3'
        }
        CKEDITOR.replace('comment', option);


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
                        if (!s.error) {
                            $("#exampleModal").modal('show');

                            $(".cart_num").html(s.datas);
                            $(".cart_tot").html(s.total + "جنيه");

                        } else {

                            $("#errorMsg").text(s.errorMsg);
                            $("#exampleModalError").modal('show');
                        }


                    }
                });

        });


        $("#closeErrorBtn").on('click', function () {
            $("#errorMsg").text('');
            $("#exampleModalError").modal('hide');
        });


    </script>
    <script>

        $('#xmodal').on('click', function () {
            $("#exampleModal").modal('hide');
        });

    </script>
@endsection