<?php

namespace App\Http\Controllers\front\customer\auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Customer;
use App\Order;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
//use Session;
//use Auth;

class CustomerAuthController extends Controller
{
    use AuthenticatesUsers;
    
    protected $redirectTo = '/login';

    public function __construct()
    {
       $this->middleware('customer_guest', ['except' => 'Logout']);
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

        $customer = Customer::where('phone',$request->phone)->first();
        if($customer){
            if($customer->active != '1'){
                Session::flash('danger',' هذا الحساب محظور');
                return back();
            }else{
                if(auth()->guard('customer')->attempt(['phone' => $phone, 'password' => $request->password],$remember))
                {
                    $customer = Customer::where('phone',$request->phone)->first();
                    $customer->ip               = $request->ip();
                    $customer->save();
        
                    $order    = Order::where('ip',$customer->ip)->first();
                    if($order)
                    {
                        $order->customer_id =  $customer->id ;
                        $order->customer_type =  'c' ;
                        $order->ip =  null ;
                        $order->save();
                    }
                   // return redirect('/');
                   if(empty(session()->get('url.intended'))){
                         return redirect('/');
                   }
                    
                   return redirect(session()->get('url.intended'));
                }else
                {
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
            'phone'   => 'required|min:11|max:11|unique:customers,phone'
        ]);

        # check if phone trying register before
        $customer = Customer::query()->where('active_phone',$request->phone)->first();
        $code = rand(1111,9999);
        $msg ='رمز التحقق: '.$code;
        if($customer)
        {
            $customer->code             = $code;
            $customer->ip               = $request->ip();
            $customer->remember_token   = 'c'.date('d-m-y').time().Str::random(50);
            $customer->active           = '0';
            $customer->save();
            send_mobile_sms($request->phone, $msg);
            Session::flash('success','هذا الحساب موجود بالفعل');
        }else{
            $customer = new Customer;
            $customer->active_phone     = $request->phone;
            $customer->ip               = $request->ip();
            $customer->code             = $code;
            $customer->active           = '0';
            $customer->remember_token   = 'c'.date('d-m-y').time().Str::random(50);
            $customer->save();
            send_mobile_sms($request->phone, $msg);
        }
        $url = url('verify-code?').'phone='.$request->phone.'&token='.$customer->remember_token;
        return redirect($url);
    }

    # register
    public function Register()
    {
        return view('front.auth.customer.register.register');
    }

    # store customer
    public function StoreCustomer(Request $request)
    {
        $this->validate($request,[
            'name'     => 'required|min:10|max:50',
            'email'    => 'required|min:5|email|max:190|unique:customers,email',
            'password' => 'required|confirmed|min:6|max:190',
            'token'    => 'required',
        ]);

        $customer = Customer::where('remember_token',$request->token)->first();
        if(!$customer)
        {
            return $this->SomethingWentWrong();
        }
        $customer->name           = $request->name;
        $customer->email          = $request->email;
        $customer->ip             = $request->ip();
        $customer->phone          = $customer->active_phone;
        $customer->active         = '1';
        $customer->password       = bcrypt($request->password);
        $customer->remember_token = null;
        $customer->save();
        Session::flash('success','تم التسجيل بنجاح ،قم بتسجل الدخول الأن ');
        return redirect()->route('front.login');
    }

    public function Logout()
    {
        if(Auth::guard('customer')->check())
        {
            Auth::guard('customer')->logout();
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
