@extends('front.layout.app')

@section('content')
<main>

    <!-- START:: BREADCRUMBS -->
    @include('front.auth.parts.breadcrumbs',[$page_name = 'نسيت كلمة المرور'])
    <!-- END:: BREADCRUMBS -->

    <!-- START:: AUTHENTICATION -->
    <section class="authentication">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-7">
                    <div class="custom_authentication">
                        <div class="custom_tab_authentication">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="active" id="user_login_tab" data-bs-toggle="tab"
                                        data-bs-target="#user_login" type="button" role="tab"
                                        aria-controls="user_login" aria-selected="true">  {{ __('messages.login_c') }} </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a id="provider_login_tab" data-bs-toggle="tab" data-bs-target="#provider_login"
                                        type="button" role="tab" aria-controls="provider_login"
                                        aria-selected="true">  {{ __('messages.login_d') }} </a>
                                </li>
                            </ul>
                        </div>

                        <div class="custom_form_authentication">
                            <div class="tab-content" id="myTabContent">
                                
                                {{-- customer --}}
                                <div class="tab-pane fade show active" id="user_login" role="tabpanel"
                                    aria-labelledby="user_login_tab">

                                    {{-- text info --}}
                                    @include('front.auth.parts.text_info',[$title = 'إستعادة كلمة المرور',$desc = 'برجاء ادخال رقم الجوال الخاص بك'])
                                    
                                    <form action="{{ route('customer.verify_phone') }}"
                                        class="form-group-custom edit_password row" method="POST">
                                        @csrf
                                        {{-- inputs --}}
                                       <div class="col-md-12 mb-3">
                                            <label for="mobile" class="form-label"> {{ __('messages.Mobile_number') }} <span>*</span></label>
                                            <input type="tel" name="phone" class="form-control" id="mobile"
                                                placeholder="{{ __('messages.Mobile_number') }}" maxlength="11" minlength="11" required>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn-animation-2 w-100">
                                            استرجاع كلمة المرور
                                            </button>
                                        </div>

                                        <div class="col-md-12">
                                            @include('front.auth.parts.login_link')
                                        </div>
                                    </form>
                                </div>

                                {{-- dealer --}}
                                <div class="tab-pane fade" id="provider_login" role="tabpanel"
                                    aria-labelledby="provider_login_tab">

                                    {{-- text info --}}
                                    @include('front.auth.parts.text_info')

                                    <form  action="{{ route('dealer.verify_phone') }}"
                                        class="form-group-custom edit_password row" method="POST">
                                        @csrf

                                        {{-- inputs --}}
                                        <div class="col-md-12 mb-3">
                                            <label for="mobile" class="form-label"> {{ __('messages.Mobile_number') }} <span>*</span></label>
                                            <input type="tel" name="phone" class="form-control" id="mobile"
                                                placeholder="{{ __('messages.Mobile_number') }}" maxlength="11" minlength="11" required>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn-animation-2 w-100">
                                            استرجاع كلمة المرور
                                            </button>
                                        </div>

                                        <div class="col-md-12">
                                            @include('front.auth.parts.login_link')
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END:: AUTHENTICATION -->
</main>
@endsection