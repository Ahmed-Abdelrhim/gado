<?php

namespace App\Http\Controllers\Api\V1\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\CustomersIndexResource;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required',
            'password' => 'required',
        ]);
        $phone = $request->phone;
        if (auth()->guard('customer')->attempt(['phone' => $phone, 'password' => $request->password])) {


            return new CustomersIndexResource(auth()->guard('customer')->user());

//            $customer = Customer::where('phone',$request->phone)->first();
//            $order    = Order::where('ip',$customer->ip)->first();
//            if($order)
//            {
//                $order->customer_id =  $customer->id ;
//                $order->customer_type =  'c' ;
//                $order->ip =  null ;
//                $order->save();
//            }
//            return redirect('/');
        } else {
//            Session::flash('danger','يوجد خطأ في بيانات الدخول ! ');
//            return back();
        }
    }
}
