<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
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
use App\Http\Resources\productResource;
use Validator;

class ApiProductsController extends Controller
{

    # section page
    public function section(Request $request)
    {
        $id = $request->input("id");
        $type = $request->input("type");
        $search = $request->input("search");

        $data = Division::where('id',$request->header("section"))->with('Categories')->latest()->first();

        $Category = Category::where('id',$id)->latest()->first();

        if(!$Category)
        {
            $msg = 'Category not found';
            return response()->json([
                'status'    => 400,
                'message'    => $msg,
            ],400);	
        }
        $majs = Product_Category::where('category_id' , $Category->id)->pluck('product_id')->toArray();
        $latest = Product::where('stock','>',0)->whereIn('id',$majs)->with('ProComments');

       

        if(is_null($type))
        {
            if(!is_null($search))
            {
                $latest =  $latest->where(function ($query) use ($search) {
                    $query->where('name_ar' , 'like' , "%". $search ."%");
                    $query->orWhere('name_en' , 'like' , "%". $search ."%");
                })->latest()->paginate(10);
            }else{
                $latest =  $latest->latest()->paginate(10);
            }
           
           

        }elseif($type == '1'){
            $latest =  $latest->orderBy('price_discount' , 'desc')->latest()->paginate(10);
        }elseif($type == '2'){
            $latest =  $latest->orderBy('price_discount' , 'asc')->latest()->paginate(10);
        }elseif($type == '3'){
            $latest = $latest->latest()->paginate(10);
        }


       

        $list = [];


        # latest item
        if(count($latest) == 0){
            $list['latest_products'] = [];
            $list['current_page']                     = $latest->toArray()['current_page'];
            $list['last_page']                        = $latest->toArray()['last_page'];
        }else{
            foreach ($latest as $key => $sec)
            {
    
                if(!is_null($request->header('Authorization'))){
                    $token = $request->header('Authorization');
                    $token = explode(' ',$token);
                    if(count( $token) == 2){
                        if($request->header('kind') == 'c'){
                            $price_new = $sec->price_discount;
        
                            $user_id  = Customer::where('api_token',$token[1])->first();
        
                            $lik = Pro_Like::where('customer_id',$user_id->id)->where('product_id',$sec->id)->first();
                           
                            if(!$lik)
                            {
                                $fav = false;
                            }else{
                                $fav = true;
                            }
                           
                        }elseif($request->header('kind') == 'd'){
                            $price_new = $sec->dealer_price;
                            $user_id  = Dealer::where('api_token',$token[1])->first();
        
                            $lik = Pro_Like::where('dealer_id',$user_id->id)->where('product_id',$sec->id)->first();
                            if(!$lik)
                            {
                                $fav = false;
                            }else{
                                $fav = true;
                            }
                        }
        
                    }else{
                        $price_new = $sec->price_discount;
                        $fav = false;
                    }
                  
                    
              
                }else{
                    $fav = false;
                    $price_new = $sec->price_discount;
                }
        
        
                if (is_null($request->header("Accept-Language"))) {
                    $name = $sec->name_ar;
                    
                }elseif ($request->header("Accept-Language") == 'ar') {
                    $name = $sec->name_ar;
                }else{
                    $name = $sec->name_en;
                }
                $praaa = (1 - ($sec->price_discount / $sec->price)) * 100 ;
    
                $list['latest_products'][$key]['id']          = $sec->id;
                $list['latest_products'][$key]['name']        = $name;
                $list['latest_products'][$key]['rate']        = $sec->rate;
                $list['latest_products'][$key]['old_price']   = $sec->price;
                $list['latest_products'][$key]['card_image']  = URL::to($sec->card_image);
                $list['latest_products'][$key]['rate_num']    = count($sec->ProComments);
                $list['latest_products'][$key]['discount']    = round($praaa, 0);
                $list['latest_products'][$key]['price_new']   =round($price_new, 0);
                $list['latest_products'][$key]['fav']         = $fav;
                $list['current_page']              = $latest->toArray()['current_page'];
                $list['last_page']                 = $latest->toArray()['last_page'];
                $list['first_page_url']            = $latest->toArray()['first_page_url'];
                $list['next_page_url']             = $latest->toArray()['next_page_url'];
                $list['last_page_url']             = $latest->toArray()['last_page_url'];
                
    
            }
        }

        # Categories item
        if(count($data->Categories) == 0){
            $list['Categories'] = [];
        }else{
            foreach ($data->Categories as $key => $cat)
            {
    
                if (is_null($request->header("Accept-Language"))) {
                    $name = $cat->name_ar;
                    
                }elseif ($request->header("Accept-Language") == 'ar') {
                    $name = $cat->name_ar;

                }else{
                    $name = $cat->name_en;
                }
                $list['Categories'][$key]['id']          = $cat->id;
                $list['Categories'][$key]['name']        = $name;
              
               
    
            }
        }


        # favourites & card
        if(!is_null($request->header('Authorization'))){
            $token = $request->header('Authorization'); 
            $token = explode(' ',$token);
            if(count( $token) == 2){
                if($request->header('kind') == 'c'){

                    $user_id  = Customer::where('api_token',$token[1])->first();

                    $lik = Pro_Like::where('customer_id',$user_id->id)->get();

                    $order = Order::where('status','1')->where('customer_id',$user_id->id)->with('Carts')->latest()->first(); 

                    if(!$lik)
                    {
                        $list['favourites'] = 0;
                    }else{
                        $list['favourites'] = count($lik);
                    }
                    if(!$order)
                    {
                        $list['card'] = 0;
                    }else{
                        $list['card'] = count($order->Carts);
                    }
                }elseif($request->header('kind') == 'd'){
                    $user_id  = Dealer::where('api_token',$token[1])->first();

                    $lik = Pro_Like::where('dealer_id',$user_id->id)->get();

                    $order = Order::where('status','1')->where('dealer_id',$user_id->id)->with('Carts')->latest()->first(); 

                    if(!$lik)
                    {
                        $list['favourites'] = 0;
                    }else{
                        $list['favourites'] = count($lik);
                    }
                    
                    
                    if(!$order)
                    {
                        $list['card'] = 0;
                    }else{
                        $list['card'] = count($order->Carts);
                    }
                }
            }else{
                $list['favourites'] = '0';
                $list['card'] = '0';
            }
        }else{
            $list['favourites'] = '0';
            $list['card'] = '0';
        }


    
        return response()->json([
            'status'    => 200,
            'message'    => 'show section',
            'data'     => $list
        ],200);

    }

