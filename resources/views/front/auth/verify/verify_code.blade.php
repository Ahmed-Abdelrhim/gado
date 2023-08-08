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

                        <div class="custom_form_authentication">

                            {{-- text info --}}
                            @include('front.auth.parts.text_info',[$title = __("messages.vryf"), $desc = __("messages.active_mass")])

                            <form action="{{ route('front.check_code') }}" method="POST" class="form-group-custom number-code">
                                @csrf
                                <input type="hidden" name="phone" value="{{ request()->phone }}">
                                <input type="hidden" name="token" value="{{ request()->token }}">
                                <div class="row" dir="ltr">
                                    <div class="col-3 mb-3">
                                        <input name="code[]" class="code-input form-control text-center"
                                            placeholder="--" type="number" required maxlength="1" />
                                    </div>
                                    <div class="col-3 mb-3">
                                        <input name="code[]" class="code-input form-control text-center"
                                            placeholder="--" type="number" required maxlength="1" />
                                    </div>
                                    <div class="col-3 mb-3">
                                        <input name="code[]" class="code-input form-control text-center"
                                            placeholder="--" type="number" required maxlength="1" />
                                    </div>
                                    <div class="col-3">
                                        <input name="code[]" class="code-input form-control text-center"
                                            placeholder="--" type="number" required maxlength="1" />
                                    </div>
                                    <div class="col-md-12 mb-5 mt-3">
                                    
                                    <div class="col-md-12">
                                        <button type="submit" class="btn-animation-2 w-100">
                                        {{ __('messages.saved') }} 
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <div class="dont_have_account m-0">
                                            <p>  {{ __('messages.no_mass') }} 
                                            <form  action="{{ route('dealer.verify_send_code') }}"
                                      method="POST">
                                        @csrf

                                        {{-- inputs --}}
                                        <input type="hidden" name="phone" class="form-control" id="mobile"
                                        placeholder="{{ __('messages.Mobile_number') }}" maxlength="11" minlength="11" value="{{ request()->phone }}" required>

                                        <button type="submit" style="color:#FFAD40" href="{{ route('front.login') }}">
                                            {{ __('messages.prass') }}</button>
                                        </form></p>
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