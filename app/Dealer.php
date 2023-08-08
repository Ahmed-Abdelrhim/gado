<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Dealer extends Authenticatable
{
    use HasFactory;
    protected $table = 'dealers';
    public function Orders()
    {
        return $this->hasMany('App\Order','dealer_id','id');
    }
    public function ProComments()
    {
        return $this->hasMany('App\Pro_Comments','dealer_id','id');
    }
    public function ProLikes()
    {
        return $this->hasMany('App\Pro_Like','dealer_id','id');
    }
}