    # best_seller page
    public function bestseller(Request $request)
    {
        $type = $request->input("type");
        $search = $request->input("search");

        $data = Division::where('id',$request->header("section"))->with('Categories')->latest()->first();
        $catss = Category::where('division_id',$request->header("section"))->with('Division')->pluck('id')->toArray();
        $procs = Product_Category::whereIn('category_id',$catss)->pluck('product_id')->toArray();
        $latest = Product::whereIn('id',$procs)->where('stock','>',0)->with('ProComments')->orderby('pay_count' , 'desc');

     

        if(is_null($type))
        {
            if(!is_null($search))
            {
                $latest =  $latest->where(function ($query) use ($search) {
                    $query->where('name_ar' , 'like' , "%". $search ."%");
                    $query->orWhere('name_en' , 'like' , "%". $search ."%");
                })->latest()->paginate(10);
            }else{
                $latest =  $latest->latest()->paginate(10);
            }
           
          

        }elseif($type == '1'){
            $latest =  $latest->orderBy('price_discount' , 'desc')->latest()->paginate(10);
        }elseif($type == '2'){
            $latest =  $latest->orderBy('price_discount' , 'asc')->latest()->paginate(10);
        }elseif($type == '3'){
            $latest = $latest->latest()->paginate(10);
        }

        $list = [];


        # latest item
        if(count($latest) == 0){
            $list['latest_products'] = [];
            $list['current_page']                     = $latest->toArray()['current_page'];
            $list['last_page']                        = $latest->toArray()['last_page'];
        }else{
            foreach ($latest as $key => $sec)
            {
    
                if(!is_null($request->header('Authorization'))){
                    $token = $request->header('Authorization'); 
                    $token = explode(' ',$token);
                    if(count( $token) == 2){
                        if($request->header('kind') == 'c'){
                            $price_new = $sec->price_discount;
        
                            $user_id  = Customer::where('api_token',$token[1])->first();
        
                            $lik = Pro_Like::where('customer_id',$user_id->id)->where('product_id',$sec->id)->first();
                        
                            if(!$lik)
                            {
                                $fav = false;
                            }else{
                                $fav = true;
                            }
                        
                        }elseif($request->header('kind') == 'd'){
                            $price_new = $sec->dealer_price;
                            $user_id  = Dealer::where('api_token',$token[1])->first();
        
                            $lik = Pro_Like::where('dealer_id',$user_id->id)->where('product_id',$sec->id)->first();
                            if(!$lik)
                            {
                                $fav = false;
                            }else{
                                $fav = true;
                            }
                        }
        
                    }else{
                        $price_new = $sec->price_discount;
                        $fav = false;
                    }
                
                    
            
                }else{
                    $fav = false;
                    $price_new = $sec->price_discount;
                }
        
        
                if (is_null($request->header("Accept-Language"))) {
                    $name = $sec->name_ar;
                    
                }elseif ($request->header("Accept-Language") == 'ar') {
                    $name = $sec->name_ar;
                }else{
                    $name = $sec->name_en;
                }
                $praaa = (1 - ($sec->price_discount / $sec->price)) * 100 ;
    
                $list['latest_products'][$key]['id']          = $sec->id;
                $list['latest_products'][$key]['name']        = $name;
                $list['latest_products'][$key]['rate']        = $sec->rate;
                $list['latest_products'][$key]['old_price']   = $sec->price;
                $list['latest_products'][$key]['card_image']  = URL::to($sec->card_image);
                $list['latest_products'][$key]['rate_num']    = count($sec->ProComments);
                $list['latest_products'][$key]['discount']    = round($praaa, 0);
                $list['latest_products'][$key]['price_new']   =round($price_new, 0);
                $list['latest_products'][$key]['fav']         = $fav;
                $list['current_page']              = $latest->toArray()['current_page'];
                $list['last_page']                 = $latest->toArray()['last_page'];
                $list['first_page_url']            = $latest->toArray()['first_page_url'];
                $list['next_page_url']             = $latest->toArray()['next_page_url'];
                $list['last_page_url']             = $latest->toArray()['last_page_url'];
                
    
            }
        }

        # Categories item
        if(count($data->Categories) == 0){
            $list['Categories'] = [];
        }else{
            foreach ($data->Categories as $key => $cat)
            {
    
                if (is_null($request->header("Accept-Language"))) {
                    $name = $cat->name_ar;
                    
                }elseif ($request->header("Accept-Language") == 'ar') {
                    $name = $cat->name_ar;

                }else{
                    $name = $cat->name_en;
                }
                $list['Categories'][$key]['id']          = $cat->id;
                $list['Categories'][$key]['name']        = $name;
            
            
    
            }
        }


        # favourites & card
        if(!is_null($request->header('Authorization'))){
            $token = $request->header('Authorization'); 
            $token = explode(' ',$token);
            if(count( $token) == 2){
                if($request->header('kind') == 'c'){

                    $user_id  = Customer::where('api_token',$token[1])->first();

                    $lik = Pro_Like::where('customer_id',$user_id->id)->get();

                    $order = Order::where('status','1')->where('customer_id',$user_id->id)->with('Carts')->latest()->first(); 

                    if(!$lik)
                    {
                        $list['favourites'] = 0;
                    }else{
                        $list['favourites'] = count($lik);
                    }
                    if(!$order)
                    {
                        $list['card'] = 0;
                    }else{
                        $list['card'] = count($order->Carts);
                    }
                }elseif($request->header('kind') == 'd'){
                    $user_id  = Dealer::where('api_token',$token[1])->first();

                    $lik = Pro_Like::where('dealer_id',$user_id->id)->get();

                    $order = Order::where('status','1')->where('dealer_id',$user_id->id)->with('Carts')->latest()->first(); 

                    if(!$lik)
                    {
                        $list['favourites'] = 0;
                    }else{
                        $list['favourites'] = count($lik);
                    }
                    if(!$order)
                    {
                        $list['card'] = 0;
                    }else{
                        $list['card'] = count($order->Carts);
                    }
                }
            }else{
                $list['favourites'] = '0';
                $list['card'] = '0';
            }
        }else{
            $list['favourites'] = '0';
            $list['card'] = '0';
        }


    
        return response()->json([
            'status'    => 200,
            'message'    => 'best_seller',
            'data'     => $list
        ],200);

    }

