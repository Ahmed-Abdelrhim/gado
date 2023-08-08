@extends('front.layout.app')

@section('content')

<main>
    <!-- START:: BREADCRUMBS -->
    @include('front.auth.parts.breadcrumbs',[$page_name = __("messages.comp_info")])
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
                                        aria-controls="user_login" aria-selected="true"> {{ __('messages.login_c') }}  </a>
                                </li>

                            </ul>

                        </div>

                        <div class="custom_form_authentication">
                            <div class="tab-content" id="myTabContent">

                                {{-- customer --}}
                                <div class="tab-pane fade show active" id="user_login" role="tabpanel"
                                    aria-labelledby="user_login_tab">

                                    {{-- text info --}}
                                    @include('front.auth.parts.text_info',[$title = __("messages.comp_info"), $desc = __("messages.plase")])

                                    <form action="{{ route('customer.store_customer') }}" method="POST" class="form-group-custom edit_password row">
                                        @csrf
                                        <input type="hidden" name="token" value="{{ request()->token }}">
                                        @include('front.auth.parts.name_phone_email_inputs')
                                        @include('front.auth.parts.password_input')

                                        <div class="col-md-12">
                                            <button type="submit" class="btn-animation-2 w-100">
                                            {{ __('messages.create_ac') }}
                                            </button>
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