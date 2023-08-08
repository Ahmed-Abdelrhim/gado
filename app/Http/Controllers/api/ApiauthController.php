<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Customer;
use App\Order;
use Validator;
use Illuminate\Support\Str;
use App\Dealer;
use Date;
use URL;
use Image;
use File;
use Auth;
use View;
use Session;

class ApiauthController extends Controller
{
    // Register send code
    public function Register(Request $request)
    {
        //chack kind of user
        if($request->kind == 'c'){
            $validator = Validator::make($request->all(), [
                'active_phone'        => 'required|unique:customers,phone',
            ]);

            foreach ((array) $validator->errors() as $value)
            {
                if(isset($value['active_phone']) && is_null($request->active_phone))
                {
                    $msg = 'phone is required';
                    return response()->json([
                        'message'  => null,
                        'error'    => $msg,
                    ],400);
                }elseif(isset($value['active_phone']) && !is_null($request->active_phone))
                {
                    $msg = 'phone is already exist';
                    return response()->json([
                        'message'  => null,
                        'error'    => $msg,
                    ],400);
                }
            }
    
            //if customer
            $customer = new Customer;
            $customer->active_phone       = $request->active_phone;
            $customer->active           = '0';
            $customer->remember_token   = 'c'.date('d-m-y').time().Str::random(50);
            $customer->ip               = $request->ip();
            $code = rand(1111,9999);
            $msg ='رمز التحقق: '.$code;
            $customer->code     = $code;
            $numbers = $request->active_phone;
            send_mobile_sms($numbers, $msg);
            $customer->save();

        }elseif($request->kind == 'd'){
            $validator = Validator::make($request->all(), [
                'active_phone'        => 'required|unique:dealers,phone',
            ]);

            foreach ((array) $validator->errors() as $value)
            {
                if(isset($value['active_phone']) && is_null($request->active_phone))
                {
                    $msg = 'phone is required';
                    return response()->json([
                        'message'  => null,
                        'error'    => $msg,
                    ],400);
                }elseif(isset($value['active_phone']) && !is_null($request->active_phone))
                {
                    $msg = 'phone is already exist';
                    return response()->json([
                        'message'  => null,
                        'error'    => $msg,
                    ],400);
                }
            }
    
            //if dealer
            $customer = new Dealer;
            $customer->active_phone       = $request->active_phone;
            $customer->remember_token   = 'd'.date('d-m-y').time().Str::random(50);
            $customer->ip               = $request->ip();
            $customer->active           = '0';
            $code = rand(1111,9999);
            $msg ='رمز التحقق: '.$code;
            $customer->code     = $code;
            $numbers = $request->active_phone;
            send_mobile_sms($numbers, $msg);
            $customer->save();
        }

       
      
        $list['active_phone']     = $customer->active_phone;
        $list['code']             = $customer->code;
        $list['kind']             = $request->kind;
        $list['section']          = $request->section;

        return response()->json([
            'message'  => 'Register send code',
            'status'    => 200,
            'data'     => $list
        ],200);

    }
    // Register enter code
    public function RegisterCode(Request $request)
    {
        //chack kind
        if($request->kind == 'c'){

            $validator = Validator::make($request->all(), [
                'code'        => 'required',
            ]);
            $customer = Customer::where('active_phone',$request->phone)->where('code',$request->code)->first();
            
            foreach ((array) $validator->errors() as $value)
            {

                if(isset($value['code']) && is_null($request->code))
                {
                    $msg = 'code is required';
                    return response()->json([
                        'message'  => $msg,
                        'status'    => 400,
                    ],400);
                }elseif(empty($customer))
                {
                    $msg = 'code is wrong';
                    return response()->json([
                        'message'  => $msg,
                        'status'    => 400,
                    ],400);
                }elseif($customer->code != $request->code)
                {
                    $msg = 'code is wrong';
                    return response()->json([
                        'message'  => $msg,
                        'status'    => 400,
                    ],400);
                }
            }

           

        }elseif($request->kind == 'd'){
            $validator = Validator::make($request->all(), [
                'code'        => 'required|unique:dealers',
            ]);
            
            $customer = Dealer::where('active_phone',$request->phone)->where('code',$request->code)->first();
            foreach ((array) $validator->errors() as $value)
            {
                if(isset($value['code']) && is_null($request->code))
                {
                    $msg = 'code is required';
                    return response()->json([
                        'message'  => $msg,
                        'status'    => 400,
                    ],400);
                }elseif(empty($customer))
                {
                    $msg = 'code is wrong';
                    return response()->json([
                        'message'  => $msg,
                        'status'    => 400,
                    ],400);
                }elseif($customer->code != $request->code)
                {
                    $msg = 'code is wrong';
                    return response()->json([
                        'message'  => $msg,
                        'status'    => 400,
                    ],400);
                }
            }
           
    
           
        }

       
      
        $list['code']           = $customer->code;
        $list['active_phone']   = $customer->active_phone;
        $list['id']             = $customer->id;
        $list['kind']           = $request->kind;
        $list['section']        = $request->section;

        return response()->json([
            'message'  => 'Register enter code',
            'status'    => 200,
            'data'     => $list
        ],200);

    }