    # latest page
    public function latest(Request $request)
    {

        $type = $request->input("type");
        $search = $request->input("search");


        $data = Division::where('id',$request->header("section"))->with('Categories')->latest()->first();
        $catss = Category::where('division_id',$request->header("section"))->with('Division')->pluck('id')->toArray();
        $procs = Product_Category::whereIn('category_id',$catss)->pluck('product_id')->toArray();
        $latest = Product::whereIn('id',$procs)->where('stock','>',0)->with('ProComments');

        

        if(is_null($type))
        {
            if(!is_null($search))
            {
                $latest =  $latest->where(function ($query) use ($search) {
                    $query->where('name_ar' , 'like' , "%". $search ."%");
                    $query->orWhere('name_en' , 'like' , "%". $search ."%");
                })->latest()->paginate(10);
            }else{
                $latest =  $latest->latest()->paginate(10);
            }
           

        }elseif($type == '1'){
            $latest =  $latest->orderBy('price_discount' , 'desc')->latest()->paginate(10);
        }elseif($type == '2'){
            $latest =  $latest->orderBy('price_discount' , 'asc')->latest()->paginate(10);
        }elseif($type == '3'){
            $latest = $latest->latest()->paginate(10);
        }
        $list = [];


        # latest item
        if(count($latest) == 0){
            $list['latest_products'] = [];
            $list['current_page']                     = $latest->toArray()['current_page'];
            $list['last_page']                        = $latest->toArray()['last_page'];
        }else{
            foreach ($latest as $key => $sec)
            {
    
                if(!is_null($request->header('Authorization'))){
                    $token = $request->header('Authorization'); 
                    $token = explode(' ',$token);
                    if(count( $token) == 2){
                        if($request->header('kind') == 'c'){
                            $price_new = $sec->price_discount;
        
                            $user_id  = Customer::where('api_token',$token[1])->first();
        
                            $lik = Pro_Like::where('customer_id',$user_id->id)->where('product_id',$sec->id)->first();
                        
                            if(!$lik)
                            {
                                $fav = false;
                            }else{
                                $fav = true;
                            }
                        
                        }elseif($request->header('kind') == 'd'){
                            $price_new = $sec->dealer_price;
                            $user_id  = Dealer::where('api_token',$token[1])->first();
        
                            $lik = Pro_Like::where('dealer_id',$user_id->id)->where('product_id',$sec->id)->first();
                            if(!$lik)
                            {
                                $fav = false;
                            }else{
                                $fav = true;
                            }
                        }
        
                    }else{
                        $price_new = $sec->price_discount;
                        $fav = false;
                    }
                
                    
            
                }else{
                    $fav = false;
                    $price_new = $sec->price_discount;
                }
        
        
                if (is_null($request->header("Accept-Language"))) {
                    $name = $sec->name_ar;
                    
                }elseif ($request->header("Accept-Language") == 'ar') {
                    $name = $sec->name_ar;
                }else{
                    $name = $sec->name_en;
                }
                $praaa = (1 - ($sec->price_discount / $sec->price)) * 100 ;
    
                $list['latest_products'][$key]['id']          = $sec->id;
                $list['latest_products'][$key]['name']        = $name;
                $list['latest_products'][$key]['rate']        = $sec->rate;
                $list['latest_products'][$key]['old_price']   = $sec->price;
                $list['latest_products'][$key]['card_image']  = URL::to($sec->card_image);
                $list['latest_products'][$key]['rate_num']    = count($sec->ProComments);
                $list['latest_products'][$key]['discount']    = round($praaa, 0);
                $list['latest_products'][$key]['price_new']   =round($price_new, 0);
                $list['latest_products'][$key]['fav']         = $fav;
                $list['current_page']              = $latest->toArray()['current_page'];
                $list['last_page']                 = $latest->toArray()['last_page'];
                $list['first_page_url']            = $latest->toArray()['first_page_url'];
                $list['next_page_url']             = $latest->toArray()['next_page_url'];
                $list['last_page_url']             = $latest->toArray()['last_page_url'];
                
    
            }
        }

        # Categories item
        if(count($data->Categories) == 0){
            $list['Categories'] = [];
        }else{
            foreach ($data->Categories as $key => $cat)
            {
    
                if (is_null($request->header("Accept-Language"))) {
                    $name = $cat->name_ar;
                    
                }elseif ($request->header("Accept-Language") == 'ar') {
                    $name = $cat->name_ar;

                }else{
                    $name = $cat->name_en;
                }
                $list['Categories'][$key]['id']          = $cat->id;
                $list['Categories'][$key]['name']        = $name;
            
            
    
            }
        }


        # favourites & card
        if(!is_null($request->header('Authorization'))){
            $token = $request->header('Authorization'); 
            $token = explode(' ',$token);
            if(count( $token) == 2){
                if($request->header('kind') == 'c'){

                    $user_id  = Customer::where('api_token',$token[1])->first();

                    $lik = Pro_Like::where('customer_id',$user_id->id)->get();

                    $order = Order::where('status','1')->where('customer_id',$user_id->id)->with('Carts')->latest()->first(); 

                    if(!$lik)
                    {
                        $list['favourites'] = 0;
                    }else{
                        $list['favourites'] = count($lik);
                    }
                    if(!$order)
                    {
                        $list['card'] = 0;
                    }else{
                        $list['card'] = count($order->Carts);
                    }
                }elseif($request->header('kind') == 'd'){
                    $user_id  = Dealer::where('api_token',$token[1])->first();

                    $lik = Pro_Like::where('dealer_id',$user_id->id)->get();

                    $order = Order::where('status','1')->where('dealer_id',$user_id->id)->with('Carts')->latest()->first(); 

                    if(!$lik)
                    {
                        $list['favourites'] = 0;
                    }else{
                        $list['favourites'] = count($lik);
                    }
                    if(!$order)
                    {
                        $list['card'] = 0;
                    }else{
                        $list['card'] = count($order->Carts);
                    }
                }
            }else{
                $list['favourites'] = '0';
                $list['card'] = '0';
            }
        }else{
            $list['favourites'] = '0';
            $list['card'] = '0';
        }


    
        return response()->json([
            'status'    => 200,
            'message'    => 'latest_products',
            'data'     => $list
        ],200);

    }


