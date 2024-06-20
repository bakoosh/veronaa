<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    protected $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }


    public function SendVerificationCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $verificationCode = rand(100000, 999999);

        $response = $this->smsService->sendSms($request->phone, $verificationCode);

        Cache::put('verification_code_' . $request->phone, $verificationCode, now()->addMinutes(10));

        return response()->json(['verification_code' => $verificationCode]);

    }

    public function verifyByCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'code' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $storedCode = Cache::get('verification_code_' . $request->phone);
        if ($storedCode && $storedCode == $request->code) {
            $user = User::updateOrCreate(['phone' => $request->phone]);
            return response()->json($user);
        } else {
            return response()->json('bad');
        }



    }

}
