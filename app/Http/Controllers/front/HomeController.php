<?php

namespace App\Http\Controllers\front;

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
use Validator;
use App\Governorate;
use App\Services\HomeService;
class HomeController extends Controller
{
    use N_COUPONS;
    public $homeService;
    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    # home
    public function Home(Request $request, $id)
    {
        //$best_seller = Product::where()
        $data = Division::query()->where('id', $id)->with('Categories')->latest()->first();
        $catss = Category::query()->where('division_id', $id)->with('Division')->pluck('id')->toArray();


        $procs = Product_Category::query()->whereIn('category_id', $catss)->pluck('product_id')->toArray();


        $slids = Pannar::query()->where('type', '2')->inRandomOrder()->get();
        $pans = Pannar::query()->where('type', '1')->inRandomOrder()->first();
        $pannns = Pannar::query()->where('type', '1')->inRandomOrder()->take(2)->get();



        $paies = Product::query()->whereIn('id', $procs)->where('stock', '>', 0)->with('ProComments')
            ->inRandomOrder()->orderby('pay_count', 'desc')->take(4)->get();
        $latest = Product::query()->whereIn('id', $procs)->where('stock', '>', 0)->with('ProComments')
            ->inRandomOrder()->latest()->take(4)->get();


        $orders = Order::query()->where('status', '1')->latest()->get();
        $date = Carbon::today()->subDays(2);
        foreach ($orders as $key => $ord) {
            if ($ord->created_at < $date) {
                $ord->delete();
            }
        }
        $div = $id;

        return view('front.home.home', [
                'data'   => $data,
                'slids'  => $slids,
                'pans'   =>  $pans,
                'pannns' => $pannns,
                'paies'  => $paies,
                'latest' => $latest,
                'div'    => $div,
            ]);

    }

    public function change(Request $request)
    {
        App::setLocale($request->lang);
        session()->put('locale', $request->lang);

        return redirect()->back();
    }

    public function ser(Request $request, $div)
    {
        $data = Division::where('id', $div)->with('Categories')->latest()->first();
        if (Auth::guard('dealer')->check()) {
            $user_id = Auth::guard('dealer')->user()->id;
            $order = Order::where('status', '1')->where('dealer_id', $user_id)->with('Carts')->latest()->first();


        } elseif (Auth::guard('customer')->check()) {
            $user_id = Auth::guard('customer')->user()->id;

            $order = Order::where('status', '1')->where('customer_id', $user_id)->with('Carts')->latest()->first();


        } else {


            $order = Order::where('status', '1')->where('ip', $request->ip())->with('Carts')->latest()->first();

        }


        $pros = Product::where('stock', '>', 0)->where(function ($query) use ($request) {
            $query->where('name_ar', 'like', "%" . $request->search . "%");
            $query->orWhere('name_en', 'like', "%" . $request->search . "%");
        })->take(50)->with('ProComments')->latest()->get();

        return view('front.home.ser', compact('data', 'order', 'pros', 'div'));
    }


