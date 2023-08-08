<?php

namespace App\Http\Controllers\Api\V1\Home;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        return \response()->json([
            'status'=> 200,
            'best_sales' => Product::with('ProComments')->inRandomOrder()->orderby('pay_count' , 'desc')->take(4)->get()
        ]);

    }
}
