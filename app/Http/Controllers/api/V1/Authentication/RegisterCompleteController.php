<?php

namespace App\Http\Controllers\Api\V1\Authentication;

use App\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class RegisterCompleteController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $validator = Validator::make(
            $request->only('api_token', 'name', 'email', 'password', 'password_confirmation'),
            [
                'api_token' => 'required',
                'name' => 'required',
                'email' => 'required',
                'password' => 'required|confirmed',
            ],
            [
                'name' => "Name Required!",
                'email' => "Email Required!",
                'password' => "Password Required!",
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 402);
        }


        $customer = Customer::whereApiToken($request->get('api_token'))->first();

        if (!$customer) {
            return response()->json(['status' => 400, 'message' => "error"], 400);
        }

        $customer->update(array(
            'name' => $request->name,
            'email' => $request->email,
            'ip' => $request->ip(),
            'phone' => $customer->active_phone,
            'active' => '1',
            'password' => bcrypt($request->password)
        ));

        return \response()->json(['status' => 200], 200);
    }
}
