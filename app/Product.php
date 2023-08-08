<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Pro_Like;
use URL;
use Auth;
class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $appends = [
        'card_image',
        'categories_ids',
    ];

    public function getCardImageAttribute()
    {
        if(is_null($this->image))
        {
            if(count($this->Images) < 1)
            {
                return URL::to('uploads/products_images/'.$this->image);
            }else{
                return URL::to('uploads/products_images/'.$this->Images[0]->image);
            }
           
        }else{
            return URL::to('uploads/products_images/'.$this->image);
        }
    }

    public function getCategoriesIdsAttribute()
    {
        return $this->Categories->pluck('category_id')->toArray();
    }

    public function Images()
    {
        return $this->hasMany('App\Product_Image','product_id','id');
    }

    public function ProTypes()
    {
        return $this->hasMany('App\Pro_Types','product_id','id');
    }

    public function ProComments()
    {
        return $this->hasMany('App\Pro_Comments','product_id','id');
    }
    public function Categories()
    {
        return $this->hasMany('App\Product_Category','product_id','id');
    }

    public function Orders()
    {
        return $this->hasMany('App\Order','product_id','id');
    }
    public function ProLikes()
    {
        return $this->hasMany('App\Pro_Like','product_id','id');
    }


    public function ProLis()
    {

        if(Auth::guard('dealer')->check())
        {
            $user_id  = Auth::guard('dealer')->user()->id;
            $lik = Pro_Like::where('dealer_id',$user_id)->where('product_id',$this->id)->latest()->first();
        }elseif(Auth::guard('customer')->check()){
            $user_id  = Auth::guard('customer')->user()->id;
            $lik = Pro_Like::where('customer_id',$user_id)->where('product_id',$this->id)->latest()->first();
        }else{
            $lik = null;
        }

        return  $lik;
    }
}
