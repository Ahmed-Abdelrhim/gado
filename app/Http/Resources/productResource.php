<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Product;
use App\Pannar;
use App\Division;
use App\Cart;
use App\Order;
use App\Order_Product;
use App\Customer;
use App\Dealer;
use App\Order_info;
use App\Email;
use App\Pro_Comments;
use App\Setting;
use App\Category;
use Session;
use Auth;
use App\Pro_Like;
use App\Inbox;
use App\Product_Category;
use App\traits\N_COUPONS;
use App\Coupon;
use Carbon\Carbon;
use App;
use View;
use DB;
use URL;
use Validator;
class productResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if(!is_null($request->header('Authorization'))){
            $token = $request->header('Authorization'); 
            $token = explode(' ',$token);
            if(count( $token) == 2){
                if($request->header('kind') == 'c'){
                    $price_new = $this->price_discount;

                    $user_id  = Customer::where('api_token',$token[1])->first();

                    $lik = Pro_Like::where('customer_id',$user_id)->where('product_id',$this->id)->latest()->first();
                    if(!$lik)
                    {
                        $fav = false;
                    }else{
                        $fav = true;
                    }
                }elseif($request->header('kind') == 'd'){
                    $price_new = $this->dealer_price;
                    $user_id  = Dealer::where('api_token',$token[1])->first();

                    $lik = Pro_Like::where('dealer_id',$user_id)->where('product_id',$this->id)->latest()->first();
                    if(!$lik)
                    {
                        $fav = false;
                    }else{
                        $fav = true;
                    }
                }

            }else{
                $price_new = $this->price_discount;
                $fav = false;
            }
          
            
      
        }else{
            $fav = false;
            $price_new = $this->price_discount;
        }


        if (is_null($request->header("Accept-Language"))) {
            $name = $this->name_ar;
            
        }elseif ($request->header("Accept-Language") == 'ar') {
            $name = $this->name_ar;
        }else{
            $name = $this->name_en;
        }
        return [
            'id' => $this->id,
            'rate' => $this->rate,
            'rate_num' => count($this->ProComments),
            'image' => URL::to($this->card_image),
            'discount' => (1 - ($this->price_discount / $this->price)) * 100,
            'name' => $name,
            'price_new' => $price_new,
            'fav' => $fav,

           
        ];
    }
}