    # filter page
    public function filter(Request $request)
    {
        $type = $request->input("type");
        $search = $request->input("search");
        $sections = $request->input("sections");
        $min_price = $request->input("min_price");
        $max_price = $request->input("max_price");
        $rate      = $request->input("rate");


        $data = Division::where('id',$request->header("section"))->with('Categories')->latest()->first();
        $catss = Category::where('division_id',$request->header("section"))->with('Division')->pluck('id')->toArray();
        $procs = Product_Category::whereIn('category_id',$catss)->pluck('product_id')->toArray();
        $latest = Product::whereIn('id',$procs)->where('stock','>',0)->with('ProComments');

        if(!is_null($sections))
        {
            $majs = Product_Category::whereIn('category_id' , $sections)->pluck('product_id')->toArray();
            $latest =  $latest->whereIn('id',$majs);
        }

        if(!is_null($min_price) && !is_null($max_price))
        {
            
            $latest =  $latest->whereBetween( 'price_discount', [$min_price, $max_price]);
        }

        if(!is_null($rate))
        {
            
            $latest =  $latest->whereIn('rate',$rate);
        }


        

        if(is_null($type))
        {
            if(!is_null($search))
            {
                $latest =  $latest->where(function ($query) use ($search) {
                    $query->where('name_ar' , 'like' , "%". $search ."%");
                    $query->orWhere('name_en' , 'like' , "%". $search ."%");
                })->latest()->paginate(10);
            }else{
                $latest =  $latest->latest()->paginate(10);
            }
        

        }elseif($type == '1'){
            $latest =  $latest->orderBy('price_discount' , 'desc')->latest()->paginate(10);
        }elseif($type == '2'){
            $latest =  $latest->orderBy('price_discount' , 'asc')->latest()->paginate(10);
        }elseif($type == '3'){
            $latest = $latest->latest()->paginate(10);
        }
        $list = [];


        # latest item
        if(count($latest) == 0){
            $list['latest_products'] = [];
            $list['current_page']                     = $latest->toArray()['current_page'];
            $list['last_page']                        = $latest->toArray()['last_page'];
        }else{
            foreach ($latest as $key => $sec)
            {
    
                if(!is_null($request->header('Authorization'))){
                    $token = $request->header('Authorization'); 
                    $token = explode(' ',$token);
                    if(count( $token) == 2){
                        if($request->header('kind') == 'c'){
                            $price_new = $sec->price_discount;
        
                            $user_id  = Customer::where('api_token',$token[1])->first();
        
                            $lik = Pro_Like::where('customer_id',$user_id->id)->where('product_id',$sec->id)->first();
                        
                            if(!$lik)
                            {
                                $fav = false;
                            }else{
                                $fav = true;
                            }
                        
                        }elseif($request->header('kind') == 'd'){
                            $price_new = $sec->dealer_price;
                            $user_id  = Dealer::where('api_token',$token[1])->first();
        
                            $lik = Pro_Like::where('dealer_id',$user_id->id)->where('product_id',$sec->id)->first();
                            if(!$lik)
                            {
                                $fav = false;
                            }else{
                                $fav = true;
                            }
                        }
        
                    }else{
                        $price_new = $sec->price_discount;
                        $fav = false;
                    }
                
                    
            
                }else{
                    $fav = false;
                    $price_new = $sec->price_discount;
                }
        
        
                if (is_null($request->header("Accept-Language"))) {
                    $name = $sec->name_ar;
                    
                }elseif ($request->header("Accept-Language") == 'ar') {
                    $name = $sec->name_ar;
                }else{
                    $name = $sec->name_en;
                }
                $praaa = (1 - ($sec->price_discount / $sec->price)) * 100 ;
    
                $list['latest_products'][$key]['id']          = $sec->id;
                $list['latest_products'][$key]['name']        = $name;
                $list['latest_products'][$key]['rate']        = $sec->rate;
                $list['latest_products'][$key]['old_price']   = $sec->price;
                $list['latest_products'][$key]['card_image']  = URL::to($sec->card_image);
                $list['latest_products'][$key]['rate_num']    = count($sec->ProComments);
                $list['latest_products'][$key]['discount']    = round($praaa, 0);
                $list['latest_products'][$key]['price_new']   =round($price_new, 0);
                $list['latest_products'][$key]['fav']         = $fav;
                $list['current_page']              = $latest->toArray()['current_page'];
                $list['last_page']                 = $latest->toArray()['last_page'];
                $list['first_page_url']            = $latest->toArray()['first_page_url'];
                $list['next_page_url']             = $latest->toArray()['next_page_url'];
                $list['last_page_url']             = $latest->toArray()['last_page_url'];
                
    
            }
        }

        # Categories item
        if(count($data->Categories) == 0){
            $list['Categories'] = [];
        }else{
            foreach ($data->Categories as $key => $cat)
            {
    
                if (is_null($request->header("Accept-Language"))) {
                    $name = $cat->name_ar;
                    
                }elseif ($request->header("Accept-Language") == 'ar') {
                    $name = $cat->name_ar;

                }else{
                    $name = $cat->name_en;
                }
                $list['Categories'][$key]['id']          = $cat->id;
                $list['Categories'][$key]['name']        = $name;
            
            
    
            }
        }


        # favourites & card
        if(!is_null($request->header('Authorization'))){
            $token = $request->header('Authorization'); 
            $token = explode(' ',$token);
            if(count( $token) == 2){
                if($request->header('kind') == 'c'){

                    $user_id  = Customer::where('api_token',$token[1])->first();

                    $lik = Pro_Like::where('customer_id',$user_id->id)->get();

                    $order = Order::where('status','1')->where('customer_id',$user_id->id)->with('Carts')->latest()->first(); 

                    if(!$lik)
                    {
                        $list['favourites'] = 0;
                    }else{
                        $list['favourites'] = count($lik);
                    }
                    if(!$order)
                    {
                        $list['card'] = 0;
                    }else{
                        $list['card'] = count($order->Carts);
                    }
                }elseif($request->header('kind') == 'd'){
                    $user_id  = Dealer::where('api_token',$token[1])->first();

                    $lik = Pro_Like::where('dealer_id',$user_id->id)->get();

                    $order = Order::where('status','1')->where('dealer_id',$user_id->id)->with('Carts')->latest()->first(); 

                    if(!$lik)
                    {
                        $list['favourites'] = 0;
                    }else{
                        $list['favourites'] = count($lik);
                    }
                    if(!$order)
                    {
                        $list['card'] = 0;
                    }else{
                        $list['card'] = count($order->Carts);
                    }
                }
            }else{
                $list['favourites'] = '0';
                $list['card'] = '0';
            }
        }else{
            $list['favourites'] = '0';
            $list['card'] = '0';
        }


    
        return response()->json([
            'status'    => 200,
            'message'    => 'filter',
            'data'     => $list
        ],200);

    }

