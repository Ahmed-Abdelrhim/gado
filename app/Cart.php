<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
       //
    protected $table = 'carts';

    public function Product()
    {
        return $this->belongsTo('App\Product', 'product_id', 'id');
    }

    public function Order()
    {
        return $this->belongsTo('App\Order', 'order_id', 'id');
    }

}
