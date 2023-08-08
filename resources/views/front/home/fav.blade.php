@extends('front.layout.app')

@section('content')

@include('front.parts.header')
    <!-- START:: SLIDER HERO SECTION -->
   
    <!-- START:: INFO SITE SECTION -->
    

    
    <main>

        <div class="breadcrumbs">
            <div class="container">
                <h1> {{ __('messages.Favorite') }}</h1>
                <ul>
                    <li>
                    <a href="{{ url('/') }}">
                            <img src="{{asset('dist/front/assets/images/icons/home.svg')}}" alt="" height="" width="" />
                            {{ __('messages.Home') }}
                        </a>
                    </li>
                    <li>/</li>
                    <li class="active"> {{ __('messages.Favorite') }}</li>
                </ul>
            </div>
        </div>
        <!-- START:: CONTENT PAGE -->
        <div class="container mt-5">
            <form accept="#" class="row">
                <div class="col-md-12">
                    <!-- START:: SECTION PRODUCTS -->
                    <section class="products_section p-0">
                        <div class="row">
                        @if(count($pros) != 0)
                            @foreach($pros as $vauu)
                            <div class="col-md-3 wow animate fadeInUp">
                                @include('front.parts.single_product',[$vauu])
                            </div>
                            @endforeach
                        @endif
                        </div>
                    </section>
                    <!-- END:: SECTION PRODUCTS -->

                </div>
            </form>
        </div>
        <!-- END:: CONTENT PAGE -->
    </main>

    <!-- START:: SECTION PRODUCTS -->
@endsection


@section('scripts')
    
<script>

var option = {
        language: 'ar',
        uiColor: '#9AB8F3'
        }
    CKEDITOR.replace( 'comment',option );


        $(document).on('click','.ods', function(){
        var data = {
            id : $(this).data("id"),
            count : $('.count').val(),
		    _token     : $("input[name='_token']").val()
	    }

		
		$.ajax(
		{
			url: "{{route('front_add_order')}}",
			type: 'post',
			data: data,
			success: function (s,result){
                $(".cart_num").html(s.datas);
                $(".cart_tot").html(s.total + "جنيه");
			}
		});
	   
	});


    $(document).on('click','.fav', function(){
        var data = {
            id : $(this).data("id"),
		    _token     : $("input[name='_token']").val()
	    }

		
		$.ajax(
		{
			url: "{{route('front_add_fav')}}",
			type: 'post',
			data: data,
			success: function (s,result){

			}
		});
	   
	});

    
    $(document).on('change','.kind', function(){

            var link = "{{url()->current()}}" + "?kind=" +$(this).val()
            window.location.href = link

    });
     
    </script>
@endsection