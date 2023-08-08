<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Model;

class Customer extends Authenticatable
{

    protected $guarded = [];
    use HasFactory;


    public function ProComments()
    {
        return $this->hasMany('App\Pro_Comments', 'customer_id', 'id');
    }

    public function ProLikes()
    {
        return $this->hasMany('App\Pro_Like', 'customer_id', 'id');
    }

    public function Orders()
    {
        return $this->hasMany('App\Order', 'customer_id', 'id');
    }
}
