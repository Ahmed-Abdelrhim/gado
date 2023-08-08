<?php
namespace App\traits;
use App\Order;
use App\Coupon;
use App\Bill;
use Carbon\Carbon;
use Auth;

trait N_COUPONS {
    function CheckCoupon($coupon_code ,$order_id)
    {
        $coupon = Coupon::where('code',$coupon_code)->first();
        $order  = Order::where('id',$order_id)->first();
    
        # $code_validity
        # $code_date
        # $total_uses
        # $order_has_coupon
        # $user_uses
        # $amount_status

        # check code
        if(!$coupon)
        {
            $code_validity = false;
            $msg = trans('messages.wrong_coupon_code');
            return response()->json([
                'status'   => '0',
                'message'  => $msg,
                'error'    => null,
                'data'    => null,
            ],400);
        }else{
            $code_validity = true;
        }
    
   
    
    
       
    
        
        if($code_validity )
        {
            $data['id']           = $coupon->id;
            $data['coupon_type']  = $coupon->type;
            $data['discount']     = $coupon->discount;
            
            if($coupon->type === 'currency')
            {
                $data['discount_amount'] = $coupon->discount;
            }elseif($coupon->type === 'percent')
            {
                $coupon_discount         = $coupon->discount;
                $calc_discount           = ($order->total * $coupon->discount) / 100 ;
                $data['discount_amount'] =  $calc_discount;
            }
    
            return response()->json([
                'status'   => '1',
                'message'  => 'تم ادخال الكبون',
                'error'    => null,
                'data'     => $data
            ],200);
        }
    }
}

