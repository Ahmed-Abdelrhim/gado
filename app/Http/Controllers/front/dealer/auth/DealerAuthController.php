<?php

namespace App\Http\Controllers\front\dealer\auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Str;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Dealer;
use App\Order;
//use Session;
use Illuminate\Support\Facades\Session;
//use Auth;
use Illuminate\Support\Facades\Auth;

class DealerAuthController extends Controller
{
    use AuthenticatesUsers;
    
    protected $redirectTo = '/login';

    public function __construct()
    {
       $this->middleware('dealer_guest', ['except' => 'Logout']);
    }

    # check auth
    public function CheckAuth(Request $request)
    {
        $this->validate($request, [
            'phone'     => 'required',
            'password'  => 'required',
        ]);
        $phone = $request->phone;
        $remember = $request->has('remember') ? true : false; 
        $customer = Dealer::query()->where('phone',$request->phone)->first();
        if($customer) {
            if($customer->active != '1') {
                // Session::flash('danger',' يتم مراجعة حسابك!  سيتم التواصل معك خلال 48 ساعة');
                Session::flash('danger',' هذا الحساب قيد المراجعة');
                return back();
            } else {
                if(auth()->guard('dealer')->attempt(['phone' => $phone, 'password' => $request->password],$remember)) {
                    $customer = Dealer::query()->where('phone',$request->phone)->first();
                    $customer->ip               = $request->ip();
                    $customer->save();
                    return redirect('/');
                } else {
                   Session::flash('danger','يوجد خطأ في بيانات الدخول ! ');
                   return back();
                }
            }
            
        }else{
            Session::flash('danger','يوجد خطأ في بيانات الدخول ! ');
            return back();
        }
    }

    # verify send code
    public function VerifySendCode(Request $request)
    {
        $this->validate($request,[
            'phone'   => 'required|min:11|max:11|unique:dealers,phone'
        ]);

        # check if phone trying register before
        $customer = Dealer::where('active_phone',$request->phone)->first();
        $code = rand(1111,9999);
        $msg ='رمز التحقق: '.$code;
        if($customer)
        {
            $customer->code             = $code;
            $customer->remember_token   = 'd'.date('d-m-y').time().Str::random(50);
            $customer->ip               = $request->ip();
            $customer->active           = '0';
            $customer->save();
            send_mobile_sms($request->phone, $msg);
        }else{
            $customer = new Dealer;
            $customer->active_phone     = $request->phone;
            $customer->code             = $code;
            $customer->ip               = $request->ip();
            $customer->active           = '0';
            $customer->remember_token   = 'd'.date('d-m-y').time().Str::random(50);
            $customer->save();
            send_mobile_sms($request->phone, $msg);
        }
    
        $url = url('verify-code?').'phone='.$request->phone.'&token='.$customer->remember_token;
        return redirect($url);
    }

    # register
    public function Register()
    {
        return view('front.auth.dealer.register.register');
    }

    # store customer
    public function StoreDealer(Request $request)
    {
        $this->validate($request,[
            'name'     => 'required|min:5|max:50',
            'email'    => 'required|min:5|email|max:190|unique:dealers,email',
            'password' => 'required|confirmed|min:6|max:190',
            'token'    => 'required',
        ]);

        $customer = Dealer::query()->where('remember_token',$request->token)->first();
        if(!$customer)
        {
            return $this->SomethingWentWrong();
        }
        $customer->name                         = $request->name;
        $customer->email                        = $request->email;
        $customer->phone                        = $request->phone;
        $customer->ip                           = $request->ip();
        $customer->commercial_registration_num  = $request->commercial_registration_num;
        $customer->tax_card_num                 = $request->tax_card_num;
        $customer->active                       = '0';
        $customer->password                     = bcrypt($request->password);
        $customer->remember_token               = null;
        $customer->save();
        Session::flash('success','تم التسجيل بنجاح ، سيتم المراجعة الان ');
        return redirect()->route('front.login');
    }

    public function Logout()
    {
        if(Auth::guard('dealer')->check())
        {
            Auth::guard('dealer')->logout();
            return redirect(url('/'));
        }else{
            return redirect(url('/'));
        }
    }

    # Something went wrong
    public function SomethingWentWrong()
    {
        Session::flash('danger','حدث خطأ ما !');
        return back();
    }
}