    // Register enter inf and complate
    public function Registerinfo(Request $request)
    {
        //chack kind
        if($request->kind == 'c'){

            $validator = Validator::make($request->all(), [
                'name'         => 'required',
                'email'        => 'required|unique:customers',
                'phone'        => 'required|unique:customers',
                'password'     => 'required',
                'con_password' => 'required',
            ]);
            
            foreach ((array) $validator->errors() as $value)
            {
                if(isset($value['name']))
                {
                    $msg = 'name is required';
                    return response()->json([
                        'message'  => $msg,
                        'status'    => 400,
                    ],400);
                }elseif(isset($value['email']) && is_null($request->email))
                {
                    $msg = 'email is required';
                    return response()->json([
                        'message'  => $msg,
                        'status'    => 400,
                    ],400);
                }elseif(isset($value['email']) && !is_null($request->email))
                {
                    $msg = 'email is already exist';
                    return response()->json([
                        'message'  => $msg,
                        'status'    => 400,
                    ],400);
                }elseif(isset($value['phone']) && is_null($request->phone))
                {
                    $msg = 'phone is required';
                    return response()->json([
                        'message'  => $msg,
                        'status'    => 400,
                    ],400);
                }elseif(isset($value['phone']) && !is_null($request->phone))
                {
                    $msg = 'phone is already exist';
                    return response()->json([
                        'message'  => $msg,
                        'status'    => 400,
                    ],400);
                }elseif(isset($value['password']))
                {
                    $msg = 'password is required';
                    return response()->json([
                        'message'  => $msg,
                        'status'    => 400,
                    ],400);
                }elseif(isset($value['con_password']))
                {
                    $msg = 'password is not confirm';
                    return response()->json([
                        'message'  => $msg,
                        'status'    => 400,
                    ],400);
                }elseif($request->password != $request->con_password)
                {
                    $msg = 'password is not confirm';
                    return response()->json([
                        'message'  => $msg,
                        'status'    => 400,
                    ],400);
                }
            }
    
            $customer = Customer::where('active_phone',$request->phone)->first();
            $customer->name        = $request->name;
            $customer->email       = $request->email;
            $customer->phone       = $request->phone;
            $customer->password    = bcrypt($request->password);
            $customer->api_token   = Str::random(60);
            $customer->active         = '1';
            $customer->ip          = $request->ip();
            $customer->save();
    
            $list['name']              = $customer->name;
            $list['email']             = $customer->email;
            $list['phone']             = $customer->phone;
            $list['api_token']         = $customer->api_token;
            $list['kind']              = $request->kind;

        

        }elseif($request->kind == 'd'){
            $validator = Validator::make($request->all(), [
                'name'         => 'required',
                'email'        => 'required|unique:dealers',
                'phone'        => 'required|unique:dealers',
                'password'     => 'required',
                'commercial_registration_num' => 'required',
                'tax_card_num'     => 'required',
                'con_password'     => 'required',

            ]);
            
            foreach ((array) $validator->errors() as $value)
            {
                if(isset($value['name']))
                {
                    $msg = 'name is required';
                    return response()->json([
                        'message'  => $msg,
                        'status'    => 400,
                    ],400);
                }elseif(isset($value['email']) && is_null($request->email))
                {
                    $msg = 'email is required';
                    return response()->json([
                        'message'  => $msg,
                        'status'    => 400,
                    ],400);
                }elseif(isset($value['email']) && !is_null($request->email))
                {
                    $msg = 'email is already exist';
                    return response()->json([
                        'message'  => $msg,
                        'status'    => 400,
                    ],400);
                }elseif(isset($value['phone']) && is_null($request->phone))
                {
                    $msg = 'phone is required';
                    return response()->json([
                        'message'  => $msg,
                        'status'    => 400,
                    ],400);
                }elseif(isset($value['phone']) && !is_null($request->phone))
                {
                    $msg = 'phone is already exist';
                    return response()->json([
                        'message'  => $msg,
                        'status'    => 400,
                    ],400);
                }elseif(isset($value['password']))
                {
                    $msg = 'password is required';
                    return response()->json([
                        'message'  => $msg,
                        'status'    => 400,
                    ],400);
                }elseif(isset($value['tax_card_num']))
                {
                    $msg = 'tax card num is required';
                    return response()->json([
                        'message'  => $msg,
                        'status'    => 400,
                    ],400);
                }elseif(isset($value['commercial_registration_num']))
                {
                    $msg = 'commercial registration num is required';
                    return response()->json([
                        'message'  => $msg,
                        'status'    => 400,
                    ],400);
                }elseif(isset($value['con_password']))
                {
                    $msg = 'password is not confirm';
                    return response()->json([
                        'message'  => $msg,
                        'status'    => 400,
                    ],400);
                }elseif($request->password != $request->con_password)
                {
                    $msg = 'password is not confirm';
                    return response()->json([
                        'message'  => $msg,
                        'status'    => 400,
                    ],400);
                }
            }
    
            $customer = Dealer::where('active_phone',$request->phone)->first();
            $customer->name        = $request->name;
            $customer->email       = $request->email;
            $customer->phone       = $request->phone;
            $customer->password    = bcrypt($request->password);
            $customer->ip               = $request->ip();
            $customer->commercial_registration_num  = $request->commercial_registration_num;
            $customer->tax_card_num                 = $request->tax_card_num;
            $customer->active                       = '0';
            $customer->remember_token               = null;
            $customer->api_token   = Str::random(60);
            $customer->save();
    
            $list['name']              = $customer->name;
            $list['email']             = $customer->email;
            $list['phone']             = $customer->phone;
            $list['api_token']         = $customer->api_token;
            $list['kind']              = $request->kind;
           
        
    
        
        }
        $list['section']        = $request->section;

        return response()->json([
            'message'  => 'Register enter inf and complate',
            'status'    => 200,
            'data'     => $list
        ],200);

    }


