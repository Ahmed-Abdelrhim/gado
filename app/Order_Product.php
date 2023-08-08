<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_Product extends Model
{
    protected $table = 'order_products';

    public function Product()
    {
        return $this->belongsTo('App\Product', 'product_id', 'id');
    }
}
