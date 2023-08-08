<?php

namespace App\Http\Controllers\front\dealer\auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Dealer;
use Session;

class PasswordController extends Controller
{
    # verify phone and send code
    public function VerifyPhone(Request $request)
    {
        $this->validate($request,[
            'phone' => 'required|exists:dealers,phone',
        ]);

        $data = Dealer::where('phone',$request->phone)->first();

        $code = rand(1111,9999);
        $msg ='رمز التحقق: '.$code;

        $data->code             = $code;
        $data->remember_token   = 'd'.date('d-m-y').time().Str::random(50);
        $data->save();
        send_mobile_sms($data->phone, $msg);
     
        $url = url('forget-password/verify-code?').'phone='.$request->phone.'&token='.$data->remember_token;
        return redirect($url);

    }
}
