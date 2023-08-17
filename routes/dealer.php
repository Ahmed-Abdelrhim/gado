<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\front\dealer\auth\DealerAuthController;

Route::group(['middleware' => ['web','dealer']], function() {


});

Route::group(['middleware' => ['web']], function() {

    /************  REGISTER  ***********/

    # verify send code
    // Route::post('dealer/verify-send-code','front\dealer\auth\DealerAuthController@VerifySendCode')->name('dealer.verify_send_code');
    Route::post('dealer/verify-send-code',[DealerAuthController::class,'VerifySendCode'])->name('dealer.verify_send_code');
    # register
    // Route::get('dealer/register','front\dealer\auth\DealerAuthController@Register')->name('dealer.register');
    Route::get('dealer/register',[DealerAuthController::class,'Register'])->name('dealer.register');
    // dealer/register?phone=01152067271
    # store dealer
    // Route::post('dealer/store/dealer','front\dealer\auth\DealerAuthController@StoreDealer')->name('dealer.store_dealer');
    Route::post('dealer/store/dealer',[DealerAuthController::class,'StoreDealer'])->name('dealer.store_dealer');

    /************  LOGIN  ***********/

    # check auth
    // Route::post('dealer/check/auth','front\dealer\auth\DealerAuthController@CheckAuth')->name('dealer.check_auth');
    Route::post('dealer/check/auth',[DealerAuthController::class,'CheckAuth'])->name('dealer.check_auth');


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
// http://127.0.0.1:8000/dealer/register?token=d17-08-231692292216dFsZnMg590GjN2cp8m0psJ6uFFYjSf07ajfTIFwbrFpmAwpSQn&phone=01152067271
