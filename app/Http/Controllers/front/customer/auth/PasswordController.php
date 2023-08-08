<?php

namespace App\Http\Controllers\front\customer\auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Customer;
use Session;

class PasswordController extends Controller
{
    # verify phone and send code
    public function VerifyPhone(Request $request)
    {
        $this->validate($request,[
            'phone' => 'required|exists:customers,phone',
        ]);

        $data = Customer::where('phone',$request->phone)->first();

        $code = rand(1111,9999);
        $msg ='رمز التحقق: '.$code;

        $data->code             = $code;
        $data->remember_token   = 'c'.date('d-m-y').time().Str::random(50);
        $data->save();
        send_mobile_sms($data->phone, $msg);
   
        $url = url('forget-password/verify-code?').'phone='.$request->phone.'&token='.$data->remember_token;
        return redirect($url);

    }
}
