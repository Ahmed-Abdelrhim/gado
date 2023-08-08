@extends('front.layout.app')

@section('content')
<main>

    <!-- START:: BREADCRUMBS -->
    @include('front.auth.parts.breadcrumbs',[$page_name = __("messages.create_ac")])
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
                                        aria-controls="user_login" aria-selected="true"> {{ __('messages.login_c') }}</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a id="provider_login_tab" data-bs-toggle="tab" data-bs-target="#provider_login"
                                        type="button" role="tab" aria-controls="provider_login"
                                        aria-selected="true"> {{ __('messages.login_d') }}</a>
                                </li>
                            </ul>
                        </div>

                        <div class="custom_form_authentication">
                            <div class="tab-content" id="myTabContent">
                                
                                {{-- customer --}}
                                <div class="tab-pane fade show active" id="user_login" role="tabpanel"
                                    aria-labelledby="user_login_tab">

                                    {{-- text info --}}
                                    @include('front.auth.parts.text_info',[$title = __("messages.create_ac"),$desc = __("messages.plase")])

                                    <form action="{{ route('customer.verify_send_code') }}"
                                        class="form-group-custom edit_password row" method="POST">
                                        @csrf
                                        {{-- inputs --}}
                                        @include('front.auth.verify.inputs')

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

                                    <form  action="{{ route('dealer.verify_send_code') }}"
                                        class="form-group-custom edit_password row" method="POST">
                                        @csrf

                                        {{-- inputs --}}
                                        @include('front.auth.verify.inputs')

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