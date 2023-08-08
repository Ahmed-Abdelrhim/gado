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
use Illuminate\Support\Str;
use App\Pro_Like;
use App\Inbox;
use App\Product_Category;
use App\traits\N_COUPONS;
use App\Coupon;
use Carbon\Carbon;
use App;
use View;
use Hash;
use DB;
use URL;
use App\Http\Resources\productResource;
use Validator;

class ApiHomeController extends Controller
{

    # show Division
    public function showDivision(Request $request)
    {
        $data = Division::latest()->get();

        $list = [];

        foreach ($data as $key => $val) {
            $list[$key]['id'] = $val->id;
            if (is_null($request->header("Accept-Language"))) {
                $list[$key]['name'] = $val->name_ar;
            } elseif ($request->header("Accept-Language") == 'ar') {
                $list[$key]['name'] = $val->name_ar;
            } else {
                $list[$key]['name'] = $val->name_en;
            }


        }

        return response()->json([
            'status' => 200,
            'message' => 'show Division',
            'data' => $list
        ], 200);


    }

    # show lang
    public function lang(Request $request)
    {

        $list = [];


        $list['ar'] = 'ar';
        $list['en'] = 'en';

        return response()->json([
            'status' => 200,
            'message' => 'show language',
            'data' => $list
        ], 200);


    }

