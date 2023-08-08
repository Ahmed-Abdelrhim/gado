<?php

namespace App\Http\Controllers\Api\V1\Authentication;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Payloads\ValidationPayload;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
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

        $validator = Validator::make(
            $request->only(['phone', 'type']),
            [
                'type' => 'required|in:customer,dealer',
//                'phone'   => 'required|min:11|max:11|unique:customers,phone'
                'phone' => 'required'
            ],
            [
                'type' => 'The :attribute field is required.',
                'phone' => "Phone Required!"
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $validatedData = $validator->validated();
        # check if phone trying register before
        $customer = Customer::whereActivePhone($validatedData['phone'])->first();
        $code = rand(1111, 9999);
        $msg = 'رمز التحقق: ' . $code;

        $data = array(
            'code' => $code,
            'ip' => $request->ip(),
            'remember_token' => 'c' . date('d-m-y') . time() . Str::random(50),
            'active' => '0'
        );
        if ($customer) {
            $customer->update($data);
            # msegat_send_mobile_sms($phone, $msg);
        } else {
            $data['active_phone'] = $validatedData['phone'];
            $data['api_token'] = hash('sha256', Str::random(120), false);
            $customer = Customer::create($data);
            # msegat_send_mobile_sms($phone, $msg);
        }

        return  \response()->json(['status' => 200, 'message' => "success", 'code' =>$customer['code'] ]);
    }
}