    public function order(Request $request)
    {

        $product = Product::where('id', $request->id)->latest()->first();

        if ($request->count > $product->stock) {
            $stock = $product->stock;
            return response()->json(['error' => true, 'errorMsg' => "العدد المتوفر لهذا المنتج فقط $stock قطعة"]);

        }

        if (Auth::guard('dealer')->check()) {

            $user_id = Auth::guard('dealer')->user()->id;
            $order = Order::where('dealer_id', $user_id)->where('status', '1')->with('Carts')->latest()->first();
            if ($order) {

                if ($cartOrderProduct = Cart::where(['order_id' => $order['id'], 'product_id' => $product['id']])->first()) {

                    if ($cartOrderProduct->count + 1 > $product->stock) {
                        $stock = $product->stock;
                        return response()->json(['error' => true, 'errorMsg' => "العدد المتوفر لهذا المنتج فقط $stock قطعة"]);

                    }


                    $cartOrderProduct->price += $product->price_discount * $cartOrderProduct->count;

                    $cartOrderProduct->count += $request->count;
                    $cartOrderProduct->save();


                } else {
                    $Cart = new Cart;
                    $Cart->count = $request->count;
                    $Cart->price = $product->dealer_price * $Cart->count;
                    $Cart->product_id = $product->id;
                    $Cart->order_id = $order->id;
                    $Cart->save();
                    $product->stock = $product->stock - $request->count;
                    $product->save();
                }


                $order->total = Cart::where('order_id', $order->id)->sum('price');
                $order->save();
            } else {
                $order = new Order;
                $order->dealer_id = Auth::guard('dealer')->user()->id;
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


        } elseif (Auth::guard('customer')->check()) {

            $user_id = Auth::guard('customer')->user()->id;
            $order = Order::where('customer_id', $user_id)->where('status', '1')->with('Carts')->latest()->first();

            if ($order) {

                if ($cartOrderProduct = Cart::where(['order_id' => $order['id'], 'product_id' => $product['id']])->first()) {


                    if ($cartOrderProduct->count + 1 > $product->stock) {
                        $stock = $product->stock;
                        return response()->json(['error' => true, 'errorMsg' => "العدد المتوفر لهذا المنتج فقط $stock قطعة"]);

                    }

                    $cartOrderProduct->price += $product->price_discount * $cartOrderProduct->count;

                    $cartOrderProduct->count += $request->count;
                    $cartOrderProduct->save();


                } else {
                    $Cart = new Cart;
                    $Cart->count = $request->count;
                    $Cart->price = $product->price_discount * $Cart->count;
                    $Cart->product_id = $product->id;
                    $Cart->order_id = $order->id;
                    $Cart->save();
                }


//                $product->stock = $product->stock - $request->count;
//                $product->save();

                $order->total = Cart::where('order_id', $order->id)->sum('price');
                $order->save();
            } else {
                $order = new Order;
                $order->customer_id = Auth::guard('customer')->user()->id;
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
//                $product->stock = $product->stock - $request->count;
//                $product->save();

                // $prod = new Order_Product ;
                // $prod->count =  1 ;
                // $prod->price =  $product->price_discount * $prod->count ;
                // $prod->product_id =  $product->id ;
                // $prod->order_id =  $order->id ;
                // $prod->save();

                $order = Order::where('id', $order->id)->where('status', '1')->with('Carts')->latest()->first();
                $order->total = Cart::where('order_id', $order->id)->sum('price');
                $order->save();
            }


        } else {

            $order = Order::where('ip', $request->ip())->where('status', '1')->with('Carts')->latest()->first();
            if ($order) {


                if ($cartOrderProduct = Cart::where(['order_id' => $order['id'], 'product_id' => $product['id']])->first()) {

                    $cartOrderProduct->price += $product->price_discount * $cartOrderProduct->count;

                    $cartOrderProduct->count += $request->count;
                    $cartOrderProduct->save();


                } else {
                    $Cart = new Cart;
                    $Cart->count = $request->count;
                    $Cart->price = $product->price_discount * $Cart->count;
                    $Cart->product_id = $product->id;
                    $Cart->order_id = $order->id;
                    $Cart->save();
//                $product->stock = $product->stock - $request->count;
//                $product->save();
                }


                $order->total = Cart::where('order_id', $order->id)->sum('price');
                $order->save();
            } else {
                $order = new Order;
                $order->ip = $request->ip();
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
//
//                $product->stock = $product->stock - $request->count;
//                $product->save();

                // $prod = new Order_Product ;
                // $prod->count =  1 ;
                // $prod->price =  $product->price_discount * $prod->count ;
                // $prod->product_id =  $product->id ;
                // $prod->order_id =  $order->id ;
                // $prod->save();

                $order = Order::where('id', $order->id)->where('status', '1')->with('Carts')->latest()->first();
                $order->total = Cart::where('order_id', $order->id)->sum('price');
                $order->save();
            }


        }
        $product->pay_count = $product->pay_count + 1;
        $product->save();
        $Carts = Cart::where('order_id', $order->id)->get();
        $datas = count($Carts);


        return response()->json(['datas' => $datas, 'total' => $order->total]);

    }

    # home cart
    public function cart(Request $request, $div)
    {
        $setting = Setting::first();

        $data = Division::where('id', $div)->with('Categories')->latest()->first();
        if (Auth::guard('dealer')->check()) {
            $user_id = Auth::guard('dealer')->user()->id;
            $order = Order::where('dealer_id', $user_id)->where('status', '1')->with('Carts.Product', 'OrderProducts.Product')->latest()->first();

            return view('front.cart.home', compact('data', 'order', 'setting', 'div'));
        } elseif (Auth::guard('customer')->check()) {
            $user_id = Auth::guard('customer')->user()->id;
            $order = Order::where('customer_id', $user_id)->where('status', '1')->with('Carts.Product', 'OrderProducts.Product')->latest()->first();

            return view('front.cart.home', compact('data', 'order', 'setting', 'div'));

        } else {
            $order = Order::where('ip', $request->ip())->where('status', '1')->with('Carts.Product', 'OrderProducts.Product')->latest()->first();
            return view('front.cart.home', compact('data', 'order', 'setting', 'div'));
        }


    }


    public function deletecart(Request $request)
    {
        $Cart = Cart::with('Order')->where('id', $request->id)->latest()->first();
        // $Cart->count =  $request->count ;

        $order = Order::where('id', $Cart->order_id)->where('status', '1')->with('Carts')->latest()->first();

        $Cart->delete();

        $order->total = Cart::where('order_id', $order->id)->sum('price');
        $order->save();

        $Carts = Cart::where('order_id', $order->id)->get();

        $setting = Setting::first();

        $datas = count($Carts);

        $total = $order->total - $setting->tax_rate;
        if ($datas == '0') {
            $order->delete();
        }
        return response()->json(['datas' => $order->total, 'total' => $total, 'cat_count' => $datas]);
    }

    public function copon(Request $request)
    {

        $copons = $this->CheckCoupon($request->copon, $request->id);

        $coupon = Coupon::where('code', $request->copon)->first();


        $mess = $copons->original['message'];
        $order = Order::where('id', $request->id)->with('Carts')->latest()->first();


        $order->total = Cart::where('order_id', $order->id)->sum('price');
        $order->save();

        $Carts = Cart::where('order_id', $order->id)->get();

        $setting = Setting::first();

        $datas = count($Carts);
        if (!$coupon) {
            $shipping_fee = ($order->Order_info()->first()->governorate_id) ? Governorate::find($order->Order_info()->first()->governorate_id)->shipping_fee : 0;
            $total = ($order->total + $shipping_fee) - $setting->tax_rate;
            $mess = trans('messages.wrong_coupon_code');
            $capp = 0;
        } else {
            $date = $coupon->end_date;
            $dif = Carbon::now();

            if ($dif > $date) {
                $shipping_fee = ($order->Order_info()->first()->governorate_id) ? Governorate::find($order->Order_info()->first()->governorate_id)->shipping_fee : 0;
                $total = ($order->total + $shipping_fee) - $setting->tax_rate;
                $mess = trans('messages.date_coupon');
                $capp = 0;


            } else {
                if ($coupon->total_uses_number == 0) {
                    $shipping_fee = ($order->Order_info()->first()->governorate_id) ? Governorate::find($order->Order_info()->first()->governorate_id)->shipping_fee : 0;
                    $total = ($order->total + $shipping_fee) - $setting->tax_rate;
                    $mess = trans('messages.total_coupon_uses');
                    $capp = 0;

                } else {
                    if (!is_null($order->coupon_id)) {
                        $shipping_fee = ($order->Order_info()->first()->governorate_id) ? Governorate::find($order->Order_info()->first()->governorate_id)->shipping_fee : 0;
                        $total = ($order->total + $shipping_fee) - $setting->tax_rate;
                        $mess = trans('messages.order_has_coupon');
                        $capp = 0;
                        $order->coupon_id = $coupon->id;
                        $order->save();


                    } else {

                        if (Auth::guard('dealer')->check()) {
                            $user_id = Auth::guard('dealer')->user()->id;
                            $user_uses = Order::where([['coupon_id', $coupon->id], ['dealer_id', $user_id]])->count();
                        } elseif (Auth::guard('customer')->check()) {
                            $user_id = Auth::guard('customer')->user()->id;
                            $user_uses = Order::where([['coupon_id', $coupon->id], ['customer_id', $user_id]])->count();

                        }

                        # check user uses

                        if ($user_uses >= $coupon->user_uses_number) {
                            $shipping_fee = ($order->Order_info()->first()->governorate_id) ? Governorate::find($order->Order_info()->first()->governorate_id)->shipping_fee : 0;
                            $total = ($order->total + $shipping_fee) - $setting->tax_rate;
                            $mess = trans('messages.user_coupon_uses');
                            $capp = 0;

                        } else {
                            $cop = $copons->original['data']['discount_amount'];
                            if (!$cop) {
                                $shipping_fee = ($order->Order_info()->first()->governorate_id) ? Governorate::find($order->Order_info()->first()->governorate_id)->shipping_fee : 0;
                                $total = ($order->total + $shipping_fee) - $setting->tax_rate;
                            } else {
                                $shipping_fee = ($order->Order_info()->first()->governorate_id) ? Governorate::find($order->Order_info()->first()->governorate_id)->shipping_fee : 0;
                                $totals = ($order->total + $shipping_fee) - $setting->tax_rate;
                                $total = $totals - $cop;
                                $order->total = $total;
                                $order->coupon_id = $coupon->id;
                                $order->save();
                                if ($coupon->type == 'percent') {
                                    $capp = $coupon->discount . '%';
                                } else {
                                    $capp = $coupon->discount . 'جنيه';
                                }


                            }
                        }
                    }

                }

            }


        }

        return response()->json(['datas' => $order->total, 'total' => $total, 'copons' => $mess, 'capp' => $capp]);

    }


    public function countcart(Request $request)
    {


        $Cart = Cart::with('Order')->where('id', $request->id)->latest()->first();

        $product = Product::where('id', $Cart->product_id)->latest()->first();


//        $Cass = $Cart->count - $request->count ;
//        $product->stock = $product->stock - $Cass;
//        $product->save();


        if ($request->count > $product->stock) {
            return response()->json(['error' => true, 'count' => $product->stock]);
        } else {
            $Cart->count = $request->count;
            if (Auth::guard('dealer')->check()) {
                $Cart->price = $product->dealer_price * $Cart->count;
            } else {
                $Cart->price = $product->price_discount * $Cart->count;
            }

            $Cart->save();

            $order = Order::where('id', $Cart->order_id)->where('status', '1')->with('Carts')->latest()->first();


            $order->total = Cart::where('order_id', $order->id)->sum('price');
            $order->save();

            $Carts = Cart::where('order_id', $order->id)->sum('count');

            $setting = Setting::first();

            $datas = ($Carts);

            $total = $order->total - $setting->tax_rate;
            if ($order->total == '0') {
                $order->delete();

            }


            return response()->json(['datas' => $order->total, 'total' => $total, 'cat_count' => $datas]);

        }


    }


    # det1
    public function detialsorder($div, $id)
    {
        $order = Order::query()->where('id', $id)->with('Carts')->latest()->first();

        if ($order->total < 200) {
            return redirect()->back()->with('msg', 'الحد الادني للطلب 200 !');
            ///  Session::flash('danger','الحد الادني للطلب 200 ! ');
            //      return back();

        }

        if (Auth::guard('dealer')->check()) {
            $orders = Order::where('dealer_id', Auth::guard('dealer')->user()->id)->skip(1)->latest()->first();
            $ords = Order::where('dealer_id', Auth::guard('dealer')->user()->id)->pluck('id')->toArray();
            //$infords = Order_info::whereIn('order_id',$ords)->latest()->get();
            //$infords = Order_info::whereIn('order_id',$ords)->latest()->get();
            $infords = Order_info::where('user_id', Auth::guard('dealer')->user()->id)->get();

        } else {
            $orders = Order::where('customer_id', Auth::guard('customer')->user()->id)->skip(1)->latest()->first();
            $ords = Order::where('customer_id', Auth::guard('customer')->user()->id)->pluck('id')->toArray();
            // $infords = Order_info::whereIn('order_id',$ords)->latest()->get();
            $infords = Order_info::where('user_id', Auth::guard('customer')->user()->id)->get();
        }


        $setting = Setting::first();

        $data = Division::where('id', $div)->with('Categories')->latest()->first();

        $governorates = Governorate::get();

        return view('front.cart.detial', compact('data', 'order', 'setting', 'div', 'infords', 'governorates'));
    }

    # det2
    public function detialstow(Request $request)
    {


        $order = Order::where('id', $request->id)->with('Carts')->latest()->first();

        if ($order['status'] > 1) {


            return redirect(route('front_order_detial', [1, $request->id]));
//            if ( $order['status']  == 2){
//                return  "طلبك تم الدفع من";
//            }

        }

        $setting = Setting::first();
        $data = Category::latest()->get();

        $merchantId = 'GADO_COOL';
        $password = '7b57cc84015c69f9602959ddcdb413d2';
        $url = 'https://banquemisr.gateway.mastercard.com/api/rest/version/62/merchant/' . $merchantId . '/session';


        $headers = array(
            'Content-Type:application/json',
            'Authorization: Basic ' . base64_encode('Merchant.' . $merchantId . ":" . $password) // <---
        );


        $url = $url;
        $ch = curl_init($url);
        curl_setopt_array($ch, array(
            CURLOPT_POST => TRUE,
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => $headers,
        ));

        $result = json_decode(curl_exec($ch));


        return view('front.cart.detial2', compact('data', 'order', 'setting', 'result'));
    }


    # det2
    public function storeinfo(Request $request)
    {

        $setting = Setting::first();
        $data = Category::latest()->get();
        if (is_null($request->adddd)) {
            if (is_null($request->inf_id)) {
                $order = Order::where('status', '1')->where('id', $request->id)->with('Carts')->latest()->first();


                $info = new Order_info;
                $info->name_first = $request->name_first;
                $info->name_last = $request->name_last;
                $info->email = $request->email;
                $info->phone = $request->phone;
                $info->email_code = $request->email_code;
                $info->address = $request->address;
                $info->desc = $request->desc;
                // $info->order_id    =  $order->id ;
                $info->governorate_id = $request->governorate_id;
                $info->user_id = $order->customer_id;

                $info->save();


                if ($info->governorate_id) {
                    $order->shipping = \App\Governorate::find($info->governorate_id)->shipping_fee;

                }

                $order->order_info_id = $info->id;
                $order->save();

            } else {

                $order = Order::where('status', '1')->where('id', $request->ord_id)->with('Carts')->latest()->first();
                $info = Order_info::find($request->inf_id);

                $info->name_first = $request->name_first;
                $info->name_last = $request->name_last;
                $info->email = $request->email;
                $info->phone = $request->phone;
                $info->email_code = $request->email_code;
                $info->address = $request->address;
                $info->desc = $request->desc;
                $info->order_id = $request->ord_id;
                $info->governorate_id = $request->governorate_id;
                $info->user_id = $order->customer_id;
                $info->save();
                if ($info->governorate_id) {
                    $order->shipping = \App\Governorate::find($info->governorate_id)->shipping_fee;
                }
                $order->order_info_id = $info->id;
                $order->save();
            }

        } else {
            $order = Order::where('status', '1')->where('id', $request->ord_id)->with('Carts')->latest()->first();

            $infos = Order_info::where('id', $request->adddd)->latest()->first();
            // dd($infos);
            // $info = new Order_info ;
            $infos->name_first = $infos->name_first;
            $infos->name_last = $infos->name_last;
            $infos->email = $infos->email;
            $infos->phone = $infos->phone;
            $infos->email_code = $infos->email_code;
            $infos->address = $infos->address;
            $infos->desc = $infos->desc;
            $infos->order_id = $request->ord_id;
            $infos->governorate_id = $infos->governorate_id;
            $infos->user_id = $order->customer_id;
            $infos->save();

            if ($infos->governorate_id) {
                $order->shipping = \App\Governorate::find($infos->governorate_id)->shipping_fee;
            }
            $order->order_info_id = $infos->id;
            $order->save();
        }


        return redirect()->route('front_pay_way', ['id' => $order->id, 'data' => $data, 'setting' => $setting]);

    }

    # delete orders
    public function Deleteinforders(Request $request)
    {

        $Orders = Order_info::findOrFail($request->id);
        $Orders->delete();

        return true;
    }

    # det3
    public function detialsthree(Request $request)
    {

        $order = Order::where('status', '1')->where('id', $request->id)->with('Carts')->latest()->first();
        $setting = Setting::first();
        $data = Category::latest()->get();


        return view('front.cart.detial3', compact('data', 'order', 'setting'));
    }


    # det3
    public function finnishinfo(Request $request)
    {


        $div = '1';
        $order = Order::where('status', '1')->where('id', $request->id)->with('Carts')->latest()->first();
        $setting = Setting::first();
        $data = Division::where('id', $div)->with('Categories')->latest()->first();

        $shippingValue = 0;

        if (!is_null($order->Order_info)) {
            $shippingValue = Governorate::find($order->Order_info()->first()->governorate_id)->shipping_fee;
        }


        foreach ($order->Carts as $val) {


            $prod = new Order_Product;
            $prod->count = $val->count;
            $prod->price = $val->price;
            $prod->product_id = $val->product_id;
            $prod->order_id = $val->order_id;
            $prod->save();
            // Discount Stock after order complete.
            $product = Product::where('id', $val->product_id)->latest()->first();
            $product->stock = $product->stock - $val->count;
            $product->save();
        }

        $Cart = Cart::where('order_id', $request->id)->delete();

        $order->shipping = $shippingValue;
        $order->pay_type = $request->type;
        $order->status = 2;
        $order->save();

        return redirect()->route('front_finnish_order', ['id' => $order->id, 'data' => $data, 'setting' => $setting, 'div' => $div]);

    }

    # pay succes
    public function pay2(Request $request)
    {

        $id = $request->input("id");
        $order = Order::where('id', $id)->with('Carts')->latest()->first();
        $setting = Setting::first();

        foreach ($order->Carts as $val) {


            $prod = new Order_Product;
            $prod->count = $val->count;
            $prod->price = $val->price;
            $prod->product_id = $val->product_id;
            $prod->order_id = $val->order_id;
            $prod->save();

            // Discount Stock after order complete.
            $product = Product::where('id', $val->product_id)->latest()->first();

            $product->stock = $product->stock - $val->count;


            $product->save();

        }

        $Cart = Cart::where('order_id', $request->id)->delete();

        $order->pay_type = 2;
        $order->status = 2;
        $order->save();

        return view('front.cart.pay2', compact('order', 'setting'));
    }

    # ppay filed
    public function pay3(Request $request)
    {

        $id = $request->input("id");
        $order = Order::where('id', $id)->with('Carts')->latest()->first();
        $setting = Setting::first();


        $order->pay_type = 2;
        $order->save();

        return view('front.cart.pay3', compact('order', 'setting'));
    }


    # orders
    public function myorders(Request $request, $div = 1)
    {


        $setting = Setting::first();
        $data = Division::where('id', $div)->with('Categories')->latest()->first();

        if (Auth::guard('dealer')->check()) {
            $user_id = Auth::guard('dealer')->user()->id;
            $orders = Order::where('dealer_id', $user_id)->with('OrderProducts.Product')->latest()->get();
            $order = Order::where('dealer_id', $user_id)->where('status', '1')->with('OrderProducts.Product', 'Order_info')->latest()->first();
            return view('front.cart.myorders', compact('data', 'order', 'setting', 'orders', 'div'));
        } elseif (Auth::guard('customer')->check()) {
            $user_id = Auth::guard('customer')->user()->id;
            $orders = Order::where('customer_id', $user_id)->with('OrderProducts.Product')->latest()->get();
            $order = Order::where('customer_id', $user_id)->where('status', '1')->with('OrderProducts.Product', 'Order_info')->latest()->first();

            return view('front.cart.myorders', compact('data', 'order', 'setting', 'orders', 'div'));

        }


    }

    # orders
    public function detorder(Request $request, $div, $id)
    {

        $setting = Setting::first();
        $data = Division::where('id', $div)->with('Categories')->latest()->first();

        if (Auth::guard('dealer')->check()) {
            $user_id = Auth::guard('dealer')->user()->id;
            $ord = Order::where('dealer_id', $user_id)->where('id', $id)->with('OrderProducts.Product', 'Order_info')->latest()->first();
            $order = Order::where('dealer_id', $user_id)->where('status', '1')->with('OrderProducts.Product', 'Order_info')->latest()->first();


        } elseif (Auth::guard('customer')->check()) {
            $user_id = Auth::guard('customer')->user()->id;
            $ord = Order::where('customer_id', $user_id)->where('id', $id)->with('OrderProducts.Product', 'Order_info')->latest()->first();
            $order = Order::where('customer_id', $user_id)->where('status', '1')->with('OrderProducts.Product', 'Order_info')->latest()->first();
        }


        if (!$ord) {
            return "Order Not Found";
        }

        if (!is_null($ord->coupon_id)) {
            $coupon = Coupon::where('id', $ord->coupon_id)->first();
            if ($coupon->type == 'percent') {
                $capp = ($ord->total * $coupon->discount) / 100;
                $result = $ord->total + $capp;
            } else {
                $capp = $coupon->discount;
                $result = $ord->total + $capp;
            }
        } else {
            $capp = null;
            $result = $ord->total;
        }

        return view('front.cart.orderdetials', compact('data', 'ord', 'setting', 'order', 'div', 'capp', 'result'));

    }

    # product
    public function product(Request $request, $div, $id)
    {


        $data = Division::where('id', $div)->with('Categories')->latest()->first();
        $pro = Product::with('ProComments.Dealer', 'ProComments.Customer', 'Images', 'ProTypes', 'Categories')->where('id', $id)->latest()->first();
        $majs = Product_Category::where('product_id', $id)->pluck('category_id')->toArray();
        $datas = Product_Category::whereIn('category_id', $majs)->pluck('product_id')->toArray();
        $copies = Product::where('stock', '>', 0)->whereIn('id', $datas)->inRandomOrder()->latest()->take(4)->get();

        if (Auth::guard('dealer')->check()) {
            $user_id = Auth::guard('dealer')->user()->id;
            $order = Order::where('status', '1')->where('dealer_id', $user_id)->with('Carts')->latest()->first();

            return view('front.home.product', compact('data', 'pro', 'order', 'copies', 'div'));
        } elseif (Auth::guard('customer')->check()) {
            $user_id = Auth::guard('customer')->user()->id;
            $order = Order::where('status', '1')->where('customer_id', $user_id)->with('Carts')->latest()->first();

            return view('front.home.product', compact('data', 'pro', 'order', 'copies', 'div'));

        }
        $order = Order::where('status', '1')->where('ip', $request->ip())->with('Carts')->latest()->first();

        return view('front.home.product', compact('data', 'pro', 'order', 'copies', 'div'));

    }

    public function addfav(Request $request)
    {


        $pro = Product::with('ProLikes')->where('id', $request->id)->latest()->first();


        if (Auth::guard('dealer')->check()) {
            $user_id = Auth::guard('dealer')->user()->id;

            $lik = Pro_Like::where('dealer_id', $user_id)->where('product_id', $request->id)->latest()->first();

            if (!$lik) {
                $like = new Pro_Like;
                $like->dealer_id = $user_id;
                $like->product_id = $request->id;
                $like->save();
            } else {
                $lik->delete();
            }
            $liks = Pro_Like::where('dealer_id', $user_id)->latest()->get();


        } elseif (Auth::guard('customer')->check()) {

            $user_id = Auth::guard('customer')->user()->id;

            $lik = Pro_Like::where('customer_id', $user_id)->where('product_id', $request->id)->latest()->first();


            if (!$lik) {

                $like = new Pro_Like;
                $like->customer_id = $user_id;
                $like->product_id = $request->id;
                $like->save();

            } else {
                $lik->delete();
            }

            $liks = Pro_Like::where('customer_id', $user_id)->latest()->get();
        }


        $datas = count($liks);

        return response()->json(['datas' => $datas]);

    }

    public function addcomment(Request $request)
    {

        $this->validate($request, [
            'rate' => 'required',
            'comment' => 'required',

        ]);

        $pro = Product::with('ProLikes')->where('id', $request->id)->latest()->first();


        if (Auth::guard('dealer')->check()) {
            $user_id = Auth::guard('dealer')->user()->id;

            $like = new Pro_Comments;
            $like->dealer_id = $user_id;
            $like->product_id = $request->id;
            $like->rate = $request->rate;
            $like->comment = $request->comment;
            $like->save();


        } elseif (Auth::guard('customer')->check()) {
            $user_id = Auth::guard('customer')->user()->id;
            $like = new Pro_Comments;
            $like->customer_id = $user_id;
            $like->product_id = $request->id;
            $like->rate = $request->rate;
            $like->comment = $request->comment;
            $like->save();

        } else {
            $like = new Pro_Comments;
            $like->product_id = $request->id;
            $like->rate = $request->rate;
            $like->comment = $request->comment;
            $like->save();
        }
        $pro->rate = Pro_Comments::where('product_id', $request->id)->avg('rate');
        $pro->save();

        return back();

    }

    public function email(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:emails,email',

        ]);


