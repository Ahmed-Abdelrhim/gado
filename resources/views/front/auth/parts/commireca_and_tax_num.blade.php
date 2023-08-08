<div class="col-md-12 mb-3">
    <label for="commercial_registration_num" class="form-label">{{ __('messages.d_num') }}<span>*</span></label>
    <input type="text" name="commercial_registration_num" class="form-control"
        id="commercial_registration_num" placeholder="{{ __('messages.d_num') }}" maxlength="190" value="{{ request()->commercial_registration_num }}">
</div>

<div class="col-md-12 mb-3">
    <label for="tax_card_num" class="form-label">{{ __('messages.tex_num') }}<span>*</span></label>
    <input type="text" name="tax_card_num" class="form-control"
        id="tax_card_num" placeholder=">{{ __('messages.tex_num') }}" maxlength="190" value="{{ request()->tax_card_num }}">
</div>