    # home page
    public function home(Request $request)
    {

        $data = Division::where('id', $request->header("section"))->with('Categories')->latest()->first();

        # get Pannars
        $slids = Pannar::where('type', '2')->where('kind', $request->header("section"))->inRandomOrder()->get();
        $pannns = Pannar::where('type', '1')->where('kind', $request->header("section"))->inRandomOrder()->take(2)->get();
        $pans = Pannar::where('type', '1')->where('kind', $request->header("section"))->inRandomOrder()->first();

        # get products
        $catss = Category::where('division_id', $request->header("section"))->with('Division')->pluck('id')->toArray();
        $procs = Product_Category::whereIn('category_id', $catss)->pluck('product_id')->toArray();
        $paies = Product::whereIn('id', $procs)->where('stock', '>', 0)->with('ProComments')->inRandomOrder()->orderby('pay_count', 'desc')->take(4)->get();
        $latest = Product::whereIn('id', $procs)->where('stock', '>', 0)->with('ProComments')->inRandomOrder()->latest()->take(4)->get();

        $list = [];

        # latest item
        if (count($latest) == 0) {
            $list['latest_products'] = [];
        } else {
            foreach ($latest as $key => $sec) {

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

                $list['latest_products'][$key]['id'] = $sec->id;
                $list['latest_products'][$key]['name'] = $name;
                $list['latest_products'][$key]['rate'] = $sec->rate;
                $list['latest_products'][$key]['old_price'] = $sec->price;
                $list['latest_products'][$key]['card_image'] = URL::to($sec->card_image);
                $list['latest_products'][$key]['rate_num'] = count($sec->ProComments);
                $list['latest_products'][$key]['discount'] = round($praaa, 0);
                $list['latest_products'][$key]['price_new'] = $price_new;
                $list['latest_products'][$key]['fav'] = $fav;


            }
        }


        # paies item
        if (count($paies) == 0) {
            $list['salaries_products'] = [];
        } else {
            foreach ($paies as $key => $val) {

                if (!is_null($request->header('Authorization'))) {
                    $token = $request->header('Authorization');
                    $token = explode(' ', $token);
                    if (count($token) == 2) {
                        if ($request->header('kind') == 'c') {
                            $price_new = $val->price_discount;

                            $user_id = Customer::where('api_token', $token[1])->first();

                            $lik = Pro_Like::where('customer_id', $user_id->id)->where('product_id', $val->id)->first();

                            if (!$lik) {
                                $fav = false;
                            } else {
                                $fav = true;
                            }

                        } elseif ($request->header('kind') == 'd') {
                            $price_new = $val->dealer_price;
                            $user_id = Dealer::where('api_token', $token[1])->first();

                            $lik = Pro_Like::where('dealer_id', $user_id->id)->where('product_id', $val->id)->first();
                            if (!$lik) {
                                $fav = false;
                            } else {
                                $fav = true;
                            }
                        }

                    } else {
                        $price_new = $val->price_discount;
                        $fav = false;
                    }


                } else {
                    $fav = false;
                    $price_new = $val->price_discount;
                }


                if (is_null($request->header("Accept-Language"))) {
                    $name = $val->name_ar;

                } elseif ($request->header("Accept-Language") == 'ar') {
                    $name = $val->name_ar;
                } else {
                    $name = $val->name_en;
                }
                $praaa = (1 - ($val->price_discount / $val->price)) * 100;

                $list['salaries_products'][$key]['id'] = $val->id;
                $list['salaries_products'][$key]['name'] = $name;
                $list['salaries_products'][$key]['rate'] = $val->rate;
                $list['salaries_products'][$key]['old_price'] = $val->price;
                $list['salaries_products'][$key]['card_image'] = URL::to($val->card_image);
                $list['salaries_products'][$key]['rate_num'] = count($val->ProComments);
                $list['salaries_products'][$key]['discount'] = round($praaa, 0);
                $list['salaries_products'][$key]['price_new'] = $price_new;
                $list['salaries_products'][$key]['fav'] = $fav;


            }
        }


        # Pannars item
        if (count($slids) == 0) {
            $list['sliders'] = [];
        } else {
            foreach ($slids as $key => $slid) {

                if (is_null($request->header("Accept-Language"))) {
                    $name = $slid->name_ar;
                    $desc = $slid->desc_ar;

                } elseif ($request->header("Accept-Language") == 'ar') {
                    $name = $slid->name_ar;
                    $desc = $slid->desc_ar;
                } else {
                    $name = $slid->name_en;
                    $desc = $slid->desc_en;
                }
                $list['sliders'][$key]['id'] = $slid->id;
                $list['sliders'][$key]['name'] = $name;
                $list['sliders'][$key]['desc'] = $desc;
                $list['sliders'][$key]['image'] = URL::to('uploads/panners/' . $slid->image);


            }
        }


        if (count($pannns) == 0) {
            $list['cards_ads'] = [];
        } else {
            foreach ($pannns as $key => $pan) {

                if (is_null($request->header("Accept-Language"))) {
                    $name = $pan->name_ar;
                    $desc = $pan->desc_ar;

                } elseif ($request->header("Accept-Language") == 'ar') {
                    $name = $pan->name_ar;
                    $desc = $pan->desc_ar;
                } else {
                    $name = $pan->name_en;
                    $desc = $pan->desc_en;
                }
                $list['cards_ads'][$key]['id'] = $pan->id;
                $list['cards_ads'][$key]['name'] = $name;
                $list['cards_ads'][$key]['desc'] = $desc;
                $list['cards_ads'][$key]['image'] = URL::to('uploads/panners/' . $pan->image);


            }
        }

        if (is_null($pans)) {
            $list['one_panner'] = [];
        } else {


            if (is_null($request->header("Accept-Language"))) {
                $name = $pans->name_ar;
                $desc = $pans->desc_ar;

            } elseif ($request->header("Accept-Language") == 'ar') {
                $name = $pans->name_ar;
                $desc = $pans->desc_ar;
            } else {
                $name = $pans->name_en;
                $desc = $pans->desc_en;
            }
            $list['one_panner']['id'] = $pans->id;
            $list['one_panner']['name'] = $name;
            $list['one_panner']['desc'] = $desc;
            $list['one_panner']['image'] = URL::to('uploads/panners/' . $pans->image);


        }

        # Categories item

        if (count($data->Categories) == 0) {

            $list['Categories'] = [];

        } else {
            foreach ($data->Categories as $key => $cat) {

                $dddddd = Product_Category::where('category_id', $cat->id)->pluck('product_id')->toArray();
                $prad = Product::where('id', $dddddd)->first();

                if (is_null($request->header("Accept-Language"))) {
                    $name = $cat->name_ar;
                } elseif ($request->header("Accept-Language") == 'ar') {
                    $name = $cat->name_ar;
                } else {
                    $name = $cat->name_en;
                }

                $list['Categories'][$key]['id'] = $cat->id;
                $list['Categories'][$key]['name'] = $name;
                $list['Categories'][$key]['image'] = $cat->image != "" ? URL::to('uploads/divisions_images/' . $cat->image) : "";


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
            'message' => 'home page',
            'data' => $list
        ], 200);

    }


    # edit profile
    public function editprofile(Request $request)
    {
        //chack kind
        if ($request->header('kind') == 'c') {
            $customer = Customer::where('id', session('customer')->id)->first();

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|unique:customers',
                'phone' => 'required|unique:customers',
            ]);