        foreach ((array)$validator->errors() as $value) {
            if (isset($value['email']) && !is_null($request->email)) {
                return response()->json([
                    'status' => '0',
                    'message' => " هذا البريد موجود بالفعل",
                ], 200);
            }
        }


        $email = new Email;
        $email->email = $request->email;
        $email->save();
        return response()->json([
            'status' => '1',
            'message' => 'تم الإشتراك',
        ], 200);


    }

    # contuct
    public function contuct(Request $request, $div)
    {

        $data = Division::where('id', $div)->with('Categories')->latest()->first();
        if (Auth::guard('dealer')->check()) {
            $user_id = Auth::guard('dealer')->user()->id;
            $order = Order::where('status', '1')->where('dealer_id', $user_id)->with('Carts')->latest()->first();

            return view('front.home.contuct', compact('data', 'order', 'div'));
        } elseif (Auth::guard('customer')->check()) {
            $user_id = Auth::guard('customer')->user()->id;
            $order = Order::where('status', '1')->where('customer_id', $user_id)->with('Carts')->latest()->first();

            return view('front.home.contuct', compact('data', 'order', 'div'));

        }
        $order = Order::where('status', '1')->where('ip', $request->ip())->with('Carts')->latest()->first();

        return view('front.home.contuct', compact('data', 'order', 'div'));
    }


    # contuct
    public function contuctadd(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|max:190',
            'email' => 'required|email|max:190',
            'phone' => 'required|max:190',
            'desc' => 'required|max:190',
        ]);

        $info = new Inbox;
        $info->name = $request->name;

        $info->email = $request->email;
        $info->phone = $request->phone;

        $info->subject = $request->desc;

        $info->save();

        return back();

    }

    # listfav
    public function listfav(Request $request, $div)
    {

        $data = Division::where('id', $div)->with('Categories')->latest()->first();
        if (Auth::guard('dealer')->check()) {
            $user_id = Auth::guard('dealer')->user()->id;
            $order = Order::where('status', '1')->where('dealer_id', $user_id)->with('Carts')->latest()->first();

            $majs = Pro_Like::where('dealer_id', $user_id)->pluck('product_id')->toArray();
            $pros = Product::whereIn('id', $majs)->with('ProComments')->latest()->get();
            return view('front.home.fav', compact('data', 'order', 'pros', 'div'));
        } elseif (Auth::guard('customer')->check()) {
            $user_id = Auth::guard('customer')->user()->id;
            $majs = Pro_Like::where('customer_id', $user_id)->pluck('product_id')->toArray();
            $pros = Product::whereIn('id', $majs)->with('ProComments')->latest()->get();
            $order = Order::where('status', '1')->where('customer_id', $user_id)->with('Carts')->latest()->first();

            return view('front.home.fav', compact('data', 'order', 'pros', 'div'));

        }

    }


    # show more
    public function shoemore(Request $request, $div, $id = null, $panner = null)
    {


        $kind = $request->kind;
        $limit = 0;

        $data = Division::where('id', $div)->with('Categories')->latest()->first();

        $catss = Category::where('division_id', $div)->with('ProductCategories')->latest()->get();

        $catssss = Category::where('division_id', $div)->with('Division')->pluck('id')->toArray();
        $procs = Product_Category::whereIn('category_id', $catssss)->pluck('product_id')->toArray();

        if (is_null($kind) || $kind == '2') {
            if (is_null($id) || $id == 'panner') {
                if (is_null($panner)) {
                    $latest = Product::whereIn('id', $procs)->with('ProComments')->orderby('pay_count', 'desc')->latest()->paginate(10);
                } else {

                    $pans = Pannar::where('name_ar', $panner)->latest()->first();
                    $pan = $pans->sections;
                    $secs = json_decode($pan);
                    $kind = $pans->name_ar;
                    $majs = Product_Category::whereIn('category_id', $secs)->pluck('product_id')->toArray();
                    if (Auth::guard('dealer')->check()) {
                        $latest = Product::where('stock', '>', 0)->whereIn('id', $majs)->whereBetween('dealer_price', [$pans->price_from, $pans->price_to])->with('ProComments')->orderby('pay_count', 'desc')->latest()->paginate(10);
                    } else {
                        $latest = Product::where('stock', '>', 0)->whereIn('id', $majs)->whereBetween('price_discount', [$pans->price_from, $pans->price_to])->with('ProComments')->orderby('pay_count', 'desc')->latest()->paginate(10);
                    }

                }
            } else {
                $majs = Product_Category::where('category_id', $id)->pluck('product_id')->toArray();
                $latest = Product::where('stock', '>', 0)->whereIn('id', $majs)->with('ProComments')->orderby('pay_count', 'desc')->latest()->paginate(10);
            }

        } elseif ($kind == "1") {
            if (is_null($id) || $id == 'panner') {
                if (is_null($panner)) {
                    $latest = Product::where('stock', '>', 0)->whereIn('id', $procs)->with('ProComments')->latest()->paginate(10);
                } else {
                    $pans = Pannar::where('id', $panner)->latest()->first();
                    $pan = $pans->sections;
                    $secs = json_decode($pan);
                    $majs = Product_Category::whereIn('category_id', $secs)->pluck('product_id')->toArray();
                    if (Auth::guard('dealer')->check()) {
                        $latest = Product::where('stock', '>', 0)->whereIn('id', $majs)->whereBetween('dealer_price', [$pans->price_from, $pans->price_to])->with('ProComments')->latest()->paginate(10);
                    } else {
                        $latest = Product::where('stock', '>', 0)->whereIn('id', $majs)->whereBetween('price_discount', [$pans->price_from, $pans->price_to])->with('ProComments')->latest()->paginate(10);
                    }

                }
            } else {
                $majs = Product_Category::where('category_id', $id)->pluck('product_id')->toArray();
                $latest = Product::where('stock', '>', 0)->whereIn('id', $majs)->with('ProComments')->latest()->paginate(10);
            }
        }




        if (Auth::guard('dealer')->check()) {
            $user_id = Auth::guard('dealer')->user()->id;
            $order = Order::where('status', '1')->where('dealer_id', $user_id)->with('Carts')->latest()->first();


            return view('front.home.show_more', compact('data', 'latest', 'order', 'catss', 'kind', 'id', 'limit', 'div'));
        } elseif (Auth::guard('customer')->check()) {
            $user_id = Auth::guard('customer')->user()->id;
            $order = Order::where('status', '1')->where('customer_id', $user_id)->with('Carts')->latest()->first();


            return view('front.home.show_more', compact('data', 'latest', 'order', 'catss', 'kind', 'id', 'limit', 'div'));

        }
        $order = Order::where('status', '1')->where('ip', $request->ip())->with('Carts')->latest()->first();


        return view('front.home.show_more', compact('data', 'latest', 'order', 'catss', 'kind', 'id', 'limit', 'div'));
    }

    # filter
    public function filter(Request $request, $id = null)
    {
        $limit = $request->count + 10;
        $count = $request->count;

        if (!is_null($request->sections)) {
            if (!is_null($request->rate)) {
                if (!is_null($request->min) && !is_null($request->max)) {
                    $majs = Product_Category::whereIn('category_id', $request->sections)->pluck('product_id')->toArray();
                    if (Auth::guard('dealer')->check()) {
                        $latest = Product::where('stock', '>', 0)->whereIn('id', $majs)->where('rate', $request->rate)->whereBetween('dealer_price', [$request->min, $request->max])->with('ProComments')->latest()->skip($count)->take(10)->get();
                    } else {
                        $latest = Product::where('stock', '>', 0)->whereIn('id', $majs)->where('rate', $request->rate)->whereBetween('price_discount', [$request->min, $request->max])->with('ProComments')->latest()->skip($count)->take(10)->get();
                    }
                } else {
                    $majs = Product_Category::whereIn('category_id', $request->sections)->pluck('product_id')->toArray();

                    $latest = Product::where('stock', '>', 0)->whereIn('id', $majs)->where('rate', $request->rate)->with('ProComments')->latest()->skip($count)->take(10)->get();

                }
            } else {

                if (!is_null($request->min) && !is_null($request->max)) {
                    $majs = Product_Category::whereIn('category_id', $request->sections)->pluck('product_id')->toArray();
                    if (Auth::guard('dealer')->check()) {
                        $latest = Product::where('stock', '>', 0)->whereIn('id', $majs)->whereBetween('dealer_price', [$request->min, $request->max])->with('ProComments')->latest()->skip($count)->take(10)->get();
                    } else {
                        $latest = Product::where('stock', '>', 0)->whereIn('id', $majs)->whereBetween('price_discount', [$request->min, $request->max])->with('ProComments')->latest()->skip($count)->take(10)->get();
                    }
                } else {
                    $majs = Product_Category::whereIn('category_id', $request->sections)->pluck('product_id')->toArray();

                    $latest = Product::where('stock', '>', 0)->whereIn('id', $majs)->with('ProComments')->skip($count)->take(10)->get();

                }

            }

        } else {
            if (!is_null($request->rate)) {
                if (!is_null($request->min) && !is_null($request->max)) {

                    if (Auth::guard('dealer')->check()) {
                        $latest = Product::where('stock', '>', 0)->where('rate', $request->rate)->whereBetween('dealer_price', [$request->min, $request->max])->with('ProComments')->latest()->skip($count)->take(10)->get();
                    } else {
                        $latest = Product::where('stock', '>', 0)->where('rate', $request->rate)->whereBetween('price_discount', [$request->min, $request->max])->with('ProComments')->latest()->skip($count)->take(10)->get();
                    }
                } else {


                    $latest = Product::where('stock', '>', 0)->where('rate', $request->rate)->with('ProComments')->latest()->skip($count)->take(10)->get();

                }
            } else {

                if (!is_null($request->min) && !is_null($request->max)) {

                    if (Auth::guard('dealer')->check()) {
                        $latest = Product::where('stock', '>', 0)->whereBetween('dealer_price', [$request->min, $request->max])->with('ProComments')->latest()->skip($count)->take(10)->get();
                    } else {
                        $latest = Product::where('stock', '>', 0)->whereBetween('price_discount', [$request->min, $request->max])->with('ProComments')->latest()->skip($count)->take(10)->get();
                    }
                } else {
                    $majs = Product_Category::where('category_id', $id)->pluck('product_id')->toArray();

                    $latest = Product::where('stock', '>', 0)->with('ProComments')->latest()->skip($count)->take(10)->get();

                }

            }
        }


        return response()->json(['datas' => $latest, 'limit' => $limit, 'count' => $limit]);

    }


    # listfav
    public function about(Request $request, $div)
    {

        $data = Division::where('id', $div)->with('Categories')->latest()->first();
        $setting = Setting::first();
        if (Auth::guard('dealer')->check()) {
            $user_id = Auth::guard('dealer')->user()->id;
            $order = Order::where('status', '1')->where('dealer_id', $user_id)->with('Carts')->latest()->first();

            return view('front.home.about', compact('data', 'order', 'setting', 'div'));
        } elseif (Auth::guard('customer')->check()) {
            $user_id = Auth::guard('customer')->user()->id;
            $order = Order::where('status', '1')->where('customer_id', $user_id)->with('Carts')->latest()->first();

            return view('front.home.about', compact('data', 'order', 'setting', 'div'));

        }

        $order = Order::where('status', '1')->where('ip', $request->ip())->with('Carts')->latest()->first();

        return view('front.home.about', compact('data', 'order', 'setting', 'div'));

    }


    public function CreateCheckoutSession(Request $request)
    {
        $id = $request->input("id");
        $order = Order::where('id', $id)->with('Carts')->latest()->first();
        $merchantId = 'GADO_COOL';
        $password = '7b57cc84015c69f9602959ddcdb413d2';
        $url = 'https://banquemisr.gateway.mastercard.com/api/rest/version/62/merchant/' . $merchantId . '/session';

        $setting = Setting::first();
        $headers = array(
            'Content-Type:application/json',
            'Authorization: Basic ' . base64_encode('Merchant.' . $merchantId . ":" . $password) // <---
        );


        $url = $url;

        $ch = curl_init($url);
        curl_setopt_array($ch, array(
            CURLOPT_POST => TRUE,
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => $headers,
        ));

        $result = json_decode(curl_exec($ch));

        return view('front.cart.pay', compact('order', 'result', 'setting'));

    }


}
