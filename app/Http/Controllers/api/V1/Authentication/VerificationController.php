<?php

namespace App\Http\Controllers\Api\V1\Authentication;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\CustomersIndexResource;
use App\Http\Resources\Api\V1\CustomerVerificationResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class VerificationController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->only(['verify_code']),
            ['verify_code' => 'required'],
            ['verify_code' => 'The :attribute field is required']);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $validatedData = $validator->validated();

        $customer = Customer::whereCode($validatedData['verify_code'])->first();

        if (!$customer) {
            return \response()->json(['status' => 400], 400);
        }

        return CustomerVerificationResource::make($customer)->additional([
            'status' => 200,
            'message' => "Success"
        ]);
    }
}
