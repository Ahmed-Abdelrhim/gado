<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Customer;
use App\Dealer;
use Session;

class PasswordController extends Controller
{
    # verify phone page
    public function VerifyPhone()
    {
        return view('front.auth.password.verify_phone');
    }

    # verify code page
    public function VerifyCode()
    {
        return view('front.auth.password.verify_code');
    }

    # check code and user type
    public function CheckCode(Request $request)
    {
        $token = $request->token;
        $code  = '';

        # check of length and collect code
        if(is_array($request->code) && count($request->code) == 4)
        {
            foreach($request->code as $co)
            {
             $code .=$co;
            }
        }else{
            return $this->SomethingWentWrong();
        }

        # check if token exist
        if(is_null($token))
        {
            return $this->SomethingWentWrong();
        }

        # get user type from token
        $user_type = str_split($token)[0];

        # check of user type
        if($user_type === 'c')
        {
            $customer = Customer::where([['remember_token',$token],['code',$code]])->first();
            if(!$customer)
            {
                return $this->IncorrectCode();
            }

            $customer->remember_token = $user_type.date('d-m-y').time().Str::random(50);
            $customer->code        = null;
            $customer->save();
            $url = url('forget-password/new-password').'?token='.$customer->remember_token.'&phone='.$customer->active_phone;
            return redirect($url);

        }elseif($user_type === 'd')
        {
            $dealer = Dealer::where([['remember_token',$token],['code',$code]])->first();
            if(!$dealer)
            {
                return $this->IncorrectCode();
            }

            $dealer->remember_token = $user_type.date('d-m-y').time().Str::random(50);
            $dealer->code        = null;
            $dealer->save();
            $url = url('forget-password/new-password').'?token='.$dealer->remember_token.'&phone='.$dealer->active_phone;
            return redirect($url);

        }else{
            return $this->SomethingWentWrong();
        }
    }

    # new password page
    public function NewPassword()
    {
        return view('front.auth.password.new_password');
    }

    # update password
    public function UpdatePassword(Request $request)
    {
        $this->validate($request,[
            'password'       => 'required|confirmed|min:6|max:190'
        ]);

        $token = $request->token;

        # check if token exist
        if(is_null($token))
        {
            return $this->SomethingWentWrong();
        }

        # get user type from token
        $user_type = str_split($token)[0];

        # check of user type
        if($user_type === 'c')
        {
            $data = Customer::where('remember_token',$request->token)->first();
            $data->password = bcrypt($request->password); 
            $data->save(); 
            Session::flash('success','تم تحديث كلمة المرور بنجاح ، قم بتسجيل الدخول الأن'); 
            return redirect('/login');
        }elseif($user_type === 'd')
        {
            $data = Dealer::where('remember_token',$request->token)->first();
            $data->password = bcrypt($request->password); 
            $data->save();   
            Session::flash('success','تم تحديث كلمة المرور بنجاح ، قم بتسجيل الدخول الأن'); 
            return redirect('/login');  
        }else{
            return $this->SomethingWentWrong();
        }
    }

    # Something went wrong
    public function SomethingWentWrong()
    {
        Session::flash('danger','حدث خطأ ما !');
        return back();
    }

    # incorrect code
    public function IncorrectCode()
    {
        Session::flash('danger','الكود الذي أدخلتة غير صحيح !');
        return back();
    }

}
