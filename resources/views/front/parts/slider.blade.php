<section class="hero_section">
    <div id="heroSectionSlider" class="owl-carousel owl-theme">
        
    @foreach($slids as $value)
        <!-- START:: SINGLE ITEM -->
        @if($div == $value->kind)
        <div class="item">
            <div class="container">
                <div class="row justify-content-between align-items-center" dir="ltr">

                    <div class="col-lg-6">
                        <div class="right_part">
                            <img src="{{asset('uploads/panners/'.$value->image)}}" alt="" width="" height="">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="left_part">
                            <h1>
                            @if(session()->get('locale') == "en")
                                    
                                    {{$value->name_en}}
                                    @else
                                    {{$value->name_ar}} 
                                    @endif
                                        
                            </h1>
                            <p>
                            @if(session()->get('locale') == "en")
                                    
                                 
                                    {!!$value->desc_en!!} 
                                    @else
                                    {!!$value->desc_ar!!} 
                                    @endif
                            </p>
                            <a href="{{ route('front_show_more', ['div'=>$div,'id'=>'panner','panner'=>$value->name_ar]) }}" class="btn-animation-1">
                                {{ __('messages.Shop_now') }}
                                <i class="fas fa-angle-double-left"></i>
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
        <!-- END:: SINGLE ITEM -->

        @endif
    @endforeach
     
        <!-- END:: SINGLE ITEM -->
    </div>
</section>