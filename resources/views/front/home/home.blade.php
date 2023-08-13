@extends('front.layout.app')

@section('content')

@include('front.parts.header')
    <!-- START:: SLIDER HERO SECTION -->
    @include('front.parts.slider')
    <!-- END:: SLIDER HERO SECTION -->

    <!-- START:: INFO SITE SECTION -->
    @include('front.parts.info')
    <!-- END:: INFO SITE SECTION -->

    <!-- START:: SECTION PRODUCTS -->
    @include('front.parts.products_section',[$data =  $paies ,$title = __("messages.best_seller")])
    <!-- END:: SECTION PRODUCTS -->
    @if(!is_null($pans))
    @if($div == $pans->kind)
    <!-- START:: LARGE BANNER SECTION -->
    <section class="large_banner_section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <div class="right_part">
                        <img src="{{asset('uploads/panners/'.$pans->image)}}" alt="" width="" height="">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="left_part">
                        <h3>
                        @if(session()->get('locale') == "en")

                                    {{$pans->name_en}}
                                    @else
                                    {{$pans->name_ar}}
                                    @endif
                        </h3>
                        <h4>
                        @if(session()->get('locale') == "en")
                                {!!$pans->desc_en!!}
                                    @else
                                    {!!$pans->desc_ar!!}

                                    @endif </h4>
                        <a href="{{ route('front_show_more', ['div'=>$div,'id'=>'panner','panner'=>$pans->name_ar]) }}" class="btn-animation-1">
                            {{ __('messages.Shop_now') }}
                            <i class="fas fa-angle-double-left"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    @endif
    <!-- END:: LARGE BANNER SECTION -->

    <!-- START:: SECTION PRODUCTS -->
    @include('front.parts.products_section',[$data = $latest ,$title =  __("messages.newly_added")])
    <!-- END:: SECTION PRODUCTS -->

    <!-- START:: LARGE BANNER SECTION -->
    <section class="small_banner_section">
        <div class="row">
        @if(!is_null($pannns))
        @foreach($pannns as $val)
        @if($div == $val->kind)
            <div class="col-md-6">
                <div class="single_banner">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="right_part">
                                <img src="{{asset('uploads/panners/'.$val->image)}}" alt="" width="" height="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="left_part">
                                <h3>
                                    @if(session()->get('locale') == "en")

                                    {{$val->name_en}}
                                    @else
                                    {{$val->name_ar}}
                                    @endif
                                </h3>
                                <h4>
                                @if(session()->get('locale') == "en")
                                {!!$val->desc_en!!}
                                    @else
                                    {!!$val->desc_ar!!}

                                    @endif
                                 </h4>
                                <a href="{{ route('front_show_more', ['div'=>$div,'id'=>'panner','panner'=>$val->name_ar]) }}" class="btn-animation-2">
                                    {{ __('messages.Shop_now') }}
                                    <i class="fas fa-angle-double-left"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @endforeach
        @endif
        </div>
    </section>
    <!-- END:: LARGE BANNER SECTION -->
    {{csrf_field()}}
    <!-- START:: SECTION PRODUCTS -->
    @include('front.parts.products_section',[$data = $latest ,$title = __("messages.Todays_Offers")])
    <!-- END:: SECTION PRODUCTS -->
@endsection


@section('scripts')


<script>

    console.log(isMobile());


    if(isMobile() !== false && isMobile() == 'android'){

        {{--window.location.href = "{{ route("app.android") }}";--}}

    }

    if(isMobile() !== false && isMobile() == 'iphone'){
        {{--window.location.href = "{{ route("app.iphone") }}";--}}
    }
    // if (isMobile() !== "" || isMobile() == "android") {
    //
    //     /* your code here */
    // }else if(isMobile() !== "" || isMobile() == "iphone"){
    //     console.log("iphone 12");
    // }

    // Used to detect whether the users browser is an mobile browser
    function isMobile() {
        ///<summary>Detecting whether the browser is a mobile browser or desktop browser</summary>
        ///<returns>A boolean value indicating whether the browser is a mobile browser or not</returns>

        if (sessionStorage.desktop) // desktop storage
            return false;
        else if (localStorage.mobile) // mobile storage
            return true;

        // alternative
        var mobile = ['iphone','ipad','android','blackberry','nokia','opera mini','windows mobile','windows phone','iemobile'];
        for (var i in mobile) if (navigator.userAgent.toLowerCase().indexOf(mobile[i].toLowerCase()) > 0)  return mobile[i].toLowerCase();

        // nothing found.. assume desktop
        return false;
    }
</script>
@endsection