@if(!is_null($vauu))
<div class="single_product">
   
        <!-- START:: WISHLIST BTN -->
        <div class="wishlist_and_badge">  

        @if(auth()->guard('customer')->check() || auth()->guard('dealer')->check())
            @if(!is_null($vauu->ProLis()))  
                <button type="button" data-id ="{{$vauu->id}}" class="wishlist_btn isFav wishde wishlist_btn_{{$vauu->id}}" id="wishlist_btn_{{$vauu->id}}"  style="background-color : #FF4747">
                </button>
            @else
                <button type="button" data-id ="{{$vauu->id}}" class=" wishlist_btn wish wishlist_btn_{{$vauu->id}}" id="wishlist_btn_{{$vauu->id}}"  style="">
                </button>
            @endif
        @else

        <a href="{{ route('front.login') }}" class="wishlist_btn" id="wishlist_btn_1"  style=""> <button type="button" data-id ="{{$vauu->id}}" class="wishlist_btn " id="wishlist_btn_1"  style="">
                </button> </a>
         

        @endif
        @if($vauu->price > 0  && $vauu->price > 0)  
            @php $praaa = (1 - ($vauu->price_discount / $vauu->price)) * 100  @endphp
            <small class="red_badge">{{ round($praaa, 0) }}%</small>
        @endif
        </div>
        <!-- START:: IMAGE PRODUCT -->
        <div class="image_product">
        <a href="{{route('front_product_detial',['div'=>$div,'id'=>$vauu])}}"> <img src="{{ $vauu->card_image }}" alt="" width="" height=""> </a>
        </div>
        <!-- START:: PRODUCT INFO -->
        <div class="product_informations">
 
        <a href="{{route('front_product_detial',['div'=>$div,'id'=>$vauu])}}">  <h5>
        @if(session()->get('locale') == "en")
                                    
        {{$vauu->name_en}}
        @else
        {{ $vauu->name_ar }}
        @endif
        </h5></a>
            <div class="rate_part">
                <ul>
                @if($vauu->rate == 0)
                    <li><i class="fas fa-star color-non"></i></li>
                    <li><i class="fas fa-star color-none"></i></li>
                    <li><i class="fas fa-star color-none"></i></li>
                    <li><i class="fas fa-star color-none"></i></li>
                    <li><i class="fas fa-star color-none"></i></li>
                @endif
                @if($vauu->rate >= 1 && $vauu->rate < 2)
                    <li><i class="fas fa-star"></i></li>
                    <li><i class="fas fa-star color-none"></i></li>
                    <li><i class="fas fa-star color-none"></i></li>
                    <li><i class="fas fa-star color-none"></i></li>
                    <li><i class="fas fa-star color-none"></i></li>
                @endif
                @if($vauu->rate > 1 && $vauu->rate <= 2 && $vauu->rate < 3)
                    <li><i class="fas fa-star"></i></li>
                    <li><i class="fas fa-star"></i></li>
                    <li><i class="fas fa-star color-none"></i></li>
                    <li><i class="fas fa-star color-none"></i></li>
                    <li><i class="fas fa-star color-none"></i></li>
                @endif
                @if($vauu->rate > 2 && $vauu->rate <= 3 && $vauu->rate < 4)
                    <li><i class="fas fa-star"></i></li>
                    <li><i class="fas fa-star"></i></li>
                    <li><i class="fas fa-star"></i></li>
                    <li><i class="fas fa-star color-none"></i></li>
                    <li><i class="fas fa-star color-none"></i></li>
                @endif
                @if($vauu->rate > 3 && $vauu->rate <= 4 && $vauu->rate < 5)
                    <li><i class="fas fa-star"></i></li>
                    <li><i class="fas fa-star"></i></li>
                    <li><i class="fas fa-star"></i></li>
                    <li><i class="fas fa-star"></i></li>
                    <li><i class="fas fa-star color-none"></i></li>
                @endif
                @if($vauu->rate > 4 && $vauu->rate <= 5)
                    <li><i class="fas fa-star"></i></li>
                    <li><i class="fas fa-star"></i></li>
                    <li><i class="fas fa-star"></i></li>
                    <li><i class="fas fa-star"></i></li>
                    <li><i class="fas fa-star"></i></li>
                @endif
                   
                </ul>
                <span> {{count($vauu->ProComments)}}</span>
            </div>
            <div class="price">
            @if(auth()->guard('dealer')->check())
                <span class="new_price">{{ $vauu->dealer_price }} EGP</span>
            @else
                <span class="new_price">{{ $vauu->price_discount }} EGP</span>
                <span class="old_price">{{ $vauu->price }} EGP</span>
            @endif
                
            </div>
        </div>
   
    <div class="add_to_cart">
        <form action="#">
       <!--//  data-bs-toggle="modal" data-bs-target="#exampleModal"-->
        <button type="button"  data-id="{{$vauu->id}}"  class="btn-animation-2 adcart">
                <img src="{{asset('dist/front/assets/images/icons/cart-2.svg')}}" alt="" width="" height="">
                {{ __('messages.Add_to_cart') }}
            </button>

            
        </form>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body body_modal">
{{--                <button type="button" class="btn btn-danger btn-round"   style="position: absolute;top: 5px; left: 5px; border-radius: 50%; ">--}}
{{--                    X--}}
{{--                </button>--}}

                <div class="icon">
                    <svg viewBox="0 0 26 26" xmlns="http://www.w3.org/2000/svg">
                        <g stroke="currentColor" stroke-width="1.5" fill="none" fill-rule="evenodd"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path class="circle"
                                d="M13 1C6.372583 1 1 6.372583 1 13s5.372583 12 12 12 12-5.372583 12-12S19.627417 1 13 1z" />
                            <path class="tick" d="M6.5 13.5L10 17 l8.808621-8.308621" />
                        </g>
                    </svg>
                </div>
                <h3>
                {{ __('messages.Product_added_to_cart') }}
               </h3>
                <div class="btns_cart_fav d-flex">
                    <a href="{{ route('front_home_cart',['div'=>$div]) }}" class="btn-animation-2" >
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


@endif

