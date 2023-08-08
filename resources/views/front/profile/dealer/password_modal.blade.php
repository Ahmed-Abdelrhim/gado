<div dir="" class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="margin-top: 8%">
      <div class="modal-content">
        <div class="modal-header" style="background:#01939B">
          <h5 class="modal-title" id="exampleModalLabel" style="color:#fff"> {{ __('messages.change_Password') }} </h5>
        </div>
        <div class="modal-body">
            <form action="{{ route('dealer.update_password') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-sm-12" style="margin-bottom: 11px">
                      <label for="old_password" class="form-label">   {{ __('messages.old_Password') }} <span class="text-danger">*</span></label>
                        <input type="text" name="old_password" id="old_password" class="form-control" required minlength="6" maxlength="190">
                    </div>
                    <div class="col-sm-6" >
                      <label for="password" class="form-label">   {{ __('messages.new_Password') }} <span class="text-danger">*</span></label>
                        <input type="text" name="password" id="password" class="form-control" required minlength="6" maxlength="190">
                    </div>
                    <div class="col-sm-6" >
                      <label for="password_confirmation" class="form-label">    {{ __('messages.confirm_new_Password') }} <span class="text-danger">*</span></label>
                        <input type="text" name="password_confirmation" id="password_confirmation" class="form-control" required minlength="6" maxlength="190">
                    </div>
                    <button type="submit" class="real_submit" style="display: none"></button>
                </div>
            </form>
        </div>
        <div class="modal-footer" >
          <button type="button" class="btn modal_submit" style="background:#01939B;color:#fff;margin: 0;right: -73%;position: relative;"> {{ __('messages.saved') }}</button>
        </div>
      </div>
    </div>
  </div>