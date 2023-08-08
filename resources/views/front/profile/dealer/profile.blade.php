@extends('front.layout.app')

@section('content')
@include('front.parts.header')
<main>
        <!-- START:: BREADCRUMBS -->
        @include('front.auth.parts.breadcrumbs',[$page_name = __('messages.Profile')])
        <!-- END:: BREADCRUMBS -->

    <!-- START:: CONTENT PAGE -->
    <div class="content_single_page">
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-3">
                    <div class="profile_list">
                        @include('front.profile.dealer.links')
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="content_page_shop mb-3 p-0">
                        <div class="title_page">
                            <h4>{{ __('messages.Profile') }}</h4>
                        </div>
                        <form class="form-group-custom edit_data row" method="POST" action="{{ route('dealer.update_profile') }}">
                            @csrf
                            <div class="col-md-6 mb-3">
                                <label for="firstName" class="form-label">{{ __('messages.user_name') }}<span>*</span></label>
                                <input type="text" name="name" value="{{ auth()->guard('dealer')->user()->name }}" class="form-control" id="firstName"
                                maxlength="50" min="10" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="mobile" class="form-label">{{ __('messages.Mobile_number') }}<span>*</span></label>
                                <input type="tel" name="phone" class="form-control" id="mobile" value="{{ auth()->guard('dealer')->user()->phone }}"
                                maxlength="11" min="11" readonly required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="email" class="form-label"> {{ __('messages.email') }} <span>*</span></label>
                                <input type="email" name="email" class="form-control" id="email" value="{{ auth()->guard('dealer')->user()->email }}"
                                   >
                            </div>
                            <div class="col-md-12 mb-3">
                                
                            <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" style="padding: 0">
                                    <img src="{{asset('dist/front/assets/images/icons/lock.svg')}}" width="" height="" alt="">
                                    {{ __('messages.change_Password') }}
                                </button>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn-animation-2">
                                {{ __('messages.saved') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- END:: CONTENT PAGE -->

    @include('front.profile.dealer.password_modal')

</main>
@endsection