<?php
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web','dealer']], function() {


});

Route::group(['middleware' => ['web']], function() {

    /************  REGISTER  ***********/

    # verify send code
    Route::post('dealer/verify-send-code','front\dealer\auth\DealerAuthController@VerifySendCode')->name('dealer.verify_send_code');
    # register
    Route::get('dealer/register','front\dealer\auth\DealerAuthController@Register')->name('dealer.register');
    # store dealer
    Route::post('dealer/store/dealer','front\dealer\auth\DealerAuthController@StoreDealer')->name('dealer.store_dealer');

    /************  LOGIN  ***********/

    # check auth
    Route::post('dealer/check/auth','front\dealer\auth\DealerAuthController@CheckAuth')->name('dealer.check_auth');
    # logout
    Route::get('dealer/logout','front\dealer\auth\DealerAuthController@Logout')->name('dealer.logout');

    /************  PROFILE  ***********/

    # profile
    Route::get('dealer/profile','front\dealer\profile\ProfileController@Index')->name('dealer.profile');
    # update
    Route::post('dealer/update-profile','front\dealer\profile\ProfileController@Update')->name('dealer.update_profile');
    # update password
    Route::post('dealer/update-password','front\dealer\profile\ProfileController@UpdatePassword')->name('dealer.update_password');

    /************  PASSWORD  ***********/

    # verify phone and send code
    Route::post('dealer/verify-phone','front\dealer\auth\PasswordController@VerifyPhone')->name('dealer.verify_phone');

});








