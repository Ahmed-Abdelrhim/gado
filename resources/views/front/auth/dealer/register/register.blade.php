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
                                        <a class="active" id="provider_login_tab" data-bs-toggle="tab"
                                           data-bs-target="#provider_login"
                                           type="button" role="tab" aria-controls="provider_login"
                                           aria-selected="true">  {{ __('messages.login_d') }}</a>
                                    </li>
                                </ul>

                            </div>

                            <div class="custom_form_authentication">
                                <div class="tab-content" id="myTabContent">


                                    <!-- dealer -->
                                    <div class="tab-pane fade show active" id="provider_login" role="tabpanel"
                                         aria-labelledby="provider_login_tab">

                                        {{-- text info --}}
                                        @include('front.auth.parts.text_info',[$title = __("messages.comp_info"), $desc = __("messages.plase")])

                                        <form action="{{ route('dealer.store_dealer') }}" method="POST"
                                              class="form-group-custom edit_password row">
                                            @csrf
                                            <input type="hidden" name="token" value="{{ request()->token }}">
                                            @include('front.auth.parts.name_phone_email_inputs')
                                            @include('front.auth.parts.commireca_and_tax_num')
                                            @include('front.auth.parts.password_input')

                                            <div class="col-md-12">
                                                <button class="btn-animation-2 w-100" type="button" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal">
                                                    {{ __('messages.create_ac') }}
                                                </button>
                                            </div>


                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal" tabindex="-1"
                                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body body_modal">
                                                            <div class="icon">
                                                                <svg viewBox="0 0 26 26"
                                                                     xmlns="http://www.w3.org/2000/svg">
                                                                    <g stroke="currentColor" stroke-width="1.5"
                                                                       fill="none" fill-rule="evenodd"
                                                                       stroke-linecap="round" stroke-linejoin="round">
                                                                        <path class="circle"
                                                                              d="M13 1C6.372583 1 1 6.372583 1 13s5.372583 12 12 12 12-5.372583 12-12S19.627417 1 13 1z"/>
                                                                        <path class="tick"
                                                                              d="M6.5 13.5L10 17 l8.808621-8.308621"/>
                                                                    </g>
                                                                </svg>
                                                            </div>
                                                            <h3>
                                                                {{ __('الرجاء اتمام العملية وسيتم التواصل معك خلال 48 ساعة') }}
                                                            </h3>
                                                            <div class="btns_cart_fav d-flex">
                                                                <button type="submit" class="btn-animation-2 w-100">
                                                                    تأكيد انشاء الحساب
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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