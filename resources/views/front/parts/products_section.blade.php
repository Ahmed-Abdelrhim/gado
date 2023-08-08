<section class="products_section">
    <div class="container">
        <div class="title_section">
            <h2>{{ $title }}</h2>
           
        </div>
        <div class="row">
            <!-- START:: SINGLE PRODUCT -->
            @if(count($data) != 0)
                @foreach($data as $vauu)
                <div class="col-md-3 wow animate fadeInUp">
                    @include('front.parts.single_product',[$vauu])
                </div>
                @endforeach
            @endif
        </div>
        <div class="show_more_btn">
            <a href="{{ route('front_show_more',['div'=>$div]) }}" class="btn-animation-1">
            {{ __('messages.show_more') }}
                <i class="fas fa-angle-double-left"></i>
            </a>
        </div>
    </div>
</section>