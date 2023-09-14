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
use Date;
use DB;
use URL;
use App\Http\Resources\productResource;

use Illuminate\Support\Facades\Validator;

// use Validator;

class ApidetProducController extends Controller
{

    # detials page
    public function detialsprod(Request $request)
    {
        $id = $request->input("id");

        $data = Division::where('id', $request->header("section"))->with('Categories')->latest()->first();

        $sec = Product::with('ProComments.Dealer', 'ProComments.Customer', 'Images', 'ProTypes', 'Categories')->where('id', $id)->latest()->first();
        // return response()->json(['data' => $sec], 200);


        $Pro_Comments = Pro_Comments::with('Dealer', 'Customer')->where('product_id', $id)->get();
        $majs = Product_Category::where('product_id', $id)->pluck('category_id')->toArray();
        $datas = Product_Category::whereIn('category_id', $majs)->pluck('product_id')->toArray();
        $copies = Product::where('stock', '>', 0)->whereIn('id', $datas)->inRandomOrder()->latest()->take(4)->get();
        if (!$sec) {
            $msg = 'Product not found';
            return response()->json([
                'status' => 400,
                'message' => $msg,
            ], 400);
        }


        $list = [];
        $praaa = (1 - ($sec->price_discount / $sec->price)) * 100;


        if (!is_null($request->header('Authorization'))) {
            $token = $request->header('Authorization');
            $token = explode(' ', $token);
            if (count($token) == 2) {
                if ($request->header('kind') == 'c') {
                    $price_new = $sec->price_discount;
                    $user_id = Customer::where('api_token', $token[1])->first();
                    $lik = Pro_Like::where('customer_id', $user_id->id)->where('product_id', $sec->id)->first();
                    if (!$lik) {
                        $fav = false;
                    } else {
                        $fav = true;
                    }

                } elseif ($request->header('kind') == 'd') {
                    $price_new = $sec->dealer_price;
                    $user_id = Dealer::where('api_token', $token[1])->first();
                    $lik = Pro_Like::where('dealer_id', $user_id->id)->where('product_id', $sec->id)->first();
                    if (!$lik) {
                        $fav = false;
                    } else {
                        $fav = true;
                    }
                }

            } else {
                $price_new = $sec->price_discount;
                $fav = false;
            }


        } else {
            $fav = false;
            $price_new = $sec->price_discount;
        }


        if (is_null($request->header("Accept-Language"))) {
            $name = $sec->name_ar;
            $desc = $sec->des_ar;
        } elseif ($request->header("Accept-Language") == 'ar') {
            $name = $sec->name_ar;
            $desc = $sec->des_ar;
        } else {
            $name = $sec->name_en;
            $desc = $sec->des_en;
        }


        #  item
        $list['id'] = $sec->id;
        $list['name'] = $name;
        $list['rate'] = $sec->rate;
        $list['desc'] = $desc;
        $list['old_price'] = $sec->price;
        $list['card_image'] = URL::to($sec->card_image);
        $list['rate_num'] = count($sec->ProComments);
        $list['discount'] = round($praaa, 0);
        $list['price_new'] = round($price_new, 0);
        // stock is here
        $list['stock'] = $sec->stock;

        $list['fav'] = $fav;

        # likes item
        if (count($copies) == 0) {
            $list['copies_products'] = [];
        } else {
            foreach ($copies as $key => $sec) {

                if (!is_null($request->header('Authorization'))) {
                    $token = $request->header('Authorization');
                    $token = explode(' ', $token);
                    if (count($token) == 2) {
                        if ($request->header('kind') == 'c') {
                            $price_new = $sec->price_discount;

                            $user_id = Customer::where('api_token', $token[1])->first();

                            $lik = Pro_Like::where('customer_id', $user_id->id)->where('product_id', $sec->id)->first();

                            if (!$lik) {
                                $fav = false;
                            } else {
                                $fav = true;
                            }

                        } elseif ($request->header('kind') == 'd') {
                            $price_new = $sec->dealer_price;
                            $user_id = Dealer::where('api_token', $token[1])->first();

                            $lik = Pro_Like::where('dealer_id', $user_id->id)->where('product_id', $sec->id)->first();
                            if (!$lik) {
                                $fav = false;
                            } else {
                                $fav = true;
                            }
                        }

                    } else {
                        $price_new = $sec->price_discount;
                        $fav = false;
                    }


                } else {
                    $fav = false;
                    $price_new = $sec->price_discount;
                }


                if (is_null($request->header("Accept-Language"))) {
                    $name = $sec->name_ar;

                } elseif ($request->header("Accept-Language") == 'ar') {
                    $name = $sec->name_ar;
                } else {
                    $name = $sec->name_en;
                }
                $praaa = (1 - ($sec->price_discount / $sec->price)) * 100;

                $list['copies_products'][$key]['id'] = $sec->id;
                $list['copies_products'][$key]['name'] = $name;
                $list['copies_products'][$key]['rate'] = $sec->rate;
                $list['copies_products'][$key]['old_price'] = $sec->price;
                $list['copies_products'][$key]['card_image'] = URL::to($sec->card_image);
                $list['copies_products'][$key]['rate_num'] = count($sec->ProComments);
                $list['copies_products'][$key]['discount'] = round($praaa, 0);
                $list['copies_products'][$key]['price_new'] = round($price_new, 0);
                $list['copies_products'][$key]['fav'] = $fav;

            }
        }

        if (count($sec->Images) == 0) {
            $list['Images'] = [];
        } else {
            foreach ($sec->Images as $key => $image) {

                $list['Images'][$key]['id'] = $image->id;
                $list['Images'][$key]['Image'] = URL::to('uploads/products_images/' . $image->image);

            }
        }

        if (count($sec->ProTypes) == 0) {
            $list['ProTypes'] = [];
        } else {
            foreach ($sec->ProTypes as $key => $new) {
                if (is_null($request->header("Accept-Language"))) {
                    $name = $new->name_ar;
                    $value = $new->value_ar;
                } elseif ($request->header("Accept-Language") == 'ar') {
                    $name = $new->name_ar;
                    $value = $new->value_ar;
                } else {
                    $name = $new->name_en;
                    $value = $new->value_en;
                }

                $list['ProTypes'][$key]['id'] = $new->id;
                $list['ProTypes'][$key]['value'] = $value;
                $list['ProTypes'][$key]['name'] = $name;
            }
        }

        if (count($Pro_Comments) == 0) {
            $list['ProComments'] = [];
        } else {
            foreach ($Pro_Comments as $key => $com) {
                if (!is_null($com->customer_id)) {
                    $name = $com->Customer->name;
                } elseif (!is_null($com->dealer_id)) {
                    $name = $com->Dealer->name;
                } else {
                    $name = ' ';
                }

                $list['ProComments'][$key]['id'] = $com->id;
                $list['ProComments'][$key]['rate'] = $com->rate;
                $list['ProComments'][$key]['comment'] = $com->comment;
                $list['ProComments'][$key]['name'] = $name;
            }
        }


        # favourites & card
        if (!is_null($request->header('Authorization'))) {
            $token = $request->header('Authorization');
            $token = explode(' ', $token);
            if (count($token) == 2) {
                if ($request->header('kind') == 'c') {

                    $user_id = Customer::where('api_token', $token[1])->first();

                    $lik = Pro_Like::where('customer_id', $user_id->id)->get();

                    $order = Order::where('status', '1')->where('customer_id', $user_id->id)->with('Carts')->latest()->first();

                    if (!$lik) {
                        $list['favourites'] = 0;
                    } else {
                        $list['favourites'] = count($lik);
                    }
                    if (!$order) {
                        $list['card'] = 0;
                    } else {
                        $list['card'] = count($order->Carts);
                    }
                } elseif ($request->header('kind') == 'd') {
                    $user_id = Dealer::where('api_token', $token[1])->first();

                    $lik = Pro_Like::where('dealer_id', $user_id->id)->get();

                    $order = Order::where('status', '1')->where('dealer_id', $user_id->id)->with('Carts')->latest()->first();

                    if (!$lik) {
                        $list['favourites'] = 0;
                    } else {
                        $list['favourites'] = count($lik);
                    }
                    if (!$order) {
                        $list['card'] = 0;
                    } else {
                        $list['card'] = count($order->Carts);
                    }
                }
            } else {
                $list['favourites'] = '0';
                $list['card'] = '0';
            }
        } else {
            $list['favourites'] = '0';
            $list['card'] = '0';
        }


        return response()->json([
            'status' => 200,
            'message' => 'show product detials',
            'data' => $list
        ], 200);

    }

