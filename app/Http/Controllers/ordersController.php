<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Carbon\Carbon;
use App\Cart;
use App\Order;
use App\Order_Product;
use App\Customer;
use App\Dealer;
use App\Order_info;
use App\Setting;
use Session;
use URL;
use View;
use DB;

class ordersController extends Controller
{
    # orders page
    public function orders()
    {
        $Orders = Order::query()
            ->where('pay_type', '!=', null)
            ->with([
                'OrderProducts' => function ($query) {
                    $query->select('id', 'product_id', 'order_id');
                },
                'OrderProducts.Product' => function ($query) {
                    $query->select('id', 'name_en', 'name_ar');
                }
            ])
            ->latest()
            ->get();
    	return view('orders.orders',compact('Orders'));
    }
    # edit
    public function Edit($id)
    {
        $ord = Order::query()->where('id',$id)->with('OrderProducts.Product','Order_info')->latest()->firstOrFail();
        $setting = Setting::query()->first();
        return view('orders.edit_order',compact('ord','setting'));
    }

    # store order
    public function Updateorders(Request $request)
    {
        $order = Order::findOrFail($request->id);
        $ord = Order_info::where('order_id',$request->id)->latest()->first();
        
        if($order->pay_type == 1){
            $order->status     = $request->status;
            $order->save();
        }else{

            if($request->pay_status == 1){
                $order->status     = 1;
                $order->pay_status     = $request->pay_status;
                $order->save();
                $msg ='عزيزي '.$ord->name_first . ' عذرا لم يتم دفع قيمة الطلب الرجاء إعادة المحاولة ' . URL::to('create-checkout-session?id='. $order->id);
                send_mobile_sms($ord->phone, $msg);
 
            }else{
                $order->pay_status     = $request->pay_status;
                $order->status     = $request->status;
                $order->save();
                $msg ='عزيزي '.$ord->name_first . ' تم دفع قيمة الطلب سيصل إليك فى أسرع وقت ';
                send_mobile_sms($ord->phone, $msg);
            }
           
        }
        

        MakeReport('بتحديث طلب ');
        Session::flash('success','تم حفظ التعديلات');
        return back();
    }

    # delete order
    public function Deleteorder($id)
    {
    	$order = Order::findOrFail($id);
        MakeReport('بحذف طلب '.$order->id);
    	$order->delete();
        Session::flash('success','تم حذف الطلب');
        return back();
    }

    # delete orders
    public function Deleteorders()
    {
        
        $Orders  = Order::latest()->get();
        foreach($Orders as $val){
            $val->delete();
        }
        
        MakeReport('بحذف الطلبات ');
        
        Session::flash('success','تم حذف الطلبات');
        return back();
    }
}
//    	return $Orders  = Order::query()
//            ->where('pay_type','!=',null)
//            ->with('OrderProducts.Product:id,name_ar,name_en')
//            //:id,name_ar,name_en
//            ->latest()
//            ->get();