            foreach ((array)$validator->errors() as $value) {
                if (isset($value['name'])) {
                    $msg = 'name is required';
                    return response()->json([
                        'message' => $msg,
                        'status' => 400,
                    ], 400);
                } elseif (isset($value['email']) && is_null($request->email)) {
                    $msg = 'email is required';
                    return response()->json([
                        'message' => $msg,
                        'status' => 400,
                    ], 400);
                } elseif (isset($value['email']) && !is_null($request->email) && $customer->email != $request->email) {
                    $msg = 'email is already exist';
                    return response()->json([
                        'message' => $msg,
                        'status' => 400,
                    ], 400);
                } elseif (isset($value['phone']) && is_null($request->phone)) {
                    $msg = 'phone is required';
                    return response()->json([
                        'message' => $msg,
                        'status' => 400,
                    ], 400);
                } elseif (isset($value['phone']) && !is_null($request->phone) && $customer->phone != $request->phone) {
                    $msg = 'phone is already exist';
                    return response()->json([
                        'message' => $msg,
                        'status' => 400,
                    ], 400);
                }
            }


            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->save();

            $list['name'] = $customer->name;
            $list['email'] = $customer->email;
            $list['phone'] = $customer->phone;


        } elseif ($request->header('kind') == 'd') {
            $customer = Dealer::where('id', session('customer')->id)->first();
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|unique:dealers',
                'phone' => 'required|unique:dealers',
                'commercial_registration_num' => 'required',
                'tax_card_num' => 'required',

            ]);

            foreach ((array)$validator->errors() as $value) {
                if (isset($value['name'])) {
                    $msg = 'name is required';
                    return response()->json([
                        'message' => $msg,
                        'status' => 400,
                    ], 400);
                } elseif (isset($value['email']) && is_null($request->email)) {
                    $msg = 'email is required';
                    return response()->json([
                        'message' => $msg,
                        'status' => 400,
                    ], 400);
                } elseif (isset($value['email']) && !is_null($request->email) && $customer->email != $request->email) {
                    $msg = 'email is already exist';
                    return response()->json([
                        'message' => $msg,
                        'status' => 400,
                    ], 400);
                } elseif (isset($value['phone']) && is_null($request->phone)) {
                    $msg = 'phone is required';
                    return response()->json([
                        'message' => $msg,
                        'status' => 400,
                    ], 400);
                } elseif (isset($value['phone']) && !is_null($request->phone) && $customer->phone != $request->phone) {
                    $msg = 'phone is already exist';
                    return response()->json([
                        'message' => $msg,
                        'status' => 400,
                    ], 400);
                } elseif (isset($value['tax_card_num'])) {
                    $msg = 'tax card num is required';
                    return response()->json([
                        'message' => $msg,
                        'status' => 400,
                    ], 400);
                } elseif (isset($value['commercial_registration_num'])) {
                    $msg = 'commercial registration num is required';
                    return response()->json([
                        'message' => $msg,
                        'status' => 400,
                    ], 400);
                }
            }


            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->commercial_registration_num = $request->commercial_registration_num;
            $customer->tax_card_num = $request->tax_card_num;
            $customer->save();

            $list['name'] = $customer->name;
            $list['email'] = $customer->email;
            $list['phone'] = $customer->phone;

        }

        return response()->json([
            'message' => 'edit profile',
            'status' => 200,
            'data' => $list
        ], 200);

    }

    # edit profile password
    public function editprofilepassword(Request $request)
    {
        //chack kind
        if ($request->header('kind') == 'c') {

            $customer = Customer::where('id', session('customer')->id)->first();
            $validator = Validator::make($request->all(), [
                'password_old' => 'required',
                'password_new' => 'required',
                'con_password' => 'required',
            ]);

            foreach ((array)$validator->errors() as $value) {
                if (isset($value['password_old'])) {
                    $msg = 'password_old is required';
                    return response()->json([
                        'message' => $msg,
                        'status' => 400,
                    ], 400);
                } elseif (isset($value['password_new'])) {
                    $msg = 'password_new is required';
                    return response()->json([
                        'message' => $msg,
                        'status' => 400,
                    ], 400);
                } elseif (isset($value['con_password'])) {
                    $msg = 'password is not confirm';
                    return response()->json([
                        'message' => $msg,
                        'status' => 400,
                    ], 400);
                } elseif (!Hash::check($request->password_old, session('customer')->password)) {
                    $msg = 'password is not courect';
                    return response()->json([
                        'message' => $msg,
                        'status' => 400,
                    ], 400);
                } elseif ($request->password_new != $request->con_password) {
                    $msg = 'password is not confirm';
                    return response()->json([
                        'message' => $msg,
                        'status' => 400,
                    ], 400);
                }
            }

        } elseif ($request->header('kind') == 'd') {

            $customer = Dealer::where('id', session('customer')->id)->first();

            $validator = Validator::make($request->all(), [
                'password_old' => 'required',
                'password_new' => 'required',
                'con_password' => 'required',
            ]);

            foreach ((array)$validator->errors() as $value) {
                if (isset($value['password_old'])) {
                    $msg = 'password_old is required';
                    return response()->json([
                        'message' => $msg,
                        'status' => 400,
                    ], 400);
                } elseif (isset($value['password_new'])) {
                    $msg = 'password_new is required';
                    return response()->json([
                        'message' => $msg,
                        'status' => 400,
                    ], 400);
                } elseif (isset($value['con_password'])) {
                    $msg = 'password is not confirm';
                    return response()->json([
                        'message' => $msg,
                        'status' => 400,
                    ], 400);
                } elseif (!Hash::check($request->password_old, session('customer')->password)) {
                    $msg = 'password is not courect';
                    return response()->json([
                        'message' => $msg,
                        'status' => 400,
                    ], 400);
                } elseif ($request->password_new != $request->con_password) {
                    $msg = 'password is not confirm';
                    return response()->json([
                        'message' => $msg,
                        'status' => 400,
                    ], 400);
                }
            }

        }

        $customer->password = bcrypt($request->password_new);
        $customer->save();

        return response()->json([
            'message' => 'edit password is done',
            'status' => 200,
        ], 200);

    }

    # about us
    public function about(Request $request)
    {

        $list = [];


        $setting = Setting::first();

        if (is_null($request->header("Accept-Language"))) {
            $name = $setting->why_us_ar;

        } elseif ($request->header("Accept-Language") == 'ar') {
            $name = $setting->why_us_ar;

        } else {
            $name = $setting->why_us_en;
        }
        $list['about'] = $name;

        return response()->json([
            'status' => 200,
            'message' => 'about page',
            'data' => $list
        ], 200);

    }

    # terms
    public function terms(Request $request)
    {

        $list = [];


        $setting = Setting::first();

        if (is_null($request->header("Accept-Language"))) {
            $name = $setting->about_ar;

        } elseif ($request->header("Accept-Language") == 'ar') {
            $name = $setting->about_ar;

        } else {
            $name = $setting->about_en;
        }
        $list['about'] = $name;

        return response()->json([
            'status' => 200,
            'message' => 'terms page',
            'data' => $list
        ], 200);

    }


    # contuct us
    public function contuctus(Request $request)
    {

        $list = [];
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'desc' => 'required',
        ]);

        foreach ((array)$validator->errors() as $value) {
            if (isset($value['name'])) {
                $msg = 'name is required';
                return response()->json([
                    'message' => $msg,
                    'status' => 400,
                ], 400);
            } elseif (isset($value['email'])) {
                $msg = 'email is required';
                return response()->json([
                    'message' => $msg,
                    'status' => 400,
                ], 400);
            } elseif (isset($value['phone'])) {
                $msg = 'phone is required';
                return response()->json([
                    'message' => $msg,
                    'status' => 400,
                ], 400);
            } elseif (isset($value['desc'])) {
                $msg = 'desc is required';
                return response()->json([
                    'message' => $msg,
                    'status' => 400,
                ], 400);
            }
        }

        $info = new Inbox;
        $info->name = $request->name;

        $info->email = $request->email;
        $info->phone = $request->phone;

        $info->subject = $request->desc;

        $info->save();

        $list['name'] = $info->name;
        $list['email'] = $info->email;
        $list['phone'] = $info->phone;
        $list['subject'] = $info->subject;

        return response()->json([
            'status' => 200,
            'message' => 'terms page',
            'data' => $list
        ], 200);

    }


    // profile
    public function profileinf(Request $request)
    {

        //if user customer
        if ($request->header('kind') == 'c') {
            $customer = Customer::where('id', session('customer')->id)->first();


            $list['name'] = $customer->name;
            $list['email'] = $customer->email;
            $list['phone'] = $customer->phone;
            $list['api_token'] = $customer->api_token;

        } elseif ($request->header('kind') == 'd') {
            $customer = Dealer::where('id', session('customer')->id)->first();


            $list['name'] = $customer->name;
            $list['email'] = $customer->email;
            $list['phone'] = $customer->phone;
            $list['api_token'] = $customer->api_token;
            $list['commercial_registration_num'] = $customer->phone;
            $list['tax_card_num'] = $customer->api_token;

        }
        return response()->json([
            'message' => 'profile',
            'status' => 200,
            'data' => $list
        ], 200);

    }


}
