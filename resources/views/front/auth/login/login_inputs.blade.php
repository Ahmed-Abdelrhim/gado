<div class="col-md-12 mb-3">
    <label for="mobile" class="form-label">{{ __('messages.Mobile_number') }}</label>
    <input type="tel" name="phone" class="form-control" id="mobile"
        placeholder="{{ __('messages.Mobile_number') }}" maxlength="11" minlength="11">
</div>
<div class="col-md-12 mb-3">
    <label for="old_password" class="form-label"> {{ __('messages.passs') }}</label>
    <div class="input_password">
        <input type="password" name="password" class="form-control"
        minlength="6" maxlength="190"
            id="old_password" placeholder="{{ __('messages.passs') }} ">
            <div class="show_hide" onclick="password_show_hide();">
                <img src="{{asset('dist/front/assets/images/icons/eye.svg')}}" id="show_eye"
                    height="" width="" alt="">
                <img src="{{asset('dist/front/assets/images/icons/eye-hide.svg')}}" class="hide_eye"
                    id="hide_eye" height="" width="" alt="">
            </div>
    </div>
</div>
<div class="col-md-12 mb-3">
      <label for="remember"  class="form-label">تذكرني </label>
      <input type="checkbox" name="remember" value="1">
</div>