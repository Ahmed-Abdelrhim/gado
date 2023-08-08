<div class="col-md-12 mb-3">
    <label for="mobile" class="form-label"> {{ __('messages.Mobile_number') }} <span>*</span></label>
    <input type="tel" name="phone" class="form-control" id="mobile"
        placeholder="{{ __('messages.Mobile_number') }}" maxlength="11" minlength="11" required>
</div>
<div class="col-md-12">
    <button type="submit" class="btn-animation-2 w-100">
    {{ __('messages.create_ac') }}
    </button>
</div>