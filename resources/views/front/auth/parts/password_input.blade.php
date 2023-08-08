<div class="col-md-12 mb-3">
    <label for="old_password" class="form-label">{{ __('messages.passs') }} 
        <span>*</span></label>
    <div class="input_password">
        <input type="password" name="password" class="form-control"
            maxlength="190" minlength="6"
            id="old_password" placeholder=" {{ __('messages.passs') }}  ">
        <div class="show_hide" onclick="password_show_hide();">
            <img src="{{asset('dist/front/assets/images/icons/eye.svg')}}" id="show_eye" height=""
                width="" alt="">
            <img src="{{asset('dist/front/assets/images/icons/eye-hide.svg')}}" class="hide_eye"
                id="hide_eye" height="" width="" alt="">
        </div>
    </div>
</div>

<div class="col-md-12 mb-3">
    <label for="confirm_password" class="form-label"> {{ __('messages.conf') }} 
        <span>*</span></label>
    <div class="input_password">
        <input type="password" name="password_confirmation" class="form-control"
            id="confirm_password "
            maxlength="190" minlength="6"
            placeholder="{{ __('messages.passs') }}  ">
        <div class="show_hide" onclick="password_show_hide_confirm();">
            <img src="{{asset('dist/front/assets/images/icons/eye.svg')}}" id="show_eye2"
                height="" width="" alt="">
            <img src="{{asset('dist/front/assets/images/icons/eye-hide.svg')}}" class="hide_eye"
                id="hide_eye2" height="" width="" alt="">
        </div>
    </div>
</div>

@if(request()->route()->getName() !== 'front.forget_password.new_password')
    <div class="col-md-12 mb-3">
        <div class="dont_have_account terms">
            <input type="checkbox" class="form-check-input" name="terms"
                id="terms">
            <label for="terms">{{ __('messages.agreee') }} <a
                    href="{{ route('front.terms_and_conditions') }}" target="_blank"> {{ __('messages.terms_and_conditions') }}</a></label>
        </div>
    </div>
@endif