    # add comment
    public function addcomment(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'rate' => 'required',
            'comment' => 'required',


        ]);

        foreach ((array)$validator->errors() as $value) {
            if (isset($value['rate'])) {
                $msg = 'rate is required';
                return response()->json([
                    'message' => $msg,
                    'status' => 400,
                ], 400);
            } elseif (isset($value['comment'])) {
                $msg = 'comment is required';
                return response()->json([
                    'message' => $msg,
                    'status' => 400,
                ], 400);
            } elseif (isset($value['id'])) {
                $msg = 'id is required';
                return response()->json([
                    'message' => $msg,
                    'status' => 400,
                ], 400);
            }
        }

        $pro = Product::with('ProLikes')->where('id', $request->id)->latest()->first();
        if (!$pro) {
            $msg = 'Product not found';
            return response()->json([
                'status' => 400,
                'message' => $msg,
            ], 400);
        }
        $list = [];
        # favourites & card
        if (!is_null($request->header('Authorization'))) {
            $token = $request->header('Authorization');
            $token = explode(' ', $token);
            if (count($token) == 2) {
                if ($request->header('kind') == 'c') {

                    $user_id = Customer::where('api_token', $token[1])->first();
                    $like = new Pro_Comments;
                    $like->customer_id = $user_id->id;
                    $like->product_id = $request->id;
                    $like->rate = $request->rate;
                    $like->comment = $request->comment;
                    $like->save();
                    $list['name'] = $user_id->name;

                } elseif ($request->header('kind') == 'd') {
                    $user_id = Dealer::where('api_token', $token[1])->first();

                    $like = new Pro_Comments;
                    $like->dealer_id = $user_id->id;
                    $like->product_id = $request->id;
                    $like->rate = $request->rate;
                    $like->comment = $request->comment;
                    $like->save();
                    $list['name'] = $user_id->name;
                } else {
                    $like = new Pro_Comments;
                    $like->product_id = $request->id;
                    $like->rate = $request->rate;
                    $like->comment = $request->comment;
                    $like->save();
                    $list['name'] = 'guest';
                }
            } else {
                $like = new Pro_Comments;
                $like->product_id = $request->id;
                $like->rate = $request->rate;
                $like->comment = $request->comment;
                $like->save();
                $list['name'] = 'guest';
            }
        } else {
            $like = new Pro_Comments;
            $like->product_id = $request->id;
            $like->rate = $request->rate;
            $like->comment = $request->comment;
            $like->save();
            $list['name'] = 'guest';
        }

        $pro->rate = Pro_Comments::where('product_id', $request->id)->avg('rate');
        $pro->save();

        $list['id'] = $like->id;
        $list['comment'] = $like->comment;
        $list['rate'] = $like->rate;
        $list['avg_rate'] = $pro->rate;

        return response()->json([
            'status' => 200,
            'message' => 'add comment',
            'data' => $list
        ], 200);

    }

    # add fav
    public function addfav(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required',

        ]);

        foreach ((array)$validator->errors() as $value) {
            if (isset($value['id'])) {
                $msg = 'id is required';
                return response()->json([
                    'message' => $msg,
                    'status' => 400,
                ], 400);
            }
        }

        $pro = Product::with('ProLikes')->where('id', $request->id)->latest()->first();
        if (!$pro) {
            $msg = 'Product not found';
            return response()->json([
                'status' => 400,
                'message' => $msg,
            ], 400);
        }
        $list = [];

        if ($request->header('kind') == 'c') {

            $user_id = Customer::where('id', session('customer')->id)->first();
            $lik = Pro_Like::where('customer_id', $user_id->id)->where('product_id', $request->id)->latest()->first();

            if (!$lik) {
                $like = new Pro_Like;
                $like->customer_id = $user_id->id;
                $like->product_id = $request->id;
                $like->save();

                $msg = ' add to favourites ';
            } else {
                $lik->delete();
                $msg = ' remove to favourites ';
            }

            $liks = Pro_Like::where('customer_id', $user_id->id)->latest()->get();

        } elseif ($request->header('kind') == 'd') {
            $user_id = Dealer::where('id', session('customer')->id)->first();

            $lik = Pro_Like::where('dealer_id', $user_id->id)->where('product_id', $request->id)->latest()->first();

            if (!$lik) {
                $like = new Pro_Like;
                $like->dealer_id = $user_id->id;
                $like->product_id = $request->id;
                $like->save();
                $msg = ' add to favourites ';
            } else {
                $lik->delete();
                $msg = ' remove to favourites ';
            }
            $liks = Pro_Like::where('dealer_id', $user_id)->latest()->get();
        }
        $datas = count($liks);

        $list['count_liks'] = $datas;

        return response()->json([
            'status' => 200,
            'message' => $msg,
            'data' => $list
        ], 200);

    }

    # add order
    public function order(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'count' => 'required',

        ]);

        foreach ((array)$validator->errors() as $value) {
            if (isset($value['id'])) {
                $msg = 'id is required';
                return response()->json([
                    'message' => $msg,
                    'status' => 400,
                ], 400);
            } elseif (isset($value['count'])) {
                $msg = 'count is required';
                return response()->json([
                    'message' => $msg,
                    'status' => 400,
                ], 400);
            }
        }

        $product = Product::where('id', $request->id)->latest()->first();
        if ($request->header('kind') == 'd') {
            $token = $request->header('Authorization');
            $token = explode(' ', $token);
            $user = Dealer::where('api_token', $token[1])->first();

            $user_id = $user->id;
            $order = Order::where('dealer_id', $user_id)->where('status', '1')->with('Carts')->latest()->first();
            if ($order) {
                $product = Product::where('id', $request->id)->latest()->first();

                // Here Check For Quantity
                if ($product->stock < $request->count) {
                    return response()->json(['msg' => 'Quantity Is more than product stock'],200);
                }

                if (isset($product->id)) {
                    $checkIfProductExistsInCart = Cart::where('product_id', $product->id)->where('order_id', $order->id)->first();
                    // check if product stock is available
                    if ($checkIfProductExistsInCart and $product->stock >= $request->count):
                        $checkIfProductExistsInCart->count = $checkIfProductExistsInCart->count + $request->count;
                        $checkIfProductExistsInCart->price = ($checkIfProductExistsInCart->price) + ($product->dealer_price * $request->count);
                        $checkIfProductExistsInCart->save();
                        $order->total = Cart::where('order_id', $order->id)->sum('price');
                        $order->save();
                    endif;

                } else {
                    // Adding Order To Cart
                    $Cart = new Cart;
                    $Cart->count = $request->count;
                    $Cart->price = $product->dealer_price * $request->count;
                    $Cart->product_id = $product->id;
                    $Cart->order_id = $order->id;
                    $Cart->save();
                    // $product->stock = $product->stock - $request->count;
                    // $product->save();

                    $order->total = Cart::where('order_id', $order->id)->sum('price');
                    $order->save();
                }

            }
            else {
                $product = Product::where('id', $request->id)->latest()->first();
                // Here Check For Quantity
                if ($product->stock < $request->count) {
                    return response()->json(['msg' => 'Quantity Is more than product stock'],200);
                }
                $order = new Order;
                $order->dealer_id = $user_id;
                $order->status = 1;
                $order->customer_type = 'd';
                $order->total = 0;
                $order->save();

                $Cart = new Cart;
                $Cart->count = $request->count;
                $Cart->price = $product->dealer_price * $Cart->count;
                $Cart->product_id = $product->id;
                $Cart->order_id = $order->id;
                $Cart->save();
                $product->stock = $product->stock - $request->count;
                $product->save();


                $order = Order::where('id', $order->id)->where('status', '1')->with('Carts')->latest()->first();
                $order->total = Cart::where('order_id', $order->id)->sum('price');
                $order->save();
            }
        }
        elseif ($request->header('kind') == 'c') {

            $token = $request->header('Authorization');
            $token = explode(' ', $token);
            $user = Customer::where('api_token', $token[1])->first();

            $user_id = $user->id;
            $order = Order::where('customer_id', $user_id)->where('status', '1')->with('Carts')->latest()->first();
            if ($order) {
                $product = Product::where('id', $request->id)->latest()->first();
                // Here Check For Quantity
                if ($product->stock < $request->count) {
                    return response()->json(['msg' => 'Quantity Is more than product stock'],200);
                }

                if (isset($product->id)) {
                    $checkIfProductExistsInCart = Cart::where('product_id', $product->id)->where('order_id', $order->id)->first();
                    if ($checkIfProductExistsInCart and $product->stock >= $request->count):
                        $checkIfProductExistsInCart->count = $checkIfProductExistsInCart->count + $request->count;
                        $checkIfProductExistsInCart->price = ($checkIfProductExistsInCart->price) + ($product->dealer_price * $request->count);
                        $checkIfProductExistsInCart->save();
                        $order->total = Cart::where('order_id', $order->id)->sum('price');
                        $order->save();
                    endif;

                } else {
                    $Cart = new Cart;
                    $Cart->count = $request->count;
                    $Cart->price = $product->price_discount * $request->count;
                    $Cart->product_id = $product->id;
                    $Cart->order_id = $order->id;
                    $Cart->save();
                    // $product->stock = $product->stock - $request->count;
                    // $product->save();
                    $order->total = Cart::where('order_id', $order->id)->sum('price');
                    $order->save();
                }

            }
            else {
                $product = Product::where('id', $request->id)->latest()->first();
                // Here Check For Quantity
                if ($product->stock < $request->count) {
                    return response()->json(['msg' => 'Quantity Is more than product stock'],200);
                }

                $order = new Order;
                $order->customer_id = $user_id;
                $order->status = 1;
                $order->customer_type = 'c';
                $order->total = 0;
                $order->save();

                $Cart = new Cart;
                $Cart->count = $request->count;
                $Cart->price = $product->price_discount * $Cart->count;
                $Cart->product_id = $product->id;
                $Cart->order_id = $order->id;
                $Cart->save();
                $product->stock = $product->stock - $request->count;
                $product->save();


                $order = Order::where('id', $order->id)->where('status', '1')->with('Carts')->latest()->first();
                $order->total = Cart::where('order_id', $order->id)->sum('price');
                $order->save();
            }
        }

        else {
            $order = Order::where('ip', $request->ip())->where('status', '1')->with('Carts')->latest()->first();
            if ($order) {
                $product = Product::where('id', $request->id)->latest()->first();
                // Here Check For Quantity
                if ($product->stock < $request->count) {
                    return response()->json(['msg' => 'Quantity Is more than product stock'],200);
                }

                if (isset($product->id)) {
                    $checkIfProductExistsInCart = Cart::where('product_id', $product->id)->where('order_id', $order->id)->first();
                    if ($checkIfProductExistsInCart and $product->stock >= $request->count):
                        $checkIfProductExistsInCart->count = $checkIfProductExistsInCart->count + $request->count;
                        $checkIfProductExistsInCart->price = ($checkIfProductExistsInCart->price) + ($product->dealer_price * $request->count);
                        $checkIfProductExistsInCart->save();
                        $order->total = Cart::where('order_id', $order->id)->sum('price');
                        $order->save();
                    endif;

                } else {
                    $Cart = new Cart;
                    $Cart->count = $request->count;
                    $Cart->price = $product->price_discount * $request->count;
                    $Cart->product_id = $product->id;
                    $Cart->order_id = $order->id;
                    $Cart->save();
                    // $product->stock = $product->stock - $request->count;
                    // $product->save();
                    $order->total = Cart::where('order_id', $order->id)->sum('price');
                    $order->save();
                }

            } else {
                $order = new Order;
                $order->ip = $request->ip();
                $order->status = 1;
                $order->customer_type = 'c';
                $order->total = 0;
                $order->save();

                $product = Product::where('id', $request->id)->latest()->first();
                // Here Check For Quantity
                if ($product->stock < $request->count) {
                    return response()->json(['msg' => 'Quantity Is more than product stock'],200);
                }

                $Cart = new Cart;
                $Cart->count = $request->count;
                $Cart->price = $product->price_discount * $Cart->count;
                $Cart->product_id = $product->id;
                $Cart->order_id = $order->id;
                $Cart->save();
                // $product->stock = $product->stock - $request->count;
                // $product->save();

                $order = Order::where('id', $order->id)->where('status', '1')->with('Carts')->latest()->first();
                $order->total = Cart::where('order_id', $order->id)->sum('price');
                $order->save();
            }
        }
        $product->pay_count = $product->pay_count + 1;
        $product->save();
        $Carts = Cart::where('order_id', $order->id)->get();
        $datas = count($Carts);

        $list = [];

        $list['total'] = $order->total;
        $list['id'] = $order->id;
        $list['count_items'] = $datas;

        return response()->json([
            'status' => 200,
            'message' => 'add is done',
            'data' => $list
        ], 200);
    }

    # home cart
    public function cart(Request $request)
    {
        $setting = Setting::first();
        // return response()->json(['data' => $request->header ]);
        if ($request->header('kind') == 'd') {
            // return response()->json(['data' => 'header kind d' ]);

            $token = $request->header('Authorization');
            $token = explode(' ', $token);
            $user = Dealer::where('api_token', $token[1])->first();

            $user_id = $user->id;
            $order = Order::where('dealer_id', $user_id)->where('status', '1')->with('Carts.Product', 'OrderProducts.Product')->latest()->first();


        } elseif ($request->header('kind') == 'c') {

            // return response()->json(['data' => 'header kind c' ]);


            $token = $request->header('Authorization');
            $token = explode(' ', $token);
            $user = Customer::where('api_token', $token[1])->first();

            $user_id = $user->id;
            $order = Order::where('customer_id', $user_id)->where('status', '1')->with('Carts.Product', 'OrderProducts.Product')->latest()->first();


        } else {

            $order = Order::where('ip', $request->ip())->where('status', '1')->with('Carts.Product', 'OrderProducts.Product')->latest()->first();
        }


        if (!$order) {
            $list['order_id'] = 0;
            $list['order_total'] = 0;

            $list['dilivary'] = 0;
            $list['Discount'] = 0;
            $list['grand_total'] = 0;
            $list['Carts'] = [];

            $msg = 'order not found';
            return response()->json([
                'status' => 200,
                'message' => 'no order',
                'data' => $list
            ], 200);
        }

        $list['order_id'] = $order->id;
        $list['order_total'] = $order->total;
        if (is_null($setting->dilivary)) {
            $list['dilivary'] = 0;
        } else {
            $list['dilivary'] = $setting->dilivary;
        }

        $list['Discount'] = 0;
        $list['grand_total'] = ($order->total + $setting->dilivary);


        // return response()->json(['data' => $order->Carts ]);

        if (count($order->Carts) == 0) {
            $list['Carts'] = [];
        } else {
            foreach ($order->Carts as $key => $val) {
                if (is_null($request->header("Accept-Language"))) {
                    $list['Carts'][$key]['name'] = $val->Product->name_ar;
                } elseif ($request->header("Accept-Language") == 'ar') {
                    $list['Carts'][$key]['name'] = $val->Product->name_ar;
                } else {
                    $list['Carts'][$key]['name'] = $val->Product->name_en;
                }

                // return response()->json(['data' => $key ]);


                $list['Carts'][$key]['cart_id'] = $val->id;


                $list['Carts'][$key]['id'] = $val->product_id;
                $list['Carts'][$key]['Image'] = URL::to($val->Product->card_image);
                $list['Carts'][$key]['rate'] = $val->Product->rate;
                if ($request->header('kind') == 'd') {
                    $list['Carts'][$key]['price'] = $val->Product->dealer_price;
                } else {
                    $list['Carts'][$key]['price'] = $val->Product->price_discount;
                }

                $list['Carts'][$key]['price_old'] = $val->Product->price;
                $list['Carts'][$key]['count'] = $val->count;

            }
        }

        return response()->json([
            'status' => 200,
            'message' => 'cart page',
            'data' => $list
        ], 200);


    }

    # countcart
    public function countcart(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'count' => 'required',
        ]);

        foreach ((array)$validator->errors() as $value) {
            if (isset($value['id'])) {
                $msg = 'id is required';
                return response()->json([
                    'message' => $msg,
                    'status' => 400,
                ], 400);
            } elseif (isset($value['count'])) {
                $msg = 'count is required';
                return response()->json([
                    'message' => $msg,
                    'status' => 400,
                ], 400);
            }
        }
        $setting = Setting::first();

        $Cart = Cart::with('Order')->where('id', $request->id)->latest()->first();

        $product = Product::where('id', $Cart->product_id)->latest()->first();

        $Cass = $Cart->count - $request->count;

        $product->stock = $product->stock - $Cass;
        $product->save();
        $Cart->count = $request->count;
        if ($request->header('kind') == 'd') {

            $Cart->price = $product->dealer_price * $request->count;
        } else {
            $Cart->price = $product->price_discount * $request->count;
        }

        $Cart->save();

        $order = Order::where('id', $Cart->order_id)->where('status', '1')->with('Carts.Product', 'OrderProducts.Product')->latest()->first();


        $order->total = Cart::where('order_id', $order->id)->sum('price');
        $order->save();

        $Carts = Cart::where('order_id', $order->id)->get();

        $setting = Setting::first();

        $datas = count($Carts);

        $total = ($order->total + $setting->dilivary) - $setting->tax_rate;

        $list['order_id'] = $order->id;
        $list['order_total'] = $order->total;
        if (is_null($setting->dilivary)) {
            $list['dilivary'] = 0;
        } else {
            $list['dilivary'] = $setting->dilivary;
        }

        $list['Discount'] = 0;
        $list['grand_total'] = ($order->total + $setting->dilivary);

        if (count($order->Carts) == 0) {
            $list['Carts'] = [];
        } else {
            foreach ($order->Carts as $key => $val) {
                if (is_null($request->header("Accept-Language"))) {
                    $list['Carts'][$key]['name'] = $val->Product->name_ar;
                } elseif ($request->header("Accept-Language") == 'ar') {
                    $list['Carts'][$key]['name'] = $val->Product->name_ar;
                } else {
                    $list['Carts'][$key]['name'] = $val->Product->name_en;
                }


                $list['Carts'][$key]['id'] = $val->id;
                $list['Carts'][$key]['Image'] = URL::to($val->Product->card_image);
                $list['Carts'][$key]['rate'] = $val->Product->rate;
                if ($request->header('kind') == 'd') {
                    $list['Carts'][$key]['price'] = $val->Product->dealer_price;
                } else {
                    $list['Carts'][$key]['price'] = $val->Product->price_discount;
                }

                $list['Carts'][$key]['price_old'] = $val->Product->price;
                $list['Carts'][$key]['count'] = $val->count;

            }
        }

        return response()->json([
            'status' => 200,
            'message' => 'count is done',
            'data' => $list
        ], 200);

    }

    # delete order
    public function Deleteorder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',


        ]);

        foreach ((array)$validator->errors() as $value) {
            if (isset($value['id'])) {
                $msg = 'id is required';
                return response()->json([
                    'message' => $msg,
                    'status' => 400,
                ], 400);
            }
        }
        $order = Order::where('id', $request->id)->latest()->first();
        if (!$order) {
            $msg = 'order not found';
            return response()->json([
                'status' => 400,
                'message' => $msg,
            ], 400);
        }

        $order->delete();
        return response()->json([
            'status' => 200,
            'message' => 'delete is done',
        ], 200);
    }


    public function deleteItemFromCart(Request $request)
    {

        // return response()->json(['message' => 'Yes']);
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        foreach ((array)$validator->errors() as $value) {
            if (isset($value['id'])) {
                $msg = 'Product ID Is Required';
                return response()->json([
                    'message' => $msg,
                    'status' => 400,
                ], 400);
            }
        }

        $Cart = Cart::with('Order')
            ->where('id', $request->id)
            ->latest()
            ->first();


        if (!$Cart) {
            $msg = 'Cart Was Not Found';
            return response()->json([
                'message' => $msg,
                'status' => 404,
            ], 400);
        }

        // $order = Order::query()->where('id', $Cart->order_id)->where('status', '1')->with('Carts')->latest()->first();
        $order = Order::query()->where('id', $Cart->order_id)->where('status', '1')->with('Carts')->latest()->first();

        $Cart->delete();

        $order->total = Cart::query()->where('order_id', $order->id)->sum('price');
        $order->save();

        $Carts = Cart::query()->where('order_id', $order->id)->get();

        $setting = Setting::query()->first();

        $datas = count($Carts);

        $total = $order->total - $setting->tax_rate;
        if ($datas == '0') {
            $order->delete();
        }

        return response()->json([
            'status' => 200,
            'message' => 'Product Deleted Successfully',
        ], 200);
        // return response()->json(['datas' => $order->total, 'total' => $total, 'cat_count' => $datas] , 200);
    }

    # home cart
    public function cartdetial(Request $request)
    {
        $setting = Setting::first();

        $sections = $request->cards;
        $copon = $request->copon;


        $list = [];
        $sum = [];


        if (is_null($setting->dilivary)) {
            $list['dilivary'] = 0;
        } else {
            $list['dilivary'] = $setting->dilivary;
        }


        foreach ($sections as $key => $cat) {
            $sum[] = (int)$cat['price'] * (int)$cat['count'];
        }
        $total = array_sum($sum);
        $list['grand_total'] = $total;


        if (!is_null($copon)) {
            $coupon = Coupon::where('code', $request->copon)->first();

            if (!$coupon) {
                $total = ($total + $setting->dilivary);
                $mess = trans('messages.wrong_coupon_code');
                $capp = 0;
            } else {
                $date = $coupon->end_date;
                $dif = Carbon::now();

                if ($dif > $date) {
                    $total = ($total + $setting->dilivary);
                    $mess = trans('messages.date_coupon');
                    $capp = 0;


                } else {
                    if ($coupon->total_uses_number == 0) {
                        $total = ($total + $setting->dilivary);
                        $mess = trans('messages.total_coupon_uses');
                        $capp = 0;

                    } else {

                        if ($request->header('kind') == 'd') {
                            $user_id = session('customer')->id;
                            $user_uses = Order::where([['coupon_id', $coupon->id], ['dealer_id', $user_id]])->count();
                        } elseif ($request->header('kind') == 'c') {
                            $user_id = session('customer')->id;
                            $user_uses = Order::where([['coupon_id', $coupon->id], ['customer_id', $user_id]])->count();

                        }

                        # check user uses

                        if ($user_uses >= $coupon->user_uses_number) {
                            $total = ($total + $setting->dilivary);
                            $mess = trans('messages.user_coupon_uses');
                            $capp = 0;

                        } else {


                            if ($coupon->type == 'percent') {
                                $coupon_discount = $coupon->discount;
                                $calc_discount = ($total * $coupon->discount) / 100;
                                $capp = $calc_discount;
                            } else {

                                $capp = $coupon->discount;
                            }

                        }


                    }

                }


            }
            $list['Discount'] = round($capp, 0);
            $list['copon_code'] = $request->copon;
            $list['order_total'] = (int)($total + $setting->dilivary) - (int)$capp;
            $mess = 'تم ادخال الكبون';

        } else {
            $list['Discount'] = 0;
            $list['copon_code'] = $request->copon;
            $list['order_total'] = ($total + $setting->dilivary);
            $mess = "cart detials without copon";
        }

        return response()->json([
            'status' => 200,
            'message' => $mess,
            'data' => $list
        ], 200);


    }

    # home cart
    public function addorder(Request $request)
    {
        $setting = Setting::first();

        $sections = $request->cards;
        $copon = $request->copon;


        $list = [];
        $sum = [];


        if (is_null($setting->dilivary)) {
            $list['dilivary'] = 0;
        } else {
            $list['dilivary'] = $setting->dilivary;
        }

        foreach ($sections as $key => $cat) {
            $product = Product::where('id', $cat['id'])->latest()->first();

            if ($request->header('kind') == 'd') {
                $token = $request->header('Authorization');
                $token = explode(' ', $token);
                $user = Dealer::where('api_token', $token[1])->first();

                $user_id = $user->id;
                $order = Order::where('dealer_id', $user_id)->where('status', '1')->with('Carts')->latest()->first();

                if ($order) {
                    $product = Product::where('id', $cat['price'])->latest()->first();
                    $Cart = new Cart;
                    $Cart->count = $cat['count'];
                    $Cart->price = $product->dealer_price * (int)$cat['count'];
                    $Cart->product_id = $product->id;
                    $Cart->order_id = $order->id;
                    $Cart->save();
                    $product->stock = $product->stock - $cat['count'];
                    $product->save();

                    $order->total = Cart::where('order_id', $order->id)->sum('price');

                    $order->save();

                } else {
                    $order = new Order;
                    $order->dealer_id = $user_id;
                    $order->status = 1;
                    $order->customer_type = 'd';
                    $order->total = 0;
                    $order->save();

                    $product = Product::where('id', $cat['id'])->latest()->first();
                    $Cart = new Cart;
                    $Cart->count = $cat['count'];
                    $Cart->price = $product->dealer_price * (int)$cat['count'];
                    $Cart->product_id = $product->id;
                    $Cart->order_id = $order->id;
                    $Cart->save();
                    $product->stock = $product->stock - $cat['count'];
                    $product->save();

                    $order = Order::where('id', $order->id)->where('status', '1')->with('Carts')->latest()->first();
                    $order->total = Cart::where('order_id', $order->id)->sum('price');
                    $order->save();

                }


            } elseif ($request->header('kind') == 'c') {

                $token = $request->header('Authorization');
                $token = explode(' ', $token);
                $user = Customer::where('api_token', $token[1])->first();

                $user_id = $user->id;
                $order = Order::where('customer_id', $user_id)->where('status', '1')->with('Carts')->latest()->first();
                if ($order) {
                    $product = Product::where('id', $cat['id'])->latest()->first();
                    $Cart = new Cart;
                    $Cart->count = $cat['count'];
                    $Cart->price = $product->price_discount * (int)$cat['count'];
                    $Cart->product_id = $product->id;
                    $Cart->order_id = $order->id;
                    $Cart->save();
                    $product->stock = $product->stock - $cat['count'];
                    $product->save();

                    $order->total = Cart::where('order_id', $order->id)->sum('price');
                    $order->save();
                } else {
                    $order = new Order;
                    $order->customer_id = $user_id;
                    $order->status = 1;
                    $order->customer_type = 'c';
                    $order->total = 0;
                    $order->save();

                    $product = Product::where('id', $cat['id'])->latest()->first();
                    $Cart = new Cart;
                    $Cart->count = $cat['count'];
                    $Cart->price = $product->price_discount * (int)$cat['count'];
                    $Cart->product_id = $product->id;
                    $Cart->order_id = $order->id;
                    $Cart->save();
                    $product->stock = $product->stock - $cat['count'];
                    $product->save();

                    $order = Order::where('id', $order->id)->where('status', '1')->with('Carts')->latest()->first();
                    $order->total = Cart::where('order_id', $order->id)->sum('price');
                    $order->save();
                }


            } else {

                $order = Order::where('ip', $request->ip())->where('status', '1')->with('Carts')->latest()->first();
                if ($order) {
                    $product = Product::where('id', $cat['id'])->latest()->first();
                    $Cart = new Cart;
                    $Cart->count = $cat['count'];
                    $Cart->price = $product->price_discount * $cat['count'];
                    $Cart->product_id = $product->id;
                    $Cart->order_id = $order->id;
                    $Cart->save();
                    $product->stock = $product->stock - $cat['count'];
                    $product->save();


                    $order->total = Cart::where('order_id', $order->id)->sum('price');
                    $order->save();
                } else {
                    $order = new Order;
                    $order->ip = $request->ip();
                    $order->status = 1;
                    $order->customer_type = 'c';
                    $order->total = 0;
                    $order->save();

                    $product = Product::where('id', $cat['id'])->latest()->first();
                    $Cart = new Cart;
                    $Cart->count = $cat['count'];
                    $Cart->price = $product->price_discount * $cat['count'];
                    $Cart->product_id = $product->id;
                    $Cart->order_id = $order->id;
                    $Cart->save();

                    $product->stock = $product->stock - $cat['count'];
                    $product->save();


                    $order = Order::where('id', $order->id)->where('status', '1')->with('Carts')->latest()->first();
                    $order->total = Cart::where('order_id', $order->id)->sum('price');
                    $order->save();
                }


            }
            $product->pay_count = $product->pay_count + 1;
            $product->save();
            $Carts = Cart::where('order_id', $order->id)->get();
            $datas = count($Carts);

        }
        $total = $order->total;


        $validator = Validator::make($request->all(), [
            'name_first' => 'required',
            'name_last' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'email_code' => 'required',
            'address' => 'required',
            'desc' => 'required',
            'pay_type' => 'required',
        ]);

        foreach ((array)$validator->errors() as $value) {
            if (isset($value['name_first'])) {
                $msg = 'name_first is required';
                return response()->json([
                    'message' => $msg,
                    'status' => 400,
                ], 400);
            } elseif (isset($value['name_last'])) {
                $msg = 'name_last is required';
                return response()->json([
                    'message' => $msg,
                    'status' => 400,
                ], 400);
            } elseif (isset($value['email'])) {
                $msg = 'email is not required';
                return response()->json([
                    'message' => $msg,
                    'status' => 400,
                ], 400);
            } elseif (isset($value['phone'])) {
                $msg = 'phone is not required';
                return response()->json([
                    'message' => $msg,
                    'status' => 400,
                ], 400);
            } elseif (isset($value['email_code'])) {
                $msg = 'email_code is not required';
                return response()->json([
                    'message' => $msg,
                    'status' => 400,
                ], 400);
            } elseif (isset($value['address'])) {
                $msg = 'address is not required';
                return response()->json([
                    'message' => $msg,
                    'status' => 400,
                ], 400);
            } elseif (isset($value['desc'])) {
                $msg = 'desc is not required';
                return response()->json([
                    'message' => $msg,
                    'status' => 400,
                ], 400);
            } elseif (isset($value['pay_type'])) {
                $msg = 'pay_type is not required';
                return response()->json([
                    'message' => $msg,
                    'status' => 400,
                ], 400);
            }
        }

        $info = new Order_info;
        $info->name_first = $request->name_first;
        $info->name_last = $request->name_last;
        $info->email = $request->email;
        $info->phone = $request->phone;
        $info->email_code = $request->email_code;
        $info->address = $request->address;
        $info->desc = $request->desc;
        $info->order_id = $order->id;
        $info->save();

        $order->pay_type = $request->pay_type;


        $list['order_id'] = $order->id;
        if ($order->pay_type == 1) {
            $order->status = 2;
            $order->save();
            $list['order_pay'] = 'Cash on Delivery';
            $list['link_pay'] = '';
        } else {
            $order->save();
            $list['order_pay'] = 'credit card';
            $list['link_pay'] = URL::to('create-checkout-session?id=' . $order->id);
        }

        foreach ($order->Carts as $val) {


            $prod = new Order_Product;
            $prod->count = $val->count;
            $prod->price = $val->price;
            $prod->product_id = $val->product_id;
            $prod->order_id = $val->order_id;
            $prod->save();
        }

        $Cart = Cart::where('order_id', $order->id)->delete();
        $order->total = Order_Product::where('order_id', $order->id)->sum('price');
        $order->save();

        if (!is_null($copon)) {
            $coupon = Coupon::where('code', $request->copon)->first();

            if (!$coupon) {
                $total = ($total + $setting->dilivary);
                $mess = trans('messages.wrong_coupon_code');
                $capp = 0;
            } else {
                $date = $coupon->end_date;
                $dif = Carbon::now();

                if ($dif > $date) {
                    $total = ($total + $setting->dilivary);
                    $mess = trans('messages.date_coupon');
                    $capp = 0;


                } else {
                    if ($coupon->total_uses_number == 0) {
                        $total = ($total + $setting->dilivary);
                        $mess = trans('messages.total_coupon_uses');
                        $capp = 0;

                    } else {

                        if ($request->header('kind') == 'd') {
                            $user_id = session('customer')->id;
                            $user_uses = Order::where([['coupon_id', $coupon->id], ['dealer_id', $user_id]])->count();
                        } elseif ($request->header('kind') == 'c') {
                            $user_id = session('customer')->id;
                            $user_uses = Order::where([['coupon_id', $coupon->id], ['customer_id', $user_id]])->count();

                        }

                        # check user uses

                        if ($user_uses >= $coupon->user_uses_number) {
                            $total = ($total + $setting->dilivary);
                            $mess = trans('messages.user_coupon_uses');
                            $capp = 0;

                        } else {


                            if ($coupon->type == 'percent') {
                                $coupon_discount = $coupon->discount;
                                $calc_discount = ($total * $coupon->discount) / 100;
                                $capp = $calc_discount;
                            } else {

                                $capp = $coupon->discount;
                            }

                        }


                    }

                }


            }
            $list['grand_total'] = round($total, 0);
            $order->total = (int)($total + $setting->dilivary) - (int)$capp;
            $order->coupon_id = $coupon->id;
            $order->save();
            $list['Discount'] = round($capp, 0);
            $list['copon_code'] = $request->copon;
            $list['order_total'] = (int)($total + $setting->dilivary) - (int)$capp;
            $mess = 'تم ادخال الكبون';

        } else {
            $list['grand_total'] = round($total, 0);
            $list['Discount'] = 0;
            $list['copon_code'] = $request->copon;
            $list['order_total'] = ($total + $setting->dilivary);
            $mess = "cart detials without copon";
        }

        return response()->json([
            'status' => 200,
            'message' => 'تم انهاء الطلب',
            'data' => $list
        ], 200);


    }


    # orders
    public function myorders(Request $request)
    {

        $list = [];
        if ($request->header('kind') == 'd') {
            $user_id = session('customer')->id;
            $orders = Order::where('dealer_id', $user_id)->where('status', '!=', '1')->with('OrderProducts.Product')->latest()->get();

        } elseif ($request->header('kind') == 'c') {
            $user_id = session('customer')->id;
            $orders = Order::where('customer_id', $user_id)->where('status', '!=', '1')->with('OrderProducts.Product')->latest()->get();

        }

        if (count($orders) == 0) {
            $list['orders'] = [];
        } else {
            foreach ($orders as $key => $pan) {
                if (is_null($request->header("Accept-Language"))) {
                    if ($pan->status == 1) {
                        $list['orders'][$key]['status'] = ' اكمال الطلب';
                    } elseif ($pan->status == 2) {
                        $list['orders'][$key]['status'] = ' جارى التجهيز';
                    } elseif ($pan->status == 3) {
                        $list['orders'][$key]['status'] = 'في الطريق';
                    } elseif ($pan->status == 4) {
                        $list['orders'][$key]['status'] = ' تم استلامها';
                    }
                } elseif ($request->header("Accept-Language") == 'ar') {
                    if ($pan->status == 1) {
                        $list['orders'][$key]['status'] = ' اكمال الطلب';
                    } elseif ($pan->status == 2) {
                        $list['orders'][$key]['status'] = ' جارى التجهيز';
                    } elseif ($pan->status == 3) {
                        $list['orders'][$key]['status'] = 'في الطريق';
                    } elseif ($pan->status == 4) {
                        $list['orders'][$key]['status'] = ' تم استلامها';
                    }
                } else {
                    if ($pan->status == 1) {
                        $list['orders'][$key]['status'] = 'Complete the order';
                    } elseif ($pan->status == 2) {
                        $list['orders'][$key]['status'] = ' Processing';
                    } elseif ($pan->status == 3) {
                        $list['orders'][$key]['status'] = 'on way';
                    } elseif ($pan->status == 4) {
                        $list['orders'][$key]['status'] = ' received';
                    }
                }

                $list['orders'][$key]['order_num'] = $pan->id;
                $list['orders'][$key]['date'] = Date::parse($pan->created_at)->format('Y-m-d');
                if (count($pan->OrderProducts) > 0) {
                    $list['orders'][$key]['image'] = URL::to($pan->OrderProducts[0]->Product->card_image);

                } else {
                    $list['orders'][$key]['image'] = URL::to('https://static.thenounproject.com/png/3482632-200.png');
                }


            }
        }

        # favourites & card
        if (!is_null($request->header('Authorization'))) {
            $token = $request->header('Authorization');
            $token = explode(' ', $token);
            if (count($token) == 2) {
                if ($request->header('kind') == 'c') {

                    $user_id = Customer::where('api_token', $token[1])->first();

                    $lik = Pro_Like::where('customer_id', $user_id->id)->get();

                    $order = Order::where('status', '1')->where('customer_id', $user_id->id)->with('Carts')->latest()->first();

                    if (!$lik) {
                        $list['favourites'] = 0;
                    } else {
                        $list['favourites'] = count($lik);
                    }
                    if (!$order) {
                        $list['card'] = 0;
                    } else {
                        $list['card'] = count($order->Carts);
                    }
                } elseif ($request->header('kind') == 'd') {
                    $user_id = Dealer::where('api_token', $token[1])->first();

                    $lik = Pro_Like::where('dealer_id', $user_id->id)->get();

                    $order = Order::where('status', '1')->where('dealer_id', $user_id->id)->with('Carts')->latest()->first();

                    if (!$lik) {
                        $list['favourites'] = 0;
                    } else {
                        $list['favourites'] = count($lik);
                    }
                    if (!$order) {
                        $list['card'] = 0;
                    } else {
                        $list['card'] = count($order->Carts);
                    }
                }
            } else {
                $list['favourites'] = '0';
                $list['card'] = '0';
            }
        } else {
            $list['favourites'] = '0';
            $list['card'] = '0';
        }

        return response()->json([
            'status' => 200,
            'message' => 'my orders',
            'data' => $list
        ], 200);

    }

    # detials  orders page
    public function detialsorder(Request $request)
    {
        $id = $request->input("id");
        $setting = Setting::first();

        $order = Order::where('id', $id)->with('OrderProducts.Product')->latest()->first();
        if (!$order) {
            $msg = 'order not found';
            return response()->json([
                'status' => 400,
                'message' => $msg,
            ], 400);
        }


        $list = [];

        $list['order_id'] = $order->id;
        if (!is_null($order->coupon_id)) {
            $coupon = Coupon::where('id', $order->coupon_id)->first();


            if ($coupon->type == 'percent') {
                $coupon_discount = $coupon->discount;
                $calc_discount = ($order->total * $coupon->discount) / 100;
                $capp = $calc_discount;
            } else {

                $capp = $coupon->discount;
            }

            $total = (int)($order->total - $setting->dilivary) + (int)$capp;
            $list['grand_total'] = round($total, 0);
            $list['Discount'] = round($capp, 0);
            $list['grand_total'] = $order->total;

        } else {
            $total = ($order->total + $setting->dilivary);
            $list['order_total'] = round($total, 0);
            $list['Discount'] = 0;
            $list['grand_total'] = $order->total;
        }

        if ($order->pay_type == 1) {
            $list['order_pay'] = 'Cash on Delivery';
        } else {
            $list['order_pay'] = 'credit card';
        }
        if (is_null($setting->dilivary)) {
            $list['dilivary'] = 0;
        } else {
            $list['dilivary'] = $setting->dilivary;
        }


        if (is_null($request->header("Accept-Language"))) {
            if ($order->status == 1) {
                $list['status'] = ' اكمال الطلب';
                $list['status_code'] = 'Complete_order';
            } elseif ($order->status == 2) {
                $list['status'] = ' جارى التجهيز';
                $list['status_code'] = 'Processing';
            } elseif ($order->status == 3) {
                $list['status'] = 'في الطريق';
                $list['status_code'] = 'on_way';
            } elseif ($order->status == 4) {
                $list['status'] = ' تم استلامها';
                $list['status_code'] = 'received';
            }
        } elseif ($request->header("Accept-Language") == 'ar') {
            if ($order->status == 1) {
                $list['status'] = ' اكمال الطلب';
                $list['status_code'] = 'Complete_order';
            } elseif ($order->status == 2) {
                $list['status'] = ' جارى التجهيز';
                $list['status_code'] = 'Processing';
            } elseif ($order->status == 3) {
                $list['status'] = 'في الطريق';
                $list['status_code'] = 'on_way';
            } elseif ($order->status == 4) {
                $list['status'] = ' تم استلامها';
                $list['status_code'] = 'received';
            }
        } else {
            if ($order->status == 1) {
                $list['status'] = 'Complete the order';
                $list['status_code'] = 'Complete_order';
            } elseif ($order->status == 2) {
                $list['status'] = ' Processing';
                $list['status_code'] = 'Processing';
            } elseif ($order->status == 3) {
                $list['status'] = 'on way';
                $list['status_code'] = 'on_way';
            } elseif ($order->status == 4) {
                $list['status'] = ' received';
                $list['status_code'] = 'received';

            }
        }


        if (count($order->OrderProducts) == 0) {
            $list['Carts'] = [];
        } else {
            foreach ($order->OrderProducts as $key => $val) {
                if (is_null($request->header("Accept-Language"))) {
                    $list['Carts'][$key]['name'] = $val->Product->name_ar;
                } elseif ($request->header("Accept-Language") == 'ar') {
                    $list['Carts'][$key]['name'] = $val->Product->name_ar;
                } else {
                    $list['Carts'][$key]['name'] = $val->Product->name_en;
                }


                $list['Carts'][$key]['id'] = $val->id;
                $list['Carts'][$key]['Image'] = URL::to($val->Product->card_image);
                $list['Carts'][$key]['rate'] = $val->Product->rate;
                if ($request->header('kind') == 'd') {
                    $list['Carts'][$key]['price'] = round($val->Product->dealer_price, 0);
                } else {
                    $list['Carts'][$key]['price'] = round($val->Product->price_discount, 0);
                }

                $list['Carts'][$key]['price_old'] = round($val->Product->price, 0);
                $list['Carts'][$key]['count'] = $val->count;

            }
        }

        # favourites & card
        if (!is_null($request->header('Authorization'))) {
            $token = $request->header('Authorization');
            $token = explode(' ', $token);
            if (count($token) == 2) {
                if ($request->header('kind') == 'c') {

                    $user_id = Customer::where('api_token', $token[1])->first();

                    $lik = Pro_Like::where('customer_id', $user_id->id)->get();

                    $order = Order::where('status', '1')->where('customer_id', $user_id->id)->with('Carts')->latest()->first();

                    if (!$lik) {
                        $list['favourites'] = 0;
                    } else {
                        $list['favourites'] = count($lik);
                    }
                    if (!$order) {
                        $list['card'] = 0;
                    } else {
                        $list['card'] = count($order->Carts);
                    }
                } elseif ($request->header('kind') == 'd') {
                    $user_id = Dealer::where('api_token', $token[1])->first();

                    $lik = Pro_Like::where('dealer_id', $user_id->id)->get();

                    $order = Order::where('status', '1')->where('dealer_id', $user_id->id)->with('Carts')->latest()->first();

                    if (!$lik) {
                        $list['favourites'] = 0;
                    } else {
                        $list['favourites'] = count($lik);
                    }
                    if (!$order) {
                        $list['card'] = 0;
                    } else {
                        $list['card'] = count($order->Carts);
                    }
                }
            } else {
                $list['favourites'] = '0';
                $list['card'] = '0';
            }
        } else {
            $list['favourites'] = '0';
            $list['card'] = '0';
        }


        return response()->json([
            'status' => 200,
            'message' => 'show order detials',
            'data' => $list
        ], 200);

    }

    # title  orders page
    public function titleorder(Request $request)
    {


        $list = [];
        if ($request->header('kind') == 'd') {
            $ords = Order::where('dealer_id', session('customer')->id)->pluck('id')->toArray();
            $infords = Order_info::whereIn('order_id', $ords)->latest()->get();

        } else if ($request->header('kind') == 'c') {
            $ords = Order::where('customer_id', session('customer')->id)->pluck('id')->toArray();
            $infords = Order_info::whereIn('order_id', $ords)->latest()->get();
        }


        if (count($infords) == 0) {
            $list['titles'] = [];
        } else {
            foreach ($infords as $key => $val) {

                $list['titles'][$key]['id'] = $val->id;
                $list['titles'][$key]['name_first'] = $val->name_first;
                $list['titles'][$key]['name_last'] = $val->name_last;
                $list['titles'][$key]['address'] = $val->address;
                $list['titles'][$key]['email_code'] = $val->email_code;
                $list['titles'][$key]['email'] = $val->email;
                $list['titles'][$key]['phone'] = $val->phone;
                $list['titles'][$key]['desc'] = $val->desc;


            }
        }


        return response()->json([
            'status' => 200,
            'message' => 'show order titles',
            'data' => $list
        ], 200);

    }


    # delete title
    public function Deletetitle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',


        ]);

        foreach ((array)$validator->errors() as $value) {
            if (isset($value['id'])) {
                $msg = 'id is required';
                return response()->json([
                    'message' => $msg,
                    'status' => 400,
                ], 400);
            }
        }
        $order = Order_info::where('id', $request->id)->latest()->first();
        if (!$order) {
            $msg = 'title not found';
            return response()->json([
                'status' => 400,
                'message' => $msg,
            ], 400);
        }

        $order->delete();
        return response()->json([
            'status' => 200,
            'message' => 'delete is done',
        ], 200);
    }


}
