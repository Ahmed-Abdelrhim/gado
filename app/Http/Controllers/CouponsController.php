<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coupon;
use Carbon\Carbon;
use Session;

class CouponsController extends Controller
{
    # coupons page
    public function Coupons()
    {
    	$coupons  = Coupon::latest()->get();
        $current  = carbon::now()->format('Y-m-d');

    	return view('coupons.coupons',compact('coupons','current'));
    }

    # store coupon
    public function StoreCoupon(Request $request)
    {
        $this->validate($request,[
            'name'              => 'required',
            'code'              => 'required',
            'type'              => 'required',
            'total_uses_number' => 'required',
            'user_uses_number'  => 'required',
            'total_amount'      => 'required',
            'discount'          => 'required',
            'end_date'          => 'required'
        ]);

        $coupon = new Coupon;
        $check_code = Coupon::where('code',$request->code)->count();
        if($check_code > 0)
        {
            Session::flash('danger','هذا الكود مستخدم من قبل');
            return back();
        }else{
            $coupon->code          = $request->code;
        }
        $coupon->name              = $request->name;
        $coupon->type              = $request->type;
        $coupon->total_uses_number = $request->total_uses_number;
        $coupon->user_uses_number  = $request->user_uses_number;
        $coupon->user_uses_number  = $request->user_uses_number;
        $coupon->discount          = $request->discount;
        $coupon->total_amount      = $request->total_amount;
        $coupon->end_date          = $request->end_date;
        $coupon->save();

        MakeReport('بإضافة كوبون جديد '.$coupon->name);
        Session::flash('success','تم حفظ الكوبون');
        return back();
    }

    # store coupon
    public function UpdateCoupon(Request $request)
    {
        $this->validate($request,[
            'edit_name'              => 'required',
            'edit_code'              => 'required',
            'edit_type'              => 'required',
            'edit_total_uses_number' => 'required',
            'edit_user_uses_number'  => 'required',
            'edit_total_amount'      => 'required',
            'edit_discount'          => 'required',
            'edit_end_date'          => 'required'
        ]);

        $coupon = Coupon::findOrFail($request->id);
        $coupon->name              = $request->edit_name;
        $coupon->code              = $request->edit_code;
        $coupon->type              = $request->edit_type;
        $coupon->total_uses_number = $request->edit_total_uses_number;
        $coupon->user_uses_number  = $request->edit_user_uses_number;
        $coupon->total_amount      = $request->edit_total_amount;
        $coupon->discount          = $request->edit_discount;
        $coupon->end_date          = $request->edit_end_date;
        $coupon->save();

        MakeReport('بتحديث كوبون '.$coupon->name);
        Session::flash('success','تم حفظ التعديلات');
        return back();
    }

    # delete coupon
    public function DeleteCoupon($id)
    {
    	$coupon = Coupon::findOrFail($id);
        MakeReport('بحذف كوبون '.$coupon->code);
    	$coupon->delete();
        Session::flash('success','تم حذف الكوبون');
        return back();
    }
}
