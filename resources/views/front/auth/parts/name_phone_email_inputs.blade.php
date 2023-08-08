<div class="col-md-12 mb-3">
    <label for="userName" class="form-label">{{ __('messages.user_name') }}
        <span>*</span></label>
    <input type="text" name="name" class="form-control" id="userName"
        placeholder="  {{ __('messages.user_name') }}" maxlength="50" minlength="10" value="{{ old('name') }}">
</div>

<div class="col-md-12 mb-3">
    <label for="mobile" class="form-label"> {{ __('messages.Mobile_number') }} <span>*</span></label>
    <input readonly type="tel" name="phone" class="form-control"
        id="mobile" placeholder="{{ __('messages.Mobile_number') }}" maxlength="11" minlength="11" value="{{ request()->phone }}">
</div>

<div class="col-md-12 mb-3">
    <label for="email" class="form-label">{{ __('messages.email') }}
        <span>*</span></label>
    <input type="email" name="email" class="form-control" id="email"
        placeholder="{{ __('messages.email') }}" maxlength="190" minlength="5" value="{{ old('email') }}">
</div>