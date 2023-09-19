<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Order_info;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;
    public function Carts()
    {
        return $this->hasMany('App\Cart','order_id','id');
    }
    public function OrderProducts()
    {
        return $this->hasMany('App\Order_Product','order_id','id');
    }

    // public function Order_info()
    // {
    //     return $this->hasMany('App\Order_info','order_id','id');
    // }

    public function Order_inf()
    {
        return Order_info::where('order_id',$this->id)->first();
    }
    
//      public function Order_info()
//    {
//        return $this->belongsTo(Order_info::class , 'order_id','id');
//    }

    public function Order_info()
    {
        return $this->hasOne(Order_info::class , 'order_id','id');
    }
}