    # my fav
    public function favourites(Request $request)
    {

        $search = $request->input("search");
        $type = $request->input("type");
        $data = Division::where('id',$request->header("section"))->with('Categories')->latest()->first();
        $catss = Category::where('division_id',$request->header("section"))->with('Division')->pluck('id')->toArray();

        if($request->header('kind') == 'c'){
            $user_id  = Customer::where('id',session('customer')->id)->first();
            $majs = Pro_Like::where('customer_id' , session('customer')->id)->pluck('product_id')->toArray();
            
        }elseif($request->header('kind') == 'd'){
            $user_id  = Dealer::where('id',session('customer')->id)->first();
            $majs = Pro_Like::where('dealer_id' , session('customer')->id)->pluck('product_id')->toArray();
        }
        

        if(is_null($type))
        {
            if(!is_null($search))
            {
                $latest = Product::whereIn('id',$majs)->where('stock','>',0)->with('ProComments')->where(function ($query) use ($search) {
                    $query->where('name_ar' , 'like' , "%". $search ."%");
                    $query->orWhere('name_en' , 'like' , "%". $search ."%");
                })->latest()->paginate(10);
            }else{
                $latest = Product::whereIn('id',$majs)->where('stock','>',0)->with('ProComments')->latest()->paginate(10);
            }
    
           

        }elseif($type == '1'){
            $latest =  Product::whereIn('id',$majs)->where('stock','>',0)->with('ProComments')->orderBy('price_discount' , 'desc')->latest()->paginate(10);
        }elseif($type == '2'){
            $latest =  Product::whereIn('id',$majs)->where('stock','>',0)->with('ProComments')->orderBy('price_discount' , 'asc')->latest()->paginate(10);
        }elseif($type == '3'){
            $latest = Product::whereIn('id',$majs)->where('stock','>',0)->with('ProComments')->latest()->paginate(10);
        }

       
   
        $list = [];


        # latest item
        if(count($latest) == 0){
            $list['latest_products'] = [];
            $list['current_page']                     = $latest->toArray()['current_page'];
            $list['last_page']                        = $latest->toArray()['last_page'];
        }else{
            foreach ($latest as $key => $sec)
            {
    
                if(!is_null($request->header('Authorization'))){
                    $token = $request->header('Authorization'); 
                    $token = explode(' ',$token);
                    if(count( $token) == 2){
                        if($request->header('kind') == 'c'){
                            $price_new = $sec->price_discount;
        
                            $user_id  = Customer::where('api_token',$token[1])->first();
        
                            $lik = Pro_Like::where('customer_id',$user_id->id)->where('product_id',$sec->id)->first();
                        
                            if(!$lik)
                            {
                                $fav = false;
                            }else{
                                $fav = true;
                            }
                        
                        }elseif($request->header('kind') == 'd'){
                            $price_new = $sec->dealer_price;
                            $user_id  = Dealer::where('api_token',$token[1])->first();
        
                            $lik = Pro_Like::where('dealer_id',$user_id->id)->where('product_id',$sec->id)->first();
                            if(!$lik)
                            {
                                $fav = false;
                            }else{
                                $fav = true;
                            }
                        }
        
                    }else{
                        $price_new = $sec->price_discount;
                        $fav = false;
                    }
                
                    
            
                }else{
                    $fav = false;
                    $price_new = $sec->price_discount;
                }
        
        
                if (is_null($request->header("Accept-Language"))) {
                    $name = $sec->name_ar;
                    
                }elseif ($request->header("Accept-Language") == 'ar') {
                    $name = $sec->name_ar;
                }else{
                    $name = $sec->name_en;
                }
                $praaa = (1 - ($sec->price_discount / $sec->price)) * 100 ;
    
                $list['latest_products'][$key]['id']          = $sec->id;
                $list['latest_products'][$key]['name']        = $name;
                $list['latest_products'][$key]['rate']        = $sec->rate;
                $list['latest_products'][$key]['old_price']   = $sec->price;
                $list['latest_products'][$key]['card_image']  = URL::to($sec->card_image);
                $list['latest_products'][$key]['rate_num']    = count($sec->ProComments);
                $list['latest_products'][$key]['discount']    = round($praaa, 0);
                $list['latest_products'][$key]['price_new']   =round($price_new, 0);
                $list['latest_products'][$key]['fav']         = $fav;
                $list['current_page']              = $latest->toArray()['current_page'];
                $list['last_page']                 = $latest->toArray()['last_page'];
                $list['first_page_url']            = $latest->toArray()['first_page_url'];
                $list['next_page_url']             = $latest->toArray()['next_page_url'];
                $list['last_page_url']             = $latest->toArray()['last_page_url'];
                
    
            }
        }


        # favourites & card
        if(!is_null($request->header('Authorization'))){
            $token = $request->header('Authorization'); 
            $token = explode(' ',$token);
            if(count( $token) == 2){
                if($request->header('kind') == 'c'){

                    $user_id  = Customer::where('api_token',$token[1])->first();

                    $lik = Pro_Like::where('customer_id',$user_id->id)->get();

                    $order = Order::where('status','1')->where('customer_id',$user_id->id)->with('Carts')->latest()->first(); 

                    if(!$lik)
                    {
                        $list['favourites'] = 0;
                    }else{
                        $list['favourites'] = count($lik);
                    }
                    if(!$order)
                    {
                        $list['card'] = 0;
                    }else{
                        $list['card'] = count($order->Carts);
                    }
                }elseif($request->header('kind') == 'd'){
                    $user_id  = Dealer::where('api_token',$token[1])->first();

                    $lik = Pro_Like::where('dealer_id',$user_id->id)->get();

                    $order = Order::where('status','1')->where('dealer_id',$user_id->id)->with('Carts')->latest()->first(); 

                    if(!$lik)
                    {
                        $list['favourites'] = 0;
                    }else{
                        $list['favourites'] = count($lik);
                    }
                    if(!$order)
                    {
                        $list['card'] = 0;
                    }else{
                        $list['card'] = count($order->Carts);
                    }
                }
            }else{
                $list['favourites'] = '0';
                $list['card'] = '0';
            }
        }else{
            $list['favourites'] = '0';
            $list['card'] = '0';
        }


    
        return response()->json([
            'status'    => 200,
            'message'    => 'favourites',
            'data'     => $list
        ],200);

    }


