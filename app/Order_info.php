<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_info extends Model
{
    protected $table = 'order_info';
    // public function Order()
    // {
    //     return $this->belongsTo('App\Order', 'order_id', 'id');
    // }
    
     public function orders()
    {
        return $this->hasMany('App\Order');
    }
}
