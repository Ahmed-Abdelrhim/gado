<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\front\customer\auth\CustomerAuthController;

Route::group(['middleware' => ['web','customer']], function() {


});

Route::group(['middleware' => ['web']], function() {
    
    /************  REGISTER  ***********/

    # verify send code
    // Route::post('customer/verify-send-code','front\customer\auth\CustomerAuthController@VerifySendCode')->name('customer.verify_send_code');
    Route::post('customer/verify-send-code',[CustomerAuthController::class,'VerifySendCode'])->name('customer.verify_send_code');


    # register
    Route::get('customer/register','front\customer\auth\CustomerAuthController@Register')->name('customer.register');
    # store customer
    Route::post('customer/store/customer','front\customer\auth\CustomerAuthController@StoreCustomer')->name('customer.store_customer');

    /************  LOGIN  ***********/

    # check auth
    Route::post('customer/check/auth','front\customer\auth\CustomerAuthController@CheckAuth')->name('customer.check_auth');
    # logout
    Route::get('customer/logout','front\customer\auth\CustomerAuthController@Logout')->name('customer.logout');

    /************  PROFILE  ***********/

    # profile
    Route::get('customer/profile','front\customer\profile\ProfileController@Index')->name('customer.profile');
    # update
    Route::post('customer/update-profile','front\customer\profile\ProfileController@Update')->name('customer.update_profile');
    # update password
    Route::post('customer/update-password','front\customer\profile\ProfileController@UpdatePassword')->name('customer.update_password');

    /************  PASSWORD  ***********/

    # verify phone and send code
    Route::post('customer/verify-phone','front\customer\auth\PasswordController@VerifyPhone')->name('customer.verify_phone');

    

});
