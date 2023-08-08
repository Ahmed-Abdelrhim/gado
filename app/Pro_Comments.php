<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pro_Comments extends Model
{
    use HasFactory;
    protected $table ='pro_comments';

    public function Customer()
    {
        return $this->belongsTo('App\Customer', 'customer_id', 'id');
    }
    public function Dealer()
    {
        return $this->belongsTo('App\Dealer', 'dealer_id', 'id');
    }

    public function Product()
    {
        return $this->belongsTo('App\Product', 'product_id', 'id');
    }
}
