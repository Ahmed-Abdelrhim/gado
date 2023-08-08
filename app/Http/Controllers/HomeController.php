<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use App\Order;
use App\Order_Product;
use App\Customer;
use App\Dealer;
use App\Order_info;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home.home');
    }

    public function Orders()
    {
        $orders  = Order::where('status','4')->with('Order_info')->latest()->get();
        $sum  =  $orders->sum('total');
        $now  = Carbon::now();
        return view('home.sales_profit',compact('orders','sum','now'));
    }
    public function Storedate(Request $request)
    {

        $orders  = Order::where('status','4')->where('created_at','>=',$request->date)->with('Order_info')->latest()->get();
        $sum  =  $orders->sum('total');
        $now  = Carbon::now();
        return view('home.sales_profit',compact('orders','sum','now'));
    }
}
