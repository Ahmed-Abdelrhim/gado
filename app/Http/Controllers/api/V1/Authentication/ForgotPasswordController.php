<?php

namespace App\Http\Controllers\Api\V1\Authentication;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\CustomerVerificationResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return CustomerVerificationResource|JsonResponse
     */
    public function __invoke(Request $request)
    {

        $validator = Validator::make($request->only(['phone', 'type']),
            ['phone' => 'required', 'type' => 'required|in:customer,dealer'
            ],
            ['phone' => 'The :attribute field is required']);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $validatedData = $validator->validated();

        $customer = Customer::wherePhone($validatedData['phone'])->first();

        if (is_null($customer)) {
            return \response()->json(['status' => 400, 'message' => 'Phone not found.'], 400);
        }

        $code = rand(1111, 9999);
        $customer->code = $code;
        $customer->remember_token = 'c' . date('d-m-y') . time() . Str::random(50);
        $customer->save();

        return  CustomerVerificationResource::make($customer)->additional(['message' => "Message 00100", 'status' =>200]);
    }
}
