@extends('front.layout.app')

@section('content')

@include('front.parts.header')
    <!-- START:: SLIDER HERO SECTION -->
   
    <!-- START:: INFO SITE SECTION -->
    

    <main>

         <!-- START:: BREADCRUMBS -->
         <div class="breadcrumbs">
            <div class="container">
                <h1>{{ __('messages.Contact_us') }}</h1>
                <ul>
                    <li>
                    <a href="{{ url('/') }}">
                            <img src="{{asset('dist/front/assets/images/icons/home.svg')}}" alt="" height="" width="" />
                            {{ __('messages.Home') }}
                        </a>
                    </li>
                    <li>/</li>
                    <li class="active">{{ __('messages.Contact_us') }}</li>
                </ul>
            </div>
        </div>
        <!-- END:: BREADCRUMBS -->

        <!-- START:: CONTENT PAGE -->
        <div class="content_single_page">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-12">
                        <div class="content_page_shop mb-3 p-0">
                            <div class="title_page">
                                <h4> {{ __('messages.Contact_us') }}</h4>
                            </div>
                            <form class="form-group-custom row"  action="{{route('front_add_contuct_us')}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="col-md-12 mb-3">
                                    <label for="firstName" class="form-label"> {{ __('messages.user_name') }} <span>*</span></label>
                                    <input type="text" name="name" class="form-control" id="firstName"
                                        placeholder="{{ __('messages.user_name') }}" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="mobile" class="form-label">  {{ __('messages.Mobile_number') }} <span>*</span></label>
                                    <input type="tel" name="phone" class="form-control" id="mobile"
                                        placeholder=" {{ __('messages.Mobile_number') }}" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="email" class="form-label"> {{ __('messages.email') }}  <span>*</span></label>
                                    <input type="email" name="email" class="form-control" id="email"
                                        placeholder=" {{ __('messages.email') }} " required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="otherData" class="form-label"> {{ __('messages.your_massage') }}</label>
                                    <textarea class="form-control" name="desc" id="otherData" rows="5"
                                        placeholder=" {{ __('messages.your_massage') }}" required></textarea>
                                </div>
                                <div class="col-md-12">
                                    <button type="supmit" class="btn-animation-2">
                                    {{ __('messages.send') }}
                                    </button>
                                </div>
                            </form>
                        </div>
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
     
    </script>
@endsection