    // login
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone'        => 'required',
            'password'     => 'required',
        ]);
        foreach ((array) $validator->errors() as $value)
		{
		    if(isset($value['phone']))
            {
                $msg = 'phone  is required';
                return response()->json([
                    'message'  => $msg,
                    'status'    => 400,
                ],400);
        
            }elseif(isset($value['password']))
            {
                $msg = 'password is required';
                return response()->json([
                    'message'  => $msg,
                    'status'    => 400,
                ],400);
            }
        }
        //if user customer
        if($request->kind == 'c'){
            $customer = Customer::where('phone',$request->phone)->first();
            if(!$customer){
                $msg = 'رقم العميل غير موجود';
                return response()->json([
                    'message'  => $msg,
                    'status'    => 400,
                ],400);
            }else{
                
    
                if (Auth::guard('customer')->attempt(['phone' => $request->phone, 'password' => $request->password])) {
    
                    $customer->api_token   = Str::random(60);
                    $customer->ip               = $request->ip();
                    $customer->save();

                    //order  ip
                    $order    = Order::where('ip',$customer->ip)->first();
                    if($order)
                    {
                        $order->customer_id =  $customer->id ;
                        $order->customer_type =  'c' ;
                        $order->ip =  null ;
                        $order->save();
                    }
    
                    $list['name']           = $customer->name;
                    $list['email']          = $customer->email;
                    $list['phone']          = $customer->phone;
                    $list['api_token']      = $customer->api_token;
                    $list['kind']           = $request->kind;
                    $list['section']        = $request->section;
    
                    if($customer->active == '0'){
                        $msg = '   هذا الحساب مححظور';
                        return response()->json([
                            'status'    => 400,
                            'message'    => $msg,
                        ],400);
                    }else{
                        return response()->json([
                            'message'  => 'تم التسجيل',
                            'status'    => 200,
                            'data'     => $list
                        ],200);
                    }
    
                }else{
    
                    $msg = 'كلمة السر خطأ';
                    return response()->json([
                        'message'  => $msg,
                        'status'    => 400,
                    ],400);
                }
            }
        }elseif($request->kind == 'd'){
            $customer = Dealer::where('phone',$request->phone)->first();
            if(!$customer){
                $msg = 'رقم العميل غير موجود';
                return response()->json([
                    'message'  => $msg,
                    'status'    => 400,
                ],400);
            }else{
                
    
                if (Auth::guard('dealer')->attempt(['phone' => $request->phone, 'password' => $request->password])) {
    
                    $customer->api_token   = Str::random(60);
                    $customer->ip               = $request->ip();
                    $customer->save();

                  
    
                    $list['name']              = $customer->name;
                    $list['email']             = $customer->email;
                    $list['phone']             = $customer->phone;
                    $list['api_token']         = $customer->api_token;
                    $list['kind']              = $request->kind;
                    $list['section']           = $request->section;
                    if($customer->active == '0'){
                        $msg = '   سيتم التواصل معك خلال 48 ساعة';
                        return response()->json([
                            'status'    => 400,
                            'message'    => $msg,
                        ],400);
                    }else{
                        return response()->json([
                            'message'  => 'تم التسجيل',
                            'status'    => 200,
                            'data'     => $list
                        ],200);
                    }
                    
    
                }else{
    
                    $msg = 'كلمة السر خطأ';
                    return response()->json([
                        'status'    => 400,
                        'message'    => $msg,
                    ],400);
                }
            }
        }
      
    }

    // verify password
    public function Verifypassword(Request $request)
    {
        //chack kind
        if($request->kind == 'c'){

            $validator = Validator::make($request->all(), [
                'phone'        => 'required',
            ]);
            foreach ((array) $validator->errors() as $value)
            {
                if(isset($value['phone']))
                {
                    $msg = 'phone  is required';
                    return response()->json([
                        'status'    => 400,
                        'message'    => $msg,
                    ],400);
            
                }
            }
    
            $customer = Customer::where('phone',$request->phone)->first();
            if(!$customer){
                $msg = 'رقم العميل غير موجود';
                return response()->json([
                    'status'    => 400,
                    'message'    => $msg,
                ],400);
            }else{
                $code = rand(1111,9999);
                $msg ='رمز التحقق: '.$code;
        
                $customer->code             = $code;
                $customer->remember_token   = 'c'.date('d-m-y').time().Str::random(50);
                $customer->api_token   = Str::random(60);
                $customer->ip               = $request->ip();
                $customer->save();
                send_mobile_sms($customer->phone, $msg);
            }
    
           
    
        }else if($request->kind == 'd'){
            $validator = Validator::make($request->all(), [
                'phone'        => 'required',
            ]);
            foreach ((array) $validator->errors() as $value)
            {
                if(isset($value['phone']))
                {
                    $msg = 'phone  is required';
                    return response()->json([
                        'status'    => 400,
                        'message'    => $msg,
                    ],400);
            
                }
            }
    
            $customer = Dealer::where('phone',$request->phone)->first();
            if(!$customer){
                $msg = 'رقم العميل غير موجود';
                return response()->json([
                    'status'    => 400,
                    'message'    => $msg,
                ],400);
            }else{
                $code = rand(1111,9999);
                $msg ='رمز التحقق: '.$code;
        
                $customer->code             = $code;
                $customer->remember_token   = 'c'.date('d-m-y').time().Str::random(50);
                $customer->api_token   = Str::random(60);
                $customer->ip               = $request->ip();
                $customer->save();
                send_mobile_sms($customer->phone, $msg);
            }
        
        }

        $list['phone']          = $request->phone;
        $list['code']           = $code;
        $list['kind']           = $request->kind;
        $list['section']        = $request->section;
        $list['api_token']      = $customer->api_token;



        return response()->json([
            'status'    => 200,
            'message'    => 'Verify password',
            'data'     => $list
        ],200);
    

    }

   
    // enter new password
    public function newpassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'code'        => 'required',
            'password'     => 'required',
            'con_password' => 'required',
        ]);
        foreach ((array) $validator->errors() as $value)
        {
            if(isset($value['code']))
            {
                $msg = 'code  is required';
                return response()->json([
                    'status'    => 400,
                    'message'    => $msg,
                ],400);
        
            }elseif(isset($value['password']))
            {
                $msg = 'password is required';
                return response()->json([
                    'status'    => 400,
                    'message'    => $msg,
                ],400);
            }elseif(isset($value['con_password']))
            {
                $msg = 'password is not confirm';
                return response()->json([
                    'status'    => 400,
                    'message'    => $msg,
                ],400);
            }elseif($request->password != $request->con_password)
            {
                $msg = 'password is not confirm';
                return response()->json([
                    'status'    => 400,
                    'message'    => $msg,
                ],400);
            }
        }

        //chack kind
        if($request->kind == 'c'){

            $customer = Customer::where('code',$request->code)->first();
            if(!$customer){
                $msg = 'هذا العميل غير موجود';
                return response()->json([
                    'status'    => 400,
                    'message'    => $msg,
                ],400);
            }else{
           
                $customer->password    = bcrypt($request->password);
                $customer->api_token   = Str::random(60);
                $customer->ip               = $request->ip();
                $customer->save();
            }
    
           
    
        }elseif($request->kind == 'd'){
            $customer = Dealer::where('code',$request->code)->first();
            if(!$customer){
                $msg = 'هذا العميل غير موجود';
                return response()->json([
                    'status'    => 400,
                    'message'    => $msg,
                ],400);
            }else{
           
                $customer->password    = bcrypt($request->password);
                $customer->api_token   = Str::random(60);
                $customer->ip               = $request->ip();
                $customer->save();
            }
        
        }

        $list['phone']          = $customer->phone;
        $list['code']           = $customer->code;
        $list['kind']           = $request->kind;
        $list['section']        = $request->section;
        $list['api_token']      = $customer->api_token;



        return response()->json([
            'status'    => 200,
            'message'    => 'enter new password',
            'data'     => $list
        ],200);
    

    }
   
}