    # search page
    public function search(Request $request)
    {
        $type = $request->input("type");
        $search = $request->input("search");

        if(!$search)
        {
            $msg = 'search is required';
            return response()->json([
                'status'    => 400,
                'message'    => $msg,
            ],400);	
        }
        $latest = Product::where('stock','>',0)->with('ProComments')->where(function ($query) use ($search) {
            $query->where('name_ar' , 'like' , "%". $search ."%");
            $query->orWhere('name_en' , 'like' , "%". $search ."%");
        });
       
        if(is_null($type))
        {
            $latest =  $latest->latest()->paginate(10);
        }elseif($type == '1'){
            $latest =  $latest->orderBy('price_discount' , 'desc')->latest()->paginate(10);
        }elseif($type == '2'){
            $latest =  $latest->orderBy('price_discount' , 'asc')->latest()->paginate(10);
        }elseif($type == '3'){
            $latest = $latest->latest()->paginate(10);
        }


        

        $list = [];


        # latest item
        if(count($latest) == 0){
            $list['latest_products'] = [];
            $list['current_page']                     = $latest->toArray()['current_page'];
            $list['last_page']                        = $latest->toArray()['last_page'];
        }else{
            foreach ($latest as $key => $sec)
            {
    
                if(!is_null($request->header('Authorization'))){
                    $token = $request->header('Authorization'); 
                    $token = explode(' ',$token);
                    if(count( $token) == 2){
                        if($request->header('kind') == 'c'){
                            $price_new = $sec->price_discount;
        
                            $user_id  = Customer::where('api_token',$token[1])->first();
        
                            $lik = Pro_Like::where('customer_id',$user_id->id)->where('product_id',$sec->id)->first();
                            
                            if(!$lik)
                            {
                                $fav = false;
                            }else{
                                $fav = true;
                            }
                            
                        }elseif($request->header('kind') == 'd'){
                            $price_new = $sec->dealer_price;
                            $user_id  = Dealer::where('api_token',$token[1])->first();
        
                            $lik = Pro_Like::where('dealer_id',$user_id->id)->where('product_id',$sec->id)->first();
                            if(!$lik)
                            {
                                $fav = false;
                            }else{
                                $fav = true;
                            }
                        }
        
                    }else{
                        $price_new = $sec->price_discount;
                        $fav = false;
                    }
                
                    
            
                }else{
                    $fav = false;
                    $price_new = $sec->price_discount;
                }
        
        
                if (is_null($request->header("Accept-Language"))) {
                    $name = $sec->name_ar;
                    
                }elseif ($request->header("Accept-Language") == 'ar') {
                    $name = $sec->name_ar;
                }else{
                    $name = $sec->name_en;
                }
                $praaa = (1 - ($sec->price_discount / $sec->price)) * 100 ;
    
                $list['latest_products'][$key]['id']          = $sec->id;
                $list['latest_products'][$key]['name']        = $name;
                $list['latest_products'][$key]['rate']        = $sec->rate;
                $list['latest_products'][$key]['old_price']   = $sec->price;
                $list['latest_products'][$key]['card_image']  = URL::to($sec->card_image);
                $list['latest_products'][$key]['rate_num']    = count($sec->ProComments);
                $list['latest_products'][$key]['discount']    = round($praaa, 0);
                $list['latest_products'][$key]['price_new']   =round($price_new, 0);
                $list['latest_products'][$key]['fav']         = $fav;
                $list['current_page']              = $latest->toArray()['current_page'];
                $list['last_page']                 = $latest->toArray()['last_page'];
                $list['first_page_url']            = $latest->toArray()['first_page_url'];
                $list['next_page_url']             = $latest->toArray()['next_page_url'];
                $list['last_page_url']             = $latest->toArray()['last_page_url'];
                
    
            }
        }

        # favourites & card
        if(!is_null($request->header('Authorization'))){
            $token = $request->header('Authorization'); 
            $token = explode(' ',$token);
            if(count( $token) == 2){
                if($request->header('kind') == 'c'){

                    $user_id  = Customer::where('api_token',$token[1])->first();

                    $lik = Pro_Like::where('customer_id',$user_id->id)->get();

                    $order = Order::where('status','1')->where('customer_id',$user_id->id)->with('Carts')->latest()->first(); 

                    if(!$lik)
                    {
                        $list['favourites'] = 0;
                    }else{
                        $list['favourites'] = count($lik);
                    }
                    if(!$order)
                    {
                        $list['card'] = 0;
                    }else{
                        $list['card'] = count($order->Carts);
                    }
                }elseif($request->header('kind') == 'd'){
                    $user_id  = Dealer::where('api_token',$token[1])->first();

                    $lik = Pro_Like::where('dealer_id',$user_id->id)->get();

                    $order = Order::where('status','1')->where('dealer_id',$user_id->id)->with('Carts')->latest()->first(); 

                    if(!$lik)
                    {
                        $list['favourites'] = 0;
                    }else{
                        $list['favourites'] = count($lik);
                    }
                    
                    
                    if(!$order)
                    {
                        $list['card'] = 0;
                    }else{
                        $list['card'] = count($order->Carts);
                    }
                }
            }else{
                $list['favourites'] = '0';
                $list['card'] = '0';
            }
        }else{
            $list['favourites'] = '0';
            $list['card'] = '0';
        }


    
        return response()->json([
            'status'    => 200,
            'message'    => 'show search',
            'data'     => $list
        ],200);

    }
  


   
}
