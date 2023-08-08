<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';

    public function Division()
    {
        return $this->belongsTo('App\Division','division_id','id');
    }
    public function ProductCategories()
    {
        return $this->hasMany('App\Product_Category','category_id','id');
    }
}
